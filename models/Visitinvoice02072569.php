<?php

namespace app\models;

use Yii;

class Visitinvoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%visit_invoice}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // ลบ required ออกจากทุกฟิลด์ที่ต้องการให้ค่าว่างได้
            [['visit_id', 'record_dt', 'order1', 'order2', 'order3', 'item', 'invoice', 'is_refund', 'amount', 'subtotal', 'ctype', 'cfield', 'drug_id', 'opbills', 'is_psc', 'is_inv', 'is_rcp', 'base_rate', 'extra', 'unit_price', 'xl_id', 'lab_id', 'xray_code', 'type16', 'seq16', 'code16', 'hosp', 'chrgitem', 'ned_code', 'order_dt', 'is_cancel'], 'safe'],
            [['record_dt', 'order_dt'], 'safe', 'skipOnEmpty' => true],
            [['order1', 'order2', 'order3', 'hosp', 'is_cancel'], 'integer', 'skipOnEmpty' => true],
            [['invoice', 'subtotal', 'base_rate', 'extra', 'unit_price'], 'number', 'skipOnEmpty' => true],
            [['visit_id', 'seq16'], 'string', 'max' => 10],
            [['item'], 'string', 'max' => 200],
            [['is_refund', 'is_psc', 'is_inv', 'is_rcp'], 'string', 'max' => 1],
            [['amount'], 'string', 'max' => 5],
            [['ctype', 'opbills', 'chrgitem'], 'string', 'max' => 2],
            [['cfield'], 'string', 'max' => 15],
            [['drug_id', 'xray_code', 'ned_code'], 'string', 'max' => 4],
            [['xl_id', 'lab_id', 'type16'], 'string', 'max' => 3],
            [['code16'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'visit_id' => Yii::t('app', 'Visit ID'),
            'record_dt' => Yii::t('app', 'Record Dt'),
            'order1' => Yii::t('app', 'Order1'),
            'order2' => Yii::t('app', 'Order2'),
            'order3' => Yii::t('app', 'Order3'),
            'item' => Yii::t('app', 'Item'),
            'invoice' => Yii::t('app', 'Invoice'),
            'is_refund' => Yii::t('app', 'Is Refund'),
            'amount' => Yii::t('app', 'Amount'),
            'subtotal' => Yii::t('app', 'Subtotal'),
            'ctype' => Yii::t('app', 'Ctype'),
            'cfield' => Yii::t('app', 'Cfield'),
            'drug_id' => Yii::t('app', 'Drug ID'),
            'opbills' => Yii::t('app', 'Opbills'),
            'is_psc' => Yii::t('app', 'Is Psc'),
            'is_inv' => Yii::t('app', 'Is Inv'),
            'is_rcp' => Yii::t('app', 'Is Rcp'),
            'base_rate' => Yii::t('app', 'Base Rate'),
            'extra' => Yii::t('app', 'Extra'),
            'unit_price' => Yii::t('app', 'Unit Price'),
            'xl_id' => Yii::t('app', 'Xl ID'),
            'lab_id' => Yii::t('app', 'Lab ID'),
            'xray_code' => Yii::t('app', 'Xray Code'),
            'type16' => Yii::t('app', 'Type16'),
            'seq16' => Yii::t('app', 'Seq16'),
            'code16' => Yii::t('app', 'Code16'),
            'hosp' => Yii::t('app', 'Hosp'),
            'chrgitem' => Yii::t('app', 'Chrgitem'),
            'ned_code' => Yii::t('app', 'Ned Code'),
            'order_dt' => Yii::t('app', 'Order Dt'),
            'is_cancel' => Yii::t('app', 'Is Cancel'),
            'auto_id' => Yii::t('app', 'Auto ID'),
        ];
    }
}
