<?php

namespace app\models\pegawai;

use Yii;

/**
 * This is the model class for table "pegawai.dm_kabupaten".
 *
 * @property string $kode_prov_kabupaten
 * @property string|null $nama
 * @property string|null $jenis
 * @property int|null $kode_prov
 * @property int|null $aktif
 * @property string|null $created_at
 * @property string|null $created_by
 * @property string|null $updated_at
 * @property string|null $updated_by
 * @property int|null $is_deleted
 */
class DmKabupaten extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pegawai.dm_kabupaten';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_prov_kabupaten'], 'required'],
            [['kode_prov', 'aktif', 'is_deleted'], 'default', 'value' => null],
            [['kode_prov', 'aktif', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'string'],
            [['kode_prov_kabupaten', 'jenis'], 'string', 'max' => 10],
            [['nama'], 'string', 'max' => 50],
            [['kode_prov_kabupaten'], 'unique'],
            [['kode_prov'], 'exist', 'skipOnError' => true, 'targetClass' => PegawaiDmProvinsi::className(), 'targetAttribute' => ['kode_prov' => 'kode']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kode_prov_kabupaten' => 'Kode Prov Kabupaten',
            'nama' => 'Nama',
            'jenis' => 'Jenis',
            'kode_prov' => 'Kode Prov',
            'aktif' => 'Aktif',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_deleted' => 'Is Deleted',
        ];
    }
    public function getProvinsi()
    {
        return $this->hasOne(DmProvinsi::className(), ['kode' => 'kode_prov']);
    }
}
