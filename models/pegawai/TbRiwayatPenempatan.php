<?php

namespace app\models\pegawai;

use Yii;

/**
 * This is the model class for table "pegawai.tb_riwayat_penempatan".
 *
 * @property int $id
 * @property string $id_nip_nrp
 * @property string $nota_dinas
 * @property string $tanggal
 * @property int|null $atasan_langsung
 * @property int $penempatan
 * @property int|null $sdm_rumpun
 * @property int|null $sdm_sub_rumpun
 * @property int|null $sdm_jenis
 * @property string|null $dokumen
 * @property int|null $unit_kerja
 */
class TbRiwayatPenempatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pegawai.tb_riwayat_penempatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_nip_nrp', 'nota_dinas', 'tanggal', 'penempatan'], 'required'],
            [['tanggal'], 'safe'],
            [['atasan_langsung', 'penempatan', 'sdm_rumpun', 'sdm_sub_rumpun', 'sdm_jenis', 'unit_kerja'], 'default', 'value' => null],
            [['atasan_langsung', 'penempatan', 'sdm_rumpun', 'sdm_sub_rumpun', 'sdm_jenis', 'unit_kerja'], 'integer'],
            [['dokumen'], 'string'],
            [['id_nip_nrp'], 'string', 'max' => 30],
            [['nota_dinas'], 'string', 'max' => 60],
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
            'nota_dinas' => 'Nota Dinas',
            'tanggal' => 'Tanggal',
            'atasan_langsung' => 'Atasan Langsung',
            'penempatan' => 'Penempatan',
            'sdm_rumpun' => 'Sdm Rumpun',
            'sdm_sub_rumpun' => 'Sdm Sub Rumpun',
            'sdm_jenis' => 'Sdm Jenis',
            'dokumen' => 'Dokumen',
            'unit_kerja' => 'Unit Kerja',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TbRiwayatPenempatanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TbRiwayatPenempatanQuery(get_called_class());
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
