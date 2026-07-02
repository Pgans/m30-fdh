<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%oop}}".
 *
 * @property string $hn
 * @property string $dateopd
 * @property string $clinic
 * @property string $oper
 * @property string $dropid
 * @property string $person_id
 * @property string $seq
 * @property string $servprice
 */
class Oop extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%oop}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db16');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hn'], 'string', 'max' => 15],
            [['dateopd', 'clinic', 'oper', 'dropid', 'person_id', 'seq', 'servprice'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hn' => 'Hn',
            'dateopd' => 'Dateopd',
            'clinic' => 'Clinic',
            'oper' => 'Oper',
            'dropid' => 'Dropid',
            'person_id' => 'Person ID',
            'seq' => 'Seq',
            'servprice' => 'Servprice',
        ];
    }
}
