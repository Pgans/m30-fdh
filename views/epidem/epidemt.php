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
	function ClickCheckAll(vol)
	{
	
		var i=1;
		for(i=1;i<=document.frmMain.hdnCount.value;i++)
		{
			if(vol.checked == true)
			{
				eval("document.frmMain.chkDel"+i+".checked=true");
			}
			else
			{
				eval("document.frmMain.chkDel"+i+".checked=false");
			}
		}
	}
</script> 
    <div class='well'>
        <form id="checkbo" name="frmMain" action="api_epidem.php" method="post">
            <input name="btnButton1" class="btn btn-success btn btn-block" id="selectAll" type="submit" name="selectAll" value="ส่งข้อมูล Epidem Covid-19">
            <input type="checkbox" id="selectAll">
            <table class="table table-striped"  border="0">
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
                        <div align="left" id="grad2"> Lab
                    </td>
                    <td width="30">
                        <div align="left" id="grad2"> แผนก
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
                        <td><input type="checkbox" name="chkDel[]" id="chkDel<?= $i; ?>" value="<?php echo $value["visit_id"]; ?><?php echo $value["cid"]; ?>"></td>
    <td class="badge"><?php echo  $value["No"]; ?>
    </div>
    </td>
    <td class="text-nowrap"><?php echo $value["regdate"]; ?></div>
    </td>
    <td><?php echo $value["visit_id"]; ?></div>
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
    <td class="text-nowrap"><?php echo $value["lab_result"]; ?></div>
    </td>
    <td class="text-nowrap" style="color:green"><?php echo $value["unit_name"]; ?></div>
    </td>
    <td class="text-nowrap" style="color:brown"><a><?php echo $value["Vaccine"]; ?></a></div>
    </td>
    <td><?php echo $value["symtom"]; ?></div>
    </td>
    </tr>
<?php endforeach; ?>
<input type="hidden" name="hdnCount" value="<?=$i;?>">
        </table>
        </form>
              
          </div>
       </div>
    </div>
</body>
</html>
