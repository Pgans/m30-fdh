<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mra_ipd".
 *
 * @property int $mra_id
 * @property int|null $unit_id
 * @property string|null $HN เลขโรงพยาบาล
 * @property string|null $AN เลขผู้ป่วยใน
 * @property string|null $dr_license เลข ว แพทย์
 * @property string|null $date_admit วันเข้ารักษา
 * @property string|null $date_discharge วันออกโรงพยาบาล
 * @property string|null $date_audit วันตรวจเวชระเบียน
 * @property string|null $NA1
 * @property string|null $Missing1
 * @property string|null $No1
 * @property int|null $dxop1 dxopข้อ1
 * @property int|null $dxop2 เกณฑ์ข้อ2
 * @property int|null $dxop3 เกณฑ์ข้อ3
 * @property int|null $dxop4 เกณฑ์ข้อ4
 * @property int|null $dxop5 เกณฑ์ข้อ5
 * @property int|null $dxop6 เกณฑ์ข้อ6
 * @property int|null $dxop7 เกณฑ์ข้อ7
 * @property int|null $dxop8 เกณฑ์ข้อ8
 * @property int|null $dxop9 เกณฑ์ข้อ9
 * @property int|null $dxop_huk หักคะแนน
 * @property string|null $NA2
 * @property string|null $Missing2
 * @property string|null $No2
 * @property int|null $other1 ข้อ1
 * @property int|null $other2 ข้อ2
 * @property int|null $other3 ข้อ3
 * @property int|null $other4 ข้อ4
 * @property int|null $other5 ข้อ5
 * @property int|null $other6 เกณฑ์ข้อ6
 * @property int|null $other7 เกณฑ์ข้อ7
 * @property int|null $other8 เกณฑ์ข้อ8
 * @property int|null $other9 เกณฑ์ข้อ9
 * @property int|null $other_huk หักคะแนน
 * @property string|null $NA3
 * @property string|null $Missing3
 * @property string|null $No3
 * @property int|null $infc1 ข้อ1
 * @property int|null $infc2 ข้อ2
 * @property int|null $infc3 ข้อ3
 * @property int|null $infc4 ข้อ4
 * @property int|null $infc5 ข้อ5
 * @property int|null $infc6 เกณฑ์ข้อ6
 * @property int|null $infc7 เกณฑ์ข้อ7
 * @property int|null $infc8 เกณฑ์ข้อ8
 * @property int|null $infc9 เกณฑ์ข้อ9
 * @property int|null $infc_huk หักคะแนน
 * @property string|null $NA4
 * @property string|null $Missing4
 * @property string|null $No4
 * @property int|null $hist1 ข้อ1
 * @property int|null $hist2 ข้อ2
 * @property int|null $hist3 ข้อ3
 * @property int|null $hist4 ข้อ4
 * @property int|null $hist5 ข้อ5
 * @property int|null $hist6 เกณฑ์ข้อ6
 * @property int|null $hist7 เกณฑ์ข้อ7
 * @property int|null $hist8 เกณฑ์ข้อ8
 * @property int|null $hist9 เกณฑ์ข้อ9
 * @property int|null $hist_huk หักคะแนน
 * @property string|null $NA5
 * @property string|null $Missing5
 * @property string|null $No5
 * @property int|null $pe1 ข้อ1
 * @property int|null $pe2 ข้อ2
 * @property int|null $pe3 ข้อ3
 * @property int|null $pe4 ข้อ4
 * @property int|null $pe5 ข้อ5
 * @property int|null $pe6 เกณฑ์ข้อ6
 * @property int|null $pe7 เกณฑ์ข้อ7
 * @property int|null $pe8 เกณฑ์ข้อ8
 * @property int|null $pe9 เกณฑ์ข้อ9
 * @property int|null $pe_huk หักคะแนน
 * @property string|null $NA6
 * @property string|null $Missing6
 * @property string|null $No6
 * @property int|null $pn1 ข้อ1
 * @property int|null $pn2 ข้อ2
 * @property int|null $pn3 ข้อ3
 * @property int|null $pn4 ข้อ4
 * @property int|null $pn5 ข้อ5
 * @property int|null $pn6 เกณฑ์ข้อ6
 * @property int|null $pn7 เกณฑ์ข้อ7
 * @property int|null $pn8 เกณฑ์ข้อ8
 * @property int|null $pn9 เกณฑ์ข้อ9
 * @property int|null $pn_huk หักคะแนน
 * @property string|null $NA7
 * @property string|null $Missing7
 * @property string|null $No7
 * @property int|null $cr1 ข้อ1
 * @property int|null $cr2 ข้อ2
 * @property int|null $cr3 ข้อ3
 * @property int|null $cr4 ข้อ4
 * @property int|null $cr5 ข้อ5
 * @property int|null $cr6 เกณฑ์ข้อ6
 * @property int|null $cr7 เกณฑ์ข้อ7
 * @property int|null $cr8 เกณฑ์ข้อ8
 * @property int|null $cr9 เกณฑ์ข้อ9
 * @property int|null $cr_huk หักคะแนน
 * @property string|null $NA8
 * @property string|null $Missing8
 * @property string|null $No8
 * @property int|null $ar1 ข้อ1
 * @property int|null $ar2 ข้อ2
 * @property int|null $ar3 ข้อ3
 * @property int|null $ar4 ข้อ4
 * @property int|null $ar5 ข้อ5
 * @property int|null $ar6 เกณฑ์ข้อ6
 * @property int|null $ar7 เกณฑ์ข้อ7
 * @property int|null $ar8 เกณฑ์ข้อ8
 * @property int|null $ar9 เกณฑ์ข้อ9
 * @property int|null $ar_huk หักคะแนน
 * @property string|null $NA9
 * @property string|null $Missing9
 * @property string|null $No9
 * @property int|null $on1 ข้อ1
 * @property int|null $on2 ข้อ2
 * @property int|null $on3 ข้อ3
 * @property int|null $on4 ข้อ4
 * @property int|null $on5 ข้อ5
 * @property int|null $on6 เกณฑ์ข้อ6
 * @property int|null $on7 เกณฑ์ข้อ7
 * @property int|null $on8 เกณฑ์ข้อ8
 * @property int|null $on9 เกณฑ์ข้อ9
 * @property int|null $on_huk หักคะแนน
 * @property string|null $NA10
 * @property string|null $Missing10
 * @property string|null $No10
 * @property int|null $lr1 ข้อ1
 * @property int|null $lr2 ข้อ2
 * @property int|null $lr3 ข้อ3
 * @property int|null $lr4 ข้อ4
 * @property int|null $lr5 ข้อ5
 * @property int|null $lr6 เกณฑ์ข้อ6
 * @property int|null $lr7 เกณฑ์ข้อ7
 * @property int|null $lr8 เกณฑ์ข้อ8
 * @property int|null $lr9 เกณฑ์ข้อ9
 * @property int|null $lr_huk หักคะแนน
 * @property string|null $NA11
 * @property string|null $Missing11
 * @property string|null $No11
 * @property int|null $rr1 ข้อ1
 * @property int|null $rr2 ข้อ2
 * @property int|null $rr3 ข้อ3
 * @property int|null $rr4 ข้อ4
 * @property int|null $rr5 ข้อ5
 * @property int|null $rr6 เกณฑ์ข้อ6
 * @property int|null $rr7 เกณฑ์ข้อ7
 * @property int|null $rr8 เกณฑ์ข้อ8
 * @property int|null $rr9 เกณฑ์ข้อ9
 * @property int|null $rr_huk หักคะแนน
 * @property string|null $NA12
 * @property string|null $Missing12
 * @property string|null $No12
 * @property int|null $nn1 ข้อ1
 * @property int|null $nn2 ข้อ2
 * @property int|null $nn3 ข้อ3
 * @property int|null $nn4 ข้อ4
 * @property int|null $nn5 ข้อ5
 * @property int|null $nn6 เกณฑ์ข้อ6
 * @property int|null $nn7 เกณฑ์ข้อ7
 * @property int|null $nn8 เกณฑ์ข้อ8
 * @property int|null $nn9 เกณฑ์ข้อ9
 * @property int|null $nn_huk หักคะแนน
 * @property string|null $hospcode รหัสโรงพยาบาล
 *
 * @property MraDepartmetns $unit
 */
