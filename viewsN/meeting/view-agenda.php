
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
?>
<h1><?= Html::encode($meeting->title) ?></h1>

<table>
    <tr>
        <th>Topic</th>
        <th>Description</th>
        <th>Meeting Link</th>
    </tr>
    <?php foreach ($meeting->agendas as $agenda): ?>
        <tr>
            <td><?= Html::encode($agenda->topic) ?></td>
            <td><?= Html::encode($agenda->description) ?></td>
            <td><?= Html::a('Go to Meeting', ['meeting/view', 'id' => $agenda->meeting_id]) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
