<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%home}}".
 *
 * @property string $hospcode
 * @property string $hid
 * @property string $house_id
 * @property string $housetype
 * @property string $roomno
 * @property string $condo
 * @property string $house
 * @property string $soisub
 * @property string $soimain
 * @property string $road
 * @property string $villaname
 * @property string $village
 * @property string $tambon
 * @property string $ampur
 * @property string $changwat
 * @property string $telephone
 * @property string $latitude
 * @property string $longitude
 * @property string $nfamily
 * @property string $locatype
 * @property string $vhvid
 * @property string $headid
 * @property string $toilet
 * @property string $water
 * @property string $watertype
 * @property string $garbage
 * @property string $housing
 * @property string $durability
 * @property string $cleanliness
 * @property string $ventilation
 * @property string $light
 * @property string $watertm
 * @property string $mfood
 * @property string $bcontrol
 * @property string $acontrol
 * @property string $chemical
 * @property string $outdate
 * @property string $d_update
 */
class Home extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%home}}';
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
            [['hospcode', 'hid', 'house_id', 'housetype', 'roomno', 'condo', 'house', 'soisub', 'soimain', 'road', 'villaname', 'village', 'tambon', 'ampur', 'changwat', 'telephone', 'latitude', 'longitude', 'nfamily', 'locatype', 'vhvid', 'headid', 'toilet', 'water', 'watertype', 'garbage', 'housing', 'durability', 'cleanliness', 'ventilation', 'light', 'watertm', 'mfood', 'bcontrol', 'acontrol', 'chemical', 'outdate', 'd_update'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hospcode' => 'Hospcode',
            'hid' => 'Hid',
            'house_id' => 'House ID',
            'housetype' => 'Housetype',
            'roomno' => 'Roomno',
            'condo' => 'Condo',
            'house' => 'House',
            'soisub' => 'Soisub',
            'soimain' => 'Soimain',
            'road' => 'Road',
            'villaname' => 'Villaname',
            'village' => 'Village',
            'tambon' => 'Tambon',
            'ampur' => 'Ampur',
            'changwat' => 'Changwat',
            'telephone' => 'Telephone',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'nfamily' => 'Nfamily',
            'locatype' => 'Locatype',
            'vhvid' => 'Vhvid',
            'headid' => 'Headid',
            'toilet' => 'Toilet',
            'water' => 'Water',
            'watertype' => 'Watertype',
            'garbage' => 'Garbage',
            'housing' => 'Housing',
            'durability' => 'Durability',
            'cleanliness' => 'Cleanliness',
            'ventilation' => 'Ventilation',
            'light' => 'Light',
            'watertm' => 'Watertm',
            'mfood' => 'Mfood',
            'bcontrol' => 'Bcontrol',
            'acontrol' => 'Acontrol',
            'chemical' => 'Chemical',
            'outdate' => 'Outdate',
            'd_update' => 'D Update',
        ];
    }
}
