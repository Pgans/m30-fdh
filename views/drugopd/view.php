<?php
/* @var $this yii\web\View */

use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\widgets\ListView;
use yii\helpers\Html;


$this->title = 'DrugOPD';

$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['drugopd/index']];
$this->params['breadcrumbs'][] = 'ค้นหารายการยา';
?>
้<head>
<style>
  /* เลือกตัวเลือกสำหรับ select ของ hospcode */
  select[name="hospcode"] {
    background-color: #FFC0CB; /* เปลี่ยนสีพื้นหลัง */
    color: #000; /* เปลี่ยนสีข้อความ */
  }

  /* เลือกตัวเลือกสำหรับ select ของ txt_month */
  select[name="txt_month"] {
    background-color: #ADD8E6;
    color: #000;
  }

  /* เลือกตัวเลือกสำหรับ select ของ txt_year */
  select[name="txt_year"] {
    background-color: #98FB98;
    color: #000;
  }

  /* เลือกปุ่มค้นหา */
  input[type="submit"] {
    background-color: #FFA500;
    color: #FFF;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
  }
  
    .active-view {
        display: block;
    }

    #list-view, #grid-view {
        display: none;
    }

</style>

</head>
<br>
<b style="color:blue">ค้นหารายการยา</b>
<div class='well'>

    <?php $form = ActiveForm::begin(); ?>
    <table>
  <tr>
   <td style="text-color:red">ระบุเดือน-ปี : </td>
   <!-- <td> <input type="text"  name="cid"  placeholder=""></td> -->
   <td>
    <select name="hospcode" >
    <option value="">---รพสต.---</option>
    <?php 
    $hosp= array('03692'=> 'หนองหลัก','03693'=> 'ขมิ้น','03694'=> 'หนองแสง','03699'=> 'โนนขวาว','03701'=> 'นาดี',
    '03702'=> 'ยางสักกระโพหลุ่ม','03703'=> 'ยางเครือ','03704'=> 'หนองไข่นก','03707'=> 'หนองฮาง','03708'=> 'ผักกระย่า',
    '03709'=> 'หนองสองห้อง','03710'=> 'หนองขุ่น','03711'=> 'ไผ่ใหญ่','03712'=> 'แสงไผ่','03713'=> 'หนองหลัก',
    '03713'=> 'ทุ่งมณี','03714'=> 'โพนแพง','03698'=> 'สร้างมิ่ง','03697'=> 'หนองเมือง','03695'=> 'บัวยาง',
    '03705'=> 'หนองเหล่า','03706'=> 'ดอนแดงใหญ่','10953'=> 'รพ.ม่วงสามสิบ','99809'=> 'PCU'
    );
    $txtHosp = isset($_POST['hospcode']) && $_POST['hospcode'] != '' ? $_POST['hospcode']: date('m');
     foreach($hosp as $i=>$mName) {
      $selected = '';
      if($txtHosp == $i) $selected = 'selected="selected"';
      echo '<option value="'.$i.'" '.$selected.'>'. $mName .'</option>'."\n";
     }
    ?>
    </select>
   </td>
   <td>
    <select name="txt_month">
     <option value="">--------------</option>
     <?php
     $month = array('01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม', '04' => 'เมษายน',
         '05' => 'พฤษภาคม', '06' => 'มิถุนายน', '07' => 'กรกฎาคม', '08' => 'สิงหาคม',
         '09' => 'กันยายน ', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม');
     $txtMonth = isset($_POST['txt_month']) && $_POST['txt_month'] != '' ? $_POST['txt_month'] : date('m');
     foreach($month as $i=>$mName) {
      $selected = '';
      if($txtMonth == $i) $selected = 'selected="selected"';
      echo '<option value="'.$i.'" '.$selected.'>'. $mName .'</option>'."\n";
     }
     ?>
    </select>
   </td>
   <td>
    <select name="txt_year">
     <option value="">--------------</option>
     <?php
     $txtYear = (isset($_POST['txt_year']) && $_POST['txt_year'] != '') ? $_POST['txt_year'] : date('Y');
     $yearStart = date('Y');
     $yearEnd = $txtYear-5;
     for($year=$yearStart;$year > $yearEnd;$year--){
      $selected = '';
      if($txtYear == $year) $selected = 'selected="selected"';
      echo '<option value="'.$year.'" '.$selected.'>'. ($year) .'</option>'."\n";
     }
     ?>
    </select>
   </td>
   <td><input type="submit" value="ค้นหา" /></td>
<div class="box box-success box-solid">
    <!-- โค้ดอื่น ๆ ที่มีอยู่ -->
    <td><?= Html::a('แสดง allEmpData', ['gridview', 'type' => 'allEmpData', 'hospcode' => $hospcode], ['class' => 'btn btn-primary']) ?></td>
    <td><?= Html::a('แสดง allReportData', ['gridview', 'type' => 'allReportData', 'hospcode' => $hospcode], ['class' => 'btn btn-primary']) ?></td>
    
    
</div>


  </tr>
 </table>
   
    <?php ActiveForm::end(); ?>

   
    <div id="dynamic-view">
    <div id="list-view" class="active-view">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_drug_item',
            'separator' => '<hr>',
        ]); ?>
    </div>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'hospcode',
                    //'headerOptions' => ['style' => 'background-color:#a4e7df'],
                    'header' => 'สถาน',
                ],
                [
                    'attribute' => 'date_serv',
                   // 'headerOptions' => ['style' => 'background-color:#a4e7df'],
                    'header' => 'วันรับบริการ',
                ],
                [
                    'attribute' => 'pid',
                    'headerOptions' => ['style' => 'background-color:#a4e7df'],
                    'header' => 'hn',
                ],
                [
                    'attribute' => 'didstd',
                    'headerOptions' => ['style' => 'background-color:#a4e7df'],
                    'header' => 'รหัสยา',
                ],
                [
                    'attribute' => 'dname',
                    'headerOptions' => ['style' => 'background-color:#a4e7df'],
                    'header' => 'ชื่อยา',
                ],
                [
                    'attribute' => 'amount',
                    'headerOptions' => ['style' => 'background-color:#a4e7df'],
                    'header' => 'จำนวน',
                ],
                [
                    'attribute' => 'unit',
                    'headerOptions' => ['style' => 'background-color:#a4e7df'],
                    'header' => 'หน่วย',
                ],
                [
                    'attribute' => 'provider',
                    'headerOptions' => ['style' => 'background-color:#a4e7df'],
                    'header' => 'ผู้จ่ายยา',
                ],
                [
                    'attribute' => 'cid',
                    'headerOptions' => ['style' => 'background-color:#a4e7df'],
                    'header' => '13หลัก',
                ],
                [
                    'attribute' => 'd_update',
                    'headerOptions' => ['style' => 'background-color:#a4e7df'],
                    'header' => 'วันที่ส่งข้อมูล',
                ],
            ],
        ]); ?>
        </div>
        <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        // ... คอลัมน์อื่น ๆ ของ GridView ...

        // สร้างคอลัมน์สำหรับแสดงลิงก์ 2 ปุ่ม
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {allEmpData} {allReportData}', // เพิ่ม template สำหรับแสดงปุ่ม
            'buttons' => [
                'allEmpData' => function ($url, $model, $key) {
                    // สร้างลิงก์แสดง allEmpData โดยส่งรหัส $model->id
                    return Html::a('แสดง All Emp Data', ['drugopd/index', 'type' => 'allEmpData', 'id' => $model->id]);
                },
                'allReportData' => function ($url, $model, $key) {
                    // สร้างลิงก์แสดง allReportData โดยส่งรหัส $model->id
                    return Html::a('แสดง All Report Data', ['drugopd/index', 'type' => 'allReportData', 'id' => $model->id]);
                },
            ],
        ],
    ],
]) ?>
