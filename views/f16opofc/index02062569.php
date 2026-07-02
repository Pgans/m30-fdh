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

$this->title = 'FDH-OPD_สิทธิ์ข้าราชการ';

// ลงทะเบียน CSS ทั้งหมดไว้ที่ส่วนหัวของ Page
$this->registerCss('
    .log-line {
        padding: 5px;
    }
    /* กำหนดสีให้กับแถวที่เป็นเลขคี่/คู่ */
    .my-striped-table tr:nth-child(odd) {
        background-color: #efefef;
    }
    .my-striped-table tr:nth-child(even) {
        background-color: white;
    }
    /* Hover Effect เปลี่ยนเป็นสีเขียวอ่อนโปร่งแสงตามดีไซน์ภาพ */
    .my-striped-table tbody tr:hover {
        background-color: rgba(144, 238, 144, 0.5) !important;
    }
    .custom-hover tbody tr:hover {
        background-color: #f5f5f5;
    }
    .btn-blink {
        animation: none;
    }
    /* สไตล์กลุ่มปุ่มเมนูด้านบน */
    .btn-group-modern {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin-top: 10px;
        margin-bottom: 20px;
    }
    .btn-modern {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
        text-decoration: none;
        color: white !important;
        transition: all 0.3s ease-in-out;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }
    .btn-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.3);
    }
    .btn-cidhn, .btn-opd, .btn-refers {
        background: linear-gradient(135deg, #18abab, #35e8d7);
    }
    .btn-ipd {
        background: linear-gradient(135deg, #ff512f, #dd2476);
    }
    /* ปุ่มส่งข้อมูลลอย (Floating Button) */
    .floating-button {
        position: fixed;
        bottom: 50px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
    }
    .floating-button button {
        background-color: #e88635;
        border: 4px solid #dadada;
        font-size: 20px;
        color: white;
        padding: 12px 30px;
        cursor: pointer;
        border-radius: 30px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease-in-out;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .floating-button button:hover {
        background-color: #d17128;
        transform: scale(1.05);
    }
    .floating-button button i {
        margin-right: 10px;
        font-size: 24px;
    }
    /* การจัดการแผงควบคุมและรายละเอียดอื่นๆ */
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
        background: linear-gradient(45deg, #a8e6cf, #e0ffff);
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);
        color: #000;
        padding: 20px;
        border-radius: 10px;
        font-size: 16px;
        margin-bottom: 20px;
    }
    #loading-spinner {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
        z-index: 9999;
    }

    /* ==========================================
       CSS สำหรับการจัดหน้าเอกสารตอนพิมพ์รายงาน
       ========================================== */
    @media print {
        /* ซ่อนรูปภาพ โลโก้ และปุ่มควบคุมต่างๆ */
        img, .btn, button, .floating-button, .container-fluid, #myModal, .modal {
            display: none !important;
        }
        
        /* ซ่อนส่วนของการ์ดหัวเรื่องด้านบน หรือปรับให้เป็นตัวหนังสือธรรมดา */
        .info-card {
            background: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin-bottom: 15px !important;
        }
        .info-card .text-right {
            display: none !important;
        }

        /* เอา Scrollbar ออกเพื่อให้ตารางแสดงได้ครบถ้วนทุกแถวลงมาด้านล่าง */
        div[style*="overflow-y: auto"] {
            height: auto !important;
            overflow: visible !important;
            border: none !important;
            box-shadow: none !important;
        }

        /* ปรับตารางและฟอนต์ให้บาง สะอาดตา พอดีหน้ากระดาษ */
        table.my-striped-table {
            width: 100% !important;
            border-collapse: collapse !important;
            font-size: 13px !important;
        }
        table.my-striped-table th, table.my-striped-table td {
            border: 1px solid #ccc !important;
            padding: 6px 4px !important;
            font-weight: normal !important; /* ตัวหนังสือบาง */
            background-color: transparent !important; /* ปรับพื้นหลังให้ขาวสะอาด */
            color: #000 !important;
        }
        table.my-striped-table th {
            font-weight: bold !important;
            background-color: #f2f2f2 !important;
        }

        /* ลบพื้นหลังไฮไลต์พิเศษของตัวแปรในแถว */
        table.my-striped-table tr, table.my-striped-table td[style*="background-color"] {
            background-color: transparent !important;
            color: #000 !important;
        }

        /* ซ่อนคอลัมน์ที่ไม่ต้องการสั่งพิมพ์ตามเงื่อนไข (อิงตามลำดับของ th/td) */
        /* คอลัมน์ที่ 1 (Checkbox), คอลัมน์ที่ 2 (#/Badge), คอลัมน์ที่ 4 (เลขบริการ) */
        table.my-striped-table th:nth-child(1), table.my-striped-table td:nth-child(1),
        table.my-striped-table th:nth-child(2), table.my-striped-table td:nth-child(2),
        table.my-striped-table th:nth-child(4), table.my-striped-table td:nth-child(4),
        /* คอลัมน์ที่ 8 (น้ำหนัก), คอลัมน์ที่ 9 (ส่วนสูง) */
        table.my-striped-table th:nth-child(8), table.my-striped-table td:nth-child(8),
        table.my-striped-table th:nth-child(9), table.my-striped-table td:nth-child(9),
        /* คอลัมน์ที่ 12 (รหัสโรค), คอลัมน์ที่ 14 (สถานะ) */
        table.my-striped-table th:nth-child(12), table.my-striped-table td:nth-child(12),
        table.my-striped-table th:nth-child(14), table.my-striped-table td:nth-child(14),
        /* คอลัมน์ที่ 16 (ค่ารักษา), คอลัมน์ที่ 17 (ตรวจสอบ) */
        table.my-striped-table th:nth-child(16), table.my-striped-table td:nth-child(16),
        table.my-striped-table th:nth-child(17), table.my-striped-table td:nth-child(17) {
            display: none !important;
        }
        
        /* ตั้งค่าหน้ากระดาษแนวนอน */
        @page {
            size: landscape;
            margin: 10mm;
        }
    }
