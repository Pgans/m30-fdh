<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper; 
//use app\models\Service;

$this->title = 'ข้อมูลยา[Drugs Ubon System]';
?>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<style>
.number{ text-align : right;}
.number div{
 background: #ABEBC6;
 color : #ff0000;
}
#test_report th{ background-color : #21BBD6; color : #ffffff;}
#test_report{
 border-right : 1px solid #eeeeee;
 border-bottom : 1px solid #eeeeee;
}
#test_report td,#test_report th{
 border-top : 1px solid #eeeeee;
 border-left : 1px solid #eeeeee;
 padding : 2px;
}
#txt_year{ width : 70px;}
.fail{ color : red;}

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
<body>

<div class="box box-success box-solid">
    <div class='well'>
    <?=Html::beginForm(['drugopd/index'],'post',['name' => 'frmMain']);?> 
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
 <table>
  <tr>
   <td>ระบุเดือน-ปี : </td>
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
   <!-- <td><?= Html::a('แสดง Gridview All Emp Data', ['drugopd/gridview', 'type' => 'allEmpData']) ?></td>
<td><?= Html::a('แสดง Gridview All Report Data', ['drugopd/gridview', 'type' => 'allReportData']) ?></td>-->
<td><?= Html::a('แสดงข้อมูล All Report Data', ['drugopd/index', 'type' => 'allReportData']) ?> 
<td><?= Html::a('แสดงข้อมูล All Emp Data', ['drugopd/index', 'type' => 'allEmpData']) ?>
</td>
</td>
  </tr>
 </table>
</form>
    </br>
    
    <!-- <table border='0' id='test_report' cellpadding='0' cellspacing='0' >
        <tr>
            <th><div  ><a>สถานพยาบาล</a></div></th>-->
        <?php
 echo "<table border='0' id='test_report' cellpadding='0' cellspacing='0'>";
 echo '<tr>';//เปิดแถวใหม่ ตาราง HTML
 //echo '<th>#</th>';
//  echo '<th>รหัสสถานพยาบาล</th>';
 echo '<th>ชื่อยา ('.$hospcode.')</th>';
          //วันที่สุดท้ายของเดือน
$timeDate = strtotime($year.'-'.$month."-01");  //เปลี่ยนวันที่เป็น timestamp
$lastDay = date("t", $timeDate);       //จำนวนวันของเดือน
echo "$timeDate";
//สร้างหัวตารางตั้งแต่วันที่ 1 ถึงวันที่สุดท้ายของดือน
for($day=1; $day<=$lastDay; $day++){
 echo '<th>' . substr("0".$day, -2) . '</th>';
}
echo "</tr>";
//วนลูปเพื่อสร้างตารางตามจำนวนรายชื่อพนักงานใน Array
foreach($allEmpData as $didstd=>$dname){
    echo '<tr>';//เปิดแถวใหม่ ตาราง HTML
    // echo '<td>'. $id .'</td>';
    // echo '<td>'. $didstd .'</td>';
     echo '<td>'. $dname .'</td>';
for($j=1; $j<=$lastDay; $j++){
    //ตรวจสอบว่าวันที่แต่ละวัน $j ของ พนักงานแต่ละรหัส  $empCode มีข้อมูลใน  $allReportData หรือไม่ ถ้ามีให้แสดงจำนวนในอาร์เรย์ออกมา ถ้าไม่มีให้เป็น 0
 //   $numSeq = isset($dayProvider[$hospcode][$j]) ? '<div>'.$hcodeProvider[$hospcode][$j].'</div>' : 0;
 $numSeq = isset($allReportData[$didstd][$j]) ? '<div>'.$allReportData[$didstd][$j].'</div>' : 0;
 echo "<td class='number'>", $numSeq, "</td>";
}
 echo '</tr>';//ปิดแถวตาราง HTML
}
echo "</table>";

   ?>
    
   