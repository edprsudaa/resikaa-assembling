<?php

namespace app\widgets;

use yii\base\Widget;

class PreviewDokumen extends Widget
{
  public $url;

  public function init()
  {
    parent::init();
  }

  public function run()
  {
    return $this->render('preview-dokumen-html', ['url' => $this->url]);
  }
}
