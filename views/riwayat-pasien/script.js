var wrap_kedudukan_keluarga = $(".wrap-kedudukan-keluarga");
var wrap_anak_istri = $(".wrap-anak-istri");
var wrap_pasangan = $(".wrap-pasangan");
var wrap_jml_anak = $(".wrap-jml-anak");
var site_controller = "/site/";
var pasien_controller = "/pasien/";
var sep_controller = "/sep/";
var analisa_kuantitatif_controller = "/analisa-kuantitatif/";
var filing_peminjaman_controller = "/filing-peminjaman/";
var analisa_dokumen_controller = "/analisa-dokumen/";
var analisa_kuantitatif_controller = "/analisa-kuantitatif/";
var penanggung_controller = "/penanggung/";
var cetak_controller = "/cetak/";
var rawatinap_controller = "/rawat-inap/";


function formModalShow(obj) {
  if (obj.loading) {
    setLoadingBtn(obj.loading.btn, obj.loading.txt ? obj.loading.txt : "");
  }
  $.ajax({
    url: obj.url,
    type: "post",
    dataType: "html",
    data: obj.data ? obj.data : "",
    success: function (result) {
      $(obj.modal ? (obj.modal.id ? obj.modal.id : "#mymodal") : "#mymodal")
        .html(result)
        .modal(
          obj.modal ? (obj.modal.config ? obj.modal.config : "show") : "show"
        );
      if (obj.loading) {
        resetLoadingBtn(obj.loading.btn, obj.loading.html);
      }
    },
    error: function (xhr, status, error) {
      errorMsg(error);
      if (obj.loading) {
        resetLoadingBtn(obj.loading.btn, obj.loading.html);
      }
    },
  });
}

//list pasien
$(".btn-list-registrasi").click(function (e) {
  e.preventDefault();
  var btn = $(this);
  var htm = btn.html();
  formModalShow({
    url: base_url + filing_distribusi_controller + "registrasi-list",
    loading: { btn: btn, html: htm },
  });
});
$(".btn-list-checkout").click(function (e) {
  e.preventDefault();
  var btn = $(this);
  var htm = btn.html();
  formModalShow({
    url: base_url + analisa_dokumen_controller + "checkout-list",
    loading: { btn: btn, html: htm },
  });
});

//list pasien
$(".btn-list-peminjaman").click(function (e) {
  e.preventDefault();
  var btn = $(this);
  var htm = btn.html();
  formModalShow({
    url: base_url + filing_distribusi_controller + "peminjaman-list",
    loading: { btn: btn, html: htm },
  });
});

//riwayat kunjungan
$(".btn-riwayat-kunjungan").click(function (e) {
  e.preventDefault();
  var rm = getRm();
  var btn = $(this);
  var htm = btn.html();
  formModal({
    url: base_url + pasien_controller + "riwayat-kunjungan",
    data: { rm: rm },
    loading: { btn: btn, html: htm },
  });
});
// Pencarian Tracer - Searching RM
$("#pencari-tracer-search-form")
  .on("beforeSubmit", function (e) {
    e.preventDefault();
    searchPencariTracer();
  })
  .on("submit", function (e) {
    e.preventDefault();
  });

function searchPencariTracer(data) {
  var form = $("#pencari-tracer-search-form");
  var el = form.find("input[name='noregistrasi']");
  var nomor = el.val();
  if (nomor) {
    var btn = $(".btn-search-pasien");
    var htm = btn.html();
    setLoadingBtn(btn, "Mencari...");
    $.ajax({
      url: base_url + filing_distribusi_controller + "pencari-tracer-search",
      type: "post",
      dataType: "json",
      data: form.serialize(),
      success: function (result) {
        // console.log(result.data.registrasi.layanan[0].unit.unt_nama);
        if (result.status) {
          setFormPencariTracer(result.data.registrasi);
          successMsg(result.msg);
        } else {
          errorMsg(result.msg);
        }
        resetLoadingBtn(btn, htm);
      },
      error: function (xhr, status, error) {
        errorMsg(error);
        resetLoadingBtn(btn, htm);
      },
    });
  } else {
    el.focus();
    errorMsg("Silahkan isi no. rekam medis atau no. identitas pasien !");
  }
}

