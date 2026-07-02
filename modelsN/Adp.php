<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%adp}}".
 *
 * @property string $hn
 * @property string $an
 * @property string $dateopd
 * @property string $type
 * @property string $code
 * @property string $qty
 * @property string $rate
 * @property string $seq
 * @property string $cagcode
 * @property string $dose
 * @property string $ca_type
 * @property string $serialno
 * @property string $totcopay
 * @property string $use_status
 * @property string $total
 * @property string $qtyday
 * @property string $tmltcode
 * @property string $status1
 * @property string $bi
 * @property string $clinic
 * @property string $itemsrc
 * @property string $provider
 * @property string $gravida
 * @property string $gaweek
 * @property string $dcip_e_screen
 * @property string $lmp
 */
class Adp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%adp}}';
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
            [['hn', 'an', 'type', 'code', 'qty', 'rate', 'seq', 'cagcode', 'dose', 'ca_type', 'serialno', 'totcopay', 'use_status', 'total', 'qtyday'], 'string', 'max' => 255],
            [['dateopd'], 'string', 'max' => 8255],
            [['tmltcode', 'status1', 'bi', 'clinic', 'itemsrc', 'provider', 'gravida', 'gaweek', 'dcip_e_screen', 'lmp'], 'string', 'max' => 200],
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
            'dateopd' => 'Dateopd',
            'type' => 'Type',
            'code' => 'Code',
            'qty' => 'Qty',
            'rate' => 'Rate',
            'seq' => 'Seq',
            'cagcode' => 'Cagcode',
            'dose' => 'Dose',
            'ca_type' => 'Ca Type',
            'serialno' => 'Serialno',
            'totcopay' => 'Totcopay',
            'use_status' => 'Use Status',
            'total' => 'Total',
            'qtyday' => 'Qtyday',
            'tmltcode' => 'Tmltcode',
            'status1' => 'Status1',
            'bi' => 'Bi',
            'clinic' => 'Clinic',
            'itemsrc' => 'Itemsrc',
            'provider' => 'Provider',
            'gravida' => 'Gravida',
            'gaweek' => 'Gaweek',
            'dcip_e_screen' => 'Dcip E Screen',
            'lmp' => 'Lmp',
        ];
    }
}
