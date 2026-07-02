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




$this->title = 'FDH-Health Rider';
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
        background-color: #f5f5f5;
        /* สีที่ต้องการเมื่อ hover */
    }
</style>

<body>
    <!--     
    <script type="text/javascript">
    setTimeout("frmMain.submit();",50000);
    //5000 อยากได้เร็วก็กำหนดตัวเลขน้อยๆเอานะ
    </script> -->
<style>
    /* ตารางเลื่อนแนวตั้งและตรึงหัวตาราง */
    .scroll-table-container {
        max-height: calc(15 * 40px); /* สูงประมาณ 15 แถว */
        overflow-y: auto;
        border: 1px solid #ddd;
    }

    .scroll-table-container table {
        width: 100%;
        border-collapse: collapse;
        font-weight: normal; /* ไม่หนาทั้งตาราง */
    }

    .scroll-table-container th {
        position: sticky;
        top: 0;
        background-color: #00d6e1;
        color: white;
        z-index: 1;
        text-align: left;
        padding: 8px;
        font-size: 14px;
        font-weight: normal;
    }

    .scroll-table-container td {
        padding: 8px;
        font-size: 14px;
        font-weight: normal;
    }

    .scroll-table-container .badge {
        font-weight: normal;
    }

    /* สีพื้นเขียวอ่อน */
    .visit-element {
        background-color: lightgreen;
        padding: 5px;
        margin-bottom: 5px;
    }

    /* พาแนลกำหนดสี */
    .panel-custom {
        background-color: #2f1c00;
        max-height: 200px;
        overflow-y: auto;
    }

    .panel-custom .panel-heading,
    .panel-custom .panel-body {
        color: #00aaff;
    }

    .panel-body {
        padding: 10px;
    }

    /* Spinner โหลด */
    .custom-spinner {
        border: 16px solid #f3f3f3;
        border-top: 16px solid purple;
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Block โค้ด */
    .code-block {
        font-family: "Courier New", Courier, monospace;
        background-color: #f5f5f5;
        padding: 10px;
        border: 1px solid #ddd;
    }

    /* Card แสดงข้อมูล */
    .info-card {
        background: linear-gradient(45deg, #add8e6, #e0ffff);
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);
        color: #000;
        padding: 20px;
        border-radius: 10px;
        font-size: 16px;
    }

    /* Spinner โหลดอยู่ตรงกลางจอ */
    #loading-spinner {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
    }

    /* Hover ตาราง */
    .my-striped-table tbody tr:hover {
        background-color: rgba(144, 238, 144, 0.5);
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
            <div class="info-card bg-info" style="box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">
                <span class="info-box-icon"><i class="fa-sharp fa-solid fa-compass" style="color: red;"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="color: red; font-size: 14px;">จัดการ Token</span>
                    <span class="info-box-number"> 0</span>

                </div>

               <div style="text-align: right;">
                <a href="<?= Url::to(['f16rider/run-curl', 'date1' => $date1, 'date2' => $date2]) ?>" 
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
            <div class="info-card bg-info" style="box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">
                <span class="info-box-icon"><i class="fas fa-hand-holding-heart" style="color: orange;"></i></i></span>
                <div class="info-box-content">

                    <!-- <span class="info-box-number" style="color: green; font-size: 18px;">ลิงค์เข้าเว็บ FDH</span> -->

                    <a href="https://uat-fdh.inet.co.th/hospital/detail" target="_blank">FDH-UAT</a><br>
                    <a href="https://fdh.moph.go.th/hospital/" target="_blank">FDH-Production</a><br>
                    <a href="https://docs.google.com/document/d/1B9IJPh0SKGytnCm1godY1ijeNxRmXlxCJJ-CsQUwRQI/" target="_blank">คู่มือ API</a>--


                    <script>
                        function openPopup() {
                            const url = "<?= \yii\helpers\Url::to(['f16rider/exportexcel']); ?>"; // ลิงก์ไปยังไฟล์ Excel
                            const popupWindow = window.open(url, 'ExcelPopup', 'width=600,height=400'); // สร้างหน้าต่างป๊อปอัป
                            popupWindow.focus(); // โฟกัสไปยังป๊อปอัป
                        }
                    </script>

                    <a href="<?= \yii\helpers\Url::to(['fdhrider/index']) ?>" class="btn btn-warning modalLink" style="font-size: 16px;" target="_blank">
                        Query <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3 mb-3">
            <div class="info-card bg-info" style="box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3); width: 350px; height: 140px;">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-3">
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
</div>
		</div>
    </div>
	<style>
.custom-spinner {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid purple; /* Purple */
  border-radius: 50%;
  width: 80px;
  height: 80px;
  animation: spin 2s linear infinite;
  margin: auto;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
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
    <!-- ############################################ Grid View ######################################################################## -->
    <div class="page-container">
        <div class="fixed-header">
            <!-- <input name="btnButton1" class="btn btn-success btn btn-block" id="selectAll" type="submit" name="selectAll" value="ส่งข้อมูล FDH OPD" style="background-color: #007100; border: 4px solid #dadada;"> -->
        </div>
        <div style="height: 400px; overflow-y: auto;">
            <div id="loading-spinner" style="display: none; color: purple; font-size: 100px;">
                <!-- Customize the style as needed -->
                <div class="custom-spinner"></div>
            </div>

            <?= Html::beginForm(['f16rider/data'], 'post', ['name' => 'frmMain']); ?>
			<?= Html::hiddenInput('date1', $date1) ?>
			<?= Html::hiddenInput('date2', $date2) ?>
			
			  <div class="floating-button" style="position: fixed; bottom: calc(2 * 2rem); left: 55%; transform: translateX(-45%); z-index: 1000;">
		<button type="submit" 
				name="btnButton1" 
				id="selectAll" 
				class="btn btn-success btn btn-block" 
				style="background-color: #00a400; border: 4px solid #dadada; padding: 10px 20px; border-radius: 30px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); font-size: 1.5rem; text-transform: uppercase; cursor: pointer; width: auto;">
			<i class="fa fa-arrow-circle-right" style="margin-right: 10px;"></i>
			ส่งข้อมูล Rider
		</button>
	</div>

            <!-- <form id="checkbo" name="frmMain" action="index" method="post"> -->
    <style>
    .normal-font {
        font-weight: normal !important;
        font-family: Tahoma, Arial, Kanit, sans-serif;
        font-size: 14px;
    }
   </style>

            <table class="table my-striped-table" width="1000" border="1" bordercolor="#ddd" style="border-collapse: collapse;position: sticky; top: 0; z-index: 1;">

                <td width="30" style="background-color: #00d6e1; color: #FFFFFF; position: sticky; top: 0; z-index: 1;">
                    <div align="center">
                        <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);">

                    </div>
                <td width="30" style="background-color: #00d6e1; color: #FFFFFF; position: sticky; top: 0; z-index: 1;">
                    <div align="center"> # </div>
                </td>
                <td width="30" style="background-color: #00d6e1; color: #FFFFFF;position: sticky; top: 0; z-index: 1;">
                    <div align="center" style="font-size: 14px;"> วันที่ </div>
                </td>
                <td width="30" style="background-color: #00d6e1; color: #FFFFFF;position: sticky; top: 0; z-index: 1;">
                    <div align="center" style="font-size: 14px;"> เลขบริการ </div>
                </td>
                <td width="30" style="background-color: #00d6e1; color: #FFFFFF;position: sticky; top: 0; z-index: 1;">
                    <div align="left" style="font-size: 14px;"> Hn </div>
                </td>
               
                <td width="30" style="background-color: #00d6e1; color: #FFFFFF;position: sticky; top: 0; z-index: 1;">
                    <div align="left" style="font-size: 14px;"> ชื่อ-สกุล </div>
                </td>
                <td width="30" style="background-color: #00d6e1; color: #FFFFFF;position: sticky; top: 0; z-index: 1;">
                    <div align="left" style="font-size: 14px;">อายุ </div>
                </td>
                <td width="30" style="background-color: #00d6e1; color: #FFFFFF;position: sticky; top: 0; z-index: 1;">
                    <div align="left" style="font-size: 14px;">แผนก </div>
                </td>
                <td width="30" style="background-color: #00d6e1; color: #FFFFFF;position: sticky; top: 0; z-index: 1;">
                    <div align="left" style="font-size: 14px;">โรคหลัก </div>
                </td>
                <td width="30" style="background-color: #00d6e1; color: #FFFFFF;position: sticky; top: 0; z-index: 1;">
                    <div align="left" style="font-size: 14px;">รหัสโรค </div>
                </td>
                <td width="30" style="background-color: #00d6e1; color: #FFFFFF;position: sticky; top: 0; z-index: 1;">
                    <div align="left" class="text-nowrap" style="font-size: 14px;"> สิทธิ์ </div>
                </td>
               
                <td width="30" style="background-color: #00d6e1; color: #FFFFFF;position: sticky; top: 0; z-index: 1;">
                    <div align="left" style="font-size: 14px;">สถานะ
                </td>
                <td width="30" style="background-color: #00d6e1; color: #FFFFFF;position: sticky; top: 0; z-index: 1;">
                    <div align="left" style="font-size: 14px;">สถานหลัก
                </td>

                <td width="30" style="background-color: #00d6e1; color: #FFFFFF;position: sticky; top: 0; z-index: 1;">
                    <div align="left" style="font-size: 14px;">authen
                </td>
				<td width="30" style="background-color: #00d6e1; color: #FFFFFF;position: sticky; top: 0; z-index: 1;">
                    <div align="left" style="font-size: 14px;">ปิดสิทธิ์
                </td>
               
                </tr>

                <?php foreach ($dataProvider->getModels() as $key => $value) : ?>
					
                    <tr style="background-color: <?= empty($value['messagecode']) ? '#f7edfa' : '#edf2f0'; ?>; font-weight: normal; font-family: Tahoma, Arial, Kanit, sans-serif; font-size: 14px;">

                        <td><input type="checkbox" name="chkDel[]"  id="chkDel<?= $key; ?>" value="<?php echo $value["visit_id"] . $value["hn"]; ?>"></td>
                        <td class="badge"><?php echo $value["No"]; ?></td>
                        <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["regdate"]; ?></td>
                        <td style="font-size: 14px;"><?php echo $value["visit_id"]; ?></td>
						<?php
						// ตรวจสอบว่า hn นี้อยู่ในรายการซ้ำหรือไม่
						$isDup = in_array($value['hn'], array_column($dupHns, 'hn'));
						$fontColor = $isDup ? 'red' : 'black';
					?>
					<td style="font-size: 14px; color: <?= $fontColor ?>;">
						<?= $value["hn"]; ?>
					</td>
                    
                        <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["fullname"]; ?></td>
                        <td style="font-size: 14px;"><?php echo $value["age"]; ?></td>
                        <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["unit_name"]; ?></td>
                        <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["Diagx"]; ?></td>
                        <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["Diag"]; ?></td>
                        <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["inscl"]; ?></td>
                        <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["messagecode"]; ?></td>
                        <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["hospmain"]; ?></td>
                        <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["claimcode"]; ?></td>
						<td class="text-nowrap" style="font-size: 14px;"><?php echo $value["endpoint"]; ?></td>
                        
                    </tr>
                <?php endforeach; ?>


            </table>
        </div>
		<br>
<?php if (!empty($dupHns)) : ?>
   <p style="color: red; font-weight: bold;">HN ซ้ำ:</p>
    <ul>
        <?php foreach ($dupHns as $dup): ?>
          <li style="color: darkorange;">
    <?= $dup['hn'] ?> (<?= $dup['count_hn'] ?> ครั้ง)
</li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p style="color: green;">ไม่พบ HN ซ้ำ</p>
<?php endif; ?>


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
                  //  alert('API ตรวจสอบข้อมูลเรียบร้อย.');

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

<!-- ################################################################################### -->
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
            <h2 style="color: #155724; border: 2px solid #c3e6cb; padding: 5px;">แสดงรายการผ่าน</h2>

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

                    // 'tableOptions' => [
                    //     'class' => 'table table-striped table-hover custom-hover',
                    //     'style' => 'border: 1px solid #dee2e6; box-shadow: 0px 2px 10px rgba(0,0,0,0.1); border-radius: 10px;',
                    // ],
                    'tableOptions' => [
                        'class' => 'table table-striped table-hover custom-hover', // ใช้คลาสของ Bootstrap และคลาสที่กำหนดเอง
                        'style' => 'width: 100%; cellspacing: 1;', // ใช้ style แทนที่จะใช้ cellspacing เป็น attribute
                    ],
                    'headerRowOptions' => ['style' => 'background-color: lightgray;'],
                    'rowOptions' => ['style' => 'background-color: #e4e4e4;'],
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
                'tableOptions' => [
                    'class' => 'table table-striped',
                    'style' => 'border: 1px solid #dee2e6; box-shadow: 0px 2px 10px rgba(0,0,0,0.1); border-radius: 10px;'
                ],
                'headerRowOptions' => ['style' => 'background-color: #ff5eae;'],
                'rowOptions' => ['style' => 'background-color: lightred;'],
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