$("#analisa-kuantitatif-form")
  .on("beforeSubmit", function (e) {
    e.preventDefault();
    var btn = $(".btn-pencari-tracer-submit");
    var htm = btn.html();
    $.ajax({
      url: base_url + analisa_kuantitatif_controller + "save",
      type: "post",
      dataType: "json",
      data: $(this).serialize(),
      success: function (result) {
        if (result.status) {
          // setRm(result.rm);
          // $('#registrasi-kunjungan').val(result.kunjungan);
          console.log(result.msg);
          if (result.status == true) {
            setTimeout(function () {
              window.location =
                base_url +
                filing_distribusi_controller +
                "pencari-tracer-list-all";
            }, 2000);
          }
        } else {
          console.log(result.msg);
        }
        console.log(btn, htm);
      },
      error: function (xhr, status, error) {
        console.log(error);
        console.log(btn, htm);
      },
    });
  })
  .on("submit", function (e) {
    e.preventDefault();
  });
//pencarian registrasi pasien
$("#registrasi-search-form")
  .on("beforeSubmit", function (e) {
    e.preventDefault();
    searchRegistrasi();
  })
  .on("submit", function (e) {
    e.preventDefault();
  });

$("#distribusi-registrasi-search-form")
  .on("beforeSubmit", function (e) {
    e.preventDefault();
    searchDistribusiRegistrasi();
  })
  .on("submit", function (e) {
    e.preventDefault();
  });

$("#distribusi-peminjaman-search-form")
  .on("beforeSubmit", function (e) {
    e.preventDefault();
    searchDistribusiPeminjaman();
  })
  .on("submit", function (e) {
    e.preventDefault();
  });

$("#registrasi-distribusi-search-form")
  .on("beforeSubmit", function (e) {
    e.preventDefault();
    searchRegistrasiDistribusi();
  })
  .on("submit", function (e) {
    e.preventDefault();
  });

//pencarian pasien
$("#peminjaman-search-form")
  .on("beforeSubmit", function (e) {
    e.preventDefault();
    searchPeminjaman();
  })
  .on("submit", function (e) {
    e.preventDefault();
  });

//Search Peminjaman
function searchPeminjaman(data) {
  var form = $("#peminjaman-search-form");
  var el = form.find("input[name='nopeminjaman']");
  var nomor = el.val();
  if (nomor) {
    var btn = $(".btn-search-peminjaman");
    var htm = btn.html();
    setLoadingBtn(btn, "Mencari...");
    $.ajax({
      url: base_url + filing_distribusi_controller + "peminjaman-search",
      type: "post",
      dataType: "json",
      data: form.serialize(),
      success: function (result) {
        if (result.status) {
          // console.log(result);
          setFormPeminjamanDokumen(result.data.peminjaman);
          successMsg(result.msg);
        } else {
          errorMsg(result.msg);
        }
        resetLoadingBtn(btn, htm);
      },
      error: function (xhr, status, error) {
        errorMsg(error);
        resetLoadingBtn(btn, htm);
      },
    });
  } else {
    el.focus();
    errorMsg("Silahkan isi no. peminjaman dokumen pasien !");
  }
}

