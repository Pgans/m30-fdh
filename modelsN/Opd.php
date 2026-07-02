<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%opd}}".
 *
 * @property string $hn
 * @property string $clinic
 * @property string $dateopd
 * @property string $timeopd
 * @property string $seq
 * @property string $uuc
 * @property string $detail
 * @property string $btemp
 * @property string $sbp
 * @property string $dbp
 * @property string $pr
 * @property string $rr
 * @property string $optype
 * @property string $typein
 * @property string $typeout
 */
class Opd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%opd}}';
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
            [['hn', 'clinic', 'dateopd', 'timeopd', 'seq', 'uuc', 'detail', 'btemp', 'sbp', 'dbp', 'pr', 'rr', 'optype', 'typein', 'typeout'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hn' => 'Hn',
            'clinic' => 'Clinic',
            'dateopd' => 'Dateopd',
            'timeopd' => 'Timeopd',
            'seq' => 'Seq',
            'uuc' => 'Uuc',
            'detail' => 'Detail',
            'btemp' => 'Btemp',
            'sbp' => 'Sbp',
            'dbp' => 'Dbp',
            'pr' => 'Pr',
            'rr' => 'Rr',
            'optype' => 'Optype',
            'typein' => 'Typein',
            'typeout' => 'Typeout',
        ];
    }
}
