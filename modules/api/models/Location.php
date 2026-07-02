<?php

namespace backend\modules\api\models;

use Yii;

/**
 * This is the model class for table "location".
 *
 * @property int $id
 * @property string $country
 * @property string $city
 * @property double $latitude
 * @property double $longitude
 * @property double $altitude
 */
class Location extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country', 'city', 'latitude', 'longitude', 'altitude'], 'required'],
            [['latitude', 'longitude', 'altitude'], 'number'],
            [['country'], 'string', 'max' => 25],
            [['city'], 'string', 'max' => 40],
        ];
    }

    public function scenarios(){
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['id','country','city','latitude','longitude','altitude']; //ต้องเหมือนใน database
        return $scenarios;
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country' => 'Country',
            'city' => 'City',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'altitude' => 'Altitude',
        ];
    }
}
