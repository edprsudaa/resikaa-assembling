<?php

namespace app\components;

use Yii;
use app\models\pegawai\DmUnitPenempatan;
use app\models\pendaftaran\KelompokUnitLayanan;
use app\models\pegawai\TbPegawai;
use app\models\AkunAknUser;
use app\models\pegawai\TbRiwayatStr;
use app\models\pegawai\TbRiwayatSipp;
use app\models\pegawai\TbRiwayatSpklinis;
use app\models\pegawai\TbRiwayatPenempatan;
use app\models\pegawai\TbUnitPltPlh;
use app\models\pendaftaran\Layanan;
use app\models\medis\Pjp;
use app\models\medis\PjpRi;
use app\models\Sesi;
use yii\helpers\ArrayHelper;
use app\components\HelperGeneralClass;
use app\components\Api;
use app\models\medis\DocClinical;
use app\models\medis\DocClinicalPasien;
use app\models\pendaftaran\Registrasi;
use app\models\pendaftaran\Pasien;

use app\models\pengolahandata\DataDasarRs;
use app\models\pengolahandata\Ketenagaan;
use app\models\pengolahandata\KualifikasiPendidikan;
use app\models\pengolahandata\ResultHead;
use app\models\penunjang\HasilPemeriksaan;
use app\models\penunjang\ResultPacs;
use app\models\sqlServer\LISORDER;

class HelperSpesialClass
{
    const LEVEL_ROOT = 'ROOT';
    const LEVEL_ADMIN = 'ADMIN';
    const LEVEL_PERAWAT = 'PERAWAT';
    const LEVEL_BIDAN = 'BIDAN';
    const LEVEL_DOKTER = 'DOKTER';
    const LEVEL_ADM = 'ADM';

