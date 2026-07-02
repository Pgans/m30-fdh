<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%ncdscreen}}".
 *
 * @property string $hospcode
 * @property string $pid
 * @property string $seq
 * @property string $date_serv
 * @property string $servplace
 * @property string $smoke
 * @property string $alcohol
 * @property string $dmfamily
 * @property string $htfamily
 * @property string $weight
 * @property string $height
 * @property string $waist_cm
 * @property string $sbp_1
 * @property string $dbp_1
 * @property string $sbp_2
 * @property string $dbp_2
 * @property string $bslevel
 * @property string $bstest
 * @property string $screenplace
 * @property string $provider
 * @property string $d_update
 * @property string $cid
 */
class Ncdscreen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ncdscreen}}';
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
            [['hospcode', 'pid', 'seq', 'date_serv', 'servplace', 'smoke', 'alcohol', 'dmfamily', 'htfamily', 'weight', 'height', 'waist_cm', 'sbp_1', 'dbp_1', 'sbp_2', 'dbp_2', 'bslevel', 'bstest', 'screenplace', 'provider', 'd_update'], 'string', 'max' => 255],
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
            'servplace' => 'Servplace',
            'smoke' => 'Smoke',
            'alcohol' => 'Alcohol',
            'dmfamily' => 'Dmfamily',
            'htfamily' => 'Htfamily',
            'weight' => 'Weight',
            'height' => 'Height',
            'waist_cm' => 'Waist Cm',
            'sbp_1' => 'Sbp 1',
            'dbp_1' => 'Dbp 1',
            'sbp_2' => 'Sbp 2',
            'dbp_2' => 'Dbp 2',
            'bslevel' => 'Bslevel',
            'bstest' => 'Bstest',
            'screenplace' => 'Screenplace',
            'provider' => 'Provider',
            'd_update' => 'D Update',
            'cid' => 'Cid',
        ];
    }
}
