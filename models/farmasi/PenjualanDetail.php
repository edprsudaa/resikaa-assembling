<?php

namespace app\models\farmasi;

use Yii;

/**
 * This is the model class for table "farmasi.penjualan_detail".
 *
 * @property int $id_penjualan_detail
 * @property bool|null $is_active
 * @property int|null $created_by
 * @property string|null $created_at
 * @property int|null $updated_by
 * @property string|null $updated_at
 * @property bool|null $is_deleted
 * @property int|null $deleted_by
 * @property string|null $deleted_at
 * @property string|null $riwayat
 * @property int|null $id_penjualan
 * @property int $id_barang
 * @property int|null $id_satuan
 * @property float|null $stok_saat_jual
 * @property float|null $jumlah
 * @property float|null $jumlah_retur
 * @property string|null $signa
 * @property string|null $catatan
 * @property string|null $expired_date
 * @property float $harga_satuan
 * @property float|null $subtotal_retur
 * @property float $subtotal
 * @property string|null $keterangan
 * @property bool|null $is_fornas
 * @property float|null $jumlah_diberi
 * @property bool|null $is_diganti jika true maka obat tersebut diganti
 * @property bool|null $is_pengganti Jika true maka obat ini merupakan obatpengganti
 * @property int|null $id_barang_diganti id obat yang digantikan
 * @property string|null $sediaan
 * @property float|null $total_subtotal_retur subtotal + subtotal_retur
 */
class PenjualanDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'farmasi.penjualan_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active', 'is_deleted', 'is_fornas', 'is_diganti', 'is_pengganti'], 'boolean'],
            [['created_by', 'updated_by', 'deleted_by', 'id_penjualan', 'id_barang', 'id_satuan', 'id_barang_diganti'], 'default', 'value' => null],
            [['created_by', 'updated_by', 'deleted_by', 'id_penjualan', 'id_barang', 'id_satuan', 'id_barang_diganti'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at', 'expired_date'], 'safe'],
            [['riwayat', 'keterangan'], 'string'],
            [['id_barang'], 'required'],
            [['stok_saat_jual', 'jumlah', 'jumlah_retur', 'harga_satuan', 'subtotal_retur', 'subtotal', 'jumlah_diberi', 'total_subtotal_retur'], 'number'],
            [['signa', 'catatan', 'sediaan'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penjualan_detail' => 'Id Penjualan Detail',
            'is_active' => 'Is Active',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'is_deleted' => 'Is Deleted',
            'deleted_by' => 'Deleted By',
            'deleted_at' => 'Deleted At',
            'riwayat' => 'Riwayat',
            'id_penjualan' => 'Id Penjualan',
            'id_barang' => 'Id Barang',
            'id_satuan' => 'Id Satuan',
            'stok_saat_jual' => 'Stok Saat Jual',
            'jumlah' => 'Jumlah',
            'jumlah_retur' => 'Jumlah Retur',
            'signa' => 'Signa',
            'catatan' => 'Catatan',
            'expired_date' => 'Expired Date',
            'harga_satuan' => 'Harga Satuan',
            'subtotal_retur' => 'Subtotal Retur',
            'subtotal' => 'Subtotal',
            'keterangan' => 'Keterangan',
            'is_fornas' => 'Is Fornas',
            'jumlah_diberi' => 'Jumlah Diberi',
            'is_diganti' => 'Is Diganti',
            'is_pengganti' => 'Is Pengganti',
            'id_barang_diganti' => 'Id Barang Diganti',
            'sediaan' => 'Sediaan',
            'total_subtotal_retur' => 'Total Subtotal Retur',
        ];
    }
    public function getBarang()
    {
        return $this->hasOne(Barang::className(), ['id_barang' => 'id_barang']);
    }
    public function getBarangGanti()
    {
        return $this->hasOne(Barang::className(), ['id_barang' => 'id_barang_diganti']);
    }
}