');
?>

<div class="row">
    <div class="col-md-12">
        <div class="info-card">
            <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 15px;">
                <div class="d-flex flex-wrap align-items-center" style="gap: 10px;">
                    <img src="uploads/LOGO-FDH.png" alt="FDH" width="150" height="80" style="object-fit: contain;">
                    <img src="uploads/brand.png" alt="Brand" width="180" height="80" style="object-fit: contain;">
                    <img src="uploads/cropped-logo-DHES2.png" alt="DHES2" width="350" height="80" style="object-fit: contain;">
                    <img src="uploads/สปสช.png" alt="สปสช" width="150" height="80" style="object-fit: contain;">
                    <img src="uploads/imagesm30.jpg" alt="Logo" width="300" height="80" style="object-fit: contain;">
                </div>
                
                <div class="text-right">
                    <?php
                    echo Html::a('<i class="fa fa-folder-open"></i> เปิดอ่านไฟล์', '#', [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'modal',
                        'data-target' => '#myModal',
                        'data-url' => Url::to(['f16opofc/list-files-partial']),
                    ]);
                    ?>
                    <?= Html::a('<i class="fa fa-check-square"></i> ผ่าน', null, ['class' => 'btn btn-success', 'id' => 'link1']) ?>
                    <?= Html::a('<i class="fa fa-ban"></i> ไม่ผ่าน', null, ['class' => 'btn btn-danger', 'id' => 'link2']) ?>
                    <a href="<?= Url::to(['f16opofc/run-curl', 'date1' => $date1, 'date2' => $date2]) ?>" class="btn btn-info" style="font-size: 14px; border-radius: 25px;">
                        RunToken <i class="fa fa-arrow-circle-right"></i>
                    </a>
                    <a href="<?= Url::to(['fdhopofc/index']) ?>" class="btn btn-warning modalLink" style="font-size: 14px;" target="_blank">
                        Query <i class="fa fa-arrow-circle-right"></i>
                    </a>
                    <?= Html::a('<i class="fa fa-trash"></i> ลบ claim_token ทั้งหมด', ['delete-all'], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูล claim_token ทั้งหมด?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
Modal::begin([
    'id' => 'myModal',
    'header' => '<h4>File List</h4>',
    'size' => Modal::SIZE_LARGE,
]);
echo '<div id="modal-content">Loading...</div>';
Modal::end();

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

<div class="container-fluid" style="margin-bottom: 20px; padding: 0;">
    <div class="row">
        <div class="col-md-12">
            <?= Html::beginForm(['index'], 'get', ['class' => 'form-inline d-flex align-items-center flex-wrap', 'style' => 'gap: 10px;']) ?>
                <div class="form-group">
                    <label class="mr-2">วันที่:</label>
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
                            'style' => 'font-size: 1.1rem; padding: 8px 15px; background-color: #e0ffff; border: 2px solid #87cefa; border-radius: 20px; color: #333;',
                        ],
                    ]) ?>
                </div>

                <div class="form-group">
                    <label class="mx-2">ถึง:</label>
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
                            'style' => 'font-size: 1.1rem; padding: 8px 15px; background-color: #e0ffff; border: 2px solid #b0e0e6; border-radius: 20px; color: #333;',
                        ],
                    ]) ?>
                </div>

                <?= Html::submitButton('🔍 ค้นหา', [
                    'class' => 'btn btn-outline-dark shadow-sm',
                    'style' => 'font-size: 1.1rem; font-weight: bold; padding: 8px 20px; border-radius: 20px; background-color: #e0ffff; transition: all 0.3s;'
                ]) ?>
            <?= Html::endForm() ?>
        </div>
    </div>
