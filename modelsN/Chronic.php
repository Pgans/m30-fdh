<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%chronic}}".
 *
 * @property string $hospcode
 * @property string $pid
 * @property string $date_diag
 * @property string $chronic
 * @property string $hosp_dx
 * @property string $hosp_rx
 * @property string $date_disch
 * @property string $typedisch
 * @property string $d_update
 * @property string $cid
 */
class Chronic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%chronic}}';
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
            [['hospcode', 'pid', 'date_diag', 'chronic', 'hosp_dx', 'hosp_rx', 'date_disch', 'typedisch', 'd_update', 'cid'], 'string', 'max' => 255],
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
            'date_diag' => 'Date Diag',
            'chronic' => 'Chronic',
            'hosp_dx' => 'Hosp Dx',
            'hosp_rx' => 'Hosp Rx',
            'date_disch' => 'Date Disch',
            'typedisch' => 'Typedisch',
            'd_update' => 'D Update',
            'cid' => 'Cid',
        ];
    }
}
