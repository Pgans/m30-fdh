<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%k_teams}}".
 *
 * @property int $id
 * @property string $team_id รหัสทีม
 * @property string $team_name ชื่อทีม
 * @property string $d_update
 *
 * @property KHa[] $kHas
 */
class Kteams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%k_teams}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['d_update'], 'safe'],
            [['team_id'], 'string', 'max' => 10],
            [['team_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'team_id' => 'Team ID',
            'team_name' => 'Team Name',
            'd_update' => 'D Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKHas()
    {
        return $this->hasMany(KHa::className(), ['team_id' => 'id']);
    }
}
