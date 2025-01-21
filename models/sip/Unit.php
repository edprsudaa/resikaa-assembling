<?php

namespace app\models\sip;

use app\models\penjualan\Penjualan;
use Yii;
use yii\httpclient\Client;

class Unit extends \yii\db\ActiveRecord
{

    public static function getDb()
    {
        return Yii::$app->get('db_simpeg');
    }

    public static function tableName()
    {
        return 'pegawai.dm_unit_penempatan';
    }

    /**
     * {@inheritdoc}
     * @return \app\models\pegawai\UnitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\sip\UnitQuery(get_called_class());
    }

    public function getUnitRumpun()
    {
        return $this->hasOne(Unit::className(), ['kode' => 'unit_rumpun']);
    }

    public function isGudang()
    {
        return $this->unitRumpun->nama === 'INSTALASI FARMASI';
    }

    public function isGudangUtama()
    {
        return $this->nama === 'GUDANG PERBEKALAN FARMASI';
    }

    public function getPenjualan()
    {
        return $this->hasMany(Penjualan::className(), ['id_depo' => 'kode']);
    }
}
