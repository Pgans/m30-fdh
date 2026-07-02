<?php

namespace app\controllers;

use Yii;
use app\models\PatientClaim305;
use app\models\PatientClaim305Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use yii\helpers\ArrayHelper;

class PatientClaim305Controller extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'import' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel  = new PatientClaim305Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new PatientClaim305();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Record created successfully.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Record updated successfully.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Record deleted.');
        return $this->redirect(['index']);
    }

    public function actionImport()
    {
        if (Yii::$app->request->isPost) {
            $file = UploadedFile::getInstanceByName('import_file');

            if (!$file) {
                Yii::$app->session->setFlash('error', 'กรุณาเลือกไฟล์');
                return $this->render('import');
            }

            $ext = strtolower($file->extension);
            if (!in_array($ext, ['xls', 'xlsx'])) {
                Yii::$app->session->setFlash('error', 'รองรับเฉพาะไฟล์ .xls และ .xlsx เท่านั้น');
                return $this->render('import');
            }

            $tmpDir = Yii::getAlias('@runtime/uploads');
            if (!is_dir($tmpDir)) {
                mkdir($tmpDir, 0755, true);
            }
            $tmpPath = $tmpDir . '/' . uniqid('import_') . '.' . $ext;
            $file->saveAs($tmpPath);

            $result   = $this->processImport($tmpPath);
            $imported = $result[0];
            $skipped  = $result[1];
            $errors   = $result[2];
            @unlink($tmpPath);

            $msg = "นำเข้าสำเร็จ {$imported} รายการ, ข้ามไป {$skipped} รายการ";
            if (!empty($errors)) {
                $msg .= ' | ข้อผิดพลาด: ' . implode('; ', array_slice($errors, 0, 3));
            }
            Yii::$app->session->setFlash('success', $msg);
            return $this->redirect(['index']);
        }

        return $this->render('import');
    }

    private function processImport($filePath)
    {
        $imported = 0;
        $skipped  = 0;
        $errors   = [];

        $colMap = [
            // snake_case
            'no'                 => 'no',
            'eclaim_no'          => 'eclaim_no',
            'patient_type'       => 'patient_type',
            'benefit_rights'     => 'benefit_rights',
            'card_no'            => 'card_no',
            'patient_name'       => 'patient_name',
            'hn'                 => 'hn',
            'an'                 => 'an',
            'service_date'       => 'service_date',
            'service_time'       => 'service_time',
            'discharge_date'     => 'discharge_date',
            'discharge_time'     => 'discharge_time',
            'data_status'        => 'data_status',
            'recorder_name'      => 'recorder_name',
            'tran_id'            => 'tran_id',
            'high_cost'          => 'high_cost',
            'claim_amount'       => 'claim_amount',
            'rep'                => 'rep',
            'stm'                => 'stm',
            'seq'                => 'seq',
            'inspection_details' => 'inspection_details',
            'deny_warning'       => 'deny_warning',
            'channel'            => 'channel',
            // Thai
            'row'                          => 'no',
            'eclaim no'                    => 'eclaim_no',
            'ประเภทผู้ป่วย'                 => 'patient_type',
            'สิทธิประโยชน์'                 => 'benefit_rights',
            'หมายเลขบัตร'                   => 'card_no',
            'ชื่อผู้ป่วย'                    => 'patient_name',
            'เลขบัตรประจำตัวผู้ป่วย(hn)'    => 'hn',
            'บัตรประจำตัวผู้ป่วยใน (an)'    => 'an',
            'วันที่เข้ารับบริการ'            => 'service_date',
            'เวลารับบริการ'                 => 'service_time',
            'วันที่จำหน่าย'                 => 'discharge_date',
            'เวลาจำหน่าย'                  => 'discharge_time',
            'สถานะข้อมูล'                   => 'data_status',
            'ชื่อผู้บันทึกเบิกชดเชย'        => 'recorder_name',
            'tran id'                      => 'tran_id',
            'ค่าใช้จ่ายสูง'                 => 'high_cost',
            'ยอดเรียกเก็บ'                  => 'claim_amount',
            'rep'                          => 'rep',
            'stm'                          => 'stm',
            'seq'                          => 'seq',
            'รายละเอียดการตรวจสอบ'          => 'inspection_details',
            'deny/warning'                 => 'deny_warning',
            'channel'                      => 'channel',
        ];

        // String fields that should be converted to string
        $stringFields = ['eclaim_no', 'card_no', 'hn', 'an', 'rep', 'stm', 'inspection_details', 'deny_warning', 'channel'];

        try {
            $spreadsheet = IOFactory::load($filePath);
            $sheet       = $spreadsheet->getActiveSheet();
            $rows        = $sheet->toArray(null, true, true, false);

            if (empty($rows)) {
                return [0, 0, ['ไฟล์ว่างเปล่า']];
            }

            // Detect header
            $headerRowIdx = -1;
            $searchTerms = ['eclaim', 'patient', 'ประเภทผู้ป่วย', 'สิทธิ', 'หมายเลขบัตร'];
            
            foreach ($rows as $rIdx => $row) {
                $rowText = strtolower(implode(' ', array_map('trim', $row)));
                foreach ($searchTerms as $term) {
                    if (strpos($rowText, strtolower($term)) !== false) {
                        $headerRowIdx = $rIdx;
                        break 2;
                    }
                }
            }

            if ($headerRowIdx === -1) {
                return [0, 0, ['ไม่พบแถว Header กรุณาตรวจสอบโครงสร้างไฟล์']];
            }

            $headers = array_map(function($h) {
                return preg_replace('/\s+/', ' ', strtolower(trim($h)));
            }, $rows[$headerRowIdx]);

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $rowCount = count($rows);
                for ($i = $headerRowIdx + 1; $i < $rowCount; $i++) {
                    $rowData = $rows[$i];

                    $hasValue = false;
                    foreach ($rowData as $v) {
                        if ($v !== null && $v !== '') {
                            $hasValue = true;
                            break;
                        }
                    }
                    if (!$hasValue) continue;

                    $data = [];
                    foreach ($headers as $colIdx => $colName) {
                        if (isset($colMap[$colName])) {
                            $value = isset($rowData[$colIdx]) ? $rowData[$colIdx] : null;
                            $data[$colMap[$colName]] = $value;
                        }
                    }

                    if (empty($data['eclaim_no'])) continue;

                    // Date conversion
                    foreach (['service_date', 'discharge_date'] as $dateAttr) {
                        if (!empty($data[$dateAttr])) {
                            if (is_numeric($data[$dateAttr])) {
                                $ts = ExcelDate::excelToTimestamp($data[$dateAttr]);
                            } else {
                                $ts = strtotime($data[$dateAttr]);
                            }
                            $data[$dateAttr] = $ts ? date('Y-m-d', $ts) : null;
                        }
                    }

                    // Type conversions - integers
                    if (isset($data['no']))           $data['no']           = (int)$data['no'];
                    if (isset($data['patient_type'])) $data['patient_type'] = (int)$data['patient_type'];
                    if (isset($data['data_status']))  $data['data_status']  = (int)$data['data_status'];
                    if (isset($data['tran_id']))      $data['tran_id']      = (int)$data['tran_id'];
                    if (isset($data['seq']))          $data['seq']          = (int)$data['seq'];
                    
                    // Type conversions - decimals
                    if (isset($data['high_cost']))    $data['high_cost']    = (float)$data['high_cost'];
                    if (isset($data['claim_amount'])) $data['claim_amount'] = (float)$data['claim_amount'];

                    // CRITICAL: Convert string fields to string (prevent validation errors)
                    foreach ($stringFields as $field) {
                        if (isset($data[$field]) && $data[$field] !== null) {
                            $data[$field] = (string)$data[$field];
                        }
                    }

                    $model = new PatientClaim305();
                    $model->setAttributes($data, false);

                    if ($model->validate() && $model->save(false)) {
                        $imported++;
                    } else {
                        $skipped++;
                        $rowNum   = $i + 1;
                        $errMsgs  = ArrayHelper::getColumn($model->errors, 0);
                        $errors[] = 'แถว ' . $rowNum . ': ' . implode(', ', $errMsgs);
                    }
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            $errors[] = 'นำเข้าล้มเหลว: ' . $e->getMessage();
        }

        return [$imported, $skipped, $errors];
    }

    protected function findModel($id)
    {
        $model = PatientClaim305::findOne($id);
        if ($model !== null) {
            return $model;
        }
        throw new NotFoundHttpException('ไม่พบข้อมูล #' . $id);
    }
}