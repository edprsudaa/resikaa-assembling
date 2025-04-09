<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Registrasi;

class RawatInapSearch extends Model
{
    public $tanggal_awal;
    public $tanggal_akhir;
    public $tanggal_final;
    public $closing;
    public $checkout;
    public $unit_kode;
    public $tgl_pulang;

    public $kode;
    public $pasien;

    public function rules()
    {
        return [
            [['tanggal_awal', 'tanggal_akhir', 'pasien', 'tgl_pulang'], 'safe'],
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
                'r.is_closing_billing_ranap',
                'r.closing_billing_ranap_by',
                'r.closing_billing_ranap_at',
                'rmr.tgl_pulang',
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
            ->leftJoin('medis.resume_medis_ri rmr', 'rmr.layanan_id = l.id');

        $this->load($params);

        $tgl_pulang = $this->tgl_pulang ?: date('Y-m-d');
        $query->andWhere(['between', 'rmr.tgl_pulang', $tgl_pulang . ' 00:00:00', $tgl_pulang . ' 23:59:59']);

        if (is_numeric($this->closing)) {
            $query->andWhere(['r.is_closing_billing_ranap' => (int)$this->closing]);
        }

        if (is_numeric($this->checkout)) {
            if ((int)$this->checkout === 0) {
                $query->andWhere(['r.tgl_keluar' => null]);
            } else {
                $query->andWhere(['not', ['r.tgl_keluar' => null]]);
            }
        }


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

        $query->groupBy(['r.kode', 'p.nama', 'rmr.tgl_pulang', 'rmr.layanan_id']);
        $query->orderBy(['rmr.tgl_pulang' => SORT_DESC]);

        $provider = new \yii\data\ArrayDataProvider([
            'allModels' => $query->all(),
            'pagination' => ['pageSize' => 10],
            'sort' => [
                'attributes' => ['kode', 'nama', 'tgl_pulang', 'tgl_keluar'],
            ],
        ]);

        return $provider;
    }
}
