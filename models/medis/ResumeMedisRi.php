<?php

namespace app\models\medis;

use Yii;
use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;
use app\models\pegawai\DmUnitPenempatan;
use app\models\medis\Icd10cmv2;
use app\models\medis\Icd9cmv3;

/**
 * This is the model class for table "medis.resume_medis_ri".
 *
 * @property int $id
 * @property int $layanan_id
 * @property int $dokter_id
 * @property string|null $ringkasan_riwayat_penyakit
 * @property string|null $hasil_pemeriksaan_fisik
 * @property string|null $indikasi_rawat_inap
 * @property int|null $diagnosa_masuk_id
 * @property string|null $diagnosa_masuk_kode
 * @property string|null $diagnosa_masuk_deskripsi
 * @property int|null $diagnosa_utama_id
 * @property string|null $diagnosa_utama_kode
 * @property string|null $diagnosa_utama_deskripsi
 * @property int|null $diagnosa_tambahan1_id
 * @property string|null $diagnosa_tambahan1_kode
 * @property string|null $diagnosa_tambahan1_deskripsi
 * @property int|null $diagnosa_tambahan2_id
 * @property string|null $diagnosa_tambahan2_kode
 * @property string|null $diagnosa_tambahan2_deskripsi
 * @property int|null $diagnosa_tambahan3_id
 * @property string|null $diagnosa_tambahan3_kode
 * @property string|null $diagnosa_tambahan3_deskripsi
 * @property int|null $diagnosa_tambahan4_id
 * @property string|null $diagnosa_tambahan4_kode
 * @property string|null $diagnosa_tambahan4_deskripsi
 * @property int|null $diagnosa_tambahan5_id
 * @property string|null $diagnosa_tambahan5_kode
 * @property string|null $diagnosa_tambahan5_deskripsi
 * @property int|null $diagnosa_tambahan6_id
 * @property string|null $diagnosa_tambahan6_kode
 * @property string|null $diagnosa_tambahan6_deskripsi
 * @property int|null $tindakan_utama_id
 * @property string|null $tindakan_utama_kode
 * @property string|null $tindakan_utama_deskripsi
 * @property int|null $tindakan_tambahan1_id
 * @property string|null $tindakan_tambahan1_kode
 * @property string|null $tindakan_tambahan1_deskripsi
 * @property int|null $tindakan_tambahan2_id
 * @property string|null $tindakan_tambahan2_kode
 * @property string|null $tindakan_tambahan2_deskripsi
 * @property int|null $tindakan_tambahan3_id
 * @property string|null $tindakan_tambahan3_kode
 * @property string|null $tindakan_tambahan3_deskripsi
 * @property int|null $tindakan_tambahan4_id
 * @property string|null $tindakan_tambahan4_kode
 * @property string|null $tindakan_tambahan4_deskripsi
 * @property int|null $tindakan_tambahan5_id
 * @property string|null $tindakan_tambahan5_kode
 * @property string|null $tindakan_tambahan5_deskripsi
 * @property int|null $tindakan_tambahan6_id
 * @property string|null $tindakan_tambahan6_kode
 * @property string|null $tindakan_tambahan6_deskripsi
 * @property string|null $alergi
 * @property string|null $diet
 * @property string|null $alasan_pulang
 * @property string|null $kondisi_pulang
 * @property string|null $cara_pulang
 * @property int|null $gcs_e
 * @property int|null $gcs_m
 * @property int|null $gcs_v
 * @property string|null $tingkat_kesadaran
 * @property string|null $nadi
 * @property string|null $darah
 * @property string|null $pernapasan
 * @property int|null $suhu
 * @property int|null $sato2
 * @property int|null $berat_badan
 * @property int|null $tinggi_badan
 * @property string|null $keadaan_gizi
 * @property string|null $keadaan_umum
 * @property string|null $terapi_perawatan
 * @property string|null $obat_rumah
 * @property string|null $terapi_pulang
 * @property int $batal
 * @property int $draf
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $log_data
 * @property int $is_deleted
 */
class ResumeMedisRi extends BaseModelAR
{

