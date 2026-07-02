<?php
use yii\helpers\Url;
?>
<!-- 
<h1>Export MySQL to Text File</h1>

<p>Click the button below to export MySQL data to a text file:</p>

<a href="<?= Url::to(['textfiles/export-text-file']) ?>" class="btn btn-primary">Export</a> -->


<h1>Export MySQL to Multiple Text Files</h1>

<p>The following files have been exported:</p>

<ul>
    <?php foreach (scandir($baseDirectory) as $file) {
        if (!in_array($file, ['.', '..'])) {
            echo '<li><a href="' . $baseDirectory . $file . '">' . $file . '</a></li>';
        }
    } ?>
</ul>
