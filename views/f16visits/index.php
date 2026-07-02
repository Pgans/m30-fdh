<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\web\View;
//use common\models\RContributionIpd;
use yii\data\ActiveDataProvider;

$this->title = 'OPD-VISIT';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['thaimed/index']];

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Example</title>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@iconify/iconify@latest/dist/iconify.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<br>
<div class="well">
    <div style="background-color: #ff6b24; padding: 10px; border: 0px solid #D4F1F5; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">
        <font color="white" size="5"><i class='fas fa-bed'></i> ผู้ป่วยนอก สิทธิ์ประกันสุขภาพ [UCS] 16 แฟ้ม New E-claim</font>
        <p style="color: pink;">16fdb = Yii::$app->db16 โรงพยาบาลม่วงสามสิบ</p>
    </div>
    <h5 style="color: green; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.1); padding: 10px;"><i class="fas fa-user"></i> ข้อมูล 16 แฟ้มส่ง Finacail Data Hub </h5>

    <!-- <p>16fdb = Yii::$app->db16</p> -->

    <div class="row">
        <!-- ######################################################################################################################### -->

        <div class="col-xl-3 col-md-5 mb-5">
            <!-- <div class="info-card bg-info" style="border: 4px solid gray;"> -->
            <div class="info-card bg-info" style="box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">
                <span class="info-box-icon"><i class="far fa-calendar-check" style="color: green;"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="color: green; font-size: 18px;">เลือกตาม Visit 10 หลัก</span>
                    <!-- <span class="info-box-number"><?php echo $amount ?></span> -->
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                    <img src="images/accept.svg" title="ข้อมูลสำเร็จ" width="70" height="60">
                    <div class="text-center">
                                <?php $form = ActiveForm::begin(['action' => ['f16visits/data']]); ?>
                                <div class="row">
                                    <div class="col-md-4 offset-md-4"> <!-- Adjust the column width and offset as needed -->
                                        <?= Html::input('text', 'visit_id', '', ['class' => 'form-control', 'maxlength' => 10, 'style' => 'width:300px']) ?>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <?= Html::submitButton('ตกลง', ['class' => 'btn btn', 'style' => 'background-color: #958beb; color: white;']) ?>
                                        </div>
                                    </div>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                        <p>*ไฟล์ไป uploads/F16_claim</p>
                        <p>* ระบบจะตั้งค่าทุกแฟ้มเป็น 0 ก่อนนำเข้า</p>

                    </div>
                </div>
            </div>
       
        <div class="col-xl-3 col-md-3 mb-3">
            <!-- <div class="info-card bg-info" style="border: 4px solid gray;"> -->
            <div class="info-card bg-info" style="box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">
                <span class="info-box-icon"><i class="far fa-calendar-check" style="color: green;"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="color: green; font-size: 18px;">ส่งออก 16 แฟ้ม</span>
                    <!-- <span class="info-box-number"><?php echo $amount ?></span> -->
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                    <img src="images/accept.svg" title="ข้อมูลสำเร็จ" width="70" height="60">
                    </br>
                    <div class="text-center">
                        <a href="<?= \yii\helpers\Url::to(['f16visits/exports']) ?>" class="btn btn-primary" style="font-size: 16px;">
                            Export Files <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>

                    <p>ส่งออก 16 แฟ้มและ Zip ไฟล์นำเข้า </p>
                    <p style="color: green;">Financial Data Hub</p>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3 mb-3">
            <!-- <div class="info-card bg-info" style="border: 4px solid gray;"> -->
            <div class="info-card bg-info" style="box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">
                <span class="info-box-icon"><i class="far fa-calendar-check" style="color: green;"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="color: green; font-size: 18px;">ปรับคิวรี่</span>
                    <!-- <span class="info-box-number"><?php echo $amount ?></span> -->
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                    <img src="images/accept.svg" title="ข้อมูลสำเร็จ" width="70" height="60">
                    </br>
                    <div class="text-center">
                        <a href="<?= \yii\helpers\Url::to(['f16fdhvisit/index']) ?>" class="btn btn-warning modalLink" style="font-size: 16px;" target="_blank">
                            Query <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>


                    <p>รูปแบบ ip.dsc_dt BETWEEN '$date1' AND '$date2' </p>
                    <p style="color: green;">Financial Data Hub</p>

                </div>
            </div>
        </div>



        <?php
        $flash = Yii::$app->session->getFlash('info');
        $timeout = Yii::$app->session->getFlash('timeout');

        $this->registerJs("
            setTimeout(function() {
                $('.alert').hide();
            }, $timeout);
        ", View::POS_READY);

        if (!empty($flash)) {
            echo '<div class="alert alert-info">' . $flash . '</div>';
        }
        ?>