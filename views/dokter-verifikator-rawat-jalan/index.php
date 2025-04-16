<?php
// echo '<pre>';
// print_r($cek_manual);
// die;
$this->title = (($model->isNewRecord) ? "Tambah " . $title : "Ubah " . $title);
$this->params['breadcrumbs'][] = $this->title;
if (!\Yii::$app->request->isAjax) {
  echo $this->render('../layouts/card-pasien.php', ['layanan' => $layanan]);
}
?>

<div class="page-form-<?= $model->formName() ?>">
  <?php


  if (!$model->isNewRecord) {
    // echo '<pre>';
    // print_r(!$cek_manual['sign_finish']);
    // die;
    if (!empty($viewrme) && $viewrme->status && $cek_manual['sign_finish'] == 1) {

      $this->title = "View Resume Medis Rawat Jalan";
      $this->params['breadcrumbs'][] = $this->title;
      echo $this->render('view_rme', [
        'title' => $title,
        'model' => $model,
        'datalist' => $datalist,
        'viewrme' => $viewrme,
        'cek_manual' => $cek_manual,
      ]);
    } else {
      echo $this->render('_form_update', [
        'title' => $title,
        'model' => $model,
        'datalist' => $datalist,
      ]);
    }
  } else {
    echo $this->render('_form_create', [
      'title' => $title,
      'model' => $model,
      'datalist' => $datalist,
    ]);
  }
  ?>
</div>