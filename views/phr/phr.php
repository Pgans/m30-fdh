<?php
namespace app\controllers;

use Yii;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\editable\Editable;
use yii\widgets\Pjax;

$this->title = 'PHR';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['rep/index']];
//$this->params['breadcrumbs'][] = 'รายงานข้อมูลE-Claim แยกตามREP';
?>
     <!-- <script type="text/javascript">
    setTimeout("frmMain.submit();",5000);
    //5000 อยากได้เร็วก็กำหนดตัวเลขน้อยๆเอานะ
    </script>   -->

     <script language="JavaScript">
	function ClickCheckAll(vol)
	{
	
		var i=1;
		for(i=1;i<=document.frmMain.hdnCount.value;i++)
		{
			if(vol.checked == true)
			{
				eval("document.frmMain.chkDel"+i+".checked=true");
			}
			else
			{
				eval("document.frmMain.chkDel"+i+".checked=false");
			}
		}
	}
</script>
<br>
<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                            <h6>ผ่านตามเงื่อนไขวันนี้</h6>
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    <span><?php echo $amount ?></span>
                                </div>
                            </div>
                            <div class="col">
                                <!-- <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="col-auto">
                        <a href="<?= \yii\helpers\Url::to(['/phr/sendphr']) ?>" target="_blank">
                                <img src="images/accept.svg" title="ข้อมูลสำเร็จ" width="70" height="60">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                            <h6>ไม่ผ่านตามเงื่อนไข</h6>
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    <span><?php echo $amountx ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>

                        <div class="col-auto">
                            <a href="<?= \yii\helpers\Url::to(['/phr/logerr']) ?>" target="_blank">
                                <img src="images/reject.76840914.svg" title="ไม่ผ่าน" width="70" height="60">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                            <h6>รายการส่งผ่านทั้งหมด</h6>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <span> <?php echo $total ?></span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <img src="images/waitmoph.98529de4.svg" title="ยอดทั้งหมด" width="70" height="60">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

   
    <?=Html::beginForm(['phr/check'],'post',['name' => 'frmMain']);?> 

            <input name="btnButton1" class="btn btn-info btn btn-block" id="deleteAll" type="submit" name="deleteAll" value="ส่งข้อมูลหมอพร้อม PHR">
           
            <table class="table table-striped" width="1100" border="0">
                <tr>
                    <th width="30">
                        <div align="center">
                            <!-- <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);"> -->
                            <input type="checkbox" id="selectAll">
                        </div>
                    <td width="30">
                        <div align="center" style="font-size: 14px;"> # </div>
                    </td>
                    <td width="30">
                        <div align="center" style="font-size: 14px;"> วันที่ </div>
                    </td>
                    <td width="30">
                        <div align="center" style="font-size: 14px;"> Visit </div>
                    </td>
                    <td width="30">
                        <div align="left" style="font-size: 14px;"> Cid </div>
                    </td>
                    
                    <td width="150">
                        <div align="left" style="font-size: 14px;"> ชื่อ-สกุล </div>
                    </td>
                    <td width="30">
                        <div align="left" style="font-size: 14px;">อายุ </div>
                    </td>
                    <td width="30">
                        <div align="left" style="font-size: 14px;"> Diag </div>
                    </td>
                   
                    <td width="30">
                        <div align="left" style="font-size: 14px;"> แผนก
                    </td>
                
                </tr>
                <?php
                foreach ($dataProvider->getModels() as $key => $value) :
                ?>
                    <tr>
                  
                        <td><input type="checkbox" name="chkDel[]"<?php echo 'checked'; ?> id="chkDel<?= $i; ?>" value="<?php echo $value["visit_id"]; ?><?php echo $value["hn"];?><?php echo $value["cid"]; ?><?php echo $value["regdate"]; ?>">
                        <td class="badge"><?php echo  $value["No"]; ?>
    </div>
    </td>
    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["regdate"]; ?></div>
    </td>
    <td style="font-size: 14px;"><?php echo $value["visit_id"]; ?></div>
    </td>
    <td style="font-size: 14px;"><?php echo $value["cid"]; ?></div>
    </td>
    <td class="text-nowrap"  style="font-size: 14px;"><?php echo $value["fullname"]; ?></td>
    <td style="font-size: 14px;"><?php echo $value["age"]; ?></div>
    </td>
    <td style="font-size: 14px;"><?php echo $value["Diag"]; ?></div>
    </td style="font-size: 14px;">  
    <td class="text-nowrap"  style="font-size: 14px;"><?php echo $value["unit_name"]; ?></div>
    </td>
    
    </tr>
<?php endforeach; ?>
</table>
<div class="box-footer with-border">
        <div class="col-md-12"> 
            <div class="form-group">
                <!-- <p> <?= Html::submitButton('ส่งข้อมูล HT', ['class' => 'btn btn-success']) ?></p> -->
                <!-- <?= Html::button(Yii::t('app', 'Ht'), ['class' => 'btn btn-warning pull-right','id'=>'btn-delete']) ?> -->
            </div>
        </div>
    </div>

    <?php

$this->registerJs('
  jQuery("#btn-delete").click(function(){
    var keys = $("#w0").yiiGridView("getSelectedRows");
    console.log(keys);
    if(keys.length>0){
      jQuery.post("'.Url::to(['delete-all']).'",{ids:keys},function(){
      });
    }
  });
');
 ?>