<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%disability}}".
 *
 * @property string $hospcode
 * @property string $disabid
 * @property string $pid
 * @property string $disabtype
 * @property string $disabcause
 * @property string $diagcode
 * @property string $date_detect
 * @property string $date_disab
 * @property string $d_update
 * @property string $cid
 */
class Disability extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%disability}}';
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
            [['hospcode', 'disabid', 'pid', 'disabtype', 'disabcause', 'diagcode', 'date_detect', 'date_disab', 'd_update'], 'string', 'max' => 255],
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
            'disabid' => 'Disabid',
            'pid' => 'Pid',
            'disabtype' => 'Disabtype',
            'disabcause' => 'Disabcause',
            'diagcode' => 'Diagcode',
            'date_detect' => 'Date Detect',
            'date_disab' => 'Date Disab',
            'd_update' => 'D Update',
            'cid' => 'Cid',
        ];
    }
}
