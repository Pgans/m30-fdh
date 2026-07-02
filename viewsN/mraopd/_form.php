<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\datecontrol\DateControl;
use app\models\Mradepartmetnsopd;
use app\models\Mraoverall;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Mraopd */
/* @var $form yii\widgets\ActiveForm */
?>
<script language="javascript">
$(document).ready(function(){
handleChk();

function handleChk() {		
    if(NA05.value=='N'){
            $('#MI05').attr("readonly", "false");
            $('#SC051').attr("readonly", "false");
            $('#SC052').attr("readonly", "false");
            $('#SC053').attr("readonly", "false");
            $('#SC054').attr("readonly", "false");
            $('#SC055').attr("readonly", "false");
            $('#SC056').attr("readonly", "false");
            $('#SC057').attr("readonly", "false");
            $('#NO05').attr("readonly", "false");	
    }else{
            $('#MI05').attr("readonly", "true");
            $('#SC051').attr("readonly", "true");
            $('#SC052').attr("readonly", "true");
            $('#SC053').attr("readonly", "true");
            $('#SC054').attr("readonly", "true");
            $('#SC055').attr("readonly", "true");
            $('#SC056').attr("readonly", "true");
            $('#SC057').attr("readonly", "true");
            $('#NO05').attr("readonly", "true");	
    }
    if(NA06.value=='N'){
            $('#MI06').attr("readonly", "false");
            $('#SC061').attr("readonly", "false");
            $('#SC062').attr("readonly", "false");
            $('#SC063').attr("readonly", "false");
            $('#SC064').attr("readonly", "false");
            $('#SC065').attr("readonly", "false");
            $('#SC066').attr("readonly", "false");
            $('#SC067').attr("readonly", "false");
            $('#NO06').attr("readonly", "false");
    }else{
            $('#MI06').attr("readonly", "true");
            $('#SC061').attr("readonly", "true");
            $('#SC062').attr("readonly", "true");
            $('#SC063').attr("readonly", "true");
            $('#SC064').attr("readonly", "true");
            $('#SC065').attr("readonly", "true");
            $('#SC066').attr("readonly", "true");
            $('#SC067').attr("readonly", "true");
            $('#NO06').attr("readonly", "true");
    }	
    if(NA07.value=='N'){
            $('#MI07').attr("readonly", "false");
            $('#SC071').attr("readonly", "false");
            $('#SC072').attr("readonly", "false");
            $('#SC073').attr("readonly", "false");
            $('#SC074').attr("readonly", "false");
            $('#SC075').attr("readonly", "false");
            $('#SC076').attr("readonly", "false");
            $('#SC077').attr("readonly", "false");
            $('#NO07').attr("readonly", "false");
    }else{
            $('#MI07').attr("readonly", "true");
            $('#SC071').attr("readonly", "true");
            $('#SC072').attr("readonly", "true");
            $('#SC073').attr("readonly", "true");
            $('#SC074').attr("readonly", "true");
            $('#SC075').attr("readonly", "true");
            $('#SC076').attr("readonly", "true");
            $('#SC077').attr("readonly", "true");
            $('#NO07').attr("readonly", "true");
    }
    if(NA08.value=='N'){
            $('#MI08').attr("readonly", "false");
            $('#SC081').attr("readonly", "false");
            $('#SC082').attr("readonly", "false");
            $('#SC083').attr("readonly", "false");
            $('#SC084').attr("readonly", "false");
            $('#SC085').attr("readonly", "false");
            $('#SC086').attr("readonly", "false");
            $('#SC087').attr("readonly", "false");
    }else{
            $('#MI08').attr("readonly", "true");
            $('#SC081').attr("readonly", "true");
            $('#SC082').attr("readonly", "true");
            $('#SC083').attr("readonly", "true");
            $('#SC084').attr("readonly", "true");
            $('#SC085').attr("readonly", "true");
            $('#SC086').attr("readonly", "true");
            $('#SC087').attr("readonly", "true");
    }
    if(NA09.value=='N'){
            $('#MI09').attr("readonly", "false");
            $('#SC091').attr("readonly", "false");
            $('#SC092').attr("readonly", "false");
            $('#SC093').attr("readonly", "false");
            $('#SC094').attr("readonly", "false");
            $('#SC095').attr("readonly", "false");
            $('#SC096').attr("readonly", "false");
            $('#SC097').attr("readonly", "false");
    }else{
            $('#MI09').attr("readonly", "true");
            $('#SC091').attr("readonly", "true");
            $('#SC092').attr("readonly", "true");
            $('#SC093').attr("readonly", "true");
            $('#SC094').attr("readonly", "true");
            $('#SC095').attr("readonly", "true");
            $('#SC096').attr("readonly", "true");
            $('#SC097').attr("readonly", "true");
    }
    if(NA10.value=='N'){
            $('#MI10').attr("readonly", "false");
            $('#SC101').attr("readonly", "false");
            $('#SC102').attr("readonly", "false");
            $('#SC103').attr("readonly", "false");
            $('#SC104').attr("readonly", "false");
            $('#SC105').attr("readonly", "false");
            $('#SC106').attr("readonly", "false");
            $('#SC107').attr("readonly", "false");
    }else{
            $('#MI10').attr("readonly", "true");
            $('#SC101').attr("readonly", "true");
            $('#SC102').attr("readonly", "true");
            $('#SC103').attr("readonly", "true");
            $('#SC104').attr("readonly", "true");
            $('#SC105').attr("readonly", "true");
            $('#SC106').attr("readonly", "true");
            $('#SC107').attr("readonly", "true");
    }
}
});

function handleClick(myRadio) {
    if(myRadio.value==1){
            NA05.value = 'N';
            NA06.value = 'N';
            NA07.value = 'N';	
            document.getElementById("cstartdate").readOnly = true;
            document.getElementById("cenddate").readOnly = true;
            handleNA05Chk();
            handleNA06Chk();
            handleNA07Chk();
            handleNA10Chk();
    }else if(myRadio.value==3){
            NA05.value = '-';
            NA06.value = '-';
            NA07.value = '-';
            NA10.value = '-';	
            document.getElementById("cstartdate").readOnly = false;
            document.getElementById("cenddate").readOnly = false;
            handleNA05Chk();
            handleNA06Chk();
            handleNA07Chk();
            handleNA10Chk();
    }else{
            NA05.value = '-';
            NA06.value = '-';
            NA07.value = '-';            
            NA10.value = 'N';
            document.getElementById("cstartdate").readOnly = false;
            document.getElementById("cenddate").readOnly = false;
            handleNA05Chk();
            handleNA06Chk();
            handleNA07Chk();
            handleNA10Chk();
    }
}

