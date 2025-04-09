<?php

use app\assets\PdfAsset;

PdfAsset::register($this);

$this->registerJs("
var url = '" . $url . "';

loadPdfByUrl(url)
");

?>

<div class="row" style="text-align: center;">
    <div class="col-4 mb-2">
        <button class="btn btn-sm btn-primary float-left" id="btn-before-page-pdf" data-page="" data-total="" onclick="changePage('before')">
            <i class="fa fa-angle-left"></i> Halaman Sebelumnya
        </button>
    </div>
    <div class="col-4 mb-2">
        <center>Page <span id="page-pdf-now"></span> / <span id="total-page-pdf"></span></center>
    </div>
    <div class="col-4 mb-2">
        <button class="btn btn-sm btn-primary float-right" id="btn-next-page-pdf" data-page="" data-total="" onclick="changePage('next')">
            Halaman Berikutnya <i class="fa fa-angle-right"></i>
        </button>
    </div>
    <div class="col-12" id="pdf-canvas">
        <div id="pdf-canvas-loading">
            <div class="spinner-border mt-4" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <h1> Sedang Memuat Dokumen</h1>
        </div>
    </div>
</div>

<script>
    function loadPdfByUrl(url) {
        $('#pdf-canvas-loading').removeClass('d-none')

        const startTime = performance.now();
        var loadingTask = pdfjsLib.getDocument(url);

        loadingTask.promise.then(function(pdf) {
            const endTime = performance.now();
            const timeTaken = (endTime - startTime) / 1000;
            console.log(`PDF Loaded in ${timeTaken.toFixed(2)} seconds`);

            var totalPages = pdf.numPages;

            for (let pageNumber = 1; pageNumber <= totalPages; pageNumber++) {
                pdf.getPage(pageNumber).then(function(page) {
                    console.log(`Page ${pageNumber} loaded`);

                    var viewport = page.getViewport({
                        scale: 3
                    });

                    // Prepare canvas using PDF page dimensions
                    var canvas = document.createElement('canvas');
                    canvas.id = `pdf-canvas-${pageNumber}`;
                    canvas.style = `border: 2px solid #000; border-radius: 4px; padding: 10px; width: 100%; max-width: 100%; height: auto; max-height: 100%;`;

                    canvas.classList.add(`pdf-canvas-preview`);
                    if (pageNumber > 1) {
                        canvas.classList.add(`d-none`);
                    }

                    var canvasBase = document.getElementById('pdf-canvas')
                    canvasBase.appendChild(canvas)

                    var context = canvas.getContext('2d');

                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    // Render PDF page into canvas context
                    var renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };
                    page.render(renderContext).promise.then(function() {
                        console.log(`Page ${pageNumber} rendered`);
                    });
                });
            }
            setBtnNextBeforePdf(1, totalPages)

            $('#pdf-canvas-loading').addClass('d-none')
        }, function(reason) {
            console.error(reason);
        });
    }

    function setBtnNextBeforePdf(pageNow, totalPage) {
        pageNow = parseInt(pageNow);
        totalPage = parseInt(totalPage);

        if (pageNow === totalPage) {
            $('#btn-next-page-pdf').attr('disabled', true);
            $('#btn-next-page-pdf').attr('data-page', null);
            $('#btn-next-page-pdf').attr('data-total', null);
        } else {
            $('#btn-next-page-pdf').attr('disabled', false);
            $('#btn-next-page-pdf').attr('data-page', pageNow + 1);
            $('#btn-next-page-pdf').attr('data-total', totalPage);
        }

        if (--pageNow === 0) {
            $('#btn-before-page-pdf').attr('disabled', true);
            $('#btn-before-page-pdf').attr('data-page', null);
            $('#btn-before-page-pdf').attr('data-total', null);
        } else {
            $('#btn-before-page-pdf').attr('disabled', false);
            $('#btn-before-page-pdf').attr('data-page', pageNow);
            $('#btn-before-page-pdf').attr('data-total', totalPage);
        }

        $('#page-pdf-now').html(pageNow + 1)
        $('#total-page-pdf').html(totalPage)
    }

    function changePage(btn) {
        let button = $('#btn-' + btn + '-page-pdf');
        let page = button.attr('data-page')
        let total = button.attr('data-total')

        button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');

        $('.pdf-canvas-preview').addClass('d-none')
        $('#pdf-canvas-' + page).removeClass('d-none')

        setBtnNextBeforePdf(page, total);

        if (btn == 'next') {
            button.html('Halaman Berikutnya <i class="fa fa-angle-right"></i>');
        } else {
            button.html('<i class="fa fa-angle-left"></i> Halaman Sebelumnya');
        }
    }
</script>