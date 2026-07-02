<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\ProcessModel;

class LockController extends Controller
{
    public function actionIndex()
    {
        $openTablesData = $this->getOpenTablesData();
        
        $model = new ProcessModel();
        $processList = $model->getProcessList();
        
        return $this->render('index', [
            'openTablesData' => $openTablesData,
            'processList' => $processList
        ]);
    }

    public function actionRefresh()
    {
        $data = $this->getOpenTablesData();
        return $this->asJson($data);
    }

    private function getOpenTablesData()
    {
        $query = "SHOW OPEN TABLES WHERE In_use > 0";
        return Yii::$app->db->createCommand($query)->queryAll();
    }

    public function actionKill($id)
    {
        $model = new ProcessModel();
        if ($model->killProcess($id)) {
            Yii::$app->session->setFlash('success', 'Kill Process สำเร็จ');
        }
        return $this->redirect(['index']);
    }
}
