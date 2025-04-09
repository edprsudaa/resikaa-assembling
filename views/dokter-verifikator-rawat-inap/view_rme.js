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

$(document).ready(function () {
  $("#lap")
    .on("beforeSubmit", function (e) {
      e.preventDefault();

      var btn = $(".btn-submit");
      var id = btn.attr("data-subid");
      // var url_batal_rme = `${baseUrl}/laporan-operasi-pasien/batal-rme`;
      var url_batal_rme = `${baseUrl}/laporan-operasi-pasien/save-update-batal?subid=${id}`;

      Swal.fire({
        title: "Alasan Pembatalan",
        input: "text",
        inputPlaceholder: "Masukkan alasan pembatalan",
        showCancelButton: true,
        confirmButtonText: "Kirim",
        cancelButtonText: "Batal",
        inputValidator: (value) => {
          if (!value) {
            return "Alasan tidak boleh kosong!";
          }
        },
      }).then((result) => {
        if (result.isConfirmed) {
          // Jika alasan diisi, kirim data ke server dengan AJAX
          Pace.track(function () {
            $.ajax({
              url: url_batal_rme,
              type: "POST",
              data: {
                // id: id,
                alasan: result.value, // Alasan yang diisi pengguna
                _csrf: yii.getCsrfToken(), // CSRF token untuk keamanan
              },
              beforeSend: function (e) {
                fbtn.setLoading(btn, "proses...");
                $(".btn").attr("disabled", true);
              },
              success: function (response) {
                if (response.status) {
                  Swal.fire({
                    icon: "success",
                    title: response.msg,
                    showConfirmButton: false,
                    timer: 1500,
                  });
                  // Lakukan tindakan tambahan seperti refresh halaman
                  $.pjax.reload({
                    container: "#pjform",
                    timeout: false,
                  });
                } else {
                  Swal.fire({
                    icon: "error",
                    title: "Gagal membatalkan laporan!",
                    text: response.msg,
                  });
                }
              },
              complete: function (e) {
                fbtn.resetLoading(btn, '<i class="fas fa-times"></i> Batal');
                $(".btn").attr("disabled", false);
              },
              error: function () {
                Swal.fire({
                  icon: "error",
                  title: "Terjadi kesalahan!",
                  text: "Gagal terhubung ke server.",
                });
              },
            });
          });
        }
      });
    })
    .on("submit", function (e) {
      e.preventDefault();
    });

  $(".btn-segarkan").on("click", function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    $.pjax.reload({ container: "#pjform", timeout: false }); //pjax form
  });
});
