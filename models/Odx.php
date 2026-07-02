<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%odx}}".
 *
 * @property string $hn
 * @property string $datedx
 * @property string $clinic
 * @property string $diag
 * @property string $dxtype
 * @property string $drdx
 * @property string $person_id
 * @property string $seq
 */
class Odx extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%odx}}';
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
            [['hn', 'seq'], 'string', 'max' => 15],
            [['datedx', 'diag', 'dxtype', 'drdx', 'person_id'], 'string', 'max' => 50],
            [['clinic'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hn' => 'Hn',
            'datedx' => 'Datedx',
            'clinic' => 'Clinic',
            'diag' => 'Diag',
            'dxtype' => 'Dxtype',
            'drdx' => 'Drdx',
            'person_id' => 'Person ID',
            'seq' => 'Seq',
        ];
    }
}