//set form pencarian tracer
function setFormPeminjamanDokumen(data) {
  // console.log(data);
  if (data) {
    var form = $("#distribusi-peminjaman-form");
    $.each(data.peminjaman, function (i, v) {
      if (i == "fp_alasan_peminjaman") {
        form.find("input[name='Distribusi[alasan_peminjaman]']").val(v);
      }
      if (i == "fp_alasan_peminjaman") {
        form.find("input[name='Distribusi[alasan_peminjaman]']").val(v);
      }
    });
    if (data.peminjaman.pegawai) {
      $.each(data.peminjaman.pegawai, function (i, v) {
        // console.log(i);
        if (i == "pgw_nama") {
          form.find("input[name='Distribusi[peminjam_dokumen]']").val(v);
        }
      });
    }
    if (data.peminjaman.unit) {
      $.each(data.peminjaman.unit, function (i, v) {
        // console.log(i);
        if (i == "unt_nama") {
          form.find("input[name='Distribusi[poli]']").val(v);
        }
      });
    }
    $.each(data.pasien, function (i, v) {
      if (i == "ps_kode") {
        form.find("input[name='Distribusi[fd_pasien_kode]']").val(v);
      }
      if (i == "ps_nama") {
        form.find("input[name='Distribusi[ps_nama]']").val(v);
      }
    });
    $.each(data, function (i, v) {
      if (i == "fpd_peminjaman_detail_kode") {
        form.find("input[name='Distribusi[fd_reg_peminjaman]']").val(v);
      }
      if (i == "reg_kode") {
        form.find("input[name='Distribusi[fd_reg_peminjaman]']").val(v);
      }
    });
  }

  if (data.msg) {
    warningMsg(data.msg);
  }
}

function searchRegistrasi(data) {
  var form = $("#registrasi-search-form");
  var el = form.find("input[name='noregistrasi']");
  var nomor = el.val();
  if (nomor) {
    var btn = $(".btn-search-pasien");
    var htm = btn.html();
    setLoadingBtn(btn, "Mencari...");
    $.ajax({
      url: base_url + filing_distribusi_controller + "registrasi-search",
      type: "post",
      dataType: "json",
      data: form.serialize(),
      success: function (result) {
        // console.log(result.data.registrasi.layanan[0].unit.unt_nama);
        if (result.status) {
          setFormPencariTracer(result.data.registrasi);
          successMsg(result.msg);
        } else {
          errorMsg(result.msg);
        }
        resetLoadingBtn(btn, htm);
      },
      error: function (xhr, status, error) {
        errorMsg(error);
        resetLoadingBtn(btn, htm);
      },
    });
  } else {
    el.focus();
    errorMsg("Silahkan isi no. rekam medis atau no. identitas pasien !");
  }
}

function searchRegistrasiDistribusi(data) {
  var form = $("#registrasi-distribusi-search-form");
  var el = form.find("input[name='noregistrasi']");
  var nomor = el.val();
  if (nomor) {
    var btn = $(".btn-search-registrasi");
    var htm = btn.html();
    setLoadingBtn(btn, "Mencari...");
    $.ajax({
      url: base_url + filing_distribusi_controller + "registrasi-search",
      type: "post",
      dataType: "json",
      data: form.serialize(),
      success: function (result) {
        // console.log(result.data.registrasi.layanan[0].unit.unt_nama);
        if (result.status) {
          setFormRegistrasiDistribusi(result.data.registrasi);
          successMsg(result.msg);
        } else {
          errorMsg(result.msg);
        }
        resetLoadingBtn(btn, htm);
      },
      error: function (xhr, status, error) {
        errorMsg(error);
        resetLoadingBtn(btn, htm);
      },
    });
  } else {
    el.focus();
    errorMsg("Silahkan isi no. rekam medis atau no. identitas pasien !");
  }
}

function searchDistribusiRegistrasi(data) {
  var form = $("#distribusi-registrasi-search-form");
  var el = form.find("input[name='noregistrasi']");
  var nomor = el.val();
  if (nomor) {
    var btn = $(".btn-search-registrasi");
    var htm = btn.html();
    setLoadingBtn(btn, "Mencari...");
    $.ajax({
      url: base_url + filing_distribusi_controller + "registrasi-search",
      type: "post",
      dataType: "json",
      data: form.serialize(),
      success: function (result) {
        if (result.status) {
          setFormDistribusiRegistrasi(result.data.registrasi);
          successMsg(result.msg);
        } else {
          errorMsg(result.msg);
        }
        resetLoadingBtn(btn, htm);
      },
      error: function (xhr, status, error) {
        errorMsg(error);
        resetLoadingBtn(btn, htm);
      },
    });
  } else {
    el.focus();
    errorMsg("Silahkan isi no. rekam medis atau no. identitas pasien !");
  }
}

