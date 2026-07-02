<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "KTP_C305_HN".
 *
 * @property string|null $ที่
 * @property string|null $rep
 * @property string|null $tran_id
 * @property string|null $HN
 * @property string|null $AN
 * @property string|null $pid
 * @property string|null $fullname
 * @property string|null $สิทธิการรักษาพยาบาล
 * @property string|null $หน่วยบริการแม่ข่าย (HmainOP)
 * @property string|null $วันที่ส่งข้อมูล
 * @property string|null $regdate
 * @property string|null $ลำดับที่
 * @property string|null $รายการประเภทที่ขอเบิก
 * @property string|null $เรียกเก็บ
 * @property string|null $O
 * @property string|null $P
 * @property string|null $Q
 * @property string|null $ล่าช้า (PS)
 * @property string|null $S
 * @property string|null $ชดเชย
 * @property string|null $U
 * @property string|null $V
 * @property string|null $W
 * @property string|null $สถานะ
 * @property string|null $c305
 * @property string|null $หมายเหตุอื่นๆ (STMID)
 * @property string|null $หน่วยบริการที่ส่งข้อมูล (HSEND)
 */
class KtpC305Hn extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'KTP_C305_HN';
    }
     public static function getDb()
    {
        return Yii::$app->get('db70');
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ที่', 'rep', 'tran_id', 'HN', 'AN', 'pid', 'fullname',
              'สิทธิการรักษาพยาบาล', 'หน่วยบริการแม่ข่าย (HmainOP)',
              'วันที่ส่งข้อมูล', 'regdate', 'ลำดับที่', 'รายการประเภทที่ขอเบิก',
              'เรียกเก็บ', 'O', 'P', 'Q', 'ล่าช้า (PS)', 'S', 'ชดเชย',
              'U', 'V', 'W', 'สถานะ', 'c305',
              'หมายเหตุอื่นๆ (STMID)', 'หน่วยบริการที่ส่งข้อมูล (HSEND)'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ที่'                                   => 'ที่',
            'rep'                                   => 'REP',
            'tran_id'                               => 'Transaction ID',
            'HN'                                    => 'HN',
            'AN'                                    => 'AN',
            'pid'                                   => 'PID (บัตรประชาชน)',
            'fullname'                              => 'ชื่อ-นามสกุล',
            'สิทธิการรักษาพยาบาล'                   => 'สิทธิการรักษาพยาบาล',
            'หน่วยบริการแม่ข่าย (HmainOP)'          => 'หน่วยบริการแม่ข่าย (HmainOP)',
            'วันที่ส่งข้อมูล'                        => 'วันที่ส่งข้อมูล',
            'regdate'                               => 'regdate',
            'ลำดับที่'                               => 'ลำดับที่',
            'รายการประเภทที่ขอเบิก'                  => 'รายการประเภทที่ขอเบิก',
            'เรียกเก็บ'                              => 'เรียกเก็บ',
            'O'                                     => 'O',
            'P'                                     => 'P',
            'Q'                                     => 'Q',
            'ล่าช้า (PS)'                           => 'ล่าช้า (PS)',
            'S'                                     => 'S',
            'ชดเชย'                                 => 'ชดเชย',
            'U'                                     => 'U',
            'V'                                     => 'V',
            'W'                                     => 'W',
            'สถานะ'                                 => 'สถานะ',
            'c305'                                  => 'C305',
            'หมายเหตุอื่นๆ (STMID)'                 => 'หมายเหตุอื่นๆ (STMID)',
            'หน่วยบริการที่ส่งข้อมูล (HSEND)'       => 'หน่วยบริการที่ส่งข้อมูล (HSEND)',
        ];
    }
}
