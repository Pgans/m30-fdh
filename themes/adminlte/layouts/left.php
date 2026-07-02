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

<aside class="main-sidebar" style="background-color: #007979 ;">

    <section class="sidebar">
		<style>

/* พื้นหลัง /* hover */
.sidebar-menu > li > a:hover {
    background-color: #d8bce9;
    color: #fff;
}

/* active */
.sidebar-menu > li.active > a {
    background-color: #06bfaa !important;
    color: #fff !important;
}
/* hover เป็นเขียวอ่อน */
.main-sidebar .sidebar-menu > li > a:hover {
    background-color: #06bfaa !important; /*  */
    color: #fff !important;
}
* Submenu */
.main-sidebar .sidebar-menu .treeview-menu {
    background-color: #06bfaa !important; /* ม่วงอ่อน */
    padding-left: 10px;
    border-left: 3px solid #b07cd7; /* เส้นนำสายตา */
    border-radius: 6px;
}

/* Submenu item */
.main-sidebar .sidebar-menu .treeview-menu > li > a {
    background: linear-gradient(135deg, #b0e2d6, #ebc5fa) !important;
    color: #333 !important;
    border-radius: 4px;
    margin: 2px 6px;
    padding: 6px 10px; /* เพิ่มระยะห่างเล็กน้อยให้สวย */
    display: block;   /* ทำให้ลิงก์เต็มแถว */
    transition: all 0.3s ease; /* เพิ่มเอฟเฟกต์ transition */
}

/* Hover submenu */
.main-sidebar .sidebar-menu .treeview-menu > li > a:hover {
    background: linear-gradient(135deg, #06bfaa, #00d4ff) !important; /* ไล่สีเขียวฟ้า */
    color: #fff !important;
    transform: translateX(4px); /* ขยับเล็กน้อยตอน hover ให้รู้สึก interactive */
}

</style>

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
                    ['label' => 'Menu', 'options' => ['class' => 'header','style' => 'background-color: #356a6a; color: white;']],
					['label' => 'พัฒนาปรับปรุง', 'icon' => 'cog text-orange', 'url' => ['/logrequests/index']],
					['label' => 'Dashboard', 'icon' => 'cog text-orange', 'url' => ['/computer/authen']],
					##['label' => 'วันหยุดราชการ', 'icon' => 'cog text-orange', 'url' => ['/holiday/index']],
					['label' => 'Thalassemia(D569)', 'icon' => 'cog text-orange', 'url' => ['d569/index']],
					##['label' => 'ใบค่ารักษาExcel', 'icon' => 'cog text-orange', 'url' => ['medical-invoice/index']],
					##['label' => 'C305_oppp', 'icon' => 'cog text-orange', 'url' => ['oppp/index']],
					##['label' => 'Dashboard-รายเดือน', 'icon' => 'cog text-orange', 'url' => ['rptfdh/reportall']],
					##['label' => 'DashboardLock', 'icon' => 'cog text-orange', 'url' => ['dashboardlock/index']],
					##['label' => 'CMI43แฟ้ม-HomeWard', 'icon' => 'cog text-orange', 'url' => ['importtextproc/import-zip']],
					##['label' => 'OP_AnyWhere', 'icon' => 'cog text-orange', 'url' => ['f16opae/index']],
					##['label' => 'FDH-PCU', 'icon' => 'cog text-orange', 'url' => ['f16janc/index']],
					##['label' => 'ตรวจสอบสถานะเคลม', 'icon' => 'cog text-orange', 'url' => ['checkopd/index3']],
					[
                        'label' => 'อุทธรณ์', 'icon' => 'cog text-orange', 'visible' => !Yii::$app->user->isGuest,
                        'items' => [
                            
							['label' => 'C305_OPPP', 'icon' => 'cog text-orange', 'url' => ['oppp/index']],
							['label' => 'C305_KTP', 'icon' => 'cog text-orange', 'url' => ['ktp305/index']],
							['label' => 'C305_FDH_Claim', 'icon' => 'cog text-orange', 'url' => ['fdh305/index']],
							['label' => 'C305_จิตเวช', 'icon' => 'cog text-orange', 'url' => ['psychia305/index']],
							['label' => 'C305_กายภาพ', 'icon' => 'cog text-orange', 'url' => ['phisycal305/index']],
							
							
                        ],
					],
                    [
                        'label' => 'FDH-PCU', 'icon' => 'cog text-orange', 
                        'items' => [
							 ['label' => 'ANC-mBAse', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancspcu/index']],
							 ['label' => 'ANC-JHCIS', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16janc/index']],							 
							 ['label' => 'เยี่ยมหลังคลอด(jhcis)', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16janccare/index']],
							 ['label' => 'เยี่ยมหลังคลอด(mbase)', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16anccare/index']],
                            ['label' => 'FitTest(mbase)', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16fittest/index']],
							['label' => 'Jhcis-FitTest', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/fittest/index']],
							['label' => 'สาวไทยแก้มแดง(mbase)', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16thaired/index']],
							['label' => 'สาวไทยแก้มแดง(jhcis)', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16jthaired/index']],
                            ##['label' => 'สุขภาพกาย-จิต[UCS]', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16screenmental/index']],
							['label' => 'ส่งวัคซีน-HPV(mbase)', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/hpv/hpv']],
                            ['label' => 'ส่งวัคซีนเด็กm-claim(mbase)', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/mbaseepi/epi']],
                            ['label' => 'ส่งวัคซีนjhcis(moph-claim)', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/hjepi/hjepi']],
							# ['label' => 'Rep-Visit48', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/readmit/revisit']],
							# ['label' => 'Unplan-Refer', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/readmit/unplan']],
                        ],
                    ],
					/*
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
					/*
					[
                        'label' => 'ตรวจสอบสถานะเคลม', 'icon' => 'cog text-orange', 
                        'items' => [
                            ['label' => 'OPD', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/checkopd/index']],
                            ['label' => 'IPD', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/checkipd/index']],
							
                        ],
                    ],
					*/
					/*
					[
                        'label' => 'การจองเคลม', 'icon' => 'cog text-orange', 
                        'items' => [
							['label' => 'จองเคลมHW', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/closevisithw/index']],
                            ['label' => 'จองเคลมตรวจเสร็จ', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/closevisit/index']],
                            ['label' => 'จองเคลมเก็บตก', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/closevisit1/index']],
							['label' => 'ยกเลิกจองเคลม', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/checkipdx/index']],
							['label' => 'ค้นหาการจองเคลม', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/logclosevisits/index']],
							['label' => 'jhcis_จองเคลม', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/closevisitjhcis/index']],
                            ['label' => 'jhcis_ค้นหาจองเคลม', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/logclosevisitsj/index']],
							['label' => 'op_uuc2', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16uuc2/index']],
                        ],
                    ],
					*/
					[
                        'label' => 'Total Visits', 'icon' => 'cog text-orange', 
                        'items' => [
                             ['label' => 'OPD', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/totalvisits/index']],
							 ['label' => 'IPD', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/totalvisitsipd/index']],
							 ['label' => 'DashBoard', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/dashtotalvisit/index']],
							
						],	
                     ],
					[
                        'label' => 'สิทธิ์ข้าราชการ', 'icon' => 'cog text-orange', 'visible' => !Yii::$app->user->isGuest,
                        'items' => [
                            ## ['label' => 'ผู้ป่วยในข้าราชการ', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ipofc/index']],
							 ['label' => 'ผู้ป่วยนอกข้าราชการ', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16opofc/index']],
							//['label' => 'ANC+Dent+US', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancdentus/index']],
							
						],	
                     ],
                    
					[
                        'label' => 'สิทธิ์ อปท.', 'icon' => 'cog text-orange', 'visible' => !Yii::$app->user->isGuest,
                        'items' => [
                            ## ['label' => 'ผู้ป่วยใน อปท.', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16iplgo/index']],
							 ['label' => 'ผู้ป่วยนอก อปท.', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16oplgo/index']],
							//['label' => 'ANC+Dent+US', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancdentus/index']],
							
							
                        ],
					],
					[
                        'label' => 'สิทธิ์ ขสมก.', 'icon' => 'cog text-orange', 'visible' => !Yii::$app->user->isGuest,
                        'items' => [
                           ##  ['label' => 'ผู้ป่วยใน ขสมก.', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ipbmta/index']],
							 ['label' => 'ผู้ป่วยนอก ขสมก.', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16opbmta/index']],
							//['label' => 'ANC+Dent+US', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancdentus/index']],
							
							
                        ],
					],
					[
                        'label' => 'ช้าราชการ กทม.', 'icon' => 'cog text-orange', 'visible' => !Yii::$app->user->isGuest,
                        'items' => [
                            ## ['label' => 'ผู้ป่วยใน กทม.', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ipbangkok/index']],
							 ['label' => 'ผู้ป่วยนอก กทม.', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16opbangkok/index']],
							//['label' => 'ANC+Dent+US', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancdentus/index']],
							
							
                        ],
					],
					[
                        'label' => 'การรถไฟแห่งประเทศไทย', 'icon' => 'cog text-orange', 'visible' => !Yii::$app->user->isGuest,
                        'items' => [
                            ## ['label' => 'ผู้ป่วยใน กทม.', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ipbangkok/index']],
							 ['label' => 'ผู้ป่วยนอกสิทธิ์การรถไฟ.', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16oprailway/index']],
							//['label' => 'ANC+Dent+US', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancdentus/index']],
							
							
                        ],
					],
					[
                        'label' => 'สิทธิ์ครูเอกชน', 'icon' => 'cog text-orange', 'visible' => !Yii::$app->user->isGuest,
                        'items' => [
                            ## ['label' => 'ผู้ป่วยใน กทม.', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ipbangkok/index']],
							 ['label' => 'ผู้ป่วยนอกสิทธิ์ครูเอกชน.', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16opteacher/index']],
							//['label' => 'ANC+Dent+US', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancdentus/index']],
							
							
                        ],
					],
					[
                        'label' => 'หญิงตั้งครรภ์', 'icon' => 'cog text-orange', 
                        'items' => [
                             ['label' => 'ANC*', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancs/index']],
							['label' => 'ANC+Dent', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancdent/index']],
							['label' => 'ANC+Dent+US', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancdentus/index']],
							['label' => 'ANC+Dent+UPT', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancdentupt/index']],
							['label' => 'ANC+Dent+US+Lab1', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancdentuslab1/index']],
							['label' => 'ANC+Dent+US+Lab2', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancdentuslab2/index']],
							['label' => 'ANC+Dent+US+Lab1+UPT*', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancdentuslab1upt/index']],
							['label' => 'ANC+US+Lab1+UPT', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancuslab1upt/index']],
							['label' => 'ANC+US+UPT', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancusupt/index']],
							['label' => 'ANC+US', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancus/index']],							
							['label' => 'ANC+US+Lab1', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancuslab1/index']],  //Hn 020146
							['label' => 'ANC+US+Lab2', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancuslab2/index']],  //Hn 020146
							['label' => 'Dent', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16dent/index']],
							['label' => 'Dent+Lab1', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16dentlab1/index']],
							['label' => 'Dent+Lab2', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16dentlab2/index']],
							['label' => 'Lab1', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16lab1/index']],
							['label' => 'Lab2', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16lab2/index']],
							['label' => 'ANC+Dent+Lab1', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancdentlab1/index']],
							['label' => 'ANC+Dent+Lab2', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancdentlab2/index']],
							['label' => 'ANC+Lab1+UPT', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16anclab1upt/index']],
							['label' => 'ANC+Lab1', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16anclab1/index']],
							['label' => 'ANC+Lab2', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16anclab2/index']],
							['label' => 'ANC+UPT', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ancupt/index']],
                        ],
                    ],
						/*
					[
                        'label' => 'OP_AnyWhere', 'icon' => 'cog text-orange', 
                        'items' => [
							['label' => 'OPAE', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16opae/index']],
							['label' => 'Walkinนอกจังหวัด', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16walkinout/index']],
                            ['label' => 'Walkinในจังหวัด', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16walkinin/index']],
							['label' => 'UC สิทธิ์เกิดทันที', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16oparise/index']],
							['label' => 'สิทธิ์ว่าง/มาตรา8', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16opsec8/index']],
                        ],
                    ],
						*/		
					[
                        'label' => 'ผู้ป่วยนอก', 'icon' => 'cog text-orange', 
                        'items' => [
						   // ['label' => 'op_จ่ายถุงยางอนามัย', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16condom/index']],
							//['label' => 'op_ฟันปลอม', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16dentures/index']],
                           // ['label' => 'op_นัดรากฟันเทียม', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16implants/index']],
                            ['label' => 'op_ฝังเข็ม*', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16opimc/index']],
							['label' => 'op_ฝังยาคุมกำเนิด', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16oppills/index']],
							['label' => 'op_ฝัง-ถอนยาคุมกำเนิด*', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16optonpills/index']],
							['label' => 'op_ถอนยาคุมกำเนิด*', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16oppillston/index']],
							['label' => 'op_ฝัง-ถอนยาคุม+upt', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16optonpillsupt/index']],
						    ['label' => 'op_ฝังยาคุม+upt', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16pillupt/index']],
							['label' => 'op_ถอนยาคุม+upt', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16pilltonupt/index']],
                            ['label' => 'op_stemi', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16stemi/index']],
							['label' => 'op_Clopidogrel', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16clopi/index']],
						    ['label' => 'op_UPT', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16upt/index']],
							['label' => 'op_Health Rider*', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16rider/index']],
							['label' => 'op_Instrument*', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16opinstru/index']],
                            ['label' => 'op_Telemed*', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16telemed/index']],
                            ['label' => 'op_Herb', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16herb/index']],
							['label' => 'op_HerbNew*', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16herbnew/index']],
							['label' => 'op_Palliative', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16palliative/index']],
							['label' => 'op_uuc2', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16uuc2/index']],
							   # ['label' => 'ANC-DENT', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16ancdent/index']],
							   # ['label' => 'Opd_List', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16opdsend/index']],
							   # ['label' => 'F16-AN', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16an/index']],
							   # ['label' => 'F16-IPD-ช่วงเวลา', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16only/index']],
							   # ['label' => 'F16-OPD-ช่วงเวลา', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16opd/index']],
							   # ['label' => 'F16-OPD-Visits', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16visits/index']],
							   # ['label' => 'จองเคลม', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/closevisit/index']],
							   # ['label' => 'OP-UCEP', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16opucep/index']],
							   # ['label' => 'Er_Ext', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16erext/index']],
                        ],
                    ],
                    [
                          'label' => 'ผู้ป่วยใน', 'icon' => 'cog text-orange',# 'visible' => !Yii::$app->user->isGuest,
                           #'label' => 'ผู้ป่วยใน','icon' => '<img src="@web/images/com002.jpg" alt="icon">',   

                        'items' => [
							['label' => 'C514', 'icon' => 'fas fa-play text-aqua', 'url' => ['/check514/index']],
                            ['label' => 'ip_Normal', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16ipnormal/index']],
                            ['label' => 'ip_HomeWard', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16homeward/index']],
							##['label' => 'ip_HomeWard2', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16homeward2/index']],
                            //['label' => 'ip_Ucep', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16ipucep/index']],
							//['label' => 'ip_ฝังยาคุม', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16ippills/index']],
                            //['label' => 'ip_ae', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16ipae/index']],
                            //['label' => 'ip_referin', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16ipreferin/index']],
							// ['label' => 'ip_referin-out', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16ipreferinout/index']],
							//['label' => 'ipaeนอกเครือข่าย+ Referin', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16ipaereferin/index']],
                            //['label' => 'ip_ผู้มีปัญหาสถานะสิทธิ์', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16ipstp/index']],
                           # ['label' => 'F16-OPD-ช่วงเวลา', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16opd/index']],
                           # ['label' => 'F16-OPD-Visits', 'icon' => 'fas fa-play text-aqua', 'url' => ['/f16visits/index']],
						   # ['label' => 'จองเคลม', 'icon' => 'fas fa-play text-aqua', 'url' => ['/closevisit/index']],
                        ],
                    ],
					/*
                    [
                        'label' => 'FDH-JHCIS', 'icon' => 'cog text-orange', 
                        'items' => [
							 ['label' => 'ANC', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16janc/index']],
							 ['label' => 'เยี่ยมหลังคลอด', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16janccare/index']],
                            ['label' => 'Fit Test', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/fittest/index']],
							['label' => 'สาวไทยแก้มแดง', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16jthaired/index']],
                            ['label' => 'สุขภาพกาย-จิต[UCS]', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/f16screenmental/index']],
                            ['label' => 'สุขภาพกาย-จิต[Non-UC]', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/convert16sss/index']],
                            # ['label' => 'ANC-ฝากครรภ์', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/anc/index']],
							# ['label' => 'Rep-Visit48', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/readmit/revisit']],
							# ['label' => 'Unplan-Refer', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/readmit/unplan']],
                        ],
                    ],
					*/
							[
								'label' => 'ศูนย์จัดเก็บรายได้',
								'icon' => 'cog text-orange',
								'url' => ['/referopd/index3'],
								'visible' => !Yii::$app->user->isGuest, // แสดงเมื่อ login แล้ว
							],

					/*
					[
                        'label' => 'ศูนย์จัดเก็บรายได้', 'icon' => 'cog text-orange', 
                        'items' => [
							['label' => 'ประมวลผลการส่งต่อ', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/referopd/index']],
							['label' => 'ประมวลผลผู้ป่วยนอก', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/opd/index']],
							['label' => 'ประมวลผลผู้ป่วยใน', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/ipd/index']],
							['label' => 'ต่างด้าว OPD', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/thangopd/index']],
							['label' => 'ต่างด้าว IPD', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/thangipd/index']],
							['label' => 'ต่างด้าวแม่มาคลอด', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/thangdown/index']],
                            ['label' => 'Refer>2', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/adjrw/refer']],
                            ['label' => 'ยอดผู้ป่วยใน', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/adjrw/adjipd']],
                            ['label' => 'ยอดผู้ป่วยนอก', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/adjrw/opdtotal']],
                            ['label' => 'Rep-Admit28', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/readmit/readmit']],
							['label' => 'Rep-Visit48', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/readmit/revisit']],
							['label' => 'Unplan-Refer', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/readmit/unplan']],
							['label' => 'Refer-ER', 'icon' => 'fa fa-check-square-o text-aqua', 'url' => ['/readmit/referopd']],							
							
                        ],
						
                    ],
					*/
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
