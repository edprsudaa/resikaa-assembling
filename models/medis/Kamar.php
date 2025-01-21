<?php

namespace app\models\medis;

use Yii;
use app\models\pegawai\DmUnitPenempatan;
use app\models\pendaftaran\KelasRawat;
/**
 * This is the model class for table "medis.kamar".
 *
 * @property int $id
 * @property int $unit_id reff pegawai.dm_unit_penepatan.kode
 * @property string $kelas_rawat_kode reff pendaftaran.kelas_rawat.kode
 * @property string $no_kamar
 * @property string $no_kasur
 * @property int|null $aktif
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $is_deleted
 */
class Kamar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.kamar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_id', 'kelas_rawat_kode', 'no_kamar', 'no_kasur', 'created_at', 'created_by'], 'required'],
            [['unit_id', 'aktif', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['unit_id', 'aktif', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['kelas_rawat_kode', 'no_kamar', 'no_kasur'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_id' => 'Unit ID',
            'kelas_rawat_kode' => 'Kelas Rawat Kode',
            'no_kamar' => 'No Kamar',
            'no_kasur' => 'No Kasur',
            'aktif' => 'Aktif',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * {@inheritdoc}
     * @return KamarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KamarQuery(get_called_class());
    }
    public function getUnit()
    {
        return $this->hasOne(DmUnitPenempatan::className(),['kode'=>'unit_id']);
    }
    public function getKelasRawat()
    {
        return $this->hasOne(KelasRawat::className(),['kode'=>'kelas_rawat_kode']);
    }
}
