<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Logdmhtdt;

/**
 * LogdmhtdtSearch represents the model behind the search form of `app\models\Logdmhtdt`.
 */
class LogdmhtdtSearch extends Logdmhtdt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['visit_id', 'pid', 'cid', 'status', 'messagecode', 'response', 'users', 'd_update'], 'safe'],
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
        $query = Logdmhtdt::find();

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

        $query->andFilterWhere(['like', 'visit_id', $this->visit_id])
            ->andFilterWhere(['like', 'pid', $this->pid])
            ->andFilterWhere(['like', 'cid', $this->cid])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'messagecode', $this->messagecode])
            ->andFilterWhere(['like', 'response', $this->response])
            ->andFilterWhere(['like', 'users', $this->users]);

        return $dataProvider;
    }
}
