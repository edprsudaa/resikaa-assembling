<?php

namespace app\models\pegawai;

use Yii;

/**
 * This is the model class for table "pegawai.dm_kecamatan".
 *
 * @property string $kode_prov_kab_kecamatan
 * @property string $nama
 * @property string|null $kode_prov_kab
 * @property string|null $kode_prov
 * @property int|null $aktif
 * @property string|null $created_at
 * @property string|null $created_by
 * @property string|null $updated_at
 * @property string|null $updated_by
 * @property int|null $is_deleted
 */
class DmKecamatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pegawai.dm_kecamatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_prov_kab_kecamatan', 'nama'], 'required'],
            [['aktif', 'is_deleted'], 'default', 'value' => null],
            [['aktif', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'string'],
            [['kode_prov_kab_kecamatan', 'kode_prov_kab', 'kode_prov'], 'string', 'max' => 10],
            [['nama'], 'string', 'max' => 50],
            [['kode_prov_kab_kecamatan'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kode_prov_kab_kecamatan' => 'Kode Prov Kab Kecamatan',
            'nama' => 'Nama',
            'kode_prov_kab' => 'Kode Prov Kab',
            'kode_prov' => 'Kode Prov',
            'aktif' => 'Aktif',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_deleted' => 'Is Deleted',
        ];
    }
    function getKabupaten()
    {
        return $this->hasOne(DmKabupaten::className(),['kode_prov_kabupaten'=>'kode_prov_kab']);
    }
}
