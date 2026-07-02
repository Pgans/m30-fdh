<?php
// models/EdcImportForm.php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class EdcImportForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $csvFile;

    public function rules()
    {
        return [
            [['csvFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'],

        ];
    }
}
