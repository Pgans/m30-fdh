<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%agendas}}".
 *
 * @property int $id
 * @property string $agenda_name ชื่อวาระ
 * @property string $agenda_topic วาระการประชุม
 */
class Agendas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%agendas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['agenda_name', 'agenda_topic'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'agenda_name' => 'Agenda Name',
            'agenda_topic' => 'Agenda Topic',
        ];
    }
}
