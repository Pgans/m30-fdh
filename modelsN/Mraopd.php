<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mra_opd".
 *
 * @property int $mra_id
 * @property int $unit_id
 * @property int $overall_id
 * @property string $HN เลขโรงพยาบาล
 * @property string $visit ครั้งที่
 * @property string $note ครั้งที่
 * @property string $dr_license เลข ว แพทย์
 * @property string $date_admit วันเข้ารักษา
 * @property string $date_discharge วันออกโรงพยาบาล
 * @property string $date_audit วันตรวจเวชระเบียน
 * @property string $NA01
 * @property string $MI01
 * @property string $NO01
 * @property string $SC011 dxopข้อ1
 * @property string $SC012 เกณฑ์ข้อ2
 * @property string $SC013 เกณฑ์ข้อ3
 * @property string $SC014 เกณฑ์ข้อ4
 * @property string $SC015 เกณฑ์ข้อ5
 * @property string $SC016 เกณฑ์ข้อ6
 * @property string $SC017 เกณฑ์ข้อ7
 * @property string $SC018 เกณฑ์ข้อ8
 * @property string $SC019 เกณฑ์ข้อ9
 * @property string $PEIM01 หักคะแนน
 * @property string $DEC01
 * @property string $NA02
 * @property string $MI02
 * @property string $NO02
 * @property string $SC021 ข้อ1
 * @property string $SC022 ข้อ2
 * @property string $SC023 ข้อ3
 * @property string $SC024 ข้อ4
 * @property string $SC025 ข้อ5
 * @property string $SC026 เกณฑ์ข้อ6
 * @property string $SC027 เกณฑ์ข้อ7
 * @property string $SC028 เกณฑ์ข้อ8
 * @property string $SC029 เกณฑ์ข้อ9
 * @property string $PEIM02 หักคะแนน
 * @property string $DEC02
 * @property string $NA03
 * @property string $MI03
 * @property string $NO03
 * @property string $SC031 ข้อ1
 * @property string $SC032 ข้อ2
 * @property string $SC033 ข้อ3
 * @property string $SC034 ข้อ4
 * @property string $SC035 ข้อ5
 * @property string $SC036 เกณฑ์ข้อ6
 * @property string $SC037 เกณฑ์ข้อ7
 * @property string $SC038 เกณฑ์ข้อ8
 * @property string $SC039 เกณฑ์ข้อ9
 * @property string $PEIM03
 * @property string $DEC03 หักคะแนน
 * @property string $NA04
 * @property string $MI04
 * @property string $NO04
 * @property string $SC041 ข้อ1
 * @property string $SC042 ข้อ2
 * @property string $SC043 ข้อ3
 * @property string $SC044 ข้อ4
 * @property string $SC045 ข้อ5
 * @property string $SC046 เกณฑ์ข้อ6
 * @property string $SC047 เกณฑ์ข้อ7
 * @property string $SC048 เกณฑ์ข้อ8
 * @property string $SC049 เกณฑ์ข้อ9
 * @property string $PEIM04
 * @property string $DEC04 หักคะแนน
 * @property string $NA05
 * @property string $MI05
 * @property string $NO05
 * @property string $SC051 ข้อ1
 * @property string $SC052 ข้อ2
 * @property string $SC053 ข้อ3
 * @property string $SC054 ข้อ4
 * @property string $SC055 ข้อ5
 * @property string $SC056 เกณฑ์ข้อ6
 * @property string $SC057 เกณฑ์ข้อ7
 * @property string $SC058 เกณฑ์ข้อ8
 * @property string $SC059 เกณฑ์ข้อ9
 * @property string $PEIM05 หักคะแนน
 * @property string $DEC05 หักคะแนน
 * @property string $Followdate1
 * @property string $Followdate2
 * @property string $NA06
 * @property string $MI06
 * @property string $NO06
 * @property string $SC061 ข้อ1
 * @property string $SC062 ข้อ2
 * @property string $SC063 ข้อ3
 * @property string $SC064 ข้อ4
 * @property string $SC065 ข้อ5
 * @property string $SC066 เกณฑ์ข้อ6
 * @property string $SC067 เกณฑ์ข้อ7
 * @property string $SC068 เกณฑ์ข้อ8
 * @property string $SC069 เกณฑ์ข้อ9
 * @property string $PEIM06 หักคะแนน
 * @property string $DEC06 หักคะแนน
 * @property string $Followdate3
 * @property string $NA07
 * @property string $MI07
 * @property string $NO07
 * @property string $SC071 ข้อ1
 * @property string $SC072 ข้อ2
 * @property string $SC073 ข้อ3
 * @property string $SC074 ข้อ4
 * @property string $SC075 ข้อ5
 * @property string $SC076 เกณฑ์ข้อ6
 * @property string $SC077 เกณฑ์ข้อ7
 * @property string $SC078 เกณฑ์ข้อ8
 * @property string $SC079 เกณฑ์ข้อ9
 * @property string $PEIM07 หักคะแนน
 * @property string $DEC07 หักคะแนน
 * @property string $NA08
 * @property string $MI08
 * @property string $NO08
 * @property string $SC081 ข้อ1
 * @property string $SC082 ข้อ2
 * @property string $SC083 ข้อ3
 * @property string $SC084 ข้อ4
 * @property string $SC085 ข้อ5
 * @property string $SC086 เกณฑ์ข้อ6
 * @property string $SC087 เกณฑ์ข้อ7
 * @property string $SC088 เกณฑ์ข้อ8
 * @property string $SC089 เกณฑ์ข้อ9
 * @property string $PEIM08 หักคะแนน
 * @property string $DEC08 หักคะแนน
 * @property string $NA09
 * @property string $MI09
 * @property string $NO09
 * @property string $SC091 ข้อ1
 * @property string $SC092 ข้อ2
 * @property string $SC093 ข้อ3
 * @property string $SC094 ข้อ4
 * @property string $SC095 ข้อ5
 * @property string $SC096 เกณฑ์ข้อ6
 * @property string $SC097 เกณฑ์ข้อ7
 * @property string $SC098 เกณฑ์ข้อ8
 * @property string $SC099 เกณฑ์ข้อ9
 * @property string $PEIM09 หักคะแนน
 * @property string $DEC09 หักคะแนน
 * @property string $NA10
 * @property string $MI10
 * @property string $NO10
 * @property string $SC101 ข้อ1
 * @property string $SC102 ข้อ2
 * @property string $SC103 ข้อ3
 * @property string $SC104 ข้อ4
 * @property string $SC105 ข้อ5
 * @property string $SC106 เกณฑ์ข้อ6
 * @property string $SC107 เกณฑ์ข้อ7
 * @property string $SC108 เกณฑ์ข้อ8
 * @property string $SC109 เกณฑ์ข้อ9
 * @property string $PEIM10 หักคะแนน
 * @property string $DEC10 หักคะแนน
 * @property string $hospcode รหัสโรงพยาบาล
 *
 * @property MraDepartmetnsOpd $unit
 */
