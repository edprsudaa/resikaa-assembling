<?php

namespace app\models\farmasi;

use Yii;

/**
 * This is the model class for table "farmasi.master_barang".
 *
 * @property int $id_barang
 * @property bool|null $is_active
 * @property int|null $created_by
 * @property string|null $created_at
 * @property int|null $updated_by
 * @property string|null $updated_at
 * @property bool|null $is_deleted
 * @property int|null $deleted_by
 * @property string|null $deleted_at
 * @property string|null $riwayat
 * @property string|null $kode_barang
 * @property string $nama_barang
 * @property string|null $nama_generik
 * @property int $id_satuan
 * @property int $id_kemasan
 * @property string|null $tipe_barang
 * @property int|null $id_kelompok
 * @property int|null $id_jenis
 * @property int|null $id_sub_jenis
 * @property int|null $id_golongan
 * @property int|null $id_klasifikasi
 * @property string|null $retriksi
 * @property string|null $deskripsi
 * @property string|null $keterangan
 * @property int|null $isi_per_kemasan
 * @property float $harga_kemasan
 * @property float $harga_satuan_terakhir
 * @property float $harga_satuan_tertinggi
 * @property bool|null $is_ppn
 * @property float|null $total_ppn
 * @property float|null $diskon_persen
 * @property float|null $stok_max
 * @property float|null $stok_min
 */
class Barang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'farmasi.master_barang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active', 'is_deleted', 'is_ppn'], 'boolean'],
            [['created_by', 'updated_by', 'deleted_by', 'id_satuan', 'id_kemasan', 'id_kelompok', 'id_jenis', 'id_sub_jenis', 'id_golongan', 'id_klasifikasi', 'isi_per_kemasan'], 'default', 'value' => null],
            [['created_by', 'updated_by', 'deleted_by', 'id_satuan', 'id_kemasan', 'id_kelompok', 'id_jenis', 'id_sub_jenis', 'id_golongan', 'id_klasifikasi', 'isi_per_kemasan'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['riwayat', 'kode_barang', 'nama_barang', 'nama_generik', 'tipe_barang', 'retriksi', 'deskripsi', 'keterangan'], 'string'],
            [['nama_barang', 'id_satuan', 'id_kemasan'], 'required'],
            [['harga_kemasan', 'harga_satuan_terakhir', 'harga_satuan_tertinggi', 'total_ppn', 'diskon_persen', 'stok_max', 'stok_min'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_barang' => 'Id Barang',
            'is_active' => 'Is Active',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'is_deleted' => 'Is Deleted',
            'deleted_by' => 'Deleted By',
            'deleted_at' => 'Deleted At',
            'riwayat' => 'Riwayat',
            'kode_barang' => 'Kode Barang',
            'nama_barang' => 'Nama Barang',
            'nama_generik' => 'Nama Generik',
            'id_satuan' => 'Id Satuan',
            'id_kemasan' => 'Id Kemasan',
            'tipe_barang' => 'Tipe Barang',
            'id_kelompok' => 'Id Kelompok',
            'id_jenis' => 'Id Jenis',
            'id_sub_jenis' => 'Id Sub Jenis',
            'id_golongan' => 'Id Golongan',
            'id_klasifikasi' => 'Id Klasifikasi',
            'retriksi' => 'Retriksi',
            'deskripsi' => 'Deskripsi',
            'keterangan' => 'Keterangan',
            'isi_per_kemasan' => 'Isi Per Kemasan',
            'harga_kemasan' => 'Harga Kemasan',
            'harga_satuan_terakhir' => 'Harga Satuan Terakhir',
            'harga_satuan_tertinggi' => 'Harga Satuan Tertinggi',
            'is_ppn' => 'Is Ppn',
            'total_ppn' => 'Total Ppn',
            'diskon_persen' => 'Diskon Persen',
            'stok_max' => 'Stok Max',
            'stok_min' => 'Stok Min',
        ];
    }

    /**
     * {@inheritdoc}
     * @return BarangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BarangQuery(get_called_class());
    }
    
    function getSatuan()
    {
        return $this->hasOne(Satuan::className(),['id_satuan'=>'id_satuan']);
    }
}
