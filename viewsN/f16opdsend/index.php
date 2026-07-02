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

$this->title = 'FDH_OPD';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['thaimed/index']];

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
<br>
<div class="well">
    <div style="background-color: #126F30; padding: 10px; border: 0px solid #D4F1F5; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);">
        <font color="white" size="5"><i class='fas fa-bed'></i> ผู้ป่วยนอก สิทธิ์ประกันสุขภาพ [UCS] 16 แฟ้ม Financail Data Hub</font>
        <p style="color: yellow;">16fdb = Yii::$app->db16 โรงพยาบาลม่วงสามสิบ</p>
    </div>
    <!-- <h5 style="color: green; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.1); padding: 10px;"><i class="fas fa-user"></i> ข้อมูล 16 แฟ้มส่ง Finacail Data Hub </h5> -->

    <body>
        <!--     
    <script type="text/javascript">
    setTimeout("frmMain.submit();",50000);
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
                    <!-- <a href="#" class="popup-link" data-url="<?= yii\helpers\Url::to(['/log/dt']) ?>"> -->
                    <div style="text-align: right;">
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
<?= Html::button('<i class="fas fa-sync-alt"></i> RunTokenx', ['class' => 'btn btn-info', 'id' => 'runTokenBtn']) ?>

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
    $(document).ready(function(){
        $("#runTokenBtn").click(function(){
            // โหลดเนื้อหาจาก URL และแสดงใน Modal โดยใช้ AJAX
            $.get("http://192.168.200.9/moph-api3/pages/token_fdh_run.php", function(data){
                $("#tokenModalBody").html(data);
                $("#tokenModal").modal();
            });
        });
    });
</script>


                    <div style="text-align: right;">
                        <a href="<?= \yii\helpers\Url::to(['f16fdhvisit/index']) ?>" class="btn btn-warning modalLink" style="font-size: 16px;" target="_blank">
                            Query <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div id="loading-spinner" style="display: none; color: purple; font-size: 100px;">
            <!-- Customize the style as needed -->
            <div class="custom-spinner"></div>
        </div>

        <?= Html::beginForm(['f16opdsend/data'], 'post', ['name' => 'frmMain']); ?>

        <!-- <form id="checkbo" name="frmMain" action="index" method="post"> -->
        <input name="btnButton1" class="btn btn-success btn btn-block" id="selectAll" type="submit" name="selectAll" value="ส่งข้อมูล FDH OPD" style="background-color: #007100; border: 4px solid #dadada;">


        <!-- <input name="btnButton1" class="btn btn-primary btn btn-block" id="checkAll" type="submit" name="select" value="ส่งข้อมูล Moph-Claim DT"> -->

        <!-- <input type="checkbox" id="selectAll"> -->

        <table class="table table-striped" width="1000" border="0">
            <tr>
                <th width="30" style="background-color: lightgreen;">
                    <div align="center">
                        <!-- <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);"> -->
                        <input type="checkbox" id="selectAll">
                    </div>
                <td width="30" style="background-color: lightgreen;">
                    <div align="center"> # </div>
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="center" style="font-size: 14px;"> วันที่ </div>
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="center" style="font-size: 14px;"> Visit </div>
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;"> Hn </div>
                </td>

                <td width="150" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;"> ชื่อ-สกุล </div>
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;">อายุ </div>
                </td>
                <td width="70" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;">แผนก </div>
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="left" class="text-nowrap" style="font-size: 14px;"> สิทธิ์การรักษา </div>
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;">รหัสโรค
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;">ค่ารักษา
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;">สถานหลัก
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;">สถานรอง
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;">Uc_Expire
                </td>
                <td width="30" style="background-color: lightgreen;">
                    <div align="left" style="font-size: 14px;"> authencode
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
<td class="text-nowrap" style="font-size: 14px;"><?php echo $value["fullname"]; ?></td>
<td style="font-size: 14px;"><?php echo $value["age"]; ?></div>
<td class="text-nowrap" style="font-size: 14px;"><?php echo $value["unit_name"]; ?></div>
<td class="text-nowrap" style="font-size: 14px;"><?php echo $value["inscl"]; ?></div>
</td>
<td class="text-nowrap" style="font-size: 14px;"><?php echo $value["Diag"]; ?></div>
</td>
<td class="text-nowrap" style="font-size: 14px; color: orange;">
    <?php echo $value["amount"]; ?>
</td>

<td class="text-nowrap" style="font-size: 14px;"><?php echo $value["hospmain"]; ?></div>
</td>
<td class="text-nowrap" style="font-size: 14px;"><?php echo $value["hospsub"]; ?></div>
</td>
<td class="text-nowrap" style="font-size: 14px;"><?php echo $value["UC_EXPIRE"]; ?></div>
</td>
<td class="text-nowrap" style="font-size: 14px;"><?php echo $value["claimcode"]; ?></div>
</td>
</tr>
<?php endforeach; ?>
</table>
<div class="box-footer with-border">
    <div class="col-md-12">
        <div class="form-group">
            <!-- <p> <?= Html::submitButton('ส่งข้อมูล HT', ['class' => 'btn btn-success']) ?></p> -->
            <!-- <?= Html::button(Yii::t('app', 'Ht'), ['class' => 'btn btn-warning pull-right', 'id' => 'btn-delete']) ?> -->
        </div>
    </div>
</div>
<?php
// Success flash message
if (Yii::$app->session->hasFlash('success')) {
    echo '<div class="alert alert-success">' . Yii::$app->session->getFlash('success') . '</div>';
}

// Error flash message
if (Yii::$app->session->hasFlash('error')) {
    echo '<div class="alert alert-danger">' . Yii::$app->session->getFlash('error') . '</div>';
}
?>

<script>
    // Automatically hide success and error messages after 15 seconds
    setTimeout(function() {
        $('.alert').slideUp('slow');
    }, 10000);
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
<script>
    $(document).ready(function() {
        $('.popup-link').click(function(e) {
            e.preventDefault(); // Prevent the default link behavior

            var url = $(this).data('url'); // Get the URL from the data-url attribute
            openModalWithData(url);
        });
    });

    function openModalWithData(url) {
        // Use AJAX to fetch data from the provided URL
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                // 'response' contains the data received from the URL
                // You can now populate your modal with this data and open it
                // For example, using a library like Bootstrap's modal:

                // Assuming you have a modal with id 'myModal'
                $('#myModal .modal-body').html(response);
                $('#myModal').modal('show');
            },
            error: function() {
                alert('An error occurred while fetching data.');
            }
        });
    }
</script>
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