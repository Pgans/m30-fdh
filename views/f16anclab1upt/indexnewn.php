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
<!-- AdminLTE CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@iconify/iconify@latest/dist/iconify.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<br>
<div class="well">
<div style="background-color: #126F30; padding: 10px; border: 0px solid #D4F1F5; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">
    <font color="white" size="5"><i class='fas fa-bed'></i> ผู้ป่วยใน สิทธิ์ประกันสุขภาพ [UCS] 16 แฟ้ม New E-claim</font>
    <p style="color: yellow;">16fdb = Yii::$app->db16 โรงพยาบาลม่วงสามสิบ</p>
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
                <span class="info-box-text" style="color: green; font-size: 18px;">เลือกช่วงวันเวลา</span>
                <!-- <span class="info-box-number"><?php echo $amount ?></span> -->
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
                <img src="images/accept.svg" title="ข้อมูลสำเร็จ" width="70" height="60">
                <div class="text-center">
                    <?php $form = ActiveForm::begin(['action' => ['f16only/data']]); ?>
                    ระหว่างวันที่:
                    <?php
                    echo yii\jui\DatePicker::widget([
                        'name' => 'date1',
                        'value' => $date1,
                        'language' => 'th',
                        'dateFormat' => 'yyyy-MM-dd',
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ]
                    ]);
                    ?>
                    ถึง:
                    <?php
                    echo yii\jui\DatePicker::widget([
                        'name' => 'date2',
                        'value' => $date2,
                        'language' => 'th',
                        'dateFormat' => 'yyyy-MM-dd',
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ]
                    ]);
                    ?>
                    <button class='btn btn-danger'> ประมวลผล </button>
                    <?php $form = ActiveForm::begin([]);
                    //echo Html::a('รายเดือน', ['thaimed/op_count'], ['class' => 'btn btn-success', 'id'=>'modalButton','target'=>'_blank']);
                    ActiveForm::end(); ?>
                    <?php ActiveForm::end(); ?>

                    <p>*ไฟล์ไป uploads/F16_claim</p>
                    <p>* ระบบจะตั้งค่าทุกแฟ้มเป็น 0 ก่อนนำเข้า</p>

                </div>
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
                    <a href="<?= \yii\helpers\Url::to(['f16only/exports']) ?>" class="btn btn-primary" style="font-size: 16px;">
                        Export Files <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>

                <p>ส่งออก 16 แฟ้มและ Zip ไฟล์นำเข้า </p>
                <p style="color: green;">Financial Data Hub</p>

            </div>
        </div>
        </div>

        <?php if (Yii::$app->session->hasFlash('error')) : ?>
    <div class="alert alert-danger" id="flash-message" style="text-align: right;">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>

    <script>
        // แสดง Flash Message เป็นเวลา 10 วินาทีแล้วซ่อนไป
        setTimeout(function() {
            document.getElementById('flash-message').style.display = 'none';
        }, 10000); // 10000 มิลลิวินาที = 10 วินาที
    </script>
<?php endif; ?>
