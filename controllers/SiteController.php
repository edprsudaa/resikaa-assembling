<?php

namespace app\controllers;

use app\components\Akun;
use app\components\Helper;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\sso\LoginForm;
use app\models\sso\User;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            $role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());

            return $this->render('index');
        } else {
            $url = 'http://sso.simrs.aa/';
            return $this->redirect($url);
        }
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionLogin()
    {
        $this->layout = "login";
        if (!Yii::$app->user->isGuest) {
            $role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
            if (isset($role['Dokter'])) {
                return $this->redirect(['dokter/index']);
            } else {
                return $this->redirect(['antrian/index']);
            }
        }
        $model = new LoginForm();
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    function actionLoginDo()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return Helper::createResponse(true);
            } else {
                return Helper::createResponse(false, $model->errors);
            }
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('http://sso.simrs.aa/keluar');
    }

    function actionAkunForm()
    {
        $model = User::findOne(Akun::user()->id);
        $model->scenario = "akun_update";
        $model->pgw_password_hash = NULL;
        return $this->render('akun_form', [
            'model' => $model,
        ]);
    }
}
