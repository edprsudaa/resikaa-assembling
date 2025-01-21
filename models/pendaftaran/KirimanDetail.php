<?php

namespace app\models\pendaftaran;

use Yii;

/**
 * This is the model class for table "pendaftaran.kiriman_detail".
 *
 * @property string $kode
 * @property string $kiriman_kode
 * @property string $nama
 * @property int|null $created_by
 * @property string|null $created_at
 * @property int|null $updated_by
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $aktif
 */
class KirimanDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran.kiriman_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'kiriman_kode', 'nama'], 'required'],
            [['created_by', 'updated_by', 'aktif'], 'default', 'value' => null],
            [['created_by', 'updated_by', 'aktif'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['kode', 'kiriman_kode'], 'string', 'max' => 10],
            [['nama'], 'string', 'max' => 255],
            [['kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kode' => 'Kode',
            'kiriman_kode' => 'Kiriman Kode',
            'nama' => 'Nama',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'aktif' => 'Aktif',
        ];
    }
    public function getKiriman()
    {
        return $this->hasOne(Kiriman::className(), ['kode' => 'kiriman_kode']);
    }
}
