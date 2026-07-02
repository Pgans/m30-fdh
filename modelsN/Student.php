<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%student}}".
 *
 * @property string $hospcode
 * @property string $pid
 * @property string $schoolcode
 * @property string $educationyear
 * @property string $class
 * @property string $grudate_date
 * @property string $d_update
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%student}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db943');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hospcode'], 'string', 'max' => 7],
            [['pid', 'schoolcode', 'educationyear', 'class', 'grudate_date', 'd_update'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hospcode' => 'Hospcode',
            'pid' => 'Pid',
            'schoolcode' => 'Schoolcode',
            'educationyear' => 'Educationyear',
            'class' => 'Class',
            'grudate_date' => 'Grudate Date',
            'd_update' => 'D Update',
        ];
    }
}