    const SDM_RUMPUN_MEDIS = '1';
    const SDM_RUMPUN_PERAWAT = '3';
    const SDM_RUMPUN_BIDAN = '4';
    public static function getDataPegawaiByNip($id)
    {
        return TbPegawai::find()->where(['id_nip_nrp' => $id])->one();
    }
    // public static function getDataPegawaiByUserID($id)
    // {
    // 	return self::getNamaPegawai(AkunAknUser::find()->joinWith(['pegawai'])->where([AkunAknUser::tableName().'.userid' => $id])->one()->pegawai);
    // }
    // public static function getLogLogin($id)
    // {
    // 	return Sesi::find()->where(['ida' => $id])->orderBy(['tgb' => SORT_DESC])->limit(3)->all();
    // }
    public static function getNamaPegawaiLogin()
    {
        return self::getUserLogin()['nama'];
    }
    public static function getNamaPegawai($pegawai)
    {
        return ($pegawai->gelar_sarjana_depan ? $pegawai->gelar_sarjana_depan . ' ' : null) . $pegawai->nama_lengkap . ($pegawai->gelar_sarjana_belakang ? ', ' . $pegawai->gelar_sarjana_belakang : null);
    }
    public static function getNamaPegawaiArray($pegawai)
    {
        //params array
        return ($pegawai['gelar_sarjana_depan'] ? $pegawai['gelar_sarjana_depan'] . ' ' : null) . $pegawai['nama_lengkap'] . ($pegawai['gelar_sarjana_belakang'] ? ', ' . $pegawai['gelar_sarjana_belakang'] : null);
    }
    // =====BY FIKRI======
    // public static function getListPerawat($original=true,$list=false)
    // {
    //     $result=TbPegawai::find()->select([TbPegawai::tableName().'.id_nip_nrp','pegawai_id',new \yii\db\Expression("CONCAT(".TbPegawai::tableName().".id_nip_nrp,' | ',gelar_sarjana_depan, ' ',nama_lengkap,' ',gelar_sarjana_belakang) as nama")])->innerjoinWith([
    //         'riwayatStr',
    //         'riwayatSipp',
    //         'riwayatSpklinis',
    //         'riwayatPenempatan'=>function($q){
    //             $q->where([TbRiwayatPenempatan::tableName().'.sdm_rumpun'=>self::SDM_RUMPUN_PERAWAT])->orderBy([TbRiwayatPenempatan::tableName().'.tanggal'=>SORT_DESC])->limit(1);
    //         }
    //     ])->where(['>=',TbRiwayatStr::tableName().'.tanggal_berlaku',date('Y-m-d')])
    //     ->andWhere(['>=',TbRiwayatSipp::tableName().'.tanggal_berlaku',date('Y-m-d')])
    //     ->andWhere(['>=',TbRiwayatSpklinis::tableName().'.tanggal_berlaku',date('Y-m-d')])
    //     ->active()->asArray()->all();
    //     if($original){
    //         return $result;
    //     }else{
    //         if($list){
    //             return ArrayHelper::map($result, 'pegawai_id', 'nama');
    //         }else{
    //             return ArrayHelper::getColumn($result, 'pegawai_id');
    //         }
    //     }
    // }
    // public static function getListBidan($original=true,$list=false)
    // {
    //     $result=TbPegawai::find()->select([TbPegawai::tableName().'.id_nip_nrp','pegawai_id',new \yii\db\Expression("CONCAT(".TbPegawai::tableName().".id_nip_nrp,' | ',gelar_sarjana_depan, ' ',nama_lengkap,' ',gelar_sarjana_belakang) as nama")])->innerjoinWith([
    //         'riwayatStr',
    //         'riwayatSipp',
    //         'riwayatSpklinis',
    //         'riwayatPenempatan'=>function($q){
    //             $q->where([TbRiwayatPenempatan::tableName().'.sdm_rumpun'=>self::SDM_RUMPUN_BIDAN])->orderBy([TbRiwayatPenempatan::tableName().'.tanggal'=>SORT_DESC])->limit(1);
    //         }
    //     ])->where(['>=',TbRiwayatStr::tableName().'.tanggal_berlaku',date('Y-m-d')])
    //     ->andWhere(['>=',TbRiwayatSipp::tableName().'.tanggal_berlaku',date('Y-m-d')])
    //     ->andWhere(['>=',TbRiwayatSpklinis::tableName().'.tanggal_berlaku',date('Y-m-d')])
    //     ->active()->asArray()->all();
    //     if($original){
    //         return $result;
    //     }else{
    //         if($list){
    //             return ArrayHelper::map($result, 'pegawai_id', 'nama');
    //         }else{
    //             return ArrayHelper::getColumn($result, 'pegawai_id');
    //         }
    //     }
    // }
    // public static function getListDokter($original=true,$list=false)
    // {
    //     //bisa by tb_riwayat_penempatan where sdm_rumpun=1
    //     $result=TbPegawai::find()->select([TbPegawai::tableName().'.id_nip_nrp','pegawai_id',new \yii\db\Expression("CONCAT(".TbPegawai::tableName().".id_nip_nrp,' | ',gelar_sarjana_depan, ' ',nama_lengkap,' ',gelar_sarjana_belakang) as nama")])->innerjoinWith([
    //         'riwayatSipp',
    //         'riwayatSpklinis',
    //         'riwayatPenempatan'=>function($q){
    //             $q->where([TbRiwayatPenempatan::tableName().'.sdm_rumpun'=>self::SDM_RUMPUN_MEDIS])->orderBy([TbRiwayatPenempatan::tableName().'.tanggal'=>SORT_DESC])->limit(1);
    //         }
    //     ])
    //     ->where(['>=',TbRiwayatSipp::tableName().'.tanggal_berlaku',date('Y-m-d')])
    //     ->andWhere(['>=',TbRiwayatSpklinis::tableName().'.tanggal_berlaku',date('Y-m-d')])
    //     ->active()->asArray()->all();
    //     if($original){
    //         return $result;
    //     }else{
    //         if($list){
    //             return ArrayHelper::map($result, 'pegawai_id', 'nama');
    //         }else{
    //             return ArrayHelper::getColumn($result, 'pegawai_id');
    //         }
    //     }
    // }
    public static function getListPerawat($original = true, $list = false)
    {
        $result = TbPegawai::find()->select([TbPegawai::tableName() . '.id_nip_nrp', 'pegawai_id', new \yii\db\Expression("CONCAT(" . TbPegawai::tableName() . ".id_nip_nrp,' | ',gelar_sarjana_depan, ' ',nama_lengkap,' ',gelar_sarjana_belakang) as nama")])->innerjoinWith([
            'riwayatPenempatan' => function ($q) {
                $q->where([TbRiwayatPenempatan::tableName() . '.sdm_rumpun' => self::SDM_RUMPUN_PERAWAT])->orderBy([TbRiwayatPenempatan::tableName() . '.tanggal' => SORT_DESC])->limit(1);
            }
        ])
            ->active()->asArray()->all();
        if ($original) {
            return $result;
        } else {
            if ($list) {
                return ArrayHelper::map($result, 'pegawai_id', 'nama');
            } else {
                return ArrayHelper::getColumn($result, 'pegawai_id');
            }
        }
    }
    public static function getListBidan($original = true, $list = false)
    {
        $result = TbPegawai::find()->select([TbPegawai::tableName() . '.id_nip_nrp', 'pegawai_id', new \yii\db\Expression("CONCAT(" . TbPegawai::tableName() . ".id_nip_nrp,' | ',gelar_sarjana_depan, ' ',nama_lengkap,' ',gelar_sarjana_belakang) as nama")])->innerjoinWith([
            'riwayatPenempatan' => function ($q) {
                $q->where([TbRiwayatPenempatan::tableName() . '.sdm_rumpun' => self::SDM_RUMPUN_BIDAN])->orderBy([TbRiwayatPenempatan::tableName() . '.tanggal' => SORT_DESC])->limit(1);
            }
        ])
            ->active()->asArray()->all();
        if ($original) {
            return $result;
        } else {
            if ($list) {
                return ArrayHelper::map($result, 'pegawai_id', 'nama');
            } else {
                return ArrayHelper::getColumn($result, 'pegawai_id');
            }
        }
    }
    public static function getListDokter($original = true, $list = false)
    {
        //bisa by tb_riwayat_penempatan where sdm_rumpun=1
        $result = TbPegawai::find()->select([TbPegawai::tableName() . '.id_nip_nrp', 'pegawai_id', new \yii\db\Expression("CONCAT(" . TbPegawai::tableName() . ".id_nip_nrp,' | ',gelar_sarjana_depan, ' ',nama_lengkap,' ',gelar_sarjana_belakang) as nama")])->innerjoinWith([
            'riwayatPenempatan' => function ($q) {
                $q->where([TbRiwayatPenempatan::tableName() . '.sdm_rumpun' => self::SDM_RUMPUN_MEDIS])->orderBy([TbRiwayatPenempatan::tableName() . '.tanggal' => SORT_DESC])->active()->limit(1);
            }
        ])->active()->asArray()->all();
        if (!$result) {
            $result = TbPegawai::find()->select([TbPegawai::tableName() . '.id_nip_nrp', 'pegawai_id', new \yii\db\Expression("CONCAT(" . TbPegawai::tableName() . ".id_nip_nrp,' | ',gelar_sarjana_depan, ' ',nama_lengkap,' ',gelar_sarjana_belakang) as nama")])->innerjoinWith([
                'pltPlh' => function ($q) {
                    $q->where([TbUnitPltPlh::tableName() . '.sdm_rumpun' => self::SDM_RUMPUN_MEDIS])->orderBy([TbUnitPltPlh::tableName() . '.tanggal_surat' => SORT_DESC])->active()->limit(1);
                }
            ])->active()->asArray()->all();
        }
        if ($original) {
            return $result;
        } else {
            if ($list) {
                return ArrayHelper::map($result, 'pegawai_id', 'nama');
            } else {
                return ArrayHelper::getColumn($result, 'pegawai_id');
            }
        }
    }
    public static function getListPjp($layanan, $original = true, $list = false)
    {
        //return pjp_id=>pegawai_nama
        $result = array();
        if ($layanan['jenis_layanan'] === Layanan::RI) {
            //RI
            $query = PjpRi::find()
                ->select([PjpRi::tableName() . '.id', PjpRi::tableName() . '.pegawai_id', TbPegawai::tableName() . '.id_nip_nrp', TbPegawai::tableName() . '.pegawai_id', new \yii\db\Expression("CONCAT(gelar_sarjana_depan, ' ',nama_lengkap,' ',gelar_sarjana_belakang) as nama")])
                ->joinWith([
                    'pegawai'
                ]);
            $query->andWhere([PjpRi::tableName() . '.registrasi_kode' => $layanan['registrasi_kode']]);
            $result = $query->asArray()->all();
        } else {
            //RJ/IGD/PENUNJANG
            $query = Pjp::find()
                ->select([Pjp::tableName() . '.id', Pjp::tableName() . '.pegawai_id', TbPegawai::tableName() . '.id_nip_nrp', TbPegawai::tableName() . '.pegawai_id', new \yii\db\Expression("CONCAT(gelar_sarjana_depan, ' ',nama_lengkap,' ',gelar_sarjana_belakang) as nama")])
                ->joinWith([
                    'pegawai'
                ]);
            $query->andWhere([Pjp::tableName() . '.layanan_id' => $layanan['id']]);
            $result = $query->asArray()->all();
        }
        if ($original) {
            return $result;
        } else {
            if ($list) {
                return ArrayHelper::map($result, 'id', 'nama');
            } else {
                return ArrayHelper::getColumn($result, 'id');
            }
        }
    }
    public static function getListPegawaiPjp($layanan, $original = true, $list = false)
    {
        //return pegawai_id=>pegawai_nama
        $result = array();
        if ($layanan['jenis_layanan'] === Layanan::RI) {
            //RI
            $query = PjpRi::find()
                ->select([PjpRi::tableName() . '.id', PjpRi::tableName() . '.pegawai_id', TbPegawai::tableName() . '.id_nip_nrp', TbPegawai::tableName() . '.pegawai_id', new \yii\db\Expression("CONCAT(gelar_sarjana_depan, ' ',nama_lengkap,' ',gelar_sarjana_belakang) as nama")])
                ->joinWith([
                    'pegawai'
                ]);
            $query->andWhere([PjpRi::tableName() . '.registrasi_kode' => $layanan['registrasi_kode']]);
            $result = $query->asArray()->all();
        } else {
            //RJ/IGD/PENUNJANG
            $query = Pjp::find()
                ->select([Pjp::tableName() . '.id', Pjp::tableName() . '.pegawai_id', TbPegawai::tableName() . '.id_nip_nrp', TbPegawai::tableName() . '.pegawai_id', new \yii\db\Expression("CONCAT(gelar_sarjana_depan, ' ',nama_lengkap,' ',gelar_sarjana_belakang) as nama")])
                ->joinWith([
                    'pegawai'
                ]);
            $query->andWhere([Pjp::tableName() . '.layanan_id' => $layanan['id']]);
            $result = $query->asArray()->all();
        }
        if ($original) {
            return $result;
        } else {
            if ($list) {
                return ArrayHelper::map($result, 'pegawai_id', 'nama');
            } else {
                return ArrayHelper::getColumn($result, 'pegawai_id');
            }
        }
    }
    public static function getUnitPenempatanPegawai($pegawai_id = null, $original = true, $list = false)
    {
        if (empty($pegawai_id)) {
            $pegawai_id = self::getUserLogin()['pegawai_id'];
        }
        $peg1 = TbRiwayatPenempatan::find()->select(['nama', 'unit_kerja as kode', 'unit_kerja', TbPegawai::tableName() . '.id_nip_nrp'])->joinWith(['unitKerja', 'pegawai' => function ($q) use ($pegawai_id) {
            $q->active()->andWhere([TbPegawai::tableName() . '.pegawai_id' => $pegawai_id]);
        }])->orderBy(['tanggal' => SORT_DESC])->asArray()->limit(1)->active()->all();
        // return $peg1;
        $peg2 = TbUnitPltPlh::find()->select(['nama', 'unit_kerja', TbPegawai::tableName() . '.id_nip_nrp'])->joinWith(['unitKerja', 'pegawai' => function ($q) use ($pegawai_id) {
            $q->active()->andWhere([TbPegawai::tableName() . '.pegawai_id' => $pegawai_id]);
        }])->orderBy(['tgl_berlaku_mulai' => SORT_DESC])->active()->asArray()->all();
        $all_penempatan = array();
        if ($peg1) {
            array_push($all_penempatan, ['nama' => $peg1[0]['nama'], 'unit_kerja' => $peg1[0]['unit_kerja']]);
        }
        foreach ($peg2 as $peg2) {
            array_push($all_penempatan, ['nama' => $peg2['nama'], 'unit_kerja' => $peg2['unit_kerja']]);
        }
        // $peg=$peg1+$peg2;
        // echo'<pre/>';print_r($all_penempatan);die();
        if ($original) {
            // return $peg;
        } else {
            if ($list) {
                return ArrayHelper::map($all_penempatan, 'unit_kerja', 'nama');
            } else {
                return ArrayHelper::getColumn($all_penempatan, 'unit_kerja');
            }
        }
        // return (ArrayHelper::map($peg1, 'unit_kerja', 'nama')+ArrayHelper::map($peg2, 'unit_kerja', 'nama'));//merge array
    }
    public static function getListIGDAksesPegawai($list = true, $user = [])
    {
        $unit = array();
        if (!$user) {
            $user = self::getUserLogin();
        }
        if (strtoupper($user['akses_level']) == self::LEVEL_ROOT || strtoupper($user['akses_level']) == self::LEVEL_ADMIN) {
            $unit = KelompokUnitLayanan::find()->select([KelompokUnitLayanan::tableName() . '.unit_id', DmUnitPenempatan::tableName() . '.kode', DmUnitPenempatan::tableName() . '.nama',])->joinWith(['unit'])->kel_igd()
                ->orderBy([DmUnitPenempatan::tableName() . '.nama' => SORT_ASC])
                ->asArray()
                ->all();
        } else if (strtoupper($user['akses_level']) == self::LEVEL_PERAWAT  || strtoupper($user['akses_level']) == self::LEVEL_BIDAN) {
            $unit = KelompokUnitLayanan::find()->select([KelompokUnitLayanan::tableName() . '.unit_id', DmUnitPenempatan::tableName() . '.kode', DmUnitPenempatan::tableName() . '.nama',])->joinWith(['unit'])->kel_igd()
                ->andWhere(KelompokUnitLayanan::tableName() . '.unit_id IN (' . implode(',', self::getUnitPenempatanPegawai($user['pegawai_id'], false, false)) . ')')
                ->orderBy([DmUnitPenempatan::tableName() . '.nama' => SORT_ASC])
                ->asArray()
                ->all();
        }
        if ($list) {
            return ['pengguna' => $user, 'unit_akses' => ArrayHelper::map($unit, 'kode', 'nama')];
        } else {
            return ['pengguna' => $user, 'unit_akses' => ArrayHelper::getColumn($unit, 'kode')];
        }
    }
    public static function getListRJAksesPegawai($list = true, $user = [])
    {
        $unit = array();
        if (!$user) {
            $user = self::getUserLogin();
        }
        $unit = KelompokUnitLayanan::find()->select([KelompokUnitLayanan::tableName() . '.unit_id', DmUnitPenempatan::tableName() . '.kode', DmUnitPenempatan::tableName() . '.nama',])->joinWith(['unit'])->kel_rj_all()
            ->orderBy([DmUnitPenempatan::tableName() . '.nama' => SORT_ASC])
            ->asArray()
            ->all();

        if ($list) {
            return ['pengguna' => $user, 'unit_akses' => ArrayHelper::map($unit, 'kode', 'nama')];
        } else {
            return ['pengguna' => $user, 'unit_akses' => ArrayHelper::getColumn($unit, 'kode')];
        }
    }
    public static function getListRIAksesPegawai($list = true, $user = [])
    {
        $unit = array();
        if (!$user) {
            $user = self::getUserLogin();
        }
        if (strtoupper($user['akses_level']) == self::LEVEL_ROOT || strtoupper($user['akses_level']) == self::LEVEL_ADMIN) {
            $unit = KelompokUnitLayanan::find()->select([KelompokUnitLayanan::tableName() . '.unit_id', DmUnitPenempatan::tableName() . '.kode', DmUnitPenempatan::tableName() . '.nama',])->joinWith(['unit'])->kel_ri()
                ->orderBy([DmUnitPenempatan::tableName() . '.nama' => SORT_ASC])
                ->asArray()
                ->all();
        } else if (strtoupper($user['akses_level']) == self::LEVEL_PERAWAT  || strtoupper($user['akses_level']) == self::LEVEL_BIDAN) {
            $unit = KelompokUnitLayanan::find()->select([KelompokUnitLayanan::tableName() . '.unit_id', DmUnitPenempatan::tableName() . '.kode', DmUnitPenempatan::tableName() . '.nama',])->joinWith(['unit'])->kel_ri()
                ->andWhere(KelompokUnitLayanan::tableName() . '.unit_id IN (' . implode(',', self::getUnitPenempatanPegawai($user['pegawai_id'], false, false)) . ')')
                ->orderBy([DmUnitPenempatan::tableName() . '.nama' => SORT_ASC])
                ->asArray()
                ->all();
        }
        //     $unit = self::getUnitPenempatanPegawai($user['pegawai_id'],true);
        if ($list) {
            return ['pengguna' => $user, 'unit_akses' => ArrayHelper::map($unit, 'kode', 'nama')];
        } else {
            return ['pengguna' => $user, 'unit_akses' => ArrayHelper::getColumn($unit, 'kode')];
        }
    }
    public static function getListRuangan($list = true, $user = [])
    {
        $unit = array();
        if (!$user) {
            $user = self::getUserLogin();
        }
        $unit = KelompokUnitLayanan::find()->select([KelompokUnitLayanan::tableName() . '.unit_id', DmUnitPenempatan::tableName() . '.kode', DmUnitPenempatan::tableName() . '.nama',])->joinWith(['unit'])->kel_ri()
            ->orderBy([DmUnitPenempatan::tableName() . '.nama' => SORT_ASC])
            ->asArray()
            ->all();

        if ($list) {
            return ['pengguna' => $user, 'unit_akses' => ArrayHelper::map($unit, 'kode', 'nama')];
        } else {
            return ['pengguna' => $user, 'unit_akses' => ArrayHelper::getColumn($unit, 'kode')];
        }
    }

