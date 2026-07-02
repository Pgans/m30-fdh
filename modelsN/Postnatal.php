<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%postnatal}}".
 *
 * @property string $hospcode
 * @property string $pid
 * @property string $seq
 * @property string $gravida
 * @property string $bdate
 * @property string $ppcare
 * @property string $ppplace
 * @property string $ppresult
 * @property string $provider
 * @property string $d_update
 * @property string $cid
 */
class Postnatal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%postnatal}}';
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
            [['hospcode', 'pid', 'seq', 'gravida', 'bdate', 'ppcare', 'ppplace', 'ppresult', 'provider', 'd_update'], 'string', 'max' => 255],
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
            'gravida' => 'Gravida',
            'bdate' => 'Bdate',
            'ppcare' => 'Ppcare',
            'ppplace' => 'Ppplace',
            'ppresult' => 'Ppresult',
            'provider' => 'Provider',
            'd_update' => 'D Update',
            'cid' => 'Cid',
        ];
    }
}
