<?php

namespace app\models\medis;

use Yii;
use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;
use app\models\medis\AsesmenHemodialisaDetail;

class AsesmenHemodialisa extends BaseModelAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.asesmen_hemodialisa_awal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['layanan_id', 'perawat_id'], 'required'],
            [['layanan_id', 'perawat_id', 'perawat_vaskuler', 'perawat_evaluasi', 'perawat_final', 'perawat_batal', 'perawat_cetak', 'batal', 'draf', 'created_by', 'updated_by', 'is_deleted','id_dokumen_rme'], 'default', 'value' => null],
            [['layanan_id', 'perawat_id', 'perawat_vaskuler', 'perawat_evaluasi', 'perawat_final', 'perawat_batal', 'perawat_cetak', 'batal', 'draf', 'created_by', 'updated_by', 'is_deleted','id_dokumen_rme'], 'integer'],
            [['tanggal_batal', 'tanggal_final', 'created_at', 'updated_at','diagnosa_keperawatan', 'intervensi_keperawatan','komplikasi_hd','tanggal_cetak','tanggal_vaskuler','tanggal_evaluasi','tanggal_pengkajian'], 'safe'],
            [['log_data', 'jenis_asesmen', 'cara_bayar', 'dx_medis', 'riw_alergi_obat', 'keluhan_utama', 'nyeri', 'skor', 'kondisi', 'keadaan_umum', 'tekanan_darah', 'map', 'nadi', 'frekuwensi_nadi', 'respirasi', 'frekuwensi_respirasi', 'konjungtiva', 'ekstrimitas_oedema','ekstrimitas_dehidrasi','ekstrimitas_pucat', 'bb_post_hd_lalu', 'posisi_cdl', 'bb_pre_hd', 'bb_kering', 'bb_diturunkan', 'bb_post_hd', 'akses_vaskular', 'riwayat_jatuh', 'diagnosis_sekunder', 'alat_bantu', 'terapi_heparin', 'cara_jalan', 'status_mental', 'pemeriksaan_penunjang', 'gizi_tanggal', 'gizi_mis_skor', 'gizi_sga_skor', 'gizi_kesimpulan', 'keyakinan_tradisional', 'kendala_komunikasi', 'merawat_dirumah', 'kondisi_saat_ini',  'intervensi_kolaborasi', 'catatan_lain',  'obat', 'catatan_medis', 'evaluasi_keperawatan','skala_nyeri','lokasi_nyeri','durasi_nyeri','versi'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'layanan_id' => 'Layanan ID',
            'perawat_id' => 'Perawat ID',
            'batal' => 'Batal',
            'tanggal_batal' => 'Tanggal Batal',
            'draf' => 'Draf',
            'tanggal_final' => 'Tanggal Final',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'log_data' => 'Log Data',
            'is_deleted' => 'Is Deleted',
            'jenis_asesmen' => 'Jenis Asesmen',
            'cara_bayar' => 'Cara Bayar',
            'dx_medis' => 'Dx Medis',
            'riw_alergi_obat' => 'Riw Alergi Obat',
            'keluhan_utama' => 'Keluhan Utama',
            'nyeri' => 'Nyeri',
            'skor' => 'Skor',
            'kondisi' => 'Kondisi',
            'keadaan_umum' => 'Keadaan Umum',
            'tekanan_darah' => 'Tekanan Darah',
            'map' => 'Map',
            'nadi' => 'Nadi',
            'frekuwensi_nadi' => 'Frekuwensi Nadi',
            'respirasi' => 'Respirasi',
            'frekuwensi_respirasi' => 'Frekuwensi Respirasi',
            'konjungtiva' => 'Konjungtiva',
            'ekstrimitas' => 'Ekstrimitas',
            'bb_pre_hd' => 'Bb Pre Hd',
            'bb_kering' => 'Bb Kering',
            'bb_diturunkan' => 'Bb Diturunkan',
            'bb_post_hd' => 'Bb Post Hd',
            'akses_vaskular' => 'Akses Vaskular',
            'riwayat_jatuh' => 'Riwayat Jatuh',
            'diagnosis_sekunder' => 'Diagnosis Sekunder',
            'alat_bantu' => 'Alat Bantu',
            'terapi_heparin' => 'Terapi Heparin',
            'cara_jalan' => 'Cara Jalan',
            'status_mental' => 'Status Mental',
            'pemeriksaan_penunjang' => 'Pemeriksaan Penunjang',
            'gizi_tanggal' => 'Gizi Tanggal',
            'gizi_mis_skor' => 'Gizi Mis Skor',
            'gizi_sga_skor' => 'Gizi Sga Skor',
            'gizi_kesimpulan' => 'Gizi Kesimpulan',
            'keyakinan_tradisional' => 'Keyakinan Tradisional',
            'kendala_komunikasi' => 'Kendala Komunikasi',
            'merawat_dirumah' => 'Merawat Dirumah',
            'kondisi_saat_ini' => 'Kondisi Saat Ini',
            'diagnosa_keperawatan' => 'Diagnosa Keperawatan',
            'intervensi_keperawatan' => 'Intervensi Keperawatan',
            'intervensi_kolaborasi' => 'Intervensi Kolaborasi',
            'catatan_lain' => 'Catatan Lain',
            'komplikasi_hd' => 'Komplikasi Hd',
            'obat' => 'Obat',
            'catatan_medis' => 'Catatan Medis',
        ];
    }

    public function beforeSave($insert) {
        
        // if (parent::beforeSave($insert)) {
        //     if (is_array($this->diagnosa_keperawatan)) {
        //         $this->diagnosa_keperawatan = implode(',', $this->diagnosa_keperawatan);
        //     }
        //     if (is_array($this->intervensi_keperawatan)) {
        //         $this->intervensi_keperawatan = implode(',', $this->intervensi_keperawatan);
        //     }
        //     return true;
        // } else {
        //     return false;
        // }

        
        if ($insert) {
            $this->batal = 0;
            $this->draf = 1;
            $this->is_deleted = 0;
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->tanggal_pengkajian = Yii::$app->formatter->asDateTime($this->tanggal_pengkajian, 'php:d-m-Y H:i');

    }

    public static function find()
    {
        return new AsesmenHemodialisaQuery(get_called_class());
    }
    public function getPerawat()
    {
        return $this->hasOne(TbPegawai::className(),['pegawai_id'=>'perawat_id']);
    }
    public function getPerawatVaskuler()
    {
        return $this->hasOne(TbPegawai::className(),['pegawai_id'=>'perawat_vaskuler']);
    }
    public function getPerawatEvaluasi()
    {
        return $this->hasOne(TbPegawai::className(),['pegawai_id'=>'perawat_evaluasi']);
    }
    public function getPerawatFinal()
    {
        return $this->hasOne(TbPegawai::className(),['pegawai_id'=>'perawat_final']);
    }

    public function getLayanan()
    {
        return $this->hasOne(Layanan::className(),['id'=>'layanan_id']);
    }

    public function getAsesmenAwalDetail()
    {
        return $this->hasMany(AsesmenHemodialisaDetail::className(), ['asesmen_awal_id' => 'id'])
                ->with([
                    'petugas',          // Mengambil relasi `petugas` pada `AsesmenHemodialisaDetail`
                ]);
    }

    
    

}




