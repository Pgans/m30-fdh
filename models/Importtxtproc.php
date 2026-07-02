<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class Importtxtproc extends Model
{
    /**
     * @var UploadedFile
     */
	
    public $file;
public $uploadFile;

public function rules()
{
    return [
        [['file'], 'file', 'extensions' => 'zip', 'checkExtensionByMimeType' => false],
        [['uploadFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'zip, txt'],
    ];
}

}
