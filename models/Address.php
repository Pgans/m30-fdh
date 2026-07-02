<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%address}}".
 *
 * @property string $hospcode
 * @property string $pid
 * @property string $addresstype
 * @property string $house_id
 * @property string $housetype
 * @property string $roomno
 * @property string $condo
 * @property string $houseno
 * @property string $soisub
 * @property string $soimain
 * @property string $road
 * @property string $villaname
 * @property string $village
 * @property string $tambon
 * @property string $ampur
 * @property string $changwat
 * @property string $d_update
 * @property string $cid
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%address}}';
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
            [['hospcode', 'pid', 'addresstype', 'house_id', 'housetype', 'roomno', 'condo', 'houseno', 'soisub', 'soimain', 'road', 'villaname', 'village', 'tambon', 'ampur', 'changwat', 'd_update'], 'string', 'max' => 255],
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
            'addresstype' => 'Addresstype',
            'house_id' => 'House ID',
            'housetype' => 'Housetype',
            'roomno' => 'Roomno',
            'condo' => 'Condo',
            'houseno' => 'Houseno',
            'soisub' => 'Soisub',
            'soimain' => 'Soimain',
            'road' => 'Road',
            'villaname' => 'Villaname',
            'village' => 'Village',
            'tambon' => 'Tambon',
            'ampur' => 'Ampur',
            'changwat' => 'Changwat',
            'd_update' => 'D Update',
            'cid' => 'Cid',
        ];
    }
}
