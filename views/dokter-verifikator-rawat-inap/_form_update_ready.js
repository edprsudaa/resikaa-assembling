$(".btn-cetak-rme").on("click", function () {
  let url = $(this).data("url");
  $.get(url, function (data) {
    let res = JSON.parse(data);
    // console.log(res);
    if (res.status) {
      let w = window.open(res.data.url, "", "height=1000,width=700");

      if (window.focus) {
        w.focus();
      } else {
        fmsg.w("Dokumen Gagal Dicetak");
      }
    } else {
      fmsg.w(`${res.message}, ${res.error}`);
    }
  });
});

$("#jam-mulai").on("input", function () {
  var waktuMulai = $("#jam-mulai").val();
  var waktuSelesai = $("#jam-selesai").val();

  var mulaiSplit = waktuMulai.split(":");
  var selesaiSplit = waktuSelesai.split(":");

  var jamMulai = parseInt(mulaiSplit[0]);
  var menitMulai = parseInt(mulaiSplit[1]);
  var jamSelesai = parseInt(selesaiSplit[0]);
  var menitSelesai = parseInt(selesaiSplit[1]);

  var hours = jamSelesai - jamMulai;
  var minutes = menitSelesai - menitMulai;

  if (minutes < 0) {
    hours--;
    minutes += 60;
  }

  if (hours < 0) {
    hours += 24; // Menambahkan 24 jam jika waktu selesai lebih kecil dari waktu mulai
  }

  hours = hours.toString().length < 2 ? "0" + hours : hours;
  minutes = minutes.toString().length < 2 ? "0" + minutes : minutes;

  if (waktuSelesai) {
    if (hours == "00") {
      $("#selisih").val(minutes + " Menit");
    } else {
      $("#selisih").val(hours + " Jam " + minutes + " Menit");
    }
  } else {
    $("#selisih").val("Silahkan isi jam selesai!");
  }
});

$("#jam-selesai").on("input", function () {
  var waktuMulai = $("#jam-mulai").val();
  var waktuSelesai = $("#jam-selesai").val();

  var mulaiSplit = waktuMulai.split(":");
  var selesaiSplit = waktuSelesai.split(":");

  var jamMulai = parseInt(mulaiSplit[0]);
  var menitMulai = parseInt(mulaiSplit[1]);
  var jamSelesai = parseInt(selesaiSplit[0]);
  var menitSelesai = parseInt(selesaiSplit[1]);

  var hours = jamSelesai - jamMulai;
  var minutes = menitSelesai - menitMulai;

  if (minutes < 0) {
    hours--;
    minutes += 60;
  }

  if (hours < 0) {
    hours += 24; // Menambahkan 24 jam jika waktu selesai lebih kecil dari waktu mulai
  }

  hours = hours.toString().length < 2 ? "0" + hours : hours;
  minutes = minutes.toString().length < 2 ? "0" + minutes : minutes;

  if (waktuMulai) {
    if (hours == "00") {
      $("#selisih").val(minutes + " Menit");
    } else {
      $("#selisih").val(hours + " Jam " + minutes + " Menit");
    }
  } else {
    $("#selisih").val("Silahkan isi jam mulai!");
  }
});

