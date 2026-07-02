<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\editable\Editable;
use yii\widgets\Pjax;

$this->title = 'Epidem Covid19';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['rep/index']];
//$this->params['breadcrumbs'][] = 'รายงานข้อมูลE-Claim แยกตามREP';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dose1</title>
</head>

<body>
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
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                                <h6>ผ่านตามเงื่อนไขวันนี้</h6>
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
                        <div class="col-auto">
                            <div class="col-auto">
                                <a href="#" class="popup-link" data-url="<?= yii\helpers\Url::to(['/log/logepidem']) ?>">
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
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>

                            <div class="col-auto">
                                <a href="#" class="popup-link" data-url="<?= yii\helpers\Url::to(['/log/logepidem']) ?>">
                                    <img src="images/reject.76840914.svg" title="ไม่ผ่าน" width="70" height="60">
                                </a>
                            </div>
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
                        <div class="col-auto">
                            <img src="images/waitmoph.98529de4.svg" title="ยอดทั้งหมด" width="70" height="60">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= Html::beginForm(['epidem/check'], 'post', ['name' => 'frmMain']); ?>
    <!-- <?= Html::beginForm(['epidem/visits'], 'post', ['name' => 'frmMain']); ?>  -->
    <!-- <form id="checkbo" name="frmMain" action="epidem/visit" method="post"> -->
    <input name="btnButton1" class="btn btn-success btn btn-block" id="selectAll" type="submit" name="selectAll" value="ส่งข้อมูล Epidem Covid-19">
    <input type="checkbox" id="selectAll">
    <table class="table table-striped" border="0">
        <tr>
            <th width="30">
                <div align="center">
                    <!-- <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);"> -->
                    <input type="checkbox" id="selectAll">
                </div>
            <td width="30">
                <div align="center" id="grad2"> # </div>
            </td>
            <td width="30">
                <div align="center" id="grad2"> วันที่ </div>
            </td>
            <td width="30">
                <div align="center" id="grad2"> Visit </div>
            </td>
            <td width="50">
                <div align="left" id="grad2"> Cid </div>
            </td>
            <td width="30">
                <div align="left" id="grad2"> Hn </div>
            </td>
            <td width="30">
                <div align="left" id="grad2"> An </div>
            </td>
            <td width="30">
                <div align="left" id="grad2"> ตึก </div>
            </td>
            <td width="150">
                <div align="left" id="grad2"> ชื่อ-สกุล </div>
            </td>
            <td width="30">
                <div align="left" id="grad2"> Diag </div>
            </td>

            <td width="30">
                <div align="left" id="grad2"> แผนก
            </td>
            <td width="30">
                <div align="left" id="grad2"> Lab
            </td>
            <td width="30">
                <div align="left" id="grad2"> วัคซีน
            </td>
            <td width="30">
                <div align="left" id="grad2"> อาการ
            </td>
        </tr>
        <?php
        foreach ($epidemProvider->getModels() as $key => $value) :
        ?>
            <tr>
                <td>
                    <div align="center"><input type="checkbox" name="chkDel[]" <?php echo 'checked'; ?> id="chkDel<?= $i; ?>" value="<?php echo $value["visit_id"]; ?><?php echo $value["cid"]; ?>">
                </td>

                <td class="badge"><?php echo  $value["No"]; ?>
                    </div>
                </td>
                <td class="text-nowrap"><?php echo $value["regdate"]; ?></div>
                </td>
                <td><?php echo $value["visit_id"]; ?></div>
                </td>
                <td><?php echo $value["cid"]; ?></div>
                </td>
                <td><?php echo $value["hn"]; ?></div>
                </td>
                <td><?php echo $value["An"]; ?></div>
                </td>
                <td><?php echo $value["ward"]; ?></div>
                </td>
                <td class="text-nowrap" style="color:green"><?php echo $value["fullname"]; ?></td>
                <td><?php echo $value["Diag"]; ?></div>
                </td>
                <td class="text-nowrap" style="color:green"><?php echo $value["unit_name"]; ?></div>
                </td>
                <td class="text-nowrap"><?php echo $value["Lab"]; ?></div>
                </td>
                <td class="text-nowrap" style="color:brown"><a><?php echo $value["Vaccine"]; ?></a></div>
                </td>
                <td><?php echo $value["symtom"]; ?></div>
                </td>
            </tr>
        <?php endforeach; ?>
        <input type="hidden" name="hdnCount" value="<?= $i; ?>">
    </table>
    </form>

    </div>
    </div>
    </div>
</body>

</html>
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