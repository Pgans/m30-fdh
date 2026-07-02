<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%log_requests}}".
 *
 * @property int $id
 * @property string $users
 * @property string $action
 * @property string $request_date
 * @property string $developer_comments
 * @property string $completion_date
 */
class Logrequests extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%log_requests}}';
    }

    /**
     * {@inheritdoc}
     */
   public function rules()
{
    return [
        [['users'], 'required'],
        [['action', 'developer_comments'], 'string'],
        [['completion_date'], 'safe'], // ไม่รวม request_date เพราะจะถูกตั้งค่าโดยอัตโนมัติ
        [['users'], 'string', 'max' => 255],
    ];
}

/**
 * {@inheritdoc}
 */
public function attributeLabels()
{
    return [
        'id' => Yii::t('app', 'ID'),
        'users' => Yii::t('app', 'ผู้ใช้'),
        'action' => Yii::t('app', 'ความต้องการเพิ่ม'),
        'request_date' => Yii::t('app', 'วันที่บันทึก'),
        'developer_comments' => Yii::t('app', 'ผู้พัฒนาปรับปรุง'),
        'completion_date' => Yii::t('app', 'วันที่เสร็จสิ้น'),
    ];
}

}
