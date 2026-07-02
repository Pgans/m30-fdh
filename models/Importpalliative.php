<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%import_palliative}}".
 *
 * @property int $auto_id
 * @property string $hospcode เลขrep
 * @property string $date_serv วันรับบริการ
 * @property string $hn hn
 * @property string $cid cid
 * @property string $fullname ชื่อสกุล
 * @property string $age อายุ
 * @property string $diag_primary โรคหลัก
 * @property string $diag_comor โรครอง
 * @property string $address ที่อยู่
 * @property string $telephone เบอร์โทร
 * @property string $status สถานะ
 * @property string $d_update วันที่นำเข้า
 */
class Importpalliative extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%import_palliative}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db14');
    }
    public $uploadPath = 'uploads/file/';
    public $file; 
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['d_update'], 'required'],
            [['d_update'], 'safe'],
            [['hospcode', 'date_serv', 'hn', 'cid', 'fullname', 'age', 'diag_primary', 'diag_comor', 'address', 'telephone', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'auto_id' => 'Auto ID',
            'hospcode' => 'Hospcode',
            'date_serv' => 'Date Serv',
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
