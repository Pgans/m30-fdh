<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%chronicfu}}".
 *
 * @property string $hospcode
 * @property string $pid
 * @property string $seq
 * @property string $date_serv
 * @property string $weight
 * @property string $height
 * @property string $waist_cm
 * @property string $sbp
 * @property string $dbp
 * @property string $foot
 * @property string $retina
 * @property string $provider
 * @property string $d_update
 * @property string $chronicfuplace
 * @property string $cid
 */
class Chronicfu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%chronicfu}}';
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
            [['hospcode', 'pid', 'seq', 'date_serv', 'weight', 'height', 'waist_cm', 'sbp', 'dbp', 'foot', 'retina', 'provider', 'd_update'], 'string', 'max' => 255],
            [['chronicfuplace'], 'string', 'max' => 6],
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
            'weight' => 'Weight',
            'height' => 'Height',
            'waist_cm' => 'Waist Cm',
            'sbp' => 'Sbp',
            'dbp' => 'Dbp',
            'foot' => 'Foot',
            'retina' => 'Retina',
            'provider' => 'Provider',
            'd_update' => 'D Update',
            'chronicfuplace' => 'Chronicfuplace',
            'cid' => 'Cid',
        ];
    }
}
