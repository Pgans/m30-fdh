<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mra_departmetns".
 *
 * @property int $unit_id auto_id
 * @property string $unit_name ชื่อแผนก
 *
 * @property MraIpd[] $mraIpds
 * @property MraIpdAn[] $mraIpdAns
 */
class Mradepartmetns extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mra_departmetns';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_mra');
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
     * Gets query for [[MraIpds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMraIpds()
    {
        return $this->hasMany(MraIpd::className(), ['unit_id' => 'unit_id']);
    }

    /**
     * Gets query for [[MraIpdAns]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMraIpdAns()
    {
        return $this->hasMany(MraIpdAn::className(), ['unit_id' => 'unit_id']);
    }
}
