<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class PatientClaim305Search extends PatientClaim305
{
    public function rules()
    {
        return [
            [['id', 'no', 'patient_type', 'data_status', 'tran_id', 'seq'], 'integer'],
            [['high_cost', 'claim_amount'], 'number'],
            [['eclaim_no', 'benefit_rights', 'card_no', 'patient_name',
              'hn', 'an', 'service_date', 'discharge_date',
              'recorder_name', 'channel', 'deny_warning'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = PatientClaim305::find();

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => ['pageSize' => 20],
            'sort'       => ['defaultOrder' => ['service_date' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id'           => $this->id,
            'patient_type' => $this->patient_type,
            'data_status'  => $this->data_status,
            'tran_id'      => $this->tran_id,
        ]);

        $query->andFilterWhere(['like', 'eclaim_no',     $this->eclaim_no])
              ->andFilterWhere(['like', 'card_no',        $this->card_no])
              ->andFilterWhere(['like', 'patient_name',   $this->patient_name])
              ->andFilterWhere(['like', 'benefit_rights', $this->benefit_rights])
              ->andFilterWhere(['like', 'channel',        $this->channel]);

        if (!empty($this->service_date)) {
            $query->andFilterWhere(['>=', 'service_date', $this->service_date]);
        }
        if (!empty($this->discharge_date)) {
            $query->andFilterWhere(['<=', 'discharge_date', $this->discharge_date]);
        }

        return $dataProvider;
    }
}