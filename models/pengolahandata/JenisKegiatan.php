<?php

namespace app\models\pengolahandata;

use Yii;

/**
 * This is the model class for table "master_jenis_kegiatan".
 *
 * @property int $jenis_kegiatan_id
 * @property int|null $jenis_kegiatan_parent_id
 * @property string $jenis_kegiatan_uraian
 * @property int|null $jenis_kegiatan_aktif
 * @property string|null $jenis_kegiatan_created_at
 * @property int $jenis_kegiatan_created_by
 * @property string|null $jenis_kegiatan_updated_at
 * @property int|null $jenis_kegiatan_updated_by
 * @property string|null $jenis_kegiatan_deleted_at
 * @property int|null $jenis_kegiatan_deleted_by
 */
class JenisKegiatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pengolahan_data.master_jenis_kegiatan';
    }
    public static function getDb()
    {
        return \Yii::$app->db_pengolahan_data;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_kegiatan_parent_id', 'jenis_kegiatan_aktif', 'jenis_kegiatan_created_by', 'jenis_kegiatan_updated_by', 'jenis_kegiatan_deleted_by'], 'default', 'value' => null],
            [['jenis_kegiatan_parent_id', 'jenis_kegiatan_aktif', 'jenis_kegiatan_created_by', 'jenis_kegiatan_updated_by', 'jenis_kegiatan_deleted_by'], 'integer'],
            [['jenis_kegiatan_uraian'], 'required'],
            [['jenis_kegiatan_uraian'], 'string'],
            [['jenis_kegiatan_created_at', 'jenis_kegiatan_updated_at', 'jenis_kegiatan_deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'jenis_kegiatan_id' => 'jenis_kegiatan ID',
            'jenis_kegiatan_parent_id' => 'Jenis Kegiatan Parent ID',
            'jenis_kegiatan_jenis' => 'Jenis Kegiatan Jenis',
            'jenis_kegiatan_uraian' => 'Jenis Kegiatan Uraian',
            'jenis_kegiatan_aktif' => 'Jenis Kegiatan Aktif',
            'jenis_kegiatan_created_at' => 'Jenis Kegiatan Created At',
            'jenis_kegiatan_created_by' => 'Jenis Kegiatan Created By',
            'jenis_kegiatan_updated_at' => 'Jenis Kegiatan Updated At',
            'jenis_kegiatan_updated_by' => 'Jenis Kegiatan Updated By',
            'jenis_kegiatan_deleted_at' => 'Jenis Kegiatan Deleted At',
            'jenis_kegiatan_deleted_by' => 'Jenis Kegiatan Deleted By',
        ];
    }
    function beforeSave($model)
    {
        if ($this->isNewRecord) {
            $this->jenis_kegiatan_created_by = Yii::$app->user->identity->id;
            $this->jenis_kegiatan_created_at = date('Y-m-d H:i:s');
           
        } else {
            $this->jenis_kegiatan_updated_by = Yii::$app->user->identity->id;
            $this->jenis_kegiatan_updated_at = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($model);
    }

    static function getJenisKegiatan()
    {
        $data = \Yii::$app->db->createCommand("
        WITH RECURSIVE rec_jenis_kegiatan AS (
            SELECT a.jenis_kegiatan_id, a.jenis_kegiatan_parent_id, a.jenis_kegiatan_uraian,a.jenis_kegiatan_uraian AS rumpun
            FROM ".JenisKegiatan::tableName()." as a
            WHERE a.jenis_kegiatan_parent_id = 0
         UNION ALL
            SELECT b.jenis_kegiatan_id, b.jenis_kegiatan_parent_id, b.jenis_kegiatan_uraian, CONCAT(rec_jenis_kegiatan.rumpun, ' >> ', b.jenis_kegiatan_uraian)
            FROM ".JenisKegiatan::tableName()." as b
               JOIN rec_jenis_kegiatan ON b.jenis_kegiatan_parent_id = rec_jenis_kegiatan.jenis_kegiatan_id
      )
      SELECT * FROM rec_jenis_kegiatan ORDER BY jenis_kegiatan_id ASC")->queryAll();

      return $data;
    }


    static function getJenisKegiatanInduk()
    {
        $data = \Yii::$app->db->createCommand("
        WITH RECURSIVE rec_kodefikasi AS (
            SELECT a.jenis_kegiatan_id, a.jenis_kegiatan_parent_id, a.jenis_kegiatan_uraian,
                   a.jenis_kegiatan_uraian AS rumpun
            FROM ".JenisKegiatan::tableName()." as a
            WHERE a.jenis_kegiatan_parent_id = 0
         UNION ALL
            SELECT b.jenis_kegiatan_id, b.jenis_kegiatan_parent_id, b.jenis_kegiatan_uraian, CONCAT(rec_kodefikasi.rumpun, ' >> ', b.jenis_kegiatan_uraian)
            FROM ".JenisKegiatan::tableName()." as b
               JOIN rec_kodefikasi ON b.jenis_kegiatan_parent_id = rec_kodefikasi.jenis_kegiatan_id
      )
      SELECT * FROM rec_kodefikasi WHERE jenis_kegiatan_id IN(select c.jenis_kegiatan_parent_id FROM ".JenisKegiatan::tableName()." as c where c.jenis_kegiatan_parent_id <> 0 group by c.jenis_kegiatan_parent_id) ORDER BY jenis_kegiatan_id ASC")->queryAll();

      return $data;
    }

    static function getJenisKegiatanAnak()
    {
        $data = \Yii::$app->db->createCommand("
        WITH RECURSIVE rec_jenis_kegiatan AS (
            SELECT a.jenis_kegiatan_id, a.jenis_kegiatan_parent_id, a.jenis_kegiatan_uraian,
                   a.jenis_kegiatan_uraian AS rumpun
            FROM ".JenisKegiatan::tableName()." as a
            WHERE a.jenis_kegiatan_parent_id = 0
         UNION ALL
            SELECT b.jenis_kegiatan_id, b.jenis_kegiatan_parent_id, b.jenis_kegiatan_uraian, CONCAT(rec_jenis_kegiatan.rumpun, ' >> ', b.jenis_kegiatan_uraian)
            FROM ".JenisKegiatan::tableName()." as b
               JOIN rec_jenis_kegiatan ON b.jenis_kegiatan_parent_id = rec_jenis_kegiatan.jenis_kegiatan_id
      )
      SELECT * FROM rec_jenis_kegiatan WHERE jenis_kegiatan_id NOT IN(select c.jenis_kegiatan_parent_id FROM ".JenisKegiatan::tableName()." as c where c.jenis_kegiatan_parent_id <> 0 group by c.jenis_kegiatan_parent_id) AND jenis_kegiatan_parent_id <> 0 ORDER BY jenis_kegiatan_id ASC")->queryAll();

      return $data;
    }

    public static function find()
    {
        return new JenisKegiatanQuery(get_called_class());
    }
}
