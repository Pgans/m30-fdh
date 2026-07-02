
<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use dosamigos\datepicker\DatePicker;
use kartik\datecontrol\DateControl;
use app\models\Mradepartmetnsopd;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('app', 'วันAudit: {name}', [
    'name' => $model->date_audit
	]);
$this->title = 'pdf_view';

?>
<br>
<p align="center"><b>โรงพยาบาลม่วงสามสิบ</b></p>
<p align="center">ประมวลผลความสมบูรณ์เวชระเบียนผู้ป่วยนอก</p>
  <!--<h5>ประมวลผลจากวันที่   '.$date1.'  ถึงวันที่  .$date2 </h5>-->
 

<?php
echo GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        
        'panel' => [
            'before'=>'<b style="color:info">ประมวลผลความสมบูรณ์เวชระเบียนผู้ป่วยนอก</b>',
           // 'after'=>'<b style="color:">ประมวลผลจากวันที่ </b>'.$date1   .'<b style="color:">ถึงวันที่</b>' .$date2 
                   ],
               'columns' => [
                   // ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'hosp_name',
                        'header' => 'รพ.',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 'unit_name',
                        'header' => 'หน่วยบริการ',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's1',
                        'header' => 'Profile',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's2',
                        'header' => 'Hist',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's3',
                        'header' => 'Phys',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's4',
                        'header' => 'Teat',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's5',
                        'header' => 'Foll1',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's6',
                        'header' => 'Foll2',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's7',
                        'header' => 'Foll3',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's8',
                        'header' => 'Oper',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's9',
                        'header' => 'Ins',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's10',
                        'header' => 'Reh',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    
                    [
                        'attribute' => 'sum',
                        'header' => 'คะแนนได้',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                
                    [
                        'attribute' => 'full',
                        'header' => 'คะแนนเต็ม',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 'percent',
                        'header' => 'ร้อยละ',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
					[
                        'attribute' => 'amounts',
                        'header' => 'ราย',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
						
                    [
                        'attribute' => 'date_audit',
                        'header' => 'Audit',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                 
                    ]
                ]);
                    
                    ?>
               <!-- </div>-->
                <div class="well">
                <table class="table table-striped" width="450" border="0" align="center" cellspacing="0" >
        <thead>
        <tr>
            <th><a>Content  medical record</a></th><th>Profile</th><th>Hist</th>
        <th>Phys</th><th>Teat</th><th>Foll1</th><th>Foll2</th><th>Foll3</th><th>Oper</th><th>Inf</th><th>Reh</th><th>Sum</th><th>Full</th>
        </tr>
        
        <?php
        foreach($dataProvider->getModels() as $key => $value):
        ?>
        <tr>
        <td><a>sum</a></td>
            <td align="center"><?=$value["s1"];?></td>
            <td align="center"><?=$value["s2"];?></td>
            <td align="center"><?=$value["s3"];?></td>
            <td align="center"><?=$value["s4"];?></td>
            <td align="center"><?=$value["s5"];?></td>
            <td align="center"><?=$value["s6"];?></td>
            <td align="center"><?=$value["s7"];?></td>
            <td align="center"><?=$value["s8"];?></td>
            <td align="center"><?=$value["s9"];?></td>
            <td align="center"><?=$value["s10"];?></td>
            
        <tr>
            <td><a>full</a></td>
            <td align="center"><?=$value["f1"];?></td>
            <td align="center"><?=$value["f2"];?></td>
            <td align="center"><?=$value["f3"];?></td>
            <td align="center"><?=$value["f4"];?></td>
            <td align="center"><?=$value["f5"];?></td>
            <td align="center"><?=$value["f6"];?></td>
            <td align="center"><?=$value["f7"];?></td>
            <td align="center"><?=$value["f8"];?></td>
            <td align="center"><?=$value["f9"];?></td>
            <td align="center"><?=$value["f10"];?></td>
               
        </tr>
        <tr>
            <td><a>Percent</a></td>
            <td align="center"><?=$value["p1"];?></td>
            <td align="center"><?=$value["p2"];?></td>
            <td align="center"><?=$value["p3"];?></td>
            <td align="center"><?=$value["p4"];?></td>
            <td align="center"><?=$value["p5"];?></td>
            <td align="center"><?=$value["p6"];?></td>
            <td align="center"><?=$value["p7"];?></td>
            <td align="center"><?=$value["p8"];?></td>
            <td align="center"><?=$value["p9"];?></td>
            <td align="center"><?=$value["p10"];?></td>
            
        </tr>
        
         
         <?php endforeach; ?>
        </table>
		
                            </div>
                         </div>
                    </div>
             </div>
        </div>
  