<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%prenatal}}".
 *
 * @property string $hospcode
 * @property string $pid
 * @property string $gravida
 * @property string $lmp
 * @property string $edc
 * @property string $vdrl_result
 * @property string $hb_result
 * @property string $hiv_result
 * @property string $date_hct
 * @property string $hct_result
 * @property string $thalassemia
 * @property string $d_update
 * @property string $provider
 * @property string $cid
 */
class Prenatal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%prenatal}}';
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
            [['hospcode', 'pid', 'gravida', 'lmp', 'edc', 'vdrl_result', 'hb_result', 'hiv_result', 'date_hct', 'hct_result', 'thalassemia', 'd_update'], 'string', 'max' => 255],
            [['provider'], 'string', 'max' => 15],
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
            'gravida' => 'Gravida',
            'lmp' => 'Lmp',
            'edc' => 'Edc',
            'vdrl_result' => 'Vdrl Result',
            'hb_result' => 'Hb Result',
            'hiv_result' => 'Hiv Result',
            'date_hct' => 'Date Hct',
            'hct_result' => 'Hct Result',
            'thalassemia' => 'Thalassemia',
            'd_update' => 'D Update',
            'provider' => 'Provider',
            'cid' => 'Cid',
        ];
    }
}
