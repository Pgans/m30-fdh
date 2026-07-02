<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%f16_fdh_ipd}}".
 *
 * @property int $id
 * @property string $main_table ชื่อแฟ้ม
 * @property string $main_query คิวรี่
 * @property string $d_update
 */
class F16fdhipd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%f16_fdh_ipd}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['main_query'], 'string'],
            [['d_update'], 'safe'],
            [['main_table'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'main_table' => 'Main Table',
            'main_query' => 'Main Query',
            'd_update' => 'D Update',
        ];
    }
}
