<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use dosamigos\datepicker\DatePicker;

$this->title = 'Mbase-สาวไทยแก้มแดง';
$this->registerCss('
    .log-line { padding: 5px; }
    /* ปรับปรุงส่วนตาราง */
    .my-striped-table th {
        background-color: #ff8a8a !important; /* สีชมพูแก้มแดง */
        color: white !important;
        font-weight: 500;
        border: none !important;
    }
    .my-striped-table tr:nth-child(odd) { background-color: #fff5f5; }
    .my-striped-table tr:nth-child(even) { background-color: white; }
    .custom-hover tbody tr:hover { background-color: #ffe0e0 !important; }
');
?>

<style>
    /* Modern Button Group */
    .btn-group-modern { display: flex; gap: 12px; justify-content: center; margin: 20px 0; flex-wrap: wrap; }
    .btn-modern {
        display: flex; align-items: center; gap: 8px; padding: 10px 18px;
        border: none; border-radius: 12px; font-size: 14px; font-weight: 600;
        color: white !important; transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-decoration: none !important;
    }
    .btn-modern:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.15); }

    /* ปรับโทนสี Gradient ใหม่ */
    .btn-anc { background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); }
    .btn-red-cheek { background: linear-gradient(135deg, #ff5252 0%, #f48fb1 100%); } /* ธีมสาวไทยแก้มแดง */
    .btn-mental { background: linear-gradient(135deg, #43a047 0%, #1de9b6 100%); }
    .btn-fittest { background: linear-gradient(135deg, #ff9800 0%, #ffeb3b 100%); }

    /* Info Card Modern */
    .info-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        border-left: 5px solid #ff5252;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: 0.3s;
        height: 100%;
    }
    .info-card:hover { box-shadow: 0 15px 35px rgba(0,0,0,0.1); }

    /* Floating Submit Button */
    .floating-button-container {
        position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%); z-index: 1000;
    }
    .btn-send-data {
        background: linear-gradient(135deg, #00b09b, #96c93d);
        color: white; font-size: 1.2rem; font-weight: bold;
        padding: 15px 35px; border-radius: 50px; border: 3px solid white;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2); cursor: pointer;
    }
</style>

<div class="btn-group-modern">
    <a href="<?= Url::to(['/f16janc/index']) ?>" class="btn-modern btn-anc"><i class="fa fa-baby"></i> ANC</a>
    <a href="<?= Url::to(['/f16jthaired/index']) ?>" class="btn-modern btn-red-cheek"><i class="fa fa-heart"></i> สาวไทยแก้มแดง</a>
    <a href="<?= Url::to(['/f16screenmental/index']) ?>" class="btn-modern btn-mental"><i class="fa fa-brain"></i> สุขภาพจิต</a>
    <a href="<?= Url::to(['/fittest/index']) ?>" class="btn-modern btn-fittest"><i class="fa fa-running"></i> FitTest</a>
</div>

<div class="container-fluid">
    <div class="alert alert-info" style="border-radius: 10px; border-left: 5px solid #ff5252;">
        <strong>เงื่อนไข:</strong> ทุกสิทธิ์ รหัสโรค ('Z13.0') หญิงวัยเจริญพันธุ์ อายุ 13-45 ปี รับยาเสริมธาตุเหล็กและกรดโฟลิก
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="info-card">
                <h5 style="color: #666;"><i class="fa fa-calendar-check text-success"></i> ผ่านวันนี้</h5>
                <h2 class="text-primary"><?= number_format($amount) ?> <small>ราย</small></h2>
                <div class="text-right">
                     <?= Html::a('เปิดไฟล์', '#', ['class' => 'btn btn-sm btn-default', 'data-toggle' => 'modal', 'data-target' => '#myModal', 'data-url' => Url::to(['f16erext/list-files-partial'])]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-card" style="border-left-color: #2575fc;">
                <?= Html::beginForm(['index'], 'get', ['class' => 'row']) ?>
                <div class="col-md-5">
                    <?= DatePicker::widget([
                        'name' => 'date1', 'value' => $date1, 'language' => 'th',
                        'clientOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd'],
                        'options' => ['class' => 'form-control', 'style' => 'border-radius:10px']
                    ]) ?>
                </div>
                <div class="col-md-5">
                    <?= DatePicker::widget([
                        'name' => 'date2', 'value' => $date2, 'language' => 'th',
                        'clientOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd'],
                        'options' => ['class' => 'form-control', 'style' => 'border-radius:10px']
                    ]) ?>
                </div>
                <div class="col-md-2">
                    <?= Html::submitButton('ค้นหา', ['class' => 'btn btn-primary btn-block', 'style' => 'border-radius:10px']) ?>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>

    <br>

    <div class="panel panel-default" style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
        <div class="panel-body" style="padding: 0;">
            <?= Html::beginForm(['f16thaired/data'], 'post', ['name' => 'frmMain']); ?>
            <div class="table-responsive" style="max-height: 600px;">
                <table class="table my-striped-table custom-hover" style="margin-bottom: 0;">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="CheckAll" onClick="ClickCheckAll(this);"></th>
                            <th>ลำดับ</th>
                            <th>วันที่</th>
                            <th>เลขบริการ</th>
                            <th>HN</th>
                            <th>ชื่อ-สกุล</th>
                            <th>อายุ (ปี)</th>
                            <th>สิทธิ์</th>
                            <th>รหัสโรค</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataProvider->getModels() as $value) : ?>
                            <tr>
                                <td><input type="checkbox" name="chkDel[]" value="<?= $value["visit_id"].$value["hn"] ?>"></td>
                                <td><?= $value["No"] ?></td>
                                <td><?= $value["regdate"] ?></td>
                                <td><span class="label label-default"><?= $value["visit_id"] ?></span></td>
                                <td><?= $value["hn"] ?></td>
                                <td><strong><?= $value["fullname"] ?></strong></td>
                                <td><?= $value["age_year"] ?></td>
                                <td><?= $value["inscl"] ?></td>
                                <td><b class="text-danger"><?= $value["Diag"] ?></b></td>
                                <td><?= $value["messagecode"] ?: '<span class="text-muted">รอดำเนินการ</span>' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php if (in_array(Yii::$app->user->id, [6,75,96, 250, 289, 383])) : ?>
    <div class="floating-button-container">
        <button type="submit" class="btn-send-data">
            <i class="fa fa-paper-plane"></i> ส่งข้อมูลสาวไทยแก้มแดง
        </button>
    </div>
<?php endif; ?>
<?= Html::endForm(); ?>

<script>
    function ClickCheckAll(vol) {
        var checkboxes = document.querySelectorAll('input[name="chkDel[]"]');
        checkboxes.forEach(function(cb) { cb.checked = vol.checked; });
    }
</script>