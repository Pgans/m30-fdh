<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%nutrition}}".
 *
 * @property string $hospcode
 * @property string $pid
 * @property string $seq
 * @property string $date_serv
 * @property string $nutritionplace
 * @property string $weight
 * @property string $height
 * @property string $headcircum
 * @property string $childdevelop
 * @property string $food
 * @property string $bottle
 * @property string $provider
 * @property string $d_update
 * @property string $cid
 */
class Nutrition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%nutrition}}';
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
            [['hospcode', 'pid', 'seq', 'date_serv', 'nutritionplace', 'weight', 'height', 'headcircum', 'childdevelop', 'food', 'bottle', 'provider', 'd_update'], 'string', 'max' => 255],
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
            'seq' => 'Seq',
            'date_serv' => 'Date Serv',
            'nutritionplace' => 'Nutritionplace',
            'weight' => 'Weight',
            'height' => 'Height',
            'headcircum' => 'Headcircum',
            'childdevelop' => 'Childdevelop',
            'food' => 'Food',
            'bottle' => 'Bottle',
            'provider' => 'Provider',
            'd_update' => 'D Update',
            'cid' => 'Cid',
        ];
    }
}
