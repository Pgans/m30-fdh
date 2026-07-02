<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%newborncare}}".
 *
 * @property string $hospcode
 * @property string $pid
 * @property string $seq
 * @property string $bdate
 * @property string $bcare
 * @property string $bcplace
 * @property string $bcareresult
 * @property string $food
 * @property string $provider
 * @property string $d_update
 * @property string $cid
 */
class Newborncare extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%newborncare}}';
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
            [['hospcode', 'pid', 'seq', 'bdate', 'bcare', 'bcplace', 'bcareresult', 'food', 'provider', 'd_update'], 'string', 'max' => 255],
            [['cid'], 'string', 'max' => 13],
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
            'seq' => 'Seq',
            'bdate' => 'Bdate',
            'bcare' => 'Bcare',
            'bcplace' => 'Bcplace',
            'bcareresult' => 'Bcareresult',
            'food' => 'Food',
            'provider' => 'Provider',
            'd_update' => 'D Update',
            'cid' => 'Cid',
        ];
    }
}
