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


$this->title = 'ตรวจสอบสถานะการเคลม ผู้ป่วยนอก สิทธิประกันสุขภาพถ้วนหน้า';
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
        #loading-spinner {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
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
        <div class="info-card bg-info" style="box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">
            <span class="info-box-icon"><i class="far fa-calendar-check" style="color: green;"></i></span>
            <div class="info-box-content">
                <span class="info-box-text" style="color: green; font-size: 18px;">ผ่านตามเงื่อนไขวันนี้</span>
                <span class="info-box-number"><?php echo $amount ?></span>
            </div>
            <div style="text-align: right;">
                <div style="text-align: right;">
                    <?= Html::a('<i class="fa fa-check-square" aria-hidden="true"></i> ผ่าน', null, ['class' => 'btn btn-success', 'id' => 'link1']) ?>
                    <img src="images/accept.svg" title="ข้อมูลสำเร็จ" width="70" height="60">
                </div>
            </div>
        </div>
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
                    '<i class="fa fa-trash" aria-hidden="true"></i> ลบ', 
                    ['delete-specific'],       
                    [
                        'class' => 'btn btn-danger', 
                        'data' => [
                            'confirm' => 'คุณแน่ใจหรือไม่ว่าต้องการลบ 10 รายการที่ไม่สำเร็จ?', 
                            'method' => 'post', 
                        ],
                    ]
                ); ?>
                <img src="images/reject.76840914.svg" title="ไม่ผ่าน" width="70" height="60">
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-3 mb-3">
        <div class="info-box bg-success" style="box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">
            <span class="info-box-icon"><i class="fas fa-hand-holding-heart" style="color: orange;"></i></span>
            <div class="info-box-content">
                <span class="info-box-text" style="color: orange; font-size: 18px;">รายการส่งผ่านทั้งหมด</span>
                <span class="info-box-number"><?php echo $total ?></span>
            </div>
            <div style="text-align: right;">
                <a href="<?= Url::to(['closevisit/run-curl']) ?>" class="btn btn-info" style="font-size: 16px;">
                    RunToken <i class="fa fa-arrow-circle-right"></i>
                </a>
                <img src="images/waitmoph.98529de4.svg" title="ยอดทั้งหมด" width="70" height="60">
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-3 mb-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <?php $form = ActiveForm::begin(['action' => ['checkopd/index'], 'method' => 'get']); ?>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label text-right">วันที่:</label>
                        <div class="col-sm-7">
                            <?= DatePicker::widget([
                                'name' => 'date1',
                                'value' => $date1 ? $date1 : date('Y-m-d', strtotime('-1 month')),
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
                    </div>
                    <button class="btn btn-danger">ตกลง</button>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="height: 400px; overflow-y: auto;">
    <div id="loading-spinner" style="display: none; color: purple; font-size: 100px;">
        <div class="custom-spinner"></div>
    </div>

    <?= Html::beginForm(['checkopd/check'], 'post', ['name' => 'frmMain']); ?>

    <div style="padding: 15px; background: linear-gradient(to right, #d4f4e8, #b0e2d6); border: 1px solid #ddd; margin-bottom: 20px; display: flex; align-items: center; gap: 15px;">
        <label style="font-size: 18px; white-space: nowrap;">เลือกแสดง:</label>

        <div style="display: flex; align-items: center; gap: 5px;">
            <input type="radio" name="alls" id="all" value="0" <?= isset($_POST['alls']) && $_POST['alls'] == "0" ? 'checked' : '' ?> required>
            <label for="all">ทั้งหมด</label>
        </div>

        <div style="display: flex; align-items: center; gap: 5px;">
            <input type="radio" name="alls" id="nopass" value="1" <?= isset($_POST['alls']) && $_POST['alls'] == "1" ? 'checked' : '' ?> required>
            <label for="nopass">รายการไม่ผ่าน</label>
        </div>
    </div>

    <input name="btnButton1" class="btn btn-success btn btn-block" id="selectAll" type="submit" name="selectAll" value="Check API Visits" style="background-color: #fb5200; border: 4px solid #dadada;">
</div>


    <table class="table table-striped" width="1000" border="0">
        <tr>
            <th width="30" style="background-color: lightgray;">
                <div align="center">
                    <!-- <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);"> -->
                    <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);">
                    <!-- <input type="checkbox" id="selectAll"> -->
                </div>
            <td width="30" style="background-color: lightgray;">
                <div align="center"> # </div>
            </td>
            <td width="30" style="background-color: lightgray;">
                <div align="center" style="font-size: 14px;"> วันที่ส่ง </div>
            </td>
            <td width="30" style="background-color: lightgray;">
                <div align="center" style="font-size: 14px;"> Visit </div>
            </td>
            <td width="30" style="background-color: lightgray;">
                <div align="left" style="font-size: 14px;"> Hn </div>
            </td>
            <!-- <td width="150" style="background-color: lightgray;">
                <div align="left" style="font-size: 14px;"> Response </div>
            </td> -->
            <td width="70" style="background-color: lightgray;">
                <div align="left" style="font-size: 14px;">กองทุน </div>
            </td>
			<td width="30" style="background-color: lightgray;">
                <div align="left" class="text-nowrap" style="font-size: 14px;"> response </div>
            </td>
            <td width="30" style="background-color: lightgray;">
                <div align="left" class="text-nowrap" style="font-size: 14px;"> status </div>
            </td>
            <td width="30" style="background-color: lightgray;">
                <div align="left" style="font-size: 14px;">messages </div>
            </td>
        </tr>
        <?php
        foreach ($visitProvider->getModels() as $key => $value) :
        ?>
            <tr>

                <td><input type="checkbox" name="chkDel[]"  id="chkDel<?= $i; ?>" value="<?php echo $value["visit_id"]; ?><?php echo $value["pid"]; ?>">
                <td class="badge"><?php echo  $value["No"]; ?>
                    </div>
                </td>
                <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["d_update"]; ?></div>
                </td>
                <td style="font-size: 14px;"><?php echo $value["visit_id"]; ?></div>
                </td>
                <td style="font-size: 14px;"><?php echo $value["pid"]; ?></div>
                </td>
                 <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["response"]; ?></div> 
                <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["users"]; ?></div>
                </td>
                <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["messagecode"]; ?></div>
                </td>
                <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["messages"]; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="box-footer with-border">
        <div class="col-md-12">
            <div class="form-group">

                <!-- <?= Html::button(Yii::t('app', 'Ht'), ['class' => 'btn btn-warning pull-right', 'id' => 'btn-delete']) ?> -->
            </div>
        </div>
    </div>
<!-- ###################################################################################### -->
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


<!-- ############################################################################# -->

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
        echo Html::beginForm(['closevisit/delete-multiple'], 'post'); // เริ่มต้นฟอร์ม POST สำหรับ multi-delete
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
    <!-- ############################################################################################### -->