<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%k_ha}}".
 *
 * @property int $id
 * @property int $workgroup_id ชื่อกลุ่มงาน
 * @property int $document_id ชื่อเอกสาร
 * @property int $team_id ชื่อทีม
 * @property int $dep_id ชื่อแผนก
 * @property string $ha_name หัวข้อเอกสาร 
 * @property string $filename ชื่อไฟล์
 * @property int $is_update การแก้ไข
 * @property string $create_date วันที่สร้าง
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
            [['workgroup_id', 'document_id', 'dep_id'], 'required'],
            [['workgroup_id', 'document_id', 'team_id', 'dep_id', 'is_update'], 'integer'],
            [['create_date', 'd_update'], 'safe'],
            [['ha_name', 'filename'], 'string', 'max' => 255],
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
            'workgroup_id' => 'กลุ่มงาน',
            'document_id' => 'รหัสเอกสาร',
            'team_id' => 'ทีม',
            'dep_id' => 'แผนก',
            'ha_name' => 'หัวข้อ',
            'filename' => 'ไฟล์แนบ',
            'is_update' => 'แก้ไข',
            'create_date' => 'วันบันทึก',
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
    public function getWorkgroup()
    {
        return $this->hasOne(Kworkgroups::className(), ['id' => 'workgroup_id']);
    }
}
