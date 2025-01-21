var currentRequestAjaxItemPemeriksaan = null; //utk cancel req pedding karna ada req new item pemeriksaan
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
  $(".form-control").addClass("input-sm");
});

paceOptions = {
  elements: false,
  ajax: true,
  restartOnPushState: false,
  restartOnRequestAfter: true,
  // minTime:50000,
  // ghostTime:120000,
  // maxProgressPerFrame:50
};
toastr.options.progressBar = true;
toastr.options.closeButton = true;
toastr.options.timeOut = 5000;
toastr.options.extendedTimeOut = 3000;
// $(document).ajaxStart(function () {
//   Pace.restart();
// });
// $(document).ajaxStop(function () {
//   Pace.stop();
// });

var fmsg = {
  e: function (txt) {
    if (typeof txt == "object") {
      $.each(txt, function (i, v) {
        toastr.error(v).css({ width: "400px", "max-width": "400px" });
      });
    } else {
      toastr.error(txt).css({ width: "400px", "max-width": "400px" });
    }
  },
  s: function (txt) {
    toastr.success(txt).css({ width: "400px", "max-width": "400px" });
  },
  i: function (txt) {
    toastr.info(txt).css({ width: "400px", "max-width": "400px" });
  },
  w: function (txt) {
    if (typeof txt == "object") {
      $.each(txt, function (i, v) {
        toastr.warning(v).css({ width: "400px", "max-width": "400px" });
      });
    } else {
      toastr.warning(txt).css({ width: "400px", "max-width": "400px" });
    }
  },
};
var fbtn = {
  setLoading: function (btn, btn_txt = "") {
    if (btn_txt) {
      $(btn)
        .html('<i class="fas fa-spinner fa-spin"></i>' + btn_txt)
        .attr("disabled", true);
    } else {
      $(btn)
        .html('<i class="fas fa-spinner fa-spin"></i> Proses...')
        .attr("disabled", true);
    }
  },
  resetLoading: function (btn, btn_html) {
    $(btn).html(btn_html).removeAttr("disabled");
  },
};
function formModal(obj) {
  if (obj.loading) {
    fbtn.setLoading(obj.loading.btn, obj.loading.txt ? obj.loading.txt : "");
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
        fbtn.resetLoading(obj.loading.btn, obj.loading.html);
      }
    },
    error: function (xhr, status, error) {
      fmsg.e(error);
      if (obj.loading) {
        fbtn.resetLoading(obj.loading.btn, obj.loading.html);
      }
    },
  });
}
function getUmur(dateString) {
  var now = new Date();
  var today = new Date(now.getYear(), now.getMonth(), now.getDate());

  var yearNow = now.getYear();
  var monthNow = now.getMonth();
  var dateNow = now.getDate();

  var date = dateString.split("-");
  var dob = new Date(date[2], date[1] - 1, date[0]);

  var yearDob = dob.getYear();
  var monthDob = dob.getMonth();
  var dateDob = dob.getDate();
  var age = {};
  var ageString = "";
  var yearString = "";
  var monthString = "";
  var dayString = "";

  yearAge = yearNow - yearDob;

  if (monthNow >= monthDob) var monthAge = monthNow - monthDob;
  else {
    yearAge--;
    var monthAge = 12 + monthNow - monthDob;
  }

  if (dateNow >= dateDob) var dateAge = dateNow - dateDob;
  else {
    monthAge--;
    var dateAge = 31 + dateNow - dateDob;

    if (monthAge < 0) {
      monthAge = 11;
      yearAge--;
    }
  }

  age = {
    years: yearAge,
    months: monthAge,
    days: dateAge,
  };

  if (age.years > 1) yearString = " Tahun";
  else yearString = " Tahun";
  if (age.months > 1) monthString = " Bulan";
  else monthString = " Bulan";
  if (age.days > 1) dayString = " Hari";
  else dayString = " Hari";

  if (age.years > 0 && age.months > 0 && age.days > 0)
    ageString =
      age.years +
      yearString +
      ", " +
      age.months +
      monthString +
      ", " +
      age.days +
      dayString;
  else if (age.years == 0 && age.months == 0 && age.days > 0)
    ageString = age.days + dayString;
  else if (age.years > 0 && age.months == 0 && age.days == 0)
    ageString = age.years + yearString;
  else if (age.years > 0 && age.months > 0 && age.days == 0)
    ageString = age.years + yearString + ", " + age.months + monthString;
  else if (age.years == 0 && age.months > 0 && age.days > 0)
    ageString = age.months + monthString + ", " + age.days + dayString;
  else if (age.years > 0 && age.months == 0 && age.days > 0)
    ageString = age.years + yearString + ", " + age.days + dayString;
  else if (age.years == 0 && age.months > 0 && age.days == 0)
    ageString = age.months + monthString;
  else ageString = "0 Hari";

  return ageString;
}
function iframe(url, content_id) {
  //untuk riwayat kunjungan pasien
  var iframe = document.createElement("iframe");
  iframe.style =
    "width:100%;border:0;height: 100%;overflow:auto;position:relative;z-index:10";
  iframe.src = url;
  // iframe.onload = function () {
  //     $(content_id+" iframe").contents().find('[name=id]').val(id);
  // };
  $(content_id).html(iframe);
  return false;
}
function iframeModal(url, content_id, id) {
  //untuk riwayat kunjungan pasien
  var iframe = document.createElement("iframe");
  iframe.style =
    "width:100%;border:0;height: 100%;overflow:auto;position:relative;z-index:10";
  iframe.src = url;
  iframe.onload = function () {
    $(content_id + " iframe")
      .contents()
      .find("[name=id]")
      .val(id);
  };
  $(content_id + "-content")
    .css("height", "500px")
    .css("html", "500px")
    .html(iframe);
  $(content_id).modal("show");
  return false;
}
