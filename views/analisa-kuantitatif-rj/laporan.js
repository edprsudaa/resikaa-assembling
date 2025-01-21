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
  $("#analisadokumenrj-jenis_laporan").on("change", function (e) {
    if ($("#AnalisaDokumenRj_jenis_laporan_0").prop("checked")) {
      $("#div-analisa-dokumen-tgl_bulan").hide();
      $("#div-analisa-dokumen-tgl_tahun").hide();
      $("#div-analisa-dokumen-tgl_hari").show();
    } else if ($("#AnalisaDokumenRj_jenis_laporan_1").prop("checked")) {
      $("#div-analisa-dokumen-tgl_hari").hide();
      $("#div-analisa-dokumen-tgl_tahun").hide();
      $("#div-analisa-dokumen-tgl_bulan").show();
    } else if ($("#AnalisaDokumenRj_jenis_laporan_2").prop("checked")) {
      $("#div-analisa-dokumen-tgl_hari").hide();
      $("#div-analisa-dokumen-tgl_bulan").hide();
      $("#div-analisa-dokumen-tgl_tahun").show();
    }
  });

  $("#analisadokumenrj-tipe_laporan").on("change", function (e) {
    if ($("#AnalisaDokumenRj_tipe_laporan_0").prop("checked")) {
      $("#div-analisa-dokumen-unit_id").hide();
      $("#analisadokumenrj-unit_id").val("").change();
      $("#analisadokumenrj-dokter_id").val("").change();

      $("#div-analisa-dokumen-dokter_id").hide();
    } else if ($("#AnalisaDokumenRj_tipe_laporan_1").prop("checked")) {
      $("#div-analisa-dokumen-dokter_id").hide();
      $("#analisadokumenrj-dokter_id").val("").change();
      $("#div-analisa-dokumen-unit_id").show();
    } else if ($("#AnalisaDokumenRj_tipe_laporan_2").prop("checked")) {
      $("#div-analisa-dokumen-unit_id").hide();
      $("#analisadokumenrj-unit_id").val("").change();
      $("#div-analisa-dokumen-dokter_id").show();
    }
  });
});
