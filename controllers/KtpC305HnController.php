<?php
/**
 * =====================================
 * วางโค้ดนี้ใน Controller ของคุณ เช่น
 * app\controllers\KtpC305HnController.php
 * =====================================
 * ต้องติดตั้ง PhpSpreadsheet ก่อน:
 *   composer require phpoffice/phpspreadsheet
 * =====================================
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use app\models\KtpC305Hn;

class KtpC305HnController extends Controller
{
    // ------------------------------------------------------------------
    // หน้า index (รายการ) — ปรับตามระบบของคุณ
    // ------------------------------------------------------------------
    public function actionIndex()
    {
        return $this->render('index');
    }

    // ------------------------------------------------------------------
    // หน้าฟอร์มอัปโหลด + รับ POST นำเข้า
    // ------------------------------------------------------------------
    public function actionImport()
    {
        if (Yii::$app->request->isPost) {
            $file = UploadedFile::getInstanceByName('import_file');

            if (!$file) {
                Yii::$app->session->setFlash('error', 'กรุณาเลือกไฟล์ Excel ก่อนนำเข้า');
                return $this->render('import');
            }

            // บันทึกไฟล์ชั่วคราว
            $tmpPath = Yii::getAlias('@runtime/uploads/') . uniqid('c305_', true) . '.' . $file->extension;
            @mkdir(dirname($tmpPath), 0777, true);

            if (!$file->saveAs($tmpPath)) {
                Yii::$app->session->setFlash('error', 'ไม่สามารถบันทึกไฟล์ชั่วคราวได้');
                return $this->render('import');
            }

            try {
                $result = $this->processImport($tmpPath);
                @unlink($tmpPath);

                // สร้าง debug info แสดง header จริง vs DB field
                $headerDebug = '';
                if (!empty($result['headerActual'])) {
                    $pairs = [];
                    foreach ($result['headerActual'] as $dbField => $excelHeader) {
                        $pairs[] = htmlspecialchars($excelHeader) . '→' . htmlspecialchars($dbField);
                    }
                    $headerDebug = '<br><small style="color:#555">Header ที่ detect: ' . implode(' | ', $pairs) . '</small>';
                }

                Yii::$app->session->setFlash(
                    'success',
                    "นำเข้าข้อมูลสำเร็จ! "
                    . "บันทึก: <strong>{$result['inserted']}</strong> แถว | "
                    . "ข้อผิดพลาด: <strong>{$result['errorRows']}</strong> แถว | "
                    . "แถวว่าง: <strong>{$result['emptyRows']}</strong> แถว "
                    . "(จากทั้งหมด {$result['total']} แถวข้อมูล)"
                    . $headerDebug
                    . ($result['firstError']
                        ? '<br><span class="text-danger"><strong>Error แรก:</strong> '
                          . htmlspecialchars($result['firstError']) . '</span>'
                        : '')
                );
            } catch (\Exception $e) {
                @unlink($tmpPath);
                Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
            }

            return $this->redirect(['import']);
        }

        return $this->render('import');
    }

    // ------------------------------------------------------------------
    // ประมวลผลไฟล์ Excel และนำเข้า DB
    // ------------------------------------------------------------------
    private function processImport(string $filePath): array
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet       = $spreadsheet->getActiveSheet();
        $rows        = $sheet->toArray(null, true, true, true); // key = A, B, C …

        // ลำดับ DB fields ตามโครงสร้างตาราง (position-based)
        $dbFields = [
            'ที่',
            'rep',
            'tran_id',
            'HN',
            'AN',
            'pid',
            'fullname',
            'สิทธิการรักษาพยาบาล',
            'หน่วยบริการแม่ข่าย (HmainOP)',
            'วันที่ส่งข้อมูล',
            'regdate',
            'ลำดับที่',
            'รายการประเภทที่ขอเบิก',
            'เรียกเก็บ',
            'O',
            'P',
            'Q',
            'ล่าช้า (PS)',
            'S',
            'ชดเชย',
            'U',
            'V',
            'W',
            'สถานะ',
            'c305',
            'หมายเหตุอื่นๆ (STMID)',
            'หน่วยบริการที่ส่งข้อมูล (HSEND)',
        ];

        // คอลัมน์วันที่ที่ต้องแปลง
        $dateFields = ['วันที่ส่งข้อมูล', 'regdate'];

        // ──────────────────────────────────────────────────────────────
        // ค้นหาแถว Header อัตโนมัติ โดยดูว่าแถวไหนมี cell ไม่ว่างติดกัน
        // มากที่สุด (>= 5 cell) แล้วถือว่านั่นคือ header row
        // จากนั้น map ตาม "ลำดับตำแหน่งคอลัมน์" ไม่ใช่ชื่อ
        // ──────────────────────────────────────────────────────────────
        $headerRowIndex  = null;
        $colPositions    = []; // dbField => letter (A,B,C,…)
        $headerActual    = []; // ชื่อ header จริงจาก Excel (เพื่อ debug)

        foreach ($rows as $rowIndex => $row) {
            // เก็บเฉพาะ column letters ที่มีค่าไม่ว่าง เรียงตาม Excel order
            $nonEmptyCols = [];
            foreach ($row as $colLetter => $cell) {
                if (trim((string)$cell) !== '') {
                    $nonEmptyCols[] = $colLetter;
                }
            }

            // ถือว่าเจอ header row เมื่อมีอย่างน้อย 5 column ไม่ว่าง
            if (count($nonEmptyCols) >= 5) {
                $headerRowIndex = $rowIndex;

                // map ตาม position: column แรก → dbFields[0], สอง → dbFields[1] …
                foreach ($nonEmptyCols as $pos => $colLetter) {
                    if (isset($dbFields[$pos])) {
                        $colPositions[$dbFields[$pos]] = $colLetter;
                        $headerActual[$dbFields[$pos]] = trim((string)$row[$colLetter]);
                    }
                }
                break;
            }
        }

        if ($headerRowIndex === null) {
            throw new \Exception(
                'ไม่พบแถว Header ในไฟล์ Excel (ต้องมีอย่างน้อย 5 คอลัมน์ที่ไม่ว่าง)'
            );
        }

        $inserted   = 0;
        $emptyRows  = 0;
        $errorRows  = 0;
        $total      = 0;
        $firstError = null;

        // ✅ ใช้ db connection เดียวกับ Model (db70)
        $db = KtpC305Hn::getDb();

        foreach ($rows as $rowIndex => $row) {
            // ข้ามแถว header และแถวก่อนหน้า
            if ($rowIndex <= $headerRowIndex) {
                continue;
            }

            // ตรวจแถวว่าง — ดูทุก cell ใน row
            $rowValues = array_filter(array_map(function($v) { return trim((string)$v); }, $row));
            if (empty($rowValues)) {
                $emptyRows++;
                continue;
            }

            $total++;
            $data = [];

            foreach ($colPositions as $dbField => $col) {
                $val = isset($row[$col]) ? trim((string)$row[$col]) : null;

                // แปลงวันที่
                if (in_array($dbField, $dateFields) && $val !== null && $val !== '') {
                    $val = $this->parseDate($val);
                }

                $data[$dbField] = ($val === '') ? null : $val;
            }

            // ✅ ใช้ raw SQL + backtick เพื่อรองรับชื่อคอลัมน์ภาษาไทย/วงเล็บ
            try {
                $cols   = [];
                $params = [];
                $i      = 0;
                foreach ($data as $colName => $val) {
                    $cols[]            = '`' . str_replace('`', '``', $colName) . '`';
                    $params[':p' . $i] = $val;
                    $i++;
                }
                $sql = 'INSERT INTO `KTP_C305_HN` ('
                    . implode(', ', $cols)
                    . ') VALUES ('
                    . implode(', ', array_keys($params))
                    . ')';
                $db->createCommand($sql, $params)->execute();
                $inserted++;
            } catch (\Exception $e) {
                $errorRows++;
                if ($firstError === null) {
                    $firstError = '[แถว ' . $rowIndex . '] ' . $e->getMessage();
                }
                \Yii::warning('Import row ' . $rowIndex . ': ' . $e->getMessage(), __METHOD__);
            }
        }

        return [
            'inserted'     => $inserted,
            'emptyRows'    => $emptyRows,
            'errorRows'    => $errorRows,
            'total'        => $total,
            'firstError'   => $firstError,
            'colsFound'    => array_keys($colPositions),
            'headerActual' => $headerActual, // ชื่อ header จริงที่อ่านได้จาก Excel
        ];
    }

    // ------------------------------------------------------------------
    // แปลงวันที่ Excel serial หรือข้อความ → Y-m-d
    // ------------------------------------------------------------------
    private function parseDate($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Excel serial number
        if (is_numeric($value) && $value > 1000) {
            try {
                $date = ExcelDate::excelToDateTimeObject((float)$value);
                return $date->format('Y-m-d');
            } catch (\Exception $e) {
                // ไม่ใช่ serial
            }
        }

        // ลอง parse ข้อความ
        $formats = ['d/m/Y', 'd-m-Y', 'Y-m-d', 'd/m/y', 'Y/m/d'];
        foreach ($formats as $fmt) {
            $dt = \DateTime::createFromFormat($fmt, $value);
            if ($dt) {
                return $dt->format('Y-m-d');
            }
        }

        // ลอง strtotime เป็น fallback
        $ts = strtotime($value);
        if ($ts) {
            return date('Y-m-d', $ts);
        }

        return $value; // คืนค่าเดิมถ้าแปลงไม่ได้
    }
}