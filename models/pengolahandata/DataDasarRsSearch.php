<?php

namespace app\models\pengolahandata;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pengolahandata\DataDasarRs;

/**
 * DataDasarRsSearch represents the model behind the search form of `app\models\pengolahandata\DataDasarRs`.
 */
class DataDasarRsSearch extends DataDasarRs
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data_dasar_rs_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['tahun', 'nomor_kode_rs', 'tanggal_registrasi', 'nama_rs', 'jenis_rs', 'kepemilikan_rs', 'kelas_rs', 'nama_direktur_rs', 'nama_penyelenggara_rs', 'alamat_rs', 'kab_kota_rs', 'kode_pos_rs', 'telepon_rs', 'fax_rs', 'email_rs', 'telepon_humas_rs', 'website_rs', 'luas_tanah_rs', 'luas_bangunan_rs', 'no_surat_izin_rs', 'tanggal_surat_izin_rs', 'oleh_surat_izin_rs', 'sifat_surat_izin_rs', 'masa_berlaku_surat_izin_rs', 'status_penyelenggaran_swasta', 'akreditasi_rs', 'pentahapan_akreditasi_rs', 'status_akreditasi_rs', 'tanggal_akreditasi_rs', 'perinatologi', 'kelas_vvip', 'kelas_vip', 'kelas_i', 'kelas_ii', 'kelas_iii', 'icu', 'picu', 'nicu', 'hcu', 'iccu', 'ruang_isolasi', 'ruang_ugd', 'ruang_bersalin', 'ruang_operasi', 'dr_sp_a', 'dr_sp_og', 'dr_sp_pd', 'dr_sp_b', 'dr_sp_rad', 'dr_sp_rm', 'dr_sp_an', 'dr_sp_jp', 'dr_sp_m', 'dr_sp_tht', 'dr_sp_kj', 'dr_sp_p', 'dr_sp_pk', 'dr_sp_p_d', 'dr_sp_s', 'dokter_sub_spesialis', 'dokter_spesialis_lain', 'dokter_umum', 'dokter_gigi', 'perawat', 'bidan', 'farmasi', 'tenaga_kesehatan_lainnya', 'jumlah_non_tenaga_kesehatan', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
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
        $query = DataDasarRs::find();

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
            'data_dasar_rs_id' => $this->data_dasar_rs_id,
            'tanggal_registrasi' => $this->tanggal_registrasi,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['ilike', 'tahun', $this->tahun])
            ->andFilterWhere(['ilike', 'nomor_kode_rs', $this->nomor_kode_rs])
            ->andFilterWhere(['ilike', 'nama_rs', $this->nama_rs])
            ->andFilterWhere(['ilike', 'jenis_rs', $this->jenis_rs])
            ->andFilterWhere(['ilike', 'kepemilikan_rs', $this->kepemilikan_rs])
            ->andFilterWhere(['ilike', 'kelas_rs', $this->kelas_rs])
            ->andFilterWhere(['ilike', 'nama_direktur_rs', $this->nama_direktur_rs])
            ->andFilterWhere(['ilike', 'nama_penyelenggara_rs', $this->nama_penyelenggara_rs])
            ->andFilterWhere(['ilike', 'alamat_rs', $this->alamat_rs])
            ->andFilterWhere(['ilike', 'kab_kota_rs', $this->kab_kota_rs])
            ->andFilterWhere(['ilike', 'kode_pos_rs', $this->kode_pos_rs])
            ->andFilterWhere(['ilike', 'telepon_rs', $this->telepon_rs])
            ->andFilterWhere(['ilike', 'fax_rs', $this->fax_rs])
            ->andFilterWhere(['ilike', 'email_rs', $this->email_rs])
            ->andFilterWhere(['ilike', 'telepon_humas_rs', $this->telepon_humas_rs])
            ->andFilterWhere(['ilike', 'website_rs', $this->website_rs])
            ->andFilterWhere(['ilike', 'luas_tanah_rs', $this->luas_tanah_rs])
            ->andFilterWhere(['ilike', 'luas_bangunan_rs', $this->luas_bangunan_rs])
            ->andFilterWhere(['ilike', 'no_surat_izin_rs', $this->no_surat_izin_rs])
            ->andFilterWhere(['ilike', 'tanggal_surat_izin_rs', $this->tanggal_surat_izin_rs])
            ->andFilterWhere(['ilike', 'oleh_surat_izin_rs', $this->oleh_surat_izin_rs])
            ->andFilterWhere(['ilike', 'sifat_surat_izin_rs', $this->sifat_surat_izin_rs])
            ->andFilterWhere(['ilike', 'masa_berlaku_surat_izin_rs', $this->masa_berlaku_surat_izin_rs])
            ->andFilterWhere(['ilike', 'status_penyelenggaran_swasta', $this->status_penyelenggaran_swasta])
            ->andFilterWhere(['ilike', 'akreditasi_rs', $this->akreditasi_rs])
            ->andFilterWhere(['ilike', 'pentahapan_akreditasi_rs', $this->pentahapan_akreditasi_rs])
            ->andFilterWhere(['ilike', 'status_akreditasi_rs', $this->status_akreditasi_rs])
            ->andFilterWhere(['ilike', 'tanggal_akreditasi_rs', $this->tanggal_akreditasi_rs])
            ->andFilterWhere(['ilike', 'perinatologi', $this->perinatologi])
            ->andFilterWhere(['ilike', 'kelas_vvip', $this->kelas_vvip])
            ->andFilterWhere(['ilike', 'kelas_vip', $this->kelas_vip])
            ->andFilterWhere(['ilike', 'kelas_i', $this->kelas_i])
            ->andFilterWhere(['ilike', 'kelas_ii', $this->kelas_ii])
            ->andFilterWhere(['ilike', 'kelas_iii', $this->kelas_iii])
            ->andFilterWhere(['ilike', 'icu', $this->icu])
            ->andFilterWhere(['ilike', 'picu', $this->picu])
            ->andFilterWhere(['ilike', 'nicu', $this->nicu])
            ->andFilterWhere(['ilike', 'hcu', $this->hcu])
            ->andFilterWhere(['ilike', 'iccu', $this->iccu])
            ->andFilterWhere(['ilike', 'ruang_isolasi', $this->ruang_isolasi])
            ->andFilterWhere(['ilike', 'ruang_ugd', $this->ruang_ugd])
            ->andFilterWhere(['ilike', 'ruang_bersalin', $this->ruang_bersalin])
            ->andFilterWhere(['ilike', 'ruang_operasi', $this->ruang_operasi])
            ->andFilterWhere(['ilike', 'dr_sp_a', $this->dr_sp_a])
            ->andFilterWhere(['ilike', 'dr_sp_og', $this->dr_sp_og])
            ->andFilterWhere(['ilike', 'dr_sp_pd', $this->dr_sp_pd])
            ->andFilterWhere(['ilike', 'dr_sp_b', $this->dr_sp_b])
            ->andFilterWhere(['ilike', 'dr_sp_rad', $this->dr_sp_rad])
            ->andFilterWhere(['ilike', 'dr_sp_rm', $this->dr_sp_rm])
            ->andFilterWhere(['ilike', 'dr_sp_an', $this->dr_sp_an])
            ->andFilterWhere(['ilike', 'dr_sp_jp', $this->dr_sp_jp])
            ->andFilterWhere(['ilike', 'dr_sp_m', $this->dr_sp_m])
            ->andFilterWhere(['ilike', 'dr_sp_tht', $this->dr_sp_tht])
            ->andFilterWhere(['ilike', 'dr_sp_kj', $this->dr_sp_kj])
            ->andFilterWhere(['ilike', 'dr_sp_p', $this->dr_sp_p])
            ->andFilterWhere(['ilike', 'dr_sp_pk', $this->dr_sp_pk])
            ->andFilterWhere(['ilike', 'dr_sp_p_d', $this->dr_sp_p_d])
            ->andFilterWhere(['ilike', 'dr_sp_s', $this->dr_sp_s])
            ->andFilterWhere(['ilike', 'dokter_sub_spesialis', $this->dokter_sub_spesialis])
            ->andFilterWhere(['ilike', 'dokter_spesialis_lain', $this->dokter_spesialis_lain])
            ->andFilterWhere(['ilike', 'dokter_umum', $this->dokter_umum])
            ->andFilterWhere(['ilike', 'dokter_gigi', $this->dokter_gigi])
            ->andFilterWhere(['ilike', 'perawat', $this->perawat])
            ->andFilterWhere(['ilike', 'bidan', $this->bidan])
            ->andFilterWhere(['ilike', 'farmasi', $this->farmasi])
            ->andFilterWhere(['ilike', 'tenaga_kesehatan_lainnya', $this->tenaga_kesehatan_lainnya])
            ->andFilterWhere(['ilike', 'jumlah_non_tenaga_kesehatan', $this->jumlah_non_tenaga_kesehatan]);

        return $dataProvider;
    }
}
