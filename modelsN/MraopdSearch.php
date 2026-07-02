<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mraopd;

/**
 * MraopdSearch represents the model behind the search form of `app\models\Mraopd`.
 */
class MraopdSearch extends Mraopd
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mra_id', 'unit_id', 'overall_id'], 'integer'],
            [['HN', 'visit', 'note', 'dr_license', 'date_admit', 'date_discharge', 'date_audit', 'NA01', 'MI01', 'NO01', 'SC011', 'SC012', 'SC013', 'SC014', 'SC015', 'SC016', 'SC017', 'SC018', 'SC019', 'PEIM01', 'DEC01', 'NA02', 'MI02', 'NO02', 'SC021', 'SC022', 'SC023', 'SC024', 'SC025', 'SC026', 'SC027', 'SC028', 'SC029', 'PEIM02', 'DEC02', 'NA03', 'MI03', 'NO03', 'SC031', 'SC032', 'SC033', 'SC034', 'SC035', 'SC036', 'SC037', 'SC038', 'SC039', 'PEIM03', 'DEC03', 'NA04', 'MI04', 'NO04', 'SC041', 'SC042', 'SC043', 'SC044', 'SC045', 'SC046', 'SC047', 'SC048', 'SC049', 'PEIM04', 'DEC04', 'NA05', 'MI05', 'NO05', 'SC051', 'SC052', 'SC053', 'SC054', 'SC055', 'SC056', 'SC057', 'SC058', 'SC059', 'PEIM05', 'DEC05', 'Followdate1', 'Followdate2', 'NA06', 'MI06', 'NO06', 'SC061', 'SC062', 'SC063', 'SC064', 'SC065', 'SC066', 'SC067', 'SC068', 'SC069', 'PEIM06', 'DEC06', 'Followdate3', 'NA07', 'MI07', 'NO07', 'SC071', 'SC072', 'SC073', 'SC074', 'SC075', 'SC076', 'SC077', 'SC078', 'SC079', 'PEIM07', 'DEC07', 'NA08', 'MI08', 'NO08', 'SC081', 'SC082', 'SC083', 'SC084', 'SC085', 'SC086', 'SC087', 'SC088', 'SC089', 'PEIM08', 'DEC08', 'NA09', 'MI09', 'NO09', 'SC091', 'SC092', 'SC093', 'SC094', 'SC095', 'SC096', 'SC097', 'SC098', 'SC099', 'PEIM09', 'DEC09', 'NA10', 'MI10', 'NO10', 'SC101', 'SC102', 'SC103', 'SC104', 'SC105', 'SC106', 'SC107', 'SC108', 'SC109', 'PEIM10', 'DEC10', 'hospcode'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Mraopd::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'mra_id' => $this->mra_id,
            'unit_id' => $this->unit_id,
            'overall_id' => $this->overall_id,
            'date_admit' => $this->date_admit,
            'date_discharge' => $this->date_discharge,
            'date_audit' => $this->date_audit,
            'Followdate1' => $this->Followdate1,
            'Followdate2' => $this->Followdate2,
            'Followdate3' => $this->Followdate3,
        ]);

        $query->andFilterWhere(['like', 'HN', $this->HN])
            ->andFilterWhere(['like', 'visit', $this->visit])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'dr_license', $this->dr_license])
            ->andFilterWhere(['like', 'NA01', $this->NA01])
            ->andFilterWhere(['like', 'MI01', $this->MI01])
            ->andFilterWhere(['like', 'NO01', $this->NO01])
            ->andFilterWhere(['like', 'SC011', $this->SC011])
            ->andFilterWhere(['like', 'SC012', $this->SC012])
            ->andFilterWhere(['like', 'SC013', $this->SC013])
            ->andFilterWhere(['like', 'SC014', $this->SC014])
            ->andFilterWhere(['like', 'SC015', $this->SC015])
            ->andFilterWhere(['like', 'SC016', $this->SC016])
            ->andFilterWhere(['like', 'SC017', $this->SC017])
            ->andFilterWhere(['like', 'SC018', $this->SC018])
            ->andFilterWhere(['like', 'SC019', $this->SC019])
            ->andFilterWhere(['like', 'PEIM01', $this->PEIM01])
            ->andFilterWhere(['like', 'DEC01', $this->DEC01])
            ->andFilterWhere(['like', 'NA02', $this->NA02])
            ->andFilterWhere(['like', 'MI02', $this->MI02])
            ->andFilterWhere(['like', 'NO02', $this->NO02])
            ->andFilterWhere(['like', 'SC021', $this->SC021])
            ->andFilterWhere(['like', 'SC022', $this->SC022])
            ->andFilterWhere(['like', 'SC023', $this->SC023])
            ->andFilterWhere(['like', 'SC024', $this->SC024])
            ->andFilterWhere(['like', 'SC025', $this->SC025])
            ->andFilterWhere(['like', 'SC026', $this->SC026])
            ->andFilterWhere(['like', 'SC027', $this->SC027])
            ->andFilterWhere(['like', 'SC028', $this->SC028])
            ->andFilterWhere(['like', 'SC029', $this->SC029])
            ->andFilterWhere(['like', 'PEIM02', $this->PEIM02])
            ->andFilterWhere(['like', 'DEC02', $this->DEC02])
            ->andFilterWhere(['like', 'NA03', $this->NA03])
            ->andFilterWhere(['like', 'MI03', $this->MI03])
            ->andFilterWhere(['like', 'NO03', $this->NO03])
            ->andFilterWhere(['like', 'SC031', $this->SC031])
            ->andFilterWhere(['like', 'SC032', $this->SC032])
            ->andFilterWhere(['like', 'SC033', $this->SC033])
            ->andFilterWhere(['like', 'SC034', $this->SC034])
            ->andFilterWhere(['like', 'SC035', $this->SC035])
            ->andFilterWhere(['like', 'SC036', $this->SC036])
            ->andFilterWhere(['like', 'SC037', $this->SC037])
            ->andFilterWhere(['like', 'SC038', $this->SC038])
            ->andFilterWhere(['like', 'SC039', $this->SC039])
            ->andFilterWhere(['like', 'PEIM03', $this->PEIM03])
            ->andFilterWhere(['like', 'DEC03', $this->DEC03])
            ->andFilterWhere(['like', 'NA04', $this->NA04])
            ->andFilterWhere(['like', 'MI04', $this->MI04])
            ->andFilterWhere(['like', 'NO04', $this->NO04])
            ->andFilterWhere(['like', 'SC041', $this->SC041])
            ->andFilterWhere(['like', 'SC042', $this->SC042])
            ->andFilterWhere(['like', 'SC043', $this->SC043])
            ->andFilterWhere(['like', 'SC044', $this->SC044])
            ->andFilterWhere(['like', 'SC045', $this->SC045])
            ->andFilterWhere(['like', 'SC046', $this->SC046])
            ->andFilterWhere(['like', 'SC047', $this->SC047])
            ->andFilterWhere(['like', 'SC048', $this->SC048])
            ->andFilterWhere(['like', 'SC049', $this->SC049])
            ->andFilterWhere(['like', 'PEIM04', $this->PEIM04])
            ->andFilterWhere(['like', 'DEC04', $this->DEC04])
            ->andFilterWhere(['like', 'NA05', $this->NA05])
            ->andFilterWhere(['like', 'MI05', $this->MI05])
            ->andFilterWhere(['like', 'NO05', $this->NO05])
            ->andFilterWhere(['like', 'SC051', $this->SC051])
            ->andFilterWhere(['like', 'SC052', $this->SC052])
            ->andFilterWhere(['like', 'SC053', $this->SC053])
            ->andFilterWhere(['like', 'SC054', $this->SC054])
            ->andFilterWhere(['like', 'SC055', $this->SC055])
            ->andFilterWhere(['like', 'SC056', $this->SC056])
            ->andFilterWhere(['like', 'SC057', $this->SC057])
            ->andFilterWhere(['like', 'SC058', $this->SC058])
            ->andFilterWhere(['like', 'SC059', $this->SC059])
            ->andFilterWhere(['like', 'PEIM05', $this->PEIM05])
            ->andFilterWhere(['like', 'DEC05', $this->DEC05])
            ->andFilterWhere(['like', 'NA06', $this->NA06])
            ->andFilterWhere(['like', 'MI06', $this->MI06])
            ->andFilterWhere(['like', 'NO06', $this->NO06])
            ->andFilterWhere(['like', 'SC061', $this->SC061])
            ->andFilterWhere(['like', 'SC062', $this->SC062])
            ->andFilterWhere(['like', 'SC063', $this->SC063])
            ->andFilterWhere(['like', 'SC064', $this->SC064])
            ->andFilterWhere(['like', 'SC065', $this->SC065])
            ->andFilterWhere(['like', 'SC066', $this->SC066])
            ->andFilterWhere(['like', 'SC067', $this->SC067])
            ->andFilterWhere(['like', 'SC068', $this->SC068])
            ->andFilterWhere(['like', 'SC069', $this->SC069])
            ->andFilterWhere(['like', 'PEIM06', $this->PEIM06])
            ->andFilterWhere(['like', 'DEC06', $this->DEC06])
            ->andFilterWhere(['like', 'NA07', $this->NA07])
            ->andFilterWhere(['like', 'MI07', $this->MI07])
            ->andFilterWhere(['like', 'NO07', $this->NO07])
            ->andFilterWhere(['like', 'SC071', $this->SC071])
            ->andFilterWhere(['like', 'SC072', $this->SC072])
            ->andFilterWhere(['like', 'SC073', $this->SC073])
            ->andFilterWhere(['like', 'SC074', $this->SC074])
            ->andFilterWhere(['like', 'SC075', $this->SC075])
            ->andFilterWhere(['like', 'SC076', $this->SC076])
            ->andFilterWhere(['like', 'SC077', $this->SC077])
            ->andFilterWhere(['like', 'SC078', $this->SC078])
            ->andFilterWhere(['like', 'SC079', $this->SC079])
            ->andFilterWhere(['like', 'PEIM07', $this->PEIM07])
            ->andFilterWhere(['like', 'DEC07', $this->DEC07])
            ->andFilterWhere(['like', 'NA08', $this->NA08])
            ->andFilterWhere(['like', 'MI08', $this->MI08])
            ->andFilterWhere(['like', 'NO08', $this->NO08])
            ->andFilterWhere(['like', 'SC081', $this->SC081])
            ->andFilterWhere(['like', 'SC082', $this->SC082])
            ->andFilterWhere(['like', 'SC083', $this->SC083])
            ->andFilterWhere(['like', 'SC084', $this->SC084])
            ->andFilterWhere(['like', 'SC085', $this->SC085])
            ->andFilterWhere(['like', 'SC086', $this->SC086])
            ->andFilterWhere(['like', 'SC087', $this->SC087])
            ->andFilterWhere(['like', 'SC088', $this->SC088])
            ->andFilterWhere(['like', 'SC089', $this->SC089])
            ->andFilterWhere(['like', 'PEIM08', $this->PEIM08])
            ->andFilterWhere(['like', 'DEC08', $this->DEC08])
            ->andFilterWhere(['like', 'NA09', $this->NA09])
            ->andFilterWhere(['like', 'MI09', $this->MI09])
            ->andFilterWhere(['like', 'NO09', $this->NO09])
            ->andFilterWhere(['like', 'SC091', $this->SC091])
            ->andFilterWhere(['like', 'SC092', $this->SC092])
            ->andFilterWhere(['like', 'SC093', $this->SC093])
            ->andFilterWhere(['like', 'SC094', $this->SC094])
            ->andFilterWhere(['like', 'SC095', $this->SC095])
            ->andFilterWhere(['like', 'SC096', $this->SC096])
            ->andFilterWhere(['like', 'SC097', $this->SC097])
            ->andFilterWhere(['like', 'SC098', $this->SC098])
            ->andFilterWhere(['like', 'SC099', $this->SC099])
            ->andFilterWhere(['like', 'PEIM09', $this->PEIM09])
            ->andFilterWhere(['like', 'DEC09', $this->DEC09])
            ->andFilterWhere(['like', 'NA10', $this->NA10])
            ->andFilterWhere(['like', 'MI10', $this->MI10])
            ->andFilterWhere(['like', 'NO10', $this->NO10])
            ->andFilterWhere(['like', 'SC101', $this->SC101])
            ->andFilterWhere(['like', 'SC102', $this->SC102])
            ->andFilterWhere(['like', 'SC103', $this->SC103])
            ->andFilterWhere(['like', 'SC104', $this->SC104])
            ->andFilterWhere(['like', 'SC105', $this->SC105])
            ->andFilterWhere(['like', 'SC106', $this->SC106])
            ->andFilterWhere(['like', 'SC107', $this->SC107])
            ->andFilterWhere(['like', 'SC108', $this->SC108])
            ->andFilterWhere(['like', 'SC109', $this->SC109])
            ->andFilterWhere(['like', 'PEIM10', $this->PEIM10])
            ->andFilterWhere(['like', 'DEC10', $this->DEC10])
            ->andFilterWhere(['like', 'hospcode', $this->hospcode]);

        return $dataProvider;
    }
}
