<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%agenda_subs}}".
 *
 * @property int $sub_id
 * @property int $agenda_id
 * @property string $topic หัวข้อย่อย
 * @property string $description รายละเอียดการนำเสนอ
 * @property string $department แผนก
 * @property string $filename ชื่อไฟล์
 * @property string $path uploads
 * @property string $create_date วันบันทึก
 *
 * @property AgendaItem $agenda
 */
class Agendasubs extends \yii\db\ActiveRecord
{
    public $file;  // เพิ่ม property เพื่อรับข้อมูลไฟล์ที่อัพโหลด
    public $filename;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%agenda_subs}}';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['agenda_id'], 'integer'],
            [['sub_description'], 'string'],
            [['create_date'], 'safe'],
            [['sub_topic', 'department', 'filename', 'path'], 'string', 'max' => 255],
           // [['file'], 'file', 'extensions' => 'pdf, doc, docx, xls, xlsx'],
            [['agenda_id'], 'exist', 'skipOnError' => true, 'targetClass' => AgendaItem::className(), 'targetAttribute' => ['agenda_id' => 'agenda_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sub_id' => 'Sub ID',
            'agenda_id' => 'Agenda ID',
            'sub_topic' => 'หัวข้อย่อยวาระประชุม',
            'sub_description' => 'รายละเอียดการนำเสนอ',
            'department' => 'แผนก',
            'filename' => 'ชื่อไฟล์',
            'path' => 'Path',
            'create_date' => 'Create Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgendaItems()
    {
        return $this->hasOne(AgendaItem::className(), ['agenda_id' => 'agenda_id']);
    }
    public function getMeetingAgends()
    {
        return $this->hasOne(Meetingagenda::className(), ['meeting_id' => 'meeting_id']);
    }
    // Generate a unique file name for Thai filename
    public function getUniqueFileName($filename)
    {
        $filename = Yii::$app->security->generateRandomString() . '_' . $filename;
        $filename = preg_replace('/[^\p{L}\p{N}_.]/u', '_', $filename); // Replace non-letter, non-number, non-underscore characters with underscores
        
        return $filename;
    }
}
