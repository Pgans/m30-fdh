<?php

use yii\helpers\Html;
//use yii\helpers\Url;
//use app\models\Service;

$this->title = 'ข้อมูลการส่ง 43 แฟ้ม[Service Ubon System]';
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
</style>
</head>
<body>
</br>
</br>
</br>

<div class="box box-success box-solid">

    <div class='well'>

    <?=Html::beginForm(['service/index'],'post',['name' => 'frmMain']);?> 
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
 <table>
  <tr>
   <td>ระบุเดือน-ปี : </td>
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
 echo '<th>#</th>';
 echo '<th>รหัสสถานพยาบาล</th>';
 echo '<th>สถานพยาบาล</th>';
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
foreach($allEmpData as $hospcode=>$hospname){
    echo '<tr>';//เปิดแถวใหม่ ตาราง HTML
    echo '<td>'. $id .'</td>';
    echo '<td>'. $hospcode .'</td>';
     echo '<td>'. $hospname .'</td>';
for($j=1; $j<=$lastDay; $j++){
    //ตรวจสอบว่าวันที่แต่ละวัน $j ของ พนักงานแต่ละรหัส  $empCode มีข้อมูลใน  $allReportData หรือไม่ ถ้ามีให้แสดงจำนวนในอาร์เรย์ออกมา ถ้าไม่มีให้เป็น 0
 //   $numSeq = isset($dayProvider[$hospcode][$j]) ? '<div>'.$hcodeProvider[$hospcode][$j].'</div>' : 0;
 $numSeq = isset($allReportData[$hospcode][$j]) ? '<div>'.$allReportData[$hospcode][$j].'</div>' : 0;
 echo "<td class='number'>", $numSeq, "</td>";
}
 echo '</tr>';//ปิดแถวตาราง HTML
}
echo "</table>";

        ?>
    
   