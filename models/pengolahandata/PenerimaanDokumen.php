<?php

namespace app\models\pengolahandata;

use Yii;

/**
 * This is the model class for table "penerimaan_dokumen".
 *
 * @property int $penerimaan_dokumen_id
 * @property string $ps_kode
 * @property string $reg_kode
 * @property string|null $tgl_penerimaan
 * @property string|null $tgl_masuk
 * @property string|null $tgl_keluar
 * @property string|null $tgl_checkout
 * @property string|null $id_debitur
 * @property int|null $status
 * @property bool|null $is_status_dokumen
 * @property bool|null $is_batal
 * @property bool|null $is_berkas_klaim
 * @property string $created_by
 * @property string $created_at
 * @property string|null $updated_by
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class PenerimaanDokumen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penerimaan_dokumen';
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
            [['ps_kode', 'reg_kode', 'created_by', 'created_at'], 'required'],
            [['tgl_penerimaan', 'tgl_masuk', 'tgl_keluar', 'tgl_checkout', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['status', 'deleted_by'], 'default', 'value' => null],
            [['status', 'deleted_by'], 'integer'],
            [['is_status_dokumen', 'is_batal', 'is_berkas_klaim'], 'boolean'],
            [['ps_kode', 'reg_kode', 'id_debitur', 'created_by', 'updated_by'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'penerimaan_dokumen_id' => 'Penerimaan Dokumen ID',
            'ps_kode' => 'Ps Kode',
            'reg_kode' => 'Reg Kode',
            'tgl_penerimaan' => 'Tgl Penerimaan',
            'tgl_masuk' => 'Tgl Masuk',
            'tgl_keluar' => 'Tgl Keluar',
            'tgl_checkout' => 'Tgl Checkout',
            'id_debitur' => 'Id Debitur',
            'status' => 'Status',
            'is_status_dokumen' => 'Is Status Dokumen',
            'is_batal' => 'Is Batal',
            'is_berkas_klaim' => 'Is Berkas Klaim',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
        ];
    }

    function beforeSave($model)
    {
        if ($this->isNewRecord) {
            $this->created_by = Yii::$app->user->identity->id;
            $this->created_at = date('Y-m-d H:i:s');
            $this->tgl_penerimaan = date('Y-m-d H:i:s');
           
        } else {
            $this->updated_by = Yii::$app->user->identity->id;
            $this->updated_at = date('Y-m-d H:i:s');
            $this->tgl_penerimaan = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($model);
    }
}
