<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\penunjang\HasilPemeriksaan;

/**
 * HasilPemeriksaanSearch represents the model behind the search form of `app\models\penunjang\HasilPemeriksaan`.
 */
class HasilPemeriksaanSearch extends HasilPemeriksaan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'layanan_id_penunjang', 'dokter_pemeriksa', 'is_save', 'is_ambil', 'tarif_tindakan_pasien_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['tgl_periksa', 'tanggal_ambil_hasil', 'klinis', 'no_pa', 'diagnosa_pa', 'kesimpulan', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
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
    public function search($params, $dokter_id = null, $tgl = null)
    {
        $query = HasilPemeriksaan::find();

        if (isset($tgl)) {
            $query->andWhere([
                'BETWEEN',
                'tgl_periksa',
                date('Y-m-d', strtotime($tgl)) . " 00:00:00.000",
                date('Y-m-d', strtotime($tgl)) . " 23:59:59.000"
            ]);
        }
        if (isset($dokter_id)) {
            $query->andWhere([
                'or',
                ['dokter_pemeriksa' => $dokter_id['id_pegawai']],
                ['dokter_pemeriksa' => $dokter_id['kode_dokter_maping_simrs']]
            ]);
        }

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
            'id' => $this->id,
            'layanan_id_penunjang' => $this->layanan_id_penunjang,
            'dokter_pemeriksa' => $this->dokter_pemeriksa,
            'tgl_periksa' => $this->tgl_periksa,
            'tanggal_ambil_hasil' => $this->tanggal_ambil_hasil,
            'is_save' => $this->is_save,
            'is_ambil' => $this->is_ambil,
            'tarif_tindakan_pasien_id' => $this->tarif_tindakan_pasien_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['ilike', 'klinis', $this->klinis])
            ->andFilterWhere(['ilike', 'no_pa', $this->no_pa])
            ->andFilterWhere(['ilike', 'diagnosa_pa', $this->diagnosa_pa])
            ->andFilterWhere(['ilike', 'kesimpulan', $this->kesimpulan]);

        return $dataProvider;
    }
}
