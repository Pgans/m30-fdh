<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;;
use app\models\Mradepartmetnsopd;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MraopdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'แบบบันทึกความสมบูรณ์เวชระเบียนผู้ป่วยนอก');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mraopd-index">
<div class="box box-success box-solid">
<div class='well'>

    <p>
        <?= Html::a(Yii::t('app', '<span class="glyphicon  glyphicon-plus" aria-hidden="true"></span>เพิ่มบันทึกผู้ป่วยนอก'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php 
    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'filename' => 'drugs',
        'showConfirmAlert' => false,
        'fontAwesome' => true,
        // 'columns' => [
        //     ['class' => 'yii\grid\SerialColumn'],
        //     'hospcode',
        //     'hospname',
        //     'didstd'
        // ],
        'clearBuffers' => true, //optional
    ]);
     ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'mra_id',
            // [
            //     'attribute' => 'unit.unit_name',
            //     'header' => 'แผนก',
            //     'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
            // ],
            [
                'attribute' => 'unit.id',
                'value'=> 'unit.unit_name',
                'filter' => Html::activeDropDownList($searchModel, 'unit_id',
                ArrayHelper::map(mradepartmetnsopd::find()->all(), 'unit_id', 'unit_name'),
                ['class' => 'form-control'])
              ],
            
            [
                'attribute' => 'HN',
                //'header' => 'แผนก',
                'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
            ],
            //'AN',
            //'dr_license',
            //'date_admit',
            //'date_discharge',
            [
            'attribute' => 'date_audit',
            'header' => 'วันตรวจสอบ',
            'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
           ],
           [
            'attribute' => 'visit',
            'header' => 'ครั้งที่',
            'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
           ],
            //'NA01',
            //'MI01',
            //'NO01',
            //'SC011',
            //'SC012',
            //'SC013',
            //'SC014',
            //'SC015',
            //'SC016',
            //'SC017',
            //'SC018',
            //'SC019',
            //'PEIM01',
            //'DEC01',
            //'NA02',
            //'MI02',
            //'NO02',
            //'SC021',
            //'SC022',
            //'SC023',
            //'SC024',
            //'SC025',
            //'SC026',
            //'SC027',
            //'SC028',
            //'SC029',
            //'PEIM02',
            //'DEC02',
            //'NA03',
            //'MI03',
            //'NO03',
            //'SC031',
            //'SC032',
            //'SC033',
            //'SC034',
            //'SC035',
            //'SC036',
            //'SC037',
            //'SC038',
            //'SC039',
            //'PEIM03',
            //'DEC03',
            //'NA04',
            //'MI04',
            //'NO04',
            //'SC041',
            //'SC042',
            //'SC043',
            //'SC044',
            //'SC045',
            //'SC046',
            //'SC047',
            //'SC048',
            //'SC049',
            //'PEIM04',
            //'DEC04',
            //'NA05',
            //'MI05',
            //'NO05',
            //'SC051',
            //'SC052',
            //'SC053',
            //'SC054',
            //'SC055',
            //'SC056',
            //'SC057',
            //'SC058',
            //'SC059',
            //'PEIM05',
            //'DEC05',
            //'Followdate1',
            //'Followdate2',
            //'NA06',
            //'MI06',
            //'NO06',
            //'SC061',
            //'SC062',
            //'SC063',
            //'SC064',
            //'SC065',
            //'SC066',
            //'SC067',
            //'SC068',
            //'SC069',
            //'PEIM06',
            //'DEC06',
            //'Followdate3',
            //'NA70',
            //'MI07',
            //'NO07',
            //'SC071',
            //'SC072',
            //'SC073',
            //'SC074',
            //'SC075',
            //'SC076',
            //'SC077',
            //'SC078',
            //'SC079',
            //'PEIM07',
            //'DEC07',
            //'NA08',
            //'MI08',
            //'NO08',
            //'SC081',
            //'SC082',
            //'SC083',
            //'SC084',
            //'SC085',
            //'SC086',
            //'SC087',
            //'SC088',
            //'SC089',
            //'PEIM08',
            //'DEC08',
            //'NA09',
            //'MI09',
            //'NO09',
            //'SC091',
            //'SC092',
            //'SC093',
            //'SC094',
            //'SC095',
            //'SC096',
            //'SC097',
            //'SC098',
            //'SC099',
            //'PEIM09',
            //'DEC09',
            //'NA10',
            //'MI10',
            //'NO10',
            //'SC101',
            //'SC102',
            //'SC103',
            //'SC104',
            //'SC105',
            //'SC106',
            //'SC107',
            //'SC108',
            //'SC109',
            //'PEIM10',
            //'DEC10',
            //'hospcode',
			[
			  'class' => 'yii\grid\ActionColumn',
			  'buttonOptions'=>['class'=>'btn btn-default'],
			  'template'=>'<div class="btn-group btn-group-sm text-center" role="group"> {view} {update} {delete} </div>'
			],
             ['class' => 'yii\grid\ActionColumn',
           'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to(['scan-batch/view',  'id' => $key, 'id' => $model->mra_id]);
           },
                'header'=>'คลิกดู',
                
                'headerOptions' => ['style' => 'width:15%'],
                'template'=>'<div class="btn-group btn-group-sm text-center" role="group"> {detail} {edit} {del} </div>',
                'buttons'=>[
                    'detail' => function($url,$model,$key){
                        return Html::a('ดูคะแนน',
                            ['mrasum', 'id' => $model->mra_id,'hn' => $model->HN],
                           // ['class' => 'btn btn-inverse'],
                            ['class' => 'btn btn-info'],
							//['class' => 'btn btn-info', 'id'=>'modalButton'],
                            $url);	     
                    },
					'edit' => function($url,$model,$key){
                        return Html::a('คะแนนร้อยละ',
                            ['pdf', 'id' => $model->mra_id,'hn' => $model->HN],
                           // ['class' => 'btn btn-inverse'],
                            ['class' => 'btn btn-warning'],
							//['class' => 'btn btn-info', 'id'=>'modalButton'],
                            $url);	     
                    },
                /*
                    'edit' => function($url,$model,$key){
                                      return Html::a('แก้ไข',
                                          ['update', 'id' => $model->mra_id],
                                          ['class' => 'btn btn-warning'],
                                       $url);
                    },
					
					'del' => function($url,$model,$key){
							 return Html::a('ลบ',
							 ['delete', 'id' => $model->mra_id],
							 ['class' => 'btn btn-danger'],
							 $url);
					 },
					 */
                ],
            ],
        ],
    ]);
     ?>

</div>

<!-- <?php
$this->registerJsFile('@web/js/main.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?> -->
<?php
  $this->registerJs("$(function() {
   $('#modalButton').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-content')
     .load($(this).attr('value'));
   });
});");
?>



</div>
