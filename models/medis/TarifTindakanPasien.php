<?php

namespace app\models\medis;

use app\models\pegawai\Pegawai;
use app\models\pegawai\TbPegawai;
use Yii;

/**
 * This is the model class for table "medis.tarif_tindakan_pasien".
 *
 * @property int $id
 * @property int $tarif_tindakan_id reff medis.tarif_tindakan.id
 * @property int $layanan_id reff pendaftaran.layanan.id
 * @property int|null $dokter_id reff pegawai.tb_pegawai.pegawai_id, jika dokter yg melakukan
 * @property int|null $perawat_id reff pegawai.tb_pegawai.pegawai_id, jika perawat yg melakukan
 * @property int $cyto
 * @property string|null $keterangan
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int $is_deleted
 */
class TarifTindakanPasien extends BaseModelAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.tarif_tindakan_pasien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['tarif_tindakan_id','pelaksana_id','layanan_id','cyto','jumlah'], 'required'],
            [['tarif_tindakan_id', 'layanan_id', 'cyto', 'jumlah'], 'required'],
            [['pelaksana_id', 'layanan_id', 'cyto', 'created_by', 'updated_by', 'is_deleted', 'jumlah', 'harga', 'subtotal'], 'integer'],
            ['jumlah', 'integer', 'min' => 1],
            [['keterangan'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tarif_tindakan_id' => 'Tindakan',
            'tanggal' => 'Tanggal',
            'pelaksana_id' => 'DPJP/PPJP',
            'layanan_id' => 'Unit',
            'cyto' => 'Cyto',
            'jumlah' => 'Jumlah',
            'keterangan' => 'Keterangan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_deleted' => 'Is Deleted',
        ];
    }
    public function getTarifTindakan()
    {
        return $this->hasOne(TarifTindakan::className(), ['id' => 'tarif_tindakan_id']);
    }

    function getPelaksana()
    {
        return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'pelaksana_id']);
    }

    public function getDokter()
    {
        return $this->hasOne(Pegawai::className(), ['pegawai_id' => 'pelaksana_id']);
    }

    public static function getTindakanPasien($layanan)
    {
        $data = Yii::$app->db_postgre->createCommand("SELECT 
                tp.id,
                t.deskripsi,
                t.kode_jenis,
                t2.deskripsi AS nama_jenis,
                kr.nama AS kelas_nama,
                tp.jumlah,
                tp.harga,
                tp.cyto,
                tp.subtotal,
                dok.pegawai_id,
                tp.layanan_id,
                tp.tarif_tindakan_id,
                tp.created_at,
                coalesce(concat(dok.gelar_sarjana_depan, ' ') , '') || coalesce(dok.nama_lengkap, '') || coalesce(concat(' ', dok.gelar_sarjana_belakang), '') as dokter_nama
            FROM medis.tarif_tindakan_pasien tp
            LEFT JOIN medis.tarif_tindakan tt ON tt.id=tp.tarif_tindakan_id
            LEFT JOIN medis.tindakan t ON t.id=tt.tindakan_id
            LEFT JOIN medis.tindakan t2 ON t2.id=t.parent_id
            LEFT JOIN pegawai.tb_pegawai dok ON dok.pegawai_id=tp.pelaksana_id
            LEFT JOIN pendaftaran.kelas_rawat kr ON kr.kode=tt.kelas_rawat_kode
            WHERE tp.layanan_id=" . $layanan . " AND tp.is_deleted=0 ORDER BY tp.created_at ")->queryAll();

        return $data;
    }

    public static function getTindakanPacs($layanan)
    {
        $data = self::find()->alias('ttp')
            ->select([
                'ttp.tanggal',
                't.kode_jenis',
                't.deskripsi',
                'ttp.pelaksana_id',
                "coalesce(concat(p.gelar_sarjana_depan, ' ') , '') || coalesce(p.nama_lengkap, '') || coalesce(concat(' ', p.gelar_sarjana_belakang), '') as dokter_nama",
                '(tt.js_adm + tt.js_sarana + tt.js_bhp + tt.js_dokter_operator + tt.js_dokter_lainya + tt.js_dokter_anastesi + tt.js_penata_anastesi + tt.js_paramedis + tt.js_lainya) as tarif'
            ])
            ->leftJoin('medis.tarif_tindakan tt', 'tt.id=ttp.tarif_tindakan_id')
            ->leftJoin('medis.tindakan t', 't.id=tt.tindakan_id')
            ->leftJoin('pegawai.tb_pegawai p', 'p.pegawai_id=ttp.pelaksana_id')
            ->where(['ttp.layanan_id' => $layanan, 'ttp.is_deleted' => 0])
            ->asArray()->all();

        return $data;
    }

    public static function getTarifTIndakanPasienExpertisePa($pemeriksaan)
    {
        $data = self::find()->alias('ttp')
            ->select([
                't.id',
                't.deskripsi'
            ])
            ->innerJoin('medis.tarif_tindakan tt', 'tt.id=ttp.tarif_tindakan_id')
            ->innerJoin('medis.tindakan t', 't.id=tt.tindakan_id')
            ->where(['ttp.id' => $pemeriksaan])
            ->asArray()
            ->one();

        return $data;
    }
}
