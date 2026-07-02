
<?php
namespace app\models;

use yii\base\Model;

class Edc extends Model
{
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => 'csv'],
        ];
    }
}

