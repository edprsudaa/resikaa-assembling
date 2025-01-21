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
    $('#analisadokumen-jenis_laporan').on('change', function (e) {
        if ($('#AnalisaDokumen_jenis_laporan_0').prop('checked')) {
            $('#div-analisa-dokumen-tgl_bulan').hide()
            $('#div-analisa-dokumen-tgl_tahun').hide()
            $('#div-analisa-dokumen-tgl_hari').show()
        } else if ($('#AnalisaDokumen_jenis_laporan_1').prop('checked')) {
            $('#div-analisa-dokumen-tgl_hari').hide()
            $('#div-analisa-dokumen-tgl_tahun').hide()
            $('#div-analisa-dokumen-tgl_bulan').show()
        } else if ($('#AnalisaDokumen_jenis_laporan_2').prop('checked')) {
            $('#div-analisa-dokumen-tgl_hari').hide()
            $('#div-analisa-dokumen-tgl_bulan').hide()
            $('#div-analisa-dokumen-tgl_tahun').show()
        }
    })

    $('#analisadokumen-tipe_laporan').on('change', function (e) {
        if ($('#AnalisaDokumen_tipe_laporan_0').prop('checked')) {
            $('#div-analisa-dokumen-unit_id').hide()
            $("#analisadokumen-unit_id").val('').change();
            $("#analisadokumen-dokter_id").val('').change();
            
            $('#div-analisa-dokumen-dokter_id').hide()
        } else if ($('#AnalisaDokumen_tipe_laporan_1').prop('checked')) {
            $('#div-analisa-dokumen-dokter_id').hide()
            $("#analisadokumen-dokter_id").val('').change();
            $('#div-analisa-dokumen-unit_id').show()

        } else if ($('#AnalisaDokumen_tipe_laporan_2').prop('checked')) {
            $('#div-analisa-dokumen-unit_id').hide()
            $("#analisadokumen-unit_id").val('').change();
            $('#div-analisa-dokumen-dokter_id').show()
        }
    })

   
})