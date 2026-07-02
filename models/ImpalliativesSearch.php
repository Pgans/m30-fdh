<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Impalliatives;

/**
 * ImpalliativesSearch represents the model behind the search form of `app\models\Impalliatives`.
 */
class ImpalliativesSearch extends Impalliatives
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['hospcode', 'regdate', 'hn', 'cid', 'fullname', 'age', 'diag_primary', 'diag_comor', 'address', 'telephone', 'status', 'd_update'], 'safe'],
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
        $query = Impalliatives::find();

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
            'd_update' => $this->d_update,
        ]);

        $query->andFilterWhere(['like', 'hospcode', $this->hospcode])
            ->andFilterWhere(['like', 'regdate', $this->regdate])
            ->andFilterWhere(['like', 'hn', $this->hn])
            ->andFilterWhere(['like', 'cid', $this->cid])
            ->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'age', $this->age])
            ->andFilterWhere(['like', 'diag_primary', $this->diag_primary])
            ->andFilterWhere(['like', 'diag_comor', $this->diag_comor])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
