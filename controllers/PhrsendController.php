<?php

namespace app\controllers;

use yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use app\models\Logphr;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\db\Query;
use yii\db\Expression;

class PhrsendController extends Controller
{
    public function actionIndex()
    {
        $data = Yii::$app->request->post();
        $regdate = isset($data['regdate']) ? $data['regdate'] : '';
    echo $regdate;
        $connection = Yii::$app->db143;

        $query01 =" SELECT
        COUNT(s.visit_id) AS total,
        SUM(CASE WHEN v.`status` = '200' THEN 1 ELSE 0 END) AS success,
        SUM(CASE WHEN v.`status` IS NULL THEN 1 ELSE 0 END) AS nopass
        FROM
            send_phr s
            LEFT JOIN log_phr v ON v.visit_id = s.visit_id
        WHERE
            s.opd_date BETWEEN '2023-01-01' AND CURDATE()
    ";
$command = \Yii::$app->db143->createCommand($query01);
$result = $command->queryOne(); // Assuming you expect one row of results

$totalx = $result['total'];
$successx = $result['success'];
$nopassx = $result['nopass'];
##$total = \Yii::$app->db143->createCommand($query01)->queryScalar();
########################## ด้านซ้ายแสดงรายการ วันที่ จำนวนที่ส่ง #########################################################
        $query1 =" SELECT
        s.opd_date as opd_date,
        COUNT(s.visit_id) AS total,
        SUM(CASE WHEN v.`status` = '200' THEN 1 ELSE 0 END) AS success,
        SUM(CASE WHEN v.`status` IS NULL THEN 1 ELSE 0 END) AS nopass
        FROM
            send_phr s
            LEFT JOIN log_phr v ON v.visit_id = s.visit_id
        WHERE
            s.opd_date BETWEEN SUBDATE(CURDATE(), INTERVAL 10 DAY) AND CURDATE()
        GROUP BY
            s.opd_date
        ORDER BY
            s.opd_date DESC
    ";
$result1 = \Yii::$app->db143->createCommand($query1)->queryAll();

$total = 0;
$success = 0;
$nopass = 0;

foreach ($result1 as $row) {
    $total += $row['total'];
    $success += $row['success'];
    $nopass += $row['nopass'];
}

$dataProvider1 = new ArrayDataProvider([
    'allModels' => $result1,
    'pagination' => [
        'pageSize' => 10,
    ],
]);
        $dataProvider1 = new ArrayDataProvider([
            'allModels' => \Yii::$app->db143->createCommand($query1)->queryAll(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

################### ดึงข้อมูล List แสดงตามวันที่ ที่เลือก ############################
        //$regdate = '2022-01-01';
        $query2 = "SELECT
        s.visit_id,
				s.unit_reg,
        v.cid,
        v.response,
        v.regdate,
        v.d_update,
        s.opd_date,
        v.status
    FROM
            send_phr s
            LEFT JOIN log_phr v ON v.visit_id = s.visit_id
    WHERE
           s.opd_date = '$regdate'
			AND v.status IS NULL
       ";

        $dataProvider2 = new ArrayDataProvider([
            'allModels' => \Yii::$app->db143->createCommand($query2)->queryAll(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $query2 = "SELECT
    v.visit_id,
    v.cid,
    v.response,
    v.regdate,
    v.d_update,
    s.opd_date,
    v.status
FROM
    log_phr v
LEFT JOIN send_phr s ON s.visit_id = v.visit_id
WHERE
    s.opd_date = '$regdate'
AND v.status <> '200'";

$dataProvider2 = new ArrayDataProvider([
    'allModels' => \Yii::$app->db143->createCommand($query2)->queryAll(),
    'pagination' => [
        'pageSize' => 20,
    ],
]);

echo '<table border="1">
        <tr>
            <th>Visit ID</th>
            <th>CID</th>
            <th>Response</th>
            <th>Registration Date</th>
            <th>Last Update Date</th>
            <th>OPD Date</th>
            <th>Status</th>
        </tr>';

foreach ($dataProvider2->getModels() as $model) {
    echo '<tr>';
    echo '<td>' . $model['visit_id'] . '</td>';
    echo '<td>' . $model['cid'] . '</td>';
    echo '<td>' . $model['response'] . '</td>';
    echo '<td>' . $model['regdate'] . '</td>';
    echo '<td>' . $model['d_update'] . '</td>';
    echo '<td>' . $model['opd_date'] . '</td>';
    echo '<td>' . $model['status'] . '</td>';
    echo '</tr>';
}

echo '</table>';

        

        ###############################################
        $query3 = "SELECT
            v.visit_id,
            v.cid,
            v.response,
            v.regdate,
            v.d_update,
            v.status
        FROM
            log_phr v
        WHERE
            date(v.regdate) = '$regdate'
        AND v.status = '200'";

        $dataProvider3 = new ArrayDataProvider([
            'allModels' => \Yii::$app->db143->createCommand($query3)->queryAll(),
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        ########################################################
      
        return $this->render('index', [
            'dataProvider1' => $dataProvider1,
           // 'dataProvider01' => $dataProvider01,
            'dataProvider2' => $dataProvider2,
            'dataProvider3' => $dataProvider3,
            'total'=>$total,
            'success'=>$success,
            'nopass'=>$nopass,
            'totalx'=>$totalx,
            'successx'=>$successx,
            'nopassx'=>$nopassx,
           // 'dataProvider3' => $dataProvider4,
        ]);
    }
    public function actionDelete($regdate, $visit_id)
    {
        $model = Logphr::findOne(['visit_id' => $visit_id]);
    
        if ($model !== null) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'ลบ ' . $visit_id . ' เรียบร้อย.');
        } else {
            Yii::$app->session->setFlash('error', 'Item not found.');
        }
    
        return $this->redirect(['phrsend/index', 'regdate' => $regdate]);
    }

    public function actionDeleteSelected()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
    
        $selectedIds = Yii::$app->request->post('ids');
    
        if (!empty($selectedIds)) {
            try {
                // Assuming you have a model named 'YourModel'
                $modelsToDelete = Logphr::findAll(['visit_id' => $selectedIds]);
    
                foreach ($modelsToDelete as $model) {
                    $model->delete();
                }
    
                return ['success' => true, 'message' => 'Selected items deleted successfully.'];
            } catch (\Exception $e) {
                // Handle the exception, log, or return an error message
                return ['success' => false, 'message' => 'Error deleting selected items.'];
            }
        } else {
            return ['success' => false, 'message' => 'No items selected for deletion.'];
        }
    }
    public function actionBulkDelete()
{
    Yii::$app->response->format = Response::FORMAT_JSON;

    $selectedIds = Yii::$app->request->post('selection');

    if (!empty($selectedIds)) {
        try {
            // Assuming you have a model named 'YourModel'
            Logphr::deleteAll(['id' => $selectedIds]);

            return ['success' => true, 'message' => 'Selected items deleted successfully.'];
        } catch (\Exception $e) {
            // Handle the exception, log, or return an error message
            return ['success' => false, 'message' => 'Error deleting selected items.'];
        }
    } else {
        return ['success' => false, 'message' => 'No items selected for deletion.'];
    }
}

public function actionUpdateSendPhrProcedure()
{
    try {
        // Call the stored procedure using Yii2's database command
        $command = Yii::$app->db143->createCommand("CALL sendphr()");
        $rowsAffected = $command->execute();
    
        Yii::$app->session->setFlash('success', "สำเร็จ Updated Successfully. จำนวน: $rowsAffected");
    } catch (\Exception $e) {
        Yii::$app->session->setFlash('error', 'Error ไม่สำเร็จ!..กรุณาตรวจสอบ: ' . $e->getMessage());
    }
    
    return $this->redirect(['index']);
    

    // Assuming you want to redirect after the stored procedure is called.
    return $this->redirect(['index']);
}
###########################################################
public function actionUpdateSendPhrAll()
{
    try {
        // Call the stored procedure using Yii2's database command
        $command = Yii::$app->db143->createCommand("CALL update_phr_all()");
        $rowsAffected = $command->execute();
    
        Yii::$app->session->setFlash('success', "สำเร็จ Updated Successfully. จำนวน: $rowsAffected");
    } catch (\Exception $e) {
        Yii::$app->session->setFlash('error', 'Error ไม่สำเร็จ!..กรุณาตรวจสอบ: ' . $e->getMessage());
    }
    
    return $this->redirect(['index']);
}
#########################################################
public function actionDeleteLogPhr()
{
    try {
        $command = Yii::$app->db143->createCommand("DELETE FROM log_phr WHERE (status <> '200' OR messagecode <> 'OK')");
        $rowsAffected = $command->execute();

        Yii::$app->session->setFlash('success', "[ลบข้อมูลสำเร็จ ส่วนที่ส่งไม่ผ่าน] Successfully. จำนวน: $rowsAffected");
    } catch (\Exception $e) {
        Yii::$app->session->setFlash('error', 'Error deleting: ' . $e->getMessage());
    }

    return $this->redirect(['index']); // Replace 'index' with the actual route you want to redirect to.
}
}
    /*
public function actionUpdateSendPhrProcedurex()
    {
        $db = Yii::$app->db143;

        // Fetching data from multiple tables as per the provided SQL query
        $dataToInsert = (new Query())
            ->select([
                'opd_date' => new Expression('DATE(o.reg_datetime)'),
                'opd_time' => new Expression('TIME(o.reg_datetime)'),
                'unit_reg' => 'o.unit_reg',
                'icd10_tm' => 'i.icd10_tm',
                'regdate' => 'v.regdate',
                'd_update' => 'v.d_update',
                'visit_id' => 'o.visit_id',
                'status' => 'v.status',
                'messagecode' => 'v.messagecode',
            ])
            ->from(['o' => 'mbase_data1.opd_visits'])
            ->leftJoin(['v' => 'log_phr'], 'o.visit_id = v.visit_id AND v.status = \'200\'')
            ->leftJoin(['d' => 'mbase_data1.opd_diagnosis'], 'd.visit_id = o.visit_id AND d.is_cancel = 0')
            ->leftJoin(['i' => 'mbase_data1.icd10new'], 'i.icd10 = d.icd10 AND d.dxt_id = 1')
            ->where([
                'and',
                ['>=', 'o.REG_DATETIME', new Expression('(SELECT MAX(opd_date) FROM send_phr)')],
                ['o.is_cancel' => 0],
                ['<>', 'i.icd10', '']
            ])
            ->groupBy('o.visit_id')
            ->all($db);

            foreach ($dataToInsert as $row) {
                $sql = "REPLACE INTO send_phr (opd_date, opd_time, unit_reg, icd10_tm, regdate, d_update, visit_id, status, messagecode) VALUES (:opd_date, :opd_time, :unit_reg, :icd10_tm, :regdate, :d_update, :visit_id, :status, :messagecode)";
            
                $params = [
                    ':opd_date' => $row['opd_date'],
                    ':opd_time' => $row['opd_time'],
                    ':unit_reg' => $row['unit_reg'],
                    ':icd10_tm' => $row['icd10_tm'],
                    ':regdate' => $row['regdate'],
                    ':d_update' => $row['d_update'],
                    ':visit_id' => $row['visit_id'],
                    ':status' => $row['status'],
                    ':messagecode' => $row['messagecode'],
                ];
            
                Yii::$app->db143->createCommand($sql, $params)->execute();
            }
            
        Yii::$app->session->setFlash('success', 'The SendPhr Procedure has been updated successfully.');
        return $this->redirect(['index']); 
    }
    */
//}
    



