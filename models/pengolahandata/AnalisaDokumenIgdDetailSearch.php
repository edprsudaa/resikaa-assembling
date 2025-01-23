<?php

namespace app\models\pengolahandata;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pengolahandata\AnalisaDokumenRjDetail;

/**
 * AnalisaDokumenDetailSearch represents the model behind the search form of `app\models\pengolahandata\AnalisaDokumenDetail`.
 */
class AnalisaDokumenIgdDetailSearch extends AnalisaDokumenRjDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['analisa_dokumen_detail_id', 'analisa_dokumen_id', 'analisa_dokumen_jenis_analisa_detail_id', 'analisa_dokumen_item_id', 'analisa_dokumen_jenis_id', 'analisa_dokumen_kelengkapan', 'analisa_dokumen_dokter_id', 'analisa_dokumen_petugas_analisa_id', 'deleted_by'], 'integer'],
            [['created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_at'], 'safe'],
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
        $query = AnalisaDokumenDetail::find();

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
            'analisa_dokumen_detail_id' => $this->analisa_dokumen_detail_id,
            'analisa_dokumen_id' => $this->analisa_dokumen_id,
            'analisa_dokumen_jenis_analisa_detail_id' => $this->analisa_dokumen_jenis_analisa_detail_id,
            'analisa_dokumen_item_id' => $this->analisa_dokumen_item_id,
            'analisa_dokumen_jenis_id' => $this->analisa_dokumen_jenis_id,
            'analisa_dokumen_kelengkapan' => $this->analisa_dokumen_kelengkapan,
            'analisa_dokumen_dokter_id' => $this->analisa_dokumen_dokter_id,
            'analisa_dokumen_petugas_analisa_id' => $this->analisa_dokumen_petugas_analisa_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['ilike', 'created_by', $this->created_by])
            ->andFilterWhere(['ilike', 'updated_by', $this->updated_by]);

        return $dataProvider;
    }
}
