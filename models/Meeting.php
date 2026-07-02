<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%meeting}}".
 *
 * @property int $meeting_id
 * @property string $title หัวข้อการประชุม
 * @property string $attime ครั้งที่
 * @property string $date วันที่
 * @property string $time เวลา
 * @property string $user ผู้จัด
 * @property string $create_date วันบันทึก
 *
 * @property Agendax[] $agendaxes
 */
class Meeting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%meeting}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'time', 'create_date'], 'safe'],
            [['title', 'attime'], 'string', 'max' => 255],
            [['user'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'meeting_id' => 'Meeting ID',
            'title' => 'การประชุม',
            'attime' => 'ครั้งที่',
            'date' => 'วันที่',
            'time' => 'เวลา',
            'user' => 'ผู้จัด',
            'create_date' => 'วันบันทึก',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgendas()
    {
        return $this->hasMany(Agenda::className(), ['meeting_id' => 'meeting_id']);
    }
}
