<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Model สำหรับตาราง patient_claim305
 *
 * @property int         $id
 * @property int         $no
 * @property string      $eclaim_no
 * @property int         $patient_type
 * @property string      $benefit_rights
 * @property string      $card_no
 * @property string      $patient_name
 * @property string|null $hn
 * @property string|null $an
 * @property string      $service_date
 * @property string|null $service_time
 * @property string|null $discharge_date
 * @property string|null $discharge_time
 * @property int         $data_status
 * @property string|null $recorder_name
 * @property int|null    $tran_id
 * @property float       $high_cost
 * @property float       $claim_amount
 * @property string|null $rep
 * @property string|null $stm
 * @property int|null    $seq
 * @property string|null $inspection_details
 * @property string|null $deny_warning
 * @property string|null $channel
 * @property string      $created_at
 * @property string      $updated_at
 */
class PatientClaim305 extends ActiveRecord
{
    public static function tableName()
    {
        return 'patient_claim305';
    }
	 public static function getDb()
    {
        return Yii::$app->get('db70');
    }

    public function rules()
    {
        return [
            [['no', 'eclaim_no', 'patient_type', 'benefit_rights', 'card_no', 'patient_name', 'service_date'], 'required'],
            [['no', 'patient_type', 'data_status', 'tran_id', 'seq'], 'integer'],
            [['high_cost', 'claim_amount'], 'number'],
            [['service_date', 'discharge_date'], 'date', 'format' => 'php:Y-m-d'],
            [['service_time', 'discharge_time'], 'safe'],
            [['eclaim_no', 'benefit_rights', 'rep', 'stm', 'channel'], 'string', 'max' => 30],
            [['card_no', 'hn', 'an'], 'string', 'max' => 20],
            [['patient_name', 'recorder_name'], 'string', 'max' => 150],
            [['inspection_details', 'deny_warning'], 'string', 'max' => 20],
            [['high_cost', 'claim_amount'], 'default', 'value' => 0.00],
            [['data_status'], 'default', 'value' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'                 => 'ID',
            'no'                 => 'No.',
            'eclaim_no'          => 'EClaim No.',
            'patient_type'       => 'Patient Type',
            'benefit_rights'     => 'Benefit Rights',
            'card_no'            => 'Card No.',
            'patient_name'       => 'Patient Name',
            'hn'                 => 'HN',
            'an'                 => 'AN',
            'service_date'       => 'Service Date',
            'service_time'       => 'Service Time',
            'discharge_date'     => 'Discharge Date',
            'discharge_time'     => 'Discharge Time',
            'data_status'        => 'Data Status',
            'recorder_name'      => 'Recorder Name',
            'tran_id'            => 'Tran ID',
            'high_cost'          => 'High Cost',
            'claim_amount'       => 'Claim Amount',
            'rep'                => 'REP',
            'stm'                => 'STM',
            'seq'                => 'SEQ',
            'inspection_details' => 'Inspection Details',
            'deny_warning'       => 'Deny / Warning',
            'channel'            => 'Channel',
            'created_at'         => 'Created At',
            'updated_at'         => 'Updated At',
        ];
    }

    public function getPatientTypeLabel()
    {
        $types = [1 => 'OPD', 2 => 'IPD'];
        return isset($types[$this->patient_type]) ? $types[$this->patient_type] : '-';
    }

    public function getDataStatusLabel()
    {
        $statuses = [0 => 'Pending', 1 => 'Approved', 2 => 'Rejected', 3 => 'Processed'];
        return isset($statuses[$this->data_status]) ? $statuses[$this->data_status] : '-';
    }
}