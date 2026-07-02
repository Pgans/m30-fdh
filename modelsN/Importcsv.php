<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%import_csv}}".
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
 * @property string $d_update
 */
class Importcsv extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%import_csv}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rep', 'd_update'], 'required'],
            [['d_update'], 'safe'],
            [['rep', 'id', 'train_id', 'hn', 'an', 'pid', 'fullname', 'main', 'regdate', 'discharge', 'ins', 'pp', 'errorcode', 'sub'], 'string', 'max' => 255],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv', 'checkExtensionByMimeType' => false],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'auto_id' => 'Auto ID',
            'rep' => 'Rep',
            'id' => 'ID',
            'train_id' => 'Train ID',
            'hn' => 'Hn',
            'an' => 'An',
            'pid' => 'Pid',
            'fullname' => 'Fullname',
            'main' => 'Main',
            'regdate' => 'Regdate',
            'discharge' => 'Discharge',
            'ins' => 'Ins',
            'pp' => 'Pp',
            'errorcode' => 'Errorcode',
            'sub' => 'Sub',
            'd_update' => 'D Update',
        ];
    }
    public function upload()
{
    if ($this->validate()) {
        $filePath = 'uploads/csvfiles/' . $this->file->baseName . '.' . $this->file->extension;
        $this->file->saveAs($filePath);
        $this->importToDatabase($filePath);
        return true;
    }
    return false;
}

public function importToDatabase($filePath)
{
    $fileContents = file_get_contents($filePath);
    $lines = explode(PHP_EOL, $fileContents);

    foreach ($lines as $line) {
        // Process each line and insert into the database
        // Assuming you have a table called 'csv_data' with a single column 'content'
        Yii::$app->db->createCommand()->insert('csv_data', ['content' => $line])->execute();
    }

    // Delete the file after importing (optional)
    unlink($filePath);
}
}
