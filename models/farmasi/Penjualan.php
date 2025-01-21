<?php

namespace app\models\farmasi;

use app\models\AkunAknUser;
use app\models\master\Barang;
use app\models\medis\Resep;
use app\models\pegawai\DmUnitPenempatan;
use app\models\pegawai\TbPegawai;
use app\models\Pendaftaran\DebiturDetail;
use app\models\simrs\Penjamin;
use app\models\simrs\Unit as SimrsUnit;
use app\models\simrs\Dokter as SimrsDokter;
use app\models\sip\Pegawai;
use app\models\sip\Unit;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "farmasi.penjualan".
 *
 * @property int $id_penjualan
 * @property bool|null $is_active
 * @property int|null $created_by
 * @property string|null $created_at
 * @property int|null $updated_by
 * @property string|null $updated_at
 * @property bool|null $is_deleted
 * @property int|null $deleted_by
 * @property string|null $deleted_at
 * @property string|null $riwayat
 * @property int $id_depo
 * @property string $no_rm
 * @property string $nama_pasien
 * @property string|null $nik
 * @property string|null $jenis_kelamin
 * @property string|null $tgl_lahir
 * @property string|null $umur
 * @property float|null $berat_badan
 * @property float|null $tinggi_badan
 * @property string|null $riwayat_alergi
 * @property string|null $alamat_pasien
 * @property string $status_pasien
 * @property string|null $no_daftar
 * @property string $no_transaksi
 * @property string|null $no_penjualan
 * @property bool|null $is_id_baru
 * @property bool|null $is_backdate
 * @property string|null $tgl_resep
 * @property string|null $jam_resep
 * @property int $id_unit
 * @property int $id_dokter
 * @property string|null $nama_dokter
 * @property string|null $sip_dokter
 * @property int $id_penjamin
 * @property string|null $no_sep
 * @property int $tipe_pembayaran
 * @property bool|null $is_kronis
 * @property int|null $id_bayar
 * @property string|null $tgl_bayar
 * @property float $total_penjualan
 * @property float|null $total_dijamin
 * @property float|null $total_dibayar
 * @property float|null $total_retur
 * @property string|null $catatan
 * @property string|null $diagnosis
 * @property string|null $racikan
 * @property int $status
 * @property int|null $id_resep
 */
class Penjualan extends \yii\db\ActiveRecord
{

    const STATUS_DIBATALKAN = 0;
    const STATUS_DRAFT = 1;
    const STATUS_DICATAT = 2;
    const STATUS_DIBAYAR = 3;
    const STATUS_DISERAHKAN = 4;
    const JENIS_POTRAIT = 0;
    const JENIS_LANDSCAPE = 1;
    public $paket_penjualan;

    // variable laporan R 
    public $lembar_fipo;
    public $format_kertas;
    public $p_dokter_id;
    public $id_dokter_lama;

