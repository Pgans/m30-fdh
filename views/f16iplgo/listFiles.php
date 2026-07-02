<?php
use yii\helpers\Html;
use yii\helpers\Url;


?>
<style>
    .custom-width {
    width: 200px; /* ปรับความกว้างตามต้องการ */
}
</style>
<div class="container">
    

    <div class="row">
        <?php foreach ($files as $file): ?>
            <?php if ($file !== '.' && $file !== '..'): ?> <!-- ข้าม '.' และ '..' -->
                <div class="col-6 mb-3"> <!-- เพิ่มระยะห่างระหว่างลิงก์ -->
                    <?php
                    // สร้างลิงก์สำหรับแต่ละไฟล์ พร้อมเรียกใช้ฟังก์ชัน JavaScript เมื่อคลิก
                    echo Html::a($file, 'javascript:void(0)', [
                        'class' => 'btn btn-info btn-block custom-width',
                        'onclick' => "loadFileContent('" . Url::to(['f16iplgo/read-file', 'fileName' => $file]) . "')", // ส่งคำขอ Ajax เมื่อคลิก
                    ]);
                    ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- ส่วนที่จะแสดงเนื้อหาจาก readfile.php -->
    <div id="file-content" class="mt-3"> <!-- เพิ่มช่องว่างด้านบน -->
        <h3>File Content</h3>
        <p>เนื้อหาจะปรากฏที่นี่เมื่อเลือกไฟล์</p>
    </div>
</div>

<!-- JavaScript เพื่อโหลดเนื้อหาโดยใช้ Ajax -->
<script>
function loadFileContent(url) {
    // ส่งคำขอ Ajax เพื่อดึงเนื้อหา
    fetch(url)
        .then(response => response.text()) // รับข้อมูลเป็นข้อความ
        .then(data => {
            // อัปเดตเนื้อหาในส่วนที่กำหนด
            var contentDiv = document.getElementById('file-content');
            contentDiv.innerHTML = data; // แสดงเนื้อหาจาก readfile.php
        })
        .catch(error => {
            console.error('Error loading file content:', error);
            var contentDiv = document.getElementById('file-content');
            contentDiv.innerHTML = 'Error loading content';
        });
}
</script>

