<?php
namespace app\components;
use Yii;
use app\components\MakeResponse;
use app\models\pendaftaran\Pasien;
use app\models\pendaftaran\Registrasi;
use app\models\pendaftaran\Layanan;
use app\models\medis\DocClinicalPasien;
use app\models\medis\ItemDocClinical;
use app\models\medis\PenunjangOrder;
use app\models\medis\AsesmenAwalMedis;
use app\models\medis\AsesmenAwalMedisObgin;
use app\models\medis\AsesmenAwalMedisPsikiatri;
use app\models\medis\AsesmenAwalPerawat;
use app\models\medis\AsesmenAwalBidan;
use app\models\medis\AsesmenAwalGizi;
use app\models\medis\AsesmenAwalPerawatNeonatus;
use app\models\medis\AsesmenAwalBidanBayiBaruLahir;
use app\models\medis\LaporanPersalinan;
use app\models\medis\Partograf;
use app\models\medis\Odontogram;
use app\models\medis\ResumeMedisRj;
use app\models\medis\ResumeMedisRi;
use app\models\medis\Resep;
use app\models\medis\Cppt;
use app\models\medis\Log;
use yii\helpers\ArrayHelper;
class Mdcp
{
    //setting date type
    const data_type=DocClinicalPasien::data_type_html_base64;
    // $transaction = Log::getDb()->beginTransaction();
    // try {
    //     $transaction->commit();
    //     return true;
    // }catch (\Exception $e){
    //     $transaction->rollBack();
    //     throw $e;
    // }catch (\Throwable $e){
    //     $transaction->rollBack();
    //     throw $e;
    // }
    // return false;
    //DM_000001
    public static function Dpjp($reg_kode,$data){//$data =>format html
        $kode='DM_000001';
        $judul='Formulir DPJP RAWATINAP';
        $data_type=self::data_type;
        if(self::data_type==DocClinicalPasien::data_type_html_base64){
            $data=base64_encode($data);
        }
        $midc_id=Yii::$app->params['setting']['mapping_doc_item_clinical'][$kode];
        $modelRegistrasi=Registrasi::find()->where(['reg_kode'=>$reg_kode])->one();
        if($modelRegistrasi->reg_mdcp_id_dpjp){
            //1.update mdcp
            $modelMdcp=DocClinicalPasien::findOne($modelRegistrasi->reg_mdcp_id_dpjp);
            $mdcp_data_before=$modelMdcp->mdcp_data;
            if($modelMdcp!==null){
                $modelMdcp->mdcp_data_type=$data_type;
                $modelMdcp->mdcp_data=$data;
                if($modelMdcp->save(false)){
                    //2.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_UPDATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=$mdcp_data_before;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil diubah');
                    }
                }
                return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal diubah');
            }
        }else{
            //1.create mdcp
            $modelMdcp=new DocClinicalPasien();
            $reg=self::getRegistrasi($reg_kode);
            $midc=ItemDocClinical::find()->where(['midc_id'=>$midc_id])->asArray()->one();
            $modelMdcp->mdcp_ps_kode=$reg['mdcp_ps_kode'];
            $modelMdcp->mdcp_ps_nama=$reg['mdcp_ps_nama'];
            $modelMdcp->mdcp_ps_tempat_lahir=$reg['mdcp_ps_tempat_lahir'];
            $modelMdcp->mdcp_ps_tgl_lahir=$reg['mdcp_ps_tgl_lahir'];
            $modelMdcp->mdcp_ps_gender=$reg['mdcp_ps_gender'];
            $modelMdcp->mdcp_ps_umur=$reg['mdcp_ps_umur'];
            $modelMdcp->mdcp_reg_kode=$reg['mdcp_reg_kode'];
            $modelMdcp->mdcp_reg_tgl=$reg['mdcp_reg_tgl'];
            $modelMdcp->mdcp_midc_id=$midc['midc_id'];
            $modelMdcp->mdcp_midc_nama=$midc['midc_nama'];
            $modelMdcp->mdcp_data_type=$data_type;
            $modelMdcp->mdcp_data=$data;
            if($modelMdcp->save(false)){
                //2.update reg_mdcp_id_dpjp
                $modelRegistrasi->reg_mdcp_id_dpjp=$modelMdcp->mdcp_id;
                if($modelRegistrasi->save(false)){
                    //3.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_CREATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=null;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil dibuat');
                    }
                }
            }
            return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal dibuat');
        }
    }
    public static function OrderPemeriksaanPenunjang($id,$pl_id,$data,$batal=false){//$data =>format html
        $kode='DM_000005';
        $judul='Order Pemeriksaan Penunjang';
        $data_type=self::data_type;
        if($data_type==DocClinicalPasien::data_type_html_base64){
            $data=base64_encode($data);
        }
        $midc_id=Yii::$app->params['setting']['mapping_doc_item_clinical'][$kode];
        $modelOrder=PenunjangOrder::find()->where(['po_id'=>$id])->one();
        if($modelOrder->po_mdcp_id){
            //1.update mdcp
            $modelMdcp=DocClinicalPasien::findOne($modelOrder->po_mdcp_id);
            $mdcp_data_before=$modelMdcp->mdcp_data;
            if($modelMdcp!==null){
                $modelMdcp->mdcp_data_type=$data_type;
                $modelMdcp->mdcp_data=$data;
                if($batal){
                    $modelMdcp->mdcp_batal=1;
                    $modelMdcp->mdcp_tgl_batal=date('Y-m-d H:i:s');
                }
                if($modelMdcp->save(false)){
                    //2.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_UPDATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=$mdcp_data_before;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil diubah');
                    }
                }
                return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal diubah');
            }
        }else{
            //1.create mdcp
            $modelMdcp=new DocClinicalPasien();
            $lay=self::getLayanan($pl_id);
            $midc=ItemDocClinical::find()->where(['midc_id'=>$midc_id])->asArray()->one();
            $modelMdcp->mdcp_ps_kode=$lay['mdcp_ps_kode'];
            $modelMdcp->mdcp_ps_nama=$lay['mdcp_ps_nama'];
            $modelMdcp->mdcp_ps_tempat_lahir=$lay['mdcp_ps_tempat_lahir'];
            $modelMdcp->mdcp_ps_tgl_lahir=$lay['mdcp_ps_tgl_lahir'];
            $modelMdcp->mdcp_ps_gender=$lay['mdcp_ps_gender'];
            $modelMdcp->mdcp_ps_umur=$lay['mdcp_ps_umur'];
            $modelMdcp->mdcp_reg_kode=$lay['mdcp_reg_kode'];
            $modelMdcp->mdcp_reg_tgl=$lay['mdcp_reg_tgl'];
            $modelMdcp->mdcp_pl_id=$lay['mdcp_pl_id'];
            $modelMdcp->mdcp_pl_tgl=$lay['mdcp_pl_tgl'];
            $modelMdcp->mdcp_unt_id=$lay['mdcp_unt_id'];
            $modelMdcp->mdcp_unt_nama=$lay['mdcp_unt_nama'];
            $modelMdcp->mdcp_midc_id=$midc['midc_id'];
            $modelMdcp->mdcp_midc_nama=$midc['midc_nama'];
            $modelMdcp->mdcp_data_type=$data_type;
            $modelMdcp->mdcp_data=$data;
            if($modelMdcp->save(false)){
                //2.update reg_mdcp_id_dpjp
                $modelOrder->po_mdcp_id=$modelMdcp->mdcp_id;
                if($modelOrder->save(false)){
                    //3.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_CREATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=null;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil dibuat');
                    }
                }
            }
            return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal dibuat');
        }
    }
    public static function ResepObat($id,$pl_id,$data,$batal=false){//$data =>format html
        $kode='DM_000006';
        $judul='Resep Obat';
        $data_type=self::data_type;
        if($data_type==DocClinicalPasien::data_type_html_base64){
            $data=base64_encode($data);
        }
        $midc_id=Yii::$app->params['setting']['mapping_doc_item_clinical'][$kode];
        $modelOrder=Resep::find()->where(['res_id'=>$id])->one();
        if($modelOrder->res_mdcp_id){
            //1.update mdcp
            $modelMdcp=DocClinicalPasien::findOne($modelOrder->res_mdcp_id);
            $mdcp_data_before=$modelMdcp->mdcp_data;
            if($modelMdcp!==null){
                $modelMdcp->mdcp_data_type=$data_type;
                $modelMdcp->mdcp_data=$data;
                if($batal){
                    $modelMdcp->mdcp_batal=1;
                    $modelMdcp->mdcp_tgl_batal=date('Y-m-d H:i:s');
                }
                if($modelMdcp->save(false)){
                    //2.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_UPDATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=$mdcp_data_before;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil diubah');
                    }
                }
                return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal diubah');
            }
        }else{
            //1.create mdcp
            $modelMdcp=new DocClinicalPasien();
            $lay=self::getLayanan($pl_id);
            $midc=ItemDocClinical::find()->where(['midc_id'=>$midc_id])->asArray()->one();
            $modelMdcp->mdcp_ps_kode=$lay['mdcp_ps_kode'];
            $modelMdcp->mdcp_ps_nama=$lay['mdcp_ps_nama'];
            $modelMdcp->mdcp_ps_tempat_lahir=$lay['mdcp_ps_tempat_lahir'];
            $modelMdcp->mdcp_ps_tgl_lahir=$lay['mdcp_ps_tgl_lahir'];
            $modelMdcp->mdcp_ps_gender=$lay['mdcp_ps_gender'];
            $modelMdcp->mdcp_ps_umur=$lay['mdcp_ps_umur'];
            $modelMdcp->mdcp_reg_kode=$lay['mdcp_reg_kode'];
            $modelMdcp->mdcp_reg_tgl=$lay['mdcp_reg_tgl'];
            $modelMdcp->mdcp_pl_id=$lay['mdcp_pl_id'];
            $modelMdcp->mdcp_pl_tgl=$lay['mdcp_pl_tgl'];
            $modelMdcp->mdcp_unt_id=$lay['mdcp_unt_id'];
            $modelMdcp->mdcp_unt_nama=$lay['mdcp_unt_nama'];
            $modelMdcp->mdcp_midc_id=$midc['midc_id'];
            $modelMdcp->mdcp_midc_nama=$midc['midc_nama'];
            $modelMdcp->mdcp_data_type=$data_type;
            $modelMdcp->mdcp_data=$data;
            if($modelMdcp->save(false)){
                //2.update reg_mdcp_id_dpjp
                $modelOrder->res_mdcp_id=$modelMdcp->mdcp_id;
                if($modelOrder->save(false)){
                    //3.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_CREATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=null;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil dibuat');
                    }
                }
            }
            return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal dibuat');
        }
    }
    public static function Cppt($id,$pl_id,$reg_kode,$data,$batal=false){//$data =>format html
        $kode='DM_000003';
        $judul='CPPT';
        $data_type=self::data_type;
        if($data_type==DocClinicalPasien::data_type_html_base64){
            $data=base64_encode($data);
        }
        $midc_id=Yii::$app->params['setting']['mapping_doc_item_clinical'][$kode];
        $modelRegistrasi=Registrasi::find()->where(['reg_kode'=>$reg_kode])->one();
        if($modelRegistrasi->reg_mdcp_id_cppt){
            //1.update mdcp
            $modelMdcp=DocClinicalPasien::findOne($modelRegistrasi->reg_mdcp_id_cppt);
            $mdcp_data_before=$modelMdcp->mdcp_data;
            if($modelMdcp!==null){
                $modelMdcp->mdcp_data_type=$data_type;
                $modelMdcp->mdcp_data=$data;
                if($batal){
                    $modelMdcp->mdcp_batal=1;
                    $modelMdcp->mdcp_tgl_batal=date('Y-m-d H:i:s');
                }
                if($modelMdcp->save(false)){
                    //2.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_UPDATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=$mdcp_data_before;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil diubah');
                    }
                }
                return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal diubah');
            }
        }else{
            //1.create mdcp
            $modelMdcp=new DocClinicalPasien();
            $lay=self::getLayanan($pl_id);
            $midc=ItemDocClinical::find()->where(['midc_id'=>$midc_id])->asArray()->one();
            $modelMdcp->mdcp_ps_kode=$lay['mdcp_ps_kode'];
            $modelMdcp->mdcp_ps_nama=$lay['mdcp_ps_nama'];
            $modelMdcp->mdcp_ps_tempat_lahir=$lay['mdcp_ps_tempat_lahir'];
            $modelMdcp->mdcp_ps_tgl_lahir=$lay['mdcp_ps_tgl_lahir'];
            $modelMdcp->mdcp_ps_gender=$lay['mdcp_ps_gender'];
            $modelMdcp->mdcp_ps_umur=$lay['mdcp_ps_umur'];
            $modelMdcp->mdcp_reg_kode=$lay['mdcp_reg_kode'];
            $modelMdcp->mdcp_reg_tgl=$lay['mdcp_reg_tgl'];
            $modelMdcp->mdcp_pl_id=$lay['mdcp_pl_id'];
            $modelMdcp->mdcp_pl_tgl=$lay['mdcp_pl_tgl'];
            $modelMdcp->mdcp_unt_id=$lay['mdcp_unt_id'];
            $modelMdcp->mdcp_unt_nama=$lay['mdcp_unt_nama'];
            $modelMdcp->mdcp_midc_id=$midc['midc_id'];
            $modelMdcp->mdcp_midc_nama=$midc['midc_nama'];
            $modelMdcp->mdcp_data_type=$data_type;
            $modelMdcp->mdcp_data=$data;
            if($modelMdcp->save(false)){
                //2.update reg_mdcp_id_dpjp
                $modelRegistrasi->reg_mdcp_id_cppt=$modelMdcp->mdcp_id;
                if($modelRegistrasi->save(false)){
                    //3.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_CREATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=null;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil dibuat');
                    }
                }
            }
            return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal dibuat');
        }
    }
    public static function AsesmenAwalMedis($id,$pl_id,$data,$batal=false){//$data =>format html
        $kode='DM_000002';
        $judul='Asesmen Awal Medis General';
        $data_type=self::data_type;
        if($data_type==DocClinicalPasien::data_type_html_base64){
            $data=base64_encode($data);
        }
        $midc_id=Yii::$app->params['setting']['mapping_doc_item_clinical'][$kode];
        $modelOrder=AsesmenAwalMedis::find()->where(['aamp_id'=>$id])->one();
        if($modelOrder->aamp_mdcp_id){
            //1.update mdcp
            $modelMdcp=DocClinicalPasien::findOne($modelOrder->aamp_mdcp_id);
            $mdcp_data_before=$modelMdcp->mdcp_data;
            if($modelMdcp!==null){
                $modelMdcp->mdcp_data_type=$data_type;
                $modelMdcp->mdcp_data=$data;
                if($batal){
                    $modelMdcp->mdcp_batal=1;
                    $modelMdcp->mdcp_tgl_batal=date('Y-m-d H:i:s');
                }
                if($modelMdcp->save(false)){
                    //2.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_UPDATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=$mdcp_data_before;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil diubah');
                    }
                }
                return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal diubah');
            }
        }else{
            //1.create mdcp
            $modelMdcp=new DocClinicalPasien();
            $lay=self::getLayanan($pl_id);
            $midc=ItemDocClinical::find()->where(['midc_id'=>$midc_id])->asArray()->one();
            $modelMdcp->mdcp_ps_kode=$lay['mdcp_ps_kode'];
            $modelMdcp->mdcp_ps_nama=$lay['mdcp_ps_nama'];
            $modelMdcp->mdcp_ps_tempat_lahir=$lay['mdcp_ps_tempat_lahir'];
            $modelMdcp->mdcp_ps_tgl_lahir=$lay['mdcp_ps_tgl_lahir'];
            $modelMdcp->mdcp_ps_gender=$lay['mdcp_ps_gender'];
            $modelMdcp->mdcp_ps_umur=$lay['mdcp_ps_umur'];
            $modelMdcp->mdcp_reg_kode=$lay['mdcp_reg_kode'];
            $modelMdcp->mdcp_reg_tgl=$lay['mdcp_reg_tgl'];
            $modelMdcp->mdcp_pl_id=$lay['mdcp_pl_id'];
            $modelMdcp->mdcp_pl_tgl=$lay['mdcp_pl_tgl'];
            $modelMdcp->mdcp_unt_id=$lay['mdcp_unt_id'];
            $modelMdcp->mdcp_unt_nama=$lay['mdcp_unt_nama'];
            $modelMdcp->mdcp_midc_id=$midc['midc_id'];
            $modelMdcp->mdcp_midc_nama=$midc['midc_nama'];
            $modelMdcp->mdcp_data_type=$data_type;
            $modelMdcp->mdcp_data=$data;
            if($modelMdcp->save(false)){
                //2.update reg_mdcp_id_dpjp
                $modelOrder->aamp_mdcp_id=$modelMdcp->mdcp_id;
                if($modelOrder->save(false)){
                    //3.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_CREATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=null;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil dibuat');
                    }
                }
            }
            return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal dibuat');
        }
    }

    public static function AnalisaKuantitatif($id,$req_kodee,$data,$batal=false){//$data =>format html
        $kode='DM_000002';
        $judul='Analisa Kuantitatif';
        $data_type=self::data_type;
        if($data_type==DocClinicalPasien::data_type_html_base64){
            $data=base64_encode($data);
        }
        $midc_id=Yii::$app->params['setting']['mapping_doc_item_clinical'][$kode];
        $modelOrder=AsesmenAwalMedis::find()->where(['aamp_id'=>$id])->one();
        if($modelOrder->aamp_mdcp_id){
            //1.update mdcp
            $modelMdcp=DocClinicalPasien::findOne($modelOrder->aamp_mdcp_id);
            $mdcp_data_before=$modelMdcp->mdcp_data;
            if($modelMdcp!==null){
                $modelMdcp->mdcp_data_type=$data_type;
                $modelMdcp->mdcp_data=$data;
                if($batal){
                    $modelMdcp->mdcp_batal=1;
                    $modelMdcp->mdcp_tgl_batal=date('Y-m-d H:i:s');
                }
                if($modelMdcp->save(false)){
                    //2.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_UPDATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=$mdcp_data_before;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil diubah');
                    }
                }
                return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal diubah');
            }
        }else{
            //1.create mdcp
            $modelMdcp=new DocClinicalPasien();
            $lay=self::getLayanan($pl_id);
            $midc=ItemDocClinical::find()->where(['midc_id'=>$midc_id])->asArray()->one();
            $modelMdcp->mdcp_ps_kode=$lay['mdcp_ps_kode'];
            $modelMdcp->mdcp_ps_nama=$lay['mdcp_ps_nama'];
            $modelMdcp->mdcp_ps_tempat_lahir=$lay['mdcp_ps_tempat_lahir'];
            $modelMdcp->mdcp_ps_tgl_lahir=$lay['mdcp_ps_tgl_lahir'];
            $modelMdcp->mdcp_ps_gender=$lay['mdcp_ps_gender'];
            $modelMdcp->mdcp_ps_umur=$lay['mdcp_ps_umur'];
            $modelMdcp->mdcp_reg_kode=$lay['mdcp_reg_kode'];
            $modelMdcp->mdcp_reg_tgl=$lay['mdcp_reg_tgl'];
            $modelMdcp->mdcp_pl_id=$lay['mdcp_pl_id'];
            $modelMdcp->mdcp_pl_tgl=$lay['mdcp_pl_tgl'];
            $modelMdcp->mdcp_unt_id=$lay['mdcp_unt_id'];
            $modelMdcp->mdcp_unt_nama=$lay['mdcp_unt_nama'];
            $modelMdcp->mdcp_midc_id=$midc['midc_id'];
            $modelMdcp->mdcp_midc_nama=$midc['midc_nama'];
            $modelMdcp->mdcp_data_type=$data_type;
            $modelMdcp->mdcp_data=$data;
            if($modelMdcp->save(false)){
                //2.update reg_mdcp_id_dpjp
                $modelOrder->aamp_mdcp_id=$modelMdcp->mdcp_id;
                if($modelOrder->save(false)){
                    //3.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_CREATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=null;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil dibuat');
                    }
                }
            }
            return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal dibuat');
        }
    }
    public static function AsesmenAwalKeperawatan($id,$pl_id,$data,$batal=false){//$data =>format html
        $kode='DM_000007';
        $judul='Asesmen Awal Keperawatan';
        $data_type=self::data_type;
        if($data_type==DocClinicalPasien::data_type_html_base64){
            $data=base64_encode($data);
        }
        $midc_id=Yii::$app->params['setting']['mapping_doc_item_clinical'][$kode];
        $modelOrder=AsesmenAwalPerawat::find()->where(['maap_id'=>$id])->one();
        if($modelOrder->maap_mdcp_id){
            //1.update mdcp
            $modelMdcp=DocClinicalPasien::findOne($modelOrder->maap_mdcp_id);
            $mdcp_data_before=$modelMdcp->mdcp_data;
            if($modelMdcp!==null){
                $modelMdcp->mdcp_data_type=$data_type;
                $modelMdcp->mdcp_data=$data;
                if($batal){
                    $modelMdcp->mdcp_batal=1;
                    $modelMdcp->mdcp_tgl_batal=date('Y-m-d H:i:s');
                }
                if($modelMdcp->save(false)){
                    //2.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_UPDATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=$mdcp_data_before;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil diubah');
                    }
                }
                return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal diubah');
            }
        }else{
            //1.create mdcp
            $modelMdcp=new DocClinicalPasien();
            $lay=self::getLayanan($pl_id);
            $midc=ItemDocClinical::find()->where(['midc_id'=>$midc_id])->asArray()->one();
            $modelMdcp->mdcp_ps_kode=$lay['mdcp_ps_kode'];
            $modelMdcp->mdcp_ps_nama=$lay['mdcp_ps_nama'];
            $modelMdcp->mdcp_ps_tempat_lahir=$lay['mdcp_ps_tempat_lahir'];
            $modelMdcp->mdcp_ps_tgl_lahir=$lay['mdcp_ps_tgl_lahir'];
            $modelMdcp->mdcp_ps_gender=$lay['mdcp_ps_gender'];
            $modelMdcp->mdcp_ps_umur=$lay['mdcp_ps_umur'];
            $modelMdcp->mdcp_reg_kode=$lay['mdcp_reg_kode'];
            $modelMdcp->mdcp_reg_tgl=$lay['mdcp_reg_tgl'];
            $modelMdcp->mdcp_pl_id=$lay['mdcp_pl_id'];
            $modelMdcp->mdcp_pl_tgl=$lay['mdcp_pl_tgl'];
            $modelMdcp->mdcp_unt_id=$lay['mdcp_unt_id'];
            $modelMdcp->mdcp_unt_nama=$lay['mdcp_unt_nama'];
            $modelMdcp->mdcp_midc_id=$midc['midc_id'];
            $modelMdcp->mdcp_midc_nama=$midc['midc_nama'];
            $modelMdcp->mdcp_data_type=$data_type;
            $modelMdcp->mdcp_data=$data;
            if($modelMdcp->save(false)){
                //2.update reg_mdcp_id_dpjp
                $modelOrder->maap_mdcp_id=$modelMdcp->mdcp_id;
                if($modelOrder->save(false)){
                    //3.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_CREATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=null;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil dibuat');
                    }
                }
            }
            return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal dibuat');
        }
    }
    public static function ResumeMedisRj($id,$pl_id,$data,$batal=false){//$data =>format html
        $kode='DM_000004';
        $judul='Resume Medis IGD & Rawat Jalan';
        $data_type=self::data_type;
        if($data_type==DocClinicalPasien::data_type_html_base64){
            $data=base64_encode($data);
        }
        $midc_id=Yii::$app->params['setting']['mapping_doc_item_clinical'][$kode];
        $modelOrder=ResumeMedisRj::find()->where(['rmrj_id'=>$id])->one();
        if($modelOrder->rmrj_mdcp_id){
            //1.update mdcp
            $modelMdcp=DocClinicalPasien::findOne($modelOrder->rmrj_mdcp_id);
            $mdcp_data_before=$modelMdcp->mdcp_data;
            if($modelMdcp!==null){
                $modelMdcp->mdcp_data_type=$data_type;
                $modelMdcp->mdcp_data=$data;
                if($batal){
                    $modelMdcp->mdcp_batal=1;
                    $modelMdcp->mdcp_tgl_batal=date('Y-m-d H:i:s');
                }
                if($modelMdcp->save(false)){
                    //2.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_UPDATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=$mdcp_data_before;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil diubah');
                    }
                }
                return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal diubah');
            }
        }else{
            //1.create mdcp
            $modelMdcp=new DocClinicalPasien();
            $lay=self::getLayanan($pl_id);
            $midc=ItemDocClinical::find()->where(['midc_id'=>$midc_id])->asArray()->one();
            $modelMdcp->mdcp_ps_kode=$lay['mdcp_ps_kode'];
            $modelMdcp->mdcp_ps_nama=$lay['mdcp_ps_nama'];
            $modelMdcp->mdcp_ps_tempat_lahir=$lay['mdcp_ps_tempat_lahir'];
            $modelMdcp->mdcp_ps_tgl_lahir=$lay['mdcp_ps_tgl_lahir'];
            $modelMdcp->mdcp_ps_gender=$lay['mdcp_ps_gender'];
            $modelMdcp->mdcp_ps_umur=$lay['mdcp_ps_umur'];
            $modelMdcp->mdcp_reg_kode=$lay['mdcp_reg_kode'];
            $modelMdcp->mdcp_reg_tgl=$lay['mdcp_reg_tgl'];
            $modelMdcp->mdcp_pl_id=$lay['mdcp_pl_id'];
            $modelMdcp->mdcp_pl_tgl=$lay['mdcp_pl_tgl'];
            $modelMdcp->mdcp_unt_id=$lay['mdcp_unt_id'];
            $modelMdcp->mdcp_unt_nama=$lay['mdcp_unt_nama'];
            $modelMdcp->mdcp_midc_id=$midc['midc_id'];
            $modelMdcp->mdcp_midc_nama=$midc['midc_nama'];
            $modelMdcp->mdcp_data_type=$data_type;
            $modelMdcp->mdcp_data=$data;
            if($modelMdcp->save(false)){
                //2.update reg_mdcp_id_dpjp
                $modelOrder->rmrj_mdcp_id=$modelMdcp->mdcp_id;
                if($modelOrder->save(false)){
                    //3.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_CREATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=null;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil dibuat');
                    }
                }
            }
            return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal dibuat');
        }
    }
    public static function ResumeMedisRi($id,$pl_id,$data,$batal=false){//$data =>format html
        $kode='DM_000008';
        $judul='Resume Medis Rawat Inap';
        $data_type=self::data_type;
        if($data_type==DocClinicalPasien::data_type_html_base64){
            $data=base64_encode($data);
        }
        $midc_id=Yii::$app->params['setting']['mapping_doc_item_clinical'][$kode];
        $modelOrder=ResumeMedisRi::find()->where(['rmri_id'=>$id])->one();
        if($modelOrder->rmrj_mdcp_id){
            //1.update mdcp
            $modelMdcp=DocClinicalPasien::findOne($modelOrder->rmri_mdcp_id);
            $mdcp_data_before=$modelMdcp->mdcp_data;
            if($modelMdcp!==null){
                $modelMdcp->mdcp_data_type=$data_type;
                $modelMdcp->mdcp_data=$data;
                if($batal){
                    $modelMdcp->mdcp_batal=1;
                    $modelMdcp->mdcp_tgl_batal=date('Y-m-d H:i:s');
                }
                if($modelMdcp->save(false)){
                    //2.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_UPDATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=$mdcp_data_before;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil diubah');
                    }
                }
                return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal diubah');
            }
        }else{
            //1.create mdcp
            $modelMdcp=new DocClinicalPasien();
            $lay=self::getLayanan($pl_id);
            $midc=ItemDocClinical::find()->where(['midc_id'=>$midc_id])->asArray()->one();
            $modelMdcp->mdcp_ps_kode=$lay['mdcp_ps_kode'];
            $modelMdcp->mdcp_ps_nama=$lay['mdcp_ps_nama'];
            $modelMdcp->mdcp_ps_tempat_lahir=$lay['mdcp_ps_tempat_lahir'];
            $modelMdcp->mdcp_ps_tgl_lahir=$lay['mdcp_ps_tgl_lahir'];
            $modelMdcp->mdcp_ps_gender=$lay['mdcp_ps_gender'];
            $modelMdcp->mdcp_ps_umur=$lay['mdcp_ps_umur'];
            $modelMdcp->mdcp_reg_kode=$lay['mdcp_reg_kode'];
            $modelMdcp->mdcp_reg_tgl=$lay['mdcp_reg_tgl'];
            $modelMdcp->mdcp_pl_id=$lay['mdcp_pl_id'];
            $modelMdcp->mdcp_pl_tgl=$lay['mdcp_pl_tgl'];
            $modelMdcp->mdcp_unt_id=$lay['mdcp_unt_id'];
            $modelMdcp->mdcp_unt_nama=$lay['mdcp_unt_nama'];
            $modelMdcp->mdcp_midc_id=$midc['midc_id'];
            $modelMdcp->mdcp_midc_nama=$midc['midc_nama'];
            $modelMdcp->mdcp_data_type=$data_type;
            $modelMdcp->mdcp_data=$data;
            if($modelMdcp->save(false)){
                //2.update reg_mdcp_id_dpjp
                $modelOrder->rmri_mdcp_id=$modelMdcp->mdcp_id;
                if($modelOrder->save(false)){
                    //3.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_CREATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=null;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil dibuat');
                    }
                }
            }
            return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal dibuat');
        }
    }
    public static function AsesmenAwalGizi($id,$pl_id,$data,$batal=false){//$data =>format html
        $kode='DM_000009';
        $judul='Asesmen Awal Gizi';
        $data_type=self::data_type;
        if($data_type==DocClinicalPasien::data_type_html_base64){
            $data=base64_encode($data);
        }
        $midc_id=Yii::$app->params['setting']['mapping_doc_item_clinical'][$kode];
        $modelOrder=AsesmenAwalGizi::find()->where(['maag_id'=>$id])->one();
        if($modelOrder->maag_mdcp_id){
            //1.update mdcp
            $modelMdcp=DocClinicalPasien::findOne($modelOrder->maag_mdcp_id);
            $mdcp_data_before=$modelMdcp->mdcp_data;
            if($modelMdcp!==null){
                $modelMdcp->mdcp_data_type=$data_type;
                $modelMdcp->mdcp_data=$data;
                if($batal){
                    $modelMdcp->mdcp_batal=1;
                    $modelMdcp->mdcp_tgl_batal=date('Y-m-d H:i:s');
                }
                if($modelMdcp->save(false)){
                    //2.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_UPDATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=$mdcp_data_before;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil diubah');
                    }
                }
                return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal diubah');
            }
        }else{
            //1.create mdcp
            $modelMdcp=new DocClinicalPasien();
            $lay=self::getLayanan($pl_id);
            $midc=ItemDocClinical::find()->where(['midc_id'=>$midc_id])->asArray()->one();
            $modelMdcp->mdcp_ps_kode=$lay['mdcp_ps_kode'];
            $modelMdcp->mdcp_ps_nama=$lay['mdcp_ps_nama'];
            $modelMdcp->mdcp_ps_tempat_lahir=$lay['mdcp_ps_tempat_lahir'];
            $modelMdcp->mdcp_ps_tgl_lahir=$lay['mdcp_ps_tgl_lahir'];
            $modelMdcp->mdcp_ps_gender=$lay['mdcp_ps_gender'];
            $modelMdcp->mdcp_ps_umur=$lay['mdcp_ps_umur'];
            $modelMdcp->mdcp_reg_kode=$lay['mdcp_reg_kode'];
            $modelMdcp->mdcp_reg_tgl=$lay['mdcp_reg_tgl'];
            $modelMdcp->mdcp_pl_id=$lay['mdcp_pl_id'];
            $modelMdcp->mdcp_pl_tgl=$lay['mdcp_pl_tgl'];
            $modelMdcp->mdcp_unt_id=$lay['mdcp_unt_id'];
            $modelMdcp->mdcp_unt_nama=$lay['mdcp_unt_nama'];
            $modelMdcp->mdcp_midc_id=$midc['midc_id'];
            $modelMdcp->mdcp_midc_nama=$midc['midc_nama'];
            $modelMdcp->mdcp_data_type=$data_type;
            $modelMdcp->mdcp_data=$data;
            if($modelMdcp->save(false)){
                //2.update reg_mdcp_id_dpjp
                $modelOrder->maag_mdcp_id=$modelMdcp->mdcp_id;
                if($modelOrder->save(false)){
                    //3.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_CREATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=null;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil dibuat');
                    }
                }
            }
            return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal dibuat');
        }
    }
    public static function AsesmenAwalKeperawatanNeonatus($id,$pl_id,$data,$batal=false){//$data =>format html
        $kode='DM_000010';
        $judul='Asesmen Awal Keperawatan Neonatus';
        $data_type=self::data_type;
        if($data_type==DocClinicalPasien::data_type_html_base64){
            $data=base64_encode($data);
        }
        $midc_id=Yii::$app->params['setting']['mapping_doc_item_clinical'][$kode];
        $modelOrder=AsesmenAwalPerawatNeonatus::find()->where(['maan_id'=>$id])->one();
        if($modelOrder->maan_mdcp_id){
            //1.update mdcp
            $modelMdcp=DocClinicalPasien::findOne($modelOrder->maan_mdcp_id);
            $mdcp_data_before=$modelMdcp->mdcp_data;
            if($modelMdcp!==null){
                $modelMdcp->mdcp_data_type=$data_type;
                $modelMdcp->mdcp_data=$data;
                if($batal){
                    $modelMdcp->mdcp_batal=1;
                    $modelMdcp->mdcp_tgl_batal=date('Y-m-d H:i:s');
                }
                if($modelMdcp->save(false)){
                    //2.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_UPDATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=$mdcp_data_before;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil diubah');
                    }
                }
                return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal diubah');
            }
        }else{
            //1.create mdcp
            $modelMdcp=new DocClinicalPasien();
            $lay=self::getLayanan($pl_id);
            $midc=ItemDocClinical::find()->where(['midc_id'=>$midc_id])->asArray()->one();
            $modelMdcp->mdcp_ps_kode=$lay['mdcp_ps_kode'];
            $modelMdcp->mdcp_ps_nama=$lay['mdcp_ps_nama'];
            $modelMdcp->mdcp_ps_tempat_lahir=$lay['mdcp_ps_tempat_lahir'];
            $modelMdcp->mdcp_ps_tgl_lahir=$lay['mdcp_ps_tgl_lahir'];
            $modelMdcp->mdcp_ps_gender=$lay['mdcp_ps_gender'];
            $modelMdcp->mdcp_ps_umur=$lay['mdcp_ps_umur'];
            $modelMdcp->mdcp_reg_kode=$lay['mdcp_reg_kode'];
            $modelMdcp->mdcp_reg_tgl=$lay['mdcp_reg_tgl'];
            $modelMdcp->mdcp_pl_id=$lay['mdcp_pl_id'];
            $modelMdcp->mdcp_pl_tgl=$lay['mdcp_pl_tgl'];
            $modelMdcp->mdcp_unt_id=$lay['mdcp_unt_id'];
            $modelMdcp->mdcp_unt_nama=$lay['mdcp_unt_nama'];
            $modelMdcp->mdcp_midc_id=$midc['midc_id'];
            $modelMdcp->mdcp_midc_nama=$midc['midc_nama'];
            $modelMdcp->mdcp_data_type=$data_type;
            $modelMdcp->mdcp_data=$data;
            if($modelMdcp->save(false)){
                //2.update reg_mdcp_id_dpjp
                $modelOrder->maan_mdcp_id=$modelMdcp->mdcp_id;
                if($modelOrder->save(false)){
                    //3.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_CREATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=null;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil dibuat');
                    }
                }
            }
            return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal dibuat');
        }
    }
    public static function AsesmenAwalKebidanan($id,$pl_id,$data,$batal=false){//$data =>format html
        $kode='DM_000012';
        $judul='Asesmen Awal Kebidanan';
        $data_type=self::data_type;
        if($data_type==DocClinicalPasien::data_type_html_base64){
            $data=base64_encode($data);
        }
        $midc_id=Yii::$app->params['setting']['mapping_doc_item_clinical'][$kode];
        $modelOrder=AsesmenAwalBidan::find()->where(['maap_id'=>$id])->one();
        if($modelOrder->maap_mdcp_id){
            //1.update mdcp
            $modelMdcp=DocClinicalPasien::findOne($modelOrder->maap_mdcp_id);
            $mdcp_data_before=$modelMdcp->mdcp_data;
            if($modelMdcp!==null){
                $modelMdcp->mdcp_data_type=$data_type;
                $modelMdcp->mdcp_data=$data;
                if($batal){
                    $modelMdcp->mdcp_batal=1;
                    $modelMdcp->mdcp_tgl_batal=date('Y-m-d H:i:s');
                }
                if($modelMdcp->save(false)){
                    //2.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_UPDATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=$mdcp_data_before;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil diubah');
                    }
                }
                return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal diubah');
            }
        }else{
            //1.create mdcp
            $modelMdcp=new DocClinicalPasien();
            $lay=self::getLayanan($pl_id);
            $midc=ItemDocClinical::find()->where(['midc_id'=>$midc_id])->asArray()->one();
            $modelMdcp->mdcp_ps_kode=$lay['mdcp_ps_kode'];
            $modelMdcp->mdcp_ps_nama=$lay['mdcp_ps_nama'];
            $modelMdcp->mdcp_ps_tempat_lahir=$lay['mdcp_ps_tempat_lahir'];
            $modelMdcp->mdcp_ps_tgl_lahir=$lay['mdcp_ps_tgl_lahir'];
            $modelMdcp->mdcp_ps_gender=$lay['mdcp_ps_gender'];
            $modelMdcp->mdcp_ps_umur=$lay['mdcp_ps_umur'];
            $modelMdcp->mdcp_reg_kode=$lay['mdcp_reg_kode'];
            $modelMdcp->mdcp_reg_tgl=$lay['mdcp_reg_tgl'];
            $modelMdcp->mdcp_pl_id=$lay['mdcp_pl_id'];
            $modelMdcp->mdcp_pl_tgl=$lay['mdcp_pl_tgl'];
            $modelMdcp->mdcp_unt_id=$lay['mdcp_unt_id'];
            $modelMdcp->mdcp_unt_nama=$lay['mdcp_unt_nama'];
            $modelMdcp->mdcp_midc_id=$midc['midc_id'];
            $modelMdcp->mdcp_midc_nama=$midc['midc_nama'];
            $modelMdcp->mdcp_data_type=$data_type;
            $modelMdcp->mdcp_data=$data;
            if($modelMdcp->save(false)){
                //2.update reg_mdcp_id_dpjp
                $modelOrder->maap_mdcp_id=$modelMdcp->mdcp_id;
                if($modelOrder->save(false)){
                    //3.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_CREATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=null;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil dibuat');
                    }
                }
            }
            return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal dibuat');
        }
    }
    public static function Partograf($id,$pl_id,$data,$batal=false){//$data =>format html
        $kode='DM_000013';
        $judul='Partograf & Catatan Persalinan';
        $data_type=self::data_type;
        if($data_type==DocClinicalPasien::data_type_html_base64){
            $data=base64_encode($data);
        }
        $midc_id=Yii::$app->params['setting']['mapping_doc_item_clinical'][$kode];
        $modelOrder=Partograf::find()->where(['part_id'=>$id])->one();
        if($modelOrder->part_mdcp_id){
            //1.update mdcp
            $modelMdcp=DocClinicalPasien::findOne($modelOrder->part_mdcp_id);
            $mdcp_data_before=$modelMdcp->mdcp_data;
            if($modelMdcp!==null){
                $modelMdcp->mdcp_data_type=$data_type;
                $modelMdcp->mdcp_data=$data;
                if($batal){
                    $modelMdcp->mdcp_batal=1;
                    $modelMdcp->mdcp_tgl_batal=date('Y-m-d H:i:s');
                }
                if($modelMdcp->save(false)){
                    //2.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_UPDATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=$mdcp_data_before;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil diubah');
                    }
                }
                return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal diubah');
            }
        }else{
            //1.create mdcp
            $modelMdcp=new DocClinicalPasien();
            $lay=self::getLayanan($pl_id);
            $midc=ItemDocClinical::find()->where(['midc_id'=>$midc_id])->asArray()->one();
            $modelMdcp->mdcp_ps_kode=$lay['mdcp_ps_kode'];
            $modelMdcp->mdcp_ps_nama=$lay['mdcp_ps_nama'];
            $modelMdcp->mdcp_ps_tempat_lahir=$lay['mdcp_ps_tempat_lahir'];
            $modelMdcp->mdcp_ps_tgl_lahir=$lay['mdcp_ps_tgl_lahir'];
            $modelMdcp->mdcp_ps_gender=$lay['mdcp_ps_gender'];
            $modelMdcp->mdcp_ps_umur=$lay['mdcp_ps_umur'];
            $modelMdcp->mdcp_reg_kode=$lay['mdcp_reg_kode'];
            $modelMdcp->mdcp_reg_tgl=$lay['mdcp_reg_tgl'];
            $modelMdcp->mdcp_pl_id=$lay['mdcp_pl_id'];
            $modelMdcp->mdcp_pl_tgl=$lay['mdcp_pl_tgl'];
            $modelMdcp->mdcp_unt_id=$lay['mdcp_unt_id'];
            $modelMdcp->mdcp_unt_nama=$lay['mdcp_unt_nama'];
            $modelMdcp->mdcp_midc_id=$midc['midc_id'];
            $modelMdcp->mdcp_midc_nama=$midc['midc_nama'];
            $modelMdcp->mdcp_data_type=$data_type;
            $modelMdcp->mdcp_data=$data;
            if($modelMdcp->save(false)){
                //2.update reg_mdcp_id_dpjp
                $modelOrder->part_mdcp_id=$modelMdcp->mdcp_id;
                if($modelOrder->save(false)){
                    //3.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_CREATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=null;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil dibuat');
                    }
                }
            }
            return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal dibuat');
        }
    }
    public static function LaporanPersalinan($id,$pl_id,$data,$batal=false){//$data =>format html
        $kode='DM_000014';
        $judul='Laporan Persalinan';
        $data_type=self::data_type;
        if($data_type==DocClinicalPasien::data_type_html_base64){
            $data=base64_encode($data);
        }
        $midc_id=Yii::$app->params['setting']['mapping_doc_item_clinical'][$kode];
        $modelOrder=LaporanPersalinan::find()->where(['pers_id'=>$id])->one();
        if($modelOrder->pers_mdcp_id){
            //1.update mdcp
            $modelMdcp=DocClinicalPasien::findOne($modelOrder->pers_mdcp_id);
            $mdcp_data_before=$modelMdcp->mdcp_data;
            if($modelMdcp!==null){
                $modelMdcp->mdcp_data_type=$data_type;
                $modelMdcp->mdcp_data=$data;
                if($batal){
                    $modelMdcp->mdcp_batal=1;
                    $modelMdcp->mdcp_tgl_batal=date('Y-m-d H:i:s');
                }
                if($modelMdcp->save(false)){
                    //2.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_UPDATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=$mdcp_data_before;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil diubah');
                    }
                }
                return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal diubah');
            }
        }else{
            //1.create mdcp
            $modelMdcp=new DocClinicalPasien();
            $lay=self::getLayanan($pl_id);
            $midc=ItemDocClinical::find()->where(['midc_id'=>$midc_id])->asArray()->one();
            $modelMdcp->mdcp_ps_kode=$lay['mdcp_ps_kode'];
            $modelMdcp->mdcp_ps_nama=$lay['mdcp_ps_nama'];
            $modelMdcp->mdcp_ps_tempat_lahir=$lay['mdcp_ps_tempat_lahir'];
            $modelMdcp->mdcp_ps_tgl_lahir=$lay['mdcp_ps_tgl_lahir'];
            $modelMdcp->mdcp_ps_gender=$lay['mdcp_ps_gender'];
            $modelMdcp->mdcp_ps_umur=$lay['mdcp_ps_umur'];
            $modelMdcp->mdcp_reg_kode=$lay['mdcp_reg_kode'];
            $modelMdcp->mdcp_reg_tgl=$lay['mdcp_reg_tgl'];
            $modelMdcp->mdcp_pl_id=$lay['mdcp_pl_id'];
            $modelMdcp->mdcp_pl_tgl=$lay['mdcp_pl_tgl'];
            $modelMdcp->mdcp_unt_id=$lay['mdcp_unt_id'];
            $modelMdcp->mdcp_unt_nama=$lay['mdcp_unt_nama'];
            $modelMdcp->mdcp_midc_id=$midc['midc_id'];
            $modelMdcp->mdcp_midc_nama=$midc['midc_nama'];
            $modelMdcp->mdcp_data_type=$data_type;
            $modelMdcp->mdcp_data=$data;
            if($modelMdcp->save(false)){
                //2.update reg_mdcp_id_dpjp
                $modelOrder->pers_mdcp_id=$modelMdcp->mdcp_id;
                if($modelOrder->save(false)){
                    //3.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_CREATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=null;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil dibuat');
                    }
                }
            }
            return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal dibuat');
        }
    }
    public static function AsesmenAwalBayiBaruLahir($id,$pl_id,$data,$batal=false){//$data =>format html
        $kode='DM_000015';
        $judul='Asesmen Awal Bayi Baru Lahir';
        $data_type=self::data_type;
        if($data_type==DocClinicalPasien::data_type_html_base64){
            $data=base64_encode($data);
        }
        $midc_id=Yii::$app->params['setting']['mapping_doc_item_clinical'][$kode];
        $modelOrder=AsesmenAwalBidanBayiBaruLahir::find()->where(['maan_id'=>$id])->one();
        if($modelOrder->maan_mdcp_id){
            //1.update mdcp
            $modelMdcp=DocClinicalPasien::findOne($modelOrder->maan_mdcp_id);
            $mdcp_data_before=$modelMdcp->mdcp_data;
            if($modelMdcp!==null){
                $modelMdcp->mdcp_data_type=$data_type;
                $modelMdcp->mdcp_data=$data;
                if($batal){
                    $modelMdcp->mdcp_batal=1;
                    $modelMdcp->mdcp_tgl_batal=date('Y-m-d H:i:s');
                }
                if($modelMdcp->save(false)){
                    //2.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_UPDATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=$mdcp_data_before;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil diubah');
                    }
                }
                return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal diubah');
            }
        }else{
            //1.create mdcp
            $modelMdcp=new DocClinicalPasien();
            $lay=self::getLayanan($pl_id);
            $midc=ItemDocClinical::find()->where(['midc_id'=>$midc_id])->asArray()->one();
            $modelMdcp->mdcp_ps_kode=$lay['mdcp_ps_kode'];
            $modelMdcp->mdcp_ps_nama=$lay['mdcp_ps_nama'];
            $modelMdcp->mdcp_ps_tempat_lahir=$lay['mdcp_ps_tempat_lahir'];
            $modelMdcp->mdcp_ps_tgl_lahir=$lay['mdcp_ps_tgl_lahir'];
            $modelMdcp->mdcp_ps_gender=$lay['mdcp_ps_gender'];
            $modelMdcp->mdcp_ps_umur=$lay['mdcp_ps_umur'];
            $modelMdcp->mdcp_reg_kode=$lay['mdcp_reg_kode'];
            $modelMdcp->mdcp_reg_tgl=$lay['mdcp_reg_tgl'];
            $modelMdcp->mdcp_pl_id=$lay['mdcp_pl_id'];
            $modelMdcp->mdcp_pl_tgl=$lay['mdcp_pl_tgl'];
            $modelMdcp->mdcp_unt_id=$lay['mdcp_unt_id'];
            $modelMdcp->mdcp_unt_nama=$lay['mdcp_unt_nama'];
            $modelMdcp->mdcp_midc_id=$midc['midc_id'];
            $modelMdcp->mdcp_midc_nama=$midc['midc_nama'];
            $modelMdcp->mdcp_data_type=$data_type;
            $modelMdcp->mdcp_data=$data;
            if($modelMdcp->save(false)){
                //2.update reg_mdcp_id_dpjp
                $modelOrder->maan_mdcp_id=$modelMdcp->mdcp_id;
                if($modelOrder->save(false)){
                    //3.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_CREATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=null;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil dibuat');
                    }
                }
            }
            return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal dibuat');
        }
    }
    public static function AsesmenAwalKeperawatanPsikiatri($id,$pl_id,$data,$batal=false){//$data =>format html
        $kode='DM_000017';
        $judul='Asesmen Awal Keperawatan Psikiatri';
        $data_type=self::data_type;
        if($data_type==DocClinicalPasien::data_type_html_base64){
            $data=base64_encode($data);
        }
        $midc_id=Yii::$app->params['setting']['mapping_doc_item_clinical'][$kode];
        $modelOrder=AsesmenAwalPerawat::find()->where(['maap_id'=>$id])->one();
        if($modelOrder->maap_mdcp_id){
            //1.update mdcp
            $modelMdcp=DocClinicalPasien::findOne($modelOrder->maap_mdcp_id);
            $mdcp_data_before=$modelMdcp->mdcp_data;
            if($modelMdcp!==null){
                $modelMdcp->mdcp_data_type=$data_type;
                $modelMdcp->mdcp_data=$data;
                if($batal){
                    $modelMdcp->mdcp_batal=1;
                    $modelMdcp->mdcp_tgl_batal=date('Y-m-d H:i:s');
                }
                if($modelMdcp->save(false)){
                    //2.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_UPDATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=$mdcp_data_before;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil diubah');
                    }
                }
                return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal diubah');
            }
        }else{
            //1.create mdcp
            $modelMdcp=new DocClinicalPasien();
            $lay=self::getLayanan($pl_id);
            $midc=ItemDocClinical::find()->where(['midc_id'=>$midc_id])->asArray()->one();
            $modelMdcp->mdcp_ps_kode=$lay['mdcp_ps_kode'];
            $modelMdcp->mdcp_ps_nama=$lay['mdcp_ps_nama'];
            $modelMdcp->mdcp_ps_tempat_lahir=$lay['mdcp_ps_tempat_lahir'];
            $modelMdcp->mdcp_ps_tgl_lahir=$lay['mdcp_ps_tgl_lahir'];
            $modelMdcp->mdcp_ps_gender=$lay['mdcp_ps_gender'];
            $modelMdcp->mdcp_ps_umur=$lay['mdcp_ps_umur'];
            $modelMdcp->mdcp_reg_kode=$lay['mdcp_reg_kode'];
            $modelMdcp->mdcp_reg_tgl=$lay['mdcp_reg_tgl'];
            $modelMdcp->mdcp_pl_id=$lay['mdcp_pl_id'];
            $modelMdcp->mdcp_pl_tgl=$lay['mdcp_pl_tgl'];
            $modelMdcp->mdcp_unt_id=$lay['mdcp_unt_id'];
            $modelMdcp->mdcp_unt_nama=$lay['mdcp_unt_nama'];
            $modelMdcp->mdcp_midc_id=$midc['midc_id'];
            $modelMdcp->mdcp_midc_nama=$midc['midc_nama'];
            $modelMdcp->mdcp_data_type=$data_type;
            $modelMdcp->mdcp_data=$data;
            if($modelMdcp->save(false)){
                //2.update reg_mdcp_id_dpjp
                $modelOrder->maap_mdcp_id=$modelMdcp->mdcp_id;
                if($modelOrder->save(false)){
                    //3.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_CREATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=null;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil dibuat');
                    }
                }
            }
            return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal dibuat');
        }
    }
    public static function AsesmenAwalMedisPsikiatri($id,$pl_id,$data,$batal=false){//$data =>format html
        $kode='DM_000018';
        $judul='Asesmen Awal Medis Psikiatri';
        $data_type=self::data_type;
        if($data_type==DocClinicalPasien::data_type_html_base64){
            $data=base64_encode($data);
        }
        $midc_id=Yii::$app->params['setting']['mapping_doc_item_clinical'][$kode];
        $modelOrder=AsesmenAwalMedisPsikiatri::find()->where(['aamp_id'=>$id])->one();
        if($modelOrder->aamp_mdcp_id){
            //1.update mdcp
            $modelMdcp=DocClinicalPasien::findOne($modelOrder->aamp_mdcp_id);
            $mdcp_data_before=$modelMdcp->mdcp_data;
            if($modelMdcp!==null){
                $modelMdcp->mdcp_data_type=$data_type;
                $modelMdcp->mdcp_data=$data;
                if($batal){
                    $modelMdcp->mdcp_batal=1;
                    $modelMdcp->mdcp_tgl_batal=date('Y-m-d H:i:s');
                }
                if($modelMdcp->save(false)){
                    //2.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_UPDATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=$mdcp_data_before;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil diubah');
                    }
                }
                return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal diubah');
            }
        }else{
            //1.create mdcp
            $modelMdcp=new DocClinicalPasien();
            $lay=self::getLayanan($pl_id);
            $midc=ItemDocClinical::find()->where(['midc_id'=>$midc_id])->asArray()->one();
            $modelMdcp->mdcp_ps_kode=$lay['mdcp_ps_kode'];
            $modelMdcp->mdcp_ps_nama=$lay['mdcp_ps_nama'];
            $modelMdcp->mdcp_ps_tempat_lahir=$lay['mdcp_ps_tempat_lahir'];
            $modelMdcp->mdcp_ps_tgl_lahir=$lay['mdcp_ps_tgl_lahir'];
            $modelMdcp->mdcp_ps_gender=$lay['mdcp_ps_gender'];
            $modelMdcp->mdcp_ps_umur=$lay['mdcp_ps_umur'];
            $modelMdcp->mdcp_reg_kode=$lay['mdcp_reg_kode'];
            $modelMdcp->mdcp_reg_tgl=$lay['mdcp_reg_tgl'];
            $modelMdcp->mdcp_pl_id=$lay['mdcp_pl_id'];
            $modelMdcp->mdcp_pl_tgl=$lay['mdcp_pl_tgl'];
            $modelMdcp->mdcp_unt_id=$lay['mdcp_unt_id'];
            $modelMdcp->mdcp_unt_nama=$lay['mdcp_unt_nama'];
            $modelMdcp->mdcp_midc_id=$midc['midc_id'];
            $modelMdcp->mdcp_midc_nama=$midc['midc_nama'];
            $modelMdcp->mdcp_data_type=$data_type;
            $modelMdcp->mdcp_data=$data;
            if($modelMdcp->save(false)){
                //2.update reg_mdcp_id_dpjp
                $modelOrder->aamp_mdcp_id=$modelMdcp->mdcp_id;
                if($modelOrder->save(false)){
                    //3.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_CREATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=null;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil dibuat');
                    }
                }
            }
            return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal dibuat');
        }
    }
    public static function AsesmenAwalMedisObgin($id,$pl_id,$data,$batal=false){//$data =>format html
        $kode='DM_000019';
        $judul='Asesmen Awal Medis Obstetri & Ginekologi';
        $data_type=self::data_type;
        if($data_type==DocClinicalPasien::data_type_html_base64){
            $data=base64_encode($data);
        }
        $midc_id=Yii::$app->params['setting']['mapping_doc_item_clinical'][$kode];
        $modelOrder=AsesmenAwalMedisObgin::find()->where(['aamp_id'=>$id])->one();
        if($modelOrder->aamp_mdcp_id){
            //1.update mdcp
            $modelMdcp=DocClinicalPasien::findOne($modelOrder->aamp_mdcp_id);
            $mdcp_data_before=$modelMdcp->mdcp_data;
            if($modelMdcp!==null){
                $modelMdcp->mdcp_data_type=$data_type;
                $modelMdcp->mdcp_data=$data;
                if($batal){
                    $modelMdcp->mdcp_batal=1;
                    $modelMdcp->mdcp_tgl_batal=date('Y-m-d H:i:s');
                }
                if($modelMdcp->save(false)){
                    //2.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_UPDATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=$mdcp_data_before;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil diubah');
                    }
                }
                return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal diubah');
            }
        }else{
            //1.create mdcp
            $modelMdcp=new DocClinicalPasien();
            $lay=self::getLayanan($pl_id);
            $midc=ItemDocClinical::find()->where(['midc_id'=>$midc_id])->asArray()->one();
            $modelMdcp->mdcp_ps_kode=$lay['mdcp_ps_kode'];
            $modelMdcp->mdcp_ps_nama=$lay['mdcp_ps_nama'];
            $modelMdcp->mdcp_ps_tempat_lahir=$lay['mdcp_ps_tempat_lahir'];
            $modelMdcp->mdcp_ps_tgl_lahir=$lay['mdcp_ps_tgl_lahir'];
            $modelMdcp->mdcp_ps_gender=$lay['mdcp_ps_gender'];
            $modelMdcp->mdcp_ps_umur=$lay['mdcp_ps_umur'];
            $modelMdcp->mdcp_reg_kode=$lay['mdcp_reg_kode'];
            $modelMdcp->mdcp_reg_tgl=$lay['mdcp_reg_tgl'];
            $modelMdcp->mdcp_pl_id=$lay['mdcp_pl_id'];
            $modelMdcp->mdcp_pl_tgl=$lay['mdcp_pl_tgl'];
            $modelMdcp->mdcp_unt_id=$lay['mdcp_unt_id'];
            $modelMdcp->mdcp_unt_nama=$lay['mdcp_unt_nama'];
            $modelMdcp->mdcp_midc_id=$midc['midc_id'];
            $modelMdcp->mdcp_midc_nama=$midc['midc_nama'];
            $modelMdcp->mdcp_data_type=$data_type;
            $modelMdcp->mdcp_data=$data;
            if($modelMdcp->save(false)){
                //2.update reg_mdcp_id_dpjp
                $modelOrder->aamp_mdcp_id=$modelMdcp->mdcp_id;
                if($modelOrder->save(false)){
                    //3.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_CREATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=null;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil dibuat');
                    }
                }
            }
            return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal dibuat');
        }
    }
    public static function OdontogramAnak($id,$pl_id,$data,$batal=false){//$data =>format html
        $kode='DM_000020';
        $judul='Odontogram Anak';
        $data_type=self::data_type;
        if($data_type==DocClinicalPasien::data_type_html_base64){
            $data=base64_encode($data);
        }
        $midc_id=Yii::$app->params['setting']['mapping_doc_item_clinical'][$kode];
        $modelOrder=Odontogram::find()->where(['mod_id'=>$id])->one();
        if($modelOrder->mod_mdcp_id){
            //1.update mdcp
            $modelMdcp=DocClinicalPasien::findOne($modelOrder->mod_mdcp_id);
            $mdcp_data_before=$modelMdcp->mdcp_data;
            if($modelMdcp!==null){
                $modelMdcp->mdcp_data_type=$data_type;
                $modelMdcp->mdcp_data=$data;
                if($batal){
                    $modelMdcp->mdcp_batal=1;
                    $modelMdcp->mdcp_tgl_batal=date('Y-m-d H:i:s');
                }
                if($modelMdcp->save(false)){
                    //2.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_UPDATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=$mdcp_data_before;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil diubah');
                    }
                }
                return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal diubah');
            }
        }else{
            //1.create mdcp
            $modelMdcp=new DocClinicalPasien();
            $lay=self::getLayanan($pl_id);
            $midc=ItemDocClinical::find()->where(['midc_id'=>$midc_id])->asArray()->one();
            $modelMdcp->mdcp_ps_kode=$lay['mdcp_ps_kode'];
            $modelMdcp->mdcp_ps_nama=$lay['mdcp_ps_nama'];
            $modelMdcp->mdcp_ps_tempat_lahir=$lay['mdcp_ps_tempat_lahir'];
            $modelMdcp->mdcp_ps_tgl_lahir=$lay['mdcp_ps_tgl_lahir'];
            $modelMdcp->mdcp_ps_gender=$lay['mdcp_ps_gender'];
            $modelMdcp->mdcp_ps_umur=$lay['mdcp_ps_umur'];
            $modelMdcp->mdcp_reg_kode=$lay['mdcp_reg_kode'];
            $modelMdcp->mdcp_reg_tgl=$lay['mdcp_reg_tgl'];
            $modelMdcp->mdcp_pl_id=$lay['mdcp_pl_id'];
            $modelMdcp->mdcp_pl_tgl=$lay['mdcp_pl_tgl'];
            $modelMdcp->mdcp_unt_id=$lay['mdcp_unt_id'];
            $modelMdcp->mdcp_unt_nama=$lay['mdcp_unt_nama'];
            $modelMdcp->mdcp_midc_id=$midc['midc_id'];
            $modelMdcp->mdcp_midc_nama=$midc['midc_nama'];
            $modelMdcp->mdcp_data_type=$data_type;
            $modelMdcp->mdcp_data=$data;
            if($modelMdcp->save(false)){
                //2.update reg_mdcp_id_dpjp
                $modelOrder->mod_mdcp_id=$modelMdcp->mdcp_id;
                if($modelOrder->save(false)){
                    //3.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_CREATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=null;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil dibuat');
                    }
                }
            }
            return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal dibuat');
        }
    }
    public static function OdontogramDewasa($id,$pl_id,$data,$batal=false){//$data =>format html
        $kode='DM_000021';
        $judul='Odontogram Dewasa';
        $data_type=self::data_type;
        if($data_type==DocClinicalPasien::data_type_html_base64){
            $data=base64_encode($data);
        }
        $midc_id=Yii::$app->params['setting']['mapping_doc_item_clinical'][$kode];
        $modelOrder=Odontogram::find()->where(['mod_id'=>$id])->one();
        if($modelOrder->mod_mdcp_id){
            //1.update mdcp
            $modelMdcp=DocClinicalPasien::findOne($modelOrder->mod_mdcp_id);
            $mdcp_data_before=$modelMdcp->mdcp_data;
            if($modelMdcp!==null){
                $modelMdcp->mdcp_data_type=$data_type;
                $modelMdcp->mdcp_data=$data;
                if($batal){
                    $modelMdcp->mdcp_batal=1;
                    $modelMdcp->mdcp_tgl_batal=date('Y-m-d H:i:s');
                }
                if($modelMdcp->save(false)){
                    //2.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_UPDATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=$mdcp_data_before;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil diubah');
                    }
                }
                return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal diubah');
            }
        }else{
            //1.create mdcp
            $modelMdcp=new DocClinicalPasien();
            $lay=self::getLayanan($pl_id);
            $midc=ItemDocClinical::find()->where(['midc_id'=>$midc_id])->asArray()->one();
            $modelMdcp->mdcp_ps_kode=$lay['mdcp_ps_kode'];
            $modelMdcp->mdcp_ps_nama=$lay['mdcp_ps_nama'];
            $modelMdcp->mdcp_ps_tempat_lahir=$lay['mdcp_ps_tempat_lahir'];
            $modelMdcp->mdcp_ps_tgl_lahir=$lay['mdcp_ps_tgl_lahir'];
            $modelMdcp->mdcp_ps_gender=$lay['mdcp_ps_gender'];
            $modelMdcp->mdcp_ps_umur=$lay['mdcp_ps_umur'];
            $modelMdcp->mdcp_reg_kode=$lay['mdcp_reg_kode'];
            $modelMdcp->mdcp_reg_tgl=$lay['mdcp_reg_tgl'];
            $modelMdcp->mdcp_pl_id=$lay['mdcp_pl_id'];
            $modelMdcp->mdcp_pl_tgl=$lay['mdcp_pl_tgl'];
            $modelMdcp->mdcp_unt_id=$lay['mdcp_unt_id'];
            $modelMdcp->mdcp_unt_nama=$lay['mdcp_unt_nama'];
            $modelMdcp->mdcp_midc_id=$midc['midc_id'];
            $modelMdcp->mdcp_midc_nama=$midc['midc_nama'];
            $modelMdcp->mdcp_data_type=$data_type;
            $modelMdcp->mdcp_data=$data;
            if($modelMdcp->save(false)){
                //2.update reg_mdcp_id_dpjp
                $modelOrder->mod_mdcp_id=$modelMdcp->mdcp_id;
                if($modelOrder->save(false)){
                    //3.create log
                    $modelLog=new Log();
                    $modelLog->scenario="mdcp";
                    $modelLog->mlog_mdcp_id=$modelMdcp->mdcp_id;
                    $modelLog->mlog_type=Log::TYPE_CREATE;
                    $modelLog->mlog_deskripsi=$modelMdcp->mdcp_midc_nama;
                    $modelLog->mlog_data_type=$modelMdcp->mdcp_data_type;
                    $modelLog->mlog_data_before=null;
                    $modelLog->mlog_data_after=$modelMdcp->mdcp_data;
                    if($modelLog->save(false)){
                        return MakeResponse::createNotJson(true,'Doc Clinical Pasien : '.$judul.' berhasil dibuat');
                    }
                }
            }
            return MakeResponse::createNotJson(false,'Doc Clinical Pasien : '.$judul.' gagal dibuat');
        }
    }
    private static function getRegistrasi($reg_kode){
        $d=Registrasi::find(['reg_kode','reg_tgl_masuk'])->with(['pasien'])->where(['reg_kode'=>$reg_kode])->asArray()->one();
        if($d){
            $umr=HelperGeneral::getUmur($d['pasien']['ps_tgl_lahir']);
            return[
                'mdcp_ps_kode'=>$d['pasien']['ps_kode'],
                'mdcp_ps_nama'=>$d['pasien']['ps_nama'],
                'mdcp_ps_tgl_lahir'=>date('Y-m-d',strtotime($d['pasien']['ps_tgl_lahir'])),
                'mdcp_ps_tempat_lahir'=>$d['pasien']['ps_tempat_lahir'],
                'mdcp_ps_gender'=>Pasien::$jenis_kelamin[$d['pasien']['ps_jkel']],
                'mdcp_ps_umur'=>$umr['th'].'TH '.$umr['bl'].'BL '.$umr['hr'].'HR',
                'mdcp_reg_kode'=>$d['reg_kode'],
                'mdcp_reg_tgl'=>$d['reg_tgl_masuk']
            ];
        }
    }
    private static function getLayanan($pl_id){
        $d=Layanan::find()->with(['unit','registrasi.pasien'])->where(['pl_id'=>$pl_id])->asArray()->one();
        if($d){
            $umr=HelperGeneral::getUmur($d['registrasi']['pasien']['ps_tgl_lahir']);
            return[
                'mdcp_ps_kode'=>$d['registrasi']['pasien']['ps_kode'],
                'mdcp_ps_nama'=>$d['registrasi']['pasien']['ps_nama'],
                'mdcp_ps_tgl_lahir'=>date('Y-m-d',strtotime($d['registrasi']['pasien']['ps_tgl_lahir'])),
                'mdcp_ps_tempat_lahir'=>$d['registrasi']['pasien']['ps_tempat_lahir'],
                'mdcp_ps_gender'=>Pasien::$jenis_kelamin[$d['registrasi']['pasien']['ps_jkel']],
                'mdcp_ps_umur'=>$umr['th'].'TH '.$umr['bl'].'BL '.$umr['hr'].'HR',
                'mdcp_reg_kode'=>$d['registrasi']['reg_kode'],
                'mdcp_reg_tgl'=>$d['registrasi']['reg_tgl_masuk'],
                'mdcp_pl_id'=>$d['pl_id'],
                'mdcp_pl_tgl'=>$d['pl_tgl_masuk'],
                'mdcp_unt_id'=>$d['pl_unit_kode'],
                'mdcp_unt_nama'=>$d['unit']['unt_nama']
            ];
        }
    }
}