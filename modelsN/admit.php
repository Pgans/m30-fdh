
<?php
$servername = "192.168.200.7";
$username = "m30";
$password = "12Mb@M30_tawat";

    function sendToLine($message){    

            $line_api = 'https://notify-api.line.me/api/notify';
   
            #$line_token = 'cfdpRl44nox1LUTTPWYppxN98w4WS0j1jB6dpPNB2FU'; //ตัวLine Notify
			$line_token = 'cnEBBi7a16Xu2t1FUvw7zYKMiUXQScValtvdiQIhrX5'; // กลุ่ม Admitt
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://notify-api.line.me/api/notify");
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'message='.$message);
            // follow redirects
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-type: application/x-www-form-urlencoded',
                'Authorization: Bearer '.$line_token,
            ]);
            // receive server response ...
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
            $server_output = curl_exec ($ch);
        
            curl_close ($ch);
    }

    try {
        $conn = new PDO("mysql:host=$servername;dbname=mbase_data1", $username, $password , array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::MYSQL_ATTR_INIT_COMMAND =>  "SET NAMES 'UTF8'"
		));
        //echo "Connected successfully"; 
       
        $stmt = $conn->prepare("SELECT k.ward, k.adm_id as an, k.hn ,k.admitt, k.fullname , k.sex, k.age
FROM (
SELECT 
CASE WHEN a.WARD_NO = 22 THEN 'LR' 
WHEN a.WARD_NO = 38 THEN 'Ward 2' 
WHEN a.WARD_NO = 39 THEN 'Ward 1' 
WHEN a.WARD_NO = 55 THEN 'Ward 4' 
WHEN a.WARD_NO = 61 THEN 'Ward 5' 
ELSE 'DayCare' END as 'WARD' ,
o.HN ,
CONCAT(    CASE
            WHEN p.PRENAME not in('') THEN TRIM(p.PRENAME)
                #WHEN TIMESTAMPDIFF(year,pv.BIRTHDATE,NOW())< '20' AND pv.sex='1' AND pv.MARRIAGE = '4'THEN 'สามเณร'
                #WHEN TIMESTAMPDIFF(year,pv.BIRTHDATE,NOW()) >= '20' AND pv.sex='1' AND pv.MARRIAGE  = '4'THEN 'พระภิกษุ'
                WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='1' THEN 'ด.ช.'
                WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='1' THEN 'นาย'
                WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='2' THEN 'ด.ญ.'
                WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='2' AND p.MARRIAGE ='1' THEN 'น.ส.'
                ELSE 'นาง' END ,'',TRIM(p.fname),'  ',p.lname) as FULLNAME,
CASE 
WHEN p.sex = 1 THEN 'ชาย'
WHEN p.sex = 2 THEN 'หญิง'
END as SEX,
TIMESTAMPDIFF(year,p.birthdate, o.reg_datetime ) as AGE,
 a.ADM_ID ,a.ADM_DT as ADMITT,
 a.DSC_DT AS DSC, a.P_DIAG, 
CASE WHEN a.IS_CANCEL=0 THEN 'admit' 
ELSE 'ผิดพลาด' END as 'STATUS-Admit',
a.BED_NO as BED 
FROM ipd_reg a 
LEFT JOIN opd_visits o ON a.VISIT_ID=o.VISIT_ID 
LEFT JOIN cid_hn c on c.HN=o.HN 
LEFT JOIN population p ON c.CID=p.CID 
WHERE a.ADM_DT BETWEEN CURDATE() AND NOW()
AND a.IS_CANCEL = 0
ORDER BY a.WARD_NO ) as k
WHERE HOUR(k.admitt) BETWEEN '0' AND '23' 
#AND  HOUR(k.admitt) BETWEEN '8' AND '23'
ORDER BY k.admitt");
        $stmt->execute(); 
        $data = $stmt->fetchAll();
        foreach ($data as $r) {
            $message = "รายงานข้อมูลอัตโนมัติการAdmit \n - วันที่ admit $r[admitt] \n - $r[fullname] \n - $r[age] ปี  - HN:$r[hn] \n - AN:$r[an]  - $r[ward] ";  
           
            // echo $message;
           sendToLine($message);    
        }
        $conn=null;
        }

    catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

    
?>
	
	