<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Importproc;

/**
 * ImporttextSearch represents the model behind the search form of `app\models\Importtxt`.
 */
class ImportprocSearch extends Importtxt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['HOSPCODE', 'PID', 'AN', 'DATETIME_ADMIT', 'WARDSTAY', 'PROCEDCODE', 'TIMESTART', 'TIMEFINISH', 'SERVICEPRICE', 'PROVIDER', 'D_UPDATE', 'CID'], 'string', 'max' => 255],
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
        $query = Importproc::find();

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
            'auto_id' => $this->auto_id,
        ]);

        $query->andFilterWhere(['like', 'HOSPCODE', $this->HOSPCODE])
            ->andFilterWhere(['like', 'PID', $this->PID])
            ->andFilterWhere(['like', 'train_id', $this->train_id])
            ->andFilterWhere(['like', 'hn', $this->hn])
            ->andFilterWhere(['like', 'an', $this->an])
            ->andFilterWhere(['like', 'pid', $this->pid])
            ->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'main', $this->main])
            ->andFilterWhere(['like', 'regdate', $this->regdate])
            ->andFilterWhere(['like', 'discharge', $this->discharge])
            ->andFilterWhere(['like', 'ins', $this->ins])
            ->andFilterWhere(['like', 'pp', $this->pp])
            ->andFilterWhere(['like', 'errorcode', $this->errorcode])
            ->andFilterWhere(['like', 'sub', $this->sub]);

        return $dataProvider;
    }
}
