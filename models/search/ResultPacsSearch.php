<?php

namespace app\models\search;

use app\models\penunjang\ResultPacs;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ResultPacsSearch represents the model behind the search form of `penunjang\models\ResultPacs`.
 */
class ResultPacsSearch extends ResultPacs
{
    public $nama;
    public function rules()
    {
        return [
            [['id_pacsorder', 'nomor_pasien', 'nomor_registrasi', 'tanggal_masuk', 'dokter_kode', 'dokter_nama', 'dokter_asal_kode', 'dokter_asal_nama', 'unit_kode', 'unit_nama', 'unit_asal_kode', 'unit_asal_nama', 'bridging_status', 'kode_jenis', 'nama_tindakan', 'order_status', 'order_date', 'modality', 'clinical_diagnosis', 'report_description', 'report_date', 'dokter_id', 'dokter_name', 'link', 'result_status', 'serah_hasil_id', 'serah_hasil_date', 'validasi_id', 'validasi_date', 'created_id', 'created_date', 'modified_id', 'modified_date', 'deleted_id', 'deleted_date', 'status', 'ket', 'nama'], 'safe'],
            [['jenis_layanan'], 'integer'],
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
        $query = ResultPacs::find();

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
            'jenis_layanan' => $this->jenis_layanan,
            'tanggal_masuk' => $this->tanggal_masuk,
            'order_date' => $this->order_date,
            'report_date' => $this->report_date,
            'serah_hasil_date' => $this->serah_hasil_date,
            'validasi_date' => $this->validasi_date,
            'created_date' => $this->created_date,
            'modified_date' => $this->modified_date,
            'deleted_date' => $this->deleted_date,
        ]);

        $query->andFilterWhere(['ilike', 'id_pacsorder', $this->id_pacsorder])
            ->andFilterWhere(['ilike', 'nomor_pasien', $this->nomor_pasien])
            ->andFilterWhere(['ilike', 'nomor_registrasi', $this->nomor_registrasi])
            ->andFilterWhere(['ilike', 'dokter_kode', $this->dokter_kode])
            ->andFilterWhere(['ilike', 'dokter_nama', $this->dokter_nama])
            ->andFilterWhere(['ilike', 'dokter_asal_kode', $this->dokter_asal_kode])
            ->andFilterWhere(['ilike', 'dokter_asal_nama', $this->dokter_asal_nama])
            ->andFilterWhere(['ilike', 'unit_kode', $this->unit_kode])
            ->andFilterWhere(['ilike', 'unit_nama', $this->unit_nama])
            ->andFilterWhere(['ilike', 'unit_asal_kode', $this->unit_asal_kode])
            ->andFilterWhere(['ilike', 'unit_asal_nama', $this->unit_asal_nama])
            ->andFilterWhere(['ilike', 'bridging_status', $this->bridging_status])
            ->andFilterWhere(['ilike', 'kode_jenis', $this->kode_jenis])
            ->andFilterWhere(['ilike', 'nama_tindakan', $this->nama_tindakan])
            ->andFilterWhere(['ilike', 'order_status', $this->order_status])
            ->andFilterWhere(['ilike', 'modality', $this->modality])
            ->andFilterWhere(['ilike', 'clinical_diagnosis', $this->clinical_diagnosis])
            ->andFilterWhere(['ilike', 'report_description', $this->report_description])
            ->andFilterWhere(['ilike', 'dokter_id', $this->dokter_id])
            ->andFilterWhere(['ilike', 'dokter_name', $this->dokter_name])
            ->andFilterWhere(['ilike', 'link', $this->link])
            ->andFilterWhere(['ilike', 'result_status', $this->result_status])
            ->andFilterWhere(['ilike', 'serah_hasil_id', $this->serah_hasil_id])
            ->andFilterWhere(['ilike', 'validasi_id', $this->validasi_id])
            ->andFilterWhere(['ilike', 'created_id', $this->created_id])
            ->andFilterWhere(['ilike', 'modified_id', $this->modified_id])
            ->andFilterWhere(['ilike', 'deleted_id', $this->deleted_id])
            ->andFilterWhere(['ilike', 'status', $this->status])
            ->andFilterWhere(['ilike', 'ket', $this->ket]);

        return $dataProvider;
    }

    public function searchDokter($params, $tgl = null, $dokter_id = null)
    {
        $query = ResultPacs::find()->alias('rp')->select([
            'p.nama',
            'pl.nama AS pasien_luar_nama',
            'rp.id_pacsorder',
            'rp.nomor_pasien',
            'rp.nomor_registrasi',
            'rp.tanggal_masuk',
            'rp.dokter_nama',
            'rp.dokter_asal_nama',
            'rp.kode_jenis',
            'rp.nama_tindakan',
            'rp.unit_asal_nama',
            'rp.nomor_transaksi',
            'rp.link',
            'rp.report_description'
        ])->leftJoin('pendaftaran.pasien p', 'p.kode=rp.nomor_pasien')
            ->leftJoin('pendaftaran.pasien_luar pl', 'pl.registrasi_kode=rp.nomor_registrasi');

        if (isset($tgl)) {
            $query->andWhere([
                'BETWEEN',
                'rp.tanggal_masuk',
                date('Y-m-d', strtotime($tgl)) . " 00:00:00.000",
                date('Y-m-d', strtotime($tgl)) . " 23:59:59.000"
            ]);
        }
        if (isset($dokter_id)) {
            $query->andWhere([
                'or',
                ['rp.dokter_kode' => $dokter_id['id_pegawai']],
                ['rp.dokter_kode' => $dokter_id['kode_dokter_maping_simrs']]
            ]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'jenis_layanan' => $this->jenis_layanan,
            'tanggal_masuk' => $this->tanggal_masuk,
            'order_date' => $this->order_date,
            'report_date' => $this->report_date,
            'serah_hasil_date' => $this->serah_hasil_date,
            'validasi_date' => $this->validasi_date,
            'created_date' => $this->created_date,
            'modified_date' => $this->modified_date,
            'deleted_date' => $this->deleted_date,
            'nama' => $this->nama
        ]);

        $query->andFilterWhere(['ilike', 'id_pacsorder', $this->id_pacsorder])
            ->andFilterWhere(['ilike', 'nomor_pasien', $this->nomor_pasien])
            ->andFilterWhere(['ilike', 'nomor_registrasi', $this->nomor_registrasi])
            ->andFilterWhere(['ilike', 'dokter_asal_nama', $this->dokter_asal_nama])
            ->andFilterWhere(['ilike', 'unit_nama', $this->unit_nama])
            ->andFilterWhere(['ilike', 'unit_asal_nama', $this->unit_asal_nama])
            ->andFilterWhere(['ilike', 'kode_jenis', $this->kode_jenis])
            ->andFilterWhere(['ilike', 'nama_tindakan', $this->nama_tindakan])
            ->andFilterWhere(['ilike', 'order_status', $this->order_status])
            ->andFilterWhere(['ilike', 'modality', $this->modality])
            ->andFilterWhere(['ilike', 'report_description', $this->report_description])
            ->andFilterWhere(['ilike', 'dokter_id', $this->dokter_id])
            ->andFilterWhere(['ilike', 'dokter_name', $this->dokter_name])
            ->andFilterWhere(['ilike', 'link', $this->link])
            ->andFilterWhere(['ilike', 'p.nama', $this->nama]);

        return $dataProvider;
    }
}
