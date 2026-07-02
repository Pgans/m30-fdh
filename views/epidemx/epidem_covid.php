<?php
session_start();
include 'chk_session.php';
error_reporting(0);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dose3</title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <meta charset="utf-8">
    <link href='https://fonts.googleapis.com/css?family=Prompt:400,300&subset=thai,latin' rel='stylesheet' type='text/css'>
    <style>
		body {
		  font-family: 'Prompt', sans-serif;
		}
		h1 {
		  font-family: 'Prompt', sans-serif;
		}
    </style>
       <style type="text/css">
  #grad0 {
  background-image: linear-gradient(to right, violet, cyan);
}
#grad4 {
  background-image: linear-gradient(to right, red,orange,yellow,green,blue,indigo,violet);
}
#grad5 {
  background-image: linear-gradient(180deg, red, yellow);
}
#grad6 {
  background-image: linear-gradient(180deg, violet, cyan);
}
#grad7 {
  background-image: linear-gradient(180deg, blue, cyan);
}
#grad01 {
  background-image: linear-gradient(to right, green , violet);
}
#grad {
  background: red; /* For browsers that do not support gradients */
  background: -webkit-linear-gradient(left,rgba(255,0,0,0),rgba(255,0,0,1)); /*Safari 5.1-6*/
  background: -o-linear-gradient(right,rgba(255,0,0,0),rgba(255,0,0,1)); /*Opera 11.1-12*/
  background: -moz-linear-gradient(right,rgba(255,0,0,0),rgba(255,0,0,1)); /*Fx 3.6-15*/
  background: linear-gradient(to right, rgba(255,0,0,0), rgba(255,0,0,1)); /*Standard*/
}
#grad1 {
    height: 55px;
    background: -webkit-linear-gradient(left, red, orange, yellow, green, blue, indigo, violet); /* For Safari 5.1 to 6.0 */
    background: -o-linear-gradient(left, red, orange, yellow, green, blue, indigo, violet); /* For Opera 11.1 to 12.0 */
    background: -moz-linear-gradient(left, red, orange, yellow, green, blue, indigo, violet); /* For Fx 3.6 to 15 */
    background: linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet); /* Standard syntax (must be last) */
}
{   
     #non-printable { display: none; }   
     #printable { display: block; }   
} 

input[type="checkbox"]
{
    font-size:18px;
}