    public static function getListRIAksesPegawaiMpp($list = true, $user = [])
    {
        $unit = array();
        if (!$user) {
            $user = self::getUserLogin();
        }
        if (strtoupper($user['akses_level']) == self::LEVEL_ROOT || strtoupper($user['akses_level']) == self::LEVEL_ADMIN) {
            $unit = KelompokUnitLayanan::find()->select([KelompokUnitLayanan::tableName() . '.unit_id', DmUnitPenempatan::tableName() . '.kode', DmUnitPenempatan::tableName() . '.nama',])->joinWith(['unit'])->kel_ri()
                ->orderBy([DmUnitPenempatan::tableName() . '.nama' => SORT_ASC])
                ->asArray()
                ->all();
        } else if (strtoupper($user['akses_level']) == self::LEVEL_PERAWAT  || strtoupper($user['akses_level']) == self::LEVEL_BIDAN) {
            $unit = DmUnitPenempatan::find()->where(['in', DmUnitPenempatan::tableName() . '.kode', self::isMppUnit()])->asArray()->all();
        }
        //     $unit = self::getUnitPenempatanPegawai($user['pegawai_id'],true);
        if ($list) {
            return ['pengguna' => $user, 'unit_akses' => ArrayHelper::map($unit, 'kode', 'nama')];
        } else {
            return ['pengguna' => $user, 'unit_akses' => ArrayHelper::getColumn($unit, 'kode')];
        }
    }

