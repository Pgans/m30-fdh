<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class Importtxt extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'txt'],
        ];
    }

    public function importToDatabase()
    {
        $filePath = 'uploads/txtfiles/' . $this->file->baseName . '.' . $this->file->extension;
        $this->file->saveAs($filePath);

        $file = fopen($filePath, "r");

        while (($line = fgets($file)) !== false) {
            // Process each line and insert into the database
            Yii::info("Importing line: " . $line);
    
            $textModel = new TextData();
            $textModel->content = $line;
    
            // Debugging statements
            var_dump($textModel->attributes); // Check the attributes being set
            var_dump($textModel->save()); // Check the save operation result
            var_dump($textModel->errors); // Check for any validation errors
            die(); // Stop execution to check the output
    
            $textModel->save();
        }
}
