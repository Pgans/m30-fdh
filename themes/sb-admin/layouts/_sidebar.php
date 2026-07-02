<?php

use yii\helpers\Url;
use mdm\admin\components\Helper;
use yii\bootstrap\Html;
?>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">รพ.ม่วงสามสิบ <sup>2</sup></div>
    </a>
    <div class="pull-left info">
        <p><?= \Yii::$app->user->identity->username ?></p>

    </div>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <!-- <div class="sidebar-heading">
        Interface
    </div> -->

    <!-- <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span></span></a>
    </li> -->
    <!-- เวชระเบียนผู้ป่วยนอก -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>เวชระเบียนผู้ป่วยนอก</span>

        </a>

        <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item" href="<?= Url::toRoute(['/mraopd/index']) ?>">บันทึกเวระเบียนผู้ป่วยนอก</a>
                <a class="collapse-item" href="cards.html">Cards</a>
            </div>
        </div>
    </li>
    <!-- ตรวจสอบ User Login เข้ามา -->
    <!-- <?php //if (!Yii::$app->user->getIsGuest()) {  
            ?> -->

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>ศูนย์จัดเก็บ</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">
                    รายงานประจำวัน: -->
                <a class="collapse-item" href="<?= Url::toRoute(['/adjrw/opdtotal']) ?>"> ยอดผู้ป่วยนอก:</a>
                <a class="collapse-item" href="<?= Url::toRoute(['/adjrw/adjipd']) ?>"> AdjRW-IPD:</a>
                <a class="collapse-item" href="<?= Url::toRoute(['/readmit/readmit']) ?>"> Rep-Admit28':</a>
                <a class="collapse-item" href="<?= Url::toRoute(['/readmit/revisit']) ?>"> ARep-Visit48:</a>
                <a class="collapse-item" href="<?= Url::toRoute(['/readmit/unplan']) ?>"> Unplan-Refer:</a>

            </div>
        </div>
    </li>
     <!-- ####################### FDH ################################################################################# -->
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsefdh" href="#" data-toggle="collapse" data-target="#collapsefdh" aria-expanded="true" aria-controls="collapsefdh">
            <i class="fas fa-fw fa-cog"></i>
            <span>FDH</span>
        </a>
        <div id="collapsefdh" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
               
				<a class="collapse-item" href="<?= Url::toRoute(['/closevisit/index'])  ?>">Close_visits</a>
                
               
            </div>
        </div>
    </li>
	 <!-- ####################### PHR ################################################################################# -->
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsep" aria-expanded="true" aria-controls="collapsep">
            <i class="fas fa-fw fa-cog"></i>
            <span>PHR</span>
        </a>
        <div id="collapsep" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">
                    รายงานประจำวัน: -->
				<a class="collapse-item" href="<?= Url::toRoute(['/phrjson/phr'])  ?>">Phr-Log</a>
                <a class="collapse-item" href="<?= Url::toRoute(['/phrjson1491/phr'])  ?>">Phr1491:2024:2567-1</a>
                <a class="collapse-item" href="<?= Url::toRoute(['/phrjson1492/phr']) ?>">Phr1492:2023:2566-2</a>
                <a class="collapse-item" href="<?= Url::toRoute(['/phrjson7091/phr'])?>">Phr7091:2022:2566-3</a>
				<a class="collapse-item" href="<?= Url::toRoute(['/phrjson7092/phr'])?>">Phr7092:2021:2564</a>
				<a class="collapse-item" href="<?= Url::toRoute(['/phrjson7093/phr'])?>">Phr7093:2020:2563</a>
               
            </div>
        </div>
    </li>
    <!-- ####################### 16แฟ้ม ################################################################################# -->
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse16" aria-expanded="true" aria-controls="collapse16">
            <i class="fas fa-fw fa-cog"></i>
            <span>16 แฟ้ม</span>
        </a>
        <div id="collapse16" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">
                    รายงานประจำวัน: -->
                <a class="collapse-item" href="<?= Url::toRoute(['/f16visit/index']) ?>">Visit:</a>
                <a class="collapse-item" href="<?= Url::toRoute(['/f16only/index']) ?>"> เลือกช่วงเวลา:</a>
                <a class="collapse-item" href="<?= Url::toRoute(['/f16stateless/index']) ?>"> ผู้มีปัญหาสถานะสิทธิ์:</a>
                 <!-- <a class="collapse-item" href="<?= Url::toRoute(['/adjrw/adjipd']) ?>"> สุขภาพกายจิต:</a>  -->
                <!-- <a class="collapse-item" href="<?= Url::toRoute(['/readmit/readmit']) ?>"> Rep-Admit28':</a> -->


            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsej" aria-expanded="true" aria-controls="collapsej">
            <i class="fas fa-fw fa-cog"></i>
            <span>16แฟ้ม-JHCIS</span>
        </a>
        <div id="collapsej" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">
                    รายงานประจำวัน: -->
                    <a class="collapse-item" href="<?= Url::toRoute(['/convert16all/index']) ?>">สุขภาพกายจิต-ทุกสิทธิ์:</a>
                    <a class="collapse-item" href="<?= Url::toRoute(['/convert16ft/index']) ?>">FitTest-ทุกสิทธิ์:</a>
               <!-- <a class="collapse-item" href="<?= Url::toRoute(['/convert16/index']) ?>">สุขภาพกายจิต-16F-JHCIS:</a> -->
               <!-- # <a class="collapse-item" href="<?= Url::toRoute(['/convert16sss/index']) ?>"> สุขภาพกายจิตNON-UC::</a> -->
               <!-- # <a class="collapse-item" href="<?= Url::toRoute(['/convert16ucs/index']) ?>"> สุขภาพกายจิตUC::</a> -->
                <!-- <a class="collapse-item" href="<?= Url::toRoute(['/f16stateless/index']) ?>"> ผู้มีปัญหาสถานะสิทธิ์:</a> -->
                 <!-- <a class="collapse-item" href="<?= Url::toRoute(['/adjrw/adjipd']) ?>"> สุขภาพกายจิต:</a>  -->
                <!-- <a class="collapse-item" href="<?= Url::toRoute(['/readmit/readmit']) ?>"> Rep-Admit28':</a> -->


            </div>
        </div>
    </li>
    <!-- ####################### API ################################################################################# -->
    <!-- ตรวจสอบ User Login เข้ามา  //'visible' => !Yii::$app->user->isGuest, -->
    <!-- <?php //if (!Yii::$app->user->getIsGuest()) { ?>-->

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOnex" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>API</span>
            </a>
            <div id="collapseOnex" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                    <a class="collapse-item" href="<?= Url::toRoute(['/dashboard/index']) ?>">ข้อมูลการส่ง API</a>
                    <a class="collapse-item" href="<?= Url::toRoute(['/phr/phr']) ?>">การส่ง PHR</a>
                    <a class="collapse-item" href="<?= Url::to(['/phrsend/index', 'regdate' => '2024-02-11']) ?>">Dashboard PHR</a>
                    <a class="collapse-item" href="<?= Url::toRoute(['/epidem/epidem']) ?>">การส่ง Epidem</a>
                    <a class="collapse-item" href="<?= Url::toRoute(['/d506/d506']) ?>">การส่ง D506</a>
                    <a class="collapse-item" href="<?= Url::toRoute(['/dmht/ht']) ?>">การส่ง HT</a>
                    <a class="collapse-item" href="<?= Url::toRoute(['/dm/dm']) ?>">การส่ง DM</a>
                    <a class="collapse-item" href="<?= Url::toRoute(['/dt/dt']) ?>">การส่ง DT</a>
                    <!-- <a class="collapse-item" href="<?= Url::toRoute(['/epi/index']) ?>">ส่งข้อมูลวัคซีนเด็ก(Epi)</a> -->
                    <a class="collapse-item" href="<?= Url::toRoute(['/hpv/hpv']) ?>">ส่งข้อมูลวัคซีน HPV</a>
                    <a class="collapse-item" href="<?= Url::toRoute(['/hjpv/hjpv']) ?>">ส่งข้อมูลวัคซีน JHCIS-HPV</a>
                    <a class="collapse-item" href="<?= Url::toRoute(['/hjepi/hjepi']) ?>">ส่งข้อมูลวัคซีน JHCIS-EPI</a>
                    <a class="collapse-item" href="<?= Url::toRoute(['/service/index']) ?>">การส่ง43แฟ้ม</a>
                    <a class="collapse-item" href="<?= Url::toRoute(['/drugopd/drugzone']) ?>">Zero Stock</a>

                </div>
            </div>
        </li>



        <!-- Divider -->
        <hr class="sidebar-divider">

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOx" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Datacenter</span>

            </a>

            <div id="collapseOx" class="collapse" aria-labelledby="headingOx" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">

                    <a class="collapse-item" href="<?= Url::toRoute(['top10/index']) ?>">10อันดับโรค</a>
                    <a class="collapse-item" href="<?= Url::toRoute(['/mraopd/index']) ?>">ปปป</a>
                </div>
            </div>
        </li>
    <!-- <?php// } ?> -->
    <!-- Nav Item - Pages Collapse Menu -->
    <!--
    <li class="nav-item active">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Admin</span>
        </a>
        <div id="collapsePages" class="collapse show" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="<?= Url::toRoute(['/user/security/login']) ?>">Login</a>
                 <a class="collapse-item" href="register.html">Register</a>
                 <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                 <div class="collapse-divider"></div>
                 <h6 class="collapse-header">Other Pages:</h6>
                 <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item" href="<?= Url::toRoute(['/user/security/logout']) ?>">Logout</a>
            </div>
        </div>
    </li>-->
    <!-- เวชระเบียนผู้ป่วยนอก -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsex" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Import-Text</span>

        </a>

        <div id="collapsex" class="collapse" aria-labelledby="headingx" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item" href="<?= Url::toRoute(['/importtext/import']) ?>">นำเข้าสิทธิ์ สปสช.</a>
                <!-- <a class="collapse-item" href="<?= Url::toRoute(['/importtext/import']) ?>">Palliative</a> -->
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsex" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Import-CSV</span>

        </a>

        <div id="collapsex" class="collapse" aria-labelledby="headingx" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item" href="<?= Url::toRoute(['/importcsv/importcsv']) ?>">EDC</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsexx" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Import-Excel</span>

        </a>

        <div id="collapsexx" class="collapse" aria-labelledby="headingxx" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">


                <a class="collapse-item" href="<?= Url::toRoute(['/authenimport/imports']) ?>">Authencode</a>
                <a class="collapse-item" href="<?= Url::toRoute(['/repimport/imports']) ?>">Rep</a>

            </div>
        </div>
    </li>
    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="<?= Url::toRoute(['convert16/index']) ?>">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>16F-jhcis</span></a>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="<?= Url::toRoute(['convert43/index']) ?>">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>43F-jhcis</span></a>
    </li>
    <!-- Nav Item - Charts -->
    <li class="nav-item">
    <a class="nav-link" href="<?= Url::to(['/phrsend/index', 'regdate' => '2024-02-11']) ?>">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Dashboard PHR</span>
    </a>
