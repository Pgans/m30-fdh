<?php

namespace backend\modules\api\models;

use Yii;

/**
 * This is the model class for table "positions".
 *
 * @property int $id รหัสตำแหน่ง
 * @property string $position_name ตำแหน่ง
 *
 * @property Person[] $people
 * @property Personsss[] $personssses
 */
class Positions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'positions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'position_name'], 'required'],
            [['id'], 'integer'],
            [['position_name'], 'string', 'max' => 100],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position_name' => 'Position Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeople()
    {
        return $this->hasMany(Person::className(), ['positions_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonssses()
    {
        return $this->hasMany(Personsss::className(), ['positions_id' => 'id']);
    }
}
