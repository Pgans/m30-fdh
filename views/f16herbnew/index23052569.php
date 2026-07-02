<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\web\View;
use dosamigos\datepicker\DatePicker;
use yii\data\ActiveDataProvider;
//use yii\bootstrap4\Alert;
use yii\bootstrap\Modal;



$this->title = 'FDH-HERB-NEW สมุนไพรไทย';
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
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@iconify/iconify@latest/dist/iconify.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<!-- ####### สลับสี ###################################### -->
<style>
    /* กำหนดสีให้กับแถวที่เป็นเลขคี่ */
    .my-striped-table tr:nth-child(odd) {
        background-color: #efefef;
        /* สีเทาจาง ๆ */
    }

    /* กำหนดสีให้กับแถวที่เป็นเลขคู่ */
    .my-striped-table tr:nth-child(even) {
        background-color: white;
    }
</style>
<style>
    .custom-hover tbody tr:hover {
        background-color: #f5f5f5; /* สีที่ต้องการเมื่อ hover */
    }
</style>
<!-- ### ตัวอักษรกระพริบ  ##### -->
<style>
    .btn-blink {
        animation: blink-animation 1s infinite;
    }

    @keyframes blink-animation {
        0% { opacity: 1; }
        50% { opacity: 0; }
        100% { opacity: 1; }
    }
</style>
<!-- <div class="well"> -->
<!-- <div style="background-color: #126F30; padding: 10px; border: 0px solid #D4F1F5; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">
        <font color="white" size="5"><i class='fas fa-bed'></i> ผู้ป่วยนอก UCS 16 แฟ้ม [FDH Telemed]</font>
        <div style="display: flex; justify-content: flex-end;">
            <span style="color: yellow;">jhcisdb = db14j(200.14) โรงพยาบาลม่วงสามสิบ</span>
        </div>
    </div> -->
<!-- <h5 style="color: green; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.1); padding: 10px;"><i class="fas fa-user"></i> ข้อมูล 16 แฟ้มส่ง Finacail Data Hub </h5> -->

<body>
    <!--     
    <script type="text/javascript">
    setTimeout("frmMain.submit();",50000);
    //5000 อยากได้เร็วก็กำหนดตัวเลขน้อยๆเอานะ
    </script> -->
    <style>
        /* CSS class with light green background */
        .visit-element {
            background-color: lightgray;
            padding: 5px;
            /* Optional padding for spacing */
            margin-bottom: 5px;
            /* Optional margin for spacing */
        }
    </style>
    <style>
        .panel-custom {
            background-color: #2f1c00;
            /* สีน้ำตาลเข้ม */
        }

        .panel-custom .panel-heading {
            color: #00aaff;
            /* ตัวหนังสือสีฟ้า */
        }

        .panel-custom .panel-body {
            color: #00aaff;
            /* ตัวหนังสือสีฟ้า */
        }
    </style>
    <style>
        .panel-custom {
            max-height: 200px;
            /* กำหนดขนาดสูงสุดของพาแนล */
            overflow-y: auto;
            /* ให้แสดงแถบเลื่อนเมื่อเนื้อหาเกินขนาดที่กำหนด */
        }

        .panel-body {
            padding: 10px;
            /* กำหนดระยะห่างของเนื้อหาภายในพาแนล */
        }
    </style>
    <style>
        .custom-spinner {
            border: 16px solid #f3f3f3;
            /* Light grey */
            border-top: 16px solid purple;
            /* Purple */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 1s linear infinite;
        }

        .code-block {
            font-family: "Courier New", Courier, monospace; // ฟอนต์สำหรับโค้ด
            background-color: #f5f5f5; // สีพื้นหลังอ่อน
            padding: 10px; // เพิ่มระยะห่างภายใน
            border: 1px solid #ddd; // ขอบบางๆ
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
	<style>
        .info-card {
            background: linear-gradient(45deg, #d6a3ff, #e0f7fa); /* Canva-like gradient */
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3); /* Card shadow */
            color: #000; /* Text color */
            padding: 20px; /* Padding inside the card */
            border-radius: 10px; /* Rounded corners */
            font-size: 16px; /* Font size */
        }
    </style>
    <style>
        #loading-spinner {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
        }
    </style>
	<style>
