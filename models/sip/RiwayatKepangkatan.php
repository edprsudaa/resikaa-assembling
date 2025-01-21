<?php 

namespace app\models\sip;
use Yii;

class RiwayatKepangkatan extends \yii\db\ActiveRecord
{

    public static function getDb()
    {
        return Yii::$app->get('db_simpeg');
    }

    public static function tableName()
    {
        return 'pegawai.tb_riwayat_kepangkatan';
    }

    public function getGolongan()
    {
        return $this->hasOne(Golongan::className(), ['kode' => 'kode_pangkat']);
    }

}