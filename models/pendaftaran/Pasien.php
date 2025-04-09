<?php

namespace app\models\pendaftaran;

use Yii;
use app\models\pegawai\DmAgama;
use app\models\pegawai\DmPendidikan;
use app\models\pegawai\DmPekerjaan;
use app\models\pegawai\DmNegara;
use app\models\pegawai\DmSuku;
use app\models\pegawai\DmKelurahanDesa;

/**
 * This is the model class for table "pendaftaran.pasien".
 *
 * @property string $kode
 * @property string $status_kawin_kode
 * @property string $agama_kode
 * @property string $pendidikan_kode
 * @property string $pekerjaan_kode
 * @property string $kewarganegaraan_kode
 * @property string $jenis_identitas_kode
 * @property string $suku_kode
 * @property string $no_identitas
 * @property string|null $nama
 * @property string|null $ayah_nama
 * @property string|null $ibu_nama
 * @property string|null $nama_pasangan
 * @property string $tempat_lahir
 * @property string $tgl_lahir
 * @property string $alamat
 * @property string $jkel l = laki-laki, p = perempuan
 * @property int|null $penghasilan rata-rata penghasilan keluarga perbln
 * @property string|null $no_telp
 * @property string|null $alergi
 * @property int $created_by
 * @property string $created_at
 * @property int|null $updated_by
 * @property string|null $updated_at
 * @property int|null $is_deleted
 * @property string|null $tempat_kerja
 * @property string|null $kelurahan_kode
 * @property string|null $kedudukan_keluarga 1=Kepala Keluarga,2=Istri,3=Anak
 * @property string|null $alamat_tempat_kerja
 * @property int|null $anak_ke
 * @property int|null $istri_ke
 * @property int|null $jml_anak
 * @property string|null $ayah_no_rekam_medis
 * @property string|null $ibu_no_rekam_medis
 * @property string|null $goldar
 * @property bool|null $is_print
 */