.my-striped-table tbody tr:hover {
    background-color: rgba(144, 238, 144, 0.5); /* สีเขียวอ่อนที่โปร่งใส */
}
</style>
    <!-- ############################# แสดงปุ่ม Select All  ################################################################### -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script language="JavaScript">
        function ClickCheckAll(vol) {

            var i = 1;
            for (i = 1; i <= document.frmMain.hdnCount.value; i++) {
                if (vol.checked == true) {
                    eval("document.frmMain.chkDel" + i + ".checked=true");
                } else {
                    eval("document.frmMain.chkDel" + i + ".checked=false");
                }
            }
        }
    </script>
    <!-- ############################# แสดงปุ่ม Select All  ################################################################### -->
    <script>
        function ClickCheckAll(vol) {
            // สมมติว่า frmMain เป็นฟอร์มหลัก
            var checkboxes = document.frmMain.querySelectorAll('input[name="chkDel[]"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = vol.checked; // เลือก/ยกเลิกการเลือกตามช่องหลัก
            });
        }
    </script>
    <!-- ############################# จบแสดงปุ่ม Select All  ################################################################### -->
    <br>
	
    <div class="row">
        <div class="col-xl-3 col-md-3 mb-3">
            <div class="info-card bg-info" style="box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">
                <span class="info-box-icon"><i class="far fa-calendar-check" style="color: green;"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="color: green; font-size: 18px;">รายการผ่านวันนี้</span>
                    <span class="info-box-number"><?php echo $amount ?></span>
                    <!-- <span class="info-box-number">100</span> -->
                </div>

                <?php
                Modal::begin([
                    'id' => 'myModal',
                    'header' => '<h4>File List</h4>',
                    'size' => Modal::SIZE_LARGE,
                ]);
                ?>
                <div id="modal-content">Loading...</div> <!-- เนื้อหาของ modal จะถูกโหลดผ่าน Ajax -->
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
                                    modal.find('#modal-content').html(data); // แสดงเนื้อหาใน Modal
                                }
                            });
                        });
                    ");
                ?>
                <div style="text-align: right;">
                    <div style="text-align: right;">
                        <?php
                        echo Html::a('เปิดอ่านไฟล์', '#', [
                            'class' => 'btn btn-primary',
                            'data-toggle' => 'modal',
                            'data-target' => '#myModal', // เปิด Modal
                            'data-url' => \yii\helpers\Url::to(['f16erext/list-files-partial']), // URL สำหรับโหลดเนื้อหา
                        ]);
                        ?>
                        <?= Html::a('<i class="fa fa-check-square" aria-hidden="true"></i> ผ่าน', null, ['class' => 'btn btn-success', 'id' => 'link1']) ?>
                        
                    </div>
                </div>
                </a>
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-xl-3 col-md-3 mb-3">
            <div class="info-card bg-warning" style="box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">
                <span class="info-box-icon"><i class="fa-sharp fa-solid fa-compass" style="color: red;"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="color: red; font-size: 14px;">จัดการ Token</span>
                    <span class="info-box-number"> 0</span>

                </div>

                <div style="text-align: right;">
                <a href="<?= Url::to(['f16herbnew/run-curl', 'date1' => $date1, 'date2' => $date2]) ?>" 
					   class="btn btn-info" 
					   style="font-size: 16px; border-radius: 25px;">
						RunToken <i class="fa fa-arrow-circle-right"></i>
				    	</a>
				

                    <?= Html::a('<i class="fa fa-ban" aria-hidden="true"></i> ไม่ผ่าน', null, ['class' => 'btn btn-danger', 'id' => 'link2']) ?>
                    
                </div>
                </a>
            </div>
        </div>


        <div class="col-xl-3 col-md-3 mb-3">
            <div class="info-card bg-warning" style="box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">
                <span class="info-box-icon"><i class="fas fa-hand-holding-heart" style="color: orange;"></i></i></span>
                <div class="info-box-content">

                    <span class="info-box-number" style="color: green; font-size: 18px;">ลิงค์เข้าเว็บ FDH</span>

                    <a href="https://uat-fdh.inet.co.th/hospital/detail" target="_blank">FDH-UAT</a>--
                    <a href="https://fdh.moph.go.th/hospital/" target="_blank">FDH-Production</a><br>
                    
                    
                    <!-- ลิงก์ที่เรียกใช้ JavaScript เพื่อเปิดป๊อปอัป -->
                    <!-- <div class="text-center">
                            <a href="javascript:void(0);" id="exportExcelButton" class="btn btn-primary" style="font-size: 16px; border: 4px solid #91ffff;" onclick="openPopup();">
                                รายชื่อและส่งออก ExcelFiles <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div> -->

                    <script>
                        function openPopup() {
                            const url = "<?= \yii\helpers\Url::to(['f16telemed/exportexcel']); ?>"; // ลิงก์ไปยังไฟล์ Excel
                            const popupWindow = window.open(url, 'ExcelPopup', 'width=600,height=400'); // สร้างหน้าต่างป๊อปอัป
                            popupWindow.focus(); // โฟกัสไปยังป๊อปอัป
                        }
                    </script>


                    <a href="<?= \yii\helpers\Url::to(['fdhherbnew/index']) ?>" class="btn btn-warning modalLink" style="font-size: 16px;" target="_blank">
                        Query <i class="fa fa-arrow-circle-right"></i>
                    </a>
                       <?= Html::a('Export', ['f16herbnew/exports'], ['class' => 'btn btn-success']) ?>
					   
                    
                </div>
            </div>
        </div>
		
    <div class="col-xl-4 col-md-3 mb-3">
    <div class="info-card text-dark"
         style="
            background: linear-gradient(to right, #b0e2d6 , #d4f4e8));
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
         ">
           <?= Html::beginForm(['index'], 'get', ['class' => 'd-flex align-items-center justify-content-between flex-wrap']) ?>
		   

        <div class="me-2 mb-2" style="flex: 1; min-width: 130px;">
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
                    'style' => '
                        font-size: 1.2rem;
                        padding: 10px 15px;
                         background-color: #e0ffff;
                        border: 2px solid #b0e0e6;
                        border-radius: 20px;
                        color: #333;
                    ',
                ],
            ]) ?>
        </div>

        <div class="me-2 mb-2" style="flex: 1; min-width: 130px;">
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
                    'style' => '
                        font-size: 1.2rem;
                        padding: 10px 15px;
                        background-color: #e0ffff;
                        border: 2px solid #b0e0e6;
                        border-radius: 20px;
                        color: #333;
                    ',
                ],
            ]) ?>
        </div>

        <div class="mb-2">
            <?= Html::submitButton('🔍 ค้นหา', [
                'class' => 'btn btn-outline-dark shadow',
                'style' => '
                    font-size: 1.2rem;
                    font-weight: bold;
                    padding: 10px 20px;
                    border-radius: 20px;
                    background-color: #ffffffcc;
                    transition: all 0.3s;
                '
            ]) ?>
        </div>

        <?= Html::endForm() ?>
			</div>
		</div>
    </div>
