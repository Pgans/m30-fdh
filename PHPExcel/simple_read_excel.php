<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Bangkok');
// http://php.net/manual/en/timezones.php
require_once("Classes/PHPExcel.php");
?>
<!DOCTYPE html>
<html lang="en">
 
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@3.3.7/dist/css/bootstrap.min.css">
      
</head>
<body>
  
<br>
<br>
 
<!-- ส่วนของฟอร์มส่งค่า --> 
<div class="container" style="width:600px;margin:auto;">
<form action="" method="post" enctype="multipart/form-data" name="form1">
FILE: <input type="file" name="_fileup" id="_fileup"><br>
<button type="submit" name="btn_submit">Send</button>
 
</form>
</div>
 
<br>
<br>
<!--  ส่วนของการแสดงค่า -->
 <div class="container" style="width:600px;margin:auto;">
 <pre>
<?php 
if(isset($_POST['btn_submit'])  && isset($_FILES['_fileup']['name']) && $_FILES['_fileup']['name']!=""){
    $tmpFile = $_FILES['_fileup']['tmp_name'];  
    $fileName = $_FILES['_fileup']['name'];  // เก็บชื่อไฟล์
    $_fileup = $_FILES['_fileup'];
    $info = pathinfo($fileName);
    $allow_file = array("csv","xls","xlsx");
/*  print_r($info);         // ข้อมูลไฟล์   
    print_r($_fileup);*/
    if($fileName!="" && in_array($info['extension'],$allow_file)){
        // อ่านไฟล์จาก path temp ชั่วคราวที่เราอัพโหลด
        $objPHPExcel = PHPExcel_IOFactory::load($tmpFile);      
         
         
        // ดึงข้อมูลของแต่ละเซลในตารางมาไว้ใช้งานในรูปแบบตัวแปร array
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
          
        // วนลูปแสดงข้อมูล
        $data_arr=array();
        foreach ($cell_collection as $cell) {
            // ค่าสำหรับดูว่าเป็นคอลัมน์ไหน เช่น A B C ....
            $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
            // คำสำหรับดูว่าเป็นแถวที่เท่าไหร่ เช่น 1 2 3 .....
            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            // ค่าของข้อมูลในเซลล์นั้นๆ เช่น A1 B1 C1 ....
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();          
             
            // เริ่มขึ้นตอนจัดเตรียมข้อมูล
            $data_arr[$column.$row]=$data_value;
            $data= json_encode($data_arr);
            for($i=0; $i <sizeof($data_arr); $i++) {
                echo $i;
            }
          //  $array = json_decode($data, true );
            #$cid =$data_arr[A2];
        }       
      print_r($data);
      print_r($data_arr);
     // print_r($array);
    }
} 
?>
 </pre>
  
 <br>
<pre>
<table class="table table-bordered">
<?php
// นำข้อมูลที่ดึงจาก excel หรือ csv ไฟล์ มาแสดง
if(isset($data_arr) && count($data_arr)>0){
 
?>
    <tr>
        <td>
        C3:<?=$data_arr['C3']?><br>
        B5:<?=$data_arr['B5']?><br>
        D7:<?=$data_arr['D7']?> <br>
        F8:<?=$data_arr['F8']?>
        </td>
    </tr>
<?php
}
?>    
</table>
</pre>
</div>
 
</body>
</html>