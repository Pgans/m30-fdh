<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%k_ha}}".
 *
 * @property int $id
 * @property int $document_id ชื่อเอกสาร
 * @property int $team_id ชื่อทีม
 * @property int $dep_id ชื่อแผนก
 * @property string $ha_name หัวข้อเอกสาร 
 * @property string $filename ชื่อไฟล์
 * @property string $d_update
 *
 * @property KDocuments $document
 * @property KTeams $team
 * @property KDepartments $dep
 */
class Kha extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%k_ha}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['document_id', 'team_id', 'dep_id'], 'integer'],
            [['d_update', 'crate_date'], 'safe'],
            [['ha_name', 'filename'], 'string', 'max' => 255],
            [['is_update'], 'integer'],
            [['document_id'], 'exist', 'skipOnError' => true, 'targetClass' => KDocuments::className(), 'targetAttribute' => ['document_id' => 'id']],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => KTeams::className(), 'targetAttribute' => ['team_id' => 'id']],
            [['dep_id'], 'exist', 'skipOnError' => true, 'targetClass' => KDepartments::className(), 'targetAttribute' => ['dep_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'document_id' => 'Document ID',
            'team_id' => 'Team ID',
            'dep_id' => 'Dep ID',
            'ha_name' => 'หัวข้อ',
            'filename' => 'ไฟล์แนบ',
            'is_update'=> 'การแก้ไข',
            'create_date'=> 'วันที่สร้าง',
            'd_update' => 'D Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocument()
    {
        return $this->hasOne(KDocuments::className(), ['id' => 'document_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(KTeams::className(), ['id' => 'team_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDep()
    {
        return $this->hasOne(KDepartments::className(), ['id' => 'dep_id']);
    }
}
