<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'View File';
$this->params['breadcrumbs'][] = ['label' => 'Upload Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$pdfUrl = Url::to(['upload-file/download', 'id' => $model->key_id]);

// Check if the file is a PDF (you can add more supported file extensions if needed)
$isPdfFile = in_array(pathinfo($model->filename, PATHINFO_EXTENSION), ['pdf']);

// Display PDF if it's a supported file format, otherwise show a message
if ($isPdfFile) {
    $pdfViewer = "<iframe src='$pdfUrl' width='100%' height='600px'></iframe>";
} else {
    $pdfViewer = "<p>File format not supported for preview.</p>";
}

// Register the PDF.js viewer script and CSS
$this->registerJsFile('@web/pdfjs/pdf.js');
$this->registerJs("PDFJS.workerSrc = '@web/pdfjs/pdf.worker.js';", yii\web\View::POS_HEAD);
?>


<h1><?= Html::encode($this->title) ?></h1>

<div class="file-view">
    <h3>File Information</h3>
    <p><strong>Agenda ID:</strong> <?= $model->agenda_id ?></p>
    <p><strong>Key Point:</strong> <?= $model->key_point ?></p>
    <p><strong>Show Work:</strong> <?= $model->show_work ? 'Yes' : 'No' ?></p>
    <p><strong>Created Date:</strong> <?= $model->create_date ?></p>
    <p><strong>Filename:</strong> <?= $model->filename ?></p>
    <p><strong>Path:</strong> <?= $model->path ?></p>

    <div>
        <?php
        $fileUrl = Yii::getAlias('@web') . '/' . $model->path;
        echo Html::a('Download File', $fileUrl, ['class' => 'btn btn-primary', 'target' => '_blank']);

        ?>
      
    <?= Html::a('Upload File', ['create'], ['class' => 'btn btn-success']) ?>
    
</div>
Embed the PDF viewer
<div>
        <iframe src="<?= $fileUrl ?>" width="100%" height="600px"></iframe>
    </div>