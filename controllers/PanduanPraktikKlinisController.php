<?php

namespace app\controllers;


use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;
use app\components\Model;

use Yii;

use app\models\pegawai\Pegawai;
use app\models\pendaftaran\Layanan;
use app\models\pendaftaran\Pasien;
use app\models\pendaftaran\Registrasi;
use app\models\pengolahandata\PanduanPraktikKlinis;
use app\models\pengolahandata\DetailPeminjamanRekamMedis;
use app\models\pengolahandata\Log;
use app\models\pengolahandata\PeminjamanRekamMedis;

use yii\base\Exception;

use yii\filters\AccessControl;
use yii\web\Controller;

use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class PanduanPraktikKlinisController extends Controller
{
    /**
     * {@inheritdoc}
     */
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::className(),
    //             'rules' => [
    //                 [
    //                     'allow' => true,
    //                     'roles' => ['@'],
    //                 ],
    //                 [
    //                     'actions' => ['generate-list-pasien-external'],
    //                     'allow' => true,
    //                     'roles' => ['?', '@'], // '?' for guest users, '@' for authenticated users
    //                 ],
    //             ]
    //         ]
    //     ];
    // }
    /**
     * Lists all Distribusi models.
     * @return mixed
     */


    public function actionList()
    {
        if (HelperSpesialClass::isProgrammer() || HelperSpesialClass::isPengolahanData() || HelperSpesialClass::isAksesDaftarPasien()) {

            return $this->render('list', []);
        } else {
            throw new NotFoundHttpException('Halaman yang dituju tidak ditemukan, silahkan hubungi IT Administrator');
        }
    }



    public function actionDaftar()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request->post("datatables");
        $connection = \Yii::$app->db;


        $sql = "SELECT * FROM pengolahan_data.panduan_praktik_klinis ppk ";

        $command = $connection->createCommand($sql);
        $results = $command->queryAll();

        return [
            "status" => 200,
            "message" => "Data successfully retrieved",
            "data" => $results
        ];
    }





    public function actionCreate()
    {



        $model = new PanduanPraktikKlinis();


        return $this->render(
            'panduan',
            [
                'model' => $model,
            ]
        );
    }

    public function actionPanduan()
    {
        $this->layout = 'main-panduan';


        $model = PanduanPraktikKlinis::find()->where(['deleted_at' => null])->all();


        return $this->render(
            'panduan_page',
            [
                'model' => $model,
            ]
        );
    }

    public function actionUpdate($id = null)
    {
        $model = PanduanPraktikKlinis::find()->where(['id' => $id])->one();
        if (!$model) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }


        return $this->render(
            'panduan',
            [
                'model' => $model,
            ]
        );
    }



    public function actionSave()
    {
        $request = Yii::$app->request->post('PanduanPraktikKlinis');

        if (isset($request['id']) && $request['id'] != null) {
            $model = PanduanPraktikKlinis::findOne($request['id']);
            if ($model === null) {
                return $this->asJson(['status' => false, 'msg' => 'Data tidak ditemukan.']);
            }
        } else {
            $model = new PanduanPraktikKlinis();
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate(false)) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $file = UploadedFile::getInstance($model, 'file_upload');
                    if ($file) {
                        // Hapus file lama jika ada
                        if ($model->file_upload) {
                            @unlink(Yii::$app->params['storage']['panduan-praktik-klinis'] . $model->file_upload);
                        }

                        $fileName = $file->name;
                        $nama_file = hash('md5', $fileName);
                        $filePath = Yii::$app->params['storage']['panduan-praktik-klinis'] . $nama_file . '.' . $file->extension;
                        $file->saveAs($filePath);

                        $model->file_upload = $nama_file . '.' . $file->extension;
                    }

                    if ($model->save(false)) {
                        $transaction->commit();
                        return $this->asJson(['status' => true, 'msg' => 'Data Berhasil Disimpan']);
                    } else {
                        $transaction->rollBack();
                        return $this->asJson(['status' => false, 'msg' => 'Data Gagal Disimpan!']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    return $this->asJson(['status' => false, 'msg' => 'Terjadi kesalahan: ' . $e->getMessage()]);
                }
            } else {
                return $this->asJson(['status' => false, 'msg' => $model->errors]);
            }
        } else {
            return $this->asJson(['status' => false, 'msg' => 'Data tidak valid.']);
        }
    }





    function actionDokumen($id)
    {
        $model = PanduanPraktikKlinis::find()->select('file_upload')->where(['id' => $id])->asArray()->limit(1)->one();
        if ($model != NULL) {
            if (file_exists(Yii::$app->params['storage']['panduan-praktik-klinis'] . $model['file_upload']) && is_file(Yii::$app->params['storage']['panduan-praktik-klinis'] . $model['file_upload'])) {
                return Yii::$app->response->sendFile(Yii::$app->params['storage']['panduan-praktik-klinis'] . $model['file_upload'], $model['file_upload'], ['inline' => true]);
            }
            throw new NotFoundHttpException('Photo tidak ditemukan');
        }
        throw new NotFoundHttpException('Data tidak ditemukan');
    }



    public function actionDelete()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // Menangkap data yang dipost
        $id = Yii::$app->request->post('id');
        $transaction = Yii::$app->db->beginTransaction();
        try {
            // Temukan model berdasarkan ID
            $model = PanduanPraktikKlinis::findOne($id);

            if (!$model) {
                throw new NotFoundHttpException('Data tidak ditemukan.');
            }

            // Update kolom deleted_at dan deleted_by pada model utama
            $model->deleted_at = date('Y-m-d H:i:s'); // Set waktu saat ini
            $model->deleted_by = Yii::$app->user->id; // Set ID pengguna yang menghapus

            if (!$model->save(false)) {
                throw new Exception('Gagal menyimpan perubahan pada model utama.');
            }

            $transaction->commit();
            $result = ['status' => true, 'msg' => 'Data berhasil dihapus.'];
        } catch (Exception $e) {
            $transaction->rollBack();
            $result = ['status' => false, 'msg' => $e->getMessage()];
        }

        return $this->asJson($result);
    }
}
