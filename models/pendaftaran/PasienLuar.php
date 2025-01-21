<?php

namespace app\models\pendaftaran;

use Yii;

/**
 * This is the model class for table "pasien_luar".
 *
 * @property int $kode_pasien_luar
 * @property string $kode
 * @property string|null $registrasi_kode
 * @property string|null $nama
 * @property string|null $tempat_lahir
 * @property string|null $tgl_lahir
 * @property int|null $umur
 * @property string|null $alamat
 * @property string|null $jkel
 * @property string|null $jenis_identitas_kode 1=KTP, 2=SIM, 3=PASPOR
 * @property string|null $no_identitas
 * @property string|null $no_telp
 * @property string|null $status_kawin_kode
 * @property string|null $tempat_kerja
 * @property string|null $alamat_tempat_kerja
 * @property string|null $ayah_nama
 * @property string|null $ibu_nama
 * @property string|null $nama_pasangan
 * @property int|null $agama_kode
 * @property int|null $pekerjaan_kode
 * @property int|null $jml_anak
 * @property int|null $penghasilan
 * @property string|null $ayah_no_rekam_medis
 * @property string|null $ibu_no_rekam_medis
 * @property string|null $kedudukan_keluarga 1=Kepala Keluarga,2=Istri,3=Anak
 * @property int|null $anak_ke
 * @property int|null $istri_ke
 * @property int|null $suku_kode
 * @property int|null $kewarganegaraan_kode
 * @property string|null $rt
 * @property string|null $rw
 * @property int|null $pendidikan_kode
 * @property string|null $kelurahan_kode
 * @property string|null $kebiasaan
 * @property string|null $riwayat_penyakit
 * @property string|null $alergi
 * @property string|null $goldar
 * @property string|null $jurusan_kode
 * @property string|null $created_by
 * @property string|null $created_at
 * @property string|null $updated_by
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class PasienLuar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran.pasien_luar';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_pendaftaran');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode'], 'required'],
            [['tgl_lahir', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['umur', 'agama_kode', 'pekerjaan_kode', 'jml_anak', 'penghasilan', 'anak_ke', 'istri_ke', 'suku_kode', 'kewarganegaraan_kode', 'pendidikan_kode', 'deleted_by'], 'default', 'value' => null],
            [['umur', 'agama_kode', 'pekerjaan_kode', 'jml_anak', 'penghasilan', 'anak_ke', 'istri_ke', 'suku_kode', 'kewarganegaraan_kode', 'pendidikan_kode', 'deleted_by'], 'integer'],
            [['jkel', 'jenis_identitas_kode', 'ayah_no_rekam_medis', 'ibu_no_rekam_medis', 'kebiasaan', 'riwayat_penyakit', 'alergi'], 'string'],
            [['kode'], 'string', 'max' => 8],
            [['registrasi_kode', 'kelurahan_kode', 'jurusan_kode'], 'string', 'max' => 10],
            [['nama', 'tempat_lahir', 'alamat', 'nama_pasangan'], 'string', 'max' => 255],
            [['no_identitas', 'no_telp'], 'string', 'max' => 30],
            [['status_kawin_kode', 'goldar'], 'string', 'max' => 2],
            [['tempat_kerja', 'ayah_nama', 'ibu_nama'], 'string', 'max' => 50],
            [['alamat_tempat_kerja'], 'string', 'max' => 100],
            [['kedudukan_keluarga'], 'string', 'max' => 1],
            [['rt', 'rw'], 'string', 'max' => 3],
            [['created_by', 'updated_by'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kode_pasien_luar' => 'Kode Pasien Luar',
            'kode' => 'Kode',
            'registrasi_kode' => 'Registrasi Kode',
            'nama' => 'Nama',
            'tempat_lahir' => 'Tempat Lahir',
            'tgl_lahir' => 'Tgl Lahir',
            'umur' => 'Umur',
            'alamat' => 'Alamat',
            'jkel' => 'Jkel',
            'jenis_identitas_kode' => 'Jenis Identitas Kode',
            'no_identitas' => 'No Identitas',
            'no_telp' => 'No Telp',
            'status_kawin_kode' => 'Status Kawin Kode',
            'tempat_kerja' => 'Tempat Kerja',
            'alamat_tempat_kerja' => 'Alamat Tempat Kerja',
            'ayah_nama' => 'Ayah Nama',
            'ibu_nama' => 'Ibu Nama',
            'nama_pasangan' => 'Nama Pasangan',
            'agama_kode' => 'Agama Kode',
            'pekerjaan_kode' => 'Pekerjaan Kode',
            'jml_anak' => 'Jml Anak',
            'penghasilan' => 'Penghasilan',
            'ayah_no_rekam_medis' => 'Ayah No Rekam Medis',
            'ibu_no_rekam_medis' => 'Ibu No Rekam Medis',
            'kedudukan_keluarga' => 'Kedudukan Keluarga',
            'anak_ke' => 'Anak Ke',
            'istri_ke' => 'Istri Ke',
            'suku_kode' => 'Suku Kode',
            'kewarganegaraan_kode' => 'Kewarganegaraan Kode',
            'rt' => 'Rt',
            'rw' => 'Rw',
            'pendidikan_kode' => 'Pendidikan Kode',
            'kelurahan_kode' => 'Kelurahan Kode',
            'kebiasaan' => 'Kebiasaan',
            'riwayat_penyakit' => 'Riwayat Penyakit',
            'alergi' => 'Alergi',
            'goldar' => 'Goldar',
            'jurusan_kode' => 'Jurusan Kode',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
        ];
    }
}