function handleNA05Chk() {    
    if(NA05.value=='N'||NA05.value=='n'){
        document.getElementById("NA05").value = "N";
        document.getElementById("SC051").value = ""
        document.getElementById("SC052").value = ""
        document.getElementById("SC053").value = ""
        document.getElementById("SC054").value = ""
        document.getElementById("SC055").value = ""
        document.getElementById("SC056").value = ""
        document.getElementById("SC057").value = ""
        document.getElementById("SC058").value = "N"
        document.getElementById("SC059").value = "N"
        document.getElementById("NO05").value = "0"
        document.getElementById("DEC05").value = "0"
        document.getElementById("MI05").readOnly = true;
        document.getElementById("SC051").readOnly = true;
        document.getElementById("SC052").readOnly = true;
        document.getElementById("SC053").readOnly = true;
        document.getElementById("SC054").readOnly = true;
        document.getElementById("SC055").readOnly = true;
        document.getElementById("SC056").readOnly = true;
        document.getElementById("SC057").readOnly = true;
       
    }else{            
        document.getElementById("NA05").value = "-";
        document.getElementById("SC051").value = "1";
        document.getElementById("SC052").value = "1";
        document.getElementById("SC053").value = "1";
        document.getElementById("SC054").value = "1";
        document.getElementById("SC055").value = "1";
        document.getElementById("SC056").value = "1";
        document.getElementById("SC057").value = "1";
        document.getElementById("SC058").value = "N";
        document.getElementById("SC059").value = "N";
        document.getElementById("NO05").value = "0";
        document.getElementById("DEC05").value = "0";
        document.getElementById("MI05").readOnly = false;
        document.getElementById("SC051").readOnly = false;
        document.getElementById("SC052").readOnly = false;
        document.getElementById("SC053").readOnly = false;
        document.getElementById("SC054").readOnly = false;
        document.getElementById("SC055").readOnly = false;
        document.getElementById("SC056").readOnly = false;
        document.getElementById("SC057").readOnly = false;    
        
    }
}  
function handleNA06Chk() {    
    if(NA06.value=='N'||NA06.value=='n'){
          document.getElementById("NA06").value = "N";
          document.getElementById("MI06").readOnly = true;
          document.getElementById("SC061").readOnly = true;
          document.getElementById("SC062").readOnly = true;
          document.getElementById("SC063").readOnly = true;
          document.getElementById("SC064").readOnly = true;
          document.getElementById("SC065").readOnly = true;
          document.getElementById("SC066").readOnly = true;
          document.getElementById("SC067").readOnly = true;
        document.getElementById("SC061").value = ""
        document.getElementById("SC062").value = ""
        document.getElementById("SC063").value = ""
        document.getElementById("SC064").value = ""
        document.getElementById("SC065").value = ""
        document.getElementById("SC066").value = ""
        document.getElementById("SC067").value = ""
        document.getElementById("SC068").value = "N"
        document.getElementById("SC069").value = "N"
        document.getElementById("NO06").value = "0"
        document.getElementById("DEC06").value = "0"
    }else{            
          document.getElementById("NA06").value = "-";
          document.getElementById("MI06").readOnly = false;
          document.getElementById("SC061").readOnly = false;
          document.getElementById("SC062").readOnly = false;
          document.getElementById("SC063").readOnly = false;
          document.getElementById("SC064").readOnly = false;
          document.getElementById("SC065").readOnly = false;
          document.getElementById("SC066").readOnly = false;
          document.getElementById("SC067").readOnly = false;    
        document.getElementById("SC061").value = "1";
        document.getElementById("SC062").value = "1";
        document.getElementById("SC063").value = "1";
        document.getElementById("SC064").value = "1";
        document.getElementById("SC065").value = "1";
        document.getElementById("SC066").value = "1";
        document.getElementById("SC067").value = "1";
        document.getElementById("SC068").value = "N";
        document.getElementById("SC069").value = "N";
        document.getElementById("NO06").value = "0";
        document.getElementById("DEC06").value = "0";
    }
}  
function handleNA07Chk() {    
    if(NA07.value=='N'||NA07.value=='n'){
          document.getElementById("NA07").value = "N";
          document.getElementById("MI07").readOnly = true;
          document.getElementById("SC071").readOnly = true;
          document.getElementById("SC072").readOnly = true;
          document.getElementById("SC073").readOnly = true;
          document.getElementById("SC074").readOnly = true;
          document.getElementById("SC075").readOnly = true;
          document.getElementById("SC076").readOnly = true;
          document.getElementById("SC077").readOnly = true;
        document.getElementById("SC071").value = ""
        document.getElementById("SC072").value = ""
        document.getElementById("SC073").value = ""
        document.getElementById("SC074").value = ""
        document.getElementById("SC075").value = ""
        document.getElementById("SC076").value = ""
        document.getElementById("SC077").value = ""
        document.getElementById("SC078").value = "N"
        document.getElementById("SC079").value = "N"
        document.getElementById("NO07").value = "0"
        document.getElementById("DEC7").value = "0"
    }else{            
          document.getElementById("NA07").value = "-";
          document.getElementById("MI07").readOnly = false;
          document.getElementById("SC071").readOnly = false;
          document.getElementById("SC072").readOnly = false;
          document.getElementById("SC073").readOnly = false;
          document.getElementById("SC074").readOnly = false;
          document.getElementById("SC075").readOnly = false;
          document.getElementById("SC076").readOnly = false;
          document.getElementById("SC077").readOnly = false;    
        document.getElementById("SC071").value = "1";
        document.getElementById("SC072").value = "1";
        document.getElementById("SC073").value = "1";
        document.getElementById("SC074").value = "1";
        document.getElementById("SC075").value = "1";
        document.getElementById("SC076").value = "1";
        document.getElementById("SC077").value = "1";
        document.getElementById("SC078").value = "N";
        document.getElementById("SC079").value = "N";
        document.getElementById("NO07").value = "0";
        document.getElementById("DEC07").value = "0";
    }
}  
function handleNA08Chk() {    
    if(NA08.value=='N'||NA08.value=='n'){
          document.getElementById("NA08").value = "N";
          document.getElementById("MI08").readOnly = true;
          document.getElementById("SC081").readOnly = true;
          document.getElementById("SC082").readOnly = true;
          document.getElementById("SC083").readOnly = true;
          document.getElementById("SC084").readOnly = true;
          document.getElementById("SC085").readOnly = true;
          document.getElementById("SC086").readOnly = true;
          document.getElementById("SC087").readOnly = true;
        document.getElementById("SC081").value = ""
        document.getElementById("SC082").value = ""
        document.getElementById("SC083").value = ""
        document.getElementById("SC084").value = ""
        document.getElementById("SC085").value = ""
        document.getElementById("SC086").value = ""
        document.getElementById("SC087").value = ""
        document.getElementById("SC088").value = "N"
        document.getElementById("SC089").value = "N"
        document.getElementById("NO08").value = "0"
        document.getElementById("DEC08").value = "0"
    }else{            
          document.getElementById("NA08").value = "-";
          document.getElementById("MI08").readOnly = false;
          document.getElementById("SC081").readOnly = false;
          document.getElementById("SC082").readOnly = false;
          document.getElementById("SC083").readOnly = false;
          document.getElementById("SC084").readOnly = false;
          document.getElementById("SC085").readOnly = false;
          document.getElementById("SC086").readOnly = false;
          document.getElementById("SC087").readOnly = false;    
        document.getElementById("SC081").value = "1";
        document.getElementById("SC082").value = "1";
        document.getElementById("SC083").value = "1";
        document.getElementById("SC084").value = "1";
        document.getElementById("SC085").value = "1";
        document.getElementById("SC086").value = "1";
        document.getElementById("SC087").value = "1";
        document.getElementById("SC088").value = "N";
        document.getElementById("SC089").value = "N";
        document.getElementById("NO08").value = "0";
        document.getElementById("DEC08").value = "0";
    }
}  
function handleNA09Chk() {    
    if(NA09.value=='N'||NA09.value=='n'){
          document.getElementById("NA09").value = "N";
          document.getElementById("MI09").readOnly = true;
          document.getElementById("SC091").readOnly = true;
          document.getElementById("SC092").readOnly = true;
          document.getElementById("SC093").readOnly = true;
          document.getElementById("SC094").readOnly = true;
          document.getElementById("SC095").readOnly = true;
          document.getElementById("SC096").readOnly = true;
          document.getElementById("SC097").readOnly = true;
        document.getElementById("SC091").value = ""
        document.getElementById("SC092").value = ""
        document.getElementById("SC093").value = ""
        document.getElementById("SC094").value = ""
        document.getElementById("SC095").value = ""
        document.getElementById("SC096").value = ""
        document.getElementById("SC097").value = ""
        document.getElementById("SC098").value = "N"
        document.getElementById("SC099").value = "N"
        document.getElementById("NO09").value = "0"
        document.getElementById("DEC09").value = "0"
    }else{            
          document.getElementById("NA09").value = "-";
          document.getElementById("MI09").readOnly = false;
          document.getElementById("SC091").readOnly = false;
          document.getElementById("SC092").readOnly = false;
          document.getElementById("SC093").readOnly = false;
          document.getElementById("SC094").readOnly = false;
          document.getElementById("SC095").readOnly = false;
          document.getElementById("SC096").readOnly = false;
          document.getElementById("SC097").readOnly = false;    
        document.getElementById("SC091").value = "1";
        document.getElementById("SC092").value = "1";
        document.getElementById("SC093").value = "1";
        document.getElementById("SC094").value = "1";
        document.getElementById("SC095").value = "1";
        document.getElementById("SC096").value = "1";
        document.getElementById("SC097").value = "1";
        document.getElementById("SC098").value = "N";
        document.getElementById("SC099").value = "N";
        document.getElementById("NO09").value = "0";
        document.getElementById("DEC09").value = "0";
    }
}  
function handleNA10Chk() {    
    if(NA10.value=='N'||NA10.value=='n'){
          document.getElementById("NA10").value = "N";
          document.getElementById("MI10").readOnly = true;
          document.getElementById("SC101").readOnly = true;
          document.getElementById("SC102").readOnly = true;
          document.getElementById("SC103").readOnly = true;
          document.getElementById("SC104").readOnly = true;
          document.getElementById("SC105").readOnly = true;
          document.getElementById("SC106").readOnly = true;
          document.getElementById("SC107").readOnly = true;
        document.getElementById("SC101").value = ""
        document.getElementById("SC102").value = ""
        document.getElementById("SC103").value = ""
        document.getElementById("SC104").value = ""
        document.getElementById("SC105").value = ""
        document.getElementById("SC106").value = ""
        document.getElementById("SC107").value = ""
        document.getElementById("SC108").value = "N"
        document.getElementById("SC109").value = "N"
        document.getElementById("SNO10").value = "0"
        document.getElementById("DEC10").value = "0"
    }else{            
          document.getElementById("NA10").value = "-";
          document.getElementById("MI10").readOnly = false;
          document.getElementById("SC101").readOnly = false;
          document.getElementById("SC102").readOnly = false;
          document.getElementById("SC103").readOnly = false;
          document.getElementById("SC104").readOnly = false;
          document.getElementById("SC105").readOnly = false;
          document.getElementById("SC106").readOnly = false;
          document.getElementById("SC107").readOnly = false;    
        document.getElementById("SC101").value = "1";
        document.getElementById("SC102").value = "1";
        document.getElementById("SC103").value = "1";
        document.getElementById("SC104").value = "1";
        document.getElementById("SC105").value = "1";
        document.getElementById("SC106").value = "1";
        document.getElementById("SC107").value = "1";
        document.getElementById("SC108").value = "N";
        document.getElementById("SC109").value = "N";
        document.getElementById("NO10").value = "0";
        document.getElementById("DEC10").value = "0";
    }
}  

