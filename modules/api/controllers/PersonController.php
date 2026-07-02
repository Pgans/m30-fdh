<?php

namespace backend\modules\api\controllers;

use backend\modules\api\models\Person;

class PersonController extends \yii\web\Controller {

  // public $enableCsrfValidation =false;

    public function actionIndex()
    {
       // echo 'this is test'; exit; 
        return $this->render('index');
    }
    public function actionCreateProvider() {
    
      \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

      $provider = new Providert();

      $provider->scenario = Student:: SCENARIO_CREATE;

      $provider->attributes = \yii::$app->request->post();

      if($provider->validate()) {

       $provider->save();

       return array('status' => true, 'data'=> 'Provider record is successfully updated');

      } else {

       return array('status'=>false,'data'=>$provider->getErrors());    

      }

    // public function actionCreatePerson() {
    //    \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
    //    $person = new Person();
    //    $person->scenario = Person::SCENARIO_CREATE;
    //    $person->attributes= \Yii::$app->request->post();

    //    if ($person->validate())  {
    //        return array('status'=> true);

    //    } else {
    //        return array('status'=>false, 'data'=>$person->getErrors());
    //    }
    // }

}
