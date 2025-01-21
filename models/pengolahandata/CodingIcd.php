<?php

namespace app\models\pengolahandata;

use Yii;

/**
 * This is the model class for table "coding_icd".
 *
 * @property int $id
 * @property string $registrasi_id
 * @property int|null $diagnosa_utama_id
 * @property string|null $diagnosa_utama_kode
 * @property string|null $diagnosa_utama_deskripsi
 * @property int|null $diagnosa_tambahan1_id
 * @property string|null $diagnosa_tambahan1_kode
 * @property string|null $diagnosa_tambahan1_deskripsi
 * @property int|null $diagnosa_tambahan2_id
 * @property string|null $diagnosa_tambahan2_kode
 * @property string|null $diagnosa_tambahan2_deskripsi
 * @property int|null $diagnosa_tambahan3_id
 * @property string|null $diagnosa_tambahan3_kode
 * @property string|null $diagnosa_tambahan3_deskripsi
 * @property int|null $diagnosa_tambahan4_id
 * @property string|null $diagnosa_tambahan4_kode
 * @property string|null $diagnosa_tambahan4_deskripsi
 * @property int|null $diagnosa_tambahan5_id
 * @property string|null $diagnosa_tambahan5_kode
 * @property string|null $diagnosa_tambahan5_deskripsi
 * @property int|null $tindakan_utama_id
 * @property string|null $tindakan_utama_kode
 * @property string|null $tindakan_utama_deskripsi
 * @property int|null $tindakan_tambahan1_id
 * @property string|null $tindakan_tambahan1_kode
 * @property string|null $tindakan_tambahan1_deskripsi
 * @property int|null $tindakan_tambahan2_id
 * @property string|null $tindakan_tambahan2_kode
 * @property string|null $tindakan_tambahan2_deskripsi
 * @property int|null $tindakan_tambahan3_id
 * @property string|null $tindakan_tambahan3_kode
 * @property string|null $tindakan_tambahan3_deskripsi
 * @property int|null $tindakan_tambahan4_id
 * @property string|null $tindakan_tambahan4_kode
 * @property string|null $tindakan_tambahan4_deskripsi
 * @property int|null $tindakan_tambahan5_id
 * @property string|null $tindakan_tambahan5_kode
 * @property string|null $tindakan_tambahan5_deskripsi
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class CodingIcd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coding_icd';
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
            [['registrasi_id', 'created_by'], 'required'],
            [['diagnosa_utama_id', 'diagnosa_tambahan1_id', 'diagnosa_tambahan2_id', 'diagnosa_tambahan3_id', 'diagnosa_tambahan4_id', 'diagnosa_tambahan5_id', 'tindakan_utama_id', 'tindakan_tambahan1_id', 'tindakan_tambahan2_id', 'tindakan_tambahan3_id', 'tindakan_tambahan4_id', 'tindakan_tambahan5_id', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['diagnosa_utama_id', 'diagnosa_tambahan1_id', 'diagnosa_tambahan2_id', 'diagnosa_tambahan3_id', 'diagnosa_tambahan4_id', 'diagnosa_tambahan5_id', 'tindakan_utama_id', 'tindakan_tambahan1_id', 'tindakan_tambahan2_id', 'tindakan_tambahan3_id', 'tindakan_tambahan4_id', 'tindakan_tambahan5_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['diagnosa_utama_kode', 'diagnosa_utama_deskripsi', 'diagnosa_tambahan1_kode', 'diagnosa_tambahan1_deskripsi', 'diagnosa_tambahan2_kode', 'diagnosa_tambahan2_deskripsi', 'diagnosa_tambahan3_kode', 'diagnosa_tambahan3_deskripsi', 'diagnosa_tambahan4_kode', 'diagnosa_tambahan4_deskripsi', 'diagnosa_tambahan5_kode', 'diagnosa_tambahan5_deskripsi', 'tindakan_utama_kode', 'tindakan_utama_deskripsi', 'tindakan_tambahan1_kode', 'tindakan_tambahan1_deskripsi', 'tindakan_tambahan2_kode', 'tindakan_tambahan2_deskripsi', 'tindakan_tambahan3_kode', 'tindakan_tambahan3_deskripsi', 'tindakan_tambahan4_kode', 'tindakan_tambahan4_deskripsi', 'tindakan_tambahan5_kode', 'tindakan_tambahan5_deskripsi'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['registrasi_id'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'registrasi_id' => 'Registrasi ID',
            'diagnosa_utama_id' => 'Diagnosa Utama ID',
            'diagnosa_utama_kode' => 'Diagnosa Utama Kode',
            'diagnosa_utama_deskripsi' => 'Diagnosa Utama Deskripsi',
            'diagnosa_tambahan1_id' => 'Diagnosa Tambahan 1 ID',
            'diagnosa_tambahan1_kode' => 'Diagnosa Tambahan 1 Kode',
            'diagnosa_tambahan1_deskripsi' => 'Diagnosa Tambahan 1 Deskripsi',
            'diagnosa_tambahan2_id' => 'Diagnosa Tambahan 2 ID',
            'diagnosa_tambahan2_kode' => 'Diagnosa Tambahan 2 Kode',
            'diagnosa_tambahan2_deskripsi' => 'Diagnosa Tambahan 2 Deskripsi',
            'diagnosa_tambahan3_id' => 'Diagnosa Tambahan 3 ID',
            'diagnosa_tambahan3_kode' => 'Diagnosa Tambahan 3 Kode',
            'diagnosa_tambahan3_deskripsi' => 'Diagnosa Tambahan 3 Deskripsi',
            'diagnosa_tambahan4_id' => 'Diagnosa Tambahan 4 ID',
            'diagnosa_tambahan4_kode' => 'Diagnosa Tambahan 4 Kode',
            'diagnosa_tambahan4_deskripsi' => 'Diagnosa Tambahan 4 Deskripsi',
            'diagnosa_tambahan5_id' => 'Diagnosa Tambahan 5 ID',
            'diagnosa_tambahan5_kode' => 'Diagnosa Tambahan 5 Kode',
            'diagnosa_tambahan5_deskripsi' => 'Diagnosa Tambahan 5 Deskripsi',
            'tindakan_utama_id' => 'Tindakan Utama ID',
            'tindakan_utama_kode' => 'Tindakan Utama Kode',
            'tindakan_utama_deskripsi' => 'Tindakan Utama Deskripsi',
            'tindakan_tambahan1_id' => 'Tindakan Tambahan 1 ID',
            'tindakan_tambahan1_kode' => 'Tindakan Tambahan 1 Kode',
            'tindakan_tambahan1_deskripsi' => 'Tindakan Tambahan 1 Deskripsi',
            'tindakan_tambahan2_id' => 'Tindakan Tambahan 2 ID',
            'tindakan_tambahan2_kode' => 'Tindakan Tambahan 2 Kode',
            'tindakan_tambahan2_deskripsi' => 'Tindakan Tambahan 2 Deskripsi',
            'tindakan_tambahan3_id' => 'Tindakan Tambahan 3 ID',
            'tindakan_tambahan3_kode' => 'Tindakan Tambahan 3 Kode',
            'tindakan_tambahan3_deskripsi' => 'Tindakan Tambahan 3 Deskripsi',
            'tindakan_tambahan4_id' => 'Tindakan Tambahan 4 ID',
            'tindakan_tambahan4_kode' => 'Tindakan Tambahan 4 Kode',
            'tindakan_tambahan4_deskripsi' => 'Tindakan Tambahan 4 Deskripsi',
            'tindakan_tambahan5_id' => 'Tindakan Tambahan 5 ID',
            'tindakan_tambahan5_kode' => 'Tindakan Tambahan 5 Kode',
            'tindakan_tambahan5_deskripsi' => 'Tindakan Tambahan 5 Deskripsi',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
        ];
    }
}