</style>
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
<div class="col-md-12">
               <div class="col-md-12 mx-auto">
                   <div class="card border-danger">
                      <div class="card-header bg-warning text-white">
                      <h3 class="page-header alert btn-info" id="grad0"><i class="glyphicon glyphicon-list" >ระบบส่งข้อมูลกองระบาดวิทยา EpidemCovid-19</i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <!-- ยอดรอส่งวันนี้&nbsp;  <?php require("total_wait2.php");?> -->
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        ผ่าน&nbsp; <?php require("count_epidem.php");?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         <input type="button" class="btn btn-warning" name="callPopUp" id="callPopUp" value="<<รันToken>>" onClick="javascript:window.open('token_alert.php' , 'ใส่ชื่อให้มันตรงนี้เปิดกี่ครั้งมันก็เปิดวินโดว์ชื่อนี้ไม่เปิดใหม่เรื่อยๆ' ,'nenuber=no,toorlbar=no,location=no,scrollbars=no,status=no,resizable=no,width=180,height=180,top=220,left=650' )";" />
                         <input type="button" class="btn btn-danger" name="callPopUp" id="callPopUp" value="ลบToken!!!" onClick="javascript:window.open('token_del.php' , 'ใส่ชื่อให้มันตรงนี้เปิดกี่ครั้งมันก็เปิดวินโดว์ชื่อนี้ไม่เปิดใหม่เรื่อยๆ' ,'nenuber=no,toorlbar=no,location=no,scrollbars=no,status=no,resizable=no,width=180,height=180,top=220,left=650' )";" />
                        
                        <!--<a href="token30.php"  class="btn btn-primary"> success </a>-->
                        <!-- <a href="token_alert.php?act=success" class="btn btn-danger"> Gen-Token!!!</a>-->
                         </h3>
                         
                       </div>
                       <meta charset="UTF-8">
   <!--<div style="height:400px;width:780px;border:solid 2px orange;overflow:scroll;overflow-x:hidden;overflow-y:scroll;">-->
  <form id="checkbo" name="frmMain" action="api_epidem.php" method="post" #target="iframe_targetxx" >
 <?php
 
                  require "config.php";
                  $num = 1 ;
                  
                    $strSQL1 ="SELECT @n :=@n +1 'No'
                    ,date(b.reg_datetime) 'regdate'
                    ,time(b.reg_datetime) 'time'
                    ,b.visit_id
                    ,b.hn,
                     CASE 
                     WHEN cv1.cid is null THEN 'N'
                     WHEN cv1.cid <> '' THEN 'Y'
                     ELSE 'Yes'
                     END as Vaccine,
                     CASE 
                     WHEN ir.adm_id is null THEN 'ไม่มี'
                     WHEN ir.adm_id <> '' THEN 'มี'
                     ELSE 'ไม่รุนแรง'
                     END as 'symtom',
                     '' as 'pregnant',
                    #b.REG_DATETIME as adm_dt,
                    #b.FINISH_DATETIME as'dsc_dt',
                    CONCAT(
                      CASE 
                             WHEN p.PRENAME not in('') THEN TRIM(p.PRENAME)
                                   WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW())< '20' AND p.sex='1' AND p.MARRIAGE = '4'THEN 'สามเณร'
                                   WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '20' AND p.sex='1' AND p.MARRIAGE  = '4'THEN 'พระภิกษุ'
                                   WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='1' THEN 'เด็กชาย'
                                   WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='1' THEN 'นาย'
                                   WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='2' THEN 'เด็กหญิง'
                                   WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='2' AND p.MARRIAGE ='1' THEN 'นางสาว'
                                   ELSE 'นาง' 
                            END ,TRIM(p.FNAME),'  ',TRIM(p.LNAME)) as 'fullname',
                      TIMESTAMPDIFF(year,p.BIRTHDATE,b.REG_DATETIME) as 'age',
                      p.cid,
                    GROUP_CONCAT(DISTINCT trim(icd.ICD10_TM)) as Diag,
                    GROUP_CONCAT(DISTINCT 
                    CASE
                    WHEN lr.LAB_RESULT  LIKE '%RT-PCR%' THEN 'RT-PCR'
                    WHEN lr.LAB_RESULT  LIKE '%Ag=Negative%' THEN 'Negative'
                    WHEN lr.LAB_RESULT  LIKE '%Ag=Positive%' THEN 'Positive'
                    ELSE LEFT(lr.LAB_RESULT,20) 
                    END )as 'lab',
                    GROUP_CONCAT(DISTINCT lr.lab_id) lab_id,
                    if(ir.adm_id is null, '' ,ir.adm_id ) An,
                    if(ir.ward_no is null, '' ,ir.ward_no ) ward,
                    CASE
                    WHEN b.INSCL in (03,04) AND uc.HOSPMAIN ='10953' THEN CONCAT(m.INSCL_NAME,'-ในเขต') 
                    WHEN b.INSCL in (03,04) AND uc.HOSPMAIN !='10953' THEN CONCAT(m.INSCL_NAME,'-นอกเขต') 
                    ELSE m.INSCL_NAME 
                    END as 'inscl' ,
                    m.inscl 'inscl_id', 
                    CASE
                    WHEN b.inscl in (03,04) THEN uc.hospmain
                    WHEN b.inscl in (08,09,21,30,31) THEN h.hosp_id
                    ELSE ''
                    END as hospmain,
                    left(e.unit_name,10) 'unit_name', 
                     p.TELEPHONE as 'เบอร์คนไข้'
                      FROM (select @n := 0) m, opd_visits b 
                      INNER JOIN cid_hn c on b.HN= c.HN
                      INNER JOIN population p on c.CID=p.CID
                      LEFT JOIN opd_diagnosis d ON d.visit_id = b.visit_id AND d.is_cancel = 0
                      LEFT JOIN icd10new icd ON icd.icd10 = d.icd10
                      LEFT  JOIN ipd_reg ir ON ir.VISIT_ID = b.visit_id  AND ir.IS_CANCEL = 0
                      INNER JOIN service_units e ON b.UNIT_REG=e.unit_id
                      LEFT JOIN refers r ON b.VISIT_ID=r.VISIT_ID AND r.IS_CANCEL='0'
                      INNER JOIN main_inscls m ON m.inscl = b.inscl 
                      LEFT JOIN uc_inscl uc ON uc.cid = p.cid AND (uc.date_abort = date(b.REG_DATETIME) or day(uc.date_abort)=0 and trim(uc.hospmain) <>'' )
                      LEFT JOIN main_inscls m1 ON m1.inscl = b.inscl 
                      LEFT JOIN hosp_sss h ON h.cid = p.cid AND h.DATE_ABORT = 0
                      LEFT JOIN lab_requests lr ON lr.visit_id = b.visit_id AND lr.is_cancel = 0 AND lr.LAB_RESULT LIKE '%positive%'
                      LEFT JOIN lab_lists l ON l.lab_id = lr.lab_id  
                      LEFT JOIN cid_vaccinate_v2 cv1 ON cv1.cid = p.cid AND cv1.is_cancel = 0
                      WHERE b.IS_CANCEL = 0
                      #AND b.visit_id not in (SELECT mv.visit_id FROM mobile_visits mv)
                      AND b.REG_DATETIME BETWEEN '2022-11-15 00:01' AND NOW()
                      AND b.visit_id NOT IN (SELECT VISIT_ID FROM log_epidem)
                      #AND lr.lab_id in ('410','411')  ##410 รหัสตรวจ antigen   394=RTPCR
                      AND (icd.icd10_tm in ('U071','U072') OR lr.lab_id in ('410','411'))
                      GROUP BY b.VISIT_ID  ORDER BY @n DESC
                       ";
  
                  $objQuery = mysql_query($strSQL1) or die ("Error Query [".$strSQL1."]");
                  ?>
                  <input name="btnButton1" class="btn btn-info btn btn-block" type="submit" name="select"id="grad0" value="ส่งข้อมูล Epidem Covid-19">
        <!-- <DIV style="width:1200px;height:700px;overflow:auto;"> -->
          <table class="table table-striped" width="1100" border="0">

                  <!--<table class='table table-warning  table-striped border='1' align='center' width='800'>-->

                  <tr>
    <!--<th width="30"> <div align="center">select </div></th>-->
    <th width="30"> <div align="center">
      <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);">
    </div></th>
    <th width="30"> <div align="center"># </div></th>
    <th width="30"> <div align="center">วันที่ </div></th>
    <th width="30"> <div align="center">Visit </div></th>
    <th width="30"> <div align="left">Hn </div></th>
    <th width="30"> <div align="left">An </div></th>
    <th width="30"> <div align="left">ตึก </div></th>
    <th width="150"> <div align="left">ชื่อ-สกุล </div></th>
    <th width="30"> <div align="left">Diag </div></th>
    <th width="30"> Lab </th>
    <th width="30"> รหัสLab </th>
    <th width="30"> แผนก </th> 
	<th width="30"> วัคซีน </th>
    <th width="30"> อาการ </th>
  </tr>
