<?php

namespace app\models\search;

use app\models\medis\TarifTindakanPasien;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TarifTindakanPasienSearch represents the model behind the search form of `app\models\postgre\TarifTindakanPasien`.
 */
class TarifTindakanPasienSearch extends TarifTindakanPasien
{
    public $deskripsi;

    public function rules()
    {
        return [
            [['id', 'layanan_id', 'pelaksana_id', 'tarif_tindakan_id', 'cyto', 'jumlah', 'harga', 'subtotal', 'pembayaran_id', 'is_lis', 'is_pac', 'created_by', 'updated_by', 'is_deleted', 'no_tran_penunjang'], 'integer'],
            [['tanggal', 'keterangan', 'no_permintaan_alat', 'created_at', 'updated_at', 'log_data', 'deskripsi', 'dokter_nama'], 'safe'],
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

    public function search($params, $layanan)
    {
        $query = TarifTindakanPasien::find()->alias('tp')
            ->select([
                "tp.id",
                "t.deskripsi",
                "tp.jumlah",
                "tp.harga",
                "tp.cyto",
                "tp.subtotal",
                "tp.pelaksana_id",
                "tp.layanan_id",
                "tp.tarif_tindakan_id",
            ])
            ->leftJoin('medis.tarif_tindakan tt', 'tt.id=tp.tarif_tindakan_id')
            ->leftJoin('medis.tindakan t', 't.id=tt.tindakan_id')
            ->leftJoin('pegawai.tb_pegawai dok', 'dok.pegawai_id=tp.pelaksana_id');

        // add conditions that should always apply here
        $query->andWhere(['tp.layanan_id' => $layanan]);

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
            'layanan_id' => $this->layanan_id,
            'pelaksana_id' => $this->pelaksana_id,
            'tarif_tindakan_id' => $this->tarif_tindakan_id,
            'tanggal' => $this->tanggal,
            'cyto' => $this->cyto,
            'jumlah' => $this->jumlah,
            'harga' => $this->harga,
            'subtotal' => $this->subtotal,
            'pembayaran_id' => $this->pembayaran_id,
            'is_lis' => $this->is_lis,
            'is_pac' => $this->is_pac,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
            'no_tran_penunjang' => $this->no_tran_penunjang,
        ]);

        $query->andFilterWhere(['ilike', 'keterangan', $this->keterangan])
            ->andFilterWhere(['ilike', 'no_permintaan_alat', $this->no_permintaan_alat])
            ->andFilterWhere(['ilike', 'log_data', $this->log_data]);

        return $dataProvider;
    }

    public function searchByRegistrasi($params, $kode_reg)
    {
        $query = TarifTindakanPasien::find()->alias('tp')
            ->select([
                "tp.id",
                "t.deskripsi",
                "tp.jumlah",
                "tp.harga",
                "tp.cyto",
                "tp.subtotal",
                "tp.pelaksana_id",
                "tp.layanan_id",
                "tp.tarif_tindakan_id",
            ])
            ->leftJoin('medis.tarif_tindakan tt', 'tt.id=tp.tarif_tindakan_id')
            ->leftJoin('medis.tindakan t', 't.id=tt.tindakan_id')
            ->leftJoin('pendaftaran.layanan l', 'l.id=tp.layanan_id')
            ->leftJoin('pegawai.tb_pegawai dok', 'dok.pegawai_id=tp.pelaksana_id');

        // add conditions that should always apply here
        $query->andWhere(['l.registrasi_kode' => $kode_reg]);

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
            'layanan_id' => $this->layanan_id,
            'pelaksana_id' => $this->pelaksana_id,
            'tarif_tindakan_id' => $this->tarif_tindakan_id,
            'tanggal' => $this->tanggal,
            'cyto' => $this->cyto,
            'jumlah' => $this->jumlah,
            'harga' => $this->harga,
            'subtotal' => $this->subtotal,
            'pembayaran_id' => $this->pembayaran_id,
            'is_lis' => $this->is_lis,
            'is_pac' => $this->is_pac,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
            'no_tran_penunjang' => $this->no_tran_penunjang,
        ]);

        $query->andFilterWhere(['ilike', 'keterangan', $this->keterangan])
            ->andFilterWhere(['ilike', 'no_permintaan_alat', $this->no_permintaan_alat])
            ->andFilterWhere(['ilike', 'log_data', $this->log_data]);

        return $dataProvider;
    }
}