function handleMI01Chk() {         
    if(MI01.value=='M'||MI01.value=='m'){
        document.getElementById("MI01").value = "M";
        document.getElementById("SC011").value = "0";
        document.getElementById("SC012").value = "0";
        document.getElementById("SC013").value = "0";
        document.getElementById("SC014").value = "0";
        document.getElementById("SC015").value = "0";
        document.getElementById("SC016").value = "0";
        document.getElementById("SC017").value = "0";
        document.getElementById("SC018").value = "0";
        document.getElementById("SC019").value = "0";
        document.getElementById("NO01").value = "0";
        document.getElementById("DEC01").value = "0";
        document.getElementById("SC011").readOnly = true;
        document.getElementById("SC012").readOnly = true;
        document.getElementById("SC013").readOnly = true;
        document.getElementById("SC014").readOnly = true;
        document.getElementById("SC015").readOnly = true;
        document.getElementById("SC016").readOnly = true;
        document.getElementById("SC017").readOnly = true;
    }else{            
        document.getElementById("MI01").value = "-";
        document.getElementById("SC011").value = "1";
        document.getElementById("SC012").value = "1";
        document.getElementById("SC013").value = "1";
        document.getElementById("SC014").value = "1";
        document.getElementById("SC015").value = "1";
        document.getElementById("SC016").value = "1";
        document.getElementById("SC017").value = "1";    
        document.getElementById("SC018").value = "N";    
        document.getElementById("SC019").value = "N";    
        document.getElementById("NO01").value = "0";    
        document.getElementById("DEC01").value = "0";    
        document.getElementById("SC011").readOnly = false;
        document.getElementById("SC012").readOnly = false;
        document.getElementById("SC013").readOnly = false;
        document.getElementById("SC014").readOnly = false;
        document.getElementById("SC015").readOnly = false;
        document.getElementById("SC016").readOnly = false;
        document.getElementById("SC017").readOnly = false;      
    } 
 }
function handleMI02Chk() {         
    if(MI02.value=='M'||MI02.value=='m'){
        document.getElementById("MI02").value = "M";
        document.getElementById("SC021").value = "0";
        document.getElementById("SC022").value = "0";
        document.getElementById("SC023").value = "0";
        document.getElementById("SC024").value = "0";
        document.getElementById("SC025").value = "0";
        document.getElementById("SC026").value = "0";
        document.getElementById("SC027").value = "0";
        document.getElementById("SC028").value = "0";
        document.getElementById("SC029").value = "0";
        document.getElementById("NO02").value = "0";
        document.getElementById("DEC02").value = "0";
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
        document.getElementById("NO02").value = "0";    
        document.getElementById("DEC02").value = "0";    
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
        document.getElementById("SC031").value = "0";
        document.getElementById("SC032").value = "0";
        document.getElementById("SC033").value = "0";
        document.getElementById("SC034").value = "0";
        document.getElementById("SC035").value = "0";
        document.getElementById("SC036").value = "0";
        document.getElementById("SC037").value = "0";
        document.getElementById("SC038").value = "0";
        document.getElementById("SC039").value = "0";
        document.getElementById("NO03").value = "0";
        document.getElementById("DEC03").value = "0";
        document.getElementById("SC031").readOnly = true;
        document.getElementById("SC032").readOnly = true;
        document.getElementById("SC033").readOnly = true;
        document.getElementById("SC034").readOnly = true;
        document.getElementById("SC035").readOnly = true;
        document.getElementById("SC036").readOnly = true;
        document.getElementById("SC037").readOnly = true;
    }else{            
        document.getElementById("MI03").value = "-";
        document.getElementById("SC031").value = "1";
        document.getElementById("SC032").value = "1";
        document.getElementById("SC033").value = "1";
        document.getElementById("SC034").value = "1";
        document.getElementById("SC035").value = "1";
        document.getElementById("SC036").value = "1";
        document.getElementById("SC037").value = "1";    
        document.getElementById("SC038").value = "N";    
        document.getElementById("SC039").value = "N";    
        document.getElementById("NO03").value = "0";    
        document.getElementById("DEC03").value = "0";    
        document.getElementById("SC031").readOnly = false;
        document.getElementById("SC032").readOnly = false;
        document.getElementById("SC033").readOnly = false;
        document.getElementById("SC034").readOnly = false;
        document.getElementById("SC035").readOnly = false;
        document.getElementById("SC036").readOnly = false;
        document.getElementById("SC037").readOnly = false;      
    } 
 }
