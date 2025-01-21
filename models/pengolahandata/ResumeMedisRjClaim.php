<?php

namespace app\models\pengolahandata;

use Yii;
use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;
use app\models\pegawai\DmUnitPenempatan;
use app\models\medis\Icd10cmv2;
use app\models\medis\Icd9cmv3;
use app\models\medis\ResumeMedisRjQuery;

/**
 * This is the model class for table "resume_medis_rj_claim".
 *
 * @property int $id
 * @property string $registrasi_kode
 * @property int $id_resume_medis_rj
 * @property int $dokter_verifikator_id
 * @property int $layanan_id
 * @property int $dokter_id
 * @property string|null $anamesis
 * @property string|null $pemeriksaan_fisik
 * @property string|null $diagnosa
 * @property int|null $diagnosa_utama_id
 * @property int|null $diagnosa_tambahan1_id
 * @property int|null $diagnosa_tambahan2_id
 * @property int|null $diagnosa_tambahan3_id
 * @property int|null $diagnosa_tambahan4_id
 * @property int|null $diagnosa_tambahan5_id
 * @property int|null $diagnosa_tambahan6_id
 * @property string|null $tindakan
 * @property int|null $tindakan_utama_id
 * @property int|null $tindakan_tambahan1_id
 * @property int|null $tindakan_tambahan2_id
 * @property int|null $tindakan_tambahan3_id
 * @property int|null $tindakan_tambahan4_id
 * @property int|null $tindakan_tambahan5_id
 * @property int|null $tindakan_tambahan6_id
 * @property string|null $terapi
 * @property string|null $rencana
 * @property string|null $alasan_kontrol
 * @property string|null $alasan
 * @property string|null $lab
 * @property string|null $rad
 * @property int|null $poli_tujuan_kontrol_id
 * @property string|null $poli_tujuan_kontrol_nama
 * @property string|null $tgl_kontrol
 * @property string|null $keterangan
 * @property int $batal
 * @property string|null $tanggal_batal
 * @property int $draf
 * @property string|null $tanggal_final
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $log_data
 * @property int $is_deleted
 * @property int|null $kasus
 * @property string|null $coder_claim_id
 */
class ResumeMedisRjClaim extends \yii\db\ActiveRecord
{
    public $utama;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resume_medis_rj_claim';
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
            [['registrasi_kode', 'id_resume_medis_rj', 'dokter_verifikator_id', 'layanan_id', 'dokter_id'], 'required'],
            [['id_resume_medis_rj', 'dokter_verifikator_id', 'layanan_id', 'dokter_id', 'diagnosa_utama_id', 'diagnosa_tambahan1_id', 'diagnosa_tambahan2_id', 'diagnosa_tambahan3_id', 'diagnosa_tambahan4_id', 'diagnosa_tambahan5_id', 'diagnosa_tambahan6_id', 'tindakan_utama_id', 'tindakan_tambahan1_id', 'tindakan_tambahan2_id', 'tindakan_tambahan3_id', 'tindakan_tambahan4_id', 'tindakan_tambahan5_id', 'tindakan_tambahan6_id', 'poli_tujuan_kontrol_id', 'batal', 'draf', 'created_by', 'updated_by', 'is_deleted', 'kasus'], 'default', 'value' => null],
            [['id_resume_medis_rj', 'dokter_verifikator_id', 'layanan_id', 'dokter_id', 'diagnosa_utama_id', 'diagnosa_tambahan1_id', 'diagnosa_tambahan2_id', 'diagnosa_tambahan3_id', 'diagnosa_tambahan4_id', 'diagnosa_tambahan5_id', 'diagnosa_tambahan6_id', 'tindakan_utama_id', 'tindakan_tambahan1_id', 'tindakan_tambahan2_id', 'tindakan_tambahan3_id', 'tindakan_tambahan4_id', 'tindakan_tambahan5_id', 'tindakan_tambahan6_id', 'poli_tujuan_kontrol_id', 'batal', 'draf', 'created_by', 'updated_by', 'is_deleted', 'kasus', 'coder_claim_id'], 'integer'],
            [['anamesis', 'pemeriksaan_fisik', 'diagnosa', 'tindakan', 'terapi', 'rencana', 'alasan_kontrol', 'alasan', 'lab', 'rad', 'poli_tujuan_kontrol_nama', 'keterangan', 'log_data'], 'string'],
            [['tgl_kontrol', 'tanggal_batal', 'tanggal_final', 'created_at', 'updated_at'], 'safe'],
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
            'id_resume_medis_rj' => 'Id Resume Medis Ri',
            'dokter_verifikator_id' => 'Dokter Verifikator ID',
            'layanan_id' => 'Layanan ID',
            'dokter_id' => 'Dokter ID',
            'anamesis' => 'Anamesis',
            'pemeriksaan_fisik' => 'Pemeriksaan Fisik',
            'diagnosa' => 'Diagnosa',
            'diagnosa_utama_id' => 'Diagnosa Utama ID',
            'diagnosa_tambahan1_id' => 'Diagnosa Tambahan1 ID',
            'diagnosa_tambahan2_id' => 'Diagnosa Tambahan2 ID',
            'diagnosa_tambahan3_id' => 'Diagnosa Tambahan3 ID',
            'diagnosa_tambahan4_id' => 'Diagnosa Tambahan4 ID',
            'diagnosa_tambahan5_id' => 'Diagnosa Tambahan5 ID',
            'diagnosa_tambahan6_id' => 'Diagnosa Tambahan6 ID',
            'tindakan' => 'Tindakan',
            'tindakan_utama_id' => 'Tindakan Utama ID',
            'tindakan_tambahan1_id' => 'Tindakan Tambahan1 ID',
            'tindakan_tambahan2_id' => 'Tindakan Tambahan2 ID',
            'tindakan_tambahan3_id' => 'Tindakan Tambahan3 ID',
            'tindakan_tambahan4_id' => 'Tindakan Tambahan4 ID',
            'tindakan_tambahan5_id' => 'Tindakan Tambahan5 ID',
            'tindakan_tambahan6_id' => 'Tindakan Tambahan6 ID',
            'terapi' => 'Terapi',
            'rencana' => 'Rencana',
            'alasan_kontrol' => 'Alasan Kontrol',
            'alasan' => 'Alasan',
            'lab' => 'Lab',
            'rad' => 'Rad',
            'poli_tujuan_kontrol_id' => 'Poli Tujuan Kontrol ID',
            'poli_tujuan_kontrol_nama' => 'Poli Tujuan Kontrol Nama',
            'tgl_kontrol' => 'Tgl Kontrol',
            'keterangan' => 'Keterangan',
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
            'kasus' => 'Kasus',
            'coder_claim_id' => 'Coder Claim ID',
        ];
    }
    function beforeSave($model)
    {
        if ($this->isNewRecord) {
            $this->created_at = date('Y-m-d H:i:s');
            $this->created_by = Yii::$app->user->identity->id;
            $this->batal = 0;
            $this->draf = 0;
            $this->is_deleted = 0;
        } else {
            $this->updated_at = date('Y-m-d H:i:s');
            $this->updated_by = Yii::$app->user->identity->id;
        }
        return parent::beforeSave($model);
    }

    public function getDokter()
    {
        return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'dokter_id']);
    }
    public function getDokterVerifikator()
    {
        return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'dokter_verifikator_id']);
    }
    public function getLayanan()
    {
        return $this->hasOne(Layanan::className(), ['id' => 'layanan_id']);
    }
    function getUnitTujuan()
    {
        return $this->hasOne(DmUnitPenempatan::className(), ['kode' => 'poli_tujuan_kontrol_id']);
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
