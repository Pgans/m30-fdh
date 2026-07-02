<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Keypoints;

/**
 * KeypointsSearch represents the model behind the search form of `app\models\Keypoints`.
 */
class KeypointsSearch extends Keypoints
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key_id', 'agenda_id'], 'integer'],
            [['key_point', 'show_work', 'create_date', 'filename', 'link'], 'safe'],
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
        $query = Keypoints::find();

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
            'key_id' => $this->key_id,
            'agenda_id' => $this->agenda_id,
            'create_date' => $this->create_date,
        ]);

        $query->andFilterWhere(['like', 'key_point', $this->key_point])
            ->andFilterWhere(['like', 'show_work', $this->show_work])
            ->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'link', $this->link]);

        return $dataProvider;
    }
}
