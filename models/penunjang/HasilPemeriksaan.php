<?php

namespace app\models\penunjang;

use app\models\medis\TarifTindakanPasien;
use app\models\pendaftaran\Layanan;
use Yii;

/**
 * This is the model class for table "hasil_pemeriksaan_pa".
 *
 * @property int $id
 * @property int|null $layanan_id_penunjang
 * @property int|null $dokter_pemeriksa
 * @property string|null $tgl_periksa
 * @property string|null $tgl_ambil_hasil
 * @property int|null $is_save
 * @property int|null $is_ambil
 * @property int|null $tarif_tindakan_pasien_id
 * @property string|null $klinis
 * @property string|null $no_pa
 * @property string|null $diagnosa_pa
 * @property string|null $kesimpulan
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 */
class HasilPemeriksaan extends \yii\db\ActiveRecord
{
    public $pasien_nama;
    public $pasien_luar_nama;
    public $no_rm;
    public $no_periksa;
    public $tindakan;
    public $kode_jenis;

    public static function tableName()
    {
        return 'penunjang_2.hasil_pemeriksaan_pa';
    }

    public static function getDb()
    {
        return Yii::$app->get('db_postgre');
    }

    public function rules()
    {
        return [
            [['layanan_id_penunjang', 'dokter_pemeriksa', 'is_save', 'is_ambil', 'tarif_tindakan_pasien_id', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['layanan_id_penunjang', 'dokter_pemeriksa', 'is_save', 'is_ambil', 'tarif_tindakan_pasien_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['tgl_periksa', 'tgl_ambil_hasil', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['klinis', 'no_pa', 'diagnosa_pa', 'kesimpulan'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'layanan_id_penunjang' => 'Layanan Id Penunjang',
            'dokter_pemeriksa' => 'Dokter Pemeriksa',
            'tgl_periksa' => 'Tgl Periksa',
            'tgl_ambil_hasil' => 'Tgl Ambil Hasil',
            'is_save' => 'Is Save',
            'is_ambil' => 'Is Ambil',
            'tarif_tindakan_pasien_id' => 'Tarif Tindakan Pasien ID',
            'klinis' => 'Klinis',
            'no_pa' => 'No Pa',                 //Selain Pemeriksaan Imunohistokima, Maka Menyimpan Hasil Makroskopis
            'diagnosa_pa' => 'Diagnosa Pa',     //Selain Pemeriksaan Imunohistokima, Maka Menyimpan Hasil Mikroskopis
            'kesimpulan' => 'Kesimpulan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'deleted_by' => 'Deleted By',
        ];
    }

    public function getLayanan()
    {
        return $this->hasOne(Layanan::className(), ['id' => 'layanan_id_penunjang']);
    }

    public function getTarifTindakanPasien()
    {
        return $this->hasOne(TarifTindakanPasien::className(), ['id' => 'tarif_tindakan_pasien_id']);
    }

    public function getLabelPemeriksaanPa()
    {
        return $this->hasOne(LabelPemeriksaanPa::className(), ['tindakan_tarif_pasien_id' => 'tarif_tindakan_pasien_id']);
    }
}
