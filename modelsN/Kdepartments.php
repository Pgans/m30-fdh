<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%k_departments}}".
 *
 * @property int $id
 * @property string $dep_id
 * @property string $dep_name
 * @property string $d_update
 *
 * @property KHa[] $kHas
 */
class Kdepartments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%k_departments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['d_update'], 'safe'],
            [['dep_id'], 'string', 'max' => 10],
            [['dep_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dep_id' => 'Dep ID',
            'dep_name' => 'Dep Name',
            'd_update' => 'D Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKHas()
    {
        return $this->hasMany(KHa::className(), ['dep_id' => 'id']);
    }
}
