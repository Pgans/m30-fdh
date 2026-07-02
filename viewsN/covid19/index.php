<?php

use onmotion\apexcharts\ApexchartsWidget;
/* @var $this yii\web\View */

$this->title = 'COVID-19';
?>
<?php //var_dump($today)
?>

<h2 class="text-center">สถานการณ์ COVID-19 ในประเทศไทย</h2>
<div class="text-center">
    ข้อมูล ณ วันที่ <?= $today->UpdateDate ?> ที่มา <?= $today->Source ?>
</div>
<div class="row my-4">
    <div class="col-md-3">
        <div class="card bg-warning shadow">
            <div class="card-body">
                <span>ติดเชื้อสะสม</span>
                <h1>
                    <?= number_format($today->Confirmed) ?><br />
                </h1>
                <small><?= $today->NewConfirmed > 0 ? 'เพิ่มขึ้น +' . $today->NewConfirmed : '' ?></small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success shadow">
            <div class="card-body">
                <span>หายแล้ว</span>
                <h1>
                    <?= number_format($today->Recovered) ?><br />
                </h1>
                <small><?= $today->NewRecovered > 0 ? 'เพิ่มขึ้น +' . $today->NewRecovered : '' ?></small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info shadow">
            <div class="card-body">
                <span>กำลังรักษา</span>
                <h1>
                    <?= number_format($today->Hospitalized) ?><br />
                </h1>
                <small><?= $today->NewHospitalized > 0 ? 'เพิ่มขึ้น +' . $today->NewHospitalized : '' ?></small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger shadow">
            <div class="card-body">
                <span>เสียชีวิต</span>
                <h1>
                    <?= number_format($today->Deaths) ?><br />
                </h1>
                <small><?= $today->NewDeaths > 0 ? 'เพิ่มขึ้น +' . $today->NewDeaths : '' ?></small>
            </div>
        </div>
    </div>
</div>

<div class="card shadow my-4">
    <div class="card-body">
        <h2 class="text-center">รายงานสถานการณ์ตามช่วงเวลา</h2>
        <?= ApexchartsWidget::widget([
            'type' => 'area', // default area
            'height' => '400', // default 350
            'width' => '100%', // default 100%
            'chartOptions' => [
                'chart' => [
                    'toolbar' => [
                        'show' => true,
                        'autoSelected' => 'zoom'
                    ],
                ],
                'xaxis' => [
                    'type' => 'datetime',
                    // 'categories' => $categories,
                ],
                'plotOptions' => [
                    'bar' => [
                        'horizontal' => false,
                        'endingShape' => 'rounded'
                    ],
                ],
                'dataLabels' => [
                    'enabled' => false
                ],
                'stroke' => [
                    'show' => true,
                    'colors' => ['transparent']
                ],
                'legend' => [
                    'verticalAlign' => 'bottom',
                    'horizontalAlign' => 'left',
                ],
            ],
            'series' => $timeline
        ]) ?>
    </div>
</div>


<div class="card shadow my-4">
    <div class="card-body">
        <?php //var_dump($case_sum)
        ?>
        <h2 class="text-center">จำนวนผู้ติดเชื้อสะสมแบ่งตามจังหวัด</h2>
        <?= ApexchartsWidget::widget([
            'type' => 'bar', // default area
            'height' => '400', // default 350
            'width' => '100%', // default 100%
            'chartOptions' => [
                'chart' => [
                    'toolbar' => [
                        'show' => true,
                        'autoSelected' => 'zoom'
                    ],
                ],
                'xaxis' => [
                    //'type' => 'datetime',
                    'categories' => $provinces_name,
                ],
                'plotOptions' => [
                    'bar' => [
                        'horizontal' => false,
                        'endingShape' => 'rounded'
                    ],
                ],
                'dataLabels' => [
                    'enabled' => true
                ],
                'stroke' => [
                    'show' => true,
                    'colors' => ['transparent']
                ],
                'legend' => [
                    'verticalAlign' => 'bottom',
                    'horizontalAlign' => 'left',
                ],
            ],
            'series' => [['name' => 'จำนวน', 'data' => $provinces_data]]
        ]) ?>
        <?php //var_dump($provinces_data)
        ?>
    </div>
</div>


<div class="card shadow my-4">
    <div class="card-body">
        <?php //var_dump($case_sum)
        ?>
        <h2 class="text-center">จำนวนผู้ติดเชื้อสะสมแบ่งตามสัญชาติ</h2>
        <?= ApexchartsWidget::widget([
            'type' => 'bar', // default area
            'height' => '600', // default 350
            'width' => '100%', // default 100%
            'chartOptions' => [
                'chart' => [
                    'toolbar' => [
                        'show' => true,
                        'autoSelected' => 'zoom'
                    ],
                ],
                'xaxis' => [
                    //'type' => 'datetime',
                    'categories' => $nation_name,
                ],
                'plotOptions' => [
                    'bar' => [
                        'horizontal' => true,
                        'endingShape' => 'rounded'
                    ],
                ],
                'dataLabels' => [
                    'enabled' => true
                ],
                'stroke' => [
                    'show' => true,
                    'colors' => ['transparent']
                ],
                'legend' => [
                    'verticalAlign' => 'bottom',
                    'horizontalAlign' => 'left',
                ],
            ],
            'series' => [['name' => 'จำนวน', 'data' => $nation_data]]
        ]) ?>
        <?php //var_dump($provinces_data)
        ?>
    </div>
</div>

<!-- 
<div class="card shadow my-4">
    <div class="card-body">
        <?php //var_dump($case_sum)
        ?>
        <h2 class="text-center">จำนวนผู้ติดเชื้อสะสมแบ่งตามเพศ</h2>
        <?= //ApexchartsWidget::widget([
            'type' => 'pie', // default area
            'height' => '400', // default 350
            'width' => '100%', // default 100%
            'chartOptions' => [
                'labels' => $gender_name,
            
            ],
            'series' => $gender_data
        ]) ?>
        <?php //var_dump($provinces_data)
        ?>
    </div>
</div> -->