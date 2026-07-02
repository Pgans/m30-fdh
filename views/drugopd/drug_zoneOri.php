<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use common\models\RContributionIpd;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;
//yii2 checkboxlist html multi value
$this->title = 'Drugs_Zone';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['drugopd/index']];
//$this->params['breadcrumbs'][] = 'การใช้ยา รพสต. ตามช่วงเวลา';
?>
<br>
        <b><a>การใช้ยา รพสต. ตามช่วงเวลา</a></b>
<div class='well'>
    <?php $form = ActiveForm::begin(); ?>

     ระหว่างวันที่:
           <?php
        echo yii\jui\DatePicker::widget([
            'name' => 'date1',
            'value' => $date1,
            'language' => 'th',
            'dateFormat' => 'yyyy-MM-dd',
            'clientOptions' => [
                'autoclose' => true,
                'changeMonth' => true,
                'changeYear' => true,
            ]
        ]);
        ?>
        ถึง:
           <?php
        echo yii\jui\DatePicker::widget([
            'name' => 'date2',
            'value' => $date2,
            'language' => 'th',
            'dateFormat' => 'yyyy-MM-dd',
            'clientOptions' => [
                'autoclose' => true,
                'changeMonth' => true,
                'changeYear' => true,
            ]
        ]);
          ?>
        
        <br>
        <br>
        <div class= 'well'>
        <div class="col col-sm-2 offset-sm-3 text-right pt-3">
         <button  name="btn_submit" id="btn_submit" value="1" class="btn btn-primary btn-block py-2">พุธที่1</button>
    </div>
       <?php
      $items = [
        '03696' => 'รพสต.พระโรจน์',
        '03700' => 'รพสต.น้ำคำแดง',
        '03699' => 'รพสต.โนนขวาว',
        '03702' => 'รพสต.ยางสักกระโพหลุ่ม',
        '03701' => 'รพสต.นาดี',
        '03704' => 'รพสต.หนองไข่นก',
       
    ];
    echo Html::checkboxList('items', [], $items, ['multiple'=>true]);
       ?>  
    </br>
      <div class="left col-sm-2  text-left ">
         <button   id="btn_submit" value="1" class="btn btn-primary btn-block py-2" id="grad1">พุธที่2</button>
    </div>
        <?php
      $items1 = [
        '03703' => 'รพสต.ยางเครือ',
        '03714' => 'รพสต.โพนแพง',
        '03705' => 'รพสต.หนองเหล่า',
        '03706' => 'รพสต.ดอนแดงใหญ่',
        '03707' => 'รพสต.หนองฮาง',
        '03713' => 'รพสต.ทุ่งมณี',
    ];
    echo Html::checkboxList('items1', [], $items1, ['multiple'=>true]);
       ?>
      </br>
      <div class="left col-sm-2  text-left ">
         <button   id="btn_submit" value="1" class="btn btn-primary btn-block py-2" id="grad1">พุธที่3</button>
    </div>
	  <?php
      $items2 = [
        '03708' => 'รพสต.ผักกระย่า',
        '03712' => 'รพสต.แสงไผ่',
        '03711' => 'รพสต.ไผ่ใหญ่',
        '03709' => 'รพสต.หนองสองห้อง',
        '03710' => 'รพสต.หนองขุ่น',
        '03693' => 'รพสต.ขมิ้น',
        
    ];
    echo Html::checkboxList('items2', [], $items2, ['multiple'=>true]);
       ?>
    </br>
      <div class="left col-sm-2  text-left ">
         <button   id="btn_submit" value="1" class="btn btn-primary btn-block py-2" id="grad1">พุธที่4</button>
    </div>
      <?php
      $items3 = [
        '03697' => 'รพสต.หนองเมือง',
        '03695' => 'รพสต.บัวยาง',
        '03694' => 'รพสต.หนองแสง',
        '03706' => 'รพสต.หนองหลัก',
        '03698' => 'รพสต.สร้างมิ่ง',
    ];
    echo Html::checkboxList('items3', [], $items3, ['multiple'=>true]);
//Yii2 array explode
       ?>
       </div>
       <div align="center" class="form-group">
        <button class='btn btn-success ' > ตกลง </button>
        <button class="btn btn-info " type="reset">ล้างข้อมูล</button>
       </div>
        <?php $form = ActiveForm::begin([ ]);
            ActiveForm::end();?>
    
</div>  
<div>  

<?php
// create data provider
$data = [
    ['name' => 'John', 'age' => 25, 'gender' => 'Male'],
    ['name' => 'Mary', 'age' => 32, 'gender' => 'Female'],
    ['name' => 'Chris', 'age' => 47, 'gender' => 'Male'],
];
$dataProvider = new ArrayDataProvider([
    'allModels' => $data,
    'sort' => [
        'attributes' => ['name', 'age', 'gender'],
    ],
    'pagination' => [
        'pageSize' => 10,
    ],
]);

// export menu widget
echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        'age',
        'gender',
    ],
    'dropdownOptions' => [
        'label' => 'Export All',
        'class' => 'btn btn-secondary',
    ],
    'target' => ExportMenu::TARGET_BLANK,
    'exportConfig' => [
        ExportMenu::FORMAT_HTML => false,
        ExportMenu::FORMAT_CSV => false,
        ExportMenu::FORMAT_TEXT => false,
        ExportMenu::FORMAT_EXCEL => [
            'label' => 'Excel',
            'icon' => 'file-excel-o',
            'iconOptions' => ['class' => 'text-success'],
            'options' => ['title' => 'Microsoft Excel'],
        ],
        ExportMenu::FORMAT_PDF => [
            'label' => 'PDF',
            'icon' => 'file-pdf-o',
            'iconOptions' => ['class' => 'text-danger'],
            'options' => ['title' => 'Portable Document Format'],
            'methods' => [
                'SetHeader' => ['Generated By: My Name'],
                'SetFooter' => ['|Page {PAGENO}|'],
            ],
        ],
    ],
]);
 ?>
<?php
echo GridView::widget([
        'dataProvider' => $dataProvider,
    
               'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'hospcode',
                        'header' => 'รหัส',
                        'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
                    ],
					[
                        'attribute' => 'hospname',
                        'header' => 'สถานพยาบาล',
                        'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
                    ],
					[
                        'attribute' => 'didstd',
                        'header' => 'รหัสยา',
                        'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
                    ],
                    [
                        'attribute' => 'dname',
                        'header' => 'ชื่อยา',
                        'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
                    ],
					[
                        'attribute' => 'amount',
                        'header' => 'จำนวน',
                        'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
                    ],
					[
                        'attribute' => 'unit_name',
                        'header' => 'หน่วยนับ',
                        'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
                    ],
					// [
                    //     'attribute' => 'unit_packing',
                    //     'header' => 'รหัสหน่วยนับ',
                    // ],
                    //yii2 kartik exportmenu excell 95+ in gridview 
                    ]
                    
                    ]);
  // Set up the ExportMenu widget
  
    
                    ?>
                    <?php ActiveForm::end(); ?>
                </div>
                    
                    <div class="alert alert-info"><?=$sql?> </div>



            