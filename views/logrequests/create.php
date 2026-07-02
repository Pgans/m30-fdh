
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Logrequests */

$this->title = Yii::t('app', 'เพิ่มข้อมูลต้องการพัฒนา');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'การพัฒนาส่งFDH'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logrequests-create" style="background: linear-gradient(to right, #e4f7f5, #f7fafc); padding: 20px; border-radius: 10px; 
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); border: 1px solid rgba(0, 0, 0, 0.1);">

    <h1 style="font-family: 'Arial', sans-serif; font-weight: bold; color: #333; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<!-- เพิ่มการโหลด Font Awesome หากต้องการใช้ไอคอน -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
