<?php

namespace app\controllers;

use Yii;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\editable\Editable;
use yii\widgets\Pjax;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use dosamigos\datepicker\DatePicker;


$this->title = 'ตรวจสอบสถานะการเคลม ผู้ป่วยในรายที่ยังส่งไม่ครบ สิทธิประกันสุขภาพถ้วนหน้า';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['rep/index']];
//$this->params['breadcrumbs'][] = 'รายงานข้อมูลE-Claim แยกตามREP';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@iconify/iconify@latest/dist/iconify.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>Dose1</title>

</head>

<body>
    <!--         
    <script type="text/javascript">
    setTimeout("frmMain.submit();",8000);
    //5000 อยากได้เร็วก็กำหนดตัวเลขน้อยๆเอานะ
    </script> -->

    <style>
    /* Custom Spinner */
    .custom-spinner {
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid purple; /* Purple */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 1s linear infinite;
    }

    /* Spinner Animation */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Loading Spinner (fixed position) */
    #loading-spinner {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
    }

    /* Table container with scroll */
    .table-container {
        max-height: 400px; /* Set max height for scrolling */
        overflow-y: auto; /* Enable vertical scrolling */
        display: block;
    }

    /* Table styling */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    /* Sticky header for the first row */
    th, td {
        padding: 8px;
        text-align: center;
    }

    /* Stick both the first row and the header row */
    .table-header, th {
        position: sticky;
        top: 0;
        background-color: lightgray;
        z-index: 10; /* Ensure they stay on top */
    }

    .table-header {
        background-color: lightgray;
        z-index: 15; /* Ensure this row is on top of the table */
    }
