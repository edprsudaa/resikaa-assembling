<?php
namespace app\components;
use Yii;
use app\models\sdm\Aplikasi;
use app\models\sdm\AksesUnit;
use app\models\sdm\DokterUnit;
use app\models\sdm\Unit;
use app\models\sdm\Pegawai;
use app\models\pendaftaran\Layanan;
use app\models\medis\Pjp;
use app\models\medis\PjpRi;
use app\models\medis\ItemPemeriksaanPenunjang;
use app\models\medis\Cppt;
use yii\helpers\ArrayHelper;
class HelperSpesial
{
    public static function getDataPegawaiByNomor($nomor)
	{
		return Pegawai::find()->where(['pgw_nomor' => $nomor])->notDeleted()->one();
	}
    public static function getDataPegawaiById($id)
	{
		return Pegawai::find()->where(['pgw_id' => $id])->notDeleted()->one();
	}
    public static function getNamaPegawai($pegawai)
    {
        return ($pegawai->pgw_gelar_depan ? $pegawai->pgw_gelar_depan . ' ' : null) . $pegawai->pgw_nama . ($pegawai->pgw_gelar_belakang ? ', ' . $pegawai->pgw_gelar_belakang : null);
    }
    public static function getNamaPegawaiArray($pegawai)
    {
        return ($pegawai['pgw_gelar_depan'] ? $pegawai['pgw_gelar_depan'] . ' ' : null) . $pegawai['pgw_nama'] . ($pegawai['pgw_gelar_belakang'] ? ', ' . $pegawai['pgw_gelar_belakang'] : null);
    }
    public static function getListPegawai($aktif=0,$original=true,$list=false)
    {
        $result=array();
        $query=Pegawai::find();
        if($aktif>0){
            $query->where(['pgw_aktif'=>1]);
        }
        $result=$query->notDeleted()->asArray()->all();
        $list_result=array();
        foreach($result as $v){
            array_push($list_result,['id'=>$v['pgw_id'],'nama'=>self::getNamaPegawaiArray($v)]);
        }
        if($original){
            return $list_result;
        }else{
            if($list){
                return ArrayHelper::map($list_result, 'id', 'nama');
            }else{
                return ArrayHelper::getColumn($list_result, 'id');
            }
        }
    }
	public static function getListDokterUnit($unit=null,$original=true,$list=false)
    {
        $result=array();
        $query=DokterUnit::find()
        ->joinWith([
            'dokter','unit'
        ]);
        if(!empty($unit)){
            $query->where(['dku_unt_id'=>$unit]);
        }
        $result=$query->notDeleted()->asArray()->all();
        // echo'<pre/>';print_r($result);die();
        $list_result=array();
        foreach($result as $v){
            array_push($list_result,['id'=>$v['dku_dokter_id'],'nama'=>self::getNamaPegawaiArray($v['dokter'])]);
        }
        if($original){
            return $list_result;
        }else{
            if($list){
                return ArrayHelper::map($list_result, 'id', 'nama');
            }else{
                return ArrayHelper::getColumn($list_result, 'id');
            }
        }
    }
    public static function getListPjp($layanan,$original=true,$list=false)
    {
        //return pjp_id=>pegawai_nama
        $result=array();
        if($layanan['pl_jenis_layanan']==Layanan::RI){
            //RI
            $query=PjpRi::find()
            ->select([PjpRi::tableName().'.pjpri_id AS id',PjpRi::tableName().'.pjpri_pgw_id',Pegawai::tableName().'.pgw_nomor',Pegawai::tableName().'.pgw_id',new \yii\db\Expression("CONCAT(COALESCE(pgw_gelar_depan,''), ' ',pgw_nama,' ',COALESCE(pgw_gelar_belakang,'')) as nama")])
            ->joinWith([
                'pegawai'
            ])
            ->where([PjpRi::tableName().'.pjpri_deleted_at'=>null]);
            $query->andWhere([PjpRi::tableName().'.pjpri_reg_kode'=>$layanan['pl_reg_kode']]);
            $result=$query->asArray()->all();
        }else{
            //RJ/IGD/PENUNJANG
            $query=Pjp::find()
            ->select([Pjp::tableName().'.pjp_id AS id',Pjp::tableName().'.pjp_pgw_id',Pegawai::tableName().'.pgw_nomor',Pegawai::tableName().'.pgw_id',new \yii\db\Expression("CONCAT(COALESCE(pgw_gelar_depan,''), ' ',pgw_nama,' ',COALESCE(pgw_gelar_belakang,'')) as nama")])
            ->joinWith([
                'pegawai'
            ])
            ->where([Pjp::tableName().'.pjp_deleted_at'=>null]);
            $query->andWhere([Pjp::tableName().'.pjp_pl_id'=>$layanan['pl_id']]);
            $result=$query->asArray()->all();
        }
        if($original){
            return $result;
        }else{
            if($list){
                return ArrayHelper::map($result, 'id', 'nama');
            }else{
                return ArrayHelper::getColumn($result, 'id');
            }
        }
    }
    public static function getListPegawaiPjp($layanan,$original=true,$list=false)
    {
        //return pegawai_id=>pegawai_nama
        $result=array();
        // echo'<pre/>';print_r($layanan);die();
        if($layanan['pl_jenis_layanan']==Layanan::RI){
        // echo'<pre/>';print_r($layanan);die();
            //RI
            $query=PjpRi::find()
            ->select([PjpRi::tableName().'.pjpri_id AS id',PjpRi::tableName().'.pjpri_pgw_id',Pegawai::tableName().'.pgw_nomor',Pegawai::tableName().'.pgw_id',new \yii\db\Expression("CONCAT(COALESCE(pgw_gelar_depan,''), ' ',pgw_nama,' ',COALESCE(pgw_gelar_belakang,'')) as nama")])
            ->joinWith([
                'pegawai'
            ])
            ->where([PjpRi::tableName().'.pjpri_deleted_at'=>null]);
            $query->andWhere([PjpRi::tableName().'.pjpri_reg_kode'=>$layanan['pl_reg_kode']]);
            $result=$query->asArray()->all();
        }else{
            //RJ/IGD/PENUNJANG
            $query=Pjp::find()
            ->select([Pjp::tableName().'.pjp_id AS id',Pjp::tableName().'.pjp_pgw_id',Pegawai::tableName().'.pgw_nomor',Pegawai::tableName().'.pgw_id',new \yii\db\Expression("CONCAT(COALESCE(pgw_gelar_depan,''), ' ',pgw_nama,' ',COALESCE(pgw_gelar_belakang,'')) as nama")])
            ->joinWith([
                'pegawai'
            ])->where([Pjp::tableName().'.pjp_deleted_at'=>null]);
            $query->andWhere([Pjp::tableName().'.pjp_pl_id'=>$layanan['pl_id']]);
            $result=$query->asArray()->all();
            // echo'<pre/>';print_r($result);die();
        }
        if($original){
            return $result;
        }else{
            if($list){
                return ArrayHelper::map($result, 'pgw_id', 'nama');
            }else{
                return ArrayHelper::getColumn($result, 'pgw_id');
            }
        }
    }
    // $model = arname()->find()
    // ->andWhere(['user_id'=>[1,5,8]])
    // ->andWhere(['or',
    //     ['status'=>1],
    //     ['verified'=>1]
    // ])
    // ->orWhere(['and',
    //     ['social_account'=>1],
    //     ['enable_social'=>1]
    // ])
    // ->all();
    public static function getListUnitLayanan($type=null,$original=true,$list=false)
    {
        $unit=array();
        if($type==Layanan::RJ){
            $unit=Unit::find()->select(['unt_id','unt_nama'])->where(['unt_is_rj'=>1])->active()->notDeleted()->orderBy(['unt_nama'=>SORT_ASC])->asArray()->all();
        }else if($type==Layanan::RI){
            $unit=Unit::find()->select(['unt_id','unt_nama'])->where(['unt_is_ri'=>1])->active()->notDeleted()->orderBy(['unt_nama'=>SORT_ASC])->asArray()->all();
        }else if($type==Layanan::IGD){
            $unit=Unit::find()->select(['unt_id','unt_nama'])->where(['unt_is_igd'=>1])->active()->notDeleted()->orderBy(['unt_nama'=>SORT_ASC])->asArray()->all();
        }else if($type==Layanan::PENUNJANG){
            $unit=Unit::find()->select(['unt_id','unt_nama'])->where(['unt_is_pnjg'=>1])->active()->notDeleted()->orderBy(['unt_nama'=>SORT_ASC])->asArray()->all();
        }else{
            $unit=Unit::find()->select(['unt_id','unt_nama'])->where(['or',['unt_is_rj'=>1],['unt_is_ri'=>1],['unt_is_igd'=>1],['unt_is_pnjg'=>1]])->active()->notDeleted()->orderBy(['unt_nama'=>SORT_ASC])->asArray()->all();
        }
        if($original){
            return $unit;
        }else{
            if($list){
                return ArrayHelper::map($unit, 'unt_id', 'unt_nama');
            }else{
                return ArrayHelper::getColumn($unit, 'unt_id');
            }
        }
    }
    public static function getListUnitPenunjangOrder($type=null,$original=true,$list=false)
    {
        $unit=ItemPemeriksaanPenunjang::find()->innerjoinWith(['unit'])->select([Unit::tableName().'.unt_id',Unit::tableName().'.unt_nama','ipp_unt_id'])->distinct()->where([Unit::tableName().'.unt_is_pnjg'=>1])->active()->notDeleted()->orderBy([Unit::tableName().'.unt_nama'=>SORT_ASC])->asArray()->all();
        if($original){
            return $unit;
        }else{
            if($list){
                return ArrayHelper::map($unit, 'unt_id', 'unt_nama');
            }else{
                return ArrayHelper::getColumn($unit, 'unt_id');
            }
        }
    }
    public static function getListUnitDepo($original=true,$list=false)
    {
        $unit=array();
        $unit=Unit::find()->select(['unt_id','unt_nama'])->where(['unt_is_depo'=>1])->active()->notDeleted()->orderBy(['unt_nama'=>SORT_ASC])->asArray()->all();
        if($original){
            return $unit;
        }else{
            if($list){
                return ArrayHelper::map($unit, 'unt_id', 'unt_nama');
            }else{
                return ArrayHelper::getColumn($unit, 'unt_id');
            }
        }
    }
    public static function getListUnitOK($original=true,$list=false)
    {
        $unit=array();
        $unit=Unit::find()->select(['unt_id','unt_nama'])->where(['unt_is_ok'=>1])->active()->notDeleted()->orderBy(['unt_nama'=>SORT_ASC])->asArray()->all();
        if($original){
            return $unit;
        }else{
            if($list){
                return ArrayHelper::map($unit, 'unt_id', 'unt_nama');
            }else{
                return ArrayHelper::getColumn($unit, 'unt_id');
            }
        }
    }
    public static function getListPpaJenis($original=true,$list=false)
    {
        $ppa_jenis=Cppt::$cppt_ppa_jenis;
        if($original){
            return $ppa_jenis;
        }else{
            if($list){
                $ppa_jenis_map=array();
                foreach($ppa_jenis as $v){
                    $ppa_jenis_map[$v]=$v;
                }
                return $ppa_jenis_map;
            }else{
                return $ppa_jenis;
            }
        }
    }
    public static function getCheckPasien($id){
        // $id => layanan_id
        // $layanan=array();
        if(!is_numeric($id)){
            $id=HelperGeneral::validateData($id);
        }    
        if(!$id){
            return MakeResponse::createNotJson(false, 'Pasien Tidak Valid, Mohon Pilih Lagi');
        }
        $layanan=Layanan::find()->joinWith([
            'unit',
            'registrasi.pasien',
            'registrasi.debiturdetail',
            'registrasi.pjpRi.pegawai',
            'pjp.pegawai',
        ])->where([Layanan::tableName().'.pl_id'=>$id])->asArray()->one();
        if(!$layanan){
            return MakeResponse::createNotJson(false, 'Pasien Tidak Valid, Mohon Pilih Lagi');
        }
        return MakeResponse::createNotJson(true,null,$layanan);
    }
    public static function checkAllowCRUDbyLayanan($pl_id){
        //chek allow create data asuhan-asuhan pasien
        return MakeResponse::createNotJson(true,'oke');
    }
    public static function checkAllowCRUDbyRegistrasi($reg_kode){
        //chek allow create data asuhan-asuhan pasien
        return MakeResponse::createNotJson(true,'oke');
    }
    //FOR PENUNJANG ORDER
    public static function PenunjangKonversiStringKeArray($items){
        $items=str_replace(' ', '', $items);
        if($items){
            //konversi dari string(,) ke array => ex : 12,11 =>[12,11]
            $array_items=explode(",",$items);
            if($array_items){
                return $array_items;
            }
        }
        return array();
    }
    
