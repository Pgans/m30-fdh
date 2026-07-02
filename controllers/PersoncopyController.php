<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class PersoncopyController extends Controller
{
    public function actionIndex()
    {
       
        Yii::$app->response->format = Response::FORMAT_JSON;
    
        try {
            // เชื่อมต่อฐานข้อมูล
            $dbjhcis = Yii::$app->db_jhcis;
            $db14j = Yii::$app->db14j;
    
            // ดึงข้อมูลจากตาราง person ในฐานข้อมูล jhcis
            $rows = $dbjhcis->createCommand('SELECT * FROM person')->queryAll();
    
            if (empty($rows)) {
                return ['message' => 'ไม่มีข้อมูลในตาราง person บน Server1'];
            }
    
            // สร้างคำสั่ง SQL สำหรับ Insert และ Update
            foreach ($rows as $row) {
                $id = $row['id'];
    
                // ตรวจสอบว่ามีข้อมูลอยู่ในฐานข้อมูล 14j หรือไม่
                $existingRow = $db14j->createCommand('SELECT COUNT(*) FROM person WHERE id = :id')
                                      ->bindValue(':id', $id)
                                      ->queryScalar();
    
                if ($existingRow > 0) {
                    // ถ้ามีข้อมูลอยู่แล้ว ให้ทำการ Update
                    $updateSQL = 'UPDATE person SET ';
                    $updateFields = [];
    
                    foreach ($row as $column => $value) {
                        if ($column !== 'id') {
                            $updateFields[] = "$column = :$column";
                        }
                    }
    
                    $updateSQL .= implode(', ', $updateFields) . ' WHERE id = :id';
                    $row['id'] = $id; // เพิ่ม id เข้าไปในตัวแปร row เพื่อใช้ใน bind
                    $db14j->createCommand($updateSQL)->bindValues($row)->execute();
                } else {
                    // ถ้ายังไม่มีข้อมูล ให้ทำการ Insert
                    $db14j->createCommand()->insert('person', $row)->execute();
                }
            }
    
            return [
                'message' => 'การคัดลอกและอัปเดตข้อมูลเสร็จสมบูรณ์',
            ];
    
        } catch (\Exception $e) {
            return ['message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()];
        }
}
public function actionTransferdata()
{

        // ดึงข้อมูลจาก SERVER1
        $peopleServer1 = Yii::$app->db_jhcis->createCommand('SELECT * FROM person')->queryAll();
        
        // ดึงข้อมูลจาก SERVER2
        $peopleServer2 = Yii::$app->db14j->createCommand('SELECT * FROM person')->queryAll();
    
        // สร้างอาเรย์เพื่อเก็บ ID ของผู้ที่มีอยู่ใน SERVER2
        $idsServer2 = array_column($peopleServer2, 'id'); // สมมุติว่า 'id' เป็นคีย์หลัก
        
        // คัดกรองข้อมูลเฉพาะที่ไม่มีใน SERVER2
        $newRecords = [];
        foreach ($peopleServer1 as $person) {
            if (!in_array($person['id'], $idsServer2)) {
                $newRecords[] = $person;
            }
        }
        ini_set('max_execution_time', 60); // 60 วินาที
        // นำข้อมูลใหม่ไปยัง SERVER2
foreach ($newRecords as $newPerson) {
    // เปลี่ยน 'CID' เป็น 'idcard'
    $exists = Yii::$app->db14j->createCommand('SELECT COUNT(*) FROM person WHERE idcard = :idcard')
                ->bindValue(':idcard', $newPerson['idcard']) // ใช้คอลัมน์ idcard
                ->queryScalar();

    if ($exists == 0) {
        Yii::$app->db14j->createCommand()->insert('person', $newPerson)->execute();
    }
    
}      
    
        echo "Data transferred successfully.";
    }
    

    public function actionCopydata()
    {
        // ลบข้อมูลใน visitancdeliver ที่อ้างอิงถึง person ก่อน
        Yii::$app->db14j->createCommand()->delete('visitancdeliver', ['pcucodeperson' => $someValue, 'pid' => $someValue, 'pregno' => $someValue])->execute();
    
        // ลบข้อมูลทั้งหมดใน db14j.person
        Yii::$app->db14j->createCommand()->delete('person')->execute();
    
        // ดึงข้อมูลจาก Server1
        $data = Yii::$app->db_jhcis->createCommand('SELECT * FROM person')->queryAll();
    
        // บันทึกข้อมูลไปยัง Server2
        foreach ($data as $row) {
            Yii::$app->db14j->createCommand()->insert('person', $row)->execute();
        }
    
        echo "Data copied successfully!\n";
    }

	################### Fit Test ###############################################################################
public function actionFittest()
{
    // ลบข้อมูลทั้งหมดใน db14j.fdh_thaired
    Yii::$app->db14j->createCommand()->delete('fittest')->execute();

    // ดึงข้อมูลจาก db_jhcis
    $sql = "
    SELECT m.hn,
COALESCE(p.postcodemoi, '34140') AS changwat,
COALESCE(p.distcodemoi, '14') AS amphur,
REPLACE(p.birth, '-', '') AS dob,
p.idcard as cid,
p.marystatus as marriage,
p.occupa,
CONCAT('0','',p.nation) as nation,
ct.titlename as title,
p.fname,
p.lname,
concat(ct.titlename,p.fname,'    ',p.lname)as fullname,
p.pid as pid,
f43.visitno as seq,
vs.symptoms,
cright.mapright,
cright.rightname,
TIMESTAMPDIFF(year,p.birth,f43.dateserv) as age_year,
p.sex as sex,
p.hnomoi as hno,
p.mumoi as mu,
left(vs.pressure,3) as sbp,
right(vs.pressure, 2 ) as dbp,
vs.temperature as btemp,
vs.pulse as pr,
vs.respri as rr,
vs.weight,
vs.height,
vs.waist,
DATE_FORMAT(f43.dateserv,'%Y-%m-%d' )as screen_date,
vs.timestart,
vs.timeend,
p.rightno,
f43.ppspecial,IF(f43.ppspecial='1b0060','ผลลบ','ผลบวก') AS'ผลตรวจ',
p.rightno,
p.dateexpire as uc_expire,
#uc.date_abort,
vs.claimcode_nhso,	
p.hosmain as hospmain,
p.hossub as hospsub,
vs.claimcode_nhso
FROM person p 
INNER JOIN f43specialpp f43 ON p.pid = f43.pid 
INNER JOIN ctitle ct on p.prename = ct.titlecode 
LEFT JOIN visit vs ON vs.visitno = f43.visitno
LEFT JOIN mathhn m ON m.pid = p.pid
LEFT JOIN cright  ON cright.rightcode = p.rightcode
#INNER  JOIN mbase_data1.uc_inscl uc ON uc.cid = m.cid AND (uc.date_abort = date(f43.dateserv) or day(uc.date_abort)=0 and trim(uc.hospmain) <>'' )
WHERE f43.dateserv BETWEEN '2024-10-01'AND NOW()
AND f43.ppspecial IN ('1b0060','1b0061') 
GROUP BY vs.visitno 
    ";
    // ดึงข้อมูลจาก Server1
    $data = Yii::$app->db_jhcis->createCommand($sql)->queryAll();
    $count = 0;
    $latestDateServ = null;

    // บันทึกข้อมูลไปยัง db14j.fdh_fittest
    foreach ($data as $row) {
        Yii::$app->db14j->createCommand()->insert('fittest', $row)->execute();
        $count++;

        // หา date_serv ล่าสุด
        if ($latestDateServ === null || $row['screen_date'] > $latestDateServ) {
            $latestDateServ = $row['screen_date'];
        }
    }

    // ตั้งค่า flash message พร้อมจำนวนแถวที่บันทึกและ date_serv ล่าสุด
    Yii::$app->session->setFlash(
        'success', 
        "ดึงข้อมูลสำเร็จ! จำนวนแถวที่บันทึก: {$count} แถว. screen_date ล่าสุด: {$latestDateServ}"
    );

    // redirect ไปที่หน้า index ของ fittest
    return $this->redirect(['fittest/index']);
}


#################################################### สาวไทยแก้มแดง  ###################################################################################
    public function actionCopydata1()
{
    // ลบข้อมูลทั้งหมดใน db14j.fdh_thaired
    Yii::$app->db14j->createCommand()->delete('fdh_thaired')->execute();

    // ดึงข้อมูลจาก db_jhcis
    $sql = "
        SELECT DISTINCT m.hn,
            person.postcodemoi AS changwat,
            COALESCE(person.distcodemoi, '14') AS amphur,
            REPLACE(person.birth, '-', '') AS dob,
            person.idcard AS cid,
            person.marystatus AS marriage,
            person.occupa,
            CONCAT('0', '', person.nation) AS nation,
            ct.titlename AS title,
            person.fname,
            person.lname,
            CONCAT(ct.titlename, person.fname, '    ', person.lname) AS fullname,
            person.pid AS pid,
            visit.visitno AS seq,
            TIMESTAMPDIFF(YEAR, person.birth, visit.visitdate) AS age_year,
			TIMESTAMPDIFF(MONTH, person.birth, visit.visitdate) % 12 AS age_month,
            visit.symptoms,
            cright.mapright,
            cright.rightname,
            person.sex AS sex,
            person.hnomoi AS hno,
            person.mumoi AS mu,
            LEFT(visit.pressure, 3) AS sbp,
            RIGHT(visit.pressure, 2) AS dbp,
            visit.temperature AS btemp,
            visit.pulse AS pr,
            visit.respri AS rr,
            visit.weight,
            visit.height,
            visit.waist,
            visit.timestart,
            visit.timeend,
            person.rightno,
            visit.pcucode AS hospcode,
			visit.claimcode_nhso,
            IF(visit.visitdate IS NULL OR TRIM(visit.visitdate) = '' OR visit.visitdate LIKE '0000-00-00%', '', DATE_FORMAT(visit.visitdate, '%Y%m%d')) AS date_serv,
            RIGHT(visitdiag.dxtype, 1) AS diagtype,
            REPLACE(IF(cdisease.mapdisease <> '', cdisease.mapdisease, cdisease.diseasecode), '.', '') AS diagcode,
            '00000' AS clinic,
            IFNULL(u.idcard, IFNULL(visitdiag.doctordiag, visit.username)) AS provider,
            IF(visitdiag.dateupdate IS NULL OR TRIM(visitdiag.dateupdate) = '' OR visitdiag.dateupdate LIKE '0000-00-00%', DATE_FORMAT(visit.visitdate, '%Y%m%d%H%i%s'), DATE_FORMAT(visitdiag.dateupdate, '%Y%m%d%H%i%s')) AS D_UPDATE,
            person.idcard AS cidx
        FROM 
            visitdiag 
            LEFT JOIN cdisease ON (visitdiag.diagcode = cdisease.diseasecode) 
            INNER JOIN (SELECT * FROM visit WHERE visit.visitdate BETWEEN '2024-10-01 00:00' AND NOW()) AS visit ON (visitdiag.pcucode = visit.pcucode AND visitdiag.visitno = visit.visitno) 
            INNER JOIN person ON visit.pcucodeperson = person.pcucodeperson AND visit.pid = person.pid 
            LEFT JOIN ctitle ct ON person.prename = ct.titlecode 
            LEFT JOIN cright ON cright.rightcode = person.rightcode
            LEFT JOIN mathhn m ON m.pid = person.pid
            LEFT JOIN `user` u ON visitdiag.pcucode = u.pcucode AND visitdiag.doctordiag = u.username
            #LEFT JOIN mbase_data1.uc_inscl uc ON uc.cid = m.cid AND (uc.date_abort = DATE(visit.visitdate) OR DAY(uc.date_abort) = 0 AND TRIM(uc.hospmain) <> '')
            LEFT JOIN (SELECT pcucodeperson, pid, IF(deaddate IS NULL OR YEAR(deaddate) = '0000', '1890-01-01', deaddate) dd FROM persondeath pd) pde ON visit.pcucodeperson = pde.pcucodeperson AND visit.pid = pde.pid 
        WHERE 
            (visit.flagservice = '01' OR visit.flagservice = '02' OR visit.flagservice = '03' OR visit.flagservice IS NULL OR TRIM(visit.flagservice) = '') 
            AND TRIM(visitdiag.pcucode) <> '' 
            AND visitdiag.pcucode <> ''
            AND cdisease.mapdisease = 'z130'
            AND person.sex = '2'
            AND TIMESTAMPDIFF(YEAR, person.birth, visit.visitdate) BETWEEN '13' AND '45'
            AND (pde.dd >= visitdate OR pde.pid IS NULL)
        ORDER BY 
            visit.pcucode ASC, visit.visitdate DESC, visit.visitno DESC
    ";

    // ดึงข้อมูลจาก Server1
    $data = Yii::$app->db_jhcis->createCommand($sql)->queryAll();
    $count = 0;
    $latestDateServ = null;

    // บันทึกข้อมูลไปยัง db14j.fdh_thaired
    foreach ($data as $row) {
        Yii::$app->db14j->createCommand()->insert('fdh_thaired', $row)->execute();
        $count++;

        // หา date_serv ล่าสุด
        if ($latestDateServ === null || $row['date_serv'] > $latestDateServ) {
            $latestDateServ = $row['date_serv'];
        }
    }

    // ตั้งค่า flash message พร้อมจำนวนแถวที่บันทึกและ date_serv ล่าสุด
    Yii::$app->session->setFlash(
        'success', 
        "ดึงข้อมูลสำเร็จ! จำนวนแถวที่บันทึก: {$count} แถว. Date_serv ล่าสุด: {$latestDateServ}"
    );

    // redirect ไปที่หน้า index ของ f16jthaired
    return $this->redirect(['f16jthaired/index']);
}
######################## เยี่ยมหลังคลอด ##############################################
public function actionCopyanccare()
{
    // ลบข้อมูลทั้งหมดใน db14j.fdh_thaired
    Yii::$app->db14j->createCommand()->delete('fdhanc_care')->execute();

    // ดึงข้อมูลจาก db_jhcis
    $sql = "
    SELECT
    person.postcodemoi as changwat,
    COALESCE(person.distcodemoi, '14') AS amphur,
    REPLACE(person.birth, '-', '') AS dob,
    vmc.pid,
    m.hn,
    vmc.visitno as seq,
    person.idcard as cid,
    person.marystatus as marriage,
    person.occupa,
    CONCAT('0','',person.nation) as nation,
    ct.titlename as title,
    person.fname,
    person.lname,
    concat(ct.titlename,person.fname,'    ',person.lname)as fullname,
    v.symptoms,
    cright.mapright,
    cright.rightname,
    TIMESTAMPDIFF(year,person.birth,vmc.datecare) as age_year,
    person.sex as sex,
    person.hnomoi as hno,
    person.mumoi as mu,
    left(v.pressure,3) as sbp,
    right(v.pressure, 2 ) as dbp,
    v.temperature as btemp,
    v.pulse as pr,
    v.respri as rr,
    v.weight,
    v.height,
    v.waist,
    v.timestart,
    v.timeend,
    person.rightno,
    vmc.pregno ,
    v.claimcode_nhso,
    vd.datedeliver ,
    vmc.datecare, 
    DATEDIFF(vmc.datecare,vd.datedeliver) AS 'ห่างวัน',
    CASE WHEN DATEDIFF(vmc.datecare,vd.datedeliver) <= 7 then 'ครั้งที่ 1'
    WHEN DATEDIFF(vmc.datecare,vd.datedeliver) BETWEEN '8' AND '15' then 'ครั้งที่2'
    WHEN DATEDIFF(vmc.datecare,vd.datedeliver) BETWEEN '16' AND '42' then 'ครั้งที่3' ELSE '' END AS 'ครั้งที่',
    vmc.visitno,
    vmc.locatecare AS 'stan',
    vmc.dateupdate
    FROM visitancmothercare vmc
    INNER JOIN visitancdeliver vd ON vmc.pcucodeperson = vd.pcucodeperson
    INNER JOIN person  ON person.pid = vmc.pid
    LEFT JOIN visit AS v ON vmc.pcucode = v.pcucode AND vmc.visitno = v.visitno 
    LEFT JOIN mathhn m ON m.pid = person.pid
     INNER JOIN ctitle ct on person.prename = ct.titlecode 
     LEFT JOIN cright  ON cright.rightcode = person.rightcode
    AND vmc.pid = vd.pid AND vmc.pregno = vd.pregno
    #LEFT JOIN mbase_data1.uc_inscl uc ON uc.cid = m.cid AND (uc.date_abort = date(vmc.datecare) or day(uc.date_abort)=0 and trim(uc.hospmain) <>'' )
    WHERE vmc.datecare BETWEEN '2024-10-01'AND CURDATE()
    AND vmc.pcucodeperson = vd.pcucodeperson AND vmc.pid = vd.pid AND vmc.pregno = vd.pregno
    GROUP BY vmc.visitno
    ";

    // ดึงข้อมูลจาก Server1
    $data = Yii::$app->db_jhcis->createCommand($sql)->queryAll();
    $count = 0;
    $latestDateServ = null;

    // บันทึกข้อมูลไปยัง db14j.fdh_thaired
    foreach ($data as $row) {
        Yii::$app->db14j->createCommand()->insert('fdhanc_care', $row)->execute();
        $count++;

        // หา date_serv ล่าสุด
        if ($latestDateServ === null || $row['datecare'] > $latestDateServ) {
            $latestDateServ = $row['datecare'];
        }
    }

    // ตั้งค่า flash message พร้อมจำนวนแถวที่บันทึกและ date_serv ล่าสุด
    Yii::$app->session->setFlash(
        'success', 
        "ดึงข้อมูลสำเร็จ! จำนวนแถวที่บันทึก: {$count} แถว. Date_serv ล่าสุด: {$latestDateServ}"
    );

    // redirect ไปที่หน้า index ของ f16jthaired
    return $this->redirect(['f16janccare/index']);
}
################### ฝากครรภ์ ###############################################################################
public function actionCopyanc()
{
    // ลบข้อมูลทั้งหมดใน db14j.fdh_thaired
    Yii::$app->db14j->createCommand()->delete('fdhanc_proc')->execute();

    // ดึงข้อมูลจาก db_jhcis
    $sql = "
    SELECT DISTINCT 
m.hn, person.pid,visitanc.pregno, 
person.postcodemoi as changwat,
COALESCE(person.distcodemoi, '14') AS amphur,
REPLACE(person.birth, '-', '') AS dob,
person.idcard as cid,
person.marystatus as marriage,
person.occupa,
CONCAT('0','',person.nation) as nation,
ct.titlename as title,
person.fname,
person.lname,
concat(ct.titlename,person.fname,'    ',person.lname)as fullname,
v.symptoms,
cright.mapright,
cright.rightname,
TIMESTAMPDIFF(year,person.birth,visitanc.datecheck) as age_year,
person.sex as sex,
person.hnomoi as hno,
person.mumoi as mu,
left(v.pressure,3) as sbp,
right(v.pressure, 2 ) as dbp,
v.temperature as btemp,
v.pulse as pr,
v.respri as rr,
v.weight,
v.height,
v.waist,
v.timestart,
v.timeend,
person.rightno,
vp.lmp,
v.claimcode_nhso,
 visitanc.pcucodeperson AS HOSPCODE, visitanc.visitno AS SEQ, 
 IF( visitanc.datecheck IS NULL OR TRIM( visitanc.datecheck ) = '' OR visitanc.datecheck LIKE '0000-00-00%', '', DATE_FORMAT( visitanc.datecheck, '%Y%m%d' ) ) AS DATE_SERV, 
 visitanc.pregno AS GRAVIDA, 
 ( 
  CASE 
   WHEN IF( datecheck IS NOT NULL AND lmp IS NOT NULL, FLOOR( DATEDIFF( datecheck, lmp ) / 7 ), 0 ) <= 12 AND IF( datecheck IS NOT NULL AND lmp IS NOT NULL, FLOOR( DATEDIFF( datecheck, lmp ) / 7 ), 0 ) <> 0 THEN '1'    
   WHEN IF( datecheck IS NOT NULL AND lmp IS NOT NULL, FLOOR( DATEDIFF( datecheck, lmp ) / 7 ), 0 ) >= 16 AND IF( datecheck IS NOT NULL AND lmp IS NOT NULL, FLOOR( DATEDIFF( datecheck, lmp ) / 7 ), 0 ) <= 20 THEN '2'    
   WHEN IF( datecheck IS NOT NULL AND lmp IS NOT NULL, FLOOR( DATEDIFF( datecheck, lmp ) / 7 ), 0 ) >= 24 AND IF( datecheck IS NOT NULL AND lmp IS NOT NULL, FLOOR( DATEDIFF( datecheck, lmp ) / 7 ), 0 ) <= 28 THEN '3'    
   WHEN IF( datecheck IS NOT NULL AND lmp IS NOT NULL, FLOOR( DATEDIFF( datecheck, lmp ) / 7 ), 0 ) >= 30 AND IF( datecheck IS NOT NULL AND lmp IS NOT NULL, FLOOR( DATEDIFF( datecheck, lmp ) / 7 ), 0 ) <= 34 THEN '4'    
   WHEN IF( datecheck IS NOT NULL AND lmp IS NOT NULL, FLOOR( DATEDIFF( datecheck, lmp ) / 7 ), 0 ) >= 36 AND IF( datecheck IS NOT NULL AND lmp IS NOT NULL, FLOOR( DATEDIFF( datecheck, lmp ) / 7 ), 0 ) <= 40 THEN '5'    
   ELSE '' 
  END 
 ) AS ANCNO, 
 ( SELECT FLOOR( DATEDIFF( CAST( visitanc.datecheck AS DATE ), CAST( visitancpregnancy.lmp AS DATE ) ) / 7 ) FROM visitancpregnancy WHERE visitancpregnancy.pcucodeperson = visitanc.pcucodeperson AND visitancpregnancy.pid = visitanc.pid AND visitancpregnancy.pregno = visitanc.pregno ) AS GA,  
 IF( ( visitanc.ancres IS NULL OR visitanc.hosservice = '' ), '9', visitanc.ancres ) AS ANCRESULT, 
 IF( ( visitanc.hosservice IS NULL OR visitanc.hosservice = '' ), IFNULL( visitanc.pcucode, '00000' ), visitanc.hosservice ) AS ANCPLACE,
 IF( u.idcard IS NULL OR TRIM( u.idcard ) = '', '', u.idcard ) AS PROVIDER, 
 IF( visitanc.dateupdate IS NULL OR TRIM( visitanc.dateupdate ) = '' OR visitanc.dateupdate LIKE '0000-00-00%', DATE_FORMAT( visitanc.datecheck, '%Y%m%d%H%i%s' ), DATE_FORMAT( visitanc.dateupdate, '%Y%m%d%H%i%s' ) ) AS D_UPDATE 
FROM 
 visitanc 
 INNER JOIN person ON visitanc.pcucodeperson = person.pcucodeperson AND visitanc.pid = person.pid 
 INNER JOIN visitancpregnancy AS vp ON visitanc.pcucodeperson = vp.pcucodeperson AND visitanc.pid = vp.pid AND visitanc.pregno = vp.pregno 
 LEFT JOIN visit AS v ON visitanc.pcucode = v.pcucode AND visitanc.visitno = v.visitno 
 LEFT JOIN user AS u ON v.pcucode = u.pcucode AND v.username = u.username 
 LEFT JOIN mathhn m ON m.pid = person.pid
 INNER JOIN ctitle ct on person.prename = ct.titlecode 
 LEFT JOIN cright  ON cright.rightcode = person.rightcode
#INNER  JOIN mbase_data1.uc_inscl uc ON uc.cid = m.cid AND (uc.date_abort = date(visitanc.datecheck) or day(uc.date_abort)=0 and trim(uc.hospmain) <>'' )
WHERE 
 visitanc.pcucodeperson IS NOT NULL 
 AND TRIM( visitanc.pcucodeperson ) <> '' 
 AND 
  ( 
   CASE 
    WHEN IF( datecheck IS NOT NULL AND lmp IS NOT NULL, FLOOR( DATEDIFF( datecheck, lmp ) / 7 ), 0 ) <= 12 AND IF( datecheck IS NOT NULL AND lmp IS NOT NULL, FLOOR( DATEDIFF( datecheck, lmp ) / 7 ), 0 ) <> 0 THEN '1'    
    WHEN IF( datecheck IS NOT NULL AND lmp IS NOT NULL, FLOOR( DATEDIFF( datecheck, lmp ) / 7 ), 0 ) >= 16 AND IF( datecheck IS NOT NULL AND lmp IS NOT NULL, FLOOR( DATEDIFF( datecheck, lmp ) / 7 ), 0 ) <= 20 THEN '2'    
    WHEN IF( datecheck IS NOT NULL AND lmp IS NOT NULL, FLOOR( DATEDIFF( datecheck, lmp ) / 7 ), 0 ) >= 24 AND IF( datecheck IS NOT NULL AND lmp IS NOT NULL, FLOOR( DATEDIFF( datecheck, lmp ) / 7 ), 0 ) <= 28 THEN '3'    
    WHEN IF( datecheck IS NOT NULL AND lmp IS NOT NULL, FLOOR( DATEDIFF( datecheck, lmp ) / 7 ), 0 ) >= 30 AND IF( datecheck IS NOT NULL AND lmp IS NOT NULL, FLOOR( DATEDIFF( datecheck, lmp ) / 7 ), 0 ) <= 34 THEN '4'    
    WHEN IF( datecheck IS NOT NULL AND lmp IS NOT NULL, FLOOR( DATEDIFF( datecheck, lmp ) / 7 ), 0 ) >= 36 AND IF( datecheck IS NOT NULL AND lmp IS NOT NULL, FLOOR( DATEDIFF( datecheck, lmp ) / 7 ), 0 ) <= 40 THEN '5'    
    ELSE '0' 
   END 
  ) IN( '1', '2', '3', '4', '5', '0', '' ) 
 AND TRIM( visitanc.pcucodeperson ) <> '' 
 AND visitanc.pcucodeperson <> '' 
 AND ( visitanc.datecheck >= ( DATE_SUB( CURDATE( ), INTERVAL 10 YEAR ) ) ) 
 AND ( ( visitanc.datecheck >= ( DATE_SUB( CURDATE( ), INTERVAL 10 YEAR ) ) ) OR ( DATE( visitanc.dateupdate ) >= ( DATE_SUB( CURDATE( ), INTERVAL 10 YEAR ) ) ) )
 AND DATE_FORMAT( visitanc.datecheck, '%Y-%m-%d' ) BETWEEN '2024-10-01' AND NOW()
GROUP BY visitanc.visitno
ORDER BY 
 visitanc.pcucodeperson ASC, visitanc.datecheck DESC, visitanc.visitno DESC
    ";
    // ดึงข้อมูลจาก Server1
    $data = Yii::$app->db_jhcis->createCommand($sql)->queryAll();
    $count = 0;
    $latestDateServ = null;

    // บันทึกข้อมูลไปยัง db14j.fdh_thaired
    foreach ($data as $row) {
        Yii::$app->db14j->createCommand()->insert('fdhanc_proc', $row)->execute();
        $count++;

        // หา date_serv ล่าสุด
        if ($latestDateServ === null || $row['DATE_SERV'] > $latestDateServ) {
            $latestDateServ = $row['DATE_SERV'];
        }
    }

    // ตั้งค่า flash message พร้อมจำนวนแถวที่บันทึกและ date_serv ล่าสุด
    Yii::$app->session->setFlash(
        'success', 
        "ดึงข้อมูลสำเร็จ! จำนวนแถวที่บันทึก: {$count} แถว. Date_serv ล่าสุด: {$latestDateServ}"
    );

    // redirect ไปที่หน้า index ของ f16jthaired
    return $this->redirect(['f16janc/index']);
}
}

?>