class Mraipd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mra_ipd';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_mra');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_id', 'dxop1', 'dxop2', 'dxop3', 'dxop4', 'dxop5', 'dxop6', 'dxop7', 'dxop8', 'dxop9', 'dxop_huk', 'other1', 'other2', 'other3', 'other4', 'other5', 'other6', 'other7', 'other8', 'other9', 'other_huk', 'infc1', 'infc2', 'infc3', 'infc4', 'infc5', 'infc6', 'infc7', 'infc8', 'infc9', 'infc_huk', 'hist1', 'hist2', 'hist3', 'hist4', 'hist5', 'hist6', 'hist7', 'hist8', 'hist9', 'hist_huk', 'pe1', 'pe2', 'pe3', 'pe4', 'pe5', 'pe6', 'pe7', 'pe8', 'pe9', 'pe_huk', 'pn1', 'pn2', 'pn3', 'pn4', 'pn5', 'pn6', 'pn7', 'pn8', 'pn9', 'pn_huk', 'cr1', 'cr2', 'cr3', 'cr4', 'cr5', 'cr6', 'cr7', 'cr8', 'cr9', 'cr_huk', 'ar1', 'ar2', 'ar3', 'ar4', 'ar5', 'ar6', 'ar7', 'ar8', 'ar9', 'ar_huk', 'on1', 'on2', 'on3', 'on4', 'on5', 'on6', 'on7', 'on8', 'on9', 'on_huk', 'lr1', 'lr2', 'lr3', 'lr4', 'lr5', 'lr6', 'lr7', 'lr8', 'lr9', 'lr_huk', 'rr1', 'rr2', 'rr3', 'rr4', 'rr5', 'rr6', 'rr7', 'rr8', 'rr9', 'rr_huk', 'nn1', 'nn2', 'nn3', 'nn4', 'nn5', 'nn6', 'nn7', 'nn8', 'nn9', 'nn_huk'], 'integer'],
            [['date_admit', 'date_discharge', 'date_audit'], 'safe'],
            [['HN', 'AN'], 'string', 'max' => 10],
            [['dr_license'], 'string', 'max' => 7],
            [['NA1', 'NA2', 'NA3', 'NA4', 'NA5', 'NA6', 'NA7', 'NA8', 'NA9', 'NA10', 'NA11', 'NA12'], 'string', 'max' => 2],
            [['Missing1', 'No1', 'Missing2', 'No2', 'Missing3', 'No3', 'Missing4', 'No4', 'Missing5', 'No5', 'Missing6', 'No6', 'Missing7', 'No7', 'Missing8', 'No8', 'Missing9', 'No9', 'Missing10', 'No10', 'Missing11', 'No11', 'Missing12', 'No12'], 'string', 'max' => 1],
            [['hospcode'], 'string', 'max' => 5],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => MraDepartmetns::className(), 'targetAttribute' => ['unit_id' => 'unit_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mra_id' => 'Mra ID',
            'unit_id' => 'Unit ID',
            'HN' => 'Hn',
            'AN' => 'An',
            'dr_license' => 'Dr License',
            'date_admit' => 'Date Admit',
            'date_discharge' => 'Date Discharge',
            'date_audit' => 'Date Audit',
            'NA1' => 'Na1',
            'Missing1' => 'Missing1',
            'No1' => 'No1',
            'dxop1' => 'Dxop1',
            'dxop2' => 'Dxop2',
            'dxop3' => 'Dxop3',
            'dxop4' => 'Dxop4',
            'dxop5' => 'Dxop5',
            'dxop6' => 'Dxop6',
            'dxop7' => 'Dxop7',
            'dxop8' => 'Dxop8',
            'dxop9' => 'Dxop9',
            'dxop_huk' => 'Dxop Huk',
            'NA2' => 'Na2',
            'Missing2' => 'Missing2',
            'No2' => 'No2',
            'other1' => 'Other1',
            'other2' => 'Other2',
            'other3' => 'Other3',
            'other4' => 'Other4',
            'other5' => 'Other5',
            'other6' => 'Other6',
            'other7' => 'Other7',
            'other8' => 'Other8',
            'other9' => 'Other9',
            'other_huk' => 'Other Huk',
            'NA3' => 'Na3',
            'Missing3' => 'Missing3',
            'No3' => 'No3',
            'infc1' => 'Infc1',
            'infc2' => 'Infc2',
            'infc3' => 'Infc3',
            'infc4' => 'Infc4',
            'infc5' => 'Infc5',
            'infc6' => 'Infc6',
            'infc7' => 'Infc7',
            'infc8' => 'Infc8',
            'infc9' => 'Infc9',
            'infc_huk' => 'Infc Huk',
            'NA4' => 'Na4',
            'Missing4' => 'Missing4',
            'No4' => 'No4',
            'hist1' => 'Hist1',
            'hist2' => 'Hist2',
            'hist3' => 'Hist3',
            'hist4' => 'Hist4',
            'hist5' => 'Hist5',
            'hist6' => 'Hist6',
            'hist7' => 'Hist7',
            'hist8' => 'Hist8',
            'hist9' => 'Hist9',
            'hist_huk' => 'Hist Huk',
            'NA5' => 'Na5',
            'Missing5' => 'Missing5',
            'No5' => 'No5',
            'pe1' => 'Pe1',
            'pe2' => 'Pe2',
            'pe3' => 'Pe3',
            'pe4' => 'Pe4',
            'pe5' => 'Pe5',
            'pe6' => 'Pe6',
            'pe7' => 'Pe7',
            'pe8' => 'Pe8',
            'pe9' => 'Pe9',
            'pe_huk' => 'Pe Huk',
            'NA6' => 'Na6',
            'Missing6' => 'Missing6',
            'No6' => 'No6',
            'pn1' => 'Pn1',
            'pn2' => 'Pn2',
            'pn3' => 'Pn3',
            'pn4' => 'Pn4',
            'pn5' => 'Pn5',
            'pn6' => 'Pn6',
            'pn7' => 'Pn7',
            'pn8' => 'Pn8',
            'pn9' => 'Pn9',
            'pn_huk' => 'Pn Huk',
            'NA7' => 'Na7',
            'Missing7' => 'Missing7',
            'No7' => 'No7',
            'cr1' => 'Cr1',
            'cr2' => 'Cr2',
            'cr3' => 'Cr3',
            'cr4' => 'Cr4',
            'cr5' => 'Cr5',
            'cr6' => 'Cr6',
            'cr7' => 'Cr7',
            'cr8' => 'Cr8',
            'cr9' => 'Cr9',
            'cr_huk' => 'Cr Huk',
            'NA8' => 'Na8',
            'Missing8' => 'Missing8',
            'No8' => 'No8',
            'ar1' => 'Ar1',
            'ar2' => 'Ar2',
            'ar3' => 'Ar3',
            'ar4' => 'Ar4',
            'ar5' => 'Ar5',
            'ar6' => 'Ar6',
            'ar7' => 'Ar7',
            'ar8' => 'Ar8',
            'ar9' => 'Ar9',
            'ar_huk' => 'Ar Huk',
            'NA9' => 'Na9',
            'Missing9' => 'Missing9',
            'No9' => 'No9',
            'on1' => 'On1',
            'on2' => 'On2',
            'on3' => 'On3',
            'on4' => 'On4',
            'on5' => 'On5',
            'on6' => 'On6',
            'on7' => 'On7',
            'on8' => 'On8',
            'on9' => 'On9',
            'on_huk' => 'On Huk',
            'NA10' => 'Na10',
            'Missing10' => 'Missing10',
            'No10' => 'No10',
            'lr1' => 'Lr1',
            'lr2' => 'Lr2',
            'lr3' => 'Lr3',
            'lr4' => 'Lr4',
            'lr5' => 'Lr5',
            'lr6' => 'Lr6',
            'lr7' => 'Lr7',
            'lr8' => 'Lr8',
            'lr9' => 'Lr9',
            'lr_huk' => 'Lr Huk',
            'NA11' => 'Na11',
            'Missing11' => 'Missing11',
            'No11' => 'No11',
            'rr1' => 'Rr1',
            'rr2' => 'Rr2',
            'rr3' => 'Rr3',
            'rr4' => 'Rr4',
            'rr5' => 'Rr5',
            'rr6' => 'Rr6',
            'rr7' => 'Rr7',
            'rr8' => 'Rr8',
            'rr9' => 'Rr9',
            'rr_huk' => 'Rr Huk',
            'NA12' => 'Na12',
            'Missing12' => 'Missing12',
            'No12' => 'No12',
            'nn1' => 'Nn1',
            'nn2' => 'Nn2',
            'nn3' => 'Nn3',
            'nn4' => 'Nn4',
            'nn5' => 'Nn5',
            'nn6' => 'Nn6',
            'nn7' => 'Nn7',
            'nn8' => 'Nn8',
            'nn9' => 'Nn9',
            'nn_huk' => 'Nn Huk',
            'hospcode' => 'Hospcode',
        ];
    }

    /**
     * Gets query for [[Unit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(MraDepartmetns::className(), ['unit_id' => 'unit_id']);
    }
}
