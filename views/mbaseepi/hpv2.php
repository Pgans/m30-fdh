<?php

namespace app\controllers;

use Yii;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\editable\Editable;
use yii\widgets\Pjax;

$this->title = 'JHCIS-HPV';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['rep/index']];
//$this->params['breadcrumbs'][] = 'รายงานข้อมูลE-Claim แยกตามREP';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hpv</title>

</head>
<style>
#loading-spinner {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
}

.spinner {
    width: 50px;
    height: 50px;
    border: 8px solid #f3f3f3;
    border-top: 8px solid #cc99ff; /* Light purple color */
    border-radius: 50%;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<body>
    <!--
    <script type="text/javascript">
    setTimeout("frmMain.submit();",50000);
    //5000 อยากได้เร็วก็กำหนดตัวเลขน้อยๆเอานะ
    </script>
	-->
   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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


<h6><a>200.14::Maphn </a> Copy [vaccineepi, person, cdrug, mathhn, visit, userx ] </h6>
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-lg-3 col-md-6 mb-3">
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
                                <a href="<?= \yii\helpers\Url::to(['/hjepi/loghpv']) ?>" target="_blank">
                                    <img src="images/accept.svg" title="ข้อมูลสำเร็จ" width="70" height="60">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-lg-3 col-md-6 mb-3">
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
                                <a href="<?= \yii\helpers\Url::to(['/hpv/logerr']) ?>" target="_blank">
                                 <a href="#" class="popup-link" data-url="<?= yii\helpers\Url::to(['/hjepi/logerr']) ?>"> 
                                    <img src="images/accept.svg" title="ข้อมูลไม่สำเร็จ" width="70" height="60">
                                </a>
                            </div>
                                <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg"> <!-- Add the desired size class, e.g., modal-lg or modal-sm -->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Data fetched from the URL will be displayed here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Pending Requests Card Example -->
        <div class="col-lg-3 col-md-6 mb-3">
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
    
    </script>
    <!-- ############################# แสดงปุ่ม Select All  ################################################################### -->
    <?= Html::beginForm(['hjepi/check'], 'post', ['name' => 'frmMain']); ?>

<div id="loading-spinner" style="display:none;">
    <div class="spinner"></div>
</div>

<input name="btnButton1" class="btn btn-info btn btn-block" id="checkAll" type="submit" name="select" value="ส่งข้อมูล Moph-Claim JHCIS-EPI">

<input type="checkbox" id="checkAllBoxes" /> Check All

<table class="table table-striped" width="1100" border="0">
    <tr>
        <th width="30">
            <div align="center">
                <input type="checkbox" id="checkAllBoxesHeader" />
            </div>
        </th>
        <td width="30">
            <div align="center"> # </div>
        </td>
        <td width="30">
            <div align="center" style="font-size: 14px;"> วันที่ </div>
        </td>
        <td width="30">
            <div align="center" style="font-size: 14px;"> Visit </div>
        </td>
        <td width="30">
            <div align="left" style="font-size: 14px;"> Hn </div>
        </td>
        <td width="30">
            <div align="left" style="font-size: 14px;"> Cid </div>
        </td>
        <td width="150">
            <div align="left" style="font-size: 14px;"> ชื่อ-สกุล </div>
        </td>
        <td width="150">
            <div align="left" style="font-size: 14px;">อายุ </div>
        </td>
        <td width="30">
            <div align="left" class="text-nowrap" style="font-size: 14px;"> Lot </div>
        </td>
        <td width="30">
            <div align="left" class="text-nowrap" style="font-size: 14px;"> รหัสยา </div>
        </td>
        <td width="30">
            <div align="left" style="font-size: 14px;"> authencode </div>
        </td>
    </tr>
    <?php
    foreach ($hjpvProvider->getModels() as $key => $value) :
    ?>
        <tr>
            <td><input type="checkbox" name="chkDel[]" class="chkDel" id="chkDel<?= $key; ?>" value="<?php echo $value["visit_id"]; ?><?php echo $value["hn"]; ?>"></td>
            <td class="badge"><?php echo $value["No"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["dateepi"]; ?></td>
            <td style="font-size: 14px;"><?php echo $value["visit_id"]; ?></td>
            <td style="font-size: 14px;"><?php echo $value["hn"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["idcard"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["fullname"]; ?></td>
            <td style="font-size: 14px;"><?php echo $value["age"]; ?></td>
            <td style="font-size: 14px;"><?php echo $value["lotno"]; ?></td>
            <td style="font-size: 14px;"><?php echo $value["drugcode"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["claimcode"]; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<div class="box-footer with-border">
    <div class="col-md-12">
        <div class="form-group">
            <!-- <p> <?= Html::submitButton('ส่งข้อมูล JHIS-EPI', ['class' => 'btn btn-success']) ?></p> -->
            <!-- <?= Html::button(Yii::t('app', 'Ht'), ['class' => 'btn btn-warning pull-right', 'id' => 'btn-delete']) ?> -->
        </div>
    </div>
</div>

<?php

$this->registerJs('
  jQuery("#btn-delete").click(function(){
    var keys = $("#w0").yiiGridView("getSelectedRows");
    console.log(keys);
    if(keys.length>0){
      jQuery.post("' . Url::to(['delete-all']) . '",{ids:keys},function(){
      });
    }
  });
');
?>

<script>
    $(document).ready(function() {
        $('.popup-link').click(function(e) {
            e.preventDefault();
            var url = $(this).data('url');
            openModalWithData(url);
        });

        // Show the spinner when the button is clicked
        $('#selectAll').click(function() {
            $('#loading-spinner').show();
        });

        // Show the spinner before form submission
        $(document).on('beforeSubmit', 'form[name="frmMain"]', function() {
            $('#loading-spinner').show();
            return true;
        });

        // Hide the spinner on successful Pjax response
        $(document).on('pjax:success', function() {
            $('#loading-spinner').hide();
        });

        // Hide the spinner on any AJAX request completion
        $(document).ajaxStop(function() {
            $('#loading-spinner').hide();
        });

        // Handle check all functionality
        $("#checkAllBoxes, #checkAllBoxesHeader").click(function() {
            $(".chkDel").prop('checked', $(this).prop('checked'));
        });

        // If all checkboxes are checked, ensure the 'Check All' is checked, too
        $(".chkDel").click(function() {
            if ($(".chkDel:checked").length == $(".chkDel").length) {
                $("#checkAllBoxes, #checkAllBoxesHeader").prop('checked', true);
            } else {
                $("#checkAllBoxes, #checkAllBoxesHeader").prop('checked', false);
            }
        });
    });

    function openModalWithData(url) {
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('#myModal .modal-body').html(response);
                $('#myModal').modal('show');
            },
            error: function() {
                alert('An error occurred while fetching data.');
            }
        });
    }
</script>
