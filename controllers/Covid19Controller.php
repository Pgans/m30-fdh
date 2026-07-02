<?php

namespace app\controllers;

class Covid19Controller extends \yii\web\Controller
{
    public function actionIndex()
    {
        $today = file_get_contents("https://covid19.th-stat.com/api/open/today");
        $today = json_decode($today);

        $timeline = file_get_contents("https://covid19.th-stat.com/api/open/timeline");
        $timeline = json_decode($timeline);

        $data_confirmed = [];
        $data_recovered = [];
        $data_hospitalized = [];
        $data_deaths = [];

        foreach($timeline->Data as $item) {
            $data_confirmed[] = [$item->Date, (int) $item->Confirmed];
            $data_recovered[] = [$item->Date, (int) $item->Recovered];
            $data_hospitalized[] = [$item->Date, (int) $item->Hospitalized];
            $data_deaths[] = [$item->Date, (int) $item->Deaths];
        }
        $confirmed = [
            'name' => 'ผู้ป่วยสะสม',
            'data' => $data_confirmed,
        ];
        $recovered = [
            'name' => 'หายแล้ว',
            'data' => $data_recovered,
        ];
        $hospitalized = [
            'name' => 'รักษาอยู่ รพ.',
            'data' => $data_hospitalized,
        ];

        $deaths = [
            'name' => 'เสียชีวิต',
            'data' => $data_deaths
        ];

        $timeline = [
            $confirmed,
            $recovered,
            $hospitalized,
            $deaths,
        ];

        $case_sum = $this->getData('https://covid19.th-stat.com/api/open/cases/sum');

        $provinces_name = [];
        $provinces_data = [];
        foreach($case_sum->Province as $province => $value) {
            $provinces_name[] = $province;
            $provinces_data[] = (int) $value;
        }

        $nation_name = [];
        $nation_data = [];
        foreach($case_sum->Nation as $nation => $value) {
            $nation_name[] = $nation;
            $nation_data[] = $value;
        }

        $gender_name = [];
        $gender_data = [];
        foreach($case_sum->Gender as $gender => $value) {
            $gender_name[] = $gender;
            $gender_data[] = $value;
        }


        return $this->render('index', [
            'today' => $today,
            'timeline' => $timeline,
            'provinces_name' => $provinces_name,
            'provinces_data' => $provinces_data,
            'nation_name' => $nation_name,
            'nation_data' => $nation_data,
            'gender_name' => $gender_name,
            'gender_data' => $gender_data,
        ]);
    }

    public function getData($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($status >= 200 && $status < 300) ? json_decode($result) : false;
    }


}
