/*
 * @Author: Dicky Ermawan S., S.T., MTA
 * @Email: wanasaja@gmail.com
 * @Web: dickyermawan.github.io
 * @Linkedin: linkedin.com/in/dickyermawan
 * @Date: 2020-11-24 14:48:27
 * @Last Modified by: Dicky Ermawan S., S.T., MTA
 * @Last Modified time: 2022-04-01 10:53:03
 */

const fungsi = (_) => {
  // disable submit form lewat enter
  $("#form-sp").on("keyup keypress", function (e) {
    let keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
      e.preventDefault();
      return false;
    }
  });

  $(
    "#asettetappengadaan-pengadaan_total_sebelum_diskon-disp, #asettetappengadaan-pengadaan_total_diskon"
  ).on("change", function (e) {
    let total_sebelum_diskon = parseInt(
      $("#asettetappengadaan-pengadaan_total_sebelum_diskon-disp").inputmask(
        "unmaskedvalue"
      )
    );
    let total_diskon = $(
      "#asettetappengadaan-pengadaan_total_diskon"
    ).inputmask("unmaskedvalue");

    let total_setelah_diskon = total_sebelum_diskon - total_diskon;
    $("#asettetappengadaan-pengadaan_total_setelah_diskon-disp")
      .val(total_setelah_diskon)
      .trigger("change");
  });

  $("#asettetappengadaan-pengadaan_total_setelah_diskon-disp").on(
    "change",
    function (e) {
      const isPpn = $("#asettetappengadaan-pengadaan_is_ppn").prop("checked");
      if (isPpn) {
        $("#asettetappengadaan-pengadaan_total_ppn-disp")
          .val(0)
          .trigger("change");
      } else {
        const totalSetelahDiskon = parseInt(
          $(
            "#asettetappengadaan-pengadaan_total_setelah_diskon-disp"
          ).inputmask("unmaskedvalue") ?? 0
        );
        total_ppn =
          (parseInt(
            $("#asettetappengadaan-pengadaan_persen_ppn").inputmask(
              "unmaskedvalue"
            ) ?? 0
          ) /
            100) *
          totalSetelahDiskon;

        $("#asettetappengadaan-pengadaan_total_ppn-disp")
          .val(total_ppn)
          .trigger("change");
        // console.log(totalSetelahDiskon);
        // console.log(total_ppn);
      }
    }
  );

  $("#asettetappengadaan-pengadaan_is_ppn").on("click change", (e) => {
    const isPpn = $("#asettetappengadaan-pengadaan_is_ppn").prop("checked");

    console.log(isPpn);
    if (isPpn) {
      $("#asettetappengadaan-pengadaan_total_ppn-disp")
        .val(0)
        .trigger("change");
    } else {
      const totalSetelahDiskon = $(
        "#asettetappengadaan-pengadaan_total_setelah_diskon-disp"
      ).inputmask("unmaskedvalue")
        ? $(
            "#asettetappengadaan-pengadaan_total_setelah_diskon-disp"
          ).inputmask("unmaskedvalue")
        : 0;
      total_ppn =
        (parseInt($("#asettetappengadaan-pengadaan_persen_ppn").val()) / 100) *
        totalSetelahDiskon;

      $("#asettetappengadaan-pengadaan_total_ppn-disp")
        .val(total_ppn)
        .trigger("change");
    }
  });

  $(
    "#asettetappengadaan-pengadaan_total_setelah_diskon, #asettetappengadaan-pengadaan_total_ppn-disp"
  ).on("change", function (e) {
    let total_setelah_diskon = parseFloat(
      $("#asettetappengadaan-pengadaan_total_setelah_diskon-disp").inputmask(
        "unmaskedvalue"
      )
    );
    let total_ppn = parseFloat(
      $("#asettetappengadaan-pengadaan_total_ppn-disp").inputmask(
        "unmaskedvalue"
      )
    );

    let total = total_setelah_diskon + total_ppn;
    $("#asettetappengadaan-pengadaan_total-disp")
      .val(total ? total : 0)
      .trigger("change");
  });

  $(".det_jumlah_kemasan").on("input change", function (e) {
    let index = $(e.target).closest("tr").index();

    let jumlah_total = $(
      `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_total`
    ).inputmask("unmaskedvalue");
    let harga_satuan =
      $(
        `#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan`
      ).inputmask("unmaskedvalue") == ""
        ? 0
        : $(
            `#asettetappengadaandetail-${index}-pengadaandetail_harga_kemasan`
          ).inputmask("unmaskedvalue");

    $(`#asettetappengadaandetail-${index}-pengadaandetail_jumlah_total`)
      .val(jumlah_total)
      .trigger("change");

    // update subtotal
    let subtotal = jumlah_total * harga_satuan;
    $(`#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`)
      .val(subtotal)
      .trigger("change");
    $(
      `#asettetappengadaandetail-${index}-pengadaandetail_diskon_persen`
    ).trigger("change");
  });

  $(".det_harga_kemasan").on("input change", function (e) {
    let index = $(e.target).closest("tr").index();

    let harga_kemasan = $(
      `#asettetappengadaandetail-${index}-pengadaandetail_harga_kemasan`
    ).inputmask("unmaskedvalue");
    let jumlah_kemasan =
      $(
        `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_kemasan`
      ).inputmask("unmaskedvalue") == ""
        ? 0
        : $(
            `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_kemasan`
          ).inputmask("unmaskedvalue");
    let isi_per_kemasan =
      $(
        `#asettetappengadaandetail-${index}-pengadaandetail_isi_per_kemasan`
      ).inputmask("unmaskedvalue") == ""
        ? 0
        : $(
            `#asettetappengadaandetail-${index}-pengadaandetail_isi_per_kemasan`
          ).inputmask("unmaskedvalue");

    // update harga_satuan
    let harga_satuan = harga_kemasan / isi_per_kemasan;
    $(`#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan`)
      .val(harga_satuan)
      .trigger("change");

    // update subtotal
    let subtotal = harga_kemasan * jumlah_kemasan;

    $(`#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`)
      .val(subtotal)
      .trigger("change");
  });

  $(".det_isi_per_kemasan").on("input change", function (e) {
    let index = $(e.target).closest("tr").index();

    let isi_per_kemasan =
      $(
        `#asettetappengadaandetail-${index}-pengadaandetail_isi_per_kemasan`
      ).inputmask("unmaskedvalue") == ""
        ? 0
        : $(
            `#asettetappengadaandetail-${index}-pengadaandetail_isi_per_kemasan`
          ).inputmask("unmaskedvalue");
    let jumlah_kemasan =
      $(
        `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_kemasan`
      ).inputmask("unmaskedvalue") == ""
        ? 0
        : $(
            `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_kemasan`
          ).inputmask("unmaskedvalue");
    let harga_kemasan =
      $(
        `#asettetappengadaandetail-${index}-pengadaandetail_harga_kemasan`
      ).inputmask("unmaskedvalue") == ""
        ? 0
        : $(
            `#asettetappengadaandetail-${index}-pengadaandetail_harga_kemasan`
          ).inputmask("unmaskedvalue");

    // update jumlah_total
    let jumlah_total = isi_per_kemasan * jumlah_kemasan;
    $(`#asettetappengadaandetail-${index}-pengadaandetail_jumlah_total`)
      .val(jumlah_total)
      .trigger("change");

    // update harga_satuan
    let harga_satuan = harga_kemasan / isi_per_kemasan;
    console.log(harga_satuan == "Infinity" ? "" : harga_satuan);
    $(`#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan`)
      .val(harga_satuan == "Infinity" ? "" : harga_satuan)
      .trigger("change");
  });

  $(".det_jumlah_total, .det_harga_satuan").on("input change", function (e) {
    let index = $(e.target).closest("tr").index();

    let jumlah_total = $(
      `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_total`
    ).inputmask("unmaskedvalue")
      ? $(
          `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_total`
        ).inputmask("unmaskedvalue")
      : 0;
    let harga_satuan = $(
      `#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan-disp`
    ).inputmask("unmaskedvalue")
      ? $(
          `#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan-disp`
        ).inputmask("unmaskedvalue")
      : 0;

    // update subtotal
    let subtotal = jumlah_total * harga_satuan;

    $(`#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`)
      .val(subtotal)
      .trigger("change");
  });

  $(".det_harga_satuan").on("input change", function (e) {
    let index = $(e.target).closest("tr").index();

    let harga_satuan = $(
      `#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan-disp`
    ).inputmask("unmaskedvalue");
    let diskon_persen =
      $(
        `#asettetappengadaandetail-${index}-pengadaandetail_diskon_persen`
      ).inputmask("unmaskedvalue") == ""
        ? 0
        : $(
            `#asettetappengadaandetail-${index}-pengadaandetail_diskon_persen`
          ).inputmask("unmaskedvalue");

    // update harga_beli_sekarang
    let harga_beli_sekarang = (
      harga_satuan -
      (harga_satuan * diskon_persen) / 100
    ).toFixed(2);
    $(
      `#asettetappengadaandetail-${index}-pengadaandetail_total_setelah_diskon-disp`
    )
      .val(harga_beli_sekarang)
      .trigger("change");
  });

  $(".det_subtotal").on("input change", function (e) {
    let index = $(e.target).closest("tr").index();

    let subtotal = $(
      `#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`
    ).inputmask("unmaskedvalue");
    let diskon_persen =
      $(
        `#asettetappengadaandetail-${index}-pengadaandetail_diskon_persen`
      ).inputmask("unmaskedvalue") == ""
        ? 0
        : $(
            `#asettetappengadaandetail-${index}-pengadaandetail_diskon_persen`
          ).inputmask("unmaskedvalue");

    // update diskon_total
    let diskon_total = (subtotal * diskon_persen) / 100;
    $(`#asettetappengadaandetail-${index}-pengadaandetail_diskon_total`)
      .val(diskon_total)
      .trigger("change");

    let hasilSubtotal = 0;
    $(".dynamicform_wrapper .form-options-item").each(function (index) {
      hasilSubtotal += parseInt(
        $(
          `#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`
        ).inputmask("unmaskedvalue")
      );
    });
    $(".dynamicform_wrappers .form-options-item").each(function (index) {
      hasilSubtotal += parseInt(
        $(
          `#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`
        ).inputmask("unmaskedvalue")
      );
    });
    $(`#asettetappengadaan-pengadaan_total_sebelum_diskon-disp`)
      .val(hasilSubtotal ? hasilSubtotal : 0)
      .trigger("change");
  });

  $(".det_diskon_persen").on("input change", function (e) {
    let index = $(e.target).closest("tr").index();

    let diskon_persen = $(
      `#asettetappengadaandetail-${index}-pengadaandetail_diskon_persen`
    ).inputmask("unmaskedvalue");
    let subtotal = parseFloat(
      $(
        `#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`
      ).inputmask("unmaskedvalue") == ""
        ? 0
        : $(
            `#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`
          ).inputmask("unmaskedvalue")
    );
    let harga_satuan =
      $(
        `#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan-disp`
      ).inputmask("unmaskedvalue") == ""
        ? 0
        : $(
            `#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan`
          ).inputmask("unmaskedvalue");

    // update diskon_total
    let diskon_total = (subtotal * diskon_persen) / 100;
    $(`#asettetappengadaandetail-${index}-pengadaandetail_diskon_total`)
      .val(diskon_total)
      .trigger("change");
    // update harga_beli_sekarang
    let harga_beli_sekarang =
      harga_satuan - (harga_satuan * diskon_persen) / 100;
    $(
      `#asettetappengadaandetail-${index}-pengadaandetail_total_setelah_diskon-disp`
    )
      .val(harga_beli_sekarang)
      .trigger("change");

    let hasilTotalDiskon = 0;
    $(".dynamicform_wrapper .form-options-item").each(function (index) {
      hasilTotalDiskon += parseInt(
        $(
          `#asettetappengadaandetail-${index}-pengadaandetail_diskon_total`
        ).inputmask("unmaskedvalue")
      );
    });
    $(".dynamicform_wrappers .form-options-item").each(function (index) {
      hasilTotalDiskon += parseInt(
        $(
          `#asettetappengadaandetail-${index}-pengadaandetail_diskon_total`
        ).inputmask("unmaskedvalue")
      );
    });
    $(`#asettetappengadaan-pengadaan_total_diskon-disp`)
      .val(hasilTotalDiskon)
      .trigger("change");
  });

 
};

