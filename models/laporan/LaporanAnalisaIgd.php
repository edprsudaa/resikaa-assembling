<?php

namespace app\models\laporan;

use app\models\pendaftaran\Registrasi;
use Yii;

/**
 * This is the model class for table "analisa_dokumen".
 *
 * @property int $analisa_dokumen_id
 * @property string $ps_kode
 * @property string $reg_kode
 * @property int|null $status
 * @property string $created_by
 * @property string $created_at
 * @property string|null $updated_by
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @property int|null $dokter_id
 * @property int|null $unit_id
 */
class LaporanAnalisaIgd extends \yii\db\ActiveRecord
{
    const JENIS_HARIAN = 'harian';
    const JENIS_BULANAN = 'bulanan';
    const JENIS_TAHUNAN = 'tahunan';
    const TIPE_DOKTER = 'dokter';
    const TIPE_RUANGAN = 'ruangan';
    const TIPE_SELURUH = 'seluruh';
    public $jenis_laporan; // harian, bulanan
    public $tipe_laporan; // harian, bulanan

    public $tgl_hari;
    public $tgl_rentang_1;
    public $tgl_rentang_2;
    public $tgl_bulan;
    public $tgl_tahun;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pengolahan_data.analisa_dokumen';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_pengolahan_data');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ps_kode', 'reg_kode'], 'required'],
            [['status', 'deleted_by', 'dokter_id', 'unit_id'], 'default', 'value' => null],
            [['status', 'deleted_by', 'dokter_id', 'unit_id'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at', 'tipe_laporan', 'jenis_laporan'], 'safe'],
            [['ps_kode', 'reg_kode', 'created_by', 'updated_by'], 'string', 'max' => 10],

            [
                ['tgl_hari',],
                'required',
                'when' => function ($model) {
                    return $model->jenis_laporan == self::JENIS_HARIAN;
                },
                'whenClient' => "function (attribute, value) {
                    return $('#PengadaanBarang_jenis_laporan_0').prop('checked');
                }"
            ],
            [
                ['tgl_bulan',],
                'required',
                'when' => function ($model) {
                    return $model->jenis_laporan == self::JENIS_BULANAN;
                },
                'whenClient' => "function (attribute, value) {
                    return $('#PengadaanBarang_jenis_laporan_1').prop('checked');
                }"
            ],
            [
                ['tgl_tahun',],
                'required',
                'when' => function ($model) {
                    return $model->jenis_laporan == self::JENIS_TAHUNAN;
                },
                'whenClient' => "function (attribute, value) {
                    return $('#PengadaanBarang_jenis_laporan_2').prop('checked');
                }"
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'analisa_dokumen_id' => 'Analisa Dokumen ID',
            'ps_kode' => 'Ps Kode',
            'reg_kode' => 'Reg Kode',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
            'dokter_id' => 'Dokter ID',
            'unit_id' => 'Unit ID',
        ];
    }
    function beforeSave($model)
    {
        if ($this->isNewRecord) {
            $this->created_at = date('Y-m-d H:i:s');
            $this->created_by = Yii::$app->user->identity->id;
        } else {
            $this->updated_at = date('Y-m-d H:i:s');
            $this->updated_by = Yii::$app->user->identity->id;
        }
        return parent::beforeSave($model);
    }
}
