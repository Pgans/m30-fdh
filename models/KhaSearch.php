<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kha;

/**
 * KhaSearch represents the model behind the search form of `app\models\Kha`.
 */
class KhaSearch extends Kha
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'workgroup_id', 'document_id', 'team_id', 'dep_id', 'is_update'], 'integer'],
            [['ha_name', 'filename', 'create_date', 'd_update'], 'safe'],
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
        $query = Kha::find();

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
            'workgroup_id' => $this->workgroup_id,
            'document_id' => $this->document_id,
            'team_id' => $this->team_id,
            'dep_id' => $this->dep_id,
            'is_update' => $this->is_update,
            'create_date' => $this->create_date,
            'd_update' => $this->d_update,
        ]);

        $query->andFilterWhere(['like', 'ha_name', $this->ha_name])
            ->andFilterWhere(['like', 'filename', $this->filename]);

        return $dataProvider;
    }
}
