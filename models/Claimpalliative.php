<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%claim_palliative}}".
 *
 * @property int $id
 * @property string $hospcode รหัสสถานบริการ
 * @property string $regdate วันเยี่ยมบ้าน
 * @property string $hn hn
 * @property string $cid 13 หลัก
 * @property string $fullname ชื่อสกุล
 * @property string $age อายุ
 * @property string $diag_primary โรคหลัก
 * @property string $diag_comor รหัสโรครอง
 * @property string $address ที่อยู่
 * @property string $telephone เบอร์โทร
 * @property string $status สถานะ
 * @property string $d_update วันที่บันทึก
 */
class Claimpalliative extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%claim_palliative}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['d_update'], 'required'],
            [['d_update'], 'safe'],
            [['hospcode', 'regdate', 'fullname', 'age', 'diag_primary', 'diag_comor', 'address', 'telephone'], 'string', 'max' => 255],
            [['hn'], 'string', 'max' => 6],
            [['cid'], 'string', 'max' => 13],
            [['status'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hospcode' => 'Hospcode',
            'regdate' => 'Regdate',
            'hn' => 'Hn',
            'cid' => 'Cid',
            'fullname' => 'Fullname',
            'age' => 'Age',
            'diag_primary' => 'Diag Primary',
            'diag_comor' => 'Diag Comor',
            'address' => 'Address',
            'telephone' => 'Telephone',
            'status' => 'Status',
            'd_update' => 'D Update',
        ];
    }
}