<br>
    
    <!-- ############################################ Grid View ######################################################################## -->
    <div class="page-container">
        <div class="fixed-header">
            <!-- <input name="btnButton1" class="btn btn-success btn btn-block" id="selectAll" type="submit" name="selectAll" value="ส่งข้อมูล FDH OPD" style="background-color: #007100; border: 4px solid #dadada;"> -->
        </div>
        <div style="height: 500px; overflow-y: auto;">
            <div id="loading-spinner" style="display: none; color: purple; font-size: 100px;">
                <!-- Customize the style as needed -->
                <div class="custom-spinner"></div>
            </div>

            <?= Html::beginForm(['f16herbnew/data'], 'post', ['name' => 'frmMain']); ?>
			<?= Html::hiddenInput('date1', $date1) ?>
			 <?= Html::hiddenInput('date2', $date2) ?>
			<?php
			$allowedUsers = [6, 96, 289, 383];  
			## 6=pgans, 96= yoo, 289= จันทร์มณี  383= ต่อง 29=จีระพงษ์  286=พิชิตพร
			$currentUserId = Yii::$app->user->id ?? null;

			if (in_array($currentUserId, $allowedUsers)) :
			?>

				<!-- Floating Button -->
				<div class="floating-button" 
					 style="position: fixed; bottom: calc(3 * 2rem); left: 50%; transform: translateX(-50%); 
							z-index: 1000;">
					<button type="submit" 
							name="btnSubmit" 
							id="btnSubmit" 
							class="btn btn-success btn btn-block" 
							style="background-color: #00a400; border: 4px solid #dadada; padding: 10px 20px; 
								   border-radius: 30px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
								   font-size: 1.5rem; text-transform: uppercase; cursor: pointer; width: auto;">
						<i class="fa fa-arrow-circle-right" style="margin-right: 10px;"></i>
						ส่งข้อมูล OP-HerbNew
					</button>
				</div>
			<?php endif; ?>
              
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
            floatingButton.style.left = `${e.clientX - offsetX}px`;
            floatingButton.style.top = `${e.clientY - offsetY}px`;
        });

        document.addEventListener("mouseup", () => {
            isDragging = false;
        });
    });
</script>
            


