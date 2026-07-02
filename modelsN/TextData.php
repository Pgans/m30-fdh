<?php

namespace app\models;

use yii\db\ActiveRecord;

class TextData extends ActiveRecord
{
    public static function import_txt()
    {
        return 'text_data';
    }

    // Additional model logic and validations...
}
