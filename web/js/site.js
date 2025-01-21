$(document).on('click','.btn-refresh',function(e){
    e.preventDefault();
    window.location.reload();
});
//================
//Pace Configuration
//================
paceOptions = {
    // Configuration goes here. Example:
    elements: false,
    ajax:false,
    restartOnPushState: false,
    restartOnRequestAfter: false
}
$.fn.modal.Constructor.prototype.enforceFocus = function() {};

var no_pasien_message="Tidak Ada Data Pasien";

var el = $(document).find("a[data-via='pjax']");

$.each(el,function (i,o) {
   $(o).on('click',function () {
        var active = $(document).find(".gui-controls").find('li.active');
        active.removeClass('active');
        $(this).parent().addClass('active');
   });
});

$(document).ready(function() {
    $('body').on('submit', '#search-bar', function (e) {
        // do something
        e.preventDefault();
        if($(this).find('input').val().length < 1)
        {
            var form = $(this).closest('form');
            if(!form.hasClass('expanded')) {
                form.addClass('expanded');
            }
            form.find('input').focus();
            return false;
        }
        return true;
    });
    // initShortcut();
})

function initShortcut() {
//     $("*").on('keydown', null, 'ctrl+shift+a', function () {
//         $(document).find("#advanced-search-button").click();
//         $(document).find('input[name="Search[rm]"]').focus();
//         return false;
//     });
//     $("*").on('keydown', null, 'f1', function () {
//         setBasic();
//         $(document).find('input[name="Search[rm]"]').focus();
//         return false;
//     });
//     $("*").on('keydown', null, 'f4', function () {
//         if(location.pathname == '/rawat-inap/index'){
//             $("#reset-form-rawatinap").click();
//             $(document).find("input[name='id']").val('');
//             $(document).find("input[name='id']").focus();
//         }else {
//             formClearData();
//         }
//     });
//     $("*").on('keydown', null, 'f2', function () {
//         setAdvance();
//         $(document).find('input[name="Search[rm]"]').focus();
//         return false;
//     });
//     $("*").on('keydown', null, 'f3', function () {
//         $(document).find('#new-pasien').click();
//         $(document).find('#pasien-nama').focus();
//         return false;
//     });
// }

// function formClearData(){
//     setBasic();
//     $(document).find('#new-pasien').click();
//     $(document).find('input[name="Search[rm]"]').val('');
//     $(document).find('input[name="Search[rm]"]').focus();

//     return false;
}

// function setAdvance() {
//     if($("#adv").val() == "B"){
//         $(document).find("#advanced-search-button").click();
//     }
// }
function setBasic() {
    if($("#adv").val() == "A"){
        $(document).find("#advanced-search-button").click();
    }
}

//================
//Toastr Configuration
//================
function resetToastr() {
    toastr.clear();
    toastr.options.closeButton = true;
    toastr.options.progressBar = false;
    toastr.options.debug = false;
    toastr.options.showDuration = 430;
    toastr.options.hideDuration = 330;
    toastr.options.timeOut = 5000;
    toastr.options.extendedTimeOut = 1000;
    toastr.options.showEasing = 'swing';
    toastr.options.hideEasing = 'swing';
    toastr.options.showMethod = 'slideDown';
    toastr.options.hideMethod = 'slideUp';
    toastr.options.positionClass = 'toast-top-right';
}



//================
//Functions
//================
function noConnectionError() {
    resetToastr();
    toastr.error('<i class="fa fa-warning"></i> Tidak Dapat Menghubungkan Ke Server, Harap Periksa Kembali Koneksi Internet Anda.', 'Oooppss.. :(');
}

function setMessage(response) {
    resetToastr();
    if($.isArray(response.d) && response.d != null && response.d != ''){
        $.each(response.d,function (i,m) {
            toastr.info(m);
        });
    }
    if(response.s){
        toastr.success(response.m)
    }else{
        toastr.warning(response.m)
    }
}

// function find(rm) {
//     $(document).find('input[name="Search[rm]"]').val(rm);

//     if($("#adv").val() == "A"){
//         $(document).find("#advanced-search-button").click();
//     }
//     $(document).find('#search-advanced-result').modal('hide');
//     $(document).find("#search-button").click();
// }