    public static function getListRIAksesPegawaiMppNew($list = true, $user = [])
    {
        $unit = array();
        if (!$user) {
            $user = self::getUserLogin();
        }
        if (!empty(HelperSpesialClass::isMppUnit())) {
            $unit = self::isMppUnit();
        } else {
            $unit = ['0'];
        }
        $unit = DmUnitPenempatan::find()->where(['in', DmUnitPenempatan::tableName() . '.kode', $unit])->asArray()->all();
        //     $unit = self::getUnitPenempatanPegawai($user['pegawai_id'],true);
        if ($list) {
            return ['pengguna' => $user, 'unit_akses' => ArrayHelper::map($unit, 'kode', 'nama')];
        } else {
            return ['pengguna' => $user, 'unit_akses' => ArrayHelper::getColumn($unit, 'kode')];
        }
    }
    public static function getListPenunjangAksesPegawai($list = true, $user = [])
    {
        $unit = array();
        if (!$user) {
            $user = self::getUserLogin();
        }
        if (strtoupper($user['akses_level']) == self::LEVEL_ROOT || strtoupper($user['akses_level']) == self::LEVEL_ADMIN) {
            $unit = KelompokUnitLayanan::find()->select([KelompokUnitLayanan::tableName() . '.unit_id', DmUnitPenempatan::tableName() . '.kode', DmUnitPenempatan::tableName() . '.nama',])->joinWith(['unit'])->kel_penunjang()
                ->orderBy([DmUnitPenempatan::tableName() . '.nama' => SORT_ASC])
                ->asArray()
                ->all();
        } else if (strtoupper($user['akses_level']) == self::LEVEL_PERAWAT  || strtoupper($user['akses_level']) == self::LEVEL_BIDAN) {
            $unit = KelompokUnitLayanan::find()->select([KelompokUnitLayanan::tableName() . '.unit_id', DmUnitPenempatan::tableName() . '.kode', DmUnitPenempatan::tableName() . '.nama',])->joinWith(['unit'])->kel_penunjang()
                ->andWhere(KelompokUnitLayanan::tableName() . '.unit_id IN (' . implode(',', self::getUnitPenempatanPegawai($user['pegawai_id'], false, false)) . ')')
                ->orderBy([DmUnitPenempatan::tableName() . '.nama' => SORT_ASC])
                ->asArray()
                ->all();
        }
        if ($list) {
            return ['pengguna' => $user, 'unit_akses' => ArrayHelper::map($unit, 'kode', 'nama')];
        } else {
            return ['pengguna' => $user, 'unit_akses' => ArrayHelper::getColumn($unit, 'kode')];
        }
    }
    public static function getListUnitLayanan($type, $original = true, $list = false)
    {
        $unit = array();
        if ($type == KelompokUnitLayanan::RJ) {
            $unit = KelompokUnitLayanan::find()->select([KelompokUnitLayanan::tableName() . '.unit_id', DmUnitPenempatan::tableName() . '.kode', DmUnitPenempatan::tableName() . '.nama',])->joinWith(['unit'])->kel_rj()
                ->orderBy([DmUnitPenempatan::tableName() . '.nama' => SORT_ASC])
                ->asArray()
                ->all();
        } else if ($type == KelompokUnitLayanan::RI) {
            $unit = KelompokUnitLayanan::find()->select([KelompokUnitLayanan::tableName() . '.unit_id', DmUnitPenempatan::tableName() . '.kode', DmUnitPenempatan::tableName() . '.nama',])->joinWith(['unit'])->kel_ri()
                ->orderBy([DmUnitPenempatan::tableName() . '.nama' => SORT_ASC])
                ->asArray()
                ->all();
        } else if ($type == KelompokUnitLayanan::IGD) {
            $unit = KelompokUnitLayanan::find()->select([KelompokUnitLayanan::tableName() . '.unit_id', DmUnitPenempatan::tableName() . '.kode', DmUnitPenempatan::tableName() . '.nama',])->joinWith(['unit'])->kel_igd()
                ->orderBy([DmUnitPenempatan::tableName() . '.nama' => SORT_ASC])
                ->asArray()
                ->all();
        } else if ($type == KelompokUnitLayanan::PENUNJANG) {
            $unit = KelompokUnitLayanan::find()->select([KelompokUnitLayanan::tableName() . '.unit_id', DmUnitPenempatan::tableName() . '.kode', DmUnitPenempatan::tableName() . '.nama',])->joinWith(['unit'])->kel_penunjang()
                ->orderBy([DmUnitPenempatan::tableName() . '.nama' => SORT_ASC])
                ->asArray()
                ->all();
        }
        if ($original) {
            return $unit;
        } else {
            if ($list) {
                return ArrayHelper::map($unit, 'unit_id', 'nama');
            } else {
                return ArrayHelper::getColumn($unit, 'unit_id');
            }
        }
    }

