<?php

namespace app\models\medis;

use Yii;
use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;
/**
 * This is the model class for table "medis.asesmen_awal_kebidanan".
 *
 * @property int $id
 * @property int $layanan_id
 * @property int $perawat_id
 * @property string|null $anamnesis_sumber
 * @property string|null $anamnesis_keluhan
 * @property string|null $riwayat_penyakit_sekarang
 * @property string|null $riwayat_penyakit_dahulu
 * @property string|null $riwayat_operasi
 * @property string|null $riwayat_pengobatan_tb
 * @property string|null $riwayat_pengobatan_lain
 * @property string|null $riwayat_penyakit_keluarga
 * @property string|null $alergi
 * @property string|null $status_sosial
 * @property string|null $ekonomi
 * @property string|null $imunisasi
 * @property string|null $status_psikologi
 * @property string|null $status_mental
 * @property string|null $riwayat_perilaku_kekerasan
 * @property string|null $ketergantungan_obat
 * @property string|null $ketergantungan_alkohol
 * @property string|null $permintaan_informasi
 * @property int|null $gcs_e
 * @property int|null $gcs_m
 * @property int|null $gcs_v
 * @property string|null $tingkat_kesadaran
 * @property string|null $nadi
 * @property string|null $darah
 * @property string|null $pernapasan
 * @property int|null $suhu
 * @property int|null $sato2
 * @property string|null $sikap_tubuh
 * @property int|null $tinggi_badan
 * @property int|null $berat_badan
 * @property float|null $imt
 * @property int|null $lila
 * @property int|null $berat_badan_sebelum
 * @property int|null $skor_penurunan_bb
 * @property string|null $kulit_warna
 * @property string|null $kulit_sianosis
 * @property string|null $kulit_kemerahan
 * @property string|null $kulit_dekubitus
 * @property string|null $kulit_turgor_kulit
 * @property string|null $kulit_tumor
 * @property string|null $kulit_luka_bakar
 * @property string|null $kulit_luka_tusuk
 * @property string|null $kulit_luka_memar
 * @property string|null $kulit_luka_robek
 * @property int|null $kepala_lk
 * @property string|null $kepala_rambut
 * @property string|null $kepala_bentuk
 * @property string|null $gigi_palsu
 * @property string|null $fontanel
 * @property string|null $telinga
 * @property string|null $hidung
 * @property string|null $sclera_mata
 * @property string|null $konjungtiva_mata
 * @property string|null $mulut
 * @property string|null $kepala_leher_terpasang_alat
 * @property string|null $respirasi_suara_napas
 * @property string|null $respirasi_pola_napas
 * @property string|null $respirasi_napas_cuping
 * @property string|null $respirasi_otot_bantu
 * @property string|null $respirasi_clubing_finger
 * @property string|null $respirasi_terpasang_alat
 * @property string|null $kardiovaskular_jantung
 * @property string|null $kardiovaskular_ictus
 * @property string|null $kardiovaskular_jvp
 * @property string|null $kardiovaskular_ekg
 * @property string|null $kardiovaskular_ctr
 * @property string|null $kardiovaskular_echo
 * @property string|null $bentuk_payudara
 * @property string|null $puting_susu
 * @property string|null $areola_mammae
 * @property string|null $pengeluaran_asi
 * @property string|null $abdomen_bekas_operasi
 * @property string|null $palpasi_atas
 * @property string|null $palpasi_samping
 * @property string|null $palpasi_bawah
 * @property int|null $palpasi_tbj
 * @property string|null $auskultasi_nilai_djj
 * @property string|null $auskultasi_status_djj
 * @property string|null $perkusi_refleks_patela_kanan
 * @property string|null $perkusi_refleks_patela_kiri
 * @property string|null $vt_idikasi
 * @property string|null $vt_portio_konsistensi
 * @property string|null $vt_portio_pendataran
 * @property string|null $vt_portio_pembukaan
 * @property string|null $vt_ketuban
 * @property string|null $vt_presentase
 * @property string|null $vt_posisi
 * @property string|null $vt_penurunan
 * @property string|null $vt_lainya
 * @property string|null $gastro_mual
 * @property string|null $gastro_muntah
 * @property string|null $gastro_acites
 * @property string|null $gastro_bising_usus
 * @property string|null $gastro_nyeri_tekan
 * @property string|null $gastro_massa_abdomen
 * @property string|null $gastro_nyeri_lepas
 * @property string|null $gastro_pembesaran_hepar
 * @property string|null $gastro_pembesaran_limpa
 * @property string|null $gastro_terpasang_alat
 * @property string|null $persepsi_pendengaran
 * @property string|null $persepsi_penglihatan
 * @property string|null $persepsi_penghiduan
 * @property string|null $neurologi_keluhan
 * @property string|null $neurologi_reflek_fisiologis
 * @property string|null $neurologi_reflek_patologis
 * @property string|null $eleminasi_bab
 * @property string|null $eliminasi_bak
 * @property string|null $genetalia_kelainan
 * @property string|null $genetalia_edema
 * @property string|null $genetalia_simetris
 * @property string|null $genetalia_secret
 * @property string|null $extremitas_edema
 * @property string|null $extremitas_fraktur
 * @property string|null $extremitas_amputasi
 * @property string|null $extremitas_parase
 * @property string|null $extremitas_legi
 * @property string|null $extremitas_defornitas
 * @property string|null $extremitas_tumor
 * @property string|null $gangguan_pertumbuhan
 * @property string|null $gangguan_perkembangan
 * @property string|null $hambatan_dalam_pembelajaran
 * @property string|null $dibutuhkan_penerjamah
 * @property string|null $bahasa_isyarat
 * @property string|null $kebutuhan_edukasi
 * @property string|null $perencanaan_pasien_pulang
 * @property int|null $riwayat_perkawinan_ke
 * @property string|null $riwayat_perkawinan_usia_kawin_thn
 * @property string|null $riwayat_perkawinan_lama_kawin_thn
 * @property string|null $riwayat_haid_menarche_umur_thn
 * @property string|null $riwayat_haid_haid
 * @property int|null $riwayat_haid_siklus_haid_hari
 * @property string|null $riwayat_haid_kelainan_haid
 * @property string|null $riwayat_haid_fluor_albus
 * @property string|null $riwayat_haid_hpht
 * @property string|null $riwayat_haid_perkiraan_partus
 * @property string|null $riwayat_kehamilan_json
 * @property int|null $rhamil_g
 * @property int|null $rhamil_p
 * @property int|null $rhamil_a
 * @property int|null $rhamil_h
 * @property int|null $rhamil_usia_kehamilan_pemeriksaan_awal_minggu
 * @property string|null $rhamil_tempat_pemeriksaan_awal
 * @property int|null $rhamil_pemeriksaan_ke
 * @property string|null $rhamil_masalah_selama_hamil
 * @property string|null $rhamil_tanda_bahaya
 * @property int|null $rhamil_usia_kehamilan_hpht_minggu
 * @property string|null $rpersalinan_tempat_melahirkan
 * @property string|null $rpersalinan_penolong_lahiran
 * @property string|null $rpersalinan_jenis_persalinan
 * @property string|null $rpersalinan_keadaan_ketuban
 * @property string|null $rpersalinan_keadaan_ketuban_ket
 * @property string|null $rpersalinan_warna_air_ketuban
 * @property int|null $rpersalinan_lama_persalinan_kala1
 * @property string|null $rpersalinan_lama_persalinan_kala1_satuan
 * @property int|null $rpersalinan_lama_persalinan_kala2
 * @property string|null $rpersalinan_lama_persalinan_kala2_satuan
 * @property int|null $rpersalinan_lama_persalinan_kala3
 * @property string|null $rpersalinan_lama_persalinan_kala3_satuan
 * @property string|null $rpersalinan_komplikasi_persalinan
 * @property string|null $rpersalinan_komplikasi_persalinan_lainya
 * @property string|null $rpersalinan_keadaan_perineum
 * @property string|null $rpersalinan_bayi_tanggal
 * @property int|null $rpersalinan_bayi_bb_gram
 * @property int|null $rpersalinan_bayi_pb_cm
 * @property string|null $rpersalinan_bayi_jk
 * @property string|null $rpersalinan_bayi_anus
 * @property int|null $rpersalinan_bayi_masa_gestasi_minggu
 * @property string|null $rpersalinan_bayi_cacat_bawaan
 * @property string|null $rpersalinan_bayi_masalah
 * @property string|null $rkesehatan_reproduksi
 * @property string|null $rkesehatan_reproduksi_lainya
 * @property string|null $rkb_pernah_kb
 * @property string|null $rkb_metode_kb
 * @property int|null $rkb_lama_kb
 * @property string|null $rkb_lama_kb_satuan
 * @property string|null $rkb_komplikasi_kb
 * @property string|null $rkb_lainnya
 * @property string|null $hal_hal_lain
 * @property string|null $kesimpulan
 * @property string|null $penatalaksanaan
 * @property int $batal
 * @property string|null $tanggal_batal
 * @property int $draf
 * @property string|null $tanggal_final
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $log_data
 * @property int $is_deleted
 */
