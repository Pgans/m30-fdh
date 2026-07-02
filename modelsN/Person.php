<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%person}}".
 *
 * @property string $hospcode
 * @property string $cid
 * @property string $pid
 * @property string $hid
 * @property string $prename
 * @property string $name
 * @property string $lname
 * @property string $hn
 * @property string $sex
 * @property string $birth
 * @property string $mstatus
 * @property string $occupation_old
 * @property string $occupation_new
 * @property string $race
 * @property string $nation
 * @property string $religion
 * @property string $education
 * @property string $fstatus
 * @property string $father
 * @property string $mother
 * @property string $couple
 * @property string $vstatus
 * @property string $movein
 * @property string $discharge
 * @property string $ddischarge
 * @property string $abogroup
 * @property string $rhgroup
 * @property string $labor
 * @property string $passport
 * @property string $typearea
 * @property string $d_update
 * @property string $telephone
 * @property string $mobile
 */
class Person extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%person}}';
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
            [['hospcode', 'cid', 'pid', 'hid', 'prename', 'name', 'lname', 'hn', 'sex', 'birth', 'mstatus', 'occupation_old', 'occupation_new', 'race', 'nation', 'religion', 'education', 'fstatus', 'father', 'mother', 'couple', 'vstatus', 'movein', 'discharge', 'ddischarge', 'abogroup', 'rhgroup', 'labor', 'passport', 'typearea', 'd_update'], 'string', 'max' => 255],
            [['telephone', 'mobile'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hospcode' => 'Hospcode',
            'cid' => 'Cid',
            'pid' => 'Pid',
            'hid' => 'Hid',
            'prename' => 'Prename',
            'name' => 'Name',
            'lname' => 'Lname',
            'hn' => 'Hn',
            'sex' => 'Sex',
            'birth' => 'Birth',
            'mstatus' => 'Mstatus',
            'occupation_old' => 'Occupation Old',
            'occupation_new' => 'Occupation New',
            'race' => 'Race',
            'nation' => 'Nation',
            'religion' => 'Religion',
            'education' => 'Education',
            'fstatus' => 'Fstatus',
            'father' => 'Father',
            'mother' => 'Mother',
            'couple' => 'Couple',
            'vstatus' => 'Vstatus',
            'movein' => 'Movein',
            'discharge' => 'Discharge',
            'ddischarge' => 'Ddischarge',
            'abogroup' => 'Abogroup',
            'rhgroup' => 'Rhgroup',
            'labor' => 'Labor',
            'passport' => 'Passport',
            'typearea' => 'Typearea',
            'd_update' => 'D Update',
            'telephone' => 'Telephone',
            'mobile' => 'Mobile',
        ];
    }
}
