<?php

namespace app\models\pengolahandata;

use app\components\HelperSpesialClass;
use app\models\pegawai\TbPegawai;
use Yii;

/**
 * This is the model class for table "peminjaman_rekam_medis".
 *
 * @property int $id
 * @property int $pegawai_id
 * @property string $token
 * @property int $pegawai_rekam_medik_id
 * @property string $tanggal_start
 * @property string $tanggal_expire
 
 * @property string|null $alasan_peminjaman
 * @property string|null $keterangan
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class PeminjamanRekamMedis extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pengolahan_data.peminjaman_rekam_medis';
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
            [['tanggal_start', 'is_internal', 'tanggal_expire', 'alasan_peminjaman'], 'required'],
            [['pegawai_id', 'pegawai_rekam_medik_id', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['pegawai_id', 'is_internal', 'pegawai_rekam_medik_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['tanggal_start', 'tanggal_expire', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['alasan_peminjaman', 'keterangan'], 'string'],
            [['token'], 'string', 'max' => 255],
            [['token'], 'unique'],
            [['file_upload'], 'required', 'when' => function ($model) {
                return $model->isNewRecord;
            }, 'whenClient' => "function (attribute, value) {
                return $('#file_upload').val() === '';
            }"],
            [['file_upload'], 'file', 'extensions' => 'pdf, doc, docx', 'maxSize' => 1024 * 1024 * 5], // 5MB limit
            [
                ['pegawai_id'],
                'required',
                'when' => function ($model) {
                    return $model->is_internal == 1;
                },
                'whenClient' => "function (attribute, value) {
                    return $('#i0').prop('checked');
                }"
            ],
            [
                ['keterangan'],
                'required',
                'when' => function ($model) {
                    return $model->is_internal == 0;
                },
                'whenClient' => "function (attribute, value) {
                    return $('#is_internal').val() == '0';
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
            'id' => 'ID',
            'pegawai_id' => 'Pegawai ID',
            'token' => 'Token',
            'pegawai_rekam_medik_id' => 'Pegawai Rekam Medik ID',
            'is_internal' => 'Internal / Eksternal',

            'tanggal_start' => 'Tanggal Start',
            'tanggal_expire' => 'Tanggal Expire',
            'alasan_peminjaman' => 'Alasan Peminjaman',
            'file_upload' => 'File Peminjaman',
            'keterangan' => 'Keterangan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
        ];
    }
    public function init()
    {
        parent::init();
        if ($this->is_internal === null) {
            $this->is_internal = false; // Set default value if needed
        }
    }

    function beforeSave($model)
    {
        $tanggalSekarang = date('Y-m-d H:i:s');


        if ($this->isNewRecord) {
            $this->created_at = date('Y-m-d H:i:s');
            $this->created_by = Yii::$app->user->identity->id;
            $this->pegawai_rekam_medik_id = HelperSpesialClass::getUserLogin()['pegawai_id'];
            $this->token = $this->generateUniqueToken();
        } else {
            $this->updated_at = date('Y-m-d H:i:s');
            $this->updated_by = Yii::$app->user->identity->id;
            $this->pegawai_rekam_medik_id = HelperSpesialClass::getUserLogin()['pegawai_id'];
        }
        return parent::beforeSave($model);
    }

    public function generateUniqueToken($length = 10)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $uniqueString = '';

        do {
            $uniqueString = '';
            while (strlen($uniqueString) < $length) {
                $randomChar = $characters[rand(0, $charactersLength - 1)];
                if (strpos($uniqueString, $randomChar) === false) {
                    $uniqueString .= $randomChar;
                }
            }

            // Check for uniqueness in the database
            $isUnique = !self::find()->where(['token' => $uniqueString])->exists();
        } while (!$isUnique);

        return $uniqueString;
    }

    function getDetailPeminjaman()
    {
        return $this->hasMany(DetailPeminjamanRekamMedis::className(), ['peminjaman_rekam_medis_id' => 'id']);
    }

    public function getPegawaiPinjam()
    {
        return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'pegawai_id']);
    }
    public function getPegawaiRekamMedis()
    {
        return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'pegawai_rekam_medik_id']);
    }
}
