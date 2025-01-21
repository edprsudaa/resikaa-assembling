<?php

namespace app\models\pendaftaran;

use Yii;
use app\models\medis\PjpRi;
use app\components\HelperSpesialClass;
use app\models\pengolahandata\AnalisaDokumen;

/**
 * This is the model class for table "pendaftaran.registrasi".
 *
 * @property string $no_daftar
 * @property string $pasien_kode
 * @property string $tgl_masuk
 * @property string|null $tgl_keluar
 * @property string $kiriman_kode
 * @property string|null $kiriman_detail_kode
 * @property string $debitur_kode
 * @property string|null $debitur_detail_kode
 * @property int $created_by
 * @property string $created_at
 * @property int|null $updated_by
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $no_sep
 * @property string|null $is_analisa 0 = belum analisa, 1 = sudah analisa Data Analisa
 * @property int $is_claim 0 = belum coding claim,1 = sudah coding claim
 * @property int $is_pelaporan 0 = belum coding pelaporan,1 = sudah coding pelaporan
 */
class Registrasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran.registrasi';
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
            [['kode', 'pasien_kode', 'tgl_masuk', 'kiriman_kode', 'debitur_kode', 'created_by', 'created_at'], 'required'],
            [['tgl_masuk', 'tgl_keluar', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_by', 'updated_by'], 'default', 'value' => null],
            [['created_by', 'updated_by', 'is_claim', 'is_pelaporan'], 'integer'],
            [['no_daftar', 'pasien_kode', 'kiriman_kode', 'kiriman_detail_kode', 'debitur_kode', 'debitur_detail_kode'], 'string', 'max' => 10],
            [['no_sep'], 'string', 'max' => 255],
            [['no_daftar'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kode' => 'No Daftar',
            'pasien_kode' => 'Pasien Kode',
            'tgl_masuk' => 'Tgl Masuk',
            'tgl_keluar' => 'Tgl Keluar',
            'kiriman_kode' => 'Kiriman Kode',
            'kiriman_detail_kode' => 'Kiriman Detail Kode',
            'debitur_kode' => 'Debitur Kode',
            'debitur_detail_kode' => 'Debitur Detail Kode',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'no_sep' => 'No Sep',
            'is_analisa' => 'Is Analisa',
            'is_claim' => 'Is Claim',
            'is_pelaporan' => 'Is Pelaporan',
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
    public function getDebiturDetail()
    {
        return $this->hasOne(DebiturDetail::className(), ['kode' => 'debitur_detail_kode']);
    }
    public function getKirimanDetail()
    {
        return $this->hasOne(KirimanDetail::className(), ['kode' => 'kiriman_detail_kode']);
    }
    public function getPasien()
    {
        return $this->hasOne(Pasien::className(), ['kode' => 'pasien_kode']);
    }
    public function getSep()
    {
        return $this->hasMany(Sep::className(), ['registrasi_kode' => 'kode']);
    }
    function getPjpRi()
    {
        return $this->hasMany(PjpRi::className(), ['registrasi_kode' => 'kode']);
    }
    function getLayanan()
    {
        return $this->hasMany(Layanan::className(), ['registrasi_kode' => 'kode']);
    }
    function getLayananone()
    {
        return $this->hasOne(Layanan::className(), ['registrasi_kode' => 'kode']);
    }
    function getAnalisaDokumen()
    {
        return $this->hasOne(AnalisaDokumen::className(), ['reg_kode' => 'kode']);
    }
}
