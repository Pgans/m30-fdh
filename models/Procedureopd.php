<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%procedure_opd}}".
 *
 * @property string $hospcode
 * @property string $pid
 * @property string $seq
 * @property string $date_serv
 * @property string $clinic
 * @property string $procedcode
 * @property string $serviceprice
 * @property string $provider
 * @property string $d_update
 * @property string $cid
 */
class Procedureopd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%procedure_opd}}';
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
            [['hospcode', 'pid', 'seq', 'date_serv', 'clinic', 'procedcode', 'serviceprice', 'provider', 'd_update'], 'string', 'max' => 255],
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
            'procedcode' => 'Procedcode',
            'serviceprice' => 'Serviceprice',
            'provider' => 'Provider',
            'd_update' => 'D Update',
            'cid' => 'Cid',
        ];
    }
}
