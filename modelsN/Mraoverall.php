<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mra_overall".
 *
 * @property int $overall_id รหัสที่ของปัญหา
 * @property string $overall_name ปัญหาจาการทบทวน
 * @property string $overall_name_th ปัญหาการทบทวนเวชระเบียน ภาษาไทย
 */
class Mraoverall extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mra_overall';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['overall_name', 'overall_name_th'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'overall_id' => 'Overall ID',
            'overall_name' => 'Overall Name',
            'overall_name_th' => 'Overall Name Th',
        ];
    }
}