    const JENIS_SOLID_CAIR = 0;
    const JENIS_LUAR = 1;
    public $etiket_obat;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'farmasi.penjualan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active', 'is_deleted', 'is_id_baru', 'is_backdate', 'is_kronis'], 'boolean'],
            [['created_by', 'updated_by', 'deleted_by', 'id_depo', 'id_unit', 'id_dokter', 'id_penjamin', 'tipe_pembayaran', 'id_bayar', 'status'], 'default', 'value' => null],
            [['created_by', 'updated_by', 'deleted_by', 'id_depo', 'id_unit', 'id_dokter', 'id_penjamin', 'tipe_pembayaran', 'id_bayar', 'status'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at', 'tgl_lahir', 'tgl_resep', 'jam_resep', 'tgl_bayar'], 'safe'],
            [['riwayat', 'no_rm', 'riwayat_alergi', 'alamat_pasien', 'catatan', 'racikan'], 'string'],
            [['id_depo', 'no_rm', 'nama_pasien', 'status_pasien', 'id_unit', 'id_dokter', 'id_penjamin', 'tipe_pembayaran'], 'required'],
            [['berat_badan', 'tinggi_badan', 'total_penjualan', 'total_dijamin', 'total_dibayar', 'total_retur'], 'number'],
            [['nama_pasien', 'nik', 'umur', 'no_daftar', 'no_penjualan', 'nama_dokter', 'sip_dokter', 'no_sep'], 'string', 'max' => 100],
            [['jenis_kelamin'], 'string', 'max' => 1],
            [['status_pasien'], 'string', 'max' => 11],
            [['no_transaksi'], 'string', 'max' => 20],
            [['no_transaksi'], 'unique'],

            [['total_penjualan', 'total_dijamin', 'total_dibayar'], 'required'],
            ['paket_penjualan', 'safe'],
            ['format_kertas', 'safe'],
            ['p_dokter_id', 'safe'],
            ['id_dokter_lama', 'safe'],
            ['diagnosis', 'safe'],
            ['etiket_obat', 'safe'],
            ['id_resep', 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penjualan' => 'Id Penjualan',
            'is_active' => 'Is Active',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'is_deleted' => 'Is Deleted',
            'deleted_by' => 'Deleted By',
            'deleted_at' => 'Deleted At',
            'riwayat' => 'Riwayat',
            'id_depo' => 'Id Depo',
            'no_rm' => 'No. RM',
            'nama_pasien' => 'Nama Pasien',
            'nik' => 'NIK',
            'jenis_kelamin' => 'Jenis Kelamin',
            'tgl_lahir' => 'Tgl Lahir',
            'umur' => 'Umur',
            'berat_badan' => 'Berat Badan',
            'tinggi_badan' => 'Tinggi Badan',
            'riwayat_alergi' => 'Riwayat Alergi',
            'alamat_pasien' => 'Alamat Pasien',
            'status_pasien' => 'Status Pasien',
            'no_daftar' => 'No. Daftar',
            'no_transaksi' => 'No. Transaksi',
            'no_penjualan' => 'No. Penjualan',
            'is_id_baru' => 'Is Id Baru',
            'is_backdate' => 'Is Backdate',
            'tgl_resep' => 'Tgl Resep',
            'jam_resep' => 'Jam Resep',
            'id_unit' => 'Id Unit',
            'id_dokter' => 'Id Dokter',
            'nama_dokter' => 'Nama Dokter',
            'sip_dokter' => 'SIP Dokter',
            'id_penjamin' => 'Id Penjamin',
            'no_sep' => 'No. SEP',
            'tipe_pembayaran' => 'Tipe Pembayaran',
            'is_kronis' => 'Is Kronis',
            'id_bayar' => 'Id Bayar',
            'tgl_bayar' => 'Tgl Bayar',
            'total_penjualan' => 'Total Penjualan',
            'total_dijamin' => 'Total Dijamin',
            'total_dibayar' => 'Total Dibayar',
            'total_retur' => 'Total Retur',
            'catatan' => 'Catatan',
            'racikan' => 'Racikan',
            'status' => 'Status',
            'diagnosis' => 'Diagnosis',
            'id_resep' => 'Id Resep',
        ];
    }


    public function getPenjualanDetail()
    {
        return $this->hasMany(PenjualanDetail::className(), ['id_penjualan' => 'id_penjualan']);
    }



    public function getDepo()
    {
        return $this->hasOne(DmUnitPenempatan::className(), ['kode' => 'id_depo']);
    }

    public function getPetugas()
    {
        return $this->hasOne(AkunAknUser::className(), ['userid' => 'created_by']);
    }

    public function getUnit()
    {
        return $this->hasOne(DmUnitPenempatan::className(), ['kode' => 'id_unit']);
    }


    public function getDokter()
    {
        return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'id_dokter']);
    }


    public function getIs_resep()
    {
        return $this->id_resep ? true : false;
    }

    public function getResep()
    {
        return $this->hasOne(Resep::className(), ['id' => 'id_resep']);
    }
}
