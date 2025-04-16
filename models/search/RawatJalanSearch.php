<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Registrasi;

class RawatJalanSearch extends Model
{
    public $tanggal_awal;
    public $tanggal_akhir;
    public $tanggal_final;
    public $closing;
    public $checkout;
    public $unit_kode;
    public $tgl_masuk;

    public $kode;
    public $pasien;

    public function rules()
    {
        return [
            [['tanggal_awal', 'tanggal_akhir', 'pasien', 'tgl_masuk'], 'safe'],
            [['closing', 'checkout', 'unit_kode'], 'integer'],
        ];
    }

    public function search($params)
    {
        $query = (new \yii\db\Query())
            ->select([
                'r.kode',
                'r.pasien_kode',
                'p.nama',
                'r.tgl_masuk',
                'r.tgl_keluar',

                'array_agg(dup.nama) AS poli',
                'r.is_claim',
                'r.is_pelaporan',
                'r.is_claim_ri',
                'r.is_pelaporan_ri',
                'rmr.layanan_id'
            ])
            ->from('pendaftaran.registrasi r')
            ->innerJoin('pendaftaran.layanan l', 'l.registrasi_kode = r.kode')
            ->innerJoin('pendaftaran.pasien p', 'r.pasien_kode = p.kode')
            ->innerJoin('pegawai.dm_unit_penempatan dup', 'l.unit_kode = dup.kode')
            ->innerJoin('medis.resume_medis_rj rmr', 'rmr.layanan_id = l.id');

        $this->load($params);

        if (!$this->tgl_masuk) {
            $tgl_masuk = date('Y-m-d');
        } else {
            $tgl_masuk = $this->tgl_masuk;
        }



        $query->andWhere(['between', 'r.tgl_masuk', $tgl_masuk . ' 00:00:00', $tgl_masuk . ' 23:59:59']);






        if ($this->unit_kode) {
            $query->andWhere(['l.unit_kode' => $this->unit_kode]);
        }
        if ($this->pasien) {

            $query->andWhere([
                'or',
                ['ilike', 'p.kode', $this->pasien],
                ['ilike', 'p.nama', $this->pasien],
                ['ilike', 'r.kode', $this->pasien],
            ]);
        }

        $query->groupBy(['r.kode', 'p.nama', 'rmr.layanan_id']);
        $query->orderBy(['r.tgl_masuk' => SORT_DESC]);

        $provider = new \yii\data\ArrayDataProvider([
            'allModels' => $query->all(),
            'pagination' => ['pageSize' => 10],
            'sort' => [
                'attributes' => ['kode', 'nama', 'tgl_masuk'],
            ],
        ]);

        return $provider;
    }
}