    public static function getListUnitAnalisa()
    {
        $unit = array();

        $unit = KelompokUnitLayanan::find()->select([KelompokUnitLayanan::tableName() . '.unit_id', DmUnitPenempatan::tableName() . '.kode', DmUnitPenempatan::tableName() . '.nama',])->joinWith(['unit'])->kel_analisa()
            ->orderBy([DmUnitPenempatan::tableName() . '.nama' => SORT_ASC])
            ->asArray()
            ->all();

        return ArrayHelper::map($unit, 'unit_id', 'nama');
    }
    public static function getListUnitRawatInapAnalisa()
    {
        $unit = array();

        $unit = KelompokUnitLayanan::find()->select([KelompokUnitLayanan::tableName() . '.unit_id', DmUnitPenempatan::tableName() . '.kode', DmUnitPenempatan::tableName() . '.nama',])->joinWith(['unit'])->kel_ri()
            ->orderBy([DmUnitPenempatan::tableName() . '.nama' => SORT_ASC])
            ->asArray()
            ->all();

        return ArrayHelper::map($unit, 'unit_id', 'nama');
    }
    public static function getListUnitIgdAnalisa()
    {
        $unit = array();

        $unit = KelompokUnitLayanan::find()->select([KelompokUnitLayanan::tableName() . '.unit_id', DmUnitPenempatan::tableName() . '.kode', DmUnitPenempatan::tableName() . '.nama',])->joinWith(['unit'])->kel_igd()
            ->orderBy([DmUnitPenempatan::tableName() . '.nama' => SORT_ASC])
            ->asArray()
            ->all();

        return ArrayHelper::map($unit, 'unit_id', 'nama');
    }
    public static function getListUnitRawatJalanAnalisa()
    {
        $unit = array();

        $unit = KelompokUnitLayanan::find()->select([KelompokUnitLayanan::tableName() . '.unit_id', DmUnitPenempatan::tableName() . '.kode', DmUnitPenempatan::tableName() . '.nama',])->joinWith(['unit'])->kel_rj()
            ->orderBy([DmUnitPenempatan::tableName() . '.nama' => SORT_ASC])
            ->asArray()
            ->all();

        return ArrayHelper::map($unit, 'unit_id', 'nama');
    }
    public static function getUserLogin()
    {
        $login = Yii::$app->user->identity;
        $akun = $login->akun;
        $level = null;
        $pesannoakses = null;
        $akses = true;
        if (strtoupper($login->roles) == 'MEDIS') {
            if (in_array($login['idData'], self::getListDokter(false))) {
                $level = self::LEVEL_DOKTER;
            } else {
                $akses = false;
                // $pesannoakses='SIP / SP KLINIS TIDAK TERSEDIA/TIDAK BERLAKU';
                $pesannoakses = 'PEGAWAI BUKAN RUMPUN MEDIS';
            }
        } else if (strtoupper($login->roles) == 'KEPERAWATAN') {
            if (in_array($login['idData'], self::getListPerawat(false))) {
                $level = self::LEVEL_PERAWAT;
            } else {
                $akses = false;
                // $pesannoakses='STR / SIP/ SP KLINIS TIDAK TERSEDIA/TIDAK BERLAKU';
                $pesannoakses = 'PEGAWAI BUKAN RUMPUN KEPERAWATAN';
            }
        } else if (strtoupper($login->roles) == 'KEBIDANAN') {
            if (in_array($login['idData'], self::getListBidan(false))) {
                $level = self::LEVEL_BIDAN;
            } else {
                $akses = false;
                // $pesannoakses='STR / SIP/ SP KLINIS TIDAK TERSEDIA/TIDAK BERLAKU';
                $pesannoakses = 'PEGAWAI BUKAN RUMPUN KEPERAWATAN';
            }
        } else if (strtoupper($login->roles) == 'ROOT' && in_array($akun->username, Yii::$app->params['other']['username_allow_root'])) {
            $level = self::LEVEL_ROOT;
        } else if (strtoupper($login->roles) == 'ROOT' && in_array($akun->username, Yii::$app->params['other']['username_allow_admin'])) {
            $level = self::LEVEL_ADMIN;
        } else if (strtoupper($login->roles) == 'NONMEDIS') {
            $level = self::LEVEL_ADM;
        }
        return [
            'akses' => $akses,
            'pesannoakses' => $pesannoakses,
            'user_id' => $login['id'],
            'username' => $akun->username,
            'pegawai_id' => $login['idData'],
            'nama' => self::getNamaPegawai($akun->pegawai),
            'akses_level' => $level
        ];
    }
    public static function isRoot($user = [])
    {
        if (!$user) {
            $user = self::getUserLogin();
        }
        if (strtoupper($user['akses_level']) === self::LEVEL_ROOT) {
            return $user;
        }
        return [];
    }
    // public static function isAdmin(){
    //     if(!$user){
    //         $user=self::getUserLogin($user=[]);
    //     }
    //     if(strtoupper($user['akses_level'])===self::LEVEL_ADMIN){
    //         return $user;
    //     }
    //     return [];
    // }
    public static function isPerawat($user = [])
    {
        if (!$user) {
            $user = self::getUserLogin();
        }
        if (strtoupper($user['akses_level']) === self::LEVEL_PERAWAT) {
            return $user;
        }
        return [];
    }
    public static function isDokter($user = [])
    {
        if (!$user) {
            $user = self::getUserLogin();
        }
        if (strtoupper($user['akses_level']) === self::LEVEL_DOKTER) {
            return $user;
        }
        return [];
    }
    public static function isAdm($user = [])
    {
        if (!$user) {
            $user = self::getUserLogin();
        }
        if (strtoupper($user['akses_level']) === self::LEVEL_ADM) {
            return $user;
        }
        return [];
    }
    public static function getCheckPasien($id)
    {
        // $id => layanan_id
        // $layanan=array();
        if (!is_numeric($id)) {
            $id = HelperGeneralClass::validateData($id);
        }
        if (!$id) {
            return Api::writeResponse(false, 'Pasien Tidak Valid, Mohon Pilih Lagi');
        }
        $registrasi = Registrasi::find()->joinWith([
            'layanan',
            'layanan.unit',
            'pasien',
            'debiturDetail',
            'pjpRi.pegawai',
            'layanan.pjp.pegawai',
        ])->where([Registrasi::tableName() . '.kode' => $id])->asArray()->one();
        if (!$registrasi) {
            return Api::writeResponse(false, 'Pasien Tidak Valid, Mohon Pilih Lagi');
        }
        return Api::writeResponse(true, null, $registrasi);
    }
    public static function getCheckRegistrasiPasien($id)
    {
        if (!is_numeric($id)) {
            $id = HelperGeneralClass::validateData($id);
        }
        if (!$id) {
            return Api::writeResponse(false, 'Pasien Tidak Valid, Mohon Pilih Lagi');
        }

        $registrasi = Registrasi::find()->joinWith([
            'layanan',
            'layanan.unit',
            'pasien',
            'debiturDetail',
            'pjpRi.pegawai',
            'layanan.pjp.pegawai',
        ])->where([Registrasi::tableName() . '.kode' => $id])->asArray()->one();
        if (!$registrasi) {
            return Api::writeResponse(false, 'Pasien Tidak Valid, Mohon Pilih Lagi');
        }
        return Api::writeResponse(true, null, $registrasi);
    }
    public static function getCheckObjectPasien($id)
    {
        // $id => layanan_id
        // $layanan=array();

        $registrasi = Registrasi::find()->joinWith([
            'layanan',
            'layanan.unit',
            'pasien',
            'debiturDetail',
            'pjpRi.pegawai',
            'layanan.pjp.pegawai',
        ])->where([Pasien::tableName() . '.kode' => $id])->asArray()->one();
        if (!$registrasi) {
            return Api::writeResponse(false, 'Pasien Tidak Valid, Mohon Pilih Lagi');
        }
        return Api::writeResponse(true, null, $registrasi);
    }
    public static function getCheckObjectPasienAll($id)
    {
        // $id => layanan_id
        // $layanan=array();

        $registrasi = Registrasi::find()->joinWith([
            'layanan',
            'layanan.unit',
            'pasien',
            'debiturDetail',
            'pjpRi.pegawai',
            'layanan.pjp.pegawai',
        ])->where([Pasien::tableName() . '.kode' => $id])->asArray()->all();
        if (!$registrasi) {
            return Api::writeResponse(false, 'Pasien Tidak Valid, Mohon Pilih Lagi');
        }
        return Api::writeResponse(true, null, $registrasi);
    }