</style>

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
                    <span class="info-box-text" style="color: green; font-size: 18px;">ผ่านตามเงื่อนไขวันนี้</span>
                    <span class="info-box-number"><?php echo $amount ?></span>
                </div>
                <!-- /.info-box-content -->
                <!-- <a href="<?= \yii\helpers\Url::to(['/log/dt']) ?>" target="_blank" class="info-box-more"> -->
                <div style="text-align: right;">
                    <div style="text-align: right;">
                        <?= Html::a('<i class="fa fa-check-square" aria-hidden="true"></i> ผ่าน', null, ['class' => 'btn btn-success', 'id' => 'link1']) ?>
                        <img src="images/accept.svg" title="ข้อมูลสำเร็จ" width="70" height="60">
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
                    <span class="info-box-text" style="color: red; font-size: 18px;">ไม่ผ่านตามเงื่อนไข</span>
                    <span class="info-box-number"><?php echo $amountx ?></span>

                </div>

                <div style="text-align: right;">
                    <?= Html::a('<i class="fa fa-ban" aria-hidden="true"></i> ไม่ผ่าน', null, ['class' => 'btn btn-danger', 'id' => 'link2']) ?>
                    <?= Html::a(
                        '<i class="fa fa-trash" aria-hidden="true"></i> ลบ', // ชื่อปุ่ม
                        ['delete-specific'],       // เส้นทางไปยัง actionDeleteSpecific
                        [
                            'class' => 'btn btn-danger', // เพิ่มสไตล์ปุ่ม
                            'data' => [
                                'confirm' => 'คุณแน่ใจหรือไม่ว่าต้องการลบ 10 รายการที่ไม่สำเร็จ?', // การยืนยันก่อนลบ
                                'method' => 'post', // ใช้ POST เพื่อความปลอดภัย
                            ],
                        ]
                    ); ?>
                    <img src="images/reject.76840914.svg" title="ไม่ผ่าน" width="70" height="60">
                </div>
                </a>
            </div>
        </div>


        <div class="col-xl-3 col-md-3 mb-3">
            <div class="info-box bg-success" style="box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">
                <span class="info-box-icon"><i class="fas fa-hand-holding-heart" style="color: orange;"></i></i></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="color: orange; font-size: 18px;">รายการส่งผ่านทั้งหมด</span>
                    <span class="info-box-number"><?php echo $total ?></span>
                </div>
                <!-- ปุ่มที่เปิด modal -->

                <div style="text-align: right;">
                    <a href="<?= Url::to(['checkipd/run-curl']) ?>" class="btn btn-info" style="font-size: 16px;">
                        RunToken <i class="fa fa-arrow-circle-right"></i>
                    </a>
                    <img src="images/waitmoph.98529de4.svg" title="ยอดทั้งหมด" width="70" height="60">
                </div>
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-xl-3 col-md-3 mb-3">
            <div class="info-card bg-info" style="box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3); width: 350px; height: 140px;">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <?php $form = ActiveForm::begin(['action' => ['checkipd/index']]); ?>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">วันที่:</label>
                                <div class="col-sm-7">
                                    <?= DatePicker::widget([
                                        'name' => 'date1',
										'value' => $date1 ? $date1 : date('Y-m-d', strtotime('-1 month')),
                                       // 'value' => $date1,
                                        'language' => 'th',
                                        'clientOptions' => [
                                            'autoclose' => true,
                                            'format' => 'yyyy-mm-dd',
                                            'todayHighlight' => true,
                                        ],
                                        'options' => [
                                            'class' => 'form-control',
                                            'placeholder' => 'เลือกวันที่เริ่มต้น',
                                        ],
                                    ]); ?>
                                </div>

                                <label class="col-sm-3 col-form-label text-right">ถึง:</label>
                                <div class="col-sm-7">
                                    <?= DatePicker::widget([
                                        'name' => 'date2',
										'value' => $date2 ? $date2 : date('Y-m-d'),
                                        //'value' => $date2,
                                        'language' => 'th',
                                        'clientOptions' => [
                                            'autoclose' => true,
                                            'format' => 'yyyy-mm-dd',
                                            'todayHighlight' => true,
                                        ],
                                        'options' => [
                                            'class' => 'form-control',
                                            'placeholder' => 'เลือกวันที่สิ้นสุด',
                                        ],
                                    ]); ?>
                                </div>
                                <button class="btn btn-danger">ตกลง</button>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="height: 400px; overflow-y: auto;">
        <div id="loading-spinner" style="display: none; color: purple; font-size: 100px;">
            <!-- Customize the style as needed -->
            <div class="custom-spinner"></div>
        </div>

        <?= Html::beginForm(['checkipd/check'], 'post', ['name' => 'frmMain']); ?>

        <input name="btnButton1" class="btn btn-success btn btn-block" id="selectAll" type="submit" value="Check API Visits" style="background-color: green; border: 4px solid #dadada;">

        <table class="table table-striped" width="1000" border="0">
            <tr>
                <th width="30" style="background-color: lightgray;">
                    <div align="center">
                        <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);">
                    </div>
                </th>
                <td width="30" style="background-color: lightgray;">
                    <div align="center"> # </div>
                </td>
                <td width="30" style="background-color: lightgray;">
                    <div align="center" style="font-size: 14px;"> วันที่ </div>
                </td>
                <td width="30" style="background-color: lightgray;">
                    <div align="center" style="font-size: 14px;"> Visit </div>
                </td>
                <td width="30" style="background-color: lightgray;">
                    <div align="left" style="font-size: 14px;"> Hn </div>
                </td>
                <td width="30" style="background-color: lightgray;">
                    <div align="left" style="font-size: 14px;"> An </div>
                </td>
                <td width="150" style="background-color: lightgray;">
                    <div align="left" style="font-size: 14px;"> Response </div>
                </td>
				<td width="70" style="background-color: lightgray;">
                    <div align="left" style="font-size: 14px;">หอผู้ป่วย </div>
                </td>
                <td width="70" style="background-color: lightgray;">
                    <div align="left" style="font-size: 14px;">กองทุน </div>
                </td>
                <td width="30" style="background-color: lightgray;">
                    <div align="left" class="text-nowrap" style="font-size: 14px;"> status </div>
                </td>
            </tr>
            <?php foreach ($visitProvider->getModels() as $key => $value) : ?>
                <tr>
                    <td><input type="checkbox" name="chkDel[]" id="chkDel<?= $key; ?>" value="<?= $value["visit_id"]. $value["an"] . $value["pid"]; ?>"></td>
                    <td class="badge"><?= $value["No"]; ?></td>
                    <td class="text-nowrap" style="font-size: 14px;"><?= $value["dsc_dt"]; ?></td>
                    <td style="font-size: 14px;"><?= $value["visit_id"]; ?></td>
                    <td style="font-size: 14px;"><?= $value["pid"]; ?></td>
                    <td style="font-size: 14px;"><?= $value["an"]; ?></td>
                    <td class="text-nowrap" style="font-size: 14px;"><?= $value["messagecode"]; ?></td>
					<td class="text-nowrap" style="font-size: 14px;"><?= $value["unit_name"]; ?></td>
                    <td class="text-nowrap" style="font-size: 14px;"><?= $value["users"]; ?></td>
                    <td class="text-nowrap" style="font-size: 14px;"><?= $value["messages"]; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="box-footer with-border">
            <div class="col-md-12">
                <div class="form-group">
                    <!-- Add any additional buttons or form elements here -->
                </div>
            </div>
        </div>

        <?= Html::endForm(); ?>
        <!-- ############################################ -->
		<p>
    <?= Html::a('⏪ กลับหน้าหลัก', ['checkopd/index3'], [
        'class' => 'btn btn-custom'
    ]) ?>
