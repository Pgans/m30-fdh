<?php

namespace backend\modules\equipments\controllers;

use Yii;
use common\models\Serviceout;
use backend\modules\equipments\models\ServiceoutSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;        // เรียกใช้ คลาส AccessControl
use common\models\User;             // เรียกใช้ Model คลาส User ที่ปรับปรังปรุงไว้
use common\components\AccessRule;   // เรียกใช้ คลาส Component AccessRule ที่เราสร้างใหม่
/**
 * ServiceoutController implements the CRUD actions for Serviceout model.
 */
class ServiceoutController extends Controller
{
     public function behaviors(){
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access'=>[
                'class'=>AccessControl::className(),
                'only'=> ['index','create','update','view','delete'],
                'ruleConfig'=>[
                    'class'=>AccessRule::className()
                ],
                'rules'=>[
                    [
                        'actions'=>['index','create','view'],
                        'allow'=> true,
                        'roles'=>[
                            User::ROLE_USER,
                            User::ROLE_EMPLOYEE,
                            User::ROLE_ADMIN

                        ]
                    ],
                    [
                        'actions'=>['update'],
                        'allow'=> true,
                        'roles'=>[
                            User::ROLE_EMPLOYEE,
                            User::ROLE_ADMIN
                        ]
                    ],
                    [
                        'actions'=>['delete'],
                        'allow'=> true,
                        'roles'=>[User::ROLE_ADMIN]
                    ]
                ]
            ]
        ];
    }


    /**
     * Lists all Serviceout models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServiceoutSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Serviceout model.
     * @param integer $id
     * @param integer $store_id
     * @return mixed
     */
    public function actionView($id, $store_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $store_id),
        ]);
    }

    /**
     * Creates a new Serviceout model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Serviceout();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'store_id' => $model->store_id]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Serviceout model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $store_id
     * @return mixed
     */
    public function actionUpdate($id, $store_id)
    {
        $model = $this->findModel($id, $store_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'store_id' => $model->store_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Serviceout model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $store_id
     * @return mixed
     */
    public function actionDelete($id, $store_id)
    {
        $this->findModel($id, $store_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Serviceout model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $store_id
     * @return Serviceout the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $store_id)
    {
        if (($model = Serviceout::findOne(['id' => $id, 'store_id' => $store_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
