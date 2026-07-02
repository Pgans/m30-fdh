<?php

namespace backend\modules\api\controllers;

use backend\modules\api\models\Location;

class LocationController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreateLocation() {
     
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
        $location = new Location();
        $location->scenario = Location:: SCENARIO_CREATE;
        $location->attributes = \yii::$app->request->post();
        if($location->validate()) {
         $location->save();
         return array('status' => true, 'data'=> 'Location record is successfully');
        } else {
         return array('status'=>false,'data'=>$location->getErrors());    
        }
      }

    public function actionGetLocation() {
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
        $location = Location::find()->all();

        if(($location)> 0 ) {
            return array('status'=> true, 'data'=>$location);

        } else {
            return array('status'=>false, 'data'=>$location->getErrors());
        }
    }

    public function actionPutLocation()
    {
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
        $attributes = \yii::$app->request->post();
        $location = Location::find()->where(['ID' => $attributes['id']])->one();
        if (count($location) > 0) {
            $location->attributes = \yii::$app->request->post();
            $location->save();
            return array('status' => true, 'data' => 'Location record is updated successfully');
        } else {
            return array('status' => false, 'data' => 'No Location Found');
        }
    }
    
    public function actionDeleteLocation()
    {
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
        $attributes = \yii::$app->request->post();
        $location = Location::find()->where(['ID' => $attributes['id']])->one();
        if (count($location) > 0) {
            $location->delete();
            return array('status' => true, 'data' => 'Location record is successfully deleted');
        } else {
            return array('status' => false, 'data' => 'No Location Found');
        }
    }

}