<?php
while($objResult = mysql_fetch_array($objQuery))
{
  $i++;
  if($i%2==0)
  {
  $bg = "#CCCCCC";
  }
  else
  {
  $bg = "#FFFFFF";
  }
?>
  <tr>

  <td ><div align="center"><input type="checkbox" name="chkDel[]" <?php echo 'checked'; ?> id="chkDel<?=$i;?>" value="<?php echo $objResult["visit_id"]; ?><?php echo $objResult["cid"]; ?>"></td>
  <td class="badge"><?php echo  $objResult["No"];?></div></td>
  <td class="text-nowrap" ><?php echo $objResult["regdate"];?></div></td>
  <td ><?php echo $objResult["visit_id"];?></div></td>
  <td ><?php echo $objResult["hn"];?></div></td>
  <td ><?php echo $objResult["An"];?></div></td>
  <td ><?php echo $objResult["ward"];?></div></td>
  <td class="text-nowrap" style="color:green"><?php echo $objResult["fullname"];?></td>
  <td class="text-nowrap"><?php echo $objResult["Diag"];?></div></td>
  <td class="text-nowrap" ><?php echo $objResult["lab"];?></div></td>
  <td class="text-nowrap" ><?php echo $objResult["lab_id"];?></div></td>
  <td class="text-nowrap" style="color:green"><?php echo $objResult["unit_name"];?></div></td>
  <td class="text-nowrap" style="color:brown"><a><?php echo $objResult["Vaccine"];?></a></div></td> 
  <td ><?php echo $objResult["symtom"];?></div></td>
                  </tr>
                  <?php
                  }
                  ?>
                  </table>
        </DIV>
        <?php
                  mysql_close($objConnect);
                  ?>
                  <input name="btnButton1" class="btn btn-success btn btn-block" id="grad0" type="submit" name="select" value="ส่งข้อมูล Epidem Covid-19">
                  <input type="hidden" name="hdnCount" value="<?=$i;?>">
         <?php 
         $epidem =json_decode($response,true);
         $err = curl_error($curl);
         curl_close($curl);
         $pid = $epidem['result']['cid'];
         //echo "<pre>";
         //print_r($epidem).'</br>';
         $status = $epidem['Message'];
         $messagecode = $epidem['MessageCode'];
         if($status = 200) {
             /*
            echo '<script type="text/javascript">
            swal("ส่งข้อมูลเรียบร้อย !!" ,"'.$status.'");
            </script>';*/
          } 
          else{
                echo '<script type="text/javascript">
            swal("ส่งข้อมูลไม่สำเร็จ !!" ,"'.$status.'");
            </script>';
            }
    
             /*
          echo "<script language=\"JavaScript\">";
          echo "alert('ส่งข้อมูลไม่สำเร็จ')";
          echo "</script>";
         }
         */
        ?>
                  <!--<input name="btnButton1" type="button" value="SentAPI" OnClick="JavaScript:alert('Hello ThaiCreate.Com');">
                  <input name="btnButton2" type="button" value="Hello 2" OnClick="JavaScript:fncAlert();">-->
                  </form>
              </div>
          </div>
       </div>
    </div>
</body>
</html>
