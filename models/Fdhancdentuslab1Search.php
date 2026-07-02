<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Fdhancdentuslab1;

/**
 * Fdhancdentuslab1Search represents the model behind the search form of `app\models\Fdhancdentuslab1`.
 */
class Fdhancdentuslab1Search extends Fdhancdentuslab1
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
        $query = Fdhancdentuslab1::find();

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
