<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;
use app\components\AccessRule;

/**
 * Fdh305Controller — รายงาน C305 (ไม่ได้ Authen OPPP)
 * โรงพยาบาลม่วงสามสิบ รหัสหน่วยบริการ 10953
 */
class Fdh305Controller extends Controller
{
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => [
                    'index', 
                    'get-unpaid-details',
                    'get-sent-details',
                    'get-visit-detail',
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'index', 
                            'get-unpaid-details',
                            'get-sent-details',
                            'get-visit-detail',
                        ],
                        'matchCallback' => function ($rule, $action) {
                            $allowedUsers = ['6', '96', '289', '383'];  ### 96-yoo 153-ice  160- สินีนาฎ    22-หทัยรัตน์  289= จันทร์มณี  383= ต่อง 29=จีระพงษ์  286=พิชิตพร
                            return in_array(Yii::$app->user->id, $allowedUsers);
                        },
                    ],
                ],
            ],
        ];
    }

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

    /** ส่งออก CSV ทั้งหมด (รายงานเต็ม) */
    public function actionExport()
    {
        $this->exportToCsv($this->queryDataWithReason());
    }

    /** ส่งออก CSV เฉพาะเดือน เช่น ?month=2567-06 (พ.ศ.) หรือ 2024-06 (ค.ศ.) */
    public function actionExportMonth($month)
    {
        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
            throw new \yii\web\BadRequestHttpException('รูปแบบเดือนไม่ถูกต้อง (YYYY-MM)');
        }
        $all       = $this->queryDataWithReason();
        $monthData = array_filter($all, function ($row) use ($month) {
            $d = $row['regdate'] ?? '';
            return $d !== '' && strtotime($d) !== false
                && date('Y-m', strtotime($d)) === $month;
        });
        $this->exportToCsv(array_values($monthData), $month);
    }

    /** ส่งออก CSV เฉพาะ tran_id + reason (2 คอลัมน์) */
    public function actionExportTransReason()
    {
        $this->exportTransReasonCsv($this->queryTransReason());
    }

    /** ส่งออก PDF (ต้องติดตั้ง composer require mpdf/mpdf) */
    public function actionExportPdf()
    {
        $this->exportToPdf($this->queryDataWithReason());
    }


    // ══════════════════════════════════════════════════════════════
    //  QUERIES
    // ══════════════════════════════════════════════════════════════

    private function queryDataWithReason(): array
    {
        $sql = "
            SELECT
                c.tran_id as trans_id,
                c.rep as trans_id2,
                c.card_no as cid,
                c.hn,
                c.service_date as regdate,
                c.patient_name as fullname,
                c.channel as dru_oper,
                c.inspection_details as c305,
                f.reason as reason
            FROM patient_claim305 c
		    INNER JOIN c305_fdh_reason f ON f.tran_id = c.tran_id
			GROUP BY c.tran_id
            ORDER BY c.service_date DESC, c.hn ASC
        ";
        try {
            $rows = Yii::$app->db70->createCommand($sql)->queryAll();
            foreach ($rows as &$row) {
                $row['trans_id']  = trim($row['trans_id']  ?? '');
                $row['trans_id2'] = trim($row['trans_id2'] ?? '');
                $row['cid']       = trim($row['cid']       ?? '');
                $row['hn']        = trim($row['hn']        ?? '');
                $row['regdate']   = trim($row['regdate']   ?? '');
                $row['fullname']  = trim($row['fullname']  ?? '');
                $row['dru_oper']  = trim($row['dru_oper']  ?? '');
                $row['c305']      = trim($row['c305']      ?? '');
                $row['reason']    = trim($row['reason']    ?? '');
            }
            unset($row);
            return $rows;
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
            return [];
        }
    }

    private function queryTransReason(): array
    {
        $sql = "
            SELECT c.tran_id, c.reason
            FROM c305_fdh_reason c
			GROUP BY c.tran_id
            ORDER BY c.tran_id
        ";
        try {
            $rows = Yii::$app->db70->createCommand($sql)->queryAll();
            foreach ($rows as &$row) {
                $row['tran_id'] = trim($row['tran_id'] ?? '');
                $row['reason']    = trim($row['reason']    ?? '');
            }
            unset($row);
            return $rows;
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
            return [];
        }
    }


    // ══════════════════════════════════════════════════════════════
    //  HELPER
    // ══════════════════════════════════════════════════════════════

    /** เหตุผลเริ่มต้น 3 ข้อ (ใช้เมื่อ reason ว่าง) */
    private function getDefaultReasons(): array
    {
        return [
            'ให้บริการนอกพื้นที่ไม่สามารถขอ Authen ได้ทันในวันที่รับบริการ',
            'ระบบอินเตอร์เนตของหน่วยบริการมีปัญหา ทำให้ไม่สามารถขอ Authen ได้',
            'ปัญหาในหน่วยบริการเอง มีผู้รับบริการจำนวนมาก ทำให้ไม่สามารถขอ Authen ได้ทันเวลา',
        ];
    }

    /** แปลง HN ให้เป็น 6 หลัก เติม 0 ข้างหน้า */
    private function formatHn(string $hn): string
    {
        $hn = preg_replace('/\D/', '', $hn);
        return $hn !== '' ? str_pad($hn, 6, '0', STR_PAD_LEFT) : '000000';
    }

    /** แปลงวันที่ Y-m-d → d/m/Y */
    private function formatDate(string $date): string
    {
        if ($date === '' || strtotime($date) === false) return '';
        return date('d/m/Y', strtotime($date));
    }


    // ══════════════════════════════════════════════════════════════
    //  EXPORT CSV — รายงานเต็ม
    //
    //  หัวกระดาษ:
    //    แบบแจ้งเหตุผลฯ
    //    ชื่อหน่วยบริการ โรงพยาบาลม่วงสามสิบ รหัสหน่วยบริการ 10953
    //
    //  คอลัมน์ (9 คอลัมน์):
    //    ลำดับ | โปรแกรมที่ส่งเบิก | เลขอ้างอิงชื่อไฟล์ |
    //    รหัสอ้างอิงจากแฟ้ม SERVICE | รหัสบัตรประชาชน |sfaa
    //    HN | วันที่เข้ารับบริการ | ชื่อ-สกุล | เหตุผล
    // ══════════════════════════════════════════════════════════════

  private function exportToCsv(array $data, ?string $month = null): void
{
    $defaultReasons = $this->getDefaultReasons();

    $filename = $month
        ? 'c305_fdh_' . $month . '_' . date('Ymd_His') . '.csv'
        : 'c305_fdh_' . date('Ymd_His') . '.csv';

    // ── สร้าง CSV content ใน memory ──────────────────────────────
    $tmpFile = fopen('php://temp', 'r+');

    // BOM — ให้ Excel เปิดภาษาไทยถูก
    fprintf($tmpFile, chr(0xEF) . chr(0xBB) . chr(0xBF));

    // ── หัวรายงาน ────────────────────────────────────────────────
    fputcsv($tmpFile, ['แบบแจ้งเหตุผลความจำเป็นกรณีไม่ได้จัดให้ผู้มีสิทธิแสดงตนยืนยันสิทธิเมื่อสิ้นสุดการรับบริการ']);
    fputcsv($tmpFile, ['']);
    fputcsv($tmpFile, ['ชื่อหน่วยบริการ โรงพยาบาลม่วงสามสิบ รหัสหน่วยบริการ 10953']);
    fputcsv($tmpFile, ['']);

    // ── หัวคอลัมน์ ───────────────────────────────────────────────
    fputcsv($tmpFile, [
        'ลำดับ',
        'โปรแกรมที่ส่งเบิก',
        'เลขอ้างอิงชื่อไฟล์',
        'รหัสบัตรประชาชน',
        'HN',
        'วันที่เข้ารับบริการ',
        'ชื่อ-สกุล',
        'เหตุผล',
    ]);

    // ── แถวข้อมูล ─────────────────────────────────────────────────
    $no = 1;
    foreach ($data as $row) {

        $hn = '="' . $this->formatHn($row['hn'] ?? '') . '"';

        $cid = trim($row['cid'] ?? '');
        if ($cid !== '' && strlen($cid) === 13) {
            $cid = '="' . $cid . '"';
        }

        $reason = $row['reason'] ?? '';
        if ($reason === '') {
            $reason = $defaultReasons[array_rand($defaultReasons)];
        }

        fputcsv($tmpFile, [
            $no++,
            'fdh',
            $row['trans_id']  ?? '',
            $cid,
            $hn,
            $this->formatDate($row['regdate'] ?? ''),
            $row['fullname']  ?? '',
            $reason,
        ]);
    }

    // ── สรุปท้าย ──────────────────────────────────────────────────
    fputcsv($tmpFile, ['']);
    fputcsv($tmpFile, ['รวมทั้งสิ้น', '', '', '', '', '', '', ($no - 1) . ' รายการ']);

    // ── อ่าน content จาก temp ────────────────────────────────────
    rewind($tmpFile);
    $csvContent = stream_get_contents($tmpFile);
    fclose($tmpFile);

    // ── ส่งผ่าน Yii2 Response ────────────────────────────────────
    $response = Yii::$app->response;
    $response->format = \yii\web\Response::FORMAT_RAW;
    $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
    $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
    $response->headers->set('Pragma', 'no-cache');
    $response->headers->set('Expires', '0');
    $response->content = $csvContent;

    return; // ไม่ต้องเรียก Yii::$app->end()
}

    // ══════════════════════════════════════════════════════════════
    //  EXPORT CSV — Trans Reason (2 คอลัมน์)
    //    tran_id | reason
    // ══════════════════════════════════════════════════════════════

    private function exportTransReasonCsv(array $data): void
{
    $defaultReasons = $this->getDefaultReasons();
    $filename = 'c305_fdh_trans_reason_' . date('Ymd_His') . '.csv';

    // ── สร้าง CSV content ใน memory ──────────────────────────────
    $tmpFile = fopen('php://temp', 'r+');

    // BOM
    fprintf($tmpFile, chr(0xEF) . chr(0xBB) . chr(0xBF));

    fputcsv($tmpFile, ['tran_id', 'reason']);

    foreach ($data as $row) {
        $reason = $row['reason'] ?? '';
        if ($reason === '') {
            $reason = $defaultReasons[array_rand($defaultReasons)];
        }
        fputcsv($tmpFile, [$row['tran_id'] ?? '', $reason]); // ✅ แก้ key
    }

    // ── อ่าน content จาก temp ────────────────────────────────────
    rewind($tmpFile);
    $csvContent = stream_get_contents($tmpFile);
    fclose($tmpFile);

    // ── ส่งผ่าน Yii2 Response ────────────────────────────────────
    $response = Yii::$app->response;
    $response->format = \yii\web\Response::FORMAT_RAW;
    $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
    $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
    $response->headers->set('Pragma', 'no-cache');
    $response->headers->set('Expires', '0');
    $response->content = $csvContent;

    // ไม่ต้องเรียก Yii::$app->end()
}


    // ══════════════════════════════════════════════════════════════
    //  EXPORT PDF — mPDF
    //  ติดตั้ง: composer require mpdf/mpdf
    // ══════════════════════════════════════════════════════════════

    private function exportToPdf(array $data): void
    {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        gc_enable();

        $defaultReasons = $this->getDefaultReasons();
        $no      = 1;
        $pdfData = [];

        foreach ($data as $row) {
            $hn     = $this->formatHn($row['hn'] ?? '');
            $reason = $row['reason'] ?? '';
            if ($reason === '') {
                $reason = $defaultReasons[array_rand($defaultReasons)];
            }
            $pdfData[] = [
                'no'       => $no++,
                'program'  => 'fdh',
                'tran_id' => $row['trans_id']  ?? '',
                'cid'      => trim($row['cid']  ?? ''),
                'hn'       => $hn,
                'regdate'  => $this->formatDate($row['regdate'] ?? ''),
                'fullname' => $row['fullname']  ?? '',
                'reason'   => $reason,
            ];
        }
        $total = count($pdfData);

        unset($data, $defaultReasons);
        gc_collect_cycles();

        $tmpDir = Yii::$app->runtimePath . '/mpdf_tmp';
        if (!is_dir($tmpDir)) {
            mkdir($tmpDir, 0755, true);
        }

        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'orientation'   => 'L',
            'margin_left'   => 12,
            'margin_right'  => 8,
            'margin_top'    => 12,
            'margin_bottom' => 12,
            'margin_footer' => 6,
            'default_font'  => 'garuda',
            'tempDir'       => $tmpDir,
            'simpleTables'  => true,
        ]);

        $mpdf->SetTitle('รายงาน C305 ไม่ได้ Authen OPPP');
        $mpdf->SetAuthor('โรงพยาบาลม่วงสามสิบ');
        $mpdf->SetFooter('หน้า {PAGENO} / {nbpg}');

        $mpdf->WriteHTML('
<style>
body      { font-family:"garuda",sans-serif; font-size:9pt; color:#2c3e50; }
h2        { text-align:center; color:#6a0dad; font-size:13pt; margin:0 0 4px; }
.sub      { text-align:center; font-size:10pt; margin:0 0 8px; }
hr        { border:none; border-top:2px solid #9b5de5; margin-bottom:10px; }
table.main{ width:100%; border-collapse:collapse; font-size:7.5pt; }
th        { background:#e5cafc; color:#6a0dad; font-weight:bold;
            text-align:center; vertical-align:middle;
            border:1px solid #c4a8e8; padding:5px 3px; white-space:nowrap; }
td        { border:1px solid #c4a8e8; padding:4px 3px; vertical-align:top; }
.tc       { text-align:center; }
.tl       { text-align:left; }
.sum      { margin-top:12px; background:#f2f0f5; border:1px solid #9b5de5;
            padding:7px 12px; font-weight:bold; font-size:10pt; }
table.sig { width:100%; margin-top:40px; }
.sig-r    { text-align:center; font-size:10pt; line-height:2.2; }
</style>
<h2>แบบแจ้งเหตุผลความจำเป็นกรณีไม่ได้จัดให้ผู้มีสิทธิแสดงตนยืนยันสิทธิเมื่อสิ้นสุดการรับบริการ (ข้อมูลติด C305)</h2>
<p class="sub">ชื่อหน่วยบริการ โรงพยาบาลม่วงสามสิบ &nbsp;&nbsp; รหัสหน่วยบริการ 10953</p>
<p class="sub">งวดจ่ายเดือน มกราคม 2568- มกราคม 2569 &nbsp;&nbsp; กรณีบริการ  ECLAIM 305</p>
<hr>
<table class="main">
<thead><tr>
<th style="width:4%;">ลำดับ</th>
    <th style="width:8%;">โปรแกรม<br>ที่ส่งเบิก</th>
    <th style="width:10%;">เลขอ้างอิงโปรแกรมที่ส่งเบิก / train_id</th>
    <th style="width:13%;">PID</th>
    <th style="width:6%;">HN</th>
    <th style="width:8%;">วันที่<br>เข้ารับบริการ</th>
    <th style="width:12%;">ชื่อ-นามสกุล</th>
    <th>เหตุผลความจำเป็น</th>
</tr></thead>
<tbody>');

        foreach (array_chunk($pdfData, 30) as $i => $chunk) {
            $html = '';
            foreach ($chunk as $r) {
                $bg = ($r['no'] % 2 === 0) ? '#ffffff' : '#f2f0f5';
                $html .=
                    '<tr style="background:' . $bg . ';">' .
                    '<td class="tc">'  . $r['no']       . '</td>' .
                    '<td class="tc">'  . htmlspecialchars($r['program'],  ENT_QUOTES, 'UTF-8') . '</td>' .
                    '<td class="tc">'  . htmlspecialchars($r['tran_id'], ENT_QUOTES, 'UTF-8') . '</td>' .                  
                    '<td class="tc">'  . htmlspecialchars($r['cid'],      ENT_QUOTES, 'UTF-8') . '</td>' .
                    '<td class="tc">'  . htmlspecialchars($r['hn'],       ENT_QUOTES, 'UTF-8') . '</td>' .
                    '<td class="tc">'  . htmlspecialchars($r['regdate'],  ENT_QUOTES, 'UTF-8') . '</td>' .
                    '<td class="tl">'  . htmlspecialchars($r['fullname'], ENT_QUOTES, 'UTF-8') . '</td>' .
                    '<td class="tl">'  . htmlspecialchars($r['reason'],   ENT_QUOTES, 'UTF-8') . '</td>' .
                    '</tr>';
            }
            $mpdf->WriteHTML($html);
            unset($html, $chunk);
            gc_collect_cycles();
        }

        $mpdf->WriteHTML(
            '</tbody></table>' .
            '<div class="sum">สรุปรวมทั้งสิ้น &nbsp;&nbsp; จำนวน &nbsp;&nbsp; '
            . number_format($total) . ' &nbsp;&nbsp; รายการ</div>' .
            '<table class="sig"><tr>' .
            '<td style="border:none;width:50%;"></td>' .
            '<td class="sig-r" style="border:none;">' .
            'ลงชื่อ ............................................<br>' .
            '(นายประจักษ์ &nbsp; สีลาชาติ)<br>' .
            'ตำแหน่งผู้อำนวยการโรงพยาบาลม่วงสามสิบ' .
            '</td></tr></table>'
        );

        $mpdf->Output('c305_fdh_' . date('Ymd_His') . '.pdf', \Mpdf\Output\Destination::DOWNLOAD);
        Yii::$app->end();
    }
}