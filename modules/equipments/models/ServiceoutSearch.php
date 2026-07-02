<?php

namespace backend\modules\equipments\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Serviceout;

/**
 * ServiceoutSearch represents the model behind the search form about `common\models\Serviceout`.
 */
class ServiceoutSearch extends Serviceout
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'device_id', 'store_id'], 'integer'],
            [['symptom', 'date_sent', 'date_in', 'price', 'orther'], 'safe'],
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
        $query = Serviceout::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize'=>8
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'device_id' => $this->device_id,
            'date_sent' => $this->date_sent,
            'date_in' => $this->date_in,
            'store_id' => $this->store_id,
        ]);

        $query->andFilterWhere(['like', 'symptom', $this->symptom])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'orther', $this->orther]);

        return $dataProvider;
    }
}
