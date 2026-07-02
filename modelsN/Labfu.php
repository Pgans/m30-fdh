<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%labfu}}".
 *
 * @property string $hcode
 * @property string $hn
 * @property string $person_id
 * @property string $dateserv
 * @property string $seq
 * @property string $labtest
 * @property string $labresult
 */
class Labfu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%labfu}}';
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
            [['hcode'], 'string', 'max' => 5],
            [['hn'], 'string', 'max' => 6],
            [['person_id'], 'string', 'max' => 13],
            [['dateserv'], 'string', 'max' => 20],
            [['seq'], 'string', 'max' => 15],
            [['labtest', 'labresult'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hcode' => 'Hcode',
            'hn' => 'Hn',
            'person_id' => 'Person ID',
            'dateserv' => 'Dateserv',
            'seq' => 'Seq',
            'labtest' => 'Labtest',
            'labresult' => 'Labresult',
        ];
    }
}
