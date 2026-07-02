<?php

namespace app\models;

use Yii;
use app\models\Mradepartmetnsipd;

/**
 * This is the model class for table "mra_ipd".
 *
 * @property int $mra_id
 * @property int $unit_id
 * @property int $overall_id
 * @property int $finding_id
 * @property string $visits
 * @property string $note
 * @property string $HN เลขโรงพยาบาล
 * @property string $AN เลขผู้ป่วยใน
 * @property string $dr_license เลข ว แพทย์
 * @property string $date_admit วันเข้ารักษา
 * @property string $date_discharge วันออกโรงพยาบาล
 * @property string $date_audit วันตรวจเวชระเบียน
 * @property string $NA1
 * @property string $Missing1
 * @property string $No1
 * @property int $dxop1 dxopข้อ1
 * @property string $dxop2 เกณฑ์ข้อ2
 * @property string $dxop3 เกณฑ์ข้อ3
 * @property string $dxop4 เกณฑ์ข้อ4
 * @property int $dxop5 เกณฑ์ข้อ5
 * @property int $dxop6 เกณฑ์ข้อ6
 * @property string $dxop7 เกณฑ์ข้อ7
 * @property int $dxop8 เกณฑ์ข้อ8
 * @property int $dxop9 เกณฑ์ข้อ9
 * @property int $dxop_huk หักคะแนน
 * @property string $NA2
 * @property string $Missing2
 * @property string $No2
 * @property int $other1 ข้อ1
 * @property int $other2 ข้อ2
 * @property int $other3 ข้อ3
 * @property int $other4 ข้อ4
 * @property int $other5 ข้อ5
 * @property int $other6 เกณฑ์ข้อ6
 * @property int $other7 เกณฑ์ข้อ7
 * @property string $other8 เกณฑ์ข้อ8
 * @property string $other9 เกณฑ์ข้อ9
 * @property int $other_huk หักคะแนน
 * @property string $NA3
 * @property string $Missing3
 * @property string $No3
 * @property int $infc1 ข้อ1
 * @property int $infc2 ข้อ2
 * @property int $infc3 ข้อ3
 * @property int $infc4 ข้อ4
 * @property int $infc5 ข้อ5
 * @property int $infc6 เกณฑ์ข้อ6
 * @property int $infc7 เกณฑ์ข้อ7
 * @property int $infc8 เกณฑ์ข้อ8
 * @property int $infc9 เกณฑ์ข้อ9
 * @property int $infc_huk หักคะแนน
 * @property string $NA4
 * @property string $Missing4
 * @property string $No4
 * @property int $hist1 ข้อ1
 * @property int $hist2 ข้อ2
 * @property int $hist3 ข้อ3
 * @property int $hist4 ข้อ4
 * @property int $hist5 ข้อ5
 * @property int $hist6 เกณฑ์ข้อ6
 * @property int $hist7 เกณฑ์ข้อ7
 * @property int $hist8 เกณฑ์ข้อ8
 * @property int $hist9 เกณฑ์ข้อ9
 * @property int $hist_huk หักคะแนน
 * @property string $NA5
 * @property string $Missing5
 * @property string $No5
 * @property int $pe1 ข้อ1
 * @property int $pe2 ข้อ2
 * @property int $pe3 ข้อ3
 * @property string $pe4 ข้อ4
 * @property int $pe5 ข้อ5
 * @property int $pe6 เกณฑ์ข้อ6
 * @property string $pe7 เกณฑ์ข้อ7
 * @property int $pe8 เกณฑ์ข้อ8
 * @property int $pe9 เกณฑ์ข้อ9
 * @property int $pe_huk หักคะแนน
 * @property string $NA6
 * @property string $Missing6
 * @property string $No6
 * @property int $pn1 ข้อ1
 * @property int $pn2 ข้อ2
 * @property int $pn3 ข้อ3
 * @property int $pn4 ข้อ4
 * @property int $pn5 ข้อ5
 * @property int $pn6 เกณฑ์ข้อ6
 * @property int $pn7 เกณฑ์ข้อ7
 * @property int $pn8 เกณฑ์ข้อ8
 * @property int $pn9 เกณฑ์ข้อ9
 * @property int $pn_huk หักคะแนน
 * @property string $NA7
 * @property string $Missing7
 * @property string $No7
 * @property string $cr1 ข้อ1
 * @property string $cr2 ข้อ2
 * @property string $cr3 ข้อ3
 * @property string $cr4 ข้อ4
 * @property string $cr5 ข้อ5
 * @property string $cr6 เกณฑ์ข้อ6
 * @property string $cr7 เกณฑ์ข้อ7
 * @property string $cr8 เกณฑ์ข้อ8
 * @property string $cr9 เกณฑ์ข้อ9
 * @property string $cr_huk หักคะแนน
 * @property string $NA8
 * @property string $Missing8
 * @property string $No8
 * @property string $ar1 ข้อ1
 * @property string $ar2 ข้อ2
 * @property string $ar3 ข้อ3
 * @property string $ar4 ข้อ4
 * @property string $ar5 ข้อ5
 * @property string $ar6 เกณฑ์ข้อ6
 * @property string $ar7 เกณฑ์ข้อ7
 * @property string $ar8 เกณฑ์ข้อ8
 * @property string $ar9 เกณฑ์ข้อ9
 * @property int $ar_huk หักคะแนน
 * @property string $NA9
 * @property string $Missing9
 * @property string $No9
 * @property string $on1 ข้อ1
 * @property string $on2 ข้อ2
 * @property string $on3 ข้อ3
 * @property string $on4 ข้อ4
 * @property string $on5 ข้อ5
 * @property string $on6 เกณฑ์ข้อ6
 * @property string $on7 เกณฑ์ข้อ7
 * @property string $on8 เกณฑ์ข้อ8
 * @property string $on9 เกณฑ์ข้อ9
 * @property int $on_huk หักคะแนน
 * @property string $NA10
 * @property string $Missing10
 * @property string $No10
 * @property string $lr1 ข้อ1
 * @property string $lr2 ข้อ2
 * @property string $lr3 ข้อ3
 * @property string $lr4 ข้อ4
 * @property string $lr5 ข้อ5
 * @property string $lr6 เกณฑ์ข้อ6
 * @property string $lr7 เกณฑ์ข้อ7
 * @property string $lr8 เกณฑ์ข้อ8
 * @property string $lr9 เกณฑ์ข้อ9
 * @property int $lr_huk หักคะแนน
 * @property string $NA11
 * @property string $Missing11
 * @property string $No11
 * @property int $rr1 ข้อ1
 * @property int $rr2 ข้อ2
 * @property int $rr3 ข้อ3
 * @property int $rr4 ข้อ4
 * @property int $rr5 ข้อ5
 * @property int $rr6 เกณฑ์ข้อ6
 * @property int $rr7 เกณฑ์ข้อ7
 * @property int $rr8 เกณฑ์ข้อ8
 * @property int $rr9 เกณฑ์ข้อ9
 * @property int $rr_huk หักคะแนน
 * @property string $NA12
 * @property string $Missing12
 * @property string $No12
 * @property int $nn1 ข้อ1
 * @property string $nn2 ข้อ2
 * @property string $nn3 ข้อ3
 * @property string $nn4 ข้อ4
 * @property int $nn5 ข้อ5
 * @property int $nn6 เกณฑ์ข้อ6
 * @property string $nn7 เกณฑ์ข้อ7
 * @property int $nn8 เกณฑ์ข้อ8
 * @property int $nn9 เกณฑ์ข้อ9
 * @property int $nn_huk หักคะแนน
 * @property string $hospcode รหัสโรงพยาบาล
 *
 * @property MraDepartmetnsIpd $unit
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
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_id', 'overall_id', 'finding_id', 'dxop1', 'dxop5', 'dxop6', 'dxop8', 'dxop9', 'dxop_huk', 'other1', 'other2', 'other3', 'other4', 'other5', 'other6', 'other7', 'other_huk', 'infc1', 'infc2', 'infc3', 'infc4', 'infc5', 'infc6', 'infc7', 'infc8', 'infc9', 'infc_huk', 'hist1', 'hist2', 'hist3', 'hist4', 'hist5', 'hist6', 'hist7', 'hist8', 'hist9', 'hist_huk', 'pe1', 'pe2', 'pe3', 'pe5', 'pe6', 'pe8', 'pe9', 'pe_huk', 'pn1', 'pn2', 'pn3', 'pn4', 'pn5', 'pn6', 'pn7', 'pn8', 'pn9', 'pn_huk', 'ar_huk', 'on_huk', 'lr_huk', 'rr1', 'rr2', 'rr3', 'rr4', 'rr5', 'rr6', 'rr7', 'rr8', 'rr9', 'rr_huk', 'nn1', 'nn5', 'nn6', 'nn8', 'nn9', 'nn_huk'], 'integer'],
            [['note'], 'string'],
            [['HN', 'AN'], 'required'],
            [['date_admit', 'date_discharge', 'date_audit'], 'safe'],
            [['visits', 'Missing1', 'No1', 'Missing2', 'No2', 'other8', 'other9', 'Missing3', 'No3', 'Missing4', 'No4', 'Missing5', 'No5', 'Missing6', 'No6', 'Missing7', 'No7', 'cr1', 'cr2', 'cr3', 'cr4', 'cr5', 'cr6', 'cr7', 'cr8', 'cr9', 'cr_huk', 'Missing8', 'No8', 'ar1', 'ar2', 'ar3', 'ar4', 'ar5', 'ar6', 'ar7', 'ar8', 'ar9', 'Missing9', 'No9', 'on1', 'on2', 'on3', 'on4', 'on5', 'on6', 'on7', 'on8', 'on9', 'Missing10', 'No10', 'lr1', 'lr2', 'lr3', 'lr4', 'lr5', 'lr6', 'lr7', 'lr8', 'lr9', 'Missing11', 'No11', 'Missing12', 'No12'], 'string', 'max' => 1],
            [['HN', 'AN'], 'string', 'max' => 10],
            [['dr_license'], 'string', 'max' => 7],
            [['NA1', 'dxop2', 'dxop3', 'dxop4', 'dxop7', 'NA2', 'NA3', 'NA4', 'NA5', 'pe4', 'pe7', 'NA6', 'NA7', 'NA8', 'NA9', 'NA10', 'NA11', 'NA12', 'nn2', 'nn3', 'nn4', 'nn7'], 'string', 'max' => 2],
            [['hospcode'], 'string', 'max' => 5],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mradepartmetnsipd::className(), 'targetAttribute' => ['unit_id' => 'unit_id']],
            [['overall_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mraoverall::className(), 'targetAttribute' => ['overall_id' => 'overall_id']],
            [['finding_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mrafinding::className(), 'targetAttribute' => ['finding_id' => 'finding_id']],
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
            'overall_id' => 'Overall ID',
            'finding_id' => 'Finding ID',
            'visits' => 'Visits',
            'note' => 'Note',
            'HN' => 'Hn',
            'AN' => 'An',
            'dr_license' => 'Dr License',
            'date_admit' => 'Date Admit',
            'date_discharge' => 'Date Discharge',
            'date_audit' => 'Date Audit',
            'NA1' => 'Na 1',
            'Missing1' => 'Missing 1',
            'No1' => 'No 1',
            'dxop1' => 'Dxop 1',
            'dxop2' => 'Dxop 2',
            'dxop3' => 'Dxop 3',
            'dxop4' => 'Dxop 4',
            'dxop5' => 'Dxop 5',
            'dxop6' => 'Dxop 6',
            'dxop7' => 'Dxop 7',
            'dxop8' => 'Dxop 8',
            'dxop9' => 'Dxop 9',
            'dxop_huk' => 'Dxop Huk',
            'NA2' => 'Na 2',
            'Missing2' => 'Missing 2',
            'No2' => 'No 2',
            'other1' => 'Other 1',
            'other2' => 'Other 2',
            'other3' => 'Other 3',
            'other4' => 'Other 4',
            'other5' => 'Other 5',
            'other6' => 'Other 6',
            'other7' => 'Other 7',
            'other8' => 'Other 8',
            'other9' => 'Other 9',
            'other_huk' => 'Other Huk',
            'NA3' => 'Na 3',
            'Missing3' => 'Missing 3',
            'No3' => 'No 3',
            'infc1' => 'Infc 1',
            'infc2' => 'Infc 2',
            'infc3' => 'Infc 3',
            'infc4' => 'Infc 4',
            'infc5' => 'Infc 5',
            'infc6' => 'Infc 6',
            'infc7' => 'Infc 7',
            'infc8' => 'Infc 8',
            'infc9' => 'Infc 9',
            'infc_huk' => 'Infc Huk',
            'NA4' => 'Na 4',
            'Missing4' => 'Missing 4',
            'No4' => 'No 4',
            'hist1' => 'Hist 1',
            'hist2' => 'Hist 2',
            'hist3' => 'Hist 3',
            'hist4' => 'Hist 4',
            'hist5' => 'Hist 5',
            'hist6' => 'Hist 6',
            'hist7' => 'Hist 7',
            'hist8' => 'Hist 8',
            'hist9' => 'Hist 9',
            'hist_huk' => 'Hist Huk',
            'NA5' => 'Na 5',
            'Missing5' => 'Missing 5',
            'No5' => 'No 5',
            'pe1' => 'Pe 1',
            'pe2' => 'Pe 2',
            'pe3' => 'Pe 3',
            'pe4' => 'Pe 4',
            'pe5' => 'Pe 5',
            'pe6' => 'Pe 6',
            'pe7' => 'Pe 7',
            'pe8' => 'Pe 8',
            'pe9' => 'Pe 9',
            'pe_huk' => 'Pe Huk',
            'NA6' => 'Na 6',
            'Missing6' => 'Missing 6',
            'No6' => 'No 6',
            'pn1' => 'Pn 1',
            'pn2' => 'Pn 2',
            'pn3' => 'Pn 3',
            'pn4' => 'Pn 4',
            'pn5' => 'Pn 5',
            'pn6' => 'Pn 6',
            'pn7' => 'Pn 7',
            'pn8' => 'Pn 8',
            'pn9' => 'Pn 9',
            'pn_huk' => 'Pn Huk',
            'NA7' => 'Na 7',
            'Missing7' => 'Missing 7',
            'No7' => 'No 7',
            'cr1' => 'Cr 1',
            'cr2' => 'Cr 2',
            'cr3' => 'Cr 3',
            'cr4' => 'Cr 4',
            'cr5' => 'Cr 5',
            'cr6' => 'Cr 6',
            'cr7' => 'Cr 7',
            'cr8' => 'Cr 8',
            'cr9' => 'Cr 9',
            'cr_huk' => 'Cr Huk',
            'NA8' => 'Na 8',
            'Missing8' => 'Missing 8',
            'No8' => 'No 8',
            'ar1' => 'Ar 1',
            'ar2' => 'Ar 2',
            'ar3' => 'Ar 3',
            'ar4' => 'Ar 4',
            'ar5' => 'Ar 5',
            'ar6' => 'Ar 6',
            'ar7' => 'Ar 7',
            'ar8' => 'Ar 8',
            'ar9' => 'Ar 9',
            'ar_huk' => 'Ar Huk',
            'NA9' => 'Na 9',
            'Missing9' => 'Missing 9',
            'No9' => 'No 9',
            'on1' => 'On 1',
            'on2' => 'On 2',
            'on3' => 'On 3',
            'on4' => 'On 4',
            'on5' => 'On 5',
            'on6' => 'On 6',
            'on7' => 'On 7',
            'on8' => 'On 8',
            'on9' => 'On 9',
            'on_huk' => 'On Huk',
            'NA10' => 'Na 10',
            'Missing10' => 'Missing 10',
            'No10' => 'No 10',
            'lr1' => 'Lr 1',
            'lr2' => 'Lr 2',
            'lr3' => 'Lr 3',
            'lr4' => 'Lr 4',
            'lr5' => 'Lr 5',
            'lr6' => 'Lr 6',
            'lr7' => 'Lr 7',
            'lr8' => 'Lr 8',
            'lr9' => 'Lr 9',
            'lr_huk' => 'Lr Huk',
            'NA11' => 'Na 11',
            'Missing11' => 'Missing 11',
            'No11' => 'No 11',
            'rr1' => 'Rr 1',
            'rr2' => 'Rr 2',
            'rr3' => 'Rr 3',
            'rr4' => 'Rr 4',
            'rr5' => 'Rr 5',
            'rr6' => 'Rr 6',
            'rr7' => 'Rr 7',
            'rr8' => 'Rr 8',
            'rr9' => 'Rr 9',
            'rr_huk' => 'Rr Huk',
            'NA12' => 'Na 12',
            'Missing12' => 'Missing 12',
            'No12' => 'No 12',
            'nn1' => 'Nn 1',
            'nn2' => 'Nn 2',
            'nn3' => 'Nn 3',
            'nn4' => 'Nn 4',
            'nn5' => 'Nn 5',
            'nn6' => 'Nn 6',
            'nn7' => 'Nn 7',
            'nn8' => 'Nn 8',
            'nn9' => 'Nn 9',
            'nn_huk' => 'Nn Huk',
            'hospcode' => 'Hospcode',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(MraDepartmetnsIpd::className(), ['unit_id' => 'unit_id']);
    }
    public function getOverall()
    {
        return $this->hasOne(Mraoverall::className(), ['overall_id' => 'overall_name']);
    }
    public function getFinding()
    {
        return $this->hasOne(Mrafinding::className(), ['finding_id' => 'finding_name']);
    }
}
//yii2 radio button
