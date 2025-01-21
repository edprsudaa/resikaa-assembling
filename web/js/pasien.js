
 setTindakan()   
    function kirimLIS(layanan_id, link) {
        let dokter = $('#dokter').val()
        if (dokter == '') {
            toastr.warning('Silahkan Pilih Dokter Terlebih Dahulu')
        } else {
            window.location.href = link + layanan_id + '&type=PK'
        }
    }

    function setTindakan(link) {
        layanan = $('#id_layanan').val()
        $.ajax({
            url: '/antrian/set-tindakan-pasien',
            data: {
                layanan_id: layanan,
            },
            dataType: 'json',
            type: 'POST',
            success: function(output) {
                if (output.kode == 200) {
                    $('body').removeClass('loading');
                    toastr.success(output.pesan);
                    $('#data_tindakan_layanan').html(output.data)
                } else {
                    $('body').removeClass('loading');
                    toastr.warning(output.pesan);
                }
            }
        });
    }

    function pilihTindakan(unit, kelas, link) {
        $('body').addClass('loading');
    
        if (kelas == '') {
            kelas = "003";
        }

        if (unit === '') {
            toastr.error('Terjadi Kesalahan Pada Sistem');
            $('body').removeClass('loading');
        } else {
            if ($('#id_dokter') == '') {
                toastr.warning('Silahkan Pilih Dokter Pelayanan Terlebih Dahulu !!')
            } else {
                openPopup(link+'?unit=' + unit + '&kelas=' + kelas, '#search', '#refresh-tindakan', '#modal-id-tindakan');
                $('body').removeClass('loading');
            }
        }
    }

    function editJumlah(id, value, link) {
        $('body').addClass('loading');
        let data = id.split('_')
        let layanan = data[0]
        let tarif_tindakan = data[1]
        let harga = data[2]

        $.ajax({
            url: link,
            data: {
                layanan_id: layanan,
                tarif_tindakan_id: tarif_tindakan,
                value: value,
                harga: harga,
            },
            dataType: 'json',
            type: 'POST',
            success: function(output) {
                if (output.kode == 200) {
                    $('body').removeClass('loading');
                    toastr.success(output.message);
                    setTindakan()
                } else {
                    $('body').removeClass('loading');
                    toastr.warning(output.message);
                }
            }
        });
    }

    function editCyto(id, value, link) {
        $('body').addClass('loading');
        let data = id.split('_')
        let layanan = data[0]
        let tarif_tindakan = data[1]

        if (value == 'on') {
            value = 1
        } else {
            value = 0
        }

        $.ajax({
            url: link,
            data: {
                layanan_id: layanan,
                tarif_tindakan_id: tarif_tindakan,
                value: value,
            },
            dataType: 'json',
            type: 'POST',
            success: function(output) {
                if (output.kode == 200) {
                    $('body').removeClass('loading');
                    toastr.success(output.message);
                    setTindakan()
                } else {
                    $('body').removeClass('loading');
                    toastr.warning(output.message);
                    setTindakan()
                }
            }
        });
    }

    function hapusTindakan(id, link) {
        $('body').addClass('loading');
        let data = id.split('_')
        let layanan = data[0]
        let tarif_tindakan = data[1]

        $.ajax({
            url: link,
            data: {
                layanan_id: layanan,
                tarif_tindakan_id: tarif_tindakan,
            },
            dataType: 'json',
            type: 'POST',
            success: function(output) {
                if (output.kode == 200) {
                    $('body').removeClass('loading');
                    toastr.success(output.message);
                    setTindakan()
                } else {
                    $('body').removeClass('loading');
                    toastr.warning(output.message);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                toastr.warning(errorThrown);
            }
        });
    }

    function hapusSemuaTindakan(link) {
        $('body').addClass('loading');
        layanan = $('#id_layanan').val()

        $.post(link, {
            'layanan': layanan
        }).done(function(output) {
            let result = jQuery.parseJSON(output)
            if (result.kode == 200) {
                $('body').removeClass('loading');
                toastr.success(result.message);
                setTindakan()
            } else {
                $('body').removeClass('loading');
                toastr.warning(result.message);
            }
        })
    }

    function ubahDokter(value, link) {
        $('body').addClass('loading');
        let no_tran = $('#no_tran').val();

        $.ajax({
            url: link,
            data: {
                no_tran: no_tran,
                value: value
            },
            dataType: 'json',
            type: 'POST',
            success: function(output) {
                if (output.kode == 200) {
                    $('body').removeClass('loading');
                    toastr.success(output.message);
                    setTindakan()
                } else {
                    $('body').removeClass('loading');
                    toastr.warning(output.message);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                toastr.warning(errorThrown);
            }
        });
    }

    function ubahDokterTindakan(id, value, link) {
        $('body').addClass('loading');
        $.ajax({
            url: link,
            data: {
                id: id,
                value: value
            },
            dataType: 'json',
            type: 'POST',
            success: function(output) {
                if (output.kode == 200) {
                    $('body').removeClass('loading');
                    toastr.success(output.message);
                    setTindakan()
                } else {
                    $('body').removeClass('loading');
                    toastr.warning(output.message);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                toastr.warning(errorThrown);
            }
        });
    }