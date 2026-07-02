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
 * Ktp305Controller — รายงาน C305
 *
 * Actions:
 *   actionIndex()             แสดงหน้า GridView
 *   actionExport()            ส่งออก CSV ทั้งหมด
 *   actionExportTransReason() ส่งออก CSV (tran_id + reason)
 *   actionExportPdf()         ส่งออก PDF รายงาน C305 (ใช้ mPDF — ไม่ต้องพึ่ง Python)
 *   actionTest()              ทดสอบ controller
 *
 * ติดตั้ง mPDF:
 *   composer require mpdf/mpdf
 */
class Psychia305Controller extends Controller
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

    /** ส่งออก CSV ทั้งหมด — URL: /ktp305/export */
    public function actionExport()
    {
        $this->exportToCsv($this->queryDataWithReason());
    }

    /** ส่งออก CSV trans_reason (2 คอลัมน์) — URL: /ktp305/export-trans-reason */
    public function actionExportTransReason()
    {
        $this->exportTransReasonCsv($this->queryTransReason());
    }

    /** ส่งออก PDF (mPDF) — URL: /ktp305/export-pdf */
    public function actionExportPdf()
    {
        $this->exportToPdf($this->queryDataWithReason());
    }

    public function actionTest()
    {
        return 'Controller Ktp305 ทำงานปกติ!';
    }

    // ════════════════════════════════════════════════════════════════
    //  QUERIES
    // ════════════════════════════════════════════════════════════════

    private function queryDataWithReason()
    {
        $sql = "
            SELECT		   
                c.tran_id,
                c.pid,
                h.hn,
                c.regdate,
                c.fullname,
                c.c305,
                c.reason
            FROM  c305_psychiatryx    c
            INNER JOIN cid_hn  h ON h.cid = c.pid
            GROUP BY c.tran_id 
        ";
        try {
            $data = Yii::$app->db70->createCommand($sql)->queryAll();
            foreach ($data as &$row) {
                $row['trans_id']  = trim($row['trans_id']  ?? '');
                $row['pid']       = trim($row['pid']       ?? '');
                $row['hn']        = trim($row['hn']        ?? '');
                $row['regdate']   = trim($row['regdate']   ?? '');
                $row['fullname']  = trim($row['fullname']  ?? '');
                $row['c305']      = trim($row['c305']      ?? '');
                $row['reason']    = trim($row['reason']    ?? '');
            }
            return $data;
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
            return [];
        }
    }

    private function queryTransReason()
    {
        $sql = "
            SELECT		   
                c.tran_id,
                c.reason
            FROM  c305_psychiatryx  c
            GROUP BY c.tran_id 
        ";
        try {
            $data = Yii::$app->db70->createCommand($sql)->queryAll();
            foreach ($data as &$row) {
                $row['tran_id'] = trim($row['tran_id'] ?? '');
                $row['reason']  = trim($row['reason']  ?? '');
            }
            return $data;
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
            return [];
        }
    }

    // ════════════════════════════════════════════════════════════════
    //  HELPER — เหตุผลเริ่มต้น
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
            ? 'c305_จิตเวช_' . $month . '_' . date('Ymd_His') . '.csv'
            : 'c305_จิตเวช_' . date('Ymd_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8

        fputcsv($out, ['แบบแจ้งเหตุผลความจำเป็นกรณีไม่ได้จัดให้ผู้มีสิทธิแสดงตนยืนยันสิทธิเมื่อสิ้นสุดการรับบริการ']);
        fputcsv($out, ['']);
        fputcsv($out, ['ชื่อหน่วยบริการ โรงพยาบาลม่วงสามสิบ รหัสหน่วยบริการ 10953']);
        fputcsv($out, ['']);
        fputcsv($out, [
            'ลำดับ', 'โปรแกรมที่ส่งเบิก', 'เลขอ้างอิงชื่อไฟล์', 'tran_id',
            'รหัสบัตรประชาชน', 'HN', 'วันที่เข้ารับบริการ', 'ชื่อ-สกุล', 'เหตุผล',
        ]);

        $no = 1;
        foreach ($data as $row) {
            $hn = trim($row['hn'] ?? '');
            $hn = $hn !== '' ? str_pad(preg_replace('/\D/', '', $hn), 6, '0', STR_PAD_LEFT) : '000000';
            $hn  = '="' . $hn . '"';

            $pid = trim($row['pid'] ?? '');
            if ($pid !== '' && strlen($pid) === 13) {
                $pid = '="' . $pid . '"';
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
                'Disability',            
                $row['tran_id'] ?? '',
                $pid,
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
    //  EXPORT CSV (trans_reason)
    // ════════════════════════════════════════════════════════════════

    private function exportTransReasonCsv(array $data): void
    {
        $defaultReasons = $this->getDefaultReasons();
        $filename = 'c305_จิตเวช_reason_' . date('Ymd_His') . '.csv';

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
            fputcsv($out, [$row['tran_id'] ?? '', $reason]);
        }
        fclose($out);
        exit();
    }

    // ════════════════════════════════════════════════════════════════
    //  EXPORT PDF — ใช้ mPDF (PHP ล้วน ไม่ต้องพึ่ง Python)
    //  ติดตั้ง: composer require mpdf/mpdf
    // ════════════════════════════════════════════════════════════════

private function exportToPdf(array $data): void
{
    // ── [1] เพิ่ม memory limit สำหรับ mPDF ──────────────────────
    $oldMemLimit = ini_get('memory_limit');
    ini_set('memory_limit', '512M');

    $defaultReasons = $this->getDefaultReasons();
    $total          = count($data);

    // ── [2] สร้าง mPDF ก่อนเลย ───────────────────────────────────
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
        'margin_header' => 0,
        'margin_footer' => 6,
        'default_font'  => 'garuda',
        'tempDir'       => $tmpDir,
    ]);

    $mpdf->SetTitle('รายงาน C305 ไม่ได้ Authen');
    $mpdf->SetAuthor('โรงพยาบาลม่วงสามสิบ');
    $mpdf->SetFooter('หน้า {PAGENO} / {nbpg}');

     // ── [3] CSS แยกต่างหาก ────────────────────────────────────────
    $mpdf->WriteHTML('
        body        { font-family: "garuda", sans-serif; font-size: 9pt; color: #2c3e50; }
        h2          { text-align: center; color: #6a0dad; font-size: 13pt; margin: 0 0 4px 0; line-height: 1.5; }
        .subtitle   { text-align: center; font-size: 10pt; margin: 0 0 8px 0; }
        hr          { border: none; border-top: 2px solid #9b5de5; margin-bottom: 10px; }
        table.main  { width: 100%; border-collapse: collapse; font-size: 7.5pt; }
        th          { background: #e5cafc; color: #6a0dad; font-weight: bold;
                      text-align: center; vertical-align: middle;
                      border: 1px solid #c4a8e8; padding: 5px 3px; white-space: nowrap; }
        td          { border: 1px solid #c4a8e8; padding: 4px 3px; vertical-align: top; }
        .tc         { text-align: center; }
        .tl         { text-align: left; }
        .mono       { text-align: center; font-family: monospace; }
        .sum-box    { margin-top: 12px; background: #f0e8ff; border: 1px solid #9b5de5;
                      border-radius: 6px; padding: 7px 12px; font-weight: bold; font-size: 10pt; }
        table.sign  { width: 100%; margin-top: 40px; }
        .sign-right { width: 50%; text-align: center; font-size: 10pt; line-height: 2.2; }
    ', \Mpdf\HTMLParserMode::HEADER_CSS);

    // ── [4] Header + เปิด table ───────────────────────────────────
    $mpdf->WriteHTML('
<h2>แบบแจ้งเหตุผลความจำเป็นกรณีไม่ได้จัดให้ผู้มีสิทธิแสดงตนยืนยันสิทธิเมื่อสิ้นสุดการรับบริการ (ข้อมูลติด C305)</h2>
<p class="subtitle">ชื่อหน่วยบริการ โรงพยาบาลม่วงสามสิบ &nbsp;&nbsp; รหัสหน่วยบริการ 10953</p>
<p class="subtitle">งวดจ่ายเดือน มกราคม 2568- มกราคม 2569  &nbsp;&nbsp; บริการฟื้นฟูและอุปกรณ์สำหรับคนพิการ DS305 (ระบบ Seamless) จิตเวช</p>
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
<tbody>', \Mpdf\HTMLParserMode::HTML_BODY);

    // ── [5] วน loop โดยตรงจาก $data โดยไม่สร้าง $pdfData ─────────
    // ลดการใช้ memory ครึ่งหนึ่ง เพราะไม่ copy ข้อมูลซ้ำ
    $chunkSize = 50;   // 50 แถวต่อ WriteHTML (ปลอดภัยกว่า 100)
    $chunkHtml = '';
    $no        = 1;

    foreach ($data as $idx => $row) {

        // แปลงข้อมูล
        $hn = trim($row['hn'] ?? '');
        if ($hn !== '') {
            $hn = str_pad(preg_replace('/\D/', '', $hn), 6, '0', STR_PAD_LEFT);
        }

        $pid = trim($row['pid'] ?? '');

        $reason = trim($row['reason'] ?? '');
        if ($reason === '') {
            $reason = $defaultReasons[array_rand($defaultReasons)];
        }

        $regdate = $row['regdate'] ?? '';
        if (!empty($regdate) && strtotime($regdate)) {
            $regdate = date('d/m/Y', strtotime($regdate));
        }

        $bg = ($no % 2 === 0) ? '#f8f4ff' : '#ffffff';

        $chunkHtml .=
            '<tr style="background:' . $bg . ';">'
            . '<td class="tc">'   . $no                                                               . '</td>'
            . '<td class="tc">Disability</td>'
            . '<td class="tc">'   . htmlspecialchars((string)($row['tran_id'] ?? ''), ENT_QUOTES, 'UTF-8') . '</td>'
            . '<td class="mono">' . htmlspecialchars($pid,                              ENT_QUOTES, 'UTF-8') . '</td>'
            . '<td class="mono">' . htmlspecialchars($hn,                               ENT_QUOTES, 'UTF-8') . '</td>'
            . '<td class="tc">'   . htmlspecialchars($regdate,                          ENT_QUOTES, 'UTF-8') . '</td>'
            . '<td class="tl">'   . htmlspecialchars((string)($row['fullname'] ?? ''), ENT_QUOTES, 'UTF-8') . '</td>'
            . '<td class="tl">'   . htmlspecialchars($reason,                           ENT_QUOTES, 'UTF-8') . '</td>'
            . '</tr>';

        $no++;

        // เมื่อครบ chunk → flush แล้วล้าง string
        if ($no % $chunkSize === 1) {
            $mpdf->WriteHTML($chunkHtml, \Mpdf\HTMLParserMode::HTML_BODY);
            $chunkHtml = '';
            gc_collect_cycles(); // [6] คืน memory ทุก chunk
        }
    }

    // flush chunk สุดท้าย (ที่อาจยังไม่ครบ chunkSize)
    if ($chunkHtml !== '') {
        $mpdf->WriteHTML($chunkHtml, \Mpdf\HTMLParserMode::HTML_BODY);
        $chunkHtml = '';
    }

    // ── [7] ปิด table + สรุป + ลงชื่อ ───────────────────────────
    $mpdf->WriteHTML('
</tbody></table>
<div class="sum-box">
    สรุปรวมทั้งสิ้น &nbsp;&nbsp; จำนวน &nbsp;&nbsp; ' . number_format($total) . ' &nbsp;&nbsp; รายการ
</div>
<table class="sign"><tr>
    <td style="border:none; width:50%;"></td>
    <td class="sign-right" style="border:none;">
        ลงชื่อ ............................................<br>
        (นายประจักษ์ &nbsp; สีลาชาติ)<br>
        ตำแหน่งผู้อำนวยการโรงพยาบาลม่วงสามสิบ
    </td>
</tr></table>
    ', \Mpdf\HTMLParserMode::HTML_BODY);

    // คืน memory limit เดิม
    ini_set('memory_limit', $oldMemLimit);

    $filename = 'c305_จิตเวช_' . date('Ymd_His') . '.pdf';
    $mpdf->Output($filename, \Mpdf\Output\Destination::DOWNLOAD);
    exit();
}
}