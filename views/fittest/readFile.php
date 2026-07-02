<?php
/** @var $content string */
/** @var $fileName string */

echo "<h2> {$fileName}</h2>";
echo "<pre>{$content}</pre>"; // แสดงเนื้อหาไฟล์ในรูปแบบ preformatted



$this->registerCss("
    .sidebar-class.modal-open {
        opacity: 0; // ทำให้ Sidebar โปร่งใสเมื่อ Modal เปิด
    }
");
?>
