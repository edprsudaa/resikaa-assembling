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
    $('#laporancoder-jenis_laporan').on('change', function (e) {
        if ($('#LaporanCoder_jenis_laporan_0').prop('checked')) {
            $('#div-analisa-dokumen-tgl_bulan').hide()
            $('#div-analisa-dokumen-tgl_tahun').hide()
            $('#div-analisa-dokumen-tgl_hari').show()
        } else if ($('#LaporanCoder_jenis_laporan_1').prop('checked')) {
            $('#div-analisa-dokumen-tgl_hari').hide()
            $('#div-analisa-dokumen-tgl_tahun').hide()
            $('#div-analisa-dokumen-tgl_bulan').show()
        } else if ($('#LaporanCoder_jenis_laporan_2').prop('checked')) {
            $('#div-analisa-dokumen-tgl_hari').hide()
            $('#div-analisa-dokumen-tgl_bulan').hide()
            $('#div-analisa-dokumen-tgl_tahun').show()
        }
    })

    $('#laporancoder-tipe_laporan').on('change', function (e) {
        if ($('#LaporanCoder_tipe_laporan_0').prop('checked')) {
            $('#div-analisa-dokumen-unit_id').hide()
            $("#laporancoder-unit_id").val('').change();
            $("#laporancoder-coder_id").val('').change();
            
            $('#div-analisa-dokumen-coder_id').hide()
        } else if ($('#LaporanCoder_tipe_laporan_1').prop('checked')) {
            $('#div-analisa-dokumen-coder_id').hide()
      
            $('#div-analisa-dokumen-coder_id').show()

        } else if ($('#LaporanCoder_tipe_laporan_2').prop('checked')) {
            $('#div-analisa-dokumen-unit_id').hide()
            $("#laporancoder-unit_id").val('').change();
            $('#div-analisa-dokumen-coder_id').show()
        }
    })

   
})