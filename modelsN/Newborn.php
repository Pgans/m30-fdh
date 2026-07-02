<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%newborn}}".
 *
 * @property string $hospcode
 * @property string $pid
 * @property string $mpid
 * @property string $gravida
 * @property string $ga
 * @property string $bdate
 * @property string $btime
 * @property string $bplace
 * @property string $bhosp
 * @property string $birthno
 * @property string $btype
 * @property string $bdoctor
 * @property string $bweight
 * @property string $asphyxia
 * @property string $vitk
 * @property string $tsh
 * @property string $tshresult
 * @property string $d_update
 * @property string $cid
 */
class Newborn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%newborn}}';
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
            [['hospcode', 'pid', 'mpid', 'gravida', 'ga', 'bdate', 'btime', 'bplace', 'bhosp', 'birthno', 'btype', 'bdoctor', 'bweight', 'asphyxia', 'vitk', 'tsh', 'tshresult', 'd_update'], 'string', 'max' => 255],
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
            'mpid' => 'Mpid',
            'gravida' => 'Gravida',
            'ga' => 'Ga',
            'bdate' => 'Bdate',
            'btime' => 'Btime',
            'bplace' => 'Bplace',
            'bhosp' => 'Bhosp',
            'birthno' => 'Birthno',
            'btype' => 'Btype',
            'bdoctor' => 'Bdoctor',
            'bweight' => 'Bweight',
            'asphyxia' => 'Asphyxia',
            'vitk' => 'Vitk',
            'tsh' => 'Tsh',
            'tshresult' => 'Tshresult',
            'd_update' => 'D Update',
            'cid' => 'Cid',
        ];
    }
}
