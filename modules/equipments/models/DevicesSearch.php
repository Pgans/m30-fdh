<?php

namespace backend\modules\equipments\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Devices;

/**
 * DevicesSearch represents the model behind the search form about `common\models\Devices`.
 */
class DevicesSearch extends Devices
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['device_id', 'category_id', 'dep_id', 'price'], 'integer'],
            [['device_serial', 'device_name', 'spec', 'purchase_date', 'due_date', 'sale_date', 'orther'], 'safe'],
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
        $query = Devices::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=> [
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
            'device_id' => $this->device_id,
            'category_id' => $this->category_id,
            'dep_id' => $this->dep_id,
            'purchase_date' => $this->purchase_date,
            'due_date' => $this->due_date,
            'price' => $this->price,
            'sale_date' => $this->sale_date,
        ]);

        $query->andFilterWhere(['like', 'device_serial', $this->device_serial])
            ->andFilterWhere(['like', 'device_name', $this->device_name])
            ->andFilterWhere(['like', 'spec', $this->spec])
            ->andFilterWhere(['like', 'orther', $this->orther]);

        return $dataProvider;
    }
}
