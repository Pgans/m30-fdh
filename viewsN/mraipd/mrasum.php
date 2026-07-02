<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\editable\Editable;
use \miloschuman\highcharts\Highcharts;

//$this->title = 'คะแนนแยกตามข้อ';
$this->title = Yii::t('app', 'AN: {name}', [
    'name' => $model->AN,
]);
$this->params['breadcrumbs'][] = ['label' => 'กลับ', 'url' => ['mraipd/index']];
//$this->params['breadcrumbs'][] = 'รายงานข้อมูลE-Claim แยกตามREP';

?>


         <!-- ################################# Start Authen Code############# -->
         <!-- <div class="row">
    <div class="panel panel-success">
        <div class="panel-heading"><i class="glyphicon glyphicon-plus"></i> รายงานการฉีดวัคซีน ศูนย์ตรวจสุขภาพชุมชน โรงพยาบาลม่วงสามสิบ</<i></div>
        <div class="panel-body">
            <div class="row"> -->
                <!-- <div class="col-md-6"> -->
                <div class="panel panel-primary" >
                        <div class="panel-heading"id= "grad8"><i class="glyphicon glyphicon-user"></i> บันทึกตรวจประเมินเวชระเบียนผู้ป่วยใน<i></div>
                        <div class="table-responsive">
                            
                            <div>
                            <table class="table table-striped" width="450" border="0" align="center" cellspacing="0" >
        <thead>
        <tr>
            <th><a>Content of medical record</a></th><th>NA (N)</th><th>Miss (M)</th><th>No (O)</th><th>ข้อที่1</th><th>ข้อที่2</th>
        <th>ข้อที่3</th><th>ข้อที่4</th><th>ข้อที่5</th><th>ข้อที่6</th><th>ข้อที่7</th><th>ข้อที่8</th><th>ข้อที่9</th><th>หัก</th><th>คะแนนเต็ม</th><th>คะแนนที่ได้</th>
        </tr>
         </thead> 
        <?php
        //while($objResult = mysql_fetch_array($dataeProvider))
        foreach($dataProvider->getModels() as $key => $value):
        ?>
        <tr>
        <td><a>1.Discharge summary : Dx, Op</a></td>
            <td align="center"><?=$value["na1"];?></td>
            <td align="center"><?=$value["missing1"];?></td>
            <td align="center"><?=$value["no1"];?></td>
            <td align="center"><?=$value["dxop1"];?></td>
            <td align="center"><?=$value["dxop2"];?></td>
            <td align="center"><?=$value["dxop3"];?></td>
            <td align="center"><?=$value["dxop4"];?></td>
            <td align="center"><?=$value["dxop5"];?></td>
            <td align="center"><?=$value["dxop6"];?></td>
            <td align="center"><?=$value["dxop7"];?></td>
            <td align="center"><?=$value["dxop8"];?></td>
            <td align="center"><?=$value["dxop9"];?></td>
            <td align="center"><?=$value["dxop_huk"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total1"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount1"];?></td>
        </tr>
        <tr>
            <td><a>2.Discharge summary : Dx, Other</a></td>
            <td align="center"><?=$value["na2"];?></td>
            <td align="center"><?=$value["missing2"];?></td>
            <td align="center"><?=$value["no2"];?></td>
            <td align="center"><?=$value["other1"];?></td>
            <td align="center"><?=$value["other2"];?></td>
            <td align="center"><?=$value["other3"];?></td>
            <td align="center"><?=$value["other4"];?></td>
            <td align="center"><?=$value["other5"];?></td>
            <td align="center"><?=$value["other6"];?></td>
            <td align="center"><?=$value["other7"];?></td>
            <td align="center"><?=$value["other8"];?></td>
            <td align="center"><?=$value["other9"];?></td>
            <td align="center"><?=$value["other_huk"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total2"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount2"];?></td>
        </tr>
        <tr>
            <td><a>3.Informed consent</a></td>
            <td align="center"><?=$value["na3"];?></td>
            <td align="center"><?=$value["missing3"];?></td>
            <td align="center"><?=$value["no3"];?></td>
            <td align="center"><?=$value["infc1"];?></td>
            <td align="center"><?=$value["infc2"];?></td>
            <td align="center"><?=$value["infc3"];?></td>
            <td align="center"><?=$value["infc4"];?></td>
            <td align="center"><?=$value["infc5"];?></td>
            <td align="center"><?=$value["infc6"];?></td>
            <td align="center"><?=$value["infc7"];?></td>
            <td align="center"><?=$value["infc8"];?></td>
            <td align="center"><?=$value["infc9"];?></td>
            <td align="center"><?=$value["infc_huk"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total3"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount3"];?></td>
        </tr>
        <tr>
            <td><a>4.History</a></td>
            <td align="center"><?=$value["na4"];?></td>
            <td align="center"><?=$value["missing4"];?></td>
            <td align="center"><?=$value["no4"];?></td>
            <td align="center"><?=$value["hist1"];?></td>
            <td align="center"><?=$value["hist2"];?></td>
            <td align="center"><?=$value["hist3"];?></td>
            <td align="center"><?=$value["hist4"];?></td>
            <td align="center"><?=$value["hist5"];?></td>
            <td align="center"><?=$value["hist6"];?></td>
            <td align="center"><?=$value["hist7"];?></td>
            <td align="center"><?=$value["hist8"];?></td>
            <td align="center"><?=$value["hist9"];?></td>
            <td align="center"><?=$value["hist_huk"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total4"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount4"];?></td>
        </tr>
        <tr>
            <td><a>5.Physical</a></td>
            <td align="center"><?=$value["na5"];?></td>
            <td align="center"><?=$value["missing5"];?></td>
            <td align="center"><?=$value["no5"];?></td>
            <td align="center"><?=$value["pe1"];?></td>
            <td align="center"><?=$value["pe2"];?></td>
            <td align="center"><?=$value["pe3"];?></td>
            <td align="center"><?=$value["pe4"];?></td>
            <td align="center"><?=$value["pe5"];?></td>
            <td align="center"><?=$value["pe6"];?></td>
            <td align="center"><?=$value["pe7"];?></td>
            <td align="center"><?=$value["pe8"];?></td>
            <td align="center"><?=$value["pe9"];?></td>
            <td align="center"><?=$value["pe_huk"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total5"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount5"];?></td>
        </tr>
        <tr>
            <td><a>6.Progress Note</a></td>
            <td align="center"><?=$value["na6"];?></td>
            <td align="center"><?=$value["missing6"];?></td>
            <td align="center"><?=$value["no6"];?></td>
            <td align="center"><?=$value["pn1"];?></td>
            <td align="center"><?=$value["pn2"];?></td>
            <td align="center"><?=$value["pn3"];?></td>
            <td align="center"><?=$value["pn4"];?></td>
            <td align="center"><?=$value["pn5"];?></td>
            <td align="center"><?=$value["pn6"];?></td>
            <td align="center"><?=$value["pn7"];?></td>
            <td align="center"><?=$value["pn8"];?></td>
            <td align="center"><?=$value["pn9"];?></td>
            <td align="center"><?=$value["pn_huk"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total6"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount6"];?></td>
        </tr>
        <tr>
            <td><a>7.Consultation record</a></td>
            <td align="center"><?=$value["na7"];?></td>
            <td align="center"><?=$value["missing7"];?></td>
            <td align="center"><?=$value["no7"];?></td>
            <td align="center"><?=$value["cr1"];?></td>
            <td align="center"><?=$value["cr2"];?></td>
            <td align="center"><?=$value["cr3"];?></td>
            <td align="center"><?=$value["cr4"];?></td>
            <td align="center"><?=$value["cr5"];?></td>
            <td align="center"><?=$value["cr6"];?></td>
            <td align="center"><?=$value["cr7"];?></td>
            <td align="center"><?=$value["cr8"];?></td>
            <td align="center"><?=$value["cr9"];?></td>
            <td align="center"><?=$value["cr_huk"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total7"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount7"];?></td>
        </tr>
        <tr>
            <td><a>8.Anaesthetic record</a></td>
            <td align="center"><?=$value["na8"];?></td>
            <td align="center"><?=$value["missing8"];?></td>
            <td align="center"><?=$value["no8"];?></td>
            <td align="center"><?=$value["ar1"];?></td>
            <td align="center"><?=$value["ar2"];?></td>
            <td align="center"><?=$value["ar3"];?></td>
            <td align="center"><?=$value["ar4"];?></td>
            <td align="center"><?=$value["ar5"];?></td>
            <td align="center"><?=$value["ar6"];?></td>
            <td align="center"><?=$value["ar7"];?></td>
            <td align="center"><?=$value["ar8"];?></td>
            <td align="center"><?=$value["ar9"];?></td>
            <td align="center"><?=$value["ar_huk"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total8"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount8"];?></td>
        </tr>
        <tr>
            <td><a>9.Operative note</a></td>
            <td align="center"><?=$value["na9"];?></td>
            <td align="center"><?=$value["missing9"];?></td>
            <td align="center"><?=$value["no9"];?></td>
            <td align="center"><?=$value["on1"];?></td>
            <td align="center"><?=$value["on2"];?></td>
            <td align="center"><?=$value["on3"];?></td>
            <td align="center"><?=$value["on4"];?></td>
            <td align="center"><?=$value["on5"];?></td>
            <td align="center"><?=$value["on6"];?></td>
            <td align="center"><?=$value["on7"];?></td>
            <td align="center"><?=$value["on8"];?></td>
            <td align="center"><?=$value["on9"];?></td>
            <td align="center"><?=$value["on_huk"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total9"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount9"];?></td>
        </tr>
        <tr>
            <td><a>10.Labour record</a></td>
            <td align="center"><?=$value["na10"];?></td>
            <td align="center"><?=$value["missing10"];?></td>
            <td align="center"><?=$value["no10"];?></td>
            <td align="center"><?=$value["lr1"];?></td>
            <td align="center"><?=$value["lr2"];?></td>
            <td align="center"><?=$value["lr3"];?></td>
            <td align="center"><?=$value["lr4"];?></td>
            <td align="center"><?=$value["lr5"];?></td>
            <td align="center"><?=$value["lr6"];?></td>
            <td align="center"><?=$value["lr7"];?></td>
            <td align="center"><?=$value["lr8"];?></td>
            <td align="center"><?=$value["lr9"];?></td>
            <td align="center"><?=$value["lr_huk"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total10"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount10"];?></td>
        </tr>
        <tr>
            <td><a>11.Rehabilitation record</a></td>
            <td align="center"><?=$value["na11"];?></td>
            <td align="center"><?=$value["missing11"];?></td>
            <td align="center"><?=$value["no11"];?></td>
            <td align="center"><?=$value["rr1"];?></td>
            <td align="center"><?=$value["rr2"];?></td>
            <td align="center"><?=$value["rr3"];?></td>
            <td align="center"><?=$value["rr4"];?></td>
            <td align="center"><?=$value["rr5"];?></td>
            <td align="center"><?=$value["rr6"];?></td>
            <td align="center"><?=$value["rr7"];?></td>
            <td align="center"><?=$value["rr8"];?></td>
            <td align="center"><?=$value["rr9"];?></td>
            <td align="center"><?=$value["rr_huk"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total11"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount11"];?></td>
        </tr>
        <tr>
            <td><a>12.Nurses' note helpful</a></td>
            <td align="center"><?=$value["na12"];?></td>
            <td align="center"><?=$value["missing12"];?></td>
            <td align="center"><?=$value["no12"];?></td>
            <td align="center"><?=$value["nn1"];?></td>
            <td align="center"><?=$value["nn2"];?></td>
            <td align="center"><?=$value["nn3"];?></td>
            <td align="center"><?=$value["nn4"];?></td>
            <td align="center"><?=$value["nn5"];?></td>
            <td align="center"><?=$value["nn6"];?></td>
            <td align="center"><?=$value["nn7"];?></td>
            <td align="center"><?=$value["nn8"];?></td>
            <td align="center"><?=$value["nn9"];?></td>
            <td align="center"><?=$value["nn_huk"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total12"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount12"];?></td>
        </tr>
        
         <?php endforeach; ?>
        </table>
        </div>
          </div>
   </div>
        <p>
            ประเมินคุณภาพการบันทึกเวชระเบียนในภาพรวม
        </p>
          <p>
		    <a>Overall finding:::</a>    <?=$value["finding_name"];?>
	      </p>
          <p>
		    <a>เลือกเพียง 1 ข้อ:::</a>    <?=$value["overall_name"];?>
	      </p>
		  <p>
		    <a>หมายเหตุ*</a>    <?=$value["note"];?>
	      </p>
		  
             <p><a class='btn btn-info' HREF="javascript:history.back()" ><i class="fa fa-reply"></i> ย้อนกลับ</a> </p>
			</div>
            

                   