<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%agenda}}".
 *
 * @property int $agenda_id
 * @property int $meeting_id ผู้เข้าชม
 * @property string $ref หลายเลข referent สำหรับอัพโหลดไฟล์ ajax
 * @property string $topic วาระการประชุม
 * @property string $discription เนื้อหาการประชุม
 * @property string $covenant
 * @property string $docs
 * @property string $create_date สร้างวันที่
 * @property int $view เข้าชม
 */
class Agenda extends \yii\db\ActiveRecord
{
    const UPLOAD_FOLDER = 'agenda';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%agenda}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['meeting_id', 'view'], 'integer'],
            [['discription'], 'string'],
            [['create_date'], 'safe'],
            [['ref'], 'string', 'max' => 50],
            [['covenant'],'file','maxFiles'=>1],
            [['topic', 'docs'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'agenda_id' => 'Agenda ID',
            'meeting_id' => 'Meeting ID',
            'ref' => 'Ref',
            'topic' => 'Topic',
            'discription' => 'Discription',
            'covenant' => 'ไฟล์',
            'docs' => 'Docs',
            'create_date' => 'Create Date',
            'view' => 'View',
        ];
    }
   
    public static function getUploadPath(){
        return Yii::getAlias('@webroot').'/'.self::UPLOAD_FOLDER.'/';
    }

    public static function getUploadUrl(){
        return Url::base(true).'/'.self::UPLOAD_FOLDER.'/';
    }

    public function listDownloadFiles($type){
		
        $docs_file = '';
        if(in_array($type, ['covenant'])){
                $data = $type==='docs'?$this->docs:$this->covenant;
                $files = Json::decode($data);
               if(is_array($files)){
                    $docs_file ='<ul>';
                    foreach ($files as $key => $value) {
                       $docs_file .= '<li>'.Html::a($value,['/agenda/download','id'=>$this->agenda_id,'file'=>$key,'file_name'=>$value]).'</li>';
                    }
                    $docs_file .='</ul>';
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
                            'url'    => Url::to(['/agenda/deletefile','id'=>$this->agenda_id,'fileName'=>$key,'field'=>$field]),
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
    public function getMeetings()
    {
        return $this->hasMany(Meeting::className(), ['meeting_id' => 'meeting_id']);
    }
    public function getMeet()
    {
        return $this->hasOne(Meeting::className(), ['meeting_id' => 'meeting_id']);
    }
}

