<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\ProcessModel;
use Yii;

class ProcessController extends Controller
{
    public function actionIndex()
    {
        $model = new ProcessModel();
        $processList = $model->getProcessList();

        return $this->render('index', [
            'processList' => $processList
        ]);
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