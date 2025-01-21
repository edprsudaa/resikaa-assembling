<?php

namespace app\models\pendaftaran;

use Yii;

/**
 * This is the model class for table "pendaftaran.pasien_anak".
 *
 * @property int $id
 * @property string $nama
 * @property string $tgl_lahir
 * @property string $status 1=anak kandung,2=anak tiri
 * @property string $pasien_kode
 * @property string|null $no_rekam_medis no pasien anak jika ada
 * @property string|null $column1
 */
class PasienAnak extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran.pasien_anak';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'tgl_lahir', 'status', 'pasien_kode'], 'required'],
            [['tgl_lahir'], 'safe'],
            [['column1'], 'string'],
            [['nama'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 1],
            [['pasien_kode', 'no_rekam_medis'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'tgl_lahir' => 'Tgl Lahir',
            'status' => 'Status',
            'pasien_kode' => 'Pasien Kode',
            'no_rekam_medis' => 'No Rekam Medis',
            'column1' => 'Column1',
        ];
    }
}