</li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="<?= Url::toRoute(['kha/index']) ?>">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>เอกสารคุณภาพ</span></a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse-" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>เข้าสู่ระบบ</span>

        </a>

        <div id="collapse-" class="collapse" aria-labelledby="heading-" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <ul class="sidebar-menu tree" data-widget="tree">
                    <!-- <li class="header"></li> -->
                    <?php
                    if (Yii::$app->user->isGuest) {
                    ?>
                        <li>
                            <a href="<?= Url::to('index.php?r=user/security/login') ?>">
                                <span class="white-text">Login</span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li>
                            <?php
                            echo Html::a(
                                'Logout',
                                ['/user/security/logout'],
                                [
                                    'data' => [
                                        'icon' => 'fa fa-sign-out text-red',
                                        'method' => 'post',
                                    ],
                                    'class' => 'white-text', // เพิ่มคลาส CSS สำหรับข้อความที่ต้องการปรับสี
                                ]
                            );
                            ?>
                        </li>
                    <?php } ?>
                </ul>

            </div>
        </div>
    </li>

    <ul class="sidebar-menu tree" data-widget="tree">
        <!-- <li class="header"></li> -->
        <?php
        if (Yii::$app->user->isGuest) {
        ?>
            <li>
                <a href="<?= Url::to('index.php?r=user/security/login') ?>">
                    <span class="white-text">Login</span>
                </a>
            </li>
        <?php } else { ?>
            <li>
                <?php
                echo Html::a(
                    'Logout',
                    ['/user/security/logout'],
                    [
                        'data' => [
                            'icon' => 'fa fa-sign-out text-red',
                            'method' => 'post',
                        ],
                        'class' => 'white-text', // เพิ่มคลาส CSS สำหรับข้อความที่ต้องการปรับสี
                    ]
                );
                ?>
            </li>
        <?php } ?>
    </ul>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <!-- End of Sidebar -->



    </div>
