<?php
use yii\helpers\Html;
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตรวจสอบสถานะการส่งข้อมูลเคลม</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f3e5f5; /* พื้นหลังสีม่วงอ่อน */
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
        background: linear-gradient(to right, #ba68c8, #ce93d8); /* ไล่เฉดสีม่วง */
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
        background: linear-gradient(to right, #e1bee7, #f3e5f5); /* ไล่เฉดสีม่วงอ่อน */
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .card-title {
        font-size: 18px;
        font-weight: bold;
        color: #6a1b9a; /* สีม่วงเข้ม */
        margin-bottom: 5px;
        display: flex;
        align-items: center;
    }
    .icon-container {
        width: 70px;
        height: 70px;
        background-color: #ab47bc; /* สีม่วง */
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
        font-size: 18px;
        font-weight: bold;
        color: #8e24aa; /* ม่วงเข้ม */
        text-decoration: none;
    }
    .report-link:hover {
        text-decoration: underline;
        color: #6a1b9a;
    }
</style>

</head>
<body>

<div class="text-center">
    <h1 class="dashboard-title" ><i class="fas fa-file-invoice-dollar"></i>
        ตรวจสอบสถานะการส่งข้อมูลเคลม
    </h1>
</div>


</body>
</html>


<div class="container">
    <div class="row">
        <?php
        $reports = [
			//['icon' => 'fas fa-file-invoice-dollar', 'title' => 'สถานะการส่งผู้ป่วยนอกวันนี้', 'url' => ['checkopd/today']],
            ['icon' => 'fas fa-leaf', 'title' => 'สถานะการส่งผู้ป่วยนอก(OPD)', 'url' => ['checkopd/index']],
           // ['icon' => 'fas fa-pills', 'title' => 'สถานะการส่งผู้ป่วยในวันนี้', 'url' => ['/checkipd/today']],
            ['icon' => 'fas fa-seedling', 'title' =>'สถานะการส่งผู้ป่วยใน(IPD)', 'url' => ['/checkipd/index']],
			 ['icon' => 'fas fa-pills', 'title' => 'สถานะการส่งผู้ป่วยในวันนี้', 'url' => ['/checkipd/today']],
           
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