class Mraopd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mra_opd';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_id', 'overall_id', 'HN'], 'required'],
            [['unit_id', 'overall_id'], 'integer'],
            [['note'], 'string'],
            [['date_admit', 'date_discharge', 'date_audit', 'Followdate1', 'Followdate2', 'Followdate3'], 'safe'],
            [['HN', 'visit'], 'string', 'max' => 10],
            [['dr_license'], 'string', 'max' => 7],
            [['NA01', 'SC012', 'SC013', 'SC014', 'SC017', 'NA02', 'NA03', 'NA04', 'NA05', 'SC054', 'SC057', 'NA06', 'NA07', 'NA08', 'NA09', 'NA10'], 'string', 'max' => 2],
            [['MI01', 'NO01', 'SC011', 'SC015', 'SC016', 'SC018', 'SC019', 'PEIM01', 'DEC01', 'MI02', 'NO02', 'SC021', 'SC022', 'SC023', 'SC024', 'SC025', 'SC026', 'SC027', 'SC028', 'SC029', 'PEIM02', 'DEC02', 'MI03', 'NO03', 'SC031', 'SC032', 'SC033', 'SC034', 'SC035', 'SC036', 'SC037', 'SC038', 'SC039', 'PEIM03', 'DEC03', 'MI04', 'NO04', 'SC041', 'SC042', 'SC043', 'SC044', 'SC045', 'SC046', 'SC047', 'SC048', 'SC049', 'PEIM04', 'DEC04', 'MI05', 'NO05', 'SC051', 'SC052', 'SC053', 'SC055', 'SC056', 'SC058', 'SC059', 'PEIM05', 'DEC05', 'MI06', 'NO06', 'SC061', 'SC062', 'SC063', 'SC064', 'SC065', 'SC066', 'SC067', 'SC068', 'SC069', 'PEIM06', 'DEC06', 'MI07', 'NO07', 'SC071', 'SC072', 'SC073', 'SC074', 'SC075', 'SC076', 'SC077', 'SC078', 'SC079', 'PEIM07', 'DEC07', 'MI08', 'NO08', 'SC081', 'SC082', 'SC083', 'SC084', 'SC085', 'SC086', 'SC087', 'SC088', 'SC089', 'PEIM08', 'DEC08', 'MI09', 'NO09', 'SC091', 'SC092', 'SC093', 'SC094', 'SC095', 'SC096', 'SC097', 'SC098', 'SC099', 'PEIM09', 'DEC09', 'MI10', 'NO10', 'SC101', 'SC102', 'SC103', 'SC104', 'SC105', 'SC106', 'SC107', 'SC108', 'SC109', 'PEIM10', 'DEC10'], 'string', 'max' => 1],
            [['hospcode'], 'string', 'max' => 5],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mradepartmetnsopd::className(), 'targetAttribute' => ['unit_id' => 'unit_id']],
			[['overall_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mraoverall::className(), 'targetAttribute' => ['overall_id' => 'overall_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mra_id' => 'Mra ID',
            'unit_id' => 'แผนก',
            'overall_id' => 'ประเมินคุณภาพเวชระเบียน',
            'HN' => 'HN',
            'visit' => 'ครั้งที่',
            'note' => 'หมายเหตุ..',
            'dr_license' => 'Dr License',
            'date_admit' => 'Date Admit',
            'date_discharge' => 'Date Discharge',
            'date_audit' => 'วันที่ Audit',
            'NA01' => 'Na 01',
            'MI01' => 'Mi 01',
            'NO01' => 'No 01',
            'SC011' => 'Sc 011',
            'SC012' => 'Sc 012',
            'SC013' => 'Sc 013',
            'SC014' => 'Sc 014',
            'SC015' => 'Sc 015',
            'SC016' => 'Sc 016',
            'SC017' => 'Sc 017',
            'SC018' => 'Sc 018',
            'SC019' => 'Sc 019',
            'PEIM01' => 'Peim 01',
            'DEC01' => 'Dec 01',
            'NA02' => 'Na 02',
            'MI02' => 'Mi 02',
            'NO02' => 'No 02',
            'SC021' => 'Sc 021',
            'SC022' => 'Sc 022',
            'SC023' => 'Sc 023',
            'SC024' => 'Sc 024',
            'SC025' => 'Sc 025',
            'SC026' => 'Sc 026',
            'SC027' => 'Sc 027',
            'SC028' => 'Sc 028',
            'SC029' => 'Sc 029',
            'PEIM02' => 'Peim 02',
            'DEC02' => 'Dec 02',
            'NA03' => 'Na 03',
            'MI03' => 'Mi 03',
            'NO03' => 'No 03',
            'SC031' => 'Sc 031',
            'SC032' => 'Sc 032',
            'SC033' => 'Sc 033',
            'SC034' => 'Sc 034',
            'SC035' => 'Sc 035',
            'SC036' => 'Sc 036',
            'SC037' => 'Sc 037',
            'SC038' => 'Sc 038',
            'SC039' => 'Sc 039',
            'PEIM03' => 'Peim 03',
            'DEC03' => 'Dec 03',
            'NA04' => 'Na 04',
            'MI04' => 'Mi 04',
            'NO04' => 'No 04',
            'SC041' => 'Sc 041',
            'SC042' => 'Sc 042',
            'SC043' => 'Sc 043',
            'SC044' => 'Sc 044',
            'SC045' => 'Sc 045',
            'SC046' => 'Sc 046',
            'SC047' => 'Sc 047',
            'SC048' => 'Sc 048',
            'SC049' => 'Sc 049',
            'PEIM04' => 'Peim 04',
            'DEC04' => 'Dec 04',
            'NA05' => 'Na 05',
            'MI05' => 'Mi 05',
            'NO05' => 'No 05',
            'SC051' => 'Sc 051',
            'SC052' => 'Sc 052',
            'SC053' => 'Sc 053',
            'SC054' => 'Sc 054',
            'SC055' => 'Sc 055',
            'SC056' => 'Sc 056',
            'SC057' => 'Sc 057',
            'SC058' => 'Sc 058',
            'SC059' => 'Sc 059',
            'PEIM05' => 'Peim 05',
            'DEC05' => 'Dec 05',
            'Followdate1' => 'Followdate 1',
            'Followdate2' => 'Followdate 2',
            'NA06' => 'Na 06',
            'MI06' => 'Mi 06',
            'NO06' => 'No 06',
            'SC061' => 'Sc 061',
            'SC062' => 'Sc 062',
            'SC063' => 'Sc 063',
            'SC064' => 'Sc 064',
            'SC065' => 'Sc 065',
            'SC066' => 'Sc 066',
            'SC067' => 'Sc 067',
            'SC068' => 'Sc 068',
            'SC069' => 'Sc 069',
            'PEIM06' => 'Peim 06',
            'DEC06' => 'Dec 06',
            'Followdate3' => 'Followdate 3',
            'NA07' => 'Na 07',
            'MI07' => 'Mi 07',
            'NO07' => 'No 07',
            'SC071' => 'Sc 071',
            'SC072' => 'Sc 072',
            'SC073' => 'Sc 073',
            'SC074' => 'Sc 074',
            'SC075' => 'Sc 075',
            'SC076' => 'Sc 076',
            'SC077' => 'Sc 077',
            'SC078' => 'Sc 078',
            'SC079' => 'Sc 079',
            'PEIM07' => 'Peim 07',
            'DEC07' => 'Dec 07',
            'NA08' => 'Na 08',
            'MI08' => 'Mi 08',
            'NO08' => 'No 08',
            'SC081' => 'Sc 081',
            'SC082' => 'Sc 082',
            'SC083' => 'Sc 083',
            'SC084' => 'Sc 084',
            'SC085' => 'Sc 085',
            'SC086' => 'Sc 086',
            'SC087' => 'Sc 087',
            'SC088' => 'Sc 088',
            'SC089' => 'Sc 089',
            'PEIM08' => 'Peim 08',
            'DEC08' => 'Dec 08',
            'NA09' => 'Na 09',
            'MI09' => 'Mi 09',
            'NO09' => 'No 09',
            'SC091' => 'Sc 091',
            'SC092' => 'Sc 092',
            'SC093' => 'Sc 093',
            'SC094' => 'Sc 094',
            'SC095' => 'Sc 095',
            'SC096' => 'Sc 096',
            'SC097' => 'Sc 097',
            'SC098' => 'Sc 098',
            'SC099' => 'Sc 099',
            'PEIM09' => 'Peim 09',
            'DEC09' => 'Dec 09',
            'NA10' => 'Na 10',
            'MI10' => 'Mi 10',
            'NO10' => 'No 10',
            'SC101' => 'Sc 101',
            'SC102' => 'Sc 102',
            'SC103' => 'Sc 103',
            'SC104' => 'Sc 104',
            'SC105' => 'Sc 105',
            'SC106' => 'Sc 106',
            'SC107' => 'Sc 107',
            'SC108' => 'Sc 108',
            'SC109' => 'Sc 109',
            'PEIM10' => 'Peim 10',
            'DEC10' => 'Dec 10',
            'hospcode' => 'Hospcode',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Mradepartmetnsopd::className(), ['unit_id' => 'unit_id']);
    }
	public function getOverall()
    {
        return $this->hasOne(Mraoverall::className(), ['overall_id' => 'overall_name']);
    }
}
