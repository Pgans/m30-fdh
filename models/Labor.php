<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%labor}}".
 *
 * @property string $hospcode
 * @property string $pid
 * @property string $gravida
 * @property string $lmp
 * @property string $edc
 * @property string $bdate
 * @property string $bresult
 * @property string $bplace
 * @property string $bhosp
 * @property string $btype
 * @property string $bdoctor
 * @property string $lborn
 * @property string $sborn
 * @property string $d_update
 * @property string $cid
 */
class Labor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%labor}}';
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
            [['hospcode', 'pid', 'gravida', 'lmp', 'edc', 'bdate', 'bresult', 'bplace', 'bhosp', 'btype', 'bdoctor', 'lborn', 'sborn', 'd_update'], 'string', 'max' => 255],
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
            'bdate' => 'Bdate',
            'bresult' => 'Bresult',
            'bplace' => 'Bplace',
            'bhosp' => 'Bhosp',
            'btype' => 'Btype',
            'bdoctor' => 'Bdoctor',
            'lborn' => 'Lborn',
            'sborn' => 'Sborn',
            'd_update' => 'D Update',
            'cid' => 'Cid',
        ];
    }
}
