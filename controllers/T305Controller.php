<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

/**
 * T305Controller สำหรับสร้างรายงาน C305
 */
class T305Controller extends Controller
{
    // ════════════════════════════════════════════════════════════════
    //  ACTIONS
    // ════════════════════════════════════════════════════════════════

    public function actionIndex()
    {
        $data = $this->queryDataWithReason();

        $dataProvider = new ArrayDataProvider([
            'allModels'  => $data,
            'pagination' => ['pageSize' => 50],
            'sort'       => [
                'attributes' => [
                    'trans_id', 'trans_id2', 'cid',
                    'hn', 'regdate', 'fullname', 'reason',
                ],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'totalRecords' => count($data),
        ]);
    }

    /** ส่งออก CSV ทั้งหมด */
    public function actionExport()
    {
        $this->exportToCsv($this->queryDataWithReason());
    }

    /** ส่งออก CSV เฉพาะเดือน */
    public function actionExportMonth($month)
    {
        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
            throw new \yii\web\BadRequestHttpException('รูปแบบเดือนไม่ถูกต้อง');
        }
        $data      = $this->queryDataWithReason();
        $monthData = [];
        foreach ($data as $row) {
            $serviceDate = $row['regdate'];
            if (empty($serviceDate) || strtotime($serviceDate) === false) continue;
            if (date('Y-m', strtotime($serviceDate)) === $month) {
                $monthData[] = $row;
            }
        }
        $this->exportToCsv($monthData, $month);
    }

    /** ส่งออก CSV Trans Reason (2 คอลัมน์) */
    public function actionExportTransReason()
    {
        $this->exportTransReasonCsv($this->queryTransReason());
    }

    /** ส่งออก PDF */
    public function actionExportPdf()
    {
        $this->exportToPdf($this->queryDataWithReason());
    }

    /** สถิติ */
    public function actionStatistics()
    {
        $data = $this->queryDataWithReason();

        $thaiMonths = [
            '01' => 'มกราคม',   '02' => 'กุมภาพันธ์', '03' => 'มีนาคม',
            '04' => 'เมษายน',   '05' => 'พฤษภาคม',    '06' => 'มิถุนายน',
            '07' => 'กรกฎาคม',  '08' => 'สิงหาคม',    '09' => 'กันยายน',
            '10' => 'ตุลาคม',   '11' => 'พฤศจิกายน',  '12' => 'ธันวาคม',
        ];

        $monthlyStats = [];
        foreach ($data as $row) {
            $serviceDate = $row['regdate'];
            if (empty($serviceDate) || strtotime($serviceDate) === false) continue;

            $monthKey   = date('Y-m', strtotime($serviceDate));
            $month      = date('m',   strtotime($serviceDate));
            $year       = date('Y',   strtotime($serviceDate)) + 543;
            $monthLabel = $thaiMonths[$month] . ' ' . $year;

            if (!isset($monthlyStats[$monthKey])) {
                $monthlyStats[$monthKey] = [
                    'label'          => $monthLabel,
                    'total'          => 0,
                    'withReason'     => 0,
                    'withoutReason'  => 0,
                ];
            }
            $monthlyStats[$monthKey]['total']++;
            if (!empty($row['reason'])) {
                $monthlyStats[$monthKey]['withReason']++;
            } else {
                $monthlyStats[$monthKey]['withoutReason']++;
            }
        }
        krsort($monthlyStats);

        return $this->render('statistics', [
            'monthlyStats' => $monthlyStats,
        ]);
    }

    /** รายละเอียดรายเดือน */
    public function actionMonthDetail($month)
    {
        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
            throw new \yii\web\BadRequestHttpException('รูปแบบเดือนไม่ถูกต้อง');
        }

        $data = $this->queryDataWithReason();

