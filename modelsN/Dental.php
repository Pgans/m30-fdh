<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%dental}}".
 *
 * @property string $hospcode
 * @property string $pid
 * @property string $seq
 * @property string $date_serv
 * @property string $denttype
 * @property string $servplace
 * @property string $pteeth
 * @property string $pcaries
 * @property string $pfilling
 * @property string $pextract
 * @property string $dteeth
 * @property string $dcaries
 * @property string $dfilling
 * @property string $dextract
 * @property string $need_fluoride
 * @property string $need_scaling
 * @property string $need_sealant
 * @property string $need_pfilling
 * @property string $need_dfilling
 * @property string $need_pextract
 * @property string $need_dextract
 * @property string $nprosthesis
 * @property string $permanent_permanent
 * @property string $permanent_prosthesis
 * @property string $prosthesis_prosthesis
 * @property string $gum
 * @property string $schooltype
 * @property string $class
 * @property string $provider
 * @property string $d_update
 * @property string $cid
 */
class Dental extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%dental}}';
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
            [['hospcode', 'pid', 'seq', 'date_serv', 'denttype', 'servplace', 'pteeth', 'pcaries', 'pfilling', 'pextract', 'dteeth', 'dcaries', 'dfilling', 'dextract', 'need_fluoride', 'need_scaling', 'need_sealant', 'need_pfilling', 'need_dfilling', 'need_pextract', 'need_dextract', 'nprosthesis', 'permanent_permanent', 'permanent_prosthesis', 'prosthesis_prosthesis', 'gum', 'schooltype', 'class', 'provider', 'd_update'], 'string', 'max' => 255],
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
            'denttype' => 'Denttype',
            'servplace' => 'Servplace',
            'pteeth' => 'Pteeth',
            'pcaries' => 'Pcaries',
            'pfilling' => 'Pfilling',
            'pextract' => 'Pextract',
            'dteeth' => 'Dteeth',
            'dcaries' => 'Dcaries',
            'dfilling' => 'Dfilling',
            'dextract' => 'Dextract',
            'need_fluoride' => 'Need Fluoride',
            'need_scaling' => 'Need Scaling',
            'need_sealant' => 'Need Sealant',
            'need_pfilling' => 'Need Pfilling',
            'need_dfilling' => 'Need Dfilling',
            'need_pextract' => 'Need Pextract',
            'need_dextract' => 'Need Dextract',
            'nprosthesis' => 'Nprosthesis',
            'permanent_permanent' => 'Permanent Permanent',
            'permanent_prosthesis' => 'Permanent Prosthesis',
            'prosthesis_prosthesis' => 'Prosthesis Prosthesis',
            'gum' => 'Gum',
            'schooltype' => 'Schooltype',
            'class' => 'Class',
            'provider' => 'Provider',
            'd_update' => 'D Update',
            'cid' => 'Cid',
        ];
    }
}
