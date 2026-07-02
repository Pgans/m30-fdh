<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%drugallergy}}".
 *
 * @property string $hospcode
 * @property string $pid
 * @property string $daterecord
 * @property string $drugallergy
 * @property string $dname
 * @property string $typedx
 * @property string $alevel
 * @property string $symptom
 * @property string $informant
 * @property string $informhosp
 * @property string $d_update
 * @property string $provider
 * @property string $cid
 */
class Drugallergy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%drugallergy}}';
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
            [['hospcode', 'pid', 'daterecord', 'drugallergy', 'dname', 'typedx', 'alevel', 'symptom', 'informant', 'informhosp', 'd_update', 'provider'], 'string', 'max' => 255],
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
            'daterecord' => 'Daterecord',
            'drugallergy' => 'Drugallergy',
            'dname' => 'Dname',
            'typedx' => 'Typedx',
            'alevel' => 'Alevel',
            'symptom' => 'Symptom',
            'informant' => 'Informant',
            'informhosp' => 'Informhosp',
            'd_update' => 'D Update',
            'provider' => 'Provider',
            'cid' => 'Cid',
        ];
    }
}
