<?php

namespace app\controllers;

class MagendaController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $sql = "SELECT m.meeting_id, m.title, m.attime, m.date, m.time,m.user, 
        a.topic, a.discription, a.covenant
        FROM meeting m
        LEFT JOIN agenda a ON a.meeting_id = m.meeting_id
        ";

      $rawData = \yii::$app->db->createCommand($sql)->queryAll();

      // print_r($rawData);
       try {
           $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
       } catch (\yii\db\Exception $e) {
           throw new \yii\web\ConflictHttpException('sql error');
       }
       $dataProvider = new \yii\data\ArrayDataProvider([
           'allModels' => $rawData,
           'pagination' => [
        'pagesize'=> 15
     ],
       ]);
    //   Yii::$app->session['date1'] = $date1;
     //  Yii::$app->session['date2'] = $date2;
       return $this->render('index', [
                   'dataProvider' => $dataProvider,
                   'sql'=>$sql,
                  // 'date1' =>$date1,
                   //'date2' =>$date2,

       ]); 
   }
   public function actionAgenda_list($meetid){
  
            $sql2 = "SELECT m.meeting_id, m.title, m.attime, m.date, m.time,m.user, 
            a.topic, a.discription, a.covenant
            FROM meeting m
            LEFT JOIN agenda a ON a.meeting_id = m.meeting_id
            WHERE m.meeting_id = '$meetid' ";
        $rawData = \yii::$app->db->createCommand($sql2)->queryAll();

        // print_r($rawData);
        try {
            $rawData = \Yii::$app->db->createCommand($sql2)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => FALSE,
        ]);
        return $this->render('agenda_list', [
                    'dataProvider' => $dataProvider,
                   // 'sql'=>$sql,

        ]);
        }
}
