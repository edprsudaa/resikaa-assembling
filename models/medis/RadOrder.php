<?php

namespace app\models\medis;

use app\models\pegawai\Pegawai;
use app\models\pendaftaran\Layanan;
use Yii;

/**
 * This is the model class for table "medis.rad_order".
 *
 * @property int $id
 * @property string $no_transaksi generate by SP/TRIGGER
 * @property int $ird 1=>IRD;0=>BUKAN IRD
 * @property string $diagnosa narasi diagnosis/catatan klinis pasien pasien
 * @property string $permintaan narasi permintaan pemeriksaan radiologi yg dibutuhkan pasien
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $log_data
 * @property int|null $is_deleted
 */
class RadOrder extends BaseModelAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.rad_order';
    }

    public static function getDb()
    {
        return Yii::$app->get('db_postgre');
    }
    public function rules()
    {
        return [
            [['ird', 'layanan_id', 'dokter_id', 'diagnosa', 'permintaan'], 'required'],
            [['ird', 'layanan_id', 'dokter_id', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['ird', 'layanan_id', 'dokter_id', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['diagnosa', 'permintaan', 'log_data'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['no_transaksi'], 'string', 'max' => 20],
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
            'diagnosa' => 'Diagnosa',
            'permintaan' => 'Permintaan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'log_data' => 'Log Data',
            'is_deleted' => 'Is Deleted',
        ];
    }

    public function getLayanan()
    {
        return $this->hasOne(Layanan::className(), ['id' => 'layanan_id']);
    }

    public function getLayananPenunjang()
    {
        return $this->hasOne(Layanan::className(), ['id' => 'layanan_id_penunjang']);
    }

    public function getDokter()
    {
        return $this->hasOne(Pegawai::className(), ['pegawai_id' => 'dokter_id']);
    }

    public static function dataLayananOrder($id)
    {
        $data = self::find()->alias('lpo')->select([
            'lpo.id AS order_id',
            'lpo.diagnosa',
            'lpo.permintaan',
            'lr.kelas_rawat_kode',
            'kr.nama AS kelas_nama',
            "coalesce(concat(dok.gelar_sarjana_depan, ' ') , '') || coalesce(dok.nama_lengkap, '') || coalesce(concat(' ', dok.gelar_sarjana_belakang), '') as dokter_nama"
        ])
            ->leftJoin('pegawai.tb_pegawai dok', 'dok.pegawai_id=lpo.dokter_id')
            ->leftJoin('pendaftaran.layanan lr', 'lr.id=lpo.layanan_id')
            ->leftJoin('pendaftaran.kelas_rawat kr', 'kr.kode=lr.kelas_rawat_kode')
            ->where([
                'lpo.layanan_id_penunjang' => $id
            ])->asArray()->one();

        return $data;
    }

    public static function pasienPemeriksaanDokter($tgl, $unit)
    {
        $data = self::find()->alias('lpo')->select([
            'r.kode AS kode_registrasi',
            "concat(p.nama, ' / ', p.kode, ' / No. Reg. : ', r.kode) AS nama"
        ])
            ->innerJoin('pendaftaran.layanan lp', 'lp.id=lpo.layanan_id_penunjang')
            ->innerJoin('pendaftaran.registrasi r', 'r.kode=lp.registrasi_kode')
            ->innerJoin('pendaftaran.pasien p', 'p.kode=r.pasien_kode')
            // ->innerJoin('penunjang.result_pacs rp', 'rp.nomor_registrasi=r.kode')
            ->andWhere(['is_deleted' => 0,]);
        // ->andWhere([
        //     'BETWEEN',
        //     'lp.tgl_masuk',
        //     date('Y-m-d', strtotime($tgl)) . " 00:00:00",
        //     date('Y-m-d', strtotime($tgl)) . " 23:59:59"
        // ]);

        if ($unit == 316) {
            $data->andWhere(['lpo.ird' => 0]);
        } else {
            $data->andWhere(['lpo.ird' => 0]);
        }

        return $data->asArray()->all();
    }

    public static function dataPasienHasil($kode_reg)
    {
        $data = self::find()->alias('lpo')->select([
            'p.nama AS pasien_nama',
            'p.kode AS pasien_kode',
            'r.kode AS registrasi_kode',
            'up.nama AS unit_asal',
            'lp.tgl_masuk',
            "coalesce(concat(dok.gelar_sarjana_depan, ' ') , '') || coalesce(dok.nama_lengkap, '') || coalesce(concat(' ', dok.gelar_sarjana_belakang), '') as dokter_nama"
        ])
            ->innerJoin('pendaftaran.layanan lp', 'lp.id=lpo.layanan_id_penunjang')
            ->innerJoin('pendaftaran.registrasi r', 'r.kode=lp.registrasi_kode')
            ->innerJoin('pendaftaran.pasien p', 'p.kode=r.pasien_kode')
            ->leftJoin('pegawai.tb_pegawai dok', 'dok.pegawai_id=lpo.dokter_id')
            ->leftJoin('pegawai.dm_unit_penempatan up', 'up.kode=lp.unit_asal_kode')
            ->where([
                'r.kode' => $kode_reg
            ])->asArray()->one();

        return $data;
    }
}