class Pasien extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    static $jenis_kelamin = ['l' => 'Laki-laki', 'p' => 'Perempuan', 'a' => 'Ambigu'];
    public static function tableName()
    {
        return 'pendaftaran.pasien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'status_kawin_kode', 'agama_kode', 'pendidikan_kode', 'pekerjaan_kode', 'kewarganegaraan_kode', 'jenis_identitas_kode', 'suku_kode', 'no_identitas', 'tempat_lahir', 'tgl_lahir', 'alamat', 'jkel', 'created_by', 'created_at'], 'required'],
            [['tgl_lahir', 'created_at', 'updated_at'], 'safe'],
            [['alamat', 'alergi'], 'string'],
            [['penghasilan', 'created_by', 'updated_by', 'is_deleted', 'anak_ke', 'istri_ke', 'jml_anak'], 'default', 'value' => null],
            [['penghasilan', 'created_by', 'updated_by', 'is_deleted', 'anak_ke', 'istri_ke', 'jml_anak'], 'integer'],
            [['is_print'], 'boolean'],
            [['kode', 'status_kawin_kode', 'agama_kode', 'pendidikan_kode', 'pekerjaan_kode', 'kewarganegaraan_kode', 'jenis_identitas_kode', 'suku_kode', 'kelurahan_kode', 'ayah_no_rekam_medis', 'ibu_no_rekam_medis'], 'string', 'max' => 10],
            [['no_identitas', 'no_telp'], 'string', 'max' => 50],
            [['nama', 'ayah_nama', 'ibu_nama', 'nama_pasangan'], 'string', 'max' => 150],
            [['tempat_lahir', 'tempat_kerja', 'alamat_tempat_kerja'], 'string', 'max' => 255],
            [['jkel', 'kedudukan_keluarga'], 'string', 'max' => 1],
            [['goldar'], 'string', 'max' => 2],
            [['kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kode' => 'Kode',
            'status_kawin_kode' => 'Status Kawin Kode',
            'agama_kode' => 'Agama Kode',
            'pendidikan_kode' => 'Pendidikan Kode',
            'pekerjaan_kode' => 'Pekerjaan Kode',
            'kewarganegaraan_kode' => 'Kewarganegaraan Kode',
            'jenis_identitas_kode' => 'Jenis Identitas Kode',
            'suku_kode' => 'Suku Kode',
            'no_identitas' => 'No Identitas',
            'nama' => 'Nama',
            'ayah_nama' => 'Ayah Nama',
            'ibu_nama' => 'Ibu Nama',
            'nama_pasangan' => 'Nama Pasangan',
            'tempat_lahir' => 'Tempat Lahir',
            'tgl_lahir' => 'Tgl Lahir',
            'alamat' => 'Alamat',
            'jkel' => 'Jkel',
            'penghasilan' => 'Penghasilan',
            'no_telp' => 'No Telp',
            'alergi' => 'Alergi',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'is_deleted' => 'Is Deleted',
            'tempat_kerja' => 'Tempat Kerja',
            'kelurahan_kode' => 'Kelurahan Kode',
            'kedudukan_keluarga' => 'Kedudukan Keluarga',
            'alamat_tempat_kerja' => 'Alamat Tempat Kerja',
            'anak_ke' => 'Anak Ke',
            'istri_ke' => 'Istri Ke',
            'jml_anak' => 'Jml Anak',
            'ayah_no_rekam_medis' => 'Ayah No Rekam Medis',
            'ibu_no_rekam_medis' => 'Ibu No Rekam Medis',
            'goldar' => 'Goldar',
            'is_print' => 'Is Print',
        ];
    }
    function getRegistrasi()
    {
        return $this->hasMany(Registrasi::className(), ['pasien_kode' => 'kode']);
    }

    function getStatusKawin()
    {
        return $this->hasOne(StatusKawin::className(), ['kode' => 'status_kawin_kode'])->select(['kode', 'nama']);
    }
    function getAgama()
    {
        return $this->hasOne(DmAgama::className(), ['id' => 'agama_kode'])->select(['id as kode', 'agama as nama']);
    }
    function getPendidikan()
    {
        return $this->hasOne(DmPendidikan::className(), ['id' => 'pendidikan_kode'])->select(['id as kode', 'pendidikan_terakhir as nama']);
    }
    function getPekerjaan()
    {
        return $this->hasOne(DmPekerjaan::className(), ['id' => 'pekerjaan_kode'])->select(['id as kode', 'nama']);
    }
    function getNegara()
    {
        return $this->hasOne(DmNegara::className(), ['id' => 'kewarganegaraan_kode'])->select(['id as kode', 'nama']);
    }
    function getSuku()
    {
        return $this->hasOne(DmSuku::className(), ['id' => 'suku_kode'])->select(['kode', 'nama']);
    }
    function getKelurahan()
    {
        return $this->hasOne(DmKelurahanDesa::className(), ['kode_prov_kab_kec_kelurahan' => 'kelurahan_kode']);
    }
    // function getJenisIdentitas()
    // {
    //     return $this->hasOne(JenisIdentitas::className(),['kode'=>'jenis_identitas_kode'])->select(['kode','nama']);
    // }
    function getAnak()
    {
        return $this->hasMany(PasienAnak::className(), ['pasien_kode' => 'kode']);
    }
    function getRiwayatPenyakit()
    {
        return $this->hasMany(PasienRiwayatPenyakit::className(), ['pasien_kode' => 'kode']);
    }
    function getKebiasaan()
    {
        return $this->hasMany(PasienKebiasaan::className(), ['pasien_kode' => 'kode']);
    }

    public static function getListPasien($q = null)
    {
        $sql = "
        select
            kode as id ,CONCAT('(',kode,') ',nama) as text,kode,nama
        FROM " . self::tableName() . "  where kode ILIKE '%" . $q . "%' OR nama ILIKE '%" . $q . "%'
         LIMIT 20";
        return \Yii::$app->db->createCommand($sql)->queryAll();
    }
}
