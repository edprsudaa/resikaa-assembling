<?php

namespace app\models\pegawai;

use Yii;

/**
 * This is the model class for table "pegawai.tb_riwayat_spklinis".
 *
 * @property int $id
 * @property string $id_nip_nrp
 * @property string $nomor_spk
 * @property string $nomor_str
 * @property string $tingkat_klinik
 * @property string $tanggal_terbit
 * @property string $tanggal_berlaku
 * @property string|null $dokumen
 */
class TbRiwayatSpklinis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pegawai.tb_riwayat_spklinis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_nip_nrp', 'nomor_spk', 'nomor_str', 'tingkat_klinik', 'tanggal_terbit', 'tanggal_berlaku'], 'required'],
            [['tanggal_terbit', 'tanggal_berlaku'], 'safe'],
            [['dokumen'], 'string'],
            [['id_nip_nrp', 'nomor_spk', 'nomor_str', 'tingkat_klinik'], 'string', 'max' => 30],
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
            'nomor_spk' => 'Nomor Spk',
            'nomor_str' => 'Nomor Str',
            'tingkat_klinik' => 'Tingkat Klinik',
            'tanggal_terbit' => 'Tanggal Terbit',
            'tanggal_berlaku' => 'Tanggal Berlaku',
            'dokumen' => 'Dokumen',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TbRiwayatSpklinisQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TbRiwayatSpklinisQuery(get_called_class());
    }
}
