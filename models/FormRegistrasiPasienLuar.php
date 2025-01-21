<?php

/**
 * Created by PhpStorm.
 * User: Salman
 * Date: 18/03/2018
 * Time: 13.20
 */

namespace app\models;

use yii\base\Model;

class FormRegistrasiPasienLuar extends Model
{

    public $NO_PASIEN, $NO_DAFTAR, $NAMA, $ALAMAT, $DESA, $RT, $RW, $KELURAHAN, $KECAMATAN, $KABUPATEN, $KD_POS;
    public $NO_TELP, $NO_HP, $TP_LAHIR, $TGL_LAHIR, $NO_DEBT, $NO_KARTU, $ATASNAMA, $HUBUNGAN, $TGL_DAFTAR, $unitDaftar, $debiturDaftar, $debiturDetailDaftar, $dokterDaftar, $tanggalDaftar;
    public $PEKERJAAN, $JENIS_KEL, $PENDAKH, $AGAMA, $STATUS, $KARTU, $PENJWB, $NAMAPEN, $ALMPEN1, $ALMPEN2, $TELPPEN, $HPPEN, $PHOTO;
    public $NAMAAYAH, $NAMAIBU, $NAMAPASANGAN, $HUBPEN, $RTPEN, $RWPEN, $KODEPOSPEN, $DESAPEN, $KECPEN, $KABPEN;
    public $NOIDENTITAS, $PROPINSI, $PROPPEN, $CREATE_ID, $CREATE_DATE, $MODIFY_ID, $MODIFY_DATE, $NUMURTH, $NUMURBL, $NUMURHR;

    public $dokterPengirim;
    public $diagnosa;
    public $catatan;
    public $noKartu;
    public $atasNama;
    public $alamatDebitur;
    public $kotaDebitur;
    public $hubunganDebitur;
    public $plafonDebitur;

    public $kiriman;
    public $subKiriman;

    public $permintaan;
    public $tgl_pengambilan_spesimen;
    public $tgl_pemeriksaan;
    public $lokalis;
    public $dilakukan_secara;
    public $spesimen_difikasi;