$(document).ready(function () {
  fungsi();

  // event setelah tambah row
  $(".dynamicform_wrapper").on("afterInsert", function (e, item) {
    // update - agar select2 tidak terselect

    $(item)
      .find("select[name*='[pengadaandetail_kodefikasi_id]']")
      .on("select2:select", function (e) {
        let index = $(this).closest("tr").index();
        let barangDipilih = e.params.data;
        let uraian = e.params.data.rumpun.split(" >> ");
        console.log(uraian);

        $(this)
          .closest("tr")
          .find(".det_kodefikasi")
          .html(barangDipilih.kode_barang);
        $(this).closest("tr").find(".det_akun").html(uraian[0]);
        $(this).closest("tr").find(".det_kelompok").html(uraian[1]);
        $(this).closest("tr").find(".det_jenis").html(uraian[2]);
        $(this).closest("tr").find(".det_objek").html(uraian[3]);
        $(this).closest("tr").find(".det_rincian_objek").html(uraian[4]);
        $(this).closest("tr").find(".det_sub_rincian_objek").html(uraian[5]);

        $(this).closest("tr").find(".div_perencanaan").fadeIn("slow");

        $(`#asettetappengadaandetail-${index}-pengadaandetail_id_kemasan`)
          .val(barangDipilih.id_kemasan)
          .trigger("change");
        $(`#asettetappengadaandetail-${index}-pengadaandetail_harga_kemasan`)
          .val(barangDipilih.harga_kemasan)
          .trigger("change");
        $(`#asettetappengadaandetail-${index}-pengadaandetail_isi_per_kemasan`)
          .val(barangDipilih.isi_per_kemasan)
          .trigger("change");
        $(`#asettetappengadaandetail-${index}-pengadaandetail_id_satuan`)
          .val(barangDipilih.id_satuan)
          .trigger("change");
        $(`#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan`)
          .val(barangDipilih.harga_satuan)
          .trigger("change");
        $(`#asettetappengadaandetail-${index}-pengadaandetail_diskon_persen`)
          .val(barangDipilih.diskon_persen)
          .trigger("change");
        $(
          `#asettetappengadaandetail-${index}-pengadaandetail_harga_beli_sekarang`
        )
          .val(0)
          .trigger("change");
        $(
          `#asettetappengadaandetail-${index}-pengadaandetail_harga_beli_tertinggi`
        )
          .val(barangDipilih.harga_beli_tertinggi)
          .trigger("change");

        $(
          `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_kemasan`
        ).focus();
        console.log(
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan`
          ).inputmask("unmaskedvalue")
        );
      });

    $(".dynamicform_wrapper .form-options-item").each(function (index) {
      $(this)
        .find(".nomor")
        .html(index + 1);
    });

    $(item)
      .find("select[name*='[pengadaandetail_kodefikasi_id]']")
      .select2("open");

    $(item)
      .find(".det_jumlah_kemasan")
      .on("input change", function (e) {
        let index = $(e.target).closest("tr").index();

        let jumlah_kemasan = $(
          `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_kemasan`
        ).inputmask("unmaskedvalue");
        let isi_per_kemasan =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_isi_per_kemasan`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_isi_per_kemasan`
              ).inputmask("unmaskedvalue");
        let harga_kemasan =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_harga_kemasan`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_harga_kemasan`
              ).inputmask("unmaskedvalue");

        // update jumlah_total
        let jumlah_total = jumlah_kemasan * isi_per_kemasan;
        $(`#asettetappengadaandetail-${index}-pengadaandetail_jumlah_total`)
          .val(jumlah_total)
          .trigger("change");

        // update subtotal
        let subtotal = jumlah_kemasan * harga_kemasan;
        $(`#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`)
          .val(subtotal)
          .trigger("change");
        $(
          `#asettetappengadaandetail-${index}-pengadaandetail_diskon_persen`
        ).trigger("change");
      });

    $(item)
      .find(".det_harga_kemasan")
      .on("input change", function (e) {
        let index = $(e.target).closest("tr").index();

        let harga_kemasan = $(
          `#asettetappengadaandetail-${index}-pengadaandetail_harga_kemasan`
        ).inputmask("unmaskedvalue");
        let jumlah_kemasan =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_kemasan`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_kemasan`
              ).inputmask("unmaskedvalue");
        let isi_per_kemasan =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_isi_per_kemasan`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_isi_per_kemasan`
              ).inputmask("unmaskedvalue");

        // update harga_satuan
        let harga_satuan = harga_kemasan / isi_per_kemasan;
        $(`#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan`)
          .val(harga_satuan)
          .trigger("change");

        // update subtotal
        let subtotal = harga_kemasan * jumlah_kemasan;
        $(`#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`)
          .val(subtotal)
          .trigger("change");
      });

    $(item)
      .find(".det_isi_per_kemasan")
      .on("input change", function (e) {
        let index = $(e.target).closest("tr").index();

        let isi_per_kemasan = $(
          `#asettetappengadaandetail-${index}-pengadaandetail_isi_per_kemasan`
        ).inputmask("unmaskedvalue");
        let jumlah_kemasan =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_kemasan`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_kemasan`
              ).inputmask("unmaskedvalue");
        let harga_kemasan =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_harga_kemasan`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_harga_kemasan`
              ).inputmask("unmaskedvalue");

        // update jumlah_total
        let jumlah_total = isi_per_kemasan * jumlah_kemasan;
        $(`#asettetappengadaandetail-${index}-pengadaandetail_jumlah_total`)
          .val(jumlah_total)
          .trigger("change");

        // update harga_satuan
        let harga_satuan = harga_kemasan / isi_per_kemasan;
        $(`#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan`)
          .val(harga_satuan)
          .trigger("change");
      });

    $(item)
      .find(".det_jumlah_total")
      .on("input change", function (e) {
        let index = $(e.target).closest("tr").index();

        let jumlah_total =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_total`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_total`
              ).inputmask("unmaskedvalue");
        let harga_satuan =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan-disp`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan-disp`
              ).inputmask("unmaskedvalue");

        // update subtotal
        let subtotal = jumlah_total * harga_satuan;
        $(`#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`)
          .val(subtotal)
          .trigger("change");
      });

    $(item)
      .find(".det_harga_satuan")
      .on("input change", function (e) {
        let index = $(e.target).closest("tr").index();
        let jumlah_total =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_total`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_total`
              ).inputmask("unmaskedvalue");

        let harga_satuan = $(
          `#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan`
        ).inputmask("unmaskedvalue");
        let diskon_persen =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_diskon_persen`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_diskon_persen`
              ).inputmask("unmaskedvalue");
        let subtotal = jumlah_total * harga_satuan;
        // update harga_beli_sekarang
        let harga_beli_sekarang = (
          harga_satuan -
          (harga_satuan * diskon_persen) / 100
        ).toFixed(2);
        $(`#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`)
          .val(subtotal)
          .trigger("change");

        $(
          `#asettetappengadaandetail-${index}-pengadaandetail_total_setelah_diskon-disp`
        )
          .val(harga_beli_sekarang)
          .trigger("change");
      });

    $(item)
      .find(".det_subtotal")
      .on("input change", function (e) {
        let index = $(e.target).closest("tr").index();

        let subtotal = $(
          `#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`
        ).inputmask("unmaskedvalue");
        let diskon_persen =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_diskon_persen`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_diskon_persen`
              ).inputmask("unmaskedvalue");

        // update diskon_total
        let diskon_total = (subtotal * diskon_persen) / 100;
        $(`#asettetappengadaandetail-${index}-pengadaandetail_diskon_total`)
          .val(diskon_total)
          .trigger("change");

        let hasilSubtotal = 0;
        $(".dynamicform_wrapper .form-options-item").each(function (index) {
          hasilSubtotal += parseInt(
            $(
              `#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`
            ).inputmask("unmaskedvalue")
              ? $(
                  `#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`
                ).inputmask("unmaskedvalue")
              : 0
          );
        });

        $(`#asettetappengadaan-pengadaan_total_sebelum_diskon-disp`)
          .val(hasilSubtotal ? hasilSubtotal : 0)
          .trigger("change");
      });

    $(item)
      .find(".det_diskon_persen")
      .on("input change", function (e) {
        let index = $(e.target).closest("tr").index();

        let diskon_persen = $(
          `#asettetappengadaandetail-${index}-pengadaandetail_diskon_persen`
        ).inputmask("unmaskedvalue");
        let subtotal =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`
              ).inputmask("unmaskedvalue");
        let harga_satuan =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan`
              ).inputmask("unmaskedvalue");

        // update diskon_total
        let diskon_total = (subtotal * diskon_persen) / 100;
        $(`#asettetappengadaandetail-${index}-pengadaandetail_diskon_total`)
          .val(diskon_total)
          .trigger("change");

        // update harga_beli_sekarang
        let harga_beli_sekarang = (
          harga_satuan -
          (harga_satuan * diskon_persen) / 100
        ).toFixed(2);
        $(
          `#asettetappengadaandetail-${index}-pengadaandetail_harga_beli_sekarang`
        )
          .val(harga_beli_sekarang)
          .trigger("change");

        let hasilTotalDiskon = 0;
        $(".dynamicform_wrapper .form-options-item").each(function (index) {
          hasilTotalDiskon += parseInt(
            $(
              `#asettetappengadaandetail-${index}-pengadaandetail_diskon_total`
            ).inputmask("unmaskedvalue")
          );
        });
        $(`#asettetappengadaan-pengadaan_total_diskon-disp`)
          .val(hasilTotalDiskon)
          .trigger("change");
      });
  });
  $(".dynamicform_wrappers").on("afterInsert", function (e, item) {
    // update - agar select2 tidak terselect

    $(item)
      .find("select[name*='[pengadaandetail_kodefikasi_id]']")
      .on("select2:select", function (e) {
        let index = $(this).closest("tr").index();
        let barangDipilih = e.params.data;
        let uraian = e.params.data.rumpun.split(" >> ");
        console.log(uraian);

        $(this)
          .closest("tr")
          .find(".det_kodefikasi")
          .html(barangDipilih.kode_barang);
        $(this).closest("tr").find(".det_akun").html(uraian[0]);
        $(this).closest("tr").find(".det_kelompok").html(uraian[1]);
        $(this).closest("tr").find(".det_jenis").html(uraian[2]);
        $(this).closest("tr").find(".det_objek").html(uraian[3]);
        $(this).closest("tr").find(".det_rincian_objek").html(uraian[4]);
        $(this).closest("tr").find(".det_sub_rincian_objek").html(uraian[5]);

        $(this).closest("tr").find(".div_perencanaan").fadeIn("slow");

        $(`#asettetappengadaandetail-${index}-pengadaandetail_id_kemasan`)
          .val(barangDipilih.id_kemasan)
          .trigger("change");
        $(`#asettetappengadaandetail-${index}-pengadaandetail_harga_kemasan`)
          .val(barangDipilih.harga_kemasan)
          .trigger("change");
        $(`#asettetappengadaandetail-${index}-pengadaandetail_isi_per_kemasan`)
          .val(barangDipilih.isi_per_kemasan)
          .trigger("change");
        $(`#asettetappengadaandetail-${index}-pengadaandetail_id_satuan`)
          .val(barangDipilih.id_satuan)
          .trigger("change");
        $(`#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan`)
          .val(barangDipilih.harga_satuan)
          .trigger("change");
        $(`#asettetappengadaandetail-${index}-pengadaandetail_diskon_persen`)
          .val(barangDipilih.diskon_persen)
          .trigger("change");
        $(
          `#asettetappengadaandetail-${index}-pengadaandetail_harga_beli_sekarang`
        )
          .val(0)
          .trigger("change");
        $(
          `#asettetappengadaandetail-${index}-pengadaandetail_harga_beli_tertinggi`
        )
          .val(barangDipilih.harga_beli_tertinggi)
          .trigger("change");

        $(
          `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_kemasan`
        ).focus();
        console.log(
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan`
          ).inputmask("unmaskedvalue")
        );
      });

    $(".dynamicform_wrapper .form-options-item").each(function (index) {
      $(this)
        .find(".nomor")
        .html(index + 1);
    });

    $(item)
      .find("select[name*='[pengadaandetail_kodefikasi_id]']")
      .select2("open");

    $(item)
      .find(".det_jumlah_kemasan")
      .on("input change", function (e) {
        let index = $(e.target).closest("tr").index();

        let jumlah_kemasan = $(
          `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_kemasan`
        ).inputmask("unmaskedvalue");
        let isi_per_kemasan =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_isi_per_kemasan`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_isi_per_kemasan`
              ).inputmask("unmaskedvalue");
        let harga_kemasan =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_harga_kemasan`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_harga_kemasan`
              ).inputmask("unmaskedvalue");

        // update jumlah_total
        let jumlah_total = jumlah_kemasan * isi_per_kemasan;
        $(`#asettetappengadaandetail-${index}-pengadaandetail_jumlah_total`)
          .val(jumlah_total)
          .trigger("change");

        // update subtotal
        let subtotal = jumlah_kemasan * harga_kemasan;
        $(`#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`)
          .val(subtotal)
          .trigger("change");
        $(
          `#asettetappengadaandetail-${index}-pengadaandetail_diskon_persen`
        ).trigger("change");
      });

    $(item)
      .find(".det_harga_kemasan")
      .on("input change", function (e) {
        let index = $(e.target).closest("tr").index();

        let harga_kemasan = $(
          `#asettetappengadaandetail-${index}-pengadaandetail_harga_kemasan`
        ).inputmask("unmaskedvalue");
        let jumlah_kemasan =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_kemasan`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_kemasan`
              ).inputmask("unmaskedvalue");
        let isi_per_kemasan =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_isi_per_kemasan`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_isi_per_kemasan`
              ).inputmask("unmaskedvalue");

        // update harga_satuan
        let harga_satuan = harga_kemasan / isi_per_kemasan;
        $(`#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan`)
          .val(harga_satuan)
          .trigger("change");

        // update subtotal
        let subtotal = harga_kemasan * jumlah_kemasan;
        $(`#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`)
          .val(subtotal)
          .trigger("change");
      });

    $(item)
      .find(".det_isi_per_kemasan")
      .on("input change", function (e) {
        let index = $(e.target).closest("tr").index();

        let isi_per_kemasan = $(
          `#asettetappengadaandetail-${index}-pengadaandetail_isi_per_kemasan`
        ).inputmask("unmaskedvalue");
        let jumlah_kemasan =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_kemasan`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_kemasan`
              ).inputmask("unmaskedvalue");
        let harga_kemasan =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_harga_kemasan`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_harga_kemasan`
              ).inputmask("unmaskedvalue");

        // update jumlah_total
        let jumlah_total = isi_per_kemasan * jumlah_kemasan;
        $(`#asettetappengadaandetail-${index}-pengadaandetail_jumlah_total`)
          .val(jumlah_total)
          .trigger("change");

        // update harga_satuan
        let harga_satuan = harga_kemasan / isi_per_kemasan;
        $(`#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan`)
          .val(harga_satuan)
          .trigger("change");
      });

    $(item)
      .find(".det_jumlah_total")
      .on("input change", function (e) {
        let index = $(e.target).closest("tr").index();

        let jumlah_total =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_total`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_total`
              ).inputmask("unmaskedvalue");
        let harga_satuan =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan-disp`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan-disp`
              ).inputmask("unmaskedvalue");

        // update subtotal
        let subtotal = jumlah_total * harga_satuan;
        $(`#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`)
          .val(subtotal)
          .trigger("change");
      });

    $(item)
      .find(".det_harga_satuan")
      .on("input change", function (e) {
        let index = $(e.target).closest("tr").index();
        let jumlah_total =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_total`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_jumlah_total`
              ).inputmask("unmaskedvalue");

        let harga_satuan = $(
          `#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan`
        ).inputmask("unmaskedvalue");
        let diskon_persen =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_diskon_persen`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_diskon_persen`
              ).inputmask("unmaskedvalue");
        let subtotal = jumlah_total * harga_satuan;
        // update harga_beli_sekarang
        let harga_beli_sekarang = (
          harga_satuan -
          (harga_satuan * diskon_persen) / 100
        ).toFixed(2);
        $(`#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`)
          .val(subtotal)
          .trigger("change");

        $(
          `#asettetappengadaandetail-${index}-pengadaandetail_total_setelah_diskon-disp`
        )
          .val(harga_beli_sekarang)
          .trigger("change");
      });

    $(item)
      .find(".det_subtotal")
      .on("input change", function (e) {
        let index = $(e.target).closest("tr").index();

        let subtotal = $(
          `#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`
        ).inputmask("unmaskedvalue");
        let diskon_persen =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_diskon_persen`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_diskon_persen`
              ).inputmask("unmaskedvalue");

        // update diskon_total
        let diskon_total = (subtotal * diskon_persen) / 100;
        $(`#asettetappengadaandetail-${index}-pengadaandetail_diskon_total`)
          .val(diskon_total)
          .trigger("change");

        let hasilSubtotal = 0;
        $(".dynamicform_wrapper .form-options-item").each(function (index) {
          hasilSubtotal += parseInt(
            $(
              `#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`
            ).inputmask("unmaskedvalue")
              ? $(
                  `#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`
                ).inputmask("unmaskedvalue")
              : 0
          );
        });

        $(`#asettetappengadaan-pengadaan_total_sebelum_diskon-disp`)
          .val(hasilSubtotal ? hasilSubtotal : 0)
          .trigger("change");
      });

    $(item)
      .find(".det_diskon_persen")
      .on("input change", function (e) {
        let index = $(e.target).closest("tr").index();

        let diskon_persen = $(
          `#asettetappengadaandetail-${index}-pengadaandetail_diskon_persen`
        ).inputmask("unmaskedvalue");
        let subtotal =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_subtotal-disp`
              ).inputmask("unmaskedvalue");
        let harga_satuan =
          $(
            `#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan`
          ).inputmask("unmaskedvalue") == ""
            ? 0
            : $(
                `#asettetappengadaandetail-${index}-pengadaandetail_harga_satuan`
              ).inputmask("unmaskedvalue");

        // update diskon_total
        let diskon_total = (subtotal * diskon_persen) / 100;
        $(`#asettetappengadaandetail-${index}-pengadaandetail_diskon_total`)
          .val(diskon_total)
          .trigger("change");

        // update harga_beli_sekarang
        let harga_beli_sekarang = (
          harga_satuan -
          (harga_satuan * diskon_persen) / 100
        ).toFixed(2);
        $(
          `#asettetappengadaandetail-${index}-pengadaandetail_harga_beli_sekarang`
        )
          .val(harga_beli_sekarang)
          .trigger("change");

        let hasilTotalDiskon = 0;
        $(".dynamicform_wrapper .form-options-item").each(function (index) {
          hasilTotalDiskon += parseInt(
            $(
              `#asettetappengadaandetail-${index}-pengadaandetail_diskon_total`
            ).inputmask("unmaskedvalue")
          );
        });
        $(`#asettetappengadaan-pengadaan_total_diskon-disp`)
          .val(hasilTotalDiskon)
          .trigger("change");
      });
  });

  $(".dynamicform_wrapper").on("afterDelete", function (e) {
    $(".dynamicform_wrapper .form-options-item").each(function (index) {
      $(this)
        .find(".nomor")
        .html(index + 1);
    });
    $(".det_subtotal").trigger("change");
  });
  $(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("Are you sure you want to delete this item?")) {
        return false;
    }
    return true;
  });
  $(".dynamicform_wrappers").on("beforeDelete", function(e, item) {
    if (! confirm("Are you sure you want to delete this item?")) {
        return false;
    }
    return true;
});
});
