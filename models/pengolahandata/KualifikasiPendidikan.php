<?php

namespace app\models\pengolahandata;

use Yii;

/**
 * This is the model class for table "aset_m_kodefikasi".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $jenis
 * @property string $kodefikasi
 * @property string|null $uraian
 * @property string|null $dasar
 * @property int|null $aktif
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class KualifikasiPendidikan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pengolahan_data.master_kualifikasi_pendidikan';
    }
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
            [['id', 'uraian', 'created_by'], 'required'],
            [['id', 'parent_id', 'aktif', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['id', 'parent_id', 'aktif', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['uraian'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'uraian' => 'Uraian',
            'aktif' => 'Aktif',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
        ];
    }

    static function getKualifikasiPendidikan()
    {
        $data = \Yii::$app->db->createCommand("
        WITH RECURSIVE rec_kualifikasi_pendidikan AS (
            SELECT a.id, a.parent_id, a.uraian,
                   a.uraian AS rumpun
            FROM ".KualifikasiPendidikan::tableName()." as a
            WHERE a.parent_id = 0
         UNION ALL
            SELECT b.id, b.parent_id, b.uraian, CONCAT(rec_kualifikasi_pendidikan.rumpun, ' >> ', b.uraian)
            FROM ".KualifikasiPendidikan::tableName()." as b
               JOIN rec_kualifikasi_pendidikan ON b.parent_id = rec_kualifikasi_pendidikan.id
      )
      SELECT * FROM rec_kualifikasi_pendidikan ORDER BY id ASC")->queryAll();

      return $data;
    }

    static function getKualifikasiPendidikanInduk()
    {
        $data = \Yii::$app->db->createCommand("
        WITH RECURSIVE rec_kualifikasi_pendidikan AS (
            SELECT a.id, a.parent_id, a.uraian,
                   a.uraian AS rumpun
            FROM ".KualifikasiPendidikan::tableName()." as a
            WHERE a.parent_id = 0
         UNION ALL
            SELECT b.id, b.parent_id, b.uraian, CONCAT(rec_kualifikasi_pendidikan.rumpun, ' >> ', b.uraian)
            FROM ".KualifikasiPendidikan::tableName()." as b
               JOIN rec_kualifikasi_pendidikan ON b.parent_id = rec_kualifikasi_pendidikan.id
      )
      SELECT * FROM rec_kualifikasi_pendidikan WHERE id IN(select c.parent_id FROM ".KualifikasiPendidikan::tableName()." as c where c.parent_id <> 0 group by c.parent_id) ORDER BY id ASC")->queryAll();

      return $data;
    }

    static function getKualifikasiPendidikanAnak()
    {
        $data = \Yii::$app->db->createCommand("
        WITH RECURSIVE rec_kualifikasi_pendidikan AS (
            SELECT a.id, a.parent_id, a.uraian,
                   a.uraian AS rumpun
            FROM ".KualifikasiPendidikan::tableName()." as a
            WHERE a.parent_id = 0
         UNION ALL
            SELECT b.id, b.parent_id, b.uraian, CONCAT(rec_kualifikasi_pendidikan.rumpun, ' >> ', b.uraian)
            FROM ".KualifikasiPendidikan::tableName()." as b
               JOIN rec_kualifikasi_pendidikan ON b.parent_id = rec_kualifikasi_pendidikan.id
      )
      SELECT * FROM rec_kualifikasi_pendidikan WHERE id NOT IN(select c.parent_id FROM ".KualifikasiPendidikan::tableName()." as c where c.parent_id <> 0 group by c.parent_id) AND parent_id <> 0 ORDER BY id ASC")->queryAll();

      return $data;
    }

    public static function find()
    {
        return new KualifikasiPendidikanQuery(get_called_class());
    }
}
