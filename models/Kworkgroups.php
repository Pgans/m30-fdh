<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%k_workgroups}}".
 *
 * @property int $id
 * @property string $workgroup_id
 * @property string $workgroup_name
 * @property string $d_update
 */
class Kworkgroups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%k_workgroups}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['d_update'], 'safe'],
            [['workgroup_id'], 'string', 'max' => 10],
            [['workgroup_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'workgroup_id' => 'Workgroup ID',
            'workgroup_name' => 'Workgroup Name',
            'd_update' => 'D Update',
        ];
    }
}
