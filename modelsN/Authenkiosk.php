<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%authen_kiosk}}".
 *
 * @property string $id
 * @property string $cid 13หลัก
 * @property string $visit_id
 * @property string $claimtype รหัสกิจกรรม
 * @property string $claimcode
 * @property string $mobile รหัส รพ.
 * @property string $dep_name แผนกที่รับบริการ
 * @property string $d_update update
 */
class Authenkiosk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%authen_kiosk}}';
    }
    
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
            [['cid', 'claimtype'], 'required'],
            [['d_update'], 'safe'],
            [['cid'], 'string', 'max' => 13],
            [['visit_id', 'mobile'], 'string', 'max' => 10],
            [['claimtype', 'claimcode'], 'string', 'max' => 20],
            [['dep_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cid' => 'Cid',
            'visit_id' => 'Visit ID',
            'claimtype' => 'Claimtype',
            'claimcode' => 'Claimcode',
            'mobile' => 'Mobile',
            'dep_name' => 'Dep Name',
            'd_update' => 'D Update',
        ];
    }
}
