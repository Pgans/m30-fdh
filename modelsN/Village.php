<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%village}}".
 *
 * @property string $hospcode
 * @property string $vid
 * @property string $ntraditional
 * @property string $nmonk
 * @property string $nreligionleader
 * @property string $nbroadcast
 * @property string $nradio
 * @property string $npchc
 * @property string $nclinic
 * @property string $ndrugstore
 * @property string $nchildcenter
 * @property string $npschool
 * @property string $nsschool
 * @property string $ntemple
 * @property string $nreligiousplace
 * @property string $nmarket
 * @property string $nshop
 * @property string $nfoodshop
 * @property string $nstall
 * @property string $nraintank
 * @property string $nchickenfarm
 * @property string $npigfarm
 * @property string $wastewater
 * @property string $garbage
 * @property string $nfactory
 * @property string $latitude
 * @property string $longitude
 * @property string $outdate
 * @property string $numactually
 * @property string $risktype
 * @property string $numstateless
 * @property string $nexerciseclub
 * @property string $nolderlyclub
 * @property string $ndisableclub
 * @property string $nnumberoneclub
 * @property string $d_update
 */
class Village extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%village}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db943');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hospcode', 'vid', 'ntraditional', 'nmonk', 'nreligionleader', 'nbroadcast', 'nradio', 'npchc', 'nclinic', 'ndrugstore', 'nchildcenter', 'npschool', 'nsschool', 'ntemple', 'nreligiousplace', 'nmarket', 'nshop', 'nfoodshop', 'nstall', 'nraintank', 'nchickenfarm', 'npigfarm', 'wastewater', 'garbage', 'nfactory', 'latitude', 'longitude', 'outdate', 'numactually', 'risktype', 'numstateless', 'nexerciseclub', 'nolderlyclub', 'ndisableclub', 'nnumberoneclub', 'd_update'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hospcode' => 'Hospcode',
            'vid' => 'Vid',
            'ntraditional' => 'Ntraditional',
            'nmonk' => 'Nmonk',
            'nreligionleader' => 'Nreligionleader',
            'nbroadcast' => 'Nbroadcast',
            'nradio' => 'Nradio',
            'npchc' => 'Npchc',
            'nclinic' => 'Nclinic',
            'ndrugstore' => 'Ndrugstore',
            'nchildcenter' => 'Nchildcenter',
            'npschool' => 'Npschool',
            'nsschool' => 'Nsschool',
            'ntemple' => 'Ntemple',
            'nreligiousplace' => 'Nreligiousplace',
            'nmarket' => 'Nmarket',
            'nshop' => 'Nshop',
            'nfoodshop' => 'Nfoodshop',
            'nstall' => 'Nstall',
            'nraintank' => 'Nraintank',
            'nchickenfarm' => 'Nchickenfarm',
            'npigfarm' => 'Npigfarm',
            'wastewater' => 'Wastewater',
            'garbage' => 'Garbage',
            'nfactory' => 'Nfactory',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'outdate' => 'Outdate',
            'numactually' => 'Numactually',
            'risktype' => 'Risktype',
            'numstateless' => 'Numstateless',
            'nexerciseclub' => 'Nexerciseclub',
            'nolderlyclub' => 'Nolderlyclub',
            'ndisableclub' => 'Ndisableclub',
            'nnumberoneclub' => 'Nnumberoneclub',
            'd_update' => 'D Update',
        ];
    }
}
