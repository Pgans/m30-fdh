<?php

namespace app\controllers;

use Yii;
use app\models\Qrcode;
use app\models\QrcodeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use Mpdf\QrCode\Qrcode as QrCodeGenerator;

/**
 * QrcodeController implements the CRUD actions for Qrcode model.
 */
class QrcodeController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => QrCode::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    // Action สำหรับสร้าง QR Code และบันทึกลงฐานข้อมูล
    public function actionGenerateQrCode($data)
    {
        $model = new Qrcode();
        $model->code_data = $data;

        if ($model->save()) {
            // สร้าง QR Code
            $qrCode = new QrCodeGenerator($data);
            $qrCode->writeFile(Yii::getAlias('@web/uploads/qrcodes/' . $model->id . '.png'));

            return $this->render('generated', ['model' => $model]);
        } else {
            Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล QR Code');
            return $this->redirect(['site/index']);
        }
    }
      // Action สำหรับดาวน์โหลดไฟล์ QR Code
    public function actionDownload($id)
    {
        $model = QrCode::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $filePath = Yii::getAlias('@web/uploads/qrcodes/') . $model->id . '.png';

        if (file_exists($filePath)) {
            Yii::$app->response->sendFile($filePath)->send();
        } else {
            throw new NotFoundHttpException('The requested file does not exist.');
        }
    }
    /*
    public function actionIndex()
    {
        $searchModel = new QrcodeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGenerateQrCode($data)
    {
        $model = new QrCode();
        $model->code_data = $data;

        if ($model->save()) {
            // สร้าง QR Code
            $qrCode = new QrCodeGenerator($data);
            $qrCode->writeFile(Yii::getAlias('@web/uploads/qrcodes/' . $model->id . '.png'));

            return $this->render('generated', ['model' => $model]);
        } else {
            Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล QR Code');
            return $this->redirect(['site/index']);
        }
    }
    */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    ################################################################
    public function actionGenerated($id)
    {
        $model = QrCode::findOne($id);
    
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    
        return $this->render('generated', [
            'model' => $model,
        ]);
    }
    /**
     * Creates a new Qrcode model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Qrcode();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Qrcode model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Qrcode model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Qrcode model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Qrcode the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Qrcode::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
