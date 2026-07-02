<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\web\View;
//use common\models\RContributionIpd;
use yii\data\ActiveDataProvider;
//use yii\bootstrap4\Alert;
use yii\bootstrap\Modal;



$this->title = 'TELEMED';
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
<<style>
  /* กำหนดสีให้กับแถวที่เป็นเลขคี่ */
  .my-striped-table tr:nth-child(odd) {
    background-color: #efefef; /* สีเทาจาง ๆ */
  }
  /* กำหนดสีให้กับแถวที่เป็นเลขคู่ */
  .my-striped-table tr:nth-child(even) {
    background-color: white;
  }
</style>
<br>
<div class="well">
    <div style="background-color: #126F30; padding: 10px; border: 0px solid #D4F1F5; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">
        <font color="white" size="5"><i class='fas fa-bed'></i> ผู้ป่วยนอก UCS 16 แฟ้ม [FDH Telemed]</font>
        <div style="display: flex; justify-content: flex-end;">
            <span style="color: yellow;">jhcisdb = db14j(200.14) โรงพยาบาลม่วงสามสิบ</span>
        </div>

    </div>
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
                        
						<?= Html::a($amount, null, ['class' => 'btn btn-success', 'id' => 'link1']) ?>

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
                                'data-url' => \yii\helpers\Url::to(['f16telemed/list-files-partial']), // URL สำหรับโหลดเนื้อหา
                            ]);
                            ?>
                            <!--<?= Html::a('ผ่าน', null, ['class' => 'btn btn-success', 'id' => 'link1']) ?>-->
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

                        <!-- ปุ่มที่เปิด modal -->
                        <?= Html::button('<i class="fas fa-sync-alt"></i> RunToken', ['class' => 'btn btn-info', 'id' => 'runTokenBtn']) ?>

                        <!-- Modal -->
                        <div class="modal fade" id="tokenModal" tabindex="-1" role="dialog" aria-labelledby="tokenModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tokenModalLabel">RunToken</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="tokenModalBody">
                                        <!-- เนื้อหาจะถูกโหลดผ่าน AJAX และแสดงที่นี่ -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- JavaScript เพื่อเปิด modal เมื่อคลิกที่ปุ่ม -->
                        <script>
                            $(document).ready(function() {
                                $("#runTokenBtn").click(function() {
                                    // โหลดเนื้อหาจาก URL และแสดงใน Modal โดยใช้ AJAX
                                    $.get("http://192.168.200.9/moph-api3/pages/token_fdh_run.php", function(data) {
                                        $("#tokenModalBody").html(data);
                                        $("#tokenModal").modal();
                                    });
                                });
                            });
                        </script>

                        <!-- ลิงค์ที่เปิด Modal -->
                        <?= Html::a('<i class="fas fa-sync-alt"></i> DelToken', '#', ['class' => 'btn btn-danger', 'id' => 'delTokenLink', 'data-toggle' => 'modal', 'data-target' => '#tokendelModal']) ?>

                        <!-- Modal -->
                        <div class="modal fade" id="tokendelModal" tabindex="-1" role="dialog" aria-labelledby="tokenModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tokenModalLabel">DelToken</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- ลิงค์ที่ใช้ลบ token -->
                                        <p>คุณแน่ใจหรือไม่ว่าต้องการที่จะลบ Token นี้?</p>
                                        <a href="http://192.168.200.9/moph-api3/pages/token_fdh_del.php" class="btn btn-danger" target="_blank">ลบ Token</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div style="text-align: right;">
                    <?= Html::a('ไม่ผ่าน', null, ['class' => 'btn btn-danger', 'id' => 'link2']) ?>
                        <img src="images/reject.76840914.svg" title="ไม่ผ่าน" width="70" height="60">
                    </div>
                    </a>
                </div>
            </div>


            <div class="col-xl-3 col-md-3 mb-3">
                <div class="info-box bg-success" style="box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">
                    <span class="info-box-icon"><i class="fas fa-hand-holding-heart" style="color: orange;"></i></i></span>
                    <div class="info-box-content">
                        <a href="<?= \yii\helpers\Url::to(['fdhtelemed/index']) ?>" class="btn btn-warning modalLink" style="font-size: 16px;" target="_blank">
                            Query <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        <span class="info-box-number"><?php echo $total ?></span>

                        <a href="https://uat-fdh.inet.co.th/hospital/detail" target="_blank">FDH-UAT</a>--
                        <a href="https://fdh.moph.go.th/hospital/" target="_blank">FDH-Production</a><br>
                        <a href="https://docs.google.com/document/d/1B9IJPh0SKGytnCm1godY1ijeNxRmXlxCJJ-CsQUwRQI/" target="_blank">คู่มือ API</a>--
                        <a href="https://docs.google.com/spreadsheets/d/1zchT_5IlznB0zxvQ-nvFtGYlb9rRM4aBdAWk0Bpd1i0/edit#gid=0/" target="_blank">Template</a>
                        <!-- ลิงก์ที่เรียกใช้ JavaScript เพื่อเปิดป๊อปอัป -->
                        <div class="text-center">
                            <a href="javascript:void(0);" id="exportExcelButton" class="btn btn-primary" style="font-size: 16px; border: 4px solid #91ffff;" onclick="openPopup();">
                                รายชื่อและส่งออก ExcelFiles <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>

                        <script>
                            function openPopup() {
                                const url = "<?= \yii\helpers\Url::to(['f16telemed/exportexcel']); ?>"; // ลิงก์ไปยังไฟล์ Excel
                                const popupWindow = window.open(url, 'ExcelPopup', 'width=600,height=400'); // สร้างหน้าต่างป๊อปอัป
                                popupWindow.focus(); // โฟกัสไปยังป๊อปอัป
                            }
                        </script>

                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-3 mb-3">
                <div class="info-card bg-info" style="box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">

                    <?php
                    // Start the session and retrieve session data
                    session_start();

                    // Retrieve the session data with checks to avoid errors
                    $visits = isset($_SESSION['visits']) ? $_SESSION['visits'] : [];
                    $hn = isset($_SESSION['hn']) ? $_SESSION['hn'] : [];
                    $success_raw = isset($_SESSION['success']) ? $_SESSION['success'] : '';

                    // Ensure `success` is a string before applying `htmlspecialchars()`
                    $success = is_array($success_raw) ? json_encode($success_raw) : $success_raw;
                    ?>
                    <div id="visitContainer">
                        <!-- จะใช้ JavaScript เพื่อเพิ่มรายการด้วยการหน่วงเวลา -->
                    </div>

                    <script>
                        // ข้อมูลจาก PHP
                        const visitContainer = document.getElementById("visitContainer");
                        const visits = <?= json_encode($visits); ?>; // แปลง PHP array เป็น JSON
                        const hn = <?= json_encode($hn); ?>;
                        const success = "<?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?>"; // ข้อความที่จะใช้

                        // ฟังก์ชันเพื่อแสดงรายการด้วยการหน่วงเวลา
                        function displayVisits(visits, delay, success) {
                            visits.forEach((visit, index) => {
                                setTimeout(() => {
                                    const visitElement = document.createElement("div");
                                    visitElement.innerHTML = `Seq:${visit} -Hn:${hn}- <span style="color: green;">${success}</span>`; // ข้อความเป็นสีเขียว
                                    visitContainer.appendChild(visitElement);

                                    // เลื่อนเมื่อมีรายการใหม่เพิ่มเข้ามา
                                    visitContainer.scrollTop = visitContainer.scrollHeight;
                                }, delay * (index + 1)); // หน่วงเวลา 500 มิลลิวินาทีสำหรับแต่ละรายการ
                            });
                        }

                        // เรียกฟังก์ชันด้วยการหน่วงเวลา 500 มิลลิวินาที
                        displayVisits(visits, 500, success); // 500 มิลลิวินาที
                    </script>


                </div>
            </div>

            <div id="loading-spinner" style="display: none; color: purple; font-size: 100px;">
                <!-- Customize the style as needed -->
                <div class="custom-spinner"></div>
            </div>

            <?= Html::beginForm(['f16telemed/data'], 'post', ['name' => 'frmMain']); ?>

            <!-- <form id="checkbo" name="frmMain" action="index" method="post"> -->
            <input name="btnButton1" class="btn btn-success btn btn-block" id="selectAll" type="submit" name="selectAll" value="ส่งข้อมูล FDH OPD" style="background-color: #007100; border: 4px solid #dadada;">
            <table class="table my-striped-table" width="1000" border="0" bordercolor="#ddd" style="border-collapse: collapse;">
                        
                <th width="30" style="background-color: lightgreen;">
                    <div align="center">
                        <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);">

                    </div>
                <td width="30" style="background-color: lightgreen;">
                    <div align="center"> # </div>
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="center" style="font-size: 14px;"> วันที่ </div>
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="center" style="font-size: 14px;"> เลขบริการ </div>
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;"> Hn </div>
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;"> Cid </div>
                </td>
                <td width="150" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;"> ชื่อ-สกุล </div>
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;">อายุ </div>
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;">แผนก </div>
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;">โรคหลัก </div>
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;">รหัสโรค </div>
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="left" class="text-nowrap" style="font-size: 14px;"> สิทธิ์ </div>
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;">ราคาเบิก
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;">ส่วนสูง
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;">สถานหลัก
                </td>

                <td width="30" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;">สถานรอง
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;">expire
                </td>

                </tr>
                <?php
                foreach ($dataProvider->getModels() as $key => $value) :
                ?>
                    <tr>

                        <td><input type="checkbox" name="chkDel[]" <?php echo 'checked'; ?> id="chkDel<?= $i; ?>" value="<?php echo $value["visit_id"]; ?><?php echo $value["hn"]; ?>">
                        <td class="badge"><?php echo  $value["No"]; ?>
        </div>
        </td>
        <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["regdate"]; ?>
</div>
</td>
<td style="font-size: 14px;"><?php echo $value["visit_id"]; ?></div>
</td>
<td style="font-size: 14px;"><?php echo $value["hn"]; ?></div>
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
<td class="text-nowrap" style="font-size: 14px;"><?php echo $value["height"]; ?></div>
</td>
<td class="text-nowrap" style="font-size: 14px;"><?php echo $value["hospmain"]; ?></div>
</td>
<td class="text-nowrap" style="font-size: 14px;"><?php echo $value["hospsub"]; ?></div>
</td>
<td class="text-nowrap" style="font-size: 14px;"><?php echo $value["UC_EXPIRE"]; ?></div>
</td>
</tr>
<?php endforeach; ?>
</table>
<!-- ###################################################################################################### -->


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
    <h2 style="color: #ff0000; border: 2px solid #c3e6cb; padding: 5px;">แสดงรายการไม่ผ่าน</h2>

            <?= \yii\grid\GridView::widget([
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
