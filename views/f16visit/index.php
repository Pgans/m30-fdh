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
<style>
    .btn-pink {
        background-color: #958beb;
        /* ตั้งค่าสีพื้นหลังเป็นม่วง */
        color: white;
        /* ตั้งค่าสีของตัวหนังสือเป็นขาว */
    }
</style>

<div style="background-color: #126F30; padding: 10px; border: 0px solid #D4F1F5;">
    <font color="white" size="5"><i class='fas fa-bed'></i> ผู้ป่วยใน สิทธิ์ประกันสุขภาพ [UCS] 16 แฟ้ม New E-claim</font> 
    <p style="color: yellow;">16fdb = Yii::$app->db16 โรงพยาบาลม่วงสามสิบ</p>
</div>
<h5 style="color: green;"><i class="fas fa-user"></i> ข้อมูล 16 แฟ้มผู้ป่วยในเลือกตาม AN </h5>

<!-- <p>16fdb = Yii::$app->db16</p> -->
<div class="row">
    <!-- ######################################################################################################################### -->
    <div class="col-lg-5 col-md-4 mb-5">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                            <h2 style="background-color: #958beb; color: red; font-size: 28px;" class="badge btn-info">
                                1
                            </h2>

                            <h3 class="text-center">
                                ข้อมูล 16 แฟ้มเลือกตาม AN
                            </h3>

                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                            <img src="images/accept.svg" title="ข้อมูลสำเร็จ" width="70" height="60">
                            <div class="text-center">
                                <?php $form = ActiveForm::begin(['action' => ['f16visit/data']]); ?>
                                <div class="row">
                                    <div class="col-md-4 offset-md-4"> <!-- Adjust the column width and offset as needed -->
                                        <?= Html::input('text', 'an', '', ['class' => 'form-control', 'maxlength' => 10, 'style' => 'width:300px']) ?>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <?= Html::submitButton('ตกลง', ['class' => 'btn btn', 'style' => 'background-color: #958beb; color: white;']) ?>
                                        </div>
                                    </div>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                            <div class="col-lg-5 col-md-6 mb-3">
                               
                                <h4 class="text-center" style="color:#1e8fa8;">
                                    วิธีการใช้งาน
                                </h4>
                                <h5 class="text-center" style="color:#1e8fa8;">* ใส่ AN = 6 หลัก</h5>
                                </p>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-3 mb-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                            <h2 style="background-color: #958beb; color: red; font-size: 28px;" class="badge btn-info">
                                2
                            </h2>

                            <h3 class="text-center">
                                ส่งออก 16 แฟ้ม
                            </h3>
                        </div>
                        <div class="text-right">
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                                <img src="images/reject.76840914.svg" title="ไม่ผ่าน" width="70" height="60">
                            </div>

                            <div class="text-center">
                                <a href="<?= \yii\helpers\Url::to(['f16visit/exports']) ?>" class="btn btn-primary" style="background-color: #958beb; color: white; font-size: 16px;">
                                    Export Files <i class="fa fa-arrow-circle-right"></i>
                                </a>

                            </div>

                            <div class="text-center">
                                <h4 style="color:#1e8fa8;"> * ส่งออก 16 แฟ้มและ Zip ไฟล์นำเข้า</h4>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <?php
            ?>
        </div>
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