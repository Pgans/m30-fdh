<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%k_documents}}".
 *
 * @property int $id
 * @property string $document_id รหัสเอกสาร
 * @property string $document_name ชื่อเอกสาร
 * @property string $d_update
 *
 * @property KHa[] $kHas
 */
class Kdocuments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%k_documents}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['d_update'], 'safe'],
            [['document_id'], 'string', 'max' => 10],
            [['document_name'], 'string', 'max' => 200],
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
            'document_name' => 'Document Name',
            'd_update' => 'D Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKHas()
    {
        return $this->hasMany(KHa::className(), ['document_id' => 'id']);
    }
}
