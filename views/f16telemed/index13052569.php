<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\web\View;
use yii\data\ActiveDataProvider;
use yii\bootstrap\Modal;
use dosamigos\datepicker\DatePicker;

$this->title = 'FDH-TELEMED';
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@iconify/iconify@latest/dist/iconify.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<style>
    /* --- 1. Global Reset & Typography --- */
    /* ❌ ลบ transition: all บน * ออกทั้งหมด — ตัวการที่ทำให้ทุกอย่างขยับ */
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 20px;
        font-family: 'Sarabun', 'Segoe UI', Tahoma, sans-serif;
        background-color: #f0f2f5;
        color: #333;
        /* ❌ ลบ overflow-y: scroll และ scrollbar-width: none ออก */
        /* เพราะซ่อน scrollbar แบบ incomplete ทำให้ layout กระตุก */
    }

    /* --- 2. Info Cards --- */
    .info-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        min-height: 140px;
        position: relative;
        overflow: hidden;
        /* ❌ ไม่ใส่ transition ที่นี่ */
    }

    .bg-passed { border-left: 5px solid #28a745; }
    .bg-failed { border-left: 5px solid #dc3545; }
    .bg-link   { border-left: 5px solid #17a2b8; }
    .bg-search { border-left: 5px solid #6c757d; }

    .info-box-text {
        font-weight: bold;
        font-size: 1.1rem;
        display: block;
        margin-bottom: 5px;
    }

    .info-box-number {
        font-size: 1.8rem;
        font-weight: 800;
        color: #2c3e50;
    }

    /* --- 3. Table Container --- */
    .table-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-top: 20px;
    }

    /* Table wrapper: scroll เฉพาะตรงนี้ ไม่กระทบ layout อื่น */
    .table-wrapper {
        height: 600px;
        overflow-y: auto;
        overflow-x: hidden;
        position: relative;
    }

    .my-striped-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        table-layout: auto;
    }

    /* Header ติดด้านบนเมื่อ scroll */
    .my-striped-table thead th {
        position: sticky;
        top: 0;
        z-index: 100;
        background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%) !important;
        color: #ffffff;
        font-weight: 500;
        padding: 15px 10px;
        text-align: center;
        border: none;
        font-size: 14px;
    }

    /* แถว: เปลี่ยนสีเฉยๆ ไม่มี transform ไม่มี transition */
    .my-striped-table tbody tr:nth-child(even) {
        background-color: #fafafa;
    }
    /* ❌ ลบ hover ออกทั้งหมด — ไม่มีการเปลี่ยนแปลงใดๆ เมื่อเลื่อนเมาส์ผ่านแถว */

    .my-striped-table td {
        padding: 12px 10px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
        vertical-align: middle;
    }

    /* --- 4. Buttons (ไม่มี transition) --- */
    .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 8px 16px;
        border: none;
        cursor: pointer;
        /* ❌ ไม่ใส่ transition */
    }

    .btn-success { background-color: #28a745; color: white; }
    .btn-primary { background-color: #007bff; color: white; }
    .btn-danger  { background-color: #dc3545; color: white; }

    /* ปุ่มลอย */
    .floating-button button {
        background: linear-gradient(45deg, #1d976c, #93f9b9) !important;
        border: none !important;
        box-shadow: 0 10px 20px rgba(29, 151, 108, 0.3) !important;
        color: white !important;
        font-weight: bold;
        /* ❌ ไม่ใส่ transition */
    }

    /* --- 5. Loading Spinner --- */
    #loading-spinner {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        padding: 40px;
        z-index: 9999;
    }

    .custom-spinner {
        border: 8px solid #f3f3f3;
        border-top: 8px solid #3498db;
        border-radius: 50%;
        width: 80px;
        height: 80px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0%   { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Sticky header สำหรับตารางหลัก */
    .table-header, th {
        position: sticky;
        top: 0;
        background-color: lightgray;
        z-index: 10;
    }
</style>

<!-- ############################# Select All ################################################################### -->
<script>
    function ClickCheckAll(vol) {
        var elements = document.frmMain.elements;
        for (var i = 0; i < elements.length; i++) {
            if (elements[i].name === "chkDel[]") {
                elements[i].checked = vol.checked;
            }
        }
    }
</script>

<h4><a>เงื่อนไข:: </a> สิทธิ์บัตรทอง ('03', '04', '33', '00', '23') แผนก ('63', '68', '70', '71')</h4>

<div class="row">
    <!-- Card 1: ผ่านวันนี้ -->
    <div class="col-xl-3 col-md-3 mb-3">
        <div class="info-card bg-info" style="box-shadow: 5px 5px 10px rgba(0,0,0,0.3);">
            <span class="info-box-icon"><i class="far fa-calendar-check" style="color: green;"></i></span>
            <div class="info-box-content">
                <span class="info-box-text" style="color: green; font-size: 18px;">รายการผ่านวันนี้</span>
                <span class="info-box-number"><?php echo $amount ?></span>
            </div>

            <?php
            Modal::begin([
                'id' => 'myModal',
                'header' => '<h4>File List</h4>',
                'size' => Modal::SIZE_LARGE,
            ]);
            ?>
            <div id="modal-content">Loading...</div>
            <?php Modal::end(); ?>
            <?php
            $this->registerJs("
                $('#myModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var url = button.data('url');
                    var modal = $(this);
                    $.ajax({
                        url: url,
                        success: function(data) {
                            modal.find('#modal-content').html(data);
                        }
                    });
                });
            ");
            ?>
            <div style="text-align: right;">
                <?php
                echo Html::a('เปิดอ่านไฟล์', '#', [
                    'class' => 'btn btn-primary',
                    'data-toggle' => 'modal',
                    'data-target' => '#myModal',
                    'data-url' => \yii\helpers\Url::to(['f16erext/list-files-partial']),
                ]);
                ?>
                <?= Html::a('<i class="fa fa-check-square" aria-hidden="true"></i> ผ่าน', null, ['class' => 'btn btn-success', 'id' => 'link1']) ?>
            </div>
        </div>
    </div>

    <!-- Card 2: ส่งไม่ผ่าน -->
    <div class="col-xl-3 col-md-3 mb-3">
        <div class="info-card bg-info" style="box-shadow: 5px 5px 10px rgba(0,0,0,0.3);">
            <span class="info-box-icon"><i class="fa-sharp fa-solid fa-compass" style="color: red;"></i></span>
            <div class="info-box-content">
                <span class="info-box-text" style="color: red; font-size: 18px;">รายการส่งไม่ผ่าน</span>
                <span class="info-box-number"><?php echo $amountx ?></span>
            </div>
            <div style="text-align: right;">
                <a href="<?= Url::to(['f16telemed/run-curl', 'date1' => $date1, 'date2' => $date2]) ?>"
                   class="btn btn-info"
                   style="font-size: 16px; border-radius: 25px;">
                    RunToken <i class="fa fa-arrow-circle-right"></i>
                </a>
                <?= Html::a('<i class="fa fa-ban" aria-hidden="true"></i> ไม่ผ่าน', null, ['class' => 'btn btn-danger', 'id' => 'link2']) ?>
            </div>
        </div>
    </div>

    <!-- Card 3: ลิงค์ -->
    <div class="col-xl-3 col-md-3 mb-3">
        <div class="info-card bg-info" style="box-shadow: 5px 5px 10px rgba(0,0,0,0.3);">
            <span class="info-box-icon"><i class="fas fa-hand-holding-heart" style="color: orange;"></i></span>
            <div class="info-box-content">
                <a href="https://uat-fdh.inet.co.th/hospital/detail" target="_blank">FDH-UAT</a><br>
                <a href="https://fdh.moph.go.th/hospital/" target="_blank">FDH-Production</a><br>
                <a href="<?= \yii\helpers\Url::to(['fdhtelemed/index']) ?>" class="btn btn-warning" style="font-size: 16px;" target="_blank">
                    Query <i class="fa fa-arrow-circle-right"></i>
                </a>
                <?= Html::a('Export', ['f16telemed/exports'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <!-- Card 4: ค้นหาวันที่ -->
    <div class="col-xl-3 col-md-3 mb-3">
        <div class="info-card bg-info" style="box-shadow: 5px 5px 10px rgba(0,0,0,0.3);">
            <?= Html::beginForm(['index'], 'get') ?>

            <div style="margin-bottom: 6px;">
                <?= DatePicker::widget([
                    'name' => 'date1',
                    'value' => $date1,
                    'language' => 'th',
                    'clientOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd', 'todayHighlight' => true],
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'เริ่ม',
                        'style' => 'width:100%; font-size:13px; padding:6px 10px; background-color:#e0ffff; border:2px solid #b0e0e6; border-radius:10px; color:#333;',
                    ],
                ]) ?>
            </div>

            <div style="margin-bottom: 8px;">
                <?= DatePicker::widget([
                    'name' => 'date2',
                    'value' => $date2,
                    'language' => 'th',
                    'clientOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd', 'todayHighlight' => true],
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'สิ้นสุด',
                        'style' => 'width:100%; font-size:13px; padding:6px 10px; background-color:#e0ffff; border:2px solid #b0e0e6; border-radius:10px; color:#333;',
                    ],
                ]) ?>
            </div>

            <?= Html::submitButton('🔍 ค้นหา', [
                'class' => 'btn btn-outline-dark',
                'style' => 'width:100%; font-size:13px; font-weight:bold; padding:6px 10px; border-radius:10px; background-color:#ffffffcc;'
            ]) ?>

            <?= Html::endForm() ?>
        </div>
    </div>
</div>


<!-- ############################################ Grid View ######################################################################## -->
<div class="page-container">

    <div style="height: 700px; overflow-y: auto; overflow-x: hidden;">

        <div id="loading-spinner">
            <div class="custom-spinner"></div>
        </div>

        <?= Html::beginForm(['f16telemed/data'], 'post', ['name' => 'frmMain']); ?>

        <!-- ปุ่มลอย -->
        <div class="floating-button" style="position: fixed; bottom: calc(3 * 2rem); left: 55%; transform: translateX(-45%); z-index: 1000;">
            <button type="submit"
                    name="btnButton1"
                    id="selectAll"
                    class="btn btn-success"
                    style="background-color: #00a400; border: 4px solid #dadada; padding: 10px 20px; border-radius: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); font-size: 1.5rem; cursor: pointer; width: auto;">
                <i class="fa fa-arrow-circle-right" style="margin-right: 10px;"></i>
                ส่งข้อมูล TELEMED
            </button>
        </div>

        <!-- Draggable button script -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const floatingButton = document.querySelector(".floating-button");
                let isDragging = false;
                let offsetX = 0;
                let offsetY = 0;

                floatingButton.addEventListener("mousedown", (e) => {
                    isDragging = true;
                    offsetX = e.clientX - floatingButton.getBoundingClientRect().left;
                    offsetY = e.clientY - floatingButton.getBoundingClientRect().top;
                });
                document.addEventListener("mousemove", (e) => {
                    if (!isDragging) return;
                    floatingButton.style.left = (e.clientX - offsetX) + "px";
                    floatingButton.style.top  = (e.clientY - offsetY) + "px";
                });
                document.addEventListener("mouseup", () => {
                    isDragging = false;
                });
            });
        </script>

        <!-- ตารางข้อมูล -->
        <table class="table my-striped-table" border="1" bordercolor="#ddd" style="border-collapse: collapse; width: 100%;">
            <thead style="position: sticky; top: 0; z-index: 10; background-color: #00d6e1; color: #FFFFFF;">
                <tr>
                    <td style="background-color: #00d6e1; color: #FFFFFF; text-align: center; white-space: nowrap;">
                        <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);">
                    </td>
                    <td style="background-color: #00d6e1; color: #FFFFFF; text-align: center; white-space: nowrap;">#</td>
                    <td style="background-color: #00d6e1; color: #FFFFFF; text-align: center; font-size: 14px; white-space: nowrap;">วันที่</td>
                    <td style="background-color: #00d6e1; color: #FFFFFF; text-align: center; font-size: 14px; white-space: nowrap;">เลขบริการ</td>
                    <td style="background-color: #00d6e1; color: #FFFFFF; text-align: left;   font-size: 14px; white-space: nowrap;">Hn</td>
                    <td style="background-color: #00d6e1; color: #FFFFFF; text-align: left;   font-size: 14px; white-space: nowrap;">ชื่อ-สกุล</td>
                    <td style="background-color: #00d6e1; color: #FFFFFF; text-align: left;   font-size: 14px; white-space: nowrap;">อายุ</td>
                    <td style="background-color: #00d6e1; color: #FFFFFF; text-align: left;   font-size: 14px; white-space: nowrap;">แผนก</td>
                    <td style="background-color: #00d6e1; color: #FFFFFF; text-align: left;   font-size: 14px; white-space: nowrap;">โรคหลัก</td>
                    <td style="background-color: #00d6e1; color: #FFFFFF; text-align: left;   font-size: 14px; white-space: nowrap;">รหัสโรค</td>
                    <td style="background-color: #00d6e1; color: #FFFFFF; text-align: left;   font-size: 14px; white-space: nowrap;">สิทธิ์</td>
                    <td style="background-color: #00d6e1; color: #FFFFFF; text-align: left;   font-size: 14px; white-space: nowrap;">สถานะ</td>
                    <td style="background-color: #00d6e1; color: #FFFFFF; text-align: left;   font-size: 14px; white-space: nowrap;">สถานหลัก</td>
                    <td style="background-color: #00d6e1; color: #FFFFFF; text-align: left;   font-size: 14px; white-space: nowrap;">authen</td>
                    <td style="background-color: #00d6e1; color: #FFFFFF; text-align: left;   font-size: 14px; white-space: nowrap;">ปิดสิทธิ์</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataProvider->getModels() as $key => $value) :
                    $isPassed = !empty($value['messagecode']);
                    $rowBg    = $isPassed ? '#f0fff4' : '#fff5f5';
                    $rowBorder= $isPassed ? '#b2dfdb' : '#ffcdd2';
                ?>
                    <tr style="background-color: <?= $rowBg ?>; border-left: 4px solid <?= $rowBorder ?>;">
                        <td style="text-align:center; padding:8px;">
                            <input type="checkbox" name="chkDel[]" id="chkDel<?= $key; ?>"
                                   value="<?= $value['visit_id'] . $value['hn'] ?>"
                                   style="width:16px; height:16px;">
                        </td>
                        <td style="text-align:center; font-size:13px; color:#888; padding:8px;">
                            <?= $value['No'] ?>
                        </td>
                        <td class="text-nowrap" style="font-size:13px; padding:8px; color:#555;">
                            <?= $value['regdate'] ?>
                        </td>
                        <td style="font-size:13px; padding:8px; font-weight:600; color:#2c3e50;">
                            <?= $value['visit_id'] ?>
                        </td>
                        <td style="font-size:13px; padding:8px; color:#34495e;">
                            <?= $value['hn'] ?>
                        </td>
                        <td class="text-nowrap" style="font-size:13px; padding:8px; font-weight:600; color:#1a1a2e;">
                            <?= $value['fullname'] ?>
                        </td>
                        <td style="font-size:13px; padding:8px; text-align:center; color:#555;">
                            <?= $value['age'] ?>
                        </td>
                        <td class="text-nowrap" style="font-size:13px; padding:8px;">
                            <span style="background:#e3f2fd; color:#1565c0; padding:2px 8px; border-radius:12px; font-size:12px;">
                                <?= $value['unit_name'] ?>
                            </span>
                        </td>
                        <td class="text-nowrap" style="font-size:12px; padding:8px; color:#6a1b9a; font-weight:600;">
                            <?= $value['Diagx'] ?>
                        </td>
                        <td class="text-nowrap" style="font-size:12px; padding:8px;">
                            <span style="background:#f3e5f5; color:#7b1fa2; padding:2px 7px; border-radius:10px;">
                                <?= $value['Diag'] ?>
                            </span>
                        </td>
                        <td class="text-nowrap" style="font-size:12px; padding:8px; color:#37474f;">
                            <?= $value['inscl'] ?>
                        </td>
                        <td class="text-nowrap" style="font-size:13px; padding:8px; text-align:center;">
                            <?php if ($isPassed): ?>
                                <span style="background:#e8f5e9; color:#2e7d32; border:1px solid #a5d6a7; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600;">
                                    ✓ <?= $value['messagecode'] ?>
                                </span>
                            <?php else: ?>
                                <span style="background:#ffebee; color:#c62828; border:1px solid #ef9a9a; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600;">
                                    ✗ รอส่ง
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="text-nowrap" style="font-size:12px; padding:8px; color:#546e7a;">
                            <?= $value['hospmain'] ?>
                        </td>
                        <td class="text-nowrap" style="font-size:12px; padding:8px;">
                            <span style="color:#00695c; font-weight:600;">
                                <?= $value['claimcode'] ?>
                            </span>
                        </td>
                        <td class="text-nowrap" style="font-size:12px; padding:8px;">
                            <span style="color:#e65100; font-weight:600;">
                                <?= $value['endpoint'] ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Form submit handler -->
        <script>
            document.querySelector('form[name="frmMain"]').addEventListener('submit', function(event) {
                var checkedRows = document.querySelectorAll('input[name="chkDel[]"]:checked');
                var count = checkedRows.length;

                if (count > 0) {
                    var currentIndex = 0;
                    function processRow() {
                        if (currentIndex < count) {
                            var row = checkedRows[currentIndex].closest('tr');
                            var originalBg = row.style.backgroundColor;
                            row.style.backgroundColor = '#F8B6F6';
                            row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            setTimeout(function() {
                                row.style.backgroundColor = originalBg;
                                currentIndex++;
                                processRow();
                            }, 1000);
                        } else {
                            document.frmMain.submit();
                        }
                    }
                    processRow();
                } else {
                    alert('Please select rows to process.');
                }
                event.preventDefault();
            });
        </script>

        <!-- Auto-hide alerts -->
        <script>
            setTimeout(function() {
                $('.alert').slideUp('slow');
            }, 15000);
        </script>

        <?php
        $this->registerJs('
            jQuery("#btn-delete").click(function(){
                var keys = $("#w0").yiiGridView("getSelectedRows");
                if(keys.length > 0){
                    jQuery.post("' . Url::to(['delete-all']) . '", {ids: keys}, function(){});
                }
            });
        ');
        ?>

        <!-- ตาราง PASS -->
        <div id="model1" style="display: none;">
            <h2 style="color: #155724; border: 2px solid #c3e6cb; padding: 5px;">แสดงรายการผ่าน</h2>
            <div class="table-wrapper">
                <?= \yii\grid\GridView::widget([
                    'dataProvider' => $passProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'visit_id', 'pid', 'users', 'response', 'd_update',
                    ],
                    'tableOptions' => [
                        'class' => 'table table-striped table-hover',
                        'style' => 'width: 100%;',
                    ],
                    'headerRowOptions' => ['style' => 'background-color: lightgray;'],
                    'rowOptions' => ['style' => 'background-color: #e4e4e4;'],
                ]); ?>
            </div>
        </div>

        <!-- ตาราง ERROR -->
        <div id="model2" style="display: none;">
            <h2 style="color: #ff0000; border: 2px solid #c3e6cb; padding: 5px;">แสดงรายการไม่ผ่าน</h2>
            <?= \yii\grid\GridView::widget([
                'dataProvider' => $errorProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'visit_id', 'pid', 'users', 'response', 'd_update',
                ],
                'tableOptions' => [
                    'class' => 'table table-striped',
                    'style' => 'border: 1px solid #dee2e6; border-radius: 10px;',
                ],
                'headerRowOptions' => ['style' => 'background-color: #ff5eae;'],
            ]); ?>
        </div>

        <?= Html::endForm() ?>
    </div>
</div>

<!-- Toggle ผ่าน/ไม่ผ่าน -->
<?php
$this->registerJs("
    $('#link1').click(function(){
        $('#model1').show();
        $('#model2').hide();
    });
    $('#link2').click(function(){
        $('#model1').hide();
        $('#model2').show();
    });
");
?>

<!-- Loading spinner control -->
<script>
    $(document).ready(function() {
        $('#selectAll').click(function() {
            $('#loading-spinner').show();
        });
        $(document).on('beforeSubmit', 'form[name="frmMain"]', function() {
            $('#loading-spinner').show();
            return true;
        });
        $(document).on('pjax:success', function() {
            $('#loading-spinner').hide();
        });
        $(document).ajaxStop(function() {
            $('#loading-spinner').hide();
        });
    });
</script>