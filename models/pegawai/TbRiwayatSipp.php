<?php

namespace app\models\pegawai;

use Yii;

/**
 * This is the model class for table "pegawai.tb_riwayat_sipp".
 *
 * @property int $id
 * @property string $id_nip_nrp
 * @property string $nomor_sipp
 * @property string $nomor_strp
 * @property string $tanggal_terbit
 * @property string $tanggal_berlaku
 * @property string|null $dokumen
 */
class TbRiwayatSipp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pegawai.tb_riwayat_sipp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_nip_nrp', 'nomor_sipp', 'nomor_strp', 'tanggal_terbit', 'tanggal_berlaku'], 'required'],
            [['tanggal_terbit', 'tanggal_berlaku'], 'safe'],
            [['dokumen'], 'string'],
            [['id_nip_nrp', 'nomor_sipp', 'nomor_strp'], 'string', 'max' => 30],
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
            'nomor_sipp' => 'Nomor Sipp',
            'nomor_strp' => 'Nomor Strp',
            'tanggal_terbit' => 'Tanggal Terbit',
            'tanggal_berlaku' => 'Tanggal Berlaku',
            'dokumen' => 'Dokumen',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TbRiwayatSippQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TbRiwayatSippQuery(get_called_class());
    }
}
