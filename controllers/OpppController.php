<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\C305Oppp;
use PHPExcel_IOFactory;
use PHPExcel_Shared_Date;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;
use app\components\AccessRule;

class OpppController extends Controller
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
        return $this->render('index');
    }

    public function actionImportExcel()
    {
        $file = UploadedFile::getInstanceByName('excel_file');
        
        if ($file) {
            $fileName = 'upload_' . time() . '.' . $file->extension;
            $filePath = Yii::getAlias('@app/runtime/uploads/') . $fileName;
            
            if (!is_dir(Yii::getAlias('@app/runtime/uploads/'))) {
                mkdir(Yii::getAlias('@app/runtime/uploads/'), 0777, true);
            }
            
            if ($file->saveAs($filePath)) {
                try {
                    $objPHPExcel = PHPExcel_IOFactory::load($filePath);
                    $worksheet = $objPHPExcel->getActiveSheet();
                    $highestRow = $worksheet->getHighestRow();
                    
                    // ค้นหาแถว header (ที่มีคำว่า "เลขอ้างอิงชื่อไฟล์")
                    $headerRow = $this->findHeaderRow($worksheet, $highestRow);
                    
                    if ($headerRow === null) {
                        Yii::$app->session->setFlash('error', 'ไม่พบแถว Header ในไฟล์ Excel');
                        return $this->redirect(['index']);
                    }
                    
                    $successCount = 0;
                    $errorCount = 0;
                    $skipCount = 0;
                    $errors = [];
                    
                    // เริ่มนำเข้าข้อมูลจากแถวถัดจาก header
                    for ($row = $headerRow + 1; $row <= $highestRow; $row++) {
                        try {
                            // ตรวจสอบว่าแถวนี้มีข้อมูลหรือไม่
                            if (!$this->isRowValid($worksheet, $row)) {
                                $skipCount++;
                                continue;
                            }
                            
                            $model = new C305Oppp();
                            
                            // นำเข้าข้อมูลทุกคอลัมน์
                            $model->เลขอ้างอิงชื่อไฟล์ = $this->cleanValue($this->getCellValue($worksheet, 'A', $row));
                            $model->ชื่อไฟล์ = $this->cleanValue($this->getCellValue($worksheet, 'B', $row));
                            $model->รหัสเขต = $this->cleanValue($this->getCellValue($worksheet, 'C', $row));
                            $model->ชื่อเขต = $this->cleanValue($this->getCellValue($worksheet, 'D', $row));
                            $model->รหัสจังหวัด = $this->cleanValue($this->getCellValue($worksheet, 'E', $row));
                            $model->ชื่อจังหวัด = $this->cleanValue($this->getCellValue($worksheet, 'F', $row));
                            $model->รหัสหน่วยบริการ = $this->cleanValue($this->getCellValue($worksheet, 'G', $row));
                            $model->ชื่อหน่วยบริการ = $this->cleanValue($this->getCellValue($worksheet, 'H', $row));
                            $model->รหัสบัตรประชาชน = $this->cleanValue($this->getCellValue($worksheet, 'I', $row));
                            
                            // วันที่เข้ารับบริการ (คอลัมน์ J)
                            $model->วันที่เข้ารับบริการ = $this->convertExcelDate(
                                $this->getCellValue($worksheet, 'J', $row)
                            );
                            
                            // วันที่ส่งข้อมูล (คอลัมน์ K)
                            $model->วันที่ส่งข้อมูล = $this->convertExcelDate(
                                $this->getCellValue($worksheet, 'K', $row)
                            );
                            
                            $model->ประเภทการบริการ = $this->cleanValue($this->getCellValue($worksheet, 'L', $row));
                            $model->รหัสอ้างอิงจากแฟ้ม_SERVICE = $this->cleanValue($this->getCellValue($worksheet, 'M', $row));
                            $model->รหัสหัตถการแพทย์แผนไทยที่จ่าย = $this->cleanValue($this->getCellValue($worksheet, 'N', $row));
                            $model->รหัสหัตถการแพทย์แผนไทยที่ไม่จ่าย = $this->cleanValue($this->getCellValue($worksheet, 'O', $row));
                            
                            // วันที่เสียชีวิต (คอลัมน์ P)
                            $model->วันที่เสียชีวิต = $this->convertExcelDate(
                                $this->getCellValue($worksheet, 'P', $row)
                            );
                            
                            $model->เพศ = $this->cleanValue($this->getCellValue($worksheet, 'Q', $row));
                            $model->สิทธิหลัก = $this->cleanValue($this->getCellValue($worksheet, 'R', $row));
                            $model->หน่วยบริการประจำ = $this->cleanValue($this->getCellValue($worksheet, 'S', $row));
                            $model->หน่วยบริการปฐมภูมิ = $this->cleanValue($this->getCellValue($worksheet, 'T', $row));
                            $model->รหัสหัตถการที่ส่งทั้งหมดในวันรับบริการเดียวกัน = $this->cleanValue($this->getCellValue($worksheet, 'U', $row));
                            $model->ประเภทกิจกรรมที่ส่งเบิกชดเชย = $this->cleanValue($this->getCellValue($worksheet, 'V', $row));
                            
                            // คอลัมน์ W-Z ว่างในไฟล์ตัวอย่าง ข้ามไป
                            
                            $model->มีการส่งรหัสวินิจฉัยโรค = $this->cleanValue($this->getCellValue($worksheet, 'AA', $row));
                            $model->แจ้งผลการตรวจสอบข้อผิดพลาดของข้อมูล = $this->cleanValue($this->getCellValue($worksheet, 'AB', $row));
                            $model->สรุปผลการตรวจสอบเบื้องต้น = $this->cleanValue($this->getCellValue($worksheet, 'AC', $row));
                            $model->วันที่รับบริการอยู่ในปีงบประมาณ = $this->cleanValue($this->getCellValue($worksheet, 'AD', $row));
                            $model->รหัสอ้างอิงข้อมูลสำหรับการติดต่อกับทาง_สปสช = $this->cleanValue($this->getCellValue($worksheet, 'AE', $row));
                            
                            // บันทึกข้อมูล
                            if ($model->save()) {
                                $successCount++;
                            } else {
                                $errorCount++;
                                $errors[] = "แถว {$row}: " . json_encode($model->errors);
                            }
                            
                        } catch (\Exception $e) {
                            $errorCount++;
                            $errors[] = "แถว {$row}: " . $e->getMessage();
                        }
                    }
                    
                    // ลบไฟล์ชั่วคราว
                    @unlink($filePath);
                    
                    // แสดงผลลัพธ์
                    $message = "นำเข้าข้อมูลสำเร็จ {$successCount} แถว";
                    if ($skipCount > 0) {
                        $message .= ", ข้ามแถว {$skipCount} แถว";
                    }
                    if ($errorCount > 0) {
                        $message .= ", ผิดพลาด {$errorCount} แถว";
                    }
                    
                    Yii::$app->session->setFlash('success', $message);
                    
                    if (!empty($errors)) {
                        Yii::$app->session->setFlash('warning', 
                            "รายละเอียดข้อผิดพลาด:<br>" . implode('<br>', array_slice($errors, 0, 10))
                        );
                    }
                    
                } catch (\Exception $e) {
                    Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
                }
            } else {
                Yii::$app->session->setFlash('error', 'ไม่สามารถบันทึกไฟล์ได้');
            }
        } else {
            Yii::$app->session->setFlash('error', 'กรุณาเลือกไฟล์');
        }
        
        return $this->redirect(['index']);
    }
    
    /**
     * ค้นหาแถว header ที่มีคำว่า "เลขอ้างอิงชื่อไฟล์"
     */
    private function findHeaderRow($worksheet, $highestRow)
    {
        for ($row = 1; $row <= min(20, $highestRow); $row++) {
            $value = $this->getCellValue($worksheet, 'A', $row);
            if (stripos($value, 'เลขอ้างอิงชื่อไฟล์') !== false) {
                return $row;
            }
        }
        return null;
    }
    
    /**
     * ตรวจสอบว่าแถวนี้มีข้อมูลที่ถูกต้องหรือไม่
     */
    private function isRowValid($worksheet, $row)
    {
        // ตรวจสอบคอลัมน์แรก (เลขอ้างอิงชื่อไฟล์)
        $refNumber = $this->getCellValue($worksheet, 'A', $row);
        
        // ข้ามแถวว่าง
        if (empty($refNumber) || trim($refNumber) === '') {
            return false;
        }
        
        // ข้ามแถวที่เป็น header ซ้ำ
        if (stripos($refNumber, 'เลขอ้างอิง') !== false) {
            return false;
        }
        
        // ตรวจสอบว่าเป็นแถวคำอธิบาย (มีแต่ชื่อและ Null)
        // ตรวจสอบคอลัมน์สำคัญ C, D, E, F (รหัสเขต, ชื่อเขต, รหัสจังหวัด, ชื่อจังหวัด)
        $checkColumns = ['C', 'D', 'E', 'F', 'G', 'H', 'I'];
        $allNullOrEmpty = true;
        
        foreach ($checkColumns as $col) {
            $value = $this->getCellValue($worksheet, $col, $row);
            // ถ้าไม่ว่างและไม่ใช่ (Null) แสดงว่าเป็นข้อมูลจริง
            if (!empty($value) && $value !== '(Null)') {
                $allNullOrEmpty = false;
                break;
            }
        }
        
        // ถ้าคอลัมน์สำคัญเป็น Null หมด = เป็นแถวคำอธิบาย
        if ($allNullOrEmpty) {
            return false;
        }
        
        return true;
    }
    
    /**
     * ดึงค่าจาก cell
     */
    private function getCellValue($worksheet, $column, $row)
    {
        try {
            $value = $worksheet->getCell($column . $row)->getValue();
            
            if ($value === null) {
                return '';
            }
            
            return trim((string)$value);
        } catch (\Exception $e) {
            return '';
        }
    }
    
    /**
     * ทำความสะอาดข้อมูล - ตัดคำอธิบายในวงเล็บและ (Null) ออก
     */
    private function cleanValue($value)
    {
        if (empty($value)) {
            return null;
        }
        
        // แปลงเป็น string ก่อน
        $value = (string)$value;
        
        // ถ้าเป็น (Null) หรือ null ให้คืนค่า null
        if (trim($value) === '(Null)' || trim($value) === 'null' || trim($value) === 'NULL') {
            return null;
        }
        
        // ตัดคำอธิบายในวงเล็บออกทั้งหมด - รวมถึงที่เป็นสีแดง
        // เช่น "ข้อมูล (Null)" จะเหลือแค่ "ข้อมูล"
        $value = preg_replace('/\s*\([^)]*\)\s*/', '', $value);
        
        // ตัดคำอธิบายในวงเล็บเหลี่ยมออก
        $value = preg_replace('/\s*\[[^\]]*\]\s*/', '', $value);
        
        // ตัด whitespace ที่เกินออก
        $value = preg_replace('/\s+/', ' ', $value);
        $value = trim($value);
        
        // ถ้าหลังจากทำความสะอาดแล้วเหลือแค่ว่างเปล่า ให้คืนค่า null
        if (empty($value)) {
            return null;
        }
        
        return $value;
    }
    
    /**
     * แปลงวันที่จาก Excel format
     */
    private function convertExcelDate($value)
    {
        if (empty($value) || $value === '(Null)') {
            return null;
        }
        
        // กรณีเป็นตัวเลข (Excel date serial)
        if (is_numeric($value)) {
            try {
                $date = PHPExcel_Shared_Date::ExcelToPHP($value);
                return date('Y-m-d', $date);
            } catch (\Exception $e) {
                return null;
            }
        }
        
        // กรณีเป็นข้อความ (เช่น "16/12/2567")
        try {
            // รูปแบบ วัน/เดือน/ปี (พ.ศ.)
            if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $value, $matches)) {
                $day = $matches[1];
                $month = $matches[2];
                $year = $matches[3];
                
                // แปลง พ.ศ. เป็น ค.ศ.
                if ($year > 2500) {
                    $year = $year - 543;
                }
                
                return sprintf('%04d-%02d-%02d', $year, $month, $day);
            }
            
            // รูปแบบอื่นๆ ให้ PHP แปลงเอง
            $timestamp = strtotime($value);
            if ($timestamp !== false) {
                return date('Y-m-d', $timestamp);
            }
        } catch (\Exception $e) {
            return null;
        }
        
        return null;
    }
}