</p>

<?php
$this->registerCss("
    .btn-custom {
        background: linear-gradient(to bottom, #28a745, #218838);
        border: 2px solid #fff;
        border-radius: 10px;
        color: white;
        font-size: 18px;
        font-weight: bold;
        padding: 10px 20px;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease-in-out;
    }
    
    .btn-custom:hover {
        background: linear-gradient(to bottom, #218838, #1e7e34);
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.5);
        transform: scale(1.05);
    }
");
?>

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

        if (count > 0) {
            var currentIndex = 0;

            function processRow() {
                if (currentIndex < count) {
                    var row = checkedRows[currentIndex].closest('tr');
                    var originalBackgroundColor = row.style.backgroundColor;
                    row.style.backgroundColor = '#F8B6F6'; // Set processing background color
                    row.scrollIntoView({ behavior: 'smooth', block: 'center' }); // Scroll to the row

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


        <!-- ################################################################################### -->


        <script>
            function ClickCheckAll(vol) {
                var i;
                for (i = 0; i < document.frmMain.elements.length; i++) {
                    if (document.frmMain.elements[i].name == "chkDel[]") {
                        document.frmMain.elements[i].checked = vol.checked;
                    }
                }
            }
        </script>





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
                    'class' => 'table table-striped',
                    'style' => 'border: 1px solid #dee2e6; box-shadow: 0px 2px 10px rgba(0,0,0,0.1); border-radius: 10px;'
                ],
                'headerRowOptions' => ['style' => 'background-color: #009700;'],
                'rowOptions' => ['style' => 'background-color: lightgreen;'],
            ]); ?>

        </div>

        <!-- ############################## ERROR ################################################################# -->
        <div id="model2" style="display: none;">
            <?php
            echo Html::beginForm(['checkipd/delete-multiple'], 'post'); // เริ่มต้นฟอร์ม POST สำหรับ multi-delete
            echo \yii\grid\GridView::widget([
                'dataProvider' => $errorProvider,
                'columns' => [

                    ['class' => 'yii\grid\SerialColumn'], // หมายเลขแถว
                    'visit_id',
                    'pid',
                    'users',
                    'response',
                    'd_update',

                    [
                        'class' => CheckboxColumn::class,
                        'checkboxOptions' => function ($model) {
                            return ['value' => $model['id']]; // ใช้ id จาก model เป็นค่า checkbox
                        },
                    ],
                    [
                        'class' => ActionColumn::class,
                        'template' => '{delete}', // กำหนดปุ่มใน ActionColumn
                        'buttons' => [
                            'delete' => function ($url, $model, $key) {
                                return Html::a(
                                    '<span class="glyphicon glyphicon-trash"></span>',
                                    ['delete', 'id' => $model['id']],
                                    [
                                        'data' => [
                                            'confirm' => 'คุณแน่ใจหรือไม่ว่าต้องการลบรายการนี้?',
                                            'method' => 'post',
                                        ],
                                    ]
                                );
                            },
                        ],
                    ],
                ],
                'tableOptions' => [
                    'class' => 'table table-striped',
                    'style' => 'border: 1px solid #dee2e6; box-shadow: 0px 2px 10px rgba(0,0,0,0.1); border-radius: 10px;',
                ],
                'headerRowOptions' => ['style' => 'background-color: #ff5eae;'],
                'rowOptions' => ['style' => 'background-color: lightred;'],
            ]);

            // ปุ่มสำหรับลบรายการที่เลือก
            echo Html::submitButton('ลบรายการที่เลือก', [
                'class' => 'btn btn-danger',
                'data-confirm' => 'คุณแน่ใจหรือไม่ว่าต้องการลบรายการที่เลือก?',
                'data-method' => 'post',
            ]);

            echo Html::endForm(); // จบฟอร์ม POST
            ?>
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
		