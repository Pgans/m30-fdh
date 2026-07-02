<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%ita66}}".
 *
 * @property int $id
 * @property string $ref หลายเลข referent สำหรับอัพโหลดไฟล์ ajax
 * @property string $title ชื่องาน
 * @property string $covenant หนังสือสัญญา
 * @property string $docs
 * @property string $create_date สร้างวันที่
 * @property string $fiscal ปีงบ
 * @property int $view ผู้เข้าชม
 */
class Ita66 extends \yii\db\ActiveRecord
{
    const UPLOAD_FOLDER = 'uploads/agenda/';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ita66}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string'],
            [['create_date'], 'safe'],
            [['view'], 'integer'],
            [['ref'], 'string', 'max' => 50],
            [['covenant', 'docs'], 'string', 'max' => 255],
            [['fiscal'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ref' => 'Ref',
            'title' => 'Title',
            'covenant' => 'Covenant',
            'docs' => 'Docs',
            'create_date' => 'Create Date',
            'fiscal' => 'Fiscal',
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
                       $docs_file .= '<li>'.Html::a($value,['/ita66/download','id'=>$this->id,'file'=>$key,'file_name'=>$value]).'</li>';
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
                            'url'    => Url::to(['/ita66/deletefile','id'=>$this->id,'fileName'=>$key,'field'=>$field]),
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



