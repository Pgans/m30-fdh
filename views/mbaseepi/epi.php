<?php

namespace app\controllers;

use Yii;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\editable\Editable;
use yii\widgets\Pjax;

$this->title = '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dose1</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <style>
        /* ===== CSS VARIABLES ===== */
        :root {
            --primary:       #1a6fb5;
            --primary-light: #e8f2fb;
            --success:       #1e8c5a;
            --success-light: #e6f7ef;
            --danger:        #c0392b;
            --danger-light:  #fdf0ee;
            --warning:       #d68910;
            --warning-light: #fef9ec;
            --info:          #0e7490;
            --info-light:    #e0f5f9;
            --header-bg:     #1e3a5f;
            --header-text:   #ffffff;
            --row-pass:      #eaf7f0;
            --row-alt:       #f8fafc;
            --row-hover:     #edf4ff;
            --border:        #d1dce8;
            --text-main:     #1f2937;
            --text-muted:    #6b7280;
            --font:          'Sarabun', sans-serif;
            --shadow-sm:     0 1px 3px rgba(0,0,0,0.08);
            --shadow-md:     0 4px 12px rgba(0,0,0,0.10);
            --radius:        10px;
        }

        body {
            font-family: var(--font);
            background: #f0f4f9;
            color: var(--text-main);
            font-size: 14px;
        }

        /* ===== PAGE HEADER ===== */
        .page-header-badge {
            display: inline-block;
            background: linear-gradient(135deg, #23faaa 0%, #026e46 100%);
            color: #fff;
            font-size: 20px;
            font-weight: 700;
            padding: 10px 28px;
            border-radius: 8px;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
            box-shadow: var(--shadow-md);
        }

        /* ===== STAT CARDS ===== */
        .stat-card {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            border-left: 5px solid transparent;
            transition: box-shadow .2s;
            margin-bottom: 16px;
        }
        .stat-card:hover { box-shadow: var(--shadow-md); }
        .stat-card.card-pass    { border-left-color: var(--success); }
        .stat-card.card-fail    { border-left-color: var(--danger); }
        .stat-card.card-total   { border-left-color: var(--primary); }

        .stat-card .stat-info   { flex: 1; }
        .stat-card .stat-label  { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .8px; color: var(--text-muted); margin-bottom: 4px; }
        .stat-card .stat-value  { font-size: 28px; font-weight: 700; color: var(--text-main); line-height: 1; }
        .stat-card .stat-icon img { width: 54px; height: 54px; opacity: .85; }

        .stat-card.card-pass  .stat-label { color: var(--success); }
        .stat-card.card-fail  .stat-label { color: var(--danger); }
        .stat-card.card-total .stat-label { color: var(--primary); }

        .stat-actions { display: flex; flex-direction: column; gap: 6px; }

        /* ===== BUTTONS ===== */
        .btn-pass   { background: var(--success); color: #fff; border: none; border-radius: 6px; padding: 6px 14px; font-size: 13px; font-family: var(--font); cursor: pointer; transition: opacity .2s; }
        .btn-fail   { background: var(--danger);  color: #fff; border: none; border-radius: 6px; padding: 6px 14px; font-size: 13px; font-family: var(--font); cursor: pointer; transition: opacity .2s; }
        .btn-info2  { background: var(--primary);  color: #fff; border: none; border-radius: 6px; padding: 6px 14px; font-size: 13px; font-family: var(--font); cursor: pointer; transition: opacity .2s; text-decoration: none; display: inline-block; }
        .btn-del    { background: #c0392b;  color: #fff; border: none; border-radius: 6px; padding: 6px 14px; font-size: 13px; font-family: var(--font); cursor: pointer; transition: opacity .2s; text-decoration: none; display: inline-block; }
        .btn-pass:hover, .btn-fail:hover, .btn-info2:hover, .btn-del:hover { opacity: .85; }

        .btn-submit-main {
            background: linear-gradient(135deg, #038c59 0%, #23faaa 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 32px;
            font-size: 15px;
            font-weight: 600;
            font-family: var(--font);
            cursor: pointer;
            box-shadow: var(--shadow-sm);
            transition: box-shadow .2s, opacity .2s;
            width: 100%;
            margin-bottom: 16px;
        }
        .btn-submit-main:hover { box-shadow: var(--shadow-md); opacity: .92; }

        /* ===== FLASH MESSAGES ===== */
        .alert {
            border-radius: var(--radius);
            padding: 12px 18px;
            font-size: 14px;
            margin-bottom: 12px;
            border: none;
            box-shadow: var(--shadow-sm);
        }
        .alert-success { background: var(--success-light); color: var(--success); border-left: 4px solid var(--success); }
        .alert-danger  { background: var(--danger-light);  color: var(--danger);  border-left: 4px solid var(--danger);  }

        /* ===== SECTION HEADERS ===== */
        .section-header-pass { color: var(--success); border-left: 4px solid var(--success); padding: 6px 12px; background: var(--success-light); border-radius: 6px; font-size: 15px; font-weight: 600; margin-bottom: 10px; }
        .section-header-fail { color: var(--danger);  border-left: 4px solid var(--danger);  padding: 6px 12px; background: var(--danger-light);  border-radius: 6px; font-size: 15px; font-weight: 600; margin-bottom: 10px; }

        /* ===== MAIN DATA TABLE ===== */
        .data-table-wrap {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            overflow-x: auto;
            margin-bottom: 24px;
        }

        table.epi-table {
            width: 1100px;
            border-collapse: collapse;
            font-size: 13px;
        }

        table.epi-table thead tr {
            background: var(--header-bg);
        }
        table.epi-table thead th,
        table.epi-table thead td {
            color: var(--header-text);
            padding: 10px 10px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            border: none;
        }
        table.epi-table thead th:first-child,
        table.epi-table thead td:first-child { border-radius: 10px 0 0 0; }
        table.epi-table thead td:last-child   { border-radius: 0 10px 0 0; }

        table.epi-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .15s;
        }
        table.epi-table tbody tr:nth-child(even)     { background: var(--row-alt); }
        table.epi-table tbody tr:hover               { background: var(--row-hover); }
        table.epi-table tbody tr.row-pass            { background: var(--row-pass); }
        table.epi-table tbody tr.row-pass:hover      { background: #d4f1e4; }

        table.epi-table tbody td {
            padding: 8px 10px;
            color: var(--text-main);
            vertical-align: middle;
        }

        .status-ok   { color: var(--success); font-weight: 700; }
        .status-fail { color: var(--text-muted); }

        /* Checkbox styling */
        input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        /* ===== LOADING SPINNER ===== */
        #loading-spinner {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
            z-index: 9999;
            background: rgba(255,255,255,0.85);
            padding: 40px;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            text-align: center;
        }
        .custom-spinner {
            border: 5px solid #e2eaf4;
            border-top: 5px solid var(--primary);
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 0.8s linear infinite;
            margin: 0 auto 12px;
        }
        .spinner-label { color: var(--primary); font-size: 14px; font-weight: 600; }

        @keyframes spin {
            0%   { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ===== MODAL ===== */
        .modal-content  { border-radius: var(--radius); border: none; box-shadow: var(--shadow-md); }
        .modal-header   { background: var(--header-bg); color: #fff; border-radius: var(--radius) var(--radius) 0 0; padding: 14px 20px; }
        .modal-title    { font-weight: 600; font-size: 16px; }
        .modal-header .close { color: #fff; opacity: .8; }

        /* ===== GridView overrides ===== */
        .table-striped > tbody > tr:nth-of-type(odd) { background: var(--row-alt); }

        /* ===== LAYOUT HELPERS ===== */
        .row { display: flex; flex-wrap: wrap; gap: 16px; margin-bottom: 8px; }
        .col-card { flex: 1; min-width: 280px; }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script language="JavaScript">
        function ClickCheckAll(vol) {
            var i;
            for (i = 0; i < document.frmMain.elements.length; i++) {
                if (document.frmMain.elements[i].name == "chkDel[]") {
                    document.frmMain.elements[i].checked = vol.checked;
                }
            }
        }
    </script>

    <br>

    <!-- ===== PAGE TITLE ===== -->
    <div class="page-header-badge">
        💉 Moph Claim วัคซีนเด็ก EPI
    </div>

    <!-- ===== STAT CARDS ===== -->
    <div class="row">

        <!-- ผ่าน -->
        <div class="col-card">
            <div class="stat-card card-pass">
                <div class="stat-info">
                    <div class="stat-label">✔ ผ่านตามเงื่อนไข</div>
                    <div class="stat-value"><?php echo $amount ?></div>
                </div>
                <div class="stat-actions">
                    <button class="btn-pass" id="link1">แสดงรายการ</button>
                </div>
                <div class="stat-icon">
                    <img src="images/accept.svg" title="ข้อมูลสำเร็จ">
                </div>
            </div>
        </div>

        <!-- ไม่ผ่าน -->
        <div class="col-card">
            <div class="stat-card card-fail">
                <div class="stat-info">
                    <div class="stat-label">✖ ไม่ผ่าน</div>
                    <div class="stat-value"><?php echo $amountx ?></div>
                </div>
                <div class="stat-actions">
                    <button class="btn-fail" id="link2">แสดงรายการ</button>
                </div>
                <div class="stat-icon">
                    <img src="images/accept.svg" title="ข้อมูลไม่ผ่าน">
                </div>
                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">รายการไม่ผ่าน</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- รวมทั้งหมด -->
        <div class="col-card">
            <div class="stat-card card-total">
                <div class="stat-info">
                    <div class="stat-label">📋 รายการส่งผ่านทั้งหมด</div>
                    <div class="stat-value"><?php echo $total ?></div>
                </div>
                <div class="stat-actions">
                    <?= Html::a('<i class="fas fa-sync-alt"></i> Refresh', ['dt/dt'], ['class' => 'btn-info2']) ?>
                    <?= Html::a('<i class="fas fa-trash"></i> Delete Error', ['dt/delete-log'], ['class' => 'btn-del']) ?>
                </div>
                <div class="stat-icon">
                    <img src="images/waitmoph.98529de4.svg" title="ยอดทั้งหมด">
                </div>
            </div>
        </div>

    </div>

    <!-- ===== FLASH MESSAGES ===== -->
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div id="success-message" class="alert alert-success">
            ✔ <?= Yii::$app->session->getFlash('success') ?>
        </div>
        <script>setTimeout(function(){ document.getElementById('success-message').style.display='none'; }, 10000);</script>
    <?php elseif (Yii::$app->session->hasFlash('error')): ?>
        <div id="error-message" class="alert alert-danger">
            ✖ <?= Yii::$app->session->getFlash('error') ?>
        </div>
        <script>setTimeout(function(){ document.getElementById('error-message').style.display='none'; }, 10000);</script>
    <?php endif; ?>

    <!-- ===== SECTION: PASS LIST ===== -->
    <div id="model1" style="display:none; margin-bottom:20px;">
        <div class="section-header-pass">✔ แสดงรายการผ่าน</div>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $passProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'visit_id', 'pid', 'status', 'response', 'd_update',
            ],
            'tableOptions' => ['class' => 'table table-striped table-bordered'],
        ]); ?>
    </div>

    <!-- ===== SECTION: ERROR LIST ===== -->
    <div id="model2" style="display:none; margin-bottom:20px;">
        <div class="section-header-fail">✖ แสดงรายการไม่ผ่าน</div>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $errorProvider,
            'tableOptions' => ['class' => 'table table-striped table-bordered', 'style' => 'font-size:13px;'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'visit_id', 'pid', 'status', 'messagecode', 'response', 'users', 'd_update',
                [
                    'class'    => 'yii\grid\ActionColumn',
                    'header'   => 'Actions',
                    'template' => '{delete}',
                    'buttons'  => [
                        'delete' => function ($url, $model, $key) {
                            return Html::button('<span class="glyphicon glyphicon-trash"></span>', [
                                'class' => 'btn-del',
                                'title' => 'Delete',
                                'data'  => [
                                    'confirm' => "ลบรายการ Visit: $model->visit_id ?",
                                    'method'  => 'post',
                                ],
                            ]);
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>

    <!-- ===== LOADING SPINNER ===== -->
    <div id="loading-spinner" style="display:none;">
        <div class="custom-spinner"></div>
        <div class="spinner-label">กำลังส่งข้อมูล...</div>
    </div>

    <!-- ===== MAIN FORM ===== -->
    <?= Html::beginForm(['mbaseepi/check'], 'post', ['name' => 'frmMain']); ?>

    <input name="btnButton1"
           class="btn-submit-main"
           id="selectAll"
           type="submit"
           value="💉 ส่งข้อมูล Moph-Claim EPI วัคซีนเด็ก">

    <!-- ===== DATA TABLE ===== -->
    <div class="data-table-wrap">
        <table class="epi-table">
            <thead>
                <tr>
                    <th>
                        <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);">
                    </th>
                    <td>#</td>
                    <td>วันที่</td>
                    <td>Visit</td>
                    <td>HN</td>
                    <td>ชื่อ-สกุล</td>
                    <td>ปี</td>
                    <td>เดือน</td>
                    <td>Vaccine</td>
                    <td>Lot Number</td>
                    <td>รหัส</td>
                    <td>เข็มที่</td>
                    <td>แผนก</td>
                    <td>สิทธิ์</td>
                    <td>รหัส</td>
                    <td>Authen Code</td>
                    <td>สถานะ</td>
                    <td>Response</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($epiProvider->getModels() as $key => $value):
                    $isPass = ($value["status"] == 200);
                ?>
                <tr class="<?= $isPass ? 'row-pass' : '' ?>">
                    <td>
                        <input type="checkbox" name="chkDel[]" checked id="chkDel<?= $i; ?>"
                               value="<?php echo $value["visit_id"] . $value["hn"]; ?>">
                    </td>
                    <td><?php echo $value["No"]; ?></td>
                    <td class="text-nowrap"><?php echo $value["regdate"]; ?></td>
                    <td><?php echo $value["visit_id"]; ?></td>
                    <td><?php echo $value["hn"]; ?></td>
                    <td class="text-nowrap"><?php echo $value["fullname"]; ?></td>
                    <td><?php echo $value["age_year"]; ?></td>
                    <td><?php echo $value["age_month"]; ?></td>
                    <td class="text-nowrap"><?php echo $value["drug_name"]; ?></td>
                    <td class="text-nowrap"><?php echo $value["lot_number"]; ?></td>
                    <td class="text-nowrap"><?php echo $value["drug_id"]; ?></td>
                    <td><?php echo $value["dose_time"]; ?></td>
                    <td class="text-nowrap"><?php echo $value["unit_name"]; ?></td>
                    <td class="text-nowrap"><?php echo $value["inscl_name"]; ?></td>
                    <td><?php echo $value["hospmain"]; ?></td>
                    <td><?php echo $value["claimcode"]; ?></td>
                    <td class="<?= $isPass ? 'status-ok' : 'status-fail' ?>">
                        <?= $value["status"]; ?>
                    </td>
                    <td class="text-nowrap"><?php echo $value["response"]; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?= Html::endForm() ?>

    <!-- ===== SCRIPTS ===== -->
    <?php
    $this->registerJs("
        $('#link1').click(function(){ $('#model1').show(); $('#model2').hide(); });
        $('#link2').click(function(){ $('#model1').hide(); $('#model2').show(); });
    ");
    $this->registerJs('
        jQuery(\"#btn-delete\").click(function(){
            var keys = $(\"#w0\").yiiGridView(\"getSelectedRows\");
            if(keys.length>0){
                jQuery.post(\"' . Url::to(['delete-all']) . '\",{ids:keys},function(){});
            }
        });
    ');
    ?>

    <script>
        $(document).ready(function () {

            // Popup modal via AJAX
            $('.popup-link').click(function (e) {
                e.preventDefault();
                openModalWithData($(this).data('url'));
            });

            // Show spinner on submit click
            $('#selectAll').click(function () {
                $('#loading-spinner').show();
            });
            $(document).on('beforeSubmit', 'form[name="frmMain"]', function () {
                $('#loading-spinner').show();
                return true;
            });
            $(document).on('pjax:success', function () { $('#loading-spinner').hide(); });
            $(document).ajaxStop(function () { $('#loading-spinner').hide(); });
        });

        function openModalWithData(url) {
            $.ajax({
                url: url, method: 'GET',
                success: function (response) {
                    $('#myModal .modal-body').html(response);
                    $('#myModal').modal('show');
                },
                error: function () { alert('เกิดข้อผิดพลาดในการโหลดข้อมูล'); }
            });
        }

        // Row-by-row visual processing before form submit
        document.querySelector('form[name="frmMain"]').addEventListener('submit', function (event) {
            var checkedRows = document.querySelectorAll('input[name="chkDel[]"]:checked');
            var count = checkedRows.length;

            if (count > 0) {
                var currentIndex = 0;
                function processRow() {
                    if (currentIndex < count) {
                        var row = checkedRows[currentIndex].closest('tr');
                        var orig = row.style.backgroundColor;
                        row.style.backgroundColor = '#fde68a';
                        row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        setTimeout(function () {
                            row.style.backgroundColor = orig;
                            currentIndex++;
                            processRow();
                        }, 800);
                    } else {
                        document.frmMain.submit();
                    }
                }
                processRow();
            } else {
                alert('กรุณาเลือกรายการก่อนส่งข้อมูล');
            }
            event.preventDefault();
        });
    </script>

</body>
</html>