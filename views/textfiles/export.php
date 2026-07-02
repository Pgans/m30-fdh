<?php 
$this->title = "Palliative Car16 ";


 ?>

<h1>Export 16 แฟ้ม ส่ง New_Eclaim</h1>

<p>The following files have been exported:ใช้ส่งออกกรณีนำเข้าจากไฟล์Excel สำหรับงานเคลม โรงพยาบาลม่วงสามสิบ</p>

<ul>
    <?php foreach (scandir($baseDirectory) as $file) {
        if (!in_array($file, ['.', '..'])) {
            echo '<li><a href="' . $baseDirectory . $file . '">' . $file . '</a></li>';
        }
    } ?>
</ul>


