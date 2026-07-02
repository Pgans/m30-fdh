<?php

namespace backend\modules\api\controllers;

class localtionController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
