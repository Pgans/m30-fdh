<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
//use yii\helpers\HtmlPurifier;
use fedemotta\datatables\DataTables;

$this->title = Yii::t('app', 'E-Meeting Muangsamsib Hospital');
/* @var $this yii\web\View */
/* @var $searchModel app\models\WorksheetsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>


<style>
    .meeting-container {
        margin-bottom: 20px;
    }

    .meeting-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .agenda-list {
        list-style-type: disc;
        padding-left: 20px;
    }

    .agenda-item {
        margin-bottom: 5px;
    }

    .agenda-link {
        display: inline-block;
        background-color: #337ab7;
        color: #fff;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 4px;
        margin-right: 10px;
    }
</style>

<h1><?= Html::encode($meeting->title) ?></h1>

<?php foreach ($meeting->agendas as $agenda): ?>
    <h2><?= Html::encode($agenda->topic) ?></h2>
    <p><?= Html::encode($agenda->description) ?></p>
    <?= Html::a('View Agenda', ['agenda/view', 'id' => $agenda->id], ['class' => 'btn btn-primary']) ?>
    <hr>
<?php endforeach; ?>
