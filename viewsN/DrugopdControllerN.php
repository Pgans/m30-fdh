<?php

namespace app\controllers;

use Yii;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper; 
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\editable\Editable;
use yii\widgets\Pjax;
use app\models\Service;
use yii\filters\VerbFilter;
/* เพิ่มคำสั่ง 3 บรรทัดต่อจากนี้ลงไป */
use yii\filters\AccessControl;        // เรียกใช้ คลาส AccessControl
use app\models\User;             // เรียกใช้ Model คลาส User ที่ปรับปรังปรุงไว้
use app\components\AccessRule;   // เรียกใช้ คลาส Component AccessRule ที่เราสร้างใหม่

class DrugopdController extends \yii\web\Controller
{
	public function behaviors(){
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access'=>[
                'class'=>AccessControl::className(),
                'only'=> ['index','create','update','view','drugzone'],
                'ruleConfig'=>[
                    'class'=>AccessRule::className()
                ],
                'rules'=>[
                    [
                        'actions'=>['index','create','drugzone'],
                        'allow'=> true,
                        'roles' => [
                            //'?', 
                           // '@',
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
    public function actionIndex()
    {
        $data = Yii::$app->request->post();
        $year =isset($data['txt_year'])  ? $data['txt_year'] : '';
        $month =isset($data['txt_month'])  ? $data['txt_month'] : '';
        $hospcode =isset($data['hospcode'])  ? $data['hospcode'] : '';

           $strSQL = "SELECT d.hospcode , d.didstd, d.dname, sum(d.amount) amount , day(d.date_serv) as dateserv
           FROM drug_opd d
           WHERE DATE_FORMAT(d.DATE_SERV,'%Y-%m') LIKE '$year-$month%'
           AND d.hospcode = '$hospcode'
           GROUP BY d.DIDSTD, d.date_serv ";
            
                    $day = Yii::$app->db3->createCommand($strSQL)->queryAll();
                    foreach($day as $row){
                        $allReportData[$row['didstd']][$row['dateserv']] = $row['amount'];
                      }
                   
                       echo "<pre>";
                      // print_r($allReportData);
                        echo "</pre>";
      //yii2 dropdownlist no model        
################################################################################
        
        $hcode = " SELECT d.hospcode , d.didstd, d.dname, d.amount , day(d.date_serv) as dateserv
        FROM drug_opd d
        WHERE d.date_serv BETWEEN CURDATE()-15 AND NOW()
        AND d.hospcode = '03693'
        GROUP BY  d.didstd, d.date_serv";
         
         $data = Yii::$app->db3->createCommand($hcode)->queryAll();
         foreach($data as $row){
            $allEmpData[$row['didstd']] =$row['didstd'] = $row['dname'];
           }
            echo "<pre>";
           // print_r($allEmpData);
            echo "</pre>";

                    return $this->render('index',[
                        'allEmpData'=> $allEmpData,
                        'allReportData'=> $allReportData,
                        'hospcode'=>$hospcode,
                        
                    ]);
                }
                public function actionDrugzone(){
                    $data = Yii::$app->request->post();
                    $date1 = isset($data['date1']) ? $data['date1'] : '';
                    $date2 = isset($data['date2']) ? $data['date2'] : '';
                    $items =isset($data['items'])  ? $data['items'] : NUll;
                    $items1 =isset($data['items1'])  ? $data['items1'] : NUll;
                    $items2 =isset($data['items2'])  ? $data['items2'] : NUll;
                    $items3 =isset($data['items3'])  ? $data['items3'] : NUll;
                    
                    if(count($items)>0){  // ตรวจสอบ checkbox ว่ามีการเลือกมาอย่างน้อย 1 รายการหรือไม่
                       // $hcode = [];
                        foreach($items as $i => $hcode) {
                           // var_dump($hcode, $items1[$i], $item2[$i]);
                           // echo "$x = $hcode <br>";
                           $code[] = $hcode;
                            $hospcode =  implode("','", $code);
                           // print_r($hospcode);
                        } 
                    }
                    if(count($items1)>0){
                        $hcode1 = []; 
                        foreach($items1 as $i => $hcode1) {
                            $code1[] = $hcode1;
                             $hospcode1 =  implode("','", $code1);
                           //  print_r($hospcode1);
                         }  
                    }
                    if(count($items2)>0){
                        $hcode1 = []; 
                        foreach($items2 as $i => $hcode2) {
                            $code2[] = $hcode2;
                             $hospcode2 =  implode("','", $code2);
                           //  print_r($hospcode1);
                         }  
                    }
                    if(count($items3)>0){
                        $hcode3 = []; 
                        foreach($items3 as $i => $hcode3) {
                            $code3[] = $hcode3;
                             $hospcode3 =  implode("','", $code3);
                           //  print_r($hospcode1);
                         }  
                    }
                $sql = "SELECT k.hospcode, k.hospname , k.dname , k.amount,  k.unit_packing, k.unit_packing, k.unit_name
                        FROM (
                        SELECT DISTINCT d.hospcode , c.hospname , d.didstd, d.dname, sum(d.amount) amount, d.unit , d.unit_packing,
                         IF(l.unit_name is null = '', l.unit_name,'') as unit_name
                        FROM drug_opd d
                        LEFT  JOIN l_unit_drugs l on l.unit_id = d.unit_packing
                        INNER JOIN chospital_muang c ON d.hospcode = c.hospcode
                        WHERE d.date_serv between  '$date1' and '$date2'
                        AND d.hospcode in ('$hospcode','$hospcode1','$hospcode2','$hospcode3')
                        GROUP BY  d.didstd, d.hospcode
                        ORDER BY HOSPCODE) as k
                        ";
                        
               $rawData = \yii::$app->db3->createCommand($sql)->queryAll();
    
               try {
                   $rawData = \Yii::$app->db3->createCommand($sql)->queryAll();
               } catch (\yii\db\Exception $e) {
                   throw new \yii\web\ConflictHttpException('sql error');
               }
               //$model->date_admit = date('Y-m-d');
               $dataProvider = new \yii\data\ArrayDataProvider([
                   'allModels' => $rawData,
                   'pagination' => FALSE,
               ]);
               return $this->render('drug_zone', [
                           'dataProvider' => $dataProvider,
                           'sql'=>$sql,
                           'date1'=>$date1,
                           'date2'=>$date2,
        
               ]); 
             
           }
           
        }

   
