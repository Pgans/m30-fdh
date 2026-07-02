<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Drugexport;

/**
 * DrugexportSearch represents the model behind the search form of `app\models\Drugexport`.
 */
class DrugexportSearch extends Drugexport
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['HOSPCODE', 'PID', 'SEQ', 'DATE_SERV', 'CLINIC', 'DIDSTD', 'DNAME', 'UNIT', 'UNIT_PACKING', 'DRUGPRICE', 'PROVIDER', 'D_UPDATE', 'CID', 'USAGE_LINE1', 'USAGE_LINE2', 'USAGE_LINE3'], 'safe'],
            [['AMOUNT', 'DRUGCOST'], 'number'],
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
        $query = Drugexport::find();

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
            'DATE_SERV' => $this->DATE_SERV,
            'AMOUNT' => $this->AMOUNT,
            'DRUGCOST' => $this->DRUGCOST,
        ]);

        $query->andFilterWhere(['like', 'HOSPCODE', $this->HOSPCODE])
            ->andFilterWhere(['like', 'PID', $this->PID])
            ->andFilterWhere(['like', 'SEQ', $this->SEQ])
            ->andFilterWhere(['like', 'CLINIC', $this->CLINIC])
            ->andFilterWhere(['like', 'DIDSTD', $this->DIDSTD])
            ->andFilterWhere(['like', 'DNAME', $this->DNAME])
            ->andFilterWhere(['like', 'UNIT', $this->UNIT])
            ->andFilterWhere(['like', 'UNIT_PACKING', $this->UNIT_PACKING])
            ->andFilterWhere(['like', 'DRUGPRICE', $this->DRUGPRICE])
            ->andFilterWhere(['like', 'PROVIDER', $this->PROVIDER])
            ->andFilterWhere(['like', 'D_UPDATE', $this->D_UPDATE])
            ->andFilterWhere(['like', 'CID', $this->CID])
            ->andFilterWhere(['like', 'USAGE_LINE1', $this->USAGE_LINE1])
            ->andFilterWhere(['like', 'USAGE_LINE2', $this->USAGE_LINE2])
            ->andFilterWhere(['like', 'USAGE_LINE3', $this->USAGE_LINE3]);

        return $dataProvider;
    }
}
