<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%women}}".
 *
 * @property string $hospcode
 * @property string $pid
 * @property string $fptype
 * @property string $nofpcause
 * @property string $totalson
 * @property string $numberson
 * @property string $abortion
 * @property string $stillbirth
 * @property string $d_update
 * @property string $cid
 */
class Women extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%women}}';
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
            [['hospcode', 'pid', 'fptype', 'nofpcause', 'totalson', 'numberson', 'abortion', 'stillbirth', 'd_update'], 'string', 'max' => 255],
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
            'fptype' => 'Fptype',
            'nofpcause' => 'Nofpcause',
            'totalson' => 'Totalson',
            'numberson' => 'Numberson',
            'abortion' => 'Abortion',
            'stillbirth' => 'Stillbirth',
            'd_update' => 'D Update',
            'cid' => 'Cid',
        ];
    }
}
