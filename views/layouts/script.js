$(document).on("click", "#kembali", function (e) {
  e.preventDefault;
  e.stopImmediatePropagation();
  // console.log("bayu");
  var id = $(this).data("id");
  console.log(id);
  let url = null;
  let layanan_operasi = localStorage.getItem("layanan");
  let unit_id = id;

  let ibs = 138;
  let ground = 288;
  let ird = 139;

  if (layanan_operasi === "pasien_pulang") {
    url = baseUrl + "/layanan-operasi/pasien-selesai-operasi";
  } else if (layanan_operasi === "pasien_ruang_lainnya") {
    url = baseUrl + "/layanan-operasi/ruangan-lainnya";
  } else if (layanan_operasi === "pasien_operasi") {
    if (unit_id == ibs) {
      url = baseUrl + "/layanan-operasi/pasien-operasi?kamar=" + ibs;
    } else if (unit_id == ird) {
      url = baseUrl + "/layanan-operasi/pasien-operasi?kamar=" + ird;
    } else {
      url = baseUrl + "/layanan-operasi/pasien-operasi?kamar=" + ground;
    }
  } else if (layanan_operasi === "batal_operasi") {
    url = baseUrl + "/pembatalan-operasi/list-data-pasien-batal";
  } else {
    url = baseUrl + "/layanan-operasi/index";
  }

  window.location.href = url;
});

$(document).ready(function () {
  console.log("ini auto load");
});
