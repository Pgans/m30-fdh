<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use dosamigos\datepicker\DatePicker;
use kartik\datecontrol\DateControl;
use app\models\Departmetnsipd;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;


$this->title = Yii::t('app', 'AN: {name}', [
    'name' => $model->AN,
]);
$this->params['breadcrumbs'][] = ['label' => 'กลับ', 'url' => ['mraipd/index']];
?>
<br>
<!-- <b><a>ประมวลผลความสมบูรณ์เวชระเบียนผู้ป่วยใน</a></b> -->
<div class='well'>
<div>
<?php
echo GridView::widget([
        'dataProvider' => $dataProvider,
        
        'panel' => [
            'before'=>'<b style="color:info">ประมวลผลความสมบูรณ์เวชระเบียนผู้ป่วยใน</b>',
           // 'after'=>'<b style="color:red">ประมวลผลจากวันที่ </b>'.$date1   .'<b style="color:red">ถึงวันที่</b>' .$date2 
          ],
               'columns' => [
                   // ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'hosp_name',
                        'header' => 'หน่วยบริการ',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 'unit_name',
                        'header' => 'แผนก',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's1',
                        'header' => 'DxOp',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's2',
                        'header' => 'Other',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's3',
                        'header' => 'InfoC',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's4',
                        'header' => 'Hist',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's5',
                        'header' => 'PhyE',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's6',
                        'header' => 'PrgN',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's7',
                        'header' => 'ConR',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's8',
                        'header' => 'Anes',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's9',
                        'header' => 'OprNt',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's10',
                        'header' => 'LaboR',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's11',
                        'header' => 'Rehap',
                        'headerOptions'=>[ 'style'=>'background-color:#E3E4FA'] ,
                    ],
                    [
                        'attribute' => 's12',
                        'header' => 'NursNt',
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
                    
                    ]
                ]);
                    
                    ?>
                </div>
                <div>
                <table class="table table-striped" width="450" border="0" align="center" cellspacing="0" >
        <thead>
        <tr>
            <th><a>Content  medical record</a></th><th>DxOp</th><th>Other</th>
        <th>InfoC</th><th>Hist</th><th>PhyE</th><th>PrgN</th><th>ConR</th><th>Anes</th><th>OprNt</th><th>LaboR</th><th>Rehap</th><th>NursNt</th>
        </tr>
        
        <?php
        //while($objResult = mysql_fetch_array($dataeProvider))
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
            <td align="center"><?=$value["s11"];?></td>
            <td align="center"><?=$value["s12"];?></td>
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
            <td align="center"><?=$value["f11"];?></td>
            <td align="center"><?=$value["f12"];?></td>
            
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
            <td align="center"><?=$value["p11"];?></td>
            <td align="center"><?=$value["p12"];?></td>  
        </tr>
        
        
         <?php endforeach; ?>
        </table>
                            </div>
                            <p><a class='btn btn-danger' HREF="javascript:history.back()" ><i class="fa fa-reply"></i> ย้อนกลับ</a> </p>
                         </div>
                    </div>
             </div>

        </div>
        