function openPopup(url, target, btn, modalID) {
    var iframe = document.createElement('iframe');

    iframe.style = "width:100%;border:0;height: 100%;overflow:auto;position:relative;z-index:10";
    iframe.src = url;

    iframe.onload = function () {
        $(modalID+" iframe").contents().find('[name=target]').val(target);
        $(modalID+" iframe").contents().find('[name=btn]').val(btn);
    };

    $(modalID+"-content").css('height','500px').css('html','500px').html(iframe);
    $(modalID).modal('show');

    return false;
}
function openPopup2(url, target, btn, modalID,id) {
    var iframe = document.createElement('iframe');

    iframe.style = "width:100%;border:0;height: 100%;overflow:auto;position:relative;z-index:10";
    iframe.src = url;

    iframe.onload = function () {
        $(modalID+" iframe").contents().find('[name=target]').val(target);
        $(modalID+" iframe").contents().find('[name=btn]').val(btn);
        $(modalID+" iframe").contents().find('[name=id]').val(id);
    };

    $(modalID+"-content").css('height','500px').css('html','500px').html(iframe);
    $(modalID).modal('show');

    return false;
}
function openPopupListTindakan(url, target, btn, modalID,rawatpoli,masrawat) {
    var iframe = document.createElement('iframe');

    iframe.style = "width:100%;border:0;height: 100%;overflow:auto;position:relative;z-index:10";
    iframe.src = url;

    iframe.onload = function () {
        $(modalID+" iframe").contents().find('[name=target]').val(target);
        $(modalID+" iframe").contents().find('[name=btn]').val(btn);
        $(modalID+" iframe").contents().find('[name=rawatpoli]').val(rawatpoli);
        $(modalID+" iframe").contents().find('[name=masrawat]').val(masrawat);
    };

    $(modalID+"-content").css('height','500px').css('html','500px').html(iframe);
    $(modalID).modal('show');

    return false;
}
function openPopup3(url,modalID,id) {
    //untuk riwayat kunjungan pasien
    var iframe = document.createElement('iframe');
    iframe.style = "width:100%;border:0;height: 100%;overflow:auto;position:relative;z-index:10";
    iframe.src = url;
    iframe.onload = function () {
        $(modalID+" iframe").contents().find('[name=id]').val(id);
    };
    $(modalID+"-content").css('height','500px').css('html','500px').html(iframe);
    $(modalID).modal('show');

    return false;
}

// function findSearch(rm){
//     $(document).find('#Search1 [name=id]').val(rm);
//     $(document).find('#Search1 [type=submit]').trigger('click');
// }


// var antrian = {
//     status : true,
//
//     init : function () {
//         antrian.start();
//     },
//
//     stop : function () {
//         antrian.status = false;
//     },
//
//     start : function () {
//             antrian.load();
//             var l = setInterval(function () {
//                 if(antrian.status == false){
//                     clearInterval(l);
//                 }else {
//                     antrian.load();
//                 }
//             },5000);
//     },
//
//     load : function () {
//         $(".antrian-btn-refresh").button('loading');
//         $.get(urlAntrian,function (r) {
//             if(r.s){
//                 antrian.setUpPayload(r.d)
//             }
//         }).always(function () {
//             $(".antrian-btn-refresh").button('reset');
//         })
//     },
//
//     setUpPayload : function(payload)
//     {
//         $(".antrian-current").html(payload.c);
//         $(".antrian-current-top").html(payload.c);
//         $(".antrian-max").html(payload.m);
//         $(".antrian-left").html(payload.l);
//     }
// }

var zebra = {
    print : function (data) {
        BrowserPrint.getDefaultDevice('printer', function(printer)
            {
                if((printer != null) && (printer.connection != undefined))
                {
                    printer.send(data);
                }
                else{
                    alert("No Printer Found");
                }
            },
            function(error_response)
            {
                // This alert doesn't pop either
                alert(	"An error occured while attempting to connect to your Zebra Printer. " +
                    "You may not have Zebra Browser Print installed, or it may not be running. " +
                    "Install Zebra Browser Print, or start the Zebra Browser Print Service, and try again.");
            }
        );
    }
}