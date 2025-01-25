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
  $("#analisadokumen-jenis_laporan").on("change", function (e) {
    if ($("#AnalisaDokumen_jenis_laporan_0").prop("checked")) {
      $("#div-analisa-dokumen-tgl_bulan").hide();
      $("#div-analisa-dokumen-tgl_tahun").hide();
      $("#div-analisa-dokumen-tgl_hari").show();
    } else if ($("#AnalisaDokumen_jenis_laporan_1").prop("checked")) {
      $("#div-analisa-dokumen-tgl_hari").hide();
      $("#div-analisa-dokumen-tgl_tahun").hide();
      $("#div-analisa-dokumen-tgl_bulan").show();
    } else if ($("#AnalisaDokumen_jenis_laporan_2").prop("checked")) {
      $("#div-analisa-dokumen-tgl_hari").hide();
      $("#div-analisa-dokumen-tgl_bulan").hide();
      $("#div-analisa-dokumen-tgl_tahun").show();
    }
  });

  $("#analisadokumen-tipe_laporan").on("change", function (e) {
    if ($("#AnalisaDokumen_tipe_laporan_0").prop("checked")) {
      $("#div-analisa-dokumen-unit_id").hide();
      $("#analisadokumen-unit_id").val("").change();
      $("#analisadokumen-dokter_id").val("").change();

      $("#div-analisa-dokumen-dokter_id").hide();
    } else if ($("#AnalisaDokumen_tipe_laporan_1").prop("checked")) {
      $("#div-analisa-dokumen-dokter_id").hide();
      $("#analisadokumen-dokter_id").val("").change();
      $("#div-analisa-dokumen-unit_id").show();
    } else if ($("#AnalisaDokumen_tipe_laporan_2").prop("checked")) {
      $("#div-analisa-dokumen-unit_id").hide();
      $("#analisadokumen-unit_id").val("").change();
      $("#div-analisa-dokumen-dokter_id").show();
    }
  });
  $("#laporananalisarawatjalan-jenis_laporan").on("change", function (e) {
    if ($("#LaporanAnalisaRawatJalan_jenis_laporan_0").prop("checked")) {
      $("#div-analisa-dokumen-rawat-jalan-tgl_bulan").hide();
      $("#div-analisa-dokumen-rawat-jalan-tgl_tahun").hide();
      $("#div-analisa-dokumen-rawat-jalan-tgl_hari").show();
    } else if ($("#LaporanAnalisaRawatJalan_jenis_laporan_1").prop("checked")) {
      $("#div-analisa-dokumen-rawat-jalan-tgl_hari").hide();
      $("#div-analisa-dokumen-rawat-jalan-tgl_tahun").hide();
      $("#div-analisa-dokumen-rawat-jalan-tgl_bulan").show();
    } else if ($("#LaporanAnalisaRawatJalan_jenis_laporan_2").prop("checked")) {
      $("#div-analisa-dokumen-rawat-jalan-tgl_hari").hide();
      $("#div-analisa-dokumen-rawat-jalan-tgl_bulan").hide();
      $("#div-analisa-dokumen-rawat-jalan-tgl_tahun").show();
    }
  });

  $("#laporananalisarawatjalan-tipe_laporan").on("change", function (e) {
    if ($("#LaporanAnalisaRawatJalan_tipe_laporan_0").prop("checked")) {
      $("#div-analisa-dokumen-rawat-jalan-unit_id").hide();
      $("#laporananalisarawatjalan-unit_id").val("").change();
      $("#laporananalisarawatjalan-dokter_id").val("").change();

      $("#div-analisa-dokumen-rawat-jalan-dokter_id").hide();
    } else if ($("#LaporanAnalisaRawatJalan_tipe_laporan_1").prop("checked")) {
      $("#div-analisa-dokumen-rawat-jalan-dokter_id").hide();
      $("#laporananalisarawatjalan-dokter_id").val("").change();
      $("#div-analisa-dokumen-rawat-jalan-unit_id").show();
    } else if ($("#LaporanAnalisaRawatJalan_tipe_laporan_2").prop("checked")) {
      $("#div-analisa-dokumen-rawat-jalan-unit_id").hide();
      $("#laporananalisarawatjalan-unit_id").val("").change();
      $("#div-analisa-dokumen-rawat-jalan-dokter_id").show();
    }
  });
  $("#laporananalisaigd-jenis_laporan").on("change", function (e) {
    if ($("#LaporanAnalisaIgd_jenis_laporan_0").prop("checked")) {
      $("#div-analisa-dokumen-igd-tgl_bulan").hide();
      $("#div-analisa-dokumen-igd-tgl_tahun").hide();
      $("#div-analisa-dokumen-igd-tgl_hari").show();
    } else if ($("#LaporanAnalisaIgd_jenis_laporan_1").prop("checked")) {
      $("#div-analisa-dokumen-igd-tgl_hari").hide();
      $("#div-analisa-dokumen-igd-tgl_tahun").hide();
      $("#div-analisa-dokumen-igd-tgl_bulan").show();
    } else if ($("#LaporanAnalisaIgd_jenis_laporan_2").prop("checked")) {
      $("#div-analisa-dokumen-igd-tgl_hari").hide();
      $("#div-analisa-dokumen-igd-tgl_bulan").hide();
      $("#div-analisa-dokumen-igd-tgl_tahun").show();
    }
  });

  $("#laporananalisaigd-tipe_laporan").on("change", function (e) {
    if ($("#LaporanAnalisaIgd_tipe_laporan_0").prop("checked")) {
      $("#div-analisa-dokumen-igd-unit_id").hide();
      $("#laporananalisaigd-unit_id").val("").change();
      $("#laporananalisaigd-dokter_id").val("").change();

      $("#div-analisa-dokumen-igd-dokter_id").hide();
    } else if ($("#LaporanAnalisaIgd_tipe_laporan_1").prop("checked")) {
      $("#div-analisa-dokumen-igd-dokter_id").hide();
      $("#laporananalisaigd-dokter_id").val("").change();
      $("#div-analisa-dokumen-igd-unit_id").show();
    } else if ($("#LaporanAnalisaIgd_tipe_laporan_2").prop("checked")) {
      $("#div-analisa-dokumen-igd-unit_id").hide();
      $("#laporananalisaigd-unit_id").val("").change();
      $("#div-analisa-dokumen-igd-dokter_id").show();
    }
  });

  $("#laporanketidaktepatanwaktu-jenis_laporan").on("change", function (e) {
    if ($("#LaporanKetidakTepatanWaktu_jenis_laporan_0").prop("checked")) {
      $("#div-ketidaktepatan-waktu-tgl_bulan").hide();
      $("#div-ketidaktepatan-waktu-tgl_tahun").hide();
      $("#div-ketidaktepatan-waktu-tgl_hari").show();
    } else if (
      $("#LaporanKetidakTepatanWaktu_jenis_laporan_1").prop("checked")
    ) {
      $("#div-ketidaktepatan-waktu-tgl_hari").hide();
      $("#div-ketidaktepatan-waktu-tgl_tahun").hide();
      $("#div-ketidaktepatan-waktu-tgl_bulan").show();
    } else if (
      $("#LaporanKetidakTepatanWaktu_jenis_laporan_2").prop("checked")
    ) {
      $("#div-ketidaktepatan-waktu-tgl_hari").hide();
      $("#div-ketidaktepatan-waktu-tgl_bulan").hide();
      $("#div-ketidaktepatan-waktu-tgl_tahun").show();
    }
  });

  $("#laporanketidaktepatanwaktu-tipe_laporan").on("change", function (e) {
    if ($("#LaporanKetidakTepatanWaktu_tipe_laporan_0").prop("checked")) {
      $("#div-ketidaktepatan-waktu-unit_id").hide();
      $("#laporanketidaktepatanwaktu-unit_id").val("").change();
      $("#laporanketidaktepatanwaktu-dokter_id").val("").change();

      $("#div-ketidaktepatan-waktu-dokter_id").hide();
    } else if (
      $("#LaporanKetidakTepatanWaktu_tipe_laporan_1").prop("checked")
    ) {
      $("#div-ketidaktepatan-waktu-dokter_id").hide();
      $("#laporanketidaktepatanwaktu-dokter_id").val("").change();
      $("#div-ketidaktepatan-waktu-unit_id").show();
    } else if (
      $("#LaporanKetidakTepatanWaktu_tipe_laporan_2").prop("checked")
    ) {
      $("#div-ketidaktepatan-waktu-unit_id").hide();
      $("#laporanketidaktepatanwaktu-unit_id").val("").change();
      $("#div-ketidaktepatan-waktu-dokter_id").show();
    }
  });
});
