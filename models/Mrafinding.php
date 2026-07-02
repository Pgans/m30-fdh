<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mra_finding".
 *
 * @property int $finding_id รหัสที่ของปัญหา
 * @property string $finding_name ปัญหาจาการทบทวน
 */
class Mrafinding extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mra_finding';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['finding_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'finding_id' => 'Finding ID',
            'finding_name' => 'Finding Name',
        ];
    }
}
