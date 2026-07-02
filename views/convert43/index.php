<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
//use common\models\RContributionIpd;
use yii\data\ActiveDataProvider;

$this->title = 'Convert Files';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['thaimed/index']];

?>
<br>
<h2 style="color: yellow; font-size: 32px;" class="badge btn-info">
    Convert 43F JHCIS->HDC
</h2>
<!-- <p>16fdb = Yii::$app->db16</p> -->
<div class="row">
    <!-- ######################################################################################################################### -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                            <h2 style="color: red; font-size: 28px;" class="badge btn-info">
                                1
                            </h2>
                            <h3>
                                ตรวจสอบคุณภาพข้อมูล
                            </h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                            <img src="images/accept.svg" title="ตรวจสอบ" width="70" height="60">
                        </div>
                        <div class="text-center">
                            <a href="<?= \yii\helpers\Url::to(['convert43/maphn']) ?>" class="btn" style="font-size: 16px; background-color: #2f97ff; color: #ffffff;">

                                Map-Hn <i class="fa fa-arrow-circle-right"></i>
                                <p>host=192.168.200.14;dbname=maphn'</p>
                            </a>
                        </div>
                        </br>
                        <div class="text-center">
                            <a href="<?= \yii\helpers\Url::to(['convert43/checkpid']) ?>" class="btn btn-info" style="font-size: 16px;">
                                HN ว่าง <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                        </br>
                        <div class="text-center">
                            <a href="<?= \yii\helpers\Url::to(['convert43/hnmap']) ?>" id="exportExcelButton" class="btn btn-info" style="font-size: 16px;" onclick="openPopup()">
                                ตรวจสอบ HN ที่ไม่สามารถ MAP ได้ <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ######################################################################################################################### -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                            <h2 style="color: red; font-size: 28px;" class="badge btn-info">
                                2
                            </h2>
                            <h3>
                                นำเข้า 43 แฟ้ม jhcis
                            </h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                            <img src="images/accept.svg" title="ข้อมูลสำเร็จ" width="70" height="60">
                            <div class="text-center">
                                <a href="<?= \yii\helpers\Url::to(['convert43/imports']) ?>" class="btn btn-success" style="font-size: 16px;">
                                    Imports Data <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                            <p>*db->200.9->jhcis43f</p>
                            <p>*copy ไฟล์ไปที่ uploads/file43/address.txt</p>
                            <p>*copy ไฟล์ mathhn->jhcis43f</p>
                            <p>* ระบบจะตั้งค่าทุกแฟ้มเป็น 0 ก่อนนำเข้า</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ######################################################################################################################### -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                            <h2 style="color: red; font-size: 28px;" class="badge btn-info">
                                3
                            </h2>
                            <h3>
                                ประมวลผล
                            </h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                            <img src="images/reject.76840914.svg" title="ไม่ผ่าน" width="70" height="60">
                        </div>

                        <div class="text-center">
                            <a href="<?= \yii\helpers\Url::to(['convert43/update']) ?>" class="btn btn-info" style="font-size: 16px;">
                                Update Data <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                        <p>Update ทุกแฟ้มให้ HN = 10953</p>
                        <p>Update 99809 = 10953</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ######################################################################################################################### -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                            <h2 style="color: red; font-size: 28px;" class="badge btn-info">
                                4
                            </h2>
                            <h3>
                                ส่งออก 43 แฟ้ม
                            </h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                            <img src="images/reject.76840914.svg" title="ไม่ผ่าน" width="70" height="60">
                        </div>

                        <div class="text-center">
                            <a href="<?= \yii\helpers\Url::to(['convert43/export']) ?>" class="btn btn-primary" style="font-size: 16px;">
                                Export Files <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                        </br>
                        <div class="text-center">
                            <a href="<?= \yii\helpers\Url::to(['convert16/exportexcel']) ?>" id="exportExcelButton" class="btn btn-primary" style="font-size: 16px;">
                                รายชื่อและส่งออก ExcelFiles <i class="fa fa-arrow-circle-right"></i>
                            </a>

                        </div></br>
                        <div class="text-center">
                            <a href="<?= \yii\helpers\Url::to(['convert43/checkpid']) ?>" class="btn" style="font-size: 16px; background-color: #7575ff; color: #ffffff;">

                                ตรวจสอบข้อมูลว่าง <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script>
        function openPopup() {
            // เปิด Popup ด้วย window.open
            window.open('<?= \yii\helpers\Url::to(['convert43/hnmap']) ?>', 'HNMapPopup', 'width=800,height=600');
        }
    </script>



</div>
</div>


<div class='well'>

    <div>
        <div>

            <?php if (Yii::$app->session->hasFlash('success')) : ?>
                <div class="alert alert-success">
                    <?= Yii::$app->session->getFlash('success') ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('error')) : ?>
                <div class="alert alert-danger">
                    <?= Yii::$app->session->getFlash('error') ?>
                </div>
            <?php endif; ?>

            <!-- MapHN  -->
            <?php
$successMessage = Yii::$app->session->getFlash('success');
if ($successMessage !== null) {
    echo '<div class="alert alert-success">' . $successMessage . '</div>';
}

$warningMessage = Yii::$app->session->getFlash('warning');
if ($warningMessage !== null) {
    echo '<div class="alert alert-warning">' . $warningMessage . '</div>';
}

$errorMessage = Yii::$app->session->getFlash('error');
if ($errorMessage !== null) {
    echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
}

$dangerMessage = Yii::$app->session->getFlash('danger');
if ($dangerMessage !== null) {
    echo '<div class="alert alert-danger">' . $dangerMessage . '</div>';
}
?>



            <script>
                $(document).ready(function() {
                    $('#exportExcelButton').on('click', function(e) {
                        e.preventDefault(); // Prevent the default behavior (following the link)

                        // Open a popup window with the specified URL
                        var popupWindow = window.open($(this).attr('href'), '_blank', 'width=800,height=600');

                        // Focus on the new window if it's not already focused
                        if (window.focus) {
                            popupWindow.focus();
                        }
                    });
                });
            </script>