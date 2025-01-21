<?php 

namespace app\models\sip;
use Yii;

class RiwayatPenempatan extends \yii\db\ActiveRecord
{

    public static function getDb()
    {
        return Yii::$app->get('db_simpeg');
    }

    public static function tableName()
    {
        return 'pegawai.tb_riwayat_penempatan';
    }

    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['kode' => 'unit_kerja']);
    }

    public function getUnitSubPenempatan()
    {
        return $this->hasOne(UnitSubPenempatan::className(), ['kode' => 'penempatan']);
    }
}