function handleMI04Chk() {         
    if(MI04.value=='M'||MI04.value=='m'){
        document.getElementById("MI04").value = "M";
        document.getElementById("SC041").value = "0";
        document.getElementById("SC042").value = "0";
        document.getElementById("SC043").value = "0";
        document.getElementById("SC044").value = "0";
        document.getElementById("SC045").value = "0";
        document.getElementById("SC046").value = "0";
        document.getElementById("SC047").value = "0";
        document.getElementById("SC048").value = "0";
        document.getElementById("SC049").value = "0";
        document.getElementById("NO04").value = "0";
        document.getElementById("DEC04").value = "0";
        document.getElementById("NO04").readOnly = true;
        document.getElementById("SC041").readOnly = true;
        document.getElementById("SC042").readOnly = true;
        document.getElementById("SC043").readOnly = true;
        document.getElementById("SC044").readOnly = true;
        document.getElementById("SC045").readOnly = true;
        document.getElementById("SC046").readOnly = true;
        document.getElementById("SC047").readOnly = true;
    }else{            
        document.getElementById("MI04").value = "-";
        document.getElementById("SC041").value = "1";
        document.getElementById("SC042").value = "1";
        document.getElementById("SC043").value = "1";
        document.getElementById("SC044").value = "1";
        document.getElementById("SC045").value = "1";
        document.getElementById("SC046").value = "1";
        document.getElementById("SC047").value = "1";    
        document.getElementById("SC048").value = "N";    
        document.getElementById("SC049").value = "N";    
        document.getElementById("NO04").value = "0";    
        document.getElementById("DEC04").value = "0";    
        document.getElementById("NO04").readOnly = false;
        document.getElementById("SC041").readOnly = false;
        document.getElementById("SC042").readOnly = false;
        document.getElementById("SC043").readOnly = false;
        document.getElementById("SC044").readOnly = false;
        document.getElementById("SC045").readOnly = false;
        document.getElementById("SC046").readOnly = false;
        document.getElementById("SC047").readOnly = false;      
    } 
 }
function handleMI05Chk() {         
    if(MI05.value=='M'||MI05.value=='m'){
        document.getElementById("MI05").value = "M";
        document.getElementById("SC051").value = "0";
        document.getElementById("SC052").value = "0";
        document.getElementById("SC053").value = "0";
        document.getElementById("SC054").value = "0";
        document.getElementById("SC055").value = "0";
        document.getElementById("SC056").value = "0";
        document.getElementById("SC057").value = "0";
        document.getElementById("SC051").readOnly = true;
        document.getElementById("SC052").readOnly = true;
        document.getElementById("SC053").readOnly = true;
        document.getElementById("SC054").readOnly = true;
        document.getElementById("SC055").readOnly = true;
        document.getElementById("SC056").readOnly = true;
        document.getElementById("SC057").readOnly = true;
    }else{            
        document.getElementById("MI05").value = "-";
        document.getElementById("SC051").value = "1";
        document.getElementById("SC052").value = "1";
        document.getElementById("SC053").value = "1";
        document.getElementById("SC054").value = "1";
        document.getElementById("SC055").value = "1";
        document.getElementById("SC056").value = "1";
        document.getElementById("SC057").value = "1";    
        document.getElementById("SC051").readOnly = false;
        document.getElementById("SC052").readOnly = false;
        document.getElementById("SC053").readOnly = false;
        document.getElementById("SC054").readOnly = false;
        document.getElementById("SC055").readOnly = false;
        document.getElementById("SC056").readOnly = false;
        document.getElementById("SC057").readOnly = false;      
    } 
 }
function handleMI06Chk() {         
    if(MI06.value=='M'||MI06.value=='m'){
        document.getElementById("MI06").value = "M";
        document.getElementById("SC061").value = "0";
        document.getElementById("SC062").value = "0";
        document.getElementById("SC063").value = "0";
        document.getElementById("SC064").value = "0";
        document.getElementById("SC065").value = "0";
        document.getElementById("SC066").value = "0";
        document.getElementById("SC067").value = "0";
        document.getElementById("SC061").readOnly = true;
        document.getElementById("SC062").readOnly = true;
        document.getElementById("SC063").readOnly = true;
        document.getElementById("SC064").readOnly = true;
        document.getElementById("SC065").readOnly = true;
        document.getElementById("SC066").readOnly = true;
        document.getElementById("SC067").readOnly = true;
    }else{            
        document.getElementById("MI06").value = "-";
        document.getElementById("SC061").value = "1";
        document.getElementById("SC062").value = "1";
        document.getElementById("SC063").value = "1";
        document.getElementById("SC064").value = "1";
        document.getElementById("SC065").value = "1";
        document.getElementById("SC066").value = "1";
        document.getElementById("SC067").value = "1";    
        document.getElementById("SC061").readOnly = false;
        document.getElementById("SC062").readOnly = false;
        document.getElementById("SC063").readOnly = false;
        document.getElementById("SC064").readOnly = false;
        document.getElementById("SC065").readOnly = false;
        document.getElementById("SC066").readOnly = false;
        document.getElementById("SC067").readOnly = false;      
    } 
 }
function handleMI07Chk() {         
    if(MI07.value=='M'||MI07.value=='m'){
        document.getElementById("MI07").value = "M";
        document.getElementById("SC071").value = "0";
        document.getElementById("SC072").value = "0";
        document.getElementById("SC073").value = "0";
        document.getElementById("SC074").value = "0";
        document.getElementById("SC075").value = "0";
        document.getElementById("SC076").value = "0";
        document.getElementById("SC077").value = "0";
        document.getElementById("SC071").readOnly = true;
        document.getElementById("SC072").readOnly = true;
        document.getElementById("SC073").readOnly = true;
        document.getElementById("SC074").readOnly = true;
        document.getElementById("SC075").readOnly = true;
        document.getElementById("SC076").readOnly = true;
        document.getElementById("SC077").readOnly = true;
    }else{            
        document.getElementById("MI07").value = "-";
        document.getElementById("SC071").value = "1";
        document.getElementById("SC072").value = "1";
        document.getElementById("SC073").value = "1";
        document.getElementById("SC074").value = "1";
        document.getElementById("SC075").value = "1";
        document.getElementById("SC076").value = "1";
        document.getElementById("SC077").value = "1";    
        document.getElementById("SC071").readOnly = false;
        document.getElementById("SC072").readOnly = false;
        document.getElementById("SC073").readOnly = false;
        document.getElementById("SC074").readOnly = false;
        document.getElementById("SC075").readOnly = false;
        document.getElementById("SC076").readOnly = false;
        document.getElementById("SC077").readOnly = false;      
    } 
 }
