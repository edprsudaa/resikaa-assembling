<?php

namespace app\models\pegawai;

use Yii;

/**
 * This is the model class for table "pegawai.tb_unit_plt_plh".
 *
 * @property int $id
 * @property string $id_nip_nrp
 * @property string|null $nomor_surat
 * @property string|null $tanggal_surat
 * @property string $jenis
 * @property int $unit_kerja
 * @property int $penempatan
 * @property int $atasan_langsung
 * @property string|null $tgl_berlaku_mulai
 * @property string|null $tgl_berlaku_sampai
 * @property int|null $status
 */
class TbUnitPltPlh extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pegawai.tb_unit_plt_plh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_nip_nrp', 'jenis', 'unit_kerja', 'penempatan', 'atasan_langsung'], 'required'],
            [['tanggal_surat', 'tgl_berlaku_mulai', 'tgl_berlaku_sampai'], 'safe'],
            [['unit_kerja', 'penempatan', 'atasan_langsung', 'status'], 'default', 'value' => null],
            [['unit_kerja', 'penempatan', 'atasan_langsung', 'status'], 'integer'],
            [['id_nip_nrp'], 'string', 'max' => 30],
            [['nomor_surat'], 'string', 'max' => 50],
            [['jenis'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_nip_nrp' => 'Id Nip Nrp',
            'nomor_surat' => 'Nomor Surat',
            'tanggal_surat' => 'Tanggal Surat',
            'jenis' => 'Jenis',
            'unit_kerja' => 'Unit Kerja',
            'penempatan' => 'Penempatan',
            'atasan_langsung' => 'Atasan Langsung',
            'tgl_berlaku_mulai' => 'Tgl Berlaku Mulai',
            'tgl_berlaku_sampai' => 'Tgl Berlaku Sampai',
            'status' => 'Status',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TbUnitPltPlhQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TbUnitPltPlhQuery(get_called_class());
    }
    public function getUnitKerja()
    {
        return $this->hasOne(DmUnitPenempatan::className(),['kode'=>'unit_kerja']);
    }
    public function getPegawai()
    {
        return $this->hasOne(TbPegawai::className(),['id_nip_nrp'=>'id_nip_nrp']);
    }
}
