<?php

namespace app\controllers;

use Yii;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\editable\Editable;
use yii\widgets\Pjax;

$this->title = 'JHCIS-EPI วัคซีนทุกชนิด';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['rep/index']];
//$this->params['breadcrumbs'][] = 'รายงานข้อมูลE-Claim แยกตามREP';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EPI</title>

</head>


<body>
    <!--
    <script type="text/javascript">
    setTimeout("frmMain.submit();",50000);
    //5000 อยากได้เร็วก็กำหนดตัวเลขน้อยๆเอานะ
    </script>
    -->
   
    <style>
    .btn-group-modern {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin-top: 10px;
    }
    
    .btn-modern {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
        text-decoration: none;
        color: white;
        transition: all 0.3s ease-in-out;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    .btn-modern i {
        font-size: 18px;
    }

    /* ปรับสีปุ่ม */
    .btn-cidhn {
       background: linear-gradient(135deg, #6a11cb, #2575fc);
    }

    .btn-opd {
        background: linear-gradient(135deg, #db2df7, #edb0f7);
    }

    .btn-ipd {
       background: linear-gradient(135deg, #db2df7, #edb0f7);
    }
	.btn-refers {
        background: linear-gradient(135deg, #db2df7, #edb0f7);
	);
	
	
    }
    /* Hover Effect */
    .btn-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.3);
    }
</style>

<div class="btn-group-modern">
    <a href="<?= Url::to(['/f16janc/index']) ?>" class="btn-modern btn-refers">
        <i class="fa fa-check-square-o"></i> ANC
    </a>
	 <a href="<?= Url::to(['/f16jthaired/index']) ?>" class="btn-modern btn-opd">
        <i class="fa fa-check-square-o"></i> สาวไทยแก้มแดง
    </a>
	 <a href="<?= Url::to(['/f16janccare/index']) ?>" class="btn-modern btn-opd">
        <i class="fa fa-check-square-o"></i> เยี่ยมหลังคลอด
    </a>
    <a href="<?= Url::to(['/fittest/index']) ?>" class="btn-modern btn-refers">
        <i class="fa fa-check-square-o"></i> FitTest
    </a>
	 <a href="<?= Url::to(['/f16screenmental/index']) ?>" class="btn-modern btn-opd">
        <i class="fa fa-check-square-o"></i> สุขภาพกาย-จิต[UCS]
    </a>
	 <a href="<?= Url::to(['/convert16sss/index']) ?>" class="btn-modern btn-opd">
        <i class="fa fa-check-square-o"></i> สุขภาพกาย-จิต[Non-UC]
    </a>
	
   
</div>


<!-- ########################  จบปุ่มเมนู ########################################-->
<br>
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
        .info-card {
            background: linear-gradient(45deg, #b0e2d6 , #d4f4e8); /* Canva-like gradient */
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


<h6><a>200.4::Maphn </a> Copy [visitepi, person, cdrug, mathhn, visit, userx ] </h6>
   <div class="row g-3">

    <!-- Card: ผ่านตามเงื่อนไข -->
    <div class="col-lg-3 col-md-6">
        <div class="card border-start border-4 border-info shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-info fw-bold text-uppercase mb-2">ผ่านตามเงื่อนไขวันนี้</h6>
                    <div class="h4 fw-bold text-dark mb-0">
                        <?= $amount ?>
                    </div>
                </div>
                <a href="<?= \yii\helpers\Url::to(['/hjepi/loghpv']) ?>" target="_blank">
                    <img src="images/accept.svg" title="ข้อมูลสำเร็จ" width="60" height="50">
                </a>
            </div>
        </div>
    </div>

    <!-- Card: ไม่ผ่านตามเงื่อนไข -->
    <div class="col-lg-3 col-md-6">
        <div class="card border-start border-4 border-warning shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-warning fw-bold text-uppercase mb-2">ไม่ผ่านตามเงื่อนไข</h6>
                    <div class="h4 fw-bold text-dark mb-0">
                        <?= $amountx ?>
                    </div>
                </div>
                <a href="#" class="popup-link" data-url="<?= yii\helpers\Url::to(['/hjepi/logerr']) ?>">
                    <img src="images/accept.svg" title="ข้อมูลไม่สำเร็จ" width="60" height="50">
                </a>
            </div>
        </div>
    </div>

    <!-- Card: ทั้งหมด -->
    <div class="col-lg-3 col-md-6">
        <div class="card border-start border-4 border-success shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-success fw-bold text-uppercase mb-2">รายการส่งผ่านทั้งหมด</h6>
                    <div class="h4 fw-bold text-dark mb-0">
                        <?= $total ?>
                    </div>
                </div>
                <img src="images/waitmoph.98529de4.svg" title="ยอดทั้งหมด" width="60" height="50">
            </div>
        </div>
    </div>

</div>

    
    <div id="loading-spinner" style="display: none; color: purple; font-size: 100px;">
        <!-- Customize the style as needed -->
        <div class="custom-spinner"></div>
    </div>
    <!-- ############################# แสดงปุ่ม Select All  ################################################################### -->
    <?= Html::beginForm(['hjepi/check'], 'post', ['name' => 'frmMain']); ?>

<div id="loading-spinner" style="display:none;">
    <div class="spinner"></div>
</div>

<input name="btnButton1" class="btn btn-info btn btn-block" id="checkAll" type="submit" name="select" value="ส่งข้อมูล Moph-Claim JHCIS-EPI">

<input type="checkbox" id="checkAllBoxes" /> Check All

<table class="table table-striped" width="1100" border="0">
    <tr>
        <th width="30">
            <div align="center">
                <input type="checkbox" id="checkAllBoxesHeader" />
            </div>
        </th>
        <td width="30">
            <div align="center"> # </div>
        </td>
        <td width="30">
            <div align="center" style="font-size: 14px;"> วันที่ </div>
        </td>
        <td width="30">
            <div align="center" style="font-size: 14px;"> Visit </div>
        </td>
        <td width="30">
            <div align="left" style="font-size: 14px;"> Hn </div>
        </td>
        <td width="30">
            <div align="left" style="font-size: 14px;"> Cid </div>
        </td>
        <td width="150">
            <div align="left" style="font-size: 14px;"> ชื่อ-สกุล </div>
        </td>
        <td width="150">
            <div align="left" style="font-size: 14px;">อายุ </div>
        </td>
        <td width="30">
            <div align="left" class="text-nowrap" style="font-size: 14px;"> Lot </div>
        </td>
        <td width="30">
            <div align="left" class="text-nowrap" style="font-size: 14px;"> รหัสยา </div>
        </td>
        <td width="30">
            <div align="left" style="font-size: 14px;"> authencode </div>
        </td>
    </tr>
    <?php
    foreach ($hjpvProvider->getModels() as $key => $value) :
    ?>
        <tr>
            <td><input type="checkbox" name="chkDel[]" class="chkDel" id="chkDel<?= $key; ?>" value="<?php echo $value["visit_id"]; ?><?php echo $value["hn"]; ?>"></td>
            <td class="badge"><?php echo $value["No"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["dateepi"]; ?></td>
            <td style="font-size: 14px;"><?php echo $value["visit_id"]; ?></td>
            <td style="font-size: 14px;"><?php echo $value["hn"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["idcard"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["fullname"]; ?></td>
            <td style="font-size: 14px;"><?php echo $value["age"]; ?></td>
            <td style="font-size: 14px;"><?php echo $value["lotno"]; ?></td>
            <td style="font-size: 14px;"><?php echo $value["drugcode"]; ?></td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["claimcode_nhso"]; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<div class="box-footer with-border">
    <div class="col-md-12">
        <div class="form-group">
            <!-- <p> <?= Html::submitButton('ส่งข้อมูล JHIS-EPI', ['class' => 'btn btn-success']) ?></p> -->
            <!-- <?= Html::button(Yii::t('app', 'Ht'), ['class' => 'btn btn-warning pull-right', 'id' => 'btn-delete']) ?> -->
        </div>
    </div>
</div>

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
            e.preventDefault();
            var url = $(this).data('url');
            openModalWithData(url);
        });

        // Show the spinner when the button is clicked
        $('#checkAll').click(function() {
            $('#loading-spinner').show();
        });

        // Show the spinner before form submission
        $(document).on('beforeSubmit', 'form[name="frmMain"]', function() {
            $('#loading-spinner').show();
            return true;
        });

        // Hide the spinner on successful Pjax response
        $(document).on('pjax:success', function() {
            $('#loading-spinner').hide();
        });

        // Hide the spinner on any AJAX request completion
        $(document).ajaxStop(function() {
            $('#loading-spinner').hide();
        });

        // Handle check all functionality
        $("#checkAllBoxes, #checkAllBoxesHeader").click(function() {
            $(".chkDel").prop('checked', $(this).prop('checked'));
        });

        // If all checkboxes are checked, ensure the 'Check All' is checked, too
        $(".chkDel").click(function() {
            if ($(".chkDel:checked").length == $(".chkDel").length) {
                $("#checkAllBoxes, #checkAllBoxesHeader").prop('checked', true);
            } else {
                $("#checkAllBoxes, #checkAllBoxesHeader").prop('checked', false);
            }
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
</body>
</html>
