<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use \miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */

$this->title = 'M30hospital(045489064)';
?>

<div class='well'>
<a href="http://192.168.200.9/yii2a-services/frontend/web/index.php?r=jobcom%2Findex" target="_blank"><img src="images/com002.jpg"
         title="แจ้งซ่อมคอมพิวเตอร์และโสตทัศนศึกษา" width="150" height="150"></a>
<a href="http://192.168.200.9/yii2a-services/frontend/web/index.php?r=jobservice%2Findex" target="_blank"><img src="images/service1.jpg" 
         title="แจ้งหน่วยซ่อมบำรุง มีระบบแจ้งเตือนเข้าไลน์กลุ่มผู้ดูแลหน่วยซ่อมบำรุง" width="150" height="150"></a>

<a href="http://192.168.200.9/yii2a-services/frontend/web/index.php?r=carjobs%2Findex" target="_blank"><img src="images/car2.jpg"
         title="โปรแกรมบันทึกการใช้รถ" width="150" height="150"></a>

<a href="http://192.168.200.9/yii2a-services/frontend/web/index.php?r=orderoils%2Findex" target="_blank"><img src="images/oils.jpg"
         title="โปรแกรมเบิกน้ำมันเชื้อเพลิงควบคุมโรคSRRT" width="150" height="150"></a>

<a href="http://192.168.200.9/yii2a-services/frontend/web/index.php?r=opdcard%2Fpermits" target="_blank"><img src="images/register.jpg" 
         title="โปรแกรมยืมเวชระเบียน ระบบมีการLogin ระเบียบการคืนภายใน7 วัน" width="150" height="150"></a>
         <a href="http://192.168.200.9/yii2a-services/frontend/web/index.php?r=opdcard%2Fpermits" target="_blank"><img src="images/leave.jpg" 
         title="โปรแกรมยืมเวชระเบียน ระบบมีการLogin ระเบียบการคืนภายใน7 วัน" width="150" height="150"></a>
<br>


 <!-- <button type="button" class="btn btn-primary btn-lg" onclick="location.href='http://localhost/yii2a-services/frontend/web/index.php?r=jobcom%2Findex'">แจ้งซ่อมคอมพิวเตอร์และโสตทัศนศึกษา</button>
 <button type="button" class="btn btn-info btn-lg" onclick="location.href='http://localhost/yii2a-services/frontend/web/index.php?r=jobservice%2Findex'">แจ้งซ่อมหน่วยซ่อมบำรุง</button> 
 <button type="button" class="btn btn-warning btn-lg" onclick="location.href='http://localhost/yii2a-services/frontend/web/index.php?r=carjobs%2Findex'">บันทึกการใช้ยานพาหนะ</button>
 <button type="button" class="btn btn-success btn-lg" onclick="location.href='http://localhost/yii2a-services/frontend/web/index.php?r=opdcard%2Fpermits'">ยืมเวชระเบียน</button> 
 <button type="button" class="btn btn-info btn-lg" onclick="location.href='http://localhost/yii2a-services/frontend/web/index.php?r=apdcard%2Fpermits'">คืนเวชระเบียน(Admin)</button>     
  -->
  
</div>
<div class='well'>
<p><a style="color:success">สำหรับดูแลระบบ</a></p>   <br>  
<a href="http://192.168.200.9/yii2a-services/backend/web/index.php?r=jobcom%2Findex" target="_blank"><img src="images/com1a.jpg"
         title="โปรแกรมสำหรับเจ้าหน้าที่คอมพิวเตอร์และโสตทัศนศึกษาบันทึกรับทราบงาน" width="150" height="150"></a>
<a href="http://192.168.200.9/yii2a-services/backend/web/index.php?r=jobservice%2Findex" target="_blank"><img src="images/service1a.jpg" 
         title="โปรแกรมสำหรับเจ้าหน้าที่งานซ่อมบำรุงไว้บันทึกรับทราบงาน" width="150" height="150"></a> 
<a href= "http://192.168.200.9/yii2a-services/frontend/web/index.php?r=apdcard%2Fpermits" target="_blank"><img src="images/mrs001.jpg"
         title="โปรแกรมคืนเวชระเบียนสำหรับเจ้าหน้าที่ห้องบัตร" width="150" height="150"></a> 
<a href="http://192.168.200.9/yii2a-services/backend/web/index.php?r=personal%2Fperson" target="_blank"><img src="images/person.jpg" 
         title="ข้อมูลบุคลากรโรงพยาบาลม่วงสามสิบ" width="150" height="150"></a>
</div>
<div class='well'>
    <h3><a style="color:blue">ขั้นตอนการเข้าใช้งาน</a></h3>
    <p><a style="color:success">Username=  เลข13หลักบัตรประจำจัวประชาชน เช่น  3341400051222</a></p> 
    <p><a style="color:success">Password = 6หลักสุดท้ายเลขบัตรประจำตัวประชาชน เช่น 051222</a></p> 
    <p><a style="color:red">***สิทธิ์การใช้งานโปรแกรมยืมเวชระเบียนเฉพาะ ตำแหน่งแพทย์หรือพยาบาล***  หากพบปัญหาการใช้งานกรุณาโทรแจ้ง ศูนย์คอมพิวเตอร์เบอร์ 508</a></p>
</div>
