<?php

namespace backend\modules\history\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\History;

/**
 * HistorySearch represents the model behind the search form about `common\models\History`.
 */
class HistorySearch extends History
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'departments_dep_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at','devices_device_id','updated_at'], 'safe'],
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
        $query = History::find();
        $query->joinWith('devicesDevice');
        //$query->joinWith('devices')

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
       // $query->joinWith['devicesDevice'];
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
           // 'devices_device_id' => $this->devices_device_id,
            'departments_dep_id' => $this->departments_dep_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);
        $query->andFilterWhere(['like', 'devices.device_serial', $this->devices_device_id ]);

        return $dataProvider;
    }
}
