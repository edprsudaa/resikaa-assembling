<?php

namespace app\controllers;

use app\models\pengolahandata\MasterItemAnalisa;
use app\models\pengolahandata\MasterJenisAnalisa;
use app\models\pengolahandata\MasterJenisAnalisaDetail;
use app\models\pengolahandata\MasterJenisAnalisaDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MasterJenisAnalisaDetailController implements the CRUD actions for MasterJenisAnalisaDetail model.
 */
class MasterJenisAnalisaDetailController extends Controller
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
     * Lists all MasterJenisAnalisaDetail models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterJenisAnalisaDetailSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $jenisAnalisa = MasterJenisAnalisa::find()->asArray()->all();
        $itemAnalisa = MasterItemAnalisa::find()->asArray()->all();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'jenisAnalisa'=>$jenisAnalisa,
            'itemAnalisa'=>$itemAnalisa,
        ]);
    }

    /**
     * Displays a single MasterJenisAnalisaDetail model.
     * @param int $jenis_analisa_detail_id Jenis Analisa Detail ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($jenis_analisa_detail_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($jenis_analisa_detail_id),
        ]);
    }

    /**
     * Creates a new MasterJenisAnalisaDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MasterJenisAnalisaDetail();
        $jenisAnalisa = MasterJenisAnalisa::find()->asArray()->all();
        $itemAnalisa = MasterItemAnalisa::find()->asArray()->all();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'jenis_analisa_detail_id' => $model->jenis_analisa_detail_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'jenisAnalisa'=>$jenisAnalisa,
            'itemAnalisa'=>$itemAnalisa
        ]);
    }

    /**
     * Updates an existing MasterJenisAnalisaDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $jenis_analisa_detail_id Jenis Analisa Detail ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($jenis_analisa_detail_id)
    {
        $model = $this->findModel($jenis_analisa_detail_id);
        $jenisAnalisa = MasterJenisAnalisa::find()->asArray()->all();
        $itemAnalisa = MasterItemAnalisa::find()->asArray()->all();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'jenis_analisa_detail_id' => $model->jenis_analisa_detail_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'jenisAnalisa'=>$jenisAnalisa,
            'itemAnalisa'=>$itemAnalisa,
        ]);
    }

    /**
     * Deletes an existing MasterJenisAnalisaDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $jenis_analisa_detail_id Jenis Analisa Detail ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($jenis_analisa_detail_id)
    {
        $this->findModel($jenis_analisa_detail_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MasterJenisAnalisaDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $jenis_analisa_detail_id Jenis Analisa Detail ID
     * @return MasterJenisAnalisaDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($jenis_analisa_detail_id)
    {
        if (($model = MasterJenisAnalisaDetail::findOne(['jenis_analisa_detail_id' => $jenis_analisa_detail_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
