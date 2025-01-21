<?php

namespace app\models\pendaftaran;

use Yii;

/**
 * This is the model class for table "pendaftaran.pasien_riwayat_penyakit".
 *
 * @property int $id
 * @property string $pasien_kode
 * @property string $penyakit_kode
 */
class PasienRiwayatPenyakit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran.pasien_riwayat_penyakit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pasien_kode', 'penyakit_kode'], 'required'],
            [['pasien_kode', 'penyakit_kode'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pasien_kode' => 'Pasien Kode',
            'penyakit_kode' => 'Penyakit Kode',
        ];
    }
    function getPenyakit()
    {
        return $this->hasOne(Penyakit::className(),['kode'=>'penyakit_kode'])->select(['kode','nama']);
    }
}
