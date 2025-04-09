<?php

namespace app\controllers;

use app\components\Akun;
use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;
use app\components\MakeResponse;
use app\models\medis\ResumeMedisRi;
use app\models\pendaftaran\Layanan;
use app\models\pendaftaran\Registrasi;
use app\models\search\RawatInapSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DokterVerifikatorRawatInapController implements the CRUD actions for Layanan model.
 */
class DokterVerifikatorRawatInapController extends Controller
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
    public function actionList()
    {
        $searchModel = new RawatInapSearch(); // ← pastikan nama class search benar
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex($id)
    {
        $title = 'Dokter Verifikator Rawat Inap';
        $get_url_view = [];
        $cek_manual = [];

        if (!is_numeric($id)) {
            $id = HelperGeneralClass::validateData($id);
        }
        $chk_pasien = HelperSpesialClass::getCheckPasienLayanan($id);

        if (!$chk_pasien->status) {
            \Yii::$app->session->setFlash('warning', $chk_pasien->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }



        // Cek data pembatalan operasi apakah ada
        $cek = $this->initModelUpdateAuto($id);


        // Jika ada
        if ($cek) {
            $data = $this->initModelUpdate($cek['id']);
            // get api view
            if ($data->id_dokumen_rme) {
                $cek_manual = Yii::$app->db->createCommand("select manual_dokumen,sign_finish from sign.dokumen_rme where id_dokumen_rme='$data->id_dokumen_rme'")->queryOne();
                $get_url_view = $this->view($data->id_dokumen_rme);
            }
        } else {
            $data = $this->initModelCreate();
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('index', [
                'title' => $title,
                'model' => $data,
                'layanan' => $chk_pasien->data,
                'viewrme' => $get_url_view,
                'cek_manual' => $cek_manual,
                'datalist' => $this->findData($id),
            ]);
        } else {
            $this->layout = 'main-pasien';
            return $this->render('index', [
                'title' => $title,
                'model' => $data,
                'layanan' => $chk_pasien->data,
                'viewrme' => $get_url_view,
                'cek_manual' => $cek_manual,
                'datalist' => $this->findData($id),
            ]);
        }
    }
    protected function initModelUpdateAuto($id)
    {
        $query = ResumeMedisRi::find()
            ->where(['layanan_id' => $id, 'is_deleted' => 0])
            ->orderBy(['created_at' => SORT_DESC]);

        // if ((Akun::user()->username != Yii::$app->params['nik_pemilik'])) {
        //     $query->andWhere(['created_by' => Akun::user()->id]);
        // }
        return $query->one();
    }
    //update & batalkan
    public function actionUpdate($id, $subid)
    {
        $title = ResumeMedisRi::judul;
        $get_url_view = [];
        $cek_manual = [];

        if (!is_numeric($id)) {
            $id = HelperGeneralClass::validateData($id);
        }
        $chk_pasien = HelperSpesialClass::getCheckPasienLayanan($id);
        if (!$chk_pasien->status) {
            return $this->redirect(Url::to(['/site/index/']));
        }

        $model = $this->initModelUpdate($subid);


        if ($model->id_dokumen_rme) { // jika ada dokumen rme nya
            $cek_manual = Yii::$app->db->createCommand("select manual_dokumen,sign_finish from sign.dokumen_rme where id_dokumen_rme='$model->id_dokumen_rme'")->queryOne();
            $get_url_view = $this->view($model->id_dokumen_rme);
        }


        // echo '<pre>';
        // print_r($this->findData($model->layanan_id));
        // die;
        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('index', [
                'title' => $title,
                'model' => $model,
                'layanan' => $chk_pasien->data,
                'viewrme' => $get_url_view,
                'cek_manual' => $cek_manual,
                'datalist' => $this->findData($model->layanan_id),
            ]);
        } else {
            $this->layout = 'main-pasien';
            return $this->render('index', [
                'title' => $title,
                'model' => $model,
                'layanan' => $chk_pasien->data,
                'viewrme' => $get_url_view,
                'cek_manual' => $cek_manual,
                'datalist' => $this->findData($model->layanan_id),
            ]);
        }
    }

    protected function initModelCreate()
    {
        $model = new ResumeMedisRi();
        return $model;
    }
    protected function initModelUpdate($subid)
    {
        return ResumeMedisRi::find()->where(['id' => $subid])->andWhere(['is_deleted' => 0])->orderBy(['created_at' => SORT_DESC])->one();
    }

    public function actionSaveUpdate($subid)
    {
        $title = 'Updated ' . ResumeMedisRi::judul;
        $model = $this->findModel($subid);


        if ($model->load(Yii::$app->request->post())) {
            // $model->lap_op_laporan = str_replace(["<<", ">>"], ["<", ">"], $model->lap_op_laporan);
            // $model->lap_op_instruksi_prwt_pasca_operasi = str_replace(["<<", ">>"], ["<", ">"], $model->lap_op_instruksi_prwt_pasca_operasi);

            if ($model->validate()) {
                if ($model->tanggal_final && !$model->batal) {
                    return MakeResponse::create(true, '', ['konfirm_final' => true, 'konfirm_batal' => false]);
                } else if ($model->tanggal_final && $model->lap_op_batal) {
                    return MakeResponse::create(true, '', ['konfirm_final' => false, 'konfirm_batal' => true]);
                } else {
                    $save = $this->save($title,  $model, []);
                    if ($save->status) {
                        return MakeResponse::create(true, $save->msg, ['konfirm_final' => false, 'konfirm_batal' => false]);
                    } else {
                        return MakeResponse::create(false, $save->msg);
                    }
                }
            } else {
                return MakeResponse::create(false, 'Data Gagal Disimpan', $model->errors);
            }
        }
    }
    public function actionSaveUpdateFinal($subid)
    {
        $title = 'Finalized ' . ResumeMedisRi::judul;
        //init model
        $model = $this->findModel($subid);



        if ($model->load(Yii::$app->request->post())) {


            if ($model->validate()) {
                $save = $this->save($title, $model, [], true, false, false);
                if ($save->status) {
                    return MakeResponse::create(true, $save->msg);
                } else {
                    return MakeResponse::create(false, $save->msg);
                }
            } else {
                return MakeResponse::create(false, 'Data Gagal Disimpan', $model->errors);
            }
        }
    }

    protected function view($id_dokumen_rme)
    {
        $baseUrl = Yii::$app->params['storage-monitoring']['base-url'];
        $urlApiView =  $baseUrl . Yii::$app->params['storage-monitoring']['view-dokumen'];

        $dataView = [
            'idDokumenRme' => $id_dokumen_rme,
            'cetak' => 0,
            'userId' => Akun::user()->id
        ];
        // Hit API View pada $viewPdf
        return Yii::$app->ApiComponent->run($urlApiView, $dataView);
    }
    public function actionPrint($id_dokumen_rme)
    {
        if (!is_numeric($id_dokumen_rme)) {
            $id_dokumen_rme = HelperGeneralClass::validateData($id_dokumen_rme);
        }
        $baseUrl = Yii::$app->params['storage-monitoring']['base-url'];
        $urlApiView =  $baseUrl . Yii::$app->params['storage-monitoring']['view-dokumen'];

        $dataView = [
            'idDokumenRme' => $id_dokumen_rme,
            'cetak' => 1,
            'userId' => Akun::user()->id
        ];
        // Hit API View pada $viewPdf
        $viewPdf = Yii::$app->ApiComponent->run($urlApiView, $dataView);
        return json_encode($viewPdf);
    }

    protected function findData($id)
    {
        $query = ResumeMedisRi::find()->joinWith(['layanan' => function ($q) {
            $q->joinWith('registrasi');
        }])->where([Layanan::tableName() . '.id' => $id])
            ->orderBy([ResumeMedisRi::tableName() . '.created_at' => SORT_DESC]);
        return $query->asArray()->all();
    }

    protected function findModel($id)
    {
        if (($model = ResumeMedisRi::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    private function save($title,  $model, $modelDetail, $final = false, $batal = false, $hapus = false, $alasan_batal = '')
    {
        $transaction = ResumeMedisRi::getDb()->beginTransaction();
        try {
            $s_flag = true;
            $m_flag = $title . ' Berhasil Disimpan';
            //save
            if (!($s_flag = $model->save(false))) {
                $m_flag = $title . ' Gagal Disimpan..';
            }

            //send TTE
            if ($s_flag && $final && Yii::$app->params['fitur']['resume_medis_ri']) {
                $dokterId = [$model->dokter_id]; // data id pegawai dokter
                $userId = Yii::$app->user->identity->id; // data id user yang login/dokter karna dokter yang mencetak

                $baseUrl = Yii::$app->params['storage-monitoring']['base-url'];
                $urlApiCek =  $baseUrl . Yii::$app->params['storage-monitoring']['cek-support-tte'];
                $urlApiKirim = $baseUrl . Yii::$app->params['storage-monitoring']['kirim-storage'];
                $urlUpdateDokumen = $baseUrl . Yii::$app->params['storage-monitoring']['update-dokumen'];

                // Persiapkan Data untuk dikirim ke API Init untuk cek apakah Dokumen dan Dokter Support untuk Sign
                $dataCekBsre = [
                    'dokumenKode' => Yii::$app->params['tte']['kode-dokumen']['resume_medis_ri'],
                    'dokterId' => $dokterId,
                    'userId' => $userId
                ];
                // Hit API Init dan Simpan result ke $cekBsre
                $cekBsre = Yii::$app->ApiComponent->run($urlApiCek, $dataCekBsre);

                if ($cekBsre->status == false) {
                    $s_flag = false;
                    $m_flag = "$cekBsre->message, $cekBsre->error";
                }

                // Siapkan Variable untuk parameter preview pdf
                $paramPreviewPdf = [
                    'id' => $model->id,
                    // 'cetak' => null,
                    // 'returnContent' => true,
                ];

                // Cek apakah return jenis dokumen 'manual' atau 'tte'
                if ($cekBsre->data->jenis == 'tte') {
                    // Tambah Parameter markTte agar html dokumen memiliki mark untuk tempat barcode tanda tangan online
                    $paramPreviewPdf['markTte'] = $cekBsre->data->mark;
                }

                // Run Method untuk membuat html PDF
                $htmlDokument = $this->runAction('dokumen-pdf', $paramPreviewPdf);

                // Ambil data jenis dari hasil API init
                $jenisDokumen = $cekBsre->data->jenis;

                // Inisialisasi Tanggal Final
                $tglFinal = date('Y-m-d H:i:s');

                // Siapkan data untuk index "dataTable" pada array Data yang akan dikirim ke API Kirim Storage
                $table = [
                    'dokumen_kode' => Yii::$app->params['tte']['kode-dokumen']['resume_medis_ri'],
                    'schema_name' => 'medis',
                    'table_name' => 'resume_medis_ri',
                    'table_primary' => 'id',
                    'id_dokumen' => $model->id,
                    'tgl_final' => $model->tanggal_final,
                    'version' => Yii::$app->params['tte']['versi']['resume_medis_ri'],
                    'orientasi' => 'p'
                ];

                // Siapkan data yang akan dikirim ke API Kirim Storage
                $dataKirimStorage = [
                    'layanan' => $model->layanan->id,
                    'dokter' => $dokterId,
                    'jenis' => $jenisDokumen,
                    'userId' => $userId,
                    'dataTable' => $table,
                    'htmlDokumen' => $htmlDokument
                ];


                $paramUpdateRme = [
                    'id_dokumen_rme' => $model->id_dokumen_rme,
                    'tgl_final' => date('Y-m-d H:i:s'),
                    'version' => Yii::$app->params['tte']['versi']['resume_medis_ri'],
                    'orientasi' => 'p',
                    'userId' => Yii::$app->user->id,
                    'htmlDokumen' => $htmlDokument
                ];

                // Hit API Kirim Storage dan simpan result
                if ($s_flag) {
                    if (empty($model->id_dokumen_rme)) {
                        $sendStorage = Yii::$app->ApiComponent->run($urlApiKirim, $dataKirimStorage);
                    } else {
                        $sendStorage = Yii::$app->ApiComponent->run($urlUpdateDokumen, $paramUpdateRme);
                    }


                    if (!$sendStorage || !$sendStorage->status) {

                        $s_flag = false;
                        $m_flag = $sendStorage->message;
                    }
                }


                // throw new Exception("test error");
                if ($s_flag) {
                    // Ambil id_dokumen_rme dari result API 
                    $idDokumenRme = $sendStorage->data->id_dokumen_rme;

                    $model->id_dokumen_rme = $idDokumenRme;
                    $model->dokter_verifikator_by = HelperSpesialClass::getUserLogin()['pegawai_id'];
                    $model->edit_verifikator = 1;

                    // save laporan operasi lagi untuk menyimpan field id_dokumen_rme
                    if (!($s_flag = $model->save(false))) {
                        $m_flag = "id dokumen RME dan versi dokumen gagal disimpan !!";
                    }
                }
            }
            //batal dokumen RME
            if ($s_flag && $batal && $alasan_batal) {
                //hit API

                $sendbatal = $this->batalRme($model->id_dokumen_rme, $alasan_batal);
                if (!$sendbatal || !$sendbatal->status) {
                    $s_flag = false;
                    $m_flag = $sendbatal->message;
                } else {
                    $m_flag = $sendbatal->message;
                }
            }
            //cek finalisasi save
            if ($s_flag) {

                $transaction->commit();
                return MakeResponse::createNotJson(true, $m_flag, ['id' => $model->id]);
            } else {
                $transaction->rollBack();
                return MakeResponse::createNotJson(false, $m_flag);
            }
        } catch (\Throwable $e) {
            $transaction->rollBack();
            return MakeResponse::createNotJson(false, 'Data Gagal Disimpan Karna : ' . $e);
        }
    }

    public function actionCopy($id, $subid)
    {
        $title = ResumeMedisRi::judul;

        if (!is_numeric($id)) {
            $id = HelperGeneralClass::validateData($id);
        }

        $chk_pasien = HelperSpesialClass::getCheckPasienLayanan($id);
        if (!$chk_pasien->status) {
            // \Yii::$app->session->setFlash('warning', $chk_pasien->msg);
            return $this->redirect(Url::to(['/site/index/']));
        }

        $model = $this->findModel($subid);
        $modelNew = new ResumeMedisRi();

        $modelNew->setAttributes($model->getAttributes(), false);
        unset($modelNew->id);
        unset($modelNew->created_at);
        unset($modelNew->created_by);
        unset($modelNew->updated_at);
        unset($modelNew->updated_by);
        unset($modelNew->versi);
        unset($modelNew->id_dokumen_rme);

        if ($modelNew->save(false)) {
            return $this->redirect(Url::to(['/dokter-verifikator-rawat-inap/update/', 'id' => HelperGeneralClass::hashData($id), 'subid' => $modelNew->id]));
        } else {
            return $this->redirect(Url::to(['/dokter-verifikator-rawat-inap/index/', 'id' => HelperGeneralClass::hashData($id)]));
        }
    }
    public function actionDokumenPdf($id, $markTte = null)
    {
        $model = ResumeMedisRi::find()->joinWith([
            'dokter',
            'unitTujuan',
            'diagmasuk',
            'diagutama',
            'diagsatu',
            'diagdua',
            'diagtiga',
            'diagempat',
            'diaglima',
            'diagenam',
            'tindutama',
            'tindsatu',
            'tinddua',
            'tindtiga',
            'tindempat',
            'tindlima',
            'tindenam',
            'layananPulang' => function ($q) {
                $q->joinWith(['unit']);
            },
            'layanan' => function ($q) {
                $q->joinWith(['registrasi' => function ($query) {
                    $query->joinWith('pasien', 'debiturDetail');
                }]);
            }
        ])
            ->where([ResumeMedisRi::tableName() . '.id' => $id])->nobatal()->orderBy(['created_at' => SORT_DESC])->one();
        $chk_pasien = HelperSpesialClass::getCheckPasien($id);
        return $this->renderPartial('/dokter-verifikator-rawat-inap/doc', [
            'model' => $model,
            'mark_tte' => $markTte
        ]);
    }
}
