<?php
use yii\helpers\Html;

/** @var $content string */
/** @var $fileName string */

echo "<h2>" . Html::encode($fileName) . "</h2>";
echo "<pre>" . Html::encode($content) . "</pre>";

$this->registerCss("
    .sidebar-class.modal-open {
        opacity: 0.5; /* ทำให้ Sidebar โปร่งใสเมื่อ Modal เปิด */
    }
    pre {
        max-height: 600px;
        overflow-y: auto;
        background-color: #f8f8f8;
        padding: 15px;
        border-radius: 8px;
    }
");
?>
