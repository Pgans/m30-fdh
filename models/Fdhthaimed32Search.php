<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Fdhthaimed32;

/**
 * Fdhthaimed32Search represents the model behind the search form of `app\models\Fdhthaimed32`.
 */
class Fdhthaimed32Search extends Fdhthaimed32
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['main_table', 'main_query', 'd_update'], 'safe'],
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
        $query = Fdhthaimed32::find();

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

        $query->andFilterWhere(['like', 'main_table', $this->main_table])
            ->andFilterWhere(['like', 'main_query', $this->main_query]);

        return $dataProvider;
    }
}
