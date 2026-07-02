<?php
namespace app\controllers;

use Yii;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\editable\Editable;
use yii\widgets\Pjax;

$this->title = 'DM';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['rep/index']];
//$this->params['breadcrumbs'][] = 'รายงานข้อมูลE-Claim แยกตามREP';
?>

 <!-- <script type="text/javascript">
setTimeout("frmMain.submit();",60000);
//5000 อยากได้เร็วก็กำหนดตัวเลขน้อยๆเอานะ
</script>  -->

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
        <div class="small-box bg-aqua" id="grad001">
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
            <a href="<?= \yii\helpers\Url::to(['/dm/log_dm']) ?>" target="_blank" class="small-box-footer">
                 DM success <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
 <!-- ./col -->

 <div class="col-md-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-orange" id="grad81">
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
            <a href="<?= \yii\helpers\Url::to(['/log/dm']) ?>" target="_blank"  class="small-box-footer">
                Log DM <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>

    </div>
    <!-- ./col -->
    <div class="col-md-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-orange" id="grad003">
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
            <a href="<?= \yii\helpers\Url::to(['/dm/log_dm']) ?>" target="_blank"  class="small-box-footer">
                Total <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>

    </div>
   
    <?=Html::beginForm(['dm/check'],'post',['name' => 'frmMain']);?> 

            <input name="btnButton1" class="btn btn-warning btn btn-block" id="grad001" id="deleteAll"  type="submit" name="select" id="grad1" value="ส่งข้อมูล Moph-Claim DM">
            <!-- <?= Html::a('Submit', ['check'], ['class' => 'btn btn-success pull-right']) ?> -->
            <!-- <?= Html::button(Yii::t('app', 'dmht'), ['class' => 'btn btn-warning pull-right', 'id' => 'check']) ?> -->
         <input type="checkbox" id="selectAll"> 
            
            <table class="table table-striped" width="1100" border="0">
                <tr>
                    <th width="30">
                        <div align="center">
                            <!-- <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);"> -->
                            <input type="checkbox" id="selectAll">
                        </div>
                        <td width="30">
                        <div  ><a># </a></div>
                    </td>
                    <td width="30">
                        <div  > <a>วันที่ </a></div>
                    </td>
                    <td width="30">
                        <div ><a>Visit</a>  </div>
                    </td>
                    <td width="30">
                        <div><a href="">Hn</a> </div>
                    </td>
                    
                    <td width="150">
                        <div ><a href="">ชื่อ-สกุล</a> </div>
                    </td>
                    <td width="30">
                        <div> <a href="">Diag</a>  </div>
                    </td>
                    <td width="30">
                        <div ><a>Lab</a></div>
                    </td>
                    <td width="30">
                        <div ><a href="">แผนก</a> </div>
                    </td>
                    <td width="30">
                        <div ><a href="">authencode</a> </div>
                    </td>
                </tr>
                <?php
                foreach ($dmProvider->getModels() as $key => $value) :
                ?>
                    <tr>
                  
                        <td><input type="checkbox" name="chkDel[]"<?php echo 'checked'; ?> id="chkDel<?= $i; ?>" value="<?php echo $value["visit_id"]; ?><?php echo $value["hn"]; ?>">
                        <td class="badge"><?php echo  $value["No"]; ?>
    </div>
    </td>
    <td class="text-nowrap"><?php echo $value["regdate"]; ?></div>
    </td>
    <td><?php echo $value["visit_id"]; ?></div>
    </td>
    <td><?php echo $value["hn"]; ?></div> </td>
    </td>
    <td class="text-nowrap" style="color:green"><?php echo $value["fullname"]; ?></td>
    <td><?php echo $value["Diag"]; ?></div>
    </td>
    <td ><?php echo $value["labname"]; ?></div>
    </td>
    <td class="text-nowrap" style="color:green"><?php echo $value["unit_name"]; ?></div>
    </td>
    <td class="text-nowrap" style="color:orange"><?php echo $value["claimcode"]; ?></div>
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

   
