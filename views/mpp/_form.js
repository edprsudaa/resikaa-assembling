$(document).ready(function () {
  $("#asesmennyeri-jenis").on("change", function (e) {
    $("#asesmennyeri-hasil_json").val("");
    $("#asesmennyeri-hasil_nilai").val("");
    $("#asesmennyeri-hasil_deskripsi").val("");
    var getval = $("input[name='AsesmenNyeri[jenis]']:checked").val();
    // console.log(getval);
    if (getval === "CCPOT") {
      $("#modal_ccpot").modal({ backdrop: "static", keyboard: false });
    } else if (getval === "BPS") {
      $("#modal_bps").modal({ backdrop: "static", keyboard: false });
    } else if (getval === "NIPS") {
      $("#modal_nips").modal({ backdrop: "static", keyboard: false });
    } else if (getval === "FLACC") {
      $("#modal_flacc").modal({ backdrop: "static", keyboard: false });
    } else if (getval === "VAS") {
      $("#modal_vas").modal({ backdrop: "static", keyboard: false });
    }
  });
  function formTojson(data) {
    var formData = {};
    var formDataArrays = {};
    $.each(data, function (i, field) {
      if (field.value.trim() != "") {
        if (/\[\]$/.test(field.name)) {
          var fName = field.name.substr(0, field.name.length - 2);
          if (!formDataArrays[fName]) {
            formDataArrays[fName] = [];
          }
          formData[fName + "[" + formDataArrays[fName].length + "]"] =
            field.value;
          formDataArrays[fName].push(field.value);
        } else {
          formData[field.name] = field.value;
        }
      }
    });
    return formData;
  }
  //MODAL ACTION SETTING
  // CCPOT MODAL
  $("#spmpp_form")
    .find(":input")
    .on("keyup input change", function () {
      var value = $(this).val();
      var value_split = value.split("@");
      // console.log(value_split[1]);
      if (value && value_split[1] !== undefined) {
        //jika langkah maka array index 1 tidak tersedia maka hitung nilai tdk perlu dilakukan
        var skor = 0;
        var q1 = $("input[name='spmpp_q1']:checked").val();
        if (q1) {
          var q1v = q1.split("@");
          skor = skor + parseInt(q1v[2]);
        }
        var q2 = $("input[name='spmpp_q2']:checked").val();
        if (q2) {
          var q2v = q2.split("@");
          skor = skor + parseInt(q2v[2]);
        }
        var q3 = $("input[name='spmpp_q3']:checked").val();
        if (q3) {
          var q3v = q3.split("@");
          skor = skor + parseInt(q3v[2]);
        }
        var q4 = $("input[name='spmpp_q4']:checked").val();
        if (q4) {
          var q4v = q4.split("@");
          skor = skor + parseInt(q4v[2]);
        }
        var q5 = $("input[name='spmpp_q5']:checked").val();
        if (q5) {
          var q5v = q5.split("@");
          skor = skor + parseInt(q5v[2]);
        }
        var q6 = $("input[name='spmpp_q6']:checked").val();
        if (q6) {
          var q6v = q6.split("@");
          skor = skor + parseInt(q6v[2]);
        }
        var q7 = $("input[name='spmpp_q7']:checked").val();
        if (q7) {
          var q7v = q7.split("@");
          skor = skor + parseInt(q7v[2]);
        }
        var q8 = $("input[name='spmpp_q8']:checked").val();
        if (q8) {
          var q8v = q8.split("@");
          skor = skor + parseInt(q8v[2]);
        }
        var q9 = $("input[name='spmpp_q9']:checked").val();
        if (q9) {
          var q9v = q9.split("@");
          skor = skor + parseInt(q9v[2]);
        }
        var q10 = $("input[name='spmpp_q10']:checked").val();
        if (q10) {
          var q10v = q10.split("@");
          skor = skor + parseInt(q10v[2]);
        }
        var q11 = $("input[name='spmpp_q11']:checked").val();
        if (q11) {
          var q11v = q11.split("@");
          skor = skor + parseInt(q11v[2]);
        }
        var q12 = $("input[name='spmpp_q12']:checked").val();
        if (q12) {
          var q12v = q12.split("@");
          skor = skor + parseInt(q12v[2]);
        }

        $("input[name='spmpp_total_skor']").val(skor);

        $("input[name='spmpp_kategori_skor']").val("-");
        //SETTING KATEGORI SKOR
        if (parseInt(skor) <= 11) {
          $("input[name='spmpp_kategori_skor']").val(
            "Tidak perlu Monitoring Intens dari Manager Pelayanan Pasien"
          );
        } else if (parseInt(skor) >= 12) {
          $("input[name='spmpp_kategori_skor']").val(
            "Perlu Monitoring Intens dari Manager Pelayanan Pasien"
          );
        }
      }
    });
  $("#modal_ccpot").on("hidden.bs.modal", function (e) {
    $(this)
      .find("input[type=checkbox], input[type=radio]")
      .prop("checked", "")
      .end();
    $("#ccpot_total_skor").val("");
    $("#ccpot_kategori_skor").val("");
  });
  $(".btn-close-modal_ccpot").click(function () {
    $("input[name='AsesmenNyeri[jenis]']").prop("checked", false);
    $("#asesmennyeri-hasil_json").val("");
    $("#asesmennyeri-hasil_nilai").val("");
    $("#asesmennyeri-hasil_deskripsi").val("");
    $(".hasil_html").html("");
    $("#modal_ccpot").modal("hide");
  });
  $("#sspmpp_form").on("submit", function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    //FORM INPUT
    var form = $("#spmpp_form").serializeArray();

    var formjson = formTojson(form);
    console.log(formjson);
    // if(formjson['ccpot_total_skor'] && formjson['ccpot_kategori_skor']){
    if (formjson["spmpp_total_skor"]) {
      //JSON Nyeri CCPOT
      var obj_json_nyeri = JSON.parse(json_nyeri);
      var obj_json_ccpot = obj_json_nyeri.ccpot;
      //SET JSON Nyeri  CCPOT BY FORM INPUT
      $.each(obj_json_ccpot.penilaian, function (i1, v1) {
        if (formjson[v1.id]) {
          var formjsonsplit = formjson[v1.id].split("@");
          $.each(v1.kriteria, function (i2, v2) {
            if (v2.val == formjsonsplit[2]) {
              obj_json_ccpot.penilaian[i1].kriteria[i2].pilih = "1";
            }
          });
        }
      });
      obj_json_ccpot.total_skor = formjson.ccpot_total_skor;
      obj_json_ccpot.kategori_skor = formjson.ccpot_kategori_skor;
      //SET PARENT FORM SAVE Nyeri
      $("#asesmennyeri-hasil_json").val(JSON.stringify(obj_json_ccpot));
      $("#asesmennyeri-hasil_nilai").val(formjson.ccpot_total_skor);
      $("#asesmennyeri-hasil_deskripsi").val(formjson.ccpot_kategori_skor);
      var table1 =
        '<div class="table-responsive"><table class="table table-bordered mb-0">';
      table1 =
        table1 +
        '<colgroup width="40"></colgroup>' +
        '<colgroup width="100"></colgroup>' +
        '<colgroup width="400"></colgroup>' +
        "<tr>" +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>No</td>' +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom>Parameter</td>' +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom>Nilai</td>' +
        "</tr>";
      $.each(obj_json_ccpot.penilaian, function (i1, v1) {
        var tr = "<tr>";
        tr =
          tr +
          '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center">' +
          ++i1 +
          "</td>";
        tr =
          tr +
          '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left">' +
          v1.parameter +
          "</td>";
        var jawaban = "?";
        $.each(v1.kriteria, function (i2, v2) {
          if (v2.pilih == "1") {
            jawaban = v2.des + " = " + v2.val;
          }
        });
        tr =
          tr +
          '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left">' +
          jawaban +
          "</td>";
        tr = tr + "</tr>";
        table1 = table1 + tr;
      });
      //
      table1 = table1 + "<tr>";
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" colspan="2" valign=middle>Keterangan Kategori Skor</td>';
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
      table1 = table1 + obj_json_ccpot.keterangan_skor;
      table1 = table1 + "</td>";
      table1 = table1 + "</tr>";
      //
      table1 = table1 + "<tr>";
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" colspan="2" valign=middle>Total Skor</td>';
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
      table1 = table1 + '<div class="row">';
      table1 = table1 + '<div class="col-sm-12">';
      table1 =
        table1 +
        '<input type="text" class="form-control form-control-sm" readonly="true" value="' +
        obj_json_ccpot.total_skor +
        '">';
      table1 = table1 + "</div>";
      table1 = table1 + "</div>";
      table1 = table1 + "</td>";
      table1 = table1 + "</tr>";
      //
      table1 = table1 + "<tr>";
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" colspan="2" valign=middle>Kategori Skor</td>';
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
      table1 = table1 + '<div class="row">';
      table1 = table1 + '<div class="col-sm-12">';
      table1 =
        table1 +
        '<input type="text" class="form-control form-control-sm" readonly="true" value="' +
        obj_json_ccpot.kategori_skor +
        '">';
      table1 = table1 + "</div>";
      table1 = table1 + "</div>";
      table1 = table1 + "</td>";
      table1 = table1 + "</tr>";
      table1 = table1 + "</table></div>";
      $(".hasil_html").html(table1);
      // https://www.yiiframework.com/doc/api/2.0/yii-web-view#registerJsFile()-detail =>paramy2(json string) ke params variable js dan json_decode php
      $("#modal_ccpot").modal("hide");
    } else {
      fmsg.w("Mohon Isi Asesmen Nyeri Dengan Benar");
    }
  });
  // END CCPOT MODAL
  // BPS MODAL
  $("#bps_form")
    .find(":input")
    .on("keyup input change", function () {
      var value = $(this).val();
      var value_split = value.split("@");
      // console.log(value_split[1]);
      if (value && value_split[1] !== undefined) {
        //jika langkah maka array index 1 tidak tersedia maka hitung nilai tdk perlu dilakukan
        var skor = 0;
        var q1 = $("input[name='bps_q1']:checked").val();
        if (q1) {
          var q1v = q1.split("@");
          skor = skor + parseInt(q1v[2]);
        }
        var q2 = $("input[name='bps_q2']:checked").val();
        if (q2) {
          var q2v = q2.split("@");
          skor = skor + parseInt(q2v[2]);
        }
        var q3 = $("input[name='bps_q3']:checked").val();
        if (q3) {
          var q3v = q3.split("@");
          skor = skor + parseInt(q3v[2]);
        }

        $("input[name='bps_total_skor']").val(skor);
        //SETTING KATEGORI SKOR
        if (parseInt(skor) == 0) {
          $("input[name='bps_kategori_skor']").val("Tidak ada nyeri(no pain)");
        } else if (parseInt(skor) >= 1 && parseInt(skor) <= 3) {
          $("input[name='bps_kategori_skor']").val("Nyeri ringan(mild pain)");
        } else if (parseInt(skor) >= 4 && parseInt(skor) <= 6) {
          $("input[name='bps_kategori_skor']").val(
            "Nyeri sedang(moderate pain)"
          );
        } else if (parseInt(skor) > 6) {
          $("input[name='bps_kategori_skor']").val(
            "Nyeri tak tertahankan(uncontrolled pain)"
          );
        }
      }
    });
  $("#modal_bps").on("hidden.bs.modal", function (e) {
    $(this)
      .find("input[type=checkbox], input[type=radio]")
      .prop("checked", "")
      .end();
    $("#bps_total_skor").val("");
    $("#bps_kategori_skor").val("");
  });
  $(".btn-close-modal_bps").click(function () {
    $("input[name='AsesmenNyeri[jenis]']").prop("checked", false);
    $("#asesmennyeri-hasil_json").val("");
    $("#asesmennyeri-hasil_nilai").val("");
    $("#asesmennyeri-hasil_deskripsi").val("");
    $(".hasil_html").html("");
    $("#modal_bps").modal("hide");
  });
  $("#bps_form").on("submit", function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    //FORM INPUT
    var form = $("#bps_form").serializeArray();
    var formjson = formTojson(form);
    if (formjson["bps_total_skor"] && formjson["bps_kategori_skor"]) {
      //JSON Nyeri SS
      var obj_json_nyeri = JSON.parse(json_nyeri);
      var obj_json_bps = obj_json_nyeri.bps;
      //SET JSON Nyeri SS BY FORM INPUT
      $.each(obj_json_bps.penilaian, function (i1, v1) {
        if (formjson[v1.id]) {
          var formjsonsplit = formjson[v1.id].split("@");
          $.each(v1.kriteria, function (i2, v2) {
            if (v2.val == formjsonsplit[2]) {
              obj_json_bps.penilaian[i1].kriteria[i2].pilih = "1";
            }
          });
        }
      });
      obj_json_bps.total_skor = formjson.bps_total_skor;
      obj_json_bps.kategori_skor = formjson.bps_kategori_skor;
      //SET PARENT FORM SAVE Nyeri
      $("#asesmennyeri-hasil_json").val(JSON.stringify(obj_json_bps));
      $("#asesmennyeri-hasil_nilai").val(formjson.bps_total_skor);
      $("#asesmennyeri-hasil_deskripsi").val(formjson.bps_kategori_skor);
      var table1 =
        '<div class="table-responsive"><table class="table table-bordered mb-0">';
      table1 =
        table1 +
        '<colgroup width="40"></colgroup>' +
        '<colgroup width="100"></colgroup>' +
        '<colgroup width="400"></colgroup>' +
        "<tr>" +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>No</td>' +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom>Parameter</td>' +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom>Nilai</td>' +
        "</tr>";
      $.each(obj_json_bps.penilaian, function (i1, v1) {
        var tr = "<tr>";
        tr =
          tr +
          '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center">' +
          ++i1 +
          "</td>";
        tr =
          tr +
          '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left">' +
          v1.parameter +
          "</td>";
        var jawaban = "?";
        $.each(v1.kriteria, function (i2, v2) {
          if (v2.pilih == "1") {
            jawaban = v2.des + " = " + v2.val;
          }
        });
        tr =
          tr +
          '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left">' +
          jawaban +
          "</td>";
        tr = tr + "</tr>";
        table1 = table1 + tr;
      });
      //
      table1 = table1 + "<tr>";
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" colspan="2" valign=middle>Keterangan Kategori Skor</td>';
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
      table1 = table1 + obj_json_bps.keterangan_skor;
      table1 = table1 + "</td>";
      table1 = table1 + "</tr>";
      //
      table1 = table1 + "<tr>";
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" colspan="2" valign=middle>Total Skor</td>';
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
      table1 = table1 + '<div class="row">';
      table1 = table1 + '<div class="col-sm-12">';
      table1 =
        table1 +
        '<input type="text" class="form-control form-control-sm" readonly="true" value="' +
        obj_json_bps.total_skor +
        '">';
      table1 = table1 + "</div>";
      table1 = table1 + "</div>";
      table1 = table1 + "</td>";
      table1 = table1 + "</tr>";
      //
      table1 = table1 + "<tr>";
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" colspan="2" valign=middle>Kategori Skor</td>';
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
      table1 = table1 + '<div class="row">';
      table1 = table1 + '<div class="col-sm-12">';
      table1 =
        table1 +
        '<input type="text" class="form-control form-control-sm" readonly="true" value="' +
        obj_json_bps.kategori_skor +
        '">';
      table1 = table1 + "</div>";
      table1 = table1 + "</div>";
      table1 = table1 + "</td>";
      table1 = table1 + "</tr>";
      table1 = table1 + "</table></div>";
      $(".hasil_html").html(table1);
      // https://www.yiiframework.com/doc/api/2.0/yii-web-view#registerJsFile()-detail =>paramy2(json string) ke params variable js dan json_decode php
      $("#modal_bps").modal("hide");
    } else {
      fmsg.w("Mohon Isi Asesmen Nyeri Dengan Benar");
    }
  });
  // END BPS MODAL
  // NIPS MODAL
  $("#nips_form")
    .find(":input")
    .on("keyup input change", function () {
      var value = $(this).val();
      var value_split = value.split("@");
      // console.log(value_split[1]);
      if (value && value_split[1] !== undefined) {
        //jika langkah maka array index 1 tidak tersedia maka hitung nilai tdk perlu dilakukan
        var skor = 0;
        var q1 = $("input[name='nips_q1']:checked").val();
        if (q1) {
          var q1v = q1.split("@");
          skor = skor + parseInt(q1v[2]);
        }
        var q2 = $("input[name='nips_q2']:checked").val();
        if (q2) {
          var q2v = q2.split("@");
          skor = skor + parseInt(q2v[2]);
        }
        var q3 = $("input[name='nips_q3']:checked").val();
        if (q3) {
          var q3v = q3.split("@");
          skor = skor + parseInt(q3v[2]);
        }
        var q4 = $("input[name='nips_q4']:checked").val();
        if (q4) {
          var q4v = q4.split("@");
          skor = skor + parseInt(q4v[2]);
        }
        var q5 = $("input[name='nips_q5']:checked").val();
        if (q5) {
          var q5v = q5.split("@");
          skor = skor + parseInt(q5v[2]);
        }
        var q6 = $("input[name='nips_q6']:checked").val();
        if (q6) {
          var q6v = q6.split("@");
          skor = skor + parseInt(q6v[2]);
        }

        $("input[name='nips_total_skor']").val(skor);
        //SETTING KATEGORI SKOR
        if (parseInt(skor) >= 0 && parseInt(skor) <= 2) {
          $("input[name='nips_kategori_skor']").val("Nyeri ringan-tidak nyeri");
        } else if (parseInt(skor) >= 3 && parseInt(skor) <= 4) {
          $("input[name='nips_kategori_skor']").val(
            "Nyeri sedang-nyeri ringan"
          );
        } else if (parseInt(skor) > 4) {
          $("input[name='nips_kategori_skor']").val("Nyeri hebat");
        }
      }
    });
  $("#modal_nips").on("hidden.bs.modal", function (e) {
    $(this)
      .find("input[type=checkbox], input[type=radio]")
      .prop("checked", "")
      .end();
    $("#nips_total_skor").val("");
    $("#nips_kategori_skor").val("");
  });
  $(".btn-close-modal_nips").click(function () {
    $("input[name='AsesmenNyeri[jenis]']").prop("checked", false);
    $("#asesmennyeri-hasil_json").val("");
    $("#asesmennyeri-hasil_nilai").val("");
    $("#asesmennyeri-hasil_deskripsi").val("");
    $(".hasil_html").html("");
    $("#modal_nips").modal("hide");
  });
  $("#nips_form").on("submit", function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    //FORM INPUT
    var form = $("#nips_form").serializeArray();
    var formjson = formTojson(form);
    if (formjson["nips_total_skor"] && formjson["nips_kategori_skor"]) {
      //JSON Nyeri SS
      var obj_json_nyeri = JSON.parse(json_nyeri);
      var obj_json_nips = obj_json_nyeri.nips;
      //SET JSON Nyeri SS BY FORM INPUT
      $.each(obj_json_nips.penilaian, function (i1, v1) {
        if (formjson[v1.id]) {
          var formjsonsplit = formjson[v1.id].split("@");
          $.each(v1.kriteria, function (i2, v2) {
            if (v2.val == formjsonsplit[2]) {
              obj_json_nips.penilaian[i1].kriteria[i2].pilih = "1";
            }
          });
        }
      });
      obj_json_nips.total_skor = formjson.nips_total_skor;
      obj_json_nips.kategori_skor = formjson.nips_kategori_skor;
      //SET PARENT FORM SAVE Nyeri
      $("#asesmennyeri-hasil_json").val(JSON.stringify(obj_json_nips));
      $("#asesmennyeri-hasil_nilai").val(formjson.nips_total_skor);
      $("#asesmennyeri-hasil_deskripsi").val(formjson.nips_kategori_skor);
      var table1 =
        '<div class="table-responsive"><table class="table table-bordered mb-0">';
      table1 =
        table1 +
        '<colgroup width="40"></colgroup>' +
        '<colgroup width="100"></colgroup>' +
        '<colgroup width="400"></colgroup>' +
        "<tr>" +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>No</td>' +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>Parameter</td>' +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>Nilai</td>' +
        "</tr>";
      $.each(obj_json_nips.penilaian, function (i1, v1) {
        var tr = "<tr>";
        tr =
          tr +
          '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center">' +
          ++i1 +
          "</td>";
        tr =
          tr +
          '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left">' +
          v1.parameter +
          "</td>";
        var jawaban = "?";
        $.each(v1.kriteria, function (i2, v2) {
          if (v2.pilih == "1") {
            jawaban = v2.des + " = " + v2.val;
          }
        });
        tr =
          tr +
          '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left">' +
          jawaban +
          "</td>";
        tr = tr + "</tr>";
        table1 = table1 + tr;
      });
      //
      table1 = table1 + "<tr>";
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" colspan="2" valign=middle>Keterangan Kategori Skor</td>';
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
      table1 = table1 + obj_json_nips.keterangan_skor;
      table1 = table1 + "</td>";
      table1 = table1 + "</tr>";
      //
      table1 = table1 + "<tr>";
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" colspan="2" valign=middle>Total Skor</td>';
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
      table1 = table1 + '<div class="row">';
      table1 = table1 + '<div class="col-sm-12">';
      table1 =
        table1 +
        '<input type="text" class="form-control form-control-sm" readonly="true" value="' +
        obj_json_nips.total_skor +
        '">';
      table1 = table1 + "</div>";
      table1 = table1 + "</div>";
      table1 = table1 + "</td>";
      table1 = table1 + "</tr>";
      //
      table1 = table1 + "<tr>";
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" colspan="2" valign=middle>Kategori Skor</td>';
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
      table1 = table1 + '<div class="row">';
      table1 = table1 + '<div class="col-sm-12">';
      table1 =
        table1 +
        '<input type="text" class="form-control form-control-sm" readonly="true" value="' +
        obj_json_nips.kategori_skor +
        '">';
      table1 = table1 + "</div>";
      table1 = table1 + "</div>";
      table1 = table1 + "</td>";
      table1 = table1 + "</tr>";
      table1 = table1 + "</table></div>";
      $(".hasil_html").html(table1);
      // https://www.yiiframework.com/doc/api/2.0/yii-web-view#registerJsFile()-detail =>paramy2(json string) ke params variable js dan json_decode php
      $("#modal_nips").modal("hide");
    } else {
      fmsg.w("Mohon Isi Asesmen Nyeri Dengan Benar");
    }
  });
  // END NIPS MODAL
  // FLACC MODAL
  $("#flacc_form")
    .find(":input")
    .on("keyup input change", function () {
      var value = $(this).val();
      var value_split = value.split("@");
      // console.log(value_split[1]);
      if (value && value_split[1] !== undefined) {
        //jika langkah maka array index 1 tidak tersedia maka hitung nilai tdk perlu dilakukan
        var skor = 0;
        var q1 = $("input[name='flacc_q1']:checked").val();
        if (q1) {
          var q1v = q1.split("@");
          skor = skor + parseInt(q1v[2]);
        }
        var q2 = $("input[name='flacc_q2']:checked").val();
        if (q2) {
          var q2v = q2.split("@");
          skor = skor + parseInt(q2v[2]);
        }
        var q3 = $("input[name='flacc_q3']:checked").val();
        if (q3) {
          var q3v = q3.split("@");
          skor = skor + parseInt(q3v[2]);
        }
        var q4 = $("input[name='flacc_q4']:checked").val();
        if (q4) {
          var q4v = q4.split("@");
          skor = skor + parseInt(q4v[2]);
        }
        var q5 = $("input[name='flacc_q5']:checked").val();
        if (q5) {
          var q5v = q5.split("@");
          skor = skor + parseInt(q5v[2]);
        }

        $("input[name='flacc_total_skor']").val(skor);
        //SETTING KATEGORI SKOR
        if (parseInt(skor) == 0) {
          $("input[name='flacc_kategori_skor']").val("Rileks dan nyaman");
        } else if (parseInt(skor) >= 1 && parseInt(skor) <= 3) {
          $("input[name='flacc_kategori_skor']").val("Sedikit tidak nyaman");
        } else if (parseInt(skor) >= 4 && parseInt(skor) <= 6) {
          $("input[name='flacc_kategori_skor']").val("Nyeri sedang");
        } else if (parseInt(skor) >= 7 && parseInt(skor) <= 10) {
          $("input[name='flacc_kategori_skor']").val(
            "Nyeri/Tidak nyaman yang parah"
          );
        }
      }
    });
  $("#modal_flacc").on("hidden.bs.modal", function (e) {
    $(this)
      .find("input[type=checkbox], input[type=radio]")
      .prop("checked", "")
      .end();
    $("#flacc_total_skor").val("");
    $("#flacc_kategori_skor").val("");
  });
  $(".btn-close-modal_flacc").click(function () {
    $("input[name='AsesmenNyeri[jenis]']").prop("checked", false);
    $("#asesmennyeri-hasil_json").val("");
    $("#asesmennyeri-hasil_nilai").val("");
    $("#asesmennyeri-hasil_deskripsi").val("");
    $(".hasil_html").html("");
    $("#modal_flacc").modal("hide");
  });
  $("#flacc_form").on("submit", function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    //FORM INPUT
    var form = $("#flacc_form").serializeArray();
    var formjson = formTojson(form);
    if (formjson["flacc_total_skor"] && formjson["flacc_kategori_skor"]) {
      //JSON Nyeri SS
      var obj_json_nyeri = JSON.parse(json_nyeri);
      var obj_json_flacc = obj_json_nyeri.flacc;
      //SET JSON Nyeri SS BY FORM INPUT
      $.each(obj_json_flacc.penilaian, function (i1, v1) {
        if (formjson[v1.id]) {
          var formjsonsplit = formjson[v1.id].split("@");
          $.each(v1.kriteria, function (i2, v2) {
            if (v2.val == formjsonsplit[2]) {
              obj_json_flacc.penilaian[i1].kriteria[i2].pilih = "1";
            }
          });
        }
      });
      obj_json_flacc.total_skor = formjson.flacc_total_skor;
      obj_json_flacc.kategori_skor = formjson.flacc_kategori_skor;
      //SET PARENT FORM SAVE Nyeri
      $("#asesmennyeri-hasil_json").val(JSON.stringify(obj_json_flacc));
      $("#asesmennyeri-hasil_nilai").val(formjson.flacc_total_skor);
      $("#asesmennyeri-hasil_deskripsi").val(formjson.flacc_kategori_skor);
      var table1 =
        '<div class="table-responsive"><table class="table table-bordered mb-0">';
      table1 =
        table1 +
        '<colgroup width="40"></colgroup>' +
        '<colgroup width="100"></colgroup>' +
        '<colgroup width="400"></colgroup>' +
        "<tr>" +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>No</td>' +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom>Parameter</td>' +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom>Nilai</td>' +
        "</tr>";
      $.each(obj_json_flacc.penilaian, function (i1, v1) {
        var tr = "<tr>";
        tr =
          tr +
          '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center">' +
          ++i1 +
          "</td>";
        tr =
          tr +
          '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left">' +
          v1.parameter +
          "</td>";
        var jawaban = "?";
        $.each(v1.kriteria, function (i2, v2) {
          if (v2.pilih == "1") {
            jawaban = v2.des + " = " + v2.val;
          }
        });
        tr =
          tr +
          '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left">' +
          jawaban +
          "</td>";
        tr = tr + "</tr>";
        table1 = table1 + tr;
      });
      //
      table1 = table1 + "<tr>";
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" colspan="2" valign=middle>Keterangan Kategori Skor</td>';
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
      table1 = table1 + obj_json_flacc.keterangan_skor;
      table1 = table1 + "</td>";
      table1 = table1 + "</tr>";
      //
      table1 = table1 + "<tr>";
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" colspan="2" valign=middle>Total Skor</td>';
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
      table1 = table1 + '<div class="row">';
      table1 = table1 + '<div class="col-sm-12">';
      table1 =
        table1 +
        '<input type="text" class="form-control form-control-sm" readonly="true" value="' +
        obj_json_flacc.total_skor +
        '">';
      table1 = table1 + "</div>";
      table1 = table1 + "</div>";
      table1 = table1 + "</td>";
      table1 = table1 + "</tr>";
      //
      table1 = table1 + "<tr>";
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" colspan="2" valign=middle>Kategori Skor</td>';
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
      table1 = table1 + '<div class="row">';
      table1 = table1 + '<div class="col-sm-12">';
      table1 =
        table1 +
        '<input type="text" class="form-control form-control-sm" readonly="true" value="' +
        obj_json_flacc.kategori_skor +
        '">';
      table1 = table1 + "</div>";
      table1 = table1 + "</div>";
      table1 = table1 + "</td>";
      table1 = table1 + "</tr>";
      table1 = table1 + "</table></div>";
      $(".hasil_html").html(table1);
      // https://www.yiiframework.com/doc/api/2.0/yii-web-view#registerJsFile()-detail =>paramy2(json string) ke params variable js dan json_decode php
      $("#modal_flacc").modal("hide");
    } else {
      fmsg.w("Mohon Isi Asesmen Nyeri Dengan Benar");
    }
  });
  // END FLACC MODAL
  // VAS MODAL
  $("#vas_form")
    .find(":input")
    .on("keyup input change", function () {
      var value = $(this).val();
      var value_split = value.split("@");
      // console.log(value_split[1]);
      if (value && value_split[1] !== undefined) {
        //jika langkah maka array index 1 tidak tersedia maka hitung nilai tdk perlu dilakukan
        var skor = 0;
        var q1 = $("input[name='vas_q1']:checked").val();
        if (q1) {
          var q1v = q1.split("@");
          skor = skor + parseInt(q1v[2]);
        }

        $("input[name='vas_total_skor']").val(skor);
        //SETTING KATEGORI SKOR
        if (parseInt(skor) == 0) {
          $("input[name='vas_kategori_skor']").val("Rileks dan nyaman");
        } else if (parseInt(skor) >= 1 && parseInt(skor) <= 3) {
          $("input[name='vas_kategori_skor']").val("Sedikit tidak nyaman");
        } else if (parseInt(skor) >= 4 && parseInt(skor) <= 6) {
          $("input[name='vas_kategori_skor']").val("Nyeri sedang");
        } else if (parseInt(skor) >= 7 && parseInt(skor) <= 10) {
          $("input[name='vas_kategori_skor']").val(
            "Nyeri/Tidak nyaman yang parah"
          );
        }
      }
    });
  $("#modal_vas").on("hidden.bs.modal", function (e) {
    $(this)
      .find("input[type=checkbox], input[type=radio]")
      .prop("checked", "")
      .end();
    $("#vas_total_skor").val("");
    $("#vas_kategori_skor").val("");
    $("#vas_penyebab").val("");
    $("#vas_kualitas").val("");
    $("#vas_penyebaran").val("");
    $("#vas_keparahan").val("");
    $("#vas_waktu").val("");
  });
  $(".btn-close-modal_vas").click(function () {
    $("input[name='AsesmenNyeri[jenis]']").prop("checked", false);
    $("#asesmennyeri-hasil_json").val("");
    $("#asesmennyeri-hasil_nilai").val("");
    $("#asesmennyeri-hasil_deskripsi").val("");
    $(".hasil_html").html("");
    $("#modal_vas").modal("hide");
  });
  $("#vas_form").on("submit", function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    //FORM INPUT
    var form = $("#vas_form").serializeArray();
    var formjson = formTojson(form);
    if (formjson["vas_total_skor"] && formjson["vas_kategori_skor"]) {
      //JSON Nyeri SS
      var obj_json_nyeri = JSON.parse(json_nyeri);
      var obj_json_vas = obj_json_nyeri.vas;
      //SET JSON Nyeri SS BY FORM INPUT
      $.each(obj_json_vas.penilaian, function (i1, v1) {
        if (formjson[v1.id]) {
          var formjsonsplit = formjson[v1.id].split("@");
          $.each(v1.kriteria, function (i2, v2) {
            if (v2.val == formjsonsplit[2]) {
              obj_json_vas.penilaian[i1].kriteria[i2].pilih = "1";
            }
          });
        }
      });
      obj_json_vas.total_skor = formjson.vas_total_skor;
      obj_json_vas.kategori_skor = formjson.vas_kategori_skor;
      if (formjson["vas_penyebab"]) {
        obj_json_vas.penyebab = formjson.vas_penyebab;
      }
      if (formjson["vas_kualitas"]) {
        obj_json_vas.kualitas = formjson.vas_kualitas;
      }
      if (formjson["vas_penyebaran"]) {
        obj_json_vas.penyebaran = formjson.vas_penyebaran;
      }
      if (formjson["vas_keparahan"]) {
        obj_json_vas.keparahan = formjson.vas_keparahan;
      }
      if (formjson["vas_waktu"]) {
        obj_json_vas.waktu = formjson.vas_waktu;
      }
      //SET PARENT FORM SAVE Nyeri
      $("#asesmennyeri-hasil_json").val(JSON.stringify(obj_json_vas));
      $("#asesmennyeri-hasil_nilai").val(formjson.vas_total_skor);
      $("#asesmennyeri-hasil_deskripsi").val(formjson.vas_kategori_skor);
      var table1 =
        '<div class="table-responsive"><table class="table table-bordered mb-0">';
      table1 =
        table1 +
        '<colgroup width="40"></colgroup>' +
        '<colgroup width="100"></colgroup>' +
        '<colgroup width="400"></colgroup>' +
        "<tr>" +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>No</td>' +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>Parameter</td>' +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>Nilai</td>' +
        "</tr>";
      $.each(obj_json_vas.penilaian, function (i1, v1) {
        var tr = "<tr>";
        tr =
          tr +
          '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center">' +
          ++i1 +
          "</td>";
        tr =
          tr +
          '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left">' +
          v1.parameter +
          "</td>";
        var jawaban = "?";
        $.each(v1.kriteria, function (i2, v2) {
          if (v2.pilih == "1") {
            jawaban = v2.des + " = " + v2.val;
          }
        });
        tr =
          tr +
          '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center">' +
          jawaban +
          "</td>";
        tr = tr + "</tr>";
        table1 = table1 + tr;
      });
      //
      table1 = table1 + "<tr>";
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" colspan="2" valign=middle>Keterangan Kategori Skor</td>';
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
      table1 = table1 + obj_json_vas.keterangan_skor;
      table1 = table1 + "</td>";
      table1 = table1 + "</tr>";
      //
      table1 = table1 + "<tr>";
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" colspan="2" valign=middle>Total Skor</td>';
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
      table1 = table1 + '<div class="row">';
      table1 = table1 + '<div class="col-sm-12">';
      table1 =
        table1 +
        '<input type="text" class="form-control form-control-sm" readonly="true" value="' +
        obj_json_vas.total_skor +
        '">';
      table1 = table1 + "</div>";
      table1 = table1 + "</div>";
      table1 = table1 + "</td>";
      table1 = table1 + "</tr>";
      //
      table1 = table1 + "<tr>";
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" colspan="2" valign=middle>Kategori Skor</td>';
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
      table1 = table1 + '<div class="row">';
      table1 = table1 + '<div class="col-sm-12">';
      table1 =
        table1 +
        '<input type="text" class="form-control form-control-sm" readonly="true" value="' +
        obj_json_vas.kategori_skor +
        '">';
      table1 = table1 + "</div>";
      table1 = table1 + "</div>";
      table1 = table1 + "</td>";
      table1 = table1 + "</tr>";
      //
      table1 = table1 + "<tr>";
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" colspan="2" valign=middle>Penyebab</td>';
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
      table1 = table1 + '<div class="row">';
      table1 = table1 + '<div class="col-sm-12">';
      table1 =
        table1 +
        '<input type="text" class="form-control form-control-sm" readonly="true" value="' +
        obj_json_vas.penyebab +
        '">';
      table1 = table1 + "</div>";
      table1 = table1 + "</div>";
      table1 = table1 + "</td>";
      table1 = table1 + "</tr>";
      //
      table1 = table1 + "<tr>";
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" colspan="2" valign=middle>Kualitas</td>';
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
      table1 = table1 + '<div class="row">';
      table1 = table1 + '<div class="col-sm-12">';
      table1 =
        table1 +
        '<input type="text" class="form-control form-control-sm" readonly="true" value="' +
        obj_json_vas.kualitas +
        '">';
      table1 = table1 + "</div>";
      table1 = table1 + "</div>";
      table1 = table1 + "</td>";
      table1 = table1 + "</tr>";
      //
      table1 = table1 + "<tr>";
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" colspan="2" valign=middle>Penyebaran</td>';
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
      table1 = table1 + '<div class="row">';
      table1 = table1 + '<div class="col-sm-12">';
      table1 =
        table1 +
        '<input type="text" class="form-control form-control-sm" readonly="true" value="' +
        obj_json_vas.penyebaran +
        '">';
      table1 = table1 + "</div>";
      table1 = table1 + "</div>";
      table1 = table1 + "</td>";
      table1 = table1 + "</tr>";
      //
      table1 = table1 + "<tr>";
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" colspan="2" valign=middle>Keparahan</td>';
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
      table1 = table1 + '<div class="row">';
      table1 = table1 + '<div class="col-sm-12">';
      table1 =
        table1 +
        '<input type="text" class="form-control form-control-sm" readonly="true" value="' +
        obj_json_vas.keparahan +
        '">';
      table1 = table1 + "</div>";
      table1 = table1 + "</div>";
      table1 = table1 + "</td>";
      table1 = table1 + "</tr>";
      //
      table1 = table1 + "<tr>";
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" colspan="2" valign=middle>Waktu</td>';
      table1 =
        table1 +
        '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
      table1 = table1 + '<div class="row">';
      table1 = table1 + '<div class="col-sm-12">';
      table1 =
        table1 +
        '<input type="text" class="form-control form-control-sm" readonly="true" value="' +
        obj_json_vas.waktu +
        '">';
      table1 = table1 + "</div>";
      table1 = table1 + "</div>";
      table1 = table1 + "</td>";
      table1 = table1 + "</tr>";

      table1 = table1 + "</table></div>";
      $(".hasil_html").html(table1);
      // https://www.yiiframework.com/doc/api/2.0/yii-web-view#registerJsFile()-detail =>paramy2(json string) ke params variable js dan json_decode php
      $("#modal_vas").modal("hide");
    } else {
      fmsg.w("Mohon Isi Asesmen Nyeri Dengan Benar");
    }
  });
  // END VAS MODAL
  //MODAL ACTION SETTING
});
