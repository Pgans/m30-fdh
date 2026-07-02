<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;


//use common\models\RContributionIpd;
use yii\data\ActiveDataProvider;

$this->title = 'Convert Files';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['thaimed/index']];

?>
<br>
<h2 style="color: white; font-size: 32px; background-color: #009191; border: 4px solid #8affc5;" class="badge">
    คัดกรองสุขภาพกาย-จิต (NON-UCS)->JHCIS-PCU
</h2>
<!-- ########################  ปุ่มเมนู ########################################-->
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

<div class="row">

    <!-- ######################################################################################################################### -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                            <h2 style="color: white; font-size: 28px; border: 4px solid #afd8d8;" class="badge btn-info">
                                1
                            </h2>

                            <h3>
                                ขั้นเตรียมข้อมูล
                            </h3>
                        </div>

                        <div class="icon">
                            <i class="ion ion-person"></i>
                            <img src="images/accept.svg" title="ข้อมูลสำเร็จ" width="70" height="60">
                            <!-- <div class="text-center">
                                <a href="<?= \yii\helpers\Url::to(['convert16sss/imports']) ?>" class="btn btn-success" style="font-size: 16px;">
                                    Imports Data <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div> -->
                            <p>db=db16=>200.9=>16fdb</p>
                            <p>แฟ้มที่เกี่ยวข้อง </p>
                            <p> person, ncd_person, ncd-person_ncd_hist, mathhn, visit, ctitle, cright, ncd_person_ncd_sceeen</p>
                            <p>*ลบข้อมูลมีค่าน้ำตาลแต่อายุน้อยกว่า 35 ปี</p>
                            <p>* ระบบจะตั้งค่าทุกแฟ้มเป็น 0 ก่อนนำเข้า</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ######################################################################################################################### -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                            <h2 style="color: white; font-size: 28px; border: 4px solid #afd8d8;" class="badge btn-info">
                                2
                            </h2>
                            <h3>
                                ประมวลผล
                            </h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                            <img src="images/reject.76840914.svg" title="ไม่ผ่าน" width="70" height="60">
                        </div>

                        <div class="text-center">
                            <a href="<?= \yii\helpers\Url::to(['convert16sss/update']) ?>" class="btn btn-info" style="font-size: 16px; border: 4px solid #91ffff;"> <!-- เพิ่มสีขอบขาว -->
                                ดึงข้อมูลเข้าแฟ้ม <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>

                        <p>ทั้งหมด 5 แฟ้ม </p>
                        <p>-PAT, OPD, ADP, INS, ODX</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ######################################################################################################################### -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                            <h2 style="color: white; font-size: 28px; border: 4px solid #afd8d8;" class="badge btn-info">
                                3
                            </h2>
                            <h3>
                                ส่งออก 16 แฟ้ม
                            </h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                            <img src="images/reject.76840914.svg" title="ไม่ผ่าน" width="70" height="60">
                        </div>

                        <div class="text-center">
                            <a href="<?= \yii\helpers\Url::to(['convert16sss/exports']) ?>" class="btn btn-primary" style="font-size: 16px;border: 4px solid #91ffff;">
                                Export Files <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                        </br>
                        <div class="text-center">
                            <a href="<?= \yii\helpers\Url::to(['convert16sss/exportexcel']) ?>" id="exportExcelButton" class="btn btn-primary" style="font-size: 16px;border: 4px solid #91ffff;">
                                รายชื่อและส่งออก ExcelFiles <i class="fa fa-arrow-circle-right"></i>
                            </a>

                        </div>
                        <p>ส่งออก 16 แฟ้มและ Zip ไฟล์นำเข้า </p>
                        <p>New E-Claim</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php if (Yii::$app->session->hasFlash('success')) : ?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('error')) : ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <script>
        $(document).ready(function() {
            $('#exportExcelButton').on('click', function(e) {
                e.preventDefault(); // Prevent the default behavior (following the link)

                // Open a popup window with the specified URL
                var popupWindow = window.open($(this).attr('href'), '_blank', 'width=800,height=600');

                // Focus on the new window if it's not already focused
                if (window.focus) {
                    popupWindow.focus();
                }
            });
        });
    </script>