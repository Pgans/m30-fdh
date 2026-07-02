<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%dru}}".
 *
 * @property string $hcode
 * @property string $hn
 * @property string $an
 * @property string $clinic
 * @property string $person_id
 * @property string $date_serv
 * @property string $did
 * @property string $didname
 * @property string $amount
 * @property string $drugprice
 * @property string $drugcost
 * @property string $didstd
 * @property string $unit
 * @property string $unit_pack
 * @property string $seq
 * @property string $drugremark
 * @property string $pa_no
 * @property string $totcopay
 * @property string $use_status
 * @property string $total
 * @property string $sigcode
 * @property string $sigtext
 * @property string $provider
 */
class Dru extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%dru}}';
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
            [['hcode', 'clinic'], 'string', 'max' => 5],
            [['hn', 'an'], 'string', 'max' => 15],
            [['person_id', 'date_serv', 'did'], 'string', 'max' => 200],
            [['didname'], 'string', 'max' => 255],
            [['amount', 'drugprice', 'drugcost', 'didstd', 'unit', 'unit_pack', 'seq', 'drugremark', 'pa_no', 'totcopay', 'use_status', 'total', 'sigcode', 'sigtext', 'provider'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hcode' => 'Hcode',
            'hn' => 'Hn',
            'an' => 'An',
            'clinic' => 'Clinic',
            'person_id' => 'Person ID',
            'date_serv' => 'Date Serv',
            'did' => 'Did',
            'didname' => 'Didname',
            'amount' => 'Amount',
            'drugprice' => 'Drugprice',
            'drugcost' => 'Drugcost',
            'didstd' => 'Didstd',
            'unit' => 'Unit',
            'unit_pack' => 'Unit Pack',
            'seq' => 'Seq',
            'drugremark' => 'Drugremark',
            'pa_no' => 'Pa No',
            'totcopay' => 'Totcopay',
            'use_status' => 'Use Status',
            'total' => 'Total',
            'sigcode' => 'Sigcode',
            'sigtext' => 'Sigtext',
            'provider' => 'Provider',
        ];
    }
}
