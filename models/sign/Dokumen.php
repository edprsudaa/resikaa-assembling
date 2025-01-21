<?php

namespace app\models\sign;

use Yii;

/**
 * This is the model class for table "dokumen".
 *
 * @property int $id_dokumen
 * @property string $nama
 * @property string|null $deskripsi
 * @property int $sign
 * @property int $external_dokumen
 * @property int $show_dokumen
 * @property int $is_active
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @property int|null $urutan
 * @property string|null $query_search_riwayat_by_norm
 * @property string|null $query_search_riwayat_by_noreg

 */
class Dokumen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sign.dokumen';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_sign');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'created_at', 'created_by'], 'required'],
            [['deskripsi', 'query_search_riwayat_by_norm', 'query_search_riwayat_by_noreg'], 'string'],
            [['sign', 'external_dokumen', 'show_dokumen', 'is_active', 'created_by', 'updated_by', 'deleted_by', 'urutan'], 'default', 'value' => null],
            [['sign', 'external_dokumen', 'show_dokumen', 'is_active', 'created_by', 'updated_by', 'deleted_by', 'urutan'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['nama'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_dokumen' => 'Id Dokumen',
            'nama' => 'Nama',
            'deskripsi' => 'Deskripsi',
            'sign' => 'Sign',
            'external_dokumen' => 'External Dokumen',
            'show_dokumen' => 'Show Dokumen',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
            'urutan' => 'Urutan',
            'query_search_riwayat_by_norm' => 'Query Search Riwayat By Norm',
            'query_search_riwayat_by_noreg' => 'Query Search Riwayat By Noreg',
        ];
    }

    function getDokumenDetail()
    {
        return $this->hasMany(DokumenDetail::className(), ['id_dokumen' => 'id_dokumen']);
    }

    public static function getListDokumen($q = null)
    {
        $sql = "
        select
        id_dokumen as id ,CONCAT('(',nama,') ',deskripsi) as text,nama,deskripsi
        FROM " . self::tableName() . " where LOWER(nama) LIKE '%" . strtolower($q) . "%' OR LOWER(deskripsi) LIKE '%" . strtolower($q) . "%'
        ";
        return \Yii::$app->db->createCommand($sql)->queryAll();
    }
}
