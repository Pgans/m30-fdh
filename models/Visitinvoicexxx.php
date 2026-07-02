<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%visit_invoice}}".
 *
 * @property string $visit_id
 * @property string $record_dt
 * @property int $order1 หมวดค่าใช้จ่าย
 * @property int $order2 ลำดับการพิมพ์ของแต่ละหมวด
 * @property int $order3
 * @property string $item รายละเอียดสำหรับพิมพ์ในใบแจ้งหนี้
 * @property double $invoice มูลค่า
 * @property string $is_refund เบิกได้ หรือไม่ได้
 * @property string $amount ปริมาณ
 * @property double $subtotal ผลรวมของแต่ละหมวด
 * @property string $ctype
 * @property string $cfield
 * @property string $drug_id
 * @property string $opbills
 * @property string $is_psc
 * @property string $is_inv
 * @property string $is_rcp
 * @property double $base_rate ค่าห้องพิเศษที่ต้องจ่ายเพิ่ม
 * @property double $extra ค่าห้องพิเศษ
 * @property double $unit_price ราคาต่อหน่วย
 * @property string $xl_id รหัส xray โยงกับ xray_lists
 * @property string $lab_id
 * @property string $xray_code
 * @property string $type16
 * @property string $seq16 visit_id
 * @property string $code16
 * @property int $hosp
 * @property string $chrgitem
 * @property string $ned_code
 * @property string $order_dt
 * @property int $is_cancel
 * @property int $auto_id
 */
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
        return Yii::$app->get('db14');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['visit_id', 'record_dt', 'order1', 'order2', 'order3', 'item', 'invoice', 'is_refund', 'amount', 'subtotal', 'ctype', 'cfield', 'drug_id', 'opbills', 'is_psc', 'is_inv', 'is_rcp', 'base_rate', 'extra', 'unit_price', 'xl_id', 'lab_id', 'xray_code', 'type16', 'seq16', 'code16', 'hosp', 'chrgitem', 'ned_code', 'order_dt', 'is_cancel'], 'required'],
            [['record_dt', 'order_dt'], 'safe'],
            [['order1', 'order2', 'order3', 'hosp', 'is_cancel'], 'integer'],
            [['invoice', 'subtotal', 'base_rate', 'extra', 'unit_price'], 'number'],
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
