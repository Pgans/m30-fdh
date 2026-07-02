<?php

namespace app\controllers;

use Yii;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\editable\Editable;
use yii\widgets\Pjax;

$this->title = 'HPV';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HPV</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

<style>
    /* ===== CSS VARIABLES — Green Theme ===== */
    :root {
        --primary:        #1a7f4b;
        --primary-dark:   #145f38;
        --primary-light:  #e6f7ee;
        --primary-mid:    #a8dfc0;

        --success:        #1a7f4b;
        --success-light:  #e6f7ee;
        --warning:        #b45309;
        --warning-light:  #fef3e2;
        --danger:         #b91c1c;
        --danger-light:   #fde8e8;

        --header-bg:      #145f38;
        --header-text:    #ffffff;

        --row-pass:       #edfaf2;
        --row-alt:        #f5fdf8;
        --row-hover:      #d4f5e4;
        --border:         #c3e6d4;

        --text-main:      #1a2e1f;
        --text-muted:     #5a7a65;

        --font:           'Sarabun', sans-serif;
        --shadow-sm:      0 1px 4px rgba(0,0,0,0.07);
        --shadow-md:      0 4px 14px rgba(0,0,0,0.10);
        --radius:         10px;
    }

    body {
        font-family: var(--font);
        background: #f0f7f3;
        color: var(--text-main);
        font-size: 14px;
    }

    /* ===== PAGE TITLE ===== */
    .page-header-badge {
        display: inline-block;
        background: linear-gradient(135deg, var(--primary-dark) 0%, #2ecc71 100%);
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
    .cards-row {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 20px;
    }
    .col-card { flex: 1; min-width: 260px; }

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
    }
    .stat-card:hover { box-shadow: var(--shadow-md); }
    .stat-card.card-pass  { border-left-color: var(--primary); }
    .stat-card.card-fail  { border-left-color: var(--warning); }
    .stat-card.card-total { border-left-color: #2ecc71; }

    .stat-info  { flex: 1; }
    .stat-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .8px;
        color: var(--text-muted);
        margin-bottom: 6px;
    }
    .stat-card.card-pass  .stat-label { color: var(--primary); }
    .stat-card.card-fail  .stat-label { color: var(--warning); }
    .stat-card.card-total .stat-label { color: #1a9e54; }

    .stat-value { font-size: 30px; font-weight: 700; color: var(--text-main); line-height: 1; }
    .stat-icon img { width: 54px; height: 54px; opacity: .85; }

    /* ===== BUTTONS ===== */
    .btn-submit-main {
        background: linear-gradient(135deg, var(--primary-dark) 0%, #27ae60 100%);
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
        margin-bottom: 14px;
        display: block;
    }
    .btn-submit-main:hover { box-shadow: var(--shadow-md); opacity: .92; }

    /* ===== LOADING SPINNER ===== */
    #loading-spinner {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
        z-index: 9999;
        background: rgba(255,255,255,0.88);
        padding: 40px;
        border-radius: 16px;
        box-shadow: var(--shadow-md);
        text-align: center;
    }
    .custom-spinner {
        border: 5px solid #c8efd8;
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

    /* ===== DATA TABLE ===== */
    .data-table-wrap {
        background: #fff;
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        overflow-x: auto;
        margin-bottom: 24px;
    }

    table.hpv-table {
        width: 1100px;
        border-collapse: collapse;
        font-size: 13px;
    }

    table.hpv-table thead tr {
        background: var(--header-bg);
    }
    table.hpv-table thead th,
    table.hpv-table thead td {
        color: var(--header-text);
        padding: 11px 12px;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
        border: none;
    }
    table.hpv-table thead th:first-child { border-radius: 10px 0 0 0; }
    table.hpv-table thead td:last-child   { border-radius: 0 10px 0 0; }

    table.hpv-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .12s;
    }
    table.hpv-table tbody tr:nth-child(even) { background: var(--row-alt); }
    table.hpv-table tbody tr:hover           { background: var(--row-hover); }

    table.hpv-table tbody td {
        padding: 8px 12px;
        color: var(--text-main);
        vertical-align: middle;
    }

    .badge-no {
        background: var(--primary-light);
        color: var(--primary-dark);
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 12px;
    }

    /* Checkbox */
    input[type="checkbox"] {
        width: 15px;
        height: 15px;
        accent-color: var(--primary);
        cursor: pointer;
    }

    /* ===== MODAL ===== */
    .modal-content  { border-radius: var(--radius); border: none; box-shadow: var(--shadow-md); }
    .modal-header   { background: var(--header-bg); color: #fff; border-radius: var(--radius) var(--radius) 0 0; padding: 14px 20px; }
    .modal-title    { font-weight: 600; font-size: 16px; }
    .modal-header .close { color: #fff; opacity: .8; }

    /* ===== LINK BUTTON IN CARD ===== */
    .link-card-btn {
        display: inline-block;
        background: var(--primary-light);
        color: var(--primary-dark);
        font-size: 12px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
        text-decoration: none;
        transition: background .15s;
        margin-top: 6px;
    }
    .link-card-btn:hover { background: var(--primary-mid); color: var(--primary-dark); text-decoration: none; }
    .link-card-btn.warn  { background: var(--warning-light); color: var(--warning); }
    .link-card-btn.warn:hover { background: #fddcae; }
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
    🌿 Moph Claim วัคซีน HPV
</div>

<!-- ===== STAT CARDS ===== -->
<div class="cards-row">

    <!-- ผ่านตามเงื่อนไข -->
    <div class="col-card">
        <div class="stat-card card-pass">
            <div class="stat-info">
                <div class="stat-label">✔ ผ่านตามเงื่อนไขวันนี้</div>
                <div class="stat-value"><?php echo $amount ?></div>
                <a href="<?= \yii\helpers\Url::to(['/hpv/loghpv']) ?>" target="_blank" class="link-card-btn">ดูรายการ →</a>
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
                <div class="stat-label">✖ ไม่ผ่านตามเงื่อนไข</div>
                <div class="stat-value"><?php echo $amountx ?></div>
                <a href="#" class="link-card-btn warn popup-link" data-url="<?= yii\helpers\Url::to(['/hpv/logerr']) ?>">ดูรายการ →</a>
            </div>
            <div class="stat-icon">
                <img src="images/accept.svg" title="ข้อมูลไม่ผ่าน">
            </div>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">รายการไม่ผ่านเงื่อนไข</h5>
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
            <div class="stat-icon">
                <img src="images/waitmoph.98529de4.svg" title="ยอดทั้งหมด">
            </div>
        </div>
    </div>

</div>

<!-- ===== LOADING SPINNER ===== -->
<div id="loading-spinner" style="display:none;">
    <div class="custom-spinner"></div>
    <div class="spinner-label">กำลังส่งข้อมูล...</div>
</div>

<!-- ===== MAIN FORM ===== -->
<?= Html::beginForm(['hpv/check'], 'post', ['name' => 'frmMain']); ?>

<button name="btnButton1" class="btn-submit-main" id="checkAll" type="submit">
    🌿 ส่งข้อมูล Moph-Claim HPV
</button>

<!-- ===== DATA TABLE ===== -->
<div class="data-table-wrap">
    <table class="hpv-table">
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
                <td>อายุ</td>
                <td>เข็มที่</td>
                <td>Lot</td>
                <td>รหัสยา</td>
                <td>ชื่อยา</td>
                <td>Authen Code</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($hpvProvider->getModels() as $key => $value): ?>
            <tr>
                <td>
                    <input type="checkbox" name="chkDel[]" checked id="chkDel<?= $i; ?>"
                           value="<?php echo $value["visit_id"] . $value["hn"]; ?>">
                </td>
                <td><span class="badge-no"><?php echo $value["No"]; ?></span></td>
                <td class="text-nowrap"><?php echo $value["regdate"]; ?></td>
                <td><?php echo $value["visit_id"]; ?></td>
                <td><?php echo $value["hn"]; ?></td>
                <td class="text-nowrap"><?php echo $value["fullname"]; ?></td>
                <td><?php echo $value["age"]; ?></td>
                <td><?php echo $value["dose_time"]; ?></td>
                <td><?php echo $value["lot_no"]; ?></td>
                <td><?php echo $value["drug_id"]; ?></td>
                <td class="text-nowrap"><?php echo $value["drug_name"]; ?></td>
                <td class="text-nowrap"><?php echo $value["claimcode"]; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= Html::endForm() ?>

<!-- ===== SCRIPTS ===== -->
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

<script>
    $(document).ready(function () {

        // Popup modal
        $('.popup-link').click(function (e) {
            e.preventDefault();
            openModalWithData($(this).data('url'));
        });

        // Show spinner on submit
        $('#checkAll').click(function () {
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
            url: url,
            method: 'GET',
            success: function (response) {
                $('#myModal .modal-body').html(response);
                $('#myModal').modal('show');
            },
            error: function () {
                alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
            }
        });
    }
</script>

</body>
</html>