<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\web\View;
//use common\models\RContributionIpd;
use yii\data\ActiveDataProvider;
use dosamigos\datepicker\DatePicker;
use yii\bootstrap\Modal;



$this->title = 'FDH-OPD_SRT สิทธิ์การรถไฟ';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['thaimed/index']];
$this->registerCss('
    .log-line {
        padding: 5px;
    }
');
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Example</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@iconify/iconify@latest/dist/iconify.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<style>
    .my-striped-table tr:nth-child(odd) {
        background-color: #efefef;
    }
    .my-striped-table tr:nth-child(even) {
        background-color: white;
    }
    .custom-hover tbody tr:hover {
        background-color: #f5f5f5;
    }
    .btn-blink {
        animation: blink-animation 1s infinite;
    }
    @keyframes blink-animation {
        0% { opacity: 1; }
        50% { opacity: 0; }
        100% { opacity: 1; }
    }
    .btn-group-modern {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin-top: 10px;
    }Modern {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
        text-decoration: none;
        color: white;
        transition: all 0.3s ease-in-out;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }
    .btn-modern i {
        font-size: 18px;
    }
    .btn-cidhn { background: linear-gradient(135deg, #18abab, #35e8d7); }
    .btn-opd { background: linear-gradient(135deg, #18abab, #35e8d7); }
    .btn-ipd { background: linear-gradient(135deg, #ff512f, #dd2476); }
    .btn-refers { background: linear-gradient(135deg, #18abab, #35e8d7); }
    .btn-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.3);
    }
    .floating-button {
        position: fixed;
        bottom: 150px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
    }
    .floating-button button {
        background-color: #00a400;
        border: 4px solid #dadada;
        font-size: 20px;
        color: white;
        padding: 10px 20px;
        cursor: pointer;
        width: 700px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .floating-button button:hover {
        background-color: #008a00;
        transform: scale(1.05);
    }
    .floating-button button i {
        margin-right: 10px;
        font-size: 24px;
    }
    .visit-element {
        background-color: lightgreen;
        padding: 5px;
        margin-bottom: 5px;
    }
    .panel-custom {
        background-color: #2f1c00;
        max-height: 200px;
        overflow-y: auto;
    }
    .panel-custom .panel-heading, .panel-custom .panel-body {
        color: #00aaff;
    }
    .panel-body {
        padding: 10px;
    }
    .custom-spinner {
        border: 16px solid #f3f3f3;
        border-top: 16px solid purple;
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 1s linear infinite;
    }
    .code-block {
        font-family: "Courier New", Courier, monospace;
        background-color: #f5f5f5;
        padding: 10px;
        border: 1px solid #ddd;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
   .info-card {
        background: linear-gradient(135deg, #f5f7fa, #f5f7fa); 
        box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.15);
        color: #333;
        padding: 20px;
        border-radius: 10px;
        font-size: 16px;
    }
    #loading-spinner {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
    }
    /* ปรับเป็นสีเทา-ขาว เรียบร้อยครับ */
    .my-striped-table tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.05); 
    }
</style>



<script>
    function ClickCheckAll(vol) {
        var checkboxes = document.frmMain.querySelectorAll('input[name="chkDel[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = vol.checked;
        });
    }
</script>

<div class="row">
    <div class="col-xl-3 col-md-12 mb-12">
        <div class="info-card bg-info" style="box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">
            <span class="info-box-icon"><i class="far fa-calendar-check" style="color: green;"></i></span>
            <img src="uploads/LOGO-FDH.png" title="ไม่ผ่าน" width="150" height="80">
            <img src="uploads/brand.png" title="ไม่ผ่าน" width="180" height="80">
            <img src="uploads/cropped-logo-DHES2.png" width="350" height="80">
            <img src="uploads/สปสช.png" width="150" height="80">
            <img src="uploads/imagesm30.jpg" width="300" height="80">

            <div style="text-align: right;">
                <?= Html::a('<i class="fa fa-check-square" aria-hidden="true"></i> ผ่าน', null, ['class' => 'btn btn-success', 'id' => 'link1']) ?>
                <?= Html::a('<i class="fa fa-ban" aria-hidden="true"></i> ไม่ผ่าน', null, ['class' => 'btn btn-danger', 'id' => 'link2']) ?>

                <a href="<?= Url::to(['f16oprailway/run-curl', 'date1' => $date1, 'date2' => $date2]) ?>" class="btn btn-info" style="font-size: 16px; border-radius: 25px;">
                    RunToken <i class="fa fa-arrow-circle-right"></i>
                </a>

                <a href="<?= \yii\helpers\Url::to(['fdhoprailway/index']) ?>" class="btn btn-warning modalLink" style="font-size: 16px;" target="_blank">
                    Query <i class="fa fa-arrow-circle-right"></i>
                </a>

                <?= Html::a('Export', ['f16oprailway/exports'], ['class' => 'btn btn-success']) ?>

                <?= Html::a('<i class="fa fa-trash"></i> ลบ claim_token ทั้งหมด', ['delete-all'], [
                    'class' => 'btn btn-danger',
                    'encode' => false,
                    'data' => [
                        'confirm' => 'คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูล claim_token ทั้งหมด?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>

            <script>
                function openPopup() {
                    const url = "<?= \yii\helpers\Url::to(['f16telemed/exportexcel']); ?>";
                    const popupWindow = window.open(url, 'ExcelPopup', 'width=600,height=400');
                    popupWindow.focus();
                }
            </script>

            <div class="container" style="padding-top: 0;">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <?= Html::beginForm(['index'], 'get', ['class' => 'd-flex align-items-center justify-content-between flex-wrap']) ?>
                        <div class="form-inline d-flex align-items-center">
                            <label class="mr-2 mb-0">วันที่:</label>
                            <?= DatePicker::widget([
                                'name' => 'date1',
                                'value' => $date1,
                                'language' => 'th',
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd',
                                    'todayHighlight' => true,
                                ],
                                'options' => [
                                    'class' => 'form-control shadow-sm',
                                    'placeholder' => 'เริ่ม',
                                    'style' => 'font-size: 1.2rem; padding: 10px 15px; background-color: #e0ffff; border: 2px solid #87cefa; border-radius: 20px; color: #333;',
                                ],
                            ]) ?>

                            <label class="mr-2 mb-0">ถึง:</label>
                            <?= DatePicker::widget([
                                'name' => 'date2',
                                'value' => $date2,
                                'language' => 'th',
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd',
                                    'todayHighlight' => true,
                                ],
                                'options' => [
                                    'class' => 'form-control shadow-sm',
                                    'placeholder' => 'สิ้นสุด',
                                    'style' => 'font-size: 1.2rem; padding: 10px 15px; background-color: #e0ffff; border: 2px solid #b0e0e6; border-radius: 20px; color: #333;',
                                ],
                            ]) ?>

                            <?= Html::submitButton('🔍 ค้นหา', [
                                'class' => 'btn btn-outline-dark shadow',
                                'style' => 'font-size: 1.2rem; font-weight: bold; padding: 10px 20px; border-radius: 20px; background-color: #e0ffff; transition: all 0.3s;'
                            ]) ?>
                        </div>
                        <?= Html::endForm() ?>
                    </div>
                </div>
            </div>
            <br>

            <p>
                <button class="btn btn-primary" onclick="printReport()">🖨️ พิมพ์รายงาน</button>
            </p>

            <script>
            function printReport() {
                var tableHTML = document.querySelector('.my-striped-table').outerHTML;
                var newWin = window.open('', '', 'width=1200,height=800');
                newWin.document.write('<html><head><title>Print Report</title>');
                newWin.document.write('<style>@media print{@page{size: landscape; margin:10mm;} table{white-space:nowrap;font-size:12px;border-collapse:collapse;} th,td{border:1px solid #ddd;padding:5px;}}</style>');
                newWin.document.write('</head><body>');
                newWin.document.write(tableHTML);
                newWin.document.write('<script>window.onload=function(){window.print();window.close();}<\/script>');
                newWin.document.write('</body></html>');
                newWin.document.close();
            }
            </script>

            <div class="page-container">
                <div style="height: 500px; overflow-y: auto;">

                    <div id="loading-spinner" style="display: none; color: purple; font-size: 100px;">
                        <div class="custom-spinner"></div>
                    </div>

                    <?= Html::beginForm(['f16oprailway/data'], 'post', ['name' => 'frmMain', 'id' => 'formMains']); ?>
                        <?= Html::hiddenInput('date1', $date1) ?>
                        <?= Html::hiddenInput('date2', $date2) ?>

                        <?php
                        $allowedUsers = [6, 96, 289, 383];
                        $currentUserId = Yii::$app->user->id ?? null;
                        if (in_array($currentUserId, $allowedUsers)) :
                        ?>
                            <div class="floating-button" style="position: fixed; bottom: calc(3 * 2rem); left: 50%; transform: translateX(-50%); z-index: 1000;">
                                <button type="button" name="btnSubmit" id="btnSubmit" class="btn btn-success btn btn-block" style="background-color: #cc1ceb; border: 4px solid #dadada; padding: 10px 20px; border-radius: 30px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); font-size: 1.5rem; text-transform: uppercase; cursor: pointer; width: auto;">
                                    <i class="fa fa-arrow-circle-right" style="margin-right: 10px;"></i>
                                    ส่งข้อมูล OP-SRT สิทธิ์การรถไฟ
                                </button>
                            </div>
                        <?php endif; ?>

                        <table class="table my-striped-table" width="1000" border="0" bordercolor="#ddd" style="border-collapse: collapse; box-shadow: 2px 2px 5px rgba(0,0,0,0.2);">
                            <thead>
                                <tr>
                                    <th width="30" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 1;">
                                        <div align="center">
                                            <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);">
                                        </div>
                                    </th>
                                    <th width="30" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 1;"><div align="center"> # </div></th>
                                    <th width="30" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 1;"><div align="center" style="font-size: 14px;"> วันที่ </div></th>
                                    <th width="30" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 1;"><div align="center" style="font-size: 14px;"> เลขบริการ </div></th>
                                    <th width="30" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 1;"><div align="left" style="font-size: 14px;"> Hn </div></th>
                                    <th width="150" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 1;"><div align="left" style="font-size: 14px;"> ชื่อ-สกุล </div></th>
                                    <th width="30" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 1;"><div align="left" style="font-size: 14px;">อายุ </div></th>
                                    <th width="30" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 1;"><div align="left" style="font-size: 14px;">น้ำหนัก </div></th>
                                    <th width="30" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 1;"><div align="left" style="font-size: 14px;">ส่วนสูง </div></th>
                                    <th width="30" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 1;"><div align="left" style="font-size: 14px;">แผนก </div></th>
                                    <th width="30" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 1;"><div align="left" style="font-size: 14px;">โรคหลัก </div></th>
                                    <th width="30" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 1;"><div align="left" style="font-size: 14px;">รหัสโรค </div></th>
                                    <th width="30" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 1;"><div align="left" class="text-nowrap" style="font-size: 14px;"> สิทธิ์ </div></th>
                                    <th width="30" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 1;"><div align="left" style="font-size: 14px;">สถานะ </div></th>
                                    <th width="30" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 1;"><div align="left" style="font-size: 14px;">EDC </div></th>
                                    <th width="30" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 1;"><div align="left" style="font-size: 14px;">ค่ารักษา </div></th>
                                    <th width="30" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 1;"><div align="left" style="font-size: 14px;">ปิดสิทธิ์ </div></th>
                                    <th width="50" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 1;"><div align="center" style="font-size: 14px;">เปิดไฟล์</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataProvider->getModels() as $key => $value) : ?>
                                <tr style="background-color: <?php echo (empty($value['messagecode']) ? '#f5e8fa' : '#ebfff9'); ?>;">
                                    <td><input type="checkbox" name="chkDel[]" value="<?php echo $value["visit_id"]; ?><?php echo $value["hn"]; ?>" style="width: 17px; height: 17px;"></td>
                                    <td class="badge"><?php echo $value["No"]; ?></td>
                                    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["regdate"]; ?></td>
                                    <td style="font-size: 14px;"><?php echo $value["visit_id"]; ?></td>
                                    <td style="font-size: 14px;"><?php echo $value["hn"]; ?></td>
                                    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["fullname"]; ?></td>
                                    <td style="font-size: 14px;"><?php echo $value["age"]; ?></td>
                                    <td style="font-size: 14px;"><?php echo $value["weight"]; ?></td>
                                    <td style="font-size: 14px;"><?php echo $value["height"]; ?></td>
                                    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["unit_name"]; ?></td>
                                    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["Diagx"]; ?></td>
                                    <td class="text-nowrap" style="font-size: 14px; color: green;"><?php echo $value["Diag"]; ?></td>
                                    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["inscl"]; ?></td>
                                    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["messagecode"]; ?></td>
                                    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["claim_code"]; ?></td>
                                    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["amount"]; ?></td>
                                    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["enpoint"]; ?></td>
                                    <td align="center">
                                        <?= Html::a('<i class="fa fa-folder-open"></i>', '#', [
                                            'class'       => 'btn btn-primary btn-xs btn-open-file',
                                            'data-toggle' => 'modal',
                                            'data-target' => '#myModal',
                                            'data-url'    => \yii\helpers\Url::to([
                                                'f16oprailway/list-files-partial',
                                                'visit' => $value['visit_id'],
                                            ]),
                                        ]) ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?= Html::endForm(); ?>
                </div>
            </div>

            <div id="model1" style="display: none;">
                <h2 style="color: #2db94d; border: 2px solid #c3e6cb; padding: 5px; text-align: center; border-radius: 10px;">แสดงรายการผ่าน</h2>
                <div class="table-wrapper">
                    <?= \yii\grid\GridView::widget([
                        'dataProvider' => $passProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'visit_id', 'pid', 'users', 'response', 'd_update',
                        ],
                        'tableOptions' => [
                            'class' => 'table table-striped table-hover custom-hover',
                            'style' => 'width: 100%; border: 1px solid #dee2e6; box-shadow: 0px 2px 10px rgba(0,0,0,0.1); border-radius: 10px;',
                        ],
                        'headerRowOptions' => ['style' => 'background-color: lightgreen;'],
                        'rowOptions' => ['style' => 'background-color: #ecffec;'],
                    ]); ?>
                </div>
            </div>

            <div id="model2" style="display: none;">
                <h2 style="color: #ff0000; border: 2px solid #c3e6cb; padding: 5px;">แสดงรายการไม่ผ่าน</h2>
                <?= \yii\grid\GridView::widget([
                    'tableOptions' => ['class' => 'table table-striped table-hover1', 'width' => '100%', 'cellspacing' => '1'],
                    'dataProvider' => $errorProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'visit_id', 'pid', 'users', 'response', 'd_update',
                    ],
                    'headerRowOptions' => ['style' => 'background-color: #ff5eae; color: white;'],
                    'rowOptions' => ['style' => 'background-color: #ffb3b3; color: #ff0000;'],
                ]); ?>
            </div>

        </div>
    </div>
</div>

<!-- ========== MODAL เปิดไฟล์ (อันเดียว ไม่ซ้อน) ========== -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-folder-open"></i> รายการไฟล์</h4>
            </div>
            <div class="modal-body">
                <!-- AJAX load จะใส่ content ตรงนี้ -->
            </div>
        </div>
    </div>
</div>

<!-- ========== MODAL Progress ========== -->
<div class="modal fade" id="progressModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content" style="border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
            <div class="modal-body" style="padding: 30px;">
                <h4 class="text-center" id="progressTitle" style="color: #2e7d32; font-weight: bold; margin-bottom: 20px;">
                    <i class="fas fa-spinner fa-spin"></i> เริ่มต้นระบบเตรียมคิว...
                </h4>
                <div class="progress" style="height: 25px; border-radius: 15px; margin-bottom: 20px; background-color: #e0f2f1;">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; background-color: #00a400; font-size: 14px; line-height: 25px; font-weight: bold;">
                        0%
                    </div>
                </div>
                <div style="background-color: #ffffff; color: #333333; padding: 15px; border: 1px solid #cccccc; border-radius: 5px; font-family: 'Courier New', Courier, monospace; min-height: 180px; max-height: 320px; overflow-y: auto; font-size: 14px; font-weight: bold; line-height: 1.7;" id="logConsole">
                    <div style="color: #888;">[ระบบ] ตรวจสอบสิทธิ์การส่งข้อมูล...</div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs("

    // ========== เปิดไฟล์ Modal ==========
    // ใช้ event delegation ผ่าน class .btn-open-file เพื่อป้องกันชนกับ Bootstrap modal event
    \$(document).on('click', '.btn-open-file', function(e) {
        e.preventDefault();
        var url = \$(this).data('url');
        \$('#myModal .modal-body').html('<div style=\"text-align:center; padding:30px;\"><i class=\"fa fa-spinner fa-spin fa-2x\"></i><br>กำลังโหลด...</div>');
        \$('#myModal').modal('show');
        \$('#myModal .modal-body').load(url, function(res, status, xhr) {
            if (status === 'error') {
                \$('#myModal .modal-body').html('<div class=\"alert alert-danger\">Error ' + xhr.status + ': ' + xhr.statusText + '</div>');
            }
        });
    });

    // ========== ผ่าน / ไม่ผ่าน ==========
    \$('#link1').click(function(){
        \$('#model1').show();
        \$('#model2').hide();
    });
    \$('#link2').click(function(){
        \$('#model1').hide();
        \$('#model2').show();
    });

    // ========== ส่งข้อมูล Queue ==========
    \$(document).ready(function() {
        \$('#btnSubmit').on('click', function(e) {
            e.preventDefault();

            var checkedRows = \$('input[name=\"chkDel[]\"]:checked');
            var totalItems = checkedRows.length;

            if (totalItems === 0) {
                alert('กรุณาเลือกรายการที่ต้องการส่งข้อมูลอย่างน้อย 1 รายการ');
                return false;
            }

            \$('#logConsole').html('');
            \$('#progressModal').modal('show');

            var date1 = \$('input[name=\"date1\"]').val();
            var date2 = \$('input[name=\"date2\"]').val();
            var currentIndex = 0;

            function sendNextItem() {
                if (currentIndex < totalItems) {
                    var currentItem = \$(checkedRows[currentIndex]);
                    var value = currentItem.val();

                    var row = currentItem.closest('tr');
                    var hn = row.find('td:nth-child(5)').text().trim();
                    var fullname = row.find('td:nth-child(6)').text().trim();

                    var displayIndex = currentIndex + 1;
                    var percent = Math.round((displayIndex / totalItems) * 100);
                    \$('#progressModal .progress-bar').css('width', percent + '%').text(percent + '%');
                    \$('#progressTitle').html('<i class=\"fas fa-spinner fa-spin\"></i> กำลังส่งข้อมูลลำดับที่ ' + displayIndex + '/' + totalItems);

                    \$.ajax({
                        url: \$('#formMains').attr('action'),
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'chkDel': [value],
                            'date1': date1,
                            'date2': date2,
                            'YII_CSRF_TOKEN': \$('input[name=\"_csrf\"]').val()
                        },
                        success: function(response) {
                            if (response && response.status === 'success') {
                                \$('#logConsole').append('<div style=\"color: #2e7d32;\">' + displayIndex + '. HN: ' + hn + ' (' + fullname + ') -> ส่งสำเร็จ</div>');
                            } else {
                                var reason = (response && response.message) ? ' (' + response.message + ')' : '';
                                \$('#logConsole').append('<div style=\"color: #c62828; background-color: #ffebee; padding: 2px 5px; margin: 2px 0; border-radius:3px;\">' + displayIndex + '. HN: ' + hn + ' (' + fullname + ') -> ส่งไม่สำเร็จ' + reason + '</div>');
                            }
                            \$('#logConsole').scrollTop(\$('#logConsole')[0].scrollHeight);
                            currentIndex++;
                            sendNextItem();
                        },
                        error: function(xhr, status, error) {
                            \$('#logConsole').append('<div style=\"color: #b71c1c; background-color: #ffcdd2; padding: 2px 5px; margin: 2px 0; border-radius:3px;\">' + displayIndex + '. HN: ' + hn + ' (' + fullname + ') -> เกิดข้อผิดพลาดของ Server Error</div>');
                            \$('#logConsole').scrollTop(\$('#logConsole')[0].scrollHeight);
                            currentIndex++;
                            sendNextItem();
                        }
                    });
                } else {
                    \$('#progressTitle').html('<i class=\"fas fa-check-circle\" style=\"color: #0277bd;\"></i> ส่งข้อมูลเสร็จสมบูรณ์เรียบร้อยแล้ว');
                    \$('#progressModal .progress-bar').removeClass('active progress-bar-striped').css('background-color', '#0277bd').text('100% เสร็จสิ้น');
                    \$('#logConsole').append('<div style=\"color: #0277bd; font-weight: bold; margin-top: 5px;\">[ระบบ] กำลังรีเฟรชหน้าต่างรายการภายใน 5 วินาที...</div>');
                    \$('#logConsole').scrollTop(\$('#logConsole')[0].scrollHeight);
                    setTimeout(function() {
                        \$('#progressModal').modal('hide');
                        location.reload();
                    }, 5000);
                }
            }

            sendNextItem();
        });
    });

", View::POS_READY);
?>