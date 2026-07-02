<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mra_ipd_an".
 *
 * @property int $an_id
 * @property int $unit_id แผนก
 * @property string|null $HN เลขโรงพยาบาล
 * @property string|null $AN เลขผู้ป่วยใน
 * @property string|null $dr_license เลข ว แพทย์
 * @property string|null $date_admit วันเข้ารักษา
 * @property string|null $date_discharge วันออกโรงพยาบาล
 * @property string|null $date_audit วันตรวจเวชระเบียน
 *
 * @property MraDepartmetns $unit
 */
class Mraan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mra_ipd_an';
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
            [['unit_id'], 'required'],
            [['unit_id'], 'integer'],
            [['date_admit', 'date_discharge', 'date_audit'], 'safe'],
            [['HN', 'AN'], 'string', 'max' => 10],
            [['dr_license'], 'string', 'max' => 7],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => MraDepartmetns::className(), 'targetAttribute' => ['unit_id' => 'unit_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'an_id' => 'An ID',
            'unit_id' => 'Unit ID',
            'HN' => 'Hn',
            'AN' => 'An',
            'dr_license' => 'Dr License',
            'date_admit' => 'Date Admit',
            'date_discharge' => 'Date Discharge',
            'date_audit' => 'Date Audit',
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
