<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%card}}".
 *
 * @property string $hospcode
 * @property string $pid
 * @property string $instype_old
 * @property string $instype_new
 * @property string $insid
 * @property string $startdate
 * @property string $expiredate
 * @property string $main
 * @property string $sub
 * @property string $d_update
 * @property string $cid
 */
class Card extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%card}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db943');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hospcode', 'pid', 'instype_old', 'instype_new', 'insid', 'startdate', 'expiredate', 'main', 'sub', 'd_update'], 'string', 'max' => 255],
            [['cid'], 'string', 'max' => 13],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hospcode' => 'Hospcode',
            'pid' => 'Pid',
            'instype_old' => 'Instype Old',
            'instype_new' => 'Instype New',
            'insid' => 'Insid',
            'startdate' => 'Startdate',
            'expiredate' => 'Expiredate',
            'main' => 'Main',
            'sub' => 'Sub',
            'd_update' => 'D Update',
            'cid' => 'Cid',
        ];
    }
}
