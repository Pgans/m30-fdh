<?php

namespace app\controllers;

use yii\web\Controller;
use Yii;

class HolidayController extends Controller
{
    public function actionFetch()
    {
        $url = 'https://calendar.google.com/calendar/ical/th.th%23holiday%40group.v.calendar.google.com/public/basic.ics';
        $ics = @file_get_contents($url);

        if (!$ics) {
            Yii::$app->session->setFlash('error', 'ไม่สามารถโหลดข้อมูลวันหยุดได้');
            return $this->redirect(['index']);
        }

        $lines = explode("\n", $ics);
        $holidays = [];
        $currentEvent = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === 'BEGIN:VEVENT') {
                $currentEvent = [];
            } elseif ($line === 'END:VEVENT') {
                if (isset($currentEvent['DTSTART']) && strpos($currentEvent['DTSTART'], '2026') === 0) {
                    $holidays[] = [
                        'date' => date('Y-m-d', strtotime($currentEvent['DTSTART'])),
                        'title' => $currentEvent['SUMMARY'] ?? '',
                    ];
                }
            } else {
                if (strpos($line, 'DTSTART') === 0) {
                    $parts = explode(':', $line);
                    $currentEvent['DTSTART'] = $parts[1] ?? null;
                }
                if (strpos($line, 'SUMMARY') === 0) {
                    $parts = explode(':', $line, 2);
                    $currentEvent['SUMMARY'] = $parts[1] ?? null;
                }
            }
        }

        Yii::$app->session->set('holidays', $holidays);
        Yii::$app->session->setFlash('success', 'โหลดข้อมูลวันหยุดปี 2569 สำเร็จแล้ว');

        return $this->redirect(['index']);
    }

    public function actionIndex()
{
    $holidays = Yii::$app->session->get('holidays', []);

    // ชื่อเดือน
    $monthNames = [
        '01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม',
        '04' => 'เมษายน', '05' => 'พฤษภาคม', '06' => 'มิถุนายน',
        '07' => 'กรกฎาคม', '08' => 'สิงหาคม', '09' => 'กันยายน',
        '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม',
    ];

    // จัดกลุ่มวันหยุดตามเดือน
    $grouped = [];
    foreach ($holidays as $holiday) {
        $month = date('m', strtotime($holiday['date']));
        $grouped[$month][] = [
            'date' => date('j', strtotime($holiday['date'])) . ' ' . $monthNames[$month] . ' ' . (date('Y', strtotime($holiday['date'])) + 543),
            'title' => $holiday['title'],
            'day' => date('j', strtotime($holiday['date'])), // เก็บวัน
        ];
    }

    // เรียงกลุ่มตามเดือน
    ksort($grouped);

    // เรียงภายในแต่ละเดือนตามวัน
    foreach ($grouped as $month => &$holidays) {
        usort($holidays, function ($a, $b) {
            return $a['day'] - $b['day']; // เปรียบเทียบวัน
        });
    }

    return $this->render('index', [
        'groupedHolidays' => $grouped,
    ]);
}

}
