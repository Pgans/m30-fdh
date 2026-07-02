<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%edc}}".
 *
 * @property int $id
 * @property string $trans_id รหัสหน่วยบริการ
 * @property string $visit_id เลขรับบริการ
 * @property string $cid รหัสประชาชน
 * @property string $amount ค่าบริการ
 * @property string $approvecode เลขApprove
 * @property string $edc_date วันที่รูดบัตร
 * @property string $edc_time เวลา
 * @property string $d_update
 */
class Edc extends \yii\db\ActiveRecord
{
    public $csvFile;
    public $file;

   // public $csvFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%edc}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edc_time', 'd_update'], 'safe'],
            [['trans_id', 'amount', 'approvecode', 'edc_date'], 'string', 'max' => 10],
            [['visit_id'], 'string', 'max' => 15],
            [['cid'], 'string', 'max' => 13],
            [['csvFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trans_id' => 'Trans ID',
            'visit_id' => 'Visit ID',
            'cid' => 'Cid',
            'amount' => 'Amount',
            'approvecode' => 'Approvecode',
            'edc_date' => 'Edc Date',
            'edc_time' => 'Edc Time',
            'd_update' => 'D Update',
        ];
    }
}