    public static function getCheckKetenagaan($id)
    {

        if (!is_numeric($id)) {
            $id = HelperGeneralClass::validateData($id);
        }
        if (!$id) {
            return Api::writeResponse(false, 'Pasien Tidak Valid, Mohon Pilih Lagi');
        }
        $registrasi = Ketenagaan::find()->where(['ketenagaan_id' => $id])->asArray()->all();
        if (!$registrasi) {
            return Api::writeResponse(false, 'Pasien Tidak Valid, Mohon Pilih Lagi');
        }
        return Api::writeResponse(true, null, $registrasi);
    }

    public static function getCheckDocClinical($id)
    {
        // $id => layanan_id
        // $layanan=array();
        if (!is_numeric($id)) {
            $id = HelperGeneralClass::validateData($id);
        }
        if (!$id) {
            return Api::writeResponse(false, 'Pasien Tidak Valid, Mohon Pilih Lagi');
        }
        $docClinicalList = DocClinicalPasien::find()->joinWith([
            'itemDocClinical',
        ])->where([DocClinicalPasien::tableName() . '.reg_kode' => $id])->asArray()->all();
        if (!$docClinicalList) {
            return Api::writeResponse(false, 'Pasien Tidak Valid, Mohon Pilih Lagi');
        }
        return Api::writeResponse(true, null, $docClinicalList);
    }

    public static function getListLabor($id)
    {

        if (!is_numeric($id)) {
            $id = HelperGeneralClass::validateData($id);
        }
        if (!$id) {
            return Api::writeResponse(false, 'Pasien Tidak Valid, Mohon Pilih Lagi');
        }
        $db = Yii::$app->db_perantara_lis;
        $listLabor = LISORDER::find()->select([
            'ID',
            'PID',
            'APID',
            'ONO',
            'PNAME',
            'SOURCE',
            'CLINICIAN',
            "CAST(Convert(CHAR(8),REQUEST_DT,112) as DATETIME) AS REQUEST_DT"
        ])->where([
            'APID' => $id
        ])->orderBy(['REQUEST_DT' => SORT_DESC])->asArray()->all();
        if (!$listLabor) {
            return Api::writeResponse(false, 'Registrasi Tidak Valid, Mohon Pilih Lagi');
        }
        return Api::writeResponse(true, null, $listLabor);
    }

    public static function getListRadiologi($id)
    {

        if (!is_numeric($id)) {
            $id = HelperGeneralClass::validateData($id);
        }
        if (!$id) {
            return Api::writeResponse(false, 'Registrasi Tidak Valid, Mohon Pilih Lagi');
        }
        $db = Yii::$app->db_perantara_lis;
        $listRadiologi = ResultPacs::find()->alias('rp')->select([
            'rp.id_pacsorder',
            'rp.report_description',
            'rp.nomor_pasien',
            'rp.nomor_registrasi',
            'p.nama AS pasien_nama',
            'p.jkel',
            'pl.nama AS pasien_luar_nama',
            'pl.jkel AS pasien_luar_jkel',
            "rp.nomor_transaksi",
            'rp.kode_jenis',
            'rp.nama_tindakan',
            'rp.unit_asal_nama',
            'rp.dokter_asal_nama',
            'rp.dokter_nama',
            'rp.tanggal_masuk',
            'rp.link',
            'rp.order_date',
            'rp.dokter_name'
        ])
            ->innerJoin('pendaftaran.pasien p', 'p.kode=rp.nomor_pasien')
            ->leftJoin('pendaftaran.registrasi r', 'r.kode=rp.nomor_registrasi')
            ->leftJoin('pendaftaran.pasien_luar pl', 'pl.registrasi_kode=r.kode')
            ->where(['rp.nomor_registrasi' => $id])->asArray()->all();
        if (!$listRadiologi) {
            return Api::writeResponse(false, 'Data Tidak Valid, Mohon Pilih Lagi');
        }
        return Api::writeResponse(true, null, $listRadiologi);
    }

    public static function getListPatologiAnatomi($id)
    {

        if (!is_numeric($id)) {
            $id = HelperGeneralClass::validateData($id);
        }
        if (!$id) {
            return Api::writeResponse(false, 'Registrasi Tidak Valid, Mohon Pilih Lagi');
        }
        $db = Yii::$app->db_perantara_lis;
        $listPatologiAnatomi = HasilPemeriksaan::find()->alias('hp')->select([
            'hp.id',
            'hp.tarif_tindakan_pasien_id',
            'upa.nama as unitAsal',
            'lpo.tgl_pemeriksaan',
            't.deskripsi',
            'hp.is_save',
            "coalesce(concat(dok.gelar_sarjana_depan, ' ') , '') || coalesce(dok.nama_lengkap, '') || coalesce(concat(' ', dok.gelar_sarjana_belakang), '') as dokterNama",
            "coalesce(concat(dok2.gelar_sarjana_depan, ' ') , '') || coalesce(dok2.nama_lengkap, '') || coalesce(concat(' ', dok2.gelar_sarjana_belakang), '') as dokterPAnama"
        ])
            ->leftJoin('pendaftaran.layanan lp', 'lp.id=hp.layanan_id_penunjang')
            ->leftJoin('pendaftaran.registrasi r', 'r.kode=lp.registrasi_kode')
            ->leftJoin('medis.lab_pa_order lpo', 'lpo.layanan_id_penunjang=hp.layanan_id_penunjang')
            ->leftJoin('pegawai.tb_pegawai dok', 'dok.pegawai_id=lpo.dokter_id')
            ->leftJoin('pegawai.tb_pegawai dok2', 'dok.pegawai_id=hp.dokter_pemeriksa')
            ->leftJoin('pegawai.dm_unit_penempatan upa', 'upa.kode=lp.unit_asal_kode')
            ->leftJoin('medis.tarif_tindakan tt', 'tt.id=hp.tarif_tindakan_pasien_id')
            ->leftJoin('medis.tindakan t', 't.id=tt.tindakan_id')
            ->where(['r.kode' => $id])
            ->asArray()->all();
        if (!$listPatologiAnatomi) {
            return Api::writeResponse(false, 'Data Tidak Valid, Mohon Pilih Lagi');
        }
        return Api::writeResponse(true, null, $listPatologiAnatomi);
    }

