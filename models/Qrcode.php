<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%qrcodes}}".
 *
 * @property int $id
 * @property string $code_data
 * @property string $created_at
 * @property string $d_update
 */
class Qrcode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%qrcodes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code_data'], 'required'],
            [['code_data'], 'string'],
            [['created_at', 'd_update'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code_data' => 'Code Data',
            'created_at' => 'Created At',
            'd_update' => 'D Update',
        ];
    }
}
