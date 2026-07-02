<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mra_departmetns_ipd".
 *
 * @property int $unit_id auto_id
 * @property string $unit_name ชื่อแผนก
 *
 * @property MraIpd[] $mraIpds
 * @property MraIpdCopy[] $mraIpdCopies
 * @property MraIpdCopy3[] $mraIpdCopy3s
 */
class Mradepartmetnsipd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mra_departmetns_ipd';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_name'], 'required'],
            [['unit_name'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'unit_id' => 'Unit ID',
            'unit_name' => 'Unit Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMraIpds()
    {
        return $this->hasMany(MraIpd::className(), ['unit_id' => 'unit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMraIpdCopies()
    {
        return $this->hasMany(MraIpdCopy::className(), ['unit_id' => 'unit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMraIpdCopy3s()
    {
        return $this->hasMany(MraIpdCopy3::className(), ['unit_id' => 'unit_id']);
    }
}
