<?php

namespace app\models\sso;

use Yii;

/**
 * This is the model class for table "akses_unit".
 *
 * @property int $id
 * @property int $unit_id
 * @property int $pengguna_id
 * @property string|null $id_aplikasi
 * @property string $tanggal_aktif
 * @property string|null $tanggal_nonaktif
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class AksesUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sso.akses_unit';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_sso');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_id', 'pengguna_id', 'tanggal_aktif', 'created_by'], 'required'],
            [['unit_id', 'pengguna_id', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['unit_id', 'pengguna_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['id_aplikasi'], 'string'],
            [['tanggal_aktif', 'tanggal_nonaktif', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_id' => 'Unit ID',
            'pengguna_id' => 'Pengguna ID',
            'id_aplikasi' => 'Id Aplikasi',
            'tanggal_aktif' => 'Tanggal Aktif',
            'tanggal_nonaktif' => 'Tanggal Nonaktif',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
        ];
    }

    public static function getUserAksesUnit($uid)
    {
        $query = self::find()->alias('a')
            ->select(['a.unit_id', 'u.nama', 'is_lab_pa', 'is_lab_pk', 'is_radiologi'])
            ->leftJoin('pegawai.dm_unit_penempatan u', 'u.kode=a.unit_id')
            ->andWhere(['a.pengguna_id' => $uid]);
        // ->andWhere([
        //     'or',
        //     ['is_lab_pa' => 1],
        //     ['is_lab_pk' => 1],
        //     ['is_radiologi' => 1]
        // ]);

        return $query->asArray()->all();
    }

    public static function cekAkses($id, $data)
    {
        foreach ($data as $d) {
            if ($id == $d['unit_id']) {
                return true;
            }
        }
        return false;
    }
}
