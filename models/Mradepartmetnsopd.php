<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mra_departmetns_opd".
 *
 * @property int $unit_id auto_id
 * @property string $unit_name ชื่อแผนก
 *
 * @property MraOpd[] $mraOpds
 */
class Mradepartmetnsopd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mra_departmetns_opd';
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
            'unit_id' => 'แผนก',
            'unit_name' => 'Unit Name',
        ];
    }

    /**
     * Gets query for [[MraOpds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMraOpds()
    {
        return $this->hasMany(MraOpd::className(), ['unit_id' => 'unit_id']);
    }
}
