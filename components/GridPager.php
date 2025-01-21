<?php
namespace app\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class GridPager extends \yii\widgets\LinkPager
{
    
    public $firstPageLabel = '<span class="fas fa-chevron-circle-up"></span>';
    public $lastPageLabel = '<span class="fas fa-chevron-circle-down"></span>';

    public $prevPageLabel = '<span class="fas fa-chevron-circle-left"></span>';
    public $nextPageLabel = '<span class="fas fa-chevron-circle-right"></span>';

    public $options = ['class' => 'pagination pagination-rounded'];

    public $linkContainerOptions = ['class' => 'page-item'];

    public $linkOptions = ['class' => 'page-link'];

    public $disabledListItemSubTagOptions = ['class' => 'page-link'];

    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = $this->linkContainerOptions;
        $linkWrapTag = ArrayHelper::remove($options, 'tag', 'li');
        Html::addCssClass($options, empty($class) ? $this->pageCssClass : $class);

        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);
            $disabledItemOptions = $this->disabledListItemSubTagOptions;
            $tag = ArrayHelper::remove($disabledItemOptions, 'tag', 'a');

            return Html::tag($linkWrapTag, Html::tag($tag, $label, $disabledItemOptions), $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;

        return Html::tag($linkWrapTag, Html::a($label, $this->pagination->createUrl($page), $linkOptions), $options);
    }
}
