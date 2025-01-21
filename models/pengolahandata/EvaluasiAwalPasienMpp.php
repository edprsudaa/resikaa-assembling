<?php

namespace app\models\pengolahandata;

use Yii;

use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;

/**
 * This is the model class for table "evaluasi_awal_pasien_mpp".
 *
 * @property int $id
 * @property string $registrasi_kode
 * @property int $layanan_id
 * @property int $mpp_id
 * @property string|null $fisik_fungsional_kognitif_kekuatan_mandiri
 * @property string|null $riwayat_kesehatan
 * @property string|null $perilaku_psikososio_kultural
 * @property string|null $kesehatan_mental
 * @property string|null $dukungan_keluarga_kemampuan_merawat
 * @property string|null $finansial_status_asuransi
 * @property string|null $riwayat_penggunaan_obat_alternatif_pengobatan
 * @property string|null $riwayat_trauma_kekerasan
 * @property string|null $pemahaman_tentang_kesehatan
 * @property string|null $harapan_hasil_asuhan_kemampuan_menerima_perubahan
 * @property string|null $aspek_legalitas
 * @property string|null $asesmen_lainnya
 * @property string|null $asuhan_tidak_sesuai_panduan
 * @property string|null $over_under_utilization_pelayanan_dasar_panduan
 * @property string|null $ketidakpatuhan_pasien
 * @property string|null $edukasi_kurang_memadai_tentang_penyakit_kondisi_kini_obat_nutri
 * @property string|null $kurang_dukungan_keluarga
 * @property string|null $penurunan_determinasi_pasien
 * @property string|null $kendala_keuangan
 * @property string|null $pemulangan_rujukan_bermasalah
 * @property string|null $identifikasi_masalah_lainnya
 * @property string|null $penggunaan_alat_medis
 * @property string|null $tatalaksana_medis
 * @property string|null $komplikasi
 * @property string|null $gejalan_perburukan
 * @property string|null $pemeriksaan_diagnostik
 * @property string|null $perkembangan_penyakit
 * @property string|null $rencana_pengobatan_dirumah
 * @property string|null $management_nyeri
 * @property string|null $aktivitas_istirahat
 * @property string|null $modifikasi_perilaku_lingkungan
 * @property string|null $personal_hygiene
 * @property string|null $management_resiko_jatuh
 * @property string|null $perawatan_luka
 * @property string|null $management_cemas_stress
 * @property string|null $pembrrian_nutrisi_ngt
 * @property string|null $pemeriksaan_rutin_dilakukan
 * @property string|null $obat_obatan_yang_digunakan
 * @property string|null $indikasi_obat
 * @property string|null $efek_samping_obat
 * @property string|null $cara_waktu_lama_makan_obat
 * @property string|null $cara_konsumsi_obat
 * @property string|null $modifikasi_diet
 * @property string|null $rehabilitation_medis
 * @property string|null $home_training
 * @property string|null $laboratorium
 * @property string|null $radiologi
 * @property string|null $petugas_asuransi_kesehatan
 * @property string|null $rohaniawan
 * @property string|null $fasilitas_kesehatan
 * @property int $batal
 * @property string|null $tanggal_batal
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $log_data
 * @property int $is_deleted
 */