function searchDistribusiPeminjaman(data) {
  var form = $("#distribusi-peminjaman-search-form");
  var el = form.find("input[name='nopeminjaman']");
  var nomor = el.val();
  if (nomor) {
    var btn = $(".btn-search-peminjaman");
    var htm = btn.html();
    setLoadingBtn(btn, "Mencari...");
    $.ajax({
      url: base_url + filing_distribusi_controller + "peminjaman-search",
      type: "post",
      dataType: "json",
      data: form.serialize(),
      success: function (result) {
        if (result.status) {
          setFormDistribusiPeminjaman(result.data.peminjaman);
          successMsg(result.msg);
        } else {
          errorMsg(result.msg);
        }
        resetLoadingBtn(btn, htm);
      },
      error: function (xhr, status, error) {
        errorMsg(error);
        resetLoadingBtn(btn, htm);
      },
    });
  } else {
    el.focus();
    errorMsg("Silahkan isi nomor peminjamanno. identitas pasien !");
  }
}

//simpan pasien baru
$("#pasien-form")
  .on("beforeSubmit", function (e) {
    e.preventDefault();
    var btn = $(".btn-biodata-submit");
    var htm = btn.html();
    setLoadingBtn(btn, "Menyimpan...");
    $.ajax({
      url: base_url + site_controller + "biodata-save",
      type: "post",
      dataType: "json",
      data: $(this).serialize(),
      success: function (result) {
        if (result.status) {
          setRm(result.rm);
          $("#registrasi-kunjungan").val(result.kunjungan);
          successMsg(result.msg);
        } else {
          errorMsg(result.msg);
        }
        resetLoadingBtn(btn, htm);
      },
      error: function (xhr, status, error) {
        errorMsg(error);
        resetLoadingBtn(btn, htm);
      },
    });
  })
  .on("submit", function (e) {
    e.preventDefault();
  });

//simpan pasien baru

//simpan pasien baru
$("#registrasi-distribusi-form")
  .on("beforeSubmit", function (e) {
    e.preventDefault();
    var btn = $(".btn-registrasi-distribusi-submit");
    var htm = btn.html();
    setLoadingBtn(btn, "Menyimpan...");
    $.ajax({
      url:
        base_url + filing_distribusi_controller + "registrasi-distribusi-save",
      type: "post",
      dataType: "json",
      data: $(this).serialize(),
      success: function (result) {
        if (result.status) {
          // setRm(result.rm);
          // $('#registrasi-kunjungan').val(result.kunjungan);
          successMsg(result.msg);
          if (result.status == true) {
            setTimeout(function () {
              window.location =
                base_url + filing_distribusi_controller + "registrasi";
            }, 2000);
          }
        } else {
          errorMsg(result.msg);
        }
        resetLoadingBtn(btn, htm);
      },
      error: function (xhr, status, error) {
        errorMsg(error);
        resetLoadingBtn(btn, htm);
      },
    });
  })
  .on("submit", function (e) {
    e.preventDefault();
  });

$("#distribusi-peminjaman-form")
  .on("beforeSubmit", function (e) {
    e.preventDefault();
    var btn = $(".btn-peminjaman-distribusi-submit");
    var htm = btn.html();
    setLoadingBtn(btn, "Menyimpan...");
    $.ajax({
      url: base_url + filing_distribusi_controller + "peminjaman-save",
      type: "post",
      dataType: "json",
      data: $(this).serialize(),
      success: function (result) {
        if (result.status) {
          // setRm(result.rm);
          // $('#registrasi-kunjungan').val(result.kunjungan);
          successMsg(result.msg);
          if (result.status == true) {
            setTimeout(function () {
              window.location =
                base_url + filing_distribusi_controller + "peminjaman";
            }, 2000);
          }
        } else {
          errorMsg(result.msg);
        }
        resetLoadingBtn(btn, htm);
      },
      error: function (xhr, status, error) {
        errorMsg(error);
        resetLoadingBtn(btn, htm);
      },
    });
  })
  .on("submit", function (e) {
    e.preventDefault();
  });

