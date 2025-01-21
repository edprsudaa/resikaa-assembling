<?php

namespace app\models\pengolahandata;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pengolahandata\MasterGolonganPenyakit;

/**
 * MasterGolonganPenyakitSearch represents the model behind the search form of `app\models\pengolahandata\MasterGolonganPenyakit`.
 */
class MasterGolonganPenyakitSearch extends MasterGolonganPenyakit
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['golongan_penyakit_id', 'golongan_penyakit_aktif', 'golongan_penyakit_created_by', 'golongan_penyakit_updated_by', 'golongan_penyakit_deleted_by'], 'integer'],
            [['golongan_penyakit_no_dtd', 'golongan_penyakit_no_daftar_terperinci', 'golongan_penyakit_uraian', 'golongan_penyakit_created_at', 'golongan_penyakit_updated_at', 'golongan_penyakit_deleted_at'], 'safe'],
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
        $query = MasterGolonganPenyakit::find();

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
            'golongan_penyakit_id' => $this->golongan_penyakit_id,
            'golongan_penyakit_aktif' => $this->golongan_penyakit_aktif,
            'golongan_penyakit_created_at' => $this->golongan_penyakit_created_at,
            'golongan_penyakit_created_by' => $this->golongan_penyakit_created_by,
            'golongan_penyakit_updated_at' => $this->golongan_penyakit_updated_at,
            'golongan_penyakit_updated_by' => $this->golongan_penyakit_updated_by,
            'golongan_penyakit_deleted_at' => $this->golongan_penyakit_deleted_at,
            'golongan_penyakit_deleted_by' => $this->golongan_penyakit_deleted_by,
        ]);

        $query->andFilterWhere(['ilike', 'golongan_penyakit_no_dtd', $this->golongan_penyakit_no_dtd])
            ->andFilterWhere(['ilike', 'golongan_penyakit_no_daftar_terperinci', $this->golongan_penyakit_no_daftar_terperinci])
            ->andFilterWhere(['ilike', 'golongan_penyakit_uraian', $this->golongan_penyakit_uraian]);

        return $dataProvider;
    }
}
