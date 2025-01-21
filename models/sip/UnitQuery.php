<?php

/*
 * @Author: Dicky Ermawan S., S.T., MTA 
 * @Email: wanasaja@gmail.com 
 * @Web: dickyermawan.github.io 
 * @Linkedin: linkedin.com/in/dickyermawan 
 * @Date: 2020-04-20 00:41:18 
 * @Last Modified by: Dicky Ermawan S., S.T., MTA
 * @Last Modified time: 2021-01-11 15:24:43
 */

namespace app\models\sip;

use yii\helpers\ArrayHelper;
use yii\httpclient\Client;


/**
 * This is the ActiveQuery class for [[\app\models\pegawai\Unit]].
 *
 * @see \app\models\pegawai\Unit
 */
class UnitQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\pegawai\Unit[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\pegawai\Unit|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function idGudang()
    {
        // return array_key_first($this->select2GudangUtama());
        return 103;
    }

    public function select2()
    {
        // $result = $this->orderBy(['nama_unit' => SORT_ASC])->all();
        // return ArrayHelper::map($result, 'id_unit', 'nama_unit');

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('http://sip.simrs.aa/api/farmasi')
            ->setData([
                'token' => 'datafarmasi2020',
                'jenis' => 'semua'
            ])
            ->send();
        if ($response->isOk) {
            return $response->data;
        }
    }

    public function select2Ruangan()
    {
        // $result = $this
        //     ->where(['=', 'is_gudang', false])
        //     ->orderBy(['nama_unit' => SORT_ASC])
        //     ->all();
        // return ArrayHelper::map($result, 'id_unit', 'nama_unit');

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('http://sip.simrs.aa/api/farmasi')
            ->setData([
                'token' => 'datafarmasi2020',
                'jenis' => 'ruangan'
            ])
            ->send();
        if ($response->isOk) {
            return $response->data;
        }
    }

    public function select2GudangUtama()
    {
        // $result = $this->where(['=', 'is_gudang', true])
        //     ->andWhere(['=', 'is_gudang_utama', true])
        //     ->orderBy(['nama_unit' => SORT_ASC])
        //     ->all();
        // return ArrayHelper::map($result, 'id_unit', 'nama_unit');

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('http://sip.simrs.aa/api/farmasi')
            ->setData([
                'token' => 'datafarmasi2020',
                'jenis' => 'gudang'
            ])
            ->send();
        if ($response->isOk) {
            return $response->data;
        }
    }

    public function select2GudangDepo()
    {
        // $result = $this->where(['=', 'is_gudang', true])
        //     ->orderBy(['nama_unit' => SORT_ASC])
        //     ->all();
        // return ArrayHelper::map($result, 'id_unit', 'nama_unit');

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('http://sip.simrs.aa/api/farmasi')
            ->setData([
                'token' => 'datafarmasi2020',
                'jenis' => 'depo-gudang'
            ])
            ->send();
        if ($response->isOk) {
            return $response->data;
        }
    }

    public function select2Depo()
    {
        $result = $this->where(['=', 'unit_rumpun', 38])
            ->andWhere(['ilike', 'nama', 'depo'])
            ->all();
        return ArrayHelper::map($result, 'kode', 'nama');

        // $client = new Client();
        // $response = $client->createRequest()
        //     ->setMethod('GET')
        //     ->setUrl('http://sip.simrs.aa/api/farmasi')
        //     ->setData([
        //         'token' => 'datafarmasi2020',
        //         'jenis' => 'depo'
        //     ])
        //     ->send();
        // if ($response->isOk) {
        //     return $response->data;
        // }
    }

    public function select2DepoEhos()
    {
        return [
            196 => 'DEPO FARMASI IPI',
            84 => 'DEPO FARMASI IRD',
            97 => 'DEPO FARMASI OK-IBS',
            93 => 'DEPO FARMASI OK-IRD',
            197 => 'DEPO FARMASI RAWAT INAP',
            190 => 'DEPO FARMASI SERUNI',
            188 => 'DEPO FARMASI UTAMA RAWAT JALAN',
        ];
    }
}
