<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\editable\Editable;
use \miloschuman\highcharts\Highcharts;

//$this->title = 'คะแนนแยกตามข้อ';
$this->title = Yii::t('app', 'HN: {name}', [
    'name' => $model->HN,
]);

$this->params['breadcrumbs'][] = ['label' => 'กลับ', 'url' => ['mraopd/index']];

?>

                <div class="panel panel-primary" >
                        <div class="panel-heading"id= "grad01"><i class="glyphicon glyphicon-user"></i> บันทึกตรวจประเมินเวชระเบียนผู้ป่วยนอก<i></div>
                        <div class="table-responsive">
                            
                            <div>
                            <table class="table table-striped" width="450" border="0" align="center" cellspacing="0" >
        <thead>
        <tr>
            <th><a>Content of medical record</a></th></th><th>Miss (M)</th><th>No (O)</th><th>ข้อที่1</th><th>ข้อที่2</th>
        <th>ข้อที่3</th><th>ข้อที่4</th><th>ข้อที่5</th><th>ข้อที่6</th><th>ข้อที่7</th><th>เพิ่ม<th>หัก</th><th>คะแนนเต็ม</th><th>คะแนนที่ได้</th>
        </tr>
         </thead> 
        <?php
        //while($objResult = mysql_fetch_array($dataeProvider))
        foreach($dataProvider->getModels() as $key => $value):
        ?>
        <tr>
        <td><a>1.Patient's Profile</a></td>
            <td align="center"><?=$value["na01"];?></td>
            <td align="center"><?=$value["mi01"];?></td>
            <td align="center"><?=$value["sc011"];?></td>
            <td align="center"><?=$value["sc012"];?></td>
            <td align="center"><?=$value["sc013"];?></td>
            <td align="center"><?=$value["sc014"];?></td>
            <td align="center"><?=$value["sc015"];?></td>
            <td align="center"><?=$value["sc016"];?></td>
            <td align="center"><?=$value["sc017"];?></td>
			<td align="center"><?=$value["no01"];?></td>
            <td align="center"><?=$value["dec01"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total1"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount1"];?></td>
        </tr>
        <tr>
            <td><a>2.History (1<sup>st</sup> visit)</a></td>
            <td align="center"><?=$value["na02"];?></td>
            <td align="center"><?=$value["mi02"];?></td>
            <td align="center"><?=$value["sc021"];?></td>
            <td align="center"><?=$value["sc022"];?></td>
            <td align="center"><?=$value["sc023"];?></td>
            <td align="center"><?=$value["sc024"];?></td>
            <td align="center"><?=$value["sc025"];?></td>
            <td align="center"><?=$value["sc026"];?></td>
            <td align="center"><?=$value["sc027"];?></td>
			<td align="center"><?=$value["no02"];?></td>
            <td align="center"><?=$value["dec02"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total2"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount2"];?></td>
        </tr>
        <tr>
            <td><a>3.Physical examination</a></td>
            <td align="center"><?=$value["na03"];?></td>
            <td align="center"><?=$value["mi03"];?></td>
            <td align="center"><?=$value["sc031"];?></td>
            <td align="center"><?=$value["sc032"];?></td>
            <td align="center"><?=$value["sc033"];?></td>
            <td align="center"><?=$value["sc034"];?></td>
            <td align="center"><?=$value["sc035"];?></td>
            <td align="center"><?=$value["sc036"];?></td>
            <td align="center"><?=$value["sc037"];?></td>
			<td align="center"><?=$value["no03"];?></td>
            <td align="center"><?=$value["dec03"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total3"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount3"];?></td>
        </tr>
        <tr>
            <td><a>4.Teatment/Investigation</a></td>
            <td align="center"><?=$value["na04"];?></td>
            <td align="center"><?=$value["mi04"];?></td>
            <td align="center"><?=$value["sc041"];?></td>
            <td align="center"><?=$value["sc042"];?></td>
            <td align="center"><?=$value["sc043"];?></td>
            <td align="center"><?=$value["sc044"];?></td>
            <td align="center"><?=$value["sc045"];?></td>
            <td align="center"><?=$value["sc046"];?></td>
            <td align="center"><?=$value["sc047"];?></td>
			<td align="center"><?=$value["no04"];?></td>
            <td align="center"><?=$value["dec04"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total4"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount4"];?></td>
        </tr>
        <tr>
            <td><a>5.Follow up ครั้งที่ 1</a><?=$value["Followdate1"];?></td>
            <td align="center"><?=$value["na05"];?></td>
            <td align="center"><?=$value["mi05"];?></td>
            <td align="center"><?=$value["sc051"];?></td>
            <td align="center"><?=$value["sc052"];?></td>
            <td align="center"><?=$value["sc053"];?></td>
            <td align="center"><?=$value["sc054"];?></td>
            <td align="center"><?=$value["sc055"];?></td>
            <td align="center"><?=$value["sc056"];?></td>
            <td align="center"><?=$value["sc057"];?></td>
			<td align="center"><?=$value["no5"];?></td>
            <td align="center"><?=$value["dec05"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total5"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount5"];?></td>
        </tr>
        <tr>
            <td><a>Follow up ครั้งที่ 2</a><?=$value["Followdate2"];?></td>
            <td align="center"><?=$value["na06"];?></td>
            <td align="center"><?=$value["mi06"];?></td>
            <td align="center"><?=$value["sc061"];?></td>
            <td align="center"><?=$value["sc062"];?></td>
            <td align="center"><?=$value["sc063"];?></td>
            <td align="center"><?=$value["sc064"];?></td>
            <td align="center"><?=$value["sc065"];?></td>
            <td align="center"><?=$value["sc066"];?></td>
            <td align="center"><?=$value["sc067"];?></td>
			<td align="center"><?=$value["no06"];?></td>
            <td align="center"><?=$value["dec06"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total6"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount6"];?></td>
        </tr>
        <tr>
            <td><a>Follow up ครั้งที่ 3</a><?=$value["Followdate3"];?></td>
            <td align="center"><?=$value["na07"];?></td>
            <td align="center"><?=$value["mi07"];?></td>
            <td align="center"><?=$value["sc071"];?></td>
            <td align="center"><?=$value["sc072"];?></td>
            <td align="center"><?=$value["sc073"];?></td>
            <td align="center"><?=$value["sc074"];?></td>
            <td align="center"><?=$value["sc075"];?></td>
            <td align="center"><?=$value["sc076"];?></td>
            <td align="center"><?=$value["sc077"];?></td>
			<td align="center"><?=$value["no07"];?></td>
            <td align="center"><?=$value["dec07"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total7"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount7"];?></td>
        </tr>
        <tr>
            <td><a>6.Operative note</a></td>
            <td align="center"><?=$value["na08"];?></td>
            <td align="center"><?=$value["mi08"];?></td>
            <td align="center"><?=$value["sc081"];?></td>
            <td align="center"><?=$value["sc082"];?></td>
            <td align="center"><?=$value["sc083"];?></td>
            <td align="center"><?=$value["sc084"];?></td>
            <td align="center"><?=$value["sc085"];?></td>
            <td align="center"><?=$value["sc086"];?></td>
            <td align="center"><?=$value["sc087"];?></td>
			<td align="center"><?=$value["no08"];?></td>
            <td align="center"><?=$value["dec08"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total8"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount8"];?></td>
        </tr>
        <tr>
            <td><a>7.Informed consent</a></td>
            <td align="center"><?=$value["na09"];?></td>
            <td align="center"><?=$value["mi09"];?></td>
            <td align="center"><?=$value["sc091"];?></td>
            <td align="center"><?=$value["sc092"];?></td>
            <td align="center"><?=$value["sc093"];?></td>
            <td align="center"><?=$value["sc094"];?></td>
            <td align="center"><?=$value["sc095"];?></td>
            <td align="center"><?=$value["sc096"];?></td>
            <td align="center"><?=$value["sc097"];?></td>
			<td align="center"><?=$value["no09"];?></td>
            <td align="center"><?=$value["dec09"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total9"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount9"];?></td>
        </tr>
         <tr>
            <td><a>8.Rehabilitation record *</a></td>
            <td align="center"><?=$value["na10"];?></td>
            <td align="center"><?=$value["mi10"];?></td>
            <td align="center"><?=$value["sc101"];?></td>
            <td align="center"><?=$value["sc102"];?></td>
            <td align="center"><?=$value["sc103"];?></td>
            <td align="center"><?=$value["sc104"];?></td>
            <td align="center"><?=$value["sc105"];?></td>
            <td align="center"><?=$value["sc106"];?></td>
            <td align="center"><?=$value["sc107"];?></td>
			<td align="center"><?=$value["no10"];?></td>
            <td align="center"><?=$value["dec10"];?></td>
            <td align="center"> <span class="btn btn-xs btn-primary"><?=$value["total10"];?></td>
            <td align="center"><span class="btn btn-xs btn-info"><?=$value["amount10"];?></td>
        </tr> 
		
         <?php endforeach; ?>
		 
        </table>
		
                  </div>
          </div>
   </div>
          <p>
		    <a>ปัญหาในการทบทวนความสมบูรณ์เวชระเบียน*</a>    <?=$value["overall_name"];?>
	      </p>
		  <p>
		    <a>หมายเหตุ*</a>    <?=$value["note"];?>
	      </p>
		  <p>
		    <a>คำอธิบาย::::: </a>  NA ไม่จำเป็นต้องมีการบันทึก Visit ครั้งนั้น                                                          <a>Missing(M)</a>  ไม่มีเอกสารให้ตรวจสอบ เวชระเบียนไม่ครบ หรือหายไปบางส่วน
		  
             <p><a class='btn btn-info' HREF="javascript:history.back()" ><i class="fa fa-reply"></i> ย้อนกลับ</a> 
             <!--<a class="btn btn-info" href="/m30-mra/web/index.php?r=mraopd%2Findex"><span class="glyphicon  glyphicon-hand-left" aria-hidden="true"></span> กลับหน้าแรก</a>-->
             <a class="btn btn-warning" href="/m30-mra/web/index.php?r=mraopd%2Fpercent"><span class="glyphicon  glyphicon-th" aria-hidden="true"></span> ประมวลผล</a>
			   
            </p>
			</div>
            