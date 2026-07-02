<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%upload_file}}".
 *
 * @property int $key_id รหัส
 * @property int $agenda_id
 * @property int $meeting_id
 * @property string $key_point ประเด็นสำคัญ
 * @property string $show_work เสนอข้อมูล
 * @property string $create_date วันบันทึก
 * @property string $filename ชื่อไฟล์
 * @property string $path uploads
 *
 * @property AgendaItem $agenda
 * @property MeetingAgenda $meeting
 */
class Uploadfile extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%upload_file}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['agenda_id', 'meeting_id'], 'integer'],
            [['meeting_id'], 'required'],
            [['show_work'], 'string'],
            [['create_date'], 'safe'],
            [['key_point', 'filename', 'path','discription2'], 'string', 'max' => 255],
           // [['file'], 'file', 'skipOnEmpty' => false],
            [['agenda_id'], 'exist', 'skipOnError' => true, 'targetClass' => AgendaItem::className(), 'targetAttribute' => ['agenda_id' => 'agenda_id']],
            [['meeting_id'], 'exist', 'skipOnError' => true, 'targetClass' => MeetingAgenda::className(), 'targetAttribute' => ['meeting_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'key_id' => 'Key ID',
            'agenda_id' => 'วาระการประชม',
            'meeting_id' => 'การประชุม',
            'key_point' => 'ประเด็นสำคัญ',
            'show_work' => 'ข้อมูลนำเสนอ',
            'create_date' => 'Create Date',
            'filename' => 'Filename',
            'path' => 'Path',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgenda()
    {
        return $this->hasOne(AgendaItem::className(), ['agenda_id' => 'agenda_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMeeting()
    {
        return $this->hasOne(MeetingAgenda::className(), ['id' => 'meeting_id']);
    }
    public function upload()
    {
        if ($this->validate()) {
            $filePath = 'uploads/agenda/' . $this->file->baseName . '.' . $this->file->extension;
            if ($this->file->saveAs($filePath)) {
                $this->file_name = $this->file->name;
                $this->file_size = $this->file->size;
                $this->created_at = time();
                return $this->save(false);
            }
        }
        return false;
    }
    public function getFilename()
    {
        return pathinfo($this->path, PATHINFO_BASENAME);
    }
}
