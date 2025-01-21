<?php

namespace app\models\pengolahandata;

use app\models\pendaftaran\Pasien;
use Yii;

/**
 * This is the model class for table "detail_peminjaman_rekam_medis".
 *
 * @property int $id
 * @property int $peminjaman_rekam_medis_id
 * @property string $pasien_kode
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class DetailPeminjamanRekamMedis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pengolahan_data.detail_peminjaman_rekam_medis';
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
            [['pasien_kode'], 'required'],
            [['peminjaman_rekam_medis_id', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['peminjaman_rekam_medis_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['pasien_kode'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'peminjaman_rekam_medis_id' => 'Peminjaman Rekam Medis ID',
            'pasien_kode' => 'Pasien Kode',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
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

    function getPeminjaman()
    {
        return $this->hasOne(PeminjamanRekamMedis::className(), ['id' => 'peminjaman_rekam_medis_id']);
    }

    public function getPasien()
    {
        return $this->hasOne(Pasien::className(), ['kode' => 'pasien_kode']);
    }
}
