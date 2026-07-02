<?php
namespace app\controllers;

use Yii;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\editable\Editable;
use yii\widgets\Pjax;

$this->title = 'PHR';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['rep/index']];
//$this->params['breadcrumbs'][] = 'รายงานข้อมูลE-Claim แยกตามREP';
?>
     <!-- <script type="text/javascript">
    setTimeout("frmMain.submit();",4000);
    //5000 อยากได้เร็วก็กำหนดตัวเลขน้อยๆเอานะ
    </script>   -->

     <script language="JavaScript">
	function ClickCheckAll(vol)
	{
	
		var i=1;
		for(i=1;i<=document.frmMain.hdnCount.value;i++)
		{
			if(vol.checked == true)
			{
				eval("document.frmMain.chkDel"+i+".checked=true");
			}
			else
			{
				eval("document.frmMain.chkDel"+i+".checked=false");
			}
		}
	}
</script>
<br>

<?php $this->registerCss("
    .form-row { display: flex; align-items: center; background-color: #9ecfcf; padding: 10px; }
    .form-field { margin-right: 20px; }
    .form-label { min-width: 80px; }
"); ?>

<?= Html::beginForm(Url::to(['phrjsontest/check']), 'post', ['name' => 'frmMain']) ?>

<div class="form-row">
    <div class="form-field">
        <?= Html::label('HN', 'hn', ['class' => 'form-label']) ?>
        <?= Html::input('text', 'hn', '', ['id' => 'hn']) ?>
    </div>

    <div class="form-field">
        <?= Html::label('Visit ID', 'visit_id', ['class' => 'form-label']) ?>
        <?= Html::input('text', 'visit_id', '', ['id' => 'visit_id']) ?>
    </div>

    <?= Html::submitButton('ตกลง', ['name' => 'submit', 'style' => 'background-color: green; color: white;']) ?>

</div>

<?= Html::endForm() ?>
<?php
$flash = Yii::$app->session->getFlash('jsonResult');
if ($flash !== null) {
    $resultArray = json_decode($flash, true);
    // ดำเนินการต่อที่นี่

    // แสดงข้อมูล JSON ด้วย highlight.js
    echo '<div style="border: 1px solid black; padding: 10px;">';
    echo '<pre><code class="json">';
    echo json_encode($resultArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    echo '</code></pre>';
    echo '</div>';
}
?>

<!-- ลิงก์ไฟล์ CSS ของ highlight.js -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.0/styles/default.min.css">

<!-- ลิงก์ไฟล์ JavaScript ของ highlight.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.0/highlight.min.js"></script>

<!-- เรียกใช้ highlight.js ในส่วน script -->
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        document.querySelectorAll('pre code').forEach((block) => {
            hljs.highlightBlock(block);
        });
    });
</script>

<!-- <?php 
$flash = Yii::$app->session->getFlash('jsonResult');
if ($flash !== null) {
    $resultArray = json_decode($flash, true);
    // ดำเนินการต่อที่นี่
    // ตัวอย่าง: แสดงข้อมูลใน $resultArray
    echo '<div style="border: 1px solid black; padding: 10px;">';
    echo '<pre>';
    print_r($resultArray);
    echo '</pre>';
    echo '</div>';
}
?> -->
