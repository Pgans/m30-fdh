<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use \miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

$this->title = 'สถานะการส่ง API Mbase';
?>
 <div class="panel-body">
    <div class="panel panel-info">
        <div class="panel-heading" ><i class="glyphicon glyphicon-plus"></i> ระบบรายงานข้อมูล10 อันดับโรคผู้ป้วยนอก</<i></div>
        <div class="panel-body">
        
     <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-info">
                        <div class="panel-heading" ><i class="glyphicon glyphicon-user"></i> ปีงบประมาณ 2566</<i></div>
                        <div class="panel-body">
                            <div>
                       
                                <?php
                                //use yii\grid\GridView;

                                echo GridView::widget([
                                    'dataProvider' => $opd1066dataProvider,
                                    'responsive' => true,
                                    'showFooter' => false,
                                    'summary'=>'',
                                    'responsive' => true,
                                    'hover' => true,
                                   
                                  
                                    'pjax' => true,
                                    'pjaxSettings' => [
                                        'neverTimeout' => true,
                                    ],
                                    'columns' => [
                                         ['class' => 'yii\grid\SerialColumn'],
                                        [
                                            'label' => 'รหัส',
                                            'attribute' => 'ICD10_TM',
                                            'headerOptions' => ['style' => 'background-color: #; color: #3498DB;'],
                                            

                                        ],
                                        [
                                            'label' => 'ชื่อโรค',
                                            'attribute' => 'ICD_NAME',
                                            'headerOptions' => ['style' => 'background-color: #; color: #3498DB;'],

                                        ],
                                        [
                                            'label' => 'จำนวน',
                                            'attribute' => 'AMOUNT',
                                            'headerOptions' => ['style' => 'background-color: #; color: #3498DB;'],
                                            'format' => ['decimal', 0]
                                        ],
                                        

                                    ],
                                ]);
                                ?>
                            </div>
                            <a style="color:#ff6c00">
                                        -ยกเว้นรหัส O และ Z ที่เป็นโรคหลัก
                                        </a>' 
                            </div></div></div>
                <div class="col-md-4">
                    <div class="panel panel-info">
                        <div class="panel-heading" ><i class="glyphicon glyphicon-user"></i> ปีงบประมาณ 2565</<i></div>
                        <div class="panel-body">
                            <div>
                       
                                <?php
                                //use yii\grid\GridView;

                                echo GridView::widget([
                                    'dataProvider' => $opd1065dataProvider,
                                    'responsive' => true,
                                    'showFooter' => false,
                                    'summary'=>'',
                                  
                                    'pjax' => true,
                                    'pjaxSettings' => [
                                        'neverTimeout' => true,
                                    ],
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn'],
                                       [
                                           'label' => 'รหัส',
                                           'attribute' => 'ICD10_TM',
                                           'headerOptions' => ['style' => 'background-color: #; color: #3498DB;'],
                                           

                                       ],
                                       [
                                           'label' => 'ชื่อโรค',
                                           'attribute' => 'ICD_NAME',
                                           'headerOptions' => ['style' => 'background-color: #; color: #3498DB;'],

                                       ],
                                       [
                                           'label' => 'จำนวน',
                                           'attribute' => 'AMOUNT',
                                           'headerOptions' => ['style' => 'background-color: #; color: #3498DB;'],
                                           'format' => ['decimal', 0]
                                       ],

                                    ],
                                ]);
                                ?>
                            </div>
                            <a style="color:#ff6c00">
                                        -ยกเว้นรหัส O และ Z ที่เป็นโรคหลัก
                                        </a>' 
                            </div></div></div>
                            <div class="col-md-4">
                    <div class="panel panel-info">
                        <div class="panel-heading"><i class="glyphicon glyphicon-user"></i>ปีงบประมาณ 2564</<i></div>
                        <div class="panel-body">
                            <div>
                       
                                <?php
                                //use yii\grid\GridView;

                                echo GridView::widget([
                                    'dataProvider' => $opd1064dataProvider,
                                    'responsive' => true,
                                   'showFooter' => false,
                                    'summary'=>'',
                                  
                                    'pjax' => true,
                                    'pjaxSettings' => [
                                        'neverTimeout' => true,
                                    ],
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn'],
                                       [
                                           'label' => 'รหัส',
                                           'attribute' => 'ICD10_TM',
                                           'headerOptions' => ['style' => 'background-color: #; color: #3498DB;'],
                                           

                                       ],
                                       [
                                           'label' => 'ชื่อโรค',
                                           'attribute' => 'ICD_NAME',
                                           'headerOptions' => ['style' => 'background-color: #; color: #3498DB;'],

                                       ],
                                       [
                                           'label' => 'จำนวน',
                                           'attribute' => 'AMOUNT',
                                           'headerOptions' => ['style' => 'background-color: #; color: #3498DB;'],
                                           'format' => ['decimal', 0]
                                       ],
										
                                    ],
                                ]);
                                ?>
                            </div>
                            <a style="color:#ff6c00">
                                        -ยกเว้นรหัส O และ Z ที่เป็นโรคหลัก
                                        </a>' 
                            </div></div></div></div></div></div>
