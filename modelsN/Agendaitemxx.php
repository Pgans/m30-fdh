<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
/**
 * This is the model class for table "{{%agenda_item}}".
 *
 * @property int $agenda_id
 * @property int $meeting_agenda_id ผู้เข้าชม
 * @property string $ref หลายเลข referent สำหรับอัพโหลดไฟล์ ajax
 * @property string $topic วาระการประชุม
 * @property string $discription เนื้อหาการประชุม
 * @property string $covenant
 * @property string $docs
 * @property string $create_date สร้างวันที่
 * @property int $view เข้าชม
 *
 * @property MeetingAgenda $meetingAgenda
 */
class Agendaitem extends \yii\db\ActiveRecord
{
    const UPLOAD_FOLDER = 'uploads/agenda/';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%agenda_item}}';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['meeting_agenda_id', 'view'], 'integer'],
            [['discription'], 'string'],
            [['create_date'], 'safe'],
            [['ref'], 'string', 'max' => 50],
            [['topic', 'covenant', 'docs'], 'string', 'max' => 255],
            [['meeting_agenda_id'], 'exist', 'skipOnError' => true, 'targetClass' => MeetingAgenda::className(), 'targetAttribute' => ['meeting_agenda_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'agenda_id' => 'Agenda ID',
            'meeting_agenda_id' => 'Meeting Agenda ID',
            'ref' => 'Ref',
            'topic' => 'Topic',
            'discription' => 'Discription',
            'covenant' => 'Covenant',
            'docs' => 'Docs',
            'create_date' => 'Create Date',
            'view' => 'View',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMeetingAgenda()
    {
        return $this->hasOne(MeetingAgenda::className(), ['id' => 'meeting_agenda_id']);
    }
    public static function getUploadPath(){
        return Yii::getAlias('@webroot').'/'.self::UPLOAD_FOLDER.'/';
    }

    public static function getUploadUrl(){
        return Url::base(true).'/'.self::UPLOAD_FOLDER.'/';
    }

    public function listDownloadFiles($type){
     $docs_file = 'No file!';
     if(in_array($type, ['docs','covenant'])){
             $data = $type==='docs'?$this->docs:$this->covenant;
             $files = Json::decode($data);
            if(is_array($files)){
                 $docs_file ='<ol>';
                 foreach ($files as $key => $value) {
                    $docs_file .= '<li>'.Html::a($value,['/agendaitem/download','id'=>$this->id,'file'=>$key,'file_name'=>$value]).'</li>';
                 }
                 $docs_file .='</ol>';
            }
     }

     return $docs_file;
    }

    public function initialPreview($data,$field,$type='file'){
            $initial = [];
            $files = Json::decode($data);
            if(is_array($files)){
                 foreach ($files as $key => $value) {
                    if($type=='file'){
                        $initial[] = "<div class='file-preview-other'><h2><i class='glyphicon glyphicon-file'></i></h2></div>";
                    }elseif($type=='config'){
                        $initial[] = [
                            'caption'=> $value,
                            'width'  => '120px',
                            'url'    => Url::to(['/agendaitem/deletefile','id'=>$this->id,'fileName'=>$key,'field'=>$field]),
                            'key'    => $key
                        ];
                    }
                    else{
                        $initial[] = Html::img(self::getUploadUrl().$this->ref.'/'.$value,['class'=>'file-preview-image', 'alt'=>$model->file_name, 'title'=>$model->file_name]);
                    }
                 }
         }
        return $initial;
    }
   
}
