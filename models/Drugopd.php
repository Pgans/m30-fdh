<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "drug_opd".
 *
 * @property string $HOSPCODE
 * @property string $PID
 * @property string $SEQ
 * @property string $DATE_SERV
 * @property string $CLINIC
 * @property string $DIDSTD
 * @property string $DNAME
 * @property string $AMOUNT
 * @property string $UNIT
 * @property string $UNIT_PACKING
 * @property string $DRUGPRICE
 * @property string $DRUGCOST
 * @property string $PROVIDER
 * @property string $D_UPDATE
 * @property string $CID
 * @property string $USAGE_LINE1
 * @property string $USAGE_LINE2
 * @property string $USAGE_LINE3
 */
class Drugopd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drug_opd';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_host');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['HOSPCODE', 'PID', 'SEQ', 'DIDSTD', 'AMOUNT', 'UNIT', 'UNIT_PACKING', 'DRUGCOST', 'PROVIDER', 'CID'], 'required'],
            [['DATE_SERV'], 'safe'],
            [['AMOUNT', 'DRUGCOST'], 'number'],
            [['DRUGPRICE', 'USAGE_LINE2', 'USAGE_LINE3'], 'string'],
            [['HOSPCODE', 'PROVIDER'], 'string', 'max' => 5],
            [['PID', 'CLINIC'], 'string', 'max' => 6],
            [['SEQ'], 'string', 'max' => 10],
            [['DIDSTD'], 'string', 'max' => 24],
            [['DNAME'], 'string', 'max' => 154],
            [['UNIT'], 'string', 'max' => 2],
            [['UNIT_PACKING'], 'string', 'max' => 20],
            [['D_UPDATE'], 'string', 'max' => 19],
            [['CID'], 'string', 'max' => 13],
            [['USAGE_LINE1'], 'string', 'max' => 72],
            [['HOSPCODE', 'PID', 'SEQ', 'DIDSTD'], 'unique', 'targetAttribute' => ['HOSPCODE', 'PID', 'SEQ', 'DIDSTD']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'HOSPCODE' => 'Hospcode',
            'PID' => 'Pid',
            'SEQ' => 'Seq',
            'DATE_SERV' => 'Date Serv',
            'CLINIC' => 'Clinic',
            'DIDSTD' => 'Didstd',
            'DNAME' => 'Dname',
            'AMOUNT' => 'Amount',
            'UNIT' => 'Unit',
            'UNIT_PACKING' => 'Unit Packing',
            'DRUGPRICE' => 'Drugprice',
            'DRUGCOST' => 'Drugcost',
            'PROVIDER' => 'Provider',
            'D_UPDATE' => 'D Update',
            'CID' => 'Cid',
            'USAGE_LINE1' => 'Usage Line 1',
            'USAGE_LINE2' => 'Usage Line 2',
            'USAGE_LINE3' => 'Usage Line 3',
        ];
    }
}
