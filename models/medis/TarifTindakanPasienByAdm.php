<?php

namespace app\models\medis;

use app\models\pegawai\TbPegawai;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "medis.tarif_tindakan_pasien_by_adm".
 *
 * @property int $id
 * @property int $layanan_id
 * @property int|null $pelaksana_id
 * @property int $tarif_tindakan_id
 * @property string $tanggal
 * @property int $cyto
 * @property int $jumlah
 * @property int $harga
 * @property int $subtotal
 * @property string|null $keterangan
 * @property string|null $no_permintaan_alat
 * @property int|null $pembayaran_id
 * @property int|null $is_lis
 * @property int|null $is_pac
 * @property string $created_at
 * @property int|null $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $log_data
 * @property int $is_deleted
 * @property int|null $no_tran_penunjang
 * @property int|null $jenis_tindakan
 * @property int|null $tarif_tindakan_pasien_id
 * @property int|null $pelaksana_anastesi_id
 * @property int|null $verified 0 : Belum verified, 1 : Sudah verified
 */
class TarifTindakanPasienByAdm extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.tarif_tindakan_pasien_by_adm';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pelaksana_id', 'keterangan', 'no_permintaan_alat', 'pembayaran_id', 'created_by', 'updated_at', 'updated_by', 'log_data', 'no_tran_penunjang', 'tarif_tindakan_pasien_id', 'pelaksana_anastesi_id'], 'default', 'value' => null],
            [['verified'], 'default', 'value' => 0],
            [['jumlah'], 'default', 'value' => 1],
            [['jenis_tindakan'], 'default', 'value' => 3],
            [['layanan_id', 'tarif_tindakan_id', 'tanggal', 'harga', 'subtotal'], 'required'],
            [['layanan_id', 'pelaksana_id', 'tarif_tindakan_id', 'cyto', 'jumlah', 'harga', 'subtotal', 'pembayaran_id', 'is_lis', 'is_pac', 'created_by', 'updated_by', 'is_deleted', 'no_tran_penunjang', 'jenis_tindakan', 'tarif_tindakan_pasien_id', 'pelaksana_anastesi_id', 'verified'], 'default', 'value' => null],
            [['layanan_id', 'pelaksana_id', 'tarif_tindakan_id', 'cyto', 'jumlah', 'harga', 'subtotal', 'pembayaran_id', 'is_lis', 'is_pac', 'created_by', 'updated_by', 'is_deleted', 'no_tran_penunjang', 'jenis_tindakan', 'tarif_tindakan_pasien_id', 'pelaksana_anastesi_id', 'verified'], 'integer'],
            [['tanggal', 'created_at', 'updated_at'], 'safe'],
            [['keterangan', 'log_data'], 'string'],
            [['no_permintaan_alat'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'layanan_id' => 'Layanan ID',
            'pelaksana_id' => 'Pelaksana ID',
            'tarif_tindakan_id' => 'Tarif Tindakan ID',
            'tanggal' => 'Tanggal',
            'cyto' => 'Cyto',
            'jumlah' => 'Jumlah',
            'harga' => 'Harga',
            'subtotal' => 'Subtotal',
            'keterangan' => 'Keterangan',
            'no_permintaan_alat' => 'No Permintaan Alat',
            'pembayaran_id' => 'Pembayaran ID',
            'is_lis' => 'Is Lis',
            'is_pac' => 'Is Pac',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'log_data' => 'Log Data',
            'is_deleted' => 'Is Deleted',
            'no_tran_penunjang' => 'No Tran Penunjang',
            'jenis_tindakan' => 'Jenis Tindakan',
            'tarif_tindakan_pasien_id' => 'Tarif Tindakan Pasien ID',
            'pelaksana_anastesi_id' => 'Pelaksana Anastesi ID',
            'verified' => 'Verified',
        ];
    }

    function getPelaksana()
    {
        return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'pelaksana_id']);
    }

    public static function getListTindakan($registrasi_kode)
    {
        $data = self::find()->alias('ttpba')->select([
            't.deskripsi as nama',
            't.id as tindakan_id',
            'ttpba.tarif_tindakan_pasien_id',
            'ttpba.jumlah',
            'ttpba.harga',
            'ttpba.subtotal',
            'ttpba.tanggal',
            'ttpba.tarif_tindakan_id',
            'ttpba.jenis_tindakan',
            'l.unit_kode',
            'l.jenis_layanan',
            'dup.nama as unit_nama',
            'ttpba.pelaksana_id',
        ])
            ->joinWith(['pelaksana' => function ($query) {
                $query->select(['pegawai_id', 'nama_lengkap', 'id_nip_nrp'])
                    ->with(['riwayatPenempatan' => function ($query) {
                        $query->distinct()->select(['id_nip_nrp', 'sdm_rumpun'])->where(['status_aktif' => 1]);
                    }]);
            }])
            ->leftJoin('pendaftaran.layanan l', 'l.id=ttpba.layanan_id')
            ->leftJoin('pegawai.dm_unit_penempatan dup', 'dup.kode=l.unit_kode')
            ->leftJoin('medis.tarif_tindakan tt', 'tt.id=ttpba.tarif_tindakan_id')
            ->leftJoin('medis.tindakan t', 't.id=tt.tindakan_id')
            ->where([
                'ttpba.is_deleted' => 0,
                'l.registrasi_kode' => $registrasi_kode
            ])
            ->orderBy(['l.unit_kode' => SORT_ASC])
            ->asArray()->all();

        $listId = array_filter(ArrayHelper::getColumn($data, 'tarif_tindakan_pasien_id'));

        $dataTambahan = TarifTindakanPasien::find()->alias('ttp')
            ->select([
                't.deskripsi as nama',
                't.id as tindakan_id',
                'ttp.jumlah',
                'ttp.harga',
                'ttp.subtotal',
                'ttp.tanggal',
                'ttp.tarif_tindakan_id',
                'ttp.jenis_tindakan',
                'l.unit_kode',
                'l.jenis_layanan',
                'dup.nama as unit_nama',
                'ttp.pelaksana_id',
            ])
            ->joinWith(['pelaksana' => function ($query) {
                $query->select(['pegawai_id', 'nama_lengkap', 'id_nip_nrp'])
                    ->with(['riwayatPenempatan' => function ($query) {
                        $query->distinct()->select(['id_nip_nrp', 'sdm_rumpun'])->where(['status_aktif' => 1]);
                    }]);
            }])
            ->leftJoin('pendaftaran.layanan l', 'l.id=ttp.layanan_id')
            ->leftJoin('pegawai.dm_unit_penempatan dup', 'dup.kode=l.unit_kode')
            ->leftJoin('medis.tarif_tindakan tt', 'tt.id=ttp.tarif_tindakan_id')
            ->leftJoin('medis.tindakan t', 't.id=tt.tindakan_id')
            ->where([
                'ttp.is_deleted' => 0,
                'l.registrasi_kode' => $registrasi_kode,
                'ttp.jenis_tindakan' => [2]
            ])
            ->andWhere(['not in', 'ttp.id', $listId])
            ->orderBy(['l.unit_kode' => SORT_ASC])
            ->asArray()->all();

        return array_merge($data, $dataTambahan);
    }
}
