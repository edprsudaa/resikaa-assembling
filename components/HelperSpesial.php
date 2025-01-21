<?php
namespace app\components;
use Yii;
use app\models\sdm\Aplikasi;
use app\models\sdm\AksesUnit;
use app\models\sdm\DokterUnit;
use app\models\sdm\Unit;

use app\models\pendaftaran\Layanan;
use app\models\medis\Pjp;
use app\models\medis\PjpRi;
use app\models\medis\ItemPemeriksaanPenunjang;
use app\models\medis\Cppt;
use app\models\pegawai\Pegawai;
use yii\helpers\ArrayHelper;
class HelperSpesial
{
    public static function getDataPegawaiByNomor($nomor)
	{
		return Pegawai::find()->where(['id_nip_nrp' => $nomor])->notDeleted()->one();
	}
    public static function getDataPegawaiById($id)
	{
		return Pegawai::find()->where(['pegawai_id' => $id])->notDeleted()->one();
	}
    public static function getNamaPegawai($pegawai)
    {
        return $pegawai->nama;
    }
    public static function getNamaPegawaiArray($pegawai)
    {
        return ($pegawai['gelar_sarjana_depan'] ? $pegawai['gelar_sarjana_depan'] . ' ' : null) . $pegawai['nama_lengkap'] . ($pegawai['gelar_sarjana_belakang'] ? ', ' . $pegawai['pgw_gelar_belakang'] : null);
    }
    // public static function getListPegawai($aktif=0,$original=true,$list=false)
    // {
    //     $result=array();
    //     $query=Pegawai::find();
    //     if($aktif>0){
    //         $query->where(['pgw_aktif'=>1]);
    //     }
    //     $result=$query->notDeleted()->asArray()->all();
    //     $list_result=array();
    //     foreach($result as $v){
    //         array_push($list_result,['id'=>$v['pgw_id'],'nama'=>self::getNamaPegawaiArray($v)]);
    //     }
    //     if($original){
    //         return $list_result;
    //     }else{
    //         if($list){
    //             return ArrayHelper::map($list_result, 'id', 'nama');
    //         }else{
    //             return ArrayHelper::getColumn($list_result, 'id');
    //         }
    //     }
    // }
	// public static function getListDokterUnit($unit=null,$original=true,$list=false)
    // {
    //     $result=array();
    //     $query=DokterUnit::find()
    //     ->joinWith([
    //         'dokter','unit'
    //     ]);
    //     if(!empty($unit)){
    //         $query->where(['dku_unt_id'=>$unit]);
    //     }
    //     $result=$query->notDeleted()->asArray()->all();
    //     // echo'<pre/>';print_r($result);die();
    //     $list_result=array();
    //     foreach($result as $v){
    //         array_push($list_result,['id'=>$v['dku_dokter_id'],'nama'=>self::getNamaPegawaiArray($v['dokter'])]);
    //     }
    //     if($original){
    //         return $list_result;
    //     }else{
    //         if($list){
    //             return ArrayHelper::map($list_result, 'id', 'nama');
    //         }else{
    //             return ArrayHelper::getColumn($list_result, 'id');
    //         }
    //     }
    // }
}
