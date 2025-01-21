<?php
namespace app\components;

use app\models\AsetKodefikasi;
use app\models\pengolahandata\JenisKegiatan;
use app\models\pengolahandata\KualifikasiPendidikan;
use app\models\pengolahandata\MasterDataDasarRs;
use Yii;
use NumberFormatter;
use yii\base\Security;
class Helper
{
    public static function hashData($data)
    {
        $s = new Security();
        return $s->hashData($data, Yii::$app->params['other']['keys'].date('Y-m-d'));
    }

    public static function validateData($data)
    {
        $s = new Security();
        return $s->validateData($data, Yii::$app->params['other']['keys'].date('Y-m-d'));
    }
    public static function highlightKeyword($text, $words)
    {
        preg_match_all('~\w+~', $words, $m);
        if (!$m)
            return $text;
        $re = '~(' . implode('|', $m[0]) . ')~i';
        return preg_replace($re, '<span style="background-color: #0168fa; color: #ffffff;">$0</span>', $text);
    }

    public static function getDateFormatToIndo($date,$full=true)
    {
        if($full){
            $month =[1 =>   'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        }else{
            $month =[1 =>   'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        }
        $date=date('Y-m-d',strtotime($date));
        $exp = explode('-', $date);
        return $exp[2] . '/' . $month[(int)$exp[1]] . '/' . $exp[0];
    }
    public static function getUmur($birthday,$today=null)
    {
        if(!$today){
            $today==date('Y-m-d');
        }
        $biday = new \DateTime($birthday);
	    $today = new \DateTime($today);
        $diff = $today->diff($biday);
        return [
            'th'=>$diff->y,
            'bl'=>$diff->m,
            'hr'=>$diff->d
        ];
    }
    public static function convertLayananId($id){
        if(!is_numeric($id)){
            $id=self::validateData($id);
        }    
        if($id){
            return $id;
        }
        return null;
    }
    public static function getValueCustomRadio($data,$val){
        if(!in_array($val, $data) && !empty($val)){
            return ['v'=>$val,'c'=>'checked'];
        }else{
            return ['v'=>null,'c'=>null];
        }
    }
    public static function createResponse($status, $msg = null, $data = null)
	{
		$_res = new \stdClass();
		$_res->status = $status == true ? true : false;
		$_res->msg = $msg;
		$_res->data = $data;
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $_res;
	}
	public static function createResponseNotJson($status, $msg = null, $data = null)
	{
		$_res = new \stdClass();
		$_res->status = $status == true ? true : false;
		$_res->msg = $msg;
		$_res->data = $data;
		return $_res;
	}
    // public static function login()
    // {
    //     $user=Yii::$app->user;
    //     $obj = new \stdClass();
    //     $obj->id=null;
    //     $obj->username=null;
    //     $obj->name=null;
    //     $obj->image=null;
    //     $obj->signature=null;
    //     if(!$user->isGuest){
    //         $obj->id=$user->identity->userid;
    //         $obj->username=$user->identity->username;
    //         $obj->name=User::getNamaPegawai($user->identity);
    //     }
    //     return $obj;
    // }
    static function getKodefikasi($p)
    {
        if(!empty($p)){
        $data = \Yii::$app->db->createCommand("WITH RECURSIVE rec_tindakan AS (
            SELECT a.kodefikasi_id, a.kodefikasi_parent_id, a.kodefikasi_uraian,
                   a.kodefikasi_uraian AS rumpun
            FROM ".AsetKodefikasi::tableName()." as a
            WHERE a.kodefikasi_parent_id=0
         UNION ALL
            SELECT b.kodefikasi_id, b.kodefikasi_parent_id, b.kodefikasi_uraian, CONCAT(rec_tindakan.rumpun, ' >> ', b.kodefikasi_uraian)
            FROM ".AsetKodefikasi::tableName()." as b
               JOIN rec_tindakan ON b.kodefikasi_parent_id = rec_tindakan.kodefikasi_id
      )
      SELECT * FROM rec_tindakan where kodefikasi_id =$p")->queryOne();
        
            return $data['kodefikasi_id'] = $data['rumpun'];
        }else{
            return $data['kodefikasi_id'] = '';
        }
    }

    static function getKualifikasiPendidikan($p)
    {
        if(!empty($p)){
        $data = \Yii::$app->db->createCommand("WITH RECURSIVE rec_tindakan AS (
            SELECT a.id, a.parent_id, a.uraian,
                   a.uraian AS rumpun
            FROM ".KualifikasiPendidikan::tableName()." as a
            WHERE a.parent_id=0
         UNION ALL
            SELECT b.id, b.parent_id, b.uraian, CONCAT(rec_tindakan.rumpun, ' >> ', b.uraian)
            FROM ".KualifikasiPendidikan::tableName()." as b
               JOIN rec_tindakan ON b.parent_id = rec_tindakan.id
      )
      SELECT * FROM rec_tindakan where id =$p")->queryOne();
        
            return $data['id'] = $data['rumpun'];
        }else{
            return $data['id'] = '';
        }
    }
    static function getJenisKegiatan($p)
    {
        if(!empty($p)){
        $data = \Yii::$app->db->createCommand("WITH RECURSIVE rec_jenis_kegiatan AS (
            SELECT a.jenis_kegiatan_id, a.jenis_kegiatan_parent_id, a.jenis_kegiatan_uraian,
                   a.jenis_kegiatan_uraian AS rumpun
            FROM ".JenisKegiatan::tableName()." as a
            WHERE a.jenis_kegiatan_parent_id=0
         UNION ALL
            SELECT b.jenis_kegiatan_id, b.jenis_kegiatan_parent_id, b.jenis_kegiatan_uraian, CONCAT(rec_jenis_kegiatan.rumpun, ' >> ', b.jenis_kegiatan_uraian)
            FROM ".JenisKegiatan::tableName()." as b
               JOIN rec_jenis_kegiatan ON b.jenis_kegiatan_parent_id = rec_jenis_kegiatan.jenis_kegiatan_id
      )
      SELECT * FROM rec_jenis_kegiatan where jenis_kegiatan_id =$p")->queryOne();
        
            return $data['jenis_kegiatan_id'] = $data['rumpun'];
        }else{
            return $data['jenis_kegiatan_id'] = '';
        }
    }
    static function getMasterDataDasarRs($p)
    {
        if(!empty($p)){
        $data = \Yii::$app->db->createCommand("WITH RECURSIVE rec_data_dasar AS (
            SELECT a.id, a.parent_id, a.deskripsi,
                   a.deskripsi AS rumpun
            FROM ".MasterDataDasarRs::tableName()." as a
            WHERE a.parent_id=0
         UNION ALL
            SELECT b.id, b.parent_id, b.deskripsi, CONCAT(rec_data_dasar.rumpun, ' >> ', b.deskripsi)
            FROM ".MasterDataDasarRs::tableName()." as b
               JOIN rec_data_dasar ON b.parent_id = rec_data_dasar.id
      )
      SELECT * FROM rec_data_dasar where id =$p")->queryOne();
        
            return $data['id'] = $data['rumpun'];
        }else{
            return $data['id'] = '';
        }
    }

    public static function radioList($index, $label, $name, $checked, $value, $model)
    {
        $id = str_replace(['[', ']'], '_', $name) . $index;
        return \yii\helpers\Html::radio(
            $name,
            $checked,
            [
                'value' => $value,
                'label' => $label,
                'id' => $id
            ]
        ) . '&nbsp;&nbsp;&nbsp;';
    }
}
