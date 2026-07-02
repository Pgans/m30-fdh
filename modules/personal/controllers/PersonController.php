<?php

namespace backend\modules\personal\controllers;

use Yii;
use common\models\Person;
use backend\modules\personal\models\PersonSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/* เพิ่มคำสั่ง 3 บรรทัดต่อจากนี้ลงไป */
use yii\filters\AccessControl;        // เรียกใช้ คลาส AccessControl
use common\models\User;             // เรียกใช้ Model คลาส User ที่ปรับปรังปรุงไว้
use common\components\AccessRule;   // เรียกใช้ คลาส Component AccessRule ที่เราสร้างใหม่

/**
 * PersonController implements the CRUD actions for Person model.
 */
class PersonController extends Controller
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
                           // User::ROLE_EMPLOYEE,
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
     * Lists all Person models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Person model.
     * @param integer $user_id
     * @param string $dep_id
     * @param integer $positions_id
     * @return mixed
     */
    public function actionView($user_id, $dep_id, $positions_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($user_id, $dep_id, $positions_id),
        ]);
    }

    /**
     * Creates a new Person model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Person();
        $user = new User();

        if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
          $user->password_hash = Yii::$app->security->generatePasswordHash($user->password_hash);
          $user->auth_key = Yii::$app->security->generateRandomString();
          if ($user->save()) {
            $file = UploadedFile::getInstance($model, 'person_img');
            if ($file->size!=0) {
              $model->photo = $user->id.'.'.$file->extension;
              $file->saveAs('uploads/person/'.$user->id.'.'.$file->extension);
            }
            $model->user_id = $user->id;
            $model->save();
          }
            return $this->redirect(['view', 'user_id' => $model->user_id, 'dep_id' => $model->dep_id, 'positions_id' => $model->positions_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'user' => $user,
            ]);
        }
    }

    /**
     * Updates an existing Person model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $user_id
     * @param string $dep_id
     * @param integer $positions_id
     * @return mixed
     */
    public function actionUpdate($user_id, $dep_id, $positions_id)
    {
        $model = $this->findModel($user_id, $dep_id, $positions_id);
        $user = $model->user;
        $oldPass = $user->password_hash;

        if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
          if ($oldPass!=$user->password_hash) {//เปลียนรกัสผ่านใหม่
            $user->password_hash = Yii::$app->security->generatePasswordHash($user->password_hash);
          }
          if ($user->save()) {
            $file = UploadedFile::getInstance($model, 'person_img');
            if (isset($file->size) && $file->size!==0) {
              $file->saveAs('uploads/person/' .$user->id.'.'.$file->extension);
            }
            $model->save();
          }

            return $this->redirect(['view', 'user_id' => $model->user_id, 'dep_id' => $model->dep_id, 'positions_id' => $model->positions_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'user'=> $user,
            ]);
        }
    }

    /**
     * Deletes an existing Person model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $user_id
     * @param string $dep_id
     * @param integer $positions_id
     * @return mixed
     */
    public function actionDelete($user_id, $dep_id, $positions_id)
    {
        $this->findModel($user_id, $dep_id, $positions_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Person model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $user_id
     * @param string $dep_id
     * @param integer $positions_id
     * @return Person the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($user_id, $dep_id, $positions_id)
    {
        if (($model = Person::findOne(['user_id' => $user_id, 'dep_id' => $dep_id, 'positions_id' => $positions_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