    public static function RekonItemPemeriksaanPenunjang($array_items){
        $list_items=ItemPemeriksaanPenunjang::getDataQuery();
        if($list_items){
            $list_items2=array();
            foreach($list_items as $val){
                if(in_array(intval($val['ipp_id']),$array_items)){
                    array_push($list_items2,$val);
                }
            }
            return $list_items2;
        }
        return array();
    }
    //END PENUNJANG ORDER
    public static function getHitungBiayaTindakan($data,$object=true){
        if($object){
            return 
            [
                'standar'=>intval($data->tft_js_adm)+intval($data->tft_js_sarana)+intval($data->tft_js_bhp)+intval($data->tft_js_dokter_operator)+intval($data->tft_js_dokter_lainya)+intval($data->tft_js_dokter_anastesi)+intval($data->tft_js_penata_anastesi)+intval($data->tft_js_paramedis)+intval($data->tft_js_lainya),
                'cyto'=>intval($data->tft_js_adm_cto)+intval($data->tft_js_sarana_cto)+intval($data->tft_js_bhp_cto)+intval($data->tft_js_dokter_operator_cto)+intval($data->tft_js_dokter_lainya_cto)+intval($data->tft_js_dokter_anastesi_cto)+intval($data->tft_js_penata_anastesi_cto)+intval($data->tft_js_paramedis_cto)+intval($data->tft_js_lainya_cto)
            ];
        }else{
            return 
            [
                'standar'=>intval($data['tft_js_adm'])+intval($data['tft_js_sarana'])+intval($data['tft_js_bhp'])+intval($data['tft_js_dokter_operator'])+intval($data['tft_js_dokter_lainya'])+intval($data['tft_js_dokter_anastesi'])+intval($data['tft_js_penata_anastesi'])+intval($data['tft_js_paramedis'])+intval($data['tft_js_lainya']),
                'cyto'=>intval($data['tft_js_adm_cto'])+intval($data['tft_js_sarana_cto'])+intval($data['tft_js_bhp_cto'])+intval($data['tft_js_dokter_operator_cto'])+intval($data['tft_js_dokter_lainya_cto'])+intval($data['tft_js_dokter_anastesi_cto'])+intval($data['tft_js_penata_anastesi_cto'])+intval($data['tft_js_paramedis_cto'])+intval($data['tft_js_lainya_cto'])
            ];
        }
    }
    // public static function isPjpDokterRi($layanan,$user){
    //     if($layanan['registrasi']['pjpRi']){
    //         foreach($layanan['registrasi']['pjpRi'] as $val){
    //             if($val['pegawai_id']==$user['pegawai_id']){
    //                 return true;
    //                 break;
    //             }
    //         }
    //     }
    //     return false;
    // }
    // public static function isPjpUtamaDokterRi($layanan,$user){
    //     if($layanan['registrasi']['pjpRi']){
    //         foreach($layanan['registrasi']['pjpRi'] as $val){
    //             if($val['pegawai_id']==$user['pegawai_id'] && $val['status']==PjpRi::DPJP){
    //                 return true;
    //                 break;
    //             }
    //         }
    //     }
    //     return false;
    // }
    // public static function isPjpPendukungDokterRi($layanan,$user){
    //     if($layanan['registrasi']['pjpRi']){
    //         foreach($layanan['registrasi']['pjpRi'] as $val){
    //             if($val['pegawai_id']==$user['pegawai_id'] && $val['status']==PjpRi::DPJP_PENDUKUNG){
    //                 return true;
    //                 break;
    //             }
    //         }
    //     }
    //     return false;
    // }
    // public static function isPjpDokterRjIgd($layanan,$user){
    //     if($layanan['pjp']){
    //         foreach($layanan['pjp'] as $val){
    //             if($val['pegawai_id']==$user['pegawai_id']){
    //                 return true;
    //                 break;
    //             }
    //         }
    //     }
    //     return false;
    // }
    // public static function isPjpUtamaDokterRjIgd($layanan,$user){
    //     if($layanan['pjp']){
    //         foreach($layanan['pjp'] as $val){
    //             if($val['pegawai_id']==$user['pegawai_id'] && $val['status']==Pjp::DPJP){
    //                 return true;
    //                 break;
    //             }
    //         }
    //     }
    //     return false;
    // }
    // public static function isPjpPendukungDokterRjIgd($layanan,$user){
    //     if($layanan['pjp']){
    //         foreach($layanan['pjp'] as $val){
    //             if($val['pegawai_id']==$user['pegawai_id'] && $val['status']==Pjp::DPJP_PENDUKUNG){
    //                 return true;
    //                 break;
    //             }
    //         }
    //     }
    //     return false;
    // }
    // public static function isPjpPerawatRi($layanan,$user){
    //     if($layanan['registrasi']['pjpRi']){
    //         foreach($layanan['registrasi']['pjpRi'] as $val){
    //             if($val['pegawai_id']==$user['pegawai_id'] && ($val['status']==PjpRi::PPJP || $val['status']==PjpRi::BPJP)){
    //                 return true;
    //                 break;
    //             }
    //         }
    //     }
    //     return false;
    // }
    // public static function isPjpPerawatRjIgd($layanan,$user){
    //     if($layanan['pjp']){
    //         foreach($layanan['pjp'] as $val){
    //             if($val['pegawai_id']==$user['pegawai_id'] && ($val['status']==Pjp::PPJP  || $val['status']==Pjp::BPJP)){
    //                 return true;
    //                 break;
    //             }
    //         }
    //     }
    //     return false;
    // }
}