function handleMI08Chk() {         
    if(MI08.value=='M'||MI08.value=='m'){
        document.getElementById("MI08").value = "M";
        document.getElementById("SC081").value = "0";
        document.getElementById("SC082").value = "0";
        document.getElementById("SC083").value = "0";
        document.getElementById("SC084").value = "0";
        document.getElementById("SC085").value = "0";
        document.getElementById("SC086").value = "0";
        document.getElementById("SC087").value = "0";
        document.getElementById("SC081").readOnly = true;
        document.getElementById("SC082").readOnly = true;
        document.getElementById("SC083").readOnly = true;
        document.getElementById("SC084").readOnly = true;
        document.getElementById("SC085").readOnly = true;
        document.getElementById("SC086").readOnly = true;
        document.getElementById("SC087").readOnly = true;
    }else{            
        document.getElementById("MI08").value = "-";
        document.getElementById("SC081").value = "1";
        document.getElementById("SC082").value = "1";
        document.getElementById("SC083").value = "1";
        document.getElementById("SC084").value = "1";
        document.getElementById("SC085").value = "1";
        document.getElementById("SC086").value = "1";
        document.getElementById("SC087").value = "1";    
        document.getElementById("SC081").readOnly = false;
        document.getElementById("SC082").readOnly = false;
        document.getElementById("SC083").readOnly = false;
        document.getElementById("SC084").readOnly = false;
        document.getElementById("SC085").readOnly = false;
        document.getElementById("SC086").readOnly = false;
        document.getElementById("SC087").readOnly = false;      
    } 
 }
function handleMI09Chk() {         
    if(MI09.value=='M'||MI09.value=='m'){
        document.getElementById("MI09").value = "M";
        document.getElementById("SC091").value = "0";
        document.getElementById("SC092").value = "0";
        document.getElementById("SC093").value = "0";
        document.getElementById("SC094").value = "0";
        document.getElementById("SC095").value = "0";
        document.getElementById("SC096").value = "0";
        document.getElementById("SC097").value = "0";
        document.getElementById("SC091").readOnly = true;
        document.getElementById("SC092").readOnly = true;
        document.getElementById("SC093").readOnly = true;
        document.getElementById("SC094").readOnly = true;
        document.getElementById("SC095").readOnly = true;
        document.getElementById("SC096").readOnly = true;
        document.getElementById("SC097").readOnly = true;
    }else{            
        document.getElementById("MI09").value = "-";
        document.getElementById("SC091").value = "1";
        document.getElementById("SC092").value = "1";
        document.getElementById("SC093").value = "1";
        document.getElementById("SC094").value = "1";
        document.getElementById("SC095").value = "1";
        document.getElementById("SC096").value = "1";
        document.getElementById("SC097").value = "1";    
        document.getElementById("SC091").readOnly = false;
        document.getElementById("SC092").readOnly = false;
        document.getElementById("SC093").readOnly = false;
        document.getElementById("SC094").readOnly = false;
        document.getElementById("SC095").readOnly = false;
        document.getElementById("SC096").readOnly = false;
        document.getElementById("SC097").readOnly = false;      
    } 
 }
