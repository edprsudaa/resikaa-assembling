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

class PeminjamanRekamMedisController extends Controller
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

    public function actionGenerateListPasien()
    {

        return $this->render('generate-list', []);
    }

    public function actionGenerateListPasienExternal()
    {
        // if (Log::getUserIpAddr() == '127.0.0.1') {
        //     return 's';
        // }
        return $this->render('generate-list-external', []);
    }

    public function actionListPeminjaman()
    {
        return $this->render('list-peminjaman', []);
    }


    public function actionDaftarPinjam()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request->post("datatables");
        $connection = \Yii::$app->db;

        $startDate = date('Y-m-d') . " 00:00:00"; // Tanggal awal dari variabel
        $endDate = date('Y-m-d') . " 23:59:59"; // Tanggal akhir dari variabel
        if ($req['tanggal_awal'] != null) {
            $startDate = $req['tanggal_awal'] . " 00:00:00";
        } else {
            $startDate = date('Y-m-d') . " 00:00:00";
        }
        if ($req['tanggal_akhir'] != null) {
            $endDate = $req['tanggal_akhir'] . " 23:59:59";
        } else {
            $endDate = date('Y-m-d') . " 23:59:59";
        }
        $sql = "SELECT
            pkm.id AS id,
            pkm.token AS token,
            tp.nama_lengkap AS peminjam,
            tprm.nama_lengkap AS petugas_pinjam,
            pkm.alasan_peminjaman as alasan_peminjaman,
            pkm.is_internal as is_internal,
            pkm.keterangan as keterangan,

            pkm.tanggal_start as tanggal_start,
            pkm.deleted_at as deleted_at,

            pkm.tanggal_expire as tanggal_expire,
            STRING_AGG(dpkm.pasien_kode, ', ') AS pasien_kode_list,
            STRING_AGG(ps.nama, ' & ') AS pasien_nama_list
        FROM
            pengolahan_data.peminjaman_rekam_medis pkm
        INNER JOIN
            pengolahan_data.detail_peminjaman_rekam_medis dpkm ON pkm.id = dpkm.peminjaman_rekam_medis_id
        LEFT JOIN
            pendaftaran.pasien ps ON ps.kode = dpkm.pasien_kode
        LEFT JOIN
            pegawai.tb_pegawai tp ON pkm.pegawai_id = tp.pegawai_id
        LEFT JOIN
            pegawai.tb_pegawai tprm ON pkm.pegawai_rekam_medik_id = tprm.pegawai_id ";

        if ($req['tipe_tanggal'] != 1) {
            $sql .= "where (pkm.tanggal_start >= :startDate AND pkm.tanggal_start <= :endDate) ";
        } else {
            $sql .= "where (pkm.tanggal_expire >= :startDate AND pkm.tanggal_expire <= :endDate) ";
        }

        $sql .= " group by pkm.id,tp.nama_lengkap,tprm.nama_lengkap";

        $command = $connection->createCommand($sql, [':startDate' => $startDate, ':endDate' => $endDate]);
        $results = $command->queryAll();
        $response = [];
        foreach ($results as $value) {

            $response[] = [
                'id' => $value['id'],
                'token' => $value['token'],
                'alasan_peminjaman' => $value['alasan_peminjaman'] ?? 'Tidak ada data',
                'peminjam' => $value['peminjam'] ?? 'Tidak ada data',
                'is_internal' => $value['is_internal'] == 1 ? 'Internal' : 'Eksternal',

                'tanggal_start' => $value['tanggal_start'],
                'tanggal_expire' => $value['tanggal_expire'],
                'petugas_pinjam' => $value['petugas_pinjam'],
                'keterangan' => $value['keterangan'],

                'deleted_at' => $value['deleted_at'],
                'token_hash' => HelperGeneralClass::hashData($value['token']),
                'log' => Log::find()->where(['token' => $value['token']])->count(),
                'pasien_kode_list' => $value['pasien_kode_list'], // Daftar pasien_kode
                'pasien_nama_list' => $value['pasien_nama_list'], // Daftar pasien_kode

            ];
        }
        return [
            "status" => 200,
            "message" => "Data successfully retrieved",
            "data" => $response
        ];
    }


    public function actionDaftarPeminjamanByPeminjam()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request->post("datatables");
        $connection = \Yii::$app->db;

        $startDate = date('Y-m-d') . " 00:00:00"; // Tanggal awal dari variabel
        $endDate = date('Y-m-d') . " 23:59:59"; // Tanggal akhir dari variabel
        if ($req['tanggal_awal'] != null) {
            $startDate = $req['tanggal_awal'] . " 00:00:00";
        } else {
            $startDate = date('Y-m-d') . " 00:00:00";
        }
        if ($req['tanggal_akhir'] != null) {
            $endDate = $req['tanggal_akhir'] . " 23:59:59";
        } else {
            $endDate = date('Y-m-d') . " 23:59:59";
        }
        $sql = "SELECT
            pkm.token AS token,
            tp.nama_lengkap AS peminjam,
            tprm.nama_lengkap AS petugas_pinjam,
            pkm.alasan_peminjaman as alasan_peminjaman,
            pkm.tanggal_start as tanggal_start,
            pkm.tanggal_expire as tanggal_expire,
            pkm.is_internal as is_internal


        FROM
            pengolahan_data.peminjaman_rekam_medis pkm
        INNER JOIN
            pengolahan_data.detail_peminjaman_rekam_medis dpkm ON pkm.id = dpkm.peminjaman_rekam_medis_id
        INNER JOIN
            pegawai.tb_pegawai tp ON pkm.pegawai_id = tp.pegawai_id
        INNER JOIN
            pegawai.tb_pegawai tprm ON pkm.pegawai_rekam_medik_id = tprm.pegawai_id ";
        if ($req['tipe_tanggal'] != 1) {
            $sql .= "where (pkm.tanggal_start >= :startDate AND pkm.tanggal_start <= :endDate) ";
        } else {
            $sql .= "where (pkm.tanggal_expire >= :startDate AND pkm.tanggal_expire <= :endDate) ";
        }
        $sql .= " AND pkm.pegawai_id = :pegawai and pkm.is_internal = 1 group by pkm.id,tp.nama_lengkap,tprm.nama_lengkap";





        $command = $connection->createCommand($sql, [':startDate' => $startDate, ':endDate' => $endDate, ':pegawai' => HelperSpesialClass::getUserLogin()['pegawai_id']]);
        $results = $command->queryAll();

        $response = [];
        foreach ($results as $value) {

            $response[] = [
                'token' => $value['token'],
                'alasan_peminjaman' => $value['alasan_peminjaman'],
                'peminjam' => $value['peminjam'],
                'tanggal_start' => $value['tanggal_start'],
                'tanggal_expire' => $value['tanggal_expire'],
                'petugas_pinjam' => $value['petugas_pinjam'],
                'is_internal' => $value['is_internal'] == 1 ? 'Internal' : 'Eksternal',
                'token_hash' => HelperGeneralClass::hashData($value['token'])
            ];
        }
        return [
            "status" => 200,
            "message" => "Data successfully retrieved",
            "data" => $response
        ];
    }


    public function actionCreate()
    {



        $modelPeminjaman = new PeminjamanRekamMedis();
        $modelDetailPeminjaman = [new DetailPeminjamanRekamMedis()];


        return $this->render(
            'peminjaman',
            [

                'modelPeminjaman' => $modelPeminjaman,


                'modelDetailPeminjaman' => (empty($modelDetailPeminjaman)) ? [new DetailPeminjamanRekamMedis] : $modelDetailPeminjaman,
            ]
        );
    }

    public function actionUpdate($id = null)
    {
        $modelPeminjaman = PeminjamanRekamMedis::find()->where(['id' => $id])->one();
        if (!$modelPeminjaman) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }
        if ($modelPeminjaman->detailPeminjaman) {
            $modelDetailPeminjaman = $modelPeminjaman->detailPeminjaman;
        }

        return $this->render(
            'peminjaman',
            [
                'modelPeminjaman' => $modelPeminjaman,
                'modelDetailPeminjaman' => (empty($modelDetailPeminjaman)) ? [new DetailPeminjamanRekamMedis] : $modelDetailPeminjaman,
            ]
        );
    }

    public function actionView($id = null)
    {
        $modelPeminjaman = PeminjamanRekamMedis::find()->where(['id' => $id])->one();
        if (!$modelPeminjaman) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }
        if ($modelPeminjaman->detailPeminjaman) {
            $modelDetailPeminjaman = $modelPeminjaman->detailPeminjaman;
        }

        return $this->render(
            'view_peminjaman',
            [
                'modelPeminjaman' => $modelPeminjaman,
                'modelDetailPeminjaman' => (empty($modelDetailPeminjaman)) ? [new DetailPeminjamanRekamMedis] : $modelDetailPeminjaman,
            ]
        );
    }



    public function actionSave()
    {
        if (isset(Yii::$app->request->post('PeminjamanRekamMedis')['id']) && Yii::$app->request->post('PeminjamanRekamMedis')['id'] != null) {
            $model = PeminjamanRekamMedis::find()->where(['id' => Yii::$app->request->post('PeminjamanRekamMedis')['id']])->one();
            $modelDetails = $model->detailPeminjaman;

            // Simpan nilai lama file_upload sebelum update
            $oldFile = $model->file_upload;

            if ($model->load(Yii::$app->request->post())) {
                if ($model->is_internal == 0) {
                    if (!empty(Yii::$app->request->post('PeminjamanRekamMedis')['pegawai_id'])) {
                        $result = ['status' => false, 'msg' => 'Peminjam harus kosong jika eksternal'];
                        return $this->asJson($result);
                    }
                }

                $oldIDs = ArrayHelper::map($modelDetails, 'id', 'id');
                $modelDetails = Model::createMultiple(DetailPeminjamanRekamMedis::className());
                Model::loadMultiple($modelDetails, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelDetails, 'id', 'id')));

                foreach ($modelDetails as $detail) {
                    $detail->peminjaman_rekam_medis_id = $model->id;
                }

                $file = UploadedFile::getInstance($model, 'file_upload');
                if ($file) {
                    // Hapus file lama jika ada dan ada file baru yang diunggah
                    if ($oldFile) {
                        @unlink(Yii::$app->params['storage']['peminjaman-rekam-medis'] . $oldFile);
                    }

                    $fileName = $file->name;
                    $nama_file = hash('md5', $fileName);
                    $filePath = Yii::$app->params['storage']['peminjaman-rekam-medis'] . $nama_file . '.' . $file->extension;
                    $file->saveAs($filePath);

                    $model->file_upload = $nama_file . '.' . $file->extension;
                } else {
                    // Jika tidak ada file baru, gunakan file lama
                    $model->file_upload = $oldFile;
                }

                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            // Hapus record yang dihapus
                            if (!empty($deletedIDs)) {
                                DetailPeminjamanRekamMedis::deleteAll(['id' => $deletedIDs]);
                            }

                            foreach ($modelDetails as $modelDetail) {
                                $modelDetail->peminjaman_rekam_medis_id = $model->id;
                                if (!($flag = $modelDetail->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }

                        if ($flag) {
                            $transaction->commit();
                            $result = ['status' => true, 'msg' => 'Data Berhasil Disimpan'];
                            return $this->asJson($result);
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                        throw $e;
                        $result = ['status' => false, 'msg' => 'Data Gagal Diubah!'];
                        return $this->asJson($result);
                    }
                } else {
                    $result = ['status' => false, 'msg' => $model->errors];
                    return $this->asJson($result);
                }
            }
        } else {
            $model = new PeminjamanRekamMedis();
            $modelDetails = [new DetailPeminjamanRekamMedis()];

            if ($model->load(Yii::$app->request->post())) {
                if ($model->is_internal == 0) {
                    if (!empty(Yii::$app->request->post('PeminjamanRekamMedis')['pegawai_id'])) {
                        $result = ['status' => false, 'msg' => 'Peminjam harus kosong jika eksternal'];
                        return $this->asJson($result);
                    }
                }


                $modelDetails = Model::createMultiple(DetailPeminjamanRekamMedis::className());
                Model::loadMultiple($modelDetails, Yii::$app->request->post());

                $file = UploadedFile::getInstance($model, 'file_upload');
                if ($file) {
                    $fileName = $file->name;
                    $nama_file = hash('md5', $fileName);
                    $filePath = Yii::$app->params['storage']['peminjaman-rekam-medis'] . $nama_file . '.' . $file->extension;
                    $file->saveAs($filePath);

                    $model->file_upload = $nama_file . '.' . $file->extension;
                }

                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            foreach ($modelDetails as $modelDetail) {
                                $modelDetail->peminjaman_rekam_medis_id = $model->id;
                                if (!($flag = $modelDetail->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }

                        if ($flag) {
                            $transaction->commit();
                            $result = ['status' => true, 'msg' => 'Data Berhasil Disimpan'];
                            return $this->asJson($result);
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                        $result = ['status' => false, 'msg' => 'Data Gagal Diubah!'];
                        return $this->asJson($result);
                    }
                } else {
                    $errors = [];
                    foreach ($modelDetails as $modelDetail) {
                        $errors = array_merge($errors, $modelDetail->errors);
                    }
                    $result = ['status' => false, 'msg' => $model->errors];
                    return $this->asJson($result);
                }
            }
        }
    }

    public function actionCheckGenerateToken()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $response = [];


        // Menangkap data yang dipost
        $postData = Yii::$app->request->post("datatables");
        $response = [];


        if (isset($postData['cari'])) {
            $peminjaman = DetailPeminjamanRekamMedis::find()
                ->innerJoinWith(['peminjaman'])
                ->innerJoinWith(['pasien'])
                ->select([
                    'detail_peminjaman_rekam_medis.pasien_kode',
                    'pasien.nama',
                    'peminjaman_rekam_medis.id as peminjaman_id',
                    'peminjaman_rekam_medis.token',
                    'peminjaman_rekam_medis.is_internal',
                    'peminjaman_rekam_medis.alasan_peminjaman',
                    'peminjaman_rekam_medis.tanggal_start',
                    'peminjaman_rekam_medis.tanggal_expire',
                ])
                ->where(['peminjaman_rekam_medis.token' => $postData['cari']])
                ->andWhere(['peminjaman_rekam_medis.is_internal' => 1])
                ->andWhere('peminjaman_rekam_medis.tanggal_expire >= :now')
                ->andWhere('peminjaman_rekam_medis.pegawai_id = :pegawai_id')

                ->addParams([':now' => date('Y-m-d H:i:s'), ':pegawai_id' => HelperSpesialClass::getUserLogin()['pegawai_id']])
                ->asArray()
                ->all();
            // Log the read action only once per peminjaman record
            if (!empty($peminjaman)) {
                $firstRecord = $peminjaman[0];
                Log::logRead($firstRecord['peminjaman_id'], $firstRecord['token'], $firstRecord['is_internal']);
            }
            foreach ($peminjaman as $value) {


                $response[] = [
                    'pasien_kode' => $value['pasien_kode'],
                    'nama' => $value['nama'],
                    'alasan_peminjaman' => $value['alasan_peminjaman'],
                    'pasien_kode_hash' => HelperGeneralClass::hashData($value['pasien_kode']),
                    'tanggal_start' => $value['tanggal_start'],
                    'tanggal_expire' => $value['tanggal_expire'],

                ];
            }
        }




        return [
            "status" => 200,
            "message" => "Data successfully retrieved",
            "data" => $response
        ];
    }

    public function actionCheckGenerateTokenExternal()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $response = [];


        // Menangkap data yang dipost
        $postData = Yii::$app->request->post("datatables");
        $response = [];


        if (isset($postData['cari'])) {
            $peminjaman = DetailPeminjamanRekamMedis::find()
                ->innerJoinWith(['peminjaman'])
                ->innerJoinWith(['pasien'])
                ->select([
                    'detail_peminjaman_rekam_medis.pasien_kode',
                    'pasien.nama',
                    'peminjaman_rekam_medis.id as peminjaman_id',
                    'peminjaman_rekam_medis.token',
                    'peminjaman_rekam_medis.is_internal',
                    'peminjaman_rekam_medis.alasan_peminjaman',
                    'peminjaman_rekam_medis.tanggal_start',
                    'peminjaman_rekam_medis.tanggal_expire',
                ])
                ->where(['peminjaman_rekam_medis.token' => $postData['cari']])
                ->andWhere(['peminjaman_rekam_medis.is_internal' => 0])
                ->andWhere('peminjaman_rekam_medis.tanggal_start <= :now')
                ->andWhere('peminjaman_rekam_medis.tanggal_expire >= :now')
                ->addParams([':now' => date('Y-m-d H:i:s')])
                ->asArray()
                ->all();
            // Log the read action only once per peminjaman record
            if (!empty($peminjaman)) {
                $firstRecord = $peminjaman[0];
                Log::logRead($firstRecord['peminjaman_id'], $firstRecord['token'], false);
            }
            foreach ($peminjaman as $value) {


                $response[] = [
                    'pasien_kode' => $value['pasien_kode'],
                    'nama' => $value['nama'],
                    'alasan_peminjaman' => $value['alasan_peminjaman'],
                    'pasien_kode_hash' => HelperGeneralClass::hashData($value['pasien_kode']),
                    'tanggal_start' => $value['tanggal_start'],
                    'tanggal_expire' => $value['tanggal_expire'],

                ];
            }
        }




        return [
            "status" => 200,
            "message" => "Data successfully retrieved",
            "data" => $response
        ];
    }

    public function actionPegawai()
    {
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post = Yii::$app->request->post();
            if (!empty($post)) {
                $out['results'] = array_values(Pegawai::getListPegawai($post['term']));
                return $out;
            }
        }
        return false;
    }
    public function actionPasien()
    {
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post = Yii::$app->request->post();
            if (!empty($post)) {
                $out['results'] = array_values(Pasien::getListPasien($post['term']));
                return $out;
            }
        }
        return false;
    }


    function actionDokumen($id)
    {
        $model = PeminjamanRekamMedis::find()->select('file_upload')->where(['id' => $id])->asArray()->limit(1)->one();
        if ($model != NULL) {
            if (file_exists(Yii::$app->params['storage']['peminjaman-rekam-medis'] . $model['file_upload']) && is_file(Yii::$app->params['storage']['peminjaman-rekam-medis'] . $model['file_upload'])) {
                return Yii::$app->response->sendFile(Yii::$app->params['storage']['peminjaman-rekam-medis'] . $model['file_upload'], $model['file_upload'], ['inline' => true]);
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
            $model = PeminjamanRekamMedis::findOne($id);

            if (!$model) {
                throw new NotFoundHttpException('Data tidak ditemukan.');
            }

            // Hapus file jika ada
            if ($model->file_upload) {
                @unlink(Yii::$app->params['storage']['peminjaman-rekam-medis'] . $model->file_upload);
            }

            // Hapus detail terkait dengan mengisi kolom deleted_at dan deleted_by
            $details = DetailPeminjamanRekamMedis::findAll(['peminjaman_rekam_medis_id' => $model->id]);
            foreach ($details as $detail) {
                $detail->deleted_at = date('Y-m-d H:i:s');
                $detail->deleted_by = Yii::$app->user->id;
                if (!$detail->save(false)) {
                    throw new Exception('Gagal menyimpan perubahan pada detail.');
                }
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

    public function actionLogPeminjaman($id)
    {
        $this->layout = false; // Menghilangkan layout agar hanya konten yang dimuat di dalam modal

        $logData = Log::find()->with(['pegawai'])->where(['peminjaman_rekam_medis_id' => $id])->all();

        return $this->render('log-detail', [
            'logData' => $logData,
        ]);
    }

    public function actionLogPeminjamanEksternal($id)
    {
        $this->layout = false; // Menghilangkan layout agar hanya konten yang dimuat di dalam modal

        $logData = Log::find()->with(['pegawaiSso'])->where(['peminjaman_rekam_medis_id' => $id])->all();

        return $this->render('log-detail-eksternal', [
            'logData' => $logData,
        ]);
    }
}
