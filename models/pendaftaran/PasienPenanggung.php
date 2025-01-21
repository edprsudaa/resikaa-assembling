<?php

namespace app\models\pendaftaran;

use app\models\pendaftaran\Debitur;
use Yii;


class PasienPenanggung extends \yii\db\ActiveRecord
{
    public $no_registrasi, $no_sep;
    public static function tableName()
    {
        return 'pendaftaran.pasien_penanggung';
    }

    public function rules()
    {
        return [
            [['pasien_kode', 'debitur_kode', 'debitur_detail_kode'], 'required'],
            [['created_by'], 'default', 'value' => null],
            [['created_by'], 'integer'],
            [['created_at', 'no_registrasi', 'debitur_nama_pasien', 'no_sep'], 'safe'],
            [['pasien_kode', 'debitur_kode', 'debitur_detail_kode'], 'string', 'max' => 10],
            [['debitur_nomor'], 'string', 'max' => 50],
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
            'debitur_kode' => 'Debitur',
            'debitur_detail_kode' => 'Debitur Detail',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'debitur_nomor' => 'Debitur Nomor',
            'debitur_nama_pasien' => 'Nama Penjamin',
        ];
    }

    // public function getDebitur()
    // {
    //     return $this->hasOne(Debitur::className(),['NODEBT'=>'NoDebt']);
    // }

    public function getDebitur()
    {
        return $this->hasOne(Debitur::className(), ['kode' => 'debitur_kode']);
    }

    public static function getPasienPenanggung($pasien_kode = null, $debitur_detail = null)
    {
        if ($pasien_kode === null || $debitur_detail === null) {
            return null;
        }

        return self::findOne(['pasien_kode' => $pasien_kode, 'debitur_detail_kode' => $debitur_detail]);
    }
}
