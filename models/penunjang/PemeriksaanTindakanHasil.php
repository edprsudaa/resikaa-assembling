<?php

namespace app\models\penunjang;

use Yii;

/**
 * This is the model class for table "pemeriksaan_tindakan_hasil".
 *
 * @property int $id
 * @property int $hasil_pemeriksaan_id
 * @property int $pemeriksaan_tindakan_id
 * @property string|null $hasil
 * @property string|null $nama
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 */
class PemeriksaanTindakanHasil extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penunjang_2.pemeriksaan_tindakan_hasil';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_postgre');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hasil_pemeriksaan_id', 'pemeriksaan_tindakan_id'], 'required'],
            [['hasil_pemeriksaan_id', 'pemeriksaan_tindakan_id', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['hasil_pemeriksaan_id', 'pemeriksaan_tindakan_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['hasil', 'nama'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hasil_pemeriksaan_id' => 'Hasil Pemeriksaan ID',
            'pemeriksaan_tindakan_id' => 'Pemeriksaan Tindakan ID',
            'hasil' => 'Hasil',
            'nama' => 'Nama',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'deleted_by' => 'Deleted By',
        ];
    }
}
