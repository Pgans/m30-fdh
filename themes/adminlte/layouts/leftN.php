<?php

use yii\bootstrap\Html;
use yii\helpers\Url;

// $command3 = Yii::$app->db->createCommand("SELECT company FROM setting WHERE id='1'");
// $company = $command3->queryScalar();
//
// $command4 = Yii::$app->db->createCommand("SELECT photo FROM setting WHERE id='1'");
// $logo = $command4->queryScalar();
if (Yii::$app->user->isGuest) {
    $name='Guest';
    $username='Guest';
 }else{
 $user_id = Yii::$app->user->identity->id;
 $command3 = Yii::$app->db->createCommand("SELECT name FROM profile WHERE user_id='$user_id'");
 $name = $command3->queryScalar();

 $username = Yii::$app->user->identity->username;
 }

?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Yii::getAlias('@web') . '/images/moph.png' ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">

                <?php if (Yii::$app->user->isGuest) { ?>

                    <a href="#"><i class="fa fa-circle text-red"></i> Offline</a>
                <?php } else { ?>
                    <p><?= $name ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                <?php } ?>


            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..." />
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
					/*
                    [
                        'label' => 'เวชระเบียนผู้ป่วยนอก', 'icon' => 'cog text-orange', 
                        'items' => [
                            ['label' => 'บันทึกเวชระเบียนผู้ป่วยนอก', 'icon' => 'fas fa-play text-aqua', 'url' => ['/mraopd/index']],
							['label' => 'ประมวลผล', 'icon' => 'fas fa-play text-aqua', 'url' => ['/mraopd/percent']],
							['label' => 'จัดการแผนก OPD', 'icon' => 'fas fa-play text-aqua', 'url' => ['/mradepartmetnsopd/index']],
                        ],
                    ],
                    [
                        'label' => 'เวชระเบียนผู้ป่วยใน', 'icon' => 'cog text-orange', 
                        'items' => [
                            ['label' => 'บันทึกเวชระเบียนผู้ป่วยใน', 'icon' => 'fas fa-play text-aqua', 'url' => ['/mraipd/index']],
							['label' => 'ประมวลผล', 'icon' => 'fas fa-play text-aqua', 'url' => ['/mraipd/percent']],
							['label' => 'จัดการแผนก IPD', 'icon' => 'fas fa-play text-aqua', 'url' => ['/departmetnsipd/index']],
                        ],
                    ],
					*/
					/*
                    [
                        'label' => 'PROJECTS API', 'icon' => 'cog text-orange', 
                        'items' => [
                            ['label' => 'Dashboard', 'icon' => 'fas fa-play text-aqua', 'url' => ['/dashboard/index']],
                            ['label' => 'ส่งข้อมูล PHR', 'icon' => 'fas fa-play text-aqua', 'url' => ['/phr/phr']],
                            ['label' => 'ส่งข้อมูล Epidem', 'icon' => 'fas fa-play text-aqua', 'url' => ['/epidem/epidem']],
                            ['label' => 'ส่งข้อมูล D506', 'icon' => 'fas fa-play text-aqua', 'url' => ['/d506/d506']],
							['label' => 'ส่งข้อมูล HT', 'icon' => 'fas fa-play text-aqua', 'url' => ['/dmht/ht']],
                            ['label' => 'ส่งข้อมูล DM', 'icon' => 'fas fa-play text-aqua', 'url' => ['/dm/dm']],
                            ['label' => 'ส่งข้อมูล DT', 'icon' => 'fas fa-play text-aqua', 'url' => ['/dt/dt']],
                            ['label' => 'ส่งข้อมูลวัคซีนเด็ก(Epi)', 'icon' => 'fas fa-play text-aqua', 'url' => ['/epi/index']],
                            ['label' => 'ส่งข้อมูลวัคซีน Moph-Claim', 'icon' => 'fas fa-plus text-aqua', 'url' => ['/dm/log_dm']],
                           // ['label' => 'ตรวจสอบการส่ง HT', 'icon' => 'fas fa-plus text-aqua', 'url' => ['/log/send']],
                           //['label' => 'ตรวจสอบการส่ง DT', 'icon' => 'fas fa-plus text-aqua', 'url' => ['/dt/log_dt']],
                           // ['label' => 'ตรวจสอบการส่ง EPIDEM', 'icon' => 'fas fa-plus text-aqua', 'url' => ['/log/logepidem']],
                           // ['label' => 'ตรวจสอบการส่ง PHR', 'icon' => 'fas fa-plus text-aqua', 'url' => ['/log/sendphr']],
							['label' => 'Monitor-43F', 'icon' => 'fas fa-play text-aqua', 'url' => ['/service/index']],
                            ['label' => 'Zero Stock', 'icon' => 'fas fa-play text-aqua', 'url' => ['/drugopd/drugzone']],
                            ['label' => 'Telemed', 'icon' => 'fas fa-play text-aqua', 'url' => ['/telemed/index']],
                        ],
                    ],
                   //yii2  ExportMenu
                    */
					[
                        'label' => 'FDH', 'icon' => 'cog text-orange', 
                        'items' => [
                            ['label' => 'Telemed', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16telemed/index']],
                            ['label' => 'HomeWard', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16homeward/index']],
                            //['label' => 'ANC-DENT', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16ancdent/index']],
                           // ['label' => 'Opd_List', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16opdsend/index']],
                           // ['label' => 'F16-AN', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16an/index']],
							//['label' => 'F16-IPD-ช่วงเวลา', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16only/index']],
                           // ['label' => 'F16-OPD-ช่วงเวลา', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16opd/index']],
                           // ['label' => 'F16-OPD-Visits', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16visits/index']],
							['label' => 'จองเคลม', 'icon' => 'fas fa-play text-aqua', 'url' => ['/closevisit/index']],
                        ],
                    ],
                    [
                        'label' => 'FDH-JHCIS', 'icon' => 'cog text-orange', 
                        'items' => [
                            ['label' => 'Fit Test', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/fittest/index']],
                            ['label' => 'สุขภาพกาย-จิต[UCS]', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16screenmental/index']],
                            ['label' => 'สุขภาพกาย-จิต[Non-UC]', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/convert16sss/index']],
                           // ['label' => 'ANC-ฝากครรภ์', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/anc/index']],
							//['label' => 'Rep-Visit48', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/readmit/revisit']],
							//['label' => 'Unplan-Refer', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/readmit/unplan']],
                        ],
                    ],
					[
                        'label' => 'ศูนย์จัดเก็บรายได้', 'icon' => 'cog text-orange', 
                        'items' => [
                            ['label' => 'Refer>2', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/adjrw/refer']],
                            ['label' => 'AdjRW-IPD', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/adjrw/adjipd']],
                            ['label' => 'ยอดผู้ป่วยนอก', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/adjrw/opdtotal']],
                            ['label' => 'Rep-Admit28', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/readmit/readmit']],
							['label' => 'Rep-Visit48', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/readmit/revisit']],
							['label' => 'Unplan-Refer', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/readmit/unplan']],
                        ],
                    ],
					/*
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
					*/
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
        <ul class="sidebar-menu tree" data-widget="tree">
            <!-- <li class="header"></li> -->
            <?php
            if (Yii::$app->user->isGuest) {
                ?>
                <li>
                    <!-- <a href="<?= Url::to('index.php?r=user/security/login') ?>">
                                    <i class="fa fa-sign-in text-green"></i> <span>เข้าสูระบบ</span>
                                </a> -->
                </li>
            <?php } else { ?>
                <li>
                    <?php
                    echo Html::a(
                        '<i class="fa fa-sign-out text-red"></i>ออกจากระบบ',
                        ['/user/security/logout'],
                        [
                            'data' => [
                                'icon' => 'fa fa-sign-out text-red',
                                'method' => 'post',
                            ],
                        ]
                    );
                    ?>
                </li>
            <?php } ?>
        </ul>
    </section>

</aside>
