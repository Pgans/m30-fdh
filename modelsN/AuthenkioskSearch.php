<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Authenkiosk;

/**
 * AuthenkioskSearch represents the model behind the search form of `app\models\Authenkiosk`.
 */
class AuthenkioskSearch extends Authenkiosk
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['hospcode', 'cid', 'visit_id', 'claimtype', 'claimcode', 'mobile', 'dep_name', 'authen_date', 'd_update'], 'safe'],
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
        $query = Authenkiosk::find();

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
            'id' => $this->id,
            'authen_date' => $this->authen_date,
            'd_update' => $this->d_update,
        ]);

        $query->andFilterWhere(['like', 'hospcode', $this->hospcode])
            ->andFilterWhere(['like', 'cid', $this->cid])
            ->andFilterWhere(['like', 'visit_id', $this->visit_id])
            ->andFilterWhere(['like', 'claimtype', $this->claimtype])
            ->andFilterWhere(['like', 'claimcode', $this->claimcode])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'dep_name', $this->dep_name]);

        return $dataProvider;
    }
}
