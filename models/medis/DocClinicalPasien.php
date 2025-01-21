<?php

namespace app\models\medis;

use app\models\pendaftaran\Pasien;
use Yii;

/**
 * This is the model class for table "doc_clinical_pasien".
 *
 * @property int $id_doc_clinical_pasien
 * @property int $manual
 * @property string $ps_kode
 * @property string $ps_nama
 * @property string $ps_tempat_lahir
 * @property string $ps_tgl_lahir
 * @property string $ps_gender
 * @property string $ps_umur
 * @property string $reg_kode
 * @property string $reg_tgl
 * @property int|null $pl_id
 * @property string|null $pl_tgl
 * @property int|null $unt_id
 * @property string|null $unt_nama
 * @property int $doc_clinical_id
 * @property string $doc_clinical_nama
 * @property string $data
 * @property int $batal
 * @property string|null $tgl_batal
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class DocClinicalPasien extends \yii\db\ActiveRecord
{

    const data_type_html='H';
    const data_type_html_base64='B';
    const data_type_link_pdf='LP';
    const data_type_link_gambar='LG';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.doc_clinical_pasien';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_medis');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['manual', 'pl_id', 'unt_id', 'doc_clinical_id', 'batal', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['manual', 'pl_id', 'unt_id', 'doc_clinical_id', 'batal', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['ps_kode', 'ps_nama', 'ps_tempat_lahir', 'ps_tgl_lahir', 'ps_gender', 'ps_umur', 'reg_kode', 'reg_tgl', 'doc_clinical_id', 'doc_clinical_nama', 'data', 'created_at', 'created_by'], 'required'],
            [['ps_tgl_lahir', 'reg_tgl', 'pl_tgl', 'tgl_batal', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['data'], 'string'],
            [['ps_kode', 'ps_umur', 'reg_kode'], 'string', 'max' => 50],
            [['ps_nama', 'ps_tempat_lahir', 'unt_nama'], 'string', 'max' => 255],
            [['ps_gender'], 'string', 'max' => 20],
            [['doc_clinical_nama'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_doc_clinical_pasien' => 'Id Doc Clinical Pasien',
            'manual' => 'Manual',
            'ps_kode' => 'Ps Kode',
            'ps_nama' => 'Ps Nama',
            'ps_tempat_lahir' => 'Ps Tempat Lahir',
            'ps_tgl_lahir' => 'Ps Tgl Lahir',
            'ps_gender' => 'Ps Gender',
            'ps_umur' => 'Ps Umur',
            'reg_kode' => 'Reg Kode',
            'reg_tgl' => 'Reg Tgl',
            'pl_id' => 'Pl ID',
            'pl_tgl' => 'Pl Tgl',
            'unt_id' => 'Unt ID',
            'unt_nama' => 'Unt Nama',
            'doc_clinical_id' => 'Doc Clinical ID',
            'doc_clinical_nama' => 'Doc Clinical Nama',
            'data' => 'Data',
            'batal' => 'Batal',
            'tgl_batal' => 'Tgl Batal',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
        ];
    }

    public function getPasien()
    {
        return $this->hasOne(Pasien::className(), ['kode' => 'ps_kode']);
    }
    function getItemDocClinical()
    {
        return $this->hasOne(ItemDocClinical::className(),['id_doc_clinical'=>'doc_clinical_id']);
    }
}
