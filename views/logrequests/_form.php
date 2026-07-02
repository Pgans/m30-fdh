<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker; // เพิ่มเครื่องหมาย ; ที่นี่

/* @var $this yii\web\View */
/* @var $model app\models\Logrequests */
/* @var $form yii\widgets\ActiveForm */
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<?php
$this->registerJs('
    $.datepicker.regional["th"] = {
        closeText: "ปิด",
        prevText: "&#x3C;ย้อน",
        nextText: "ถัดไป&#x3E;",
        currentText: "วันนี้",
        monthNames: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
        monthNamesShort: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."],
        dayNames: ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์"],
        dayNamesShort: ["อา.", "จ.", "อ.", "พ.", "พฤ.", "ศ.", "ส."],
        dayNamesMin: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส"],
        weekHeader: "สัปดาห์",
        firstDay: 0,
        isRTL: false,
        showMonthAfterYear: false,
        yearRange: "c-100:c+10",
        dateFormat: "yy-mm-dd",
        // กำหนดการตั้งค่าต่างๆ ของ DatePicker
    };
    $.datepicker.setDefaults($.datepicker.regional["th"]);
');
?>
<div class="logrequests-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'users')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'action')->textarea(['rows' => 6]) ?>

    <!-- <?= $form->field($model, 'request_date')->textInput() ?> -->

    <?= $form->field($model, 'developer_comments')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'completion_date')->widget(DatePicker::class, [
        'options' => ['class' => 'form-control'],
        'clientOptions' => [
            'dateFormat' => 'yyyy-mm-dd', // รูปแบบวันที่ที่ต้องการ
            'changeMonth' => true,       // ตัวเลือกให้เปลี่ยนเดือน
            'changeYear' => true,        // ตัวเลือกให้เปลี่ยนปี
            'showButtonPanel' => true,   // ปุ่มให้ปิดปฏิทิน
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fas fa-save"></i> ' . Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
