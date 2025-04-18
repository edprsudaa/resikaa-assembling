<?php

namespace app\models\medis;

use Yii;
use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;
use app\models\pegawai\DmUnitPenempatan;
use app\models\medis\Icd10cmv2;
use app\models\medis\Icd9cmv3;

class ResumeMedisRj extends BaseModelAR
{
    /**
     * {@inheritdoc}
     */
    const judul = 'Resume Medis Rawat Jalan';


    public static function tableName()
    {
        return 'medis.resume_medis_rj';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['layanan_id', 'dokter_id'], 'required'],
            [['layanan_id', 'dokter_id', 'diagnosa_utama_id', 'diagnosa_tambahan1_id', 'diagnosa_tambahan2_id', 'diagnosa_tambahan3_id', 'diagnosa_tambahan4_id', 'diagnosa_tambahan5_id', 'diagnosa_tambahan6_id', 'tindakan_utama_id', 'tindakan_tambahan1_id', 'tindakan_tambahan2_id', 'tindakan_tambahan3_id', 'tindakan_tambahan4_id', 'tindakan_tambahan5_id', 'tindakan_tambahan6_id', 'anamesis', 'pemeriksaan_fisik', 'terapi', 'lab', 'rad', 'keterangan', 'batal', 'draf', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['layanan_id', 'dokter_id', 'diagnosa_utama_id', 'diagnosa_tambahan1_id', 'diagnosa_tambahan2_id', 'diagnosa_tambahan3_id', 'diagnosa_tambahan4_id', 'diagnosa_tambahan5_id', 'diagnosa_tambahan6_id', 'tindakan_utama_id', 'tindakan_tambahan1_id', 'tindakan_tambahan2_id', 'tindakan_tambahan3_id', 'tindakan_tambahan4_id', 'tindakan_tambahan5_id', 'tindakan_tambahan6_id', 'batal', 'draf', 'created_by', 'updated_by', 'is_deleted', 'poli_tujuan_kontrol_id', 'kasus'], 'integer'],
            [['rencana', 'alasan', 'alasan_kontrol', 'diagnosa', 'tindakan', 'anamesis', 'pemeriksaan_fisik', 'terapi', 'rad', 'lab', 'keterangan', 'log_data', 'poli_tujuan_kontrol_nama'], 'string'],
            [['created_at', 'updated_at', 'tanggal_batal', 'tanggal_final', 'tgl_kontrol'], 'safe'],
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
            'anamesis' => 'Anamesis',
            'pemeriksaan_fisik' => 'Pemeriksaan Fisik',
            'diagnosa' => 'Diagnosa',
            'kasus' => 'Kasus',
            'diagnosa_utama_id' => 'Diagnosa Utama',
            'diagnosa_tambahan1_id' => 'Diagnosa Tambahan1',
            'diagnosa_tambahan2_id' => 'Diagnosa Tambahan2',
            'diagnosa_tambahan3_id' => 'Diagnosa Tambahan3',
            'diagnosa_tambahan4_id' => 'Diagnosa Tambahan4',
            'diagnosa_tambahan5_id' => 'Diagnosa Tambahan5',
            'diagnosa_tambahan6_id' => 'Diagnosa Tambahan6',
            'tindakan' => 'Tindakan',
            'tindakan_utama_id' => 'Tindakan Utama',
            'tindakan_tambahan1_id' => 'Tindakan Tambahan1',
            'tindakan_tambahan2_id' => 'Tindakan Tambahan2',
            'tindakan_tambahan3_id' => 'Tindakan Tambahan3',
            'tindakan_tambahan4_id' => 'Tindakan Tambahan4',
            'tindakan_tambahan5_id' => 'Tindakan Tambahan5',
            'tindakan_tambahan6_id' => 'Tindakan Tambahan6',
            'rencana' => 'Rencana',
            'alasan' => 'Alasan',
            'alasan_kontrol' => 'Alasan Kontrol',
            'terapi' => 'Terapi',
            'lab' => 'Laboratorium',
            'rad' => 'Radiologi',
            'tgl_kontrol' => 'Tgl Kontrol',
            'poli_tujuan_kontrol_id' => 'Poli Tujuan Kontrol',
            'poli_tujuan_kontrol_nama' => 'Nama Poli Tujuan Kontrol',
            'keterangan' => 'Keterangan',
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
        return new ResumeMedisRjQuery(get_called_class());
    }
    public function getDokter()
    {
        return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'dokter_id']);
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
