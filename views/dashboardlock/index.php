<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\helpers\Url;

$this->title = 'Dashboard แสดงข้อมูลการทำงานของ Server Mbase';
?>

<div class="dashboard" style="background-color: #f3e5f5; padding: 20px; border-radius: 10px;">
    <h1 style="color: #6a1b9a;">
<?= Html::encode($this->title) ?></h1>

    <!-- แสดงเวลาปัจจุบัน -->
    <div id="current-time" style="color: #6a1b9a; font-weight: bold; font-size: 16px;">
        เวลาปัจจุบัน: <?= date('Y-m-d H:i:s') ?>
    </div>

    <!-- ใช้ Flexbox เพื่อแบ่ง col-6 -->
    <div class="row" style="display: flex;">
        <!-- ตารางข้อมูล -->
        <div class="col-6" style="padding: 10px; flex: 1;">
            <div class="table-container" style="background-color: #ffffff; border-radius: 10px; padding: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $data,
                        'pagination' => false,
                    ]),
                    'columns' => [
                        'Database',
                        'Table',
                        [
                            'attribute' => 'In_use',
                            'label' => 'In Use',
                        ],
                        [
                            'attribute' => 'Name_locked',
                            'label' => 'Name Locked',
                        ],
                    ],
                ]) ?>
            </div>
        </div>

        <!-- กราฟข้อมูล -->
		
        <div class="col-6" style="padding: 10px; flex: 1;">
            <div class="chart-container" style="background-color: #ffffff; border-radius: 10px; padding: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <canvas id="line-chart" style="width: 100%; height: 400px;"></canvas>
				
            </div>
        </div>
    </div>
     
    <!-- Script ที่จะทำการรีเฟรชข้อมูลและเวลา -->
	<!--
    <?php
    $this->registerJs(new JsExpression('
        function updateDashboard() {
            $.ajax({
                url: "' . Url::to(['dashboardlock/index']) . '",
                success: function(data) {
                    $(".table-container").html($(data).find(".table-container"));
                }
            });
        }

        function updateTime() {
            $("#current-time").text(new Date().toLocaleString());
        }

       // setInterval(updateDashboard, 60000); // รีเฟรชข้อมูลทุก 1 นาที
       // setInterval(updateTime, 1000); // อัปเดตเวลาทุกวินาที
    '));
    ?>
	-->

    <!-- กราฟเส้นแบบ Real-time -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('line-chart').getContext('2d');
        var lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= Json::encode(array_column($data, 'Table')) ?>,
                datasets: [{
                    label: 'In Use Count',
                    data: <?= Json::encode(array_column($data, 'In_use')) ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                animation: {
                    duration: 0 // ไม่มีการแอนิเมชั่น
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });

        // ฟังก์ชันอัปเดตกราฟแบบ Real-time
        function updateChartData() {
            $.ajax({
                url: "' . Url::to(['dashboardlock/get-realtime-data']) . '",
                success: function(data) {
                    var parsedData = JSON.parse(data);
                    lineChart.data.labels.push(parsedData.label);
                    lineChart.data.datasets[0].data.push(parsedData.value);

                    // รีเฟรชกราฟ
                    if (lineChart.data.labels.length > 10) {
                        lineChart.data.labels.shift(); // ลบข้อมูลเก่า
                        lineChart.data.datasets[0].data.shift();
                    }

                    lineChart.update();
                }
            });
        }

        setInterval(updateChartData, 1000); // รีเฟรชข้อมูลกราฟทุก 1 วินาที
    </script>
</div>
