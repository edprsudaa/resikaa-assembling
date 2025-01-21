<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

\hail812\adminlte3\assets\FontAwesomeAsset::register($this);
\hail812\adminlte3\assets\AdminLteAsset::register($this);
\hail812\adminlte3\assets\PluginAsset::register($this)->add(['sweetalert2', 'toastr', 'datatable', 'pace', 'icheck-bootstrap']);

use app\assets\AppAsset;

AppAsset::register($this);
// $this->registerCssFile('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback');

$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <title><?= Html::encode(isset($this->context->title) ? $this->context->title : '') ?></title>
    <?php $this->head() ?>
</head>
<?php $this->beginBody() ?>

<?php echo $content; ?>
<script>
    var base_url = '<?php echo Url::base(); ?>';
</script>
<?php $this->endBody() ?>

</html>
<?php $this->endPage() ?>