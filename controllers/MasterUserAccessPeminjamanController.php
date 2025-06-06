<?php

namespace app\controllers;

use app\models\pegawai\Pegawai;
use app\models\pengolahandata\MasterIpPeminjaman;
use app\models\pengolahandata\MasterUserAccessPeminjamanSearch;
use app\models\pengolahandata\MasterUserAccessPeminjaman;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MasterUserAccessPeminjamanController implements the CRUD actions for MasterUserAccessPeminjaman model.
 */
class MasterUserAccessPeminjamanController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all MasterUserAccessPeminjaman models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterUserAccessPeminjamanSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MasterUserAccessPeminjaman model.
     * @param int $id Item Analisa ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MasterUserAccessPeminjaman model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MasterUserAccessPeminjaman();

        if ($model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            var_dump($model->errors); // Ini akan menampilkan error validasi jika ada
        }


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterUserAccessPeminjaman model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id Item Analisa ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MasterUserAccessPeminjaman model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id Item Analisa ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = MasterUserAccessPeminjaman::find()->where(['id' => $id])->one();

        $model->deleted_by = Yii::$app->user->identity->id;
        $model->deleted_at = date('Y-m-d H:i:s');
        $model->save(false);

        return $this->redirect(['index']);
    }
    public function actionPegawai()
    {
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post = Yii::$app->request->post();
            if (!empty($post)) {
                $out['results'] = array_values(Pegawai::getListPegawaiPeminjaman($post['term']));
                return $out;
            }
        }
        return false;
    }

    public function actionIpAddress()
    {
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post = Yii::$app->request->post();
            if (!empty($post)) {
                $out['results'] = array_values(MasterIpPeminjaman::getListIpPeminjaman($post['term']));
                return $out;
            }
        }
        return false;
    }

    /**
     * Finds the MasterUserAccessPeminjaman model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Item Analisa ID
     * @return MasterUserAccessPeminjaman the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterUserAccessPeminjaman::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