</ul>
<!--  
[
                        'label' => 'ส่งออก TextFiles', 'icon' => 'cog text-orange', 
                        'items' => [
                            ['label' => 'Paliiative', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/textfiles/exporttextnon']],
                            ['label' => 'Paliiative-MultiFiles', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/textfiles/multitextfiles']],
                            //['label' => 'MultiFiles-Test', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/textfiles/multitext']],
                            ['label' => 'Paliiative เลือกแฟ้ม', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/textfiles']],
                            //['label' => 'Rep-Admit28', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/readmit/readmit']],
							
                        ],
                    ],
                    [
                        'label' => 'นำเข้า TextFiles', 'icon' => 'cog text-orange', 
                        'items' => [
                            ['label' => 'นำเข้าไฟล์สิทธิ์ สปสช.', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/importtext/import']],
                            //['label' => 'Paliiative-MultiFiles', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/textfiles/multitextfiles']],
                            //['label' => 'MultiFiles-Test', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/textfiles/multitext']],
                          
                        ],
                    ],
                    // ['label' => 'Login', 'url' => ['/user/security/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'จัดการเว็บไซต์', 'icon' => 'cog', 'visible' => !Yii::$app->user->isGuest,
                        'items' => [
                            ['label' => 'Log_ht', 'icon' => 'fas fa-play text-aqua', 'url' => ['/logdmhtdt/index'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Log_dm', 'icon' => 'fas fa-play text-aqua', 'url' => ['/logdm/index'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Log_dt', 'icon' => 'fas fa-play text-aqua', 'url' => ['/logdt/index'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Test_epidemx', 'icon' => 'fas fa-play text-aqua', 'url' => ['/epidemx/check'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'Test_d506x', 'icon' => 'fas fa-play text-aqua', 'url' => ['/d506t/check'], 'visible' => !Yii::$app->user->isGuest],
                        ],
                    ],
                    [
                        'label' => '16แฟ้ม Palliative', 'icon' => 'cog text-orange', 
                        'items' => [
                            ['label' => 'นำเข้าExcel-Palliative', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['textfiles/index']],
                            ['label' => 'ส่งออก 16 แฟ้ม Palliative', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/textfiles/exporttextnon']],
							
                        ],
                    ],
                    [
                        'label' => 'Converts', 'icon' => 'cog text-orange', 
                        'items' => [
                            ['label' => '16F_pcu', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['convert16/index']],
                           // ['label' => 'ส่งออก 16 แฟ้ม Palliative', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/textfiles/exporttextnon']],
							
                        ],
                    ],
					[
                        'label' => 'REP', 'icon' => 'cog text-orange', 
                        'items' => [
                            ['label' => 'นำเข้าไฟล์Excel', 'icon' => 'fas fa-play text-aqua', 'url' => ['repimport2/importx']],
                            ['label' => 'นำเข้าไฟล์Rep', 'icon' => 'fas fa-play text-aqua', 'url' => ['repimport/imports']],
							['label' => 'รายงาน Repส่งการเงิน', 'icon' => 'fas fa-play text-aqua', 'url' => ['rep/rep']],
							['label' => 'Upload excel', 'icon' => 'fas fa-play text-aqua', 'url' => ['import/index']],
							['label' => 'นำเข้าไฟล์excelทดสอบ', 'icon' => 'fas fa-play text-aqua', 'url' => ['repimport/index']],
                        ],
                    ],
                    [
                        'label' => 'นำเข้าไฟล์', 'icon' => 'cog text-orange', 
                        'items' => [
                            ['label' => 'นำเข้าไฟล์Palliative', 'icon' => 'fas fa-play text-aqua', 'url' => ['textfiles/imports']],
                            ['label' => 'นำเข้าไฟล์Authencode', 'icon' => 'fas fa-play text-aqua', 'url' => ['authenimport/imports']],
                            ['label' => 'นำเข้าไฟล์Rep', 'icon' => 'fas fa-play text-aqua', 'url' => ['repimport/imports']],
							//['label' => 'นำเข้าไฟล์csv', 'icon' => 'fas fa-play text-aqua', 'url' => ['site/import']],
							//['label' => 'Upload excel', 'icon' => 'fas fa-play text-aqua', 'url' => ['import/index']],
							//['label' => 'นำเข้าไฟล์excelทดสอบ', 'icon' => 'fas fa-play text-aqua', 'url' => ['repimport/index']],
                        ],
                    ],
                    [
                        'label' => 'จัดการเว็บไซต์', 'icon' => 'cog', 'visible' => !Yii::$app->user->isGuest,
                        'items' => [
                            ['label' => 'หมวดหมู่', 'icon' => 'circle-o text-aqua', 'url' => ['/newscategory/index'], 'visible' => !Yii::$app->user->isGuest],
                            ['label' => 'หัวข้อ', 'icon' => 'circle-o text-aqua', 'url' => ['/news/admin'], 'visible' => !Yii::$app->user->isGuest],
                        ],
                    ],
                    Yii::$app->user->isGuest ?
                        ['label' => 'เข้าสู่ระบบ', 'icon' => 'sign-in text-green', 'url' => ['/user/security/login']] : [
                            'label' => 'ยินดีต้อนรับ (' . Yii::$app->user->identity->username . ')',
                            'items' => [
                                ['label' => 'โพรไฟล์', 'icon' => 'user', 'url' => ['/user/profile']],
                                //['label' => 'Debug', 'icon' => 'dashboard-alt', 'url' => ['/debug']],
                                ['label' => 'จัดการผู้ใช้', 'icon' => 'user-secret', 'url' => ['/user/admin/index']],
                            ]
                        ],
                ],
            ]
			
        ) ?>


                -->