$("#penerima-dokumen-form")
  .on("beforeSubmit", function (e) {
    e.preventDefault();

    $.ajax({
      url: base_url + filing_distribusi_controller + "penerima-dokumen-save",
      type: "post",
      dataType: "json",
      data: $(this).serialize(),
      success: function (result) {
        if (result.status) {
          // setRm(result.rm);
          // $('#registrasi-kunjungan').val(result.kunjungan);
          successMsg(result.msg);
          if (result.status == true) {
            setTimeout(function () {
              location.reload();
            }, 2000);
          }
        } else {
          errorMsg(result.msg);
        }
      },
      error: function (xhr, status, error) {
        errorMsg(error);
      },
    });
  })
  .on("submit", function (e) {
    e.preventDefault();
  });

$("#kirim-dokumen-form")
  .on("beforeSubmit", function (e) {
    e.preventDefault();

    $.ajax({
      url: base_url + filing_distribusi_controller + "kirim-dokumen-save",
      type: "post",
      dataType: "json",
      data: $(this).serialize(),
      success: function (result) {
        if (result.status) {
          // setRm(result.rm);
          // $('#registrasi-kunjungan').val(result.kunjungan);
          successMsg(result.msg);
          if (result.status == true) {
            setTimeout(function () {
              location.reload();
            }, 2000);
          }
        } else {
          errorMsg(result.msg);
        }
      },
      error: function (xhr, status, error) {
        errorMsg(error);
      },
    });
  })
  .on("submit", function (e) {
    e.preventDefault();
  });

//reset form biodata
$(".btn-biodata-reset").click(function (e) {
  e.preventDefault();
  resetFormBiodata();
});
// ---END BIODATA ---

//simpan distribusi registrasi baru
$("#distribusi-registrasi-form-id")
  .on("beforeSubmit", function (e) {
    e.preventDefault();
    var btn = $(".btn-register-distribusi-submit");
    var htm = btn.html();
    setLoadingBtn(btn, "Menyimpan...");

    $.ajax({
      url: base_url + filing_distribusi_controller + "registrasi-save",
      type: "post",
      dataType: "json",
      data: $(this).serialize(),
      success: function (result) {
        if (result.status) {
          successMsg(result.msg);
          if (result.status == true) {
            setTimeout(function () {
              location.reload();
            }, 2000);
          }
        } else {
          errorMsg(result.msg);
        }
        resetLoadingBtn(btn, htm);
      },
      error: function (xhr, status, error) {
        errorMsg(error);
        resetLoadingBtn(btn, htm);
      },
    });
  })
  .on("submit", function (e) {
    e.preventDefault();
  });

//reset form biodata
$(".btn-biodata-reset").click(function (e) {
  e.preventDefault();
  resetFormBiodata();
});

//set form pencarian tracer
function setFormPencariTracer(data) {
  if (data) {
    var form = $("#pencari-tracer-form");
    $.each(data.layanan[0].unit, function (i, v) {
      if (i == "unt_nama") {
        form.find("input[name='PencariTracer[poli]']").val(v);
      }
    });
    $.each(data.pasien, function (i, v) {
      if (i == "ps_nama") {
        form.find("input[name='PencariTracer[ps_nama]']").val(v);
      }
      if (i == "ps_kode") {
        form
          .find("input[name='PencariTracer[ps_kode]']")
          .val(v)
          .attr("readonly", true);
      }
    });
    $.each(data, function (i, v) {
      if (i == "reg_kode") {
        form.find("input[name='PencariTracer[fpt_reg_kode]']").val(v);
      }
      if (i == "reg_tgl_masuk") {
        form.find("input[name='PencariTracer[tgl_masuk]']").val(v);
      }
    });
  }

  if (data.msg) {
    warningMsg(data.msg);
  }
}

