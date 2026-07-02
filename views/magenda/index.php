<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'E-meeting';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['thaimed/index']];
//$this->params['breadcrumbs'][] = 'รายงานนับผู้ป่วยนอกสถานบริการ';
?>

<div class="box box-default box-solid" >
    <div class="box-header" id="grad8">
        <div class="box-title"> E-Meeting<small> วาระการประชุม</small></div>
    </div>
    <div class="box-body">
    
<?php
//return $this->redirect(array('report/dsc_list', ['date1' => $date1, 'date1' => $date2]));
echo GridView::widget([
        'dataProvider' => $dataProvider,
        
        // 'panel' => [
        //     'before'=>'วาระการประชุม',
        //     'after'=>'ประมวลผล '.date('Y-m-d H:i:s')
        //   ],
               'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                  
                    [
                        'attribute' => 'title',
                        'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,  
                        'format' => 'raw',
                        'value' => function($model) {
                            $meetid = $model['meeting_id'];
                            $title = $model['title'];
                            return Html::a(Html::encode($title), ['magenda/agenda_list','meetid' => $meetid],['target'=>'_blank']);
                        }
                            ],
                    [
                        'attribute' => 'attime',
                        'header' => 'ครั้งที่',
                        'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,  
                    ],
                    [
                        'attribute' => 'date',
                        'header' => 'วันที่ประชุม',
                        'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,  
                    ],
                    [
                        'attribute' => 'time',
                        'header' => 'เวลา',
                        'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,  
                    ],
                    [
                        'attribute' => 'user',
                        'header' => 'ผู้จัด',
                        'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,  
                    ],
                    [
                        'attribute' => 'meeting_id',
                        'header' => 'ผู้จัด',
                        'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,  
                    ],
                    // [
                    //     'attribute' => 'title ',
                    //     'header' => 'จำนวน',
                    //     'format' => 'raw',
                    //     'value' => function($model) {
                    //         $inscl = $model['meeting_id'];
                    //         $total = $model['title'];
                    //         return Html::a(Html::encode($total), ['thaimed/surgeon_9007810_list','inscl'=> $inscl],['target'=>'_blank']);
                    //     }
                         //   ],
                  ]
                ]
                    );
                    
                    ?>
                    
            <!-- <div class="alert alert-danger"><?=$sql?> </div> -->
