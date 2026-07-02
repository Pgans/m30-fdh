<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%death}}".
 *
 * @property string $hospcode
 * @property string $pid
 * @property string $hospdeath
 * @property string $an
 * @property string $seq
 * @property string $ddeath
 * @property string $cdeath_a
 * @property string $cdeath_b
 * @property string $cdeath_c
 * @property string $cdeath_d
 * @property string $odisease
 * @property string $cdeath
 * @property string $pregdeath
 * @property string $pdeath
 * @property string $provider
 * @property string $d_update
 * @property string $cid
 */
class Death extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%death}}';
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
            [['hospcode', 'pid', 'hospdeath', 'an', 'seq', 'ddeath', 'cdeath_a', 'cdeath_b', 'cdeath_c', 'cdeath_d', 'odisease', 'cdeath', 'pregdeath', 'pdeath', 'provider', 'd_update'], 'string', 'max' => 255],
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
            'hospdeath' => 'Hospdeath',
            'an' => 'An',
            'seq' => 'Seq',
            'ddeath' => 'Ddeath',
            'cdeath_a' => 'Cdeath A',
            'cdeath_b' => 'Cdeath B',
            'cdeath_c' => 'Cdeath C',
            'cdeath_d' => 'Cdeath D',
            'odisease' => 'Odisease',
            'cdeath' => 'Cdeath',
            'pregdeath' => 'Pregdeath',
            'pdeath' => 'Pdeath',
            'provider' => 'Provider',
            'd_update' => 'D Update',
            'cid' => 'Cid',
        ];
    }
}
