<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%ins}}".
 *
 * @property string $hn
 * @property string $inscl
 * @property string $subtype
 * @property string $cid
 * @property string $hcode
 * @property string $dateexp
 * @property string $hospmain
 * @property string $hospsub
 * @property string $govcode
 * @property string $govname
 * @property string $permitno
 * @property string $docno
 * @property string $ownrpid
 * @property string $ownname
 * @property string $an
 * @property string $seq
 * @property string $subinscl
 * @property string $relinscl
 * @property string $htype
 */
class Ins extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ins}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db16');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hn'], 'string', 'max' => 255],
            [['inscl', 'subtype', 'cid', 'hcode', 'dateexp', 'hospmain', 'hospsub', 'govcode', 'govname', 'permitno', 'docno', 'ownrpid', 'ownname', 'an', 'seq', 'subinscl', 'relinscl', 'htype'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hn' => 'Hn',
            'inscl' => 'Inscl',
            'subtype' => 'Subtype',
            'cid' => 'Cid',
            'hcode' => 'Hcode',
            'dateexp' => 'Dateexp',
            'hospmain' => 'Hospmain',
            'hospsub' => 'Hospsub',
            'govcode' => 'Govcode',
            'govname' => 'Govname',
            'permitno' => 'Permitno',
            'docno' => 'Docno',
            'ownrpid' => 'Ownrpid',
            'ownname' => 'Ownname',
            'an' => 'An',
            'seq' => 'Seq',
            'subinscl' => 'Subinscl',
            'relinscl' => 'Relinscl',
            'htype' => 'Htype',
        ];
    }
}
