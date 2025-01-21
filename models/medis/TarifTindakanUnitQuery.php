<?php

namespace app\models\medis;
use app\models\pendaftaran\KelasRawat;
use yii\helpers\ArrayHelper;
use app\models\pegawai\DmUnitPenempatan;
use app\components\HelperSpesialClass;
/**
 * This is the ActiveQuery class for [[TarifTindakanUnit]].
 *
 * @see TarifTindakanUnit
 */
class TarifTindakanUnitQuery extends \yii\db\ActiveQuery
{
    // public function init()
    // {
    //     $this->andOnCondition([TarifTindakanUnit::tableName().'.is_deleted'=>0]);
    //     parent::init();
    // }
    public function active()
    {
        return $this->andWhere([TarifTindakanUnit::tableName().'.aktif'=>1]);
    }
    /**
     * {@inheritdoc}
     * @return TarifTindakanUnit[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TarifTindakanUnit|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    public function getListTarifTindakanUnit($original=true,$search=null,$unit_id=null,$kelas_rawat=null){
        $q=$this->innerjoinWith([
            'tarifTindakan'=>function($q){
                $q->innerjoinWith([
                    'tindakan'=>function($q){
                        $q->active();
                    },
                    'skTarif'=>function($q){
                        $q->active();
                    },
                    'kelasRawat'=>function($q){
                        $q->active();
                    },
                ]);
            },
            'unit'
            ]);
        if($search) $q->andWhere(['like',Tindakan::tableName().'.deskripsi',$search]);
        if($kelas_rawat) $q->andWhere([KelasRawat::tableName().'.kode'=>$kelas_rawat]);    
        if($unit_id) $q->andWhere([TarifTindakanUnit::tableName().'.unit_id'=>$unit_id]);    

        $q->select([
            TarifTindakanUnit::tableName().'.tarif_tindakan_id as id',
            TarifTindakanUnit::tableName().'.tarif_tindakan_id',
            Tindakan::tableName().'.id as tindakan_id',
            Tindakan::tableName().'.deskripsi as tindakan_nama',
            SkTarif::tableName().'.id as sk_tarif_id',
            KelasRawat::tableName().'.kode as kelas_rawat_kode',
            KelasRawat::tableName().'.nama as kelas_rawat_nama',
            DmUnitPenempatan::tableName().'.kode as unit_id',
            DmUnitPenempatan::tableName().'.nama as unit_nama'
        ]);
        if($original){
            return $q->asArray()->all();
        }else{
            $items = ArrayHelper::getColumn($q->asArray()->all(),function ($data) {
                $biaya=HelperSpesialClass::getHitungBiayaTindakan($data['tarifTindakan'],false);
                $text=$data['tindakan_nama'].' [KODE : '.$data['tindakan_id'].' | '.$data['kelas_rawat_nama'].' | Standar:Rp. '.number_format($biaya['standar']).']';
                if($biaya['cyto'] > 0){
                    $text=$data['tindakan_nama'].' [KODE : '.$data['tindakan_id'].' | '.$data['kelas_rawat_nama'].' | Standar:Rp. '.number_format($biaya['standar']).' / Cyto:Rp. '.number_format($biaya['cyto']).']';
                }
                return [
                    'id' => $data['id'],
                    'text' => $text
                ];
            });
            return ArrayHelper::map($items, 'id', 'text');
        }
        // Array
        //     (
        //         [0] => Array
        //             (
        //                 [tarif_tindakan_id] => 1
        //                 [tindakan_id] => 2219
        //                 [tindakan_nama] => Buka jahitan
        //                 [sk_tarif_id] => 1
        //                 [kelas_rawat_kode] => 001
        //                 [nama] => KELAS I
        //                 [unit_id] => 145
        //                 [unit_nama] => POLI ANAK
        //                 [tarifTindakan] => Array
        //                     (
        //                         [id] => 1
        //                         [tindakan_id] => 2219
        //                         [kelas_rawat_kode] => 001
        //                         [sk_tarif_id] => 1
        //                         [js_adm] => 0.00
        //                         [js_sarana] => 0.00
        //                         [js_bhp] => 30000.00
        //                         [js_dokter_operator] => 0.00
        //                         [js_dokter_lainya] => 0.00
        //                         [js_dokter_anastesi] => 0.00
        //                         [js_penata_anastesi] => 0.00
        //                         [js_paramedis] => 0.00
        //                         [js_lainya] => 0.00
        //                         [js_adm_cto] => 0.00
        //                         [js_sarana_cto] => 0.00
        //                         [js_bhp_cto] => 0.00
        //                         [js_dokter_operator_cto] => 0.00
        //                         [js_dokter_lainya_cto] => 0.00
        //                         [js_dokter_anastesi_cto] => 0.00
        //                         [js_penata_anastesi_cto] => 0.00
        //                         [js_paramedis_cto] => 0.00
        //                         [js_lainya_cto] => 0.00
        //                         [created_at] => 2021-01-06 14:32:27.16911
        //                         [created_by] => 1
        //                         [updated_at] => 
        //                         [updated_by] => 
        //                         [is_deleted] => 0
        //                         [tindakan] => Array
        //                             (
        //                                 [id] => 2219
        //                                 [parent_id] => 2208
        //                                 [deskripsi] => Buka jahitan
        //                                 [aktif] => 1
        //                                 [kode_jenis] => 
        //                                 [created_at] => 2020-12-31 10:19:48.641417
        //                                 [created_by] => 1
        //                                 [updated_at] => 
        //                                 [updated_by] => 
        //                                 [is_deleted] => 0
        //                             )
        //                         [skTarif] => Array
        //                             (
        //                                 [id] => 1
        //                                 [nomor] => PERATURAN GUBERNUR RIAU NOMOR 2 TAHUN 2019
        //                                 [tanggal] => 2019-01-02
        //                                 [keterangan] => TARIF PELAYANAN PADA BADAN LAYANAN UMUM DAERAH RUMAH SAKIT DI LINGKUNGAN PEMERINTAH PROVINSI RIAU
        //                                 [aktif] => 1
        //                                 [created_at] => 2021-01-05 09:20:14.546618
        //                                 [created_by] => 1
        //                                 [updated_at] => 
        //                                 [updated_by] => 
        //                                 [is_deleted] => 
        //                             )
        //                         [kelasRawat] => Array
        //                             (
        //                                 [kode] => 001
        //                                 [nama] => KELAS I
        //                                 [aktif] => 1
        //                                 [created_by] => 1
        //                                 [created_at] => 2020-12-21 13:13:54.034695
        //                                 [updated_by] => 1
        //                                 [updated_at] => 2020-12-21 07:14:29
        //                                 [is_deleted] => 
        //                             )
        //                     )
        //                 [unit] => Array
        //                     (
        //                         [kode] => 145
        //                         [nama] => POLI ANAK
        //                         [unit_rumpun] => 46
        //                         [kode_unitsub_maping_simrs] => 
        //                         [aktif] => 1
        //                         [created_at] => 
        //                         [created_by] => 
        //                         [updated_at] => 
        //                         [updated_by] => 
        //                         [is_deleted] => 
        //                     )
        //             )
        //     )
    }
}