    public function attributeLabels()
    {
        [
            'NO_PASIEN' => \Yii::t('app', 'Nomor Rekam Medis'),
            'NO_DAFTAR' => \Yii::t('app', 'Nomor Daftar'),
            'NAMA' => \Yii::t('app', 'Nama Pasien'),
            'ALAMAT' => \Yii::t('app', 'Alamat'),
            'DESA' => \Yii::t('app', 'Desa'),
            'RT' => \Yii::t('app', 'RT'),
            'RW' => \Yii::t('app', 'RW'),
            'KELURAHAN' => \Yii::t('app', 'Kelurahan/Desa'),
            'KECAMATAN' => \Yii::t('app', 'Kecamatan'),
            'KABUPATEN' => \Yii::t('app', 'Kabupaten/Kota'),
            'KD_POS' => \Yii::t('app', 'Kode Pos'),
            'NO_TELP' => \Yii::t('app', 'Nomor Telepon'),
            'NO_HP' => \Yii::t('app', 'Nomor HP'),
            'TP_LAHIR' => \Yii::t('app', 'Tempat Lahir'),
            'TGL_LAHIR' => \Yii::t('app', 'Tanggal Lahir'),
            'NO_DEBT' => \Yii::t('app', 'Nomor Debitur'),
            'NO_KARTU' => \Yii::t('app', 'Nomor Kartu'),
            'ATASNAMA' => \Yii::t('app', 'Atas Nama'),
            'HUBUNGAN' => \Yii::t('app', 'Hubungan'),
            'TGL_DAFTAR' => \Yii::t('app', 'Tanggal Daftar'),
            'PEKERJAAN' => \Yii::t('app', 'Pekerjaan'),
            'JENIS_KEL' => \Yii::t('app', 'Jenis Kelamin'),
            'PENDAKH' => \Yii::t('app', 'Pendidikan Akhir'),
            'AGAMA' => \Yii::t('app', 'Agama'),
            'STATUS' => \Yii::t('app', 'Status'),
            'KARTU' => \Yii::t('app', 'Kartu'),
            'PENJWB' => 'Penjwb',
            'NAMAPEN' => 'Namapen',
            'ALMPEN1' => 'Almpen1',
            'ALMPEN2' => 'Almpen2',
            'TELPPEN' => 'Telppen',
            'HPPEN' => 'Hppen',
            'PHOTO' => 'Photo',
            'NAMAAYAH' => \Yii::t('app', 'Nama Ayah'),
            'NAMAIBU' => \Yii::t('app', 'Nama Ibu'),
            'NAMAPASANGAN' => \Yii::t('app', 'Nama Suami/Istri'),
            'HUBPEN' => 'Hubpen',
            'RTPEN' => 'Rtpen',
            'RWPEN' => 'Rwpen',
            'KODEPOSPEN' => 'Kodepospen',
            'DESAPEN' => 'Desapen',
            'KECPEN' => 'Kecpen',
            'KABPEN' => 'Kabpen',
            'NOIDENTITAS' => \Yii::t('app', 'Nomor Identitas/KTP'),
            'PROPINSI' => \Yii::t('app', 'Propinsi'),
            'PROPPEN' => 'Proppen',
            'CREATE_ID' => 'Create  ID',
            'CREATE_DATE' => 'Create  Date',
            'MODIFY_ID' => 'Modify  ID',
            'MODIFY_DATE' => 'Modify  Date',
            'NUMURTH' => 'Numurth',
            'NUMURBL' => 'Numurbl',
            'NUMURHR' => 'Numurhr',

            'dokterPengirim' => \Yii::t('app', 'Dokter Pengirim'),
            'diagnosa' => \Yii::t('app', 'Diagnosa'),
            'catatan' => \Yii::t('app', 'catatan'),
            'debiturDaftar' => \Yii::t('app', 'Debitur / Penanggung'),
            'debiturDetailDaftar' => \Yii::t('app', 'Debitur Detail'),
            'dokterDaftar' => \Yii::t('app', 'Dokter'),
            'noKartu' => \Yii::t('app', 'Nomor Kartu'),
            'alamatDebitur' => \Yii::t('app', 'Alamat Debitur'),
            'kotaDebitur' => \Yii::t('app', 'Kota Debitur'),
            'hubunganDebitur' => \Yii::t('app', 'Hubungan Debitur'),

            'plafonDebitur' => \Yii::t('app', 'Plafon Debitur'),
            'unitDaftar' => \Yii::t('app', 'Unit Daftar'),
            'tanggalDaftar' => \Yii::t('app', 'Tanggal Daftar'),

            'kiriman' => \Yii::t('app', 'Kiriman'),
            'subKiriman' => \Yii::t('app', 'Sub Kiriman'),

            'permintaan' => \Yii::t('app', 'Permintaan'),
            'tgl_pengambilan_spesimen' => \Yii::t('app', 'Tanggal Pengambilan Spesimen'),
            'tgl_pemeriksaan' => \Yii::t('app', 'Tanggal Pemeriksaan'),
            'lokalis' => \Yii::t('app', 'Lokalis'),
            'dilakukan_secara' => \Yii::t('app', 'Dilakukan Secara'),
            'spesimen_difikasi' => \Yii::t('app', 'Spesimen Difikasi'),
        ];
    }


    public function rules()
    {
        return [
            [
                ['NAMA', 'TP_LAHIR', 'TGL_LAHIR', 'JENIS_KEL', 'debiturDaftar', 'tanggalDaftar', 'unitDaftar', 'dokterDaftar'], 'required', 'message' => 'Kolom ini Harus Diisi'
            ],
            [
                ['NUMURTH', 'NUMURBL', 'NUMURHR'], 'integer'
            ],
            [
                ['TGL_LAHIR', 'TGL_DAFTAR', 'CREATE_DATE', 'MODIFY_DATE'], 'safe'
            ],
            [
                ['NO_PASIEN', 'NAMA', 'kiriman', 'subKiriman', 'ALAMAT', 'DESA', 'RT', 'RW', 'KELURAHAN', 'KECAMATAN', 'KABUPATEN', 'KD_POS', 'NO_TELP', 'NO_HP', 'TP_LAHIR', 'NO_DEBT', 'NO_KARTU', 'ATASNAMA', 'HUBUNGAN', 'PEKERJAAN', 'JENIS_KEL', 'PENDAKH', 'AGAMA', 'STATUS', 'KARTU', 'PENJWB', 'NAMAPEN', 'ALMPEN1', 'ALMPEN2', 'TELPPEN', 'HPPEN', 'PHOTO', 'NAMAAYAH', 'NAMAIBU', 'NAMAPASANGAN', 'HUBPEN', 'RTPEN', 'RWPEN', 'KODEPOSPEN', 'DESAPEN', 'KECPEN', 'KABPEN', 'NOIDENTITAS', 'PROPINSI', 'PROPPEN', 'CREATE_ID', 'MODIFY_ID', 'debiturDaftar', 'alamatDebitur', 'kotaDebitur', 'hubunganDebitur', 'plafonDebitur', 'unitDaftar', 'dokterDaftar'], 'string'
            ],
            ['noKartu', 'string', 'max' => 20]
        ];
    }
}