    const judul = 'Resume Medis Rawat Inap';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.resume_medis_ri';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['layanan_id', 'dokter_id'], 'required'],
            [['layanan_id', 'dokter_id', 'diagnosa_masuk_id', 'diagnosa_utama_id', 'diagnosa_tambahan1_id', 'diagnosa_tambahan2_id', 'diagnosa_tambahan3_id', 'diagnosa_tambahan4_id', 'diagnosa_tambahan5_id', 'diagnosa_tambahan6_id', 'tindakan_utama_id', 'tindakan_tambahan1_id', 'tindakan_tambahan2_id', 'tindakan_tambahan3_id', 'tindakan_tambahan4_id', 'tindakan_tambahan5_id', 'tindakan_tambahan6_id', 'gcs_e', 'gcs_m', 'gcs_v', 'suhu', 'sato2', 'berat_badan', 'tinggi_badan', 'batal', 'draf', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['layanan_id', 'dokter_id', 'diagnosa_masuk_id', 'diagnosa_utama_id', 'diagnosa_tambahan1_id', 'diagnosa_tambahan2_id', 'diagnosa_tambahan3_id', 'diagnosa_tambahan4_id', 'diagnosa_tambahan5_id', 'diagnosa_tambahan6_id', 'tindakan_utama_id', 'tindakan_tambahan1_id', 'tindakan_tambahan2_id', 'tindakan_tambahan3_id', 'tindakan_tambahan4_id', 'tindakan_tambahan5_id', 'tindakan_tambahan6_id',  'batal', 'draf', 'created_by', 'updated_by', 'is_deleted', 'poli_tujuan_kontrol_id', 'sato2', 'layanan_pulang_id'], 'integer'],
            [['ringkasan_riwayat_penyakit', 'hasil_pemeriksaan_fisik', 'indikasi_rawat_inap', 'diagnosa_masuk_kode', 'diagnosa_masuk_deskripsi', 'diagnosa_utama_kode', 'diagnosa_utama_deskripsi', 'diagnosa_tambahan1_kode', 'diagnosa_tambahan1_deskripsi', 'diagnosa_tambahan2_kode', 'diagnosa_tambahan2_deskripsi', 'diagnosa_tambahan3_kode', 'diagnosa_tambahan3_deskripsi', 'diagnosa_tambahan4_kode', 'diagnosa_tambahan4_deskripsi', 'diagnosa_tambahan5_kode', 'diagnosa_tambahan5_deskripsi', 'diagnosa_tambahan6_kode', 'diagnosa_tambahan6_deskripsi', 'tindakan_utama_kode', 'tindakan_utama_deskripsi', 'tindakan_tambahan1_kode', 'tindakan_tambahan1_deskripsi', 'tindakan_tambahan2_kode', 'tindakan_tambahan2_deskripsi', 'tindakan_tambahan3_kode', 'tindakan_tambahan3_deskripsi', 'tindakan_tambahan4_kode', 'tindakan_tambahan4_deskripsi', 'tindakan_tambahan5_kode', 'tindakan_tambahan5_deskripsi', 'tindakan_tambahan6_kode', 'tindakan_tambahan6_deskripsi', 'gcs_e', 'gcs_m', 'gcs_v', 'suhu',  'berat_badan', 'tinggi_badan', 'alergi', 'diet', 'alasan_pulang', 'kondisi_pulang', 'cara_pulang', 'tingkat_kesadaran', 'nadi', 'darah', 'pernapasan', 'keadaan_gizi', 'keadaan_umum', 'terapi_perawatan', 'obat_rumah', 'terapi_pulang', 'log_data', 'hasil_penunjang', 'poli_tujuan_kontrol_nama', 'terapi_dirawat'], 'string'],
            [['created_at', 'updated_at', 'tanggal_batal', 'tanggal_final', 'tgl_kontrol', 'tgl_pulang'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'layanan_id' => 'Layanan',
            'dokter_id' => 'Dokter',
            'ringkasan_riwayat_penyakit' => 'Ringkasan Riwayat Penyakit',
            'hasil_pemeriksaan_fisik' => 'Hasil Pemeriksaan Fisik',
            'indikasi_rawat_inap' => 'Indikasi Rawat Inap',
            'diagnosa_masuk_id' => 'Diagnosa Masuk ID',
            'diagnosa_masuk_kode' => 'Diagnosa Masuk Kode',
            'diagnosa_masuk_deskripsi' => 'Diagnosa Masuk Deskripsi',
            'diagnosa_utama_id' => 'Diagnosa Utama ID',
            'diagnosa_utama_kode' => 'Diagnosa Utama Kode',
            'diagnosa_utama_deskripsi' => 'Diagnosa Utama Deskripsi',
            'diagnosa_tambahan1_id' => 'Diagnosa Tambahan1 ID',
            'diagnosa_tambahan1_kode' => 'Diagnosa Tambahan1 Kode',
            'diagnosa_tambahan1_deskripsi' => 'Diagnosa Tambahan1 Deskripsi',
            'diagnosa_tambahan2_id' => 'Diagnosa Tambahan2 ID',
            'diagnosa_tambahan2_kode' => 'Diagnosa Tambahan2 Kode',
            'diagnosa_tambahan2_deskripsi' => 'Diagnosa Tambahan2 Deskripsi',
            'diagnosa_tambahan3_id' => 'Diagnosa Tambahan3 ID',
            'diagnosa_tambahan3_kode' => 'Diagnosa Tambahan3 Kode',
            'diagnosa_tambahan3_deskripsi' => 'Diagnosa Tambahan3 Deskripsi',
            'diagnosa_tambahan4_id' => 'Diagnosa Tambahan4 ID',
            'diagnosa_tambahan4_kode' => 'Diagnosa Tambahan4 Kode',
            'diagnosa_tambahan4_deskripsi' => 'Diagnosa Tambahan4 Deskripsi',
            'diagnosa_tambahan5_id' => 'Diagnosa Tambahan5 ID',
            'diagnosa_tambahan5_kode' => 'Diagnosa Tambahan5 Kode',
            'diagnosa_tambahan5_deskripsi' => 'Diagnosa Tambahan5 Deskripsi',
            'diagnosa_tambahan6_id' => 'Diagnosa Tambahan6 ID',
            'diagnosa_tambahan6_kode' => 'Diagnosa Tambahan6 Kode',
            'diagnosa_tambahan6_deskripsi' => 'Diagnosa Tambahan6 Deskripsi',
            'tindakan_utama_id' => 'Tindakan Utama ID',
            'tindakan_utama_kode' => 'Tindakan Utama Kode',
            'tindakan_utama_deskripsi' => 'Tindakan Utama Deskripsi',
            'tindakan_tambahan1_id' => 'Tindakan Tambahan1 ID',
            'tindakan_tambahan1_kode' => 'Tindakan Tambahan1 Kode',
            'tindakan_tambahan1_deskripsi' => 'Tindakan Tambahan1 Deskripsi',
            'tindakan_tambahan2_id' => 'Tindakan Tambahan2 ID',
            'tindakan_tambahan2_kode' => 'Tindakan Tambahan2 Kode',
            'tindakan_tambahan2_deskripsi' => 'Tindakan Tambahan2 Deskripsi',
            'tindakan_tambahan3_id' => 'Tindakan Tambahan3 ID',
            'tindakan_tambahan3_kode' => 'Tindakan Tambahan3 Kode',
            'tindakan_tambahan3_deskripsi' => 'Tindakan Tambahan3 Deskripsi',
            'tindakan_tambahan4_id' => 'Tindakan Tambahan4 ID',
            'tindakan_tambahan4_kode' => 'Tindakan Tambahan4 Kode',
            'tindakan_tambahan4_deskripsi' => 'Tindakan Tambahan4 Deskripsi',
            'tindakan_tambahan5_id' => 'Tindakan Tambahan5 ID',
            'tindakan_tambahan5_kode' => 'Tindakan Tambahan5 Kode',
            'tindakan_tambahan5_deskripsi' => 'Tindakan Tambahan5 Deskripsi',
            'tindakan_tambahan6_id' => 'Tindakan Tambahan6 ID',
            'tindakan_tambahan6_kode' => 'Tindakan Tambahan6 Kode',
            'tindakan_tambahan6_deskripsi' => 'Tindakan Tambahan6 Deskripsi',
            'alergi' => 'Alergi',
            'diet' => 'Diet',
            'alasan_pulang' => 'Alasan Pulang',
            'kondisi_pulang' => 'Kondisi Pulang',
            'cara_pulang' => 'Cara Pulang',
            'gcs_e' => 'Gcs E',
            'gcs_m' => 'Gcs M',
            'gcs_v' => 'Gcs V',
            'tingkat_kesadaran' => 'Tingkat Kesadaran',
            'nadi' => 'Nadi',
            'darah' => 'Darah',
            'pernapasan' => 'Pernapasan',
            'suhu' => 'Suhu',
            'sato2' => 'Sato2',
            'berat_badan' => 'Berat Badan',
            'tinggi_badan' => 'Tinggi Badan',
            'keadaan_gizi' => 'Keadaan Gizi',
            'keadaan_umum' => 'Keadaan Umum',
            'terapi_perawatan' => 'Terapi Perawatan',
            'obat_rumah' => 'Obat Rumah',
            'terapi_pulang' => 'Terapi Pulang',
            'batal' => 'Batal',
            'draf' => 'Draf',
            'tanggal_batal' => 'Tanggal Batal',
            'tanggal_final' => 'Tanggal Final',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'log_data' => 'Log Data',
            'is_deleted' => 'Is Deleted',
            'hasil_penunjang' => 'Hasil Penunjang',
            'poli_tujuan_kontrol_id' => 'Id Poli Tujuan Kontrol',
            'poli_tujuan_kontrol_nama' => 'Nama Poli Tujuan Kontrol',
            'terapi_dirawat' => 'Terapi Dirawat',
            'layanan_pulang_id' => 'Ruangan Layanan Pulang',
        ];
    }
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->is_deleted = 0;
            $this->batal = 0;
            $this->draf = 1;
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
    /**
     * {@inheritdoc}
     * @return ResumeMedisRiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResumeMedisRiQuery(get_called_class());
    }
    public function getDokter()
    {
        return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'dokter_id']);
    }
    public function getLayanan()
    {
        return $this->hasOne(Layanan::className(), ['id' => 'layanan_id']);
    }
    public function getLayananPulang()
    {
        return $this->hasOne(Layanan::className(), ['id' => 'layanan_pulang_id']);
    }
    function getUnitTujuan()
    {
        return $this->hasOne(DmUnitPenempatan::className(), ['kode' => 'poli_tujuan_kontrol_id']);
    }
    //add new 030323
    function getDiagmasuk()
    {
        return $this->hasOne(Icd10cmv2::className(), ['id' => 'diagnosa_masuk_id']);
    }
    function getDiagutama()
    {
        return $this->hasOne(Icd10cmv2::className(), ['id' => 'diagnosa_utama_id']);
    }
    function getDiagsatu()
    {
        return $this->hasOne(Icd10cmv2::className(), ['id' => 'diagnosa_tambahan1_id']);
    }
    function getDiagdua()
    {
        return $this->hasOne(Icd10cmv2::className(), ['id' => 'diagnosa_tambahan2_id']);
    }
    function getDiagtiga()
    {
        return $this->hasOne(Icd10cmv2::className(), ['id' => 'diagnosa_tambahan3_id']);
    }
    function getDiagempat()
    {
        return $this->hasOne(Icd10cmv2::className(), ['id' => 'diagnosa_tambahan4_id']);
    }
    function getDiaglima()
    {
        return $this->hasOne(Icd10cmv2::className(), ['id' => 'diagnosa_tambahan5_id']);
    }
    function getDiagenam()
    {
        return $this->hasOne(Icd10cmv2::className(), ['id' => 'diagnosa_tambahan6_id']);
    }
    function getTindutama()
    {
        return $this->hasOne(Icd9cmv3::className(), ['id' => 'tindakan_utama_id']);
    }
    function getTindsatu()
    {
        return $this->hasOne(Icd9cmv3::className(), ['id' => 'tindakan_tambahan1_id']);
    }
    function getTinddua()
    {
        return $this->hasOne(Icd9cmv3::className(), ['id' => 'tindakan_tambahan2_id']);
    }
    function getTindtiga()
    {
        return $this->hasOne(Icd9cmv3::className(), ['id' => 'tindakan_tambahan3_id']);
    }
    function getTindempat()
    {
        return $this->hasOne(Icd9cmv3::className(), ['id' => 'tindakan_tambahan4_id']);
    }
    function getTindlima()
    {
        return $this->hasOne(Icd9cmv3::className(), ['id' => 'tindakan_tambahan5_id']);
    }
    function getTindenam()
    {
        return $this->hasOne(Icd9cmv3::className(), ['id' => 'tindakan_tambahan6_id']);
    }
}
