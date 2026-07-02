<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "import_palliative".
 *
 * @property int $auto_id
 * @property string $rep เลขrep
 * @property string $id
 * @property string $train_id
 * @property string $hn
 * @property string $an
 * @property string $pid
 * @property string $fullname ชื่อสกุล
 * @property string $main กองทุน
 * @property string $regdate วันที่รับรักษา
 * @property string $discharge วันจำหน่าย
 * @property string $ins ค่ารักษา
 * @property string $pp
 * @property string $errorcode
 * @property string $sub กองทุนย่อย
 */
class Importpalliative extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'import_palliative';
    }
    public static function getDb()
    {
        return Yii::$app->get('db14');
    }

    public $uploadPath = 'uploads/file/';
    public $file; 
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hospcode', 'date_serv', 'hn', 'cid', 'fullname', 'age', 'diag_primary', 'diag_comor', 'address', 'telephone', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'auto_id' => 'Auto ID',
            'hospcode' => 'Hospcode',
            'date_serv' => 'Date_serv',
            'hn' => 'Hn ID',
            'cid' => 'Cid',
            'fullname' => 'fullname',
            'age' => 'Age',
            'diag_primary' => 'Diag_Primary',
            'diag_comor' => 'Diag_comor',
            'address' => 'Address',
            'telephone' => 'Telephone',
            'status' => 'Status',
            'd_update' => 'D_update',
            
        ];
    }
    /*
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
    */
}


