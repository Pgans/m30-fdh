<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\editable\Editable;
use yii\widgets\Pjax;

$this->title = 'Epidem Covid19';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['rep/index']];
//$this->params['breadcrumbs'][] = 'รายงานข้อมูลE-Claim แยกตามREP';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dose1</title>
</head>

<body>
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
<div class="box box-success box-solid">
<div class="mradepartmetnsopd-index"> 
    <div class='well'>
    <div class="col-md-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua" id="grad3">
            <div class="inner">
                <h3>
                <?php  echo $amount ?>
                </h3>

                <p>
                    ผ่านตามเงื่อนไขวันนี้
                </p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
                <img src="images/accept.svg" title="ข้อมูลสำเร็จ" width="70" height="60">
            </div>
            <a href="<?= \yii\helpers\Url::to(['/log/logepidem']) ?>" target="_blank" class="small-box-footer">
                 Epidem success <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
 <!-- ./col -->

 <div class="col-md-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-orange" id="grad31">
            <div class="inner">
                <h3>
                   <?php echo $amountx ?>
                    <!-- <?= count(\Yii::$app->getModules()) ?> -->
                </h3>

                <p>
                   ไม่ผ่านตามเงื่อนไขวันนี้
                </p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
                <img src="images/reject.76840914.svg" title="ไม่ผ่าน" width="70" height="60">
            </div>
            <a href="<?= \yii\helpers\Url::to(['log/logepidem']) ?>" target="_blank"  class="small-box-footer">
                Log Epidem <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>

    </div>
    <!-- ./col -->
    <div class="col-md-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-orange" id="grad1">
            <div class="inner">
                <h3>
                 <?php  echo $total ?> 
                </h3>

                <p>
                    รายการส่งผ่านทั้งหมด
                </p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
                <img src="images/waitmoph.98529de4.svg" title="ยอดทั้งหมด" width="70" height="60">
            </div>
            <a href="<?= \yii\helpers\Url::to(['/debug']) ?>" target="_blank"  class="small-box-footer">
                Total <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>

    </div>
    <?=Html::beginForm(['epidemx/check'],'post',['name' => 'frmMain']);?> 
    <!-- <?=Html::beginForm(['epidem/visits'],'post',['name' => 'frmMain']);?>  -->
        <!-- <form id="checkbo" name="frmMain" action="epidem/visit" method="post"> -->
            <input name="btnButton1" class="btn btn-success btn btn-block" id="selectAll" type="submit" name="selectAll" value="ส่งข้อมูล Epidem Covid-19">
            <input type="checkbox" id="selectAll">
            <table class="table table-striped"  border="0">
                <tr>
                    <th width="30">
                        <div align="center">
                            <!-- <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);"> -->
                            <input type="checkbox" id="selectAll">
                        </div>
                    <td width="30">
                        <div align="center" id="grad2"> # </div>
                    </td>
                    <td width="30">
                        <div align="center" id="grad2"> วันที่ </div>
                    </td>
                    <td width="30">
                        <div align="center" id="grad2"> Visit </div>
                    </td>
                    <td width="50">
                        <div align="left" id="grad2"> Cid </div>
                    </td>
                    <td width="30">
                        <div align="left" id="grad2"> Hn </div>
                    </td>
                    <td width="30">
                        <div align="left" id="grad2"> An </div>
                    </td>
                    <td width="30">
                        <div align="left" id="grad2"> ตึก </div>
                    </td>
                    <td width="150">
                        <div align="left" id="grad2"> ชื่อ-สกุล </div>
                    </td>
                    <td width="30">
                        <div align="left" id="grad2"> Diag </div>
                    </td>
                    
                    <td width="30">
                        <div align="left" id="grad2"> แผนก
                    </td>
                    <td width="30">
                        <div align="left" id="grad2"> Lab
                    </td>
                    <td width="30">
                        <div align="left" id="grad2"> วัคซีน
                    </td>
                    <td width="30">
                        <div align="left" id="grad2"> อาการ
                    </td>
                </tr>
                <?php
                foreach ($epidemProvider->getModels() as $key => $value) :
                ?>
                    <tr>
                    <td ><div align="center"><input type="checkbox" name="chkDel[]" <?php echo 'checked'; ?> id="chkDel<?=$i;?>" value="<?php echo $value["visit_id"]; ?><?php echo $value["cid"]; ?>"></td>
                        
    <td class="badge"><?php echo  $value["No"]; ?>
    </div>
    </td>
    <td class="text-nowrap"><?php echo $value["regdate"]; ?></div>
    </td>
    <td><?php echo $value["visit_id"]; ?></div>
    </td>
    <td><?php echo $value["cid"]; ?></div>
    </td>
    <td><?php echo $value["hn"]; ?></div>
    </td>
    <td><?php echo $value["An"]; ?></div>
    </td>
    <td><?php echo $value["ward"]; ?></div>
    </td>
    <td class="text-nowrap" style="color:green"><?php echo $value["fullname"]; ?></td>
    <td><?php echo $value["Diag"]; ?></div>
    </td>
    <td class="text-nowrap" style="color:green"><?php echo $value["unit_name"]; ?></div>
    </td>
    <td class="text-nowrap"><?php echo $value["Lab"]; ?></div>
    </td>
    <td class="text-nowrap" style="color:brown"><a><?php echo $value["Vaccine"]; ?></a></div>
    </td>
    <td><?php echo $value["symtom"]; ?></div>
    </td>
    </tr>
<?php endforeach; ?>
<input type="hidden" name="hdnCount" value="<?=$i;?>">
        </table>
        </form>
              
          </div>
       </div>
    </div>
</body>
</html>
