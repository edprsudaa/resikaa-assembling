<?php
namespace app\components;
use Yii;
use yii\helpers\Html;
class ActionColumn extends \yii\grid\ActionColumn
{
    public $headerOptions = [
        'class' => 'action-column',
        'style' => 'min-width: 140px; text-align: center;'
    ];

    public $options = [
        'options' => ['style' => 'text-align: center'],
    ];

    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'fas fa-eye fa-xs');
        $this->initDefaultButton('update', 'fas fa-edit fa-xs');
        $this->initDefaultButton('delete', 'fas fa-trash fa-xs', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ]);
    }

    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'View');
                        $class = 'btn btn-info btn-xs';
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        $class = 'btn btn-warning btn-xs';
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        $class = 'btn btn-danger btn-xs';
                        break;
                    default:
                        $title = ucfirst($name);
                }
                $options = array_merge([
                    'title' => $title,
                    'class' => $class,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('span', '', ['class' => "mdi $iconName"]);
                return Html::a($icon, $url, $options);
            };
        }
    }

}