<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

class MonitoringController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ]
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
}
