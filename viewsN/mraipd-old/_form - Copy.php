<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

?>

<body>
<center>
<!-- <font><h2>แบบบันทึกตรวจประเมินเวชระเบียนผู้ป่วยใน </h2></font> -->
<?php $form = ActiveForm::begin(); ?>
<div class="mraipd-form">

    <div class="well">
      <div class="row">
           <div class="col-md-2">
           <?= $form->field($model, 'hospcode')->textInput(['maxlength' => true,'value'=>'10953']) ?>
          </div>
          <div class="col-md-2">
          <?= $form->field($model, 'unit_id')->textInput() ?>
          </div>
          <div class="col-md-1">
          <?= $form->field($model, 'HN')->textInput(['maxlength' => true]) ?>
          </div>
          <div class="col-md-1">
          <?= $form->field($model, 'AN')->textInput(['maxlength' => true]) ?>
          </div>
          <!-- <div class="col-md-2">
          <?= $form->field($model, 'dr_license')->textInput(['maxlength' => true]) ?>
          </div> -->
          <div class="col-md-2">
          <?= $form->field($model, 'date_admit')->textInput() ?>
          </div>
          <div class="col-md-2">
          <?= $form->field($model, 'date_discharge')->textInput() ?>
          </div>
          <div class="col-md-2">
          <?= $form->field($model, 'date_audit')->textInput() ?>
          </div>
      </div>
    </div>
</div>
<!-- <form name="form1" method="POST" action="addipd2.php" onsubmit="JavaScript:return fncCHKIPD();">  -->
<!-- <table><tbody><tr><td class="a">
Overall finding  &nbsp;&nbsp;  <input type="checkbox" name="OVERALLFIND1" value="1" autocomplete="off">การจัดเรียงเวชระเบียนไม่เป็นไปตามมาตรฐานที่กำหนด<br>
        &nbsp;&nbsp;&nbsp; <input type="checkbox" name="OVERALLFIND2" value="1" autocomplete="off">เอกสารบางแผ่น ไม่มีชื่อผู้รับบริการ HN AN ทำให้ไม่สามารถระบุได้ว่า เอกสารแผ่นนี้เป็นของใครจึงไม่สามารถทบทวนเอกสารแผ่นนั้นได้<br>
