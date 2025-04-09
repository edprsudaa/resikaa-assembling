<?php

namespace app\assets;

use yii\web\AssetBundle;

class PdfAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $js = [
    'js/pdfjs/pdf.min.js',
    'js/pdfjs/pdf.worker.min.js',
  ];

  public $jsOptions = [
    'position' => \yii\web\View::POS_HEAD,
  ];

  public function init()
  {
    parent::init();
    // Set the workerSrc for PDF.js
    $this->js[] = 'js/pdfjs/setup.js'; // A custom JavaScript file to set the workerSrc
  }
}
