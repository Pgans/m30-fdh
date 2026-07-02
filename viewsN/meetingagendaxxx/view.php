
<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $meetingAgenda->title;
$this->params['breadcrumbs'][] = ['label' => 'Meeting Agendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1 ><?= Html::encode($this->title) ?></h1>



<ul>
    <?php foreach ($meetingAgenda->agendaItems as $agendaItem) : ?>
        <li>
           <h1><?= Html::encode($agendaItem->topic) ?>:</h1> 
            <?= Html::encode($agendaItem->discription) ?>:
            <?php if (!empty($agendaItem->discription)) : ?>
                <?= Html::a('ไฟล์แนบ', $agendaItem->covenant,'format'=>'html', ['target' => '_blank']) ?>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
