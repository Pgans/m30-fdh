<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%upload_file}}".
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
class Uploadfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%upload_file}}';
    }
    public $file;
    //public $agenda_id;
    //public $key_point;
   // public $show_work;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['agenda_id'], 'integer'],
            [['show_work'], 'string'],
            [['create_date'], 'safe'],
            [['key_point', 'filename', 'path'], 'string', 'max' => 255],
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

    public function upload()
    {
        if ($this->validate()) {
            $path = 'uploads/meetings/' . uniqid() . '.' . $this->file->extension;
            if ($this->file->saveAs($path)) {
                $this->create_date = date('Y-m-d H:i:s');
                $this->filename = $this->file->name;
                $this->path = $path;
                return $this->save(false);
            }
        }
        return false;
    }

}
