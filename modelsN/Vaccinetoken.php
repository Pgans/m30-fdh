<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vaccine_token".
 *
 * @property int $auto_id
 * @property string $token_dt
 * @property string $token
 * @property string $staff_id
 */
class Vaccinetoken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vaccine_token';
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
            [['token_dt', 'token', 'staff_id'], 'required'],
            [['token_dt'], 'safe'],
            [['token'], 'string'],
            [['staff_id'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'auto_id' => 'Auto ID',
            'token_dt' => 'Token Dt',
            'token' => 'Token',
            'staff_id' => 'Staff ID',
        ];
    }
}
