<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%fdh_hurb}}".
 *
 * @property int $id
 * @property string $main_table ชื่อแฟ้ม
 * @property string $main_query คิวรี่
 * @property string $d_update
 */
class Fdhhurb extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%fdh_hurb}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db14');
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
            'id' => Yii::t('app', 'ID'),
            'main_table' => Yii::t('app', 'Main Table'),
            'main_query' => Yii::t('app', 'Main Query'),
            'd_update' => Yii::t('app', 'D Update'),
        ];
    }
}
