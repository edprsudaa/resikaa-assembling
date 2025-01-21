<?php

namespace app\models\search;

use app\models\FilterHeader;
use app\models\medis\LabPaOrder;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\medis\LabPkOrder;
use app\models\medis\RadOrder;
use app\models\sso\AksesUnit;
use Yii;
use yii\db\Expression;

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
                'lpo.id',
                'lpo.layanan_id',
                'lpo.dokter_id',
                'lpo.no_transaksi',
                'lpo.created_at',
                'lpo.layanan_id_penunjang',
                'lpo.ird',
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

        $data = AksesUnit::getUserAksesUnit(Yii::$app->user->identity->getId());
        $cek = AksesUnit::cekAkses(275, $data);
        $cekIrd = AksesUnit::cekAkses(318, $data);

        if ($cek && !$cekIrd) {
            $query->andWhere(['lpo.ird' => 0]);
        } elseif (!$cek && $cekIrd) {
            $query->andWhere(['lpo.ird' => 1]);
        }

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
