/*
 * @Author: Dicky Ermawan S., S.T., MTA 
 * @Email: wanasaja@gmail.com 
 * @Web: dickyermawan.github.io 
 * @Linkedin: linkedin.com/in/dickyermawan 
 * @Date: 2021-03-08 07:01:51 
 * @Last Modified by: Dicky Ermawan S., S.T., MTA
 * @Last Modified time: 2022-04-08 11:46:09
 */


$(document).ready(function () {
    $('#kegiatanpelayananrawatinap-jenis_laporan').on('change', function (e) {
        if ($('#KegiatanPelayananRawatInap_jenis_laporan_0').prop('checked')) {
            $('#div-kegiatan-pelayanan-rawat-inap-tgl_bulan').hide()
            $('#div-kegiatan-pelayanan-rawat-inap-tgl_tahun').hide()
            $('#div-kegiatan-pelayanan-rawat-inap-tgl_hari').show()
        } else if ($('#KegiatanPelayananRawatInap_jenis_laporan_1').prop('checked')) {
            $('#div-kegiatan-pelayanan-rawat-inap-tgl_hari').hide()
            $('#div-kegiatan-pelayanan-rawat-inap-tgl_tahun').hide()
            $('#div-kegiatan-pelayanan-rawat-inap-tgl_bulan').show()
        } else if ($('#KegiatanPelayananRawatInap_jenis_laporan_2').prop('checked')) {
            $('#div-kegiatan-pelayanan-rawat-inap-tgl_hari').hide()
            $('#div-kegiatan-pelayanan-rawat-inap-tgl_bulan').hide()
            $('#div-kegiatan-pelayanan-rawat-inap-tgl_tahun').show()
        }
    })
    $('#kunjunganrawatdarurat-jenis_laporan').on('change', function (e) {
         if ($('#KunjunganRawatDarurat_jenis_laporan_0').prop('checked')) {
             $('#div-kunjungan-rawat-darurat-tgl_bulan').hide()
             $('#div-kunjungan-rawat-darurat-tgl_tahun').hide()
             $('#div-kunjungan-rawat-darurat-tgl_hari').show()
         } else if ($('#KunjunganRawatDarurat_jenis_laporan_1').prop('checked')) {
             $('#div-kunjungan-rawat-darurat-tgl_hari').hide()
             $('#div-kunjungan-rawat-darurat-tgl_tahun').hide()
             $('#div-kunjungan-rawat-darurat-tgl_bulan').show()
         } else if ($('#KunjunganRawatDarurat_jenis_laporan_2').prop('checked')) {
             $('#div-kunjungan-rawat-darurat-tgl_hari').hide()
             $('#div-kunjungan-rawat-darurat-tgl_bulan').hide()
             $('#div-kunjungan-rawat-darurat-tgl_tahun').show()
         }
    })
    $('#kegiatankesehatangigimulut-jenis_laporan').on('change', function (e) {
        if ($('#KegiatanKesehatanGigiMulut_jenis_laporan_0').prop('checked')) {
            $('#div-kegiatan-kesehatan-gigi-mulut-tgl_bulan').hide()
            $('#div-kegiatan-kesehatan-gigi-mulut-tgl_tahun').hide()
            $('#div-kegiatan-kesehatan-gigi-mulut-tgl_hari').show()
        } else if ($('#KegiatanKesehatanGigiMulut_jenis_laporan_1').prop('checked')) {
            $('#div-kegiatan-kesehatan-gigi-mulut-tgl_hari').hide()
            $('#div-kegiatan-kesehatan-gigi-mulut-tgl_tahun').hide()
            $('#div-kegiatan-kesehatan-gigi-mulut-tgl_bulan').show()
        } else if ($('#KegiatanKesehatanGigiMulut_jenis_laporan_2').prop('checked')) {
            $('#div-kegiatan-kesehatan-gigi-mulut-tgl_hari').hide()
            $('#div-kegiatan-kesehatan-gigi-mulut-tgl_bulan').hide()
            $('#div-kegiatan-kesehatan-gigi-mulut-tgl_tahun').show()
        }
    })
    $('#kegiatankebidanan-jenis_laporan').on('change', function (e) {
        if ($('#KegiatanKebidanan_jenis_laporan_0').prop('checked')) {
            $('#div-kegiatan-kebidanan-tgl_bulan').hide()
            $('#div-kegiatan-kebidanan-tgl_tahun').hide()
            $('#div-kegiatan-kebidanan-tgl_hari').show()
        } else if ($('#KegiatanKebidanan_jenis_laporan_1').prop('checked')) {
            $('#div-kegiatan-kebidanan-tgl_hari').hide()
            $('#div-kegiatan-kebidanan-tgl_tahun').hide()
            $('#div-kegiatan-kebidanan-tgl_bulan').show()
        } else if ($('#KegiatanKebidanan_jenis_laporan_2').prop('checked')) {
            $('#div-kegiatan-kebidanan-tgl_hari').hide()
            $('#div-kegiatan-kebidanan-tgl_bulan').hide()
            $('#div-kegiatan-kebidanan-tgl_tahun').show()
        }
    })

    $('#kegiatanperinatologi-jenis_laporan').on('change', function (e) {
        if ($('#KegiatanPerinatologi_jenis_laporan_0').prop('checked')) {
            $('#div-kegiatan-perinatologi-tgl_bulan').hide()
            $('#div-kegiatan-perinatologi-tgl_tahun').hide()
            $('#div-kegiatan-perinatologi-tgl_hari').show()
        } else if ($('#KegiatanPerinatologi_jenis_laporan_1').prop('checked')) {
            $('#div-kegiatan-perinatologi-tgl_hari').hide()
            $('#div-kegiatan-perinatologi-tgl_tahun').hide()
            $('#div-kegiatan-perinatologi-tgl_bulan').show()
        } else if ($('#KegiatanPerinatologi_jenis_laporan_2').prop('checked')) {
            $('#div-kegiatan-perinatologi-tgl_hari').hide()
            $('#div-kegiatan-perinatologi-tgl_bulan').hide()
            $('#div-kegiatan-perinatologi-tgl_tahun').show()
        }
    })
    $('#kegiatanpembedahan-jenis_laporan').on('change', function (e) {
        if ($('#KegiatanPembedahan_jenis_laporan_0').prop('checked')) {
            $('#div-kegiatan-pembedahan-tgl_bulan').hide()
            $('#div-kegiatan-pembedahan-tgl_tahun').hide()
            $('#div-kegiatan-pembedahan-tgl_hari').show()
        } else if ($('#KegiatanPembedahan_jenis_laporan_1').prop('checked')) {
            $('#div-kegiatan-pembedahan-tgl_hari').hide()
            $('#div-kegiatan-pembedahan-tgl_tahun').hide()
            $('#div-kegiatan-pembedahan-tgl_bulan').show()
        } else if ($('#KegiatanPembedahan_jenis_laporan_2').prop('checked')) {
            $('#div-kegiatan-pembedahan-tgl_hari').hide()
            $('#div-kegiatan-pembedahan-tgl_bulan').hide()
            $('#div-kegiatan-pembedahan-tgl_tahun').show()
        }
    })
  
    $('#pemeriksaanlaboratorium-jenis_laporan').on('change', function (e) {
        if ($('#PemeriksaanLaboratorium_jenis_laporan_0').prop('checked')) {
            $('#div-pemeriksaan-laboratorium-tgl_bulan').hide()
            $('#div-pemeriksaan-laboratorium-tgl_tahun').hide()
            $('#div-pemeriksaan-laboratorium-tgl_hari').show()
        } else if ($('#PemeriksaanLaboratorium_jenis_laporan_1').prop('checked')) {
            $('#div-pemeriksaan-laboratorium-tgl_hari').hide()
            $('#div-pemeriksaan-laboratorium-tgl_tahun').hide()
            $('#div-pemeriksaan-laboratorium-tgl_bulan').show()
        } else if ($('#PemeriksaanLaboratorium_jenis_laporan_2').prop('checked')) {
            $('#div-pemeriksaan-laboratorium-tgl_hari').hide()
            $('#div-pemeriksaan-laboratorium-tgl_bulan').hide()
            $('#div-pemeriksaan-laboratorium-tgl_tahun').show()
        }
    })


    $('#pelayananrehabilitasimedik-jenis_laporan').on('change', function (e) {
        if ($('#PelayananRehabilitasiMedik_jenis_laporan_0').prop('checked')) {
            $('#div-pelayanan-rehabilitasi-medik-tgl_bulan').hide()
            $('#div-pelayanan-rehabilitasi-medik-tgl_tahun').hide()
            $('#div-pelayanan-rehabilitasi-medik-tgl_hari').show()
        } else if ($('#PelayananRehabilitasiMedik_jenis_laporan_1').prop('checked')) {
            $('#div-pelayanan-rehabilitasi-medik-tgl_hari').hide()
            $('#div-pelayanan-rehabilitasi-medik-tgl_tahun').hide()
            $('#div-pelayanan-rehabilitasi-medik-tgl_bulan').show()
        } else if ($('#PelayananRehabilitasiMedik_jenis_laporan_2').prop('checked')) {
            $('#div-pelayanan-rehabilitasi-medik-tgl_hari').hide()
            $('#div-pelayanan-rehabilitasi-medik-tgl_bulan').hide()
            $('#div-pelayanan-rehabilitasi-medik-tgl_tahun').show()
        }
    })
   
    $('#kegiatanpelayanankhusus-jenis_laporan').on('change', function (e) {
        if ($('#KegiatanPelayananKhusus_jenis_laporan_0').prop('checked')) {
            $('#div-kegiatan-pelayanan-khusus-tgl_bulan').hide()
            $('#div-kegiatan-pelayanan-khusus-tgl_tahun').hide()
            $('#div-kegiatan-pelayanan-khusus-tgl_hari').show()
        } else if ($('#KegiatanPelayananKhusus_jenis_laporan_1').prop('checked')) {
            $('#div-kegiatan-pelayanan-khusus-tgl_hari').hide()
            $('#div-kegiatan-pelayanan-khusus-tgl_tahun').hide()
            $('#div-kegiatan-pelayanan-khusus-tgl_bulan').show()
        } else if ($('#KegiatanPelayananKhusus_jenis_laporan_2').prop('checked')) {
            $('#div-kegiatan-pelayanan-khusus-tgl_hari').hide()
            $('#div-kegiatan-pelayanan-khusus-tgl_bulan').hide()
            $('#div-kegiatan-pelayanan-khusus-tgl_tahun').show()
        }
    })

    $('#kegiatankesehatanjiwa-jenis_laporan').on('change', function (e) {
        if ($('#KegiatanKesehatanJiwa_jenis_laporan_0').prop('checked')) {
            $('#div-kegiatan-kesehatan-jiwa-tgl_bulan').hide()
            $('#div-kegiatan-kesehatan-jiwa-tgl_tahun').hide()
            $('#div-kegiatan-kesehatan-jiwa-tgl_hari').show()
        } else if ($('#KegiatanKesehatanJiwa_jenis_laporan_1').prop('checked')) {
            $('#div-kegiatan-kesehatan-jiwa-tgl_hari').hide()
            $('#div-kegiatan-kesehatan-jiwa-tgl_tahun').hide()
            $('#div-kegiatan-kesehatan-jiwa-tgl_bulan').show()
        } else if ($('#KegiatanKesehatanJiwa_jenis_laporan_2').prop('checked')) {
            $('#div-kegiatan-kesehatan-jiwa-tgl_hari').hide()
            $('#div-kegiatan-kesehatan-jiwa-tgl_bulan').hide()
            $('#div-kegiatan-kesehatan-jiwa-tgl_tahun').show()
        }
    })

    $('#kegiatankeluargaberencana-jenis_laporan').on('change', function (e) {
        if ($('#KegiatanKeluargaBerencana_jenis_laporan_0').prop('checked')) {
            $('#div-kegiatan-keluarga-berencana-tgl_bulan').hide()
            $('#div-kegiatan-keluarga-berencana-tgl_tahun').hide()
            $('#div-kegiatan-keluarga-berencana-tgl_hari').show()
        } else if ($('#KegiatanKeluargaBerencana_jenis_laporan_1').prop('checked')) {
            $('#div-kegiatan-keluarga-berencana-tgl_hari').hide()
            $('#div-kegiatan-keluarga-berencana-tgl_tahun').hide()
            $('#div-kegiatan-keluarga-berencana-tgl_bulan').show()
        } else if ($('#KegiatanKeluargaBerencana_jenis_laporan_2').prop('checked')) {
            $('#div-kegiatan-keluarga-berencana-tgl_hari').hide()
            $('#div-kegiatan-keluarga-berencana-tgl_bulan').hide()
            $('#div-kegiatan-keluarga-berencana-tgl_tahun').show()
        }
    })

    $('#pengadaanobatpenulisanpelayananresep-jenis_laporan').on('change', function (e) {
        if ($('#PengadaanObatPenulisanPelayananResep_jenis_laporan_0').prop('checked')) {
            $('#div-pengadaan-obat-penulisan-pelayanan-resep-tgl_bulan').hide()
            $('#div-pengadaan-obat-penulisan-pelayanan-resep-tgl_tahun').hide()
            $('#div-pengadaan-obat-penulisan-pelayanan-resep-tgl_hari').show()
        } else if ($('#PengadaanObatPenulisanPelayananResep_jenis_laporan_1').prop('checked')) {
            $('#div-pengadaan-obat-penulisan-pelayanan-resep-tgl_hari').hide()
            $('#div-pengadaan-obat-penulisan-pelayanan-resep-tgl_tahun').hide()
            $('#div-pengadaan-obat-penulisan-pelayanan-resep-tgl_bulan').show()
        } else if ($('#PengadaanObatPenulisanPelayananResep_jenis_laporan_2').prop('checked')) {
            $('#div-pengadaan-obat-penulisan-pelayanan-resep-tgl_hari').hide()
            $('#div-pengadaan-obat-penulisan-pelayanan-resep-tgl_bulan').hide()
            $('#div-pengadaan-obat-penulisan-pelayanan-resep-tgl_tahun').show()
        }
    })
   
    $('#kegiatanrujukan-jenis_laporan').on('change', function (e) {
        if ($('#KegiatanRujukan_jenis_laporan_0').prop('checked')) {
            $('#div-kegiatan-rujukan-tgl_bulan').hide()
            $('#div-kegiatan-rujukan-tgl_tahun').hide()
            $('#div-kegiatan-rujukan-tgl_hari').show()
        } else if ($('#KegiatanRujukan_jenis_laporan_1').prop('checked')) {
            $('#div-kegiatan-rujukan-tgl_hari').hide()
            $('#div-kegiatan-rujukan-tgl_tahun').hide()
            $('#div-kegiatan-rujukan-tgl_bulan').show()
        } else if ($('#KegiatanRujukan_jenis_laporan_2').prop('checked')) {
            $('#div-kegiatan-rujukan-tgl_hari').hide()
            $('#div-kegiatan-rujukan-tgl_bulan').hide()
            $('#div-kegiatan-rujukan-tgl_tahun').show()
        }
    })

    
    $('#carabayar-jenis_laporan').on('change', function (e) {
        if ($('#CaraBayar_jenis_laporan_0').prop('checked')) {
            $('#div-cara-bayar-tgl_bulan').hide()
            $('#div-cara-bayar-tgl_tahun').hide()
            $('#div-cara-bayar-tgl_hari').show()
        } else if ($('#CaraBayar_jenis_laporan_1').prop('checked')) {
            $('#div-cara-bayar-tgl_hari').hide()
            $('#div-cara-bayar-tgl_tahun').hide()
            $('#div-cara-bayar-tgl_bulan').show()
        } else if ($('#CaraBayar_jenis_laporan_2').prop('checked')) {
            $('#div-cara-bayar-tgl_hari').hide()
            $('#div-cara-bayar-tgl_bulan').hide()
            $('#div-cara-bayar-tgl_tahun').show()
        }
    })

    $('#morbiditaspasienrawatinaprumahsakit-jenis_laporan').on('change', function (e) {
        if ($('#MorbiditasPasienRawatInapRumahSakit_jenis_laporan_0').prop('checked')) {
            $('#div-morbiditas-pasien-rawat-inap-rumah-sakit-tgl_bulan').hide()
            $('#div-morbiditas-pasien-rawat-inap-rumah-sakit-tgl_tahun').hide()
            $('#div-morbiditas-pasien-rawat-inap-rumah-sakit-tgl_hari').show()
        } else if ($('#MorbiditasPasienRawatInapRumahSakit_jenis_laporan_1').prop('checked')) {
            $('#div-morbiditas-pasien-rawat-inap-rumah-sakit-tgl_hari').hide()
            $('#div-morbiditas-pasien-rawat-inap-rumah-sakit-tgl_tahun').hide()
            $('#div-morbiditas-pasien-rawat-inap-rumah-sakit-tgl_bulan').show()
        } else if ($('#MorbiditasPasienRawatInapRumahSakit_jenis_laporan_2').prop('checked')) {
            $('#div-morbiditas-pasien-rawat-inap-rumah-sakit-tgl_hari').hide()
            $('#div-morbiditas-pasien-rawat-inap-rumah-sakit-tgl_bulan').hide()
            $('#div-morbiditas-pasien-rawat-inap-rumah-sakit-tgl_tahun').show()
        }
    })

    $('#morbiditaspasienrawatinaprumahsakitpenyebabkecelakaan-jenis_laporan').on('change', function (e) {
        if ($('#MorbiditasPasienRawatInapRumahSakitPenyebabKecelakaan_jenis_laporan_0').prop('checked')) {
            $('#div-morbiditas-pasien-rawat-inap-rumah-sakit-penyebab-kecelakaan-tgl_bulan').hide()
            $('#div-morbiditas-pasien-rawat-inap-rumah-sakit-penyebab-kecelakaan-tgl_tahun').hide()
            $('#div-morbiditas-pasien-rawat-inap-rumah-sakit-penyebab-kecelakaan-tgl_hari').show()
        } else if ($('#MorbiditasPasienRawatInapRumahSakitPenyebabKecelakaan_jenis_laporan_1').prop('checked')) {
            $('#div-morbiditas-pasien-rawat-inap-rumah-sakit-penyebab-kecelakaan-tgl_hari').hide()
            $('#div-morbiditas-pasien-rawat-inap-rumah-sakit-penyebab-kecelakaan-tgl_tahun').hide()
            $('#div-morbiditas-pasien-rawat-inap-rumah-sakit-penyebab-kecelakaan-tgl_bulan').show()
        } else if ($('#MorbiditasPasienRawatInapRumahSakitPenyebabKecelakaan_jenis_laporan_2').prop('checked')) {
            $('#div-morbiditas-pasien-rawat-inap-rumah-sakit-penyebab-kecelakaan-tgl_hari').hide()
            $('#div-morbiditas-pasien-rawat-inap-rumah-sakit-penyebab-kecelakaan-tgl_bulan').hide()
            $('#div-morbiditas-pasien-rawat-inap-rumah-sakit-penyebab-kecelakaan-tgl_tahun').show()
        }
    })
    $('#morbiditaspasienrawatjalanrumahsakit-jenis_laporan').on('change', function (e) {
        if ($('#MorbiditasPasienRawatJalanRumahSakit_jenis_laporan_0').prop('checked')) {
            $('#div-morbiditas-pasien-rawat-jalan-rumah-sakit-tgl_bulan').hide()
            $('#div-morbiditas-pasien-rawat-jalan-rumah-sakit-tgl_tahun').hide()
            $('#div-morbiditas-pasien-rawat-jalan-rumah-sakit-tgl_hari').show()
        } else if ($('#MorbiditasPasienRawatJalanRumahSakit_jenis_laporan_1').prop('checked')) {
            $('#div-morbiditas-pasien-rawat-jalan-rumah-sakit-tgl_hari').hide()
            $('#div-morbiditas-pasien-rawat-jalan-rumah-sakit-tgl_tahun').hide()
            $('#div-morbiditas-pasien-rawat-jalan-rumah-sakit-tgl_bulan').show()
        } else if ($('#MorbiditasPasienRawatJalanRumahSakit_jenis_laporan_2').prop('checked')) {
            $('#div-morbiditas-pasien-rawat-jalan-rumah-sakit-tgl_hari').hide()
            $('#div-morbiditas-pasien-rawat-jalan-rumah-sakit-tgl_bulan').hide()
            $('#div-morbiditas-pasien-rawat-jalan-rumah-sakit-tgl_tahun').show()
        }
    })

    $('#morbiditaspasienrawatjalanrumahsakitpenyebabkecelakaan-jenis_laporan').on('change', function (e) {
        if ($('#MorbiditasPasienRawatJalanRumahSakitPenyebabKecelakaan_jenis_laporan_0').prop('checked')) {
            $('#div-morbiditas-pasien-rawat-jalan-rumah-sakit-penyebab-kecelakaan-tgl_bulan').hide()
            $('#div-morbiditas-pasien-rawat-jalan-rumah-sakit-penyebab-kecelakaan-tgl_tahun').hide()
            $('#div-morbiditas-pasien-rawat-jalan-rumah-sakit-penyebab-kecelakaan-tgl_hari').show()
        } else if ($('#MorbiditasPasienRawatJalanRumahSakitPenyebabKecelakaan_jenis_laporan_1').prop('checked')) {
            $('#div-morbiditas-pasien-rawat-jalan-rumah-sakit-penyebab-kecelakaan-tgl_hari').hide()
            $('#div-morbiditas-pasien-rawat-jalan-rumah-sakit-penyebab-kecelakaan-tgl_tahun').hide()
            $('#div-morbiditas-pasien-rawat-jalan-rumah-sakit-penyebab-kecelakaan-tgl_bulan').show()
        } else if ($('#MorbiditasPasienRawatJalanRumahSakitPenyebabKecelakaan_jenis_laporan_2').prop('checked')) {
            $('#div-morbiditas-pasien-rawat-jalan-rumah-sakit-penyebab-kecelakaan-tgl_hari').hide()
            $('#div-morbiditas-pasien-rawat-jalan-rumah-sakit-penyebab-kecelakaan-tgl_bulan').hide()
            $('#div-morbiditas-pasien-rawat-jalan-rumah-sakit-penyebab-kecelakaan-tgl_tahun').show()
        }
    })

    $('#pengunjungrumahsakit-jenis_laporan').on('change', function (e) {
        if ($('#PengunjungRumahSakit_jenis_laporan_0').prop('checked')) {
            $('#div-pengunjung-rumah-sakit-tgl_bulan').hide()
            $('#div-pengunjung-rumah-sakit-tgl_tahun').hide()
            $('#div-pengunjung-rumah-sakit-tgl_hari').show()
        } else if ($('#PengunjungRumahSakit_jenis_laporan_1').prop('checked')) {
            $('#div-pengunjung-rumah-sakit-tgl_hari').hide()
            $('#div-pengunjung-rumah-sakit-tgl_tahun').hide()
            $('#div-pengunjung-rumah-sakit-tgl_bulan').show()
        } else if ($('#PengunjungRumahSakit_jenis_laporan_2').prop('checked')) {
            $('#div-pengunjung-rumah-sakit-tgl_hari').hide()
            $('#div-pengunjung-rumah-sakit-tgl_bulan').hide()
            $('#div-pengunjung-rumah-sakit-tgl_tahun').show()
        }
    })

    $('#kunjunganrawtjalan-jenis_laporan').on('change', function (e) {
        if ($('#KunjunganRawatJalan_jenis_laporan_0').prop('checked')) {
            $('#div-kunjungan-rawat-jalan-tgl_bulan').hide()
            $('#div-kunjungan-rawat-jalan-tgl_tahun').hide()
            $('#div-kunjungan-rawat-jalan-tgl_hari').show()
        } else if ($('#KunjunganRawatJalan_jenis_laporan_1').prop('checked')) {
            $('#div-kunjungan-rawat-jalan-tgl_hari').hide()
            $('#div-kunjungan-rawat-jalan-tgl_tahun').hide()
            $('#div-kunjungan-rawat-jalan-tgl_bulan').show()
        } else if ($('#KunjunganRawatJalan_jenis_laporan_2').prop('checked')) {
            $('#div-kunjungan-rawat-jalan-tgl_hari').hide()
            $('#div-kunjungan-rawat-jalan-tgl_bulan').hide()
            $('#div-kunjungan-rawat-jalan-tgl_tahun').show()
        }
    })

    $('#daftarpenyakitbesarrawatinap-jenis_laporan').on('change', function (e) {
        if ($('#DaftarPenyakitBesarRawatInap_jenis_laporan_0').prop('checked')) {
            $('#div-daftar-penyakit-besar-rawat-inap-tgl_bulan').hide()
            $('#div-daftar-penyakit-besar-rawat-inap-tgl_tahun').hide()
            $('#div-daftar-penyakit-besar-rawat-inap-tgl_hari').show()
        } else if ($('#DaftarPenyakitBesarRawatInap_jenis_laporan_1').prop('checked')) {
            $('#div-daftar-penyakit-besar-rawat-inap-tgl_hari').hide()
            $('#div-daftar-penyakit-besar-rawat-inap-tgl_tahun').hide()
            $('#div-daftar-penyakit-besar-rawat-inap-tgl_bulan').show()
        } else if ($('#DaftarPenyakitBesarRawatInap_jenis_laporan_2').prop('checked')) {
            $('#div-daftar-penyakit-besar-rawat-inap-tgl_hari').hide()
            $('#div-daftar-penyakit-besar-rawat-inap-tgl_bulan').hide()
            $('#div-daftar-penyakit-besar-rawat-inap-tgl_tahun').show()
        }
    })
   
    $('#daftarpenyakitbesarrawatjalan-jenis_laporan').on('change', function (e) {
        if ($('#DaftarPenyakitBesarRawatJalan_jenis_laporan_0').prop('checked')) {
            $('#div-daftar-penyakit-besar-rawat-jalan-tgl_bulan').hide()
            $('#div-daftar-penyakit-besar-rawat-jalan-tgl_tahun').hide()
            $('#div-daftar-penyakit-besar-rawat-jalan-tgl_hari').show()
        } else if ($('#DaftarPenyakitBesarRawatJalan_jenis_laporan_1').prop('checked')) {
            $('#div-daftar-penyakit-besar-rawat-jalan-tgl_hari').hide()
            $('#div-daftar-penyakit-besar-rawat-jalan-tgl_tahun').hide()
            $('#div-daftar-penyakit-besar-rawat-jalan-tgl_bulan').show()
        } else if ($('#DaftarPenyakitBesarRawatJalan_jenis_laporan_2').prop('checked')) {
            $('#div-daftar-penyakit-besar-rawat-jalan-tgl_hari').hide()
            $('#div-daftar-penyakit-besar-rawat-jalan-tgl_bulan').hide()
            $('#div-daftar-penyakit-besar-rawat-jalan-tgl_tahun').show()
        }
    })

   

   
})