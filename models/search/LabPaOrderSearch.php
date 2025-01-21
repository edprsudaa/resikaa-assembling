<?php

namespace app\models\search;

use app\models\medis\LabPaOrder;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * LabPaOrderSearch represents the model behind the search form of `app\models\postgre\LabPaOrder`.
 */
class LabPaOrderSearch extends LabPaOrder
{
    public $pasien_kode;
    public $pasien_nama;
    public $tanggal_penunjang;

    public function rules()
    {
        return [
            [['id', 'ird', 'layanan_id', 'dokter_id', 'created_by', 'updated_by', 'is_deleted', 'nomr', 'layanan_id_penunjang'], 'integer'],
            [['no_transaksi', 'tgl_pengambilan_spesimen', 'tgl_pemeriksaan', 'lokalis', 'dilakukan_secara', 'spesimen_difikasi', 'cairan_fiksasi', 'pernah_pemeriksaan_pa', 'diagnosa', 'permintaan', 'haid_terakhir_g', 'haid_terakhir_p', 'created_at', 'updated_at', 'log_data', 'pasien_kode', 'pasien_nama', 'tanggal_penunjang'], 'safe'],
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
        $query = LabPaOrder::find()->alias('lpo')
            ->select([
                'lpo.id',
                'lpo.layanan_id',
                'lpo.dokter_id',
                'lpo.no_transaksi',
                'lpo.created_at',
                'lpo.ird',
                'lpo.layanan_id_penunjang',
                'l.unit_kode',
                'l.registrasi_kode',
                'l.tgl_masuk',
                'up.nama',
                'up2.nama',
                'r.pasien_kode',
                'p.nama'
            ])
            ->leftJoin('pendaftaran.layanan l', 'l.id=lpo.layanan_id')
            ->leftJoin('pegawai.dm_unit_penempatan up', 'up.kode=l.unit_kode')
            ->leftJoin('pegawai.dm_unit_penempatan up2', 'up2.kode=l.unit_tujuan_kode')
            ->leftJoin('pendaftaran.registrasi r', 'r.kode=l.registrasi_kode')
            ->leftJoin('pendaftaran.pasien p', 'p.kode=r.pasien_kode')
            ->andWhere(['lpo.is_deleted' => 0])->andWhere([
                'BETWEEN',
                'lpo.created_at',
                date('Y-m-d', strtotime($params['tgl'])) . " 00:00:00",
                date('Y-m-d', strtotime($params['tgl'])) . " 23:59:59"
            ]);

        if ($params['unit'] != "") {
            $query->andWhere([
                'l.unit_kode' => $params['unit']
            ]);
        }

        if ($params['dokter'] != "") {
            $query->andWhere([
                'lpo.dokter_id' => $params['dokter']
            ]);
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'attributes' => [
                    'lpo.layanan_id_penunjang' => [
                        'asc' => [new Expression('lpo.layanan_id_penunjang NULLS FIRST')],
                        'desc' => [new Expression('lpo.layanan_id_penunjang DESC NULLS FIRST')],
                    ],
                    'lpo.created_at',
                ],
                'defaultOrder' => [
                    'lpo.layanan_id_penunjang' => SORT_DESC,
                    'lpo.created_at' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'r.pasien_kode' => $this->pasien_kode,
            'p.nama' => $this->pasien_nama,
        ]);

        $query->andFilterWhere(['ilike', 'r.pasien_kode', $this->pasien_kode])
            ->andFilterWhere(['ilike', 'p.nama', $this->pasien_nama]);

        return $dataProvider;
    }

    public function searchAntrian($params, $cek)
    {
        $query = LabPaOrder::find()->alias('lpo')->select([
            'lpo.layanan_id_penunjang',
            'lpo.id',
            'lpo.layanan_id',
            'lpo.dokter_id',
            'lpo.no_transaksi',
            'lp.tgl_masuk',
            'lp.registrasi_kode',
            'lp.nomor_urut',
            'up.nama as unitTujuan',
            'upa.nama as unitAsal',
            'p.nama as namaPasien'
        ])
            ->innerJoin('pendaftaran.layanan lp', 'lp.id=lpo.layanan_id_penunjang')
            ->innerJoin('pegawai.dm_unit_penempatan up', 'up.kode=lp.unit_kode')
            ->innerJoin('pegawai.dm_unit_penempatan upa', 'upa.kode=lp.unit_asal_kode')
            ->innerJoin('pendaftaran.registrasi r', 'r.kode=lp.registrasi_kode')
            ->innerJoin('pendaftaran.pasien p', 'p.kode=r.pasien_kode')
            ->andWhere([
                'BETWEEN',
                'lp.tgl_masuk',
                date('Y-m-d', strtotime($params['tgl'])) . " 00:00:00",
                date('Y-m-d', strtotime($params['tgl'])) . " 23:59:59"
            ]);

        if ($params['unit'] != '') {
            $query->andWhere([
                'lp.unit_asal_kode' => $params['unit']
            ]);
        }

        if ($params['dokter'] != '') {
            $query->andWhere([
                'lpo.dokter_id' => $params['dokter']
            ]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5
            ],
            'sort' => [
                'attributes' => ['created_at']
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'r.pasien_kode' => $this->pasien_kode,
            'p.nama' => $this->pasien_nama,
        ]);

        $query->andFilterWhere(['ilike', 'r.pasien_kode', $this->pasien_kode])
            ->andFilterWhere(['ilike', 'p.nama', $this->pasien_nama]);

        return $dataProvider;
    }
}
