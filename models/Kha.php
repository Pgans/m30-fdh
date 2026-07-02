<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;


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
    public $file;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['workgroup_id', 'document_id', 'team_id', 'dep_id', 'is_update'], 'integer'],
            [['document_id', 'team_id'], 'required'],
            [['create_date', 'd_update'], 'safe'],
            [['ha_name', 'filename'], 'string', 'max' => 255],
            [['document_id'], 'exist', 'skipOnError' => true, 'targetClass' => KDocuments::className(), 'targetAttribute' => ['document_id' => 'id']],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => KTeams::className(), 'targetAttribute' => ['team_id' => 'id']],
            [['dep_id'], 'exist', 'skipOnError' => true, 'targetClass' => KDepartments::className(), 'targetAttribute' => ['dep_id' => 'id']],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'xls, xlsx, doc, docx, pdf'],
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
            'document_id' => 'Document ID',
            'team_id' => 'Team ID',
            'dep_id' => 'Dep ID',
            'ha_name' => 'Ha Name',
            'filename' => 'Filename',
            'is_update' => 'Is Update',
            'create_date' => 'Create Date',
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
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->file = UploadedFile::getInstance($this, 'file');

            if ($this->file) {
                $this->filename = $this->file->baseName . '.' . $this->file->extension;
            }

            return true;
        }

        return false;
    }
/*
    public function upload()
    {
        if ($this->validate()) {
            $uploadPath = 'uploads/ha/';
            $filePath = $uploadPath . $this->filename;

            // Save the filename to the database
            $this->save(false); // Save without validation

            // Upload the file
            $this->file->saveAs($filePath);

            return true;
        } else {
            return false;
        }
    }
    */
    /*
     public function upload()
{
    if ($this->validate()) {
        $originalFilename = $this->file->baseName; // Get the original file name
        $filename = $originalFilename . '_' . uniqid() . '.' . $this->file->extension;
        $filePath = 'uploads/ha/' . $filename;

        // Save the file
        $this->file->saveAs($filePath);

        // Set permission for the directory
        chmod('uploads/ha/', 0777);

        return $filename;
    } else {
        return false;
    }
}
*/
public function actionUpload()
{
    $model = new Kha();

    if (Yii::$app->request->isPost) {
        $model->file = UploadedFile::getInstance($model, 'file');

        if ($model->file && $model->validate()) {
            // Set the filename based on your requirements
            $model->filename = $model->file->baseName . '.' . $model->file->extension;

            // Move the file to the desired directory
            $uploadPath = 'uploads/ha/';
            $model->file->saveAs($uploadPath . $model->filename);

            // Save the model with the filename
            if ($model->save()) {
                // File uploaded and model saved successfully
                return $this->redirect(['index']);
            }
        }
    }

    return $this->render('upload', ['model' => $model]);
}

}