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
    คัดกรองสุขภาพกาย-จิต (สิทธิ์ประกันสุขภาพบัตรทอง)->JHCIS-PCU
</h2>

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
                                นำเข้าข้อมูล 16 แฟ้ม
                            </h3>
                        </div>

                       

                        <div class="icon">
                            <i class="ion ion-person"></i>
                            <img src="images/accept.svg" title="ข้อมูลสำเร็จ" width="70" height="60">
                            <div class="text-center">
                                <a href="<?= \yii\helpers\Url::to(['convert16/imports']) ?>" class="btn btn-success" style="font-size: 16px;">
                                    Imports Data <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>

                            <p>*copy ไฟล์ไปที่ uploads/file16/ADP.txt</p>
                            <p>* ระบบจะตั้งค่าทุกแฟ้มเป็น 0 ก่อนนำเข้า</p>
                            <p>***ต้องแปลงเป็น UTF-8***</p>
                            <p>-DRU.txt ,-PAT.txt,-OPD.txt </p>

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
                                ประมวลผล
                            </h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                            <img src="images/reject.76840914.svg" title="ไม่ผ่าน" width="70" height="60">
                        </div>

                        <div class="text-center">
                            <a href="<?= \yii\helpers\Url::to(['convert16/update']) ?>" class="btn btn-info" style="font-size: 16px;">
                                Update Data <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                        <p>update ทุกแฟ้มให้ HN = 10953</p>
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
                                ส่งออก 16 แฟ้ม
                            </h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                            <img src="images/reject.76840914.svg" title="ไม่ผ่าน" width="70" height="60">
                        </div>

                        <div class="text-center">
                            <a href="<?= \yii\helpers\Url::to(['convert16/exports']) ?>" class="btn btn-primary" style="font-size: 16px;">
                                Export Files <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                        </br>
                        <div class="text-center">
                            <a href="<?= \yii\helpers\Url::to(['convert16/exportexcel']) ?>" id="exportExcelButton" class="btn btn-primary" style="font-size: 16px;">
                                รายชื่อและส่งออก ExcelFiles <i class="fa fa-arrow-circle-right"></i>
                            </a>

                        </div>
                        <p>ส่งออก 16 แฟ้มและ Zip ไฟล์นำเข้า </p>
                        <p>New E-Claim</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


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