<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%hosp_anamai}}".
 *
 * @property string $id รหัสรพ.สต
 * @property string $hospcode รหัสสถานพบาบาล
 * @property string $hospname ชื่อสถานพยาบาล
 */
class Hospanamai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hosp_anamai}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_host');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hospcode'], 'string', 'max' => 20],
            [['hospname'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hospcode' => 'Hospcode',
            'hospname' => 'Hospname',
        ];
    }
}