$(document).ready(function () {
  $("#lap")
    .on("beforeSubmit", function (e) {
      e.preventDefault();
      let mulai = $("#jam-mulai").val();
      let selesai = $("#jam-selesai").val();

      if (mulai != "" && selesai != "") {
        var btn = $(".btn-submit");
        fbtn.setLoading(btn, "proses...");
        var post_data = $(this).serialize();
        var subid = btn.attr("data-subid");
        var url_update_draf = `${baseUrl}/dokter-verifikator-rawat-inap/save-update?subid=${subid}`;
        var url_update_final = `${baseUrl}/dokter-verifikator-rawat-inap/save-update-final?subid=${subid}`;
        var url_update_batal = `${baseUrl}/dokter-verifikator-rawat-inap/save-update-batal?subid=${subid}`;
        $.ajax({
          url: url_update_draf,
          type: "post",
          dataType: "json",
          data: post_data,
          beforeSend: function (e) {
            fbtn.setLoading(btn, "proses...");
            $(".btn").attr("disabled", true);
          },
          success: function (data) {
            if (data.status) {
              if (data.data.konfirm_final) {
                Swal.fire({
                  title: "Anda Yakin ?",
                  text: "Yakin Simpan Final, Karna Dengan ini Anda Tidak Dapat Melakukan Perubahan Lagi?",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonText: "Ya!",
                  cancelButtonText: "Tidak!",
                  customClass: {
                    confirmButton: "btn btn-success mt-2",
                    cancelButton: "btn btn-danger ml-2 mt-2",
                  },
                  buttonsStyling: false,
                  // showLoaderOnConfirm: true,
                }).then(function (t) {
                  t.value
                    ? //AJAX SAVE FINAL
                      $.ajax({
                        url: url_update_final,
                        type: "post",
                        dataType: "json",
                        data: post_data,
                        beforeSend: function (e) {
                          fbtn.setLoading(btn, "proses...");
                          $(".btn").attr("disabled", true);
                        },
                        success: function (data) {
                          if (data.status) {
                            fmsg.s(data.msg);
                            // $.pjax.reload({
                            //   container: "#pjform",
                            //   timeout: false,
                            // });
                            location.reload(); //redirect ke index
                          } else {
                            if (data.data) {
                              fmsg.w(
                                data.msg + " : " + JSON.stringify(data.data)
                              );
                            } else {
                              fmsg.w(data.msg);
                            }
                          }
                        },
                        complete: function (e) {
                          fbtn.resetLoading(
                            btn,
                            '<i class="fas fa-save"></i> Simpan'
                          );
                          $(".btn").attr("disabled", false);
                        },
                      })
                    : t.dismiss === Swal.DismissReason.cancel;
                });
              } else if (data.data.konfirm_batal) {
                Swal.fire({
                  title: "Anda Yakin ?",
                  text: "Yakin Simpan Batalkan, Karna Dengan ini Anda Tidak Dapat Melakukan Perubahan Lagi?",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonText: "Ya!",
                  cancelButtonText: "Tidak!",
                  customClass: {
                    confirmButton: "btn btn-success mt-2",
                    cancelButton: "btn btn-danger ml-2 mt-2",
                  },
                  buttonsStyling: false,
                  // showLoaderOnConfirm: true,
                }).then(function (t) {
                  t.value
                    ? //AJAX SAVE BATALKAN
                      $.ajax({
                        url: url_update_batal,
                        type: "post",
                        dataType: "json",
                        data: post_data,
                        beforeSend: function (e) {
                          fbtn.setLoading(btn, "proses...");
                          $(".btn").attr("disabled", true);
                        },
                        success: function (data) {
                          if (data.status) {
                            fmsg.s(data.msg);
                            $.pjax.reload({
                              container: "#pjform",
                              timeout: false,
                            });
                          } else {
                            if (data.data) {
                              fmsg.w(
                                data.msg + " : " + JSON.stringify(data.data)
                              );
                            } else {
                              fmsg.w(data.msg);
                            }
                          }
                        },
                        complete: function (e) {
                          fbtn.resetLoading(
                            btn,
                            '<i class="fas fa-save"></i> Simpan'
                          );
                          $(".btn").attr("disabled", false);
                        },
                      })
                    : t.dismiss === Swal.DismissReason.cancel;
                });
              } else {
                //msg success save draf
                fmsg.s(data.msg);
                $.pjax.reload({ container: "#pjform", timeout: false }); //pjax form
              }
            } else {
              if (data.data) {
                fmsg.w(data.msg + " : " + JSON.stringify(data.data));
              } else {
                fmsg.w(data.msg);
              }
            }
          },
          complete: function (e) {
            fbtn.resetLoading(btn, '<i class="fas fa-save"></i> Simpan');
            $(".btn").attr("disabled", false);
          },
        });
      } else {
        Swal.fire({
          title: "Gagal Menyimpan!",
          text: "Silahkan Lengkapi Jam Mulai dan Jam Selesai Terlebih Dahulu!",
          icon: "error",
          showConfirmButton: false,
          showCancelButton: true,
          buttonsStyling: false,
          cancelButtonText: "Ya, Akan saya lengkapi",
          customClass: {
            cancelButton: "btn btn-danger",
          },
        });
      }
    })
    .on("submit", function (e) {
      e.preventDefault();
    });

  $(document).on("click", ".btn-hapus-draf", function (e) {
    e.preventDefault;
    e.stopImmediatePropagation();
    var obj_url = $(this).data("url");
    Swal.fire({
      title: "Anda Yakin ?",
      text: "Yakin Hapus, Karna Dengan ini Data Tidak Akan Ditampilkan Lagi ?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya!",
      cancelButtonText: "Tidak!",
      customClass: {
        confirmButton: "btn btn-success mt-2",
        cancelButton: "btn btn-danger ml-2 mt-2",
      },
      buttonsStyling: false,
      // showLoaderOnConfirm: true,
    }).then(function (t) {
      t.value
        ? $.ajax({
            url: obj_url,
            type: "get",
            beforeSend: function (e) {
              fbtn.setLoading($(this), "proses...");
              $(".btn").attr("disabled", true);
            },
            success: function (data) {
              console.log(data);
              if (data.status) {
                fmsg.s(data.msg);
                //redirect ke index
                window.location.href = `${baseUrl}/dokter-verifikator-rawat-inap/index?id=${data.data.id}`;
                // location.reload();
              } else {
                fmsg.w(data.msg);
              }
            },
            complete: function (e) {
              fbtn.resetLoading(
                $(this),
                '<i class="fas fa-trash-alt"></i> Hapus'
              );
              $(".btn").attr("disabled", false);
            },
          })
        : t.dismiss === Swal.DismissReason.cancel;
    });
  });

  $(".btn-segarkan").on("click", function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    $.pjax.reload({ container: "#pjform", timeout: false }); //pjax form
  });
});
