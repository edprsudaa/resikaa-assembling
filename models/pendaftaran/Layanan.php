<?php

namespace app\models\pendaftaran;

use Yii;
use app\models\pegawai\DmUnitPenempatan;
use app\models\medis\Pjp;
use app\models\medis\Kamar;
use app\models\pendaftaran\KelasRawat;
use app\models\pegawai\TbPegawai;
use app\models\medis\Icd10cmPasien;
use app\models\medis\Icd9cmPasien;
use app\models\pengolahandata\CatatanMpp;

use app\models\medis\Resep;
use app\components\HelperSpesialClass;
use app\models\medis\ResumeMedisRi;
use app\models\medis\ResumeMedisRj;

/**
 * This is the model class for table "pendaftaran.layanan".
 *
 * @property int $kode
 * @property string $registrasi_kode
 * @property int $jenis_layanan
 * @property string $tgl_masuk
 * @property string|null $tgl_keluar
 * @property int $unit_kode
 * @property int|null $nomor_urut
 * @property int|null $panggilPerawat
 * @property int|null $dipanggilPerawat
 * @property string|null $kamar_id
 * @property string|null $kelas_rawat_kode
 * @property string|null $dokter_kode
 * @property string|null $unit_asal_kode
 * @property string|null $unit_tujuan_kode
 * @property string|null $cara_masuk_unit_kode
 * @property string|null $cara_keluar_kode
 * @property string|null $status_keluar_kode
 * @property string|null $keterangan
 * @property int $created_by
 * @property string $created_at
 * @property int|null $updated_by
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @property int|null $panggildokter
 * @property int|null $dipanggildokter
 */
