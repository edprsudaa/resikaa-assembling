<?php

namespace app\models\medis;

use app\models\FilterHeader;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\medis\LabPkOrder;

class LabPkOrderSearch extends LabPkOrder
{
    public $pasien_kode;
    public $pasien_nama;
    public $tanggal_penunjang;

    public function rules()
    {
        return [
            [['id', 'ird', 'layanan_id', 'dokter_id', 'created_by', 'updated_by', 'is_deleted', 'nomr', 'layanan_id_penunjang'], 'integer'],
            [['no_transaksi', 'diagnosa', 'kondisi_sampel', 'catatan', 'created_at', 'updated_at', 'log_data', 'pasien_kode', 'pasien_nama', 'tanggal_penunjang'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = LabPkOrder::find()->alias('lpo')
            ->select([
                'lpo.layanan_id_penunjang',
                'lpo.id',
                'lpo.layanan_id',
                'lpo.dokter_id',
                'lpo.no_transaksi',
                'lpo.created_at',
                'lpo.ird',
                'l.unit_kode',
                'l.registrasi_kode',
                'l.tgl_masuk',
                'up.nama',
                'r.pasien_kode',
                'p.nama'
            ])
            ->leftJoin('pendaftaran.layanan l', 'lpo.id=lpo.layanan_id')
            ->leftJoin('pegawai.dm_unit_penempatan up', 'up.kode=l.unit_kode')
            ->leftJoin('pendaftaran.registrasi r', 'r.kode=l.registrasi_kode')
            ->leftJoin('pendaftaran.pasien p', 'p.kode=r.pasien_kode')
            ->andWhere([
                'lpo.layanan_id_penunjang' => NULL
            ]);

        // if ($params['unit'] != '') {
        //     $query->andWhere([
        //         'l.unit_kode' => $params['unit']
        //     ]);
        // }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 4
            ],
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_ASC]
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

    public function searchAntrian($params, $cek)
    {
        if (isset($cek['pk'])) {
            $query[] = LabPkOrder::find()->alias('lpo')->select([
                'lpo.layanan_id_penunjang',
                'lpo.id',
                'lpo.layanan_id',
                'lpo.dokter_id',
                'lpo.no_transaksi',
                'lp.created_at',
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
                    'lp.created_at',
                    date('Y-m-d', strtotime($params['tgl'])) . " 00:00:00",
                    date('Y-m-d', strtotime($params['tgl'])) . " 23:59:59"
                ]);
        }
        if (isset($cek['pa'])) {
            $query[] = LabPaOrder::find()->alias('lpo')->select([
                'lpo.layanan_id_penunjang',
                'lpo.id',
                'lpo.layanan_id',
                'lpo.dokter_id',
                'lpo.no_transaksi',
                'lp.created_at',
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
                    'lp.created_at',
                    date('Y-m-d', strtotime($params['tgl'])) . " 00:00:00",
                    date('Y-m-d', strtotime($params['tgl'])) . " 23:59:59"
                ]);
        }
        if (isset($cek['rad'])) {
            $query[] = RadOrder::find()->alias('lpo')->select([
                'lpo.layanan_id_penunjang',
                'lpo.id',
                'lpo.layanan_id',
                'lpo.dokter_id',
                'lpo.no_transaksi',
                'lp.created_at',
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
                    'lp.created_at',
                    date('Y-m-d', strtotime($params['tgl'])) . " 00:00:00",
                    date('Y-m-d', strtotime($params['tgl'])) . " 23:59:59"
                ]);
        }

        if (count($query) == 1) {
            $queryAntrian = $query[0];
        } elseif (count($query) == 2) {
            $queryAntrian = $query[0]->union($query[1]);
        } else {
            $queryAntrian = $query[0]->union($query[1])->union($query[2]);
        }

        // if ($params['unit'] != '') {
        //     $queryAntrian->andWhere([
        //         'lp.unit_kode' => $params['unit']
        //     ]);
        // }

        // if ($params['dokter'] != '') {
        //     $queryAntrian->andWhere([
        //         'lpo.dokter_id' => $params['dokter']
        //     ]);
        // }

        $dataProvider = new ActiveDataProvider([
            'query' => $queryAntrian,
            'pagination' => [
                'pageSize' => 5
            ],
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_ASC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $queryAntrian->andFilterWhere([
            'r.pasien_kode' => $this->pasien_kode,
            'p.nama' => $this->pasien_nama,
        ]);

        $queryAntrian->andFilterWhere(['ilike', 'r.pasien_kode', $this->pasien_kode])
            ->andFilterWhere(['ilike', 'p.nama', $this->pasien_nama]);

        return $dataProvider;
    }
}