function handleMI10Chk() {         
    if(MI10.value=='M'||MI10.value=='m'){
        document.getElementById("MI10").value = "M";
        document.getElementById("SC101").value = "0";
        document.getElementById("SC102").value = "0";
        document.getElementById("SC103").value = "0";
        document.getElementById("SC104").value = "0";
        document.getElementById("SC105").value = "0";
        document.getElementById("SC106").value = "0";
        document.getElementById("SC107").value = "0";
        document.getElementById("SC101").readOnly = true;
        document.getElementById("SC102").readOnly = true;
        document.getElementById("SC103").readOnly = true;
        document.getElementById("SC104").readOnly = true;
        document.getElementById("SC105").readOnly = true;
        document.getElementById("SC106").readOnly = true;
        document.getElementById("SC107").readOnly = true;
    }else{            
        document.getElementById("MI10").value = "-";
        document.getElementById("SC101").value = "1";
        document.getElementById("SC102").value = "1";
        document.getElementById("SC103").value = "1";
        document.getElementById("SC104").value = "1";
        document.getElementById("SC105").value = "1";
        document.getElementById("SC106").value = "1";
        document.getElementById("SC107").value = "1";    
        document.getElementById("SC101").readOnly = false;
        document.getElementById("SC102").readOnly = false;
        document.getElementById("SC103").readOnly = false;
        document.getElementById("SC104").readOnly = false;
        document.getElementById("SC105").readOnly = false;
        document.getElementById("SC106").readOnly = false;
        document.getElementById("SC107").readOnly = false;      
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
        if(SC021.value=='N'||SC021.value=='n'||SC021.value=='1'||SC021.value=='0'){  }else{ document.getElementById("SC021").value = "0"; }
        if(SC022.value=='N'||SC022.value=='n'||SC022.value=='1'||SC022.value=='0'){  }else{ document.getElementById("SC022").value = "0"; }
        if(SC023.value=='N'||SC023.value=='n'||SC023.value=='1'||SC023.value=='0'){  }else{ document.getElementById("SC023").value = "0"; }
        if(SC024.value=='N'||SC024.value=='n'||SC024.value=='1'||SC024.value=='0'){  }else{ document.getElementById("SC024").value = "0"; }
        if(SC025.value=='N'||SC025.value=='n'||SC025.value=='1'||SC025.value=='0'){  }else{ document.getElementById("SC025").value = "0"; }
        if(SC026.value=='N'||SC026.value=='n'||SC026.value=='1'||SC026.value=='0'){  }else{ document.getElementById("SC026").value = "0"; }
        if(SC027.value=='N'||SC027.value=='n'||SC027.value=='1'||SC027.value=='0'){  }else{ document.getElementById("SC027").value = "0"; }
        if(SC031.value=='N'||SC031.value=='n'||SC031.value=='1'||SC031.value=='0'){  }else{ document.getElementById("SC031").value = "0"; }
        if(SC032.value=='N'||SC032.value=='n'||SC032.value=='1'||SC032.value=='0'){  }else{ document.getElementById("SC032").value = "0"; }
        if(SC033.value=='N'||SC033.value=='n'||SC033.value=='1'||SC033.value=='0'){  }else{ document.getElementById("SC033").value = "0"; }
        if(SC034.value=='N'||SC034.value=='n'||SC034.value=='1'||SC034.value=='0'){  }else{ document.getElementById("SC034").value = "0"; }
        if(SC035.value=='N'||SC035.value=='n'||SC035.value=='1'||SC035.value=='0'){  }else{ document.getElementById("SC035").value = "0"; }
        if(SC036.value=='N'||SC036.value=='n'||SC036.value=='1'||SC036.value=='0'){  }else{ document.getElementById("SC036").value = "0"; }
        if(SC037.value=='N'||SC037.value=='n'||SC037.value=='1'||SC037.value=='0'){  }else{ document.getElementById("SC037").value = "0"; }
        if(SC041.value=='N'||SC041.value=='n'||SC041.value=='1'||SC041.value=='0'){  }else{ document.getElementById("SC041").value = "0"; }
        if(SC042.value=='N'||SC042.value=='n'||SC042.value=='1'||SC042.value=='0'){  }else{ document.getElementById("SC042").value = "0"; }
        if(SC043.value=='N'||SC043.value=='n'||SC043.value=='1'||SC043.value=='0'){  }else{ document.getElementById("SC043").value = "0"; }
        if(SC044.value=='N'||SC044.value=='n'||SC044.value=='1'||SC044.value=='0'){  }else{ document.getElementById("SC044").value = "0"; }
        if(SC045.value=='N'||SC045.value=='n'||SC045.value=='1'||SC045.value=='0'){  }else{ document.getElementById("SC045").value = "0"; }
        if(SC046.value=='N'||SC046.value=='n'||SC046.value=='1'||SC046.value=='0'){  }else{ document.getElementById("SC046").value = "0"; }
        if(SC047.value=='N'||SC047.value=='n'||SC047.value=='1'||SC047.value=='0'){  }else{ document.getElementById("SC047").value = "0"; }
        if(SC051.value=='N'||SC051.value=='n'||SC051.value=='1'||SC051.value=='0'||NA05.value=='N'){  }else{ document.getElementById("SC051").value = "0"; }
        if(SC052.value=='N'||SC052.value=='n'||SC052.value=='1'||SC052.value=='0'||NA05.value=='N'){  }else{ document.getElementById("SC052").value = "0"; }
        if(SC053.value=='N'||SC053.value=='n'||SC053.value=='1'||SC053.value=='0'||NA05.value=='N'){  }else{ document.getElementById("SC053").value = "0"; }
        if(SC054.value=='N'||SC054.value=='n'||SC054.value=='1'||SC054.value=='0'||NA05.value=='N'){  }else{ document.getElementById("SC054").value = "0"; }
        if(SC055.value=='N'||SC055.value=='n'||SC055.value=='1'||SC055.value=='0'||NA05.value=='N'){  }else{ document.getElementById("SC055").value = "0"; }
        if(SC056.value=='N'||SC056.value=='n'||SC056.value=='1'||SC056.value=='0'||NA05.value=='N'){  }else{ document.getElementById("SC056").value = "0"; }
        if(SC057.value=='N'||SC057.value=='n'||SC057.value=='1'||SC057.value=='0'||NA05.value=='N'){  }else{ document.getElementById("SC057").value = "0"; }
        if(SC061.value=='N'||SC061.value=='n'||SC061.value=='1'||SC061.value=='0'||NA06.value=='N'){  }else{ document.getElementById("SC061").value = "0"; }
        if(SC062.value=='N'||SC062.value=='n'||SC062.value=='1'||SC062.value=='0'||NA06.value=='N'){  }else{ document.getElementById("SC062").value = "0"; }
        if(SC063.value=='N'||SC063.value=='n'||SC063.value=='1'||SC063.value=='0'||NA06.value=='N'){  }else{ document.getElementById("SC063").value = "0"; }
        if(SC064.value=='N'||SC064.value=='n'||SC064.value=='1'||SC064.value=='0'||NA06.value=='N'){  }else{ document.getElementById("SC064").value = "0"; }
        if(SC065.value=='N'||SC065.value=='n'||SC065.value=='1'||SC065.value=='0'||NA06.value=='N'){  }else{ document.getElementById("SC065").value = "0"; }
        if(SC066.value=='N'||SC066.value=='n'||SC066.value=='1'||SC066.value=='0'||NA06.value=='N'){  }else{ document.getElementById("SC066").value = "0"; }
        if(SC067.value=='N'||SC067.value=='n'||SC067.value=='1'||SC067.value=='0'||NA06.value=='N'){  }else{ document.getElementById("SC067").value = "0"; }
        if(SC071.value=='N'||SC071.value=='n'||SC071.value=='1'||SC071.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC071").value = "0"; }
        if(SC072.value=='N'||SC072.value=='n'||SC072.value=='1'||SC072.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC072").value = "0"; }
        if(SC073.value=='N'||SC073.value=='n'||SC073.value=='1'||SC073.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC073").value = "0"; }
        if(SC074.value=='N'||SC074.value=='n'||SC074.value=='1'||SC074.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC074").value = "0"; }
        if(SC075.value=='N'||SC075.value=='n'||SC075.value=='1'||SC075.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC075").value = "0"; }
        if(SC076.value=='N'||SC076.value=='n'||SC076.value=='1'||SC076.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC076").value = "0"; }
        if(SC077.value=='N'||SC077.value=='n'||SC077.value=='1'||SC077.value=='0'||NA07.value=='N'){  }else{ document.getElementById("SC077").value = "0"; }
        if(SC081.value=='N'||SC081.value=='n'||SC081.value=='1'||SC081.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC081").value = "0"; }
        if(SC082.value=='N'||SC082.value=='n'||SC082.value=='1'||SC082.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC082").value = "0"; }
        if(SC083.value=='N'||SC083.value=='n'||SC083.value=='1'||SC083.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC083").value = "0"; }
        if(SC084.value=='N'||SC084.value=='n'||SC084.value=='1'||SC084.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC084").value = "0"; }
        if(SC085.value=='N'||SC085.value=='n'||SC085.value=='1'||SC085.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC085").value = "0"; }
        if(SC086.value=='N'||SC086.value=='n'||SC086.value=='1'||SC086.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC086").value = "0"; }
        if(SC087.value=='N'||SC087.value=='n'||SC087.value=='1'||SC087.value=='0'||NA08.value=='N'){  }else{ document.getElementById("SC087").value = "0"; }
        if(SC091.value=='N'||SC091.value=='n'||SC091.value=='1'||SC091.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC091").value = "0"; }
        if(SC092.value=='N'||SC092.value=='n'||SC092.value=='1'||SC092.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC092").value = "0"; }
        if(SC093.value=='N'||SC093.value=='n'||SC093.value=='1'||SC093.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC093").value = "0"; }
        if(SC094.value=='N'||SC094.value=='n'||SC094.value=='1'||SC094.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC094").value = "0"; }
        if(SC095.value=='N'||SC095.value=='n'||SC095.value=='1'||SC095.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC095").value = "0"; }
        if(SC096.value=='N'||SC096.value=='n'||SC096.value=='1'||SC096.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC096").value = "0"; }
        if(SC097.value=='N'||SC097.value=='n'||SC097.value=='1'||SC097.value=='0'||NA09.value=='N'){  }else{ document.getElementById("SC097").value = "0"; }
        if(SC101.value=='N'||SC101.value=='n'||SC101.value=='1'||SC101.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC101").value = "0"; }
        if(SC102.value=='N'||SC102.value=='n'||SC102.value=='1'||SC102.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC102").value = "0"; }
        if(SC103.value=='N'||SC103.value=='n'||SC103.value=='1'||SC103.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC103").value = "0"; }
        if(SC104.value=='N'||SC104.value=='n'||SC104.value=='1'||SC104.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC104").value = "0"; }
        if(SC105.value=='N'||SC105.value=='n'||SC105.value=='1'||SC105.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC105").value = "0"; }
        if(SC106.value=='N'||SC106.value=='n'||SC106.value=='1'||SC106.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC106").value = "0"; }
        if(SC107.value=='N'||SC107.value=='n'||SC107.value=='1'||SC107.value=='0'||NA10.value=='N'){  }else{ document.getElementById("SC107").value = "0"; }
        if(DEC01.value=='1'||DEC01.value=='0'){  }else{ document.getElementById("DEC01").value = "0"; }
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

<div class="mraopd-form">
    <center>
    <div class="box box-success box-solid" id="grad8">
	<div align="center" class="well">
      <div class="table-responsive">
    <?php $form = ActiveForm::begin(); ?>
	 <div class="col-md-2">
           <?= $form->field($model, 'hospcode')->textInput(['maxlength' => true,'value'=>'10953']) ?>
     </div>
     <div class="col-md-3">
          <?= $form->field($model, 'unit_id')->widget(Select2::className(), [
                            'data' => ArrayHelper::map(Mradepartmetnsopd::find()->all(),'unit_id','unit_name'),
                            'options' => [
                                'placeholder' => '<--คลิก/เลือกแผนก-->',
                            ],
                            'pluginOptions' =>
                                [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
          </div>
	 <div class="col-md-2">
          <?= $form->field($model, 'HN')->textInput(['maxlength' => 6]) ?>
     </div>
	 <div class="col-md-2">
          
		  <?= $form->field($model, 'visit')->dropDownList(['1' => '1', '2' => '2', '3' => '3','4'=>'4'])?>
     </div>
	<div class="col-md-3">
          <?= $form->field($model, 'date_audit')->widget(DatePicker::className(),[
    'options' => ['placeholder' => 'เลือกวัน Audit ...'],
     'language' => 'th',
    'id' => 'datepicker1',
    'inline' => false,
    'clientOptions' => [
        //'defaultDate' => date('Y-m-d'),
        'autoclose' => true,
        'todayHighlight' => true,
        'format' => 'yyyy-mm-dd',
        'startDate' => date('2022-01-01'),    
    ]
  ]);?>
          </div>  
	 </div>
    </div>
</div>
</center>
<center>
<div class="table-responsive">
<div class="box box-success box-solid" id="grad8">
    <div class="well">
        <table class="tbinsopd">
        <th style="color:blue">No </th> 
    <th style="color:green">Contents</th>
    <th style="color:green">NA (N)</th> 
    <th style="color:green">Miss (M)</th>
    <th style="color:green">ข้อที่ 1</th>
    <th style="color:green">ข้อที่ 2</th>
    <th style="color:green">ข้อที่ 3</th>
    <th style="color:green">ข้อที่ 4</th>
    <th style="color:green">ข้อที่ 5</th>
    <th style="color:green">ข้อที่ 6</th>
    <th style="color:green">ข้อที่ 7</th>
    <th style="color:green">เพิ่มคะแนน</th>
    <th style="color:green">หักคะแนน</th>
  </tr>
  <tr>
  	<td><font>1</font></td>
	<td class="left"><font> Patient's Profile </font></td>
    <td><?= $form->field($model, 'NA01')->textInput(['id'=>'NA01','size'=>1,'maxlength' => 1, 'value'=>'-', 'autocomplete'=>'off'])->label(false) ?></td>
    <td><?= $form->field($model, 'MI01')->textInput(['id'=>'MI01','size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMI01Chk(this)'])->label(false) ?></td> 
    <td><?= $form->field($model, 'SC011')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>  
    <td><?= $form->field($model, 'SC012')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>  
    <td><?= $form->field($model, 'SC013')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>  
    <td><?= $form->field($model, 'SC014')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>  
    <td><?= $form->field($model, 'SC015')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>  
    <td><?= $form->field($model, 'SC016')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>  
    <td><?= $form->field($model, 'SC017')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>     
    <td><?= $form->field($model, 'NO01')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>  
    <td><?= $form->field($model, 'DEC01')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>   
    
 </tr>
 <tr>
  	<td><font>2</font></td>
	<td class="left"><font> History (1<sup>st</sup> visit) </font></td>
    <td><?= $form->field($model, 'NA02')->textInput(['id'=>'NA02','size'=>1,'maxlength' => 1, 'value'=>'-', 'autocomplete'=>'off'])->label(false) ?></td>
    <td><?= $form->field($model, 'MI02')->textInput(['id'=>'MI02','size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMI02Chk(this)'])->label(false) ?></td>
    <td><?= $form->field($model, 'SC021')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>   
    <td><?= $form->field($model, 'SC022')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>  
    <td><?= $form->field($model, 'SC023')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>  
    <td><?= $form->field($model, 'SC024')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>  
    <td><?= $form->field($model, 'SC025')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>  
    <td><?= $form->field($model, 'SC026')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>  
    <td><?= $form->field($model, 'SC027')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>  
    <td><?= $form->field($model, 'NO02')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>  
    <td><?= $form->field($model, 'DEC02')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>  
 </tr>
 <tr>
  	<td><font>3</font></td>
	<td class="left"><font> Physical examination </font></td>
    <td><?= $form->field($model, 'NA03')->textInput(['id'=>'NA03','size'=>1,'maxlength' => 1, 'value'=>'-', 'autocomplete'=>'off'])->label(false) ?></td>
    <td><?= $form->field($model, 'MI03')->textInput(['id'=>'MI03','size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMI03Chk(this)'])->label(false) ?></td>
    <td><?= $form->field($model, 'SC031')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>  
    <td><?= $form->field($model, 'SC032')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>
    <td><?= $form->field($model, 'SC033')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>
    <td><?= $form->field($model, 'SC034')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>
    <td><?= $form->field($model, 'SC035')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>
    <td><?= $form->field($model, 'SC036')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>
    <td><?= $form->field($model, 'SC037')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>   
    <td><?= $form->field($model, 'NO03')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>  
    <td><?= $form->field($model, 'DEC03')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>   
 </tr>
 <tr>
  	<td><font>4</font></td>
	<td class="left"><font> Teatment/Investigation </font></td>
    <td><?= $form->field($model, 'NA04')->textInput(['id'=>'NA04','size'=>1,'maxlength' => 1, 'value'=>'-', 'autocomplete'=>'off'])->label(false) ?></td>
    <td><?= $form->field($model, 'MI04')->textInput(['id'=>'MI04','size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMI04Chk(this)'])->label(false) ?></td>
    <td><?= $form->field($model, 'SC041')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>   
    <td><?= $form->field($model, 'SC042')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>       
    <td><?= $form->field($model, 'SC043')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>   
    <td><?= $form->field($model, 'SC044')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>    
    <td><?= $form->field($model, 'SC045')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>      
    <td><?= $form->field($model, 'SC046')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>  
    <td><?= $form->field($model, 'SC047')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>     
    <td><?= $form->field($model, 'NO04')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>  
    <td><?= $form->field($model, 'DEC04')->dropDownList(['0' => '0', '1' => '1'])->label(false)?> </td>   
 </tr>
 <tr>
  	<td><font>5</font></td>
	<td class="left"><font> Follow up ครั้งที่ 1 <?= $form->field($model, 'Followdate1')->widget(DatePicker::className(),[
    'options' => ['placeholder' => 'เลือกวัน...'],
     'language' => 'th',
    'id' => 'datepicker1',
    'inline' => false,
    'clientOptions' => [
        //'defaultDate' => date('Y-m-d'),
        'autoclose' => true,
        'todayHighlight' => true,
        'format' => 'yyyy-mm-dd',
       // 'startDate' => date('2022-01-01'),
        'size'=>10,
        'maxlength'=>10,
    ]
  ])->label(false);?> </font></td>
    <td><?= $form->field($model, 'NA05')->textInput(['id'=>'NA05','size'=>1,'maxlength' => 1, 'value'=>'N','onchange'=> 'handleNA05Chk(this)'])->label(false) ?></td>
    <td><?= $form->field($model, 'MI05')->textInput(['id'=>'MI05','size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMI05Chk(this)'])->label(false) ?></td>
    <td><?= $form->field($model, 'SC051')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
    <td><?= $form->field($model, 'SC052')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>      
    <td><?= $form->field($model, 'SC053')->dropDownList([''=>'','0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
    <td><?= $form->field($model, 'SC054')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>       
    <td><?= $form->field($model, 'SC055')->dropDownList([''=>'','0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>      
    <td><?= $form->field($model, 'SC056')->dropDownList([''=>'','0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>      
    <td><?= $form->field($model, 'SC057')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>
    <td><?= $form->field($model, 'NO05')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
    <td><?= $form->field($model, 'DEC05')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>    
     
 </tr>
 <tr>
  	<td><font></font></td>
	<td class="left"><font> Follow up ครั้งที่ 2 <?= $form->field($model, 'Followdate2')->widget(DatePicker::className(),[
    'options' => ['placeholder' => 'เลือกวัน...'],
     'language' => 'th',
    'id' => 'datepicker1',
    'inline' => false,
    'clientOptions' => [
        //'defaultDate' => date('Y-m-d'),
        'autoclose' => true,
        'todayHighlight' => true,
        'format' => 'yyyy-mm-dd',
       // 'startDate' => date('2022-01-01'),
        'size'=>10,
        'maxlength'=>10,
    ]
  ])->label(false);?> </font></td>
    <td><?= $form->field($model, 'NA06')->textInput(['id'=>'NA06','size'=>1,'maxlength' => 1, 'value'=>'N','onchange'=> 'handleNA06Chk(this)'])->label(false) ?></td>
    <td><?= $form->field($model, 'MI06')->textInput(['id'=>'MI06','size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMI06Chk(this)'])->label(false) ?></td>
    <td><?= $form->field($model, 'SC061')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
    <td><?= $form->field($model, 'SC062')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>      
    <td><?= $form->field($model, 'SC063')->dropDownList([''=>'','0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
    <td><?= $form->field($model, 'SC064')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>       
    <td><?= $form->field($model, 'SC065')->dropDownList([''=>'','0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>      
    <td><?= $form->field($model, 'SC066')->dropDownList([''=>'','0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>      
    <td><?= $form->field($model, 'SC067')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>
    <td><?= $form->field($model, 'NO06')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
    <td><?= $form->field($model, 'DEC06')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>     
 </tr>
 <tr>
 <td><font></font></td>
	<td class="left"><font> Follow up ครั้งที่ 3 <?= $form->field($model, 'Followdate3')->widget(DatePicker::className(),[
    'options' => ['placeholder' => 'เลือกวัน...'],
     'language' => 'th',
    'id' => 'datepicker1',
    'inline' => false,
    'clientOptions' => [
        //'defaultDate' => date('Y-m-d'),
        'autoclose' => true,
        'todayHighlight' => true,
        'format' => 'yyyy-mm-dd',
       // 'startDate' => date('2022-01-01'),
        'size'=>10,
        'maxlength'=>10,
    ]
  ])->label(false);?> </font></td>
    <td><?= $form->field($model, 'NA07')->textInput(['id'=>'NA07','size'=>1,'maxlength' => 1, 'value'=>'N','onchange'=> 'handleNA07Chk(this)'])->label(false) ?></td>
    <td><?= $form->field($model, 'MI07')->textInput(['id'=>'MI07','size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMI07Chk(this)'])->label(false) ?></td>
    <td><?= $form->field($model, 'SC071')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
    <td><?= $form->field($model, 'SC072')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>      
    <td><?= $form->field($model, 'SC073')->dropDownList([''=>'','0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
    <td><?= $form->field($model, 'SC074')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>       
    <td><?= $form->field($model, 'SC075')->dropDownList([''=>'','0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>      
    <td><?= $form->field($model, 'SC076')->dropDownList([''=>'','0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>      
    <td><?= $form->field($model, 'SC077')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>
    <td><?= $form->field($model, 'NO07')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
    <td><?= $form->field($model, 'DEC07')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>    
 </tr>
 <tr>
 <td><font>6</font></td>
    <td class="left"><font> Operative note </font></td>
    <td><?= $form->field($model, 'NA08')->textInput(['id'=>'NA08','size'=>1,'maxlength' => 1, 'value'=>'N','onchange'=> 'handleNA08Chk(this)'])->label(false) ?></td>
    <td><?= $form->field($model, 'MI08')->textInput(['id'=>'MI08','size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMI08Chk(this)'])->label(false) ?></td>
    <td><?= $form->field($model, 'SC081')->textInput(['id'=>"SC081",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'SC082')->textInput(['id'=>"SC082",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'SC083')->textInput(['id'=>"SC083",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'SC084')->textInput(['id'=>"SC084",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'SC085')->textInput(['id'=>"SC085",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'SC086')->textInput(['id'=>"SC086",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'SC087')->textInput(['id'=>"SC087",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'NO08')->textInput(['id'=>'NO08','size'=>1,'maxlength' => 1,'autocomplete'=>'off'])->label(false) ?></td>
    <td><?= $form->field($model, 'DEC08')->textInput(['id'=>"DEC08",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td> 
 </tr>
 <tr>
 <td><font>7</font></td>
    <td class="left"><font> Informed consent </font></td>
    <td><?= $form->field($model, 'NA09')->textInput(['id'=>'NA09','size'=>1,'maxlength' => 1, 'value'=>'N','onchange'=> 'handleNA09Chk(this)'])->label(false) ?></td>
    <td><?= $form->field($model, 'MI09')->textInput(['id'=>'MI09','size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMI09Chk(this)'])->label(false) ?></td>
    <td><?= $form->field($model, 'SC091')->textInput(['id'=>"SC091",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'SC092')->textInput(['id'=>"SC092",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'SC093')->textInput(['id'=>"SC093",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'SC094')->textInput(['id'=>"SC094",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'SC095')->textInput(['id'=>"SC095",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'SC096')->textInput(['id'=>"SC096",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'SC097')->textInput(['id'=>"SC097",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'NO09')->textInput(['id'=>'NO09','size'=>1,'maxlength' => 1,'autocomplete'=>'off'])->label(false) ?></td>
    <td><?= $form->field($model, 'DEC09')->textInput(['id'=>"DEC09",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td> 
 </tr>
  <tr>
 <td><font>8</font></td>
    <td class="left"><font> Rehabilitation record * </font></td>
    <td><?= $form->field($model, 'NA10')->textInput(['id'=>'NA10','size'=>1,'maxlength' => 1, 'value'=>'N','onchange'=> 'handleNA10Chk(this)'])->label(false) ?></td>
    <td><?= $form->field($model, 'MI10')->textInput(['id'=>'MI10','size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMI10Chk(this)'])->label(false) ?></td>
    <td><?= $form->field($model, 'SC101')->textInput(['id'=>"SC101",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'SC102')->textInput(['id'=>"SC102",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'SC103')->textInput(['id'=>"SC103",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'SC104')->textInput(['id'=>"SC104",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'SC105')->textInput(['id'=>"SC105",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'SC106')->textInput(['id'=>"SC106",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'SC107')->textInput(['id'=>"SC107",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td>    
    <td><?= $form->field($model, 'NO10')->textInput(['id'=>'NO10','size'=>1,'maxlength' => 1,'autocomplete'=>'off'])->label(false) ?></td>
    <td><?= $form->field($model, 'DEC10')->textInput(['id'=>"DEC10",'size'=>1,'maxlength' => 1, 'onchange'=>'handleSCChk(this)'])->label(false) ?></td> 
 </tr>     
</table>
	<div class="table-responsive">
	
		<div class="col-md-5">
          <?= $form->field($model, 'overall_id')->widget(Select2::className(), [
                            'data' => ArrayHelper::map(Mraoverall::find()->all(),'overall_id','overall_name'),
							//['value' =>  $model->overal_id = 4]
                            'options' => [
							['value' =>  $model->overall_id = 4]
                                //'placeholder' => '<--เลือกเพียง 1 ข้อ>',
                            ],
                            'pluginOptions' =>
                                [
                                'allowClear' => true
								//'value'=>'4'
                            ],
                        ]);
                 ?>
                </div>
		<div class="col-md-6">
		<?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

            </div>
	    </div>
	</div>

    <div align="center" class="form-group">
        <?= Html::submitButton('<i class="glyphicon glyphicon-plus"></i> '.($model->isNewRecord ? 'บันทึก' : 'แก้ไข'), ['class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary').' btn-lg btn-block']) ?>
        
    </div>

    <?php ActiveForm::end(); ?>

</div>
