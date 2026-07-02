<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%agenda_uploads}}".
 *
 * @property int $id
 * @property int $meeting_id
 * @property string $topic วาระประชุม
 * @property string $description เรื่อง
 * @property string $filename ชื่อไฟล์
 * @property string $path ที่อยู่ไฟล์
 * @property string $create_date วันบันทึก
 *
 * @property MeetingAgenda $meeting
 */
class Agendauploads extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%agenda_uploads}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['meeting_id'], 'integer'],
            [['description'], 'string'],
            [['create_date'], 'safe'],
            [['topic', 'filename', 'path'], 'string', 'max' => 255],
            [['meeting_id'], 'exist', 'skipOnError' => true, 'targetClass' => MeetingAgenda::className(), 'targetAttribute' => ['meeting_id' => 'id']],
           // [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => ['pdf', 'doc', 'docx', 'txt']],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'meeting_id' => 'Meeting ID',
            'topic' => 'Topic',
            'description' => 'Description',
            'filename' => 'Filename',
            'path' => 'Path',
            'create_date' => 'Create Date',
        ];
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
            // Create a directory to save the uploaded files
            $uploadPath = 'uploads/agenda/';
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Generate a unique filename and save the file
            $filename = uniqid() . '.' . $this->file->extension;
            $filePath = $uploadPath . $filename;
            if ($this->file->saveAs($filePath)) {
                // Set the "filename" and "path" attributes of the model
                $this->filename = $filename;
                $this->path = $filePath;

                // Save the model with the file information
                return $this->save(false);
            } else {
                // Error while saving the file
                return false;
            }
        } else {
            // Validation error
            return false;
        }
    }
}