</div>

<p>
    <button class="btn btn-primary" onclick="printReport(event); return false;">🖨️ พิมพ์รายงาน</button>
</p>

<?= Html::beginForm(['f16opofc/data'], 'post', ['name' => 'frmMain', 'id' => 'formMains']); ?>
    <?= Html::hiddenInput('date1', $date1) ?>
    <?= Html::hiddenInput('date2', $date2) ?>  

    <?php
    $allowedUsers = [6, 96, 289, 383];  
    $currentUserId = Yii::$app->user->id ?? null;

    if (in_array($currentUserId, $allowedUsers)) :
    ?>
        <div class="floating-button">
            <button type="submit" name="btnSubmit" id="btnSubmit">
                <i class="fa fa-arrow-circle-right"></i> ส่งข้อมูล OP-สิทธิ์ข้าราชการ
            </button>
        </div>
    <?php endif; ?>

    <div style="height: 550px; overflow-y: auto; border: 1px solid #ddd; border-radius: 4px; box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);">
        <table class="table my-striped-table" style="width: 100%; margin-bottom: 0;">
            <thead>
                <tr>
                    <th width="40" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 10; text-align: center;">
                        <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);">
                    </th>
                    <th width="50" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 10; text-align: center;">#</th>
                    <th width="100" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 10; text-align: center;">วันที่</th>
                    <th width="110" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 10;">เลขบริการ</th>
                    <th width="90" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 10;">Hn</th>
                    <th width="180" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 10;">ชื่อ-สกุล</th>
                    <th width="60" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 10;">อายุ</th>
                    <th width="70" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 10;">น้ำหนัก</th>
                    <th width="70" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 10;">ส่วนสูง</th>
                    <th width="120" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 10;">แผนก</th>
                    <th width="150" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 10;">โรคหลัก</th>
                    <th width="90" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 10;">รหัสโรค</th>
                    <th width="80" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 10;">สิทธิ์</th>
                    <th width="90" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 10;">สถานะ</th>
                    <th width="110" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 10;">EDC</th>
                    <th width="100" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 10;">ค่ารักษา</th>
                    <th width="100" style="background-color: #a8e6cf; position: sticky; top: 0; z-index: 10; text-align: center;">ตรวจสอบ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataProvider->getModels() as $key => $value) : ?>
                    <tr style="background-color: <?= (empty($value['messagecode']) ? '#F2DEF9' : '#daf7ef'); ?>;">
                        <td style="text-align: center; vertical-align: middle;">
                            <input type="checkbox" name="chkDel[]" id="chkDel<?= $key; ?>" value="<?= htmlspecialchars($value["visit_id"] . $value["hn"]) ?>" style="width: 18px; height: 18px;">
                        </td>
                        <td style="text-align: center; vertical-align: middle;"><span class="badge"><?= $value["No"]; ?></span></td>
                        <td class="text-nowrap" style="font-size: 14px; vertical-align: middle;"><?= $value["regdate"]; ?></td>
                        <td style="font-size: 14px; vertical-align: middle;"><?= $value["visit_id"]; ?></td>

                        <?php
                        $color   = "black";
                        $bgcolor = "transparent";
                        if (!empty($value["hosp_id"])) {
                            $color = "white"; $bgcolor = "red";
                        } elseif (!empty($value["us_no"])) {
                            $color = "white"; $bgcolor = "purple";
                        } elseif (!empty($value["xreq_no"])) {
                            $color = "white"; $bgcolor = "green";
                        }
                        ?>
                        <td style="font-size:14px; color:<?= $color ?>; background-color:<?= $bgcolor ?>; padding:5px; border-radius:4px; vertical-align: middle; font-weight: bold;">
                            <?= $value["hn"] ?>
                        </td>

                        <td class="text-nowrap" style="font-size: 14px; vertical-align: middle;"><?= $value["fullname"]; ?></td>
                        <td style="font-size: 14px; vertical-align: middle;"><?= $value["age"]; ?></td>
                        <td style="font-size: 14px; vertical-align: middle;"><?= $value["weight"]; ?></td>
                        <td style="font-size: 14px; vertical-align: middle;"><?= $value["height"]; ?></td>
                        <td class="text-nowrap" style="font-size: 14px; vertical-align: middle;"><?= $value["unit_name"]; ?></td>
                        <td class="text-nowrap" style="font-size: 14px; vertical-align: middle;"><?= $value["Diagx"]; ?></td>
                        <td class="text-nowrap" style="font-size: 14px; vertical-align: middle; color: green;">
                            <?= $value["Diag"]; ?>
                        </td>
                        <td class="text-nowrap" style="font-size: 14px; vertical-align: middle;"><?= $value["inscl"]; ?></td>
                        <td class="text-nowrap" style="font-size: 14px; vertical-align: middle;"><?= $value["messagecode"]; ?></td>

                        <?php
                        $claimCode = trim($value["claim_code"] ?? '');
                        $claimColor = (strlen($claimCode) === 9) ? 'green' : 'red';
                        ?>
                        <td class="text-nowrap" style="font-size: 14px; vertical-align: middle; color: <?= $claimColor ?>; font-weight: bold;">
                            <?= htmlspecialchars($claimCode) ?>
                        </td>

                        <td class="text-nowrap" style="font-size: 14px; vertical-align: middle; font-weight: bold;"><?= number_format((float)$value["amount"], 2); ?></td>
                        
                        <td style="text-align:center; vertical-align: middle; padding:4px;">
                            <button type="button" style="background:#2e7d32; color:#fff; border:none; border-radius:6px; padding:6px 12px; font-size:12px; font-weight:500; cursor:pointer;"
                                    onclick="openCheckModal('<?= $value["visit_id"]; ?>', '<?= $value["hn"]; ?>', '<?= addslashes($value["fullname"]); ?>')" title="ตรวจสอบข้อมูลก่อนส่ง">
                                <i class="fas fa-search" style="font-size:11px;"></i> ตรวจสอบ
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?= Html::endForm() ?>

