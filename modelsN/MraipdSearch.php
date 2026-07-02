<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mraipd;

/**
 * MraipdSearch represents the model behind the search form of `app\models\Mraipd`.
 */
class MraipdSearch extends Mraipd
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mra_id', 'unit_id', 'dxop1', 'dxop2', 'dxop3', 'dxop4', 'dxop5', 'dxop6', 'dxop7', 'dxop8', 'dxop9', 'dxop_huk', 'other1', 'other2', 'other3', 'other4', 'other5', 'other6', 'other7', 'other8', 'other9', 'other_huk', 'infc1', 'infc2', 'infc3', 'infc4', 'infc5', 'infc6', 'infc7', 'infc8', 'infc9', 'infc_huk', 'hist1', 'hist2', 'hist3', 'hist4', 'hist5', 'hist6', 'hist7', 'hist8', 'hist9', 'hist_huk', 'pe1', 'pe2', 'pe3', 'pe4', 'pe5', 'pe6', 'pe7', 'pe8', 'pe9', 'pe_huk', 'pn1', 'pn2', 'pn3', 'pn4', 'pn5', 'pn6', 'pn7', 'pn8', 'pn9', 'pn_huk', 'cr1', 'cr2', 'cr3', 'cr4', 'cr5', 'cr6', 'cr7', 'cr8', 'cr9', 'cr_huk', 'ar1', 'ar2', 'ar3', 'ar4', 'ar5', 'ar6', 'ar7', 'ar8', 'ar9', 'ar_huk', 'on1', 'on2', 'on3', 'on4', 'on5', 'on6', 'on7', 'on8', 'on9', 'on_huk', 'lr1', 'lr2', 'lr3', 'lr4', 'lr5', 'lr6', 'lr7', 'lr8', 'lr9', 'lr_huk', 'rr1', 'rr2', 'rr3', 'rr4', 'rr5', 'rr6', 'rr7', 'rr8', 'rr9', 'rr_huk', 'nn1', 'nn2', 'nn3', 'nn4', 'nn5', 'nn6', 'nn7', 'nn8', 'nn9', 'nn_huk'], 'integer'],
            [['HN', 'AN', 'dr_license', 'date_admit', 'date_discharge', 'date_audit', 'NA1', 'Missing1', 'No1', 'NA2', 'Missing2', 'No2', 'NA3', 'Missing3', 'No3', 'NA4', 'Missing4', 'No4', 'NA5', 'Missing5', 'No5', 'NA6', 'Missing6', 'No6', 'NA7', 'Missing7', 'No7', 'NA8', 'Missing8', 'No8', 'NA9', 'Missing9', 'No9', 'NA10', 'Missing10', 'No10', 'NA11', 'Missing11', 'No11', 'NA12', 'Missing12', 'No12', 'hospcode'], 'safe'],
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
        $query = Mraipd::find();

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
            'date_admit' => $this->date_admit,
            'date_discharge' => $this->date_discharge,
            'date_audit' => $this->date_audit,
            'dxop1' => $this->dxop1,
            'dxop2' => $this->dxop2,
            'dxop3' => $this->dxop3,
            'dxop4' => $this->dxop4,
            'dxop5' => $this->dxop5,
            'dxop6' => $this->dxop6,
            'dxop7' => $this->dxop7,
            'dxop8' => $this->dxop8,
            'dxop9' => $this->dxop9,
            'dxop_huk' => $this->dxop_huk,
            'other1' => $this->other1,
            'other2' => $this->other2,
            'other3' => $this->other3,
            'other4' => $this->other4,
            'other5' => $this->other5,
            'other6' => $this->other6,
            'other7' => $this->other7,
            'other8' => $this->other8,
            'other9' => $this->other9,
            'other_huk' => $this->other_huk,
            'infc1' => $this->infc1,
            'infc2' => $this->infc2,
            'infc3' => $this->infc3,
            'infc4' => $this->infc4,
            'infc5' => $this->infc5,
            'infc6' => $this->infc6,
            'infc7' => $this->infc7,
            'infc8' => $this->infc8,
            'infc9' => $this->infc9,
            'infc_huk' => $this->infc_huk,
            'hist1' => $this->hist1,
            'hist2' => $this->hist2,
            'hist3' => $this->hist3,
            'hist4' => $this->hist4,
            'hist5' => $this->hist5,
            'hist6' => $this->hist6,
            'hist7' => $this->hist7,
            'hist8' => $this->hist8,
            'hist9' => $this->hist9,
            'hist_huk' => $this->hist_huk,
            'pe1' => $this->pe1,
            'pe2' => $this->pe2,
            'pe3' => $this->pe3,
            'pe4' => $this->pe4,
            'pe5' => $this->pe5,
            'pe6' => $this->pe6,
            'pe7' => $this->pe7,
            'pe8' => $this->pe8,
            'pe9' => $this->pe9,
            'pe_huk' => $this->pe_huk,
            'pn1' => $this->pn1,
            'pn2' => $this->pn2,
            'pn3' => $this->pn3,
            'pn4' => $this->pn4,
            'pn5' => $this->pn5,
            'pn6' => $this->pn6,
            'pn7' => $this->pn7,
            'pn8' => $this->pn8,
            'pn9' => $this->pn9,
            'pn_huk' => $this->pn_huk,
            'cr1' => $this->cr1,
            'cr2' => $this->cr2,
            'cr3' => $this->cr3,
            'cr4' => $this->cr4,
            'cr5' => $this->cr5,
            'cr6' => $this->cr6,
            'cr7' => $this->cr7,
            'cr8' => $this->cr8,
            'cr9' => $this->cr9,
            'cr_huk' => $this->cr_huk,
            'ar1' => $this->ar1,
            'ar2' => $this->ar2,
            'ar3' => $this->ar3,
            'ar4' => $this->ar4,
            'ar5' => $this->ar5,
            'ar6' => $this->ar6,
            'ar7' => $this->ar7,
            'ar8' => $this->ar8,
            'ar9' => $this->ar9,
            'ar_huk' => $this->ar_huk,
            'on1' => $this->on1,
            'on2' => $this->on2,
            'on3' => $this->on3,
            'on4' => $this->on4,
            'on5' => $this->on5,
            'on6' => $this->on6,
            'on7' => $this->on7,
            'on8' => $this->on8,
            'on9' => $this->on9,
            'on_huk' => $this->on_huk,
            'lr1' => $this->lr1,
            'lr2' => $this->lr2,
            'lr3' => $this->lr3,
            'lr4' => $this->lr4,
            'lr5' => $this->lr5,
            'lr6' => $this->lr6,
            'lr7' => $this->lr7,
            'lr8' => $this->lr8,
            'lr9' => $this->lr9,
            'lr_huk' => $this->lr_huk,
            'rr1' => $this->rr1,
            'rr2' => $this->rr2,
            'rr3' => $this->rr3,
            'rr4' => $this->rr4,
            'rr5' => $this->rr5,
            'rr6' => $this->rr6,
            'rr7' => $this->rr7,
            'rr8' => $this->rr8,
            'rr9' => $this->rr9,
            'rr_huk' => $this->rr_huk,
            'nn1' => $this->nn1,
            'nn2' => $this->nn2,
            'nn3' => $this->nn3,
            'nn4' => $this->nn4,
            'nn5' => $this->nn5,
            'nn6' => $this->nn6,
            'nn7' => $this->nn7,
            'nn8' => $this->nn8,
            'nn9' => $this->nn9,
            'nn_huk' => $this->nn_huk,
        ]);

        $query->andFilterWhere(['like', 'HN', $this->HN])
            ->andFilterWhere(['like', 'AN', $this->AN])
            ->andFilterWhere(['like', 'dr_license', $this->dr_license])
            ->andFilterWhere(['like', 'NA1', $this->NA1])
            ->andFilterWhere(['like', 'Missing1', $this->Missing1])
            ->andFilterWhere(['like', 'No1', $this->No1])
            ->andFilterWhere(['like', 'NA2', $this->NA2])
            ->andFilterWhere(['like', 'Missing2', $this->Missing2])
            ->andFilterWhere(['like', 'No2', $this->No2])
            ->andFilterWhere(['like', 'NA3', $this->NA3])
            ->andFilterWhere(['like', 'Missing3', $this->Missing3])
            ->andFilterWhere(['like', 'No3', $this->No3])
            ->andFilterWhere(['like', 'NA4', $this->NA4])
            ->andFilterWhere(['like', 'Missing4', $this->Missing4])
            ->andFilterWhere(['like', 'No4', $this->No4])
            ->andFilterWhere(['like', 'NA5', $this->NA5])
            ->andFilterWhere(['like', 'Missing5', $this->Missing5])
            ->andFilterWhere(['like', 'No5', $this->No5])
            ->andFilterWhere(['like', 'NA6', $this->NA6])
            ->andFilterWhere(['like', 'Missing6', $this->Missing6])
            ->andFilterWhere(['like', 'No6', $this->No6])
            ->andFilterWhere(['like', 'NA7', $this->NA7])
            ->andFilterWhere(['like', 'Missing7', $this->Missing7])
            ->andFilterWhere(['like', 'No7', $this->No7])
            ->andFilterWhere(['like', 'NA8', $this->NA8])
            ->andFilterWhere(['like', 'Missing8', $this->Missing8])
            ->andFilterWhere(['like', 'No8', $this->No8])
            ->andFilterWhere(['like', 'NA9', $this->NA9])
            ->andFilterWhere(['like', 'Missing9', $this->Missing9])
            ->andFilterWhere(['like', 'No9', $this->No9])
            ->andFilterWhere(['like', 'NA10', $this->NA10])
            ->andFilterWhere(['like', 'Missing10', $this->Missing10])
            ->andFilterWhere(['like', 'No10', $this->No10])
            ->andFilterWhere(['like', 'NA11', $this->NA11])
            ->andFilterWhere(['like', 'Missing11', $this->Missing11])
            ->andFilterWhere(['like', 'No11', $this->No11])
            ->andFilterWhere(['like', 'NA12', $this->NA12])
            ->andFilterWhere(['like', 'Missing12', $this->Missing12])
            ->andFilterWhere(['like', 'No12', $this->No12])
            ->andFilterWhere(['like', 'hospcode', $this->hospcode]);

        return $dataProvider;
    }
}
