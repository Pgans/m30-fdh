<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%charge_opd}}".
 *
 * @property string $hospcode
 * @property string $pid
 * @property string $seq
 * @property string $date_serv
 * @property string $clinic
 * @property string $chargeitem
 * @property string $chargelist
 * @property string $quantity
 * @property string $instype
 * @property string $cost
 * @property string $price
 * @property string $payprice
 * @property string $d_update
 * @property string $cid
 */
class Chargeopd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%charge_opd}}';
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
            [['hospcode', 'pid', 'seq', 'date_serv', 'clinic', 'chargeitem', 'chargelist', 'quantity', 'instype', 'cost', 'price', 'payprice', 'd_update'], 'string', 'max' => 255],
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
            'date_serv' => 'Date Serv',
            'clinic' => 'Clinic',
            'chargeitem' => 'Chargeitem',
            'chargelist' => 'Chargelist',
            'quantity' => 'Quantity',
            'instype' => 'Instype',
            'cost' => 'Cost',
            'price' => 'Price',
            'payprice' => 'Payprice',
            'd_update' => 'D Update',
            'cid' => 'Cid',
        ];
    }
}
