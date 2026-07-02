<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UploadForm */
/* @var $data array|null */

$this->title = 'Upload Lab Data';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="lab-upload">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <button class="btn btn-success">Upload</button>

    <?php ActiveForm::end() ?>
</div>

<?php if ($data !== null): ?>
    <h2>Query Results</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>HN</th>
                <th>Visit ID</th>
                <th>Registration Date</th>
                <th>Max Visit</th>
                <th>Max Date</th>
                <th>Staff ID</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= Html::encode($row['hn']) ?></td>
                    <td><?= Html::encode($row['visit_id']) ?></td>
                    <td><?= Html::encode($row['reg_datetime']) ?></td>
                    <td><?= Html::encode($row['max_visit']) ?></td>
                    <td><?= Html::encode($row['maxdate']) ?></td>
                    <td><?= Html::encode($row['staff_id']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
