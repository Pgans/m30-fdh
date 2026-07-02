<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%diagnosis_opd}}".
 *
 * @property string $hospcode
 * @property string $pid
 * @property string $seq
 * @property string $date_serv
 * @property string $diagtype
 * @property string $diagcode
 * @property string $clinic
 * @property string $provider
 * @property string $d_update
 * @property string $cid
 */
class Diagnosisopd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diagnosis_opd}}';
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
            [['hospcode', 'pid', 'seq', 'date_serv', 'diagtype', 'diagcode', 'clinic', 'provider', 'd_update'], 'string', 'max' => 255],
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
            'diagtype' => 'Diagtype',
            'diagcode' => 'Diagcode',
            'clinic' => 'Clinic',
            'provider' => 'Provider',
            'd_update' => 'D Update',
            'cid' => 'Cid',
        ];
    }
}
