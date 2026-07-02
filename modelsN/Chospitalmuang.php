<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chospital_muang".
 *
 * @property string $hospcode
 * @property string $hospname
 */
class Chospitalmuang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chospital_muang';
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
            [['hospcode'], 'required'],
            [['hospcode'], 'string', 'max' => 5],
            [['hospname'], 'string', 'max' => 255],
            [['hospcode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hospcode' => 'Hospcode',
            'hospname' => 'Hospname',
        ];
    }
}
