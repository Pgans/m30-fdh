<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

$this->title = "Refers";
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['reg/index']];
$this->params['breadcrumbs'][] = 'งานเวชระเบียน';
?>

<div class='well'>
 
<?php
echo GridView::widget([
        'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
        'panel' => [
            'before'=>'<b style="color:blue ">ข้อมูลRefer ที่ Visit เดียว </b><b style="color: red">มีทั้ง Referin Referout </b>',
            'after'=>'<a>ประมวลผลย้อนหลัง 7 วัน</a> '
            ],
    ]
  );

        ?>
        <div class="alert alert-warning">
            <?=$sql?>
        </div>
