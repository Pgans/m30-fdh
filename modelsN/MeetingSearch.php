<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Meeting;

/**
 * MeetingSearch represents the model behind the search form of `app\models\Meeting`.
 */
class MeetingSearch extends Meeting
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['meeting_id'], 'integer'],
            [['title', 'attime', 'date', 'time', 'user', 'create_date'], 'safe'],
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
        $query = Meeting::find();

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
            'meeting_id' => $this->meeting_id,
            'date' => $this->date,
            'time' => $this->time,
            'create_date' => $this->create_date,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'attime', $this->attime])
            ->andFilterWhere(['like', 'user', $this->user]);

        return $dataProvider;
    }
}
