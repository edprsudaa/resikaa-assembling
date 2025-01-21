<?php

namespace app\models\medis;

use Yii;
use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;

/**
 * This is the model class for table "medis.lab_pa_order".
 *
 * @property int $id
 * @property string $no_transaksi generate by SP/TRIGGER
 * @property int $ird 1=>IRD;0=>BUKAN IRD
 * @property string $tgl_pengambilan_spesimen
 * @property string $tgl_pemeriksaan
 * @property string $lokalis
 * @property string $dilakukan_secara Biopsi/Biopsi Aspirasi/Kerokan/Operasi/Smear/Inprint/Sekret/Cairan Tubuh
 * @property string $spesimen_difikasi Ya/Tidak
 * @property string $cairan_fiksasi Formalin 10%/Alkohol 70%/Lainnya narasi
 * @property string $pernah_pemeriksaan_pa Tidak/Narasi Pernah pada tanggal
 * @property string $diagnosa
 * @property string $permintaan
 * @property string|null $haid_terakhir_g
 * @property string|null $haid_terakhir_p
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $log_data
 * @property int|null $is_deleted
 */
class LabPaOrder extends BaseModelAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.lab_pa_order';
    }

    public static function getDb()
    {
        return Yii::$app->get('db_postgre');
    }
    public function rules()
    {
        return [
            [['ird', 'layanan_id', 'dokter_id', 'tgl_pengambilan_spesimen', 'tgl_pemeriksaan', 'lokalis', 'dilakukan_secara', 'spesimen_difikasi', 'diagnosa', 'permintaan'], 'required'],
            [['ird', 'layanan_id', 'dokter_id', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['ird', 'layanan_id', 'dokter_id', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['tgl_pengambilan_spesimen', 'tgl_pemeriksaan', 'created_at', 'updated_at'], 'safe'],
            [['lokalis', 'diagnosa', 'permintaan', 'log_data'], 'string'],
            [['no_transaksi'], 'string', 'max' => 20],
            [['dilakukan_secara', 'spesimen_difikasi', 'cairan_fiksasi', 'pernah_pemeriksaan_pa', 'haid_terakhir_g', 'haid_terakhir_p'], 'string', 'max' => 255],
            [['no_transaksi'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_transaksi' => 'No.Transaksi',
            'ird' => 'Kirim Ke Unit IRD',
            'layanan_id' => 'Layanan',
            'dokter_id' => 'Dokter',
            'tgl_pengambilan_spesimen' => 'Tgl.Pengambilan Spesimen',
            'tgl_pemeriksaan' => 'Tgl.Pemeriksaan',
            'lokalis' => 'Status Lokalis',
            'dilakukan_secara' => 'Dilakukan Secara',
            'spesimen_difikasi' => 'Spesimen Difikasi',
            'cairan_fiksasi' => 'Cairan Fiksasi',
            'pernah_pemeriksaan_pa' => 'Pernah Pemeriksaan PA',
            'diagnosa' => 'Diagnosa',
            'permintaan' => 'Permintaan',
            'haid_terakhir_g' => 'Haid Terakhir (G)',
            'haid_terakhir_p' => 'Haid Terakhir (P)',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'log_data' => 'Log Data',
            'is_deleted' => 'Is Deleted',
        ];
    }
    public function getDokter()
    {
        return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'dokter_id']);
    }
    public function getLayanan()
    {
        return $this->hasOne(Layanan::className(), ['id' => 'layanan_id']);
    }
    public function getLayananPenunjang()
    {
        return $this->hasOne(Layanan::className(), ['id' => 'layanan_id_penunjang']);
    }

    public static function dataLayananOrder($id)
    {
        $data = self::find()->alias('lpo')->select([
            'lpo.id AS order_id',
            'lpo.layanan_id',
            'lpo.diagnosa',
            'lpo.tgl_pengambilan_spesimen',
            'lpo.tgl_pemeriksaan',
            'lpo.lokalis',
            'lpo.dilakukan_secara',
            'lpo.spesimen_difikasi',
            'lpo.cairan_fiksasi',
            'lpo.pernah_pemeriksaan_pa',
            'lpo.permintaan',
            'lpo.haid_terakhir_g',
            'lpo.haid_terakhir_p',
            'lr.kelas_rawat_kode',
            'kr.nama AS kelas_nama',
            "coalesce(concat(dok.gelar_sarjana_depan, ' ') , '') || coalesce(dok.nama_lengkap, '') || coalesce(concat(' ', dok.gelar_sarjana_belakang), '') as dokter_nama"
        ])
            ->leftJoin('pegawai.tb_pegawai dok', 'dok.pegawai_id=lpo.dokter_id')
            ->leftJoin('pendaftaran.layanan lr', 'lr.id=lpo.layanan_id')
            ->leftJoin('pendaftaran.kelas_rawat kr', 'kr.kode=lr.kelas_rawat_kode')
            ->where([
                'lpo.layanan_id_penunjang' => $id,
                'lpo.is_deleted' => 0
            ])->asArray()->one();

        return $data;
    }
}
