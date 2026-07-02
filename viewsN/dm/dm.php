<?php

namespace app\controllers;

use Yii;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\editable\Editable;
use yii\widgets\Pjax;

$this->title = 'DM';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['rep/index']];
//$this->params['breadcrumbs'][] = 'รายงานข้อมูลE-Claim แยกตามREP';
?>

<!-- <script type="text/javascript">
setTimeout("frmMain.submit();",60000);
//5000 อยากได้เร็วก็กำหนดตัวเลขน้อยๆเอานะ
</script>   -->

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
<h2 style="color: yellow; font-size: 32px;" class="badge btn-info">
    Moph Claim DM
</h2>
<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                            <h6>ผ่านตามเงื่อนไข</h6>
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    <span><?php echo $amount ?></span>
                                </div>
                            </div>
                            <div class="col">
                                <!-- <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div> -->
                            </div>
                        </div>
                    </div>
                    <?= Html::a('แสดงรายการ', null, ['class' => 'btn btn-success', 'id' => 'link1']) ?>
                    <div class="col-auto">
                        <div class="col-auto">
                            <a href="<?= \yii\helpers\Url::to(['/dm/log_dm']) ?>" target="_blank">
                                <img src="images/accept.svg" title="ข้อมูลสำเร็จ" width="70" height="60">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                            <h6>ไม่ผ่านตามเงื่อนไข</h6>
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    <span><?php echo $amountx ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?= Html::a('แสดงรายการ', null, ['class' => 'btn btn-danger', 'id' => 'link2']) ?>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>

                        <div class="col-auto">

                            <!-- <a href="#" class="popup-link" data-url="<?= yii\helpers\Url::to(['/log/dm']) ?>"> -->
                            <img src="images/reject.76840914.svg" title="ไม่ผ่าน" width="70" height="60">
                            </a>
                            <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg"> <!-- Add the desired size class, e.g., modal-lg or modal-sm -->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Data fetched from the URL will be displayed here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                            <h6>รายการส่งผ่านทั้งหมด</h6>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <span> <?php echo $total ?></span>
                        </div>
                    </div>
                    <?= Html::a('<i class="fas fa-sync-alt"></i> Refresh', ['dm/dm'], ['class' => 'btn btn-info', 'id' => 'link3']) ?>
                    <div class="col-auto">
                        <img src="images/waitmoph.98529de4.svg" title="ยอดทั้งหมด" width="70" height="60">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= Html::beginForm(['dm/check'], 'post', ['name' => 'frmMain']); ?>

<input name="btnButton1" class="btn btn-info btn btn-block" id="grad001" id="deleteAll" type="submit" name="select" id="grad1" value="ส่งข้อมูล Moph-Claim DM">
<!-- <?= Html::a('Submit', ['check'], ['class' => 'btn btn-success pull-right']) ?> -->
<!-- <?= Html::button(Yii::t('app', 'dmht'), ['class' => 'btn btn-warning pull-right', 'id' => 'check']) ?> -->
<input type="checkbox" id="selectAll">

<table class="table table-striped" width="1100" border="0">
    <tr>
        <th width="30">
            <div align="center">
                <!-- <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);"> -->
                <input type="checkbox" id="selectAll">
            </div>
        <td width="30">
            <div><a># </a></div>
        </td>
        <td width="30" style="font-size: 14px;">
            <div> <a>วันที่ </a></div>
        </td>
        <td width="30" style="font-size: 14px;">
            <div><a>Visit</a> </div>
        </td>
        <td width="30" style="font-size: 14px;">
            <div><a href="">Hn</a> </div>
        </td>

        <td width="150" style="font-size: 14px;">
            <div><a href="">ชื่อ-สกุล</a> </div>
        </td>
        <td width="30" style="font-size: 14px;">
            <div> <a href="">Diag</a> </div>
        </td>
        <td width="30" style="font-size: 14px;">
            <div><a>Lab</a></div>
        </td>
        <td width="30" style="font-size: 14px;">
            <div><a href="">แผนก</a> </div>
        </td>
        <td width="30" style="font-size: 14px;">
            <div><a href="">authencode</a> </div>
        </td>
    </tr>
    <?php
    foreach ($dmProvider->getModels() as $key => $value) :
    ?>
        <tr>

            <td><input type="checkbox" name="chkDel[]" <?php echo 'checked'; ?> id="chkDel<?= $i; ?>" value="<?php echo $value["visit_id"]; ?><?php echo $value["hn"]; ?>">
            <td class="badge"><?php echo  $value["No"]; ?>
                </div>
            </td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["regdate"]; ?></div>
            </td>
            <td style="font-size: 14px;"><?php echo $value["visit_id"]; ?></div>
            </td>
            <td style="font-size: 14px;"><?php echo $value["hn"]; ?></div>
            </td>
            </td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["fullname"]; ?></td>
            <td><?php echo $value["Diag"]; ?></div>
            </td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["labname"]; ?></div>
            </td>
            <td class="text-nowrap" style="font-size: 14px;"><?php echo $value["unit_name"]; ?></div>
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

<!-- ############################## PASS ################################################################# -->
<div id="model1" style="display: none;">
    <h2 style="color: #155724; border: 2px solid #c3e6cb; padding: 5px;">แสดงรายการผ่าน</h2>

    <?= \yii\grid\GridView::widget([
        'dataProvider' => $passProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'visit_id',
            'pid',
            'status',
            'response',
            'd_update',
        ],
        'tableOptions' => ['class' => 'table table-striped'], // เพิ่มคลาส CSS ให้กับตาราง GridView
    ]); ?>

</div>

<!-- ############################## ERROR ################################################################# -->
<div id="model2" style="display: none;">
    <h2 style="color: #721c24; border: 2px solid #f5c6cb; padding: 5px;">แสดงรายการไม่ผ่าน</h2>

    <?= \yii\grid\GridView::widget([
        'dataProvider' => $errorProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'visit_id',
            'pid',
            'status',
            'response',
            'd_update',
        ],
        'tableOptions' => ['class' => 'table table-striped'], #ff00ff // เพิ่มคลาส CSS ให้กับตาราง GridView
    ]); ?>

</div>

<!-- ############################################################################################### -->



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