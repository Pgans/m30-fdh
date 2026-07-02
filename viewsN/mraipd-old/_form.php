<?php  
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Mraipd */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile("@web/owl.carousel/owl-carousel/owl.carousel.css");
// $this->registerCssFile("@web/owl.carousel/owl-carousel/owl.theme.css");

//register js files
$this->registerJsFile("@web/owl.carousel/owl-carousel/owl.carousel.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("@web/js/index.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
// popup css
$this->registerCssFile("http://www.jacklmoore.com/colorbox/example1/colorbox.css");
// popup js
//$this->registerJsFile("http://code.jquery.com/jquery-3.2.1.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("http://www.jacklmoore.com/colorbox/jquery.colorbox.js", ['depends' => [\yii\web\JqueryAsset::className()]]);

?>


<?php $form = ActiveForm::begin(); ?>
<div class="mraipd-form">

    <div class="well">
      <div class="row">
           <div class="col-md-2">
           <?= $form->field($model, 'hospcode')->textInput(['maxlength' => true,'value'=>'10953']) ?>
          </div>
          <div class="col-md-2">
          <?= $form->field($model, 'unit_id')->textInput() ?>
          </div>
          <div class="col-md-1">
          <?= $form->field($model, 'HN')->textInput(['maxlength' => true]) ?>
          </div>
          <div class="col-md-1">
          <?= $form->field($model, 'AN')->textInput(['maxlength' => true]) ?>
          </div>
          <!-- <div class="col-md-2">
          <?= $form->field($model, 'dr_license')->textInput(['maxlength' => true]) ?>
          </div> -->
          <div class="col-md-2">
          <?= $form->field($model, 'date_admit')->textInput() ?>
          </div>
          <div class="col-md-2">
          <?= $form->field($model, 'date_discharge')->textInput() ?>
          </div>
          <div class="col-md-2">
          <?= $form->field($model, 'date_audit')->textInput() ?>
          </div>
      </div>
    </div>
</div>
<div class="box box-default">
    <div class="well">
    <table>
    <tr>
        <th><a>Content of medical record</a></th><th>NA (N)</th><th>Miss (M)</th><th>No (O)</th><th>ข้อที่1</th><th>ข้อที่2</th>
        <th>ข้อที่3</th><th>ข้อที่4</th><th>ข้อที่5</th><th>ข้อที่6</th><th>ข้อที่7</th><th>ข้อที่8</th><th>ข้อที่9</th><th>หัก</th>
    </tr>
    <!-- <?php $form = ActiveForm::begin(); ?> -->
    <div class="col-md-10">
    <tr>
            <!-- <td><?= $form->field($model, 'content_id')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td> -->
            <td><a>Discharge summary : Dx, Op</a></td>
            <td> <?= $form->field($model, 'NA1')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing1')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td> <?= $form->field($model, 'No1')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td> <?= $form->field($model, 'dxop1')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'dxop2')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'dxop3')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'dxop4')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'dxop5')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'dxop6')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'dxop7')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'dxop8')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'dxop9')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'dxop_huk')->textInput(['maxlength' => true,'value'=>'0'])->label(false) ?></td>
        </tr>
        <tr>
            <td style="col:#ffff; backgroup:black;"><a>Discharge summary : Dx, Other</a></td>
            <td><?= $form->field($model, 'NA2')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing2')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'No2')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td> <?= $form->field($model, 'other1')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'other2')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'other3')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'other4')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td>  <?= $form->field($model, 'other5')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'other6')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'other7')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'other8')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'other9')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'other_huk')->textInput(['maxlength' => true,'value'=>'0'])->label(false) ?></td>
        </tr>
        <tr>
            <td><a>Informed consent</a></td>
            <td><?= $form->field($model, 'NA3')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing3')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'No3')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td> <?= $form->field($model, 'infc1')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'infc2')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'infc3')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'infc4')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td>  <?= $form->field($model, 'infc5')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'infc6')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'infc7')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'infc8')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'infc9')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'infc_huk')->textInput(['maxlength' => true,'value'=>'0'])->label(false) ?></td>
        </tr>
        <tr>
            <td><a>History</a></td>
            <td><?= $form->field($model, 'NA4')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing4')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'No4')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td> <?= $form->field($model, 'hist1')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'hist2')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'hist3')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'hist4')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td>  <?= $form->field($model, 'hist5')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'hist6')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'hist7')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'hist8')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'hist9')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'hist_huk')->textInput(['maxlength' => true,'value'=>'0'])->label(false) ?></td>
        </tr>
        <tr>
            <td><a>Physical examination</a></td>
            <td><?= $form->field($model, 'NA5')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing5')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'No5')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td> <?= $form->field($model, 'pe1')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'pe2')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'pe3')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'pe4')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td>  <?= $form->field($model, 'pe5')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'pe6')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'pe7')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'pe8')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'pe9')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'pe_huk')->textInput(['maxlength' => true,'value'=>'0'])->label(false) ?></td>
        </tr>
        <tr>
            <td><a>Progress Note</a></td>
            <td><?= $form->field($model, 'NA6')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing6')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'No6')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td> <?= $form->field($model, 'pn1')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'pn2')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'pn3')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'pn4')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td>  <?= $form->field($model, 'pn5')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'pn6')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'pn7')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'pn8')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'pn9')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'pn_huk')->textInput(['maxlength' => true,'value'=>'0'])->label(false) ?></td>
        </tr>
        <tr>
            <td><a>Consultation record</a></td>
            <td><?= $form->field($model, 'NA7')->textInput(['maxlength' => true,'value'=>'N'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing7')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'No7')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td> <?= $form->field($model, 'cr1')->textInput(['maxlength' => true])->label(false) ?></td>
            <td> <?= $form->field($model, 'cr2')->textInput(['maxlength' => true])->label(false) ?></td>
            <td><?= $form->field($model, 'cr3')->textInput(['maxlength' => true])->label(false) ?></td>
            <td><?= $form->field($model, 'cr4')->textInput(['maxlength' => true])->label(false) ?></td>
            <td>  <?= $form->field($model, 'cr5')->textInput(['maxlength' => true])->label(false) ?></td>
            <td> <?= $form->field($model, 'cr6')->textInput(['maxlength' => true])->label(false) ?></td>
            <td> <?= $form->field($model, 'cr7')->textInput(['maxlength' => true])->label(false) ?></td>
            <td> <?= $form->field($model, 'cr8')->textInput(['maxlength' => true])->label(false) ?></td>
            <td> <?= $form->field($model, 'cr9')->textInput(['maxlength' => true])->label(false) ?></td>
            <td><?= $form->field($model, 'cr_huk')->textInput(['maxlength' => true,'value'=>'0'])->label(false) ?></td>
        </tr>
        <tr>
            <td><a>Anaesthetic record</a></td>
            <td><?= $form->field($model, 'NA8')->textInput(['maxlength' => true,'value'=>'N'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing8')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'No8')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td> <?= $form->field($model, 'ar1')->textInput(['maxlength' => true])->label(false) ?></td>
            <td> <?= $form->field($model, 'ar2')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'ar3')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'ar4')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td>  <?= $form->field($model, 'ar5')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'ar6')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'ar7')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'ar8')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'ar9')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'ar_huk')->textInput(['maxlength' => true,'value'=>'0'])->label(false) ?></td>
        </tr>
        <tr>
            <td><a>Operative note</a></td>
            <td><?= $form->field($model, 'NA9')->textInput(['maxlength' => true,'value'=>'N'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing9')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'No9')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td> <?= $form->field($model, 'on1')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'on2')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'on3')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'on4')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td>  <?= $form->field($model, 'on5')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'on6')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'on7')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'on8')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'on9')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'on_huk')->textInput(['maxlength' => true,'value'=>'0'])->label(false) ?></td>
        </tr>
        <tr>
            <td><a>Labour record</a></td>
            <td><?= $form->field($model, 'NA10')->textInput(['maxlength' => true,'value'=>'N'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing10')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'No10')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td> <?= $form->field($model, 'lr1')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'lr2')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'lr3')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'lr4')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td>  <?= $form->field($model, 'lr5')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'lr6')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'lr7')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'lr8')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'lr9')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'lr_huk')->textInput(['maxlength' => true,'value'=>'0'])->label(false) ?></td>
        </tr>
        <tr>
            <td><a>Rehabilitation record</a></td>
            <td><?= $form->field($model, 'NA11')->textInput(['maxlength' => true,'value'=>'N'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing11')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'No11')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td> <?= $form->field($model, 'rr1')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'rr2')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'rr3')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'rr4')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td>  <?= $form->field($model, 'rr5')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'rr6')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'rr7')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'rr8')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'rr9')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'rr_huk')->textInput(['maxlength' => true,'value'=>'0'])->label(false) ?></td>
        </tr>
        <tr>
            <td><a>Nurses' note helpful</a></td>
            <td><?= $form->field($model, 'NA12')->textInput(['maxlength' => true,'value'=>'N'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing12')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td><?= $form->field($model, 'No12')->textInput(['maxlength' => true,'value'=>'-'])->label(false) ?></td>
            <td> <?= $form->field($model, 'nn1')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'nn2')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'nn3')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'nn4')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td>  <?= $form->field($model, 'nn5')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'nn6')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'nn7')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'nn8')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'nn9')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'nn_huk')->textInput(['maxlength' => true,'value'=>'0'])->label(false) ?></td>
        </tr>
        <!-- <tr>
	 <td class="left"><font> Physical examination </font></td>
	<td><div><input name="NA05" type="text" id="NA05" size="1" maxlength="1" value="-" readonly="" autocomplete="off"></div></td>
	<td><div data-tip="กรอก M เมื่อไม่มีเอกสารให้ตรวจสอบ"><input onchange="handleMI05Chk(this)" name="MI05" type="text" id="MI05" size="1" maxlength="1" value="-" tabindex="44" autocomplete="off"></div></td>
	<td><input name="NO05" type="text" id="NO05" size="1" maxlength="1" value="-" onchange="handleNO05Chk(this)" autocomplete="off"></td>
	<td><div data-tip="T P R และ BP (BP ยกเว้น <3 ปี)"><input name="SC051" type="text" id="SC051" size="1" maxlength="1" tabindex="105" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="มี นน.ทุกราย,ส่วนสูง(เด็กทุกราย),ผู้ใหญ่กรณีหา BMI Body Surface Area รายที่ให้เคมี"><input name="SC052" type="text" id="SC052" size="1" maxlength="1" tabindex="105" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ดู คลำ เคาะ ฟัง สอดคล้องกับ chief complaint"><input name="SC053" type="text" id="SC053" size="1" maxlength="1" tabindex="105" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="วาดรูปหรือกราฟฟิกสิ่งที่ตรวจพบความผิดปกติที่ถูกต้อง(กรณีปกติ ต้องได้คะแนนข้อ3"><input name="SC054" type="text" id="SC054" size="1" maxlength="1" tabindex="105" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ตรวจร่างกายทุกระบบ"><input name="SC055" type="text" id="SC055" size="1" maxlength="1" tabindex="105" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="สรุปปัญหา pt ที่รักษาครั้งนี้(Problem list)"><input name="SC056" type="text" id="SC056" size="1" maxlength="1" tabindex="105" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="สรุปวินิจฉัยขั้นต้นสอดคล้องประวัติผลการตรวจร่างกาย"><input name="SC057" type="text" id="SC057" size="1" maxlength="1" tabindex="105" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="แผนการรักษาใน admit ครั้งนี้ (บันทึก admit ถือว่าไม่ผ่านเกณฑ์)"><input name="SC058" type="text" id="SC058" size="1" maxlength="1" tabindex="105" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
    <td><div data-tip="ลายมืออ่านออกชื่อแพทย์ที่ตรวจร่างกายระบุได่ว่าเป็นผู้ใด"><input name="SC059" type="text" id="SC059" size="1" maxlength="1" tabindex="105" value="1" onchange="handleSCChk(this)" autocomplete="off"></div></td>
	<td><div><input name="DEC05" type="text" id="DEC05" size="1" maxlength="1" value="0" readonly="" autocomplete="off"></div></td>
</tr>-->

    </table> 

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
 
