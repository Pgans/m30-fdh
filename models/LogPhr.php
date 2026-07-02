<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%log_phr}}".
 *
 * @property int $id
 * @property string $visit_id visit
 * @property string $pid
 * @property string $status สถานะการส่ง
 * @property string $messagecode รหัสสถานะการส่ง
 * @property string $response คืนค่าjson
 * @property string $users ผู้ส่งข้อมูล
 * @property string $d_update วันที่ส่งข้อมูล
 * @property string $cid
 * @property string $regdate
 */
class Logphr extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%log_phr}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db143');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['visit_id', 'd_update'], 'required'],
            [['d_update', 'regdate'], 'safe'],
            [['visit_id', 'pid', 'status'], 'string', 'max' => 50],
            [['messagecode'], 'string', 'max' => 30],
            [['response'], 'string', 'max' => 255],
            [['users'], 'string', 'max' => 100],
            [['cid'], 'string', 'max' => 13],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'visit_id' => 'Visit ID',
            'pid' => 'Pid',
            'status' => 'Status',
            'messagecode' => 'Messagecode',
            'response' => 'Response',
            'users' => 'Users',
            'd_update' => 'D Update',
            'cid' => 'Cid',
            'regdate' => 'Regdate',
        ];
    }
}
