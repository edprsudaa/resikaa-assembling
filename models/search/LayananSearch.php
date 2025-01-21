<?php

namespace app\models\search;

use app\models\pegawai\DmUnitPenempatan;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pendaftaran\Layanan;

/**
 * LayananSearch represents the model behind the search form of `app\models\pendaftaran\Layanan`.
 */
class LayananSearch extends Layanan
{
    public $noRm;
    public function rules()
    {
        return [
            [['id', 'jenis_layanan', 'unit_kode', 'nomor_urut', 'panggil_perawat', 'dipanggil_perawat', 'kamar_id', 'unit_asal_kode', 'unit_tujuan_kode', 'created_by', 'updated_by', 'deleted_by', 'panggil_dokter', 'dipanggil_dokter'], 'integer'],
            [['registrasi_kode', 'tgl_masuk', 'tgl_keluar', 'kelas_rawat_kode', 'cara_masuk_unit_kode', 'cara_keluar_kode', 'status_keluar_kode', 'keterangan', 'created_at', 'updated_at', 'deleted_at', 'noRm'], 'safe'],
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
        $cek = DmUnitPenempatan::cekAkses($params['unit']);
        if ($cek) {
            $query = Layanan::find()->alias('lp')->select([
                'lp.tgl_masuk',
                'lp.registrasi_kode',
                'lp.nomor_urut',
                'lp.panggil_dokter',
                'lp.deleted_by',
                'lpo.id',
                'lpo.layanan_id',
                'lpo.dokter_id',
                'lpo.no_transaksi',
                'lpo.layanan_id_penunjang',
                'up.nama as unitTujuan',
                'upa.nama as unitAsal',
                'p.nama as namaPasien',
                'pl.nama as namaPasienLuar',
                'r.pasien_kode as noRm',
                'lp.nomor_urut',
                'debd.nama as debiturNama',
                "coalesce(concat(dok.gelar_sarjana_depan, ' ') , '') || coalesce(dok.nama_lengkap, '') || coalesce(concat(' ', dok.gelar_sarjana_belakang), '') as dokterNama"
            ])
                ->leftJoin('pegawai.dm_unit_penempatan up', 'up.kode=lp.unit_kode')
                ->leftJoin('pegawai.dm_unit_penempatan upa', 'upa.kode=lp.unit_asal_kode')
                ->leftJoin('pendaftaran.registrasi r', 'r.kode=lp.registrasi_kode')
                ->leftJoin('pendaftaran.debitur_detail debd', 'debd.kode=r.debitur_detail_kode')
                ->leftJoin('pendaftaran.pasien p', 'p.kode=r.pasien_kode')
                ->leftJoin('pendaftaran.pasien_luar pl', 'pl.registrasi_kode=r.kode')
                ->leftJoin('penunjang_2.no_transaksi_order nto', 'nto.layanan_id=lp.id');
            if ($cek == 'pk') {
                $query->leftJoin('medis.lab_pk_order lpo', 'lpo.layanan_id_penunjang=lp.id')
                    ->leftJoin('pegawai.tb_pegawai dok', 'dok.pegawai_id=nto.dokter_id');
            } elseif ($cek == 'pa') {
                $query->leftJoin('medis.lab_pa_order lpo', 'lpo.layanan_id_penunjang=lp.id')
                    ->leftJoin('pegawai.tb_pegawai dok', 'dok.pegawai_id=nto.dokter_id');
            } else {
                $query->leftJoin('medis.rad_order lpo', 'lpo.layanan_id_penunjang=lp.id')
                    ->leftJoin('pegawai.tb_pegawai dok', 'dok.pegawai_id=nto.dokter_id');
            }
        } else {
            $query = Layanan::find()->alias('lp')->select([
                'lp.tgl_masuk',
                'lp.registrasi_kode',
                'lp.nomor_urut',
                'lp.id as layanan_id_penunjang',
                'up.nama as unitTujuan',
                'upa.nama as unitAsal',
                'p.nama as namaPasien',
                'pl.nama as namaPasienLuar',
                'r.pasien_kode as noRm',
                'lp.nomor_urut',
                'debd.nama as debiturNama',
                "coalesce(concat(dok.gelar_sarjana_depan, ' ') , '') || coalesce(dok.nama_lengkap, '') || coalesce(concat(' ', dok.gelar_sarjana_belakang), '') as dokterNama"
            ])
                ->leftJoin('pegawai.dm_unit_penempatan up', 'up.kode=lp.unit_kode')
                ->leftJoin('pegawai.dm_unit_penempatan upa', 'upa.kode=lp.unit_asal_kode')
                ->leftJoin('pendaftaran.registrasi r', 'r.kode=lp.registrasi_kode')
                ->leftJoin('pendaftaran.debitur_detail debd', 'debd.kode=r.debitur_detail_kode')
                ->leftJoin('pendaftaran.pasien p', 'p.kode=r.pasien_kode')
                ->leftJoin('pendaftaran.pasien_luar pl', 'pl.registrasi_kode=r.kode')
                ->leftJoin('penunjang_2.no_transaksi_order nto', 'nto.layanan_id=lp.id')
                ->leftJoin('pegawai.tb_pegawai dok', 'dok.pegawai_id=nto.dokter_id');
        }

        $query->andWhere([
            'BETWEEN',
            'lp.tgl_masuk',
            date('Y-m-d', strtotime($params['tgl'])) . " 00:00:00",
            date('Y-m-d', strtotime($params['tgl'])) . " 23:59:59"
        ])
            ->andWhere([
                'jenis_layanan' => 4,
                'lp.unit_kode' => $params['unit'],
            ]);

        // return $query->asArray()->all();
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
            'nomor_urut' => $this->nomor_urut,
        ]);

        $query->andFilterWhere(['ilike', 'p.kode', $this->noRm])
            ->andFilterWhere(['ilike', 'kelas_rawat_kode', $this->kelas_rawat_kode])
            ->andFilterWhere(['ilike', 'cara_masuk_unit_kode', $this->cara_masuk_unit_kode])
            ->andFilterWhere(['ilike', 'cara_keluar_kode', $this->cara_keluar_kode])
            ->andFilterWhere(['ilike', 'status_keluar_kode', $this->status_keluar_kode])
            ->andFilterWhere(['ilike', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }

    public function cekAksesUnit()
    {
        $userUnit = \Yii::$app->user->identity->getAksesUnit();
        $hasil = [
            'pa' => false,
            'pk' => false,
            'rad' => false
        ];
        foreach ($userUnit as $unit) {
            if ($unit['is_lab_pa'] == 1) {
                $hasil['pa'] = true;
            } elseif ($unit['is_lab_pk'] == 1) {
                $hasil['pk'] = true;
            } else {
                $hasil['rad'] = true;
            }
        }
        return $hasil;
    }
}