<table class="table my-striped-table" width="1000" border="1" bordercolor="#ddd"
       style="border-collapse: collapse; box-shadow: 2px 2px 5px rgba(0,0,0,0.2);">

    <tr>
        <th width="30" style="background-color: lightpink; position: sticky; top: 0; z-index: 1;">
            <div align="center">
                <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);">
            </div>
        </th>
        <td width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
            <div align="center">#</div>
        </td>
        <td width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
            <div align="center" style="font-size: 14px;">วันรับบริการ</div>
        </td>
        <td width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
            <div align="center" style="font-size: 14px;">เลขบริการ</div>
        </td>
        <td width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
            <div align="left" style="font-size: 14px;">Hn</div>
        </td>
        <td width="150" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
            <div align="left" style="font-size: 14px;">ชื่อ-สกุล</div>
        </td>
        <td width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
            <div align="left" style="font-size: 14px;">อายุ</div>
        </td>
        <td width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
            <div align="left" style="font-size: 14px;">แผนก</div>
        </td>
        <td width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
            <div align="left" style="font-size: 14px;">โรคหลัก</div>
        </td>
        <td width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
            <div align="left" style="font-size: 14px;">สมุนไพร</div>
        </td>
        <td width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
            <div align="left" style="font-size: 14px;">ค่ารักษา</div>
        </td>
        <td width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
            <div align="left" class="text-nowrap" style="font-size: 14px;">สิทธิ์</div>
        </td>
        <td width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
            <div align="left" style="font-size: 14px;">สถานหลัก</div>
        </td>
        <td width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
            <div align="left" style="font-size: 14px;">สถานรอง</div>
        </td>
        <td width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
        </td>
        <td width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
            <div align="left" style="font-size: 14px;">authen</div>
        </td>
        <td width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
            <div align="left" style="font-size: 14px;">ปิดสิทธิ์</div>
        </td>
        <!-- ✅ คอลัมน์ตรวจสอบ -->
        <td width="85" style="background-color: lightgray; position: sticky; top: 0; z-index: 1; text-align:center;">
            <div style="font-size: 14px;">ตรวจสอบ</div>
        </td>
    </tr>

    <?php foreach ($dataProvider->getModels() as $key => $value) : ?>
        <tr style="background-color: <?php echo (empty($value['messagecode']) ? '#f7edfa' : '#edf2f0'); ?>;">
            <td>
                <input type="checkbox" name="chkDel[]"
                       id="chkDel<?= $key; ?>"
                       value="<?php echo $value["VISIT_ID"]; ?><?php echo $value["HN"]; ?>"
                       style="width: 16px; height: 16px;">
            </td>
            <td class="badge"><?php echo $value["No"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["REG_DATETIME"]; ?></td>
            <td style="font-size: 14px;"><?php echo $value["VISIT_ID"]; ?></td>
            <td style="font-size: 14px;"><?php echo $value["HN"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["fullname"]; ?></td>
            <td style="font-size: 14px;"><?php echo $value["age"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["unit_name"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["Diagx"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["Herb"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["amount"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["inscl"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["hospmain"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["hospsub"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["messagecode"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["claimcode"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["endpoint"]; ?></td>
            <!-- ✅ ปุ่มตรวจสอบ -->
            <td style="text-align:center; padding:4px;">
                <button type="button"
                        class="btn btn-sm"
                        style="background:#1D9E75; color:#fff; border:none; border-radius:6px;
                               padding:4px 10px; font-size:12px; font-weight:500; cursor:pointer;"
                        onclick="openCheckModal(
                            '<?php echo $value["VISIT_ID"]; ?>',
                            '<?php echo $value["HN"]; ?>',
                            '<?php echo addslashes($value["fullname"]); ?>'
                        )"
                        title="ตรวจสอบข้อมูลก่อนส่ง">
                    <i class="fas fa-search" style="font-size:11px;"></i> ตรวจสอบ
                </button>
            </td>
        </tr>
    <?php endforeach; ?>
</table>


<!-- ====================================================
     CSS
     ==================================================== -->
<style>
/* ✅ Modal กว้างตามหน้าจอ */
#modalCheckData .modal-dialog {
    max-width:75vw;
    width: 75vw;
    margin: 20px auto;
}
#modalCheckData .modal-content {
    border-radius: 10px;
    overflow: hidden;
    border: none;
}
#modalCheckData .modal-header {
    background: linear-gradient(135deg, #1D9E75 0%, #0F6E56 100%);
    border-bottom: none;
    padding: 14px 18px;
}
#modalCheckData .modal-footer {
    background: #f9f9f9;
    border-top: 1px solid #e5e5e5;
    padding: 10px 18px;
}
#mdBody {
    max-height: 75vh;
    overflow-y: auto;
    padding: 16px 18px;
}

/* Summary cards */
.chk-sum-row  { display: flex; gap: 10px; margin-bottom: 16px; }
.chk-sum-card {
    flex: 1; border-radius: 10px; padding: 14px 16px;
    display: flex; align-items: center; gap: 12px;
}
.csc-ok    { background: #E1F5EE; }
.csc-empty { background: #FCEBEB; }
.csc-na    { background: #F1EFE8; }
.csc-icon  {
    width: 36px; height: 36px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 17px; font-weight: 700; flex-shrink: 0;
}
.csc-ok    .csc-icon { background: #9FE1CB; color: #085041; }
.csc-empty .csc-icon { background: #F7C1C1; color: #791F1F; }
.csc-na    .csc-icon { background: #D3D1C7; color: #444441; }
.csc-num { font-size: 26px; font-weight: 700; line-height: 1; }
.csc-ok    .csc-num { color: #0F6E56; }
.csc-empty .csc-num { color: #A32D2D; }
.csc-na    .csc-num { color: #5F5E5A; }
.csc-lbl { font-size: 11px; font-weight: 500; margin-top: 3px; }
.csc-ok    .csc-lbl { color: #1D9E75; }
.csc-empty .csc-lbl { color: #E24B4A; }
.csc-na    .csc-lbl { color: #888780; }

/* แถวแฟ้ม */
.file-row {
    border: 1px solid #e4e4e4; border-radius: 8px;
    margin-bottom: 6px; overflow: hidden; transition: box-shadow 0.15s;
}
.file-row:hover { box-shadow: 0 2px 6px rgba(0,0,0,0.07); }
.file-header {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 14px; user-select: none; transition: background 0.1s;
}
.file-header.clickable { cursor: pointer; }
.file-header.clickable:hover { background: rgba(0,0,0,0.02); }
.fh-ok    { border-left: 4px solid #1D9E75; }
.fh-empty { border-left: 4px solid #E24B4A; }
.fh-na    { border-left: 4px solid #B4B2A9; }
.fh-warn  { border-left: 4px solid #EF9F27; }
.file-name { font-size: 13px; font-weight: 600; min-width: 60px; color: #333; }
.req-star  { color: #E24B4A; font-size: 12px; }
.fpill { font-size: 11px; font-weight: 500; padding: 3px 11px; border-radius: 20px; }
.fpill-ok    { background: #E1F5EE; color: #0F6E56; }
.fpill-empty { background: #FCEBEB; color: #A32D2D; }
.fpill-na    { background: #F1EFE8; color: #5F5E5A; }
.fpill-warn  { background: #FAEEDA; color: #633806; }
.fchev { margin-left: auto; font-size: 11px; color: #bbb; transition: transform 0.2s; }
.file-row.open .fchev { transform: rotate(180deg); }
.file-body { display: none; border-top: 1px solid #eee; }
.file-row.open .file-body { display: block; }

/* ตารางข้อมูล */
.dtbl { width: 100%; border-collapse: collapse; font-size: 11px; }
.dtbl th {
    background: #f7faf9; padding: 5px 10px; text-align: left;
    border-bottom: 1px solid #e5e5e5; color: #666; font-size: 10px;
    font-weight: 600; white-space: nowrap; text-transform: uppercase; letter-spacing: 0.03em;
}
.dtbl td { padding: 5px 10px; border-bottom: 1px solid #f0f0f0; color: #333; white-space: nowrap; }
.dtbl tr:last-child td { border-bottom: none; }
.dtbl tbody tr:hover td { background: #fafafa; }

/* Progress */
.chk-prog-bar  { height: 5px; background: rgba(255,255,255,0.3); border-radius: 3px; overflow: hidden; margin-bottom: 14px; }
.chk-prog-fill { height: 100%; background: #fff; border-radius: 3px; transition: width 0.25s; width: 0%; }

/* Alert */
.chk-err-box {
    background: #FCEBEB; border: 1px solid #F7C1C1;
    border-radius: 8px; padding: 12px 14px; color: #791F1F; font-size: 13px;
}
.chk-alert {
    border-radius: 8px; padding: 10px 14px; font-size: 13px;
    font-weight: 500; margin-bottom: 14px;
    display: flex; align-items: center; gap: 8px;
}
.chk-alert-ok    { background: #E1F5EE; color: #0F6E56; border: 1px solid #9FE1CB; }
.chk-alert-error { background: #FCEBEB; color: #A32D2D; border: 1px solid #F7C1C1; }
</style>


<!-- ====================================================
     MODAL
     ==================================================== -->
<div class="modal fade" id="modalCheckData" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <!-- Header — สีเขียวเข้ม -->
            <div class="modal-header">
                <div style="display:flex; align-items:center; gap:11px;">
                    <div style="width:40px; height:40px; border-radius:10px;
                                background:rgba(255,255,255,0.2);
                                display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fas fa-clipboard-check" style="color:#fff; font-size:18px;"></i>
                    </div>
                    <div>
                        <div style="font-size:15px; font-weight:600; color:#fff;">
                            ตรวจสอบข้อมูล 8 แฟ้ม
                        </div>
                        <div id="mdPatientInfo" style="font-size:11px; color:rgba(255,255,255,0.8); margin-top:2px;"></div>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal"
                        style="font-size:22px; color:#fff; opacity:0.8; margin-left:auto;">&times;</button>
            </div>

            <!-- Body -->
            <div id="mdBody">

                <!-- Progress -->
                <div id="mdProgress" style="display:none; margin-bottom:6px;">
                    <div class="chk-prog-bar">
                        <div class="chk-prog-fill" id="mdProgFill"></div>
                    </div>
                    <div style="font-size:11px; color:#999; text-align:center; margin-top:6px;">
                        <i class="fas fa-spinner fa-spin"></i>&nbsp; กำลังตรวจสอบข้อมูล...
                    </div>
                </div>

                <!-- Alert ผ่าน / ไม่ผ่าน -->
                <div id="mdAlert" style="display:none;"></div>

                <!-- Summary cards -->
                <div id="mdSummary" style="display:none; margin-bottom:14px;">
                    <div class="chk-sum-row">
                        <div class="chk-sum-card csc-ok">
                            <div class="csc-icon">&#10004;</div>
                            <div>
                                <div class="csc-num" id="mdOkCount">0</div>
                                <div class="csc-lbl">มีข้อมูล</div>
                            </div>
                        </div>
                        <div class="chk-sum-card csc-empty">
                            <div class="csc-icon">&#10008;</div>
                            <div>
                                <div class="csc-num" id="mdEmptyCount">0</div>
                                <div class="csc-lbl">ไม่มีข้อมูล</div>
                            </div>
                        </div>
                        <div class="chk-sum-card csc-na">
                            <div class="csc-icon">&mdash;</div>
                            <div>
                                <div class="csc-num" id="mdNaCount">0</div>
                                <div class="csc-lbl">ไม่บังคับ</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- รายการแฟ้ม -->
                <div id="mdGrid"></div>

            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <small style="font-size:11px; color:#999;">
                    <span style="color:#E24B4A; font-weight:700;">*</span> = แฟ้มบังคับ
                    &nbsp;&nbsp;
                    <i class="fas fa-hand-pointer" style="font-size:10px;"></i> คลิกแถบเพื่อดูข้อมูล
                </small>
                <button type="button" class="btn btn-secondary btn-sm"
                        data-dismiss="modal"
                        style="border-radius:7px; padding:6px 18px;">
                    <i class="fas fa-times"></i> ปิด
                </button>
            </div>

        </div>
    </div>
</div>


<!-- ====================================================
     SCRIPT
     ==================================================== -->
<script>

var checkDataUrl = '<?= \yii\helpers\Url::to(['check-data']) ?>';

// ====================================================
// เปิด Modal + โหลดข้อมูล
// ====================================================
function openCheckModal(visit, hn, name) {
    $('#mdPatientInfo').html(
        '<b>HN:</b> ' + hn +
        '&nbsp;|&nbsp;<b>Visit:</b> ' + visit +
        '&nbsp;|&nbsp;' + name
    );
    $('#mdGrid').html('');
    $('#mdAlert').hide().html('');
    $('#mdSummary').hide();
    $('#mdProgress').show();
    $('#mdProgFill').css('width', '0%');
    $('#modalCheckData').modal('show');

    var pct = 0;
    var pTimer = setInterval(function () {
        pct += 7;
        if (pct > 88) { clearInterval(pTimer); pct = 88; }
        $('#mdProgFill').css('width', pct + '%');
    }, 70);

    $.getJSON(checkDataUrl, { visit: visit, hn: hn })
        .done(function (res) {
            clearInterval(pTimer);
            $('#mdProgFill').css('width', '100%');
            setTimeout(function () { $('#mdProgress').hide(); }, 300);
            renderFiles(res);
        })
        .fail(function (jqXHR) {
            clearInterval(pTimer);
            $('#mdProgress').hide();
            $('#mdGrid').html(
                '<div class="chk-err-box">' +
                '<i class="fas fa-exclamation-triangle"></i>&nbsp;' +
                'เกิดข้อผิดพลาด HTTP <b>' + jqXHR.status + '</b>' +
                '</div>'
            );
        });
}

// ====================================================
// Render รายการแฟ้ม
// ====================================================
function renderFiles(res) {
    if (!res.success) {
        $('#mdGrid').html(
            '<div class="chk-err-box">' +
            '<i class="fas fa-exclamation-triangle"></i>&nbsp;' +
            '<b>[Error]</b> ' + res.message +
            (res.file
                ? '<br><small style="opacity:.7;">' + res.file + ' line ' + res.line + '</small>'
                : '') +
            '</div>'
        );
        return;
    }

    var ok = 0, empty = 0, na = 0, html = '';

    $.each(res.data, function (_, item) {
        var hCls, pCls, icon, label;

        if (item.status === 'ok') {
            hCls = 'fh-ok';    pCls = 'fpill-ok';
            icon = '&#10004;'; label = 'มี ' + item.count + ' record'; ok++;
        } else if (item.status === 'empty') {
            hCls = 'fh-empty'; pCls = 'fpill-empty';
            icon = '&#10008;'; label = 'ไม่มีข้อมูล!'; empty++;
        } else if (item.status === 'error') {
            hCls = 'fh-warn';  pCls = 'fpill-warn';
            icon = '&#9888;';  label = 'Query Error'; empty++;
        } else if (item.status === 'no_config') {
            hCls = 'fh-warn';  pCls = 'fpill-warn';
            icon = '&#9881;';  label = 'ไม่มี config'; empty++;
        } else {
            hCls = 'fh-na';   pCls = 'fpill-na';
            icon = '&mdash;'; label = 'ไม่บังคับ'; na++;
        }

        var reqBadge = item.required
            ? '<span class="req-star"> *</span>' : '';
        var msgSpan  = item.message
            ? '<span style="font-size:10px;color:#aaa;margin-left:6px;">(' + item.message + ')</span>' : '';

        var tblHtml = buildDataTable(item.rows);
        var hasData = (tblHtml !== '');

        html +=
            '<div class="file-row' + (item.status === 'empty' ? ' open' : '') + '">' +
            '  <div class="file-header ' + hCls + (hasData ? ' clickable' : '') + '"' +
               (hasData ? ' onclick="toggleRow(this)"' : '') + '>' +
            '    <span class="file-name">' + item.table + reqBadge + '</span>' +
            '    <span class="fpill ' + pCls + '">' + icon + '&nbsp;' + label + '</span>' +
                 msgSpan +
            (hasData ? '<span class="fchev">&#9660;</span>' : '') +
            '  </div>' +
            (hasData
                ? '<div class="file-body"><div style="overflow-x:auto;">' + tblHtml + '</div></div>'
                : '') +
            '</div>';
    });

    $('#mdGrid').html(html);
    $('#mdOkCount').text(ok);
    $('#mdEmptyCount').text(empty);
    $('#mdNaCount').text(na);
    $('#mdSummary').fadeIn(200);

    // Alert ผ่าน / ไม่ผ่าน
    if (res.hasError) {
        $('#mdAlert')
            .html('<i class="fas fa-times-circle"></i>&nbsp;ข้อมูลไม่ครบ — กรุณาตรวจสอบแฟ้มสีแดงก่อนส่ง')
            .removeClass('chk-alert-ok').addClass('chk-alert chk-alert-error')
            .show();
    } else {
        $('#mdAlert')
            .html('<i class="fas fa-check-circle"></i>&nbsp;ข้อมูลครบถ้วน — พร้อมส่งข้อมูล')
            .removeClass('chk-alert-error').addClass('chk-alert chk-alert-ok')
            .show();
    }
}

// ====================================================
// สร้างตาราง HTML จาก rows
// ====================================================
function buildDataTable(rows) {
    if (!rows || rows.length === 0) return '';
    var cols = Object.keys(rows[0]);
    var h = '<table class="dtbl"><thead><tr>';
    cols.forEach(function (c) { h += '<th>' + c + '</th>'; });
    h += '</tr></thead><tbody>';
    rows.forEach(function (row) {
        h += '<tr>';
        cols.forEach(function (c) {
            var v = (row[c] !== null && row[c] !== undefined)
                  ? row[c]
                  : '<span style="color:#ccc;font-style:italic;">null</span>';
            h += '<td>' + v + '</td>';
        });
        h += '</tr>';
    });
    return h + '</tbody></table>';
}

// ====================================================
// Toggle เปิด/ปิดตาราง
// ====================================================
function toggleRow(hdr) {
    var row = hdr.closest('.file-row');
    if (row) row.classList.toggle('open');
}

// ====================================================
// Check All (เดิม)
// ====================================================
function ClickCheckAll(vol) {
    var i;
    for (i = 0; i < document.frmMain.elements.length; i++) {
        if (document.frmMain.elements[i].name == "chkDel[]") {
            document.frmMain.elements[i].checked = vol.checked;
        }
    }
}

// ====================================================
// Form Submit (เดิม)
// ====================================================
document.querySelector('form[name="frmMain"]').addEventListener('submit', function (event) {
    var checkedRows = document.querySelectorAll('input[name="chkDel[]"]:checked');
    var count = checkedRows.length;

    if (count > 0) {
        var currentIndex = 0;

        function processRow() {
            if (currentIndex < count) {
                var row = checkedRows[currentIndex].closest('tr');
                var originalBackgroundColor = row.style.backgroundColor;
                row.style.backgroundColor = '#F8B6F6';
                row.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'nearest' });
                setTimeout(function () {
                    row.style.backgroundColor = originalBackgroundColor;
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
<!-- ########################################################################################## -->


<!-- ############################ Setflash Alert 5 วินาที ######################################################### -->
<script>
    // Automatically hide success and error messages after 15 seconds
    setTimeout(function() {
        $('.alert').slideUp('slow');
    }, 15000);
</script>
<!-- ################################################################################################################## -->
<?php

$this->registerJs('
  jQuery("#btn-delete").click(function(){
    var keys = $("#w0").yiiGridView("getSelectedRows");
    console.log(keys);
    if(keys.length>0){
      jQuery.post("' . Url::to(['delete-all']) . '",{ids:keys},function(){
      });
    }
  });
');
?>
<!-- ############################## PASS ################################################################# -->
<div id="model1" style="display: none;">
    <h2 style="color: #2db94d; border: 2px solid #c3e6cb; padding: 5px; text-align: center; border-radius: 10px;">แสดงรายการผ่าน</h2>

    <div class="table-wrapper">
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $passProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'visit_id',
                'pid',
                'users',
                'response',
                'd_update',
            ],
            'tableOptions' => [
                'class' => 'table table-striped table-hover custom-hover', // ใช้คลาสของ Bootstrap และคลาสที่กำหนดเอง
                'style' => 'width: 100%; border: 1px solid #dee2e6; box-shadow: 0px 2px 10px rgba(0,0,0,0.1); border-radius: 10px;', // ใช้ style เพื่อกำหนดเส้นขอบและเงา
            ],
            'headerRowOptions' => ['style' => 'background-color: lightgray;'],
            'rowOptions' => ['style' => 'background-color: #ecffec;'],
        ]); ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        var tableWrapper = $('.table-wrapper');
        var tableHeight = 200; // กำหนดความสูงของพื้นที่ Scrollbar

        tableWrapper.css({
            'max-height': tableHeight,
            'overflow-y': 'auto',
            'overflow-x': 'hidden'
        });

        // Fix header when scrolling
        var headerClone = tableWrapper.find('thead').clone(); // Clone the table header
        var fixedHeader = $('<div>').addClass('fixed-header'); // Create a fixed header container

        fixedHeader.append(headerClone); // Append the cloned header to fixed container
        fixedHeader.css({
            'position': 'sticky',
            'top': 0,
            'background-color': '#009700', // ให้สีตรงกับสีของส่วนหัว
            'z-index': 1000
        });

        tableWrapper.prepend(fixedHeader); // Add the fixed header to the wrapper
    });
</script>

<!-- ############################## ERROR ################################################################# -->
<div id="model2" style="display: none;">
    <h2 style="color: #ff0000; border: 2px solid #c3e6cb; padding: 5px;">แสดงรายการไม่ผ่าน</h2>

    <?= \yii\grid\GridView::widget([
        'tableOptions' => [
            'class' => 'table table-striped table-hover1',
            'width' => '100%',
            'cellspacing' => '1'
        ],
        'dataProvider' => $errorProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'visit_id',
            'pid',
            'users',
            'response',
            'd_update',
        ],
        'headerRowOptions' => ['style' => 'background-color: #ff5eae; color: white;'],
        'rowOptions' => ['style' => 'background-color: #ffb3b3; color: #ff0000;'],
    ]); ?>
</div>

</div>
</div>


<!-- สคริปต์ jQuery เพื่อแสดง/ซ่อนข้อมูลเมื่อคลิกที่ลิงค์ -->
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
<script>
    $(document).ready(function() {
        $('.popup-link').click(function(e) {
            e.preventDefault();
            var url = $(this).data('url');
            openModalWithData(url);
        });

        $('#selectAll').click(function() {
            // Show the spinner when the button is clicked
            $('#loading-spinner').show();
        });

        // Assuming you have a form with the class 'your-form-class'
        $(document).on('beforeSubmit', 'form[name="frmMain"]', function() {
            // Show the spinner before form submission
            $('#loading-spinner').show();
            return true;
        });

        // If you're using Pjax, hide the spinner on successful Pjax response
        $(document).on('pjax:success', function() {
            $('#loading-spinner').hide();
        });

        // If you're not using Pjax, hide the spinner on any AJAX request completion
        $(document).ajaxStop(function() {
            $('#loading-spinner').hide();
        });
    });

    function openModalWithData(url) {
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('#myModal .modal-body').html(response);
                $('#myModal').modal('show');
            },
            error: function() {
                alert('An error occurred while fetching data.');
            }
        });
    }
</script>