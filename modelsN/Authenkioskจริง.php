<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "authen_kiosk".
 *
 * @property int $id
 * @property string $hospcode เลขrep
 * @property string $cid
 * @property string $visit_id
 * @property string $mobile
 * @property string $claimcode
 * @property string $claimtype
 * @property string $dep_name ชื่อสกุล
 * @property string $authen_date กองทุน
 * @property string $d_update วันที่รับรักษา
 */
class Authenkiosk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'authen_kiosk';
    }
    //public $uploadPath = 'uploads/file';
	public $file;
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cid', 'visit_id', 'claimtype', 'd_update'], 'required'],
            [['d_update'], 'safe'],
            [['cid'], 'string', 'max' => 13],
            [['visit_id', 'mobile'], 'string', 'max' => 10],
            [['claimtype', 'claimcode'], 'string', 'max' => 20],
            [['dep_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            //'hospcode' => 'Hospcode',
            'cid' => 'Cid',
            'visit_id' => 'Visit ID',
            'mobile' => 'Mobile',
            'claimcode' => 'Claimcode',
            'claimtype' => 'Claimtype',
            'dep_name' => 'Dep Name',
           // 'authen_date' => 'Authen Date',
            'd_update' => 'D Update',
        ];
    }
    public function uploadFile($model, $attribute)
    {
        $file = UploadedFile::getInstance($model, $attribute);

        if($file){
            if($this->isNewRecord){
                $fileName = time().'_'.$file->baseName.'.'.$file->extension;
            }else{
                $fileName = $this->getOldAttribute($attribute);
            }
            $file->saveAs(Yii::getAlias('@webroot').'/'.$this->uploadPath.'/'.$fileName);

            return $fileName;
        }
        return $this->isNewRecord ? false : $this->getOldAttribute($attribute);
    }
}