    public static function getListLaporanOperasi($id)
    {

        if (!is_numeric($id)) {
            $id = HelperGeneralClass::validateData($id);
        }
        if (!$id) {
            return Api::writeResponse(false, 'Registrasi Tidak Valid, Mohon Pilih Lagi');
        }
        $db = Yii::$app->db_perantara_lis;
        $listPatologiAnatomi = HasilPemeriksaan::find()->alias('hp')->select([
            'hp.id',
            'hp.tarif_tindakan_pasien_id',
            'upa.nama as unitAsal',
            'lpo.tgl_pemeriksaan',
            't.deskripsi',
            'hp.is_save',
            "coalesce(concat(dok.gelar_sarjana_depan, ' ') , '') || coalesce(dok.nama_lengkap, '') || coalesce(concat(' ', dok.gelar_sarjana_belakang), '') as dokterNama",
            "coalesce(concat(dok2.gelar_sarjana_depan, ' ') , '') || coalesce(dok2.nama_lengkap, '') || coalesce(concat(' ', dok2.gelar_sarjana_belakang), '') as dokterPAnama"
        ])
            ->leftJoin('pendaftaran.layanan lp', 'lp.id=hp.layanan_id_penunjang')
            ->leftJoin('pendaftaran.registrasi r', 'r.kode=lp.registrasi_kode')
            ->leftJoin('medis.lab_pa_order lpo', 'lpo.layanan_id_penunjang=hp.layanan_id_penunjang')
            ->leftJoin('pegawai.tb_pegawai dok', 'dok.pegawai_id=lpo.dokter_id')
            ->leftJoin('pegawai.tb_pegawai dok2', 'dok.pegawai_id=hp.dokter_pemeriksa')
            ->leftJoin('pegawai.dm_unit_penempatan upa', 'upa.kode=lp.unit_asal_kode')
            ->leftJoin('medis.tarif_tindakan tt', 'tt.id=hp.tarif_tindakan_pasien_id')
            ->leftJoin('medis.tindakan t', 't.id=tt.tindakan_id')
            ->where(['r.kode' => $id])
            ->asArray()->all();
        if (!$listPatologiAnatomi) {
            return Api::writeResponse(false, 'Data Tidak Valid, Mohon Pilih Lagi');
        }
        return Api::writeResponse(true, null, $listPatologiAnatomi);
    }

    public static function getPreviewDocClinical($id)
    {
        // $id => layanan_id
        // $layanan=array();
        if (!is_numeric($id)) {
            $id = HelperGeneralClass::validateData($id);
        }
        if (!$id) {
            return Api::writeResponse(false, 'Pasien Tidak Valid, Mohon Pilih Lagi');
        }
        $docClinicalPasien = DocClinicalPasien::find()->where(['id_doc_clinical_pasien' => $id])->asArray()->one();
        $docClinicalPasien['data'] = base64_decode($docClinicalPasien['data']);
        if (!$docClinicalPasien) {
            return Api::writeResponse(false, 'Pasien Tidak Valid, Mohon Pilih Lagi');
        }
        return Api::writeResponse(true, null, $id);
    }
    public static function getHitungBiayaTindakan($data, $object = true)
    {
        if ($object) {
            return
                [
                    'standar' => intval($data->js_adm) + intval($data->js_sarana) + intval($data->js_bhp) + intval($data->js_dokter_operator) + intval($data->js_dokter_lainya) + intval($data->js_dokter_anastesi) + intval($data->js_penata_anastesi) + intval($data->js_paramedis) + intval($data->js_lainya),
                    'cyto' => intval($data->js_adm_cto) + intval($data->js_sarana_cto) + intval($data->js_bhp_cto) + intval($data->js_dokter_operator_cto) + intval($data->js_dokter_lainya_cto) + intval($data->js_dokter_anastesi_cto) + intval($data->js_penata_anastesi_cto) + intval($data->js_paramedis_cto) + intval($data->js_lainya_cto)
                ];
        } else {
            return
                [
                    'standar' => intval($data['js_adm']) + intval($data['js_sarana']) + intval($data['js_bhp']) + intval($data['js_dokter_operator']) + intval($data['js_dokter_lainya']) + intval($data['js_dokter_anastesi']) + intval($data['js_penata_anastesi']) + intval($data['js_paramedis']) + intval($data['js_lainya']),
                    'cyto' => intval($data['js_adm_cto']) + intval($data['js_sarana_cto']) + intval($data['js_bhp_cto']) + intval($data['js_dokter_operator_cto']) + intval($data['js_dokter_lainya_cto']) + intval($data['js_dokter_anastesi_cto']) + intval($data['js_penata_anastesi_cto']) + intval($data['js_paramedis_cto']) + intval($data['js_lainya_cto'])
                ];
        }
    }
    public static function isPjpDokterRi($layanan, $user)
    {
        if ($layanan['registrasi']['pjpRi']) {
            foreach ($layanan['registrasi']['pjpRi'] as $val) {
                if ($val['pegawai_id'] == $user['pegawai_id']) {
                    return true;
                    break;
                }
            }
        }
        return false;
    }
    public static function isPjpUtamaDokterRi($layanan, $user)
    {
        if ($layanan['registrasi']['pjpRi']) {
            foreach ($layanan['registrasi']['pjpRi'] as $val) {
                if ($val['pegawai_id'] == $user['pegawai_id'] && $val['status'] == PjpRi::DPJP) {
                    return true;
                    break;
                }
            }
        }
        return false;
    }
    public static function isPjpPendukungDokterRi($layanan, $user)
    {
        if ($layanan['registrasi']['pjpRi']) {
            foreach ($layanan['registrasi']['pjpRi'] as $val) {
                if ($val['pegawai_id'] == $user['pegawai_id'] && $val['status'] == PjpRi::DPJP_PENDUKUNG) {
                    return true;
                    break;
                }
            }
        }
        return false;
    }
    public static function isPjpDokterRjIgd($layanan, $user)
    {
        if ($layanan['pjp']) {
            foreach ($layanan['pjp'] as $val) {
                if ($val['pegawai_id'] == $user['pegawai_id']) {
                    return true;
                    break;
                }
            }
        }
        return false;
    }
    public static function isPjpUtamaDokterRjIgd($layanan, $user)
    {
        if ($layanan['pjp']) {
            foreach ($layanan['pjp'] as $val) {
                if ($val['pegawai_id'] == $user['pegawai_id'] && $val['status'] == Pjp::DPJP) {
                    return true;
                    break;
                }
            }
        }
        return false;
    }
    public static function isPjpPendukungDokterRjIgd($layanan, $user)
    {
        if ($layanan['pjp']) {
            foreach ($layanan['pjp'] as $val) {
                if ($val['pegawai_id'] == $user['pegawai_id'] && $val['status'] == Pjp::DPJP_PENDUKUNG) {
                    return true;
                    break;
                }
            }
        }
        return false;
    }
    public static function isPjpPerawatRi($layanan, $user)
    {
        if ($layanan['registrasi']['pjpRi']) {
            foreach ($layanan['registrasi']['pjpRi'] as $val) {
                if ($val['pegawai_id'] == $user['pegawai_id'] && ($val['status'] == PjpRi::PPJP || $val['status'] == PjpRi::BPJP)) {
                    return true;
                    break;
                }
            }
        }
        return false;
    }
    public static function isPjpPerawatRjIgd($layanan, $user)
    {
        if ($layanan['pjp']) {
            foreach ($layanan['pjp'] as $val) {
                if ($val['pegawai_id'] == $user['pegawai_id'] && ($val['status'] == Pjp::PPJP  || $val['status'] == Pjp::BPJP)) {
                    return true;
                    break;
                }
            }
        }
        return false;
    }

