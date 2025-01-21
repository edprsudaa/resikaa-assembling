<?php

namespace app\models\pengolahandata;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pengolahandata\MasterPatologiKlinik;

/**
 * MasterPatologiKlinikSearch represents the model behind the search form of `app\models\pengolahandata\MasterPatologiKlinik`.
 */
class MasterPatologiKlinikSearch extends MasterPatologiKlinik
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['patologi_klinik_id', 'patologi_klinik_aktif', 'patologi_klinik_created_by', 'patologi_klinik_updated_by', 'patologi_klinik_deleted_by'], 'integer'],
            [['patologi_klinik_no', 'patologi_klinik_uraian', 'patologi_klinik_created_at', 'patologi_klinik_updated_at', 'patologi_klinik_deleted_at'], 'safe'],
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
        $query = MasterPatologiKlinik::find();

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
            'patologi_klinik_id' => $this->patologi_klinik_id,
            'patologi_klinik_aktif' => $this->patologi_klinik_aktif,
            'patologi_klinik_created_at' => $this->patologi_klinik_created_at,
            'patologi_klinik_created_by' => $this->patologi_klinik_created_by,
            'patologi_klinik_updated_at' => $this->patologi_klinik_updated_at,
            'patologi_klinik_updated_by' => $this->patologi_klinik_updated_by,
            'patologi_klinik_deleted_at' => $this->patologi_klinik_deleted_at,
            'patologi_klinik_deleted_by' => $this->patologi_klinik_deleted_by,
        ]);

        $query->andFilterWhere(['ilike', 'patologi_klinik_no', $this->patologi_klinik_no])
            ->andFilterWhere(['ilike', 'patologi_klinik_uraian', $this->patologi_klinik_uraian]);

        return $dataProvider;
    }
}
