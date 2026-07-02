<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;


/**
 * This is the model class for table "{{%key_points}}".
 *
 * @property int $key_id รหัส
 * @property int $agenda_id
 * @property string $key_point ประเด็นสำคัญ
 * @property string $show_work เสนอข้อมูล
 * @property string $create_date วันบันทึก
 * @property string $filename ชื่อไฟล์
 * @property string $link uploads
 *
 * @property AgendaItem $agenda
 */
class Keypoints extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%key_points}}';
    }
    public $upload_folder ='uploads/meetints/';
    public $file; 
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['agenda_id'], 'integer'],
            [['show_work'], 'string'],
            [['create_date'], 'safe'],
            [['key_point', 'filename', 'link'], 'string', 'max' => 255],
            [['file'], 'file', 'extensions' => 'pdf, doc, docx', 'maxSize' => 1024 * 1024 * 10], // Adjust file types and size as needed
            [['agenda_id'], 'exist', 'skipOnError' => true, 'targetClass' => AgendaItem::className(), 'targetAttribute' => ['agenda_id' => 'agenda_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'key_id' => 'Key ID',
            'agenda_id' => 'Agenda ID',
            'key_point' => 'Key Point',
            'show_work' => 'Show Work',
            'create_date' => 'Create Date',
            'filename' => 'Filename',
            'link' => 'Link',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgenda()
    {
        return $this->hasOne(AgendaItem::className(), ['agenda_id' => 'agenda_id']);
    }
    public function upload()
    {
        if ($this->validate()) {
            $this->file->saveAs('uploads/meetings' . $this->file->baseName . '.' . $this->file->extension);
            return true;
        } else {
            return false;
        }
    }
    public function getAgendaItem()
    {
        return $this->hasOne(AgendaItem::className(), ['id' => 'agenda_id']);
    }
}
