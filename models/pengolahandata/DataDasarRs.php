<?php

namespace app\models\pengolahandata;

use Yii;

/**
 * This is the model class for table "data_dasar_rs".
 *
 * @property int $data_dasar_rs_id
 * @property string $tahun
 * @property string|null $nomor_kode_rs
 * @property string|null $tanggal_registrasi
 * @property string $nama_rs
 * @property string|null $jenis_rs
 * @property string|null $kepemilikan_rs
 * @property string|null $kelas_rs
 * @property string $nama_direktur_rs
 * @property string|null $nama_penyelenggara_rs
 * @property string $alamat_rs
 * @property string $kab_kota_rs
 * @property string $kode_pos_rs
 * @property string $telepon_rs
 * @property string $fax_rs
 * @property string $email_rs
 * @property string $telepon_humas_rs
 * @property string $website_rs
 * @property string $luas_tanah_rs
 * @property string $luas_bangunan_rs
 * @property string $no_surat_izin_rs
 * @property string $tanggal_surat_izin_rs
 * @property string $oleh_surat_izin_rs
 * @property string $sifat_surat_izin_rs
 * @property string $masa_berlaku_surat_izin_rs
 * @property string $status_penyelenggaran_swasta
 * @property string|null $akreditasi_rs
 * @property string|null $pentahapan_akreditasi_rs
 * @property string|null $status_akreditasi_rs
 * @property string|null $tanggal_akreditasi_rs
 * @property string|null $perinatologi
 * @property string|null $kelas_vvip
 * @property string|null $kelas_vip
 * @property string|null $kelas_i
 * @property string|null $kelas_ii
 * @property string|null $kelas_iii
 * @property string|null $icu
 * @property string|null $picu
 * @property string|null $nicu
 * @property string|null $hcu
 * @property string|null $iccu
 * @property string|null $ruang_isolasi
 * @property string|null $ruang_ugd
 * @property string|null $ruang_bersalin
 * @property string|null $ruang_operasi
 * @property string|null $dr_sp_a
 * @property string|null $dr_sp_og
 * @property string|null $dr_sp_pd
 * @property string|null $dr_sp_b
 * @property string|null $dr_sp_rad
 * @property string|null $dr_sp_rm
 * @property string|null $dr_sp_an
 * @property string|null $dr_sp_jp
 * @property string|null $dr_sp_m
 * @property string|null $dr_sp_tht
 * @property string|null $dr_sp_kj
 * @property string|null $dr_sp_p
 * @property string|null $dr_sp_pk
 * @property string|null $dr_sp_p_d
 * @property string|null $dr_sp_s
 * @property string|null $dokter_sub_spesialis
 * @property string|null $dokter_spesialis_lain
 * @property string|null $dokter_umum
 * @property string|null $dokter_gigi
 * @property string|null $perawat
 * @property string|null $bidan
 * @property string|null $farmasi
 * @property string|null $tenaga_kesehatan_lainnya
 * @property string|null $jumlah_non_tenaga_kesehatan
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class DataDasarRs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_dasar_rs';
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
            [['tahun', 'nama_rs', 'nama_direktur_rs', 'alamat_rs', 'kab_kota_rs', 'kode_pos_rs', 'telepon_rs', 'fax_rs', 'email_rs', 'telepon_humas_rs', 'website_rs', 'luas_tanah_rs', 'luas_bangunan_rs', 'no_surat_izin_rs', 'tanggal_surat_izin_rs', 'oleh_surat_izin_rs', 'sifat_surat_izin_rs', 'masa_berlaku_surat_izin_rs', 'status_penyelenggaran_swasta'], 'required'],
            [['tanggal_registrasi', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['tahun', 'tanggal_surat_izin_rs', 'tanggal_akreditasi_rs'], 'string', 'max' => 4],
            [['nomor_kode_rs', 'nama_rs', 'jenis_rs', 'kepemilikan_rs', 'kelas_rs', 'nama_direktur_rs', 'nama_penyelenggara_rs', 'alamat_rs', 'kab_kota_rs', 'kode_pos_rs', 'telepon_rs', 'fax_rs', 'email_rs', 'telepon_humas_rs', 'website_rs', 'luas_tanah_rs', 'luas_bangunan_rs', 'no_surat_izin_rs', 'oleh_surat_izin_rs', 'sifat_surat_izin_rs', 'masa_berlaku_surat_izin_rs', 'status_penyelenggaran_swasta', 'akreditasi_rs', 'pentahapan_akreditasi_rs', 'status_akreditasi_rs', 'perinatologi', 'kelas_vvip', 'kelas_vip', 'kelas_i', 'kelas_ii', 'kelas_iii', 'icu', 'picu', 'nicu', 'hcu', 'iccu', 'ruang_isolasi', 'ruang_ugd', 'ruang_bersalin', 'ruang_operasi', 'dr_sp_a', 'dr_sp_og', 'dr_sp_pd', 'dr_sp_b', 'dr_sp_rad', 'dr_sp_rm', 'dr_sp_an', 'dr_sp_jp', 'dr_sp_m', 'dr_sp_tht', 'dr_sp_kj', 'dr_sp_p', 'dr_sp_pk', 'dr_sp_p_d', 'dr_sp_s', 'dokter_sub_spesialis', 'dokter_spesialis_lain', 'dokter_umum', 'dokter_gigi', 'perawat', 'bidan', 'farmasi', 'tenaga_kesehatan_lainnya', 'jumlah_non_tenaga_kesehatan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'data_dasar_rs_id' => 'Data Dasar Rs ID',
            'tahun' => 'Tahun',
            'nomor_kode_rs' => 'Nomor Kode Rs',
            'tanggal_registrasi' => 'Tanggal Registrasi',
            'nama_rs' => 'Nama Rs',
            'jenis_rs' => 'Jenis Rs',
            'kepemilikan_rs' => 'Kepemilikan Rs',
            'kelas_rs' => 'Kelas Rs',
            'nama_direktur_rs' => 'Nama Direktur Rs',
            'nama_penyelenggara_rs' => 'Nama Penyelenggara Rs',
            'alamat_rs' => 'Alamat Rs',
            'kab_kota_rs' => 'Kab Kota Rs',
            'kode_pos_rs' => 'Kode Pos Rs',
            'telepon_rs' => 'Telepon Rs',
            'fax_rs' => 'Fax Rs',
            'email_rs' => 'Email Rs',
            'telepon_humas_rs' => 'Telepon Humas Rs',
            'website_rs' => 'Website Rs',
            'luas_tanah_rs' => 'Luas Tanah Rs',
            'luas_bangunan_rs' => 'Luas Bangunan Rs',
            'no_surat_izin_rs' => 'No Surat Izin Rs',
            'tanggal_surat_izin_rs' => 'Tanggal Surat Izin Rs',
            'oleh_surat_izin_rs' => 'Oleh Surat Izin Rs',
            'sifat_surat_izin_rs' => 'Sifat Surat Izin Rs',
            'masa_berlaku_surat_izin_rs' => 'Masa Berlaku Surat Izin Rs',
            'status_penyelenggaran_swasta' => 'Status Penyelenggaran Swasta',
            'akreditasi_rs' => 'Akreditasi Rs',
            'pentahapan_akreditasi_rs' => 'Pentahapan Akreditasi Rs',
            'status_akreditasi_rs' => 'Status Akreditasi Rs',
            'tanggal_akreditasi_rs' => 'Tanggal Akreditasi Rs',
            'perinatologi' => 'Perinatologi',
            'kelas_vvip' => 'Kelas Vvip',
            'kelas_vip' => 'Kelas Vip',
            'kelas_i' => 'Kelas I',
            'kelas_ii' => 'Kelas Ii',
            'kelas_iii' => 'Kelas Iii',
            'icu' => 'Icu',
            'picu' => 'Picu',
            'nicu' => 'Nicu',
            'hcu' => 'Hcu',
            'iccu' => 'Iccu',
            'ruang_isolasi' => 'Ruang Isolasi',
            'ruang_ugd' => 'Ruang Ugd',
            'ruang_bersalin' => 'Ruang Bersalin',
            'ruang_operasi' => 'Ruang Operasi',
            'dr_sp_a' => 'Dr Sp A',
            'dr_sp_og' => 'Dr Sp Og',
            'dr_sp_pd' => 'Dr Sp Pd',
            'dr_sp_b' => 'Dr Sp B',
            'dr_sp_rad' => 'Dr Sp Rad',
            'dr_sp_rm' => 'Dr Sp Rm',
            'dr_sp_an' => 'Dr Sp An',
            'dr_sp_jp' => 'Dr Sp Jp',
            'dr_sp_m' => 'Dr Sp M',
            'dr_sp_tht' => 'Dr Sp Tht',
            'dr_sp_kj' => 'Dr Sp Kj',
            'dr_sp_p' => 'Dr Sp P',
            'dr_sp_pk' => 'Dr Sp Pk',
            'dr_sp_p_d' => 'Dr Sp P D',
            'dr_sp_s' => 'Dr Sp S',
            'dokter_sub_spesialis' => 'Dokter Sub Spesialis',
            'dokter_spesialis_lain' => 'Dokter Spesialis Lain',
            'dokter_umum' => 'Dokter Umum',
            'dokter_gigi' => 'Dokter Gigi',
            'perawat' => 'Perawat',
            'bidan' => 'Bidan',
            'farmasi' => 'Farmasi',
            'tenaga_kesehatan_lainnya' => 'Tenaga Kesehatan Lainnya',
            'jumlah_non_tenaga_kesehatan' => 'Jumlah Non Tenaga Kesehatan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
        ];
    }
    function beforeSave($model)
    {
        if ($this->isNewRecord) {
            $this->created_by = Yii::$app->user->identity->id;
            $this->created_at = date('Y-m-d H:i:s');
           
        } else {
            $this->updated_by = Yii::$app->user->identity->id;
            $this->updated_at = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($model);
    }
}
