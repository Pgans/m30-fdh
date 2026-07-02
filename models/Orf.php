<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%orf}}".
 *
 * @property string $hn
 * @property string $dateopd
 * @property string $clinic
 * @property string $refer
 * @property string $refertype
 * @property string $seq
 * @property string $referdate
 */
class Orf extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%orf}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db16');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hn', 'dateopd', 'clinic', 'refer', 'refertype', 'seq', 'referdate'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hn' => 'Hn',
            'dateopd' => 'Dateopd',
            'clinic' => 'Clinic',
            'refer' => 'Refer',
            'refertype' => 'Refertype',
            'seq' => 'Seq',
            'referdate' => 'Referdate',
        ];
    }
}
