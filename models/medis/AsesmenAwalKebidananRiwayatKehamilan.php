<?php

namespace app\models\medis;

use Yii;
use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;
/**
 * This is the model class for table "medis.asesmen_awal_kebidanan_riwayat_kehamilan".
 *
 * @property int $id
 * @property int $layanan_id
 * @property int $perawat_id
 * @property string|null $tanggal
 * @property string|null $usia_kehamilan
 * @property string|null $tempat
 * @property string|null $penyulit
 * @property string|null $tindakan
 * @property string|null $penolong
 * @property string|null $jk
 * @property int|null $bb_gram
 * @property string|null $ket_anak_skrg
 * @property string|null $ket
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $log_data
 * @property int $is_deleted
 */
class AsesmenAwalKebidananRiwayatKehamilan extends BaseModelAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.asesmen_awal_kebidanan_riwayat_kehamilan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['layanan_id', 'perawat_id'], 'required'],
            [['layanan_id', 'perawat_id', 'bb_gram', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['layanan_id', 'perawat_id', 'bb_gram', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['tanggal', 'usia_kehamilan', 'tempat', 'penyulit', 'tindakan', 'penolong', 'jk', 'ket_anak_skrg', 'ket', 'log_data'], 'string'],
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
            'layanan_id' => 'Layanan ID',
            'perawat_id' => 'Perawat ID',
            'tanggal' => 'Tgl/Thn',
            'usia_kehamilan' => 'Usia Kehamilan',
            'tempat' => 'Tempat',
            'penyulit' => 'Penyulit',
            'tindakan' => 'Jenis Tindakan',
            'penolong' => 'Penolong',
            'jk' => 'Jenis kelamin',
            'bb_gram' => 'BB(gram)',
            'ket_anak_skrg' => 'Ket.Anak Skrg',
            'ket' => 'Keterangan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'log_data' => 'Log Data',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * {@inheritdoc}
     * @return AsesmenAwalKebidananRiwayatKehamilanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AsesmenAwalKebidananRiwayatKehamilanQuery(get_called_class());
    }
    public function beforeSave($insert) {
        if ($insert) {
            $this->is_deleted = 0;
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
    public function getPerawat()
    {
        return $this->hasOne(TbPegawai::className(),['pegawai_id'=>'perawat_id']);
    }
    public function getLayanan()
    {
        return $this->hasOne(Layanan::className(),['id'=>'layanan_id']);
    }
}