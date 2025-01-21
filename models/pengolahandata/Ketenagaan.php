<?php

namespace app\models\pengolahandata;

use app\components\Akun;
use Yii;

/**
 * This is the model class for table "ketenagaan".
 *
 * @property int $ketenagaan_id
 * @property string $tahun
 * @property int|null $dokter_umum_keadaan_lk
 * @property int|null $dokter_umum_keadaan_pr
 * @property int|null $dokter_umum_kebutuhan_lk
 * @property int|null $dokter_umum_kebutuhan_pr
 * @property int|null $dokter_umum_kekurangan_lk
 * @property int|null $dokter_umum_kekurangan_pr
 * @property int|null $dokter_ppds_keadaan_lk
 * @property int|null $dokter_ppds_keadaan_pr
 * @property int|null $dokter_ppds_kebutuhan_lk
 * @property int|null $dokter_ppds_kebutuhan_pr
 * @property int|null $dokter_ppds_kekurangan_lk
 * @property int|null $dokter_ppds_kekurangan_pr
 * @property int|null $dokter_spesialisbedah_keadaan_lk
 * @property int|null $dokter_spesialisbedah_keadaan_pr
 * @property int|null $dokter_spesialisbedah_kebutuhan_lk
 * @property int|null $dokter_spesialisbedah_kebutuhan_pr
 * @property int|null $dokter_spesialisbedah_kekurangan_lk
 * @property int|null $dokter_spesialisbedah_kekurangan_pr
 * @property int|null $dokter_spesialispenyakitdalam_keadaan_lk
 * @property int|null $dokter_spesialispenyakitdalam_keadaan_pr
 * @property int|null $dokter_spesialispenyakitdalam_kebutuhan_lk
 * @property int|null $dokter_spesialispenyakitdalam_kebutuhan_pr
 * @property int|null $dokter_spesialispenyakitdalam_kekurangan_lk
 * @property int|null $dokter_spesialispenyakitdalam_kekurangan_pr
 * @property int|null $dokter_spesialiskesehatananak_keadaan_lk
 * @property int|null $dokter_spesialiskesehatananak_keadaan_pr
 * @property int|null $dokter_spesialiskesehatananak_kebutuhan_lk
 * @property int|null $dokter_spesialiskesehatananak_kebutuhan_pr
 * @property int|null $dokter_spesialiskesehatananak_kekurangan_lk
 * @property int|null $dokter_spesialiskesehatananak_kekurangan_pr
 * @property int|null $dokter_spesialisobgin_keadaan_lk
 * @property int|null $dokter_spesialisobgin_keadaan_pr
 * @property int|null $dokter_spesialisobgin_kebutuhan_lk
 * @property int|null $dokter_spesialisobgin_kebutuhan_pr
 * @property int|null $dokter_spesialisobgin_kekurangan_lk
 * @property int|null $dokter_spesialisobgin_kekurangan_pr
 * @property int|null $dokter_spesialisradiologi_keadaan_lk
 * @property int|null $dokter_spesialisradiologi_keadaan_pr
 * @property int|null $dokter_spesialisradiologi_kebutuhan_lk
 * @property int|null $dokter_spesialisradiologi_kebutuhan_pr
 * @property int|null $dokter_spesialisradiologi_kekurangan_lk
 * @property int|null $dokter_spesialisradiologi_kekurangan_pr
 * @property int|null $dokter_spesialisonkologiradiasi_keadaan_lk
 * @property int|null $dokter_spesialisonkologiradiasi_keadaan_pr
 * @property int|null $dokter_spesialisonkologiradiasi_kebutuhan_lk
 * @property int|null $dokter_spesialisonkologiradiasi_kebutuhan_pr
 * @property int|null $dokter_spesialisonkologiradiasi_kekurangan_lk
 * @property int|null $dokter_spesialisonkologiradiasi_kekurangan_pr
 * @property int|null $dokter_spesialiskedokterannulir_keadaan_lk
 * @property int|null $dokter_spesialiskedokterannulir_keadaan_pr
 * @property int|null $dokter_spesialiskedokterannulir_kebutuhan_lk
 * @property int|null $dokter_spesialiskedokterannulir_kebutuhan_pr
 * @property int|null $dokter_spesialiskedokterannulir_kekurangan_lk
 * @property int|null $dokter_spesialiskedokterannulir_kekurangan_pr
 * @property int|null $dokter_spesialisanesthesi_keadaan_lk
 * @property int|null $dokter_spesialisanesthesi_keadaan_pr
 * @property int|null $dokter_spesialisanesthesi_kebutuhan_lk
 * @property int|null $dokter_spesialisanesthesi_kebutuhan_pr
 * @property int|null $dokter_spesialisanesthesi_kekurangan_lk
 * @property int|null $dokter_spesialisanesthesi_kekurangan_pr
 * @property int|null $dokter_spesialispatologiklinik_keadaan_lk
 * @property int|null $dokter_spesialispatologiklinik_keadaan_pr
 * @property int|null $dokter_spesialispatologiklinik_kebutuhan_lk
 * @property int|null $dokter_spesialispatologiklinik_kebutuhan_pr
 * @property int|null $dokter_spesialispatologiklinik_kekurangan_lk
 * @property int|null $dokter_spesialispatologiklinik_kekurangan_pr
 * @property int|null $dokter_spesialisjiwa_keadaan_lk
 * @property int|null $dokter_spesialisjiwa_keadaan_pr
 * @property int|null $dokter_spesialisjiwa_kebutuhan_lk
 * @property int|null $dokter_spesialisjiwa_kebutuhan_pr
 * @property int|null $dokter_spesialisjiwa_kekurangan_lk
 * @property int|null $dokter_spesialisjiwa_kekurangan_pr
 * @property int|null $dokter_spesialismata_keadaan_lk
 * @property int|null $dokter_spesialismata_keadaan_pr
 * @property int|null $dokter_spesialismata_kebutuhan_lk
 * @property int|null $dokter_spesialismata_kebutuhan_pr
 * @property int|null $dokter_spesialismata_kekurangan_lk
 * @property int|null $dokter_spesialismata_kekurangan_pr
 * @property int|null $dokter_spesialistht_keadaan_lk
 * @property int|null $dokter_spesialistht_keadaan_pr
 * @property int|null $dokter_spesialistht_kebutuhan_lk
 * @property int|null $dokter_spesialistht_kebutuhan_pr
 * @property int|null $dokter_spesialistht_kekurangan_lk
 * @property int|null $dokter_spesialistht_kekurangan_pr
 * @property int|null $dokter_spesialiskulitkelamin_keadaan_lk
 * @property int|null $dokter_spesialiskulitkelamin_keadaan_pr
 * @property int|null $dokter_spesialiskulitkelamin_kebutuhan_lk
 * @property int|null $dokter_spesialiskulitkelamin_kebutuhan_pr
 * @property int|null $dokter_spesialiskulitkelamin_kekurangan_lk
 * @property int|null $dokter_spesialiskulitkelamin_kekurangan_pr
 * @property int|null $dokter_spesialiskardiologi_keadaan_lk
 * @property int|null $dokter_spesialiskardiologi_keadaan_pr
 * @property int|null $dokter_spesialiskardiologi_kebutuhan_lk
 * @property int|null $dokter_spesialiskardiologi_kebutuhan_pr
 * @property int|null $dokter_spesialiskardiologi_kekurangan_lk
 * @property int|null $dokter_spesialiskardiologi_kekurangan_pr
 * @property int|null $dokter_spesialisparu_keadaan_lk
 * @property int|null $dokter_spesialisparu_keadaan_pr
 * @property int|null $dokter_spesialisparu_kebutuhan_lk
 * @property int|null $dokter_spesialisparu_kebutuhan_pr
 * @property int|null $dokter_spesialisparu_kekurangan_lk
 * @property int|null $dokter_spesialisparu_kekurangan_pr
 * @property int|null $dokter_spesialissaraf_keadaan_lk
 * @property int|null $dokter_spesialissaraf_keadaan_pr
 * @property int|null $dokter_spesialissaraf_kebutuhan_lk
 * @property int|null $dokter_spesialissaraf_kebutuhan_pr
 * @property int|null $dokter_spesialissaraf_kekurangan_lk
 * @property int|null $dokter_spesialissaraf_kekurangan_pr
 * @property int|null $dokter_spesialisbedahsaraf_keadaan_lk
 * @property int|null $dokter_spesialisbedahsaraf_keadaan_pr
 * @property int|null $dokter_spesialisbedahsaraf_kebutuhan_lk
 * @property int|null $dokter_spesialisbedahsaraf_kebutuhan_pr
 * @property int|null $dokter_spesialisbedahsaraf_kekurangan_lk
 * @property int|null $dokter_spesialisbedahsaraf_kekurangan_pr
 * @property int|null $dokter_spesialisbedahorthopedi_keadaan_lk
 * @property int|null $dokter_spesialisbedahorthopedi_keadaan_pr
 * @property int|null $dokter_spesialisbedahorthopedi_kebutuhan_lk
 * @property int|null $dokter_spesialisbedahorthopedi_kebutuhan_pr
 * @property int|null $dokter_spesialisbedahorthopedi_kekurangan_lk
 * @property int|null $dokter_spesialisbedahorthopedi_kekurangan_pr
 * @property int|null $dokter_spesialisurologi_keadaan_lk
 * @property int|null $dokter_spesialisurologi_keadaan_pr
 * @property int|null $dokter_spesialisurologi_kebutuhan_lk
 * @property int|null $dokter_spesialisurologi_kebutuhan_pr
 * @property int|null $dokter_spesialisurologi_kekurangan_lk
 * @property int|null $dokter_spesialisurologi_kekurangan_pr
 * @property int|null $dokter_spesialispatologianatomi_keadaan_lk
 * @property int|null $dokter_spesialispatologianatomi_keadaan_pr
 * @property int|null $dokter_spesialispatologianatomi_kebutuhan_lk
 * @property int|null $dokter_spesialispatologianatomi_kebutuhan_pr
 * @property int|null $dokter_spesialispatologianatomi_kekurangan_lk
 * @property int|null $dokter_spesialispatologianatomi_kekurangan_pr
 * @property int|null $dokter_spesialispatologiforensik_keadaan_lk
 * @property int|null $dokter_spesialispatologiforensik_keadaan_pr
 * @property int|null $dokter_spesialispatologiforensik_kebutuhan_lk
 * @property int|null $dokter_spesialispatologiforensik_kebutuhan_pr
 * @property int|null $dokter_spesialispatologiforensik_kekurangan_lk
 * @property int|null $dokter_spesialispatologiforensik_kekurangan_pr
 * @property int|null $dokter_spesialisrehabilitasimedik_keadaan_lk
 * @property int|null $dokter_spesialisrehabilitasimedik_keadaan_pr
 * @property int|null $dokter_spesialisrehabilitasimedik_kebutuhan_lk
 * @property int|null $dokter_spesialisrehabilitasimedik_kebutuhan_pr
 * @property int|null $dokter_spesialisrehabilitasimedik_kekurangan_lk
 * @property int|null $dokter_spesialisrehabilitasimedik_kekurangan_pr
 * @property int|null $dokter_spesialisbedahplastik_keadaan_lk
 * @property int|null $dokter_spesialisbedahplastik_keadaan_pr
 * @property int|null $dokter_spesialisbedahplastik_kebutuhan_lk
 * @property int|null $dokter_spesialisbedahplastik_kebutuhan_pr
 * @property int|null $dokter_spesialisbedahplastik_kekurangan_lk
 * @property int|null $dokter_spesialisbedahplastik_kekurangan_pr
 * @property int|null $dokter_spesialiskedokteranolahraga_keadaan_lk
 * @property int|null $dokter_spesialiskedokteranolahraga_keadaan_pr
 * @property int|null $dokter_spesialiskedokteranolahraga_kebutuhan_lk
 * @property int|null $dokter_spesialiskedokteranolahraga_kebutuhan_pr
 * @property int|null $dokter_spesialiskedokteranolahraga_kekurangan_lk
 * @property int|null $dokter_spesialiskedokteranolahraga_kekurangan_pr
 * @property int|null $dokter_spesialismikrobiologiklinik_keadaan_lk
 * @property int|null $dokter_spesialismikrobiologiklinik_keadaan_pr
 * @property int|null $dokter_spesialismikrobiologiklinik_kebutuhan_lk
 * @property int|null $dokter_spesialismikrobiologiklinik_kebutuhan_pr
 * @property int|null $dokter_spesialismikrobiologiklinik_kekurangan_lk
 * @property int|null $dokter_spesialismikrobiologiklinik_kekurangan_pr
 * @property int|null $dokter_spesialisparasitologiklinik_keadaan_lk
 * @property int|null $dokter_spesialisparasitologiklinik_keadaan_pr
 * @property int|null $dokter_spesialisparasitologiklinik_kebutuhan_lk
 * @property int|null $dokter_spesialisparasitologiklinik_kebutuhan_pr
 * @property int|null $dokter_spesialisparasitologiklinik_kekurangan_lk
 * @property int|null $dokter_spesialisparasitologiklinik_kekurangan_pr
 * @property int|null $dokter_spesialisgizimedik_keadaan_lk
 * @property int|null $dokter_spesialisgizimedik_keadaan_pr
 * @property int|null $dokter_spesialisgizimedik_kebutuhan_lk
 * @property int|null $dokter_spesialisgizimedik_kebutuhan_pr
 * @property int|null $dokter_spesialisgizimedik_kekurangan_lk
 * @property int|null $dokter_spesialisgizimedik_kekurangan_pr
 * @property int|null $dokter_spesialisfarmaklinik_keadaan_lk
 * @property int|null $dokter_spesialisfarmaklinik_keadaan_pr
 * @property int|null $dokter_spesialisfarmaklinik_kebutuhan_lk
 * @property int|null $dokter_spesialisfarmaklinik_kebutuhan_pr
 * @property int|null $dokter_spesialisfarmaklinik_kekurangan_lk
 * @property int|null $dokter_spesialisfarmaklinik_kekurangan_pr
 * @property int|null $dokter_spesialislainnya_keadaan_lk
 * @property int|null $dokter_spesialislainnya_keadaan_pr
 * @property int|null $dokter_spesialislainnya_kebutuhan_lk
 * @property int|null $dokter_spesialislainnya_kebutuhan_pr
 * @property int|null $dokter_spesialislainnya_kekurangan_lk
 * @property int|null $dokter_spesialislainnya_kekurangan_pr
 * @property int|null $dokter_subspesialislainnya_keadaan_lk
 * @property int|null $dokter_subspesialislainnya_keadaan_pr
 * @property int|null $dokter_subspesialislainnya_kebutuhan_lk
 * @property int|null $dokter_subspesialislainnya_kebutuhan_pr
 * @property int|null $dokter_subspesialislainnya_kekurangan_lk
 * @property int|null $dokter_subspesialislainnya_kekurangan_pr
 * @property int|null $dokter_gigi_keadaan_lk
 * @property int|null $dokter_gigi_keadaan_pr
 * @property int|null $dokter_gigi_kebutuhan_lk
 * @property int|null $dokter_gigi_kebutuhan_pr
 * @property int|null $dokter_gigi_kekurangan_lk
 * @property int|null $dokter_gigi_kekurangan_pr
 * @property int|null $dokter_gigi_spesialis_keadaan_lk
 * @property int|null $dokter_gigi_spesialis_keadaan_pr
 * @property int|null $dokter_gigi_spesialis_kebutuhan_lk
 * @property int|null $dokter_gigi_spesialis_kebutuhan_pr
 * @property int|null $dokter_gigi_spesialis_kekurangan_lk
 * @property int|null $dokter_gigi_spesialis_kekurangan_pr
 * @property int|null $dokter_doktergigimhamars_keadaan_lk
 * @property int|null $dokter_doktergigimhamars_keadaan_pr
 * @property int|null $dokter_doktergigimhamars_kebutuhan_lk
 * @property int|null $dokter_doktergigimhamars_kebutuhan_pr
 * @property int|null $dokter_doktergigimhamars_kekurangan_lk
 * @property int|null $dokter_doktergigimhamars_kekurangan_pr
 * @property int|null $dokter_doktergigis2s3kesehatanmasyarakat_keadaan_lk
 * @property int|null $dokter_doktergigis2s3kesehatanmasyarakat_keadaan_pr
 * @property int|null $dokter_doktergigis2s3kesehatanmasyarakat_kebutuhan_lk
 * @property int|null $dokter_doktergigis2s3kesehatanmasyarakat_kebutuhan_pr
 * @property int|null $dokter_doktergigis2s3kesehatanmasyarakat_kekurangan_lk
 * @property int|null $dokter_doktergigis2s3kesehatanmasyarakat_kekurangan_pr
 * @property int|null $s3_dokterkonsultan_keadaan_lk
 * @property int|null $s3_dokterkonsultan_keadaan_pr
 * @property int|null $s3_dokterkonsultan_kebutuhan_lk
 * @property int|null $s3_dokterkonsultan_kebutuhan_pr
 * @property int|null $s3_dokterkonsultan_kekurangan_lk
 * @property int|null $s3_dokterkonsultan_kekurangan_pr
 * @property int|null $s3_keperawatan_keadaan_lk
 * @property int|null $s3_keperawatan_keadaan_pr
 * @property int|null $s3_keperawatan_kebutuhan_lk
 * @property int|null $s3_keperawatan_kebutuhan_pr
 * @property int|null $s3_keperawatan_kekurangan_lk
 * @property int|null $s3_keperawatan_kekurangan_pr
 * @property int|null $s2_keperawatan_keadaan_lk
 * @property int|null $s2_keperawatan_keadaan_pr
 * @property int|null $s2_keperawatan_kebutuhan_lk
 * @property int|null $s2_keperawatan_kebutuhan_pr
 * @property int|null $s2_keperawatan_kekurangan_lk
 * @property int|null $s2_keperawatan_kekurangan_pr
 * @property int|null $s1_keperawatan_keadaan_lk
 * @property int|null $s1_keperawatan_keadaan_pr
 * @property int|null $s1_keperawatan_kebutuhan_lk
 * @property int|null $s1_keperawatan_kebutuhan_pr
 * @property int|null $s1_keperawatan_kekurangan_lk
 * @property int|null $s1_keperawatan_kekurangan_pr
 * @property int|null $d4_keperawatan_keadaan_lk
 * @property int|null $d4_keperawatan_keadaan_pr
 * @property int|null $d4_keperawatan_kebutuhan_lk
 * @property int|null $d4_keperawatan_kebutuhan_pr
 * @property int|null $d4_keperawatan_kekurangan_lk
 * @property int|null $d4_keperawatan_kekurangan_pr
 * @property int|null $perawat_vokasional_keadaan_lk
 * @property int|null $perawat_vokasional_keadaan_pr
 * @property int|null $perawat_vokasional_kebutuhan_lk
 * @property int|null $perawat_vokasional_kebutuhan_pr
 * @property int|null $perawat_vokasional_kekurangan_lk
 * @property int|null $perawat_vokasional_kekurangan_pr
 * @property int|null $perawat_spesialis_keadaan_lk
 * @property int|null $perawat_spesialis_keadaan_pr
 * @property int|null $perawat_spesialis_kebutuhan_lk
 * @property int|null $perawat_spesialis_kebutuhan_pr
 * @property int|null $perawat_spesialis_kekurangan_lk
 * @property int|null $perawat_spesialis_kekurangan_pr
 * @property int|null $pembantu_keperawatan_keadaan_lk
 * @property int|null $pembantu_keperawatan_keadaan_pr
 * @property int|null $pembantu_keperawatan_kebutuhan_lk
 * @property int|null $pembantu_keperawatan_kebutuhan_pr
 * @property int|null $pembantu_keperawatan_kekurangan_lk
 * @property int|null $pembantu_keperawatan_kekurangan_pr
 * @property int|null $s3_kebidanan_keadaan_lk
 * @property int|null $s3_kebidanan_keadaan_pr
 * @property int|null $s3_kebidanan_kebutuhan_lk
 * @property int|null $s3_kebidanan_kebutuhan_pr
 * @property int|null $s3_kebidanan_kekurangan_lk
 * @property int|null $s3_kebidanan_kekurangan_pr
 * @property int|null $s2_kebidanan_keadaan_lk
 * @property int|null $s2_kebidanan_keadaan_pr
 * @property int|null $s2_kebidanan_kebutuhan_lk
 * @property int|null $s2_kebidanan_kebutuhan_pr
 * @property int|null $s2_kebidanan_kekurangan_lk
 * @property int|null $s2_kebidanan_kekurangan_pr
 * @property int|null $s1_kebidanan_keadaan_lk
 * @property int|null $s1_kebidanan_keadaan_pr
 * @property int|null $s1_kebidanan_kebutuhan_lk
 * @property int|null $s1_kebidanan_kebutuhan_pr
 * @property int|null $s1_kebidanan_kekurangan_lk
 * @property int|null $s1_kebidanan_kekurangan_pr
 * @property int|null $d3_kebidanan_keadaan_lk
 * @property int|null $d3_kebidanan_keadaan_pr
 * @property int|null $d3_kebidanan_kebutuhan_lk
 * @property int|null $d3_kebidanan_kebutuhan_pr
 * @property int|null $d3_kebidanan_kekurangan_lk
 * @property int|null $d3_kebidanan_kekurangan_pr
 * @property int|null $tenaga_keperawatanlainnya_keadaan_lk
 * @property int|null $tenaga_keperawatanlainnya_keadaan_pr
 * @property int|null $tenaga_keperawatanlainnya_kebutuhan_lk
 * @property int|null $tenaga_keperawatanlainnya_kebutuhan_pr
 * @property int|null $tenaga_keperawatanlainnya_kekurangan_lk
 * @property int|null $tenaga_keperawatanlainnya_kekurangan_pr
 * @property int|null $s3_farmasiapoteker_keadaan_lk
 * @property int|null $s3_farmasiapoteker_keadaan_pr
 * @property int|null $s3_farmasiapoteker_kebutuhan_lk
 * @property int|null $s3_farmasiapoteker_kebutuhan_pr
 * @property int|null $s3_farmasiapoteker_kekurangan_lk
 * @property int|null $s3_farmasiapoteker_kekurangan_pr
 * @property int|null $s2_farmasiapoteker_keadaan_lk
 * @property int|null $s2_farmasiapoteker_keadaan_pr
 * @property int|null $s2_farmasiapoteker_kebutuhan_lk
 * @property int|null $s2_farmasiapoteker_kebutuhan_pr
 * @property int|null $s2_farmasiapoteker_kekurangan_lk
 * @property int|null $s2_farmasiapoteker_kekurangan_pr
 * @property int|null $apoteker_keadaan_lk
 * @property int|null $apoteker_keadaan_pr
 * @property int|null $apoteker_kebutuhan_lk
 * @property int|null $apoteker_kebutuhan_pr
 * @property int|null $apoteker_kekurangan_lk
 * @property int|null $apoteker_kekurangan_pr
 * @property int|null $s3_farmasifarmakologikimia_keadaan_lk
 * @property int|null $s3_farmasifarmakologikimia_keadaan_pr
 * @property int|null $s3_farmasifarmakologikimia_kebutuhan_lk
 * @property int|null $s3_farmasifarmakologikimia_kebutuhan_pr
 * @property int|null $s3_farmasifarmakologikimia_kekurangan_lk
 * @property int|null $s3_farmasifarmakologikimia_kekurangan_pr
 * @property int|null $s1_farmasiapoteker_keadaan_lk
 * @property int|null $s1_farmasiapoteker_keadaan_pr
 * @property int|null $s1_farmasiapoteker_kebutuhan_lk
 * @property int|null $s1_farmasiapoteker_kebutuhan_pr
 * @property int|null $s1_farmasiapoteker_kekurangan_lk
 * @property int|null $s1_farmasiapoteker_kekurangan_pr
 * @property int|null $akafarma_keadaan_lk
 * @property int|null $akafarma_keadaan_pr
 * @property int|null $akafarma_kebutuhan_lk
 * @property int|null $akafarma_kebutuhan_pr
 * @property int|null $akafarma_kekurangan_lk
 * @property int|null $akafarma_kekurangan_pr
 * @property int|null $akfar_keadaan_lk
 * @property int|null $akfar_keadaan_pr
 * @property int|null $akfar_kebutuhan_lk
 * @property int|null $akfar_kebutuhan_pr
 * @property int|null $akfar_kekurangan_lk
 * @property int|null $akfar_kekurangan_pr
 * @property int|null $analis_farmasi_keadaan_lk
 * @property int|null $analis_farmasi_keadaan_pr
 * @property int|null $analis_farmasi_kebutuhan_lk
 * @property int|null $analis_farmasi_kebutuhan_pr
 * @property int|null $analis_farmasi_kekurangan_lk
 * @property int|null $analis_farmasi_kekurangan_pr
 * @property int|null $asisten_apoteker_keadaan_lk
 * @property int|null $asisten_apoteker_keadaan_pr
 * @property int|null $asisten_apoteker_kebutuhan_lk
 * @property int|null $asisten_apoteker_kebutuhan_pr
 * @property int|null $asisten_apoteker_kekurangan_lk
 * @property int|null $asisten_apoteker_kekurangan_pr
 * @property int|null $s1_farmasiapotekersmf_keadaan_lk
 * @property int|null $s1_farmasiapotekersmf_keadaan_pr
 * @property int|null $s1_farmasiapotekersmf_kebutuhan_lk
 * @property int|null $s1_farmasiapotekersmf_kebutuhan_pr
 * @property int|null $s1_farmasiapotekersmf_kekurangan_lk
 * @property int|null $s1_farmasiapotekersmf_kekurangan_pr
 * @property int|null $st_lab_kimia_farmasi_keadaan_lk
 * @property int|null $st_lab_kimia_farmasi_keadaan_pr
 * @property int|null $st_lab_kimia_farmasi_kebutuhan_lk
 * @property int|null $st_lab_kimia_farmasi_kebutuhan_pr
 * @property int|null $st_lab_kimia_farmasi_kekurangan_lk
 * @property int|null $st_lab_kimia_farmasi_kekurangan_pr
 * @property int|null $tenaga_kefarmasianlainnya_keadaan_lk
 * @property int|null $tenaga_kefarmasianlainnya_keadaan_pr
 * @property int|null $tenaga_kefarmasianlainnya_kebutuhan_lk
 * @property int|null $tenaga_kefarmasianlainnya_kebutuhan_pr
 * @property int|null $tenaga_kefarmasianlainnya_kekurangan_lk
 * @property int|null $tenaga_kefarmasianlainnya_kekurangan_pr
 * @property int|null $s3_kesehatan_masyarakatan_keadaan_lk
 * @property int|null $s3_kesehatan_masyarakatan_keadaan_pr
 * @property int|null $s3_kesehatan_masyarakatan_kebutuhan_lk
 * @property int|null $s3_kesehatan_masyarakatan_kebutuhan_pr
 * @property int|null $s3_kesehatan_masyarakatan_kekurangan_lk
 * @property int|null $s3_kesehatan_masyarakatan_kekurangan_pr
 * @property int|null $s3_epidemologi_keadaan_lk
 * @property int|null $s3_epidemologi_keadaan_pr
 * @property int|null $s3_epidemologi_kebutuhan_lk
 * @property int|null $s3_epidemologi_kebutuhan_pr
 * @property int|null $s3_epidemologi_kekurangan_lk
 * @property int|null $s3_epidemologi_kekurangan_pr
 * @property int|null $s3_psikologi_keadaan_lk
 * @property int|null $s3_psikologi_keadaan_pr
 * @property int|null $s3_psikologi_kebutuhan_lk
 * @property int|null $s3_psikologi_kebutuhan_pr
 * @property int|null $s3_psikologi_kekurangan_lk
 * @property int|null $s3_psikologi_kekurangan_pr
 * @property int|null $s2_kesehatan_masyarakatan_keadaan_lk
 * @property int|null $s2_kesehatan_masyarakatan_keadaan_pr
 * @property int|null $s2_kesehatan_masyarakatan_kebutuhan_lk
 * @property int|null $s2_kesehatan_masyarakatan_kebutuhan_pr
 * @property int|null $s2_kesehatan_masyarakatan_kekurangan_lk
 * @property int|null $s2_kesehatan_masyarakatan_kekurangan_pr
 * @property int|null $s2_epidemologi_keadaan_lk
 * @property int|null $s2_epidemologi_keadaan_pr
 * @property int|null $s2_epidemologi_kebutuhan_lk
 * @property int|null $s2_epidemologi_kebutuhan_pr
 * @property int|null $s2_epidemologi_kekurangan_lk
 * @property int|null $s2_epidemologi_kekurangan_pr
 * @property int|null $s2_biomedik_keadaan_lk
 * @property int|null $s2_biomedik_keadaan_pr
 * @property int|null $s2_biomedik_kebutuhan_lk
 * @property int|null $s2_biomedik_kebutuhan_pr
 * @property int|null $s2_biomedik_kekurangan_lk
 * @property int|null $s2_biomedik_kekurangan_pr
 * @property int|null $s2_psikologi_keadaan_lk
 * @property int|null $s2_psikologi_keadaan_pr
 * @property int|null $s2_psikologi_kebutuhan_lk
 * @property int|null $s2_psikologi_kebutuhan_pr
 * @property int|null $s2_psikologi_kekurangan_lk
 * @property int|null $s2_psikologi_kekurangan_pr
 * @property int|null $s1_kesehatan_masyarakat_keadaan_lk
 * @property int|null $s1_kesehatan_masyarakat_keadaan_pr
 * @property int|null $s1_kesehatan_masyarakat_kebutuhan_lk
 * @property int|null $s1_kesehatan_masyarakat_kebutuhan_pr
 * @property int|null $s1_kesehatan_masyarakat_kekurangan_lk
 * @property int|null $s1_kesehatan_masyarakat_kekurangan_pr
 * @property int|null $s1_psikologi_keadaan_lk
 * @property int|null $s1_psikologi_keadaan_pr
 * @property int|null $s1_psikologi_kebutuhan_lk
 * @property int|null $s1_psikologi_kebutuhan_pr
 * @property int|null $s1_psikologi_kekurangan_lk
 * @property int|null $s1_psikologi_kekurangan_pr
 * @property int|null $d3_kesehatan_masyarakat_keadaan_lk
 * @property int|null $d3_kesehatan_masyarakat_keadaan_pr
 * @property int|null $d3_kesehatan_masyarakat_kebutuhan_lk
 * @property int|null $d3_kesehatan_masyarakat_kebutuhan_pr
 * @property int|null $d3_kesehatan_masyarakat_kekurangan_lk
 * @property int|null $d3_kesehatan_masyarakat_kekurangan_pr
 * @property int|null $d3_sanitarian_keadaan_lk
 * @property int|null $d3_sanitarian_keadaan_pr
 * @property int|null $d3_sanitarian_kebutuhan_lk
 * @property int|null $d3_sanitarian_kebutuhan_pr
 * @property int|null $d3_sanitarian_kekurangan_lk
 * @property int|null $d3_sanitarian_kekurangan_pr
 * @property int|null $tenaga_kesehatan_masyarakatlainnya_keadaan_lk
 * @property int|null $tenaga_kesehatan_masyarakatlainnya_keadaan_pr
 * @property int|null $tenaga_kesehatan_masyarakatlainnya_kebutuhan_lk
 * @property int|null $tenaga_kesehatan_masyarakatlainnya_kebutuhan_pr
 * @property int|null $tenaga_kesehatan_masyarakatlainnya_kekurangan_lk
 * @property int|null $tenaga_kesehatan_masyarakatlainnya_kekurangan_pr
 * @property int|null $s3_gizi_dietisien_keadaan_lk
 * @property int|null $s3_gizi_dietisien_keadaan_pr
 * @property int|null $s3_gizi_dietisien_kebutuhan_lk
 * @property int|null $s3_gizi_dietisien_kebutuhan_pr
 * @property int|null $s3_gizi_dietisien_kekurangan_lk
 * @property int|null $s3_gizi_dietisien_kekurangan_pr
 * @property int|null $s2_gizi_dietisien_keadaan_lk
 * @property int|null $s2_gizi_dietisien_keadaan_pr
 * @property int|null $s2_gizi_dietisien_kebutuhan_lk
 * @property int|null $s2_gizi_dietisien_kebutuhan_pr
 * @property int|null $s2_gizi_dietisien_kekurangan_lk
 * @property int|null $s2_gizi_dietisien_kekurangan_pr
 * @property int|null $s1_gizi_dietisien_keadaan_lk
 * @property int|null $s1_gizi_dietisien_keadaan_pr
 * @property int|null $s1_gizi_dietisien_kebutuhan_lk
 * @property int|null $s1_gizi_dietisien_kebutuhan_pr
 * @property int|null $s1_gizi_dietisien_kekurangan_lk
 * @property int|null $s1_gizi_dietisien_kekurangan_pr
 * @property int|null $d4_gizi_dietisien_keadaan_lk
 * @property int|null $d4_gizi_dietisien_keadaan_pr
 * @property int|null $d4_gizi_dietisien_kebutuhan_lk
 * @property int|null $d4_gizi_dietisien_kebutuhan_pr
 * @property int|null $d4_gizi_dietisien_kekurangan_lk
 * @property int|null $d4_gizi_dietisien_kekurangan_pr
 * @property int|null $d3_gizi_dietisien_keadaan_lk
 * @property int|null $d3_gizi_dietisien_keadaan_pr
 * @property int|null $d3_gizi_dietisien_kebutuhan_lk
 * @property int|null $d3_gizi_dietisien_kebutuhan_pr
 * @property int|null $d3_gizi_dietisien_kekurangan_lk
 * @property int|null $d3_gizi_dietisien_kekurangan_pr
 * @property int|null $d1_gizi_dietisien_keadaan_lk
 * @property int|null $d1_gizi_dietisien_keadaan_pr
 * @property int|null $d1_gizi_dietisien_kebutuhan_lk
 * @property int|null $d1_gizi_dietisien_kebutuhan_pr
 * @property int|null $d1_gizi_dietisien_kekurangan_lk
 * @property int|null $d1_gizi_dietisien_kekurangan_pr
 * @property int|null $tenaga_gizilainnya_keadaan_lk
 * @property int|null $tenaga_gizilainnya_keadaan_pr
 * @property int|null $tenaga_gizilainnya_kebutuhan_lk
 * @property int|null $tenaga_gizilainnya_kebutuhan_pr
 * @property int|null $tenaga_gizilainnya_kekurangan_lk
 * @property int|null $tenaga_gizilainnya_kekurangan_pr
 * @property int|null $s1_fisioterapis_keadaan_lk
 * @property int|null $s1_fisioterapis_keadaan_pr
 * @property int|null $s1_fisioterapis_kebutuhan_lk
 * @property int|null $s1_fisioterapis_kebutuhan_pr
 * @property int|null $s1_fisioterapis_kekurangan_lk
 * @property int|null $s1_fisioterapis_kekurangan_pr
 * @property int|null $d3_fisioterapis_keadaan_lk
 * @property int|null $d3_fisioterapis_keadaan_pr
 * @property int|null $d3_fisioterapis_kebutuhan_lk
 * @property int|null $d3_fisioterapis_kebutuhan_pr
 * @property int|null $d3_fisioterapis_kekurangan_lk
 * @property int|null $d3_fisioterapis_kekurangan_pr
 * @property int|null $d3_okupasiterapis_keadaan_lk
 * @property int|null $d3_okupasiterapis_keadaan_pr
 * @property int|null $d3_okupasiterapis_kebutuhan_lk
 * @property int|null $d3_okupasiterapis_kebutuhan_pr
 * @property int|null $d3_okupasiterapis_kekurangan_lk
 * @property int|null $d3_okupasiterapis_kekurangan_pr
 * @property int|null $d3_terapiwicara_keadaan_lk
 * @property int|null $d3_terapiwicara_keadaan_pr
 * @property int|null $d3_terapiwicara_kebutuhan_lk
 * @property int|null $d3_terapiwicara_kebutuhan_pr
 * @property int|null $d3_terapiwicara_kekurangan_lk
 * @property int|null $d3_terapiwicara_kekurangan_pr
 * @property int|null $d3_orthopedi_keadaan_lk
 * @property int|null $d3_orthopedi_keadaan_pr
 * @property int|null $d3_orthopedi_kebutuhan_lk
 * @property int|null $d3_orthopedi_kebutuhan_pr
 * @property int|null $d3_orthopedi_kekurangan_lk
 * @property int|null $d3_orthopedi_kekurangan_pr
 * @property int|null $d3_akupuntur_keadaan_lk
 * @property int|null $d3_akupuntur_keadaan_pr
 * @property int|null $d3_akupuntur_kebutuhan_lk
 * @property int|null $d3_akupuntur_kebutuhan_pr
 * @property int|null $d3_akupuntur_kekurangan_lk
 * @property int|null $d3_akupuntur_kekurangan_pr
 * @property int|null $tenaga_keterapianfisiklainnya_keadaan_lk
 * @property int|null $tenaga_keterapianfisiklainnya_keadaan_pr
 * @property int|null $tenaga_keterapianfisiklainnya_kebutuhan_lk
 * @property int|null $tenaga_keterapianfisiklainnya_kebutuhan_pr
 * @property int|null $tenaga_keterapianfisiklainnya_kekurangan_lk
 * @property int|null $tenaga_keterapianfisiklainnya_kekurangan_pr
 * @property int|null $s3_optoelektronikaapllaser_keadaan_lk
 * @property int|null $s3_optoelektronikaapllaser_keadaan_pr
 * @property int|null $s3_optoelektronikaapllaser_kebutuhan_lk
 * @property int|null $s3_optoelektronikaapllaser_kebutuhan_pr
 * @property int|null $s3_optoelektronikaapllaser_kekurangan_lk
 * @property int|null $s3_optoelektronikaapllaser_kekurangan_pr
 * @property int|null $s2_optoelektronikaapllaser_keadaan_lk
 * @property int|null $s2_optoelektronikaapllaser_keadaan_pr
 * @property int|null $s2_optoelektronikaapllaser_kebutuhan_lk
 * @property int|null $s2_optoelektronikaapllaser_kebutuhan_pr
 * @property int|null $s2_optoelektronikaapllaser_kekurangan_lk
 * @property int|null $s2_optoelektronikaapllaser_kekurangan_pr
 * @property int|null $radiografer_keadaan_lk
 * @property int|null $radiografer_keadaan_pr
 * @property int|null $radiografer_kebutuhan_lk
 * @property int|null $radiografer_kebutuhan_pr
 * @property int|null $radiografer_kekurangan_lk
 * @property int|null $radiografer_kekurangan_pr
 * @property int|null $radioterapis_nondokter_keadaan_lk
 * @property int|null $radioterapis_nondokter_keadaan_pr
 * @property int|null $radioterapis_nondokter_kebutuhan_lk
 * @property int|null $radioterapis_nondokter_kebutuhan_pr
 * @property int|null $radioterapis_nondokter_kekurangan_lk
 * @property int|null $radioterapis_nondokter_kekurangan_pr
 * @property int|null $d4_fisikamedik_keadaan_lk
 * @property int|null $d4_fisikamedik_keadaan_pr
 * @property int|null $d4_fisikamedik_kebutuhan_lk
 * @property int|null $d4_fisikamedik_kebutuhan_pr
 * @property int|null $d4_fisikamedik_kekurangan_lk
 * @property int|null $d4_fisikamedik_kekurangan_pr
 * @property int|null $d3_teknikgigi_keadaan_lk
 * @property int|null $d3_teknikgigi_keadaan_pr
 * @property int|null $d3_teknikgigi_kebutuhan_lk
 * @property int|null $d3_teknikgigi_kebutuhan_pr
 * @property int|null $d3_teknikgigi_kekurangan_lk
 * @property int|null $d3_teknikgigi_kekurangan_pr
 * @property int|null $d3_teknikradiologiradioterapi_keadaan_lk
 * @property int|null $d3_teknikradiologiradioterapi_keadaan_pr
 * @property int|null $d3_teknikradiologiradioterapi_kebutuhan_lk
 * @property int|null $d3_teknikradiologiradioterapi_kebutuhan_pr
 * @property int|null $d3_teknikradiologiradioterapi_kekurangan_lk
 * @property int|null $d3_teknikradiologiradioterapi_kekurangan_pr
 * @property int|null $d3_refraksionisoptisien_keadaan_lk
 * @property int|null $d3_refraksionisoptisien_keadaan_pr
 * @property int|null $d3_refraksionisoptisien_kebutuhan_lk
 * @property int|null $d3_refraksionisoptisien_kebutuhan_pr
 * @property int|null $d3_refraksionisoptisien_kekurangan_lk
 * @property int|null $d3_refraksionisoptisien_kekurangan_pr
 * @property int|null $d3_perekammedis_keadaan_lk
 * @property int|null $d3_perekammedis_keadaan_pr
 * @property int|null $d3_perekammedis_kebutuhan_lk
 * @property int|null $d3_perekammedis_kebutuhan_pr
 * @property int|null $d3_perekammedis_kekurangan_lk
 * @property int|null $d3_perekammedis_kekurangan_pr
 * @property int|null $d3_teknikelektromedik_keadaan_lk
 * @property int|null $d3_teknikelektromedik_keadaan_pr
 * @property int|null $d3_teknikelektromedik_kebutuhan_lk
 * @property int|null $d3_teknikelektromedik_kebutuhan_pr
 * @property int|null $d3_teknikelektromedik_kekurangan_lk
 * @property int|null $d3_teknikelektromedik_kekurangan_pr
 * @property int|null $d3_analiskesehatan_keadaan_lk
 * @property int|null $d3_analiskesehatan_keadaan_pr
 * @property int|null $d3_analiskesehatan_kebutuhan_lk
 * @property int|null $d3_analiskesehatan_kebutuhan_pr
 * @property int|null $d3_analiskesehatan_kekurangan_lk
 * @property int|null $d3_analiskesehatan_kekurangan_pr
 * @property int|null $d3_informasikesehatan_keadaan_lk
 * @property int|null $d3_informasikesehatan_keadaan_pr
 * @property int|null $d3_informasikesehatan_kebutuhan_lk
 * @property int|null $d3_informasikesehatan_kebutuhan_pr
 * @property int|null $d3_informasikesehatan_kekurangan_lk
 * @property int|null $d3_informasikesehatan_kekurangan_pr
 * @property int|null $d3_kardiovaskular_keadaan_lk
 * @property int|null $d3_kardiovaskular_keadaan_pr
 * @property int|null $d3_kardiovaskular_kebutuhan_lk
 * @property int|null $d3_kardiovaskular_kebutuhan_pr
 * @property int|null $d3_kardiovaskular_kekurangan_lk
 * @property int|null $d3_kardiovaskular_kekurangan_pr
 * @property int|null $d3_orthotikprostetik_keadaan_lk
 * @property int|null $d3_orthotikprostetik_keadaan_pr
 * @property int|null $d3_orthotikprostetik_kebutuhan_lk
 * @property int|null $d3_orthotikprostetik_kebutuhan_pr
 * @property int|null $d3_orthotikprostetik_kekurangan_lk
 * @property int|null $d3_orthotikprostetik_kekurangan_pr
 * @property int|null $d1_tekniktranfusi_keadaan_lk
 * @property int|null $d1_tekniktranfusi_keadaan_pr
 * @property int|null $d1_tekniktranfusi_kebutuhan_lk
 * @property int|null $d1_tekniktranfusi_kebutuhan_pr
 * @property int|null $d1_tekniktranfusi_kekurangan_lk
 * @property int|null $d1_tekniktranfusi_kekurangan_pr
 * @property int|null $teknisi_gigi_keadaan_lk
 * @property int|null $teknisi_gigi_keadaan_pr
 * @property int|null $teknisi_gigi_kebutuhan_lk
 * @property int|null $teknisi_gigi_kebutuhan_pr
 * @property int|null $teknisi_gigi_kekurangan_lk
 * @property int|null $teknisi_gigi_kekurangan_pr
 * @property int|null $tenaga_itteknologinano_keadaan_lk
 * @property int|null $tenaga_itteknologinano_keadaan_pr
 * @property int|null $tenaga_itteknologinano_kebutuhan_lk
 * @property int|null $tenaga_itteknologinano_kebutuhan_pr
 * @property int|null $tenaga_itteknologinano_kekurangan_lk
 * @property int|null $tenaga_itteknologinano_kekurangan_pr
 * @property int|null $teknisi_patologianatomi_keadaan_lk
 * @property int|null $teknisi_patologianatomi_keadaan_pr
 * @property int|null $teknisi_patologianatomi_kebutuhan_lk
 * @property int|null $teknisi_patologianatomi_kebutuhan_pr
 * @property int|null $teknisi_patologianatomi_kekurangan_lk
 * @property int|null $teknisi_patologianatomi_kekurangan_pr
 * @property int|null $teknisi_kardiovaskular_keadaan_lk
 * @property int|null $teknisi_kardiovaskular_keadaan_pr
 * @property int|null $teknisi_kardiovaskular_kebutuhan_lk
 * @property int|null $teknisi_kardiovaskular_kebutuhan_pr
 * @property int|null $teknisi_kardiovaskular_kekurangan_lk
 * @property int|null $teknisi_kardiovaskular_kekurangan_pr
 * @property int|null $teknisi_elektromedis_keadaan_lk
 * @property int|null $teknisi_elektromedis_keadaan_pr
 * @property int|null $teknisi_elektromedis_kebutuhan_lk
 * @property int|null $teknisi_elektromedis_kebutuhan_pr
 * @property int|null $teknisi_elektromedis_kekurangan_lk
 * @property int|null $teknisi_elektromedis_kekurangan_pr
 * @property int|null $akupuntur_terapi_keadaan_lk
 * @property int|null $akupuntur_terapi_keadaan_pr
 * @property int|null $akupuntur_terapi_kebutuhan_lk
 * @property int|null $akupuntur_terapi_kebutuhan_pr
 * @property int|null $akupuntur_terapi_kekurangan_lk
 * @property int|null $akupuntur_terapi_kekurangan_pr
 * @property int|null $analis_kesehatan_keadaan_lk
 * @property int|null $analis_kesehatan_keadaan_pr
 * @property int|null $analis_kesehatan_kebutuhan_lk
 * @property int|null $analis_kesehatan_kebutuhan_pr
 * @property int|null $analis_kesehatan_kekurangan_lk
 * @property int|null $analis_kesehatan_kekurangan_pr
 * @property int|null $tenaga_keteknisianmedislainnya_keadaan_lk
 * @property int|null $tenaga_keteknisianmedislainnya_keadaan_pr
 * @property int|null $tenaga_keteknisianmedislainnya_kebutuhan_lk
 * @property int|null $tenaga_keteknisianmedislainnya_kebutuhan_pr
 * @property int|null $tenaga_keteknisianmedislainnya_kekurangan_lk
 * @property int|null $tenaga_keteknisianmedislainnya_kekurangan_pr
 * @property int|null $s3_biologi_keadaan_lk
 * @property int|null $s3_biologi_keadaan_pr
 * @property int|null $s3_biologi_kebutuhan_lk
 * @property int|null $s3_biologi_kebutuhan_pr
 * @property int|null $s3_biologi_kekurangan_lk
 * @property int|null $s3_biologi_kekurangan_pr
 * @property int|null $s3_kimia_keadaan_lk
 * @property int|null $s3_kimia_keadaan_pr
 * @property int|null $s3_kimia_kebutuhan_lk
 * @property int|null $s3_kimia_kebutuhan_pr
 * @property int|null $s3_kimia_kekurangan_lk
 * @property int|null $s3_kimia_kekurangan_pr
 * @property int|null $s3_ekonomiakuntansi_keadaan_lk
 * @property int|null $s3_ekonomiakuntansi_keadaan_pr
 * @property int|null $s3_ekonomiakuntansi_kebutuhan_lk
 * @property int|null $s3_ekonomiakuntansi_kebutuhan_pr
 * @property int|null $s3_ekonomiakuntansi_kekurangan_lk
 * @property int|null $s3_ekonomiakuntansi_kekurangan_pr
 * @property int|null $s3_administrasi_keadaan_lk
 * @property int|null $s3_administrasi_keadaan_pr
 * @property int|null $s3_administrasi_kebutuhan_lk
 * @property int|null $s3_administrasi_kebutuhan_pr
 * @property int|null $s3_administrasi_kekurangan_lk
 * @property int|null $s3_administrasi_kekurangan_pr
 * @property int|null $s3_hukum_keadaan_lk
 * @property int|null $s3_hukum_keadaan_pr
 * @property int|null $s3_hukum_kebutuhan_lk
 * @property int|null $s3_hukum_kebutuhan_pr
 * @property int|null $s3_hukum_kekurangan_lk
 * @property int|null $s3_hukum_kekurangan_pr
 * @property int|null $s3_tehnik_keadaan_lk
 * @property int|null $s3_tehnik_keadaan_pr
 * @property int|null $s3_tehnik_kebutuhan_lk
 * @property int|null $s3_tehnik_kebutuhan_pr
 * @property int|null $s3_tehnik_kekurangan_lk
 * @property int|null $s3_tehnik_kekurangan_pr
 * @property int|null $s3_kesejahteraansosial_keadaan_lk
 * @property int|null $s3_kesejahteraansosial_keadaan_pr
 * @property int|null $s3_kesejahteraansosial_kebutuhan_lk
 * @property int|null $s3_kesejahteraansosial_kebutuhan_pr
 * @property int|null $s3_kesejahteraansosial_kekurangan_lk
 * @property int|null $s3_kesejahteraansosial_kekurangan_pr
 * @property int|null $s3_fisika_keadaan_lk
 * @property int|null $s3_fisika_keadaan_pr
 * @property int|null $s3_fisika_kebutuhan_lk
 * @property int|null $s3_fisika_kebutuhan_pr
 * @property int|null $s3_fisika_kekurangan_lk
 * @property int|null $s3_fisika_kekurangan_pr
 * @property int|null $s3_komputer_keadaan_lk
 * @property int|null $s3_komputer_keadaan_pr
 * @property int|null $s3_komputer_kebutuhan_lk
 * @property int|null $s3_komputer_kebutuhan_pr
 * @property int|null $s3_komputer_kekurangan_lk
 * @property int|null $s3_komputer_kekurangan_pr
 * @property int|null $s3_statistik_keadaan_lk
 * @property int|null $s3_statistik_keadaan_pr
 * @property int|null $s3_statistik_kebutuhan_lk
 * @property int|null $s3_statistik_kebutuhan_pr
 * @property int|null $s3_statistik_kekurangan_lk
 * @property int|null $s3_statistik_kekurangan_pr
 * @property int|null $doktoral_lainnya_keadaan_lk
 * @property int|null $doktoral_lainnya_keadaan_pr
 * @property int|null $doktoral_lainnya_kebutuhan_lk
 * @property int|null $doktoral_lainnya_kebutuhan_pr
 * @property int|null $doktoral_lainnya_kekurangan_lk
 * @property int|null $doktoral_lainnya_kekurangan_pr
 * @property int|null $s2_biologi_keadaan_lk
 * @property int|null $s2_biologi_keadaan_pr
 * @property int|null $s2_biologi_kebutuhan_lk
 * @property int|null $s2_biologi_kebutuhan_pr
 * @property int|null $s2_biologi_kekurangan_lk
 * @property int|null $s2_biologi_kekurangan_pr
 * @property int|null $s2_kimia_keadaan_lk
 * @property int|null $s2_kimia_keadaan_pr
 * @property int|null $s2_kimia_kebutuhan_lk
 * @property int|null $s2_kimia_kebutuhan_pr
 * @property int|null $s2_kimia_kekurangan_lk
 * @property int|null $s2_kimia_kekurangan_pr
 * @property int|null $s2_ekonomiakuntansi_keadaan_lk
 * @property int|null $s2_ekonomiakuntansi_keadaan_pr
 * @property int|null $s2_ekonomiakuntansi_kebutuhan_lk
 * @property int|null $s2_ekonomiakuntansi_kebutuhan_pr
 * @property int|null $s2_ekonomiakuntansi_kekurangan_lk
 * @property int|null $s2_ekonomiakuntansi_kekurangan_pr
 * @property int|null $s2_administrasi_keadaan_lk
 * @property int|null $s2_administrasi_keadaan_pr
 * @property int|null $s2_administrasi_kebutuhan_lk
 * @property int|null $s2_administrasi_kebutuhan_pr
 * @property int|null $s2_administrasi_kekurangan_lk
 * @property int|null $s2_administrasi_kekurangan_pr
 * @property int|null $s2_hukum_keadaan_lk
 * @property int|null $s2_hukum_keadaan_pr
 * @property int|null $s2_hukum_kebutuhan_lk
 * @property int|null $s2_hukum_kebutuhan_pr
 * @property int|null $s2_hukum_kekurangan_lk
 * @property int|null $s2_hukum_kekurangan_pr
 * @property int|null $s2_tehnik_keadaan_lk
 * @property int|null $s2_tehnik_keadaan_pr
 * @property int|null $s2_tehnik_kebutuhan_lk
 * @property int|null $s2_tehnik_kebutuhan_pr
 * @property int|null $s2_tehnik_kekurangan_lk
 * @property int|null $s2_tehnik_kekurangan_pr
 * @property int|null $s2_kesejahteraansosial_keadaan_lk
 * @property int|null $s2_kesejahteraansosial_keadaan_pr
 * @property int|null $s2_kesejahteraansosial_kebutuhan_lk
 * @property int|null $s2_kesejahteraansosial_kebutuhan_pr
 * @property int|null $s2_kesejahteraansosial_kekurangan_lk
 * @property int|null $s2_kesejahteraansosial_kekurangan_pr
 * @property int|null $s2_fisika_keadaan_lk
 * @property int|null $s2_fisika_keadaan_pr
 * @property int|null $s2_fisika_kebutuhan_lk
 * @property int|null $s2_fisika_kebutuhan_pr
 * @property int|null $s2_fisika_kekurangan_lk
 * @property int|null $s2_fisika_kekurangan_pr
 * @property int|null $s2_komputer_keadaan_lk
 * @property int|null $s2_komputer_keadaan_pr
 * @property int|null $s2_komputer_kebutuhan_lk
 * @property int|null $s2_komputer_kebutuhan_pr
 * @property int|null $s2_komputer_kekurangan_lk
 * @property int|null $s2_komputer_kekurangan_pr
 * @property int|null $s2_statistik_keadaan_lk
 * @property int|null $s2_statistik_keadaan_pr
 * @property int|null $s2_statistik_kebutuhan_lk
 * @property int|null $s2_statistik_kebutuhan_pr
 * @property int|null $s2_statistik_kekurangan_lk
 * @property int|null $s2_statistik_kekurangan_pr
 * @property int|null $s2_administrasikesehatanmasyarakat_keadaan_lk
 * @property int|null $s2_administrasikesehatanmasyarakat_keadaan_pr
 * @property int|null $s2_administrasikesehatanmasyarakat_kebutuhan_lk
 * @property int|null $s2_administrasikesehatanmasyarakat_kebutuhan_pr
 * @property int|null $s2_administrasikesehatanmasyarakat_kekurangan_lk
 * @property int|null $s2_administrasikesehatanmasyarakat_kekurangan_pr
 * @property int|null $pasca_sarjanalainnya_keadaan_lk
 * @property int|null $pasca_sarjanalainnya_keadaan_pr
 * @property int|null $pasca_sarjanalainnya_kebutuhan_lk
 * @property int|null $pasca_sarjanalainnya_kebutuhan_pr
 * @property int|null $pasca_sarjanalainnya_kekurangan_lk
 * @property int|null $pasca_sarjanalainnya_kekurangan_pr
 * @property int|null $sarjana_biologi_keadaan_lk
 * @property int|null $sarjana_biologi_keadaan_pr
 * @property int|null $sarjana_biologi_kebutuhan_lk
 * @property int|null $sarjana_biologi_kebutuhan_pr
 * @property int|null $sarjana_biologi_kekurangan_lk
 * @property int|null $sarjana_biologi_kekurangan_pr
 * @property int|null $sarjana_kimia_keadaan_lk
 * @property int|null $sarjana_kimia_keadaan_pr
 * @property int|null $sarjana_kimia_kebutuhan_lk
 * @property int|null $sarjana_kimia_kebutuhan_pr
 * @property int|null $sarjana_kimia_kekurangan_lk
 * @property int|null $sarjana_kimia_kekurangan_pr
 * @property int|null $sarjana_ekonomiakuntansi_keadaan_lk
 * @property int|null $sarjana_ekonomiakuntansi_keadaan_pr
 * @property int|null $sarjana_ekonomiakuntansi_kebutuhan_lk
 * @property int|null $sarjana_ekonomiakuntansi_kebutuhan_pr
 * @property int|null $sarjana_ekonomiakuntansi_kekurangan_lk
 * @property int|null $sarjana_ekonomiakuntansi_kekurangan_pr
 * @property int|null $sarjana_administrasi_keadaan_lk
 * @property int|null $sarjana_administrasi_keadaan_pr
 * @property int|null $sarjana_administrasi_kebutuhan_lk
 * @property int|null $sarjana_administrasi_kebutuhan_pr
 * @property int|null $sarjana_administrasi_kekurangan_lk
 * @property int|null $sarjana_administrasi_kekurangan_pr
 * @property int|null $sarjana_hukum_keadaan_lk
 * @property int|null $sarjana_hukum_keadaan_pr
 * @property int|null $sarjana_hukum_kebutuhan_lk
 * @property int|null $sarjana_hukum_kebutuhan_pr
 * @property int|null $sarjana_hukum_kekurangan_lk
 * @property int|null $sarjana_hukum_kekurangan_pr
 * @property int|null $sarjana_tehnik_keadaan_lk
 * @property int|null $sarjana_tehnik_keadaan_pr
 * @property int|null $sarjana_tehnik_kebutuhan_lk
 * @property int|null $sarjana_tehnik_kebutuhan_pr
 * @property int|null $sarjana_tehnik_kekurangan_lk
 * @property int|null $sarjana_tehnik_kekurangan_pr
 * @property int|null $sarjana_kesejahteraansosial_keadaan_lk
 * @property int|null $sarjana_kesejahteraansosial_keadaan_pr
 * @property int|null $sarjana_kesejahteraansosial_kebutuhan_lk
 * @property int|null $sarjana_kesejahteraansosial_kebutuhan_pr
 * @property int|null $sarjana_kesejahteraansosial_kekurangan_lk
 * @property int|null $sarjana_kesejahteraansosial_kekurangan_pr
 * @property int|null $sarjana_fisika_keadaan_lk
 * @property int|null $sarjana_fisika_keadaan_pr
 * @property int|null $sarjana_fisika_kebutuhan_lk
 * @property int|null $sarjana_fisika_kebutuhan_pr
 * @property int|null $sarjana_fisika_kekurangan_lk
 * @property int|null $sarjana_fisika_kekurangan_pr
 * @property int|null $sarjana_komputer_keadaan_lk
 * @property int|null $sarjana_komputer_keadaan_pr
 * @property int|null $sarjana_komputer_kebutuhan_lk
 * @property int|null $sarjana_komputer_kebutuhan_pr
 * @property int|null $sarjana_komputer_kekurangan_lk
 * @property int|null $sarjana_komputer_kekurangan_pr
 * @property int|null $sarjana_statistik_keadaan_lk
 * @property int|null $sarjana_statistik_keadaan_pr
 * @property int|null $sarjana_statistik_kebutuhan_lk
 * @property int|null $sarjana_statistik_kebutuhan_pr
 * @property int|null $sarjana_statistik_kekurangan_lk
 * @property int|null $sarjana_statistik_kekurangan_pr
 * @property int|null $sarjana_lainnya_keadaan_lk
 * @property int|null $sarjana_lainnya_keadaan_pr
 * @property int|null $sarjana_lainnya_kebutuhan_lk
 * @property int|null $sarjana_lainnya_kebutuhan_pr
 * @property int|null $sarjana_lainnya_kekurangan_lk
 * @property int|null $sarjana_lainnya_kekurangan_pr
 * @property int|null $sarjana_muda_biologi_keadaan_lk
 * @property int|null $sarjana_muda_biologi_keadaan_pr
 * @property int|null $sarjana_muda_biologi_kebutuhan_lk
 * @property int|null $sarjana_muda_biologi_kebutuhan_pr
 * @property int|null $sarjana_muda_biologi_kekurangan_lk
 * @property int|null $sarjana_muda_biologi_kekurangan_pr
 * @property int|null $sarjana_muda_kimia_keadaan_lk
 * @property int|null $sarjana_muda_kimia_keadaan_pr
 * @property int|null $sarjana_muda_kimia_kebutuhan_lk
 * @property int|null $sarjana_muda_kimia_kebutuhan_pr
 * @property int|null $sarjana_muda_kimia_kekurangan_lk
 * @property int|null $sarjana_muda_kimia_kekurangan_pr
 * @property int|null $sarjana_muda_ekonomiakuntansi_keadaan_lk
 * @property int|null $sarjana_muda_ekonomiakuntansi_keadaan_pr
 * @property int|null $sarjana_muda_ekonomiakuntansi_kebutuhan_lk
 * @property int|null $sarjana_muda_ekonomiakuntansi_kebutuhan_pr
 * @property int|null $sarjana_muda_ekonomiakuntansi_kekurangan_lk
 * @property int|null $sarjana_muda_ekonomiakuntansi_kekurangan_pr
 * @property int|null $sarjana_muda_administrasi_keadaan_lk
 * @property int|null $sarjana_muda_administrasi_keadaan_pr
 * @property int|null $sarjana_muda_administrasi_kebutuhan_lk
 * @property int|null $sarjana_muda_administrasi_kebutuhan_pr
 * @property int|null $sarjana_muda_administrasi_kekurangan_lk
 * @property int|null $sarjana_muda_administrasi_kekurangan_pr
 * @property int|null $sarjana_muda_hukum_keadaan_lk
 * @property int|null $sarjana_muda_hukum_keadaan_pr
 * @property int|null $sarjana_muda_hukum_kebutuhan_lk
 * @property int|null $sarjana_muda_hukum_kebutuhan_pr
 * @property int|null $sarjana_muda_hukum_kekurangan_lk
 * @property int|null $sarjana_muda_hukum_kekurangan_pr
 * @property int|null $sarjana_muda_tehnik_keadaan_lk
 * @property int|null $sarjana_muda_tehnik_keadaan_pr
 * @property int|null $sarjana_muda_tehnik_kebutuhan_lk
 * @property int|null $sarjana_muda_tehnik_kebutuhan_pr
 * @property int|null $sarjana_muda_tehnik_kekurangan_lk
 * @property int|null $sarjana_muda_tehnik_kekurangan_pr
 * @property int|null $sarjana_muda_kesejahteraansosial_keadaan_lk
 * @property int|null $sarjana_muda_kesejahteraansosial_keadaan_pr
 * @property int|null $sarjana_muda_kesejahteraansosial_kebutuhan_lk
 * @property int|null $sarjana_muda_kesejahteraansosial_kebutuhan_pr
 * @property int|null $sarjana_muda_kesejahteraansosial_kekurangan_lk
 * @property int|null $sarjana_muda_kesejahteraansosial_kekurangan_pr
 * @property int|null $sarjana_muda_sekretaris_keadaan_lk
 * @property int|null $sarjana_muda_sekretaris_keadaan_pr
 * @property int|null $sarjana_muda_sekretaris_kebutuhan_lk
 * @property int|null $sarjana_muda_sekretaris_kebutuhan_pr
 * @property int|null $sarjana_muda_sekretaris_kekurangan_lk
 * @property int|null $sarjana_muda_sekretaris_kekurangan_pr
 * @property int|null $sarjana_muda_komputer_keadaan_lk
 * @property int|null $sarjana_muda_komputer_keadaan_pr
 * @property int|null $sarjana_muda_komputer_kebutuhan_lk
 * @property int|null $sarjana_muda_komputer_kebutuhan_pr
 * @property int|null $sarjana_muda_komputer_kekurangan_lk
 * @property int|null $sarjana_muda_komputer_kekurangan_pr
 * @property int|null $sarjana_muda_statistik_keadaan_lk
 * @property int|null $sarjana_muda_statistik_keadaan_pr
 * @property int|null $sarjana_muda_statistik_kebutuhan_lk
 * @property int|null $sarjana_muda_statistik_kebutuhan_pr
 * @property int|null $sarjana_muda_statistik_kekurangan_lk
 * @property int|null $sarjana_muda_statistik_kekurangan_pr
 * @property int|null $sarjana_muda_lainnya_keadaan_lk
 * @property int|null $sarjana_muda_lainnya_keadaan_pr
 * @property int|null $sarjana_muda_lainnya_kebutuhan_lk
 * @property int|null $sarjana_muda_lainnya_kebutuhan_pr
 * @property int|null $sarjana_muda_lainnya_kekurangan_lk
 * @property int|null $sarjana_muda_lainnya_kekurangan_pr
 * @property int|null $sma_smu_keadaan_lk
 * @property int|null $sma_smu_keadaan_pr
 * @property int|null $sma_smu_kebutuhan_lk
 * @property int|null $sma_smu_kebutuhan_pr
 * @property int|null $sma_smu_kekurangan_lk
 * @property int|null $sma_smu_kekurangan_pr
 * @property int|null $smea_keadaan_lk
 * @property int|null $smea_keadaan_pr
 * @property int|null $smea_kebutuhan_lk
 * @property int|null $smea_kebutuhan_pr
 * @property int|null $smea_kekurangan_lk
 * @property int|null $smea_kekurangan_pr
 * @property int|null $stm_keadaan_lk
 * @property int|null $stm_keadaan_pr
 * @property int|null $stm_kebutuhan_lk
 * @property int|null $stm_kebutuhan_pr
 * @property int|null $stm_kekurangan_lk
 * @property int|null $stm_kekurangan_pr
 * @property int|null $smkk_keadaan_lk
 * @property int|null $smkk_keadaan_pr
 * @property int|null $smkk_kebutuhan_lk
 * @property int|null $smkk_kebutuhan_pr
 * @property int|null $smkk_kekurangan_lk
 * @property int|null $smkk_kekurangan_pr
 * @property int|null $spsa_keadaan_lk
 * @property int|null $spsa_keadaan_pr
 * @property int|null $spsa_kebutuhan_lk
 * @property int|null $spsa_kebutuhan_pr
 * @property int|null $spsa_kekurangan_lk
 * @property int|null $spsa_kekurangan_pr
 * @property int|null $smtp_keadaan_lk
 * @property int|null $smtp_keadaan_pr
 * @property int|null $smtp_kebutuhan_lk
 * @property int|null $smtp_kebutuhan_pr
 * @property int|null $smtp_kekurangan_lk
 * @property int|null $smtp_kekurangan_pr
 * @property int|null $sd_kebawah_keadaan_lk
 * @property int|null $sd_kebawah_keadaan_pr
 * @property int|null $sd_kebawah_kebutuhan_lk
 * @property int|null $sd_kebawah_kebutuhan_pr
 * @property int|null $sd_kebawah_kekurangan_lk
 * @property int|null $sd_kebawah_kekurangan_pr
 * @property int|null $smta_lainnya_keadaan_lk
 * @property int|null $smta_lainnya_keadaan_pr
 * @property int|null $smta_lainnya_kebutuhan_lk
 * @property int|null $smta_lainnya_kebutuhan_pr
 * @property int|null $smta_lainnya_kekurangan_lk
 * @property int|null $smta_lainnya_kekurangan_pr
 * @property string $created_at
 * @property string|null $updated_by
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class Ketenagaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ketenagaan';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_pengolahan_data');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun'], 'required'],
            [['dokter_umum_keadaan_lk', 'dokter_umum_keadaan_pr', 'dokter_umum_kebutuhan_lk', 'dokter_umum_kebutuhan_pr', 'dokter_umum_kekurangan_lk', 'dokter_umum_kekurangan_pr', 'dokter_ppds_keadaan_lk', 'dokter_ppds_keadaan_pr', 'dokter_ppds_kebutuhan_lk', 'dokter_ppds_kebutuhan_pr', 'dokter_ppds_kekurangan_lk', 'dokter_ppds_kekurangan_pr', 'dokter_spesialisbedah_keadaan_lk', 'dokter_spesialisbedah_keadaan_pr', 'dokter_spesialisbedah_kebutuhan_lk', 'dokter_spesialisbedah_kebutuhan_pr', 'dokter_spesialisbedah_kekurangan_lk', 'dokter_spesialisbedah_kekurangan_pr', 'dokter_spesialispenyakitdalam_keadaan_lk', 'dokter_spesialispenyakitdalam_keadaan_pr', 'dokter_spesialispenyakitdalam_kebutuhan_lk', 'dokter_spesialispenyakitdalam_kebutuhan_pr', 'dokter_spesialispenyakitdalam_kekurangan_lk', 'dokter_spesialispenyakitdalam_kekurangan_pr', 'dokter_spesialiskesehatananak_keadaan_lk', 'dokter_spesialiskesehatananak_keadaan_pr', 'dokter_spesialiskesehatananak_kebutuhan_lk', 'dokter_spesialiskesehatananak_kebutuhan_pr', 'dokter_spesialiskesehatananak_kekurangan_lk', 'dokter_spesialiskesehatananak_kekurangan_pr', 'dokter_spesialisobgin_keadaan_lk', 'dokter_spesialisobgin_keadaan_pr', 'dokter_spesialisobgin_kebutuhan_lk', 'dokter_spesialisobgin_kebutuhan_pr', 'dokter_spesialisobgin_kekurangan_lk', 'dokter_spesialisobgin_kekurangan_pr', 'dokter_spesialisradiologi_keadaan_lk', 'dokter_spesialisradiologi_keadaan_pr', 'dokter_spesialisradiologi_kebutuhan_lk', 'dokter_spesialisradiologi_kebutuhan_pr', 'dokter_spesialisradiologi_kekurangan_lk', 'dokter_spesialisradiologi_kekurangan_pr', 'dokter_spesialisonkologiradiasi_keadaan_lk', 'dokter_spesialisonkologiradiasi_keadaan_pr', 'dokter_spesialisonkologiradiasi_kebutuhan_lk', 'dokter_spesialisonkologiradiasi_kebutuhan_pr', 'dokter_spesialisonkologiradiasi_kekurangan_lk', 'dokter_spesialisonkologiradiasi_kekurangan_pr', 'dokter_spesialiskedokterannulir_keadaan_lk', 'dokter_spesialiskedokterannulir_keadaan_pr', 'dokter_spesialiskedokterannulir_kebutuhan_lk', 'dokter_spesialiskedokterannulir_kebutuhan_pr', 'dokter_spesialiskedokterannulir_kekurangan_lk', 'dokter_spesialiskedokterannulir_kekurangan_pr', 'dokter_spesialisanesthesi_keadaan_lk', 'dokter_spesialisanesthesi_keadaan_pr', 'dokter_spesialisanesthesi_kebutuhan_lk', 'dokter_spesialisanesthesi_kebutuhan_pr', 'dokter_spesialisanesthesi_kekurangan_lk', 'dokter_spesialisanesthesi_kekurangan_pr', 'dokter_spesialispatologiklinik_keadaan_lk', 'dokter_spesialispatologiklinik_keadaan_pr', 'dokter_spesialispatologiklinik_kebutuhan_lk', 'dokter_spesialispatologiklinik_kebutuhan_pr', 'dokter_spesialispatologiklinik_kekurangan_lk', 'dokter_spesialispatologiklinik_kekurangan_pr', 'dokter_spesialisjiwa_keadaan_lk', 'dokter_spesialisjiwa_keadaan_pr', 'dokter_spesialisjiwa_kebutuhan_lk', 'dokter_spesialisjiwa_kebutuhan_pr', 'dokter_spesialisjiwa_kekurangan_lk', 'dokter_spesialisjiwa_kekurangan_pr', 'dokter_spesialismata_keadaan_lk', 'dokter_spesialismata_keadaan_pr', 'dokter_spesialismata_kebutuhan_lk', 'dokter_spesialismata_kebutuhan_pr', 'dokter_spesialismata_kekurangan_lk', 'dokter_spesialismata_kekurangan_pr', 'dokter_spesialistht_keadaan_lk', 'dokter_spesialistht_keadaan_pr', 'dokter_spesialistht_kebutuhan_lk', 'dokter_spesialistht_kebutuhan_pr', 'dokter_spesialistht_kekurangan_lk', 'dokter_spesialistht_kekurangan_pr', 'dokter_spesialiskulitkelamin_keadaan_lk', 'dokter_spesialiskulitkelamin_keadaan_pr', 'dokter_spesialiskulitkelamin_kebutuhan_lk', 'dokter_spesialiskulitkelamin_kebutuhan_pr', 'dokter_spesialiskulitkelamin_kekurangan_lk', 'dokter_spesialiskulitkelamin_kekurangan_pr', 'dokter_spesialiskardiologi_keadaan_lk', 'dokter_spesialiskardiologi_keadaan_pr', 'dokter_spesialiskardiologi_kebutuhan_lk', 'dokter_spesialiskardiologi_kebutuhan_pr', 'dokter_spesialiskardiologi_kekurangan_lk', 'dokter_spesialiskardiologi_kekurangan_pr', 'dokter_spesialisparu_keadaan_lk', 'dokter_spesialisparu_keadaan_pr', 'dokter_spesialisparu_kebutuhan_lk', 'dokter_spesialisparu_kebutuhan_pr', 'dokter_spesialisparu_kekurangan_lk', 'dokter_spesialisparu_kekurangan_pr', 'dokter_spesialissaraf_keadaan_lk', 'dokter_spesialissaraf_keadaan_pr', 'dokter_spesialissaraf_kebutuhan_lk', 'dokter_spesialissaraf_kebutuhan_pr', 'dokter_spesialissaraf_kekurangan_lk', 'dokter_spesialissaraf_kekurangan_pr', 'dokter_spesialisbedahsaraf_keadaan_lk', 'dokter_spesialisbedahsaraf_keadaan_pr', 'dokter_spesialisbedahsaraf_kebutuhan_lk', 'dokter_spesialisbedahsaraf_kebutuhan_pr', 'dokter_spesialisbedahsaraf_kekurangan_lk', 'dokter_spesialisbedahsaraf_kekurangan_pr', 'dokter_spesialisbedahorthopedi_keadaan_lk', 'dokter_spesialisbedahorthopedi_keadaan_pr', 'dokter_spesialisbedahorthopedi_kebutuhan_lk', 'dokter_spesialisbedahorthopedi_kebutuhan_pr', 'dokter_spesialisbedahorthopedi_kekurangan_lk', 'dokter_spesialisbedahorthopedi_kekurangan_pr', 'dokter_spesialisurologi_keadaan_lk', 'dokter_spesialisurologi_keadaan_pr', 'dokter_spesialisurologi_kebutuhan_lk', 'dokter_spesialisurologi_kebutuhan_pr', 'dokter_spesialisurologi_kekurangan_lk', 'dokter_spesialisurologi_kekurangan_pr', 'dokter_spesialispatologianatomi_keadaan_lk', 'dokter_spesialispatologianatomi_keadaan_pr', 'dokter_spesialispatologianatomi_kebutuhan_lk', 'dokter_spesialispatologianatomi_kebutuhan_pr', 'dokter_spesialispatologianatomi_kekurangan_lk', 'dokter_spesialispatologianatomi_kekurangan_pr', 'dokter_spesialispatologiforensik_keadaan_lk', 'dokter_spesialispatologiforensik_keadaan_pr', 'dokter_spesialispatologiforensik_kebutuhan_lk', 'dokter_spesialispatologiforensik_kebutuhan_pr', 'dokter_spesialispatologiforensik_kekurangan_lk', 'dokter_spesialispatologiforensik_kekurangan_pr', 'dokter_spesialisrehabilitasimedik_keadaan_lk', 'dokter_spesialisrehabilitasimedik_keadaan_pr', 'dokter_spesialisrehabilitasimedik_kebutuhan_lk', 'dokter_spesialisrehabilitasimedik_kebutuhan_pr', 'dokter_spesialisrehabilitasimedik_kekurangan_lk', 'dokter_spesialisrehabilitasimedik_kekurangan_pr', 'dokter_spesialisbedahplastik_keadaan_lk', 'dokter_spesialisbedahplastik_keadaan_pr', 'dokter_spesialisbedahplastik_kebutuhan_lk', 'dokter_spesialisbedahplastik_kebutuhan_pr', 'dokter_spesialisbedahplastik_kekurangan_lk', 'dokter_spesialisbedahplastik_kekurangan_pr', 'dokter_spesialiskedokteranolahraga_keadaan_lk', 'dokter_spesialiskedokteranolahraga_keadaan_pr', 'dokter_spesialiskedokteranolahraga_kebutuhan_lk', 'dokter_spesialiskedokteranolahraga_kebutuhan_pr', 'dokter_spesialiskedokteranolahraga_kekurangan_lk', 'dokter_spesialiskedokteranolahraga_kekurangan_pr', 'dokter_spesialismikrobiologiklinik_keadaan_lk', 'dokter_spesialismikrobiologiklinik_keadaan_pr', 'dokter_spesialismikrobiologiklinik_kebutuhan_lk', 'dokter_spesialismikrobiologiklinik_kebutuhan_pr', 'dokter_spesialismikrobiologiklinik_kekurangan_lk', 'dokter_spesialismikrobiologiklinik_kekurangan_pr', 'dokter_spesialisparasitologiklinik_keadaan_lk', 'dokter_spesialisparasitologiklinik_keadaan_pr', 'dokter_spesialisparasitologiklinik_kebutuhan_lk', 'dokter_spesialisparasitologiklinik_kebutuhan_pr', 'dokter_spesialisparasitologiklinik_kekurangan_lk', 'dokter_spesialisparasitologiklinik_kekurangan_pr', 'dokter_spesialisgizimedik_keadaan_lk', 'dokter_spesialisgizimedik_keadaan_pr', 'dokter_spesialisgizimedik_kebutuhan_lk', 'dokter_spesialisgizimedik_kebutuhan_pr', 'dokter_spesialisgizimedik_kekurangan_lk', 'dokter_spesialisgizimedik_kekurangan_pr', 'dokter_spesialisfarmaklinik_keadaan_lk', 'dokter_spesialisfarmaklinik_keadaan_pr', 'dokter_spesialisfarmaklinik_kebutuhan_lk', 'dokter_spesialisfarmaklinik_kebutuhan_pr', 'dokter_spesialisfarmaklinik_kekurangan_lk', 'dokter_spesialisfarmaklinik_kekurangan_pr', 'dokter_spesialislainnya_keadaan_lk', 'dokter_spesialislainnya_keadaan_pr', 'dokter_spesialislainnya_kebutuhan_lk', 'dokter_spesialislainnya_kebutuhan_pr', 'dokter_spesialislainnya_kekurangan_lk', 'dokter_spesialislainnya_kekurangan_pr', 'dokter_subspesialislainnya_keadaan_lk', 'dokter_subspesialislainnya_keadaan_pr', 'dokter_subspesialislainnya_kebutuhan_lk', 'dokter_subspesialislainnya_kebutuhan_pr', 'dokter_subspesialislainnya_kekurangan_lk', 'dokter_subspesialislainnya_kekurangan_pr', 'dokter_gigi_keadaan_lk', 'dokter_gigi_keadaan_pr', 'dokter_gigi_kebutuhan_lk', 'dokter_gigi_kebutuhan_pr', 'dokter_gigi_kekurangan_lk', 'dokter_gigi_kekurangan_pr', 'dokter_gigi_spesialis_keadaan_lk', 'dokter_gigi_spesialis_keadaan_pr', 'dokter_gigi_spesialis_kebutuhan_lk', 'dokter_gigi_spesialis_kebutuhan_pr', 'dokter_gigi_spesialis_kekurangan_lk', 'dokter_gigi_spesialis_kekurangan_pr', 'dokter_doktergigimhamars_keadaan_lk', 'dokter_doktergigimhamars_keadaan_pr', 'dokter_doktergigimhamars_kebutuhan_lk', 'dokter_doktergigimhamars_kebutuhan_pr', 'dokter_doktergigimhamars_kekurangan_lk', 'dokter_doktergigimhamars_kekurangan_pr', 'dokter_doktergigis2s3kesehatanmasyarakat_keadaan_lk', 'dokter_doktergigis2s3kesehatanmasyarakat_keadaan_pr', 'dokter_doktergigis2s3kesehatanmasyarakat_kebutuhan_lk', 'dokter_doktergigis2s3kesehatanmasyarakat_kebutuhan_pr', 'dokter_doktergigis2s3kesehatanmasyarakat_kekurangan_lk', 'dokter_doktergigis2s3kesehatanmasyarakat_kekurangan_pr', 's3_dokterkonsultan_keadaan_lk', 's3_dokterkonsultan_keadaan_pr', 's3_dokterkonsultan_kebutuhan_lk', 's3_dokterkonsultan_kebutuhan_pr', 's3_dokterkonsultan_kekurangan_lk', 's3_dokterkonsultan_kekurangan_pr', 's3_keperawatan_keadaan_lk', 's3_keperawatan_keadaan_pr', 's3_keperawatan_kebutuhan_lk', 's3_keperawatan_kebutuhan_pr', 's3_keperawatan_kekurangan_lk', 's3_keperawatan_kekurangan_pr', 's2_keperawatan_keadaan_lk', 's2_keperawatan_keadaan_pr', 's2_keperawatan_kebutuhan_lk', 's2_keperawatan_kebutuhan_pr', 's2_keperawatan_kekurangan_lk', 's2_keperawatan_kekurangan_pr', 's1_keperawatan_keadaan_lk', 's1_keperawatan_keadaan_pr', 's1_keperawatan_kebutuhan_lk', 's1_keperawatan_kebutuhan_pr', 's1_keperawatan_kekurangan_lk', 's1_keperawatan_kekurangan_pr', 'd4_keperawatan_keadaan_lk', 'd4_keperawatan_keadaan_pr', 'd4_keperawatan_kebutuhan_lk', 'd4_keperawatan_kebutuhan_pr', 'd4_keperawatan_kekurangan_lk', 'd4_keperawatan_kekurangan_pr', 'perawat_vokasional_keadaan_lk', 'perawat_vokasional_keadaan_pr', 'perawat_vokasional_kebutuhan_lk', 'perawat_vokasional_kebutuhan_pr', 'perawat_vokasional_kekurangan_lk', 'perawat_vokasional_kekurangan_pr', 'perawat_spesialis_keadaan_lk', 'perawat_spesialis_keadaan_pr', 'perawat_spesialis_kebutuhan_lk', 'perawat_spesialis_kebutuhan_pr', 'perawat_spesialis_kekurangan_lk', 'perawat_spesialis_kekurangan_pr', 'pembantu_keperawatan_keadaan_lk', 'pembantu_keperawatan_keadaan_pr', 'pembantu_keperawatan_kebutuhan_lk', 'pembantu_keperawatan_kebutuhan_pr', 'pembantu_keperawatan_kekurangan_lk', 'pembantu_keperawatan_kekurangan_pr', 's3_kebidanan_keadaan_lk', 's3_kebidanan_keadaan_pr', 's3_kebidanan_kebutuhan_lk', 's3_kebidanan_kebutuhan_pr', 's3_kebidanan_kekurangan_lk', 's3_kebidanan_kekurangan_pr', 's2_kebidanan_keadaan_lk', 's2_kebidanan_keadaan_pr', 's2_kebidanan_kebutuhan_lk', 's2_kebidanan_kebutuhan_pr', 's2_kebidanan_kekurangan_lk', 's2_kebidanan_kekurangan_pr', 's1_kebidanan_keadaan_lk', 's1_kebidanan_keadaan_pr', 's1_kebidanan_kebutuhan_lk', 's1_kebidanan_kebutuhan_pr', 's1_kebidanan_kekurangan_lk', 's1_kebidanan_kekurangan_pr', 'd3_kebidanan_keadaan_lk', 'd3_kebidanan_keadaan_pr', 'd3_kebidanan_kebutuhan_lk', 'd3_kebidanan_kebutuhan_pr', 'd3_kebidanan_kekurangan_lk', 'd3_kebidanan_kekurangan_pr', 'tenaga_keperawatanlainnya_keadaan_lk', 'tenaga_keperawatanlainnya_keadaan_pr', 'tenaga_keperawatanlainnya_kebutuhan_lk', 'tenaga_keperawatanlainnya_kebutuhan_pr', 'tenaga_keperawatanlainnya_kekurangan_lk', 'tenaga_keperawatanlainnya_kekurangan_pr', 's3_farmasiapoteker_keadaan_lk', 's3_farmasiapoteker_keadaan_pr', 's3_farmasiapoteker_kebutuhan_lk', 's3_farmasiapoteker_kebutuhan_pr', 's3_farmasiapoteker_kekurangan_lk', 's3_farmasiapoteker_kekurangan_pr', 's2_farmasiapoteker_keadaan_lk', 's2_farmasiapoteker_keadaan_pr', 's2_farmasiapoteker_kebutuhan_lk', 's2_farmasiapoteker_kebutuhan_pr', 's2_farmasiapoteker_kekurangan_lk', 's2_farmasiapoteker_kekurangan_pr', 'apoteker_keadaan_lk', 'apoteker_keadaan_pr', 'apoteker_kebutuhan_lk', 'apoteker_kebutuhan_pr', 'apoteker_kekurangan_lk', 'apoteker_kekurangan_pr', 's3_farmasifarmakologikimia_keadaan_lk', 's3_farmasifarmakologikimia_keadaan_pr', 's3_farmasifarmakologikimia_kebutuhan_lk', 's3_farmasifarmakologikimia_kebutuhan_pr', 's3_farmasifarmakologikimia_kekurangan_lk', 's3_farmasifarmakologikimia_kekurangan_pr', 's1_farmasiapoteker_keadaan_lk', 's1_farmasiapoteker_keadaan_pr', 's1_farmasiapoteker_kebutuhan_lk', 's1_farmasiapoteker_kebutuhan_pr', 's1_farmasiapoteker_kekurangan_lk', 's1_farmasiapoteker_kekurangan_pr', 'akafarma_keadaan_lk', 'akafarma_keadaan_pr', 'akafarma_kebutuhan_lk', 'akafarma_kebutuhan_pr', 'akafarma_kekurangan_lk', 'akafarma_kekurangan_pr', 'akfar_keadaan_lk', 'akfar_keadaan_pr', 'akfar_kebutuhan_lk', 'akfar_kebutuhan_pr', 'akfar_kekurangan_lk', 'akfar_kekurangan_pr', 'analis_farmasi_keadaan_lk', 'analis_farmasi_keadaan_pr', 'analis_farmasi_kebutuhan_lk', 'analis_farmasi_kebutuhan_pr', 'analis_farmasi_kekurangan_lk', 'analis_farmasi_kekurangan_pr', 'asisten_apoteker_keadaan_lk', 'asisten_apoteker_keadaan_pr', 'asisten_apoteker_kebutuhan_lk', 'asisten_apoteker_kebutuhan_pr', 'asisten_apoteker_kekurangan_lk', 'asisten_apoteker_kekurangan_pr', 's1_farmasiapotekersmf_keadaan_lk', 's1_farmasiapotekersmf_keadaan_pr', 's1_farmasiapotekersmf_kebutuhan_lk', 's1_farmasiapotekersmf_kebutuhan_pr', 's1_farmasiapotekersmf_kekurangan_lk', 's1_farmasiapotekersmf_kekurangan_pr', 'st_lab_kimia_farmasi_keadaan_lk', 'st_lab_kimia_farmasi_keadaan_pr', 'st_lab_kimia_farmasi_kebutuhan_lk', 'st_lab_kimia_farmasi_kebutuhan_pr', 'st_lab_kimia_farmasi_kekurangan_lk', 'st_lab_kimia_farmasi_kekurangan_pr', 'tenaga_kefarmasianlainnya_keadaan_lk', 'tenaga_kefarmasianlainnya_keadaan_pr', 'tenaga_kefarmasianlainnya_kebutuhan_lk', 'tenaga_kefarmasianlainnya_kebutuhan_pr', 'tenaga_kefarmasianlainnya_kekurangan_lk', 'tenaga_kefarmasianlainnya_kekurangan_pr', 's3_kesehatan_masyarakatan_keadaan_lk', 's3_kesehatan_masyarakatan_keadaan_pr', 's3_kesehatan_masyarakatan_kebutuhan_lk', 's3_kesehatan_masyarakatan_kebutuhan_pr', 's3_kesehatan_masyarakatan_kekurangan_lk', 's3_kesehatan_masyarakatan_kekurangan_pr', 's3_epidemologi_keadaan_lk', 's3_epidemologi_keadaan_pr', 's3_epidemologi_kebutuhan_lk', 's3_epidemologi_kebutuhan_pr', 's3_epidemologi_kekurangan_lk', 's3_epidemologi_kekurangan_pr', 's3_psikologi_keadaan_lk', 's3_psikologi_keadaan_pr', 's3_psikologi_kebutuhan_lk', 's3_psikologi_kebutuhan_pr', 's3_psikologi_kekurangan_lk', 's3_psikologi_kekurangan_pr', 's2_kesehatan_masyarakatan_keadaan_lk', 's2_kesehatan_masyarakatan_keadaan_pr', 's2_kesehatan_masyarakatan_kebutuhan_lk', 's2_kesehatan_masyarakatan_kebutuhan_pr', 's2_kesehatan_masyarakatan_kekurangan_lk', 's2_kesehatan_masyarakatan_kekurangan_pr', 's2_epidemologi_keadaan_lk', 's2_epidemologi_keadaan_pr', 's2_epidemologi_kebutuhan_lk', 's2_epidemologi_kebutuhan_pr', 's2_epidemologi_kekurangan_lk', 's2_epidemologi_kekurangan_pr', 's2_biomedik_keadaan_lk', 's2_biomedik_keadaan_pr', 's2_biomedik_kebutuhan_lk', 's2_biomedik_kebutuhan_pr', 's2_biomedik_kekurangan_lk', 's2_biomedik_kekurangan_pr', 's2_psikologi_keadaan_lk', 's2_psikologi_keadaan_pr', 's2_psikologi_kebutuhan_lk', 's2_psikologi_kebutuhan_pr', 's2_psikologi_kekurangan_lk', 's2_psikologi_kekurangan_pr', 's1_kesehatan_masyarakat_keadaan_lk', 's1_kesehatan_masyarakat_keadaan_pr', 's1_kesehatan_masyarakat_kebutuhan_lk', 's1_kesehatan_masyarakat_kebutuhan_pr', 's1_kesehatan_masyarakat_kekurangan_lk', 's1_kesehatan_masyarakat_kekurangan_pr', 's1_psikologi_keadaan_lk', 's1_psikologi_keadaan_pr', 's1_psikologi_kebutuhan_lk', 's1_psikologi_kebutuhan_pr', 's1_psikologi_kekurangan_lk', 's1_psikologi_kekurangan_pr', 'd3_kesehatan_masyarakat_keadaan_lk', 'd3_kesehatan_masyarakat_keadaan_pr', 'd3_kesehatan_masyarakat_kebutuhan_lk', 'd3_kesehatan_masyarakat_kebutuhan_pr', 'd3_kesehatan_masyarakat_kekurangan_lk', 'd3_kesehatan_masyarakat_kekurangan_pr', 'd3_sanitarian_keadaan_lk', 'd3_sanitarian_keadaan_pr', 'd3_sanitarian_kebutuhan_lk', 'd3_sanitarian_kebutuhan_pr', 'd3_sanitarian_kekurangan_lk', 'd3_sanitarian_kekurangan_pr', 'tenaga_kesehatan_masyarakatlainnya_keadaan_lk', 'tenaga_kesehatan_masyarakatlainnya_keadaan_pr', 'tenaga_kesehatan_masyarakatlainnya_kebutuhan_lk', 'tenaga_kesehatan_masyarakatlainnya_kebutuhan_pr', 'tenaga_kesehatan_masyarakatlainnya_kekurangan_lk', 'tenaga_kesehatan_masyarakatlainnya_kekurangan_pr', 's3_gizi_dietisien_keadaan_lk', 's3_gizi_dietisien_keadaan_pr', 's3_gizi_dietisien_kebutuhan_lk', 's3_gizi_dietisien_kebutuhan_pr', 's3_gizi_dietisien_kekurangan_lk', 's3_gizi_dietisien_kekurangan_pr', 's2_gizi_dietisien_keadaan_lk', 's2_gizi_dietisien_keadaan_pr', 's2_gizi_dietisien_kebutuhan_lk', 's2_gizi_dietisien_kebutuhan_pr', 's2_gizi_dietisien_kekurangan_lk', 's2_gizi_dietisien_kekurangan_pr', 's1_gizi_dietisien_keadaan_lk', 's1_gizi_dietisien_keadaan_pr', 's1_gizi_dietisien_kebutuhan_lk', 's1_gizi_dietisien_kebutuhan_pr', 's1_gizi_dietisien_kekurangan_lk', 's1_gizi_dietisien_kekurangan_pr', 'd4_gizi_dietisien_keadaan_lk', 'd4_gizi_dietisien_keadaan_pr', 'd4_gizi_dietisien_kebutuhan_lk', 'd4_gizi_dietisien_kebutuhan_pr', 'd4_gizi_dietisien_kekurangan_lk', 'd4_gizi_dietisien_kekurangan_pr', 'd3_gizi_dietisien_keadaan_lk', 'd3_gizi_dietisien_keadaan_pr', 'd3_gizi_dietisien_kebutuhan_lk', 'd3_gizi_dietisien_kebutuhan_pr', 'd3_gizi_dietisien_kekurangan_lk', 'd3_gizi_dietisien_kekurangan_pr', 'd1_gizi_dietisien_keadaan_lk', 'd1_gizi_dietisien_keadaan_pr', 'd1_gizi_dietisien_kebutuhan_lk', 'd1_gizi_dietisien_kebutuhan_pr', 'd1_gizi_dietisien_kekurangan_lk', 'd1_gizi_dietisien_kekurangan_pr', 'tenaga_gizilainnya_keadaan_lk', 'tenaga_gizilainnya_keadaan_pr', 'tenaga_gizilainnya_kebutuhan_lk', 'tenaga_gizilainnya_kebutuhan_pr', 'tenaga_gizilainnya_kekurangan_lk', 'tenaga_gizilainnya_kekurangan_pr', 's1_fisioterapis_keadaan_lk', 's1_fisioterapis_keadaan_pr', 's1_fisioterapis_kebutuhan_lk', 's1_fisioterapis_kebutuhan_pr', 's1_fisioterapis_kekurangan_lk', 's1_fisioterapis_kekurangan_pr', 'd3_fisioterapis_keadaan_lk', 'd3_fisioterapis_keadaan_pr', 'd3_fisioterapis_kebutuhan_lk', 'd3_fisioterapis_kebutuhan_pr', 'd3_fisioterapis_kekurangan_lk', 'd3_fisioterapis_kekurangan_pr', 'd3_okupasiterapis_keadaan_lk', 'd3_okupasiterapis_keadaan_pr', 'd3_okupasiterapis_kebutuhan_lk', 'd3_okupasiterapis_kebutuhan_pr', 'd3_okupasiterapis_kekurangan_lk', 'd3_okupasiterapis_kekurangan_pr', 'd3_terapiwicara_keadaan_lk', 'd3_terapiwicara_keadaan_pr', 'd3_terapiwicara_kebutuhan_lk', 'd3_terapiwicara_kebutuhan_pr', 'd3_terapiwicara_kekurangan_lk', 'd3_terapiwicara_kekurangan_pr', 'd3_orthopedi_keadaan_lk', 'd3_orthopedi_keadaan_pr', 'd3_orthopedi_kebutuhan_lk', 'd3_orthopedi_kebutuhan_pr', 'd3_orthopedi_kekurangan_lk', 'd3_orthopedi_kekurangan_pr', 'd3_akupuntur_keadaan_lk', 'd3_akupuntur_keadaan_pr', 'd3_akupuntur_kebutuhan_lk', 'd3_akupuntur_kebutuhan_pr', 'd3_akupuntur_kekurangan_lk', 'd3_akupuntur_kekurangan_pr', 'tenaga_keterapianfisiklainnya_keadaan_lk', 'tenaga_keterapianfisiklainnya_keadaan_pr', 'tenaga_keterapianfisiklainnya_kebutuhan_lk', 'tenaga_keterapianfisiklainnya_kebutuhan_pr', 'tenaga_keterapianfisiklainnya_kekurangan_lk', 'tenaga_keterapianfisiklainnya_kekurangan_pr', 's3_optoelektronikaapllaser_keadaan_lk', 's3_optoelektronikaapllaser_keadaan_pr', 's3_optoelektronikaapllaser_kebutuhan_lk', 's3_optoelektronikaapllaser_kebutuhan_pr', 's3_optoelektronikaapllaser_kekurangan_lk', 's3_optoelektronikaapllaser_kekurangan_pr', 's2_optoelektronikaapllaser_keadaan_lk', 's2_optoelektronikaapllaser_keadaan_pr', 's2_optoelektronikaapllaser_kebutuhan_lk', 's2_optoelektronikaapllaser_kebutuhan_pr', 's2_optoelektronikaapllaser_kekurangan_lk', 's2_optoelektronikaapllaser_kekurangan_pr', 'radiografer_keadaan_lk', 'radiografer_keadaan_pr', 'radiografer_kebutuhan_lk', 'radiografer_kebutuhan_pr', 'radiografer_kekurangan_lk', 'radiografer_kekurangan_pr', 'radioterapis_nondokter_keadaan_lk', 'radioterapis_nondokter_keadaan_pr', 'radioterapis_nondokter_kebutuhan_lk', 'radioterapis_nondokter_kebutuhan_pr', 'radioterapis_nondokter_kekurangan_lk', 'radioterapis_nondokter_kekurangan_pr', 'd4_fisikamedik_keadaan_lk', 'd4_fisikamedik_keadaan_pr', 'd4_fisikamedik_kebutuhan_lk', 'd4_fisikamedik_kebutuhan_pr', 'd4_fisikamedik_kekurangan_lk', 'd4_fisikamedik_kekurangan_pr', 'd3_teknikgigi_keadaan_lk', 'd3_teknikgigi_keadaan_pr', 'd3_teknikgigi_kebutuhan_lk', 'd3_teknikgigi_kebutuhan_pr', 'd3_teknikgigi_kekurangan_lk', 'd3_teknikgigi_kekurangan_pr', 'd3_teknikradiologiradioterapi_keadaan_lk', 'd3_teknikradiologiradioterapi_keadaan_pr', 'd3_teknikradiologiradioterapi_kebutuhan_lk', 'd3_teknikradiologiradioterapi_kebutuhan_pr', 'd3_teknikradiologiradioterapi_kekurangan_lk', 'd3_teknikradiologiradioterapi_kekurangan_pr', 'd3_refraksionisoptisien_keadaan_lk', 'd3_refraksionisoptisien_keadaan_pr', 'd3_refraksionisoptisien_kebutuhan_lk', 'd3_refraksionisoptisien_kebutuhan_pr', 'd3_refraksionisoptisien_kekurangan_lk', 'd3_refraksionisoptisien_kekurangan_pr', 'd3_perekammedis_keadaan_lk', 'd3_perekammedis_keadaan_pr', 'd3_perekammedis_kebutuhan_lk', 'd3_perekammedis_kebutuhan_pr', 'd3_perekammedis_kekurangan_lk', 'd3_perekammedis_kekurangan_pr', 'd3_teknikelektromedik_keadaan_lk', 'd3_teknikelektromedik_keadaan_pr', 'd3_teknikelektromedik_kebutuhan_lk', 'd3_teknikelektromedik_kebutuhan_pr', 'd3_teknikelektromedik_kekurangan_lk', 'd3_teknikelektromedik_kekurangan_pr', 'd3_analiskesehatan_keadaan_lk', 'd3_analiskesehatan_keadaan_pr', 'd3_analiskesehatan_kebutuhan_lk', 'd3_analiskesehatan_kebutuhan_pr', 'd3_analiskesehatan_kekurangan_lk', 'd3_analiskesehatan_kekurangan_pr', 'd3_informasikesehatan_keadaan_lk', 'd3_informasikesehatan_keadaan_pr', 'd3_informasikesehatan_kebutuhan_lk', 'd3_informasikesehatan_kebutuhan_pr', 'd3_informasikesehatan_kekurangan_lk', 'd3_informasikesehatan_kekurangan_pr', 'd3_kardiovaskular_keadaan_lk', 'd3_kardiovaskular_keadaan_pr', 'd3_kardiovaskular_kebutuhan_lk', 'd3_kardiovaskular_kebutuhan_pr', 'd3_kardiovaskular_kekurangan_lk', 'd3_kardiovaskular_kekurangan_pr', 'd3_orthotikprostetik_keadaan_lk', 'd3_orthotikprostetik_keadaan_pr', 'd3_orthotikprostetik_kebutuhan_lk', 'd3_orthotikprostetik_kebutuhan_pr', 'd3_orthotikprostetik_kekurangan_lk', 'd3_orthotikprostetik_kekurangan_pr', 'd1_tekniktranfusi_keadaan_lk', 'd1_tekniktranfusi_keadaan_pr', 'd1_tekniktranfusi_kebutuhan_lk', 'd1_tekniktranfusi_kebutuhan_pr', 'd1_tekniktranfusi_kekurangan_lk', 'd1_tekniktranfusi_kekurangan_pr', 'teknisi_gigi_keadaan_lk', 'teknisi_gigi_keadaan_pr', 'teknisi_gigi_kebutuhan_lk', 'teknisi_gigi_kebutuhan_pr', 'teknisi_gigi_kekurangan_lk', 'teknisi_gigi_kekurangan_pr', 'tenaga_itteknologinano_keadaan_lk', 'tenaga_itteknologinano_keadaan_pr', 'tenaga_itteknologinano_kebutuhan_lk', 'tenaga_itteknologinano_kebutuhan_pr', 'tenaga_itteknologinano_kekurangan_lk', 'tenaga_itteknologinano_kekurangan_pr', 'teknisi_patologianatomi_keadaan_lk', 'teknisi_patologianatomi_keadaan_pr', 'teknisi_patologianatomi_kebutuhan_lk', 'teknisi_patologianatomi_kebutuhan_pr', 'teknisi_patologianatomi_kekurangan_lk', 'teknisi_patologianatomi_kekurangan_pr', 'teknisi_kardiovaskular_keadaan_lk', 'teknisi_kardiovaskular_keadaan_pr', 'teknisi_kardiovaskular_kebutuhan_lk', 'teknisi_kardiovaskular_kebutuhan_pr', 'teknisi_kardiovaskular_kekurangan_lk', 'teknisi_kardiovaskular_kekurangan_pr', 'teknisi_elektromedis_keadaan_lk', 'teknisi_elektromedis_keadaan_pr', 'teknisi_elektromedis_kebutuhan_lk', 'teknisi_elektromedis_kebutuhan_pr', 'teknisi_elektromedis_kekurangan_lk', 'teknisi_elektromedis_kekurangan_pr', 'akupuntur_terapi_keadaan_lk', 'akupuntur_terapi_keadaan_pr', 'akupuntur_terapi_kebutuhan_lk', 'akupuntur_terapi_kebutuhan_pr', 'akupuntur_terapi_kekurangan_lk', 'akupuntur_terapi_kekurangan_pr', 'analis_kesehatan_keadaan_lk', 'analis_kesehatan_keadaan_pr', 'analis_kesehatan_kebutuhan_lk', 'analis_kesehatan_kebutuhan_pr', 'analis_kesehatan_kekurangan_lk', 'analis_kesehatan_kekurangan_pr', 'tenaga_keteknisianmedislainnya_keadaan_lk', 'tenaga_keteknisianmedislainnya_keadaan_pr', 'tenaga_keteknisianmedislainnya_kebutuhan_lk', 'tenaga_keteknisianmedislainnya_kebutuhan_pr', 'tenaga_keteknisianmedislainnya_kekurangan_lk', 'tenaga_keteknisianmedislainnya_kekurangan_pr', 's3_biologi_keadaan_lk', 's3_biologi_keadaan_pr', 's3_biologi_kebutuhan_lk', 's3_biologi_kebutuhan_pr', 's3_biologi_kekurangan_lk', 's3_biologi_kekurangan_pr', 's3_kimia_keadaan_lk', 's3_kimia_keadaan_pr', 's3_kimia_kebutuhan_lk', 's3_kimia_kebutuhan_pr', 's3_kimia_kekurangan_lk', 's3_kimia_kekurangan_pr', 's3_ekonomiakuntansi_keadaan_lk', 's3_ekonomiakuntansi_keadaan_pr', 's3_ekonomiakuntansi_kebutuhan_lk', 's3_ekonomiakuntansi_kebutuhan_pr', 's3_ekonomiakuntansi_kekurangan_lk', 's3_ekonomiakuntansi_kekurangan_pr', 's3_administrasi_keadaan_lk', 's3_administrasi_keadaan_pr', 's3_administrasi_kebutuhan_lk', 's3_administrasi_kebutuhan_pr', 's3_administrasi_kekurangan_lk', 's3_administrasi_kekurangan_pr', 's3_hukum_keadaan_lk', 's3_hukum_keadaan_pr', 's3_hukum_kebutuhan_lk', 's3_hukum_kebutuhan_pr', 's3_hukum_kekurangan_lk', 's3_hukum_kekurangan_pr', 's3_tehnik_keadaan_lk', 's3_tehnik_keadaan_pr', 's3_tehnik_kebutuhan_lk', 's3_tehnik_kebutuhan_pr', 's3_tehnik_kekurangan_lk', 's3_tehnik_kekurangan_pr', 's3_kesejahteraansosial_keadaan_lk', 's3_kesejahteraansosial_keadaan_pr', 's3_kesejahteraansosial_kebutuhan_lk', 's3_kesejahteraansosial_kebutuhan_pr', 's3_kesejahteraansosial_kekurangan_lk', 's3_kesejahteraansosial_kekurangan_pr', 's3_fisika_keadaan_lk', 's3_fisika_keadaan_pr', 's3_fisika_kebutuhan_lk', 's3_fisika_kebutuhan_pr', 's3_fisika_kekurangan_lk', 's3_fisika_kekurangan_pr', 's3_komputer_keadaan_lk', 's3_komputer_keadaan_pr', 's3_komputer_kebutuhan_lk', 's3_komputer_kebutuhan_pr', 's3_komputer_kekurangan_lk', 's3_komputer_kekurangan_pr', 's3_statistik_keadaan_lk', 's3_statistik_keadaan_pr', 's3_statistik_kebutuhan_lk', 's3_statistik_kebutuhan_pr', 's3_statistik_kekurangan_lk', 's3_statistik_kekurangan_pr', 'doktoral_lainnya_keadaan_lk', 'doktoral_lainnya_keadaan_pr', 'doktoral_lainnya_kebutuhan_lk', 'doktoral_lainnya_kebutuhan_pr', 'doktoral_lainnya_kekurangan_lk', 'doktoral_lainnya_kekurangan_pr', 's2_biologi_keadaan_lk', 's2_biologi_keadaan_pr', 's2_biologi_kebutuhan_lk', 's2_biologi_kebutuhan_pr', 's2_biologi_kekurangan_lk', 's2_biologi_kekurangan_pr', 's2_kimia_keadaan_lk', 's2_kimia_keadaan_pr', 's2_kimia_kebutuhan_lk', 's2_kimia_kebutuhan_pr', 's2_kimia_kekurangan_lk', 's2_kimia_kekurangan_pr', 's2_ekonomiakuntansi_keadaan_lk', 's2_ekonomiakuntansi_keadaan_pr', 's2_ekonomiakuntansi_kebutuhan_lk', 's2_ekonomiakuntansi_kebutuhan_pr', 's2_ekonomiakuntansi_kekurangan_lk', 's2_ekonomiakuntansi_kekurangan_pr', 's2_administrasi_keadaan_lk', 's2_administrasi_keadaan_pr', 's2_administrasi_kebutuhan_lk', 's2_administrasi_kebutuhan_pr', 's2_administrasi_kekurangan_lk', 's2_administrasi_kekurangan_pr', 's2_hukum_keadaan_lk', 's2_hukum_keadaan_pr', 's2_hukum_kebutuhan_lk', 's2_hukum_kebutuhan_pr', 's2_hukum_kekurangan_lk', 's2_hukum_kekurangan_pr', 's2_tehnik_keadaan_lk', 's2_tehnik_keadaan_pr', 's2_tehnik_kebutuhan_lk', 's2_tehnik_kebutuhan_pr', 's2_tehnik_kekurangan_lk', 's2_tehnik_kekurangan_pr', 's2_kesejahteraansosial_keadaan_lk', 's2_kesejahteraansosial_keadaan_pr', 's2_kesejahteraansosial_kebutuhan_lk', 's2_kesejahteraansosial_kebutuhan_pr', 's2_kesejahteraansosial_kekurangan_lk', 's2_kesejahteraansosial_kekurangan_pr', 's2_fisika_keadaan_lk', 's2_fisika_keadaan_pr', 's2_fisika_kebutuhan_lk', 's2_fisika_kebutuhan_pr', 's2_fisika_kekurangan_lk', 's2_fisika_kekurangan_pr', 's2_komputer_keadaan_lk', 's2_komputer_keadaan_pr', 's2_komputer_kebutuhan_lk', 's2_komputer_kebutuhan_pr', 's2_komputer_kekurangan_lk', 's2_komputer_kekurangan_pr', 's2_statistik_keadaan_lk', 's2_statistik_keadaan_pr', 's2_statistik_kebutuhan_lk', 's2_statistik_kebutuhan_pr', 's2_statistik_kekurangan_lk', 's2_statistik_kekurangan_pr', 's2_administrasikesehatanmasyarakat_keadaan_lk', 's2_administrasikesehatanmasyarakat_keadaan_pr', 's2_administrasikesehatanmasyarakat_kebutuhan_lk', 's2_administrasikesehatanmasyarakat_kebutuhan_pr', 's2_administrasikesehatanmasyarakat_kekurangan_lk', 's2_administrasikesehatanmasyarakat_kekurangan_pr', 'pasca_sarjanalainnya_keadaan_lk', 'pasca_sarjanalainnya_keadaan_pr', 'pasca_sarjanalainnya_kebutuhan_lk', 'pasca_sarjanalainnya_kebutuhan_pr', 'pasca_sarjanalainnya_kekurangan_lk', 'pasca_sarjanalainnya_kekurangan_pr', 'sarjana_biologi_keadaan_lk', 'sarjana_biologi_keadaan_pr', 'sarjana_biologi_kebutuhan_lk', 'sarjana_biologi_kebutuhan_pr', 'sarjana_biologi_kekurangan_lk', 'sarjana_biologi_kekurangan_pr', 'sarjana_kimia_keadaan_lk', 'sarjana_kimia_keadaan_pr', 'sarjana_kimia_kebutuhan_lk', 'sarjana_kimia_kebutuhan_pr', 'sarjana_kimia_kekurangan_lk', 'sarjana_kimia_kekurangan_pr', 'sarjana_ekonomiakuntansi_keadaan_lk', 'sarjana_ekonomiakuntansi_keadaan_pr', 'sarjana_ekonomiakuntansi_kebutuhan_lk', 'sarjana_ekonomiakuntansi_kebutuhan_pr', 'sarjana_ekonomiakuntansi_kekurangan_lk', 'sarjana_ekonomiakuntansi_kekurangan_pr', 'sarjana_administrasi_keadaan_lk', 'sarjana_administrasi_keadaan_pr', 'sarjana_administrasi_kebutuhan_lk', 'sarjana_administrasi_kebutuhan_pr', 'sarjana_administrasi_kekurangan_lk', 'sarjana_administrasi_kekurangan_pr', 'sarjana_hukum_keadaan_lk', 'sarjana_hukum_keadaan_pr', 'sarjana_hukum_kebutuhan_lk', 'sarjana_hukum_kebutuhan_pr', 'sarjana_hukum_kekurangan_lk', 'sarjana_hukum_kekurangan_pr', 'sarjana_tehnik_keadaan_lk', 'sarjana_tehnik_keadaan_pr', 'sarjana_tehnik_kebutuhan_lk', 'sarjana_tehnik_kebutuhan_pr', 'sarjana_tehnik_kekurangan_lk', 'sarjana_tehnik_kekurangan_pr', 'sarjana_kesejahteraansosial_keadaan_lk', 'sarjana_kesejahteraansosial_keadaan_pr', 'sarjana_kesejahteraansosial_kebutuhan_lk', 'sarjana_kesejahteraansosial_kebutuhan_pr', 'sarjana_kesejahteraansosial_kekurangan_lk', 'sarjana_kesejahteraansosial_kekurangan_pr', 'sarjana_fisika_keadaan_lk', 'sarjana_fisika_keadaan_pr', 'sarjana_fisika_kebutuhan_lk', 'sarjana_fisika_kebutuhan_pr', 'sarjana_fisika_kekurangan_lk', 'sarjana_fisika_kekurangan_pr', 'sarjana_komputer_keadaan_lk', 'sarjana_komputer_keadaan_pr', 'sarjana_komputer_kebutuhan_lk', 'sarjana_komputer_kebutuhan_pr', 'sarjana_komputer_kekurangan_lk', 'sarjana_komputer_kekurangan_pr', 'sarjana_statistik_keadaan_lk', 'sarjana_statistik_keadaan_pr', 'sarjana_statistik_kebutuhan_lk', 'sarjana_statistik_kebutuhan_pr', 'sarjana_statistik_kekurangan_lk', 'sarjana_statistik_kekurangan_pr', 'sarjana_lainnya_keadaan_lk', 'sarjana_lainnya_keadaan_pr', 'sarjana_lainnya_kebutuhan_lk', 'sarjana_lainnya_kebutuhan_pr', 'sarjana_lainnya_kekurangan_lk', 'sarjana_lainnya_kekurangan_pr', 'sarjana_muda_biologi_keadaan_lk', 'sarjana_muda_biologi_keadaan_pr', 'sarjana_muda_biologi_kebutuhan_lk', 'sarjana_muda_biologi_kebutuhan_pr', 'sarjana_muda_biologi_kekurangan_lk', 'sarjana_muda_biologi_kekurangan_pr', 'sarjana_muda_kimia_keadaan_lk', 'sarjana_muda_kimia_keadaan_pr', 'sarjana_muda_kimia_kebutuhan_lk', 'sarjana_muda_kimia_kebutuhan_pr', 'sarjana_muda_kimia_kekurangan_lk', 'sarjana_muda_kimia_kekurangan_pr', 'sarjana_muda_ekonomiakuntansi_keadaan_lk', 'sarjana_muda_ekonomiakuntansi_keadaan_pr', 'sarjana_muda_ekonomiakuntansi_kebutuhan_lk', 'sarjana_muda_ekonomiakuntansi_kebutuhan_pr', 'sarjana_muda_ekonomiakuntansi_kekurangan_lk', 'sarjana_muda_ekonomiakuntansi_kekurangan_pr', 'sarjana_muda_administrasi_keadaan_lk', 'sarjana_muda_administrasi_keadaan_pr', 'sarjana_muda_administrasi_kebutuhan_lk', 'sarjana_muda_administrasi_kebutuhan_pr', 'sarjana_muda_administrasi_kekurangan_lk', 'sarjana_muda_administrasi_kekurangan_pr', 'sarjana_muda_hukum_keadaan_lk', 'sarjana_muda_hukum_keadaan_pr', 'sarjana_muda_hukum_kebutuhan_lk', 'sarjana_muda_hukum_kebutuhan_pr', 'sarjana_muda_hukum_kekurangan_lk', 'sarjana_muda_hukum_kekurangan_pr', 'sarjana_muda_tehnik_keadaan_lk', 'sarjana_muda_tehnik_keadaan_pr', 'sarjana_muda_tehnik_kebutuhan_lk', 'sarjana_muda_tehnik_kebutuhan_pr', 'sarjana_muda_tehnik_kekurangan_lk', 'sarjana_muda_tehnik_kekurangan_pr', 'sarjana_muda_kesejahteraansosial_keadaan_lk', 'sarjana_muda_kesejahteraansosial_keadaan_pr', 'sarjana_muda_kesejahteraansosial_kebutuhan_lk', 'sarjana_muda_kesejahteraansosial_kebutuhan_pr', 'sarjana_muda_kesejahteraansosial_kekurangan_lk', 'sarjana_muda_kesejahteraansosial_kekurangan_pr', 'sarjana_muda_sekretaris_keadaan_lk', 'sarjana_muda_sekretaris_keadaan_pr', 'sarjana_muda_sekretaris_kebutuhan_lk', 'sarjana_muda_sekretaris_kebutuhan_pr', 'sarjana_muda_sekretaris_kekurangan_lk', 'sarjana_muda_sekretaris_kekurangan_pr', 'sarjana_muda_komputer_keadaan_lk', 'sarjana_muda_komputer_keadaan_pr', 'sarjana_muda_komputer_kebutuhan_lk', 'sarjana_muda_komputer_kebutuhan_pr', 'sarjana_muda_komputer_kekurangan_lk', 'sarjana_muda_komputer_kekurangan_pr', 'sarjana_muda_statistik_keadaan_lk', 'sarjana_muda_statistik_keadaan_pr', 'sarjana_muda_statistik_kebutuhan_lk', 'sarjana_muda_statistik_kebutuhan_pr', 'sarjana_muda_statistik_kekurangan_lk', 'sarjana_muda_statistik_kekurangan_pr', 'sarjana_muda_lainnya_keadaan_lk', 'sarjana_muda_lainnya_keadaan_pr', 'sarjana_muda_lainnya_kebutuhan_lk', 'sarjana_muda_lainnya_kebutuhan_pr', 'sarjana_muda_lainnya_kekurangan_lk', 'sarjana_muda_lainnya_kekurangan_pr', 'sma_smu_keadaan_lk', 'sma_smu_keadaan_pr', 'sma_smu_kebutuhan_lk', 'sma_smu_kebutuhan_pr', 'sma_smu_kekurangan_lk', 'sma_smu_kekurangan_pr', 'smea_keadaan_lk', 'smea_keadaan_pr', 'smea_kebutuhan_lk', 'smea_kebutuhan_pr', 'smea_kekurangan_lk', 'smea_kekurangan_pr', 'stm_keadaan_lk', 'stm_keadaan_pr', 'stm_kebutuhan_lk', 'stm_kebutuhan_pr', 'stm_kekurangan_lk', 'stm_kekurangan_pr', 'smkk_keadaan_lk', 'smkk_keadaan_pr', 'smkk_kebutuhan_lk', 'smkk_kebutuhan_pr', 'smkk_kekurangan_lk', 'smkk_kekurangan_pr', 'spsa_keadaan_lk', 'spsa_keadaan_pr', 'spsa_kebutuhan_lk', 'spsa_kebutuhan_pr', 'spsa_kekurangan_lk', 'spsa_kekurangan_pr', 'smtp_keadaan_lk', 'smtp_keadaan_pr', 'smtp_kebutuhan_lk', 'smtp_kebutuhan_pr', 'smtp_kekurangan_lk', 'smtp_kekurangan_pr', 'sd_kebawah_keadaan_lk', 'sd_kebawah_keadaan_pr', 'sd_kebawah_kebutuhan_lk', 'sd_kebawah_kebutuhan_pr', 'sd_kebawah_kekurangan_lk', 'sd_kebawah_kekurangan_pr', 'smta_lainnya_keadaan_lk', 'smta_lainnya_keadaan_pr', 'smta_lainnya_kebutuhan_lk', 'smta_lainnya_kebutuhan_pr', 'smta_lainnya_kekurangan_lk', 'smta_lainnya_kekurangan_pr', 'deleted_by'], 'default', 'value' => null],
            [['dokter_umum_keadaan_lk', 'dokter_umum_keadaan_pr', 'dokter_umum_kebutuhan_lk', 'dokter_umum_kebutuhan_pr', 'dokter_umum_kekurangan_lk', 'dokter_umum_kekurangan_pr', 'dokter_ppds_keadaan_lk', 'dokter_ppds_keadaan_pr', 'dokter_ppds_kebutuhan_lk', 'dokter_ppds_kebutuhan_pr', 'dokter_ppds_kekurangan_lk', 'dokter_ppds_kekurangan_pr', 'dokter_spesialisbedah_keadaan_lk', 'dokter_spesialisbedah_keadaan_pr', 'dokter_spesialisbedah_kebutuhan_lk', 'dokter_spesialisbedah_kebutuhan_pr', 'dokter_spesialisbedah_kekurangan_lk', 'dokter_spesialisbedah_kekurangan_pr', 'dokter_spesialispenyakitdalam_keadaan_lk', 'dokter_spesialispenyakitdalam_keadaan_pr', 'dokter_spesialispenyakitdalam_kebutuhan_lk', 'dokter_spesialispenyakitdalam_kebutuhan_pr', 'dokter_spesialispenyakitdalam_kekurangan_lk', 'dokter_spesialispenyakitdalam_kekurangan_pr', 'dokter_spesialiskesehatananak_keadaan_lk', 'dokter_spesialiskesehatananak_keadaan_pr', 'dokter_spesialiskesehatananak_kebutuhan_lk', 'dokter_spesialiskesehatananak_kebutuhan_pr', 'dokter_spesialiskesehatananak_kekurangan_lk', 'dokter_spesialiskesehatananak_kekurangan_pr', 'dokter_spesialisobgin_keadaan_lk', 'dokter_spesialisobgin_keadaan_pr', 'dokter_spesialisobgin_kebutuhan_lk', 'dokter_spesialisobgin_kebutuhan_pr', 'dokter_spesialisobgin_kekurangan_lk', 'dokter_spesialisobgin_kekurangan_pr', 'dokter_spesialisradiologi_keadaan_lk', 'dokter_spesialisradiologi_keadaan_pr', 'dokter_spesialisradiologi_kebutuhan_lk', 'dokter_spesialisradiologi_kebutuhan_pr', 'dokter_spesialisradiologi_kekurangan_lk', 'dokter_spesialisradiologi_kekurangan_pr', 'dokter_spesialisonkologiradiasi_keadaan_lk', 'dokter_spesialisonkologiradiasi_keadaan_pr', 'dokter_spesialisonkologiradiasi_kebutuhan_lk', 'dokter_spesialisonkologiradiasi_kebutuhan_pr', 'dokter_spesialisonkologiradiasi_kekurangan_lk', 'dokter_spesialisonkologiradiasi_kekurangan_pr', 'dokter_spesialiskedokterannulir_keadaan_lk', 'dokter_spesialiskedokterannulir_keadaan_pr', 'dokter_spesialiskedokterannulir_kebutuhan_lk', 'dokter_spesialiskedokterannulir_kebutuhan_pr', 'dokter_spesialiskedokterannulir_kekurangan_lk', 'dokter_spesialiskedokterannulir_kekurangan_pr', 'dokter_spesialisanesthesi_keadaan_lk', 'dokter_spesialisanesthesi_keadaan_pr', 'dokter_spesialisanesthesi_kebutuhan_lk', 'dokter_spesialisanesthesi_kebutuhan_pr', 'dokter_spesialisanesthesi_kekurangan_lk', 'dokter_spesialisanesthesi_kekurangan_pr', 'dokter_spesialispatologiklinik_keadaan_lk', 'dokter_spesialispatologiklinik_keadaan_pr', 'dokter_spesialispatologiklinik_kebutuhan_lk', 'dokter_spesialispatologiklinik_kebutuhan_pr', 'dokter_spesialispatologiklinik_kekurangan_lk', 'dokter_spesialispatologiklinik_kekurangan_pr', 'dokter_spesialisjiwa_keadaan_lk', 'dokter_spesialisjiwa_keadaan_pr', 'dokter_spesialisjiwa_kebutuhan_lk', 'dokter_spesialisjiwa_kebutuhan_pr', 'dokter_spesialisjiwa_kekurangan_lk', 'dokter_spesialisjiwa_kekurangan_pr', 'dokter_spesialismata_keadaan_lk', 'dokter_spesialismata_keadaan_pr', 'dokter_spesialismata_kebutuhan_lk', 'dokter_spesialismata_kebutuhan_pr', 'dokter_spesialismata_kekurangan_lk', 'dokter_spesialismata_kekurangan_pr', 'dokter_spesialistht_keadaan_lk', 'dokter_spesialistht_keadaan_pr', 'dokter_spesialistht_kebutuhan_lk', 'dokter_spesialistht_kebutuhan_pr', 'dokter_spesialistht_kekurangan_lk', 'dokter_spesialistht_kekurangan_pr', 'dokter_spesialiskulitkelamin_keadaan_lk', 'dokter_spesialiskulitkelamin_keadaan_pr', 'dokter_spesialiskulitkelamin_kebutuhan_lk', 'dokter_spesialiskulitkelamin_kebutuhan_pr', 'dokter_spesialiskulitkelamin_kekurangan_lk', 'dokter_spesialiskulitkelamin_kekurangan_pr', 'dokter_spesialiskardiologi_keadaan_lk', 'dokter_spesialiskardiologi_keadaan_pr', 'dokter_spesialiskardiologi_kebutuhan_lk', 'dokter_spesialiskardiologi_kebutuhan_pr', 'dokter_spesialiskardiologi_kekurangan_lk', 'dokter_spesialiskardiologi_kekurangan_pr', 'dokter_spesialisparu_keadaan_lk', 'dokter_spesialisparu_keadaan_pr', 'dokter_spesialisparu_kebutuhan_lk', 'dokter_spesialisparu_kebutuhan_pr', 'dokter_spesialisparu_kekurangan_lk', 'dokter_spesialisparu_kekurangan_pr', 'dokter_spesialissaraf_keadaan_lk', 'dokter_spesialissaraf_keadaan_pr', 'dokter_spesialissaraf_kebutuhan_lk', 'dokter_spesialissaraf_kebutuhan_pr', 'dokter_spesialissaraf_kekurangan_lk', 'dokter_spesialissaraf_kekurangan_pr', 'dokter_spesialisbedahsaraf_keadaan_lk', 'dokter_spesialisbedahsaraf_keadaan_pr', 'dokter_spesialisbedahsaraf_kebutuhan_lk', 'dokter_spesialisbedahsaraf_kebutuhan_pr', 'dokter_spesialisbedahsaraf_kekurangan_lk', 'dokter_spesialisbedahsaraf_kekurangan_pr', 'dokter_spesialisbedahorthopedi_keadaan_lk', 'dokter_spesialisbedahorthopedi_keadaan_pr', 'dokter_spesialisbedahorthopedi_kebutuhan_lk', 'dokter_spesialisbedahorthopedi_kebutuhan_pr', 'dokter_spesialisbedahorthopedi_kekurangan_lk', 'dokter_spesialisbedahorthopedi_kekurangan_pr', 'dokter_spesialisurologi_keadaan_lk', 'dokter_spesialisurologi_keadaan_pr', 'dokter_spesialisurologi_kebutuhan_lk', 'dokter_spesialisurologi_kebutuhan_pr', 'dokter_spesialisurologi_kekurangan_lk', 'dokter_spesialisurologi_kekurangan_pr', 'dokter_spesialispatologianatomi_keadaan_lk', 'dokter_spesialispatologianatomi_keadaan_pr', 'dokter_spesialispatologianatomi_kebutuhan_lk', 'dokter_spesialispatologianatomi_kebutuhan_pr', 'dokter_spesialispatologianatomi_kekurangan_lk', 'dokter_spesialispatologianatomi_kekurangan_pr', 'dokter_spesialispatologiforensik_keadaan_lk', 'dokter_spesialispatologiforensik_keadaan_pr', 'dokter_spesialispatologiforensik_kebutuhan_lk', 'dokter_spesialispatologiforensik_kebutuhan_pr', 'dokter_spesialispatologiforensik_kekurangan_lk', 'dokter_spesialispatologiforensik_kekurangan_pr', 'dokter_spesialisrehabilitasimedik_keadaan_lk', 'dokter_spesialisrehabilitasimedik_keadaan_pr', 'dokter_spesialisrehabilitasimedik_kebutuhan_lk', 'dokter_spesialisrehabilitasimedik_kebutuhan_pr', 'dokter_spesialisrehabilitasimedik_kekurangan_lk', 'dokter_spesialisrehabilitasimedik_kekurangan_pr', 'dokter_spesialisbedahplastik_keadaan_lk', 'dokter_spesialisbedahplastik_keadaan_pr', 'dokter_spesialisbedahplastik_kebutuhan_lk', 'dokter_spesialisbedahplastik_kebutuhan_pr', 'dokter_spesialisbedahplastik_kekurangan_lk', 'dokter_spesialisbedahplastik_kekurangan_pr', 'dokter_spesialiskedokteranolahraga_keadaan_lk', 'dokter_spesialiskedokteranolahraga_keadaan_pr', 'dokter_spesialiskedokteranolahraga_kebutuhan_lk', 'dokter_spesialiskedokteranolahraga_kebutuhan_pr', 'dokter_spesialiskedokteranolahraga_kekurangan_lk', 'dokter_spesialiskedokteranolahraga_kekurangan_pr', 'dokter_spesialismikrobiologiklinik_keadaan_lk', 'dokter_spesialismikrobiologiklinik_keadaan_pr', 'dokter_spesialismikrobiologiklinik_kebutuhan_lk', 'dokter_spesialismikrobiologiklinik_kebutuhan_pr', 'dokter_spesialismikrobiologiklinik_kekurangan_lk', 'dokter_spesialismikrobiologiklinik_kekurangan_pr', 'dokter_spesialisparasitologiklinik_keadaan_lk', 'dokter_spesialisparasitologiklinik_keadaan_pr', 'dokter_spesialisparasitologiklinik_kebutuhan_lk', 'dokter_spesialisparasitologiklinik_kebutuhan_pr', 'dokter_spesialisparasitologiklinik_kekurangan_lk', 'dokter_spesialisparasitologiklinik_kekurangan_pr', 'dokter_spesialisgizimedik_keadaan_lk', 'dokter_spesialisgizimedik_keadaan_pr', 'dokter_spesialisgizimedik_kebutuhan_lk', 'dokter_spesialisgizimedik_kebutuhan_pr', 'dokter_spesialisgizimedik_kekurangan_lk', 'dokter_spesialisgizimedik_kekurangan_pr', 'dokter_spesialisfarmaklinik_keadaan_lk', 'dokter_spesialisfarmaklinik_keadaan_pr', 'dokter_spesialisfarmaklinik_kebutuhan_lk', 'dokter_spesialisfarmaklinik_kebutuhan_pr', 'dokter_spesialisfarmaklinik_kekurangan_lk', 'dokter_spesialisfarmaklinik_kekurangan_pr', 'dokter_spesialislainnya_keadaan_lk', 'dokter_spesialislainnya_keadaan_pr', 'dokter_spesialislainnya_kebutuhan_lk', 'dokter_spesialislainnya_kebutuhan_pr', 'dokter_spesialislainnya_kekurangan_lk', 'dokter_spesialislainnya_kekurangan_pr', 'dokter_subspesialislainnya_keadaan_lk', 'dokter_subspesialislainnya_keadaan_pr', 'dokter_subspesialislainnya_kebutuhan_lk', 'dokter_subspesialislainnya_kebutuhan_pr', 'dokter_subspesialislainnya_kekurangan_lk', 'dokter_subspesialislainnya_kekurangan_pr', 'dokter_gigi_keadaan_lk', 'dokter_gigi_keadaan_pr', 'dokter_gigi_kebutuhan_lk', 'dokter_gigi_kebutuhan_pr', 'dokter_gigi_kekurangan_lk', 'dokter_gigi_kekurangan_pr', 'dokter_gigi_spesialis_keadaan_lk', 'dokter_gigi_spesialis_keadaan_pr', 'dokter_gigi_spesialis_kebutuhan_lk', 'dokter_gigi_spesialis_kebutuhan_pr', 'dokter_gigi_spesialis_kekurangan_lk', 'dokter_gigi_spesialis_kekurangan_pr', 'dokter_doktergigimhamars_keadaan_lk', 'dokter_doktergigimhamars_keadaan_pr', 'dokter_doktergigimhamars_kebutuhan_lk', 'dokter_doktergigimhamars_kebutuhan_pr', 'dokter_doktergigimhamars_kekurangan_lk', 'dokter_doktergigimhamars_kekurangan_pr', 'dokter_doktergigis2s3kesehatanmasyarakat_keadaan_lk', 'dokter_doktergigis2s3kesehatanmasyarakat_keadaan_pr', 'dokter_doktergigis2s3kesehatanmasyarakat_kebutuhan_lk', 'dokter_doktergigis2s3kesehatanmasyarakat_kebutuhan_pr', 'dokter_doktergigis2s3kesehatanmasyarakat_kekurangan_lk', 'dokter_doktergigis2s3kesehatanmasyarakat_kekurangan_pr', 's3_dokterkonsultan_keadaan_lk', 's3_dokterkonsultan_keadaan_pr', 's3_dokterkonsultan_kebutuhan_lk', 's3_dokterkonsultan_kebutuhan_pr', 's3_dokterkonsultan_kekurangan_lk', 's3_dokterkonsultan_kekurangan_pr', 's3_keperawatan_keadaan_lk', 's3_keperawatan_keadaan_pr', 's3_keperawatan_kebutuhan_lk', 's3_keperawatan_kebutuhan_pr', 's3_keperawatan_kekurangan_lk', 's3_keperawatan_kekurangan_pr', 's2_keperawatan_keadaan_lk', 's2_keperawatan_keadaan_pr', 's2_keperawatan_kebutuhan_lk', 's2_keperawatan_kebutuhan_pr', 's2_keperawatan_kekurangan_lk', 's2_keperawatan_kekurangan_pr', 's1_keperawatan_keadaan_lk', 's1_keperawatan_keadaan_pr', 's1_keperawatan_kebutuhan_lk', 's1_keperawatan_kebutuhan_pr', 's1_keperawatan_kekurangan_lk', 's1_keperawatan_kekurangan_pr', 'd4_keperawatan_keadaan_lk', 'd4_keperawatan_keadaan_pr', 'd4_keperawatan_kebutuhan_lk', 'd4_keperawatan_kebutuhan_pr', 'd4_keperawatan_kekurangan_lk', 'd4_keperawatan_kekurangan_pr', 'perawat_vokasional_keadaan_lk', 'perawat_vokasional_keadaan_pr', 'perawat_vokasional_kebutuhan_lk', 'perawat_vokasional_kebutuhan_pr', 'perawat_vokasional_kekurangan_lk', 'perawat_vokasional_kekurangan_pr', 'perawat_spesialis_keadaan_lk', 'perawat_spesialis_keadaan_pr', 'perawat_spesialis_kebutuhan_lk', 'perawat_spesialis_kebutuhan_pr', 'perawat_spesialis_kekurangan_lk', 'perawat_spesialis_kekurangan_pr', 'pembantu_keperawatan_keadaan_lk', 'pembantu_keperawatan_keadaan_pr', 'pembantu_keperawatan_kebutuhan_lk', 'pembantu_keperawatan_kebutuhan_pr', 'pembantu_keperawatan_kekurangan_lk', 'pembantu_keperawatan_kekurangan_pr', 's3_kebidanan_keadaan_lk', 's3_kebidanan_keadaan_pr', 's3_kebidanan_kebutuhan_lk', 's3_kebidanan_kebutuhan_pr', 's3_kebidanan_kekurangan_lk', 's3_kebidanan_kekurangan_pr', 's2_kebidanan_keadaan_lk', 's2_kebidanan_keadaan_pr', 's2_kebidanan_kebutuhan_lk', 's2_kebidanan_kebutuhan_pr', 's2_kebidanan_kekurangan_lk', 's2_kebidanan_kekurangan_pr', 's1_kebidanan_keadaan_lk', 's1_kebidanan_keadaan_pr', 's1_kebidanan_kebutuhan_lk', 's1_kebidanan_kebutuhan_pr', 's1_kebidanan_kekurangan_lk', 's1_kebidanan_kekurangan_pr', 'd3_kebidanan_keadaan_lk', 'd3_kebidanan_keadaan_pr', 'd3_kebidanan_kebutuhan_lk', 'd3_kebidanan_kebutuhan_pr', 'd3_kebidanan_kekurangan_lk', 'd3_kebidanan_kekurangan_pr', 'tenaga_keperawatanlainnya_keadaan_lk', 'tenaga_keperawatanlainnya_keadaan_pr', 'tenaga_keperawatanlainnya_kebutuhan_lk', 'tenaga_keperawatanlainnya_kebutuhan_pr', 'tenaga_keperawatanlainnya_kekurangan_lk', 'tenaga_keperawatanlainnya_kekurangan_pr', 's3_farmasiapoteker_keadaan_lk', 's3_farmasiapoteker_keadaan_pr', 's3_farmasiapoteker_kebutuhan_lk', 's3_farmasiapoteker_kebutuhan_pr', 's3_farmasiapoteker_kekurangan_lk', 's3_farmasiapoteker_kekurangan_pr', 's2_farmasiapoteker_keadaan_lk', 's2_farmasiapoteker_keadaan_pr', 's2_farmasiapoteker_kebutuhan_lk', 's2_farmasiapoteker_kebutuhan_pr', 's2_farmasiapoteker_kekurangan_lk', 's2_farmasiapoteker_kekurangan_pr', 'apoteker_keadaan_lk', 'apoteker_keadaan_pr', 'apoteker_kebutuhan_lk', 'apoteker_kebutuhan_pr', 'apoteker_kekurangan_lk', 'apoteker_kekurangan_pr', 's3_farmasifarmakologikimia_keadaan_lk', 's3_farmasifarmakologikimia_keadaan_pr', 's3_farmasifarmakologikimia_kebutuhan_lk', 's3_farmasifarmakologikimia_kebutuhan_pr', 's3_farmasifarmakologikimia_kekurangan_lk', 's3_farmasifarmakologikimia_kekurangan_pr', 's1_farmasiapoteker_keadaan_lk', 's1_farmasiapoteker_keadaan_pr', 's1_farmasiapoteker_kebutuhan_lk', 's1_farmasiapoteker_kebutuhan_pr', 's1_farmasiapoteker_kekurangan_lk', 's1_farmasiapoteker_kekurangan_pr', 'akafarma_keadaan_lk', 'akafarma_keadaan_pr', 'akafarma_kebutuhan_lk', 'akafarma_kebutuhan_pr', 'akafarma_kekurangan_lk', 'akafarma_kekurangan_pr', 'akfar_keadaan_lk', 'akfar_keadaan_pr', 'akfar_kebutuhan_lk', 'akfar_kebutuhan_pr', 'akfar_kekurangan_lk', 'akfar_kekurangan_pr', 'analis_farmasi_keadaan_lk', 'analis_farmasi_keadaan_pr', 'analis_farmasi_kebutuhan_lk', 'analis_farmasi_kebutuhan_pr', 'analis_farmasi_kekurangan_lk', 'analis_farmasi_kekurangan_pr', 'asisten_apoteker_keadaan_lk', 'asisten_apoteker_keadaan_pr', 'asisten_apoteker_kebutuhan_lk', 'asisten_apoteker_kebutuhan_pr', 'asisten_apoteker_kekurangan_lk', 'asisten_apoteker_kekurangan_pr', 's1_farmasiapotekersmf_keadaan_lk', 's1_farmasiapotekersmf_keadaan_pr', 's1_farmasiapotekersmf_kebutuhan_lk', 's1_farmasiapotekersmf_kebutuhan_pr', 's1_farmasiapotekersmf_kekurangan_lk', 's1_farmasiapotekersmf_kekurangan_pr', 'st_lab_kimia_farmasi_keadaan_lk', 'st_lab_kimia_farmasi_keadaan_pr', 'st_lab_kimia_farmasi_kebutuhan_lk', 'st_lab_kimia_farmasi_kebutuhan_pr', 'st_lab_kimia_farmasi_kekurangan_lk', 'st_lab_kimia_farmasi_kekurangan_pr', 'tenaga_kefarmasianlainnya_keadaan_lk', 'tenaga_kefarmasianlainnya_keadaan_pr', 'tenaga_kefarmasianlainnya_kebutuhan_lk', 'tenaga_kefarmasianlainnya_kebutuhan_pr', 'tenaga_kefarmasianlainnya_kekurangan_lk', 'tenaga_kefarmasianlainnya_kekurangan_pr', 's3_kesehatan_masyarakatan_keadaan_lk', 's3_kesehatan_masyarakatan_keadaan_pr', 's3_kesehatan_masyarakatan_kebutuhan_lk', 's3_kesehatan_masyarakatan_kebutuhan_pr', 's3_kesehatan_masyarakatan_kekurangan_lk', 's3_kesehatan_masyarakatan_kekurangan_pr', 's3_epidemologi_keadaan_lk', 's3_epidemologi_keadaan_pr', 's3_epidemologi_kebutuhan_lk', 's3_epidemologi_kebutuhan_pr', 's3_epidemologi_kekurangan_lk', 's3_epidemologi_kekurangan_pr', 's3_psikologi_keadaan_lk', 's3_psikologi_keadaan_pr', 's3_psikologi_kebutuhan_lk', 's3_psikologi_kebutuhan_pr', 's3_psikologi_kekurangan_lk', 's3_psikologi_kekurangan_pr', 's2_kesehatan_masyarakatan_keadaan_lk', 's2_kesehatan_masyarakatan_keadaan_pr', 's2_kesehatan_masyarakatan_kebutuhan_lk', 's2_kesehatan_masyarakatan_kebutuhan_pr', 's2_kesehatan_masyarakatan_kekurangan_lk', 's2_kesehatan_masyarakatan_kekurangan_pr', 's2_epidemologi_keadaan_lk', 's2_epidemologi_keadaan_pr', 's2_epidemologi_kebutuhan_lk', 's2_epidemologi_kebutuhan_pr', 's2_epidemologi_kekurangan_lk', 's2_epidemologi_kekurangan_pr', 's2_biomedik_keadaan_lk', 's2_biomedik_keadaan_pr', 's2_biomedik_kebutuhan_lk', 's2_biomedik_kebutuhan_pr', 's2_biomedik_kekurangan_lk', 's2_biomedik_kekurangan_pr', 's2_psikologi_keadaan_lk', 's2_psikologi_keadaan_pr', 's2_psikologi_kebutuhan_lk', 's2_psikologi_kebutuhan_pr', 's2_psikologi_kekurangan_lk', 's2_psikologi_kekurangan_pr', 's1_kesehatan_masyarakat_keadaan_lk', 's1_kesehatan_masyarakat_keadaan_pr', 's1_kesehatan_masyarakat_kebutuhan_lk', 's1_kesehatan_masyarakat_kebutuhan_pr', 's1_kesehatan_masyarakat_kekurangan_lk', 's1_kesehatan_masyarakat_kekurangan_pr', 's1_psikologi_keadaan_lk', 's1_psikologi_keadaan_pr', 's1_psikologi_kebutuhan_lk', 's1_psikologi_kebutuhan_pr', 's1_psikologi_kekurangan_lk', 's1_psikologi_kekurangan_pr', 'd3_kesehatan_masyarakat_keadaan_lk', 'd3_kesehatan_masyarakat_keadaan_pr', 'd3_kesehatan_masyarakat_kebutuhan_lk', 'd3_kesehatan_masyarakat_kebutuhan_pr', 'd3_kesehatan_masyarakat_kekurangan_lk', 'd3_kesehatan_masyarakat_kekurangan_pr', 'd3_sanitarian_keadaan_lk', 'd3_sanitarian_keadaan_pr', 'd3_sanitarian_kebutuhan_lk', 'd3_sanitarian_kebutuhan_pr', 'd3_sanitarian_kekurangan_lk', 'd3_sanitarian_kekurangan_pr', 'tenaga_kesehatan_masyarakatlainnya_keadaan_lk', 'tenaga_kesehatan_masyarakatlainnya_keadaan_pr', 'tenaga_kesehatan_masyarakatlainnya_kebutuhan_lk', 'tenaga_kesehatan_masyarakatlainnya_kebutuhan_pr', 'tenaga_kesehatan_masyarakatlainnya_kekurangan_lk', 'tenaga_kesehatan_masyarakatlainnya_kekurangan_pr', 's3_gizi_dietisien_keadaan_lk', 's3_gizi_dietisien_keadaan_pr', 's3_gizi_dietisien_kebutuhan_lk', 's3_gizi_dietisien_kebutuhan_pr', 's3_gizi_dietisien_kekurangan_lk', 's3_gizi_dietisien_kekurangan_pr', 's2_gizi_dietisien_keadaan_lk', 's2_gizi_dietisien_keadaan_pr', 's2_gizi_dietisien_kebutuhan_lk', 's2_gizi_dietisien_kebutuhan_pr', 's2_gizi_dietisien_kekurangan_lk', 's2_gizi_dietisien_kekurangan_pr', 's1_gizi_dietisien_keadaan_lk', 's1_gizi_dietisien_keadaan_pr', 's1_gizi_dietisien_kebutuhan_lk', 's1_gizi_dietisien_kebutuhan_pr', 's1_gizi_dietisien_kekurangan_lk', 's1_gizi_dietisien_kekurangan_pr', 'd4_gizi_dietisien_keadaan_lk', 'd4_gizi_dietisien_keadaan_pr', 'd4_gizi_dietisien_kebutuhan_lk', 'd4_gizi_dietisien_kebutuhan_pr', 'd4_gizi_dietisien_kekurangan_lk', 'd4_gizi_dietisien_kekurangan_pr', 'd3_gizi_dietisien_keadaan_lk', 'd3_gizi_dietisien_keadaan_pr', 'd3_gizi_dietisien_kebutuhan_lk', 'd3_gizi_dietisien_kebutuhan_pr', 'd3_gizi_dietisien_kekurangan_lk', 'd3_gizi_dietisien_kekurangan_pr', 'd1_gizi_dietisien_keadaan_lk', 'd1_gizi_dietisien_keadaan_pr', 'd1_gizi_dietisien_kebutuhan_lk', 'd1_gizi_dietisien_kebutuhan_pr', 'd1_gizi_dietisien_kekurangan_lk', 'd1_gizi_dietisien_kekurangan_pr', 'tenaga_gizilainnya_keadaan_lk', 'tenaga_gizilainnya_keadaan_pr', 'tenaga_gizilainnya_kebutuhan_lk', 'tenaga_gizilainnya_kebutuhan_pr', 'tenaga_gizilainnya_kekurangan_lk', 'tenaga_gizilainnya_kekurangan_pr', 's1_fisioterapis_keadaan_lk', 's1_fisioterapis_keadaan_pr', 's1_fisioterapis_kebutuhan_lk', 's1_fisioterapis_kebutuhan_pr', 's1_fisioterapis_kekurangan_lk', 's1_fisioterapis_kekurangan_pr', 'd3_fisioterapis_keadaan_lk', 'd3_fisioterapis_keadaan_pr', 'd3_fisioterapis_kebutuhan_lk', 'd3_fisioterapis_kebutuhan_pr', 'd3_fisioterapis_kekurangan_lk', 'd3_fisioterapis_kekurangan_pr', 'd3_okupasiterapis_keadaan_lk', 'd3_okupasiterapis_keadaan_pr', 'd3_okupasiterapis_kebutuhan_lk', 'd3_okupasiterapis_kebutuhan_pr', 'd3_okupasiterapis_kekurangan_lk', 'd3_okupasiterapis_kekurangan_pr', 'd3_terapiwicara_keadaan_lk', 'd3_terapiwicara_keadaan_pr', 'd3_terapiwicara_kebutuhan_lk', 'd3_terapiwicara_kebutuhan_pr', 'd3_terapiwicara_kekurangan_lk', 'd3_terapiwicara_kekurangan_pr', 'd3_orthopedi_keadaan_lk', 'd3_orthopedi_keadaan_pr', 'd3_orthopedi_kebutuhan_lk', 'd3_orthopedi_kebutuhan_pr', 'd3_orthopedi_kekurangan_lk', 'd3_orthopedi_kekurangan_pr', 'd3_akupuntur_keadaan_lk', 'd3_akupuntur_keadaan_pr', 'd3_akupuntur_kebutuhan_lk', 'd3_akupuntur_kebutuhan_pr', 'd3_akupuntur_kekurangan_lk', 'd3_akupuntur_kekurangan_pr', 'tenaga_keterapianfisiklainnya_keadaan_lk', 'tenaga_keterapianfisiklainnya_keadaan_pr', 'tenaga_keterapianfisiklainnya_kebutuhan_lk', 'tenaga_keterapianfisiklainnya_kebutuhan_pr', 'tenaga_keterapianfisiklainnya_kekurangan_lk', 'tenaga_keterapianfisiklainnya_kekurangan_pr', 's3_optoelektronikaapllaser_keadaan_lk', 's3_optoelektronikaapllaser_keadaan_pr', 's3_optoelektronikaapllaser_kebutuhan_lk', 's3_optoelektronikaapllaser_kebutuhan_pr', 's3_optoelektronikaapllaser_kekurangan_lk', 's3_optoelektronikaapllaser_kekurangan_pr', 's2_optoelektronikaapllaser_keadaan_lk', 's2_optoelektronikaapllaser_keadaan_pr', 's2_optoelektronikaapllaser_kebutuhan_lk', 's2_optoelektronikaapllaser_kebutuhan_pr', 's2_optoelektronikaapllaser_kekurangan_lk', 's2_optoelektronikaapllaser_kekurangan_pr', 'radiografer_keadaan_lk', 'radiografer_keadaan_pr', 'radiografer_kebutuhan_lk', 'radiografer_kebutuhan_pr', 'radiografer_kekurangan_lk', 'radiografer_kekurangan_pr', 'radioterapis_nondokter_keadaan_lk', 'radioterapis_nondokter_keadaan_pr', 'radioterapis_nondokter_kebutuhan_lk', 'radioterapis_nondokter_kebutuhan_pr', 'radioterapis_nondokter_kekurangan_lk', 'radioterapis_nondokter_kekurangan_pr', 'd4_fisikamedik_keadaan_lk', 'd4_fisikamedik_keadaan_pr', 'd4_fisikamedik_kebutuhan_lk', 'd4_fisikamedik_kebutuhan_pr', 'd4_fisikamedik_kekurangan_lk', 'd4_fisikamedik_kekurangan_pr', 'd3_teknikgigi_keadaan_lk', 'd3_teknikgigi_keadaan_pr', 'd3_teknikgigi_kebutuhan_lk', 'd3_teknikgigi_kebutuhan_pr', 'd3_teknikgigi_kekurangan_lk', 'd3_teknikgigi_kekurangan_pr', 'd3_teknikradiologiradioterapi_keadaan_lk', 'd3_teknikradiologiradioterapi_keadaan_pr', 'd3_teknikradiologiradioterapi_kebutuhan_lk', 'd3_teknikradiologiradioterapi_kebutuhan_pr', 'd3_teknikradiologiradioterapi_kekurangan_lk', 'd3_teknikradiologiradioterapi_kekurangan_pr', 'd3_refraksionisoptisien_keadaan_lk', 'd3_refraksionisoptisien_keadaan_pr', 'd3_refraksionisoptisien_kebutuhan_lk', 'd3_refraksionisoptisien_kebutuhan_pr', 'd3_refraksionisoptisien_kekurangan_lk', 'd3_refraksionisoptisien_kekurangan_pr', 'd3_perekammedis_keadaan_lk', 'd3_perekammedis_keadaan_pr', 'd3_perekammedis_kebutuhan_lk', 'd3_perekammedis_kebutuhan_pr', 'd3_perekammedis_kekurangan_lk', 'd3_perekammedis_kekurangan_pr', 'd3_teknikelektromedik_keadaan_lk', 'd3_teknikelektromedik_keadaan_pr', 'd3_teknikelektromedik_kebutuhan_lk', 'd3_teknikelektromedik_kebutuhan_pr', 'd3_teknikelektromedik_kekurangan_lk', 'd3_teknikelektromedik_kekurangan_pr', 'd3_analiskesehatan_keadaan_lk', 'd3_analiskesehatan_keadaan_pr', 'd3_analiskesehatan_kebutuhan_lk', 'd3_analiskesehatan_kebutuhan_pr', 'd3_analiskesehatan_kekurangan_lk', 'd3_analiskesehatan_kekurangan_pr', 'd3_informasikesehatan_keadaan_lk', 'd3_informasikesehatan_keadaan_pr', 'd3_informasikesehatan_kebutuhan_lk', 'd3_informasikesehatan_kebutuhan_pr', 'd3_informasikesehatan_kekurangan_lk', 'd3_informasikesehatan_kekurangan_pr', 'd3_kardiovaskular_keadaan_lk', 'd3_kardiovaskular_keadaan_pr', 'd3_kardiovaskular_kebutuhan_lk', 'd3_kardiovaskular_kebutuhan_pr', 'd3_kardiovaskular_kekurangan_lk', 'd3_kardiovaskular_kekurangan_pr', 'd3_orthotikprostetik_keadaan_lk', 'd3_orthotikprostetik_keadaan_pr', 'd3_orthotikprostetik_kebutuhan_lk', 'd3_orthotikprostetik_kebutuhan_pr', 'd3_orthotikprostetik_kekurangan_lk', 'd3_orthotikprostetik_kekurangan_pr', 'd1_tekniktranfusi_keadaan_lk', 'd1_tekniktranfusi_keadaan_pr', 'd1_tekniktranfusi_kebutuhan_lk', 'd1_tekniktranfusi_kebutuhan_pr', 'd1_tekniktranfusi_kekurangan_lk', 'd1_tekniktranfusi_kekurangan_pr', 'teknisi_gigi_keadaan_lk', 'teknisi_gigi_keadaan_pr', 'teknisi_gigi_kebutuhan_lk', 'teknisi_gigi_kebutuhan_pr', 'teknisi_gigi_kekurangan_lk', 'teknisi_gigi_kekurangan_pr', 'tenaga_itteknologinano_keadaan_lk', 'tenaga_itteknologinano_keadaan_pr', 'tenaga_itteknologinano_kebutuhan_lk', 'tenaga_itteknologinano_kebutuhan_pr', 'tenaga_itteknologinano_kekurangan_lk', 'tenaga_itteknologinano_kekurangan_pr', 'teknisi_patologianatomi_keadaan_lk', 'teknisi_patologianatomi_keadaan_pr', 'teknisi_patologianatomi_kebutuhan_lk', 'teknisi_patologianatomi_kebutuhan_pr', 'teknisi_patologianatomi_kekurangan_lk', 'teknisi_patologianatomi_kekurangan_pr', 'teknisi_kardiovaskular_keadaan_lk', 'teknisi_kardiovaskular_keadaan_pr', 'teknisi_kardiovaskular_kebutuhan_lk', 'teknisi_kardiovaskular_kebutuhan_pr', 'teknisi_kardiovaskular_kekurangan_lk', 'teknisi_kardiovaskular_kekurangan_pr', 'teknisi_elektromedis_keadaan_lk', 'teknisi_elektromedis_keadaan_pr', 'teknisi_elektromedis_kebutuhan_lk', 'teknisi_elektromedis_kebutuhan_pr', 'teknisi_elektromedis_kekurangan_lk', 'teknisi_elektromedis_kekurangan_pr', 'akupuntur_terapi_keadaan_lk', 'akupuntur_terapi_keadaan_pr', 'akupuntur_terapi_kebutuhan_lk', 'akupuntur_terapi_kebutuhan_pr', 'akupuntur_terapi_kekurangan_lk', 'akupuntur_terapi_kekurangan_pr', 'analis_kesehatan_keadaan_lk', 'analis_kesehatan_keadaan_pr', 'analis_kesehatan_kebutuhan_lk', 'analis_kesehatan_kebutuhan_pr', 'analis_kesehatan_kekurangan_lk', 'analis_kesehatan_kekurangan_pr', 'tenaga_keteknisianmedislainnya_keadaan_lk', 'tenaga_keteknisianmedislainnya_keadaan_pr', 'tenaga_keteknisianmedislainnya_kebutuhan_lk', 'tenaga_keteknisianmedislainnya_kebutuhan_pr', 'tenaga_keteknisianmedislainnya_kekurangan_lk', 'tenaga_keteknisianmedislainnya_kekurangan_pr', 's3_biologi_keadaan_lk', 's3_biologi_keadaan_pr', 's3_biologi_kebutuhan_lk', 's3_biologi_kebutuhan_pr', 's3_biologi_kekurangan_lk', 's3_biologi_kekurangan_pr', 's3_kimia_keadaan_lk', 's3_kimia_keadaan_pr', 's3_kimia_kebutuhan_lk', 's3_kimia_kebutuhan_pr', 's3_kimia_kekurangan_lk', 's3_kimia_kekurangan_pr', 's3_ekonomiakuntansi_keadaan_lk', 's3_ekonomiakuntansi_keadaan_pr', 's3_ekonomiakuntansi_kebutuhan_lk', 's3_ekonomiakuntansi_kebutuhan_pr', 's3_ekonomiakuntansi_kekurangan_lk', 's3_ekonomiakuntansi_kekurangan_pr', 's3_administrasi_keadaan_lk', 's3_administrasi_keadaan_pr', 's3_administrasi_kebutuhan_lk', 's3_administrasi_kebutuhan_pr', 's3_administrasi_kekurangan_lk', 's3_administrasi_kekurangan_pr', 's3_hukum_keadaan_lk', 's3_hukum_keadaan_pr', 's3_hukum_kebutuhan_lk', 's3_hukum_kebutuhan_pr', 's3_hukum_kekurangan_lk', 's3_hukum_kekurangan_pr', 's3_tehnik_keadaan_lk', 's3_tehnik_keadaan_pr', 's3_tehnik_kebutuhan_lk', 's3_tehnik_kebutuhan_pr', 's3_tehnik_kekurangan_lk', 's3_tehnik_kekurangan_pr', 's3_kesejahteraansosial_keadaan_lk', 's3_kesejahteraansosial_keadaan_pr', 's3_kesejahteraansosial_kebutuhan_lk', 's3_kesejahteraansosial_kebutuhan_pr', 's3_kesejahteraansosial_kekurangan_lk', 's3_kesejahteraansosial_kekurangan_pr', 's3_fisika_keadaan_lk', 's3_fisika_keadaan_pr', 's3_fisika_kebutuhan_lk', 's3_fisika_kebutuhan_pr', 's3_fisika_kekurangan_lk', 's3_fisika_kekurangan_pr', 's3_komputer_keadaan_lk', 's3_komputer_keadaan_pr', 's3_komputer_kebutuhan_lk', 's3_komputer_kebutuhan_pr', 's3_komputer_kekurangan_lk', 's3_komputer_kekurangan_pr', 's3_statistik_keadaan_lk', 's3_statistik_keadaan_pr', 's3_statistik_kebutuhan_lk', 's3_statistik_kebutuhan_pr', 's3_statistik_kekurangan_lk', 's3_statistik_kekurangan_pr', 'doktoral_lainnya_keadaan_lk', 'doktoral_lainnya_keadaan_pr', 'doktoral_lainnya_kebutuhan_lk', 'doktoral_lainnya_kebutuhan_pr', 'doktoral_lainnya_kekurangan_lk', 'doktoral_lainnya_kekurangan_pr', 's2_biologi_keadaan_lk', 's2_biologi_keadaan_pr', 's2_biologi_kebutuhan_lk', 's2_biologi_kebutuhan_pr', 's2_biologi_kekurangan_lk', 's2_biologi_kekurangan_pr', 's2_kimia_keadaan_lk', 's2_kimia_keadaan_pr', 's2_kimia_kebutuhan_lk', 's2_kimia_kebutuhan_pr', 's2_kimia_kekurangan_lk', 's2_kimia_kekurangan_pr', 's2_ekonomiakuntansi_keadaan_lk', 's2_ekonomiakuntansi_keadaan_pr', 's2_ekonomiakuntansi_kebutuhan_lk', 's2_ekonomiakuntansi_kebutuhan_pr', 's2_ekonomiakuntansi_kekurangan_lk', 's2_ekonomiakuntansi_kekurangan_pr', 's2_administrasi_keadaan_lk', 's2_administrasi_keadaan_pr', 's2_administrasi_kebutuhan_lk', 's2_administrasi_kebutuhan_pr', 's2_administrasi_kekurangan_lk', 's2_administrasi_kekurangan_pr', 's2_hukum_keadaan_lk', 's2_hukum_keadaan_pr', 's2_hukum_kebutuhan_lk', 's2_hukum_kebutuhan_pr', 's2_hukum_kekurangan_lk', 's2_hukum_kekurangan_pr', 's2_tehnik_keadaan_lk', 's2_tehnik_keadaan_pr', 's2_tehnik_kebutuhan_lk', 's2_tehnik_kebutuhan_pr', 's2_tehnik_kekurangan_lk', 's2_tehnik_kekurangan_pr', 's2_kesejahteraansosial_keadaan_lk', 's2_kesejahteraansosial_keadaan_pr', 's2_kesejahteraansosial_kebutuhan_lk', 's2_kesejahteraansosial_kebutuhan_pr', 's2_kesejahteraansosial_kekurangan_lk', 's2_kesejahteraansosial_kekurangan_pr', 's2_fisika_keadaan_lk', 's2_fisika_keadaan_pr', 's2_fisika_kebutuhan_lk', 's2_fisika_kebutuhan_pr', 's2_fisika_kekurangan_lk', 's2_fisika_kekurangan_pr', 's2_komputer_keadaan_lk', 's2_komputer_keadaan_pr', 's2_komputer_kebutuhan_lk', 's2_komputer_kebutuhan_pr', 's2_komputer_kekurangan_lk', 's2_komputer_kekurangan_pr', 's2_statistik_keadaan_lk', 's2_statistik_keadaan_pr', 's2_statistik_kebutuhan_lk', 's2_statistik_kebutuhan_pr', 's2_statistik_kekurangan_lk', 's2_statistik_kekurangan_pr', 's2_administrasikesehatanmasyarakat_keadaan_lk', 's2_administrasikesehatanmasyarakat_keadaan_pr', 's2_administrasikesehatanmasyarakat_kebutuhan_lk', 's2_administrasikesehatanmasyarakat_kebutuhan_pr', 's2_administrasikesehatanmasyarakat_kekurangan_lk', 's2_administrasikesehatanmasyarakat_kekurangan_pr', 'pasca_sarjanalainnya_keadaan_lk', 'pasca_sarjanalainnya_keadaan_pr', 'pasca_sarjanalainnya_kebutuhan_lk', 'pasca_sarjanalainnya_kebutuhan_pr', 'pasca_sarjanalainnya_kekurangan_lk', 'pasca_sarjanalainnya_kekurangan_pr', 'sarjana_biologi_keadaan_lk', 'sarjana_biologi_keadaan_pr', 'sarjana_biologi_kebutuhan_lk', 'sarjana_biologi_kebutuhan_pr', 'sarjana_biologi_kekurangan_lk', 'sarjana_biologi_kekurangan_pr', 'sarjana_kimia_keadaan_lk', 'sarjana_kimia_keadaan_pr', 'sarjana_kimia_kebutuhan_lk', 'sarjana_kimia_kebutuhan_pr', 'sarjana_kimia_kekurangan_lk', 'sarjana_kimia_kekurangan_pr', 'sarjana_ekonomiakuntansi_keadaan_lk', 'sarjana_ekonomiakuntansi_keadaan_pr', 'sarjana_ekonomiakuntansi_kebutuhan_lk', 'sarjana_ekonomiakuntansi_kebutuhan_pr', 'sarjana_ekonomiakuntansi_kekurangan_lk', 'sarjana_ekonomiakuntansi_kekurangan_pr', 'sarjana_administrasi_keadaan_lk', 'sarjana_administrasi_keadaan_pr', 'sarjana_administrasi_kebutuhan_lk', 'sarjana_administrasi_kebutuhan_pr', 'sarjana_administrasi_kekurangan_lk', 'sarjana_administrasi_kekurangan_pr', 'sarjana_hukum_keadaan_lk', 'sarjana_hukum_keadaan_pr', 'sarjana_hukum_kebutuhan_lk', 'sarjana_hukum_kebutuhan_pr', 'sarjana_hukum_kekurangan_lk', 'sarjana_hukum_kekurangan_pr', 'sarjana_tehnik_keadaan_lk', 'sarjana_tehnik_keadaan_pr', 'sarjana_tehnik_kebutuhan_lk', 'sarjana_tehnik_kebutuhan_pr', 'sarjana_tehnik_kekurangan_lk', 'sarjana_tehnik_kekurangan_pr', 'sarjana_kesejahteraansosial_keadaan_lk', 'sarjana_kesejahteraansosial_keadaan_pr', 'sarjana_kesejahteraansosial_kebutuhan_lk', 'sarjana_kesejahteraansosial_kebutuhan_pr', 'sarjana_kesejahteraansosial_kekurangan_lk', 'sarjana_kesejahteraansosial_kekurangan_pr', 'sarjana_fisika_keadaan_lk', 'sarjana_fisika_keadaan_pr', 'sarjana_fisika_kebutuhan_lk', 'sarjana_fisika_kebutuhan_pr', 'sarjana_fisika_kekurangan_lk', 'sarjana_fisika_kekurangan_pr', 'sarjana_komputer_keadaan_lk', 'sarjana_komputer_keadaan_pr', 'sarjana_komputer_kebutuhan_lk', 'sarjana_komputer_kebutuhan_pr', 'sarjana_komputer_kekurangan_lk', 'sarjana_komputer_kekurangan_pr', 'sarjana_statistik_keadaan_lk', 'sarjana_statistik_keadaan_pr', 'sarjana_statistik_kebutuhan_lk', 'sarjana_statistik_kebutuhan_pr', 'sarjana_statistik_kekurangan_lk', 'sarjana_statistik_kekurangan_pr', 'sarjana_lainnya_keadaan_lk', 'sarjana_lainnya_keadaan_pr', 'sarjana_lainnya_kebutuhan_lk', 'sarjana_lainnya_kebutuhan_pr', 'sarjana_lainnya_kekurangan_lk', 'sarjana_lainnya_kekurangan_pr', 'sarjana_muda_biologi_keadaan_lk', 'sarjana_muda_biologi_keadaan_pr', 'sarjana_muda_biologi_kebutuhan_lk', 'sarjana_muda_biologi_kebutuhan_pr', 'sarjana_muda_biologi_kekurangan_lk', 'sarjana_muda_biologi_kekurangan_pr', 'sarjana_muda_kimia_keadaan_lk', 'sarjana_muda_kimia_keadaan_pr', 'sarjana_muda_kimia_kebutuhan_lk', 'sarjana_muda_kimia_kebutuhan_pr', 'sarjana_muda_kimia_kekurangan_lk', 'sarjana_muda_kimia_kekurangan_pr', 'sarjana_muda_ekonomiakuntansi_keadaan_lk', 'sarjana_muda_ekonomiakuntansi_keadaan_pr', 'sarjana_muda_ekonomiakuntansi_kebutuhan_lk', 'sarjana_muda_ekonomiakuntansi_kebutuhan_pr', 'sarjana_muda_ekonomiakuntansi_kekurangan_lk', 'sarjana_muda_ekonomiakuntansi_kekurangan_pr', 'sarjana_muda_administrasi_keadaan_lk', 'sarjana_muda_administrasi_keadaan_pr', 'sarjana_muda_administrasi_kebutuhan_lk', 'sarjana_muda_administrasi_kebutuhan_pr', 'sarjana_muda_administrasi_kekurangan_lk', 'sarjana_muda_administrasi_kekurangan_pr', 'sarjana_muda_hukum_keadaan_lk', 'sarjana_muda_hukum_keadaan_pr', 'sarjana_muda_hukum_kebutuhan_lk', 'sarjana_muda_hukum_kebutuhan_pr', 'sarjana_muda_hukum_kekurangan_lk', 'sarjana_muda_hukum_kekurangan_pr', 'sarjana_muda_tehnik_keadaan_lk', 'sarjana_muda_tehnik_keadaan_pr', 'sarjana_muda_tehnik_kebutuhan_lk', 'sarjana_muda_tehnik_kebutuhan_pr', 'sarjana_muda_tehnik_kekurangan_lk', 'sarjana_muda_tehnik_kekurangan_pr', 'sarjana_muda_kesejahteraansosial_keadaan_lk', 'sarjana_muda_kesejahteraansosial_keadaan_pr', 'sarjana_muda_kesejahteraansosial_kebutuhan_lk', 'sarjana_muda_kesejahteraansosial_kebutuhan_pr', 'sarjana_muda_kesejahteraansosial_kekurangan_lk', 'sarjana_muda_kesejahteraansosial_kekurangan_pr', 'sarjana_muda_sekretaris_keadaan_lk', 'sarjana_muda_sekretaris_keadaan_pr', 'sarjana_muda_sekretaris_kebutuhan_lk', 'sarjana_muda_sekretaris_kebutuhan_pr', 'sarjana_muda_sekretaris_kekurangan_lk', 'sarjana_muda_sekretaris_kekurangan_pr', 'sarjana_muda_komputer_keadaan_lk', 'sarjana_muda_komputer_keadaan_pr', 'sarjana_muda_komputer_kebutuhan_lk', 'sarjana_muda_komputer_kebutuhan_pr', 'sarjana_muda_komputer_kekurangan_lk', 'sarjana_muda_komputer_kekurangan_pr', 'sarjana_muda_statistik_keadaan_lk', 'sarjana_muda_statistik_keadaan_pr', 'sarjana_muda_statistik_kebutuhan_lk', 'sarjana_muda_statistik_kebutuhan_pr', 'sarjana_muda_statistik_kekurangan_lk', 'sarjana_muda_statistik_kekurangan_pr', 'sarjana_muda_lainnya_keadaan_lk', 'sarjana_muda_lainnya_keadaan_pr', 'sarjana_muda_lainnya_kebutuhan_lk', 'sarjana_muda_lainnya_kebutuhan_pr', 'sarjana_muda_lainnya_kekurangan_lk', 'sarjana_muda_lainnya_kekurangan_pr', 'sma_smu_keadaan_lk', 'sma_smu_keadaan_pr', 'sma_smu_kebutuhan_lk', 'sma_smu_kebutuhan_pr', 'sma_smu_kekurangan_lk', 'sma_smu_kekurangan_pr', 'smea_keadaan_lk', 'smea_keadaan_pr', 'smea_kebutuhan_lk', 'smea_kebutuhan_pr', 'smea_kekurangan_lk', 'smea_kekurangan_pr', 'stm_keadaan_lk', 'stm_keadaan_pr', 'stm_kebutuhan_lk', 'stm_kebutuhan_pr', 'stm_kekurangan_lk', 'stm_kekurangan_pr', 'smkk_keadaan_lk', 'smkk_keadaan_pr', 'smkk_kebutuhan_lk', 'smkk_kebutuhan_pr', 'smkk_kekurangan_lk', 'smkk_kekurangan_pr', 'spsa_keadaan_lk', 'spsa_keadaan_pr', 'spsa_kebutuhan_lk', 'spsa_kebutuhan_pr', 'spsa_kekurangan_lk', 'spsa_kekurangan_pr', 'smtp_keadaan_lk', 'smtp_keadaan_pr', 'smtp_kebutuhan_lk', 'smtp_kebutuhan_pr', 'smtp_kekurangan_lk', 'smtp_kekurangan_pr', 'sd_kebawah_keadaan_lk', 'sd_kebawah_keadaan_pr', 'sd_kebawah_kebutuhan_lk', 'sd_kebawah_kebutuhan_pr', 'sd_kebawah_kekurangan_lk', 'sd_kebawah_kekurangan_pr', 'smta_lainnya_keadaan_lk', 'smta_lainnya_keadaan_pr', 'smta_lainnya_kebutuhan_lk', 'smta_lainnya_kebutuhan_pr', 'smta_lainnya_kekurangan_lk', 'smta_lainnya_kekurangan_pr', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['tahun', 'updated_by'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ketenagaan_id' => 'Ketenagaan ID',
            'tahun' => 'Tahun',
            'dokter_umum_keadaan_lk' => 'Dokter Umum Keadaan Lk',
            'dokter_umum_keadaan_pr' => 'Dokter Umum Keadaan Pr',
            'dokter_umum_kebutuhan_lk' => 'Dokter Umum Kebutuhan Lk',
            'dokter_umum_kebutuhan_pr' => 'Dokter Umum Kebutuhan Pr',
            'dokter_umum_kekurangan_lk' => 'Dokter Umum Kekurangan Lk',
            'dokter_umum_kekurangan_pr' => 'Dokter Umum Kekurangan Pr',
            'dokter_ppds_keadaan_lk' => 'Dokter Ppds Keadaan Lk',
            'dokter_ppds_keadaan_pr' => 'Dokter Ppds Keadaan Pr',
            'dokter_ppds_kebutuhan_lk' => 'Dokter Ppds Kebutuhan Lk',
            'dokter_ppds_kebutuhan_pr' => 'Dokter Ppds Kebutuhan Pr',
            'dokter_ppds_kekurangan_lk' => 'Dokter Ppds Kekurangan Lk',
            'dokter_ppds_kekurangan_pr' => 'Dokter Ppds Kekurangan Pr',
            'dokter_spesialisbedah_keadaan_lk' => 'Dokter Spesialisbedah Keadaan Lk',
            'dokter_spesialisbedah_keadaan_pr' => 'Dokter Spesialisbedah Keadaan Pr',
            'dokter_spesialisbedah_kebutuhan_lk' => 'Dokter Spesialisbedah Kebutuhan Lk',
            'dokter_spesialisbedah_kebutuhan_pr' => 'Dokter Spesialisbedah Kebutuhan Pr',
            'dokter_spesialisbedah_kekurangan_lk' => 'Dokter Spesialisbedah Kekurangan Lk',
            'dokter_spesialisbedah_kekurangan_pr' => 'Dokter Spesialisbedah Kekurangan Pr',
            'dokter_spesialispenyakitdalam_keadaan_lk' => 'Dokter Spesialispenyakitdalam Keadaan Lk',
            'dokter_spesialispenyakitdalam_keadaan_pr' => 'Dokter Spesialispenyakitdalam Keadaan Pr',
            'dokter_spesialispenyakitdalam_kebutuhan_lk' => 'Dokter Spesialispenyakitdalam Kebutuhan Lk',
            'dokter_spesialispenyakitdalam_kebutuhan_pr' => 'Dokter Spesialispenyakitdalam Kebutuhan Pr',
            'dokter_spesialispenyakitdalam_kekurangan_lk' => 'Dokter Spesialispenyakitdalam Kekurangan Lk',
            'dokter_spesialispenyakitdalam_kekurangan_pr' => 'Dokter Spesialispenyakitdalam Kekurangan Pr',
            'dokter_spesialiskesehatananak_keadaan_lk' => 'Dokter Spesialiskesehatananak Keadaan Lk',
            'dokter_spesialiskesehatananak_keadaan_pr' => 'Dokter Spesialiskesehatananak Keadaan Pr',
            'dokter_spesialiskesehatananak_kebutuhan_lk' => 'Dokter Spesialiskesehatananak Kebutuhan Lk',
            'dokter_spesialiskesehatananak_kebutuhan_pr' => 'Dokter Spesialiskesehatananak Kebutuhan Pr',
            'dokter_spesialiskesehatananak_kekurangan_lk' => 'Dokter Spesialiskesehatananak Kekurangan Lk',
            'dokter_spesialiskesehatananak_kekurangan_pr' => 'Dokter Spesialiskesehatananak Kekurangan Pr',
            'dokter_spesialisobgin_keadaan_lk' => 'Dokter Spesialisobgin Keadaan Lk',
            'dokter_spesialisobgin_keadaan_pr' => 'Dokter Spesialisobgin Keadaan Pr',
            'dokter_spesialisobgin_kebutuhan_lk' => 'Dokter Spesialisobgin Kebutuhan Lk',
            'dokter_spesialisobgin_kebutuhan_pr' => 'Dokter Spesialisobgin Kebutuhan Pr',
            'dokter_spesialisobgin_kekurangan_lk' => 'Dokter Spesialisobgin Kekurangan Lk',
            'dokter_spesialisobgin_kekurangan_pr' => 'Dokter Spesialisobgin Kekurangan Pr',
            'dokter_spesialisradiologi_keadaan_lk' => 'Dokter Spesialisradiologi Keadaan Lk',
            'dokter_spesialisradiologi_keadaan_pr' => 'Dokter Spesialisradiologi Keadaan Pr',
            'dokter_spesialisradiologi_kebutuhan_lk' => 'Dokter Spesialisradiologi Kebutuhan Lk',
            'dokter_spesialisradiologi_kebutuhan_pr' => 'Dokter Spesialisradiologi Kebutuhan Pr',
            'dokter_spesialisradiologi_kekurangan_lk' => 'Dokter Spesialisradiologi Kekurangan Lk',
            'dokter_spesialisradiologi_kekurangan_pr' => 'Dokter Spesialisradiologi Kekurangan Pr',
            'dokter_spesialisonkologiradiasi_keadaan_lk' => 'Dokter Spesialisonkologiradiasi Keadaan Lk',
            'dokter_spesialisonkologiradiasi_keadaan_pr' => 'Dokter Spesialisonkologiradiasi Keadaan Pr',
            'dokter_spesialisonkologiradiasi_kebutuhan_lk' => 'Dokter Spesialisonkologiradiasi Kebutuhan Lk',
            'dokter_spesialisonkologiradiasi_kebutuhan_pr' => 'Dokter Spesialisonkologiradiasi Kebutuhan Pr',
            'dokter_spesialisonkologiradiasi_kekurangan_lk' => 'Dokter Spesialisonkologiradiasi Kekurangan Lk',
            'dokter_spesialisonkologiradiasi_kekurangan_pr' => 'Dokter Spesialisonkologiradiasi Kekurangan Pr',
            'dokter_spesialiskedokterannulir_keadaan_lk' => 'Dokter Spesialiskedokterannulir Keadaan Lk',
            'dokter_spesialiskedokterannulir_keadaan_pr' => 'Dokter Spesialiskedokterannulir Keadaan Pr',
            'dokter_spesialiskedokterannulir_kebutuhan_lk' => 'Dokter Spesialiskedokterannulir Kebutuhan Lk',
            'dokter_spesialiskedokterannulir_kebutuhan_pr' => 'Dokter Spesialiskedokterannulir Kebutuhan Pr',
            'dokter_spesialiskedokterannulir_kekurangan_lk' => 'Dokter Spesialiskedokterannulir Kekurangan Lk',
            'dokter_spesialiskedokterannulir_kekurangan_pr' => 'Dokter Spesialiskedokterannulir Kekurangan Pr',
            'dokter_spesialisanesthesi_keadaan_lk' => 'Dokter Spesialisanesthesi Keadaan Lk',
            'dokter_spesialisanesthesi_keadaan_pr' => 'Dokter Spesialisanesthesi Keadaan Pr',
            'dokter_spesialisanesthesi_kebutuhan_lk' => 'Dokter Spesialisanesthesi Kebutuhan Lk',
            'dokter_spesialisanesthesi_kebutuhan_pr' => 'Dokter Spesialisanesthesi Kebutuhan Pr',
            'dokter_spesialisanesthesi_kekurangan_lk' => 'Dokter Spesialisanesthesi Kekurangan Lk',
            'dokter_spesialisanesthesi_kekurangan_pr' => 'Dokter Spesialisanesthesi Kekurangan Pr',
            'dokter_spesialispatologiklinik_keadaan_lk' => 'Dokter Spesialispatologiklinik Keadaan Lk',
            'dokter_spesialispatologiklinik_keadaan_pr' => 'Dokter Spesialispatologiklinik Keadaan Pr',
            'dokter_spesialispatologiklinik_kebutuhan_lk' => 'Dokter Spesialispatologiklinik Kebutuhan Lk',
            'dokter_spesialispatologiklinik_kebutuhan_pr' => 'Dokter Spesialispatologiklinik Kebutuhan Pr',
            'dokter_spesialispatologiklinik_kekurangan_lk' => 'Dokter Spesialispatologiklinik Kekurangan Lk',
            'dokter_spesialispatologiklinik_kekurangan_pr' => 'Dokter Spesialispatologiklinik Kekurangan Pr',
            'dokter_spesialisjiwa_keadaan_lk' => 'Dokter Spesialisjiwa Keadaan Lk',
            'dokter_spesialisjiwa_keadaan_pr' => 'Dokter Spesialisjiwa Keadaan Pr',
            'dokter_spesialisjiwa_kebutuhan_lk' => 'Dokter Spesialisjiwa Kebutuhan Lk',
            'dokter_spesialisjiwa_kebutuhan_pr' => 'Dokter Spesialisjiwa Kebutuhan Pr',
            'dokter_spesialisjiwa_kekurangan_lk' => 'Dokter Spesialisjiwa Kekurangan Lk',
            'dokter_spesialisjiwa_kekurangan_pr' => 'Dokter Spesialisjiwa Kekurangan Pr',
            'dokter_spesialismata_keadaan_lk' => 'Dokter Spesialismata Keadaan Lk',
            'dokter_spesialismata_keadaan_pr' => 'Dokter Spesialismata Keadaan Pr',
            'dokter_spesialismata_kebutuhan_lk' => 'Dokter Spesialismata Kebutuhan Lk',
            'dokter_spesialismata_kebutuhan_pr' => 'Dokter Spesialismata Kebutuhan Pr',
            'dokter_spesialismata_kekurangan_lk' => 'Dokter Spesialismata Kekurangan Lk',
            'dokter_spesialismata_kekurangan_pr' => 'Dokter Spesialismata Kekurangan Pr',
            'dokter_spesialistht_keadaan_lk' => 'Dokter Spesialistht Keadaan Lk',
            'dokter_spesialistht_keadaan_pr' => 'Dokter Spesialistht Keadaan Pr',
            'dokter_spesialistht_kebutuhan_lk' => 'Dokter Spesialistht Kebutuhan Lk',
            'dokter_spesialistht_kebutuhan_pr' => 'Dokter Spesialistht Kebutuhan Pr',
            'dokter_spesialistht_kekurangan_lk' => 'Dokter Spesialistht Kekurangan Lk',
            'dokter_spesialistht_kekurangan_pr' => 'Dokter Spesialistht Kekurangan Pr',
            'dokter_spesialiskulitkelamin_keadaan_lk' => 'Dokter Spesialiskulitkelamin Keadaan Lk',
            'dokter_spesialiskulitkelamin_keadaan_pr' => 'Dokter Spesialiskulitkelamin Keadaan Pr',
            'dokter_spesialiskulitkelamin_kebutuhan_lk' => 'Dokter Spesialiskulitkelamin Kebutuhan Lk',
            'dokter_spesialiskulitkelamin_kebutuhan_pr' => 'Dokter Spesialiskulitkelamin Kebutuhan Pr',
            'dokter_spesialiskulitkelamin_kekurangan_lk' => 'Dokter Spesialiskulitkelamin Kekurangan Lk',
            'dokter_spesialiskulitkelamin_kekurangan_pr' => 'Dokter Spesialiskulitkelamin Kekurangan Pr',
            'dokter_spesialiskardiologi_keadaan_lk' => 'Dokter Spesialiskardiologi Keadaan Lk',
            'dokter_spesialiskardiologi_keadaan_pr' => 'Dokter Spesialiskardiologi Keadaan Pr',
            'dokter_spesialiskardiologi_kebutuhan_lk' => 'Dokter Spesialiskardiologi Kebutuhan Lk',
            'dokter_spesialiskardiologi_kebutuhan_pr' => 'Dokter Spesialiskardiologi Kebutuhan Pr',
            'dokter_spesialiskardiologi_kekurangan_lk' => 'Dokter Spesialiskardiologi Kekurangan Lk',
            'dokter_spesialiskardiologi_kekurangan_pr' => 'Dokter Spesialiskardiologi Kekurangan Pr',
            'dokter_spesialisparu_keadaan_lk' => 'Dokter Spesialisparu Keadaan Lk',
            'dokter_spesialisparu_keadaan_pr' => 'Dokter Spesialisparu Keadaan Pr',
            'dokter_spesialisparu_kebutuhan_lk' => 'Dokter Spesialisparu Kebutuhan Lk',
            'dokter_spesialisparu_kebutuhan_pr' => 'Dokter Spesialisparu Kebutuhan Pr',
            'dokter_spesialisparu_kekurangan_lk' => 'Dokter Spesialisparu Kekurangan Lk',
            'dokter_spesialisparu_kekurangan_pr' => 'Dokter Spesialisparu Kekurangan Pr',
            'dokter_spesialissaraf_keadaan_lk' => 'Dokter Spesialissaraf Keadaan Lk',
            'dokter_spesialissaraf_keadaan_pr' => 'Dokter Spesialissaraf Keadaan Pr',
            'dokter_spesialissaraf_kebutuhan_lk' => 'Dokter Spesialissaraf Kebutuhan Lk',
            'dokter_spesialissaraf_kebutuhan_pr' => 'Dokter Spesialissaraf Kebutuhan Pr',
            'dokter_spesialissaraf_kekurangan_lk' => 'Dokter Spesialissaraf Kekurangan Lk',
            'dokter_spesialissaraf_kekurangan_pr' => 'Dokter Spesialissaraf Kekurangan Pr',
            'dokter_spesialisbedahsaraf_keadaan_lk' => 'Dokter Spesialisbedahsaraf Keadaan Lk',
            'dokter_spesialisbedahsaraf_keadaan_pr' => 'Dokter Spesialisbedahsaraf Keadaan Pr',
            'dokter_spesialisbedahsaraf_kebutuhan_lk' => 'Dokter Spesialisbedahsaraf Kebutuhan Lk',
            'dokter_spesialisbedahsaraf_kebutuhan_pr' => 'Dokter Spesialisbedahsaraf Kebutuhan Pr',
            'dokter_spesialisbedahsaraf_kekurangan_lk' => 'Dokter Spesialisbedahsaraf Kekurangan Lk',
            'dokter_spesialisbedahsaraf_kekurangan_pr' => 'Dokter Spesialisbedahsaraf Kekurangan Pr',
            'dokter_spesialisbedahorthopedi_keadaan_lk' => 'Dokter Spesialisbedahorthopedi Keadaan Lk',
            'dokter_spesialisbedahorthopedi_keadaan_pr' => 'Dokter Spesialisbedahorthopedi Keadaan Pr',
            'dokter_spesialisbedahorthopedi_kebutuhan_lk' => 'Dokter Spesialisbedahorthopedi Kebutuhan Lk',
            'dokter_spesialisbedahorthopedi_kebutuhan_pr' => 'Dokter Spesialisbedahorthopedi Kebutuhan Pr',
            'dokter_spesialisbedahorthopedi_kekurangan_lk' => 'Dokter Spesialisbedahorthopedi Kekurangan Lk',
            'dokter_spesialisbedahorthopedi_kekurangan_pr' => 'Dokter Spesialisbedahorthopedi Kekurangan Pr',
            'dokter_spesialisurologi_keadaan_lk' => 'Dokter Spesialisurologi Keadaan Lk',
            'dokter_spesialisurologi_keadaan_pr' => 'Dokter Spesialisurologi Keadaan Pr',
            'dokter_spesialisurologi_kebutuhan_lk' => 'Dokter Spesialisurologi Kebutuhan Lk',
            'dokter_spesialisurologi_kebutuhan_pr' => 'Dokter Spesialisurologi Kebutuhan Pr',
            'dokter_spesialisurologi_kekurangan_lk' => 'Dokter Spesialisurologi Kekurangan Lk',
            'dokter_spesialisurologi_kekurangan_pr' => 'Dokter Spesialisurologi Kekurangan Pr',
            'dokter_spesialispatologianatomi_keadaan_lk' => 'Dokter Spesialispatologianatomi Keadaan Lk',
            'dokter_spesialispatologianatomi_keadaan_pr' => 'Dokter Spesialispatologianatomi Keadaan Pr',
            'dokter_spesialispatologianatomi_kebutuhan_lk' => 'Dokter Spesialispatologianatomi Kebutuhan Lk',
            'dokter_spesialispatologianatomi_kebutuhan_pr' => 'Dokter Spesialispatologianatomi Kebutuhan Pr',
            'dokter_spesialispatologianatomi_kekurangan_lk' => 'Dokter Spesialispatologianatomi Kekurangan Lk',
            'dokter_spesialispatologianatomi_kekurangan_pr' => 'Dokter Spesialispatologianatomi Kekurangan Pr',
            'dokter_spesialispatologiforensik_keadaan_lk' => 'Dokter Spesialispatologiforensik Keadaan Lk',
            'dokter_spesialispatologiforensik_keadaan_pr' => 'Dokter Spesialispatologiforensik Keadaan Pr',
            'dokter_spesialispatologiforensik_kebutuhan_lk' => 'Dokter Spesialispatologiforensik Kebutuhan Lk',
            'dokter_spesialispatologiforensik_kebutuhan_pr' => 'Dokter Spesialispatologiforensik Kebutuhan Pr',
            'dokter_spesialispatologiforensik_kekurangan_lk' => 'Dokter Spesialispatologiforensik Kekurangan Lk',
            'dokter_spesialispatologiforensik_kekurangan_pr' => 'Dokter Spesialispatologiforensik Kekurangan Pr',
            'dokter_spesialisrehabilitasimedik_keadaan_lk' => 'Dokter Spesialisrehabilitasimedik Keadaan Lk',
            'dokter_spesialisrehabilitasimedik_keadaan_pr' => 'Dokter Spesialisrehabilitasimedik Keadaan Pr',
            'dokter_spesialisrehabilitasimedik_kebutuhan_lk' => 'Dokter Spesialisrehabilitasimedik Kebutuhan Lk',
            'dokter_spesialisrehabilitasimedik_kebutuhan_pr' => 'Dokter Spesialisrehabilitasimedik Kebutuhan Pr',
            'dokter_spesialisrehabilitasimedik_kekurangan_lk' => 'Dokter Spesialisrehabilitasimedik Kekurangan Lk',
            'dokter_spesialisrehabilitasimedik_kekurangan_pr' => 'Dokter Spesialisrehabilitasimedik Kekurangan Pr',
            'dokter_spesialisbedahplastik_keadaan_lk' => 'Dokter Spesialisbedahplastik Keadaan Lk',
            'dokter_spesialisbedahplastik_keadaan_pr' => 'Dokter Spesialisbedahplastik Keadaan Pr',
            'dokter_spesialisbedahplastik_kebutuhan_lk' => 'Dokter Spesialisbedahplastik Kebutuhan Lk',
            'dokter_spesialisbedahplastik_kebutuhan_pr' => 'Dokter Spesialisbedahplastik Kebutuhan Pr',
            'dokter_spesialisbedahplastik_kekurangan_lk' => 'Dokter Spesialisbedahplastik Kekurangan Lk',
            'dokter_spesialisbedahplastik_kekurangan_pr' => 'Dokter Spesialisbedahplastik Kekurangan Pr',
            'dokter_spesialiskedokteranolahraga_keadaan_lk' => 'Dokter Spesialiskedokteranolahraga Keadaan Lk',
            'dokter_spesialiskedokteranolahraga_keadaan_pr' => 'Dokter Spesialiskedokteranolahraga Keadaan Pr',
            'dokter_spesialiskedokteranolahraga_kebutuhan_lk' => 'Dokter Spesialiskedokteranolahraga Kebutuhan Lk',
            'dokter_spesialiskedokteranolahraga_kebutuhan_pr' => 'Dokter Spesialiskedokteranolahraga Kebutuhan Pr',
            'dokter_spesialiskedokteranolahraga_kekurangan_lk' => 'Dokter Spesialiskedokteranolahraga Kekurangan Lk',
            'dokter_spesialiskedokteranolahraga_kekurangan_pr' => 'Dokter Spesialiskedokteranolahraga Kekurangan Pr',
            'dokter_spesialismikrobiologiklinik_keadaan_lk' => 'Dokter Spesialismikrobiologiklinik Keadaan Lk',
            'dokter_spesialismikrobiologiklinik_keadaan_pr' => 'Dokter Spesialismikrobiologiklinik Keadaan Pr',
            'dokter_spesialismikrobiologiklinik_kebutuhan_lk' => 'Dokter Spesialismikrobiologiklinik Kebutuhan Lk',
            'dokter_spesialismikrobiologiklinik_kebutuhan_pr' => 'Dokter Spesialismikrobiologiklinik Kebutuhan Pr',
            'dokter_spesialismikrobiologiklinik_kekurangan_lk' => 'Dokter Spesialismikrobiologiklinik Kekurangan Lk',
            'dokter_spesialismikrobiologiklinik_kekurangan_pr' => 'Dokter Spesialismikrobiologiklinik Kekurangan Pr',
            'dokter_spesialisparasitologiklinik_keadaan_lk' => 'Dokter Spesialisparasitologiklinik Keadaan Lk',
            'dokter_spesialisparasitologiklinik_keadaan_pr' => 'Dokter Spesialisparasitologiklinik Keadaan Pr',
            'dokter_spesialisparasitologiklinik_kebutuhan_lk' => 'Dokter Spesialisparasitologiklinik Kebutuhan Lk',
            'dokter_spesialisparasitologiklinik_kebutuhan_pr' => 'Dokter Spesialisparasitologiklinik Kebutuhan Pr',
            'dokter_spesialisparasitologiklinik_kekurangan_lk' => 'Dokter Spesialisparasitologiklinik Kekurangan Lk',
            'dokter_spesialisparasitologiklinik_kekurangan_pr' => 'Dokter Spesialisparasitologiklinik Kekurangan Pr',
            'dokter_spesialisgizimedik_keadaan_lk' => 'Dokter Spesialisgizimedik Keadaan Lk',
            'dokter_spesialisgizimedik_keadaan_pr' => 'Dokter Spesialisgizimedik Keadaan Pr',
            'dokter_spesialisgizimedik_kebutuhan_lk' => 'Dokter Spesialisgizimedik Kebutuhan Lk',
            'dokter_spesialisgizimedik_kebutuhan_pr' => 'Dokter Spesialisgizimedik Kebutuhan Pr',
            'dokter_spesialisgizimedik_kekurangan_lk' => 'Dokter Spesialisgizimedik Kekurangan Lk',
            'dokter_spesialisgizimedik_kekurangan_pr' => 'Dokter Spesialisgizimedik Kekurangan Pr',
            'dokter_spesialisfarmaklinik_keadaan_lk' => 'Dokter Spesialisfarmaklinik Keadaan Lk',
            'dokter_spesialisfarmaklinik_keadaan_pr' => 'Dokter Spesialisfarmaklinik Keadaan Pr',
            'dokter_spesialisfarmaklinik_kebutuhan_lk' => 'Dokter Spesialisfarmaklinik Kebutuhan Lk',
            'dokter_spesialisfarmaklinik_kebutuhan_pr' => 'Dokter Spesialisfarmaklinik Kebutuhan Pr',
            'dokter_spesialisfarmaklinik_kekurangan_lk' => 'Dokter Spesialisfarmaklinik Kekurangan Lk',
            'dokter_spesialisfarmaklinik_kekurangan_pr' => 'Dokter Spesialisfarmaklinik Kekurangan Pr',
            'dokter_spesialislainnya_keadaan_lk' => 'Dokter Spesialislainnya Keadaan Lk',
            'dokter_spesialislainnya_keadaan_pr' => 'Dokter Spesialislainnya Keadaan Pr',
            'dokter_spesialislainnya_kebutuhan_lk' => 'Dokter Spesialislainnya Kebutuhan Lk',
            'dokter_spesialislainnya_kebutuhan_pr' => 'Dokter Spesialislainnya Kebutuhan Pr',
            'dokter_spesialislainnya_kekurangan_lk' => 'Dokter Spesialislainnya Kekurangan Lk',
            'dokter_spesialislainnya_kekurangan_pr' => 'Dokter Spesialislainnya Kekurangan Pr',
            'dokter_subspesialislainnya_keadaan_lk' => 'Dokter Subspesialislainnya Keadaan Lk',
            'dokter_subspesialislainnya_keadaan_pr' => 'Dokter Subspesialislainnya Keadaan Pr',
            'dokter_subspesialislainnya_kebutuhan_lk' => 'Dokter Subspesialislainnya Kebutuhan Lk',
            'dokter_subspesialislainnya_kebutuhan_pr' => 'Dokter Subspesialislainnya Kebutuhan Pr',
            'dokter_subspesialislainnya_kekurangan_lk' => 'Dokter Subspesialislainnya Kekurangan Lk',
            'dokter_subspesialislainnya_kekurangan_pr' => 'Dokter Subspesialislainnya Kekurangan Pr',
            'dokter_gigi_keadaan_lk' => 'Dokter Gigi Keadaan Lk',
            'dokter_gigi_keadaan_pr' => 'Dokter Gigi Keadaan Pr',
            'dokter_gigi_kebutuhan_lk' => 'Dokter Gigi Kebutuhan Lk',
            'dokter_gigi_kebutuhan_pr' => 'Dokter Gigi Kebutuhan Pr',
            'dokter_gigi_kekurangan_lk' => 'Dokter Gigi Kekurangan Lk',
            'dokter_gigi_kekurangan_pr' => 'Dokter Gigi Kekurangan Pr',
            'dokter_gigi_spesialis_keadaan_lk' => 'Dokter Gigi Spesialis Keadaan Lk',
            'dokter_gigi_spesialis_keadaan_pr' => 'Dokter Gigi Spesialis Keadaan Pr',
            'dokter_gigi_spesialis_kebutuhan_lk' => 'Dokter Gigi Spesialis Kebutuhan Lk',
            'dokter_gigi_spesialis_kebutuhan_pr' => 'Dokter Gigi Spesialis Kebutuhan Pr',
            'dokter_gigi_spesialis_kekurangan_lk' => 'Dokter Gigi Spesialis Kekurangan Lk',
            'dokter_gigi_spesialis_kekurangan_pr' => 'Dokter Gigi Spesialis Kekurangan Pr',
            'dokter_doktergigimhamars_keadaan_lk' => 'Dokter Doktergigimhamars Keadaan Lk',
            'dokter_doktergigimhamars_keadaan_pr' => 'Dokter Doktergigimhamars Keadaan Pr',
            'dokter_doktergigimhamars_kebutuhan_lk' => 'Dokter Doktergigimhamars Kebutuhan Lk',
            'dokter_doktergigimhamars_kebutuhan_pr' => 'Dokter Doktergigimhamars Kebutuhan Pr',
            'dokter_doktergigimhamars_kekurangan_lk' => 'Dokter Doktergigimhamars Kekurangan Lk',
            'dokter_doktergigimhamars_kekurangan_pr' => 'Dokter Doktergigimhamars Kekurangan Pr',
            'dokter_doktergigis2s3kesehatanmasyarakat_keadaan_lk' => 'Dokter Doktergigis 2s 3kesehatanmasyarakat Keadaan Lk',
            'dokter_doktergigis2s3kesehatanmasyarakat_keadaan_pr' => 'Dokter Doktergigis 2s 3kesehatanmasyarakat Keadaan Pr',
            'dokter_doktergigis2s3kesehatanmasyarakat_kebutuhan_lk' => 'Dokter Doktergigis 2s 3kesehatanmasyarakat Kebutuhan Lk',
            'dokter_doktergigis2s3kesehatanmasyarakat_kebutuhan_pr' => 'Dokter Doktergigis 2s 3kesehatanmasyarakat Kebutuhan Pr',
            'dokter_doktergigis2s3kesehatanmasyarakat_kekurangan_lk' => 'Dokter Doktergigis 2s 3kesehatanmasyarakat Kekurangan Lk',
            'dokter_doktergigis2s3kesehatanmasyarakat_kekurangan_pr' => 'Dokter Doktergigis 2s 3kesehatanmasyarakat Kekurangan Pr',
            's3_dokterkonsultan_keadaan_lk' => 'S 3 Dokterkonsultan Keadaan Lk',
            's3_dokterkonsultan_keadaan_pr' => 'S 3 Dokterkonsultan Keadaan Pr',
            's3_dokterkonsultan_kebutuhan_lk' => 'S 3 Dokterkonsultan Kebutuhan Lk',
            's3_dokterkonsultan_kebutuhan_pr' => 'S 3 Dokterkonsultan Kebutuhan Pr',
            's3_dokterkonsultan_kekurangan_lk' => 'S 3 Dokterkonsultan Kekurangan Lk',
            's3_dokterkonsultan_kekurangan_pr' => 'S 3 Dokterkonsultan Kekurangan Pr',
            's3_keperawatan_keadaan_lk' => 'S 3 Keperawatan Keadaan Lk',
            's3_keperawatan_keadaan_pr' => 'S 3 Keperawatan Keadaan Pr',
            's3_keperawatan_kebutuhan_lk' => 'S 3 Keperawatan Kebutuhan Lk',
            's3_keperawatan_kebutuhan_pr' => 'S 3 Keperawatan Kebutuhan Pr',
            's3_keperawatan_kekurangan_lk' => 'S 3 Keperawatan Kekurangan Lk',
            's3_keperawatan_kekurangan_pr' => 'S 3 Keperawatan Kekurangan Pr',
            's2_keperawatan_keadaan_lk' => 'S 2 Keperawatan Keadaan Lk',
            's2_keperawatan_keadaan_pr' => 'S 2 Keperawatan Keadaan Pr',
            's2_keperawatan_kebutuhan_lk' => 'S 2 Keperawatan Kebutuhan Lk',
            's2_keperawatan_kebutuhan_pr' => 'S 2 Keperawatan Kebutuhan Pr',
            's2_keperawatan_kekurangan_lk' => 'S 2 Keperawatan Kekurangan Lk',
            's2_keperawatan_kekurangan_pr' => 'S 2 Keperawatan Kekurangan Pr',
            's1_keperawatan_keadaan_lk' => 'S 1 Keperawatan Keadaan Lk',
            's1_keperawatan_keadaan_pr' => 'S 1 Keperawatan Keadaan Pr',
            's1_keperawatan_kebutuhan_lk' => 'S 1 Keperawatan Kebutuhan Lk',
            's1_keperawatan_kebutuhan_pr' => 'S 1 Keperawatan Kebutuhan Pr',
            's1_keperawatan_kekurangan_lk' => 'S 1 Keperawatan Kekurangan Lk',
            's1_keperawatan_kekurangan_pr' => 'S 1 Keperawatan Kekurangan Pr',
            'd4_keperawatan_keadaan_lk' => 'D 4 Keperawatan Keadaan Lk',
            'd4_keperawatan_keadaan_pr' => 'D 4 Keperawatan Keadaan Pr',
            'd4_keperawatan_kebutuhan_lk' => 'D 4 Keperawatan Kebutuhan Lk',
            'd4_keperawatan_kebutuhan_pr' => 'D 4 Keperawatan Kebutuhan Pr',
            'd4_keperawatan_kekurangan_lk' => 'D 4 Keperawatan Kekurangan Lk',
            'd4_keperawatan_kekurangan_pr' => 'D 4 Keperawatan Kekurangan Pr',
            'perawat_vokasional_keadaan_lk' => 'Perawat Vokasional Keadaan Lk',
            'perawat_vokasional_keadaan_pr' => 'Perawat Vokasional Keadaan Pr',
            'perawat_vokasional_kebutuhan_lk' => 'Perawat Vokasional Kebutuhan Lk',
            'perawat_vokasional_kebutuhan_pr' => 'Perawat Vokasional Kebutuhan Pr',
            'perawat_vokasional_kekurangan_lk' => 'Perawat Vokasional Kekurangan Lk',
            'perawat_vokasional_kekurangan_pr' => 'Perawat Vokasional Kekurangan Pr',
            'perawat_spesialis_keadaan_lk' => 'Perawat Spesialis Keadaan Lk',
            'perawat_spesialis_keadaan_pr' => 'Perawat Spesialis Keadaan Pr',
            'perawat_spesialis_kebutuhan_lk' => 'Perawat Spesialis Kebutuhan Lk',
            'perawat_spesialis_kebutuhan_pr' => 'Perawat Spesialis Kebutuhan Pr',
            'perawat_spesialis_kekurangan_lk' => 'Perawat Spesialis Kekurangan Lk',
            'perawat_spesialis_kekurangan_pr' => 'Perawat Spesialis Kekurangan Pr',
            'pembantu_keperawatan_keadaan_lk' => 'Pembantu Keperawatan Keadaan Lk',
            'pembantu_keperawatan_keadaan_pr' => 'Pembantu Keperawatan Keadaan Pr',
            'pembantu_keperawatan_kebutuhan_lk' => 'Pembantu Keperawatan Kebutuhan Lk',
            'pembantu_keperawatan_kebutuhan_pr' => 'Pembantu Keperawatan Kebutuhan Pr',
            'pembantu_keperawatan_kekurangan_lk' => 'Pembantu Keperawatan Kekurangan Lk',
            'pembantu_keperawatan_kekurangan_pr' => 'Pembantu Keperawatan Kekurangan Pr',
            's3_kebidanan_keadaan_lk' => 'S 3 Kebidanan Keadaan Lk',
            's3_kebidanan_keadaan_pr' => 'S 3 Kebidanan Keadaan Pr',
            's3_kebidanan_kebutuhan_lk' => 'S 3 Kebidanan Kebutuhan Lk',
            's3_kebidanan_kebutuhan_pr' => 'S 3 Kebidanan Kebutuhan Pr',
            's3_kebidanan_kekurangan_lk' => 'S 3 Kebidanan Kekurangan Lk',
            's3_kebidanan_kekurangan_pr' => 'S 3 Kebidanan Kekurangan Pr',
            's2_kebidanan_keadaan_lk' => 'S 2 Kebidanan Keadaan Lk',
            's2_kebidanan_keadaan_pr' => 'S 2 Kebidanan Keadaan Pr',
            's2_kebidanan_kebutuhan_lk' => 'S 2 Kebidanan Kebutuhan Lk',
            's2_kebidanan_kebutuhan_pr' => 'S 2 Kebidanan Kebutuhan Pr',
            's2_kebidanan_kekurangan_lk' => 'S 2 Kebidanan Kekurangan Lk',
            's2_kebidanan_kekurangan_pr' => 'S 2 Kebidanan Kekurangan Pr',
            's1_kebidanan_keadaan_lk' => 'S 1 Kebidanan Keadaan Lk',
            's1_kebidanan_keadaan_pr' => 'S 1 Kebidanan Keadaan Pr',
            's1_kebidanan_kebutuhan_lk' => 'S 1 Kebidanan Kebutuhan Lk',
            's1_kebidanan_kebutuhan_pr' => 'S 1 Kebidanan Kebutuhan Pr',
            's1_kebidanan_kekurangan_lk' => 'S 1 Kebidanan Kekurangan Lk',
            's1_kebidanan_kekurangan_pr' => 'S 1 Kebidanan Kekurangan Pr',
            'd3_kebidanan_keadaan_lk' => 'D 3 Kebidanan Keadaan Lk',
            'd3_kebidanan_keadaan_pr' => 'D 3 Kebidanan Keadaan Pr',
            'd3_kebidanan_kebutuhan_lk' => 'D 3 Kebidanan Kebutuhan Lk',
            'd3_kebidanan_kebutuhan_pr' => 'D 3 Kebidanan Kebutuhan Pr',
            'd3_kebidanan_kekurangan_lk' => 'D 3 Kebidanan Kekurangan Lk',
            'd3_kebidanan_kekurangan_pr' => 'D 3 Kebidanan Kekurangan Pr',
            'tenaga_keperawatanlainnya_keadaan_lk' => 'Tenaga Keperawatanlainnya Keadaan Lk',
            'tenaga_keperawatanlainnya_keadaan_pr' => 'Tenaga Keperawatanlainnya Keadaan Pr',
            'tenaga_keperawatanlainnya_kebutuhan_lk' => 'Tenaga Keperawatanlainnya Kebutuhan Lk',
            'tenaga_keperawatanlainnya_kebutuhan_pr' => 'Tenaga Keperawatanlainnya Kebutuhan Pr',
            'tenaga_keperawatanlainnya_kekurangan_lk' => 'Tenaga Keperawatanlainnya Kekurangan Lk',
            'tenaga_keperawatanlainnya_kekurangan_pr' => 'Tenaga Keperawatanlainnya Kekurangan Pr',
            's3_farmasiapoteker_keadaan_lk' => 'S 3 Farmasiapoteker Keadaan Lk',
            's3_farmasiapoteker_keadaan_pr' => 'S 3 Farmasiapoteker Keadaan Pr',
            's3_farmasiapoteker_kebutuhan_lk' => 'S 3 Farmasiapoteker Kebutuhan Lk',
            's3_farmasiapoteker_kebutuhan_pr' => 'S 3 Farmasiapoteker Kebutuhan Pr',
            's3_farmasiapoteker_kekurangan_lk' => 'S 3 Farmasiapoteker Kekurangan Lk',
            's3_farmasiapoteker_kekurangan_pr' => 'S 3 Farmasiapoteker Kekurangan Pr',
            's2_farmasiapoteker_keadaan_lk' => 'S 2 Farmasiapoteker Keadaan Lk',
            's2_farmasiapoteker_keadaan_pr' => 'S 2 Farmasiapoteker Keadaan Pr',
            's2_farmasiapoteker_kebutuhan_lk' => 'S 2 Farmasiapoteker Kebutuhan Lk',
            's2_farmasiapoteker_kebutuhan_pr' => 'S 2 Farmasiapoteker Kebutuhan Pr',
            's2_farmasiapoteker_kekurangan_lk' => 'S 2 Farmasiapoteker Kekurangan Lk',
            's2_farmasiapoteker_kekurangan_pr' => 'S 2 Farmasiapoteker Kekurangan Pr',
            'apoteker_keadaan_lk' => 'Apoteker Keadaan Lk',
            'apoteker_keadaan_pr' => 'Apoteker Keadaan Pr',
            'apoteker_kebutuhan_lk' => 'Apoteker Kebutuhan Lk',
            'apoteker_kebutuhan_pr' => 'Apoteker Kebutuhan Pr',
            'apoteker_kekurangan_lk' => 'Apoteker Kekurangan Lk',
            'apoteker_kekurangan_pr' => 'Apoteker Kekurangan Pr',
            's3_farmasifarmakologikimia_keadaan_lk' => 'S 3 Farmasifarmakologikimia Keadaan Lk',
            's3_farmasifarmakologikimia_keadaan_pr' => 'S 3 Farmasifarmakologikimia Keadaan Pr',
            's3_farmasifarmakologikimia_kebutuhan_lk' => 'S 3 Farmasifarmakologikimia Kebutuhan Lk',
            's3_farmasifarmakologikimia_kebutuhan_pr' => 'S 3 Farmasifarmakologikimia Kebutuhan Pr',
            's3_farmasifarmakologikimia_kekurangan_lk' => 'S 3 Farmasifarmakologikimia Kekurangan Lk',
            's3_farmasifarmakologikimia_kekurangan_pr' => 'S 3 Farmasifarmakologikimia Kekurangan Pr',
            's1_farmasiapoteker_keadaan_lk' => 'S 1 Farmasiapoteker Keadaan Lk',
            's1_farmasiapoteker_keadaan_pr' => 'S 1 Farmasiapoteker Keadaan Pr',
            's1_farmasiapoteker_kebutuhan_lk' => 'S 1 Farmasiapoteker Kebutuhan Lk',
            's1_farmasiapoteker_kebutuhan_pr' => 'S 1 Farmasiapoteker Kebutuhan Pr',
            's1_farmasiapoteker_kekurangan_lk' => 'S 1 Farmasiapoteker Kekurangan Lk',
            's1_farmasiapoteker_kekurangan_pr' => 'S 1 Farmasiapoteker Kekurangan Pr',
            'akafarma_keadaan_lk' => 'Akafarma Keadaan Lk',
            'akafarma_keadaan_pr' => 'Akafarma Keadaan Pr',
            'akafarma_kebutuhan_lk' => 'Akafarma Kebutuhan Lk',
            'akafarma_kebutuhan_pr' => 'Akafarma Kebutuhan Pr',
            'akafarma_kekurangan_lk' => 'Akafarma Kekurangan Lk',
            'akafarma_kekurangan_pr' => 'Akafarma Kekurangan Pr',
            'akfar_keadaan_lk' => 'Akfar Keadaan Lk',
            'akfar_keadaan_pr' => 'Akfar Keadaan Pr',
            'akfar_kebutuhan_lk' => 'Akfar Kebutuhan Lk',
            'akfar_kebutuhan_pr' => 'Akfar Kebutuhan Pr',
            'akfar_kekurangan_lk' => 'Akfar Kekurangan Lk',
            'akfar_kekurangan_pr' => 'Akfar Kekurangan Pr',
            'analis_farmasi_keadaan_lk' => 'Analis Farmasi Keadaan Lk',
            'analis_farmasi_keadaan_pr' => 'Analis Farmasi Keadaan Pr',
            'analis_farmasi_kebutuhan_lk' => 'Analis Farmasi Kebutuhan Lk',
            'analis_farmasi_kebutuhan_pr' => 'Analis Farmasi Kebutuhan Pr',
            'analis_farmasi_kekurangan_lk' => 'Analis Farmasi Kekurangan Lk',
            'analis_farmasi_kekurangan_pr' => 'Analis Farmasi Kekurangan Pr',
            'asisten_apoteker_keadaan_lk' => 'Asisten Apoteker Keadaan Lk',
            'asisten_apoteker_keadaan_pr' => 'Asisten Apoteker Keadaan Pr',
            'asisten_apoteker_kebutuhan_lk' => 'Asisten Apoteker Kebutuhan Lk',
            'asisten_apoteker_kebutuhan_pr' => 'Asisten Apoteker Kebutuhan Pr',
            'asisten_apoteker_kekurangan_lk' => 'Asisten Apoteker Kekurangan Lk',
            'asisten_apoteker_kekurangan_pr' => 'Asisten Apoteker Kekurangan Pr',
            's1_farmasiapotekersmf_keadaan_lk' => 'S 1 Farmasiapotekersmf Keadaan Lk',
            's1_farmasiapotekersmf_keadaan_pr' => 'S 1 Farmasiapotekersmf Keadaan Pr',
            's1_farmasiapotekersmf_kebutuhan_lk' => 'S 1 Farmasiapotekersmf Kebutuhan Lk',
            's1_farmasiapotekersmf_kebutuhan_pr' => 'S 1 Farmasiapotekersmf Kebutuhan Pr',
            's1_farmasiapotekersmf_kekurangan_lk' => 'S 1 Farmasiapotekersmf Kekurangan Lk',
            's1_farmasiapotekersmf_kekurangan_pr' => 'S 1 Farmasiapotekersmf Kekurangan Pr',
            'st_lab_kimia_farmasi_keadaan_lk' => 'St Lab Kimia Farmasi Keadaan Lk',
            'st_lab_kimia_farmasi_keadaan_pr' => 'St Lab Kimia Farmasi Keadaan Pr',
            'st_lab_kimia_farmasi_kebutuhan_lk' => 'St Lab Kimia Farmasi Kebutuhan Lk',
            'st_lab_kimia_farmasi_kebutuhan_pr' => 'St Lab Kimia Farmasi Kebutuhan Pr',
            'st_lab_kimia_farmasi_kekurangan_lk' => 'St Lab Kimia Farmasi Kekurangan Lk',
            'st_lab_kimia_farmasi_kekurangan_pr' => 'St Lab Kimia Farmasi Kekurangan Pr',
            'tenaga_kefarmasianlainnya_keadaan_lk' => 'Tenaga Kefarmasianlainnya Keadaan Lk',
            'tenaga_kefarmasianlainnya_keadaan_pr' => 'Tenaga Kefarmasianlainnya Keadaan Pr',
            'tenaga_kefarmasianlainnya_kebutuhan_lk' => 'Tenaga Kefarmasianlainnya Kebutuhan Lk',
            'tenaga_kefarmasianlainnya_kebutuhan_pr' => 'Tenaga Kefarmasianlainnya Kebutuhan Pr',
            'tenaga_kefarmasianlainnya_kekurangan_lk' => 'Tenaga Kefarmasianlainnya Kekurangan Lk',
            'tenaga_kefarmasianlainnya_kekurangan_pr' => 'Tenaga Kefarmasianlainnya Kekurangan Pr',
            's3_kesehatan_masyarakatan_keadaan_lk' => 'S 3 Kesehatan Masyarakatan Keadaan Lk',
            's3_kesehatan_masyarakatan_keadaan_pr' => 'S 3 Kesehatan Masyarakatan Keadaan Pr',
            's3_kesehatan_masyarakatan_kebutuhan_lk' => 'S 3 Kesehatan Masyarakatan Kebutuhan Lk',
            's3_kesehatan_masyarakatan_kebutuhan_pr' => 'S 3 Kesehatan Masyarakatan Kebutuhan Pr',
            's3_kesehatan_masyarakatan_kekurangan_lk' => 'S 3 Kesehatan Masyarakatan Kekurangan Lk',
            's3_kesehatan_masyarakatan_kekurangan_pr' => 'S 3 Kesehatan Masyarakatan Kekurangan Pr',
            's3_epidemologi_keadaan_lk' => 'S 3 Epidemologi Keadaan Lk',
            's3_epidemologi_keadaan_pr' => 'S 3 Epidemologi Keadaan Pr',
            's3_epidemologi_kebutuhan_lk' => 'S 3 Epidemologi Kebutuhan Lk',
            's3_epidemologi_kebutuhan_pr' => 'S 3 Epidemologi Kebutuhan Pr',
            's3_epidemologi_kekurangan_lk' => 'S 3 Epidemologi Kekurangan Lk',
            's3_epidemologi_kekurangan_pr' => 'S 3 Epidemologi Kekurangan Pr',
            's3_psikologi_keadaan_lk' => 'S 3 Psikologi Keadaan Lk',
            's3_psikologi_keadaan_pr' => 'S 3 Psikologi Keadaan Pr',
            's3_psikologi_kebutuhan_lk' => 'S 3 Psikologi Kebutuhan Lk',
            's3_psikologi_kebutuhan_pr' => 'S 3 Psikologi Kebutuhan Pr',
            's3_psikologi_kekurangan_lk' => 'S 3 Psikologi Kekurangan Lk',
            's3_psikologi_kekurangan_pr' => 'S 3 Psikologi Kekurangan Pr',
            's2_kesehatan_masyarakatan_keadaan_lk' => 'S 2 Kesehatan Masyarakatan Keadaan Lk',
            's2_kesehatan_masyarakatan_keadaan_pr' => 'S 2 Kesehatan Masyarakatan Keadaan Pr',
            's2_kesehatan_masyarakatan_kebutuhan_lk' => 'S 2 Kesehatan Masyarakatan Kebutuhan Lk',
            's2_kesehatan_masyarakatan_kebutuhan_pr' => 'S 2 Kesehatan Masyarakatan Kebutuhan Pr',
            's2_kesehatan_masyarakatan_kekurangan_lk' => 'S 2 Kesehatan Masyarakatan Kekurangan Lk',
            's2_kesehatan_masyarakatan_kekurangan_pr' => 'S 2 Kesehatan Masyarakatan Kekurangan Pr',
            's2_epidemologi_keadaan_lk' => 'S 2 Epidemologi Keadaan Lk',
            's2_epidemologi_keadaan_pr' => 'S 2 Epidemologi Keadaan Pr',
            's2_epidemologi_kebutuhan_lk' => 'S 2 Epidemologi Kebutuhan Lk',
            's2_epidemologi_kebutuhan_pr' => 'S 2 Epidemologi Kebutuhan Pr',
            's2_epidemologi_kekurangan_lk' => 'S 2 Epidemologi Kekurangan Lk',
            's2_epidemologi_kekurangan_pr' => 'S 2 Epidemologi Kekurangan Pr',
            's2_biomedik_keadaan_lk' => 'S 2 Biomedik Keadaan Lk',
            's2_biomedik_keadaan_pr' => 'S 2 Biomedik Keadaan Pr',
            's2_biomedik_kebutuhan_lk' => 'S 2 Biomedik Kebutuhan Lk',
            's2_biomedik_kebutuhan_pr' => 'S 2 Biomedik Kebutuhan Pr',
            's2_biomedik_kekurangan_lk' => 'S 2 Biomedik Kekurangan Lk',
            's2_biomedik_kekurangan_pr' => 'S 2 Biomedik Kekurangan Pr',
            's2_psikologi_keadaan_lk' => 'S 2 Psikologi Keadaan Lk',
            's2_psikologi_keadaan_pr' => 'S 2 Psikologi Keadaan Pr',
            's2_psikologi_kebutuhan_lk' => 'S 2 Psikologi Kebutuhan Lk',
            's2_psikologi_kebutuhan_pr' => 'S 2 Psikologi Kebutuhan Pr',
            's2_psikologi_kekurangan_lk' => 'S 2 Psikologi Kekurangan Lk',
            's2_psikologi_kekurangan_pr' => 'S 2 Psikologi Kekurangan Pr',
            's1_kesehatan_masyarakat_keadaan_lk' => 'S 1 Kesehatan Masyarakat Keadaan Lk',
            's1_kesehatan_masyarakat_keadaan_pr' => 'S 1 Kesehatan Masyarakat Keadaan Pr',
            's1_kesehatan_masyarakat_kebutuhan_lk' => 'S 1 Kesehatan Masyarakat Kebutuhan Lk',
            's1_kesehatan_masyarakat_kebutuhan_pr' => 'S 1 Kesehatan Masyarakat Kebutuhan Pr',
            's1_kesehatan_masyarakat_kekurangan_lk' => 'S 1 Kesehatan Masyarakat Kekurangan Lk',
            's1_kesehatan_masyarakat_kekurangan_pr' => 'S 1 Kesehatan Masyarakat Kekurangan Pr',
            's1_psikologi_keadaan_lk' => 'S 1 Psikologi Keadaan Lk',
            's1_psikologi_keadaan_pr' => 'S 1 Psikologi Keadaan Pr',
            's1_psikologi_kebutuhan_lk' => 'S 1 Psikologi Kebutuhan Lk',
            's1_psikologi_kebutuhan_pr' => 'S 1 Psikologi Kebutuhan Pr',
            's1_psikologi_kekurangan_lk' => 'S 1 Psikologi Kekurangan Lk',
            's1_psikologi_kekurangan_pr' => 'S 1 Psikologi Kekurangan Pr',
            'd3_kesehatan_masyarakat_keadaan_lk' => 'D 3 Kesehatan Masyarakat Keadaan Lk',
            'd3_kesehatan_masyarakat_keadaan_pr' => 'D 3 Kesehatan Masyarakat Keadaan Pr',
            'd3_kesehatan_masyarakat_kebutuhan_lk' => 'D 3 Kesehatan Masyarakat Kebutuhan Lk',
            'd3_kesehatan_masyarakat_kebutuhan_pr' => 'D 3 Kesehatan Masyarakat Kebutuhan Pr',
            'd3_kesehatan_masyarakat_kekurangan_lk' => 'D 3 Kesehatan Masyarakat Kekurangan Lk',
            'd3_kesehatan_masyarakat_kekurangan_pr' => 'D 3 Kesehatan Masyarakat Kekurangan Pr',
            'd3_sanitarian_keadaan_lk' => 'D 3 Sanitarian Keadaan Lk',
            'd3_sanitarian_keadaan_pr' => 'D 3 Sanitarian Keadaan Pr',
            'd3_sanitarian_kebutuhan_lk' => 'D 3 Sanitarian Kebutuhan Lk',
            'd3_sanitarian_kebutuhan_pr' => 'D 3 Sanitarian Kebutuhan Pr',
            'd3_sanitarian_kekurangan_lk' => 'D 3 Sanitarian Kekurangan Lk',
            'd3_sanitarian_kekurangan_pr' => 'D 3 Sanitarian Kekurangan Pr',
            'tenaga_kesehatan_masyarakatlainnya_keadaan_lk' => 'Tenaga Kesehatan Masyarakatlainnya Keadaan Lk',
            'tenaga_kesehatan_masyarakatlainnya_keadaan_pr' => 'Tenaga Kesehatan Masyarakatlainnya Keadaan Pr',
            'tenaga_kesehatan_masyarakatlainnya_kebutuhan_lk' => 'Tenaga Kesehatan Masyarakatlainnya Kebutuhan Lk',
            'tenaga_kesehatan_masyarakatlainnya_kebutuhan_pr' => 'Tenaga Kesehatan Masyarakatlainnya Kebutuhan Pr',
            'tenaga_kesehatan_masyarakatlainnya_kekurangan_lk' => 'Tenaga Kesehatan Masyarakatlainnya Kekurangan Lk',
            'tenaga_kesehatan_masyarakatlainnya_kekurangan_pr' => 'Tenaga Kesehatan Masyarakatlainnya Kekurangan Pr',
            's3_gizi_dietisien_keadaan_lk' => 'S 3 Gizi Dietisien Keadaan Lk',
            's3_gizi_dietisien_keadaan_pr' => 'S 3 Gizi Dietisien Keadaan Pr',
            's3_gizi_dietisien_kebutuhan_lk' => 'S 3 Gizi Dietisien Kebutuhan Lk',
            's3_gizi_dietisien_kebutuhan_pr' => 'S 3 Gizi Dietisien Kebutuhan Pr',
            's3_gizi_dietisien_kekurangan_lk' => 'S 3 Gizi Dietisien Kekurangan Lk',
            's3_gizi_dietisien_kekurangan_pr' => 'S 3 Gizi Dietisien Kekurangan Pr',
            's2_gizi_dietisien_keadaan_lk' => 'S 2 Gizi Dietisien Keadaan Lk',
            's2_gizi_dietisien_keadaan_pr' => 'S 2 Gizi Dietisien Keadaan Pr',
            's2_gizi_dietisien_kebutuhan_lk' => 'S 2 Gizi Dietisien Kebutuhan Lk',
            's2_gizi_dietisien_kebutuhan_pr' => 'S 2 Gizi Dietisien Kebutuhan Pr',
            's2_gizi_dietisien_kekurangan_lk' => 'S 2 Gizi Dietisien Kekurangan Lk',
            's2_gizi_dietisien_kekurangan_pr' => 'S 2 Gizi Dietisien Kekurangan Pr',
            's1_gizi_dietisien_keadaan_lk' => 'S 1 Gizi Dietisien Keadaan Lk',
            's1_gizi_dietisien_keadaan_pr' => 'S 1 Gizi Dietisien Keadaan Pr',
            's1_gizi_dietisien_kebutuhan_lk' => 'S 1 Gizi Dietisien Kebutuhan Lk',
            's1_gizi_dietisien_kebutuhan_pr' => 'S 1 Gizi Dietisien Kebutuhan Pr',
            's1_gizi_dietisien_kekurangan_lk' => 'S 1 Gizi Dietisien Kekurangan Lk',
            's1_gizi_dietisien_kekurangan_pr' => 'S 1 Gizi Dietisien Kekurangan Pr',
            'd4_gizi_dietisien_keadaan_lk' => 'D 4 Gizi Dietisien Keadaan Lk',
            'd4_gizi_dietisien_keadaan_pr' => 'D 4 Gizi Dietisien Keadaan Pr',
            'd4_gizi_dietisien_kebutuhan_lk' => 'D 4 Gizi Dietisien Kebutuhan Lk',
            'd4_gizi_dietisien_kebutuhan_pr' => 'D 4 Gizi Dietisien Kebutuhan Pr',
            'd4_gizi_dietisien_kekurangan_lk' => 'D 4 Gizi Dietisien Kekurangan Lk',
            'd4_gizi_dietisien_kekurangan_pr' => 'D 4 Gizi Dietisien Kekurangan Pr',
            'd3_gizi_dietisien_keadaan_lk' => 'D 3 Gizi Dietisien Keadaan Lk',
            'd3_gizi_dietisien_keadaan_pr' => 'D 3 Gizi Dietisien Keadaan Pr',
            'd3_gizi_dietisien_kebutuhan_lk' => 'D 3 Gizi Dietisien Kebutuhan Lk',
            'd3_gizi_dietisien_kebutuhan_pr' => 'D 3 Gizi Dietisien Kebutuhan Pr',
            'd3_gizi_dietisien_kekurangan_lk' => 'D 3 Gizi Dietisien Kekurangan Lk',
            'd3_gizi_dietisien_kekurangan_pr' => 'D 3 Gizi Dietisien Kekurangan Pr',
            'd1_gizi_dietisien_keadaan_lk' => 'D 1 Gizi Dietisien Keadaan Lk',
            'd1_gizi_dietisien_keadaan_pr' => 'D 1 Gizi Dietisien Keadaan Pr',
            'd1_gizi_dietisien_kebutuhan_lk' => 'D 1 Gizi Dietisien Kebutuhan Lk',
            'd1_gizi_dietisien_kebutuhan_pr' => 'D 1 Gizi Dietisien Kebutuhan Pr',
            'd1_gizi_dietisien_kekurangan_lk' => 'D 1 Gizi Dietisien Kekurangan Lk',
            'd1_gizi_dietisien_kekurangan_pr' => 'D 1 Gizi Dietisien Kekurangan Pr',
            'tenaga_gizilainnya_keadaan_lk' => 'Tenaga Gizilainnya Keadaan Lk',
            'tenaga_gizilainnya_keadaan_pr' => 'Tenaga Gizilainnya Keadaan Pr',
            'tenaga_gizilainnya_kebutuhan_lk' => 'Tenaga Gizilainnya Kebutuhan Lk',
            'tenaga_gizilainnya_kebutuhan_pr' => 'Tenaga Gizilainnya Kebutuhan Pr',
            'tenaga_gizilainnya_kekurangan_lk' => 'Tenaga Gizilainnya Kekurangan Lk',
            'tenaga_gizilainnya_kekurangan_pr' => 'Tenaga Gizilainnya Kekurangan Pr',
            's1_fisioterapis_keadaan_lk' => 'S 1 Fisioterapis Keadaan Lk',
            's1_fisioterapis_keadaan_pr' => 'S 1 Fisioterapis Keadaan Pr',
            's1_fisioterapis_kebutuhan_lk' => 'S 1 Fisioterapis Kebutuhan Lk',
            's1_fisioterapis_kebutuhan_pr' => 'S 1 Fisioterapis Kebutuhan Pr',
            's1_fisioterapis_kekurangan_lk' => 'S 1 Fisioterapis Kekurangan Lk',
            's1_fisioterapis_kekurangan_pr' => 'S 1 Fisioterapis Kekurangan Pr',
            'd3_fisioterapis_keadaan_lk' => 'D 3 Fisioterapis Keadaan Lk',
            'd3_fisioterapis_keadaan_pr' => 'D 3 Fisioterapis Keadaan Pr',
            'd3_fisioterapis_kebutuhan_lk' => 'D 3 Fisioterapis Kebutuhan Lk',
            'd3_fisioterapis_kebutuhan_pr' => 'D 3 Fisioterapis Kebutuhan Pr',
            'd3_fisioterapis_kekurangan_lk' => 'D 3 Fisioterapis Kekurangan Lk',
            'd3_fisioterapis_kekurangan_pr' => 'D 3 Fisioterapis Kekurangan Pr',
            'd3_okupasiterapis_keadaan_lk' => 'D 3 Okupasiterapis Keadaan Lk',
            'd3_okupasiterapis_keadaan_pr' => 'D 3 Okupasiterapis Keadaan Pr',
            'd3_okupasiterapis_kebutuhan_lk' => 'D 3 Okupasiterapis Kebutuhan Lk',
            'd3_okupasiterapis_kebutuhan_pr' => 'D 3 Okupasiterapis Kebutuhan Pr',
            'd3_okupasiterapis_kekurangan_lk' => 'D 3 Okupasiterapis Kekurangan Lk',
            'd3_okupasiterapis_kekurangan_pr' => 'D 3 Okupasiterapis Kekurangan Pr',
            'd3_terapiwicara_keadaan_lk' => 'D 3 Terapiwicara Keadaan Lk',
            'd3_terapiwicara_keadaan_pr' => 'D 3 Terapiwicara Keadaan Pr',
            'd3_terapiwicara_kebutuhan_lk' => 'D 3 Terapiwicara Kebutuhan Lk',
            'd3_terapiwicara_kebutuhan_pr' => 'D 3 Terapiwicara Kebutuhan Pr',
            'd3_terapiwicara_kekurangan_lk' => 'D 3 Terapiwicara Kekurangan Lk',
            'd3_terapiwicara_kekurangan_pr' => 'D 3 Terapiwicara Kekurangan Pr',
            'd3_orthopedi_keadaan_lk' => 'D 3 Orthopedi Keadaan Lk',
            'd3_orthopedi_keadaan_pr' => 'D 3 Orthopedi Keadaan Pr',
            'd3_orthopedi_kebutuhan_lk' => 'D 3 Orthopedi Kebutuhan Lk',
            'd3_orthopedi_kebutuhan_pr' => 'D 3 Orthopedi Kebutuhan Pr',
            'd3_orthopedi_kekurangan_lk' => 'D 3 Orthopedi Kekurangan Lk',
            'd3_orthopedi_kekurangan_pr' => 'D 3 Orthopedi Kekurangan Pr',
            'd3_akupuntur_keadaan_lk' => 'D 3 Akupuntur Keadaan Lk',
            'd3_akupuntur_keadaan_pr' => 'D 3 Akupuntur Keadaan Pr',
            'd3_akupuntur_kebutuhan_lk' => 'D 3 Akupuntur Kebutuhan Lk',
            'd3_akupuntur_kebutuhan_pr' => 'D 3 Akupuntur Kebutuhan Pr',
            'd3_akupuntur_kekurangan_lk' => 'D 3 Akupuntur Kekurangan Lk',
            'd3_akupuntur_kekurangan_pr' => 'D 3 Akupuntur Kekurangan Pr',
            'tenaga_keterapianfisiklainnya_keadaan_lk' => 'Tenaga Keterapianfisiklainnya Keadaan Lk',
            'tenaga_keterapianfisiklainnya_keadaan_pr' => 'Tenaga Keterapianfisiklainnya Keadaan Pr',
            'tenaga_keterapianfisiklainnya_kebutuhan_lk' => 'Tenaga Keterapianfisiklainnya Kebutuhan Lk',
            'tenaga_keterapianfisiklainnya_kebutuhan_pr' => 'Tenaga Keterapianfisiklainnya Kebutuhan Pr',
            'tenaga_keterapianfisiklainnya_kekurangan_lk' => 'Tenaga Keterapianfisiklainnya Kekurangan Lk',
            'tenaga_keterapianfisiklainnya_kekurangan_pr' => 'Tenaga Keterapianfisiklainnya Kekurangan Pr',
            's3_optoelektronikaapllaser_keadaan_lk' => 'S 3 Optoelektronikaapllaser Keadaan Lk',
            's3_optoelektronikaapllaser_keadaan_pr' => 'S 3 Optoelektronikaapllaser Keadaan Pr',
            's3_optoelektronikaapllaser_kebutuhan_lk' => 'S 3 Optoelektronikaapllaser Kebutuhan Lk',
            's3_optoelektronikaapllaser_kebutuhan_pr' => 'S 3 Optoelektronikaapllaser Kebutuhan Pr',
            's3_optoelektronikaapllaser_kekurangan_lk' => 'S 3 Optoelektronikaapllaser Kekurangan Lk',
            's3_optoelektronikaapllaser_kekurangan_pr' => 'S 3 Optoelektronikaapllaser Kekurangan Pr',
            's2_optoelektronikaapllaser_keadaan_lk' => 'S 2 Optoelektronikaapllaser Keadaan Lk',
            's2_optoelektronikaapllaser_keadaan_pr' => 'S 2 Optoelektronikaapllaser Keadaan Pr',
            's2_optoelektronikaapllaser_kebutuhan_lk' => 'S 2 Optoelektronikaapllaser Kebutuhan Lk',
            's2_optoelektronikaapllaser_kebutuhan_pr' => 'S 2 Optoelektronikaapllaser Kebutuhan Pr',
            's2_optoelektronikaapllaser_kekurangan_lk' => 'S 2 Optoelektronikaapllaser Kekurangan Lk',
            's2_optoelektronikaapllaser_kekurangan_pr' => 'S 2 Optoelektronikaapllaser Kekurangan Pr',
            'radiografer_keadaan_lk' => 'Radiografer Keadaan Lk',
            'radiografer_keadaan_pr' => 'Radiografer Keadaan Pr',
            'radiografer_kebutuhan_lk' => 'Radiografer Kebutuhan Lk',
            'radiografer_kebutuhan_pr' => 'Radiografer Kebutuhan Pr',
            'radiografer_kekurangan_lk' => 'Radiografer Kekurangan Lk',
            'radiografer_kekurangan_pr' => 'Radiografer Kekurangan Pr',
            'radioterapis_nondokter_keadaan_lk' => 'Radioterapis Nondokter Keadaan Lk',
            'radioterapis_nondokter_keadaan_pr' => 'Radioterapis Nondokter Keadaan Pr',
            'radioterapis_nondokter_kebutuhan_lk' => 'Radioterapis Nondokter Kebutuhan Lk',
            'radioterapis_nondokter_kebutuhan_pr' => 'Radioterapis Nondokter Kebutuhan Pr',
            'radioterapis_nondokter_kekurangan_lk' => 'Radioterapis Nondokter Kekurangan Lk',
            'radioterapis_nondokter_kekurangan_pr' => 'Radioterapis Nondokter Kekurangan Pr',
            'd4_fisikamedik_keadaan_lk' => 'D 4 Fisikamedik Keadaan Lk',
            'd4_fisikamedik_keadaan_pr' => 'D 4 Fisikamedik Keadaan Pr',
            'd4_fisikamedik_kebutuhan_lk' => 'D 4 Fisikamedik Kebutuhan Lk',
            'd4_fisikamedik_kebutuhan_pr' => 'D 4 Fisikamedik Kebutuhan Pr',
            'd4_fisikamedik_kekurangan_lk' => 'D 4 Fisikamedik Kekurangan Lk',
            'd4_fisikamedik_kekurangan_pr' => 'D 4 Fisikamedik Kekurangan Pr',
            'd3_teknikgigi_keadaan_lk' => 'D 3 Teknikgigi Keadaan Lk',
            'd3_teknikgigi_keadaan_pr' => 'D 3 Teknikgigi Keadaan Pr',
            'd3_teknikgigi_kebutuhan_lk' => 'D 3 Teknikgigi Kebutuhan Lk',
            'd3_teknikgigi_kebutuhan_pr' => 'D 3 Teknikgigi Kebutuhan Pr',
            'd3_teknikgigi_kekurangan_lk' => 'D 3 Teknikgigi Kekurangan Lk',
            'd3_teknikgigi_kekurangan_pr' => 'D 3 Teknikgigi Kekurangan Pr',
            'd3_teknikradiologiradioterapi_keadaan_lk' => 'D 3 Teknikradiologiradioterapi Keadaan Lk',
            'd3_teknikradiologiradioterapi_keadaan_pr' => 'D 3 Teknikradiologiradioterapi Keadaan Pr',
            'd3_teknikradiologiradioterapi_kebutuhan_lk' => 'D 3 Teknikradiologiradioterapi Kebutuhan Lk',
            'd3_teknikradiologiradioterapi_kebutuhan_pr' => 'D 3 Teknikradiologiradioterapi Kebutuhan Pr',
            'd3_teknikradiologiradioterapi_kekurangan_lk' => 'D 3 Teknikradiologiradioterapi Kekurangan Lk',
            'd3_teknikradiologiradioterapi_kekurangan_pr' => 'D 3 Teknikradiologiradioterapi Kekurangan Pr',
            'd3_refraksionisoptisien_keadaan_lk' => 'D 3 Refraksionisoptisien Keadaan Lk',
            'd3_refraksionisoptisien_keadaan_pr' => 'D 3 Refraksionisoptisien Keadaan Pr',
            'd3_refraksionisoptisien_kebutuhan_lk' => 'D 3 Refraksionisoptisien Kebutuhan Lk',
            'd3_refraksionisoptisien_kebutuhan_pr' => 'D 3 Refraksionisoptisien Kebutuhan Pr',
            'd3_refraksionisoptisien_kekurangan_lk' => 'D 3 Refraksionisoptisien Kekurangan Lk',
            'd3_refraksionisoptisien_kekurangan_pr' => 'D 3 Refraksionisoptisien Kekurangan Pr',
            'd3_perekammedis_keadaan_lk' => 'D 3 Perekammedis Keadaan Lk',
            'd3_perekammedis_keadaan_pr' => 'D 3 Perekammedis Keadaan Pr',
            'd3_perekammedis_kebutuhan_lk' => 'D 3 Perekammedis Kebutuhan Lk',
            'd3_perekammedis_kebutuhan_pr' => 'D 3 Perekammedis Kebutuhan Pr',
            'd3_perekammedis_kekurangan_lk' => 'D 3 Perekammedis Kekurangan Lk',
            'd3_perekammedis_kekurangan_pr' => 'D 3 Perekammedis Kekurangan Pr',
            'd3_teknikelektromedik_keadaan_lk' => 'D 3 Teknikelektromedik Keadaan Lk',
            'd3_teknikelektromedik_keadaan_pr' => 'D 3 Teknikelektromedik Keadaan Pr',
            'd3_teknikelektromedik_kebutuhan_lk' => 'D 3 Teknikelektromedik Kebutuhan Lk',
            'd3_teknikelektromedik_kebutuhan_pr' => 'D 3 Teknikelektromedik Kebutuhan Pr',
            'd3_teknikelektromedik_kekurangan_lk' => 'D 3 Teknikelektromedik Kekurangan Lk',
            'd3_teknikelektromedik_kekurangan_pr' => 'D 3 Teknikelektromedik Kekurangan Pr',
            'd3_analiskesehatan_keadaan_lk' => 'D 3 Analiskesehatan Keadaan Lk',
            'd3_analiskesehatan_keadaan_pr' => 'D 3 Analiskesehatan Keadaan Pr',
            'd3_analiskesehatan_kebutuhan_lk' => 'D 3 Analiskesehatan Kebutuhan Lk',
            'd3_analiskesehatan_kebutuhan_pr' => 'D 3 Analiskesehatan Kebutuhan Pr',
            'd3_analiskesehatan_kekurangan_lk' => 'D 3 Analiskesehatan Kekurangan Lk',
            'd3_analiskesehatan_kekurangan_pr' => 'D 3 Analiskesehatan Kekurangan Pr',
            'd3_informasikesehatan_keadaan_lk' => 'D 3 Informasikesehatan Keadaan Lk',
            'd3_informasikesehatan_keadaan_pr' => 'D 3 Informasikesehatan Keadaan Pr',
            'd3_informasikesehatan_kebutuhan_lk' => 'D 3 Informasikesehatan Kebutuhan Lk',
            'd3_informasikesehatan_kebutuhan_pr' => 'D 3 Informasikesehatan Kebutuhan Pr',
            'd3_informasikesehatan_kekurangan_lk' => 'D 3 Informasikesehatan Kekurangan Lk',
            'd3_informasikesehatan_kekurangan_pr' => 'D 3 Informasikesehatan Kekurangan Pr',
            'd3_kardiovaskular_keadaan_lk' => 'D 3 Kardiovaskular Keadaan Lk',
            'd3_kardiovaskular_keadaan_pr' => 'D 3 Kardiovaskular Keadaan Pr',
            'd3_kardiovaskular_kebutuhan_lk' => 'D 3 Kardiovaskular Kebutuhan Lk',
            'd3_kardiovaskular_kebutuhan_pr' => 'D 3 Kardiovaskular Kebutuhan Pr',
            'd3_kardiovaskular_kekurangan_lk' => 'D 3 Kardiovaskular Kekurangan Lk',
            'd3_kardiovaskular_kekurangan_pr' => 'D 3 Kardiovaskular Kekurangan Pr',
            'd3_orthotikprostetik_keadaan_lk' => 'D 3 Orthotikprostetik Keadaan Lk',
            'd3_orthotikprostetik_keadaan_pr' => 'D 3 Orthotikprostetik Keadaan Pr',
            'd3_orthotikprostetik_kebutuhan_lk' => 'D 3 Orthotikprostetik Kebutuhan Lk',
            'd3_orthotikprostetik_kebutuhan_pr' => 'D 3 Orthotikprostetik Kebutuhan Pr',
            'd3_orthotikprostetik_kekurangan_lk' => 'D 3 Orthotikprostetik Kekurangan Lk',
            'd3_orthotikprostetik_kekurangan_pr' => 'D 3 Orthotikprostetik Kekurangan Pr',
            'd1_tekniktranfusi_keadaan_lk' => 'D 1 Tekniktranfusi Keadaan Lk',
            'd1_tekniktranfusi_keadaan_pr' => 'D 1 Tekniktranfusi Keadaan Pr',
            'd1_tekniktranfusi_kebutuhan_lk' => 'D 1 Tekniktranfusi Kebutuhan Lk',
            'd1_tekniktranfusi_kebutuhan_pr' => 'D 1 Tekniktranfusi Kebutuhan Pr',
            'd1_tekniktranfusi_kekurangan_lk' => 'D 1 Tekniktranfusi Kekurangan Lk',
            'd1_tekniktranfusi_kekurangan_pr' => 'D 1 Tekniktranfusi Kekurangan Pr',
            'teknisi_gigi_keadaan_lk' => 'Teknisi Gigi Keadaan Lk',
            'teknisi_gigi_keadaan_pr' => 'Teknisi Gigi Keadaan Pr',
            'teknisi_gigi_kebutuhan_lk' => 'Teknisi Gigi Kebutuhan Lk',
            'teknisi_gigi_kebutuhan_pr' => 'Teknisi Gigi Kebutuhan Pr',
            'teknisi_gigi_kekurangan_lk' => 'Teknisi Gigi Kekurangan Lk',
            'teknisi_gigi_kekurangan_pr' => 'Teknisi Gigi Kekurangan Pr',
            'tenaga_itteknologinano_keadaan_lk' => 'Tenaga Itteknologinano Keadaan Lk',
            'tenaga_itteknologinano_keadaan_pr' => 'Tenaga Itteknologinano Keadaan Pr',
            'tenaga_itteknologinano_kebutuhan_lk' => 'Tenaga Itteknologinano Kebutuhan Lk',
            'tenaga_itteknologinano_kebutuhan_pr' => 'Tenaga Itteknologinano Kebutuhan Pr',
            'tenaga_itteknologinano_kekurangan_lk' => 'Tenaga Itteknologinano Kekurangan Lk',
            'tenaga_itteknologinano_kekurangan_pr' => 'Tenaga Itteknologinano Kekurangan Pr',
            'teknisi_patologianatomi_keadaan_lk' => 'Teknisi Patologianatomi Keadaan Lk',
            'teknisi_patologianatomi_keadaan_pr' => 'Teknisi Patologianatomi Keadaan Pr',
            'teknisi_patologianatomi_kebutuhan_lk' => 'Teknisi Patologianatomi Kebutuhan Lk',
            'teknisi_patologianatomi_kebutuhan_pr' => 'Teknisi Patologianatomi Kebutuhan Pr',
            'teknisi_patologianatomi_kekurangan_lk' => 'Teknisi Patologianatomi Kekurangan Lk',
            'teknisi_patologianatomi_kekurangan_pr' => 'Teknisi Patologianatomi Kekurangan Pr',
            'teknisi_kardiovaskular_keadaan_lk' => 'Teknisi Kardiovaskular Keadaan Lk',
            'teknisi_kardiovaskular_keadaan_pr' => 'Teknisi Kardiovaskular Keadaan Pr',
            'teknisi_kardiovaskular_kebutuhan_lk' => 'Teknisi Kardiovaskular Kebutuhan Lk',
            'teknisi_kardiovaskular_kebutuhan_pr' => 'Teknisi Kardiovaskular Kebutuhan Pr',
            'teknisi_kardiovaskular_kekurangan_lk' => 'Teknisi Kardiovaskular Kekurangan Lk',
            'teknisi_kardiovaskular_kekurangan_pr' => 'Teknisi Kardiovaskular Kekurangan Pr',
            'teknisi_elektromedis_keadaan_lk' => 'Teknisi Elektromedis Keadaan Lk',
            'teknisi_elektromedis_keadaan_pr' => 'Teknisi Elektromedis Keadaan Pr',
            'teknisi_elektromedis_kebutuhan_lk' => 'Teknisi Elektromedis Kebutuhan Lk',
            'teknisi_elektromedis_kebutuhan_pr' => 'Teknisi Elektromedis Kebutuhan Pr',
            'teknisi_elektromedis_kekurangan_lk' => 'Teknisi Elektromedis Kekurangan Lk',
            'teknisi_elektromedis_kekurangan_pr' => 'Teknisi Elektromedis Kekurangan Pr',
            'akupuntur_terapi_keadaan_lk' => 'Akupuntur Terapi Keadaan Lk',
            'akupuntur_terapi_keadaan_pr' => 'Akupuntur Terapi Keadaan Pr',
            'akupuntur_terapi_kebutuhan_lk' => 'Akupuntur Terapi Kebutuhan Lk',
            'akupuntur_terapi_kebutuhan_pr' => 'Akupuntur Terapi Kebutuhan Pr',
            'akupuntur_terapi_kekurangan_lk' => 'Akupuntur Terapi Kekurangan Lk',
            'akupuntur_terapi_kekurangan_pr' => 'Akupuntur Terapi Kekurangan Pr',
            'analis_kesehatan_keadaan_lk' => 'Analis Kesehatan Keadaan Lk',
            'analis_kesehatan_keadaan_pr' => 'Analis Kesehatan Keadaan Pr',
            'analis_kesehatan_kebutuhan_lk' => 'Analis Kesehatan Kebutuhan Lk',
            'analis_kesehatan_kebutuhan_pr' => 'Analis Kesehatan Kebutuhan Pr',
            'analis_kesehatan_kekurangan_lk' => 'Analis Kesehatan Kekurangan Lk',
            'analis_kesehatan_kekurangan_pr' => 'Analis Kesehatan Kekurangan Pr',
            'tenaga_keteknisianmedislainnya_keadaan_lk' => 'Tenaga Keteknisianmedislainnya Keadaan Lk',
            'tenaga_keteknisianmedislainnya_keadaan_pr' => 'Tenaga Keteknisianmedislainnya Keadaan Pr',
            'tenaga_keteknisianmedislainnya_kebutuhan_lk' => 'Tenaga Keteknisianmedislainnya Kebutuhan Lk',
            'tenaga_keteknisianmedislainnya_kebutuhan_pr' => 'Tenaga Keteknisianmedislainnya Kebutuhan Pr',
            'tenaga_keteknisianmedislainnya_kekurangan_lk' => 'Tenaga Keteknisianmedislainnya Kekurangan Lk',
            'tenaga_keteknisianmedislainnya_kekurangan_pr' => 'Tenaga Keteknisianmedislainnya Kekurangan Pr',
            's3_biologi_keadaan_lk' => 'S 3 Biologi Keadaan Lk',
            's3_biologi_keadaan_pr' => 'S 3 Biologi Keadaan Pr',
            's3_biologi_kebutuhan_lk' => 'S 3 Biologi Kebutuhan Lk',
            's3_biologi_kebutuhan_pr' => 'S 3 Biologi Kebutuhan Pr',
            's3_biologi_kekurangan_lk' => 'S 3 Biologi Kekurangan Lk',
            's3_biologi_kekurangan_pr' => 'S 3 Biologi Kekurangan Pr',
            's3_kimia_keadaan_lk' => 'S 3 Kimia Keadaan Lk',
            's3_kimia_keadaan_pr' => 'S 3 Kimia Keadaan Pr',
            's3_kimia_kebutuhan_lk' => 'S 3 Kimia Kebutuhan Lk',
            's3_kimia_kebutuhan_pr' => 'S 3 Kimia Kebutuhan Pr',
            's3_kimia_kekurangan_lk' => 'S 3 Kimia Kekurangan Lk',
            's3_kimia_kekurangan_pr' => 'S 3 Kimia Kekurangan Pr',
            's3_ekonomiakuntansi_keadaan_lk' => 'S 3 Ekonomiakuntansi Keadaan Lk',
            's3_ekonomiakuntansi_keadaan_pr' => 'S 3 Ekonomiakuntansi Keadaan Pr',
            's3_ekonomiakuntansi_kebutuhan_lk' => 'S 3 Ekonomiakuntansi Kebutuhan Lk',
            's3_ekonomiakuntansi_kebutuhan_pr' => 'S 3 Ekonomiakuntansi Kebutuhan Pr',
            's3_ekonomiakuntansi_kekurangan_lk' => 'S 3 Ekonomiakuntansi Kekurangan Lk',
            's3_ekonomiakuntansi_kekurangan_pr' => 'S 3 Ekonomiakuntansi Kekurangan Pr',
            's3_administrasi_keadaan_lk' => 'S 3 Administrasi Keadaan Lk',
            's3_administrasi_keadaan_pr' => 'S 3 Administrasi Keadaan Pr',
            's3_administrasi_kebutuhan_lk' => 'S 3 Administrasi Kebutuhan Lk',
            's3_administrasi_kebutuhan_pr' => 'S 3 Administrasi Kebutuhan Pr',
            's3_administrasi_kekurangan_lk' => 'S 3 Administrasi Kekurangan Lk',
            's3_administrasi_kekurangan_pr' => 'S 3 Administrasi Kekurangan Pr',
            's3_hukum_keadaan_lk' => 'S 3 Hukum Keadaan Lk',
            's3_hukum_keadaan_pr' => 'S 3 Hukum Keadaan Pr',
            's3_hukum_kebutuhan_lk' => 'S 3 Hukum Kebutuhan Lk',
            's3_hukum_kebutuhan_pr' => 'S 3 Hukum Kebutuhan Pr',
            's3_hukum_kekurangan_lk' => 'S 3 Hukum Kekurangan Lk',
            's3_hukum_kekurangan_pr' => 'S 3 Hukum Kekurangan Pr',
            's3_tehnik_keadaan_lk' => 'S 3 Tehnik Keadaan Lk',
            's3_tehnik_keadaan_pr' => 'S 3 Tehnik Keadaan Pr',
            's3_tehnik_kebutuhan_lk' => 'S 3 Tehnik Kebutuhan Lk',
            's3_tehnik_kebutuhan_pr' => 'S 3 Tehnik Kebutuhan Pr',
            's3_tehnik_kekurangan_lk' => 'S 3 Tehnik Kekurangan Lk',
            's3_tehnik_kekurangan_pr' => 'S 3 Tehnik Kekurangan Pr',
            's3_kesejahteraansosial_keadaan_lk' => 'S 3 Kesejahteraansosial Keadaan Lk',
            's3_kesejahteraansosial_keadaan_pr' => 'S 3 Kesejahteraansosial Keadaan Pr',
            's3_kesejahteraansosial_kebutuhan_lk' => 'S 3 Kesejahteraansosial Kebutuhan Lk',
            's3_kesejahteraansosial_kebutuhan_pr' => 'S 3 Kesejahteraansosial Kebutuhan Pr',
            's3_kesejahteraansosial_kekurangan_lk' => 'S 3 Kesejahteraansosial Kekurangan Lk',
            's3_kesejahteraansosial_kekurangan_pr' => 'S 3 Kesejahteraansosial Kekurangan Pr',
            's3_fisika_keadaan_lk' => 'S 3 Fisika Keadaan Lk',
            's3_fisika_keadaan_pr' => 'S 3 Fisika Keadaan Pr',
            's3_fisika_kebutuhan_lk' => 'S 3 Fisika Kebutuhan Lk',
            's3_fisika_kebutuhan_pr' => 'S 3 Fisika Kebutuhan Pr',
            's3_fisika_kekurangan_lk' => 'S 3 Fisika Kekurangan Lk',
            's3_fisika_kekurangan_pr' => 'S 3 Fisika Kekurangan Pr',
            's3_komputer_keadaan_lk' => 'S 3 Komputer Keadaan Lk',
            's3_komputer_keadaan_pr' => 'S 3 Komputer Keadaan Pr',
            's3_komputer_kebutuhan_lk' => 'S 3 Komputer Kebutuhan Lk',
            's3_komputer_kebutuhan_pr' => 'S 3 Komputer Kebutuhan Pr',
            's3_komputer_kekurangan_lk' => 'S 3 Komputer Kekurangan Lk',
            's3_komputer_kekurangan_pr' => 'S 3 Komputer Kekurangan Pr',
            's3_statistik_keadaan_lk' => 'S 3 Statistik Keadaan Lk',
            's3_statistik_keadaan_pr' => 'S 3 Statistik Keadaan Pr',
            's3_statistik_kebutuhan_lk' => 'S 3 Statistik Kebutuhan Lk',
            's3_statistik_kebutuhan_pr' => 'S 3 Statistik Kebutuhan Pr',
            's3_statistik_kekurangan_lk' => 'S 3 Statistik Kekurangan Lk',
            's3_statistik_kekurangan_pr' => 'S 3 Statistik Kekurangan Pr',
            'doktoral_lainnya_keadaan_lk' => 'Doktoral Lainnya Keadaan Lk',
            'doktoral_lainnya_keadaan_pr' => 'Doktoral Lainnya Keadaan Pr',
            'doktoral_lainnya_kebutuhan_lk' => 'Doktoral Lainnya Kebutuhan Lk',
            'doktoral_lainnya_kebutuhan_pr' => 'Doktoral Lainnya Kebutuhan Pr',
            'doktoral_lainnya_kekurangan_lk' => 'Doktoral Lainnya Kekurangan Lk',
            'doktoral_lainnya_kekurangan_pr' => 'Doktoral Lainnya Kekurangan Pr',
            's2_biologi_keadaan_lk' => 'S 2 Biologi Keadaan Lk',
            's2_biologi_keadaan_pr' => 'S 2 Biologi Keadaan Pr',
            's2_biologi_kebutuhan_lk' => 'S 2 Biologi Kebutuhan Lk',
            's2_biologi_kebutuhan_pr' => 'S 2 Biologi Kebutuhan Pr',
            's2_biologi_kekurangan_lk' => 'S 2 Biologi Kekurangan Lk',
            's2_biologi_kekurangan_pr' => 'S 2 Biologi Kekurangan Pr',
            's2_kimia_keadaan_lk' => 'S 2 Kimia Keadaan Lk',
            's2_kimia_keadaan_pr' => 'S 2 Kimia Keadaan Pr',
            's2_kimia_kebutuhan_lk' => 'S 2 Kimia Kebutuhan Lk',
            's2_kimia_kebutuhan_pr' => 'S 2 Kimia Kebutuhan Pr',
            's2_kimia_kekurangan_lk' => 'S 2 Kimia Kekurangan Lk',
            's2_kimia_kekurangan_pr' => 'S 2 Kimia Kekurangan Pr',
            's2_ekonomiakuntansi_keadaan_lk' => 'S 2 Ekonomiakuntansi Keadaan Lk',
            's2_ekonomiakuntansi_keadaan_pr' => 'S 2 Ekonomiakuntansi Keadaan Pr',
            's2_ekonomiakuntansi_kebutuhan_lk' => 'S 2 Ekonomiakuntansi Kebutuhan Lk',
            's2_ekonomiakuntansi_kebutuhan_pr' => 'S 2 Ekonomiakuntansi Kebutuhan Pr',
            's2_ekonomiakuntansi_kekurangan_lk' => 'S 2 Ekonomiakuntansi Kekurangan Lk',
            's2_ekonomiakuntansi_kekurangan_pr' => 'S 2 Ekonomiakuntansi Kekurangan Pr',
            's2_administrasi_keadaan_lk' => 'S 2 Administrasi Keadaan Lk',
            's2_administrasi_keadaan_pr' => 'S 2 Administrasi Keadaan Pr',
            's2_administrasi_kebutuhan_lk' => 'S 2 Administrasi Kebutuhan Lk',
            's2_administrasi_kebutuhan_pr' => 'S 2 Administrasi Kebutuhan Pr',
            's2_administrasi_kekurangan_lk' => 'S 2 Administrasi Kekurangan Lk',
            's2_administrasi_kekurangan_pr' => 'S 2 Administrasi Kekurangan Pr',
            's2_hukum_keadaan_lk' => 'S 2 Hukum Keadaan Lk',
            's2_hukum_keadaan_pr' => 'S 2 Hukum Keadaan Pr',
            's2_hukum_kebutuhan_lk' => 'S 2 Hukum Kebutuhan Lk',
            's2_hukum_kebutuhan_pr' => 'S 2 Hukum Kebutuhan Pr',
            's2_hukum_kekurangan_lk' => 'S 2 Hukum Kekurangan Lk',
            's2_hukum_kekurangan_pr' => 'S 2 Hukum Kekurangan Pr',
            's2_tehnik_keadaan_lk' => 'S 2 Tehnik Keadaan Lk',
            's2_tehnik_keadaan_pr' => 'S 2 Tehnik Keadaan Pr',
            's2_tehnik_kebutuhan_lk' => 'S 2 Tehnik Kebutuhan Lk',
            's2_tehnik_kebutuhan_pr' => 'S 2 Tehnik Kebutuhan Pr',
            's2_tehnik_kekurangan_lk' => 'S 2 Tehnik Kekurangan Lk',
            's2_tehnik_kekurangan_pr' => 'S 2 Tehnik Kekurangan Pr',
            's2_kesejahteraansosial_keadaan_lk' => 'S 2 Kesejahteraansosial Keadaan Lk',
            's2_kesejahteraansosial_keadaan_pr' => 'S 2 Kesejahteraansosial Keadaan Pr',
            's2_kesejahteraansosial_kebutuhan_lk' => 'S 2 Kesejahteraansosial Kebutuhan Lk',
            's2_kesejahteraansosial_kebutuhan_pr' => 'S 2 Kesejahteraansosial Kebutuhan Pr',
            's2_kesejahteraansosial_kekurangan_lk' => 'S 2 Kesejahteraansosial Kekurangan Lk',
            's2_kesejahteraansosial_kekurangan_pr' => 'S 2 Kesejahteraansosial Kekurangan Pr',
            's2_fisika_keadaan_lk' => 'S 2 Fisika Keadaan Lk',
            's2_fisika_keadaan_pr' => 'S 2 Fisika Keadaan Pr',
            's2_fisika_kebutuhan_lk' => 'S 2 Fisika Kebutuhan Lk',
            's2_fisika_kebutuhan_pr' => 'S 2 Fisika Kebutuhan Pr',
            's2_fisika_kekurangan_lk' => 'S 2 Fisika Kekurangan Lk',
            's2_fisika_kekurangan_pr' => 'S 2 Fisika Kekurangan Pr',
            's2_komputer_keadaan_lk' => 'S 2 Komputer Keadaan Lk',
            's2_komputer_keadaan_pr' => 'S 2 Komputer Keadaan Pr',
            's2_komputer_kebutuhan_lk' => 'S 2 Komputer Kebutuhan Lk',
            's2_komputer_kebutuhan_pr' => 'S 2 Komputer Kebutuhan Pr',
            's2_komputer_kekurangan_lk' => 'S 2 Komputer Kekurangan Lk',
            's2_komputer_kekurangan_pr' => 'S 2 Komputer Kekurangan Pr',
            's2_statistik_keadaan_lk' => 'S 2 Statistik Keadaan Lk',
            's2_statistik_keadaan_pr' => 'S 2 Statistik Keadaan Pr',
            's2_statistik_kebutuhan_lk' => 'S 2 Statistik Kebutuhan Lk',
            's2_statistik_kebutuhan_pr' => 'S 2 Statistik Kebutuhan Pr',
            's2_statistik_kekurangan_lk' => 'S 2 Statistik Kekurangan Lk',
            's2_statistik_kekurangan_pr' => 'S 2 Statistik Kekurangan Pr',
            's2_administrasikesehatanmasyarakat_keadaan_lk' => 'S 2 Administrasikesehatanmasyarakat Keadaan Lk',
            's2_administrasikesehatanmasyarakat_keadaan_pr' => 'S 2 Administrasikesehatanmasyarakat Keadaan Pr',
            's2_administrasikesehatanmasyarakat_kebutuhan_lk' => 'S 2 Administrasikesehatanmasyarakat Kebutuhan Lk',
            's2_administrasikesehatanmasyarakat_kebutuhan_pr' => 'S 2 Administrasikesehatanmasyarakat Kebutuhan Pr',
            's2_administrasikesehatanmasyarakat_kekurangan_lk' => 'S 2 Administrasikesehatanmasyarakat Kekurangan Lk',
            's2_administrasikesehatanmasyarakat_kekurangan_pr' => 'S 2 Administrasikesehatanmasyarakat Kekurangan Pr',
            'pasca_sarjanalainnya_keadaan_lk' => 'Pasca Sarjanalainnya Keadaan Lk',
            'pasca_sarjanalainnya_keadaan_pr' => 'Pasca Sarjanalainnya Keadaan Pr',
            'pasca_sarjanalainnya_kebutuhan_lk' => 'Pasca Sarjanalainnya Kebutuhan Lk',
            'pasca_sarjanalainnya_kebutuhan_pr' => 'Pasca Sarjanalainnya Kebutuhan Pr',
            'pasca_sarjanalainnya_kekurangan_lk' => 'Pasca Sarjanalainnya Kekurangan Lk',
            'pasca_sarjanalainnya_kekurangan_pr' => 'Pasca Sarjanalainnya Kekurangan Pr',
            'sarjana_biologi_keadaan_lk' => 'Sarjana Biologi Keadaan Lk',
            'sarjana_biologi_keadaan_pr' => 'Sarjana Biologi Keadaan Pr',
            'sarjana_biologi_kebutuhan_lk' => 'Sarjana Biologi Kebutuhan Lk',
            'sarjana_biologi_kebutuhan_pr' => 'Sarjana Biologi Kebutuhan Pr',
            'sarjana_biologi_kekurangan_lk' => 'Sarjana Biologi Kekurangan Lk',
            'sarjana_biologi_kekurangan_pr' => 'Sarjana Biologi Kekurangan Pr',
            'sarjana_kimia_keadaan_lk' => 'Sarjana Kimia Keadaan Lk',
            'sarjana_kimia_keadaan_pr' => 'Sarjana Kimia Keadaan Pr',
            'sarjana_kimia_kebutuhan_lk' => 'Sarjana Kimia Kebutuhan Lk',
            'sarjana_kimia_kebutuhan_pr' => 'Sarjana Kimia Kebutuhan Pr',
            'sarjana_kimia_kekurangan_lk' => 'Sarjana Kimia Kekurangan Lk',
            'sarjana_kimia_kekurangan_pr' => 'Sarjana Kimia Kekurangan Pr',
            'sarjana_ekonomiakuntansi_keadaan_lk' => 'Sarjana Ekonomiakuntansi Keadaan Lk',
            'sarjana_ekonomiakuntansi_keadaan_pr' => 'Sarjana Ekonomiakuntansi Keadaan Pr',
            'sarjana_ekonomiakuntansi_kebutuhan_lk' => 'Sarjana Ekonomiakuntansi Kebutuhan Lk',
            'sarjana_ekonomiakuntansi_kebutuhan_pr' => 'Sarjana Ekonomiakuntansi Kebutuhan Pr',
            'sarjana_ekonomiakuntansi_kekurangan_lk' => 'Sarjana Ekonomiakuntansi Kekurangan Lk',
            'sarjana_ekonomiakuntansi_kekurangan_pr' => 'Sarjana Ekonomiakuntansi Kekurangan Pr',
            'sarjana_administrasi_keadaan_lk' => 'Sarjana Administrasi Keadaan Lk',
            'sarjana_administrasi_keadaan_pr' => 'Sarjana Administrasi Keadaan Pr',
            'sarjana_administrasi_kebutuhan_lk' => 'Sarjana Administrasi Kebutuhan Lk',
            'sarjana_administrasi_kebutuhan_pr' => 'Sarjana Administrasi Kebutuhan Pr',
            'sarjana_administrasi_kekurangan_lk' => 'Sarjana Administrasi Kekurangan Lk',
            'sarjana_administrasi_kekurangan_pr' => 'Sarjana Administrasi Kekurangan Pr',
            'sarjana_hukum_keadaan_lk' => 'Sarjana Hukum Keadaan Lk',
            'sarjana_hukum_keadaan_pr' => 'Sarjana Hukum Keadaan Pr',
            'sarjana_hukum_kebutuhan_lk' => 'Sarjana Hukum Kebutuhan Lk',
            'sarjana_hukum_kebutuhan_pr' => 'Sarjana Hukum Kebutuhan Pr',
            'sarjana_hukum_kekurangan_lk' => 'Sarjana Hukum Kekurangan Lk',
            'sarjana_hukum_kekurangan_pr' => 'Sarjana Hukum Kekurangan Pr',
            'sarjana_tehnik_keadaan_lk' => 'Sarjana Tehnik Keadaan Lk',
            'sarjana_tehnik_keadaan_pr' => 'Sarjana Tehnik Keadaan Pr',
            'sarjana_tehnik_kebutuhan_lk' => 'Sarjana Tehnik Kebutuhan Lk',
            'sarjana_tehnik_kebutuhan_pr' => 'Sarjana Tehnik Kebutuhan Pr',
            'sarjana_tehnik_kekurangan_lk' => 'Sarjana Tehnik Kekurangan Lk',
            'sarjana_tehnik_kekurangan_pr' => 'Sarjana Tehnik Kekurangan Pr',
            'sarjana_kesejahteraansosial_keadaan_lk' => 'Sarjana Kesejahteraansosial Keadaan Lk',
            'sarjana_kesejahteraansosial_keadaan_pr' => 'Sarjana Kesejahteraansosial Keadaan Pr',
            'sarjana_kesejahteraansosial_kebutuhan_lk' => 'Sarjana Kesejahteraansosial Kebutuhan Lk',
            'sarjana_kesejahteraansosial_kebutuhan_pr' => 'Sarjana Kesejahteraansosial Kebutuhan Pr',
            'sarjana_kesejahteraansosial_kekurangan_lk' => 'Sarjana Kesejahteraansosial Kekurangan Lk',
            'sarjana_kesejahteraansosial_kekurangan_pr' => 'Sarjana Kesejahteraansosial Kekurangan Pr',
            'sarjana_fisika_keadaan_lk' => 'Sarjana Fisika Keadaan Lk',
            'sarjana_fisika_keadaan_pr' => 'Sarjana Fisika Keadaan Pr',
            'sarjana_fisika_kebutuhan_lk' => 'Sarjana Fisika Kebutuhan Lk',
            'sarjana_fisika_kebutuhan_pr' => 'Sarjana Fisika Kebutuhan Pr',
            'sarjana_fisika_kekurangan_lk' => 'Sarjana Fisika Kekurangan Lk',
            'sarjana_fisika_kekurangan_pr' => 'Sarjana Fisika Kekurangan Pr',
            'sarjana_komputer_keadaan_lk' => 'Sarjana Komputer Keadaan Lk',
            'sarjana_komputer_keadaan_pr' => 'Sarjana Komputer Keadaan Pr',
            'sarjana_komputer_kebutuhan_lk' => 'Sarjana Komputer Kebutuhan Lk',
            'sarjana_komputer_kebutuhan_pr' => 'Sarjana Komputer Kebutuhan Pr',
            'sarjana_komputer_kekurangan_lk' => 'Sarjana Komputer Kekurangan Lk',
            'sarjana_komputer_kekurangan_pr' => 'Sarjana Komputer Kekurangan Pr',
            'sarjana_statistik_keadaan_lk' => 'Sarjana Statistik Keadaan Lk',
            'sarjana_statistik_keadaan_pr' => 'Sarjana Statistik Keadaan Pr',
            'sarjana_statistik_kebutuhan_lk' => 'Sarjana Statistik Kebutuhan Lk',
            'sarjana_statistik_kebutuhan_pr' => 'Sarjana Statistik Kebutuhan Pr',
            'sarjana_statistik_kekurangan_lk' => 'Sarjana Statistik Kekurangan Lk',
            'sarjana_statistik_kekurangan_pr' => 'Sarjana Statistik Kekurangan Pr',
            'sarjana_lainnya_keadaan_lk' => 'Sarjana Lainnya Keadaan Lk',
            'sarjana_lainnya_keadaan_pr' => 'Sarjana Lainnya Keadaan Pr',
            'sarjana_lainnya_kebutuhan_lk' => 'Sarjana Lainnya Kebutuhan Lk',
            'sarjana_lainnya_kebutuhan_pr' => 'Sarjana Lainnya Kebutuhan Pr',
            'sarjana_lainnya_kekurangan_lk' => 'Sarjana Lainnya Kekurangan Lk',
            'sarjana_lainnya_kekurangan_pr' => 'Sarjana Lainnya Kekurangan Pr',
            'sarjana_muda_biologi_keadaan_lk' => 'Sarjana Muda Biologi Keadaan Lk',
            'sarjana_muda_biologi_keadaan_pr' => 'Sarjana Muda Biologi Keadaan Pr',
            'sarjana_muda_biologi_kebutuhan_lk' => 'Sarjana Muda Biologi Kebutuhan Lk',
            'sarjana_muda_biologi_kebutuhan_pr' => 'Sarjana Muda Biologi Kebutuhan Pr',
            'sarjana_muda_biologi_kekurangan_lk' => 'Sarjana Muda Biologi Kekurangan Lk',
            'sarjana_muda_biologi_kekurangan_pr' => 'Sarjana Muda Biologi Kekurangan Pr',
            'sarjana_muda_kimia_keadaan_lk' => 'Sarjana Muda Kimia Keadaan Lk',
            'sarjana_muda_kimia_keadaan_pr' => 'Sarjana Muda Kimia Keadaan Pr',
            'sarjana_muda_kimia_kebutuhan_lk' => 'Sarjana Muda Kimia Kebutuhan Lk',
            'sarjana_muda_kimia_kebutuhan_pr' => 'Sarjana Muda Kimia Kebutuhan Pr',
            'sarjana_muda_kimia_kekurangan_lk' => 'Sarjana Muda Kimia Kekurangan Lk',
            'sarjana_muda_kimia_kekurangan_pr' => 'Sarjana Muda Kimia Kekurangan Pr',
            'sarjana_muda_ekonomiakuntansi_keadaan_lk' => 'Sarjana Muda Ekonomiakuntansi Keadaan Lk',
            'sarjana_muda_ekonomiakuntansi_keadaan_pr' => 'Sarjana Muda Ekonomiakuntansi Keadaan Pr',
            'sarjana_muda_ekonomiakuntansi_kebutuhan_lk' => 'Sarjana Muda Ekonomiakuntansi Kebutuhan Lk',
            'sarjana_muda_ekonomiakuntansi_kebutuhan_pr' => 'Sarjana Muda Ekonomiakuntansi Kebutuhan Pr',
            'sarjana_muda_ekonomiakuntansi_kekurangan_lk' => 'Sarjana Muda Ekonomiakuntansi Kekurangan Lk',
            'sarjana_muda_ekonomiakuntansi_kekurangan_pr' => 'Sarjana Muda Ekonomiakuntansi Kekurangan Pr',
            'sarjana_muda_administrasi_keadaan_lk' => 'Sarjana Muda Administrasi Keadaan Lk',
            'sarjana_muda_administrasi_keadaan_pr' => 'Sarjana Muda Administrasi Keadaan Pr',
            'sarjana_muda_administrasi_kebutuhan_lk' => 'Sarjana Muda Administrasi Kebutuhan Lk',
            'sarjana_muda_administrasi_kebutuhan_pr' => 'Sarjana Muda Administrasi Kebutuhan Pr',
            'sarjana_muda_administrasi_kekurangan_lk' => 'Sarjana Muda Administrasi Kekurangan Lk',
            'sarjana_muda_administrasi_kekurangan_pr' => 'Sarjana Muda Administrasi Kekurangan Pr',
            'sarjana_muda_hukum_keadaan_lk' => 'Sarjana Muda Hukum Keadaan Lk',
            'sarjana_muda_hukum_keadaan_pr' => 'Sarjana Muda Hukum Keadaan Pr',
            'sarjana_muda_hukum_kebutuhan_lk' => 'Sarjana Muda Hukum Kebutuhan Lk',
            'sarjana_muda_hukum_kebutuhan_pr' => 'Sarjana Muda Hukum Kebutuhan Pr',
            'sarjana_muda_hukum_kekurangan_lk' => 'Sarjana Muda Hukum Kekurangan Lk',
            'sarjana_muda_hukum_kekurangan_pr' => 'Sarjana Muda Hukum Kekurangan Pr',
            'sarjana_muda_tehnik_keadaan_lk' => 'Sarjana Muda Tehnik Keadaan Lk',
            'sarjana_muda_tehnik_keadaan_pr' => 'Sarjana Muda Tehnik Keadaan Pr',
            'sarjana_muda_tehnik_kebutuhan_lk' => 'Sarjana Muda Tehnik Kebutuhan Lk',
            'sarjana_muda_tehnik_kebutuhan_pr' => 'Sarjana Muda Tehnik Kebutuhan Pr',
            'sarjana_muda_tehnik_kekurangan_lk' => 'Sarjana Muda Tehnik Kekurangan Lk',
            'sarjana_muda_tehnik_kekurangan_pr' => 'Sarjana Muda Tehnik Kekurangan Pr',
            'sarjana_muda_kesejahteraansosial_keadaan_lk' => 'Sarjana Muda Kesejahteraansosial Keadaan Lk',
            'sarjana_muda_kesejahteraansosial_keadaan_pr' => 'Sarjana Muda Kesejahteraansosial Keadaan Pr',
            'sarjana_muda_kesejahteraansosial_kebutuhan_lk' => 'Sarjana Muda Kesejahteraansosial Kebutuhan Lk',
            'sarjana_muda_kesejahteraansosial_kebutuhan_pr' => 'Sarjana Muda Kesejahteraansosial Kebutuhan Pr',
            'sarjana_muda_kesejahteraansosial_kekurangan_lk' => 'Sarjana Muda Kesejahteraansosial Kekurangan Lk',
            'sarjana_muda_kesejahteraansosial_kekurangan_pr' => 'Sarjana Muda Kesejahteraansosial Kekurangan Pr',
            'sarjana_muda_sekretaris_keadaan_lk' => 'Sarjana Muda Sekretaris Keadaan Lk',
            'sarjana_muda_sekretaris_keadaan_pr' => 'Sarjana Muda Sekretaris Keadaan Pr',
            'sarjana_muda_sekretaris_kebutuhan_lk' => 'Sarjana Muda Sekretaris Kebutuhan Lk',
            'sarjana_muda_sekretaris_kebutuhan_pr' => 'Sarjana Muda Sekretaris Kebutuhan Pr',
            'sarjana_muda_sekretaris_kekurangan_lk' => 'Sarjana Muda Sekretaris Kekurangan Lk',
            'sarjana_muda_sekretaris_kekurangan_pr' => 'Sarjana Muda Sekretaris Kekurangan Pr',
            'sarjana_muda_komputer_keadaan_lk' => 'Sarjana Muda Komputer Keadaan Lk',
            'sarjana_muda_komputer_keadaan_pr' => 'Sarjana Muda Komputer Keadaan Pr',
            'sarjana_muda_komputer_kebutuhan_lk' => 'Sarjana Muda Komputer Kebutuhan Lk',
            'sarjana_muda_komputer_kebutuhan_pr' => 'Sarjana Muda Komputer Kebutuhan Pr',
            'sarjana_muda_komputer_kekurangan_lk' => 'Sarjana Muda Komputer Kekurangan Lk',
            'sarjana_muda_komputer_kekurangan_pr' => 'Sarjana Muda Komputer Kekurangan Pr',
            'sarjana_muda_statistik_keadaan_lk' => 'Sarjana Muda Statistik Keadaan Lk',
            'sarjana_muda_statistik_keadaan_pr' => 'Sarjana Muda Statistik Keadaan Pr',
            'sarjana_muda_statistik_kebutuhan_lk' => 'Sarjana Muda Statistik Kebutuhan Lk',
            'sarjana_muda_statistik_kebutuhan_pr' => 'Sarjana Muda Statistik Kebutuhan Pr',
            'sarjana_muda_statistik_kekurangan_lk' => 'Sarjana Muda Statistik Kekurangan Lk',
            'sarjana_muda_statistik_kekurangan_pr' => 'Sarjana Muda Statistik Kekurangan Pr',
            'sarjana_muda_lainnya_keadaan_lk' => 'Sarjana Muda Lainnya Keadaan Lk',
            'sarjana_muda_lainnya_keadaan_pr' => 'Sarjana Muda Lainnya Keadaan Pr',
            'sarjana_muda_lainnya_kebutuhan_lk' => 'Sarjana Muda Lainnya Kebutuhan Lk',
            'sarjana_muda_lainnya_kebutuhan_pr' => 'Sarjana Muda Lainnya Kebutuhan Pr',
            'sarjana_muda_lainnya_kekurangan_lk' => 'Sarjana Muda Lainnya Kekurangan Lk',
            'sarjana_muda_lainnya_kekurangan_pr' => 'Sarjana Muda Lainnya Kekurangan Pr',
            'sma_smu_keadaan_lk' => 'Sma Smu Keadaan Lk',
            'sma_smu_keadaan_pr' => 'Sma Smu Keadaan Pr',
            'sma_smu_kebutuhan_lk' => 'Sma Smu Kebutuhan Lk',
            'sma_smu_kebutuhan_pr' => 'Sma Smu Kebutuhan Pr',
            'sma_smu_kekurangan_lk' => 'Sma Smu Kekurangan Lk',
            'sma_smu_kekurangan_pr' => 'Sma Smu Kekurangan Pr',
            'smea_keadaan_lk' => 'Smea Keadaan Lk',
            'smea_keadaan_pr' => 'Smea Keadaan Pr',
            'smea_kebutuhan_lk' => 'Smea Kebutuhan Lk',
            'smea_kebutuhan_pr' => 'Smea Kebutuhan Pr',
            'smea_kekurangan_lk' => 'Smea Kekurangan Lk',
            'smea_kekurangan_pr' => 'Smea Kekurangan Pr',
            'stm_keadaan_lk' => 'Stm Keadaan Lk',
            'stm_keadaan_pr' => 'Stm Keadaan Pr',
            'stm_kebutuhan_lk' => 'Stm Kebutuhan Lk',
            'stm_kebutuhan_pr' => 'Stm Kebutuhan Pr',
            'stm_kekurangan_lk' => 'Stm Kekurangan Lk',
            'stm_kekurangan_pr' => 'Stm Kekurangan Pr',
            'smkk_keadaan_lk' => 'Smkk Keadaan Lk',
            'smkk_keadaan_pr' => 'Smkk Keadaan Pr',
            'smkk_kebutuhan_lk' => 'Smkk Kebutuhan Lk',
            'smkk_kebutuhan_pr' => 'Smkk Kebutuhan Pr',
            'smkk_kekurangan_lk' => 'Smkk Kekurangan Lk',
            'smkk_kekurangan_pr' => 'Smkk Kekurangan Pr',
            'spsa_keadaan_lk' => 'Spsa Keadaan Lk',
            'spsa_keadaan_pr' => 'Spsa Keadaan Pr',
            'spsa_kebutuhan_lk' => 'Spsa Kebutuhan Lk',
            'spsa_kebutuhan_pr' => 'Spsa Kebutuhan Pr',
            'spsa_kekurangan_lk' => 'Spsa Kekurangan Lk',
            'spsa_kekurangan_pr' => 'Spsa Kekurangan Pr',
            'smtp_keadaan_lk' => 'Smtp Keadaan Lk',
            'smtp_keadaan_pr' => 'Smtp Keadaan Pr',
            'smtp_kebutuhan_lk' => 'Smtp Kebutuhan Lk',
            'smtp_kebutuhan_pr' => 'Smtp Kebutuhan Pr',
            'smtp_kekurangan_lk' => 'Smtp Kekurangan Lk',
            'smtp_kekurangan_pr' => 'Smtp Kekurangan Pr',
            'sd_kebawah_keadaan_lk' => 'Sd Kebawah Keadaan Lk',
            'sd_kebawah_keadaan_pr' => 'Sd Kebawah Keadaan Pr',
            'sd_kebawah_kebutuhan_lk' => 'Sd Kebawah Kebutuhan Lk',
            'sd_kebawah_kebutuhan_pr' => 'Sd Kebawah Kebutuhan Pr',
            'sd_kebawah_kekurangan_lk' => 'Sd Kebawah Kekurangan Lk',
            'sd_kebawah_kekurangan_pr' => 'Sd Kebawah Kekurangan Pr',
            'smta_lainnya_keadaan_lk' => 'Smta Lainnya Keadaan Lk',
            'smta_lainnya_keadaan_pr' => 'Smta Lainnya Keadaan Pr',
            'smta_lainnya_kebutuhan_lk' => 'Smta Lainnya Kebutuhan Lk',
            'smta_lainnya_kebutuhan_pr' => 'Smta Lainnya Kebutuhan Pr',
            'smta_lainnya_kekurangan_lk' => 'Smta Lainnya Kekurangan Lk',
            'smta_lainnya_kekurangan_pr' => 'Smta Lainnya Kekurangan Pr',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
        ];
    }
    function beforeSave($model)
    {
        if ($this->isNewRecord) {
            $this->created_by = Yii::$app->user->identity->id;
            $this->created_at = date('Y-m-d H:i:s');
           
        } else {
            $this->updated_by = Yii::$app->user->identity->id;
            $this->updated_at = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($model);
    }
}
