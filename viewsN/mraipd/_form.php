<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\datecontrol\DateControl;
use app\models\Departmetnsipd;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Mraoverall;

/* @var $this yii\web\View */
/* @var $model app\models\Mraipd */
/* @var $form yii\widgets\ActiveForm */
?>


<script language="javascript">
$(document).ready(function(){
handleChk();

function handleChk() {
    // if(NA7.value=='N'){
    //         $('#Missing7').attr("readonly", "false");
    //         $('#No7').attr("readonly", "false");
    //         $('#cr1').attr("readonly", "false");
    //         $('#cr2').attr("readonly", "false");
    //         $('#cr3').attr("readonly", "false");
    //         $('#cr4').attr("readonly", "false");
    //         $('#cr5').attr("readonly", "false");
    //         $('#cr6').attr("readonly", "false");
    //         $('#cr7').attr("readonly", "false");
    //         $('#cr8').attr("readonly", "false");
    //         $('#cr9').attr("readonly", "false");
    // }else{
    //         $('#Missing7').attr("readonly", "true");
    //         $('#No7').attr("readonly", "true");
    //         $('#cr1').attr("readonly", "true");
    //         $('#cr2').attr("readonly", "true");
    //         $('#cr3').attr("readonly", "true");
    //         $('#cr4').attr("readonly", "true");
    //         $('#cr5').attr("readonly", "true");
    //         $('#cr6').attr("readonly", "true");
    //         $('#cr7').attr("readonly", "true");
    //         $('#cr8').attr("readonly", "true");
    //         $('#cr9').attr("readonly", "true");
    // }

    // if(NA07.value=='N'){
    //         $('#MI07').attr("readonly", "false");
    //         $('#NO07').attr("readonly", "false");
    //         $('#SC071').attr("readonly", "false");
    //         $('#SC072').attr("readonly", "false");
    //         $('#SC073').attr("readonly", "false");
    //         $('#SC074').attr("readonly", "false");
    //         $('#SC075').attr("readonly", "false");
    //         $('#SC076').attr("readonly", "false");
    //         $('#SC077').attr("readonly", "false");
    //         $('#SC078').attr("readonly", "false");
    //         $('#SC079').attr("readonly", "false");
    // }else{
    //         $('#MI07').attr("readonly", "true");
    //         $('#NO07').attr("readonly", "true");
    //         $('#SC071').attr("readonly", "true");
    //         $('#SC072').attr("readonly", "true");
    //         $('#SC073').attr("readonly", "true");
    //         $('#SC074').attr("readonly", "true");
    //         $('#SC075').attr("readonly", "true");
    //         $('#SC076').attr("readonly", "true");
    //         $('#SC077').attr("readonly", "true");
    //         $('#SC078').attr("readonly", "true");
    //         $('#SC079').attr("readonly", "true");
    // }
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
function handleNA1Chk() {    
    if(NA1.value=='N'||NA1.value=='n'){
          document.getElementById("NA1").value = "N";
          document.getElementById("dxop1").value = "0"
          document.getElementById("dxop2").value = "0"
          document.getElementById("dxop3").value = "0"
          document.getElementById("dxop4").value = "0"
          document.getElementById("dxop5").value = "0"
          document.getElementById("dxop6").value = "0"
          document.getElementById("dxop7").value = "0"
          document.getElementById("dxop8").value = "0"
          document.getElementById("dxop9").value = "0"
          document.getElementById("dxop_huk").value = "0"
          document.getElementById("Missing1").readOnly = true;
          document.getElementById("No1").readOnly = true;
    }else{            
          document.getElementById("NA1").value = "-";
          document.getElementById("dxop1").value = "1";
          document.getElementById("dxop2").value = "N";
          document.getElementById("dxop3").value = "N";
          document.getElementById("dxop4").value = "N";
          document.getElementById("dxop5").value = "1";
          document.getElementById("dxop6").value = "1";
          document.getElementById("dxop7").value = "N";
          document.getElementById("dxop8").value = "1";
          document.getElementById("dxop9").value = "1";
          document.getElementById("dxop_huk").value = "0";
          document.getElementById("Missing1").readOnly = false;
          document.getElementById("No1").readOnly = false;
    }
}                             
function handleNA2Chk() {    
    if(NA2.value=='N'||NA2.value=='n'){
          document.getElementById("NA2").value = "N";
          document.getElementById("other1").value = "0"
          document.getElementById("other2").value = "0"
          document.getElementById("other3").value = "0"
          document.getElementById("other4").value = "0"
          document.getElementById("other5").value = "0"
          document.getElementById("other6").value = "0"
          document.getElementById("other7").value = "0"
          document.getElementById("other8").value = "0"
          document.getElementById("other9").value = "0"
          document.getElementById("other_huk").value = "0"
          document.getElementById("Missing2").readOnly = true;
          document.getElementById("No2").readOnly = true;
    }else{            
          document.getElementById("NA2").value = "-";
          document.getElementById("other1").value = "1";
          document.getElementById("other2").value = "1";
          document.getElementById("other3").value = "1";
          document.getElementById("other4").value = "1";
          document.getElementById("other1").value = "1";
          document.getElementById("other5").value = "1";
          document.getElementById("other6").value = "1";
          document.getElementById("other7").value = "1";
          document.getElementById("other8").value = "N";
          document.getElementById("other9").value = "N";
          document.getElementById("other_huk").value = "0";
          document.getElementById("Missing2").readOnly = false;
          document.getElementById("No2").readOnly = false;
    }
}    
function handleNA3Chk() {    
    if(NA3.value=='N'||NA3.value=='n'){
          document.getElementById("NA3").value = "N";
          document.getElementById("infc1").value = "0"
          document.getElementById("infc2").value = "0"
          document.getElementById("infc3").value = "0"
          document.getElementById("infc4").value = "0"
          document.getElementById("infc5").value = "0"
          document.getElementById("infc6").value = "0"
          document.getElementById("infc7").value = "0"
          document.getElementById("infc8").value = "0"
          document.getElementById("infc9").value = "0"
          document.getElementById("infc_huk").value = "0"
          document.getElementById("Missing3").readOnly = true;
          document.getElementById("No3").readOnly = true;
    }else{            
          document.getElementById("NA3").value = "-";
          document.getElementById("infc1").value = "1";
          document.getElementById("infc2").value = "1";
          document.getElementById("infc3").value = "1";
          document.getElementById("infc4").value = "1";
          document.getElementById("infc5").value = "1";
          document.getElementById("infc6").value = "1";
          document.getElementById("infc7").value = "1";
          document.getElementById("infc8").value = "1";
          document.getElementById("infc9").value = "1";
          document.getElementById("infc_huk").value = "0";
          document.getElementById("Missing3").readOnly = false;
          document.getElementById("No3").readOnly = false;
    }
}
function handleNA4Chk() {    
    if(NA4.value=='N'||NA4.value=='n'){
          document.getElementById("NA4").value = "N";
          document.getElementById("hist1").value = "0"
          document.getElementById("hist2").value = "0"
          document.getElementById("hist3").value = "0"
          document.getElementById("hist4").value = "0"
          document.getElementById("hist5").value = "0"
          document.getElementById("hist6").value = "0"
          document.getElementById("hist7").value = "0"
          document.getElementById("hist8").value = "0"
          document.getElementById("hist9").value = "0"
          document.getElementById("hist_huk").value = "0"
          document.getElementById("Missing4").readOnly = true;
          document.getElementById("No4").readOnly = true;
    }else{            
          document.getElementById("NA4").value = "-";
          document.getElementById("hist1").value = "1";
          document.getElementById("hist2").value = "1";
          document.getElementById("hist3").value = "1";
          document.getElementById("hist4").value = "1";
          document.getElementById("hist5").value = "1";
          document.getElementById("hist6").value = "1";
          document.getElementById("hist7").value = "1";
          document.getElementById("hist8").value = "1";
          document.getElementById("hist9").value = "1";
          document.getElementById("hist_huk").value = "0";
          document.getElementById("Missing4").readOnly = false;
          document.getElementById("No4").readOnly = false;
    }
} 
function handleNA5Chk() {    
    if(NA5.value=='N'||NA5.value=='n'){
          document.getElementById("NA5").value = "N";
          document.getElementById("pe1").value = "0"
          document.getElementById("pe2").value = "0"
          document.getElementById("pe3").value = "0"
          document.getElementById("pe4").value = "0"
          document.getElementById("pe5").value = "0"
          document.getElementById("pe6").value = "0"
          document.getElementById("pe7").value = "0"
          document.getElementById("pe8").value = "0"
          document.getElementById("pe9").value = "0"
          document.getElementById("pe_huk").value = "0"
          document.getElementById("Missing5").readOnly = true;
          document.getElementById("No5").readOnly = true;
    }else{            
          document.getElementById("NA5").value = "-";
          document.getElementById("pe1").value = "1";
          document.getElementById("pe2").value = "1";
          document.getElementById("pe3").value = "1";
          document.getElementById("pe4").value = "1";
          document.getElementById("pe5").value = "1";
          document.getElementById("pe6").value = "1";
          document.getElementById("pe7").value = "1";
          document.getElementById("pe8").value = "1";
          document.getElementById("pe9").value = "1";
          document.getElementById("pe_huk").value = "0";
          document.getElementById("Missing5").readOnly = false;
          document.getElementById("No5").readOnly = false;
    }
} 
function handleNA6Chk() {    
    if(NA6.value=='N'||NA6.value=='n'){
          document.getElementById("NA6").value = "N";
          document.getElementById("pn1").value = "0"
          document.getElementById("pn2").value = "0"
          document.getElementById("pn3").value = "0"
          document.getElementById("pn4").value = "0"
          document.getElementById("pn5").value = "0"
          document.getElementById("pn6").value = "0"
          document.getElementById("pn7").value = "0"
          document.getElementById("pn8").value = "0"
          document.getElementById("pn9").value = "0"
          document.getElementById("pn_huk").value = "0"
          document.getElementById("Missing6").readOnly = true;
          document.getElementById("No6").readOnly = true;
    }else{            
          document.getElementById("NA6").value = "-";
          document.getElementById("pn1").value = "1";
          document.getElementById("pn2").value = "1";
          document.getElementById("pn3").value = "1";
          document.getElementById("pn4").value = "1";
          document.getElementById("pn5").value = "1";
          document.getElementById("pn6").value = "1";
          document.getElementById("pn7").value = "1";
          document.getElementById("pn8").value = "1";
          document.getElementById("pn9").value = "1";
          document.getElementById("pn_huk").value = "0";
          document.getElementById("Missing6").readOnly = false;
          document.getElementById("No6").readOnly = false;
    }
} 

function handleNA7Chk() {    
    if(NA7.value=='N'||NA7.value=='n'){
          document.getElementById("NA7").value = "N";
          document.getElementById("cr1").value = "-"
        document.getElementById("cr2").value = "-"
        document.getElementById("cr3").value = "-"
        document.getElementById("cr4").value = "-"
        document.getElementById("cr5").value = "-"
        document.getElementById("cr6").value = "-"
        document.getElementById("cr7").value = "-"
        document.getElementById("cr8").value = "-"
        document.getElementById("cr9").value = "-"
          document.getElementById("Missing7").readonly = true;
          document.getElementById("No7").readonly = true;
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

function handleNA8Chk() {    
    if(NA8.value=='N'||NA8.value=='n'){
          document.getElementById("NA8").value = "N";
          document.getElementById("ar1").value = ""
        document.getElementById("ar2").value = ""
        document.getElementById("ar3").value = ""
        document.getElementById("ar4").value = ""
        document.getElementById("ar5").value = ""
        document.getElementById("ar6").value = ""
        document.getElementById("ar7").value = ""
        document.getElementById("ar8").value = ""
        document.getElementById("ar9").value = ""
          document.getElementById("Missing8").readOnly = true;
          document.getElementById("No8").readOnly = true;
          document.getElementById("ar1").readOnly = true;
          document.getElementById("ar2").readOnly = true;
          document.getElementById("ar3").readOnly = true;
          document.getElementById("car4").readOnly = true;
          document.getElementById("ar5").readOnly = true;
          document.getElementById("ar").readOnly = true;
          document.getElementById("ar7").readOnly = true;
          document.getElementById("ar8").readOnly = true;
          document.getElementById("ar9").readOnly = true;
       
    }else{            
          document.getElementById("NA8").value = "-";
          document.getElementById("ar1").value = "1";
        document.getElementById("ar2").value = "1";
        document.getElementById("ar3").value = "1";
        document.getElementById("ar4").value = "1";
        document.getElementById("ar5").value = "1";
        document.getElementById("ar6").value = "1";
        document.getElementById("ar7").value = "1";
        document.getElementById("ar8").value = "1";
        document.getElementById("ar9").value = "1";
          document.getElementById("Missing8").readOnly = false;
          document.getElementById("No8").readOnly = false;
          document.getElementById("ar1").readOnly = false;
          document.getElementById("ar2").readOnly = false;
          document.getElementById("ar3").readOnly = false;
          document.getElementById("ar4").readOnly = false;
          document.getElementById("ar5").readOnly = false;
          document.getElementById("ar6").readOnly = false;
          document.getElementById("ar7").readOnly = false;
          document.getElementById("ar8").readOnly = false;
          document.getElementById("ar9").readOnly = false;        
        
    }
}  

function handleNA9Chk() {  
    if(NA9.value=='N'||NA9.value=='n'){
          document.getElementById("NA9").value = "N";
          document.getElementById("on1").value = ""
          document.getElementById("on2").value = ""
          document.getElementById("on3").value = ""
          document.getElementById("on4").value = ""
          document.getElementById("on5").value = ""
          document.getElementById("on6").value = ""
          document.getElementById("on7").value = ""
          document.getElementById("on8").value = ""
          document.getElementById("on9").value = ""
          document.getElementById("Missing9").readOnly = true;
          document.getElementById("NO9").readOnly = true;
          document.getElementById("on1").readOnly = true;
          document.getElementById("on2").readOnly = true;
          document.getElementById("on3").readOnly = true;
          document.getElementById("on4").readOnly = true;
          document.getElementById("on5").readOnly = true;
          document.getElementById("on6").readOnly = true;
          document.getElementById("on7").readOnly = true;
          document.getElementById("on8").readOnly = true;
          document.getElementById("on9").readOnly = true;
       
    }else{ 
          document.getElementById("NA9").value = "-";
          document.getElementById("on1").value = "1";
          document.getElementById("on2").value = "1";
          document.getElementById("on3").value = "1";
          document.getElementById("on4").value = "1";
          document.getElementById("on5").value = "1";
          document.getElementById("on6").value = "1";
          document.getElementById("on7").value = "1";
          document.getElementById("on8").value = "1";
          document.getElementById("on9").value = "1";        
          document.getElementById("Missing9").readOnly = false;
          document.getElementById("NO9").readOnly = false;
          document.getElementById("on1").readOnly = false;
          document.getElementById("on2").readOnly = false;
          document.getElementById("on3").readOnly = false;
          document.getElementById("on4").readOnly = false;
          document.getElementById("on5").readOnly = false;
          document.getElementById("on6").readOnly = false;
          document.getElementById("on7").readOnly = false;
          document.getElementById("on8").readOnly = false;
          document.getElementById("on9").readOnly = false;
       
     }
}  
function handleNA10Chk() {  
    if(NA10.value=='N'||NA10.value=='n'){
          document.getElementById("NA10").value = "N";
          document.getElementById("lr1").value = ""
        document.getElementById("lr2").value = ""
        document.getElementById("lr3").value = ""
        document.getElementById("lr4").value = ""
        document.getElementById("lr5").value = ""
        document.getElementById("lr6").value = ""
        document.getElementById("lr7").value = ""
        document.getElementById("lr8").value = ""
        document.getElementById("lr9").value = ""
          document.getElementById("Missing10").readOnly = true;
          document.getElementById("NO10").readOnly = true;
          document.getElementById("lr1").readOnly = true;
          document.getElementById("lr2").readOnly = true;
          document.getElementById("lr3").readOnly = true;
          document.getElementById("lr4").readOnly = true;
          document.getElementById("lr5").readOnly = true;
          document.getElementById("lr6").readOnly = true;
          document.getElementById("lr7").readOnly = true;
          document.getElementById("lr8").readOnly = true;
          document.getElementById("lr9").readOnly = true;
      
    }else{            
          document.getElementById("NA10").value = "-";
          document.getElementById("lr1").value = "1";
        document.getElementById("lr2").value = "1";
        document.getElementById("lr3").value = "1";
        document.getElementById("lr4").value = "1";
        document.getElementById("lr5").value = "1";
        document.getElementById("lr6").value = "1";
        document.getElementById("lr7").value = "1";
        document.getElementById("lr8").value = "1";
        document.getElementById("lr9").value = "1";
          document.getElementById("Missing10").readOnly = false;
          document.getElementById("NO10").readOnly = false;
          document.getElementById("lr1").readOnly = false;
          document.getElementById("lr2").readOnly = false;
          document.getElementById("lr3").readOnly = false;
          document.getElementById("lr4").readOnly = false;
          document.getElementById("lr5").readOnly = false;
          document.getElementById("lr6").readOnly = false;
          document.getElementById("lr7").readOnly = false;
          document.getElementById("lr8").readOnly = false;
          document.getElementById("lr9").readOnly = false;
        
     }
}  
function handleNA11Chk() {  
    if(NA11.value=='N'||NA11.value=='n'){
          document.getElementById("NA11").value = "N";
          document.getElementById("rr1").value = ""
          document.getElementById("rr2").value = ""
          document.getElementById("rr3").value = ""
          document.getElementById("rr4").value = ""
          document.getElementById("rr5").value = ""
          document.getElementById("rr6").value = ""
          document.getElementById("rr7").value = ""
          document.getElementById("rr8").value = ""
          document.getElementById("rr9").value = ""
          document.getElementById("Missing11").readOnly = true;
          document.getElementById("NO11").readOnly = true;
          document.getElementById("rr1").readOnly = true;
          document.getElementById("rr2").readOnly = true;
          document.getElementById("rr3").readOnly = true;
          document.getElementById("rr4").readOnly = true;
          document.getElementById("rr5").readOnly = true;
          document.getElementById("rr6").readOnly = true;
          document.getElementById("rr7").readOnly = true;
          document.getElementById("rr8").readOnly = true;
          document.getElementById("rr9").readOnly = true;
        
    }else{
          document.getElementById("NA11").value = "-";
          document.getElementById("rr1").value = "1";
        document.getElementById("rr2").value = "1";
        document.getElementById("rr3").value = "1";
        document.getElementById("rr4").value = "1";
        document.getElementById("rr5").value = "1";
        document.getElementById("rr6").value = "1";
        document.getElementById("rr7").value = "1";
        document.getElementById("rr8").value = "1";
        document.getElementById("rr9").value = "1";
          document.getElementById("Missing11").readOnly = false;
          document.getElementById("NO11").readOnly = false;
          document.getElementById("rr1").readOnly = false;
          document.getElementById("rr2").readOnly = false;
          document.getElementById("rr3").readOnly = false;
          document.getElementById("rr4").readOnly = false;
          document.getElementById("rr5").readOnly = false;
          document.getElementById("rr6").readOnly = false;
          document.getElementById("rr7").readOnly = false;
          document.getElementById("rr8").readOnly = false;
          document.getElementById("rr9").readOnly = false;
      
    }
}
function handleNA12Chk() {    
    if(NA12.value=='N'||NA12.value=='n'){
          document.getElementById("NA1").value = "N";
          document.getElementById("nn1").value = "0"
          document.getElementById("nn2").value = "0"
          document.getElementById("nn3").value = "0"
          document.getElementById("nn4").value = "0"
          document.getElementById("nn5").value = "0"
          document.getElementById("nn6").value = "0"
          document.getElementById("nn7").value = "0"
          document.getElementById("nn8").value = "0"
          document.getElementById("nn9").value = "0"
          document.getElementById("nn_huk").value = "0"
          document.getElementById("Missing12").readOnly = true;
          document.getElementById("No12").readOnly = true;
    }else{            
          document.getElementById("NA12").value = "-";
          document.getElementById("nn1").value = "1";
          document.getElementById("nn2").value = "1";
          document.getElementById("nn3").value = "1";
          document.getElementById("nn4").value = "1";
          document.getElementById("nn5").value = "1";
          document.getElementById("nn6").value = "1";
          document.getElementById("nn7").value = "1";
          document.getElementById("nn8").value = "1";
          document.getElementById("nn9").value = "1";
          document.getElementById("nn_huk").value = "0";
          document.getElementById("Missing12").readOnly = false;
          document.getElementById("No12").readOnly = false;
    }
}                             

function handleMI01Chk() {         
    if(Missing1.value=='M'||Missing1.value=='m'){
        document.getElementById("Missing1").value = "M";
        document.getElementById("NO1").value = "-";
        document.getElementById("dxop1").value = "0";
        document.getElementById("dxop2").value = "0";
        document.getElementById("dxop3").value = "0";
        document.getElementById("dxop4").value = "0";
        document.getElementById("dxop5").value = "0";
        document.getElementById("dxop6").value = "0";
        document.getElementById("dxop7").value = "0";
        document.getElementById("dxop8").value = "0";
        document.getElementById("dxop9").value = "0";
        document.getElementById("NO1").readOnly = true;
        document.getElementById("dxop1").readOnly = true;
        document.getElementById("dxop2").readOnly = true;
        document.getElementById("dxop3").readOnly = true;
        document.getElementById("dxop4").readOnly = true;
        document.getElementById("dxop5").readOnly = true;
        document.getElementById("dxop6").readOnly = true;
        document.getElementById("dxop7").readOnly = true;
        document.getElementById("dxop8").readOnly = true;
        document.getElementById("dxop9").readOnly = true;
        
    }else{            
        document.getElementById("Missing1").value = "-";
        document.getElementById("dxop1").value = "1";
        document.getElementById("dxop2").value = "1";
        document.getElementById("dxop3").value = "1";
        document.getElementById("dxop4").value = "1";
        document.getElementById("dxop5").value = "1";
        document.getElementById("dxop6").value = "1";
        document.getElementById("dxop7").value = "1";
        document.getElementById("dxop8").value = "1";
        document.getElementById("dxop9").value = "1";
        document.getElementById("NO1").readOnly = false;
        document.getElementById("dxop1").readOnly = false;
        document.getElementById("dxop2").readOnly = false;
        document.getElementById("dxop3").readOnly = false;
        document.getElementById("dxop4").readOnly = false;
        document.getElementById("dxop5").readOnly = false;
        document.getElementById("dxop6").readOnly = false;
        document.getElementById("dxop7").readOnly = false;
        document.getElementById("dxop8").readOnly = false;
        document.getElementById("dxop9").readOnly = false;
               
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
 function handleMI07Chk() {   
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
 
 function handleMI08Chk() {   
    if(Missing8.value=='M'||Missing8.value=='m'){
        document.getElementById("Missing8").value = "M";
        document.getElementById("NO8").value = "-";
        document.getElementById("ar1").value = "0";
        document.getElementById("ar2").value = "0";
        document.getElementById("ar3").value = "0";
        document.getElementById("ar4").value = "0";
        document.getElementById("ar5").value = "0";
        document.getElementById("ar6").value = "0";
        document.getElementById("ar7").value = "0";
        document.getElementById("ar8").value = "0";
        document.getElementById("ar9").value = "0";
        document.getElementById("NO8").readOnly = true;
        document.getElementById("ar1").readOnly = true;
        document.getElementById("ar2").readOnly = true;
        document.getElementById("ar3").readOnly = true;
        document.getElementById("ar4").readOnly = true;
        document.getElementById("ar5").readOnly = true;
        document.getElementById("ar6").readOnly = true;
        document.getElementById("ar7").readOnly = true;
        document.getElementById("ar8").readOnly = true;
        document.getElementById("ar9").readOnly = true;
    }else{            
        document.getElementById("Missing8").value = "-";
        document.getElementById("ar1").value = "1";
        document.getElementById("ar2").value = "1";
        document.getElementById("ar3").value = "1";
        document.getElementById("ar4").value = "1";
        document.getElementById("ar5").value = "1";
        document.getElementById("ar6").value = "1";
        document.getElementById("ar7").value = "1";
        document.getElementById("ar8").value = "1";
        document.getElementById("ar9").value = "1";    
        document.getElementById("NO8").readOnly = false;
        document.getElementById("ar1").readOnly = false;
        document.getElementById("ar2").readOnly = false;
        document.getElementById("ar3").readOnly = false;
        document.getElementById("ar4").readOnly = false;
        document.getElementById("ar5").readOnly = false;
        document.getElementById("ar6").readOnly = false;
        document.getElementById("ar7").readOnly = false;
        document.getElementById("ar8").readOnly = false;
        document.getElementById("ar9").readOnly = false;   
    } 
 }                            
 function handleMI09Chk() {   
    if(Missing9.value=='M'||Missing9.value=='m'){
        document.getElementById("Missing9").value = "M";
        document.getElementById("NO9").value = "-";
        document.getElementById("on1").value = "0";
        document.getElementById("on2").value = "0";
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
 function handleMI10Chk() {   
    if(Missing10.value=='M'||Missing10.value=='m'){
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
 function handleMI11Chk() {   
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
 function handleMI12Chk() {   
    if(Missing12.value=='M'||Missing12.value=='m'){
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
function handleNO9Chk() {    
    if(NO9.value=='O'||NO9.value=='o'){
        document.getElementById("NO9").value = "O";
        document.getElementById("on1").value = "0";
        document.getElementById("on2").value = "0";
        document.getElementById("on3").value = "0";
        document.getElementById("on4").value = "0";
        document.getElementById("on5").value = "0";
        document.getElementById("on6").value = "0";
        document.getElementById("on7").value = "0";
        document.getElementById("on8").value = "0";
        document.getElementById("on9").value = "0";
          document.getElementById("Missing9").readOnly = true;
          document.getElementById("on1").readOnly = true;
          document.getElementById("on2").readOnly = true;
          document.getElementById("on3").readOnly = true;
          document.getElementById("on4").readOnly = true;
          document.getElementById("on5").readOnly = true;
          document.getElementById("on6").readOnly = true;
          document.getElementById("on7").readOnly = true;
          document.getElementById("on8").readOnly = true;
          document.getElementById("on9").readOnly = true;
    }else{            
        document.getElementById("NO9").value = "-";
        document.getElementById("on1").value = "1";
        document.getElementById("on2").value = "1";
        document.getElementById("on3").value = "1";
        document.getElementById("on4").value = "1";
        document.getElementById("on5").value = "1";
        document.getElementById("on6").value = "1";
        document.getElementById("on7").value = "1";
        document.getElementById("on8").value = "1";
        document.getElementById("on9").value = "1";
          document.getElementById("Missing9").readOnly = false;
          document.getElementById("on1").readOnly = false;
          document.getElementById("on2").readOnly = false;
          document.getElementById("on3").readOnly = false;
          document.getElementById("on4").readOnly = false;
          document.getElementById("on5").readOnly = false;
          document.getElementById("on6").readOnly = false;
          document.getElementById("on7").readOnly = false;
          document.getElementById("on8").readOnly = false;
          document.getElementById("on9").readOnly = false;
    }    
}
function handleNO10Chk() {    
    if(NO10.value=='O'||NO10.value=='o'){
        document.getElementById("NO10").value = "O";
        document.getElementById("lr1").value = "0";
        document.getElementById("lr2").value = "0";
        document.getElementById("lr3").value = "0";
        document.getElementById("lr4").value = "0";
        document.getElementById("lr5").value = "0";
        document.getElementById("lr6").value = "0";
        document.getElementById("lr7").value = "0";
        document.getElementById("lr8").value = "0";
        document.getElementById("lr9").value = "0";
          document.getElementById("Missing10").readOnly = true;
          document.getElementById("lr1").readOnly = true;
          document.getElementById("lr2").readOnly = true;
          document.getElementById("lr3").readOnly = true;
          document.getElementById("lr4").readOnly = true;
          document.getElementById("lr5").readOnly = true;
          document.getElementById("lr6").readOnly = true;
          document.getElementById("lr7").readOnly = true;
          document.getElementById("Slr8").readOnly = true;
          document.getElementById("lr9").readOnly = true;
    }else{            
        document.getElementById("NO10").value = "-";
        document.getElementById("lr1").value = "1";
        document.getElementById("lr2").value = "1";
        document.getElementById("lr3").value = "1";
        document.getElementById("lr4").value = "1";
        document.getElementById("lr5").value = "1";
        document.getElementById("lr6").value = "1";
        document.getElementById("lr7").value = "1";
        document.getElementById("lr8").value = "1";
        document.getElementById("lr9").value = "1";
          document.getElementById("Missing10").readOnly = false;
          document.getElementById("lr1").readOnly = false;
          document.getElementById("lr2").readOnly = false;
          document.getElementById("lr3").readOnly = false;
          document.getElementById("lr4").readOnly = false;
          document.getElementById("lr5").readOnly = false;
          document.getElementById("lr6").readOnly = false;
          document.getElementById("lr7").readOnly = false;
          document.getElementById("lr8").readOnly = false;
          document.getElementById("lr9").readOnly = false;
    }    
}
function handleNO11Chk() {     
    if(NO11.value=='O'||NO11.value=='o'){
        document.getElementById("NO11").value = "O";
        document.getElementById("rr1").value = "0";
        document.getElementById("rr2").value = "0";
        document.getElementById("rr3").value = "0";
        document.getElementById("rr4").value = "0";
        document.getElementById("rr5").value = "0";
        document.getElementById("rr6").value = "0";
        document.getElementById("rr7").value = "0";
        document.getElementById("rr8").value = "0";
        document.getElementById("rr9").value = "0";
          document.getElementById("Missing11").readOnly = true;
          document.getElementById("rr1").readOnly = true;
          document.getElementById("rr2").readOnly = true;
          document.getElementById("rr3").readOnly = true;
          document.getElementById("rr4").readOnly = true;
          document.getElementById("rr5").readOnly = true;
          document.getElementById("rr6").readOnly = true;
          document.getElementById("rr7").readOnly = true;
          document.getElementById("rr8").readOnly = true;
          document.getElementById("rr19").readOnly = true;
    }else{            
        document.getElementById("NO11").value = "-";
        document.getElementById("rr1").value = "1";
        document.getElementById("rr2").value = "1";
        document.getElementById("rr3").value = "1";
        document.getElementById("rr4").value = "1";
        document.getElementById("rr5").value = "1";
        document.getElementById("rr6").value = "1";
        document.getElementById("rr7").value = "1";
        document.getElementById("rr18").value = "1";
        document.getElementById("rr9").value = "1";
          document.getElementById("Missing11").readOnly = false;
          document.getElementById("rr1").readOnly = false;
          document.getElementById("rr2").readOnly = false;
          document.getElementById("rr3").readOnly = false;
          document.getElementById("rr4").readOnly = false;
          document.getElementById("rr5").readOnly = false;
          document.getElementById("rr6").readOnly = false;
          document.getElementById("rr7").readOnly = false;
          document.getElementById("rr8").readOnly = false;
          document.getElementById("rr9").readOnly = false;
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

function handleSC1Chk() {     
       
        if(dxop1.value=='N'||dxop1.value=='n'||dxop1.value=='1'||dxop1.value=='0'||NA1.value=='-'){  }else{ document.getElementById("dxop1").value = "1"; }
        if(dxop2.value=='N'||dxop2.value=='n'||dxop2.value=='1'||dxop2.value=='0'||NA1.value=='-'){  }else{ document.getElementById("dxop2").value = "1"; }
        if(dxop3.value=='N'||dxop3.value=='n'||dxop3.value=='1'||dxop3.value=='0'||NA1.value=='-'){  }else{ document.getElementById("dxop3").value = "1"; }
        if(dxop4.value=='N'||dxop4.value=='n'||dxop4.value=='1'||dxop4.value=='0'||NA1.value=='-'){  }else{ document.getElementById("dxop4").value = "1"; }
        if(dxop5.value=='N'||dxop5.value=='n'||dxop5.value=='1'||dxop5.value=='0'||NA1.value=='-'){  }else{ document.getElementById("dxop5").value = "1"; }
        if(dxop6.value=='N'||dxop6.value=='n'||dxop6.value=='1'||dxop6.value=='0'||NA1.value=='-'){  }else{ document.getElementById("dxop6").value = "1"; }
        if(dxop7.value=='N'||dxop7.value=='n'||dxop7.value=='1'||dxop7.value=='0'||NA1.value=='-'){  }else{ document.getElementById("dxop7").value = "1"; }
        if(dxop8.value=='N'||dxop8.value=='n'||dxop8.value=='1'||dxop8.value=='0'||NA1.value=='-'){  }else{ document.getElementById("dxop8").value = "1"; }
        if(dxop9.value=='N'||dxop9.value=='n'||dxop9.value=='1'||dxop9.value=='0'||NA1.value=='-'){  }else{ document.getElementById("dxop9").value = "1"; }
        if(dxop_huk.value=='N'||dxop_huk.value=='n'||dxop_huk.value=='1'||dxop_huk.value=='0'||NA1.value=='-'){  }else{ document.getElementById("dxop_huk").value = "0"; }

        if(other1.value=='N'||other1.value=='n'||other1.value=='1'||other1.value=='0'||NA2.value=='-'){  }else{ document.getElementById("other1").value = "1"; }
        if(other2.value=='N'||other1.value=='n'||other2.value=='1'||other1.value=='0'||NA2.value=='-'){  }else{ document.getElementById("other1").value = "1"; }
        if(other3.value=='N'||other1.value=='n'||other3.value=='1'||other1.value=='0'||NA2.value=='-'){  }else{ document.getElementById("other1").value = "1"; }
        if(other4.value=='N'||other1.value=='n'||other4.value=='1'||other1.value=='0'||NA2.value=='-'){  }else{ document.getElementById("other1").value = "1"; }
        if(other5.value=='N'||other1.value=='n'||other5.value=='1'||other1.value=='0'||NA2.value=='-'){  }else{ document.getElementById("other1").value = "1"; }
        if(other6.value=='N'||other1.value=='n'||other6.value=='1'||other1.value=='0'||NA2.value=='-'){  }else{ document.getElementById("other1").value = "1"; }
        if(other7.value=='N'||other1.value=='n'||other7.value=='1'||other1.value=='0'||NA2.value=='-'){  }else{ document.getElementById("other1").value = "1"; }
        if(other8.value=='N'||other1.value=='n'||other8.value=='1'||other1.value=='0'||NA2.value=='-'){  }else{ document.getElementById("other1").value = "1"; }
        if(other9.value=='N'||other1.value=='n'||other9.value=='1'||other1.value=='0'||NA2.value=='-'){  }else{ document.getElementById("other1").value = "1"; }
        if(other_huk.value=='N'||other_huk.value=='n'||other_huk.value=='1'||other_huk.value=='0'||NA2.value=='-'){  }else{ document.getElementById("other_huk").value = "0"; }
        
        if(infc1.value=='N'||infc1.value=='n'||infc1.value=='1'||infc1.value=='0'||NA3.value=='-'){  }else{ document.getElementById("infc1").value = "1"; }
        if(infc2.value=='N'||infc2.value=='n'||infc2.value=='1'||infc2.value=='0'||NA3.value=='-'){  }else{ document.getElementById("infc2").value = "1"; }
        if(infc3.value=='N'||infc3.value=='n'||infc3.value=='1'||infc3.value=='0'||NA3.value=='-'){  }else{ document.getElementById("infc3").value = "1"; }
        if(infc4.value=='N'||infc4.value=='n'||infc4.value=='1'||infc4.value=='0'||NA3.value=='-'){  }else{ document.getElementById("infc4").value = "1"; }
        if(infc5.value=='N'||infc5.value=='n'||infc5.value=='1'||infc5.value=='0'||NA3.value=='-'){  }else{ document.getElementById("infc5").value = "1"; }
        if(infc6.value=='N'||infc6.value=='n'||infc6.value=='1'||infc6.value=='0'||NA3.value=='-'){  }else{ document.getElementById("infc6").value = "1"; }
        if(infc7.value=='N'||infc7.value=='n'||infc7.value=='1'||infc7.value=='0'||NA3.value=='-'){  }else{ document.getElementById("infc7").value = "1"; }
        if(infc8.value=='N'||infc8.value=='n'||infc8.value=='1'||infc8.value=='0'||NA3.value=='-'){  }else{ document.getElementById("infc8").value = "1"; }
        if(infc9.value=='N'||infc9.value=='n'||infc9.value=='1'||infc9.value=='0'||NA3.value=='-'){  }else{ document.getElementById("infc9").value = "1"; }
        if(infc_huk.value=='N'||infc_huk.value=='n'||infc_huk.value=='1'||infc_huk.value=='0'||NA3.value=='-'){  }else{ document.getElementById("infc_huk").value = "0"; }

        if(hist1.value=='N'||hist1.value=='n'||hist1.value=='1'||hist1.value=='0'||NA4.value=='-'){  }else{ document.getElementById("hist1").value = "1"; }
        if(hist2.value=='N'||hist2.value=='n'||hist2.value=='1'||hist2.value=='0'||NA4.value=='-'){  }else{ document.getElementById("hist2").value = "1"; }
        if(hist3.value=='N'||hist3.value=='n'||hist3.value=='1'||hist3.value=='0'||NA4.value=='-'){  }else{ document.getElementById("hist3").value = "1"; }
        if(hist4.value=='N'||hist4.value=='n'||hist4.value=='1'||hist4.value=='0'||NA4.value=='-'){  }else{ document.getElementById("hist4").value = "1"; }
        if(hist5.value=='N'||hist5.value=='n'||hist5.value=='1'||hist5.value=='0'||NA4.value=='-'){  }else{ document.getElementById("hist5").value = "1"; }
        if(hist6.value=='N'||hist6.value=='n'||hist6.value=='1'||hist6.value=='0'||NA4.value=='-'){  }else{ document.getElementById("hist6").value = "1"; }
        if(hist7.value=='N'||hist7.value=='n'||hist7.value=='1'||hist7.value=='0'||NA4.value=='-'){  }else{ document.getElementById("hist7").value = "1"; }
        if(hist8.value=='N'||hist8.value=='n'||hist8.value=='1'||hist8.value=='0'||NA4.value=='-'){  }else{ document.getElementById("hist8").value = "1"; }
        if(hist9.value=='N'||hist9.value=='n'||hist9.value=='1'||hist9.value=='0'||NA4.value=='-'){  }else{ document.getElementById("hist9").value = "1"; }
        if(hist_huk.value=='N'||hist_huk.value=='n'||hist_huk.value=='1'||hist_huk.value=='0'||NA4.value=='-'){  }else{ document.getElementById("hist_huk").value = "0"; }

        if(pn1.value=='N'||pn1.value=='n'||pn1.value=='1'||pn.value=='0'||NA6.value=='-'){  }else{ document.getElementById("pn1").value = "1"; }
        if(pn2.value=='N'||pn2.value=='n'||pn2.value=='1'||pn2.value=='0'||NA46.value=='-'){  }else{ document.getElementById("pn2").value = "1"; }
        if(hist3.value=='N'||hist3.value=='n'||hist3.value=='1'||hist3.value=='0'||NA4.value=='-'){  }else{ document.getElementById("hist3").value = "1"; }
        if(hist4.value=='N'||hist4.value=='n'||hist4.value=='1'||hist4.value=='0'||NA4.value=='-'){  }else{ document.getElementById("hist4").value = "1"; }
        if(hist5.value=='N'||hist5.value=='n'||hist5.value=='1'||hist5.value=='0'||NA4.value=='-'){  }else{ document.getElementById("hist5").value = "1"; }
        if(hist6.value=='N'||hist6.value=='n'||hist6.value=='1'||hist6.value=='0'||NA4.value=='-'){  }else{ document.getElementById("hist6").value = "1"; }
        if(hist7.value=='N'||hist7.value=='n'||hist7.value=='1'||hist7.value=='0'||NA4.value=='-'){  }else{ document.getElementById("hist7").value = "1"; }
        if(hist8.value=='N'||hist8.value=='n'||hist8.value=='1'||hist8.value=='0'||NA4.value=='-'){  }else{ document.getElementById("hist8").value = "1"; }
        if(hist9.value=='N'||hist9.value=='n'||hist9.value=='1'||hist9.value=='0'||NA4.value=='-'){  }else{ document.getElementById("hist9").value = "1"; }
        if(hist_huk.value=='N'||hist_huk.value=='n'||hist_huk.value=='1'||hist_huk.value=='0'||NA4.value=='-'){  }else{ document.getElementById("hist_huk").value = "0"; }


        if(cr1.value=='N'||cr1.value=='n'||cr1.value=='1'||cr1.value=='0'||NA7.value=='N'){  }else{ document.getElementById("cr1").value = "0"; }
        if(cr2.value=='N'||cr2.value=='n'||cr2.value=='1'||cr2.value=='0'||NA7.value=='N'){  }else{ document.getElementById("cr2").value = "0"; }
        if(cr3.value=='N'||cr3.value=='n'||cr3.value=='1'||cr3.value=='0'||NA7.value=='N'){  }else{ document.getElementById("cr3").value = "0"; }
        if(cr4.value=='N'||cr4.value=='n'||cr4.value=='1'||cr4.value=='0'||NA7.value=='N'){  }else{ document.getElementById("cr4").value = "0"; }
        if(cr5.value=='N'||cr5.value=='n'||cr5.value=='1'||cr5.value=='0'||NA7.value=='N'){  }else{ document.getElementById("cr5").value = "0"; }
        if(cr6.value=='N'||cr6.value=='n'||cr6.value=='1'||cr6.value=='0'||NA7.value=='N'){  }else{ document.getElementById("cr6").value = "0"; }
        if(cr7.value=='N'||cr7.value=='n'||cr7.value=='1'||cr7.value=='0'||NA7.value=='N'){  }else{ document.getElementById("cr7").value = "0"; }
        if(cr8.value=='N'||cr8.value=='n'||cr8.value=='1'||cr8.value=='0'||NA7.value=='N'){  }else{ document.getElementById("cr8").value = "0"; }
        if(cr9.value=='N'||cr9.value=='n'||cr9.value=='1'||cr9.value=='0'||NA7.value=='N'){  }else{ document.getElementById("cr9").value = "0"; }

        if(ar1.value=='N'||ar1.value=='n'||ar1.value=='1'||ar1.value=='0'||NA8.value=='N'){  }else{ document.getElementById("ar1").value = "0"; }
        if(ar2.value=='N'||ar2.value=='n'||ar2.value=='1'||ar2.value=='0'||NA8.value=='N'){  }else{ document.getElementById("ar2").value = "0"; }
        if(ar3.value=='N'||ar3.value=='n'||ar3.value=='1'||ar3.value=='0'||NA8.value=='N'){  }else{ document.getElementById("ar3").value = "0"; }
        if(ar4.value=='N'||ar4.value=='n'||ar4.value=='1'||ar4.value=='0'||NA8.value=='N'){  }else{ document.getElementById("ar4").value = "0"; }
        if(ar5.value=='N'||ar5.value=='n'||ar5.value=='1'||ar5.value=='0'||NA8.value=='N'){  }else{ document.getElementById("ar5").value = "0"; }
        if(ar6.value=='N'||ar6.value=='n'||ar6.value=='1'||ar6.value=='0'||NA8.value=='N'){  }else{ document.getElementById("ar6").value = "0"; }
        if(ar7.value=='N'||ar7.value=='n'||ar7.value=='1'||ar7.value=='0'||NA8.value=='N'){  }else{ document.getElementById("ar7").value = "0"; }
        if(ar8.value=='N'||ar8.value=='n'||ar8.value=='1'||ar8.value=='0'||NA8.value=='N'){  }else{ document.getElementById("ar8").value = "0"; }
        if(ar9.value=='N'||ar9.value=='n'||ar9.value=='1'||ar9.value=='0'||NA8.value=='N'){  }else{ document.getElementById("ar9").value = "0"; }

        if(on1.value=='N'||on1.value=='n'||on1.value=='1'||on1.value=='0'||NA9.value=='N'){  }else{ document.getElementById("on1").value = "0"; }
        if(on2.value=='N'||on2.value=='n'||on2.value=='1'||on2.value=='0'||NA9.value=='N'){  }else{ document.getElementById("on2").value = "0"; }
        if(on3.value=='N'||on3.value=='n'||on3.value=='1'||on3.value=='0'||NA9.value=='N'){  }else{ document.getElementById("on3").value = "0"; }
        if(on4.value=='N'||on4.value=='n'||on4.value=='1'||on4.value=='0'||NA9.value=='N'){  }else{ document.getElementById("on4").value = "0"; }
        if(on5.value=='N'||on5.value=='n'||on5.value=='1'||on5.value=='0'||NA9.value=='N'){  }else{ document.getElementById("on5").value = "0"; }
        if(on6.value=='N'||on6.value=='n'||on6.value=='1'||on6.value=='0'||NA9.value=='N'){  }else{ document.getElementById("on6").value = "0"; }
        if(on7.value=='N'||on7.value=='n'||on7.value=='1'||on7.value=='0'||NA9.value=='N'){  }else{ document.getElementById("on7").value = "0"; }
        if(on8.value=='N'||on8.value=='n'||on8.value=='1'||on8.value=='0'||NA9.value=='N'){  }else{ document.getElementById("on8").value = "0"; }
        if(on9.value=='N'||on9.value=='n'||on9.value=='1'||on9.value=='0'||NA9.value=='N'){  }else{ document.getElementById("on9").value = "0"; }

        if(lr1.value=='N'||lr1.value=='n'||lr1.value=='1'||lr1.value=='0'||NA10.value=='N'){  }else{ document.getElementById("lr1").value = "0"; }
        if(lr2.value=='N'||lr2.value=='n'||lr2.value=='1'||lr2.value=='0'||NA10.value=='N'){  }else{ document.getElementById("lr2").value = "0"; }
        if(lr3.value=='N'||lr3.value=='n'||lr3.value=='1'||lr3.value=='0'||NA10.value=='N'){  }else{ document.getElementById("lr3").value = "0"; }
        if(lr4.value=='N'||lr4.value=='n'||lr4.value=='1'||lr4.value=='0'||NA10.value=='N'){  }else{ document.getElementById("lr4").value = "0"; }
        if(lr5.value=='N'||lr5.value=='n'||lr5.value=='1'||lr5.value=='0'||NA10.value=='N'){  }else{ document.getElementById("lr5").value = "0"; }
        if(lr6.value=='N'||lr6.value=='n'||lr6.value=='1'||lr6.value=='0'||NA10.value=='N'){  }else{ document.getElementById("lr6").value = "0"; }
        if(lr7.value=='N'||lr7.value=='n'||lr7.value=='1'||lr7.value=='0'||NA10.value=='N'){  }else{ document.getElementById("lr7").value = "0"; }
        if(lr8.value=='N'||lr8.value=='n'||lr8.value=='1'||lr8.value=='0'||NA10.value=='N'){  }else{ document.getElementById("lr8").value = "0"; }
        if(lr9.value=='N'||lr9.value=='n'||lr9.value=='1'||lr9.value=='0'||NA10.value=='N'){  }else{ document.getElementById("lr9").value = "0"; }

        if(rr1.value=='N'||rr1.value=='n'||rr1.value=='1'||rr1.value=='0'||NA11.value=='N'){  }else{ document.getElementById("rr1").value = "0"; }
        if(rr2.value=='N'||rr2.value=='n'||rr2.value=='1'||rr2.value=='0'||NA11.value=='N'){  }else{ document.getElementById("rr2").value = "0"; }
        if(rr3.value=='N'||rr3.value=='n'||rr3.value=='1'||rr3.value=='0'||NA11.value=='N'){  }else{ document.getElementById("rr3").value = "0"; }
        if(rr4.value=='N'||rr4.value=='n'||rr4.value=='1'||rr4.value=='0'||NA11.value=='N'){  }else{ document.getElementById("rr4").value = "0"; }
        if(rr5.value=='N'||rr5.value=='n'||rr5.value=='1'||rr5.value=='0'||NA11.value=='N'){  }else{ document.getElementById("rr5").value = "0"; }
        if(rr6.value=='N'||rr6.value=='n'||rr6.value=='1'||rr6.value=='0'||NA11.value=='N'){  }else{ document.getElementById("rr6").value = "0"; }
        if(rr7.value=='N'||rr7.value=='n'||rr7.value=='1'||rr7.value=='0'||NA11.value=='N'){  }else{ document.getElementById("rr7").value = "0"; }
        if(rr8.value=='N'||rr8.value=='n'||rr8.value=='1'||rr8.value=='0'||NA11.value=='N'){  }else{ document.getElementById("rr8").value = "0"; }
        if(rr9.value=='N'||rr9.value=='n'||rr9.value=='1'||rr9.value=='0'||NA11.value=='N'){  }else{ document.getElementById("rr9").value = "0"; }


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

$("#date_admit").kvDatepicker("update", new Date(2010, 12, 01));

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


<div class="mraipd-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $form = ActiveForm::begin(); ?>
<div class="mraipd-form">

    <div class="well">
    <div class="table-responsive">
      <div class="row">
           <div class="col-md-2">
           <?= $form->field($model, 'hospcode')->textInput(['maxlength' => true,'value'=>'10953']) ?>
          </div>
          <div class="col-md-2">
          <?= $form->field($model, 'unit_id')->widget(Select2::className(), [
                            'data' => ArrayHelper::map(Departmetnsipd::find()->all(),'unit_id','unit_name'),
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
          <div class="col-md-1">
          <?= $form->field($model, 'HN')->textInput(['maxlength' => 6]) ?>
          </div>
          <div class="col-md-1">
          <?= $form->field($model, 'AN')->textInput(['maxlength' => 6]) ?>
          </div>
          <div class="col-md-1">
          <?= $form->field($model, 'visits')->textInput(['maxlength' => 2]) ?>
          </div>
          <!-- <div class="col-md-2">
          <?= $form->field($model, 'dr_license')->textInput(['maxlength' =>true]) ?>
          </div> -->
          <div class="col-md-2">
         
        <?= $form->field($model, 'date_admit')->widget(DatePicker::className(),[
            'options' => ['placeholder' => 'เลือกวัน Admit ...'],
     'language' => 'th',
   // 'id' => 'datepicker1',
    'inline' => false,
    'clientOptions' => [
        //'defaultDate' => date('Y-m-d'),
        'autoclose' => true,
        'todayHighlight' => true,
        'format' => 'yyyy-mm-dd',
        //'startDate' => date('2022-01-01'),
        
    ]
  ]);?>
          </div>
          <!-- <div class="col-md-2">
          <?= $form->field($model, 'date_discharge')->widget(DatePicker::className(),[
            'options' => ['placeholder' => 'เลือกวัน Dishcharege'],
      'language' => 'th',           
    //'id' => 'datepicker1',
    'inline' => false,
    'clientOptions' => [
        //'defaultDate' => date('Y-m-d'),
        'autoclose' => true,
        'todayHighlight' => true,
        'format' => 'yyyy-mm-dd',
      //  'valueTo' => '02-20-2012'
        
    ]
  ]);?>
    </div> -->
 <div class="col-md-2">
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
    // 'startDate' => date('2022-01-01'),
        
    ]
  ]);?>
          </div>
      </div>
    </div>
</div>
<center>
<div class="table-responsive">
    <div class="well">
    <table>
    <tr>
        <th><a>Content of medical record</a></th><th>NA (N)</th><th>Miss (M)</th><th>No (O)</th><th>ข้อที่1</th><th>ข้อที่2</th>
        <th>ข้อที่3</th><th>ข้อที่4</th><th>ข้อที่5</th><th>ข้อที่6</th><th>ข้อที่7</th><th>ข้อที่8</th><th>ข้อที่9</th><th>หัก</th>
    </tr>
        <tr>
        <td><a>Discharge summary : Dx, Op</a></td>
            <td><?= $form->field($model, 'NA1')->textInput(['id'=>'NA1','size'=>1,'maxlength' => 1, 'onchange'=>'handleNA1Chk(this)','value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing1')->textInput(['id'=>'Missing7','size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMI01Chk(this)'])->label(false) ?></td>
            <td><?= $form->field($model, 'No1')->textInput(['size'=>1,'id'=>'NO1','size'=>1,'maxlength' => 1, 'onchange'=>'handleNO1Chk(this)','value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'dxop1')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>     
            <td><?= $form->field($model, 'dxop2')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>     
            <td><?= $form->field($model, 'dxop3')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>     
            <td><?= $form->field($model, 'dxop4')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>     
            <td><?= $form->field($model, 'dxop5')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>     
            <td><?= $form->field($model, 'dxop6')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>     []
            <td><?= $form->field($model, 'dxop7')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>     
            <td><?= $form->field($model, 'dxop8')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>     
            <td><?= $form->field($model, 'dxop9')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'dxop_huk')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>         
        </tr>
        <tr>
            <td style="col:#ffff; backgroup:black;"><a>Discharge summary : Dx, Other</a></td>
           <td><?= $form->field($model, 'NA2')->textInput(['id'=>'NA2','size'=>1,'maxlength' => 1, 'onchange'=>'handleNA2Chk(this)','value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing2')->textInput(['size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMissing2Chk(this)'])->label(false) ?></td>
            <td><?= $form->field($model, 'No2')->textInput(['size'=>1,'id'=>'NO2','size'=>1,'maxlength' => 1, 'onchange'=>'handleNO2Chk(this)','value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'other1')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>     
            <td><?= $form->field($model, 'other2')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>     
            <td><?= $form->field($model, 'other3')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>     
            <td><?= $form->field($model, 'other4')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>     
            <td><?= $form->field($model, 'other5')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>     
            <td><?= $form->field($model, 'other6')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>     
            <td><?= $form->field($model, 'other7')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>     
            <td><?= $form->field($model, 'other8')->dropDownList(['N' => 'N', '1' => '1','0'=>'0'])->label(false)?> </td>     
            <td><?= $form->field($model, 'other9')->dropDownList(['N' => 'N', '1' => '1','0'=>'0'])->label(false)?> </td>     
            <td><?= $form->field($model, 'other_huk')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td>     
        
        </tr>
        <tr>
            <td><a>Informed consent</a></td>
            <td><?= $form->field($model, 'NA3')->textInput(['id'=>'NA3','size'=>1,'maxlength' => 1, 'onchange'=>'handleNA3Chk(this)','value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing3')->textInput(['size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMissing3Chk(this)'])->label(false) ?></td>
            <td><?= $form->field($model, 'No3')->textInput(['size'=>1,'id'=>'NO3','size'=>1,'maxlength' => 1, 'onchange'=>'handleNO3Chk(this)','value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'infc1')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'infc2')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'infc3')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'infc4')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'infc5')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'infc6')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'infc7')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'infc8')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'infc9')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'infc_huk')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
        
        </tr>
        <tr>
            <td><a>History</a></td>
            <td><?= $form->field($model, 'NA4')->textInput(['id'=>'NA4','size'=>1,'maxlength' => 1, 'onchange'=>'handleNA4Chk(this)','value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing4')->textInput(['size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMissing4Chk(this)'])->label(false) ?></td>
            <td><?= $form->field($model, 'No4')->textInput(['size'=>1,'id'=>'NO4','size'=>1,'maxlength' => 1, 'onchange'=>'handleNO4Chk(this)','value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'hist1')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'hist2')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'hist3')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'hist4')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'hist5')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'hist6')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'hist7')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'hist8')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'hist9')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'hist_huk')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            
        </tr>
        <tr>
            <td><a>Physical examination</a></td>
            <td><?= $form->field($model, 'NA5')->textInput(['id'=>'NA5','size'=>1,'maxlength' => 1, 'onchange'=>'handleNA5Chk(this)','value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing5')->textInput(['size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMissing5Chk(this)'])->label(false) ?></td>
            <td><?= $form->field($model, 'No5')->textInput(['size'=>1,'id'=>'NO5','size'=>1,'maxlength' => 1, 'onchange'=>'handleNO5Chk(this)','value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'pe1')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'pe2')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'pe3')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'pe4')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'pe5')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'pe6')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'pe7')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'pe8')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'pe9')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'pe_huk')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
                
        </tr>
        <tr>
            <td><a>Progress Note</a></td>
            <td><?= $form->field($model, 'NA6')->textInput(['id'=>'NA6','size'=>1,'maxlength' => 1, 'onchange'=>'handleNA6Chk(this)','value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing6')->textInput(['size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMissing6Chk(this)'])->label(false) ?></td>
            <td><?= $form->field($model, 'No6')->textInput(['size'=>1,'id'=>'NO6','size'=>1,'maxlength' => 1, 'onchange'=>'handleNO6Chk(this)','value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'pn1')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'pn2')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'pn3')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'pn4')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'pn5')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'pn6')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'pn7')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'pn8')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'pn9')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
            <td><?= $form->field($model, 'pn_huk')->dropDownList(['0' => '0', '1' => '1','N'=>'N'])->label(false)?> </td> 
              
        </tr>
        <tr>
            <td><a>Consultation record</a></td>
            <td><?= $form->field($model, 'NA7')->textInput(['id'=>'NA7','size'=>1,'maxlength' => 1, 'onchange'=>'handleNA7Chk(this)','value'=>'N' ,'autocomplete'=> 'off'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing7')->textInput(['id'=>'Missing7','size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMI07Chk(this)'])->label(false) ?></td>
            <td><?= $form->field($model, 'No7')->textInput(['size'=>1,'id'=>'NO7','size'=>1,'maxlength' => 1, 'onchange'=>'handleNO7Chk(this)','value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'cr1')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'cr2')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'cr3')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'cr4')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'cr5')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'cr6')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'cr7')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'cr8')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'cr9')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'cr_huk')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
        </tr>
        <tr>
            <td><a>Anaesthetic record</a></td>
            <td><?= $form->field($model, 'NA8')->textInput(['id'=>'NA8','size'=>1,'maxlength' => 1, 'onchange'=>'handleNA8Chk(this)','value'=>'N' ,'autocomplete'=> 'off'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing8')->textInput(['id'=>'Missing8','size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMI08Chk(this)'])->label(false) ?></td>
            <td><?= $form->field($model, 'No8')->textInput(['size'=>1,'id'=>'NO8','size'=>1,'maxlength' => 1, 'onchange'=>'handleNO8Chk(this)','value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'ar1')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'ar2')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'ar3')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'ar4')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'ar5')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'ar6')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'ar7')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'ar8')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'ar9')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'ar_huk')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
           
        </tr>
        <tr>
            <td><a>Operative note</a></td>
            <td><?= $form->field($model, 'NA9')->textInput(['id'=>'NA9','size'=>1,'maxlength' => 1, 'onchange'=>'handleNA9Chk(this)','value'=>'N' ,'autocomplete'=> 'off'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing9')->textInput(['size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMissing9Chk(this)','autocomplete'=> 'off'])->label(false) ?></td>
            <td><?= $form->field($model, 'No9')->textInput(['size'=>1,'id'=>'NO9','size'=>1,'maxlength' => 1, 'onchange'=>'handleNO9Chk(this)','value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'on1')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'on2')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'on3')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'on4')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'on5')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'on6')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'on7')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'on8')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'on9')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'on_huk')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            
        </tr>
        <tr>
            <td><a>Labour record</a></td>
            <td><?= $form->field($model, 'NA10')->textInput(['id'=>'NA10','size'=>1,'maxlength' => 1, 'onchange'=>'handleNA10Chk(this)','value'=>'N' ,'autocomplete'=> 'off'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing10')->textInput(['size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMissing10Chk(this)','autocomplete'=> 'off'])->label(false) ?></td>
            <td><?= $form->field($model, 'No10')->textInput(['size'=>1,'id'=>'NO10','size'=>1,'maxlength' => 1, 'onchange'=>'handleNO10Chk(this)','value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'lr1')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'lr2')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'lr3')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'lr4')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'lr5')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'lr6')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'lr7')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'lr8')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'lr9')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'lr_huk')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
           
        </tr>
        <tr>
            <td><a>Rehabilitation record</a></td>
            <td><?= $form->field($model, 'NA11')->textInput(['id'=>'NA11','size'=>1,'maxlength' => 1, 'onchange'=>'handleNA11Chk(this)','value'=>'N' ,'autocomplete'=> 'off'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing11')->textInput(['size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMissing11Chk(this)','autocomplete'=> 'off'])->label(false) ?></td>
            <td><?= $form->field($model, 'No11')->textInput(['size'=>1,'id'=>'NO11','size'=>1,'maxlength' => 1, 'onchange'=>'handleNO11Chk(this)','value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'rr1')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'rr2')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'rr3')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'rr4')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'rr5')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'rr6')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'rr7')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'rr8')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'rr9')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'rr_huk')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            
        </tr>
        <tr>
            <td><a>Nurses' note helpful</a></td>
            <td><?= $form->field($model, 'NA12')->textInput(['id'=>'NA12','size'=>1,'maxlength' => 1, 'onchange'=>'handleNA12Chk(this)','value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing12')->textInput(['size'=>1,'maxlength' => 1,'value'=>'-', 'onchange'=> 'handleMissing12Chk(this)'])->label(false) ?></td>
            <td><?= $form->field($model, 'No12')->textInput(['size'=>1,'id'=>'NO12','size'=>1,'maxlength' => 1, 'onchange'=>'handleNO12Chk(this)','value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'nn1')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'nn2')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'nn3')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'nn4')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'nn5')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'nn6')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'nn7')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'nn8')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'nn9')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
            <td><?= $form->field($model, 'nn_huk')->dropDownList([''=>'','0' => '0', '1' => '1'])->label(false)?> </td>  
              
        </tr>
</table>
<div class="table-responsive">
    <div class="well">
        <div class="col-md-6" align="left">        
        <?= $form->field($model, 'finding_id')->radioList([
            '1'=>'การจัดเรียงเวชระเบียนไม่เป็นไปตามมาตรฐานที่กำหนด',
            '2'=>'เอกสารบางแผ่น ไม่มีชื่อผุ้รับบริการ AN HN ทำให้ไม่สามารถระบุได้ว่า เอกสารแผ่นนี้เป็นของใครจึงไม่สามารถทบทวนเอกสารแผ่นนั้นได้'])
           ->label('<a>OverAll Finding</a>'); ?>
    </div>
    <div class="col-md-6" align="left">
        <?= $form->field($model, 'overall_id')->radioList([
            '1'=>'ไม่มี',
            '2'=>'Documentation inadequate for meaningful revie',
            '3'=>'No significant medical record issue identified',
            '4'=>'Certain issue in question specify'
            ])
           ->label('<a>เลือกเพียง 1 ข้อ</a>'); ?>
    </div>

		<div class="col-md-12" align="left">
		<?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
        
            </div>
        
            <div align="center" class="form-group">
        <?= Html::submitButton('<i class="glyphicon glyphicon-plus"></i> '.($model->isNewRecord ? 'บันทึก' : 'แก้ไข'), ['class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary').' btn-lg btn-block']) ?>
        
    </div>

    <?php ActiveForm::end(); ?>

</div>