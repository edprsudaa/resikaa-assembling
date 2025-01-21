<?php

namespace app\models\pendaftaran;

use Yii;

/**
 * This is the model class for table "pendaftaran.pasien_kebiasaan".
 *
 * @property int $id
 * @property string $pasien_kode
 * @property int $kebiasaan_kode
 */
class PasienKebiasaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran.pasien_kebiasaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pasien_kode', 'kebiasaan_kode'], 'required'],
            [['kebiasaan_kode'], 'default', 'value' => null],
            [['kebiasaan_kode'], 'integer'],
            [['pasien_kode'], 'string', 'max' => 10],
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
            'kebiasaan_kode' => 'Kebiasaan Kode',
        ];
    }
    function getKebiasaan()
    {
        return $this->hasOne(Kebiasaan::className(),['kode'=>'kebiasaan_kode'])->select(['kode','nama']);
    }
}
