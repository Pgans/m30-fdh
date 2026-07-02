<?php

namespace backend\modules\study\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\University;

/**
 * UniversitySearch represents the model behind the search form about `common\models\University`.
 */
class UniversitySearch extends University
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['university_id'], 'integer'],
            [['university_name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = University::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'university_id' => $this->university_id,
        ]);

        $query->andFilterWhere(['like', 'university_name', $this->university_name]);

        return $dataProvider;
    }
}