(เลือกเพียง 1 ข้อ)  <input name="OVERALL" id="OVERALL1" type="radio" value="1" autocomplete="off">Documentation inadequate for meaningful review (ข้อมูลไม่เพียงพอสำหรับการทบทวน)<br>
         <input name="OVERALL" id="OVERALL2" type="radio" value="2" checked="checked" autocomplete="off">No significant medical recode issue identified (ไม่มีปัญหาสำคัญจากการทบทวน)<br>
         <input name="OVERALL" id="OVERALL3" type="radio" value="3" autocomplete="off">Certain issue in question specify (มีปัญหาจากการทบทวนที่ต้องค้นต่อ ระบุ 
<input class="OVERALLNOTE" name="OVERALLNOTE" type="text" id="OVERALLNOTE" size="30" maxlength="250" value="" tabindex="7" onchange="handleOVNOTChk(this)" autocomplete="off"> -->

<script language="javascript">
$(document).ready(function(){
handleChk();

function handleChk() {
    if(NA7.value=='N'){
            $('#Missing7').attr("disabled", "false");
            $('#No7').attr("readonly", "false");
            $('#cr1').attr("readonly", "false");
            $('#cr2').attr("readonly", "false");
            $('#cr3').attr("readonly", "false");
            $('#cr4').attr("readonly", "false");
            $('#cr5').attr("readonly", "false");
            $('#cr6').attr("readonly", "false");
            $('#cr7').attr("readonly", "false");
            $('#cr8').attr("readonly", "false");
            $('#cr9').attr("readonly", "false");
    }else{
            $('#Missing7').attr("readonly", "true");
            $('#No7').attr("readonly", "true");
            $('#cr1').attr("readonly", "true");
            $('#cr2').attr("readonly", "true");
            $('#cr3').attr("readonly", "true");
            $('#cr4').attr("readonly", "true");
            $('#cr5').attr("readonly", "true");
            $('#SC076').attr("readonly", "true");
            $('#cr7').attr("readonly", "true");
            $('#cr8').attr("readonly", "true");
            $('#cr9').attr("readonly", "true");
    }

    if(NA07.value=='N'){
            $('#MI07').attr("readonly", "false");
            $('#NO07').attr("readonly", "false");
            $('#SC071').attr("readonly", "false");
            $('#SC072').attr("readonly", "false");
            $('#SC073').attr("readonly", "false");
            $('#SC074').attr("readonly", "false");
            $('#SC075').attr("readonly", "false");
            $('#SC076').attr("readonly", "false");
            $('#SC077').attr("readonly", "false");
            $('#SC078').attr("readonly", "false");
            $('#SC079').attr("readonly", "false");
    }else{
            $('#MI07').attr("readonly", "true");
            $('#NO07').attr("readonly", "true");
            $('#SC071').attr("readonly", "true");
            $('#SC072').attr("readonly", "true");
            $('#SC073').attr("readonly", "true");
            $('#SC074').attr("readonly", "true");
            $('#SC075').attr("readonly", "true");
            $('#SC076').attr("readonly", "true");
            $('#SC077').attr("readonly", "true");
            $('#SC078').attr("readonly", "true");
            $('#SC079').attr("readonly", "true");
    }
    if(NA08.value=='N'){
            $('#MI08').attr("readonly", "false");
            $('#NO08').attr("readonly", "false");
            $('#SC081').attr("readonly", "false");
            $('#SC082').attr("readonly", "false");
            $('#SC083').attr("readonly", "false");
            $('#SC084').attr("readonly", "false");
            $('#SC085').attr("readonly", "false");
            $('#SC086').attr("readonly", "false");
            $('#SC087').attr("readonly", "false");
            $('#SC088').attr("readonly", "false");
            $('#SC089').attr("readonly", "false");
    }else{
            $('#MI08').attr("readonly", "true");
            $('#NO08').attr("readonly", "true");
            $('#SC081').attr("readonly", "true");
            $('#SC082').attr("readonly", "true");
            $('#SC083').attr("readonly", "true");
            $('#SC084').attr("readonly", "true");
            $('#SC085').attr("readonly", "true");
            $('#SC086').attr("readonly", "true");
            $('#SC087').attr("readonly", "true");
            $('#SC088').attr("readonly", "true");
            $('#SC089').attr("readonly", "true");
    }
    if(NA09.value=='N'){
            $('#MI09').attr("readonly", "false");
            $('#NO09').attr("readonly", "false");
            $('#SC091').attr("readonly", "false");
            $('#SC092').attr("readonly", "false");
            $('#SC093').attr("readonly", "false");
            $('#SC094').attr("readonly", "false");
            $('#SC095').attr("readonly", "false");
            $('#SC096').attr("readonly", "false");
            $('#SC097').attr("readonly", "false");
            $('#SC098').attr("readonly", "false");
            $('#SC099').attr("readonly", "false");
    }else{
            $('#MI09').attr("readonly", "true");
            $('#NO09').attr("readonly", "true");
            $('#SC091').attr("readonly", "true");
            $('#SC092').attr("readonly", "true");
            $('#SC093').attr("readonly", "true");
            $('#SC094').attr("readonly", "true");
            $('#SC095').attr("readonly", "true");
            $('#SC096').attr("readonly", "true");
            $('#SC097').attr("readonly", "true");
            $('#SC098').attr("readonly", "true");
            $('#SC099').attr("readonly", "true");
    }
    if(NA10.value=='N'){
            $('#MI10').attr("readonly", "false");
            $('#NO10').attr("readonly", "false");
            $('#SC101').attr("readonly", "false");
            $('#SC102').attr("readonly", "false");
            $('#SC103').attr("readonly", "false");
            $('#SC104').attr("readonly", "false");
            $('#SC105').attr("readonly", "false");
            $('#SC106').attr("readonly", "false");
            $('#SC107').attr("readonly", "false");
            $('#SC108').attr("readonly", "false");
            $('#SC109').attr("readonly", "false");
    }else{
            $('#MI10').attr("readonly", "true");
            $('#NO10').attr("readonly", "true");
            $('#SC101').attr("readonly", "true");
            $('#SC102').attr("readonly", "true");
            $('#SC103').attr("readonly", "true");
            $('#SC104').attr("readonly", "true");
            $('#SC105').attr("readonly", "true");
            $('#SC106').attr("readonly", "true");
            $('#SC107').attr("readonly", "true");
            $('#SC108').attr("readonly", "true");
            $('#SC109').attr("readonly", "true");
    }
    if(NA11.value=='N'){
            $('#MI11').attr("readonly", "false");
            $('#NO11').attr("readonly", "false");
            $('#SC111').attr("readonly", "false");
            $('#SC112').attr("readonly", "false");
            $('#SC113').attr("readonly", "false");
            $('#SC114').attr("readonly", "false");
            $('#SC115').attr("readonly", "false");
            $('#SC116').attr("readonly", "false");
            $('#SC117').attr("readonly", "false");
            $('#SC118').attr("readonly", "false");
            $('#SC119').attr("readonly", "false");
    }else{
            $('#MI11').attr("readonly", "true");
            $('#NO11').attr("readonly", "true");
            $('#SC111').attr("readonly", "true");
            $('#SC112').attr("readonly", "true");
            $('#SC113').attr("readonly", "true");
            $('#SC114').attr("readonly", "true");
            $('#SC115').attr("readonly", "true");
            $('#SC116').attr("readonly", "true");
            $('#SC117').attr("readonly", "true");
            $('#SC118').attr("readonly", "true");
            $('#SC119').attr("readonly", "true");
    }
}
});

function handleOVNOTChk() {    
    if(OVERALLNOTE.value==''){
          $( "#OVERALL2" ).prop('checked', true);
          
    }else{     
         $( "#OVERALL3" ).prop('checked', true);
    }
} 
function handleNA7Chk() {    
    if(NA7.value=='N'||NA7.value=='n'){
          document.getElementById("NA7").value = "N";
          document.getElementById("cr1").value = ""
        document.getElementById("cr2").value = ""
        document.getElementById("cr3").value = ""
        document.getElementById("cr4").value = ""
        document.getElementById("cr5").value = ""
        document.getElementById("cr6").value = ""
        document.getElementById("cr7").value = ""
        document.getElementById("cr8").value = ""
        document.getElementById("cr9").value = ""
          document.getElementById("Missing7").readOnly = true;
          document.getElementById("No7").readOnly = true;
          document.getElementById("cr1").readOnly = true;
          document.getElementById("cr2").readOnly = true;
          document.getElementById("cr3").readOnly = true;
          document.getElementById("cr4").readOnly = true;
          document.getElementById("cr5").readOnly = true;
          document.getElementById("cr").readOnly = true;
          document.getElementById("cr7").readOnly = true;
          document.getElementById("cr8").readOnly = true;
          document.getElementById("cr9").readOnly = true;
       
    }else{            
          document.getElementById("NA7").value = "-";
          document.getElementById("cr1").value = "1";
        document.getElementById("cr2").value = "1";
        document.getElementById("cr3").value = "1";
        document.getElementById("cr4").value = "1";
        document.getElementById("cr5").value = "1";
        document.getElementById("cr6").value = "1";
        document.getElementById("cr7").value = "1";
        document.getElementById("cr8").value = "1";
        document.getElementById("cr9").value = "1";
          document.getElementById("Missing7").readOnly = false;
          document.getElementById("No7").readOnly = false;
          document.getElementById("cr1").readOnly = false;
          document.getElementById("cr2").readOnly = false;
          document.getElementById("cr3").readOnly = false;
          document.getElementById("cr4").readOnly = false;
          document.getElementById("cr5").readOnly = false;
          document.getElementById("cr6").readOnly = false;
          document.getElementById("cr7").readOnly = false;
          document.getElementById("cr8").readOnly = false;
          document.getElementById("cr9").readOnly = false;        
        
    }
}  
function handleNA07Chk() {    
    if(NA07.value=='N'||NA07.value=='n'){
          document.getElementById("NA07").value = "N";
          document.getElementById("MI07").readOnly = true;
          document.getElementById("NO07").readOnly = true;
          document.getElementById("SC071").readOnly = true;
          document.getElementById("SC072").readOnly = true;
          document.getElementById("SC073").readOnly = true;
          document.getElementById("SC074").readOnly = true;
          document.getElementById("SC075").readOnly = true;
          document.getElementById("SC076").readOnly = true;
          document.getElementById("SC077").readOnly = true;
          document.getElementById("SC078").readOnly = true;
          document.getElementById("SC079").readOnly = true;
        document.getElementById("SC071").value = ""
        document.getElementById("SC072").value = ""
        document.getElementById("SC073").value = ""
        document.getElementById("SC074").value = ""
        document.getElementById("SC075").value = ""
        document.getElementById("SC076").value = ""
        document.getElementById("SC077").value = ""
        document.getElementById("SC078").value = ""
        document.getElementById("SC079").value = ""
    }else{            
          document.getElementById("NA07").value = "-";
          document.getElementById("MI07").readOnly = false;
          document.getElementById("NO07").readOnly = false;
          document.getElementById("SC071").readOnly = false;
          document.getElementById("SC072").readOnly = false;
          document.getElementById("SC073").readOnly = false;
          document.getElementById("SC074").readOnly = false;
          document.getElementById("SC075").readOnly = false;
          document.getElementById("SC076").readOnly = false;
          document.getElementById("SC077").readOnly = false;
          document.getElementById("SC078").readOnly = false;
          document.getElementById("SC079").readOnly = false;        
        document.getElementById("SC071").value = "1";
        document.getElementById("SC072").value = "1";
        document.getElementById("SC073").value = "1";
        document.getElementById("SC074").value = "1";
        document.getElementById("SC075").value = "1";
        document.getElementById("SC076").value = "1";
        document.getElementById("SC077").value = "1";
        document.getElementById("SC078").value = "1";
        document.getElementById("SC079").value = "1";
    }
}  
function handleNA08Chk() {   
    if(NA08.value=='N'||NA08.value=='n'){
          document.getElementById("NA08").value = "N";
          document.getElementById("MI08").readOnly = true;
          document.getElementById("NO08").readOnly = true;
          document.getElementById("SC081").readOnly = true;
          document.getElementById("SC082").readOnly = true;
          document.getElementById("SC083").readOnly = true;
          document.getElementById("SC084").readOnly = true;
          document.getElementById("SC085").readOnly = true;
          document.getElementById("SC086").readOnly = true;
          document.getElementById("SC087").readOnly = true;
          document.getElementById("SC088").readOnly = true;
          document.getElementById("SC089").readOnly = true;
        document.getElementById("SC081").value = ""
        document.getElementById("SC082").value = ""
        document.getElementById("SC083").value = ""
        document.getElementById("SC084").value = ""
        document.getElementById("SC085").value = ""
        document.getElementById("SC086").value = ""
        document.getElementById("SC087").value = ""
        document.getElementById("SC088").value = ""
        document.getElementById("SC089").value = ""
    }else{            
          document.getElementById("NA08").value = "-";
          document.getElementById("MI08").readOnly = false;
          document.getElementById("NO08").readOnly = false;
          document.getElementById("SC081").readOnly = false;
          document.getElementById("SC082").readOnly = false;
          document.getElementById("SC083").readOnly = false;
          document.getElementById("SC084").readOnly = false;
          document.getElementById("SC085").readOnly = false;
          document.getElementById("SC086").readOnly = false;
          document.getElementById("SC087").readOnly = false;
          document.getElementById("SC088").readOnly = false;
          document.getElementById("SC089").readOnly = false;
        document.getElementById("SC081").value = "1";
        document.getElementById("SC082").value = "1";
        document.getElementById("SC083").value = "1";
        document.getElementById("SC084").value = "1";
        document.getElementById("SC085").value = "1";
        document.getElementById("SC086").value = "1";
        document.getElementById("SC087").value = "1";
        document.getElementById("SC088").value = "1";
        document.getElementById("SC089").value = "1";
     }
}  
function handleNA09Chk() {  
    if(NA09.value=='N'||NA09.value=='n'){
          document.getElementById("NA09").value = "N";
          document.getElementById("MI09").readOnly = true;
          document.getElementById("NO09").readOnly = true;
          document.getElementById("SC091").readOnly = true;
          document.getElementById("SC092").readOnly = true;
          document.getElementById("SC093").readOnly = true;
          document.getElementById("SC094").readOnly = true;
          document.getElementById("SC095").readOnly = true;
          document.getElementById("SC096").readOnly = true;
          document.getElementById("SC097").readOnly = true;
          document.getElementById("SC098").readOnly = true;
          document.getElementById("SC099").readOnly = true;
        document.getElementById("SC091").value = ""
        document.getElementById("SC092").value = ""
        document.getElementById("SC093").value = ""
        document.getElementById("SC094").value = ""
        document.getElementById("SC095").value = ""
        document.getElementById("SC096").value = ""
        document.getElementById("SC097").value = ""
        document.getElementById("SC098").value = ""
        document.getElementById("SC099").value = ""
    }else{            
          document.getElementById("NA09").value = "-";
          document.getElementById("MI09").readOnly = false;
          document.getElementById("NO09").readOnly = false;
          document.getElementById("SC091").readOnly = false;
          document.getElementById("SC092").readOnly = false;
          document.getElementById("SC093").readOnly = false;
          document.getElementById("SC094").readOnly = false;
          document.getElementById("SC095").readOnly = false;
          document.getElementById("SC096").readOnly = false;
          document.getElementById("SC097").readOnly = false;
          document.getElementById("SC098").readOnly = false;
          document.getElementById("SC099").readOnly = false;
        document.getElementById("SC091").value = "1";
        document.getElementById("SC092").value = "1";
        document.getElementById("SC093").value = "1";
        document.getElementById("SC094").value = "1";
        document.getElementById("SC095").value = "1";
        document.getElementById("SC096").value = "1";
        document.getElementById("SC097").value = "1";
        document.getElementById("SC098").value = "1";
        document.getElementById("SC099").value = "1";
     }
}  
function handleNA10Chk() {  
    if(NA10.value=='N'||NA10.value=='n'){
          document.getElementById("NA10").value = "N";
          document.getElementById("MI10").readOnly = true;
          document.getElementById("NO10").readOnly = true;
          document.getElementById("SC101").readOnly = true;
          document.getElementById("SC102").readOnly = true;
          document.getElementById("SC103").readOnly = true;
          document.getElementById("SC104").readOnly = true;
          document.getElementById("SC105").readOnly = true;
          document.getElementById("SC106").readOnly = true;
          document.getElementById("SC107").readOnly = true;
          document.getElementById("SC108").readOnly = true;
          document.getElementById("SC109").readOnly = true;
        document.getElementById("SC101").value = ""
        document.getElementById("SC102").value = ""
        document.getElementById("SC103").value = ""
        document.getElementById("SC104").value = ""
        document.getElementById("SC105").value = ""
        document.getElementById("SC106").value = ""
        document.getElementById("SC107").value = ""
        document.getElementById("SC108").value = ""
        document.getElementById("SC109").value = ""
    }else{            
          document.getElementById("NA10").value = "-";
          document.getElementById("MI10").readOnly = false;
          document.getElementById("NO10").readOnly = false;
          document.getElementById("SC101").readOnly = false;
          document.getElementById("SC102").readOnly = false;
          document.getElementById("SC103").readOnly = false;
          document.getElementById("SC104").readOnly = false;
          document.getElementById("SC105").readOnly = false;
          document.getElementById("SC106").readOnly = false;
          document.getElementById("SC107").readOnly = false;
          document.getElementById("SC108").readOnly = false;
          document.getElementById("SC109").readOnly = false;
        document.getElementById("SC101").value = "1";
        document.getElementById("SC102").value = "1";
        document.getElementById("SC103").value = "1";
        document.getElementById("SC104").value = "1";
        document.getElementById("SC105").value = "1";
        document.getElementById("SC106").value = "1";
        document.getElementById("SC107").value = "1";
        document.getElementById("SC108").value = "1";
        document.getElementById("SC109").value = "1";
     }
}  
function handleNA11Chk() {  
    if(NA11.value=='N'||NA11.value=='n'){
          document.getElementById("NA11").value = "N";
          document.getElementById("MI11").readOnly = true;
          document.getElementById("NO11").readOnly = true;
          document.getElementById("SC111").readOnly = true;
          document.getElementById("SC112").readOnly = true;
          document.getElementById("SC113").readOnly = true;
          document.getElementById("SC114").readOnly = true;
          document.getElementById("SC115").readOnly = true;
          document.getElementById("SC116").readOnly = true;
          document.getElementById("SC117").readOnly = true;
          document.getElementById("SC118").readOnly = true;
          document.getElementById("SC119").readOnly = true;
        document.getElementById("SC111").value = ""
        document.getElementById("SC112").value = ""
        document.getElementById("SC113").value = ""
        document.getElementById("SC114").value = ""
        document.getElementById("SC115").value = ""
        document.getElementById("SC116").value = ""
        document.getElementById("SC117").value = ""
        document.getElementById("SC118").value = ""
        document.getElementById("SC119").value = ""
    }else{
          document.getElementById("NA11").value = "-";
          document.getElementById("MI11").readOnly = false;
          document.getElementById("NO11").readOnly = false;
          document.getElementById("SC111").readOnly = false;
          document.getElementById("SC112").readOnly = false;
          document.getElementById("SC113").readOnly = false;
          document.getElementById("SC114").readOnly = false;
          document.getElementById("SC115").readOnly = false;
          document.getElementById("SC116").readOnly = false;
          document.getElementById("SC117").readOnly = false;
          document.getElementById("SC118").readOnly = false;
          document.getElementById("SC119").readOnly = false;
        document.getElementById("SC111").value = "1";
        document.getElementById("SC112").value = "1";
        document.getElementById("SC113").value = "1";
        document.getElementById("SC114").value = "1";
        document.getElementById("SC115").value = "1";
        document.getElementById("SC116").value = "1";
        document.getElementById("SC117").value = "1";
        document.getElementById("SC118").value = "1";
        document.getElementById("SC119").value = "1";
    }
}

function handleMI01Chk() {         
    if(MI01.value=='M'||MI01.value=='m'){
        document.getElementById("MI01").value = "M";
        document.getElementById("NO01").value = "-";
        document.getElementById("SC011").value = "0";
        document.getElementById("SC012").value = "0";
        document.getElementById("SC013").value = "0";
        document.getElementById("SC014").value = "0";
        document.getElementById("SC015").value = "0";
        document.getElementById("SC016").value = "0";
        document.getElementById("SC017").value = "0";
        document.getElementById("SC018").value = "0";
        document.getElementById("SC019").value = "0";
        document.getElementById("NO01").readOnly = true;
        document.getElementById("SC011").readOnly = true;
        document.getElementById("SC012").readOnly = true;
        document.getElementById("SC013").readOnly = true;
        document.getElementById("SC014").readOnly = true;
        document.getElementById("SC015").readOnly = true;
        document.getElementById("SC016").readOnly = true;
        document.getElementById("SC017").readOnly = true;
        document.getElementById("SC018").readOnly = true;
        document.getElementById("SC019").readOnly = true;
    }else{            
        document.getElementById("MI01").value = "-";
        document.getElementById("SC011").value = "1";
        document.getElementById("SC012").value = "1";
        document.getElementById("SC013").value = "1";
        document.getElementById("SC014").value = "1";
        document.getElementById("SC015").value = "1";
        document.getElementById("SC016").value = "1";
        document.getElementById("SC017").value = "1";
        document.getElementById("SC018").value = "1";
        document.getElementById("SC019").value = "1";         
        document.getElementById("NO01").readOnly = false;
        document.getElementById("SC011").readOnly = false;
        document.getElementById("SC012").readOnly = false;
        document.getElementById("SC013").readOnly = false;
        document.getElementById("SC014").readOnly = false;
        document.getElementById("SC015").readOnly = false;
        document.getElementById("SC016").readOnly = false;
        document.getElementById("SC017").readOnly = false;
        document.getElementById("SC018").readOnly = false;
        document.getElementById("SC019").readOnly = false;          
    } 
 }
 function handleMI02Chk() {   
    if(MI02.value=='M'||MI02.value=='m'){
        document.getElementById("MI02").value = "M";
        document.getElementById("NO02").value = "-";
        document.getElementById("SC021").value = "0";
        document.getElementById("SC022").value = "0";
        document.getElementById("SC023").value = "0";
        document.getElementById("SC024").value = "0";
        document.getElementById("SC025").value = "0";
        document.getElementById("SC026").value = "0";
        document.getElementById("SC027").value = "0";
        document.getElementById("SC028").value = "0";
        document.getElementById("SC029").value = "0";
        document.getElementById("NO02").readOnly = true;
        document.getElementById("SC021").readOnly = true;
        document.getElementById("SC022").readOnly = true;
        document.getElementById("SC023").readOnly = true;
        document.getElementById("SC024").readOnly = true;
        document.getElementById("SC025").readOnly = true;
        document.getElementById("SC026").readOnly = true;
        document.getElementById("SC027").readOnly = true;
    }else{            
        document.getElementById("MI02").value = "-";
        document.getElementById("SC021").value = "1";
        document.getElementById("SC022").value = "1";
        document.getElementById("SC023").value = "1";
        document.getElementById("SC024").value = "1";
        document.getElementById("SC025").value = "1";
        document.getElementById("SC026").value = "1";
        document.getElementById("SC027").value = "1";
        document.getElementById("SC028").value = "N";
        document.getElementById("SC029").value = "N";    
        document.getElementById("NO02").readOnly = false;
        document.getElementById("SC021").readOnly = false;
        document.getElementById("SC022").readOnly = false;
        document.getElementById("SC023").readOnly = false;
        document.getElementById("SC024").readOnly = false;
        document.getElementById("SC025").readOnly = false;
        document.getElementById("SC026").readOnly = false;
        document.getElementById("SC027").readOnly = false;
    } 
 }
 function handleMI03Chk() {                 
    if(MI03.value=='M'||MI03.value=='m'){
        document.getElementById("MI03").value = "M";
        document.getElementById("NO03").value = "-";
        document.getElementById("SC031").value = "0";
        document.getElementById("SC032").value = "0";
        document.getElementById("SC033").value = "0";
        document.getElementById("SC034").value = "0";
        document.getElementById("SC035").value = "0";
        document.getElementById("SC036").value = "0";
        document.getElementById("SC037").value = "0";
        document.getElementById("SC038").value = "0";
        document.getElementById("SC039").value = "0";
        document.getElementById("NO03").readOnly = true;
        document.getElementById("SC031").readOnly = true;
        document.getElementById("SC032").readOnly = true;
        document.getElementById("SC033").readOnly = true;
        document.getElementById("SC034").readOnly = true;
        document.getElementById("SC035").readOnly = true;
        document.getElementById("SC036").readOnly = true;
        document.getElementById("SC037").readOnly = true;
        document.getElementById("SC038").readOnly = true;
        document.getElementById("SC039").readOnly = true;
    }else{          
        document.getElementById("MI03").value = "-";
        document.getElementById("SC031").value = "1";
        document.getElementById("SC032").value = "1";
        document.getElementById("SC033").value = "1";
        document.getElementById("SC034").value = "1";
        document.getElementById("SC035").value = "1";
        document.getElementById("SC036").value = "1";
        document.getElementById("SC037").value = "1";
        document.getElementById("SC038").value = "1";
        document.getElementById("SC039").value = "1";   
        document.getElementById("NO03").readOnly = false;
        document.getElementById("SC031").readOnly = false;
        document.getElementById("SC032").readOnly = false;
        document.getElementById("SC033").readOnly = false;
        document.getElementById("SC034").readOnly = false;
        document.getElementById("SC035").readOnly = false;
        document.getElementById("SC036").readOnly = false;
        document.getElementById("SC037").readOnly = false;
        document.getElementById("SC038").readOnly = false;
        document.getElementById("SC039").readOnly = false;
    } 
 }
 function handleMI04Chk() {   
    if(MI04.value=='M'||MI04.value=='m'){
        document.getElementById("MI04").value = "M";
        document.getElementById("NO04").value = "-";
        document.getElementById("SC041").value = "0";
        document.getElementById("SC042").value = "0";
        document.getElementById("SC043").value = "0";
        document.getElementById("SC044").value = "0";
        document.getElementById("SC045").value = "0";
        document.getElementById("SC046").value = "0";
        document.getElementById("SC047").value = "0";
        document.getElementById("SC048").value = "0";
        document.getElementById("SC049").value = "0";
        document.getElementById("NO04").readOnly = true;
        document.getElementById("SC041").readOnly = true;
        document.getElementById("SC042").readOnly = true;
        document.getElementById("SC043").readOnly = true;
        document.getElementById("SC044").readOnly = true;
        document.getElementById("SC045").readOnly = true;
        document.getElementById("SC046").readOnly = true;
        document.getElementById("SC047").readOnly = true;
        document.getElementById("SC048").readOnly = true;
        document.getElementById("SC049").readOnly = true;
    }else{         
        document.getElementById("MI04").value = "-";
        document.getElementById("SC041").value = "1";
        document.getElementById("SC042").value = "1";
        document.getElementById("SC043").value = "1";
        document.getElementById("SC044").value = "1";
        document.getElementById("SC045").value = "1";
        document.getElementById("SC046").value = "1";
        document.getElementById("SC047").value = "1";
        document.getElementById("SC048").value = "1";
        document.getElementById("SC049").value = "1";   
        document.getElementById("NO04").readOnly = false;
        document.getElementById("SC041").readOnly = false;
        document.getElementById("SC042").readOnly = false;
        document.getElementById("SC043").readOnly = false;
        document.getElementById("SC044").readOnly = false;
        document.getElementById("SC045").readOnly = false;
        document.getElementById("SC046").readOnly = false;
        document.getElementById("SC047").readOnly = false;
        document.getElementById("SC048").readOnly = false;
        document.getElementById("SC049").readOnly = false; 
    } 
 }
 function handleMI05Chk() {   
    if(MI05.value=='M'||MI05.value=='m'){
        document.getElementById("MI05").value = "M";
        document.getElementById("NO05").value = "-";
        document.getElementById("SC051").value = "0";
        document.getElementById("SC052").value = "0";
        document.getElementById("SC053").value = "0";
        document.getElementById("SC054").value = "0";
        document.getElementById("SC055").value = "0";
        document.getElementById("SC056").value = "0";
        document.getElementById("SC057").value = "0";
        document.getElementById("SC058").value = "0";
        document.getElementById("SC059").value = "0";
        document.getElementById("NO05").readOnly = true;
        document.getElementById("SC051").readOnly = true;
        document.getElementById("SC052").readOnly = true;
        document.getElementById("SC053").readOnly = true;
        document.getElementById("SC054").readOnly = true;
        document.getElementById("SC055").readOnly = true;
        document.getElementById("SC056").readOnly = true;
        document.getElementById("SC057").readOnly = true;
        document.getElementById("SC058").readOnly = true;
        document.getElementById("SC059").readOnly = true;
    }else{            
        document.getElementById("MI05").value = "-";
        document.getElementById("SC051").value = "1";
        document.getElementById("SC052").value = "1";
        document.getElementById("SC053").value = "1";
        document.getElementById("SC054").value = "1";
        document.getElementById("SC055").value = "1";
        document.getElementById("SC056").value = "1";
        document.getElementById("SC057").value = "1";
        document.getElementById("SC058").value = "1";
        document.getElementById("SC059").value = "1";     
        document.getElementById("NO05").readOnly = false;
        document.getElementById("SC051").readOnly = false;
        document.getElementById("SC052").readOnly = false;
        document.getElementById("SC053").readOnly = false;
        document.getElementById("SC054").readOnly = false;
        document.getElementById("SC055").readOnly = false;
        document.getElementById("SC056").readOnly = false;
        document.getElementById("SC057").readOnly = false;
        document.getElementById("SC058").readOnly = false;
        document.getElementById("SC059").readOnly = false;
    } 
 }
 function handleMI06Chk() {   
    if(MI06.value=='M'||MI06.value=='m'){
        document.getElementById("MI06").value = "M";
        document.getElementById("NO06").value = "-";
        document.getElementById("SC061").value = "0";
        document.getElementById("SC062").value = "0";
        document.getElementById("SC063").value = "0";
        document.getElementById("SC064").value = "0";
        document.getElementById("SC065").value = "0";
        document.getElementById("SC066").value = "0";
        document.getElementById("SC067").value = "0";
        document.getElementById("SC068").value = "0";
        document.getElementById("SC069").value = "0";
        document.getElementById("NO06").readOnly = true;
        document.getElementById("SC061").readOnly = true;
        document.getElementById("SC062").readOnly = true;
        document.getElementById("SC063").readOnly = true;
        document.getElementById("SC064").readOnly = true;
        document.getElementById("SC065").readOnly = true;
        document.getElementById("SC066").readOnly = true;
        document.getElementById("SC067").readOnly = true;
        document.getElementById("SC068").readOnly = true;
        document.getElementById("SC069").readOnly = true;
    }else{            
        document.getElementById("MI06").value = "-";
        document.getElementById("SC061").value = "1";
        document.getElementById("SC062").value = "1";
        document.getElementById("SC063").value = "1";
        document.getElementById("SC064").value = "1";
        document.getElementById("SC065").value = "1";
        document.getElementById("SC066").value = "1";
        document.getElementById("SC067").value = "1";
        document.getElementById("SC068").value = "1";
        document.getElementById("SC069").value = "1";    
        document.getElementById("NO06").readOnly = false;
        document.getElementById("SC061").readOnly = false;
        document.getElementById("SC062").readOnly = false;
        document.getElementById("SC063").readOnly = false;
        document.getElementById("SC064").readOnly = false;
        document.getElementById("SC065").readOnly = false;
        document.getElementById("SC066").readOnly = false;
        document.getElementById("SC067").readOnly = false;
        document.getElementById("SC068").readOnly = false;
        document.getElementById("SC069").readOnly = false;   
    } 
 } 
 function handleMissing7Chk() {   
    if(Missing7.value=='M'||Missing7.value=='m'){
        document.getElementById("Missing7").value = "M";
        document.getElementById("NO7").value = "-";
        document.getElementById("cr1").value = "0";
        document.getElementById("cr2").value = "0";
        document.getElementById("cr3").value = "0";
        document.getElementById("cr4").value = "0";
        document.getElementById("cr5").value = "0";
        document.getElementById("cr6").value = "0";
        document.getElementById("cr7").value = "0";
        document.getElementById("cr8").value = "0";
        document.getElementById("cr9").value = "0";
        document.getElementById("NO7").readOnly = true;
        document.getElementById("cr1").readOnly = true;
        document.getElementById("cr2").readOnly = true;
        document.getElementById("cr3").readOnly = true;
        document.getElementById("cr4").readOnly = true;
        document.getElementById("cr5").readOnly = true;
        document.getElementById("cr6").readOnly = true;
        document.getElementById("cr7").readOnly = true;
        document.getElementById("cr8").readOnly = true;
        document.getElementById("cr9").readOnly = true;
    }else{            
        document.getElementById("Missing7").value = "-";
        document.getElementById("cr1").value = "1";
        document.getElementById("cr2").value = "1";
        document.getElementById("cr3").value = "1";
        document.getElementById("cr4").value = "1";
        document.getElementById("cr5").value = "1";
        document.getElementById("cr6").value = "1";
        document.getElementById("cr7").value = "1";
        document.getElementById("cr8").value = "1";
        document.getElementById("cr9").value = "1";    
        document.getElementById("NO7").readOnly = false;
        document.getElementById("cr1").readOnly = false;
        document.getElementById("cr2").readOnly = false;
        document.getElementById("cr3").readOnly = false;
        document.getElementById("cr4").readOnly = false;
        document.getElementById("cr5").readOnly = false;
        document.getElementById("cr6").readOnly = false;
        document.getElementById("cr7").readOnly = false;
        document.getElementById("cr8").readOnly = false;
        document.getElementById("cr9").readOnly = false;   
    } 
 }
 function handleMI07Chk() {   
    if(MI07.value=='M'||MI07.value=='m'){
        document.getElementById("MI07").value = "M";
        document.getElementById("NO07").value = "-";
        document.getElementById("SC071").value = "0";
        document.getElementById("SC072").value = "0";
        document.getElementById("SC073").value = "0";
        document.getElementById("SC074").value = "0";
        document.getElementById("SC075").value = "0";
        document.getElementById("SC076").value = "0";
        document.getElementById("SC077").value = "0";
        document.getElementById("SC078").value = "0";
        document.getElementById("SC079").value = "0";
        document.getElementById("NO07").readOnly = true;
        document.getElementById("SC071").readOnly = true;
        document.getElementById("SC072").readOnly = true;
        document.getElementById("SC073").readOnly = true;
        document.getElementById("SC074").readOnly = true;
        document.getElementById("SC075").readOnly = true;
        document.getElementById("SC076").readOnly = true;
        document.getElementById("SC077").readOnly = true;
        document.getElementById("SC078").readOnly = true;
        document.getElementById("SC079").readOnly = true;
    }else{            
        document.getElementById("MI07").value = "-";
        document.getElementById("SC071").value = "1";
        document.getElementById("SC072").value = "1";
        document.getElementById("SC073").value = "1";
        document.getElementById("SC074").value = "1";
        document.getElementById("SC075").value = "1";
        document.getElementById("SC076").value = "1";
        document.getElementById("SC077").value = "1";
        document.getElementById("SC078").value = "1";
        document.getElementById("SC079").value = "1";    
        document.getElementById("NO07").readOnly = false;
        document.getElementById("SC071").readOnly = false;
        document.getElementById("SC072").readOnly = false;
        document.getElementById("SC073").readOnly = false;
        document.getElementById("SC074").readOnly = false;
        document.getElementById("SC075").readOnly = false;
        document.getElementById("SC076").readOnly = false;
        document.getElementById("SC077").readOnly = false;
        document.getElementById("SC078").readOnly = false;
        document.getElementById("SC079").readOnly = false;   
    } 
 }
 function handleMI08Chk() {   
    if(MI08.value=='M'||MI08.value=='m'){
        document.getElementById("MI08").value = "M";
        document.getElementById("NO08").value = "-";
        document.getElementById("SC081").value = "0";
        document.getElementById("SC082").value = "0";
        document.getElementById("SC083").value = "0";
        document.getElementById("SC084").value = "0";
        document.getElementById("SC085").value = "0";
        document.getElementById("SC086").value = "0";
        document.getElementById("SC087").value = "0";
        document.getElementById("SC088").value = "0";
        document.getElementById("SC089").value = "0";
        document.getElementById("NO08").readOnly = true;
        document.getElementById("SC081").readOnly = true;
        document.getElementById("SC082").readOnly = true;
        document.getElementById("SC083").readOnly = true;
        document.getElementById("SC084").readOnly = true;
        document.getElementById("SC085").readOnly = true;
        document.getElementById("SC086").readOnly = true;
        document.getElementById("SC087").readOnly = true;
        document.getElementById("SC088").readOnly = true;
        document.getElementById("SC089").readOnly = true;
    }else{            
        document.getElementById("MI08").value = "-";
        document.getElementById("SC081").value = "1";
        document.getElementById("SC082").value = "1";
        document.getElementById("SC083").value = "1";
        document.getElementById("SC084").value = "1";
        document.getElementById("SC085").value = "1";
        document.getElementById("SC086").value = "1";
        document.getElementById("SC087").value = "1";
        document.getElementById("SC088").value = "1";
        document.getElementById("SC089").value = "1";    
        document.getElementById("NO08").readOnly = false;
        document.getElementById("SC081").readOnly = false;
        document.getElementById("SC082").readOnly = false;
        document.getElementById("SC083").readOnly = false;
        document.getElementById("SC084").readOnly = false;
        document.getElementById("SC085").readOnly = false;
        document.getElementById("SC086").readOnly = false;
        document.getElementById("SC087").readOnly = false;
        document.getElementById("SC088").readOnly = false;
        document.getElementById("SC089").readOnly = false;   
    } 
 }
 function handleMI09Chk() {   
    if(MI09.value=='M'||MI09.value=='m'){
        document.getElementById("MI09").value = "M";
        document.getElementById("NO09").value = "-";
        document.getElementById("SC091").value = "0";
        document.getElementById("SC092").value = "0";
        document.getElementById("SC093").value = "0";
        document.getElementById("SC094").value = "0";
        document.getElementById("SC095").value = "0";
        document.getElementById("SC096").value = "0";
        document.getElementById("SC097").value = "0";
        document.getElementById("SC098").value = "0";
        document.getElementById("SC099").value = "0";
        document.getElementById("NO09").readOnly = true;
        document.getElementById("SC091").readOnly = true;
        document.getElementById("SC092").readOnly = true;
        document.getElementById("SC093").readOnly = true;
        document.getElementById("SC094").readOnly = true;
        document.getElementById("SC095").readOnly = true;
        document.getElementById("SC096").readOnly = true;
        document.getElementById("SC097").readOnly = true;
        document.getElementById("SC098").readOnly = true;
        document.getElementById("SC099").readOnly = true;
    }else{            
        document.getElementById("MI09").value = "-";
        document.getElementById("SC091").value = "1";
        document.getElementById("SC092").value = "1";
        document.getElementById("SC093").value = "1";
        document.getElementById("SC094").value = "1";
        document.getElementById("SC095").value = "1";
        document.getElementById("SC096").value = "1";
        document.getElementById("SC097").value = "1";
        document.getElementById("SC098").value = "1";
        document.getElementById("SC099").value = "1";    
        document.getElementById("NO09").readOnly = false;
        document.getElementById("SC091").readOnly = false;
        document.getElementById("SC092").readOnly = false;
        document.getElementById("SC093").readOnly = false;
        document.getElementById("SC094").readOnly = false;
        document.getElementById("SC095").readOnly = false;
        document.getElementById("SC096").readOnly = false;
        document.getElementById("SC097").readOnly = false;
        document.getElementById("SC098").readOnly = false;
        document.getElementById("SC099").readOnly = false;   
    } 
 }
 function handleMI10Chk() {   
    if(MI10.value=='M'||MI10.value=='m'){
        document.getElementById("MI10").value = "M";
        document.getElementById("NO10").value = "-";
        document.getElementById("SC101").value = "0";
        document.getElementById("SC102").value = "0";
        document.getElementById("SC103").value = "0";
        document.getElementById("SC104").value = "0";
        document.getElementById("SC105").value = "0";
        document.getElementById("SC106").value = "0";
        document.getElementById("SC107").value = "0";
        document.getElementById("SC108").value = "0";
        document.getElementById("SC109").value = "0";
        document.getElementById("NO10").readOnly = true;
        document.getElementById("SC101").readOnly = true;
        document.getElementById("SC102").readOnly = true;
        document.getElementById("SC103").readOnly = true;
        document.getElementById("SC104").readOnly = true;
        document.getElementById("SC105").readOnly = true;
        document.getElementById("SC106").readOnly = true;
        document.getElementById("SC107").readOnly = true;
        document.getElementById("SC108").readOnly = true;
        document.getElementById("SC109").readOnly = true;
    }else{            
        document.getElementById("MI10").value = "-";
        document.getElementById("SC101").value = "1";
        document.getElementById("SC102").value = "1";
        document.getElementById("SC103").value = "1";
        document.getElementById("SC104").value = "1";
        document.getElementById("SC105").value = "1";
        document.getElementById("SC106").value = "1";
        document.getElementById("SC107").value = "1";
        document.getElementById("SC108").value = "1";
        document.getElementById("SC109").value = "1";    
        document.getElementById("NO10").readOnly = false;
        document.getElementById("SC101").readOnly = false;
        document.getElementById("SC102").readOnly = false;
        document.getElementById("SC103").readOnly = false;
        document.getElementById("SC104").readOnly = false;
        document.getElementById("SC105").readOnly = false;
        document.getElementById("SC106").readOnly = false;
        document.getElementById("SC107").readOnly = false;
        document.getElementById("SC108").readOnly = false;
        document.getElementById("SC109").readOnly = false;   
    } 
 }
 function handleMI11Chk() {   
    if(MI11.value=='M'||MI11.value=='m'){
        document.getElementById("MI11").value = "M";
        document.getElementById("NO11").value = "-";
        document.getElementById("SC111").value = "0";
        document.getElementById("SC112").value = "0";
        document.getElementById("SC113").value = "0";
        document.getElementById("SC114").value = "0";
        document.getElementById("SC115").value = "0";
        document.getElementById("SC116").value = "0";
        document.getElementById("SC117").value = "0";
        document.getElementById("SC118").value = "0";
        document.getElementById("SC119").value = "0";
        document.getElementById("NO11").readOnly = true;
        document.getElementById("SC111").readOnly = true;
        document.getElementById("SC112").readOnly = true;
        document.getElementById("SC113").readOnly = true;
        document.getElementById("SC114").readOnly = true;
        document.getElementById("SC115").readOnly = true;
        document.getElementById("SC116").readOnly = true;
        document.getElementById("SC117").readOnly = true;
        document.getElementById("SC118").readOnly = true;
        document.getElementById("SC119").readOnly = true;
    }else{            
        document.getElementById("MI11").value = "-";
        document.getElementById("SC111").value = "1";
        document.getElementById("SC112").value = "1";
        document.getElementById("SC113").value = "1";
        document.getElementById("SC114").value = "1";
        document.getElementById("SC115").value = "1";
        document.getElementById("SC116").value = "1";
        document.getElementById("SC117").value = "1";
        document.getElementById("SC118").value = "1";
        document.getElementById("SC119").value = "1";    
        document.getElementById("NO11").readOnly = false;
        document.getElementById("SC111").readOnly = false;
        document.getElementById("SC112").readOnly = false;
        document.getElementById("SC113").readOnly = false;
        document.getElementById("SC114").readOnly = false;
        document.getElementById("SC115").readOnly = false;
        document.getElementById("SC116").readOnly = false;
        document.getElementById("SC117").readOnly = false;
        document.getElementById("SC118").readOnly = false;
        document.getElementById("SC119").readOnly = false;   
    } 
 }
 function handleMI12Chk() {   
    if(MI12.value=='M'||MI12.value=='m'){
        document.getElementById("MI12").value = "M";
        document.getElementById("NO12").value = "-";
        document.getElementById("SC121").value = "0";
        document.getElementById("SC122").value = "0";
        document.getElementById("SC123").value = "0";
        document.getElementById("SC124").value = "0";
        document.getElementById("SC125").value = "0";
        document.getElementById("SC126").value = "0";
        document.getElementById("SC127").value = "0";
        document.getElementById("SC128").value = "0";
        document.getElementById("SC129").value = "0";
        document.getElementById("NO12").readOnly = true;
        document.getElementById("SC121").readOnly = true;
        document.getElementById("SC122").readOnly = true;
        document.getElementById("SC123").readOnly = true;
        document.getElementById("SC124").readOnly = true;
        document.getElementById("SC125").readOnly = true;
        document.getElementById("SC126").readOnly = true;
        document.getElementById("SC127").readOnly = true;
        document.getElementById("SC128").readOnly = true;
        document.getElementById("SC129").readOnly = true;
    }else{            
        document.getElementById("MI12").value = "-";
        document.getElementById("SC121").value = "1";
        document.getElementById("SC122").value = "1";
        document.getElementById("SC123").value = "1";
        document.getElementById("SC124").value = "1";
        document.getElementById("SC125").value = "1";
        document.getElementById("SC126").value = "1";
        document.getElementById("SC127").value = "1";
        document.getElementById("SC128").value = "1";
        document.getElementById("SC129").value = "1";    
        document.getElementById("NO12").readOnly = false;
        document.getElementById("SC121").readOnly = false;
        document.getElementById("SC122").readOnly = false;
        document.getElementById("SC123").readOnly = false;
        document.getElementById("SC124").readOnly = false;
        document.getElementById("SC125").readOnly = false;
        document.getElementById("SC126").readOnly = false;
        document.getElementById("SC127").readOnly = false;
        document.getElementById("SC128").readOnly = false;
        document.getElementById("SC129").readOnly = false;   
    }
}

function handleNO01Chk() {            
    if(NO01.value=='O'||NO01.value=='o'){
          document.getElementById("NO01").value = "O";
          document.getElementById("SC011").value = "0";
          document.getElementById("SC012").value = "0";
          document.getElementById("SC013").value = "0";
          document.getElementById("SC014").value = "0";
          document.getElementById("SC015").value = "0";
          document.getElementById("SC016").value = "0";
          document.getElementById("SC017").value = "0";
          document.getElementById("SC018").value = "0";
          document.getElementById("SC019").value = "0";
          document.getElementById("MI01").readOnly = true;
          document.getElementById("SC011").readOnly = true;
          document.getElementById("SC012").readOnly = true;
          document.getElementById("SC013").readOnly = true;
          document.getElementById("SC014").readOnly = true;
          document.getElementById("SC015").readOnly = true;
          document.getElementById("SC016").readOnly = true;
          document.getElementById("SC017").readOnly = true;
          document.getElementById("SC018").readOnly = true;
          document.getElementById("SC019").readOnly = true;
    }else{     
          document.getElementById("NO01").value = "-";
          document.getElementById("SC011").value = "1";
          document.getElementById("SC012").value = "1";
          document.getElementById("SC013").value = "1";
          document.getElementById("SC014").value = "1";
          document.getElementById("SC015").value = "1";
          document.getElementById("SC016").value = "1";
          document.getElementById("SC017").value = "1";
          document.getElementById("SC018").value = "1";
          document.getElementById("SC019").value = "1";
          document.getElementById("MI01").readOnly = false;
          document.getElementById("SC011").readOnly = false;
          document.getElementById("SC012").readOnly = false;
          document.getElementById("SC013").readOnly = false;
          document.getElementById("SC014").readOnly = false;
          document.getElementById("SC015").readOnly = false;
          document.getElementById("SC016").readOnly = false;
          document.getElementById("SC017").readOnly = false;
          document.getElementById("SC018").readOnly = false;
          document.getElementById("SC019").readOnly = false;
    }    
}
function handleNO02Chk() {    
    if(NO02.value=='O'||NO02.value=='o'){
          document.getElementById("NO02").value = "O";
          document.getElementById("SC021").value = "0";
          document.getElementById("SC022").value = "0";
          document.getElementById("SC023").value = "0";
          document.getElementById("SC024").value = "0";
          document.getElementById("SC025").value = "0";
          document.getElementById("SC026").value = "0";
          document.getElementById("SC027").value = "0";
          document.getElementById("SC028").value = "0";
          document.getElementById("SC029").value = "0";
          document.getElementById("MI02").readOnly = true;
          document.getElementById("SC021").readOnly = true;
          document.getElementById("SC022").readOnly = true;
          document.getElementById("SC023").readOnly = true;
          document.getElementById("SC024").readOnly = true;
          document.getElementById("SC025").readOnly = true;
          document.getElementById("SC026").readOnly = true;
          document.getElementById("SC027").readOnly = true;
          document.getElementById("SC028").readOnly = true;
          document.getElementById("SC029").readOnly = true;
    }else{            
          document.getElementById("NO02").value = "-";
          document.getElementById("SC021").value = "1";
          document.getElementById("SC022").value = "1";
          document.getElementById("SC023").value = "1";
          document.getElementById("SC024").value = "1";
          document.getElementById("SC025").value = "1";
          document.getElementById("SC026").value = "1";
          document.getElementById("SC027").value = "1";
          document.getElementById("SC028").value = "N";
          document.getElementById("SC029").value = "N";
          document.getElementById("MI02").readOnly = false;
          document.getElementById("SC021").readOnly = false;
          document.getElementById("SC022").readOnly = false;
          document.getElementById("SC023").readOnly = false;
          document.getElementById("SC024").readOnly = false;
          document.getElementById("SC025").readOnly = false;
          document.getElementById("SC026").readOnly = false;
          document.getElementById("SC027").readOnly = false;
          document.getElementById("SC028").readOnly = true;
          document.getElementById("SC029").readOnly = true;
    }    
}
function handleNO03Chk() {             
    if(NO03.value=='O'||NO03.value=='o'){
        document.getElementById("NO03").value = "O";
        document.getElementById("SC031").value = "0";
        document.getElementById("SC032").value = "0";
        document.getElementById("SC033").value = "0";
        document.getElementById("SC034").value = "0";
        document.getElementById("SC035").value = "0";
        document.getElementById("SC036").value = "0";
        document.getElementById("SC037").value = "0";
        document.getElementById("SC038").value = "0";
        document.getElementById("SC039").value = "0";
        document.getElementById("MI03").readOnly = true;
        document.getElementById("SC031").readOnly = true;
        document.getElementById("SC032").readOnly = true;
        document.getElementById("SC033").readOnly = true;
        document.getElementById("SC034").readOnly = true;
        document.getElementById("SC035").readOnly = true;
        document.getElementById("SC036").readOnly = true;
        document.getElementById("SC037").readOnly = true;
        document.getElementById("SC038").readOnly = true;
        document.getElementById("SC039").readOnly = true;
    }else{            
        document.getElementById("NO03").value = "-";
        document.getElementById("SC031").value = "1";
        document.getElementById("SC032").value = "1";
        document.getElementById("SC033").value = "1";
        document.getElementById("SC034").value = "1";
        document.getElementById("SC035").value = "1";
        document.getElementById("SC036").value = "1";
        document.getElementById("SC037").value = "1";
        document.getElementById("SC038").value = "1";
        document.getElementById("SC039").value = "1";
          document.getElementById("MI03").readOnly = false;
          document.getElementById("SC031").readOnly = false;
          document.getElementById("SC032").readOnly = false;
          document.getElementById("SC033").readOnly = false;
          document.getElementById("SC034").readOnly = false;
          document.getElementById("SC035").readOnly = false;
          document.getElementById("SC036").readOnly = false;
          document.getElementById("SC037").readOnly = false;
          document.getElementById("SC038").readOnly = false;
          document.getElementById("SC039").readOnly = false;
    }    
}
function handleNO04Chk() {      
    if(NO04.value=='O'||NO04.value=='o'){
        document.getElementById("NO04").value = "O";
        document.getElementById("SC041").value = "0";
        document.getElementById("SC042").value = "0";
        document.getElementById("SC043").value = "0";
        document.getElementById("SC044").value = "0";
        document.getElementById("SC045").value = "0";
        document.getElementById("SC046").value = "0";
        document.getElementById("SC047").value = "0";
        document.getElementById("SC048").value = "0";
        document.getElementById("SC049").value = "0";
          document.getElementById("MI04").readOnly = true;
          document.getElementById("SC041").readOnly = true;
          document.getElementById("SC042").readOnly = true;
          document.getElementById("SC043").readOnly = true;
          document.getElementById("SC044").readOnly = true;
          document.getElementById("SC045").readOnly = true;
          document.getElementById("SC046").readOnly = true;
          document.getElementById("SC047").readOnly = true;
          document.getElementById("SC048").readOnly = true;
          document.getElementById("SC049").readOnly = true;
    }else{            
        document.getElementById("NO04").value = "-";
        document.getElementById("SC041").value = "1";
        document.getElementById("SC042").value = "1";
        document.getElementById("SC043").value = "1";
        document.getElementById("SC044").value = "1";
        document.getElementById("SC045").value = "1";
        document.getElementById("SC046").value = "1";
        document.getElementById("SC047").value = "1";
        document.getElementById("SC048").value = "1";
        document.getElementById("SC049").value = "1";
          document.getElementById("MI04").readOnly = false;
          document.getElementById("SC041").readOnly = false;
          document.getElementById("SC042").readOnly = false;
          document.getElementById("SC043").readOnly = false;
          document.getElementById("SC044").readOnly = false;
          document.getElementById("SC045").readOnly = false;
          document.getElementById("SC046").readOnly = false;
          document.getElementById("SC047").readOnly = false;
          document.getElementById("SC048").readOnly = false;
          document.getElementById("SC049").readOnly = false;
    }    
}
function handleNO05Chk() {           
    if(NO05.value=='O'||NO05.value=='o'){
        document.getElementById("NO05").value = "O";
        document.getElementById("SC051").value = "0";
        document.getElementById("SC052").value = "0";
        document.getElementById("SC053").value = "0";
        document.getElementById("SC054").value = "0";
        document.getElementById("SC055").value = "0";
        document.getElementById("SC056").value = "0";
        document.getElementById("SC057").value = "0";
        document.getElementById("SC058").value = "0";
        document.getElementById("SC059").value = "0";
          document.getElementById("MI05").readOnly = true;
          document.getElementById("SC051").readOnly = true;
          document.getElementById("SC052").readOnly = true;
          document.getElementById("SC053").readOnly = true;
          document.getElementById("SC054").readOnly = true;
          document.getElementById("SC055").readOnly = true;
          document.getElementById("SC056").readOnly = true;
          document.getElementById("SC057").readOnly = true;
          document.getElementById("SC058").readOnly = true;
          document.getElementById("SC059").readOnly = true;
    }else{            
        document.getElementById("NO05").value = "-";
        document.getElementById("SC051").value = "1";
        document.getElementById("SC052").value = "1";
        document.getElementById("SC053").value = "1";
        document.getElementById("SC054").value = "1";
        document.getElementById("SC055").value = "1";
        document.getElementById("SC056").value = "1";
        document.getElementById("SC057").value = "1";
        document.getElementById("SC058").value = "1";
        document.getElementById("SC059").value = "1";
          document.getElementById("MI05").readOnly = false;
          document.getElementById("SC051").readOnly = false;
          document.getElementById("SC052").readOnly = false;
          document.getElementById("SC053").readOnly = false;
          document.getElementById("SC054").readOnly = false;
          document.getElementById("SC055").readOnly = false;
          document.getElementById("SC056").readOnly = false;
          document.getElementById("SC057").readOnly = false;
          document.getElementById("SC058").readOnly = false;
          document.getElementById("SC059").readOnly = false;
    }    
}
function handleNO06Chk() {    
    if(NO06.value=='O'||NO06.value=='o'){
        document.getElementById("NO06").value = "O";
        document.getElementById("SC061").value = "0";
        document.getElementById("SC062").value = "0";
        document.getElementById("SC063").value = "0";
        document.getElementById("SC064").value = "0";
        document.getElementById("SC065").value = "0";
        document.getElementById("SC066").value = "0";
        document.getElementById("SC067").value = "0";
        document.getElementById("SC068").value = "0";
        document.getElementById("SC069").value = "0";
          document.getElementById("MI06").readOnly = true;
          document.getElementById("SC061").readOnly = true;
          document.getElementById("SC062").readOnly = true;
          document.getElementById("SC063").readOnly = true;
          document.getElementById("SC064").readOnly = true;
          document.getElementById("SC065").readOnly = true;
          document.getElementById("SC066").readOnly = true;
          document.getElementById("SC067").readOnly = true;
          document.getElementById("SC068").readOnly = true;
          document.getElementById("SC069").readOnly = true;
    }else{            
        document.getElementById("NO06").value = "-";
        document.getElementById("SC061").value = "1";
        document.getElementById("SC062").value = "1";
        document.getElementById("SC063").value = "1";
        document.getElementById("SC064").value = "1";
        document.getElementById("SC065").value = "1";
        document.getElementById("SC066").value = "1";
        document.getElementById("SC067").value = "1";
        document.getElementById("SC068").value = "1";
        document.getElementById("SC069").value = "1";
          document.getElementById("MI06").readOnly = false;
          document.getElementById("SC061").readOnly = false;
          document.getElementById("SC062").readOnly = false;
          document.getElementById("SC063").readOnly = false;
          document.getElementById("SC064").readOnly = false;
          document.getElementById("SC065").readOnly = false;
          document.getElementById("SC066").readOnly = false;
          document.getElementById("SC067").readOnly = false;
          document.getElementById("SC068").readOnly = false;
          document.getElementById("SC069").readOnly = false;
    }    
}
function handleNO7Chk() {    
    if(NO7.value=='O'||NO7.value=='o'){
        document.getElementById("NO7").value = "O";
        document.getElementById("cr1").value = "0";
        document.getElementById("cr2").value = "0";
        document.getElementById("cr3").value = "0";
        document.getElementById("cr4").value = "0";
        document.getElementById("cr5").value = "0";
        document.getElementById("cr6").value = "0";
        document.getElementById("cr7").value = "0";
        document.getElementById("cr8").value = "0";
        document.getElementById("cr9").value = "0";
          document.getElementById("Missing7").readOnly = true;
          document.getElementById("cr1").readOnly = true;
          document.getElementById("cr2").readOnly = true;
          document.getElementById("cr3").readOnly = true;
          document.getElementById("cr4").readOnly = true;
          document.getElementById("cr5").readOnly = true;
          document.getElementById("cr6").readOnly = true;
          document.getElementById("Scr7").readOnly = true;
          document.getElementById("cr8").readOnly = true;
          document.getElementById("cr9").readOnly = true;
    }else{            
        document.getElementById("NO7").value = "-";
        document.getElementById("cr1").value = "1";
        document.getElementById("cr2").value = "1";
        document.getElementById("cr3").value = "1";
        document.getElementById("cr4").value = "1";
        document.getElementById("cr5").value = "1";
        document.getElementById("cr6").value = "1";
        document.getElementById("cr7").value = "1";
        document.getElementById("cr8").value = "1";
        document.getElementById("cr9").value = "1";
          document.getElementById("Missing7").readOnly = false;
          document.getElementById("cr1").readOnly = false;
          document.getElementById("cr2").readOnly = false;
          document.getElementById("cr3").readOnly = false;
          document.getElementById("cr4").readOnly = false;
          document.getElementById("cr5").readOnly = false;
          document.getElementById("cr6").readOnly = false;
          document.getElementById("cr7").readOnly = false;
          document.getElementById("cr8").readOnly = false;
          document.getElementById("cr9").readOnly = false;
    }    
}
function handleNO07Chk() {    
    if(NO07.value=='O'||NO07.value=='o'){
        document.getElementById("NO07").value = "O";
        document.getElementById("SC071").value = "0";
        document.getElementById("SC072").value = "0";
        document.getElementById("SC073").value = "0";
        document.getElementById("SC074").value = "0";
        document.getElementById("SC075").value = "0";
        document.getElementById("SC076").value = "0";
        document.getElementById("SC077").value = "0";
        document.getElementById("SC078").value = "0";
        document.getElementById("SC079").value = "0";
          document.getElementById("MI07").readOnly = true;
          document.getElementById("SC071").readOnly = true;
          document.getElementById("SC072").readOnly = true;
          document.getElementById("SC073").readOnly = true;
          document.getElementById("SC074").readOnly = true;
          document.getElementById("SC075").readOnly = true;
          document.getElementById("SC076").readOnly = true;
          document.getElementById("SC077").readOnly = true;
          document.getElementById("SC078").readOnly = true;
          document.getElementById("SC079").readOnly = true;
    }else{            
        document.getElementById("NO07").value = "-";
        document.getElementById("SC071").value = "1";
        document.getElementById("SC072").value = "1";
        document.getElementById("SC073").value = "1";
        document.getElementById("SC074").value = "1";
        document.getElementById("SC075").value = "1";
        document.getElementById("SC076").value = "1";
        document.getElementById("SC077").value = "1";
        document.getElementById("SC078").value = "1";
        document.getElementById("SC079").value = "1";
          document.getElementById("MI07").readOnly = false;
          document.getElementById("SC071").readOnly = false;
          document.getElementById("SC072").readOnly = false;
          document.getElementById("SC073").readOnly = false;
          document.getElementById("SC074").readOnly = false;
          document.getElementById("SC075").readOnly = false;
          document.getElementById("SC076").readOnly = false;
          document.getElementById("SC077").readOnly = false;
          document.getElementById("SC078").readOnly = false;
          document.getElementById("SC079").readOnly = false;
    }    
}
function handleNO08Chk() {     
    if(NO08.value=='O'||NO08.value=='o'){
        document.getElementById("NO08").value = "O";
        document.getElementById("SC081").value = "0";
        document.getElementById("SC082").value = "0";
        document.getElementById("SC083").value = "0";
        document.getElementById("SC084").value = "0";
        document.getElementById("SC085").value = "0";
        document.getElementById("SC086").value = "0";
        document.getElementById("SC087").value = "0";
        document.getElementById("SC088").value = "0";
        document.getElementById("SC089").value = "0";
          document.getElementById("MI08").readOnly = true;
          document.getElementById("SC081").readOnly = true;
          document.getElementById("SC082").readOnly = true;
          document.getElementById("SC083").readOnly = true;
          document.getElementById("SC084").readOnly = true;
          document.getElementById("SC085").readOnly = true;
          document.getElementById("SC086").readOnly = true;
          document.getElementById("SC087").readOnly = true;
          document.getElementById("SC088").readOnly = true;
          document.getElementById("SC089").readOnly = true;
    }else{            
        document.getElementById("NO08").value = "-";
        document.getElementById("SC081").value = "1";
        document.getElementById("SC082").value = "1";
        document.getElementById("SC083").value = "1";
        document.getElementById("SC084").value = "1";
        document.getElementById("SC085").value = "1";
        document.getElementById("SC086").value = "1";
        document.getElementById("SC087").value = "1";
        document.getElementById("SC088").value = "1";
        document.getElementById("SC089").value = "1";
          document.getElementById("MI08").readOnly = false;
          document.getElementById("SC081").readOnly = false;
          document.getElementById("SC082").readOnly = false;
          document.getElementById("SC083").readOnly = false;
          document.getElementById("SC084").readOnly = false;
          document.getElementById("SC085").readOnly = false;
          document.getElementById("SC086").readOnly = false;
          document.getElementById("SC087").readOnly = false;
          document.getElementById("SC088").readOnly = false;
          document.getElementById("SC089").readOnly = false;
    }    
}
function handleNO09Chk() {    
    if(NO09.value=='O'||NO09.value=='o'){
        document.getElementById("NO09").value = "O";
        document.getElementById("SC091").value = "0";
        document.getElementById("SC092").value = "0";
        document.getElementById("SC093").value = "0";
        document.getElementById("SC094").value = "0";
        document.getElementById("SC095").value = "0";
        document.getElementById("SC096").value = "0";
        document.getElementById("SC097").value = "0";
        document.getElementById("SC098").value = "0";
        document.getElementById("SC099").value = "0";
          document.getElementById("MI09").readOnly = true;
          document.getElementById("SC091").readOnly = true;
          document.getElementById("SC092").readOnly = true;
          document.getElementById("SC093").readOnly = true;
          document.getElementById("SC094").readOnly = true;
          document.getElementById("SC095").readOnly = true;
          document.getElementById("SC096").readOnly = true;
          document.getElementById("SC097").readOnly = true;
          document.getElementById("SC098").readOnly = true;
          document.getElementById("SC099").readOnly = true;
    }else{            
        document.getElementById("NO09").value = "-";
        document.getElementById("SC091").value = "1";
        document.getElementById("SC092").value = "1";
        document.getElementById("SC093").value = "1";
        document.getElementById("SC094").value = "1";
        document.getElementById("SC095").value = "1";
        document.getElementById("SC096").value = "1";
        document.getElementById("SC097").value = "1";
        document.getElementById("SC098").value = "1";
        document.getElementById("SC099").value = "1";
          document.getElementById("MI09").readOnly = false;
          document.getElementById("SC091").readOnly = false;
          document.getElementById("SC092").readOnly = false;
          document.getElementById("SC093").readOnly = false;
          document.getElementById("SC094").readOnly = false;
          document.getElementById("SC095").readOnly = false;
          document.getElementById("SC096").readOnly = false;
          document.getElementById("SC097").readOnly = false;
          document.getElementById("SC098").readOnly = false;
          document.getElementById("SC099").readOnly = false;
    }    
}
function handleNO10Chk() {    
    if(NO10.value=='O'||NO10.value=='o'){
        document.getElementById("NO10").value = "O";
        document.getElementById("SC101").value = "0";
        document.getElementById("SC102").value = "0";
        document.getElementById("SC103").value = "0";
        document.getElementById("SC104").value = "0";
        document.getElementById("SC105").value = "0";
        document.getElementById("SC106").value = "0";
        document.getElementById("SC107").value = "0";
        document.getElementById("SC108").value = "0";
        document.getElementById("SC109").value = "0";
          document.getElementById("MI10").readOnly = true;
          document.getElementById("SC101").readOnly = true;
          document.getElementById("SC102").readOnly = true;
          document.getElementById("SC103").readOnly = true;
          document.getElementById("SC104").readOnly = true;
          document.getElementById("SC105").readOnly = true;
          document.getElementById("SC106").readOnly = true;
          document.getElementById("SC107").readOnly = true;
          document.getElementById("SC108").readOnly = true;
          document.getElementById("SC109").readOnly = true;
    }else{            
        document.getElementById("NO10").value = "-";
        document.getElementById("SC101").value = "1";
        document.getElementById("SC102").value = "1";
        document.getElementById("SC103").value = "1";
        document.getElementById("SC104").value = "1";
        document.getElementById("SC105").value = "1";
        document.getElementById("SC106").value = "1";
        document.getElementById("SC107").value = "1";
        document.getElementById("SC108").value = "1";
        document.getElementById("SC109").value = "1";
          document.getElementById("MI10").readOnly = false;
          document.getElementById("SC101").readOnly = false;
          document.getElementById("SC102").readOnly = false;
          document.getElementById("SC103").readOnly = false;
          document.getElementById("SC104").readOnly = false;
          document.getElementById("SC105").readOnly = false;
          document.getElementById("SC106").readOnly = false;
          document.getElementById("SC107").readOnly = false;
          document.getElementById("SC108").readOnly = false;
          document.getElementById("SC109").readOnly = false;
    }    
}
function handleNO11Chk() {     
    if(NO11.value=='O'||NO11.value=='o'){
        document.getElementById("NO11").value = "O";
        document.getElementById("SC111").value = "0";
        document.getElementById("SC112").value = "0";
        document.getElementById("SC113").value = "0";
        document.getElementById("SC114").value = "0";
        document.getElementById("SC115").value = "0";
        document.getElementById("SC116").value = "0";
        document.getElementById("SC117").value = "0";
        document.getElementById("SC118").value = "0";
        document.getElementById("SC119").value = "0";
          document.getElementById("MI11").readOnly = true;
          document.getElementById("SC111").readOnly = true;
          document.getElementById("SC112").readOnly = true;
          document.getElementById("SC113").readOnly = true;
          document.getElementById("SC114").readOnly = true;
          document.getElementById("SC115").readOnly = true;
          document.getElementById("SC116").readOnly = true;
          document.getElementById("SC117").readOnly = true;
          document.getElementById("SC118").readOnly = true;
          document.getElementById("SC119").readOnly = true;
    }else{            
        document.getElementById("NO11").value = "-";
        document.getElementById("SC111").value = "1";
        document.getElementById("SC112").value = "1";
        document.getElementById("SC113").value = "1";
        document.getElementById("SC114").value = "1";
        document.getElementById("SC115").value = "1";
        document.getElementById("SC116").value = "1";
        document.getElementById("SC117").value = "1";
        document.getElementById("SC118").value = "1";
        document.getElementById("SC119").value = "1";
          document.getElementById("MI11").readOnly = false;
          document.getElementById("SC111").readOnly = false;
          document.getElementById("SC112").readOnly = false;
          document.getElementById("SC113").readOnly = false;
          document.getElementById("SC114").readOnly = false;
          document.getElementById("SC115").readOnly = false;
          document.getElementById("SC116").readOnly = false;
          document.getElementById("SC117").readOnly = false;
          document.getElementById("SC118").readOnly = false;
          document.getElementById("SC119").readOnly = false;
    }    
}
function handleNO12Chk() {    
    if(NO12.value=='O'||NO12.value=='o'){
        document.getElementById("NO12").value = "O";
        document.getElementById("SC121").value = "0";
        document.getElementById("SC122").value = "0";
        document.getElementById("SC123").value = "0";
        document.getElementById("SC124").value = "0";
        document.getElementById("SC125").value = "0";
        document.getElementById("SC126").value = "0";
        document.getElementById("SC127").value = "0";
        document.getElementById("SC128").value = "0";
        document.getElementById("SC129").value = "0";
          document.getElementById("MI12").readOnly = true;
          document.getElementById("SC121").readOnly = true;
          document.getElementById("SC122").readOnly = true;
          document.getElementById("SC123").readOnly = true;
          document.getElementById("SC124").readOnly = true;
          document.getElementById("SC125").readOnly = true;
          document.getElementById("SC126").readOnly = true;
          document.getElementById("SC127").readOnly = true;
          document.getElementById("SC128").readOnly = true;
          document.getElementById("SC129").readOnly = true;
    }else{            
        document.getElementById("NO12").value = "-";
        document.getElementById("SC121").value = "1";
        document.getElementById("SC122").value = "1";
        document.getElementById("SC123").value = "1";
        document.getElementById("SC124").value = "1";
        document.getElementById("SC125").value = "1";
        document.getElementById("SC126").value = "1";
        document.getElementById("SC127").value = "1";
        document.getElementById("SC128").value = "1";
        document.getElementById("SC129").value = "1";
          document.getElementById("MI12").readOnly = false;
          document.getElementById("SC121").readOnly = false;
          document.getElementById("SC122").readOnly = false;
          document.getElementById("SC123").readOnly = false;
          document.getElementById("SC124").readOnly = false;
          document.getElementById("SC125").readOnly = false;
          document.getElementById("SC126").readOnly = false;
          document.getElementById("SC127").readOnly = false;
          document.getElementById("SC128").readOnly = false;
          document.getElementById("SC129").readOnly = false;
    }   
}

function handleSCChk() {     
        if(SC011.value=='N'||SC011.value=='n'||SC011.value=='1'||SC011.value=='0'){  }else{ document.getElementById("SC011").value = "0"; }
        if(SC012.value=='N'||SC012.value=='n'||SC012.value=='1'||SC012.value=='0'){  }else{ document.getElementById("SC012").value = "0"; }
        if(SC013.value=='N'||SC013.value=='n'||SC013.value=='1'||SC013.value=='0'){  }else{ document.getElementById("SC013").value = "0"; }
        if(SC014.value=='N'||SC014.value=='n'||SC014.value=='1'||SC014.value=='0'){  }else{ document.getElementById("SC014").value = "0"; }
        if(SC015.value=='N'||SC015.value=='n'||SC015.value=='1'||SC015.value=='0'){  }else{ document.getElementById("SC015").value = "0"; }
        if(SC016.value=='N'||SC016.value=='n'||SC016.value=='1'||SC016.value=='0'){  }else{ document.getElementById("SC016").value = "0"; }
        if(SC017.value=='N'||SC017.value=='n'||SC017.value=='1'||SC017.value=='0'){  }else{ document.getElementById("SC017").value = "0"; }
        if(SC018.value=='N'||SC018.value=='n'||SC018.value=='1'||SC018.value=='0'){  }else{ document.getElementById("SC018").value = "0"; }
        if(SC019.value=='N'||SC019.value=='n'||SC019.value=='1'||SC019.value=='0'){  }else{ document.getElementById("SC019").value = "0"; }
        if(SC021.value=='N'||SC021.value=='n'||SC021.value=='1'||SC021.value=='0'){  }else{ document.getElementById("SC021").value = "0"; }
        if(SC022.value=='N'||SC022.value=='n'||SC022.value=='1'||SC022.value=='0'){  }else{ document.getElementById("SC022").value = "0"; }
        if(SC023.value=='N'||SC023.value=='n'||SC023.value=='1'||SC023.value=='0'){  }else{ document.getElementById("SC023").value = "0"; }
        if(SC024.value=='N'||SC024.value=='n'||SC024.value=='1'||SC024.value=='0'){  }else{ document.getElementById("SC024").value = "0"; }
        if(SC025.value=='N'||SC025.value=='n'||SC025.value=='1'||SC025.value=='0'){  }else{ document.getElementById("SC025").value = "0"; }
        if(SC026.value=='N'||SC026.value=='n'||SC026.value=='1'||SC026.value=='0'){  }else{ document.getElementById("SC026").value = "0"; }
        if(SC027.value=='N'||SC027.value=='n'||SC027.value=='1'||SC027.value=='0'){  }else{ document.getElementById("SC027").value = "0"; }
        if(SC028.value=='N'||SC028.value=='n'||SC028.value=='1'||SC028.value=='0'){  }else{ document.getElementById("SC028").value = "0"; }
        if(SC029.value=='N'||SC029.value=='n'||SC029.value=='1'||SC029.value=='0'){  }else{ document.getElementById("SC029").value = "0"; }
        if(SC031.value=='N'||SC031.value=='n'||SC031.value=='1'||SC031.value=='0'){  }else{ document.getElementById("SC031").value = "0"; }
        if(SC032.value=='N'||SC032.value=='n'||SC032.value=='1'||SC032.value=='0'){  }else{ document.getElementById("SC032").value = "0"; }
        if(SC033.value=='N'||SC033.value=='n'||SC033.value=='1'||SC033.value=='0'){  }else{ document.getElementById("SC033").value = "0"; }
        if(SC034.value=='N'||SC034.value=='n'||SC034.value=='1'||SC034.value=='0'){  }else{ document.getElementById("SC034").value = "0"; }
        if(SC035.value=='N'||SC035.value=='n'||SC035.value=='1'||SC035.value=='0'){  }else{ document.getElementById("SC035").value = "0"; }
        if(SC036.value=='N'||SC036.value=='n'||SC036.value=='1'||SC036.value=='0'){  }else{ document.getElementById("SC036").value = "0"; }
        if(SC037.value=='N'||SC037.value=='n'||SC037.value=='1'||SC037.value=='0'){  }else{ document.getElementById("SC037").value = "0"; }
        if(SC038.value=='N'||SC038.value=='n'||SC038.value=='1'||SC038.value=='0'){  }else{ document.getElementById("SC038").value = "0"; }
        if(SC039.value=='N'||SC039.value=='n'||SC039.value=='1'||SC039.value=='0'){  }else{ document.getElementById("SC039").value = "0"; }
        if(SC041.value=='N'||SC041.value=='n'||SC041.value=='1'||SC041.value=='0'){  }else{ document.getElementById("SC041").value = "0"; }
        if(SC042.value=='N'||SC042.value=='n'||SC042.value=='1'||SC042.value=='0'){  }else{ document.getElementById("SC042").value = "0"; }
        if(SC043.value=='N'||SC043.value=='n'||SC043.value=='1'||SC043.value=='0'){  }else{ document.getElementById("SC043").value = "0"; }
        if(SC044.value=='N'||SC044.value=='n'||SC044.value=='1'||SC044.value=='0'){  }else{ document.getElementById("SC044").value = "0"; }
        if(SC045.value=='N'||SC045.value=='n'||SC045.value=='1'||SC045.value=='0'){  }else{ document.getElementById("SC045").value = "0"; }
        if(SC046.value=='N'||SC046.value=='n'||SC046.value=='1'||SC046.value=='0'){  }else{ document.getElementById("SC046").value = "0"; }
        if(SC047.value=='N'||SC047.value=='n'||SC047.value=='1'||SC047.value=='0'){  }else{ document.getElementById("SC047").value = "0"; }
        if(SC048.value=='N'||SC048.value=='n'||SC048.value=='1'||SC048.value=='0'){  }else{ document.getElementById("SC048").value = "0"; }
        if(SC049.value=='N'||SC049.value=='n'||SC049.value=='1'||SC049.value=='0'){  }else{ document.getElementById("SC049").value = "0"; }
        if(SC051.value=='N'||SC051.value=='n'||SC051.value=='1'||SC051.value=='0'){  }else{ document.getElementById("SC051").value = "0"; }
        if(SC052.value=='N'||SC052.value=='n'||SC052.value=='1'||SC052.value=='0'){  }else{ document.getElementById("SC052").value = "0"; }
        if(SC053.value=='N'||SC053.value=='n'||SC053.value=='1'||SC053.value=='0'){  }else{ document.getElementById("SC053").value = "0"; }
        if(SC054.value=='N'||SC054.value=='n'||SC054.value=='1'||SC054.value=='0'){  }else{ document.getElementById("SC054").value = "0"; }
        if(SC055.value=='N'||SC055.value=='n'||SC055.value=='1'||SC055.value=='0'){  }else{ document.getElementById("SC055").value = "0"; }
        if(SC056.value=='N'||SC056.value=='n'||SC056.value=='1'||SC056.value=='0'){  }else{ document.getElementById("SC056").value = "0"; }
        if(SC057.value=='N'||SC057.value=='n'||SC057.value=='1'||SC057.value=='0'){  }else{ document.getElementById("SC057").value = "0"; }
        if(SC058.value=='N'||SC058.value=='n'||SC058.value=='1'||SC058.value=='0'){  }else{ document.getElementById("SC058").value = "0"; }
        if(SC059.value=='N'||SC059.value=='n'||SC059.value=='1'||SC059.value=='0'){  }else{ document.getElementById("SC059").value = "0"; }
        if(SC061.value=='N'||SC061.value=='n'||SC061.value=='1'||SC061.value=='0'){  }else{ document.getElementById("SC061").value = "0"; }
        if(SC062.value=='N'||SC062.value=='n'||SC062.value=='1'||SC062.value=='0'){  }else{ document.getElementById("SC062").value = "0"; }
        if(SC063.value=='N'||SC063.value=='n'||SC063.value=='1'||SC063.value=='0'){  }else{ document.getElementById("SC063").value = "0"; }
        if(SC064.value=='N'||SC064.value=='n'||SC064.value=='1'||SC064.value=='0'){  }else{ document.getElementById("SC064").value = "0"; }
        if(SC065.value=='N'||SC065.value=='n'||SC065.value=='1'||SC065.value=='0'){  }else{ document.getElementById("SC065").value = "0"; }
        if(SC066.value=='N'||SC066.value=='n'||SC066.value=='1'||SC066.value=='0'){  }else{ document.getElementById("SC066").value = "0"; }
        if(SC067.value=='N'||SC067.value=='n'||SC067.value=='1'||SC067.value=='0'){  }else{ document.getElementById("SC067").value = "0"; }
        if(SC068.value=='N'||SC068.value=='n'||SC068.value=='1'||SC068.value=='0'){  }else{ document.getElementById("SC068").value = "0"; }
        if(SC069.value=='N'||SC069.value=='n'||SC069.value=='1'||SC069.value=='0'){  }else{ document.getElementById("SC069").value = "0"; }
        if(SC071.value=='N'||SC071.value=='n'||SC071.value=='1'||SC071.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC071").value = "0"; }
        if(SC072.value=='N'||SC072.value=='n'||SC072.value=='1'||SC072.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC072").value = "0"; }
        if(SC073.value=='N'||SC073.value=='n'||SC073.value=='1'||SC073.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC073").value = "0"; }
        if(SC074.value=='N'||SC074.value=='n'||SC074.value=='1'||SC074.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC074").value = "0"; }
        if(SC075.value=='N'||SC075.value=='n'||SC075.value=='1'||SC075.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC075").value = "0"; }
        if(SC076.value=='N'||SC076.value=='n'||SC076.value=='1'||SC076.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC076").value = "0"; }
        if(SC077.value=='N'||SC077.value=='n'||SC077.value=='1'||SC077.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC077").value = "0"; }
        if(SC078.value=='N'||SC078.value=='n'||SC078.value=='1'||SC078.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC078").value = "0"; }
        if(SC079.value=='N'||SC079.value=='n'||SC079.value=='1'||SC079.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC079").value = "0"; }
        if(SC081.value=='N'||SC081.value=='n'||SC081.value=='1'||SC081.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC081").value = "0"; }
        if(SC082.value=='N'||SC082.value=='n'||SC082.value=='1'||SC082.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC082").value = "0"; }
        if(SC083.value=='N'||SC083.value=='n'||SC083.value=='1'||SC083.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC083").value = "0"; }
        if(SC084.value=='N'||SC084.value=='n'||SC084.value=='1'||SC084.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC084").value = "0"; }
        if(SC085.value=='N'||SC085.value=='n'||SC085.value=='1'||SC085.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC085").value = "0"; }
        if(SC086.value=='N'||SC086.value=='n'||SC086.value=='1'||SC086.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC086").value = "0"; }
        if(SC087.value=='N'||SC087.value=='n'||SC087.value=='1'||SC087.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC087").value = "0"; }
        if(SC088.value=='N'||SC088.value=='n'||SC088.value=='1'||SC088.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC088").value = "0"; }
        if(SC089.value=='N'||SC089.value=='n'||SC089.value=='1'||SC089.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC089").value = "0"; }
        if(SC091.value=='N'||SC091.value=='n'||SC091.value=='1'||SC091.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC091").value = "0"; }
        if(SC092.value=='N'||SC092.value=='n'||SC092.value=='1'||SC092.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC092").value = "0"; }
        if(SC093.value=='N'||SC093.value=='n'||SC093.value=='1'||SC093.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC093").value = "0"; }
        if(SC094.value=='N'||SC094.value=='n'||SC094.value=='1'||SC094.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC094").value = "0"; }
        if(SC095.value=='N'||SC095.value=='n'||SC095.value=='1'||SC095.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC095").value = "0"; }
        if(SC096.value=='N'||SC096.value=='n'||SC096.value=='1'||SC096.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC096").value = "0"; }
        if(SC097.value=='N'||SC097.value=='n'||SC097.value=='1'||SC097.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC097").value = "0"; }
        if(SC098.value=='N'||SC098.value=='n'||SC098.value=='1'||SC098.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC098").value = "0"; }
        if(SC099.value=='N'||SC099.value=='n'||SC099.value=='1'||SC099.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC099").value = "0"; }
        if(SC101.value=='N'||SC101.value=='n'||SC101.value=='1'||SC101.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC101").value = "0"; }
        if(SC102.value=='N'||SC102.value=='n'||SC102.value=='1'||SC102.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC102").value = "0"; }
        if(SC103.value=='N'||SC103.value=='n'||SC103.value=='1'||SC103.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC103").value = "0"; }
        if(SC104.value=='N'||SC104.value=='n'||SC104.value=='1'||SC104.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC104").value = "0"; }
        if(SC105.value=='N'||SC105.value=='n'||SC105.value=='1'||SC105.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC105").value = "0"; }
        if(SC106.value=='N'||SC106.value=='n'||SC106.value=='1'||SC106.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC106").value = "0"; }
        if(SC107.value=='N'||SC107.value=='n'||SC107.value=='1'||SC107.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC107").value = "0"; }
        if(SC108.value=='N'||SC108.value=='n'||SC108.value=='1'||SC108.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC108").value = "0"; }
        if(SC109.value=='N'||SC109.value=='n'||SC109.value=='1'||SC109.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC109").value = "0"; }
        if(SC111.value=='N'||SC111.value=='n'||SC111.value=='1'||SC111.value=='0'||NA11.value=='N'){  }else{ document.getElementById("SC111").value = "0"; }
        if(SC112.value=='N'||SC112.value=='n'||SC112.value=='1'||SC112.value=='0'||NA11.value=='N'){  }else{ document.getElementById("SC112").value = "0"; }
        if(SC113.value=='N'||SC113.value=='n'||SC113.value=='1'||SC113.value=='0'||NA11.value=='N'){  }else{ document.getElementById("SC113").value = "0"; }
        if(SC114.value=='N'||SC114.value=='n'||SC114.value=='1'||SC114.value=='0'||NA11.value=='N'){  }else{ document.getElementById("SC114").value = "0"; }
        if(SC115.value=='N'||SC115.value=='n'||SC115.value=='1'||SC115.value=='0'||NA11.value=='N'){  }else{ document.getElementById("SC115").value = "0"; }
        if(SC116.value=='N'||SC116.value=='n'||SC116.value=='1'||SC116.value=='0'||NA11.value=='N'){  }else{ document.getElementById("SC116").value = "0"; }
        if(SC117.value=='N'||SC117.value=='n'||SC117.value=='1'||SC117.value=='0'||NA11.value=='N'){  }else{ document.getElementById("SC117").value = "0"; }
        if(SC118.value=='N'||SC118.value=='n'||SC118.value=='1'||SC118.value=='0'||NA11.value=='N'){  }else{ document.getElementById("SC118").value = "0"; }
        if(SC119.value=='N'||SC119.value=='n'||SC119.value=='1'||SC119.value=='0'||NA11.value=='N'){  }else{ document.getElementById("SC119").value = "0"; }
        if(SC121.value=='N'||SC121.value=='n'||SC121.value=='1'||SC121.value=='0'){  }else{ document.getElementById("SC121").value = "0"; }
        if(SC122.value=='N'||SC122.value=='n'||SC122.value=='1'||SC122.value=='0'){  }else{ document.getElementById("SC122").value = "0"; }
        if(SC123.value=='N'||SC123.value=='n'||SC123.value=='1'||SC123.value=='0'){  }else{ document.getElementById("SC123").value = "0"; }
        if(SC124.value=='N'||SC124.value=='n'||SC124.value=='1'||SC124.value=='0'){  }else{ document.getElementById("SC124").value = "0"; }
        if(SC125.value=='N'||SC125.value=='n'||SC125.value=='1'||SC125.value=='0'){  }else{ document.getElementById("SC125").value = "0"; }
        if(SC126.value=='N'||SC126.value=='n'||SC126.value=='1'||SC126.value=='0'){  }else{ document.getElementById("SC126").value = "0"; }
        if(SC127.value=='N'||SC127.value=='n'||SC127.value=='1'||SC127.value=='0'){  }else{ document.getElementById("SC127").value = "0"; }
        if(SC128.value=='N'||SC128.value=='n'||SC128.value=='1'||SC128.value=='0'){  }else{ document.getElementById("SC128").value = "0"; }
        if(SC129.value=='N'||SC129.value=='n'||SC129.value=='1'||SC129.value=='0'){  }else{ document.getElementById("SC129").value = "0"; }
        if(DEC12.value=='1'||DEC12.value=='0'){  }else{ document.getElementById("DEC12").value = "0"; }
}
function handleSC1Chk() {     
        if(SC011.value=='N'||SC011.value=='n'||SC011.value=='1'||SC011.value=='0'){  }else{ document.getElementById("SC011").value = "0"; }
        if(SC012.value=='N'||SC012.value=='n'||SC012.value=='1'||SC012.value=='0'){  }else{ document.getElementById("SC012").value = "0"; }
        if(SC013.value=='N'||SC013.value=='n'||SC013.value=='1'||SC013.value=='0'){  }else{ document.getElementById("SC013").value = "0"; }
        if(SC014.value=='N'||SC014.value=='n'||SC014.value=='1'||SC014.value=='0'){  }else{ document.getElementById("SC014").value = "0"; }
        if(SC015.value=='N'||SC015.value=='n'||SC015.value=='1'||SC015.value=='0'){  }else{ document.getElementById("SC015").value = "0"; }
        if(SC016.value=='N'||SC016.value=='n'||SC016.value=='1'||SC016.value=='0'){  }else{ document.getElementById("SC016").value = "0"; }
        if(SC017.value=='N'||SC017.value=='n'||SC017.value=='1'||SC017.value=='0'){  }else{ document.getElementById("SC017").value = "0"; }
        if(SC018.value=='N'||SC018.value=='n'||SC018.value=='1'||SC018.value=='0'){  }else{ document.getElementById("SC018").value = "0"; }
        if(SC019.value=='N'||SC019.value=='n'||SC019.value=='1'||SC019.value=='0'){  }else{ document.getElementById("SC019").value = "0"; }
        if(SC021.value=='N'||SC021.value=='n'||SC021.value=='1'||SC021.value=='0'){  }else{ document.getElementById("SC021").value = "0"; }
        if(SC022.value=='N'||SC022.value=='n'||SC022.value=='1'||SC022.value=='0'){  }else{ document.getElementById("SC022").value = "0"; }
        if(SC023.value=='N'||SC023.value=='n'||SC023.value=='1'||SC023.value=='0'){  }else{ document.getElementById("SC023").value = "0"; }
        if(SC024.value=='N'||SC024.value=='n'||SC024.value=='1'||SC024.value=='0'){  }else{ document.getElementById("SC024").value = "0"; }
        if(SC025.value=='N'||SC025.value=='n'||SC025.value=='1'||SC025.value=='0'){  }else{ document.getElementById("SC025").value = "0"; }
        if(SC026.value=='N'||SC026.value=='n'||SC026.value=='1'||SC026.value=='0'){  }else{ document.getElementById("SC026").value = "0"; }
        if(SC027.value=='N'||SC027.value=='n'||SC027.value=='1'||SC027.value=='0'){  }else{ document.getElementById("SC027").value = "0"; }
        if(SC028.value=='N'||SC028.value=='n'||SC028.value=='1'||SC028.value=='0'){  }else{ document.getElementById("SC028").value = "0"; }
        if(SC029.value=='N'||SC029.value=='n'||SC029.value=='1'||SC029.value=='0'){  }else{ document.getElementById("SC029").value = "0"; }
        if(SC031.value=='N'||SC031.value=='n'||SC031.value=='1'||SC031.value=='0'){  }else{ document.getElementById("SC031").value = "0"; }
        if(SC032.value=='N'||SC032.value=='n'||SC032.value=='1'||SC032.value=='0'){  }else{ document.getElementById("SC032").value = "0"; }
        if(SC033.value=='N'||SC033.value=='n'||SC033.value=='1'||SC033.value=='0'){  }else{ document.getElementById("SC033").value = "0"; }
        if(SC034.value=='N'||SC034.value=='n'||SC034.value=='1'||SC034.value=='0'){  }else{ document.getElementById("SC034").value = "0"; }
        if(SC035.value=='N'||SC035.value=='n'||SC035.value=='1'||SC035.value=='0'){  }else{ document.getElementById("SC035").value = "0"; }
        if(SC036.value=='N'||SC036.value=='n'||SC036.value=='1'||SC036.value=='0'){  }else{ document.getElementById("SC036").value = "0"; }
        if(SC037.value=='N'||SC037.value=='n'||SC037.value=='1'||SC037.value=='0'){  }else{ document.getElementById("SC037").value = "0"; }
        if(SC038.value=='N'||SC038.value=='n'||SC038.value=='1'||SC038.value=='0'){  }else{ document.getElementById("SC038").value = "0"; }
        if(SC039.value=='N'||SC039.value=='n'||SC039.value=='1'||SC039.value=='0'){  }else{ document.getElementById("SC039").value = "0"; }
        if(SC041.value=='N'||SC041.value=='n'||SC041.value=='1'||SC041.value=='0'){  }else{ document.getElementById("SC041").value = "0"; }
        if(SC042.value=='N'||SC042.value=='n'||SC042.value=='1'||SC042.value=='0'){  }else{ document.getElementById("SC042").value = "0"; }
        if(SC043.value=='N'||SC043.value=='n'||SC043.value=='1'||SC043.value=='0'){  }else{ document.getElementById("SC043").value = "0"; }
        if(SC044.value=='N'||SC044.value=='n'||SC044.value=='1'||SC044.value=='0'){  }else{ document.getElementById("SC044").value = "0"; }
        if(SC045.value=='N'||SC045.value=='n'||SC045.value=='1'||SC045.value=='0'){  }else{ document.getElementById("SC045").value = "0"; }
        if(SC046.value=='N'||SC046.value=='n'||SC046.value=='1'||SC046.value=='0'){  }else{ document.getElementById("SC046").value = "0"; }
        if(SC047.value=='N'||SC047.value=='n'||SC047.value=='1'||SC047.value=='0'){  }else{ document.getElementById("SC047").value = "0"; }
        if(SC048.value=='N'||SC048.value=='n'||SC048.value=='1'||SC048.value=='0'){  }else{ document.getElementById("SC048").value = "0"; }
        if(SC049.value=='N'||SC049.value=='n'||SC049.value=='1'||SC049.value=='0'){  }else{ document.getElementById("SC049").value = "0"; }
        if(SC051.value=='N'||SC051.value=='n'||SC051.value=='1'||SC051.value=='0'){  }else{ document.getElementById("SC051").value = "0"; }
        if(SC052.value=='N'||SC052.value=='n'||SC052.value=='1'||SC052.value=='0'){  }else{ document.getElementById("SC052").value = "0"; }
        if(SC053.value=='N'||SC053.value=='n'||SC053.value=='1'||SC053.value=='0'){  }else{ document.getElementById("SC053").value = "0"; }
        if(SC054.value=='N'||SC054.value=='n'||SC054.value=='1'||SC054.value=='0'){  }else{ document.getElementById("SC054").value = "0"; }
        if(SC055.value=='N'||SC055.value=='n'||SC055.value=='1'||SC055.value=='0'){  }else{ document.getElementById("SC055").value = "0"; }
        if(SC056.value=='N'||SC056.value=='n'||SC056.value=='1'||SC056.value=='0'){  }else{ document.getElementById("SC056").value = "0"; }
        if(SC057.value=='N'||SC057.value=='n'||SC057.value=='1'||SC057.value=='0'){  }else{ document.getElementById("SC057").value = "0"; }
        if(SC058.value=='N'||SC058.value=='n'||SC058.value=='1'||SC058.value=='0'){  }else{ document.getElementById("SC058").value = "0"; }
        if(SC059.value=='N'||SC059.value=='n'||SC059.value=='1'||SC059.value=='0'){  }else{ document.getElementById("SC059").value = "0"; }
        if(SC061.value=='N'||SC061.value=='n'||SC061.value=='1'||SC061.value=='0'){  }else{ document.getElementById("SC061").value = "0"; }
        if(SC062.value=='N'||SC062.value=='n'||SC062.value=='1'||SC062.value=='0'){  }else{ document.getElementById("SC062").value = "0"; }
        if(SC063.value=='N'||SC063.value=='n'||SC063.value=='1'||SC063.value=='0'){  }else{ document.getElementById("SC063").value = "0"; }
        if(SC064.value=='N'||SC064.value=='n'||SC064.value=='1'||SC064.value=='0'){  }else{ document.getElementById("SC064").value = "0"; }
        if(SC065.value=='N'||SC065.value=='n'||SC065.value=='1'||SC065.value=='0'){  }else{ document.getElementById("SC065").value = "0"; }
        if(SC066.value=='N'||SC066.value=='n'||SC066.value=='1'||SC066.value=='0'){  }else{ document.getElementById("SC066").value = "0"; }
        if(SC067.value=='N'||SC067.value=='n'||SC067.value=='1'||SC067.value=='0'){  }else{ document.getElementById("SC067").value = "0"; }
        if(SC068.value=='N'||SC068.value=='n'||SC068.value=='1'||SC068.value=='0'){  }else{ document.getElementById("SC068").value = "0"; }
        if(SC069.value=='N'||SC069.value=='n'||SC069.value=='1'||SC069.value=='0'){  }else{ document.getElementById("SC069").value = "0"; }
        if(cr1.value=='N'||cr1.value=='n'||cr1.value=='1'||cr1.value=='0'||NA7.value=='N'){  }else{ document.getElementById("cr1").value = "0"; }
        if(cr2.value=='N'||cr2.value=='n'||cr2.value=='1'||cr2.value=='0'||NA7.value=='N'){  }else{ document.getElementById("cr2").value = "0"; }
        if(cr3.value=='N'||cr3.value=='n'||cr3.value=='1'||cr3.value=='0'||NA7.value=='N'){  }else{ document.getElementById("cr3").value = "0"; }
        if(cr4.value=='N'||cr4.value=='n'|cr4.value=='1'||cr4.value=='0'||NA7.value=='N'){  }else{ document.getElementById("cr4").value = "0"; }
        if(cr5.value=='N'||cr5.value=='n'|cr5.value=='1'||cr5.value=='0'||NA7.value=='N'){  }else{ document.getElementById("cr5").value = "0"; }
        if(cr6.value=='N'||cr6.value=='n'|cr6.value=='1'||cr6.value=='0'||NA7.value=='N'){  }else{ document.getElementById("cr6").value = "0"; }
        if(cr7.value=='N'||cr7.value=='n'|cr7.value=='1'||cr7.value=='0'||NA7.value=='N'){  }else{ document.getElementById("cr7").value = "0"; }
        if(cr8.value=='N'||cr8.value=='n'|cr8.value=='1'||cr8.value=='0'||NA7.value=='N'){  }else{ document.getElementById("cr8").value = "0"; }
        if(cr9.value=='N'||cr9.value=='n'|cr9.value=='1'||cr9.value=='0'||NA7.value=='N'){  }else{ document.getElementById("cr9").value = "0"; }
        if(SC075.value=='N'||SC075.value=='n'||SC075.value=='1'||SC075.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC075").value = "0"; }
        if(SC076.value=='N'||SC076.value=='n'||SC076.value=='1'||SC076.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC076").value = "0"; }
        if(SC077.value=='N'||SC077.value=='n'||SC077.value=='1'||SC077.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC077").value = "0"; }
        if(SC078.value=='N'||SC078.value=='n'||SC078.value=='1'||SC078.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC078").value = "0"; }
        if(SC079.value=='N'||SC079.value=='n'||SC079.value=='1'||SC079.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC079").value = "0"; }
        if(SC081.value=='N'||SC081.value=='n'||SC081.value=='1'||SC081.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC081").value = "0"; }
        if(SC082.value=='N'||SC082.value=='n'||SC082.value=='1'||SC082.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC082").value = "0"; }
        if(SC083.value=='N'||SC083.value=='n'||SC083.value=='1'||SC083.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC083").value = "0"; }
        if(SC084.value=='N'||SC084.value=='n'||SC084.value=='1'||SC084.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC084").value = "0"; }
        if(SC085.value=='N'||SC085.value=='n'||SC085.value=='1'||SC085.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC085").value = "0"; }
        if(SC086.value=='N'||SC086.value=='n'||SC086.value=='1'||SC086.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC086").value = "0"; }
        if(SC087.value=='N'||SC087.value=='n'||SC087.value=='1'||SC087.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC087").value = "0"; }
        if(SC088.value=='N'||SC088.value=='n'||SC088.value=='1'||SC088.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC088").value = "0"; }
        if(SC089.value=='N'||SC089.value=='n'||SC089.value=='1'||SC089.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC089").value = "0"; }
        if(SC091.value=='N'||SC091.value=='n'||SC091.value=='1'||SC091.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC091").value = "0"; }
        if(SC092.value=='N'||SC092.value=='n'||SC092.value=='1'||SC092.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC092").value = "0"; }
        if(SC093.value=='N'||SC093.value=='n'||SC093.value=='1'||SC093.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC093").value = "0"; }
        if(SC094.value=='N'||SC094.value=='n'||SC094.value=='1'||SC094.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC094").value = "0"; }
        if(SC095.value=='N'||SC095.value=='n'||SC095.value=='1'||SC095.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC095").value = "0"; }
        if(SC096.value=='N'||SC096.value=='n'||SC096.value=='1'||SC096.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC096").value = "0"; }
        if(SC097.value=='N'||SC097.value=='n'||SC097.value=='1'||SC097.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC097").value = "0"; }
        if(SC098.value=='N'||SC098.value=='n'||SC098.value=='1'||SC098.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC098").value = "0"; }
        if(SC099.value=='N'||SC099.value=='n'||SC099.value=='1'||SC099.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC099").value = "0"; }
        if(SC101.value=='N'||SC101.value=='n'||SC101.value=='1'||SC101.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC101").value = "0"; }
        if(SC102.value=='N'||SC102.value=='n'||SC102.value=='1'||SC102.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC102").value = "0"; }
        if(SC103.value=='N'||SC103.value=='n'||SC103.value=='1'||SC103.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC103").value = "0"; }
        if(SC104.value=='N'||SC104.value=='n'||SC104.value=='1'||SC104.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC104").value = "0"; }
        if(SC105.value=='N'||SC105.value=='n'||SC105.value=='1'||SC105.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC105").value = "0"; }
        if(SC106.value=='N'||SC106.value=='n'||SC106.value=='1'||SC106.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC106").value = "0"; }
        if(SC107.value=='N'||SC107.value=='n'||SC107.value=='1'||SC107.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC107").value = "0"; }
        if(SC108.value=='N'||SC108.value=='n'||SC108.value=='1'||SC108.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC108").value = "0"; }
        if(SC109.value=='N'||SC109.value=='n'||SC109.value=='1'||SC109.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC109").value = "0"; }
        if(SC111.value=='N'||SC111.value=='n'||SC111.value=='1'||SC111.value=='0'||NA11.value=='N'){  }else{ document.getElementById("SC111").value = "0"; }
        if(SC112.value=='N'||SC112.value=='n'||SC112.value=='1'||SC112.value=='0'||NA11.value=='N'){  }else{ document.getElementById("SC112").value = "0"; }
        if(SC113.value=='N'||SC113.value=='n'||SC113.value=='1'||SC113.value=='0'||NA11.value=='N'){  }else{ document.getElementById("SC113").value = "0"; }
        if(SC114.value=='N'||SC114.value=='n'||SC114.value=='1'||SC114.value=='0'||NA11.value=='N'){  }else{ document.getElementById("SC114").value = "0"; }
        if(SC115.value=='N'||SC115.value=='n'||SC115.value=='1'||SC115.value=='0'||NA11.value=='N'){  }else{ document.getElementById("SC115").value = "0"; }
        if(SC116.value=='N'||SC116.value=='n'||SC116.value=='1'||SC116.value=='0'||NA11.value=='N'){  }else{ document.getElementById("SC116").value = "0"; }
        if(SC117.value=='N'||SC117.value=='n'||SC117.value=='1'||SC117.value=='0'||NA11.value=='N'){  }else{ document.getElementById("SC117").value = "0"; }
        if(SC118.value=='N'||SC118.value=='n'||SC118.value=='1'||SC118.value=='0'||NA11.value=='N'){  }else{ document.getElementById("SC118").value = "0"; }
        if(SC119.value=='N'||SC119.value=='n'||SC119.value=='1'||SC119.value=='0'||NA11.value=='N'){  }else{ document.getElementById("SC119").value = "0"; }
        if(SC121.value=='N'||SC121.value=='n'||SC121.value=='1'||SC121.value=='0'){  }else{ document.getElementById("SC121").value = "0"; }
        if(SC122.value=='N'||SC122.value=='n'||SC122.value=='1'||SC122.value=='0'){  }else{ document.getElementById("SC122").value = "0"; }
        if(SC123.value=='N'||SC123.value=='n'||SC123.value=='1'||SC123.value=='0'){  }else{ document.getElementById("SC123").value = "0"; }
        if(SC124.value=='N'||SC124.value=='n'||SC124.value=='1'||SC124.value=='0'){  }else{ document.getElementById("SC124").value = "0"; }
        if(SC125.value=='N'||SC125.value=='n'||SC125.value=='1'||SC125.value=='0'){  }else{ document.getElementById("SC125").value = "0"; }
        if(SC126.value=='N'||SC126.value=='n'||SC126.value=='1'||SC126.value=='0'){  }else{ document.getElementById("SC126").value = "0"; }
        if(SC127.value=='N'||SC127.value=='n'||SC127.value=='1'||SC127.value=='0'){  }else{ document.getElementById("SC127").value = "0"; }
        if(SC128.value=='N'||SC128.value=='n'||SC128.value=='1'||SC128.value=='0'){  }else{ document.getElementById("SC128").value = "0"; }
        if(SC129.value=='N'||SC129.value=='n'||SC129.value=='1'||SC129.value=='0'){  }else{ document.getElementById("SC129").value = "0"; }
        if(DEC12.value=='1'||DEC12.value=='0'){  }else{ document.getElementById("DEC12").value = "0"; }
}

function getState() {
        var str='';
        var val=document.getElementById('deptid');
		
        for (i=0;i< val.length;i++) { 
            if(val[i].selected){
                str += val[i].value + ','; 
            }
        }         
        var str=str.slice(0,str.length -1);

        $.ajax({          
                        type: "GET",
                        url: "get_state.php",
                        data: 'deptid='+str,
                        success: function(data){
                                $("#subdeptid").html(data);
                        }
        });
}
</script>

</h5>
</td></tr></tbody></table>
<table class="tbinsipd">
  <tbody><tr>
    <th>Content of medical record</th>
    <th>NA (N)</th> 
    <th>Miss (M)</th>
    <th>No (O)</th>
    <th>ข้อที่ 1</th>
    <th>ข้อที่ 2</th>
    <th>ข้อที่ 3</th>
    <th>ข้อที่ 4</th>
    <th>ข้อที่ 5</th>
    <th>ข้อที่ 6</th>
    <th>ข้อที่ 7</th>
    <th>ข้อที่ 8</th>
    <th>ข้อที่ 9</th>
    <th>หักคะแนน</th>
  </tr>
  <tr>
	<td class="left"><font> Discharge summary : Dx, Op </font></td>
	<td><div><input name="NA01" type="text" id="NA01" size="1" maxlength="1" value="-" readonly="" autocomplete="off"></div></td>
	<td><div data-tip="กรอก M เมื่อไม่มีเอกสารให้ตรวจสอบ"><input onchange="handleMI01Chk(this)" name="MI01" type="text" id="MI01" size="1" maxlength="1" value="-" tabindex="40" autocomplete="off"></div></td>
	<td><input name="NO01" type="text" id="NO01" size="1" maxlength="1" value="-" onchange="handleNO01Chk(this)" autocomplete="off"></td>
	<td><div data-tip="Pdx ถูกต้องตรงกับเวชระเบียน"><input name="SC011" type="text" id="SC011" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="โรคร่วม โรคแทรก สาเหตุบาดเจ็บ External cause ถูกต้อง/ครบถ้วน"><input name="SC012" type="text" id="SC012" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="Proc/Op ถูกต้องครบถ้วน (ไม่มี proc หรือ op ให้ 1 คะแนน)"><input name="SC013" type="text" id="SC013" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ว.ด.ป. เริ่มต้น สิ้นสุด op .ใน or ,ทุกครั้ง(ไม่มี op ใน or ให้ 1 คะแนน"><input name="SC014" type="text" id="SC014" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ไม่ใช้ตัวย่อใน Pdx cc, proc,op และลายมืออ่านออก"><input name="SC015" type="text" id="SC015" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="Clinical summary: ปัญหาแรกรับ investigate การรักษา/ผลการรักษา ฟื้นฟู Home med"><input name="SC016" type="text" id="SC016" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="สรุปสาเหตุการตายถูกต้อง(ptไม่ตายให้ NA)"><input name="SC017" type="text" id="SC017" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="D/C status,Type ถูกต้อง กรณี D/C transfer ระบุสถานพยาบาลส่งต่อ"><input name="SC018" type="text" id="SC018" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ลายมือชื่อแพทย์ผู้รักษาหรือผู้สรุป ระบุชื่อ-สกุลและเลข ว "><input name="SC019" type="text" id="SC019" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
	<td><div><input name="DEC01" type="text" id="DEC01" size="1" maxlength="1" value="0" tabindex="200" readonly="" autocomplete="off"></div></td>
 </tr>
  <tr>
	<td class="left"><font> Discharge summary : Other </font></td>
	<td><div><input name="NA02" type="text" id="NA02" size="1" maxlength="1" value="-" readonly="" autocomplete="off"></div></td>
	<td><div data-tip="กรอก M เมื่อไม่มีเอกสารให้ตรวจสอบ"><input onchange="handleMI02Chk(this)" name="MI02" type="text" id="MI02" size="1" maxlength="1" value="-" tabindex="41" autocomplete="off"></div></td>
	<td><input name="NO02" type="text" id="NO02" size="1" maxlength="1" value="-" onchange="handleNO02Chk(this)" autocomplete="off"></td>
	<td><div data-tip="ชื่อ-สกุล เพศ อายุptถูกต้อง(ไม่ทราบว่าเป็นใครและสืบค้นไม่ได้ให้ 1 คะแนน)"><input name="SC021" type="text" id="SC021" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="เลข 13 หลัก, เลขต่างด้าว, ไม่มีเลขที่บัตร/ไม่รู้สึกตัว/เสียชีวิตและไม่พบหลักฐาน(ให้ระบุ)"><input name="SC022" type="text" id="SC022" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="มีที่อยู่ปัจจุบัน pt ไม่รู้สึกตัว/เสียชีวิตและไม่พบหลักฐาน(ให้ระบุ)"><input name="SC023" type="text" id="SC023" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ชื่อ รพ. HN AN ถูกต้องตรงทุกแห่ง"><input name="SC024" type="text" id="SC024" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ว.ด.ป. เวลาที่ admit และ D/C ตรงกับเวชระเบียน"><input name="SC025" type="text" id="SC025" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="จำนวนวันนอน รพ. จำนวนวันลากลับบ้านถูกต้อง"><input name="SC026" type="text" id="SC026" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ชื่อ-สกุลผู้ให้รหัส โรคและหัตถการ"><input name="SC027" type="text" id="SC027" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div><input name="SC028" type="text" id="SC028" size="1" maxlength="1" tabindex="103" value="N" readonly="" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div><input name="SC029" type="text" id="SC029" size="1" maxlength="1" tabindex="103" value="N" readonly="" onchange="handleSCChk(this)" autocomplete="off"></div></td>
	<td><div><input name="DEC02" type="text" id="DEC02" size="1" maxlength="1" value="0" readonly="" autocomplete="off"></div></td>
 </tr>
  <tr>
	<td class="left"><font> Informed consent </font></td>
	<td><div><input name="NA03" type="text" id="NA03" size="1" maxlength="1" value="-" readonly="" autocomplete="off"></div></td>
	<td><div data-tip="กรอก M เมื่อไม่มีเอกสารให้ตรวจสอบ"><input onchange="handleMI03Chk(this)" name="MI03" type="text" id="MI03" size="1" maxlength="1" value="-" tabindex="42" autocomplete="off"></div></td>
	<td><input name="NO03" type="text" id="NO03" size="1" maxlength="1" value="-" onchange="handleNO03Chk(this)" autocomplete="off"></td>
	<td><div data-tip="ชื่อ-สกุล pt ถูกต้อง"><input name="SC031" type="text" id="SC031" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ลายมือชื่อผู้ให้คำอธิบาย(ชื่อ-สกุล ตำแหน่ง) เกี่ยวกับการรักษา"><input name="SC032" type="text" id="SC032" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ลายมือชื่อ-สกุล ผู้รับทราบข้อมูลและยินยอมรักษาฯ กรณี <18 ปี หรือสติไม่ดีให้ระบุ ชื่อ-สกุล คสพ."><input name="SC033" type="text" id="SC033" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ลายมือ/ลายพิมพ์นิ้วมือพยานฝ่าย pt 1 คน ชื่อ-สกุล คสพ.ชัดเจน(ถ้ามาคนเดียวให้ระบุ)"><input name="SC034" type="text" id="SC034" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ลายมือชื่อพยานฝ่าย จนท รพ.1คน ชื่อ-สกุล ตำแหน่ง(ไม่เป็นคนเดียวกับผู้ให้คำอธิบาย)"><input name="SC035" type="text" id="SC035" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="เหตุผลเข้ารักษา วิธีการรักษา/หัตถการ การให้ยาระงับความรู้สึกที่แจ้งแก่ pt และญาติ"><input name="SC036" type="text" id="SC036" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ทางเลือก ข้อดี ข้อเสีย ของทางเลือกการรักษาที่แจ้งแก่ pt และญาติรับทราบ"><input name="SC037" type="text" id="SC037" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ระยะเวลารักษา ผลการรักษา ความเสี่ยงภาวะแทรกซ้อน"><input name="SC038" type="text" id="SC038" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ว.ด.ป. และเวลาที่รับทราบและยินยอมรักษา"><input name="SC039" type="text" id="SC039" size="1" maxlength="1" tabindex="103" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
	<td><div><input name="DEC03" type="text" id="DEC03" size="1" maxlength="1" value="0" readonly="" autocomplete="off"></div></td>
 </tr>
  <tr>
	<td class="left"><font> History </font></td>
	<td><div><input name="NA04" type="text" id="NA04" size="1" maxlength="1" value="-" readonly="" autocomplete="off"></div></td>
	<td><div data-tip="กรอก M เมื่อไม่มีเอกสารให้ตรวจสอบ"><input onchange="handleMI04Chk(this)" name="MI04" type="text" id="MI04" size="1" maxlength="1" value="-" tabindex="43" autocomplete="off"></div></td>
	<td><input name="NO04" type="text" id="NO04" size="1" maxlength="1" value="-" onchange="handleNO04Chk(this)" autocomplete="off"></td>
    <td><div data-tip="chief complaint; อาการและระยะเวลาที่มา รพ."><input name="SC041" type="text" id="SC041" size="1" maxlength="1" tabindex="104" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="Present illiness 5W 2H (what where when why who how,howmany (อย่างน้อย 3ข้อ)"><input name="SC042" type="text" id="SC042" size="1" maxlength="1" tabindex="104" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="Prssent illiness ส่วนที่รักษาที่รักษาที่ได้แล้วประวัติรักษาที่ผ่านมา(ไม่รักษาที่ใด)"><input name="SC043" type="text" id="SC043" size="1" maxlength="1" tabindex="104" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="past illiness ที่สำคัญและเกี่ยวกับปัญหาที่มา กรณีไม่มี past iliness ระบุ(ไม่มี)"><input name="SC044" type="text" id="SC044" size="1" maxlength="1" tabindex="104" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ประวัติแพ้ยาและอื่นๆ ชื่อยาสิ่งที่แพ้ (ไม่ทราบ/ไม่มีประวัติแพ้ ให้ระบุ)"><input name="SC045" type="text" id="SC045" size="1" maxlength="1" tabindex="104" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ประวัติอื่นๆ family,personal,Social,Mens(11-60 ปี)Vaccine,Growth(0-14 ปี)ต้องบันทึก"><input name="SC046" type="text" id="SC046" size="1" maxlength="1" tabindex="104" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ซักประวัติเจ็บป่วยระบบอื่นๆ (review system)ทุกระบบ"><input name="SC047" type="text" id="SC047" size="1" maxlength="1" tabindex="104" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ลายมืออ่านออก ลายชื่อแพทย์ระบุได้ว่าเป็นผู้ใด"><input name="SC048" type="text" id="SC048" size="1" maxlength="1" tabindex="104" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="แหล่งที่มาของข้อมูลประวัติจาก pt"><input name="SC049" type="text" id="SC049" size="1" maxlength="1" tabindex="104" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
	<td><div><input name="DEC04" type="text" id="DEC04" size="1" maxlength="1" value="0" readonly="" autocomplete="off"></div></td>
 </tr>
  <tr>
	<td class="left"><font> Physical examination </font></td>
	<td><div><input name="NA05" type="text" id="NA05" size="1" maxlength="1" value="-" readonly="" autocomplete="off"></div></td>
	<td><div data-tip="กรอก M เมื่อไม่มีเอกสารให้ตรวจสอบ"><input onchange="handleMI05Chk(this)" name="MI05" type="text" id="MI05" size="1" maxlength="1" value="-" tabindex="44" autocomplete="off"></div></td>
	<td><input name="NO05" type="text" id="NO05" size="1" maxlength="1" value="-" onchange="handleNO05Chk(this)" autocomplete="off"></td>
	<td><div data-tip="T P R และ BP (BP ยกเว้น <3 ปี)"><input name="SC051" type="text" id="SC051" size="1" maxlength="1" tabindex="105" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="มี นน.ทุกราย,ส่วนสูง(เด็กทุกราย),ผู้ใหญ่กรณีหา BMI Body Surface Area รายที่ให้เคมี"><input name="SC052" type="text" id="SC052" size="1" maxlength="1" tabindex="105" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ดู คลำ เคาะ ฟัง สอดคล้องกับ chief complaint"><input name="SC053" type="text" id="SC053" size="1" maxlength="1" tabindex="105" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="วาดรูปหรือกราฟฟิกสิ่งที่ตรวจพบความผิดปกติที่ถูกต้อง(กรณีปกติ ต้องได้คะแนนข้อ3"><input name="SC054" type="text" id="SC054" size="1" maxlength="1" tabindex="105" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ตรวจร่างกายทุกระบบ"><input name="SC055" type="text" id="SC055" size="1" maxlength="1" tabindex="105" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="สรุปปัญหา pt ที่รักษาครั้งนี้(Problem list)"><input name="SC056" type="text" id="SC056" size="1" maxlength="1" tabindex="105" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="สรุปวินิจฉัยขั้นต้นสอดคล้องประวัติผลการตรวจร่างกาย"><input name="SC057" type="text" id="SC057" size="1" maxlength="1" tabindex="105" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="แผนการรักษาใน admit ครั้งนี้ (บันทึก admit ถือว่าไม่ผ่านเกณฑ์)"><input name="SC058" type="text" id="SC058" size="1" maxlength="1" tabindex="105" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ลายมืออ่านออกชื่อแพทย์ที่ตรวจร่างกายระบุได่ว่าเป็นผู้ใด"><input name="SC059" type="text" id="SC059" size="1" maxlength="1" tabindex="105" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
	<td><div><input name="DEC05" type="text" id="DEC05" size="1" maxlength="1" value="0" readonly="" autocomplete="off"></div></td>
 </tr>
  <tr>
	<td class="left"><font> Progress note </font></td>
	<td><div><input name="NA06" type="text" id="NA06" size="1" maxlength="1" value="-" readonly="" autocomplete="off"></div></td>
	<td><div data-tip="กรอก M เมื่อไม่มีเอกสารให้ตรวจสอบ"><input onchange="handleMI06Chk(this)" name="MI06" type="text" id="MI06" size="1" maxlength="1" value="-" tabindex="45" autocomplete="off"></div></td>
	<td><input name="NO06" type="text" id="NO06" size="1" maxlength="1" value="-" onchange="handleNO06Chk(this)" autocomplete="off"></td>
	<td><div data-tip="ว.ด.ป. และเวลาทุกครั้งที่บันทึก"><input name="SC061" type="text" id="SC061" size="1" maxlength="1" tabindex="106" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="บันทึกทุก 3 วันแรก"><input name="SC062" type="text" id="SC062" size="1" maxlength="1" tabindex="106" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="เนื้อหาครอบคลุม soap ใน3 วันแรก"><input name="SC063" type="text" id="SC063" size="1" maxlength="1" tabindex="106" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="บันทึกทุกครั้งที่มีการเปลี่ยนแปลงแพทย์ผู้ดูแล/รักษาให้ยา/หัตถการ"><input name="SC064" type="text" id="SC064" size="1" maxlength="1" tabindex="106" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="บันทึกเนื้อหา SOAP ทุกครั้งที่มีการเปลี่ยนแปลงแพทย์ผู้รักษา/ให้ยา/หัตถการ"><input name="SC065" type="text" id="SC065" size="1" maxlength="1" tabindex="106" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="แปลผล investigation ที่สำคัญและวินิจฉัยร่วมกับการรักษา เมื่อ investigate ผิดปกติ"><input name="SC066" type="text" id="SC066" size="1" maxlength="1" tabindex="106" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="บันทึก Progress note ตรงตำแหน่งที่หน่วยบริการ กำหนดให้บันทึก"><input name="SC067" type="text" id="SC067" size="1" maxlength="1" tabindex="106" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ลายมืออ่านออก ลายชื่อแพทย์ที่บันทึก Progress note"><input name="SC068" type="text" id="SC068" size="1" maxlength="1" tabindex="106" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ว.ด.ป. และเวลาพร้อมลงนามกำกับในใบคำสั่งการรักษาทุกครั้ง"><input name="SC069" type="text" id="SC069" size="1" maxlength="1" tabindex="106" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
	<td><div><input name="DEC06" type="text" id="DEC06" size="1" maxlength="1" value="0" readonly="" autocomplete="off"></div></td>
 </tr>
  <tr>
	<td class="left"><font> Consultation record </font></td>
	<td><div data-tip="กรอก N เมื่อไม่จำเป็นต้องมีการบันทึก"><input onchange="handleNA07Chk(this)" name="NA07" type="text" id="NA07" size="1" maxlength="1" value="N" tabindex="26" autocomplete="off"></div></td>
	<td><div data-tip="กรอก M เมื่อไม่มีเอกสารให้ตรวจสอบ"><input onchange="handleMI07Chk(this)" name="MI07" type="text" id="MI07" size="1" maxlength="1" value="-" tabindex="46" autocomplete="off" readonly="readonly"></div></td>
	<td><input name="NO07" type="text" id="NO07" size="1" maxlength="1" value="-" onchange="handleNO07Chk(this)" autocomplete="off" readonly="readonly"></td>
	<td><div data-tip="ว.ด.ป. และเวลาความจำเป็นเร่งด่วนและหน่วยงานที่ขอปรึกษา"><input name="SC071" type="text" id="SC071" size="1" maxlength="1" tabindex="107" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="บันทึกขอปรึกษาระบุปัญหาที่ต้องการปรึกษาชัดเจน"><input name="SC072" type="text" id="SC072" size="1" maxlength="1" tabindex="107" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="ประวัติตรวจร่างกายและการรักษาโดยย่อของแพทย์ผู้ขอปรึกษา"><input name="SC073" type="text" id="SC073" size="1" maxlength="1" tabindex="107" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="ลายมืออ่านออก(ไม่มีลายมือชื่อแพทย์ผู้ขอปรึกษาไม่ได้คะแนนเกณฑ์ข้อ1-4)"><input name="SC074" type="text" id="SC074" size="1" maxlength="1" tabindex="107" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="บันทึกผลตรวจ ประเมินเพิ่มเติมคำวินิจฉัยของผู้รับปรึกษา"><input name="SC075" type="text" id="SC075" size="1" maxlength="1" tabindex="107" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="บันทึกความเห็น แผนการรักษา คำแนะนำ"><input name="SC076" type="text" id="SC076" size="1" maxlength="1" tabindex="107" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="ว.ด.ป.และเวลาที่ผู้รับปรึกษามาตรวจผู้ป่วย"><input name="SC077" type="text" id="SC077" size="1" maxlength="1" tabindex="107" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="ลายมืออ่านออก(ไม่มีลายมือชื่อแพทย์ไม่ได้คะแนนข้อ 5,8)"><input name="SC078" type="text" id="SC078" size="1" maxlength="1" tabindex="107" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="แพทย์ผู้รับปรึกษาบันทึกผลให้คำปรึกษาตรงตำแหน่ง"><input name="SC079" type="text" id="SC079" size="1" maxlength="1" tabindex="107" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
	<td><div><input name="DEC07" type="text" id="DEC07" size="1" maxlength="1" value="0" readonly="" autocomplete="off"></div></td>
 </tr>
 <tr>
 <td class="left"><font> Consultation recordxxx </font></td>
            <td><?= $form->field($model, 'NA7')->textInput(['id'=>'NA7','size'=>1,'maxlength' => 1, 'onchange'=>'handleNA7Chk(this)','value'=>'N' ,'autocomplete'=> 'off'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing7')->textInput(['size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMissing7Chk(this)','autocomplete'=> 'off'])->label(false) ?></td>
            <td><?= $form->field($model, 'No7')->textInput(['size'=>1,'id'=>'NO7','size'=>1,'maxlength' => 1, 'onchange'=>'handleNO7Chk(this)','value'=>'-'])->label(false) ?></td>
            <td> <?= $form->field($model, 'cr1')->textInput(['id'=>"cr1",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSC1Chk(this)','autocomplete'=>'off'])->label(false) ?></td>
            <td> <?= $form->field($model, 'cr2')->textInput(['id'=>'cr2','size'=>1,'maxlength' => 1, 'onchange'=>'handleSC1Chk(this)','autocomplete'=> 'off'])->label(false) ?></td>
            <td> <?= $form->field($model, 'cr3')->textInput(['id'=>'cr3','size'=>1,'maxlength' => 1, 'onchange'=>'handleSC1Chk(this)','autocomplete'=> 'off'])->label(false) ?></td>
            <td> <?= $form->field($model, 'cr4')->textInput(['id'=>'cr4','size'=>1,'maxlength' => 1, 'onchange'=>'handleSC1Chk(this)','autocomplete'=> 'off'])->label(false) ?></td>
            <td> <?= $form->field($model, 'cr5')->textInput(['id'=>'cr5','size'=>1,'maxlength' => 1, 'onchange'=>'handleSC1Chk(this)','autocomplete'=> 'off'])->label(false) ?></td>
            <td> <?= $form->field($model, 'cr6')->textInput(['id'=>'cr6','size'=>1,'maxlength' => 1, 'onchange'=>'handleSC1Chk(this)','autocomplete'=> 'off'])->label(false) ?></td>
            <td> <?= $form->field($model, 'cr7')->textInput(['id'=>'cr7','size'=>1,'maxlength' => 1, 'onchange'=>'handleSC1Chk(this)','autocomplete'=> 'off'])->label(false) ?></td>
            <td> <?= $form->field($model, 'cr8')->textInput(['id'=>'cr8','size'=>1,'maxlength' => 1, 'onchange'=>'handleSC1Chk(this)','autocomplete'=> 'off'])->label(false) ?></td>
            <td> <?= $form->field($model, 'cr9')->textInput(['id'=>'cr9','size'=>1,'maxlength' => 1, 'onchange'=>'handleSC1Chk(this)','autocomplete'=> 'off'])->label(false) ?></td>
            <td><?= $form->field($model, 'cr_huk')->textInput(['size'=>1,'maxlength' => 1,'value'=>'0'])->label(false) ?></td>
  </tr>
  <tr>
	<td class="left"><font> Anaesthetic record </font></td>
	<td><div data-tip="กรอก N เมื่อไม่จำเป็นต้องมีการบันทึก"><input onchange="handleNA08Chk(this)" name="NA08" type="text" id="NA08" size="1" maxlength="1" value="N" tabindex="27" autocomplete="off"></div></td>
	<td><div data-tip="กรอก M เมื่อไม่มีเอกสารให้ตรวจสอบ"><input onchange="handleMI08Chk(this)" name="MI08" type="text" id="MI08" size="1" maxlength="1" value="-" tabindex="47" autocomplete="off" readonly="readonly"></div></td>
	<td><input name="NO08" type="text" id="NO08" size="1" maxlength="1" value="-" onchange="handleNO08Chk(this)" autocomplete="off" readonly="readonly"></td>
	<td><div data-tip="บันทึก Status pt ก่อนให้ยาระงับความรู้สึกและวิธีให้ยา"><input name="SC081" type="text" id="SC081" size="1" maxlength="1" tabindex="108" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="บันทึกโรคก่อนผ่าตัดสอดคล้องวินิจฉัย(ข้อมูลขัดแย้ง= ไม่ผ่านเกณฑ์)"><input name="SC082" type="text" id="SC082" size="1" maxlength="1" tabindex="108" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="บันทึกชนิดและชื่อการผ่าตัดสอดคล้องกับการผ่าตัด(ข้อมูลขัดแย้ง=ไม่ผ่านเกณฑ์)"><input name="SC083" type="text" id="SC083" size="1" maxlength="1" tabindex="108" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="บันทึกก่อนผ่าตัดอย่างน้อย 1 วัน (Pre anesthetic Round) โดยทีมวิสัญญี"><input name="SC084" type="text" id="SC084" size="1" maxlength="1" tabindex="108" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="V/S และบันทึกติดตามการเฝ้าระวังระหว่างยาดมทุก 5 นาที"><input name="SC085" type="text" id="SC085" size="1" maxlength="1" tabindex="108" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="intake,Output blood loss,Total intake และ Total output"><input name="SC086" type="text" id="SC086" size="1" maxlength="1" tabindex="108" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="บันทึกหลังสิ้นสุดผ่าตัด 1 ชั่วโมง (Recovery room) โดยทีมวิสัญญี"><input name="SC087" type="text" id="SC087" size="1" maxlength="1" tabindex="108" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="บันทึกดูแลหลังผ่าตัด 24 hrs"><input name="SC088" type="text" id="SC088" size="1" maxlength="1" tabindex="108" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="ลายมืออ่านออกและระบุทีมวิสัญญี"><input name="SC089" type="text" id="SC089" size="1" maxlength="1" tabindex="108" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
	<td><div><input name="DEC08" type="text" id="DEC08" size="1" maxlength="1" value="0" readonly="" autocomplete="off"></div></td>
 </tr>
  <tr>
	<td class="left"><font> Operative note </font></td>
	<td><div data-tip="กรอก N เมื่อไม่จำเป็นต้องมีการบันทึก"><input onchange="handleNA09Chk(this)" name="NA09" type="text" id="NA09" size="1" maxlength="1" value="N" tabindex="28" autocomplete="off"></div></td>
	<td><div data-tip="กรอก M เมื่อไม่มีเอกสารให้ตรวจสอบ"><input onchange="handleMI09Chk(this)" name="MI09" type="text" id="MI09" size="1" maxlength="1" value="-" tabindex="48" autocomplete="off" readonly="readonly"></div></td>
	<td><input name="NO09" type="text" id="NO09" size="1" maxlength="1" value="-" onchange="handleNO09Chk(this)" autocomplete="off" readonly="readonly"></td>
	<td><div data-tip="ข้อมูลผู้ป่วยถูกต้อง ครบถ้วน ชื่อ-สกุล อายุ HN AN เป็นต้น"><input name="SC091" type="text" id="SC091" size="1" maxlength="1" tabindex="109" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="บันทึก Dx ก่อนและหลังการทำหัตถการ ไม่ใช้(same,ปีกกา,-)"><input name="SC092" type="text" id="SC092" size="1" maxlength="1" tabindex="109" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="บันทึกชื่อการทำหัตถการถูกต้อง ครบถ้วน"><input name="SC093" type="text" id="SC093" size="1" maxlength="1" tabindex="109" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="บันทึกรายละเอียดสิ่งที่พบสอดคล้องกับ post op Dx"><input name="SC094" type="text" id="SC094" size="1" maxlength="1" tabindex="109" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="บันทึกวิธีการทำหัตถการ: Position,incision สิ่งที่ตัดออกรวมส่งชิ้นเนื้อเพื่อตรวจ(ถ้ามี)"><input name="SC095" type="text" id="SC095" size="1" maxlength="1" tabindex="109" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="บันทึกภาวะแทรกซ้อนและจำนวนเลือดที่สูญเสียระหว่างผ่าตัด กรณีไม่มีระบุ(ไม่มี)"><input name="SC096" type="text" id="SC096" size="1" maxlength="1" tabindex="109" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="บันทึกวันเวลา ที่เริ่มต้นและสิ้นสุดการทำหัตถการ"><input name="SC097" type="text" id="SC097" size="1" maxlength="1" tabindex="109" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="บันทึกชื่อคณะผู้ร่วมทำหัตถการ"><input name="SC098" type="text" id="SC098" size="1" maxlength="1" tabindex="109" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="บันทึกลายมืออ่านออกและลงลายมือชื่อ Dr(ระบุได้ว่าเป็นผู้ใด)"><input name="SC099" type="text" id="SC099" size="1" maxlength="1" tabindex="109" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
	<td><div><input name="DEC09" type="text" id="DEC09" size="1" maxlength="1" value="0" tabindex="201" readonly="" autocomplete="off"></div></td>
 </tr>
  <tr>
	<td class="left"><font> Labour record </font></td>
	<td><div data-tip="กรอก N เมื่อไม่จำเป็นต้องมีการบันทึก"><input onchange="handleNA10Chk(this)" name="NA10" type="text" id="NA10" size="1" maxlength="1" value="N" tabindex="29" autocomplete="off"></div></td>
	<td><div data-tip="กรอก M เมื่อไม่มีเอกสารให้ตรวจสอบ"><input onchange="handleMI10Chk(this)" name="MI10" type="text" id="MI10" size="1" maxlength="1" value="-" tabindex="49" autocomplete="off" readonly="readonly"></div></td>
	<td><input name="NO10" type="text" id="NO10" size="1" maxlength="1" value="-" onchange="handleNO10Chk(this)" autocomplete="off" readonly="readonly"></td>
	<td><div data-tip="ประเมินแรกรับ:ประวัติ GPAL,LMP,EDC,Gestation Age,ประวัติ ANC,complication,Risk,monitoring"><input name="SC101" type="text" id="SC101" size="1" maxlength="1" tabindex="110" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="ประเมินผู้คลอด ระยะรอคลอด,ว ด ป,เวลา,ชีพจร,BP,Progress Labour,Fetal assesment,complication"><input name="SC102" type="text" id="SC102" size="1" maxlength="1" tabindex="110" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="วันที่,ระยะเวลาการคลอตแต่ละ stage(กรณี elective C/S ไม่ต้องประเมินให้ 1 คะแนน"><input name="SC103" type="text" id="SC103" size="1" maxlength="1" tabindex="110" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="บันทึกหัตถการวิธีการคลอด, ภาวะแทรกซ้อนและการระงับความรู้สึก(ถ้ามี)Episiotomy ตามสภาพ"><input name="SC104" type="text" id="SC104" size="1" maxlength="1" tabindex="110" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="บันทึกคำสั่งและบันทึกการให้ยาในระยะก่อน ระหว่างและหลังคลอด"><input name="SC105" type="text" id="SC105" size="1" maxlength="1" tabindex="110" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="บันทึก ว.ด.ป. เวลาที่ทารก เพศ นน.และความยาวของทารก"><input name="SC106" type="text" id="SC106" size="1" maxlength="1" tabindex="110" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="ประเมินมารดาระยะหลังคลอด:Placenta check,complication,blood loss,V/S"><input name="SC107" type="text" id="SC107" size="1" maxlength="1" tabindex="110" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="Apgar score(1นาที 5นาทีและ10 นาที)"><input name="SC108" type="text" id="SC108" size="1" maxlength="1" tabindex="110" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="ลายมือที่อ่านออกและลายมือชื่อDrหรือพยาบาลผู้ทำคลอด"><input name="SC109" type="text" id="SC109" size="1" maxlength="1" tabindex="110" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
	<td><div><input name="DEC10" type="text" id="DEC10" size="1" maxlength="1" value="0" readonly="" autocomplete="off"></div></td>
 </tr>
  <tr>
	<td class="left"><font> Rehabilitation record </font></td>
	<td><div data-tip="กรอก N เมื่อไม่จำเป็นต้องมีการบันทึก"><input onchange="handleNA11Chk(this)" name="NA11" type="text" id="NA11" size="1" maxlength="1" value="N" tabindex="30" autocomplete="off"></div></td>
	<td><div data-tip="กรอก M เมื่อไม่มีเอกสารให้ตรวจสอบ"><input onchange="handleMI11Chk(this)" name="MI11" type="text" id="MI11" size="1" maxlength="1" value="-" tabindex="50" autocomplete="off" readonly="readonly"></div></td>
	<td><input name="NO11" type="text" id="NO11" size="1" maxlength="1" value="-" onchange="handleNO11Chk(this)" autocomplete="off" readonly="readonly"></td>
	<td><div data-tip="ซักประวัติอาการสำคัญ ประวัติปัจจุบันและอดีตที่เกี่ยวข้องกับปัญหา"><input name="SC111" type="text" id="SC111" size="1" maxlength="1" tabindex="111" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="ตรวจร่างกายที่เกี่ยวข้องกับปัญหาที่ต้องการฟื้นฟู"><input name="SC112" type="text" id="SC112" size="1" maxlength="1" tabindex="111" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="Dxหรือ Dxทางกายภาพบำบัดและสรุปปัญหาที่ต้องการฟื้นฟูฯ"><input name="SC113" type="text" id="SC113" size="1" maxlength="1" tabindex="111" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="เป้าหมายที่ต้องการฟื้นฟูฯการวางแผนชนิดการบำบัดหรือหัตถการ ข้อห้ามและข้อควรระวัง"><input name="SC114" type="text" id="SC114" size="1" maxlength="1" tabindex="111" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="การรักษาที่ให้ในแต่ละครั้ง ระบุอวัยวะหรือตำแหน่งที่บำบัดและเวลาที่ใช้"><input name="SC115" type="text" id="SC115" size="1" maxlength="1" tabindex="111" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="ประเมินผลการให้บริการและความก้าวหน้าการฟื้นฟูฯ"><input name="SC116" type="text" id="SC116" size="1" maxlength="1" tabindex="111" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="สรุปผลการให้บริการฟื้นฟูฯและแผนจำหน่าย"><input name="SC117" type="text" id="SC117" size="1" maxlength="1" tabindex="111" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="การให้ home program"><input name="SC118" type="text" id="SC118" size="1" maxlength="1" tabindex="111" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
    <td><div data-tip="ลายมือที่อ่านออกและลายมือแพทย์เวชศาสตร์ฟื้นฟูและนักกายฯ"><input name="SC119" type="text" id="SC119" size="1" maxlength="1" tabindex="111" onchange="handleSCChk(this)" autocomplete="off" readonly="readonly"></div></td>
	<td><div><input name="DEC11" type="text" id="DEC11" size="1" maxlength="1" value="0" readonly="" autocomplete="off"></div></td>
 </tr>
  <tr>
	<td class="left"><font> Nurses' note helpful </font></td>
	<td><div><input name="NA12" type="text" id="NA12" size="1" maxlength="1" value="-" readonly="" autocomplete="off"></div></td>
	<td><div data-tip="กรอก M เมื่อไม่มีเอกสารให้ตรวจสอบ"><input onchange="handleMI12Chk(this)" name="MI12" type="text" id="MI12" size="1" maxlength="1" value="-" tabindex="51" autocomplete="off"></div></td>
	<td><input onchange="handleNO12Chk(this)" name="NO12" type="text" id="NO12" size="1" maxlength="1" value="-" autocomplete="off"></td>
	<td><div data-tip="ประเมินแรกรับ:อาการสำคัญ ระยะเวลาที่เกิดอาการประวัติเจ็บป่วยปัจจุบันและอดีตอาการแรกรับระบุปัญหาตามสภาพ"><input name="SC121" type="text" id="SC121" size="1" maxlength="1" tabindex="121" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ปัญหาทางการพยาบาลสอดคล้องกับอาการแสดงด้านร่างกาย จิตใจ อารมณ์ สังคม จิตวิญญาณ ตั้งแต่แรกรับถึงจำหน่าย"><input name="SC122" type="text" id="SC122" size="1" maxlength="1" tabindex="121" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="การพยาบาลและการดูแลกิจวัตรประจำวันและการประเมินซ้ำ เฝ้าระวังอาการหรือวัดV/sหรือ early detection"><input name="SC123" type="text" id="SC123" size="1" maxlength="1" tabindex="121" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="การตอบสนองการรักษาการเปลี่ยนแปลงของร่างกาย พฤติกรรมการรักษา ยา การให้เลือด หัตถการสำคัญ"><input name="SC124" type="text" id="SC124" size="1" maxlength="1" tabindex="121" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="การให้ข้อมูลระหว่างการดูแล ข้อมูลเจ็บป่วย คำปรึกษา แนะนำแก้ไขปัญหาสุขภาพอื่น"><input name="SC125" type="text" id="SC125" size="1" maxlength="1" tabindex="121" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="เตรียมพร้อมดูแลต่อเนื่องที่บ้าน อาการหรือปัญหาสำคัญที่ต้องได้ความรู้ฝึกทักษะและกิจกรรม"><input name="SC126" type="text" id="SC126" size="1" maxlength="1" tabindex="121" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="1)อาการแสดงผลก่อนจำหน่าย 2)กิจกรรมพยาบาล 3)ข้อมูลเพื่อส่งต่อ"><input name="SC127" type="text" id="SC127" size="1" maxlength="1" tabindex="121" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="การประสานการดูแลต่อเนื่อง, ระบุอาการที่รับส่งต่อทั้งในและนอก รพ."><input name="SC128" type="text" id="SC128" size="1" maxlength="1" tabindex="121" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="การบันทึกอ่านออกและลายมือชื่อผู้บันทึกอ่านออก"><input name="SC129" type="text" id="SC129" size="1" maxlength="1" tabindex="121" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
	<td><div data-tip="1)บันทึกไม่ต่อเนื่องทุกวัน 2) วัน เวลาไม่สอดคล้อง"><input onchange="handleMI12Chk(this)" name="DEC12" type="text" id="DEC12" size="1" maxlength="1" value="0" tabindex="202" autocomplete="off"></div></td>
 </tr>
 </tbody></table>
<!-- <table>
<tbody><tr>
<td class="a">
 <b><input type="submit" name="submit" value="บันทึก" style="width:50px;height:50px;font-weight:bold;" tabindex="999" autocomplete="off"></b>
<button class="bmain" type="button" style="width:100px;height:50px" tabindex="999"><strong>กลับเมนูหลัก</strong></button> 
</td>
 </tr>
</tbody></table> -->
</form>
<br>
<div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
 
<table class="table table-hover table-bordered dataTable table-info dataTable table-striped " id="datatable2">
    <thead>
        <tr style="font-size:14px; font-weight:bold" class="center">
            <td width="250" style="background-color: #ffd4c9;">โรงพยาบาล</td>
            <td width="140" style="background-color: #fbff9b;">HN</td>
            <td width="140" style="background-color: #fbff9b;">AN</td>
            <td width="140" style="background-color: #a5ffad;">คะแนนรวม</td>
            <td width="140" style="background-color: #d4e7f7;">คะแนนเต็ม</td>
            <td width="140" style="background-color: #ffd4c9;">%</td>
            <td width="140" style="background-color: #ffd4c9;">INT/EXT</td>
            <td width="140" style="background-color: #ffd4c9;">วันที่ Audit</td>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
</center>



<div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div></body>