    static function getKualifikasiPendidikan($p)
    {
        if (!empty($p)) {
            $data = \Yii::$app->db->createCommand("WITH RECURSIVE rec_tindakan AS (
            SELECT a.id, a.parent_id, a.uraian,
                   a.uraian AS rumpun
            FROM " . KualifikasiPendidikan::tableName() . " as a
            WHERE a.parent_id=0
         UNION ALL
            SELECT b.id, b.parent_id, b.uraian, CONCAT(rec_tindakan.rumpun, ' >> ', b.uraian)
            FROM " . KualifikasiPendidikan::tableName() . " as b
               JOIN rec_tindakan ON b.parent_id = rec_tindakan.id
      )
      SELECT * FROM rec_tindakan where id =$p")->queryOne();

            return $data['id'] = $data['rumpun'];
        } else {
            return $data['id'] = '';
        }
    }

    static function isDokterVerifikator()
    {
        //echo "<pre>"; print_r(array_keys(Yii::$app->params['mpp'])); exit;
        $user = Yii::$app->user->identity;
        if ($user != NULL) {
            $key = array_keys(Yii::$app->params['dokter_verifikator']);
            if (in_array($user->idProfil, $key)) {
                return true;
            }
        }
        return false;
        //echo "<pre>"; print_r($user); exit;
    }

    static function isCoder()
    {
        //echo "<pre>"; print_r(array_keys(Yii::$app->params['mpp'])); exit;
        $user = Yii::$app->user->identity;
        if ($user != NULL) {
            $key = array_keys(Yii::$app->params['coder']);
            if (in_array($user->idProfil, $key)) {
                return true;
            }
        }
        return false;
        //echo "<pre>"; print_r($user); exit;
    }

    static function isAksesDaftarPasien()
    {
        //echo "<pre>"; print_r(array_keys(Yii::$app->params['mpp'])); exit;
        $user = Yii::$app->user->identity;
        if ($user != NULL) {
            $key = array_keys(Yii::$app->params['akses-daftar-pasien']);
            if (in_array($user->idProfil, $key)) {
                return true;
            }
        }
        return false;
        //echo "<pre>"; print_r($user); exit;
    }

    static function isProgrammer()
    {
        //echo "<pre>"; print_r(array_keys(Yii::$app->params['mpp'])); exit;
        $user = Yii::$app->user->identity;
        if ($user != NULL) {
            $key = array_keys(Yii::$app->params['programmer']);
            if (in_array($user->idProfil, $key)) {
                return true;
            }
        }
        return false;
        //echo "<pre>"; print_r($user); exit;
    }

    static function isMpp()
    {
        //echo "<pre>"; print_r(array_keys(Yii::$app->params['mpp'])); exit;
        $user = Yii::$app->user->identity;
        if ($user != NULL) {
            $key = array_keys(Yii::$app->params['mpp']);
            if (in_array($user->idProfil, $key)) {
                return true;
            }
        }
        return false;
        //echo "<pre>"; print_r($user); exit;
    }

    static function isCasemixRj()
    {
        //echo "<pre>"; print_r(array_keys(Yii::$app->params['mpp'])); exit;
        $user = Yii::$app->user->identity;
        if ($user != NULL) {
            $key = array_keys(Yii::$app->params['casemix-rj']);
            if (in_array($user->idProfil, $key)) {
                return true;
            }
        }
        return false;
        //echo "<pre>"; print_r($user); exit;
    }

    static function isCasemix()
    {
        //echo "<pre>"; print_r(array_keys(Yii::$app->params['mpp'])); exit;
        $user = Yii::$app->user->identity;
        if ($user != NULL) {
            $key = array_keys(Yii::$app->params['casemix']);
            if (in_array($user->idProfil, $key)) {
                return true;
            }
        }
        return false;
        //echo "<pre>"; print_r($user); exit;
    }

    static function isPengolahanData()
    {
        //echo "<pre>"; print_r(array_keys(Yii::$app->params['mpp'])); exit;
        $user = Yii::$app->user->identity;
        if ($user != NULL) {
            $key = array_keys(Yii::$app->params['pengolahan-data']);
            if (in_array($user->idProfil, $key)) {
                return true;
            }
        }
        return false;
        //echo "<pre>"; print_r($user); exit;
    }


    static function isAnalisaDokumen()
    {
        //echo "<pre>"; print_r(array_keys(Yii::$app->params['mpp'])); exit;
        $user = Yii::$app->user->identity;
        if ($user != NULL) {
            $key = array_keys(Yii::$app->params['analisa-dokumen']);
            if (in_array($user->idProfil, $key)) {
                return true;
            }
        }
        return false;
        //echo "<pre>"; print_r($user); exit;
    }

    static function isAnalisaCoder()
    {
        //echo "<pre>"; print_r(array_keys(Yii::$app->params['mpp'])); exit;
        $user = Yii::$app->user->identity;
        if ($user != NULL) {
            $key = array_keys(Yii::$app->params['analisa-coder']);
            if (in_array($user->idProfil, $key)) {
                return true;
            }
        }
        return false;
        //echo "<pre>"; print_r($user); exit;
    }
    static function isMppUnit()
    {
        $user = Yii::$app->user->identity;
        if ($user != null) {
            $key = array_keys(Yii::$app->params['mpp']);
            if (in_array($user->idProfil, $key)) {
                foreach (Yii::$app->params['mpp'] as $value) {
                    if ($value['id'] == $user->idProfil) {
                        return $value['unit'];
                    }
                }
            }
        }
    }

    static function isCoderUser()
    {
        $coderUserIds = [];
        $user = Yii::$app->user->identity;
        if ($user != null) {
            $key = array_keys(Yii::$app->params['coder']);
            // if (in_array($user->idProfil, $key)) {
            foreach (Yii::$app->params['coder'] as $value) {
                $coderUserIds[] = $value['id'];
            }
            foreach (Yii::$app->params['analisa-coder'] as $value) {
                $coderUserIds[] = $value['id'];
            }
            // }
        }
        return $coderUserIds;
    }

    public static function getListCoder($list = true, $user = [])
    {
        $coder = array();
        if (!$user) {
            $user = self::getUserLogin();
        }
        if (!empty(HelperSpesialClass::isCoderUser())) {
            $coder = self::isCoderUser();
        } else {
            $coder = ['0'];
        }
        $coder = TbPegawai::find()->where(['in', TbPegawai::tableName() . '.pegawai_id', $coder])->asArray()->all();
        //     $coder = self::getcoderPenempatanPegawai($user['pegawai_id'],true);
        if ($list) {
            return ArrayHelper::map($coder, 'pegawai_id', 'nama_lengkap');
        } else {
            return ArrayHelper::getColumn($coder, 'pegawai_id');
        }
    }
    public static function generateUniqueToken($length = 10)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $uniqueString = '';

        while (strlen($uniqueString) < $length) {
            $randomChar = $characters[rand(0, $charactersLength - 1)];
            if (strpos($uniqueString, $randomChar) === false) {
                $uniqueString .= $randomChar;
            }
        }

        return $uniqueString;
    }
}
