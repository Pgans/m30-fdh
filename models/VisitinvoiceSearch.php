<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Visitinvoice;

/**
 * VisitinvoiceSearch represents the model behind the search form of `app\models\Visitinvoice`.
 */
class VisitinvoiceSearch extends Visitinvoice
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['visit_id', 'record_dt', 'item', 'is_refund', 'amount', 'ctype', 'cfield', 'drug_id', 'opbills', 'is_psc', 'is_inv', 'is_rcp', 'xl_id', 'lab_id', 'xray_code', 'type16', 'seq16', 'code16', 'chrgitem', 'ned_code', 'order_dt'], 'safe'],
            [['order1', 'order2', 'order3', 'hosp', 'is_cancel', 'auto_id'], 'integer'],
            [['invoice', 'subtotal', 'base_rate', 'extra', 'unit_price'], 'number'],
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

public function search($params)
{
    $query = Visitinvoice::find()
        ->select(['visit_id', 'auto_id', 'invoice', 'amount', 'unit_price', 'code16', 'is_cancel']) // เลือกฟิลด์ทั้งหมดที่ต้องการ
        ->where(['is_cancel' => 0]) // เงื่อนไขที่ต้องการ
        ->groupBy(['visit_id', 'auto_id', 'invoice', 'amount', 'unit_price', 'code16', 'is_cancel']); // Group ตาม visit_id เพื่อให้เอาข้อมูลซ้ำออก

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);

    // Load and validate the params if necessary
    $this->load($params);

    if (!$this->validate()) {
        $query->where('0=1'); // No data when validation fails
        return $dataProvider;
    }

    // Apply filtering if visit_id is specified
    if (!empty($this->visit_id)) {
        $query->andWhere(['visit_id' => $this->visit_id]);
    }

    return $dataProvider;
}


}
/*	
public function search($params)
{
    // ใช้ 'auto_id' แทน 'id'
    $query = Visitinvoice::find()
        ->select(['auto_id', 'visit_id', 'invoice', 'amount', 'unit_price', 'code16', 'is_cancel']) // เปลี่ยนเป็น auto_id หรือคอลัมน์ที่มีอยู่จริงในตาราง
        ->where(['is_cancel' => 0]);

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);

    $this->load($params);

    if (!$this->validate()) {
        $query->where('0=1');
        return $dataProvider;
    }

    if (!empty($this->visit_id)) {
        $query->andWhere(['visit_id' => $this->visit_id]);
    }

    return $dataProvider;
}
}

    