        $thaiMonths = [
            '01' => 'มกราคม',   '02' => 'กุมภาพันธ์', '03' => 'มีนาคม',
            '04' => 'เมษายน',   '05' => 'พฤษภาคม',    '06' => 'มิถุนายน',
            '07' => 'กรกฎาคม',  '08' => 'สิงหาคม',    '09' => 'กันยายน',
            '10' => 'ตุลาคม',   '11' => 'พฤศจิกายน',  '12' => 'ธันวาคม',
        ];

        $monthData = [];
        foreach ($data as $row) {
            $serviceDate = $row['regdate'];
            if (empty($serviceDate) || strtotime($serviceDate) === false) continue;
            if (date('Y-m', strtotime($serviceDate)) === $month) {
                $monthData[] = $row;
            }
        }

        [$year, $monthNum] = explode('-', $month);
        $monthLabel = $thaiMonths[$monthNum] . ' ' . ($year + 543);

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels'  => $monthData,
            'pagination' => ['pageSize' => 20],
            'sort'       => [
                'attributes'   => ['regdate', 'hn', 'reason'],
                'defaultOrder' => ['regdate' => SORT_DESC],
            ],
        ]);

        return $this->render('month-detail', [
            'dataProvider'       => $dataProvider,
            'monthLabel'         => $monthLabel,
            'month'              => $month,
            'totalCount'         => count($monthData),
            'withReasonCount'    => count(array_filter($monthData, function($r) { return !empty($r['reason']); })),
            'withoutReasonCount' => count(array_filter($monthData, function($r) { return  empty($r['reason']); })),
        ]);
    }

    // ════════════════════════════════════════════════════════════════
    //  QUERIES
    // ════════════════════════════════════════════════════════════════

    private function queryDataWithReason(): array
    {
        $sql = "
            SELECT
			c.trans_id,
			c.trans_id2,
			c.cid,
			c.hn,
			c.regdate,
			c.fullname,
			c.dru_oper,
			c.c305,
			c.reason
		FROM c305_thaimed c
		WHERE c.trans_id2 IS NOT NULL
		  AND c.trans_id2 <> ''
		GROUP BY c.trans_id2;
        ";
        try {
            $data = Yii::$app->db70->createCommand($sql)->queryAll();
            foreach ($data as &$row) {
                $row['trans_id']  = trim($row['trans_id']  ?? '');
                $row['trans_id2'] = trim($row['trans_id2'] ?? '');
                $row['cid']       = trim($row['cid']       ?? '');
                $row['hn']        = trim($row['hn']        ?? '');
                $row['regdate']   = trim($row['regdate']   ?? '');
                $row['fullname']  = trim($row['fullname']  ?? '');
                $row['reason']    = trim($row['reason']    ?? '');
            }
            return $data;
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
            return [];
        }
    }

    private function queryTransReason(): array
    {
        $sql = "
            SELECT
			c.trans_id2,
			c.reason
		FROM c305_thaimed c
		WHERE c.trans_id2 IS NOT NULL
		  AND c.trans_id2 <> ''
		GROUP BY c.trans_id2
        ";
        try {
            $data = Yii::$app->db70->createCommand($sql)->queryAll();
            foreach ($data as &$row) {
                $row['trans_id2'] = trim($row['trans_id2'] ?? '');
                $row['reason']    = trim($row['reason']    ?? '');
            }
            return $data;
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
            return [];
        }
    }

    // ════════════════════════════════════════════════════════════════
    //  HELPER
    // ════════════════════════════════════════════════════════════════

    private function getDefaultReasons(): array
    {
        return [
            'ให้บริการนอกพื้นที่ไม่สามารถขอ Authen ได้ทันในวันที่รับบริการ',
            'ระบบอินเตอร์เนตของหน่วยบริการมีปัญหา ทำให้ไม่สามารถขอ Authen ได้',
            'ปัญหาในหน่วยบริการเอง มีผู้รับบริการจำนวนมาก ทำให้ไม่สามารถขอ Authen ได้ทันเวลา',
        ];
    }

    // ════════════════════════════════════════════════════════════════
    //  EXPORT CSV (ทั้งหมด)
    // ════════════════════════════════════════════════════════════════

    private function exportToCsv(array $data, ?string $month = null): void
    {
        $defaultReasons = $this->getDefaultReasons();

        $filename = $month
            ? 'c305_oppp_' . $month . '_' . date('Ymd_His') . '.csv'
            : 'c305_oppp_' . date('Ymd_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($out, ['แบบแจ้งเหตุผลความจำเป็นกรณีไม่ได้จัดให้ผู้มีสิทธิแสดงตนยืนยันสิทธิเมื่อสิ้นสุดการรับบริการ']);
        fputcsv($out, ['']);
        fputcsv($out, ['ชื่อหน่วยบริการ โรงพยาบาลม่วงสามสิบ รหัสหน่วยบริการ 10953']);
        fputcsv($out, ['']);
        fputcsv($out, [
            'ลำดับ', 'โปรแกรมที่ส่งเบิก', 'เลขอ้างอิงชื่อไฟล์',
            'รหัสอ้างอิงจากแฟ้ม SERVICE', 'รหัสบัตรประชาชน',
            'HN', 'วันที่เข้ารับบริการ', 'ชื่อ-สกุล', 'เหตุผล',
        ]);

        $no = 1;
        foreach ($data as $row) {
            $hn = trim($row['hn'] ?? '');
            if ($hn !== '') {
                $hn = str_pad(preg_replace('/\D/', '', $hn), 6, '0', STR_PAD_LEFT);
                $hn = '="' . $hn . '"';
            } else {
                $hn = '="000000"';
            }

            $cid = trim($row['cid'] ?? '');
            if ($cid !== '' && strlen($cid) === 13) {
                $cid = '="' . $cid . '"';
            }

            $reason = trim($row['reason'] ?? '');
            if ($reason === '') {
                $reason = $defaultReasons[array_rand($defaultReasons)];
            }

            $regdate = $row['regdate'] ?? '';
            if (!empty($regdate) && strtotime($regdate)) {
                $regdate = date('d/m/Y', strtotime($regdate));
            }

            fputcsv($out, [
                $no++,
                'oppp',
                $row['trans_id']  ?? '',
                $row['trans_id2'] ?? '',
                $cid,
                $hn,
                $regdate,
                $row['fullname']  ?? '',
                $reason,
            ]);
        }
        fclose($out);
        exit();
    }

    // ════════════════════════════════════════════════════════════════
    //  EXPORT CSV (trans_reason — 2 คอลัมน์)
    // ════════════════════════════════════════════════════════════════

    private function exportTransReasonCsv(array $data): void
    {
        $defaultReasons = $this->getDefaultReasons();
        $filename = 'c305_oppp_trans_reason_' . date('Ymd_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($out, ['tran_id', 'reason']);

        foreach ($data as $row) {
            $reason = trim($row['reason'] ?? '');
            if ($reason === '') {
                $reason = $defaultReasons[array_rand($defaultReasons)];
            }
            fputcsv($out, [$row['trans_id2'] ?? '', $reason]);
        }
        fclose($out);
        exit();
    }

  // ════════════════════════════════════════════════════════════════
    //  EXPORT PDF — mPDF (PHP ล้วน)
    //  ติดตั้ง: composer require mpdf/mpdf
    // ════════════════════════════════════════════════════════════════

    private function exportToPdf(array $data): void
    {
        // ── ปลดล็อค execution time + เพิ่ม memory ───────────────────
        set_time_limit(0);                         // ไม่จำกัดเวลา
        ini_set('memory_limit', '1024M');
        ini_set('pcre.backtrack_limit', 10000000);
        gc_enable();

        $defaultReasons = $this->getDefaultReasons();

        // ── เตรียมข้อมูล ─────────────────────────────────────────────
        $no      = 1;
        $pdfData = [];
        foreach ($data as $row) {
            $hn = trim($row['hn'] ?? '');
            if ($hn !== '') {
                $hn = str_pad(preg_replace('/\D/', '', $hn), 6, '0', STR_PAD_LEFT);
            }

            $cid = trim($row['cid'] ?? '');

            $reason = trim($row['reason'] ?? '');
            if ($reason === '') {
                $reason = $defaultReasons[array_rand($defaultReasons)];
            }

            $regdate = $row['regdate'] ?? '';
            if (!empty($regdate) && strtotime($regdate)) {
                $regdate = date('d/m/Y', strtotime($regdate));
            }

            $pdfData[] = [
                'no'       => $no++,
                'program'  => 'OPPP/TT305',
                'trans_id' => $row['trans_id']  ?? '',
                'tran_id2' => $row['trans_id2'] ?? '',
                'cid'      => $cid,
                'hn'       => $hn,
                'regdate'  => $regdate,
                'fullname' => $row['fullname']  ?? '',
                'reason'   => $reason,
            ];
        }
        $total = count($pdfData);

        // คืน memory จาก $data ที่ไม่ใช้แล้ว
        unset($data, $defaultReasons);
        gc_collect_cycles();

        // ── สร้าง tmp dir ─────────────────────────────────────────────
        $tmpDir = Yii::$app->runtimePath . '/mpdf_tmp';
        if (!is_dir($tmpDir)) {
            mkdir($tmpDir, 0755, true);
        }

        // ── สร้าง mPDF ────────────────────────────────────────────────
        $mpdf = new \Mpdf\Mpdf([
            'mode'             => 'utf-8',
            'format'           => 'A4',
            'orientation'      => 'L',
            'margin_left'      => 12,
            'margin_right'     => 8,
            'margin_top'       => 12,
            'margin_bottom'    => 12,
            'margin_header'    => 0,
            'margin_footer'    => 6,
            'default_font'     => 'garuda',
            'tempDir'          => $tmpDir,
            'useSubstitutions' => false,  // ลด memory
            'simpleTables'     => true,   // ลด memory — ตารางไม่ซับซ้อน
        ]);

        $mpdf->SetTitle('รายงาน C305 ไม่ได้ Authen OPPP');
        $mpdf->SetAuthor('โรงพยาบาลม่วงสามสิบ');
        $mpdf->SetFooter('หน้า {PAGENO} / {nbpg}');

        // ── WriteHTML ส่วนที่ 1: CSS + หัวกระดาษ + เปิดตาราง ─────────
        $htmlHeader = '
<style>
    body       { font-family: "garuda", sans-serif; font-size: 9pt; color: #2c3e50; }
    h2         { text-align: center; color: #6a0dad; font-size: 13pt; margin: 0 0 4px 0; line-height: 1.5; }
    .subtitle  { text-align: center; font-size: 10pt; margin: 0 0 8px 0; }
    hr         { border: none; border-top: 2px solid #9b5de5; margin-bottom: 10px; }
    table.main { width: 100%; border-collapse: collapse; font-size: 7.5pt; }
    th         { background: #e5cafc; color: #6a0dad; font-weight: bold;
                 text-align: center; vertical-align: middle;
                 border: 1px solid #c4a8e8; padding: 5px 3px; white-space: nowrap; }
    td         { border: 1px solid #c4a8e8; padding: 4px 3px; vertical-align: top; }
    .tc        { text-align: center; }
    .tl        { text-align: left; }
    .mono      { text-align: center; }
    .sum-box   { margin-top: 12px; background: #f0e8ff; border: 1px solid #9b5de5;
                 padding: 7px 12px; font-weight: bold; font-size: 10pt; }
    table.sign { width: 100%; margin-top: 40px; }
    .sign-r    { text-align: center; font-size: 10pt; line-height: 2.2; }
</style>
<h2>แบบแจ้งเหตุผลความจำเป็นกรณีไม่ได้จัดให้ผู้มีสิทธิแสดงตนยืนยันสิทธิเมื่อสิ้นสุดการรับบริการ (ข้อมูลติด C305)</h2>
<p class="sub">ชื่อหน่วยบริการ โรงพยาบาลม่วงสามสิบ &nbsp;&nbsp; รหัสหน่วยบริการ 10953</p>
<p class="sub">งวดจ่ายเดือน มกราคม 2568- มกราคม 2569 &nbsp;&nbsp; บริการแพทย์แผนไทย TT305 </p>
<hr>
<table class="main">
<thead>
<tr>
	<th style="width:4%;">ลำดับ</th>
    <th style="width:8%;">โปรแกรม<br>ที่ส่งเบิก</th>
    <th style="width:12%;">เลขอ้างอิงโปรแกรมที่ส่งเบิก / train_id</th>
    <th style="width:13%;">PID</th>
    <th style="width:6%;">HN</th>
    <th style="width:8%;">วันที่<br>เข้ารับบริการ</th>
    <th style="width:12%;">ชื่อ-นามสกุล</th>
    <th>เหตุผลความจำเป็น</th>
</tr>
</thead>
<tbody>';

        $mpdf->WriteHTML($htmlHeader);
        unset($htmlHeader);
        gc_collect_cycles();

        // ── WriteHTML ส่วนที่ 2: แถวข้อมูล แบ่งทีละ 30 แถว ──────────
        $chunks = array_chunk($pdfData, 30);
        unset($pdfData);
        gc_collect_cycles();

        foreach ($chunks as $key => $chunk) {
            $chunkRows = '';
            foreach ($chunk as $row) {
                $bg = ($row['no'] % 2 === 0) ? '#ffffff' : '#f0e8ff';
                $chunkRows .=
                    '<tr style="background:' . $bg . ';">' .
                    '<td class="tc">'   . htmlspecialchars($row['no'],       ENT_QUOTES, 'UTF-8') . '</td>' .
                    '<td class="tc">'   . htmlspecialchars($row['program'],  ENT_QUOTES, 'UTF-8') . '</td>' .
                    '<td class="tc">'   . htmlspecialchars($row['tran_id2'], ENT_QUOTES, 'UTF-8') . '</td>' .
                    '<td class="mono">' . htmlspecialchars($row['cid'],      ENT_QUOTES, 'UTF-8') . '</td>' .
                    '<td class="mono">' . htmlspecialchars($row['hn'],       ENT_QUOTES, 'UTF-8') . '</td>' .
                    '<td class="tc">'   . htmlspecialchars($row['regdate'],  ENT_QUOTES, 'UTF-8') . '</td>' .
                    '<td class="tl">'   . htmlspecialchars($row['fullname'], ENT_QUOTES, 'UTF-8') . '</td>' .
                    '<td class="tl">'   . htmlspecialchars($row['reason'],   ENT_QUOTES, 'UTF-8') . '</td>' .
                    '</tr>';
            }
            $mpdf->WriteHTML($chunkRows);

            unset($chunkRows, $chunk, $chunks[$key]);
            gc_collect_cycles();
        }
        unset($chunks);
        gc_collect_cycles();

        // ── WriteHTML ส่วนที่ 3: ปิดตาราง + สรุป + ลายเซ็น ──────────
        $mpdf->WriteHTML(
            '</tbody></table>' .
            '<div class="sum-box">สรุปรวมทั้งสิ้น &nbsp;&nbsp; จำนวน &nbsp;&nbsp; ' . number_format($total) . ' &nbsp;&nbsp; รายการ</div>' .
            '<table class="sign"><tr>' .
            '<td style="border:none; width:50%;"></td>' .
            '<td class="sign-r" style="border:none;">' .
            'ลงชื่อ ............................................<br>' .
            '(นายประจักษ์ &nbsp; สีลาชาติ)<br>' .
            'ตำแหน่งผู้อำนวยการโรงพยาบาลม่วงสามสิบ' .
            '</td></tr></table>'
        );

        // ── Output ────────────────────────────────────────────────────
        $filename = 'c305_oppp_' . date('Ymd_His') . '.pdf';
        $mpdf->Output($filename, \Mpdf\Output\Destination::DOWNLOAD);
        exit();
    }
}