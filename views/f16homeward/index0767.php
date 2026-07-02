<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\web\View;
use yii\data\ActiveDataProvider;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

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
        #loading-spinner {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
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
                        echo Html::a('เปิดอ่านไฟล์', '#', [
                            'class' => 'btn btn-primary',
                            'data-toggle' => 'modal',
                            'data-target' => '#myModal', // เปิด Modal
                            'data-url' => \yii\helpers\Url::to(['f16homeward/list-files-partial']), // URL สำหรับโหลดเนื้อหา
                        ]);
                        ?>
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
                    <span class="info-box-text" style="color: red; font-size: 14px;">จัดการ Token</span>

                   
                    <a href="<?= Url::to(['f16homeward/run-curl']) ?>" class="btn btn-info" style="font-size: 16px;">
                                    RunToken <i class="fa fa-arrow-circle-right"></i>
                                </a>
                    </div>
                <div style="text-align: right;">
            
                

                    <?= Html::a('<i class="fa fa-ban" aria-hidden="true"></i> ไม่ผ่าน', null, ['class' => 'btn btn-danger', 'id' => 'link2']) ?>
                    <img src="images/reject.76840914.svg" title="ไม่ผ่าน" width="70" height="60">
                </div>
                </a>
            </div>
        </div>


        <div class="col-xl-3 col-md-3 mb-3">
            <div class="info-box bg-success" style="box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">
                <span class="info-box-icon"><i class="fas fa-hand-holding-heart" style="color: orange;"></i></i></span>
                <div class="info-box-content">
                    <span class="info-box-number" style="color: green; font-size: 18px;">ลิงค์เข้าเว็บ FDH</span>

                    <a href="https://uat-fdh.inet.co.th/hospital/detail" target="_blank">FDH-UAT</a>--
                    <a href="https://fdh.moph.go.th/hospital/" target="_blank">FDH-Production</a><br>
                    <a href="https://docs.google.com/document/d/1B9IJPh0SKGytnCm1godY1ijeNxRmXlxCJJ-CsQUwRQI/" target="_blank">คู่มือ API</a>--
                    <a href="https://docs.google.com/spreadsheets/d/1zchT_5IlznB0zxvQ-nvFtGYlb9rRM4aBdAWk0Bpd1i0/edit#gid=0/" target="_blank">Template</a>--
                    <a href="https://docs.google.com/document/d/1yDwflxOG_EG9HkEWbewfk446kmkGQ_2KiJhyqg2iY2E/" target="_blank">จองเคลม</a>
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


                    <a href="<?= \yii\helpers\Url::to(['fdhhomeward/index']) ?>" class="btn btn-warning modalLink" style="font-size: 16px;" target="_blank">
                        Query <i class="fa fa-arrow-circle-right"></i>
                    </a>
                    <!-- <a href="<?= \yii\helpers\Url::to(['f16only/exports']) ?>" class="btn btn-primary" style="font-size: 16px;">
                        ส่งออก 16F <i class="fa fa-arrow-circle-right"></i>
                    </a> -->

                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-3 mb-3">
            <div class="info-card bg-info" style="box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">

                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <?php $form = ActiveForm::begin(['action' => ['f16homeward/index']]); ?>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">วันที่:</label>
                                <div class="col-sm-9">
                                    <?= yii\jui\DatePicker::widget([
                                        'name' => 'date1',
                                        'value' => $date1,
                                        'language' => 'th',
                                        'dateFormat' => 'yyyy-MM-dd',
                                        'options' => [
                                            'class' => 'form-control',
                                            'placeholder' => 'เลือกวันที่เริ่มต้น',
                                        ],
                                        'clientOptions' => [
                                            'changeMonth' => true,
                                            'changeYear' => true,
                                        ],
                                    ]); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">ถึง:</label>
                                <div class="col-sm-9">
                                    <?= yii\jui\DatePicker::widget([
                                        'name' => 'date2',
                                        'value' => $date2,
                                        'language' => 'th',
                                        'dateFormat' => 'yyyy-MM-dd',
                                        'options' => [
                                            'class' => 'form-control',
                                            'placeholder' => 'เลือกวันที่สิ้นสุด',
                                        ],
                                        'clientOptions' => [
                                            'changeMonth' => true,
                                            'changeYear' => true,
                                        ],
                                    ]); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button class="btn btn-danger">ตกลง</button>
                                </div>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ############################################################################################################################## -->

    <!-- ############################################ Grid View ######################################################################## -->
    <div class="page-container">
        <div class="fixed-header">
            <!-- <input name="btnButton1" class="btn btn-success btn btn-block" id="selectAll" type="submit" name="selectAll" value="ส่งข้อมูล FDH Home-Ward " style="background-color: #b605cf; border: 4px solid #dadada;"> -->
        </div>
        <div style="height: 400px; overflow-y: auto;">
        <div id="loading-spinner" style="display: none;">
            <!-- Customize the style as needed -->
            <div class="custom-spinner"></div>
        </div>

            <?= Html::beginForm(['f16homeward/data'], 'post', ['name' => 'frmMain']); ?>

            <!-- <form id="checkbo" name="frmMain" action="index" method="post"> -->
            <input name="btnButton1" class="btn btn-success btn btn-block" id="selectAll" type="submit" name="selectAll" value="ส่งข้อมูล FDH Home-Ward" style="background-color: #00a400; border: 4px solid #dadada;">
            <table class="table my-striped-table" width="1000" border="0" bordercolor="#ddd" style="border-collapse: collapse;">

                <th width="30" style="background-color: lightgray;">
                    <div align="center">
                        <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);">

                    </div>
                <td width="30" style="background-color: lightgray;">
                    <div align="center"> # </div>
                </td>
                <td width="30" style="background-color: lightgray;">
                    <div align="center" style="font-size: 14px;"> วันAdmit </div>
                </td>
                <td width="30" style="background-color: lightgray;">
                    <div align="center" style="font-size: 14px;"> วันDSC </div>
                </td>
                <td width="30" style="background-color: lightgray;">
                    <div align="center" style="font-size: 14px;"> An </div>
                </td>
                <td width="30" style="background-color: lightgray;">
                    <div align="left" style="font-size: 14px;"> Hn </div>
                </td>
                <td width="30" style="background-color: lightgray;">
                    <div align="left" style="font-size: 14px;"> Visits </div>
                </td>
                <td width="30" style="background-color: lightgray;">
                    <div align="left" style="font-size: 14px;"> Cid </div>
                </td>
                <td width="150" style="background-color: lightgray;">
                    <div align="left" style="font-size: 14px;"> ชื่อ-สกุล </div>
                </td>
                <td width="30" style="background-color: lightgray;">
                    <div align="left" style="font-size: 14px;">อายุ </div>
                </td>
                <td width="30" style="background-color: lightgray;">
                    <div align="left" style="font-size: 14px;">แผนก </div>
                </td>
                <td width="30" style="background-color: lightgray;">
                    <div align="left" style="font-size: 14px;">โรคหลัก </div>
                </td>
                <td width="30" style="background-color: lightgray;">
                    <div align="left" style="font-size: 14px;">รหัสโรค </div>
                </td>
                <td width="30" style="background-color: lightgray;">
                    <div align="left" class="text-nowrap" style="font-size: 14px;"> สิทธิ์ </div>
                </td>
                <td width="30" style="background-color: lightgray;">
                    <div align="left" style="font-size: 14px;">ราคาเบิก
                </td>
                <td width="30" style="background-color: lightgray;">
                    <div align="left" style="font-size: 14px;">xx
                </td>
                <td width="30" style="background-color: lightgray;">
                    <div align="left" style="font-size: 14px;">สถานหลัก
                </td>

                <td width="30" style="background-color: lightgray;">
                    <div align="left" style="font-size: 14px;">สถานรอง
                </td>
                <td width="30" style="background-color: lightgray;">
                    <div align="left" style="font-size: 14px;">Claim
                </td>
                </tr>
                <?php
                foreach ($dataProvider->getModels() as $key => $value) :
                ?>
                    <tr>
                    <tr style="background-color: <?php echo ($value['response'] == 'สำเร็จ' ? '#E1FAD1 ' : '#F2DEF9'); ?>;">
                        <td><input type="checkbox" name="chkDel[]" <?php echo 'checked'; ?> id="chkDel<?= $i; ?>" value="<?php echo $value["visit_id"]; ?><?php echo $value["an"]; ?>">
                        <td class="badge"><?php echo  $value["No"]; ?>
        </div>
        </td>
        <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["regdate"]; ?>
    </div></td>
    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["dsc"]; ?>
    </div></td>
    <td class="text-nowrap" style="font-size: 14px; color: #009b00; box-shadow: 0 0 10px rgba(0, 155, 0, 0.5); border-radius: 5px; padding: 5px;">
        <?php echo $value["an"]; ?>
    </td>

    <!-- <td style="font-size: 14px;"><?php echo $value["an"]; ?></div> -->
    </td>
    <td style="font-size: 14px;"><?php echo $value["hn"]; ?></div>
    </td>
    <td style="font-size: 14px;"><?php echo $value["visit_id"]; ?></div>
    </td>
    <td style="font-size: 14px;"><?php echo $value["cid"]; ?></div>
    </td>
    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["fullname"]; ?></td>
    <td style="font-size: 14px;"><?php echo $value["age"]; ?></div>
    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["unit_name"]; ?></div>
    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["Diagx"]; ?></div>
    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["Diag"]; ?></div>
    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["inscl"]; ?></div>
    </td>
    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["amount"]; ?></div>
    </td>
    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["response"]; ?></div>
    </td>
    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["hospmain"]; ?></div>
    </td>
    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["hospsub"]; ?></div>
    </td>
    <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["claimcode"]; ?></div>
    </td>
    </tr>
<?php endforeach; ?>
</table>
</div>

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
                'an',
                'users',
                'response',
                'd_update',
            ],
            'tableOptions' => [
                'class' => 'table table-striped',
                'style' => 'border: 1px solid #dee2e6; box-shadow: 0px 2px 10px rgba(0,0,0,0.1); border-radius: 10px;',
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