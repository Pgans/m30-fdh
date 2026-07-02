<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%pat}}".
 *
 * @property string $hcode
 * @property string $hn
 * @property string $changwat
 * @property string $amphur
 * @property string $dob
 * @property string $sex
 * @property string $marriage
 * @property string $occupa
 * @property string $nation
 * @property string $person_id
 * @property string $namepat
 * @property string $title
 * @property string $fname
 * @property string $lname
 * @property string $idtype
 */
class Pat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pat}}';
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
            [['hcode', 'hn', 'changwat', 'amphur', 'dob', 'sex', 'marriage', 'occupa', 'person_id', 'namepat', 'title', 'fname', 'lname', 'idtype'], 'string', 'max' => 255],
            [['nation'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hcode' => 'Hcode',
            'hn' => 'Hn',
            'changwat' => 'Changwat',
            'amphur' => 'Amphur',
            'dob' => 'Dob',
            'sex' => 'Sex',
            'marriage' => 'Marriage',
            'occupa' => 'Occupa',
            'nation' => 'Nation',
            'person_id' => 'Person ID',
            'namepat' => 'Namepat',
            'title' => 'Title',
            'fname' => 'Fname',
            'lname' => 'Lname',
            'idtype' => 'Idtype',
        ];
    }
}
