<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Logrequests;

/**
 * LogrequestsSearch represents the model behind the search form of `app\models\Logrequests`.
 */
class LogrequestsSearch extends Logrequests
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['users', 'action', 'request_date', 'developer_comments', 'completion_date'], 'safe'],
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
        $query = Logrequests::find();

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
            'request_date' => $this->request_date,
            'completion_date' => $this->completion_date,
        ]);

        $query->andFilterWhere(['like', 'users', $this->users])
            ->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'developer_comments', $this->developer_comments]);

        return $dataProvider;
    }
}
