<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%cht}}".
 *
 * @property string $hn
 * @property string $an
 * @property string $date
 * @property string $total
 * @property string $paid
 * @property string $pttype
 * @property string $person_id
 * @property string $seq
 * @property string $opd_memo
 * @property string $invoice_no
 * @property string $invoice_lt
 */
class Cht extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cht}}';
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
            [['hn', 'an', 'date', 'total', 'paid', 'pttype', 'person_id', 'seq', 'opd_memo', 'invoice_no', 'invoice_lt'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hn' => 'Hn',
            'an' => 'An',
            'date' => 'Date',
            'total' => 'Total',
            'paid' => 'Paid',
            'pttype' => 'Pttype',
            'person_id' => 'Person ID',
            'seq' => 'Seq',
            'opd_memo' => 'Opd Memo',
            'invoice_no' => 'Invoice No',
            'invoice_lt' => 'Invoice Lt',
        ];
    }
}