class EvaluasiAwalPasienMpp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evaluasi_awal_pasien_mpp';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_pengolahan_data');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['layanan_id', 'mpp_id', 'batal', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['layanan_id', 'mpp_id', 'batal', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['fisik_fungsional_kognitif_kekuatan_mandiri', 'riwayat_kesehatan', 'perilaku_psikososio_kultural', 'kesehatan_mental', 'dukungan_keluarga_kemampuan_merawat', 'finansial_status_asuransi', 'riwayat_penggunaan_obat_alternatif_pengobatan', 'riwayat_trauma_kekerasan', 'pemahaman_tentang_kesehatan', 'harapan_hasil_asuhan_kemampuan_menerima_perubahan', 'aspek_legalitas', 'asesmen_lainnya', 'asuhan_tidak_sesuai_panduan', 'over_under_utilization_pelayanan_dasar_panduan', 'ketidakpatuhan_pasien', 'edukasi_kurang_memadai_tentang_penyakit_kondisi_kini_obat_nutri', 'kurang_dukungan_keluarga', 'penurunan_determinasi_pasien', 'kendala_keuangan', 'pemulangan_rujukan_bermasalah', 'identifikasi_masalah_lainnya', 'penggunaan_alat_medis', 'tatalaksana_medis', 'komplikasi', 'gejalan_perburukan', 'pemeriksaan_diagnostik', 'perkembangan_penyakit', 'rencana_pengobatan_dirumah', 'management_nyeri', 'aktivitas_istirahat', 'modifikasi_perilaku_lingkungan', 'personal_hygiene', 'management_resiko_jatuh', 'perawatan_luka', 'management_cemas_stress', 'pembrrian_nutrisi_ngt', 'pemeriksaan_rutin_dilakukan', 'obat_obatan_yang_digunakan', 'indikasi_obat', 'efek_samping_obat', 'cara_waktu_lama_makan_obat', 'cara_konsumsi_obat', 'modifikasi_diet', 'rehabilitation_medis', 'home_training', 'laboratorium', 'radiologi', 'petugas_asuransi_kesehatan', 'rohaniawan', 'fasilitas_kesehatan', 'log_data'], 'string'],
            [['tanggal_batal', 'created_at', 'updated_at'], 'safe'],
            [['registrasi_kode'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'registrasi_kode' => 'Registrasi Kode',
            'layanan_id' => 'Layanan ID',
            'mpp_id' => 'Mpp ID',
            'fisik_fungsional_kognitif_kekuatan_mandiri' => 'Fisik Fungsional Kognitif Kekuatan Mandiri',
            'riwayat_kesehatan' => 'Riwayat Kesehatan',
            'perilaku_psikososio_kultural' => 'Perilaku Psikososio Kultural',
            'kesehatan_mental' => 'Kesehatan Mental',
            'dukungan_keluarga_kemampuan_merawat' => 'Dukungan Keluarga Kemampuan Merawat',
            'finansial_status_asuransi' => 'Finansial Status Asuransi',
            'riwayat_penggunaan_obat_alternatif_pengobatan' => 'Riwayat Penggunaan Obat Alternatif Pengobatan',
            'riwayat_trauma_kekerasan' => 'Riwayat Trauma Kekerasan',
            'pemahaman_tentang_kesehatan' => 'Pemahaman Tentang Kesehatan',
            'harapan_hasil_asuhan_kemampuan_menerima_perubahan' => 'Harapan Hasil Asuhan Kemampuan Menerima Perubahan',
            'aspek_legalitas' => 'Aspek Legalitas',
            'asesmen_lainnya' => 'Asesmen Lainnya',
            'asuhan_tidak_sesuai_panduan' => 'Asuhan Tidak Sesuai Panduan',
            'over_under_utilization_pelayanan_dasar_panduan' => 'Over Under Utilization Pelayanan Dasar Panduan',
            'ketidakpatuhan_pasien' => 'Ketidakpatuhan Pasien',
            'edukasi_kurang_memadai_tentang_penyakit_kondisi_kini_obat_nutri' => 'Edukasi Kurang Memadai Tentang Penyakit Kondisi Kini Obat Nutri',
            'kurang_dukungan_keluarga' => 'Kurang Dukungan Keluarga',
            'penurunan_determinasi_pasien' => 'Penurunan Determinasi Pasien',
            'kendala_keuangan' => 'Kendala Keuangan',
            'pemulangan_rujukan_bermasalah' => 'Pemulangan Rujukan Bermasalah',
            'identifikasi_masalah_lainnya' => 'Identifikasi Masalah Lainnya',
            'penggunaan_alat_medis' => 'Penggunaan Alat Medis',
            'tatalaksana_medis' => 'Tatalaksana Medis',
            'komplikasi' => 'Komplikasi',
            'gejalan_perburukan' => 'Gejalan Perburukan',
            'pemeriksaan_diagnostik' => 'Pemeriksaan Diagnostik',
            'perkembangan_penyakit' => 'Perkembangan Penyakit',
            'rencana_pengobatan_dirumah' => 'Rencana Pengobatan Dirumah',
            'management_nyeri' => 'Management Nyeri',
            'aktivitas_istirahat' => 'Aktivitas Istirahat',
            'modifikasi_perilaku_lingkungan' => 'Modifikasi Perilaku Lingkungan',
            'personal_hygiene' => 'Personal Hygiene',
            'management_resiko_jatuh' => 'Management Resiko Jatuh',
            'perawatan_luka' => 'Perawatan Luka',
            'management_cemas_stress' => 'Management Cemas Stress',
            'pembrrian_nutrisi_ngt' => 'Pembrrian Nutrisi Ngt',
            'pemeriksaan_rutin_dilakukan' => 'Pemeriksaan Rutin Dilakukan',
            'obat_obatan_yang_digunakan' => 'Obat Obatan Yang Digunakan',
            'indikasi_obat' => 'Indikasi Obat',
            'efek_samping_obat' => 'Efek Samping Obat',
            'cara_waktu_lama_makan_obat' => 'Cara Waktu Lama Makan Obat',
            'cara_konsumsi_obat' => 'Cara Konsumsi Obat',
            'modifikasi_diet' => 'Modifikasi Diet',
            'rehabilitation_medis' => 'Rehabilitation Medis',
            'home_training' => 'Home Training',
            'laboratorium' => 'Laboratorium',
            'radiologi' => 'Radiologi',
            'petugas_asuransi_kesehatan' => 'Petugas Asuransi Kesehatan',
            'rohaniawan' => 'Rohaniawan',
            'fasilitas_kesehatan' => 'Fasilitas Kesehatan',
            'batal' => 'Batal',
            'tanggal_batal' => 'Tanggal Batal',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'log_data' => 'Log Data',
            'is_deleted' => 'Is Deleted',
        ];
    }
    function beforeSave($model)
    {
        if ($this->isNewRecord) {
            $this->created_at = date('Y-m-d H:i:s');
            $this->created_by = Yii::$app->user->identity->id;
            $this->batal = 0;
            $this->is_deleted = 0;
        } else {
            $this->updated_at = date('Y-m-d H:i:s');
            $this->updated_by = Yii::$app->user->identity->id;
        }
        return parent::beforeSave($model);
    }
    public function getMpp()
    {
        return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'mpp_id']);
    }
    public function getLayanan()
    {
        return $this->hasOne(Layanan::className(), ['id' => 'layanan_id']);
    }
}
