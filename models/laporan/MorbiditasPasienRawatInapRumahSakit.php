<?php

/*
 * @Author: Dicky Ermawan S., S.T., MTA 
 * @Email: wanasaja@gmail.com 
 * @Web: dickyermawan.github.io 
 * @Linkedin: linkedin.com/in/dickyermawan 
 * @Date: 2021-03-08 06:36:35 
 * @Last Modified by: Dicky Ermawan S., S.T., MTA
 * @Last Modified time: 2022-04-08 11:47:16
 */

namespace app\models\laporan;

use yii\base\Model;

class MorbiditasPasienRawatInapRumahSakit extends Model
{
    const JENIS_HARIAN = 'harian';
    const JENIS_BULANAN = 'bulanan';
    const JENIS_TAHUNAN = 'tahunan';

    public $jenis_laporan; // harian, bulanan
    public $tgl_hari;
    public $tgl_bulan;
    public $tgl_tahun;
 

    public function rules()
    {
        return [
            [
                [
                    'jenis_laporan',
                    // 'id_kegiatan',
                ], 'required',
            ],
            [
                ['tgl_hari',], 'required', 'when' => function ($model) {
                    return $model->jenis_laporan == self::JENIS_HARIAN;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#PengadaanBarang_jenis_laporan_0').prop('checked');
                }"
            ],
            [
                ['tgl_bulan',], 'required', 'when' => function ($model) {
                    return $model->jenis_laporan == self::JENIS_BULANAN;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#PengadaanBarang_jenis_laporan_1').prop('checked');
                }"
            ],
            [
                ['tgl_tahun',], 'required', 'when' => function ($model) {
                    return $model->jenis_laporan == self::JENIS_TAHUNAN;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#PengadaanBarang_jenis_laporan_2').prop('checked');
                }"
            ],
            [
                [
                    'id_supplier',
                    'id_kegiatan',
                ], 'safe',
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'jenis_laporan' => 'Jenis Laporan',
            'tgl_hari' => 'Tgl Hari',
            'tgl_bulan' => 'Tgl Bulan',
            'id_supplier' => 'Distributor',
        ];
    }

   
}