//set form pencarian tracer
function setFormRegistrasiDistribusi(data) {
  if (data) {
    var form = $("#registrasi-distribusi-form");
    $.each(data.layanan[0].unit, function (i, v) {
      if (i == "unt_nama") {
        form.find("input[name='Distribusi[poli]']").val(v);
      }
    });

    $.each(data.pasien, function (i, v) {
      if (i == "ps_nama") {
        form.find("input[name='Distribusi[ps_nama]']").val(v);
      }
      if (i == "ps_kode") {
        form
          .find("input[name='Distribusi[fd_pasien_kode]']")
          .val(v)
          .attr("readonly", true);
      }
    });
    $.each(data, function (i, v) {
      if (i == "reg_kode") {
        form.find("input[name='Distribusi[fd_reg_kode]']").val(v);
      }
      if (i == "reg_tgl_masuk") {
        form.find("input[name='Distribusi[tgl_masuk]']").val(v);
      }
    });
  }

  if (data.msg) {
    warningMsg(data.msg);
  }
}

//set form distribusi registrasi
function setFormDistribusiRegistrasi(data) {
  if (data) {
    var form = $("#distribusi-registrasi-form-id");
    if (data.layanan[0]) {
      $.each(data.layanan[0].unit, function (i, v) {
        if (i == "unt_nama") {
          form.find("input[name='Distribusi[poli]']").val(v);
        }
      });
    }
    $.each(data.pasien, function (i, v) {
      if (i == "ps_nama") {
        form.find("input[name='Distribusi[ps_nama]']").val(v);
      }
      if (i == "ps_kode") {
        form.find("input[name='Distribusi[fd_pasien_kode]']").val(v);
      }
    });
    $.each(data, function (i, v) {
      if (i == "reg_kode") {
        form.find("input[name='Distribusi[fd_reg_kode]']").val(v);
      }
      if (i == "reg_tgl_masuk") {
        form.find("input[name='Distribusi[tgl_masuk]']").val(v);
      }
    });
  }

  if (data.msg) {
    warningMsg(data.msg);
  }
}

//set form distribusi peminjaman
function setFormDistribusiPeminjaman(data) {
  if (data) {
    var form = $("#distribusi-peminjaman-form");

    $.each(data.pasien, function (i, v) {
      if (i == "ps_nama") {
        form.find("input[name='Distribusi[ps_nama]']").val(v);
      }
      if (i == "ps_kode") {
        form
          .find("input[name='Distribusi[fd_pasien_kode]']")
          .val(v)
          .attr("readonly", true);
      }
    });
    $.each(data.peminjaman, function (i, v) {
      if (i == "fp_alasan_peminjaman") {
        form.find("input[name='Distribusi[alasan_peminjaman]']").val(v);
      }
      if (i == "fp_keterangan") {
        form
          .find("input[name='Distribusi[keterangan_peminjaman]']")
          .val(v)
          .attr("readonly", true);
      }
    });
    $.each(data.peminjaman.unit, function (i, v) {
      if (i == "unt_nama") {
        form.find("input[name='Distribusi[poli]']").val(v);
      }
    });
    $.each(data.peminjaman.pegawai, function (i, v) {
      if (i == "pgw_nama") {
        form.find("input[name='Distribusi[peminjam_dokumen]']").val(v);
      }
    });
    $.each(data, function (i, v) {
      if (i == "fpd_peminjaman_detail_kode") {
        form.find("input[name='Distribusi[fd_reg_peminjaman]']").val(v);
      }
      if (i == "fpd_created_at") {
        form.find("input[name='Distribusi[tgl_peminjaman]']").val(v);
      }
    });
  }

  if (data.msg) {
    warningMsg(data.msg);
  }
}

