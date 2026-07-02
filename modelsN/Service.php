<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "service".
 *
 * @property string $HOSPCODE รหัส รพ.ม่วง
 * @property string $PID
 * @property string $HN
 * @property string $SEQ
 * @property string $DATE_SERV
 * @property string $TIME_SERV
 * @property string $LOCATION
 * @property string $INTIME
 * @property string $INSTYPE
 * @property string $INSID
 * @property string $MAIN
 * @property string $TYPEIN
 * @property string $REFERINHOSP
 * @property string $CAUSEIN
 * @property string $CHIEFCOMP
 * @property string $SERVPLACE
 * @property string $BTEMP
 * @property string $SBP
 * @property string $DBP
 * @property string $PR
 * @property string $RR
 * @property string $TYPEOUT
 * @property string $REFEROUTHOSP
 * @property string $CAUSEOUT
 * @property string $COST
 * @property string $PRICE
 * @property string $PAYPRICE
 * @property string $ACTUALPAY
 * @property string $D_UPDATE
 * @property string $HSUB
 * @property string $CID
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service';
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
            [['HOSPCODE', 'PID', 'HN', 'SEQ', 'INSTYPE', 'CHIEFCOMP', 'BTEMP', 'SBP', 'DBP', 'PR', 'RR', 'CID'], 'required'],
            [['CHIEFCOMP'], 'string'],
            [['BTEMP', 'CAUSEOUT', 'COST', 'PRICE', 'PAYPRICE', 'ACTUALPAY'], 'number'],
            [['HOSPCODE', 'MAIN', 'REFERINHOSP', 'REFEROUTHOSP', 'HSUB'], 'string', 'max' => 5],
            [['PID', 'HN'], 'string', 'max' => 6],
            [['SEQ', 'DATE_SERV'], 'string', 'max' => 10],
            [['TIME_SERV'], 'string', 'max' => 11],
            [['LOCATION', 'INTIME', 'TYPEIN', 'CAUSEIN', 'SERVPLACE', 'TYPEOUT'], 'string', 'max' => 1],
            [['INSTYPE'], 'string', 'max' => 4],
            [['INSID'], 'string', 'max' => 20],
            [['SBP', 'DBP', 'PR', 'RR'], 'string', 'max' => 3],
            [['D_UPDATE'], 'string', 'max' => 19],
            [['CID'], 'string', 'max' => 13],
            [['HOSPCODE', 'PID', 'SEQ'], 'unique', 'targetAttribute' => ['HOSPCODE', 'PID', 'SEQ']],
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
            'HN' => 'Hn',
            'SEQ' => 'Seq',
            'DATE_SERV' => 'Date Serv',
            'TIME_SERV' => 'Time Serv',
            'LOCATION' => 'Location',
            'INTIME' => 'Intime',
            'INSTYPE' => 'Instype',
            'INSID' => 'Insid',
            'MAIN' => 'Main',
            'TYPEIN' => 'Typein',
            'REFERINHOSP' => 'Referinhosp',
            'CAUSEIN' => 'Causein',
            'CHIEFCOMP' => 'Chiefcomp',
            'SERVPLACE' => 'Servplace',
            'BTEMP' => 'Btemp',
            'SBP' => 'Sbp',
            'DBP' => 'Dbp',
            'PR' => 'Pr',
            'RR' => 'Rr',
            'TYPEOUT' => 'Typeout',
            'REFEROUTHOSP' => 'Referouthosp',
            'CAUSEOUT' => 'Causeout',
            'COST' => 'Cost',
            'PRICE' => 'Price',
            'PAYPRICE' => 'Payprice',
            'ACTUALPAY' => 'Actualpay',
            'D_UPDATE' => 'D Update',
            'HSUB' => 'Hsub',
            'CID' => 'Cid',
        ];
    }
}