class Layanan extends \yii\db\ActiveRecord
{
    const IGD = 1;
    const RJ = 2;
    const RI = 3;
    const PENUNJANG = 4;
    const RJUTAMA = 5;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran.layanan';
    }
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
            [['registrasi_kode', 'jenis_layanan', 'tgl_masuk', 'unit_kode'], 'required'],
            [['jenis_layanan', 'unit_kode', 'nomor_urut', 'panggil_perawat', 'dipanggil_perawat', 'created_by', 'updated_by', 'deleted_by', 'panggil_dokter', 'dipanggil_dokter'], 'default', 'value' => null],
            [['jenis_layanan', 'unit_kode', 'nomor_urut', 'panggil_perawat', 'dipanggil_perawat', 'created_by', 'updated_by', 'deleted_by', 'panggil_dokter', 'dipanggil_dokter', 'kamar_id'], 'integer'],
            [['tgl_masuk', 'tgl_keluar', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['keterangan'], 'string'],
            [['registrasi_kode', 'kelas_rawat_kode', 'cara_masuk_unit_kode', 'cara_keluar_kode', 'status_keluar_kode'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'registrasi_kode' => 'Registrasi Kode',
            'jenis_layanan' => 'Jenis Layanan',
            'tgl_masuk' => 'Tgl Masuk',
            'tgl_keluar' => 'Tgl Keluar',
            'unit_kode' => 'Unit Kode',
            'nomor_urut' => 'Nomor Urut',
            'panggil_perawat' => 'Panggil Perawat',
            'dipanggil_perawat' => 'Dipanggil Perawat',
            'kamar_id' => 'Kamar',
            'kelas_rawat_kode' => 'Kelas',
            'unit_asal_kode' => 'Unit Asal Kode',
            'unit_tujuan_kode' => 'Unit Tujuan Kode',
            'cara_masuk_unit_kode' => 'Cara Masuk Unit Kode',
            'cara_keluar_kode' => 'Cara Keluar Kode',
            'status_keluar_kode' => 'Status Keluar Kode',
            'keterangan' => 'Keterangan',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
            'panggil_dokter' => 'Panggil Dokter',
            'dipanggil_dokter' => 'Dipanggil Dokter',
        ];
    }
    function beforeSave($model)
    {
        $user = HelperSpesialClass::getUserLogin();
        if ($this->isNewRecord) {
            $this->created_by = $user['user_id'];
            $this->created_at = date('Y-m-d H:i:s');
        } else {
            $this->updated_by = $user['user_id'];
            $this->updated_at = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($model);
    }
    function getRegistrasi()
    {
        return $this->hasOne(Registrasi::className(), ['kode' => 'registrasi_kode']);
    }
    function getUnit()
    {
        return $this->hasOne(DmUnitPenempatan::className(), ['kode' => 'unit_kode']);
    }
    function getUnitAsal()
    {
        return $this->hasOne(DmUnitPenempatan::className(), ['kode' => 'unit_asal_kode']);
    }
    function getUnitTujuan()
    {
        return $this->hasOne(DmUnitPenempatan::className(), ['kode' => 'unit_tujuan_kode']);
    }
    function getPjp()
    {
        return $this->hasMany(Pjp::className(), ['layanan_id' => 'id']);
    }
    // function getDpjpri()
    // {
    //     return $this->hasMany(Dpjpri::className(),['registrasi_kode'=>'registrasi_kode']);
    // }
    function getKelasRawat()
    {
        return $this->hasOne(KelasRawat::className(), ['kode' => 'kelas_rawat_kode']);
    }
    function getKamar()
    {
        return $this->hasOne(Kamar::className(), ['id' => 'kamar_id']);
    }
    public static function generateNoAntrian($unit_kode)
    {
        $find = false;
        $max_now = self::find()->where(['unit_kode' => $unit_kode, "TO_CHAR(tgl_masuk :: DATE,'YYYY-MM-DD')" => date('Y-m-d')])->andWhere('deleted_at is null')->max('nomor_urut');
        $max = !empty($max_now) ? $max_now : 1;
        while (!$find) {
            $count = self::find()->where(['nomor_urut' => $max, 'unit_kode' => $unit_kode, "TO_CHAR(tgl_masuk :: DATE,'YYYY-MM-DD')" => date('Y-m-d')])->andWhere('deleted_at is null')->count();
            if ($count < 1) {
                $find = true;
            } else {
                $max++;
            }
        }
        return $max;
    }
    public static function find()
    {
        return new LayananQuery(get_called_class());
    }
    public static function getDataExpertisePa($layanan_id_penunjang)
    {
        $data = self::find()->select([
            'p.nama AS pasien_nama',
            'p.kode AS pasien_kode',
            'p.jkel AS pasien_jkel',
            'p.tgl_lahir AS pasien_tgl_lahir',
            'p.alamat',
            'pl.nama AS pasien_luar_nama',
            'pl.kode AS pasien_luar_kode',
            'pl.jkel AS pasien_luar_jkel',
            'pl.tgl_lahir AS pasien_luar_tgl_lahir',
            'pl.alamat AS pasien_luar_alamat',
            'lpo.dokter_id',
            'lpo.tgl_pemeriksaan AS tgl_order',
            'upa.nama as unit_asal_nama',
            'pendaftaran.layanan.unit_asal_kode as unit_asal_kode',
            'dd.nama AS debitur_nama',
            "coalesce(concat(tp.gelar_sarjana_depan, ' ') , '') || coalesce(tp.nama_lengkap, '') || coalesce(concat(' ', tp.gelar_sarjana_belakang), '') as dokter_nama"
        ])
            ->leftJoin('pendaftaran.registrasi r', 'r.kode=pendaftaran.layanan.registrasi_kode')
            ->leftJoin('pendaftaran.pasien p', 'p.kode=r.pasien_kode')
            ->leftJoin('pendaftaran.pasien_luar pl', 'pl.registrasi_kode=r.kode')
            ->leftJoin('pegawai.dm_unit_penempatan up', 'up.kode=pendaftaran.layanan.unit_kode')
            ->leftJoin('medis.lab_pa_order lpo', 'lpo.layanan_id_penunjang=pendaftaran.layanan.id')
            ->leftJoin('pegawai.tb_pegawai tp', 'tp.pegawai_id=lpo.dokter_id')
            ->leftJoin('pegawai.dm_unit_penempatan upa', 'upa.kode=pendaftaran.layanan.unit_asal_kode')
            ->leftJoin('pendaftaran.debitur_detail dd', 'dd.kode=r.debitur_detail_kode')
            ->where([
                'pendaftaran.layanan.id' => $layanan_id_penunjang
            ])
            ->asArray()->one();

        return $data;
    }
    function getIcd10pasien()
    {
        return $this->hasMany(Icd10cmPasien::className(), ['layanan_id' => 'id']);
    }
    function getIcd9pasien()
    {
        return $this->hasMany(Icd9cmPasien::className(), ['layanan_id' => 'id']);
    }
    function getReseppasien()
    {
        return $this->hasMany(Resep::className(), ['layanan_id' => 'id']);
    }

    function getResumemedisri()
    {
        return $this->hasMany(ResumeMedisRi::className(), ['layanan_id' => 'id']);
    }
    function getCatatanMpp()
    {
        return $this->hasMany(CatatanMpp::className(), ['layanan_id' => 'id']);
    }
    function getResumemedisrj()
    {
        return $this->hasMany(ResumeMedisRj::className(), ['layanan_id' => 'id']);
    }
}
