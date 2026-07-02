<?php
use yii\helpers\Html;

$this->title = 'Export Success';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="export-success">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>The export process was successful.</p>
    <!-- Additional content or actions -->
</div>
<ul>
    <?php foreach (scandir($baseDirectory) as $file) {
        if (!in_array($file, ['.', '..'])) {
            echo '<li><a href="' . $baseDirectory . $file . '">' . $file . '</a></li>';
        }
    } ?>
</ul>