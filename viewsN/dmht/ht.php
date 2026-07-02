<?php

namespace app\controllers;

use Yii;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\editable\Editable;


$this->title = 'HT';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['rep/index']];
//$this->params['breadcrumbs'][] = 'รายงานข้อมูลE-Claim แยกตามREP';
?>

<!-- <script type="text/javascript">
    setTimeout("frmMain.submit();",5000);
    //5000 อยากได้เร็วก็กำหนดตัวเลขน้อยๆเอานะ
    </script>  -->

<script language="JavaScript">
    function ClickCheckAll(vol) {

        var i = 1;
        for (i = 1; i <= document.frmMain.hdnCount.value; i++) {
            if (vol.checked == true) {
                eval("document.frmMain.chkDel" + i + ".checked=true");
            } else {
                eval("document.frmMain.chkDel" + i + ".checked=false");
            }
        }
    }
</script>
<br>
<h2 style="color: yellow; font-size: 32px;" class="badge btn-info">
    Moph Claim-HT
</h2>
<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                            <h6 class="text-info">ผ่านตามเงื่อนไขวันนี้</h6>
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    <span class="text-dark"><?php echo $amount ?></span>
                                </div>
                            </div>
                           
                            <div class="col">
                                <!-- <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div> -->
                            </div>
                        </div>
                    </div>
                    <?= Html::a('แสดงรายการ', null, ['class' => 'btn btn-success', 'id' => 'link1']) ?>
                    <div class="col-auto">
                        <div class="col-auto">
    
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
                            <h6 class="text-danger">ไม่ผ่านตามเงื่อนไข</h6>
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    <span><?php echo $amountx ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?= Html::a('แสดงรายการ', null, ['class' => 'btn btn-danger', 'id' => 'link2']) ?>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                        <div class="col-auto">
                    
                            <img id="rejectImage" src="images/reject.76840914.svg" title="ไม่ผ่าน" width="70" height="60">
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
                            <h6 class="text-success">รายการส่งผ่านทั้งหมด</h6>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <span> <?php echo $total ?></span>
                        </div>
                    </div>
                    <?= Html::a('<i class="fas fa-sync-alt"></i> Refresh', ['dmht/ht'], ['class' => 'btn btn-info', 'id' => 'link3']) ?>

                    <div class="col-auto">
                        <img src="images/waitmoph.98529de4.svg" title="ยอดทั้งหมด" width="70" height="60">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ############################## PASS ################################################################# -->
<div id="model1" style="display: none;">
<h2 style="color: green; border: 2px solid #d1d1d1;">แสดงรายการผ่าน</h2>

<?= \yii\grid\GridView::widget([
    'dataProvider' => $passProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'visit_id',
        'pid',
        'status',
        'response',
        'd_update',
    ],
    'tableOptions' => ['class' => 'table table-striped'], // เพิ่มคลาส CSS ให้กับตาราง GridView
]); ?>

    </div>

<!-- ############################## ERROR ################################################################# -->
<div id="model2" style="display: none;">
<h2 style="color: red;border: 2px solid #d1d1d1;">แสดงรายการไม่ผ่าน</h2>

<?= \yii\grid\GridView::widget([
    'dataProvider' => $loghtProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'visit_id',
        'pid',
        'status',
        'response',
        'd_update',
    ],
    'tableOptions' => ['class' => 'table table-striped'], // เพิ่มคลาส CSS ให้กับตาราง GridView
]); ?>

    </div>


<!-- ############################################################################################### -->

<div class="card-body">
    <div class="table-responsive">
        <?= Html::beginForm(['dmht/check'], 'post', ['name' => 'frmMain']); ?>
       

        <!-- <form id="checkbo" name="frmMain" action="dmht/check" method="post">  -->
        <!-- <input name="btnButton1" class="btn btn-info btn btn-block" id="selectAll" type="submit" name="selectAll" value="ส่งข้อมูล Moph-Claim HT" id="grad3"> -->
        <input name="btnButton1" class="btn btn-info btn btn-block" id="deleteAll" type="submit" name="deleteAll" value="ส่งข้อมูล Moph-Claim HT" 
        style="background-color: #00b9b9; color: #ffff00;">

        <!-- <input type="checkbox" id="selectAll"> -->
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <tr>
                    <th width="30"align="left" style="font-size: 14px; background-color: #00b7b7; color: white;">
                        <div align="center">
                            <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);">
                            <!-- <input type="checkbox" id="selectAll">-->
                        </div>
                        <td width="30" align="left" style="font-size: 14px; background-color: #00b7b7; color: white;"> # </td>
                        
                    <td width="30" align="left" style="font-size: 14px; background-color: #00b7b7; color: white;"><div> <a>วันที่ </a></div> </td>

                    <td width="30" align="left" style="font-size: 14px; background-color: #00b7b7; color: white;">Visit</a> </div> </td>

                    <td width="30" align="left" style="font-size: 14px; background-color: #00b7b7; color: white;">Hn</a> </div> </td>

                    <td width="150" align="left" style="font-size: 14px; background-color: #00b7b7; color: white;">ชื่อ-สกุล</a> </div></td>

                    <td width="30" align="left" style="font-size: 14px; background-color: #00b7b7; color: white;">Diag</a> </div></td>

                    <td width="30" align="left" style="font-size: 14px; background-color: #00b7b7; color: white;">Lab</a></div></td>

                    <td width="30" align="left" style="font-size: 14px; background-color: #00b7b7; color: white;">แผนก</a> </div></td>

                    <td width="30" align="left" style="font-size: 14px; background-color: #00b7b7; color: white;">authencode</a> </div> </td>
                </tr>
                <?php
                foreach ($htProvider->getModels() as $key => $value) :
                ?>
                    <tr>

                        <td><input type="checkbox" name="chkDel[]" <?php echo 'checked'; ?> id="chkDel<?= $i; ?>" value="<?php echo $value["visit_id"]; ?><?php echo $value["hn"]; ?>">
                        <td class="badge"><?php echo  $value["No"]; ?>
        </div>
        </td>
        <td class="text-nowrap"><?php echo $value["regdate"]; ?>
    </div>
    </td>
    <td style="font-size: 14px;"><?php echo $value["visit_id"]; ?>
</div>
</td>
<td style="font-size: 14px;"><?php echo $value["hn"]; ?>
    </div>
</td>
</td>
<td class="text-nowrap" style="font-size: 14px;"><?php echo $value["fullname"]; ?></td>
<td style="font-size: 14px;"><?php echo $value["Diag"]; ?></div>
</td>
<td class="text-nowrap" style="font-size: 14px;"><?php echo $value["labname"]; ?></div>
</td>
<td class="text-nowrap" style="font-size: 14px;"><?php echo $value["unit_name"]; ?></div>
</td>
<td class="text-nowrap" style="font-size: 14px;"><?php echo $value["claimcode"]; ?></div>
</td>
</tr>
<?php endforeach; ?>
</table>
<div class="box-footer with-border">
    <div class="col-md-12">
        <div class="form-group">
            <!-- <p> <?= Html::submitButton('ส่งข้อมูล HT', ['class' => 'btn btn-success']) ?></p> -->
            <input type="hidden" name="hdnCount" value="<?= $i; ?>">

            </form>
        </div>
    </div>
</div>


<!-- สคริปต์ jQuery เพื่อแสดง/ซ่อนข้อมูลเมื่อคลิกที่ลิงค์ -->
<?php
$this->registerJs("
    $('#link1').click(function(){
        $('#model1').show();
        $('#model2').hide();
    });

    $('#link2').click(function(){
        $('#model1').hide();
        $('#model2').show();
    });
");
?>
