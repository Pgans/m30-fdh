<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\F16fdhipd */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    /* CSS เพื่อให้ปุ่มมีเส้นขอบและมีเมื่อโฮเวอร์ */
    .btn-bordered {
        border: 2px solid transparent; /* เส้นขอบโปร่งใสเมื่อปกติ */
        transition: all 0.3s ease; /* ทำให้การเปลี่ยนแปลงเส้นขอบเป็นอย่างนุ่มนวล */
    }

    .btn-bordered:hover {
        background-color: #2980b9; /* เปลี่ยนสีพื้นหลังเมื่อโฮเวอร์ */
        border-color: #2980b9; /* เปลี่ยนสีเส้นขอบเมื่อโฮเวอร์ */
        color: #fff; /* เปลี่ยนสีตัวอักษรเมื่อโฮเวอร์ */
    }

    .panel-3d {
        border: 1px solid #ccc; /* ให้มีเส้นเรียบ */
        border-radius: 6px; /* โค้งมน */
        padding: 20px; /* ระยะห่างขอบ */
        box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.75); /* เส้นเรืองแสง 3 มิติ */
    }

    /* CSS สำหรับลายน้ำ */
    .watermark {
        position: relative; /* ตั้งค่าตำแหน่งเป็น relative เพื่อให้ลายน้ำตามประมาณการ */
    }

    .watermark::before,
    .watermark::after {
        content: "OP-เกิดสิทธิ์ทันที";
        position: absolute;
        font-size: 5em; /* ขนาดตัวอักษร */
        color: rgba(0, 0, 0, 0.2); /* สีของตัวอักษร */
        pointer-events: none; /* ป้องกันการคลิกที่ตัวอักษร */
        z-index: 1; /* ให้ตัวอักษรอยู่ข้างหน้าเพื่อไม่ให้บังคับปุ่มหรือเนื้อหาอื่นๆ */
    }

    .watermark::before {
        top: 30%;
        left: 30%;
        transform: rotate(-45deg) translate(-50%, -50%);
    }

    .watermark::after {
        top: 70%;
        left: 70%;
        transform: rotate(-45deg) translate(-50%, -50%);
    }
</style>

<div class="watermark">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'main_table')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>

    <?= $form->field($model, 'main_query')->textarea(['rows' => 22, 'class' => 'form-control']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'บันทึก' : 'แก้ไข', [
            'class' => $model->isNewRecord ? 'btn btn-success btn-lg btn-3d btn-bordered' : 'btn btn-primary btn-lg btn-3d btn-bordered',
            'style' => 'background-color: #3498db; color: #fff; border-color: #3498db;'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