<div id="loading-spinner">
    <div class="custom-spinner"></div>
</div>

<div class="modal fade" id="progressModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content" style="border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
            <div class="modal-body" style="padding: 30px;">
                <h4 class="text-center" id="progressTitle" style="color: #2e7d32; font-weight: bold; margin-bottom: 20px;">
                    <i class="fas fa-spinner fa-spin"></i> กำลังเตรียมระบบส่งข้อมูล...
                </h4>
                
                <div class="progress" style="height: 25px; border-radius: 15px; margin-bottom: 20px; background-color: #e0f2f1;">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; background-color: #00a400; font-size: 14px; line-height: 25px; font-weight: bold;">
                        0%
                    </div>
                </div>

                <div style="background-color: #ffffff; color: #333333; padding: 15px; border: 1px solid #cccccc; border-radius: 5px; font-family: 'Courier New', Courier, monospace; min-height: 180px; max-height: 320px; overflow-y: auto; font-size: 14px; font-weight: bold; line-height: 1.7;" id="logConsole">
                    <div style="color: #888;">[ระบบ] เริ่มต้นตรวจสอบคิว...</div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// เพิ่มฟังก์ชัน printReport() เข้าไปในสคริปต์เดิม
$this->registerJs("
    window.printReport = function(e) {
        if(e) e.preventDefault();
        window.print();
    };

    $('#link1').click(function(){
        $('#model1').show();
        $('#model2').hide();
    });

    $('#link2').click(function(){
        $('#model1').hide();
        $('#model2').show();
    });

    $(document).ready(function() {
        // เมื่อทำการกดปุ่มลอย ส่งข้อมูล
        $('#btnSubmit').on('click', function(e) {
            e.preventDefault();
            
            var checkedRows = $('input[name=\"chkDel[]\"]:checked');
            var totalItems = checkedRows.length;
            
            if (totalItems === 0) {
                alert('กรุณาเลือกรายการที่ต้องการส่งข้อมูลอย่างน้อย 1 รายการ');
                return false;
            }

            // ล้างค่าเก่าและสั่งเปิดหน้าต่างแสดงความคืบหน้าคิว
            $('#logConsole').html('');
            $('#progressModal').modal('show');
            
            var date1 = $('input[name=\"date1\"]').val();
            var date2 = $('input[name=\"date2\"]').val();
            var currentIndex = 0;

            function sendNextItem() {
                if (currentIndex < totalItems) {
                    var currentItem = $(checkedRows[currentIndex]);
                    var value = currentItem.val(); 
                    
                    // แกะแถวเพื่อเอา HN (หลัก 5) และ ชื่อ-สกุล (หลัก 6) มาแสดงผลในหน้า Log
                    var row = currentItem.closest('tr');
                    var hn = row.find('td:nth-child(5)').text().trim();
                    var fullname = row.find('td:nth-child(6)').text().trim();
                    
                    var displayIndex = currentIndex + 1;
                    
                    // ปรับแต่งแถบความคืบหน้า
                    var percent = Math.round((displayIndex / totalItems) * 100);
                    $('#progressModal .progress-bar').css('width', percent + '%').text(percent + '%');
                    $('#progressTitle').html('<i class=\"fas fa-spinner fa-spin\"></i> กำลังส่งข้อมูลลำดับที่ ' + displayIndex + '/' + totalItems);

                    // ยิงส่งแบบ AJAX รายตัวไปที่ Action Controller
                    $.ajax({
                        url: $('#formMains').attr('action'),
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'chkDel': [value],
                            'date1': date1,
                            'date2': date2,
                            'YII_CSRF_TOKEN': $('input[name=\"_csrf\"]').val()
                        },
                        success: function(response) {
                            if (response && response.status === 'success') {
                                $('#logConsole').append('<div style=\"color: #2e7d32;\">' + displayIndex + '. HN: ' + hn + ' (' + fullname + ') -> ส่งสำเร็จ</div>');
                            } else {
                                var reason = (response && response.message) ? ' (' + response.message + ')' : '';
                                $('#logConsole').append('<div style=\"color: #c62828; background-color: #ffebee; padding: 2px 5px; margin: 2px 0; border-radius:3px;\">' + displayIndex + '. HN: ' + hn + ' (' + fullname + ') -> ส่งไม่สำเร็จ' + reason + '</div>');
                            }
                            
                            $('#logConsole').scrollTop($('#logConsole')[0].scrollHeight);
                            currentIndex++;
                            sendNextItem();
                        },
                        error: function(xhr, status, error) {
                            $('#logConsole').append('<div style=\"color: #b71c1c; background-color: #ffcdd2; padding: 2px 5px; margin: 2px 0; border-radius:3px;\">' + displayIndex + '. HN: ' + hn + ' (' + fullname + ') -> เกิดข้อผิดพลาดของ Server Error</div>');
                            $('#logConsole').scrollTop($('#logConsole')[0].scrollHeight);
                            
                            currentIndex++;
                            sendNextItem();
                        }
                    });
                } else {
                    // ประมวลผลสำเร็จทุกเคสเรียบร้อย
                    $('#progressTitle').html('<i class=\"fas fa-check-circle\" style=\"color: #0277bd;\"></i> ส่งข้อมูลเสร็จสมบูรณ์เรียบร้อยแล้ว');
                    $('#progressModal .progress-bar').removeClass('active progress-bar-striped').css('background-color', '#0277bd').text('100% เสร็จสิ้น');
                    
                    $('#logConsole').append('<div style=\"color: #0277bd; font-weight: bold; margin-top: 5px;\">[ระบบ] กำลังรีเฟรชหน้าต่างรายการภายใน 3 วินาที...</div>');
                    $('#logConsole').scrollTop($('#logConsole')[0].scrollHeight);

                    // หน่วงเวลารอ 3 วินาที (3000 ms) ปิดกล่องและรีเฟรชหน้าจอทันที
                    setTimeout(function() {
                        $('#progressModal').modal('hide');
                        location.reload();
                    }, 3000);
                }
            }

            // เริ่มคำสั่งยิงคิวแรก
            sendNextItem();
        });
    });
", View::POS_READY);
?>