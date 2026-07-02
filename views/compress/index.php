<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = 'GZIP / PIGZ Process Monitor';
$this->registerCss(<<<CSS
body {
    background: linear-gradient(135deg, #1f4037, #99f2c8);
    font-family: 'Segoe UI', sans-serif;
}

.glass-box {
    background: rgba(255, 255, 255, 0.15);
    border-radius: 16px;
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    backdrop-filter: blur(7.5px);
    -webkit-backdrop-filter: blur(7.5px);
    border: 1px solid rgba(255, 255, 255, 0.18);
    padding: 30px;
    margin-top: 40px;
    color: #fff;
}

h1 {
    text-align: center;
    color: #ffffff;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
    font-weight: bold;
    margin-bottom: 30px;
}

.table-glass {
    width: 100%;
    color: #fff;
    background: rgba(255,255,255,0.05);
    border-radius: 12px;
    overflow: hidden;
    margin-top: 20px;
}

.table-glass thead {
    background-color: rgba(255, 255, 255, 0.15);
    font-weight: bold;
    text-transform: uppercase;
}

.table-glass th, .table-glass td {
    padding: 12px 15px;
    text-align: left;
}

.btn-kill {
    background-color: #ff4d4d;
    color: white;
    border: none;
    padding: 6px 14px;
    border-radius: 8px;
    transition: 0.3s ease-in-out;
    cursor: pointer;
}

.btn-kill:hover {
    background-color: #e60000;
    transform: scale(1.05);
}
CSS);
?>

<div class="container">
    <div class="glass-box">
        <h1><?= Html::encode($this->title) ?></h1>

        <table class="table-glass">
            <thead>
                <tr>
                    <th>Host</th>
                    <th>PID</th>
                    <th>Elapsed Time</th>
                    <th>Command</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($processes as $p): ?>
                    <tr>
                        <td><?= isset($p['host']) ? Html::encode($p['host']) : '-' ?></td>
                        <td><?= isset($p['pid']) ? Html::encode($p['pid']) : '-' ?></td>
                        <td><?= isset($p['etime']) ? Html::encode($p['etime']) : '-' ?></td>
                        <td><pre><?= isset($p['cmd']) ? Html::encode($p['cmd']) : '-' ?></pre></td>
                        <td>
                            <?= Html::button('Kill', [
                                'class' => 'btn-kill',
                                'data-pid' => $p['pid'],
                                'data-host' => $p['host'],
                                'data-user' => $p['user'],
                                'onclick' => new JsExpression("
                                    var pid = $(this).data('pid');
                                    var host = $(this).data('host');
                                    var user = $(this).data('user');
                                    if (confirm('Kill process ' + pid + ' on ' + host + '?')) {
                                        $.post('" . Url::to(['compress/kill']) . "', {
                                            host: host,
                                            user: user,
                                            pid: pid
                                        },
