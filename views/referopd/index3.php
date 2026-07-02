<?php
use yii\helpers\Html;
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ศูนย์จัดเก็บรายได้</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e3f2fd; /* พื้นหลังสีฟ้าอ่อน */
            padding: 20px;
        }
        .dashboard-title {
            display: inline-block;
            text-align: center;
            font-size: 36px;
            font-weight: bold;
            color: white;
            padding: 10px 30px;
            border-radius: 15px;
            background: linear-gradient(to right, #42a5f5, #90caf9); /* ไล่เฉดสีฟ้า */
            box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.2);
            margin: 20px auto;
        }
        .card-custom {
            border-radius: 15px;
            background: #ffffff;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s, box-shadow 0.3s;
            padding: 15px;
            margin-bottom: 20px;
        }
        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.3);
        }
        .card-body {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            background: linear-gradient(to right, #bbdefb, #e3f2fd); /* ไล่เฉดสีฟ้าอ่อน */
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .card-title {
            font-size: 18px;
            font-weight: bold;
            color: #1565c0; /* สีน้ำเงินเข้ม */
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }
        .icon-container {
            width: 70px;
            height: 70px;
            background-color: #64b5f6; /* สีฟ้าปานกลาง */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
        }
        .icon-container i {
            font-size: 22px;
            color: #ffffff;
        }
        .report-link {
            font-size: 16px;
            font-weight: bold;
            color: #1e88e5; /* ฟ้าเข้ม */
            text-decoration: none;
        }
        .report-link:hover {
            text-decoration: underline;
            color: #1565c0;
        }
    </style>
</head>
<body>

<div class="text-center">
    <h1 class="dashboard-title" ><i class="fas fa-file-invoice-dollar"></i>
        ศูนย์จัดเก็บรายได้ โรงพยาบาลม่วงสามสิบ
    </h1>
</div>


</body>
</html>


<div class="container">
    <div class="row">
        <?php
        $reports = [
			['icon' => 'fas fa-file-invoice-dollar', 'title' => 'ศูนย์จัดเก็บรายได้', 'url' => ['mmm/index']],
            ['icon' => 'fas fa-leaf', 'title' => 'ประมวลผลผู้ป่วยนอก', 'url' => ['opd/index']],
            ['icon' => 'fas fa-pills', 'title' => 'ประมวลผลผู้ป่วยใน', 'url' => ['/ipd/index']],
            ['icon' => 'fas fa-seedling', 'title' =>'ต่างด้าว OPD', 'url' => ['/thangopd/index']],
            ['icon' => 'fas fa-user-md', 'title' => 'ต่างด้าว IPD', 'url' => ['/thangipd/index']],
            ['icon' => 'fas fa-stethoscope', 'title' => 'ต่างด้าวแม่มาคลอด', 'url' => ['/thangdown/index']],
            ['icon' => 'fas fa-file-medical', 'title' => 'ตรวจสอบReferมากกว่า2 ครั้ง', 'url' => ['/adjrw/refer']],
            ['icon' => 'fas fa-calendar-alt', 'title' => 'ผู้ป่วยใน-ADJRW', 'url' => ['/adjrw/adjipd']],
			['icon' => 'fas fa-leaf', 'title' => 'ผู้ป่วยนอกแยกสิทธิ์', 'url' => ['/adjrw/opdtotal']],
            ['icon' => 'fas fa-seedling', 'title' =>'Rep-Admit28', 'url' => ['/readmit/readmit']],
            ['icon' => 'fas fa-user-md', 'title' => 'Rep-Visit48', 'url' => ['/readmit/revisit']],
            ['icon' => 'fas fa-stethoscope', 'title' => 'Unplan-Refer', 'url' => ['/readmit/unplan']],
			['icon' => 'fas fa-calendar-alt', 'title' => 'Refer-ER', 'url' => ['/readmit/referopd']],
			['icon' => 'fas fa-calendar-alt', 'title' => 'OP-UCS นอกเขต ในจังหวัด', 'url' => ['/opucs/opucin']],
			['icon' => 'fas fa-calendar-alt', 'title' => 'OP-UCS นอกเขต นอกจังหวัด', 'url' => ['/opucs/opucout']],
			['icon' => 'fas fa-pills', 'title' => 'fibroscan(92.02)', 'url' => ['/operations/index']],
			['icon' => 'fas fa-stethoscope', 'title' => 'scanning C.A.T (88.38)', 'url' => ['/operations/icd8838']],
        ];

        foreach ($reports as $report) {
            echo '<div class="col-md-6 col-lg-4 mb-4">
                    <div class="card card-custom">
                        <div class="card-body">
                            <div class="icon-container">
                                <i class="'.$report['icon'].'"></i>
                            </div>
                            <h5 class="card-title">'. Html::a($report['title'], $report['url'], ['class' => 'report-link']) .'</h5>
                        </div>
                    </div>
                </div>';
        }
        ?>
    </div>
</div>

</body>
</html>
