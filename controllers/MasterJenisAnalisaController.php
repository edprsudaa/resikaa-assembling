<?php

namespace app\controllers;

use app\models\pengolahandata\MasterJenisAnalisa;
use app\models\pengolahandata\MasterJenisAnalisaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MasterJenisAnalisaController implements the CRUD actions for MasterJenisAnalisa model.
 */
class MasterJenisAnalisaController extends Controller
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
     * Lists all MasterJenisAnalisa models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterJenisAnalisaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MasterJenisAnalisa model.
     * @param int $jenis_analisa_id Jenis Analisa ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($jenis_analisa_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($jenis_analisa_id),
        ]);
    }

    /**
     * Creates a new MasterJenisAnalisa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MasterJenisAnalisa();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'jenis_analisa_id' => $model->jenis_analisa_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterJenisAnalisa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $jenis_analisa_id Jenis Analisa ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($jenis_analisa_id)
    {
        $model = $this->findModel($jenis_analisa_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'jenis_analisa_id' => $model->jenis_analisa_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MasterJenisAnalisa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $jenis_analisa_id Jenis Analisa ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($jenis_analisa_id)
    {
        $this->findModel($jenis_analisa_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MasterJenisAnalisa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $jenis_analisa_id Jenis Analisa ID
     * @return MasterJenisAnalisa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($jenis_analisa_id)
    {
        if (($model = MasterJenisAnalisa::findOne(['jenis_analisa_id' => $jenis_analisa_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
