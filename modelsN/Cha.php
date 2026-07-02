<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%cha}}".
 *
 * @property string $hn
 * @property string $an
 * @property string $date
 * @property string $chrgitem
 * @property string $amount
 * @property string $person_id
 * @property string $seq
 */
class Cha extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cha}}';
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
            [['hn', 'an', 'date', 'chrgitem', 'amount', 'person_id', 'seq'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hn' => 'Hn',
            'an' => 'An',
            'date' => 'Date',
            'chrgitem' => 'Chrgitem',
            'amount' => 'Amount',
            'person_id' => 'Person ID',
            'seq' => 'Seq',
        ];
    }
}
