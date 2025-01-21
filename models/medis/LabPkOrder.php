<?php

namespace app\models\medis;

use app\models\pegawai\Pegawai;
use Yii;
use app\models\pendaftaran\Layanan;

/**
 * This is the model class for table "medis.lab_pk_order".
 *
 * @property int $id
 * @property string $no_transaksi generate by SP/TRIGGER
 * @property int $ird 1=>IRD;0=>BUKAN IRD
 * @property string $diagnosa
 * @property string $kondisi_sampel Cukup/Kurang/Beku/Lisis/Ikterik/Lipemik
 * @property string|null $catatan
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $log_data
 * @property int|null $is_deleted
 */
class LabPkOrder extends BaseModelAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.lab_pk_order';
    }

    public static function getDb()
    {
        return Yii::$app->get('db_postgre');
    }
    public function rules()
    {
        return [
            [['ird', 'layanan_id', 'dokter_id', 'diagnosa'], 'required'],
            [['ird', 'layanan_id', 'dokter_id', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['ird', 'layanan_id', 'dokter_id', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['diagnosa', 'catatan', 'log_data'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['no_transaksi'], 'string', 'max' => 20],
            [['kondisi_sampel'], 'string', 'max' => 255],
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
            'kondisi_sampel' => 'Kondisi Sampel',
            'catatan' => 'Catatan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'log_data' => 'Log Data',
            'is_deleted' => 'Is Deleted',
        ];
    }
    public function getPemeriksaan()
    {
        return $this->hasMany(LabPkOrderDetail::className(), ['lab_pk_order_id' => 'id'])->alias('pemeriksaan');
    }

    public function getLayanan()
    {
        return $this->hasOne(Layanan::className(), ['id' => 'layanan_id'])->alias('layanan');
    }

    public function getLayananPenunjang()
    {
        return $this->hasOne(Layanan::className(), ['id' => 'layanan_id_penunjang']);
    }

    public function getDokter()
    {
        return $this->hasOne(Pegawai::className(), ['pegawai_id' => 'dokter_id'])->alias('dokter');
    }

    public static function dataLayananOrder($id)
    {
        $data = self::find()->alias('lpo')->select([
            'lpo.id AS order_id',
            'lpo.diagnosa',
            'lpo.catatan',
            'lpo.kondisi_sampel',
            'lpo.layanan_id',
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
