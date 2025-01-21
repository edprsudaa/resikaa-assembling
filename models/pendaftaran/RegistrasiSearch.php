<?php

namespace app\models\pendaftaran;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pendaftaran\Registrasi;

/**
 * RegistrasiSearch represents the model behind the search form of `app\models\pendaftaran\Registrasi`.
 */
class RegistrasiSearch extends Registrasi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'pasien_kode', 'tgl_masuk', 'tgl_keluar', 'kiriman_detail_kode', 'debitur_detail_kode', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_at', 'no_sep', 'is_print', 'lambar', 'old_kiriman_detail_kode', 'old_debitur_detail_kode'], 'safe'],
            [['deleted_by'], 'integer'],
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
        $query = Registrasi::find()->joinWith('analisaDokumen');

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
            'tgl_masuk' => $this->tgl_masuk,
            'tgl_keluar' => $this->tgl_keluar,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['ilike', 'kode', $this->kode])
            ->andFilterWhere(['ilike', 'pasien_kode', $this->pasien_kode])
            ->andFilterWhere(['ilike', 'kiriman_detail_kode', $this->kiriman_detail_kode])
            ->andFilterWhere(['ilike', 'debitur_detail_kode', $this->debitur_detail_kode])
            ->andFilterWhere(['ilike', 'created_by', $this->created_by])
            ->andFilterWhere(['ilike', 'updated_by', $this->updated_by])
            ->andFilterWhere(['ilike', 'no_sep', $this->no_sep])
            ->andFilterWhere(['ilike', 'is_print', $this->is_print])
            ->andFilterWhere(['ilike', 'lambar', $this->lambar])
            ->andFilterWhere(['ilike', 'old_kiriman_detail_kode', $this->old_kiriman_detail_kode])
            ->andFilterWhere(['ilike', 'old_debitur_detail_kode', $this->old_debitur_detail_kode]);

        return $dataProvider;
    }
}
