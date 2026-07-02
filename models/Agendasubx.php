<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%agenda_subx}}".
 *
 * @property int $sub_id
 * @property int $meeting_id
 * @property int $agenda_id
 * @property string $sub_topic หัวข้อย่อย
 * @property string $sub_description รายละเอียดการนำเสนอ
 * @property string $department แผนก
 * @property string $filename ชื่อไฟล์
 * @property string $path uploads
 * @property string $create_date วันบันทึก
 *
 * @property AgendaItemx $agenda
 */
class Agendasubx extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%agenda_subx}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['meeting_id', 'agenda_id'], 'integer'],
            [['sub_description'], 'string'],
            [['create_date'], 'safe'],
            [['sub_topic', 'department', 'filename', 'path'], 'string', 'max' => 255],
            [['agenda_id'], 'exist', 'skipOnError' => true, 'targetClass' => AgendaItemx::className(), 'targetAttribute' => ['agenda_id' => 'agenda_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sub_id' => 'Sub ID',
            'meeting_id' => 'Meeting ID',
            'agenda_id' => 'Agenda ID',
            'sub_topic' => 'Sub Topic',
            'sub_description' => 'Sub Description',
            'department' => 'Department',
            'filename' => 'Filename',
            'path' => 'Path',
            'create_date' => 'Create Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgenda()
    {
        return $this->hasOne(AgendaItemx::className(), ['agenda_id' => 'agenda_id']);
    }
}
