<?php

use kartik\grid\GridView;
use yii\helpers\Html;
//use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\base\DynamicModel;
use yii\widgets\ActiveForm;


//use common\models\RContributionIpd;
use yii\data\ActiveDataProvider;

$this->title = 'Convert Files';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['thaimed/index']];

?>
<br>
<h2 style="color: white; font-size: 32px; background-color: #009191; border: 4px solid #8affc5;" class="badge">
    คัดกรองสุขภาพกาย-จิต (รวมทุกสิทธิ์)->JHCIS-PCU
</h2>


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

                            <?php echo Html::a('Update ตาราง all_ucs_ncd_screen', ['updateall'], [
                                'class' => 'btn btn-info',
                                'style' => 'border-color: #6affb5;', // Replace #your_border_color with your desired color code
                            ]);
                            ?>
                            <!-- <div class="text-center">
                                <a href="<?= \yii\helpers\Url::to(['convert16all/imports']) ?>" class="btn btn-success" style="font-size: 16px;">
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
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            <h2 style="color: white; font-size: 28px; border: 4px solid #afd8d8;" class="badge btn-info">
                                2
                            </h2>
                            <h3>ประมวลผล</h3>
                        </div>
                
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                            <img src="images/reject.76840914.svg" title="ไม่ผ่าน" width="70" height="60">
                        </div>
                        
                        <?php
$form = ActiveForm::begin([
    'action' => ['convert16all/update'],
    'method' => 'post',
]);
?>

<div class="form-group">
    <label for="date1">ระหว่างวันที่:</label>
    <?= yii\jui\DatePicker::widget([
        'name' => 'date1',
        'value' => $date1,
        'language' => 'th',
        'dateFormat' => 'yyyy-MM-dd',
        'clientOptions' => [
            'changeMonth' => true,
            'changeYear' => true,
        ],
        'options' => ['class' => 'form-control']
    ]); ?>
</div>

<div class="form-group">
    <label for="date2">ถึงวันที่:</label>
    <?= yii\jui\DatePicker::widget([
        'name' => 'date2',
        'value' => $date2,
        'language' => 'th',
        'dateFormat' => 'yyyy-MM-dd',
        'clientOptions' => [
            'changeMonth' => true,
            'changeYear' => true,
        ],
        'options' => ['class' => 'form-control']
    ]); ?>
</div>

<div class="form-group">
    <?= Html::submitButton('ตกลง', ['class' => 'btn btn-danger']) ?>
</div>

<?php ActiveForm::end(); ?>
                    </div>
                   
                        <p>มี5แฟ้ม- PAT, OPD, ADP, INS, ODX</p>
                    </div>
                </div>
            </div>
        </div>


        <!-- ######################################################################################################################### -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-left-danger shadow h-100 py-2">
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
    <div id="success-alert" class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>

    <script>
        // Automatically hide the success alert after 1 minute (30 seconds)
        setTimeout(function() {
            document.getElementById('success-alert').style.display = 'none';
            // Reset form fields
            document.getElementById('date1').value = '';
            document.getElementById('date2').value = '';
            // Redirect to convert16all/index after 1 minute
            setTimeout(function() {
                window.location.href = '<?= Yii::$app->urlManager->createUrl(['convert16all/index']) ?>';
            }, 1000); // 1000 milliseconds = 1 second
        }, 30000); // 60,000 milliseconds = 30 seconds
    </script>
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
        <script>
    document.getElementById('refreshButton').addEventListener('click', function () {
        // Disable the button to prevent multiple clicks
        this.disabled = true;

        // Set $date1 and $date2 to empty values
        <?php $date1 = ''; ?>
        <?php $date2 = ''; ?>

        // Redirect or perform other actions as needed
        window.location.href = 'convert16all/update';
    });
</script>
<script>
    // Add a script to reset form values after submission
    document.getElementById('myForm').addEventListener('submit', function () {
        setTimeout(function () {
            document.getElementsByName('date1')[0].value = '';
            document.getElementsByName('date2')[0].value = '';
        }, 1000); // Adjust the delay (in milliseconds) based on your needs
    });
</script>
        