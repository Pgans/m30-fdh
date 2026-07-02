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




$this->title = 'Home-Ward';
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
	
	<!-- ปุ่มลอย ด้านล่าง  -->
	<style>
    .floating-button {
        position: fixed; /* ทำให้ปุ่มลอยอยู่ในตำแหน่ง */
        bottom: 150px; /* ห่างจากขอบล่างของหน้าจอ 80px */
        left: 50%; /* กึ่งกลางตามแนวนอน */
        transform: translateX(-50%); /* ดันกลับเพื่อให้อยู่ตรงกลาง */
        z-index: 1000; /* อยู่เหนือองค์ประกอบอื่น */
    }

    .floating-button input[type="submit"] {
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
    }

    .floating-button input[type="submit"]:hover {
        background-color: #008a00;
        transform: scale(1.05);
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
<!-- จบปุ่มลอย -->

    <style>
        /* CSS class with light green background */
        .visit-element {
            background-color: lightgreen;
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
            background: linear-gradient(45deg, #add8e6, #e0ffff);
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
            <!-- <div class="info-card bg-info" style="border: 4px solid gray;"> -->
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
					echo Html::a('<i class="fa fa-folder-open"></i> เปิดอ่านไฟล์', '#', [
						'class' => 'btn',
						'style' => '
							background-color: #ffffff;
							color: #007bff;
							border-radius: 25px;
							padding: 10px 20px;
							font-weight: bold;
							border: 2px solid #007bff;
							box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
							transition: all 0.3s;
						',
						'data-toggle' => 'modal',
						'data-target' => '#myModal',
						'data-url' => \yii\helpers\Url::to(['f16ipae/list-files-partial']),
					]);
					?>

                       <?= Html::a('<i class="fa fa-check-square" aria-hidden="true"></i> ผ่าน', null, [
							'class' => 'btn',
							'id' => 'link1',
							'style' => '
								background-color: #ffffff;
								color: #28a745;
								border-radius: 25px;
								padding: 10px 20px;
								font-weight: bold;
								border: 2px solid #28a745;
								box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
								transition: all 0.3s;
							'
						]) ?>
                      
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
              <a href="<?= Url::to(['f16homeward/run-curl', 'date1' => $date1, 'date2' => $date2]) ?>" 
			   class="btn"
			   style="
				   background-color: #ffffff;
				   color: #28a745;
				   border: 2px solid #28a745;
				   border-radius: 25px;
				   font-size: 16px;
				   font-weight: bold;
				   padding: 10px 20px;
				   box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
				   transition: background-color 0.3s, color 0.3s;
			   ">
			   RunToken <i class="fa fa-arrow-circle-right"></i>
			</a>
                    <?= Html::a('<i class="fa fa-ban" aria-hidden="true"></i> ไม่ผ่าน', null, [
						'class' => 'btn',
						'id' => 'link2',
						'style' => '
							background-color: #ffffffcc;
							border-radius: 25px;
							padding: 10px 20px;
							border: 1px solid #f2132a;
							color: #f2132a;
							font-weight: bold;
							transition: all 0.3s;
						'
					]) ?>


                    
                </div>
                </a>
            </div>
        </div>



        <div class="col-xl-3 col-md-3 mb-3">
           <div class="info-card bg-info" style="box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">
                <span class="info-box-icon"><i class="fas fa-hand-holding-heart" style="color: orange;"></i></i></span>
                <div class="info-box-content">
                
                    <a href="https://uat-fdh.inet.co.th/hospital/detail" target="_blank">FDH-UAT</a></br>
                    <a href="https://fdh.moph.go.th/hospital/" target="_blank">FDH-Production</a><br>
                    <a href="https://docs.google.com/document/d/1B9IJPh0SKGytnCm1godY1ijeNxRmXlxCJJ-CsQUwRQI/" target="_blank">คู่มือ API</a>--
                    
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


                   <a href="<?= \yii\helpers\Url::to(['fdhhomeward/index']) ?>" 
					   class="btn"
					   style="
						   background-color: #fff3cd;
						   color: #856404;
						   border: 2px solid #ffeeba;
						   border-radius: 25px;
						   font-size: 16px;
						   font-weight: bold;
						   padding: 10px 20px;
						   box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
						   transition: all 0.3s ease;
					   "
					   target="_blank">
					   Query <i class="fa fa-arrow-circle-right"></i>
					</a>

                </div>
            </div>
        </div>
 <div class="col-xl-4 col-md-3 mb-3">
    <div class="info-card text-dark"
         style="
            background: linear-gradient(to right, #add8e6, #e0ffff);
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
            <!-- <input name="btnButton1" class="btn btn-success btn btn-block" id="selectAll" type="submit" name="selectAll" value="ส่งข้อมูล FDH Home-Ward " style="background-color: #b605cf; border: 4px solid #dadada;"> -->
        </div>
        <div style="height: 700px; overflow-y: auto;">
        <div id="loading-spinner" style="display: none;">
            <!-- Customize the style as needed -->
            <div class="custom-spinner"></div>
        </div>
		
			<?= Html::beginForm(['f16homeward/data'], 'post', ['name' => 'frmMain']); ?>
			
				 <!-- Hidden fields สำหรับเก็บวันที่ -->
			<?= Html::hiddenInput('date1', $date1) ?>
			<?= Html::hiddenInput('date2', $date2) ?>  
		<?php
			$allowedUsers = [6, 29 , 96, 289, 383];  
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
						ส่งข้อมูล IP-HomeWard
					</button>
				</div>
			<?php endif; ?>
			


<!--<input name="btnButton1" class="btn btn-success btn btn-block" id="selectAll" type="submit" name="selectAll" value="ส่งข้อมูล FDH Home-Ward" style="background-color: #00a400; border: 4px solid #dadada;">-->

          <table class="table my-striped-table" width="1000" border="0" bordercolor="#ddd" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
                <div align="center">
                    <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);">
                </div>
            </th>
            <th width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
                <div align="center"> # </div>
            </th>
            <th width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
                <div align="center" style="font-size: 14px;"> วันAdmit </div>
            </th>
            <th width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
                <div align="center" style="font-size: 14px;"> วันDSC </div>
            </th>
            <th width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
                <div align="center" style="font-size: 14px;"> An </div>
            </th>
            <th width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
                <div align="left" style="font-size: 14px;"> Hn </div>
            </th>
            <th width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
                <div align="left" style="font-size: 14px;"> Visits </div>
            </th>
            <th width="150" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
                <div align="left" style="font-size: 14px;"> ชื่อ-สกุล </div>
            </th>
            <th width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
                <div align="left" style="font-size: 14px;">อายุ </div>
            </th>
            <th width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
                <div align="left" style="font-size: 14px;">แผนก </div>
            </th>
            <th width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
                <div align="left" style="font-size: 14px;">โรคหลัก </div>
            </th>
            <th width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
                <div align="left" style="font-size: 14px;">รหัสโรค </div>
            </th>
            <th width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
                <div align="left" class="text-nowrap" style="font-size: 14px;"> สิทธิ์ </div>
            </th>
            <th width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
                <div align="left" style="font-size: 14px;">สถานหลัก </div>
            </th>
            <th width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
                <div align="left" style="font-size: 14px;">สถานรอง </div>
            </th>
            <th width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
                <div align="left" style="font-size: 14px;">ค่ารักษา </div>
            </th>
			 <th width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
                <div align="left" style="font-size: 14px;">สถานะ </div>
            </th>
            <th width="30" style="background-color: lightgray; position: sticky; top: 0; z-index: 1;">
                <div align="left" style="font-size: 14px;">Claim </div>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dataProvider->getModels() as $key => $value) : ?>
        <tr style="background-color: <?php echo (empty($value['messagecode']) ? '#F2DEF9' : '#daf7ef'); ?>;">
            <td><input type="checkbox" name="chkDel[]"  id="chkDel<?= $key; ?>" value="<?php echo $value["visit_id"] . $value["an"]; ?>"style="width: 17px; height: 17px;"></td>
            <td class="badge"><?php echo  $value["No"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["regdate"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["dsc"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px; color: #009b00; box-shadow: 0 0 10px rgba(0, 155, 0, 0.5); border-radius: 5px; padding: 5px;">
                <?php echo $value["an"]; ?>
            </td>
            <td style="font-size: 14px;"><?php echo $value["hn"]; ?></td>
            <td style="font-size: 14px;"><?php echo $value["visit_id"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["fullname"]; ?></td>
            <td style="font-size: 14px;"><?php echo $value["age"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["unit_name"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["Diagx"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["Diag"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["inscl"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["hospmain"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["hospsub"]; ?></td>
			<td class="text-nowrap" style="font-size: 14px; color: orange;"><?php echo $value["amount"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["messagecode"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["claimcode"]; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    function ClickCheckAll(vol) {
        var i;
        for (i = 0; i < document.frmMain.elements.length; i++) {
            if (document.frmMain.elements[i].name == "chkDel[]") {
                document.frmMain.elements[i].checked = vol.checked;
            }
        }
    }

    // Function to handle form submission with row processing
    document.querySelector('form[name="frmMain"]').addEventListener('submit', function(event) {
        var rows = document.querySelectorAll('table.table-striped tr');
        var checkedRows = document.querySelectorAll('input[name="chkDel[]"]:checked');
        var count = checkedRows.length;
        var scrollContainer = document.getElementById('scrollContainer');

        if (count > 0) {
            var currentIndex = 0;

            function processRow() {
                if (currentIndex < count) {
                    var row = checkedRows[currentIndex].closest('tr');
                    var originalBackgroundColor = row.style.backgroundColor;
                    row.style.backgroundColor = '#F8B6F6'; // Set processing background color

                    // Scroll the row into view
                    row.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'nearest' });

                    // Simulate API call or other processing
                    setTimeout(function() {
                        // Example: Update row style back to original color
                        row.style.backgroundColor = originalBackgroundColor;

                        // Move to the next row
                        currentIndex++;
                        processRow();
                    }, 1000); // Simulate delay for demonstration
                } else {
                    // Finish processing
                   // alert('API ตรวจสอบข้อมูลเรียบร้อย.');

                    // Submit the form
                    document.frmMain.submit();
                }
            }

            // Start processing rows
            processRow();
        } else {
            // No rows selected
            alert('Please select rows to process.');
        }

        // Prevent form submission
        event.preventDefault();
    });
</script>
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
<div id="model1" style="display: none; background: linear-gradient(45deg, #a8e6cf, #dcedc1); padding: 20px; border-radius: 10px;">
    <h2 style="color: #155724; border: 2px solid #c3e6cb; padding: 5px; background: #dcedc1;">แสดงรายการผ่าน</h2>

    <div class="table-wrapper" style="background: linear-gradient(45deg, #a8e6cf, #dcedc1); padding: 20px; border-radius: 10px;">
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $passProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'visit_id',
                'an',
                'users',
                'response',
                'd_update',
            ],
            'tableOptions' => [
                'class' => 'table table-striped',
                'style' => 'border: 1px solid #dee2e6; box-shadow: 0px 2px 10px rgba(0,0,0,0.1); border-radius: 10px;',
            ],
            'headerRowOptions' => ['style' => 'background: linear-gradient(45deg, #a8e6cf, #dcedc1);'],
			'rowOptions' => ['style' => 'background: linear-gradient(45deg, #ffffcc, #fff3e6);'],


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
    'dataProvider' => $errorProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'visit_id',
        'an',
        'users',
        'response',
        'd_update',
    ],
    'tableOptions' => [
        'class' => 'table table-striped',
        'style' => 'border: 1px solid #dee2e6; box-shadow: 0px 2px 10px rgba(0,0,0,0.1); border-radius: 10px;'
    ],
    'headerRowOptions' => ['style' => 'background-color: #ffcccc;'], // สีแดงอ่อนใน header
    'rowOptions' => ['style' => 'background-color: #ffb3b3;'], // สีแดงอ่อนในแถว
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
