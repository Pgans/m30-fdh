<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\Service;

$this->title = 'SERVICE';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['rep/index']];
//$this->params['breadcrumbs'][] = 'รายงานข้อมูลE-Claim แยกตามREP';
?>

<div class="box box-success box-solid">
<div class="mradepartmetnsopd-index">
    <div class='well'>

    <?=Html::beginForm(['service/index'],'post', ['name' => 'frmMain']);?> 
    <table border='0' id='test_report' cellpadding='0' cellspacing='0'>
        <tr>
            <th><div  ><a>สถานพยาบาล</a></div></th>
        </tr>

        <?php
        foreach ($dataProvider->getModels() as $key => $value) :
        ?>
        <tr>
            <td><div><?php echo $value["hospname"]; ?></div> </td>
        </tr>
        <?php endforeach; ?>
         
        <?php
        //วันที่สุดท้ายของเดือน
        $timeDate = strtotime($year.'-'.$month."-01");  //เปลี่ยนวันที่เป็น timestamp
        $lastDay = date("t", $timeDate);       //จำนวนวันของเดือน
        //echo "$timeDate";
        //สร้างหัวตารางตั้งแต่วันที่ 1 ถึงวันที่สุดท้ายของดือน
        for($day=1; $day<=$lastDay; $day++){
        echo '<th>' . substr("0".$day, -2) . '</th>';
        }
        echo "</tr>";

        /*
        //วนลูปเพื่อสร้างตารางตามจำนวนรายชื่อพนักงานใน Array
        foreach($allEmpData as $empCode=>$empName){
        echo '<tr>';//เปิดแถวใหม่ ตาราง HTML
        echo '<td>'. $empName .'</td>';
        //เรียกข้อมูลการจองของพนักงานแต่ละคน ในเดือนนี้
        for($j=1; $j<=$lastDay; $j++){
        //ตรวจสอบว่าวันที่แต่ละวัน $j ของ พนักงานแต่ละรหัส  $empCode มีข้อมูลใน  $allReportData หรือไม่ ถ้ามีให้แสดงจำนวนในอาร์เรย์ออกมา ถ้าไม่มีให้เป็น 0
        $numSeq = isset($allReportData[$empCode][$j]) ? '<div>'.$allReportData[$empCode][$j].'</div>' : 0;
        echo "<td class='number'>", $numSeq, "</td>";
        }
        echo '</tr>';//ปิดแถวตาราง HTML
        }
        echo "</table>";
        echo "<pre>";
        print_r($allReportData);
        echo "</pre>";
        */
     ?>