class AsesmenAwalKebidanan extends BaseModelAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.asesmen_awal_kebidanan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['layanan_id', 'perawat_id'], 'required'],
            [['layanan_id', 'perawat_id', 'gcs_e', 'gcs_m', 'gcs_v', 'suhu', 'sato2', 'tinggi_badan', 'berat_badan', 'lila', 'berat_badan_sebelum', 'skor_penurunan_bb', 'kepala_lk', 'palpasi_tbj', 'riwayat_perkawinan_ke', 'riwayat_haid_siklus_haid_hari', 'rhamil_g', 'rhamil_p', 'rhamil_a', 'rhamil_h', 'rhamil_usia_kehamilan_pemeriksaan_awal_minggu', 'rhamil_pemeriksaan_ke', 'rhamil_usia_kehamilan_hpht_minggu', 'rpersalinan_lama_persalinan_kala1', 'rpersalinan_lama_persalinan_kala2', 'rpersalinan_lama_persalinan_kala3', 'rpersalinan_bayi_bb_gram', 'rpersalinan_bayi_pb_cm', 'rpersalinan_bayi_masa_gestasi_minggu', 'rkb_lama_kb', 'batal', 'draf', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['layanan_id', 'perawat_id', 'gcs_e', 'gcs_m', 'gcs_v', 'suhu', 'sato2', 'tinggi_badan', 'berat_badan', 'lila', 'berat_badan_sebelum', 'skor_penurunan_bb', 'kepala_lk', 'palpasi_tbj', 'riwayat_perkawinan_ke', 'riwayat_haid_siklus_haid_hari', 'rhamil_g', 'rhamil_p', 'rhamil_a', 'rhamil_h', 'rhamil_usia_kehamilan_pemeriksaan_awal_minggu', 'rhamil_pemeriksaan_ke', 'rhamil_usia_kehamilan_hpht_minggu', 'rpersalinan_lama_persalinan_kala1', 'rpersalinan_lama_persalinan_kala2', 'rpersalinan_lama_persalinan_kala3', 'rpersalinan_bayi_bb_gram', 'rpersalinan_bayi_pb_cm', 'rpersalinan_bayi_masa_gestasi_minggu', 'rkb_lama_kb', 'batal', 'draf', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['anamnesis_sumber', 'anamnesis_keluhan', 'riwayat_penyakit_sekarang', 'riwayat_penyakit_dahulu', 'riwayat_operasi', 'riwayat_pengobatan_tb', 'riwayat_pengobatan_lain', 'riwayat_penyakit_keluarga', 'alergi', 'status_sosial', 'ekonomi', 'imunisasi', 'status_psikologi', 'status_mental', 'riwayat_perilaku_kekerasan', 'ketergantungan_obat', 'ketergantungan_alkohol', 'permintaan_informasi', 'tingkat_kesadaran', 'nadi', 'darah', 'pernapasan', 'sikap_tubuh', 'kulit_warna', 'kulit_sianosis', 'kulit_kemerahan', 'kulit_dekubitus', 'kulit_turgor_kulit', 'kulit_tumor', 'kulit_luka_bakar', 'kulit_luka_tusuk', 'kulit_luka_memar', 'kulit_luka_robek', 'kepala_rambut', 'kepala_bentuk', 'gigi_palsu', 'fontanel', 'telinga', 'hidung', 'sclera_mata', 'konjungtiva_mata', 'mulut', 'kepala_leher_terpasang_alat', 'respirasi_suara_napas', 'respirasi_pola_napas', 'respirasi_napas_cuping', 'respirasi_otot_bantu', 'respirasi_clubing_finger', 'respirasi_terpasang_alat', 'kardiovaskular_jantung', 'kardiovaskular_ictus', 'kardiovaskular_jvp', 'kardiovaskular_ekg', 'kardiovaskular_ctr', 'kardiovaskular_echo', 'bentuk_payudara', 'puting_susu', 'areola_mammae', 'pengeluaran_asi', 'abdomen_bekas_operasi', 'palpasi_atas', 'palpasi_samping', 'palpasi_bawah', 'auskultasi_nilai_djj', 'auskultasi_status_djj', 'perkusi_refleks_patela_kanan', 'perkusi_refleks_patela_kiri', 'vt_idikasi', 'vt_portio_konsistensi', 'vt_portio_pendataran', 'vt_portio_pembukaan', 'vt_ketuban', 'vt_presentase', 'vt_posisi', 'vt_penurunan', 'vt_lainya', 'gastro_mual', 'gastro_muntah', 'gastro_acites', 'gastro_bising_usus', 'gastro_nyeri_tekan', 'gastro_massa_abdomen', 'gastro_nyeri_lepas', 'gastro_pembesaran_hepar', 'gastro_pembesaran_limpa', 'gastro_terpasang_alat', 'persepsi_pendengaran', 'persepsi_penglihatan', 'persepsi_penghiduan', 'neurologi_keluhan', 'neurologi_reflek_fisiologis', 'neurologi_reflek_patologis', 'eleminasi_bab', 'eliminasi_bak', 'genetalia_kelainan', 'genetalia_edema', 'genetalia_simetris', 'genetalia_secret', 'extremitas_edema', 'extremitas_fraktur', 'extremitas_amputasi', 'extremitas_parase', 'extremitas_legi', 'extremitas_defornitas', 'extremitas_tumor', 'gangguan_pertumbuhan', 'gangguan_perkembangan', 'hambatan_dalam_pembelajaran', 'dibutuhkan_penerjamah', 'bahasa_isyarat', 'kebutuhan_edukasi', 'perencanaan_pasien_pulang', 'riwayat_perkawinan_usia_kawin_thn', 'riwayat_perkawinan_lama_kawin_thn', 'riwayat_haid_menarche_umur_thn', 'riwayat_haid_haid', 'riwayat_haid_kelainan_haid', 'riwayat_haid_fluor_albus', 'riwayat_kehamilan_json', 'rhamil_tempat_pemeriksaan_awal', 'rhamil_masalah_selama_hamil', 'rhamil_tanda_bahaya', 'rpersalinan_tempat_melahirkan', 'rpersalinan_penolong_lahiran', 'rpersalinan_jenis_persalinan', 'rpersalinan_keadaan_ketuban', 'rpersalinan_keadaan_ketuban_ket', 'rpersalinan_warna_air_ketuban', 'rpersalinan_lama_persalinan_kala1_satuan', 'rpersalinan_lama_persalinan_kala2_satuan', 'rpersalinan_lama_persalinan_kala3_satuan', 'rpersalinan_komplikasi_persalinan', 'rpersalinan_komplikasi_persalinan_lainya', 'rpersalinan_keadaan_perineum', 'rpersalinan_bayi_jk', 'rpersalinan_bayi_anus', 'rpersalinan_bayi_cacat_bawaan', 'rpersalinan_bayi_masalah', 'rkesehatan_reproduksi', 'rkesehatan_reproduksi_lainya', 'rkb_pernah_kb', 'rkb_metode_kb', 'rkb_lama_kb_satuan', 'rkb_komplikasi_kb', 'rkb_lainnya', 'hal_hal_lain', 'kesimpulan', 'penatalaksanaan', 'log_data'], 'string'],
            [['imt'], 'number'],
            [['riwayat_haid_hpht', 'riwayat_haid_perkiraan_partus', 'rpersalinan_bayi_tanggal', 'tanggal_batal', 'tanggal_final', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'layanan_id' => 'Layanan ID',
            'perawat_id' => 'Perawat ID',
            'anamnesis_sumber' => 'Anamnesis Sumber',
            'anamnesis_keluhan' => 'Anamnesis Keluhan',
            'riwayat_penyakit_sekarang' => 'Riwayat Penyakit Sekarang',
            'riwayat_penyakit_dahulu' => 'Riwayat Penyakit Dahulu',
            'riwayat_operasi' => 'Riwayat Operasi',
            'riwayat_pengobatan_tb' => 'Riwayat Pengobatan Tb',
            'riwayat_pengobatan_lain' => 'Riwayat Pengobatan Lain',
            'riwayat_penyakit_keluarga' => 'Riwayat Penyakit Keluarga',
            'alergi' => 'Alergi',
            'status_sosial' => 'Status Sosial',
            'ekonomi' => 'Ekonomi',
            'imunisasi' => 'Imunisasi',
            'status_psikologi' => 'Status Psikologi',
            'status_mental' => 'Status Mental',
            'riwayat_perilaku_kekerasan' => 'Riwayat Perilaku Kekerasan',
            'ketergantungan_obat' => 'Ketergantungan Obat',
            'ketergantungan_alkohol' => 'Ketergantungan Alkohol',
            'permintaan_informasi' => 'Permintaan Informasi',
            'gcs_e' => 'Gcs E',
            'gcs_m' => 'Gcs M',
            'gcs_v' => 'Gcs V',
            'tingkat_kesadaran' => 'Tingkat Kesadaran',
            'nadi' => 'Nadi',
            'darah' => 'Darah',
            'pernapasan' => 'Pernapasan',
            'suhu' => 'Suhu',
            'sato2' => 'Sato2',
            'sikap_tubuh' => 'Sikap Tubuh',
            'tinggi_badan' => 'Tinggi Badan',
            'berat_badan' => 'Berat Badan',
            'imt' => 'Imt',
            'lila' => 'Lila',
            'berat_badan_sebelum' => 'Berat Badan Sebelum',
            'skor_penurunan_bb' => 'Skor Penurunan Bb',
            'kulit_warna' => 'Kulit Warna',
            'kulit_sianosis' => 'Kulit Sianosis',
            'kulit_kemerahan' => 'Kulit Kemerahan',
            'kulit_dekubitus' => 'Kulit Dekubitus',
            'kulit_turgor_kulit' => 'Kulit Turgor Kulit',
            'kulit_tumor' => 'Kulit Tumor',
            'kulit_luka_bakar' => 'Kulit Luka Bakar',
            'kulit_luka_tusuk' => 'Kulit Luka Tusuk',
            'kulit_luka_memar' => 'Kulit Luka Memar',
            'kulit_luka_robek' => 'Kulit Luka Robek',
            'kepala_lk' => 'Kepala Lk',
            'kepala_rambut' => 'Kepala Rambut',
            'kepala_bentuk' => 'Kepala Bentuk',
            'gigi_palsu' => 'Gigi Palsu',
            'fontanel' => 'Fontanel',
            'telinga' => 'Telinga',
            'hidung' => 'Hidung',
            'sclera_mata' => 'Sclera Mata',
            'konjungtiva_mata' => 'Konjungtiva Mata',
            'mulut' => 'Mulut',
            'kepala_leher_terpasang_alat' => 'Kepala Leher Terpasang Alat',
            'respirasi_suara_napas' => 'Respirasi Suara Napas',
            'respirasi_pola_napas' => 'Respirasi Pola Napas',
            'respirasi_napas_cuping' => 'Respirasi Napas Cuping',
            'respirasi_otot_bantu' => 'Respirasi Otot Bantu',
            'respirasi_clubing_finger' => 'Respirasi Clubing Finger',
            'respirasi_terpasang_alat' => 'Respirasi Terpasang Alat',
            'kardiovaskular_jantung' => 'Kardiovaskular Jantung',
            'kardiovaskular_ictus' => 'Kardiovaskular Ictus',
            'kardiovaskular_jvp' => 'Kardiovaskular Jvp',
            'kardiovaskular_ekg' => 'Kardiovaskular Ekg',
            'kardiovaskular_ctr' => 'Kardiovaskular Ctr',
            'kardiovaskular_echo' => 'Kardiovaskular Echo',
            'bentuk_payudara' => 'Bentuk Payudara',
            'puting_susu' => 'Puting Susu',
            'areola_mammae' => 'Areola Mammae',
            'pengeluaran_asi' => 'Pengeluaran Asi',
            'abdomen_bekas_operasi' => 'Abdomen Bekas Operasi',
            'palpasi_atas' => 'Palpasi Atas',
            'palpasi_samping' => 'Palpasi Samping',
            'palpasi_bawah' => 'Palpasi Bawah',
            'palpasi_tbj' => 'Palpasi Tbj',
            'auskultasi_nilai_djj' => 'Auskultasi Nilai Djj',
            'auskultasi_status_djj' => 'Auskultasi Status Djj',
            'perkusi_refleks_patela_kanan' => 'Perkusi Refleks Patela Kanan',
            'perkusi_refleks_patela_kiri' => 'Perkusi Refleks Patela Kiri',
            'vt_idikasi' => 'Vt Idikasi',
            'vt_portio_konsistensi' => 'Vt Portio Konsistensi',
            'vt_portio_pendataran' => 'Vt Portio Pendataran',
            'vt_portio_pembukaan' => 'Vt Portio Pembukaan',
            'vt_ketuban' => 'Vt Ketuban',
            'vt_presentase' => 'Vt Presentase',
            'vt_posisi' => 'Vt Posisi',
            'vt_penurunan' => 'Vt Penurunan',
            'vt_lainya' => 'Vt Lainya',
            'gastro_mual' => 'Gastro Mual',
            'gastro_muntah' => 'Gastro Muntah',
            'gastro_acites' => 'Gastro Acites',
            'gastro_bising_usus' => 'Gastro Bising Usus',
            'gastro_nyeri_tekan' => 'Gastro Nyeri Tekan',
            'gastro_massa_abdomen' => 'Gastro Massa Abdomen',
            'gastro_nyeri_lepas' => 'Gastro Nyeri Lepas',
            'gastro_pembesaran_hepar' => 'Gastro Pembesaran Hepar',
            'gastro_pembesaran_limpa' => 'Gastro Pembesaran Limpa',
            'gastro_terpasang_alat' => 'Gastro Terpasang Alat',
            'persepsi_pendengaran' => 'Persepsi Pendengaran',
            'persepsi_penglihatan' => 'Persepsi Penglihatan',
            'persepsi_penghiduan' => 'Persepsi Penghiduan',
            'neurologi_keluhan' => 'Neurologi Keluhan',
            'neurologi_reflek_fisiologis' => 'Neurologi Reflek Fisiologis',
            'neurologi_reflek_patologis' => 'Neurologi Reflek Patologis',
            'eleminasi_bab' => 'Eleminasi Bab',
            'eliminasi_bak' => 'Eliminasi Bak',
            'genetalia_kelainan' => 'Genetalia Kelainan',
            'genetalia_edema' => 'Genetalia Edema',
            'genetalia_simetris' => 'Genetalia Simetris',
            'genetalia_secret' => 'Genetalia Secret',
            'extremitas_edema' => 'Extremitas Edema',
            'extremitas_fraktur' => 'Extremitas Fraktur',
            'extremitas_amputasi' => 'Extremitas Amputasi',
            'extremitas_parase' => 'Extremitas Parase',
            'extremitas_legi' => 'Extremitas Legi',
            'extremitas_defornitas' => 'Extremitas Defornitas',
            'extremitas_tumor' => 'Extremitas Tumor',
            'gangguan_pertumbuhan' => 'Gangguan Pertumbuhan',
            'gangguan_perkembangan' => 'Gangguan Perkembangan',
            'hambatan_dalam_pembelajaran' => 'Hambatan Dalam Pembelajaran',
            'dibutuhkan_penerjamah' => 'Dibutuhkan Penerjamah',
            'bahasa_isyarat' => 'Bahasa Isyarat',
            'kebutuhan_edukasi' => 'Kebutuhan Edukasi',
            'perencanaan_pasien_pulang' => 'Perencanaan Pasien Pulang',
            'riwayat_perkawinan_ke' => 'Riwayat Perkawinan Ke',
            'riwayat_perkawinan_usia_kawin_thn' => 'Riwayat Perkawinan Usia Kawin Thn',
            'riwayat_perkawinan_lama_kawin_thn' => 'Riwayat Perkawinan Lama Kawin Thn',
            'riwayat_haid_menarche_umur_thn' => 'Riwayat Haid Menarche Umur Thn',
            'riwayat_haid_haid' => 'Riwayat Haid Haid',
            'riwayat_haid_siklus_haid_hari' => 'Riwayat Haid Siklus Haid Hari',
            'riwayat_haid_kelainan_haid' => 'Riwayat Haid Kelainan Haid',
            'riwayat_haid_fluor_albus' => 'Riwayat Haid Fluor Albus',
            'riwayat_haid_hpht' => 'Riwayat Haid Hpht',
            'riwayat_haid_perkiraan_partus' => 'Riwayat Haid Perkiraan Partus',
            'riwayat_kehamilan_json' => 'Riwayat Kehamilan Json',
            'rhamil_g' => 'Rhamil G',
            'rhamil_p' => 'Rhamil P',
            'rhamil_a' => 'Rhamil A',
            'rhamil_h' => 'Rhamil H',
            'rhamil_usia_kehamilan_pemeriksaan_awal_minggu' => 'Rhamil Usia Kehamilan Pemeriksaan Awal Minggu',
            'rhamil_tempat_pemeriksaan_awal' => 'Rhamil Tempat Pemeriksaan Awal',
            'rhamil_pemeriksaan_ke' => 'Rhamil Pemeriksaan Ke',
            'rhamil_masalah_selama_hamil' => 'Rhamil Masalah Selama Hamil',
            'rhamil_tanda_bahaya' => 'Rhamil Tanda Bahaya',
            'rhamil_usia_kehamilan_hpht_minggu' => 'Rhamil Usia Kehamilan Hpht Minggu',
            'rpersalinan_tempat_melahirkan' => 'Rpersalinan Tempat Melahirkan',
            'rpersalinan_penolong_lahiran' => 'Rpersalinan Penolong Lahiran',
            'rpersalinan_jenis_persalinan' => 'Rpersalinan Jenis Persalinan',
            'rpersalinan_keadaan_ketuban' => 'Rpersalinan Keadaan Ketuban',
            'rpersalinan_keadaan_ketuban_ket' => 'Rpersalinan Keadaan Ketuban Ket',
            'rpersalinan_warna_air_ketuban' => 'Rpersalinan Warna Air Ketuban',
            'rpersalinan_lama_persalinan_kala1' => 'Rpersalinan Lama Persalinan Kala1',
            'rpersalinan_lama_persalinan_kala1_satuan' => 'Rpersalinan Lama Persalinan Kala1 Satuan',
            'rpersalinan_lama_persalinan_kala2' => 'Rpersalinan Lama Persalinan Kala2',
            'rpersalinan_lama_persalinan_kala2_satuan' => 'Rpersalinan Lama Persalinan Kala2 Satuan',
            'rpersalinan_lama_persalinan_kala3' => 'Rpersalinan Lama Persalinan Kala3',
            'rpersalinan_lama_persalinan_kala3_satuan' => 'Rpersalinan Lama Persalinan Kala3 Satuan',
            'rpersalinan_komplikasi_persalinan' => 'Rpersalinan Komplikasi Persalinan',
            'rpersalinan_komplikasi_persalinan_lainya' => 'Rpersalinan Komplikasi Persalinan Lainya',
            'rpersalinan_keadaan_perineum' => 'Rpersalinan Keadaan Perineum',
            'rpersalinan_bayi_tanggal' => 'Rpersalinan Bayi Tanggal',
            'rpersalinan_bayi_bb_gram' => 'Rpersalinan Bayi Bb Gram',
            'rpersalinan_bayi_pb_cm' => 'Rpersalinan Bayi Pb Cm',
            'rpersalinan_bayi_jk' => 'Rpersalinan Bayi Jk',
            'rpersalinan_bayi_anus' => 'Rpersalinan Bayi Anus',
            'rpersalinan_bayi_masa_gestasi_minggu' => 'Rpersalinan Bayi Masa Gestasi Minggu',
            'rpersalinan_bayi_cacat_bawaan' => 'Rpersalinan Bayi Cacat Bawaan',
            'rpersalinan_bayi_masalah' => 'Rpersalinan Bayi Masalah',
            'rkesehatan_reproduksi' => 'Rkesehatan Reproduksi',
            'rkesehatan_reproduksi_lainya' => 'Rkesehatan Reproduksi Lainya',
            'rkb_pernah_kb' => 'Rkb Pernah Kb',
            'rkb_metode_kb' => 'Rkb Metode Kb',
            'rkb_lama_kb' => 'Rkb Lama Kb',
            'rkb_lama_kb_satuan' => 'Rkb Lama Kb Satuan',
            'rkb_komplikasi_kb' => 'Rkb Komplikasi Kb',
            'rkb_lainnya' => 'Rkb Lainnya',
            'hal_hal_lain' => 'Hal Hal Lain',
            'kesimpulan' => 'Kesimpulan',
            'penatalaksanaan' => 'Penatalaksanaan',
            'batal' => 'Batal',
            'tanggal_batal' => 'Tanggal Batal',
            'draf' => 'Draf',
            'tanggal_final' => 'Tanggal Final',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'log_data' => 'Log Data',
            'is_deleted' => 'Is Deleted',
        ];
    }

    public function beforeSave($insert) {
        if ($insert) {
            $this->batal = 0;
            $this->draf = 1;
            $this->is_deleted = 0;
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
    public static function find()
    {
        return new AsesmenAwalKebidananQuery(get_called_class());
    }
    public function getPerawat()
    {
        return $this->hasOne(TbPegawai::className(),['pegawai_id'=>'perawat_id']);
    }
    public function getLayanan()
    {
        return $this->hasOne(Layanan::className(),['id'=>'layanan_id']);
    }
}