$(".btn-pencari-tracer").click(function (e) {
  e.preventDefault();
  var btn = $(this);
  var htm = btn.html();
  formModal({
    url: base_url + filing_distribusi_controller + "pencari-tracer-form",
    loading: { btn: btn, html: htm },
  });
});
function cetakAntrian(noreg) {
  var w = window.open(
    base_url + cetak_controller + "cetak-antrian?noreg=" + noreg,
    "_blank"
  );
  if (w) {
    w.focus();
  } else {
    errorMsg(
      "Cetak SEP diblock oleh browser anda, izinkan popup untuk mencetak SEP"
    );
  }
}
$(".btn-riwayat-bpjs").click(function (e) {
  e.preventDefault();
  var btn = $(this);
  var htm = btn.html();
  var rm = getRm();
  if (rm) {
    formModal({
      url: base_url + sep_controller + "riwayat-form",
      data: { rm: rm },
      loading: { btn: btn, html: htm },
    });
  } else {
    errorMsg("Silahkan cari pasien terlebih dahulu");
  }
});
function searchRegistrasiSelesai(data) {
  if (data) {
    var btn = $(".btn-search-peminjaman");
    var htm = btn.html();
    setLoadingBtn(btn, "Mencari...");
    var kode = data;

    Swal.fire({
      title: "Apakah dokumen sudah kembali?",
      text: "Anda tidak bisa membatalkan proses ini!",
      icon: "info",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, sudah kembali!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: base_url + filing_distribusi_controller + "registrasi-selesai",
          type: "post",
          dataType: "json",
          data: { kode: kode },
          success: function (result) {
            if (result.status) {
              successMsg(result.msg);
              if (result.status == true) {
                setTimeout(function () {
                  location.reload();
                }, 2000);
              }
            } else {
              errorMsg(result.msg);
            }
            resetLoadingBtn(btn, htm);
          },
          error: function (xhr, status, error) {
            errorMsg(error);
            resetLoadingBtn(btn, htm);
          },
        });
      }
    });
  } else {
    el.focus();
    errorMsg("Silahkan isi nomor pendaftaran / no. identitas pasien !");
  }
}
function searchPeminjamanSelesai(data) {
  if (data) {
    var btn = $(".btn-search-peminjaman");
    var htm = btn.html();
    setLoadingBtn(btn, "Mencari...");
    var kode = data;
    Swal.fire({
      title: "Apakah dokumen sudah kembali?",
      text: "Anda tidak bisa membatalkan proses ini!",
      icon: "info",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, sudah kembali!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: base_url + filing_distribusi_controller + "peminjaman-selesai",
          type: "post",
          dataType: "json",
          data: { kode: kode },
          success: function (result) {
            if (result.status) {
              successMsg(result.msg);
              if (result.status == true) {
                setTimeout(function () {
                  location.reload();
                }, 2000);
              }
            } else {
              errorMsg(result.msg);
            }
            resetLoadingBtn(btn, htm);
          },
          error: function (xhr, status, error) {
            errorMsg(error);
            resetLoadingBtn(btn, htm);
          },
        });
      }
    });
  } else {
    el.focus();
    errorMsg("Silahkan isi nomor peminjaman / no. identitas pasien !");
  }
}

$(".dynamicform_wrapper").on("beforeInsert", function (e, item) {
  // console.log("beforeInsert");
});

$(".dynamicform_wrapper").on("afterInsert", function (e, item) {
  // console.log("afterInsert");
});

$(".dynamicform_wrapper").on("beforeDelete", function (e, item) {
  if (!confirm("Are you sure you want to delete this item?")) {
    return false;
  }
  return true;
});

$(".dynamicform_wrapper").on("afterDelete", function (e) {
  // console.log("Deleted item!");
});

$(".dynamicform_wrapper").on("limitReached", function (e, item) {
  alert("Limit reached");
});
