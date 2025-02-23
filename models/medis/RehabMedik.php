<?php

namespace app\models\medis;

use Yii;
use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;
use app\models\medis\RehabMedikDetail;

class RehabMedik extends BaseModelAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.asesmen_rehab_medik';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['layanan_id', 'perawat_id'], 'required'],
            [['layanan_id', 'perawat_id', 'perawat_final', 'perawat_batal', 'batal', 'draf', 'created_by', 'updated_by', 'is_deleted','id_dokumen_rme','parent_id'], 'default', 'value' => null],
            [['layanan_id', 'perawat_id', 'perawat_final', 'perawat_batal','batal', 'draf', 'created_by', 'updated_by', 'is_deleted','id_dokumen_rme'], 'integer'],
            [['tanggal_batal', 'tanggal_final', 'created_at', 'updated_at'], 'safe'],
            [['log_data', 'anamnesa', 'pemeriksaan_fisik', 'pemeriksaan_penunjang', 'diagnosis', 'asesmen_ke', 'frekuensi_layanan', 'program','versi'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'layanan_id' => 'Layanan ID',
            'perawat_id' => 'Perawat ID',
            'batal' => 'Batal',
            'tanggal_batal' => 'Tanggal Batal',
            'draf' => 'Draf',
            'tanggal_final' => 'Tanggal Final',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'log_data' => 'Log Data',
            'is_deleted' => 'Is Deleted',
            'anamnesa' => 'Anamnesa',
            'pemeriksaan_fisik' => 'Pemeriksaan Fisik',
            'pemeriksaan_penunjang' => 'Pemeriksaan Hasil Penunjang',
            'dx_medis' => 'Diagnosis',
            'riw_alergi_obat' => 'Asesment Ke',
            'frekuensi_layanan' => 'Frekuensi Layanan',
            'program' => 'Program',
            'parent_id' => 'Parent ID',
            
        ];
    }

    public function beforeSave($insert) {
        
        // if (parent::beforeSave($insert)) {
        //     if (is_array($this->diagnosa_keperawatan)) {
        //         $this->diagnosa_keperawatan = implode(',', $this->diagnosa_keperawatan);
        //     }
        //     if (is_array($this->intervensi_keperawatan)) {
        //         $this->intervensi_keperawatan = implode(',', $this->intervensi_keperawatan);
        //     }
        //     return true;
        // } else {
        //     return false;
        // }

        
        if ($insert) {
            $this->batal = 0;
            $this->draf = 1;
            $this->is_deleted = 0;
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function afterFind()
    {
        // parent::afterFind();
        // if (is_string($this->diagnosa_keperawatan)) {
        //     $this->diagnosa_keperawatan = explode(',', $this->diagnosa_keperawatan);
        // }
        // if (is_string($this->intervensi_keperawatan)) {
        //     $this->intervensi_keperawatan = explode(',', $this->intervensi_keperawatan);
        // }
        // $this->tanggal_pengkajian =  Yii::$app->formatter->asDate($this->tanggal_pengkajian, 'dd-MM-yyyy');
    }

    public static function find()
    {
        return new RehabMedikQuery(get_called_class());
    }
    public function getPerawat()
    {
        return $this->hasOne(TbPegawai::className(),['pegawai_id'=>'perawat_id']);
    }
    public function getPerawatFinal()
    {
        return $this->hasOne(TbPegawai::className(),['pegawai_id'=>'perawat_final']);
    }

    public function getLayanan()
    {
        return $this->hasOne(Layanan::className(),['id'=>'layanan_id']);
    }

    public function getRehabMedikDetail()
    {
        return $this->hasMany(RehabMedikDetail::className(),['rehab_medik_id'=>'id']);
    }

    
    

}




