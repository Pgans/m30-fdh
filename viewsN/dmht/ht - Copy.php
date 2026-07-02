<?php

namespace app\controllers;

use Yii;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\editable\Editable;
use yii\widgets\Pjax;

$this->title = 'HT';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['rep/index']];
//$this->params['breadcrumbs'][] = 'รายงานข้อมูลE-Claim แยกตามREP';
?>

<!-- <script type="text/javascript">
    setTimeout("frmMain.submit();",50000);
    //5000 อยากได้เร็วก็กำหนดตัวเลขน้อยๆเอานะ
    </script> -->

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
                                    <h3> <?php echo $amount ?></h3>
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
                        <img src="images/accept.svg" title="ข้อมูลสำเร็จ" width="70" height="60">
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
                            <h6>ไมผ่านตามเงื่อนไข</h6>
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">ปปปป</div>
                            </div>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                        <img src="images/reject.76840914.svg" title="ไม่ผ่าน" width="70" height="60">
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
                            <h3><?php echo $amountx ?></h3>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="box box-success box-solid">
        <div class="mradepartmetnsopd-index">
            <div class="card-body">
                <div class="col-xl-3 col-md-6 mb-4">
                    <!-- small box -->
                    <div class="small-box bg-aqua" id="grad3">
                        <div class="inner">
                            <h3>
                                <?php echo $amount ?>
                            </h3>

                            <p>
                                ผ่านตามเงื่อนไขวันนี้
                            </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                            <img src="images/accept.svg" title="ข้อมูลสำเร็จ" width="70" height="60">
                        </div>
                        <a href="<?= \yii\helpers\Url::to(['/log/ht']) ?>" target="_blank" class="small-box-footer">
                            <!-- <a href="< ?= //\yii\helpers\Url::to(['logdmhtdt/index']) ?>" target="_blank" class="small-box-footer"> -->
                            HT success <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-xl-3 col-md-6 mb-4">
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
                        <a href="<?= \yii\helpers\Url::to(['/log/ht']) ?>" target="_blank" class="small-box-footer">
                            Log HT <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>

                </div>
                <!-- ./col -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <!-- small box -->
                    <div class="small-box bg-orange" id="grad1">
                        <div class="inner">
                            <h3>
                                <?php echo $total ?>
                            </h3>

                            <p>
                                รายการส่งผ่านทั้งหมด
                            </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                            <img src="images/waitmoph.98529de4.svg" title="ยอดทั้งหมด" width="70" height="60">
                        </div>
                        <a href="<?= \yii\helpers\Url::to(['/debug']) ?>" target="_blank" class="small-box-footer">
                            Total <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <?= Html::beginForm(['dmht/check'], 'post', ['name' => 'frmMain']); ?>

                <!-- <form id="checkbo" name="frmMain" action="dmht/check" method="post">  -->
                <input name="btnButton1" class="btn btn-primary btn btn-block" id="grad3" id="select" type="submit" value="ส่งข้อมูล Moph-Claim HT">

                <!-- <input type="checkbox" id="selectAll"> -->

                <table class="table table-striped" width="1100" border="0">
                    <tr>
                        <th width="30">
                            <div align="center">
                                <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);">
                                <!-- <input type="checkbox" id="selectAll">-->
                            </div>
                        <td width="30">
                            <div><a># </a></div>
                        </td>
                        <td width="30">
                            <div> <a>วันที่ </a></div>
                        </td>
                        <td width="30">
                            <div><a>Visit</a> </div>
                        </td>
                        <td width="30">
                            <div><a href="">Hn</a> </div>
                        </td>

                        <td width="150">
                            <div><a href="">ชื่อ-สกุล</a> </div>
                        </td>
                        <td width="30">
                            <div> <a href="">Diag</a> </div>
                        </td>
                        <td width="30">
                            <div><a>Lab</a></div>
                        </td>
                        <td width="30">
                            <div><a href="">แผนก</a> </div>
                        </td>
                        <td width="30">
                            <div><a href="">authencode</a> </div>
                        </td>
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
        <td><?php echo $value["visit_id"]; ?>
    </div>
    </td>
    <td><?php echo $value["hn"]; ?>
</div>
</td>
</td>
<td class="text-nowrap" style="color:green"><?php echo $value["fullname"]; ?></td>
<td><?php echo $value["Diag"]; ?></div>
</td>
<td><?php echo $value["labname"]; ?></div>
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
            <input type="hidden" name="hdnCount" value="<?= $i; ?>">

            </form>
        </div>
    </div>
</div>