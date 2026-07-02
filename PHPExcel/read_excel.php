<?php
header("Content-type:application/json; charset=UTF-8");    
header("Cache-Control: no-store, no-cache, must-revalidate");         
header("Cache-Control: post-check=0, pre-check=0", false); 
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Bangkok');
// http://php.net/manual/en/timezones.php
require_once("/PHPExcel/Classes/PHPExcel.php");
?>
<?php 
if(isset($_FILES['excelFile']['name']) && $_FILES['excelFile']['name']!=""){
    $tmpFile = $_FILES['excelFile']['tmp_name'];  
    $fileName = $_FILES['excelFile']['name'];  // เก็บชื่อไฟล์
    $_fileup = $_FILES['excelFile'];
    $info = pathinfo($fileName);
    $allow_file = array("csv","xls","xlsx");
  print_r($info);         // ข้อมูลไฟล์   
    //print_r($_fileup);*/
    if($fileName!="" && in_array($info['extension'],$allow_file)){
        // อ่านไฟล์จาก path temp ชั่วคราวที่เราอัพโหลด
        $objPHPExcel = PHPExcel_IOFactory::load($tmpFile);      
          
          
        // ดึงข้อมูลของแต่ละเซลในตารางมาไว้ใช้งานในรูปแบบตัวแปร array
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
           
        // วนลูปแสดงข้อมูล
        $v=1;
        $json_data = array();
        foreach ($cell_collection as $cell) {
            // ค่าสำหรับดูว่าเป็นคอลัมน์ไหน เช่น A B C ....
            $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
            // คำสำหรับดูว่าเป็นแถวที่เท่าไหร่ เช่น 1 2 3 .....
            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            // ค่าของข้อมูลในเซลล์นั้นๆ เช่น A1 B1 C1 ....
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();          
              
            // เท่านี้เราก็สามารถแสดงข้อมูลจากการอ่านไฟล์ได้แล้ว และสามารถนำข้อมูลเหล่านี้
            // ทำการบันทักลงฐานข้อมูล หรือแสดงได้เลย
            $json_data["$column$row"] = $data_value;
//            echo $v." ----  ".$data_value."<br>";
             $v++;
        }       
         // แปลง array เป็นรูปแบบ json string  
        if(isset($json_data)){  
            $json= json_encode($json_data);    
            if(isset($_GET['callback']) && $_GET['callback']!=""){    
            echo $_GET['callback']."(".$json.");";        
            }else{    
            echo $json;    
            }    
        }        
    }
} 
?>