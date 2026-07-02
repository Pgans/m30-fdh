<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mra_content_ipd_l".
 *
 * @property int $content_id
 * @property string|null $content_name ชื่อหัวข้อ
 *
 * @property MraIpd[] $mraIpds
 */
class MraContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mra_content_ipd_l';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_mra');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_name'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'content_id' => 'Content ID',
            'content_name' => 'Content Name',
        ];
    }

    /**
     * Gets query for [[MraIpds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMraIpds()
    {
        return $this->hasMany(MraIpd::className(), ['content_id' => 'content_id']);
    }
}
