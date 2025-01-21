<?php
namespace app\components;
use app\models\sdm\AksesUnit;
use app\models\sdm\Unit;
use yii\helpers\ArrayHelper;
use Yii;
class Akun
{
    public static function isGuest()
    {
        $user=Yii::$app->user;
        if(!$user->isGuest){
            return false;
        }
        return true;
    }
    public static function user()
    {
        $user=Yii::$app->user;
        $obj = new \stdClass();
        $obj->id=!$user->isGuest ? $user->identity->userid : NULL;
        $obj->username=!$user->isGuest ? $user->identity->username : NULL;
        $obj->name=!$user->isGuest ? HelperSpesial::getNamaPegawai($user->identity) : NULL;
        return $obj;
    }
    private static function getAksesUnitDb($pgw_id=null){
        return AksesUnit::find()->joinWith(['unit'=>function($q){
            $q->active();
        }])->where(['aku_apl_id'=>Yii::$app->params['app']['id']])->andWhere(['aku_pgw_id'=>$pgw_id])->active()->notDeleted()->asArray()->all();     
    }
    private static function getAksesUnit(){
        $akses=\Yii::$app->session->get('user.akses_unit_medis');
        if(!$akses){
            $pgw_id=self::user()->id;
            $akses=self::getAksesUnitDb($pgw_id);
            $list_akses=array();
            foreach($akses as $v){
                array_push($list_akses,['id'=>$v['aku_unt_id'],'nama'=>$v['unit']['unt_nama']]);
            }
            return $list_akses;
        }else{
            return $akses;
        }
    }

    public static function user_akses_unit()
    {
        $list_akses=self::getAksesUnit();
        return $list_akses;
    }
    public static function user_akses_unit_id()
    {
        $list_akses=self::getAksesUnit();
        return ArrayHelper::getColumn($list_akses, 'id');
    }
    public static function user_akses_unit_map()
    {
        $list_akses=self::getAksesUnit();
        return ArrayHelper::map($list_akses, 'id', 'nama');
    }

    public static function akses_unit_login($pgw_id=null,$original=true,$list=false)
    {
        $pgw_id=self::user()->id;
        $akses=self::getAksesUnitDb($pgw_id);
        $list_akses=array();
        foreach($akses as $v){
            array_push($list_akses,['id'=>$v['aku_unt_id'],'nama'=>$v['unit']['unt_nama']]);
        }
        return $list_akses;
    }
}