<?php

namespace backend\modules\api\controllers;

use backend\modules\api\models\Provider;

class ProviderController extends \yii\web\Controller {

    public $enableCsrfValidation = false;


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreateProvider() {
     
       \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
       $provider = new Provider();
       $provider->scenario = Provider:: SCENARIO_CREATE;
       $provider->attributes = \yii::$app->request->post();
       if($provider->validate()) {
        $provider->save();
        return array('status' => true, 'data'=> 'Provider record is successfully');
       } else {
        return array('status'=>false,'data'=>$provider->getErrors());    
       }
     }
     public function actionGetProvider() {
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
        $provider = Provider::find()->all();

        if(count($provider) > 0) {
            return array('status' => true, 'data' => $provider);
        } else {
            return array('status'=> false, 'data'=>'No Provider Not Found');
        }
     }

     public function actionUpdateProvider() {

           \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;     

         $attributes = \yii::$app->request->post();
       
         $provider = Provider::find()->where(['Cid' => $attributes['CID'] ])->one();

          if(count($provider) > 0 ) {

           $provider->attributes = \yii::$app->request->post();

           $provider->save();

           return array('status' => true, 'data'=> 'Provider record is updated successfully');
          }
        else
        {

           return array('status'=>false,'data'=> 'No Provider Found');

        }
   }

     public function actionDelete()
        {
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
        $attributes = \yii::$app->request->post();
            $provider = Provider::find()->where(['Provider' => $attributes['PROVIDER'] ])->one();  
            if(count($provider) > 0 )
        {
            $provider->delete();
        return array('status' => true, 'data'=> 'Provider record is successfully deleted'); 
            }
        else
        {
        return array('status'=>false,'data'=> 'No Provider Found');
        }
        }

        public function actionPutProvider()
    {
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
        $attributes = \yii::$app->request->post();
        $provider = Provider::find()->where(['Cid' => $attributes['CID']])->one();
        //'CID' => 'Cid',
        if (count($provider) > 0) {
            $provider->attributes = \yii::$app->request->post();
            $provider->save();
            return array('status' => true, 'data' => 'provider record is updated successfully');
        } else {
            return array('status' => false, 'data' => 'No Provider Found');
        }
    }
}
