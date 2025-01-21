<?php

namespace app\controllers;

use app\models\pengolahandata\MasterItemAnalisa;
use app\models\pengolahandata\MasterItemAnalisaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MasterItemAnalisaController implements the CRUD actions for MasterItemAnalisa model.
 */
class MasterItemAnalisaController extends Controller
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
     * Lists all MasterItemAnalisa models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterItemAnalisaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MasterItemAnalisa model.
     * @param int $item_analisa_id Item Analisa ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($item_analisa_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($item_analisa_id),
        ]);
    }

    /**
     * Creates a new MasterItemAnalisa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MasterItemAnalisa();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'item_analisa_id' => $model->item_analisa_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterItemAnalisa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $item_analisa_id Item Analisa ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($item_analisa_id)
    {
        $model = $this->findModel($item_analisa_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'item_analisa_id' => $model->item_analisa_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MasterItemAnalisa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $item_analisa_id Item Analisa ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($item_analisa_id)
    {
        $this->findModel($item_analisa_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MasterItemAnalisa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $item_analisa_id Item Analisa ID
     * @return MasterItemAnalisa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($item_analisa_id)
    {
        if (($model = MasterItemAnalisa::findOne(['item_analisa_id' => $item_analisa_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
