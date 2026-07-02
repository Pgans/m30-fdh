<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<style>
    .custom-width { width: 200px; }
</style>
<div class="container">
    <div class="row">
        <?php foreach ($files as $file): ?>
            <div class="col-6 mb-3">
                <?php
                echo Html::a($file, 'javascript:void(0)', [
                    'class' => 'btn btn-info btn-block custom-width',
                    'onclick' => "loadFileContent('" . Url::to([
                        'f16oprailway/read-file',
                        'fileName' => $file,
                        'visit'    => $visit,  // ← เพิ่มตรงนี้
                    ]) . "')",
                ]);
                ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="file-content" class="mt-3">
        <p class="text-muted">เลือกไฟล์เพื่อดูเนื้อหาหรือยังไม่ส่งหรือ ลบไปแล้วใน 7 วัน</p>
    </div>
</div>

<script>
function loadFileContent(url) {
    document.getElementById('file-content').innerHTML = '<p>กำลังโหลด...</p>';
    fetch(url)
        .then(response => {
            if (!response.ok) throw new Error('HTTP error ' + response.status);
            return response.text();
        })
        .then(data => {
            document.getElementById('file-content').innerHTML = data;
        })
        .catch(error => {
            document.getElementById('file-content').innerHTML = 
                '<div class="alert alert-danger">Error: ' + error.message + '</div>';
        });
}
</script>