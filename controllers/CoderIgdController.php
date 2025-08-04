<?php

namespace app\controllers;

use app\components\Api;
use app\components\HelperSpesialClass;
use app\components\HelperGeneralClass;

use app\components\Model;
use app\models\AksesUnit;
use app\models\bedahsentral\AsesmenPraInduksi;
use app\models\bedahsentral\LaporanOperasi;
use app\models\bedahsentral\TimOperasi;
use app\models\bedahsentral\TimOperasiDetail;
use Yii;
use app\models\Distribusi;
use app\models\DistribusiDetail;
use app\models\DistribusiDetailSearch;
use app\models\DistribusiSearch;
use app\models\FmDistribusi;
use app\models\FmDistribusiDetail;
use app\models\fileman\AnalisaKuantitatif;
use app\models\medis\AsesmenAwalKebidanan;
use app\models\medis\AsesmenAwalKeperawatanGeneral;
use app\models\medis\AsesmenAwalMedis;
use app\models\medis\Cppt;
use app\models\medis\DocClinicalPasien;
use app\models\medis\Icd10cmv2;
use app\models\medis\Icd9cmv3;
use app\models\medis\PermintaanKonsultasi;
use app\models\medis\Pjp;
use app\models\medis\PjpRi;
use app\models\medis\Resep;
use app\models\medis\ResumeMedisRi;
use app\models\medis\TarifTindakanPasien;
use app\models\Pegawai;
use app\models\pegawai\DmUnitPenempatan;
use app\models\pegawai\TbPegawai;
use app\models\Peminjaman;
use app\models\PeminjamanDetail;
use app\models\PencariTracer;
use app\models\PencariTracerSearch;
use app\models\pendaftaran\Layanan;
use app\models\pendaftaran\Pasien;
use app\models\pendaftaran\Registrasi;

use app\models\medis\ResumeMedisRj;
use app\models\medis\RingkasanPulangIgd;
use app\models\medis\TarifTindakanPasienByAdm;
use app\models\pengolahandata\CatatanMpp;
use app\models\pengolahandata\CodingClaim;
use app\models\pengolahandata\CodingClaimDiagnosaDetail;
use app\models\pengolahandata\CodingClaimTindakanDetail;
use app\models\pengolahandata\CodingPelaporanRi;
use app\models\pengolahandata\CodingClaimIgd;
use app\models\pengolahandata\CodingPelaporanDiagnosaDetailRi;
use app\models\pengolahandata\CodingPelaporanTindakanDetailRi;
use app\models\pengolahandata\CodingPelaporanDiagnosaDetailI;
use app\models\pengolahandata\CodingClaimDiagnosaDetailIgd;
use app\models\pengolahandata\CodingPelaporanTindakanDetailIgd;
use app\models\pengolahandata\CodingClaimTindakanDetailIgd;
use app\models\pengolahandata\CodingPelaporanDiagnosaDetailIgd;
use app\models\pengolahandata\CodingPelaporanIgd;

use app\models\sip\Unit as SipUnit;
use app\models\sqlServer\LISORDER;
use app\models\Unit;
use app\widgets\AuthUser;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\base\Exception;
use yii\data\SqlDataProvider;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * FilingDistribusiController implements the CRUD actions for Distribusi model.
 */
class CoderIgdController extends Controller
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
    /**
     * Lists all Distribusi models.
     * @return mixed
     */


    public function actionList()
    {
        return $this->render('list', []);
    }

    public function actionDaftarCoding()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request->post("datatables");
        $layanan = Layanan::find()->select(["registrasi_kode", "jenis_layanan", "deleted_at", "unit_tujuan_kode", "id", "unit_kode"])->orderBy(["created_at" => SORT_DESC]);
        $queryData = Registrasi::find()
            ->select(["array_agg(layanan.jenis_layanan) as jenis", "registrasi.kode"])
            ->innerJoin(["layanan" => $layanan], "layanan.registrasi_kode=registrasi.kode and layanan.deleted_at is null")
            ->where("layanan.unit_tujuan_kode is null");
        if ($req['tanggal_awal'] != null) {
            $queryData = $queryData->andWhere([">=", "registrasi.tgl_masuk", $req['tanggal_awal'] . " 00:00:00"]);
        } else {
            $queryData = $queryData->andWhere([">=", "registrasi.tgl_masuk", date('Y-m-d') . " 00:00:00"]);
        }
        if ($req['tanggal_akhir'] != null) {
            $queryData = $queryData->andWhere(["<=", "registrasi.tgl_masuk", $req['tanggal_akhir'] . " 23:59:59"]);
        } else {
            $queryData = $queryData->andWhere(["<=", "registrasi.tgl_masuk", date('Y-m-d') . " 23:59:59"]);
        }

        $queryData = $queryData->andWhere("registrasi.deleted_at is Null")
            ->groupBy("registrasi.kode");


        $queryDataTest = (new \yii\db\Query())
            ->select([
                "registrasi.kode",
                "registrasi.pasien_kode",
                "pasien.nama",
                "registrasi.tgl_masuk",
                "registrasi.tgl_keluar",
                "array_agg(dm_unit_penempatan.nama) as poli",
                "registrasi.is_claim as claim",
                "registrasi.is_pelaporan as pelaporan",
                "debitur.nama as debitur",

            ])
            ->from("ranap")
            ->withQuery($queryData, "ranap", true)
            ->innerJoin("pendaftaran.registrasi", "registrasi.kode=ranap.kode and jenis::text not like '%3%' and jenis::text not like '%2%'")
            ->innerJoin("pendaftaran.layanan", "layanan.registrasi_kode=ranap.kode and layanan.jenis_layanan in (1)")
            ->leftJoin("pendaftaran.debitur_detail", "registrasi.debitur_detail_kode=debitur_detail.kode")
            ->leftJoin("pendaftaran.debitur", "debitur_detail.debitur_kode=debitur.kode")

            ->innerJoin("pendaftaran.pasien", "registrasi.pasien_kode=pasien.kode")
            ->innerJoin("medis.ringkasan_pulang_igd rpi", "rpi.layanan_id=layanan.id")



            ->innerJoin("pegawai.dm_unit_penempatan", "dm_unit_penempatan.kode=layanan.unit_kode");


        if ($req['claim'] != null) {
            if ($req['claim'] == 1) {
                $queryDataTest = $queryDataTest->andWhere(["registrasi.is_claim" => 1]);
            } elseif ($req['claim'] == 0) {
                $queryDataTest = $queryDataTest->andWhere(["registrasi.is_claim" => 0]);
            }
        }

        if ($req['pelaporan'] != null) {
            if ($req['pelaporan'] == 1) {
                $queryDataTest = $queryDataTest->andWhere(["registrasi.is_pelaporan" => 1]);
            } elseif ($req['pelaporan'] == 0) {
                $queryDataTest = $queryDataTest->andWhere(["registrasi.is_pelaporan" => 0]);
            }
        }

        if ($req['unit_kode'] != null) {
            $queryDataTest = $queryDataTest->andWhere(["layanan.unit_kode" => $req['unit_kode']]);
        }
        if ($req['debitur'] != null) {
            $queryDataTest = $queryDataTest->andWhere(["debitur_detail.debitur_kode" => $req['debitur']]);
        }
        // ->andWhere(["in","layanan.jenis"])
        $queryDataTest = $queryDataTest->groupBy(["registrasi.kode", "pasien.nama", "debitur.nama"])
            ->all();
        $response = [];


        foreach ($queryDataTest as $value) {
            $poliList = [];
            $string = str_replace(['{', '}', '"'], '', $value['poli']);

            // memisahkan string berdasarkan tanda koma
            $poliListData = explode(',', $string);
            $poliListData = array_unique($poliListData);
            $response[] = [
                'kode' => $value['kode'],
                'pasien_kode' => $value['pasien_kode'],
                'nama' => $value['nama'],
                'tgl_masuk' => $value['tgl_masuk'],
                'tgl_keluar' => $value['tgl_keluar'],
                'debitur' => $value['debitur'],


                'claim' => $value['claim'],
                'pelaporan' => $value['pelaporan'],

                'poli' => $poliListData,
                'registrasi_kode_hash' => HelperGeneralClass::hashData($value['kode'])
            ];
        }
        return [
            "status" => 200,
            "message" => "Data successfully retrieved",
            "data" => $response
        ];
    }

    public function actionView($id = null)
    {

        $userLogin = HelperSpesialClass::getUserLogin();
        if (!$userLogin['akses']) {
            Yii::$app->session->setFlash('warning', $userLogin['pesannoakses']);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $chk_pasien = HelperSpesialClass::getCheckPasien($id);
        if (!$chk_pasien->con) {
            \Yii::$app->session->setFlash('warning', $chk_pasien->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }

        $layananId = array();
        foreach ($chk_pasien->data['layanan'] as $item) {
            $layananId[] = $item['id'];
        }

        if (!$chk_pasien->con) {
            \Yii::$app->session->setFlash('warning', $chk_pasien->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listRingkasanPulangIgd = RingkasanPulangIgd::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();

        $listCoder = CodingPelaporanIgd::find()->joinWith(['pelaporanDiagnosa', 'pelaporanTindakan', 'ringkasanPulangIgd'])->where(['registrasi_kode' => $chk_pasien->data['kode']])->one();


        return $this->render(
            'view',
            [
                'registrasi' => $chk_pasien->data,
                'listCoder' => $listCoder,
                'listRingkasanPulangIgd' => $listRingkasanPulangIgd,
            ]
        );
    }
    public function actionPelaporan($id = null, $registrasi_kode = null)
    {

        $ringkasanPulangIgd = RingkasanPulangIgd::find()->where(['id' => $id])->one();
        $registrasi = HelperSpesialClass::getCheckPasien($registrasi_kode);
        $getListTindakan = TarifTindakanPasienByAdm::getListTindakan($registrasi->data['kode']);
        $layananId = array();

        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
        }
        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }

        $listCoder = CodingPelaporanIgd::find()->joinWith(['pelaporanDiagnosa', 'pelaporanTindakan', 'ringkasanPulangIgd'])->where(['registrasi_kode' => $registrasi->data['kode']])->one();

        $listRingkasanPulangIgd = RingkasanPulangIgd::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();

        $modelData = CodingPelaporanIgd::find()->where(['id_ringkasan_pulang_igd' => $ringkasanPulangIgd->id])->one();
        $modelCodingPelaporanIgd = new CodingPelaporanIgd();
        $modelsPelaporanDiagnosa = [new CodingPelaporanDiagnosaDetailIgd];

        $modelsPelaporanTindakan = [new CodingPelaporanTindakanDetailIgd];

        if ($modelData) {
            $modelCodingPelaporanIgd = CodingPelaporanIgd::find()->where(['id_ringkasan_pulang_igd' => $ringkasanPulangIgd->id])->one();
            if ($modelCodingPelaporanIgd->pelaporanDiagnosa) {
                $modelsPelaporanDiagnosa = $modelCodingPelaporanIgd->pelaporanDiagnosa;
            } else {
                $modelsPelaporanDiagnosa = [new CodingPelaporanDiagnosaDetailIgd];
            }
            if ($modelCodingPelaporanIgd->pelaporanTindakan) {
                $modelsPelaporanTindakan = $modelCodingPelaporanIgd->pelaporanTindakan;
            } else {
                $modelsPelaporanTindakan = [new CodingPelaporanTindakanDetailIgd];
            }
        }

        return $this->render(
            'pelaporan',
            [
                'registrasi' => $registrasi->data,
                'model' => $ringkasanPulangIgd,
                'listCoder' => $listCoder,
                'listRingkasanPulangIgd' => $listRingkasanPulangIgd,
                'getListTindakan' => $getListTindakan,
                'modelCodingPelaporanIgd' => $modelCodingPelaporanIgd,
                'modelsPelaporanDiagnosa' => (empty($modelsPelaporanDiagnosa)) ? [new CodingPelaporanDiagnosaDetailIgd] : $modelsPelaporanDiagnosa,
                'modelsPelaporanTindakan' => (empty($modelsPelaporanTindakan)) ? [new CodingPelaporanTindakanDetailIgd] : $modelsPelaporanTindakan,

            ]
        );
    }

    public function actionClaim($id = null, $registrasi_kode = null)
    {
        $registrasi = HelperSpesialClass::getCheckPasien($registrasi_kode);

        $layananId = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
        }

        $listRingkasanPulangIgd = RingkasanPulangIgd::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listCoder = CodingClaimIgd::find()->joinWith(['pelaporanDiagnosa', 'pelaporanTindakan', 'ringkasanPulangIgd'])->where(['registrasi_kode' => $registrasi->data['kode']])->one();


        $modelData = CodingClaimIgd::find()->where(['registrasi_kode' => $registrasi->data['kode']])->one();
        $modelCodingClaimIgd = new CodingClaimIgd();
        $modelCodingClaimDiagnosaDetailIgd = [new CodingClaimDiagnosaDetailIgd];

        $modelCodingClaimTindakanDetailIgd = [new CodingClaimTindakanDetailIgd];

        if ($modelData) {
            $modelCodingClaimIgd = CodingClaimIgd::find()->where(['registrasi_kode' => $registrasi->data['kode']])->one();
            if ($modelCodingClaimIgd->pelaporanDiagnosa) {
                $modelCodingClaimDiagnosaDetailIgd = $modelCodingClaimIgd->pelaporanDiagnosa;
            } else {
                $modelCodingClaimDiagnosaDetailIgd = [new CodingClaimDiagnosaDetailIgd];
            }
            if ($modelCodingClaimIgd->pelaporanTindakan) {
                $modelCodingClaimTindakanDetailIgd = $modelCodingClaimIgd->pelaporanTindakan;
            } else {
                $modelCodingClaimTindakanDetailIgd = [new CodingClaimTindakanDetailIgd];
            }
        }
        return $this->render(
            'claim',
            [
                'registrasi' => $registrasi->data,
                'listCoder' => $listCoder,

                'modelCodingClaimIgd' => $modelCodingClaimIgd,
                'listRingkasanPulangIgd' => $listRingkasanPulangIgd,
                'modelCodingClaimDiagnosaDetailIgd' => (empty($modelCodingClaimDiagnosaDetailIgd)) ? [new CodingClaimDiagnosaDetailIgd] : $modelCodingClaimDiagnosaDetailIgd,
                'modelCodingClaimTindakanDetailIgd' => (empty($modelCodingClaimTindakanDetailIgd)) ? [new CodingClaimTindakanDetailIgd] : $modelCodingClaimTindakanDetailIgd,
            ]
        );
    }

    public function actionPelaporanDiagnosaSave()
    {
        $modelData = CodingPelaporanIgd::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanIgd')['registrasi_kode']])->one();

        if ($modelData) {
            $model = CodingPelaporanIgd::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanIgd')['registrasi_kode']])->one();
            $modelClaim = CodingClaimIgd::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanIgd')['registrasi_kode']])->one();

            $modelDetails = $model->pelaporanDiagnosa;


            if ($model->load(Yii::$app->request->post())) {
                $modelDataClaim = CodingClaimIgd::find()->where(['registrasi_kode' => $model['registrasi_kode']])->one();
                if ($modelDataClaim) {
                    if ($modelDataClaim->diagnosa_simpan == 1) {
                        $result = ['status' => false, 'msg' => 'Anda tidak bisa ubah coding pelaporan karena sudah coding claim'];
                        return $this->asJson($result);
                    }
                }
                $oldIDs  = ArrayHelper::map($modelDetails, 'id', 'id');
                $modelDetails    = Model::createMultiple(CodingPelaporanDiagnosaDetailIgd::className());
                Model::loadMultiple($modelDetails, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelDetails, 'id', 'id')));
                foreach ($modelDetails as $detail) {
                    $detail->coding_pelaporan_id = $model->id;
                }
                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        CodingClaimDiagnosaDetailIgd::deleteAll(['coding_pelaporan_id' => $modelDataClaim->id]);

                        $modelClaim->attributes = $model->attributes;
                        $modelDetailsClaim = CodingClaimDiagnosaDetailIgd::loadMultiple($modelDetails, Yii::$app->request->post());

                        if ($flag = $model->save(false) && $modelClaim->save(false)) {
                            // delete dahulu semua record yang ada
                            if (!empty($deletedIDs)) {
                                CodingPelaporanDiagnosaDetailIgd::deleteAll(['id' => $deletedIDs]);
                            }
                            foreach ($modelDetails as $key => $modelDetail) {

                                $modelDetailsClaim = new CodingClaimDiagnosaDetailIgd();

                                $icd10 = Icd10cmv2::find()->where(['id' => $modelDetail->icd10_id])->one();
                                if ($icd10) {
                                    $modelDetail->icd10_kode = $icd10->kode;
                                    $modelDetailsClaim->icd10_kode = $icd10->kode;

                                    $modelDetail->icd10_deskripsi = $icd10->deskripsi;
                                    $modelDetailsClaim->icd10_deskripsi = $icd10->deskripsi;
                                }
                                //membuat urutan paling atas menjadi utama
                                if ($key == 0) {
                                    $modelDetail->utama = 1;
                                    $modelDetailsClaim->utama = 1;
                                } else {
                                    $modelDetail->utama = 0;
                                    $modelDetailsClaim->utama = 0;
                                }


                                $modelDetail->coding_pelaporan_id = $model->id;
                                $modelDetailsClaim->coding_pelaporan_id = $modelClaim->id;
                                $modelDetailsClaim->icd10_id = $modelDetail->icd10_id;
                                // $modelDetailsClaim->utama = $modelDetail->utama;




                                if (!($flag = $modelDetail->save(false) && $modelDetailsClaim->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            $registrasiModel = Registrasi::find()->where(['kode' => Yii::$app->request->post('CodingPelaporanIgd')['registrasi_kode']])->one();
                            $registrasiModel->is_pelaporan = 1;
                            $registrasiModel->save(false);
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
            $model = new CodingPelaporanIgd();
            $modelClaim = new CodingClaimIgd();


            $modelDetails = [new CodingPelaporanDiagnosaDetailIgd()];


            if ($model->load(Yii::$app->request->post())) {
                $modelDataClaim = CodingClaimIgd::find()->where(['registrasi_kode' => $model->registrasi_kode])->one();
                if ($modelDataClaim) {
                    if ($modelDataClaim->diagnosa_simpan == 1) {
                        $result = ['status' => false, 'msg' => 'Anda tidak bisa ubah coding pelaporan karena sudah coding claim'];
                        return $this->asJson($result);
                    }
                }
                $modelDetails    = Model::createMultiple(CodingPelaporanDiagnosaDetailIgd::className());

                Model::loadMultiple($modelDetails, Yii::$app->request->post());

                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        $modelClaim->attributes = $model->attributes;
                        $modelDetailsClaim = CodingClaimDiagnosaDetailIgd::loadMultiple($modelDetails, Yii::$app->request->post());

                        if ($flag = $model->save(false) && $modelClaim->save(false)) {
                            foreach ($modelDetails as $key => $modelDetail) {
                                $modelDetailsClaim = new CodingClaimDiagnosaDetailIgd();

                                $icd10 = Icd10cmv2::find()->where(['id' => $modelDetail->icd10_id])->one();
                                if ($icd10) {
                                    $modelDetail->icd10_kode = $icd10->kode;
                                    $modelDetailsClaim->icd10_kode = $icd10->kode;

                                    $modelDetail->icd10_deskripsi = $icd10->deskripsi;
                                    $modelDetailsClaim->icd10_deskripsi = $icd10->deskripsi;
                                }
                                //membuat urutan paling atas menjadi utama
                                if ($key == 0) {
                                    $modelDetail->utama = 1;
                                    $modelDetailsClaim->utama = 1;
                                } else {
                                    $modelDetail->utama = 0;
                                    $modelDetailsClaim->utama = 0;
                                }

                                $modelDetail->coding_pelaporan_id = $model->id;
                                $modelDetailsClaim->coding_pelaporan_id = $modelClaim->id;
                                $modelDetailsClaim->icd10_id = $modelDetail->icd10_id;




                                if (!($flag = $modelDetail->save(false) && $modelDetailsClaim->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }

                        if ($flag) {
                            $registrasiModel = Registrasi::find()->where(['kode' => Yii::$app->request->post('CodingPelaporanIgd')['registrasi_kode']])->one();
                            $registrasiModel->is_pelaporan = 1;
                            $registrasiModel->save(false);
                            $transaction->commit();
                            $result = ['status' => true, 'msg' => 'Data Berhasil Disimpan'];
                            return $this->asJson($result);
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                        $result = ['status' => false, 'msg' => $e->getMessage()];
                        return $this->asJson($result);
                        return Api::writeResponse(false, 'Resep Obat Gagal Ditambahkan!');
                    }
                } else {
                    $result = ['status' => false, 'msg' => $model->errors];
                    return $this->asJson($result);

                    return Api::writeResponse(false, 'Data Gagal Disimpan', $model->errors);
                }
            }
        }
    }

    public function actionPelaporanTindakanSave()
    {

        $modelData = CodingPelaporanIgd::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanIgd')['registrasi_kode']])->one();
        if ($modelData) {


            $model = CodingPelaporanIgd::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanIgd')['registrasi_kode']])->one();
            $modelClaim = CodingClaimIgd::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanIgd')['registrasi_kode']])->one();

            $modelDetails = $model->pelaporanTindakan;


            if ($model->load(Yii::$app->request->post())) {
                $modelDataClaim = CodingClaimIgd::find()->where(['registrasi_kode' => $model->registrasi_kode])->one();
                if ($modelDataClaim->tindakan_simpan == 1) {
                    $result = ['status' => false, 'msg' => 'Anda tidak bisa ubah coding pelaporan karena sudah coding claim'];
                    return $this->asJson($result);
                }

                $oldIDs  = ArrayHelper::map($modelDetails, 'id', 'id');
                $modelDetails    = Model::createMultiple(CodingPelaporanTindakanDetailIgd::className());
                Model::loadMultiple($modelDetails, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelDetails, 'id', 'id')));
                foreach ($modelDetails as $detail) {
                    $detail->coding_pelaporan_id = $model->id;
                }
                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        CodingClaimTindakanDetailIgd::deleteAll(['coding_pelaporan_id' => $modelDataClaim->id]);
                        $modelClaim->attributes = $model->attributes;
                        $modelDetailsClaim = CodingClaimTindakanDetailIgd::loadMultiple($modelDetails, Yii::$app->request->post());

                        if ($flag = $model->save(false) && $modelClaim->save(false)) {
                            // delete dahulu semua record yang ada
                            if (!empty($deletedIDs)) {
                                CodingPelaporanTindakanDetailIgd::deleteAll(['id' => $deletedIDs]);
                            }
                            foreach ($modelDetails as $key => $modelDetail) {
                                $modelDetailsClaim = new CodingClaimTindakanDetailIgd();

                                $icd9 = Icd9cmv3::find()->where(['id' => $modelDetail->icd9_id])->one();
                                if ($icd9) {
                                    $modelDetail->icd9_kode = $icd9->kode;
                                    $modelDetailsClaim->icd9_kode = $icd9->kode;

                                    $modelDetail->icd9_deskripsi = $icd9->deskripsi;
                                    $modelDetailsClaim->icd9_deskripsi = $icd9->deskripsi;
                                }
                                $modelDetail->coding_pelaporan_id = $model->id;
                                //membuat urutan paling atas menjadi utama
                                if ($key == 0) {
                                    $modelDetail->utama = 1;
                                    $modelDetailsClaim->utama = 1;
                                } else {
                                    $modelDetail->utama = 0;
                                    $modelDetailsClaim->utama = 0;
                                }
                                $modelDetailsClaim->coding_pelaporan_id = $modelClaim->id;
                                $modelDetailsClaim->icd9_id = $modelDetail->icd9_id;
                                if (!($flag = $modelDetail->save(false) && $modelDetailsClaim->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            $registrasiModel = Registrasi::find()->where(['kode' => Yii::$app->request->post('CodingPelaporanIgd')['registrasi_kode']])->one();
                            $registrasiModel->is_pelaporan = 1;
                            $registrasiModel->save(false);
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
                    $result = ['status' => false, 'msg' => 'tes'];
                    return $this->asJson($result);
                    return Api::writeResponse(false, 'Resep Obat Gagal Diubah', $model->errors);
                }
            }
        } else {
            $model = new CodingPelaporanIgd();
            $modelClaim = new CodingClaimIgd();


            $modelDetails = [new CodingPelaporanTindakanDetailIgd()];
            $modelDetailsClaim = new CodingClaimTindakanDetailIgd();

            if ($model->load(Yii::$app->request->post())) {
                $modelDetails    = Model::createMultiple(CodingPelaporanTindakanDetailIgd::className());
                Model::loadMultiple($modelDetails, Yii::$app->request->post());
                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        $modelClaim->attributes = $model->attributes;

                        if ($flag = $model->save(false) && $modelClaim->save(false)) {
                            foreach ($modelDetails as $key => $modelDetail) {

                                $modelDetailsClaim = new CodingClaimTindakanDetailIgd();

                                $icd9 = Icd9cmv3::find()->where(['id' => $modelDetail->icd9_id])->one();
                                if ($icd9) {
                                    $modelDetail->icd9_kode = $icd9->kode;
                                    $modelDetailsClaim->icd9_kode = $icd9->kode;

                                    $modelDetail->icd9_deskripsi = $icd9->deskripsi;
                                    $modelDetailsClaim->icd9_deskripsi = $icd9->deskripsi;
                                }
                                $modelDetail->coding_pelaporan_id = $model->id;

                                //membuat urutan paling atas menjadi utama
                                if ($key == 0) {
                                    $modelDetail->utama = 1;
                                    $modelDetailsClaim->utama = 1;
                                } else {
                                    $modelDetail->utama = 0;
                                    $modelDetailsClaim->utama = 0;
                                }

                                $modelDetailsClaim->coding_pelaporan_id = $modelClaim->id;
                                $modelDetailsClaim->icd9_id = $modelDetail->icd9_id;
                                if (!($flag = $modelDetail->save(false) && $modelDetailsClaim->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }

                        if ($flag) {
                            $registrasiModel = Registrasi::find()->where(['kode' => Yii::$app->request->post('CodingPelaporanIgd')['registrasi_kode']])->one();
                            $registrasiModel->is_pelaporan = 1;
                            $registrasiModel->save(false);
                            $transaction->commit();
                            $result = ['status' => true, 'msg' => 'Data Berhasil Disimpan'];
                            return $this->asJson($result);
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                        $result = ['status' => false, 'msg' => $e->getMessage()];
                        return $this->asJson($result);
                        return Api::writeResponse(false, 'Resep Obat Gagal Ditambahkan!');
                    }
                } else {
                    $result = ['status' => false, 'msg' => '$model->errors'];
                    return $this->asJson($result);

                    return Api::writeResponse(false, 'Data Gagal Disimpan', $model->errors);
                }
            }
        }
    }

    public function actionClaimDiagnosaSave()
    {
        $modelData = CodingClaimIgd::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaimIgd')['registrasi_kode']])->one();
        if ($modelData) {
            $model = CodingClaimIgd::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaimIgd')['registrasi_kode']])->one();
            $modelDetails = $model->pelaporanDiagnosa;

            if ($model->load(Yii::$app->request->post())) {
                $oldIDs  = ArrayHelper::map($modelDetails, 'id', 'id');
                $modelDetails    = Model::createMultiple(CodingClaimDiagnosaDetailIgd::className());
                Model::loadMultiple($modelDetails, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelDetails, 'id', 'id')));
                foreach ($modelDetails as $detail) {
                    $detail->coding_pelaporan_id = $model->id;
                }
                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        $model->diagnosa_simpan = 1;

                        if ($flag = $model->save(false)) {
                            // delete dahulu semua record yang ada
                            if (!empty($deletedIDs)) {
                                CodingClaimDiagnosaDetailIgd::deleteAll(['id' => $deletedIDs]);
                            }
                            foreach ($modelDetails as $key => $modelDetails) {

                                $icd10 = Icd10cmv2::find()->where(['id' => $modelDetails->icd10_id])->one();
                                if ($icd10) {
                                    $modelDetails->icd10_kode = $icd10->kode;
                                    $modelDetails->icd10_deskripsi = $icd10->deskripsi;
                                }
                                //membuat urutan paling atas menjadi utama
                                if ($key == 0) {
                                    $modelDetails->utama = 1;
                                } else {
                                    $modelDetails->utama = 0;
                                }
                                $modelDetails->coding_pelaporan_id = $model->id;
                                if (!($flag = $modelDetails->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }


                        if ($flag) {
                            //Set Is claim  tabel registrasi =1
                            $registrasiModel = Registrasi::find()->where(['kode' =>  Yii::$app->request->post('CodingClaimIgd')['registrasi_kode']])->one();
                            $registrasiModel->is_claim = 1;
                            $registrasiModel->save(false);
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
                    return Api::writeResponse(false, 'Resep Obat Gagal Diubah', $model->errors);
                }
            }
        } else {
            $model = new CodingClaimIgd();
            $modelClaim = new CodingClaimIgd();

            $modelDetails = [new CodingClaimDiagnosaDetailIgd()];
            if ($model->load(Yii::$app->request->post())) {
                $modelDetails    = Model::createMultiple(CodingClaimDiagnosaDetailIgd::className());
                Model::loadMultiple($modelDetails, Yii::$app->request->post());
                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            foreach ($modelDetails as $key => $modelDetails) {

                                $icd10 = Icd10cmv2::find()->where(['id' => $modelDetails->icd10_id])->one();
                                if ($icd10) {
                                    $modelDetails->icd10_kode = $icd10->kode;
                                    $modelDetails->icd10_deskripsi = $icd10->deskripsi;
                                }
                                //membuat urutan paling atas menjadi utama
                                if ($key == 0) {
                                    $modelDetails->utama = 1;
                                } else {
                                    $modelDetails->utama = 0;
                                }
                                $modelDetails->coding_pelaporan_id = $model->id;
                                if (!($flag = $modelDetails->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }

                        if ($flag) {
                            //Set Is claim tabel registrasi =1
                            $registrasiModel = Registrasi::find()->where(['kode' =>  Yii::$app->request->post('CodingClaimIgd')['registrasi_kode']])->one();
                            $registrasiModel->is_claim = 1;
                            $registrasiModel->save(false);

                            $transaction->commit();
                            $result = ['status' => true, 'msg' => 'Data Berhasil Disimpan'];
                            return $this->asJson($result);
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                        $result = ['status' => false, 'msg' => $e->getMessage()];
                        return $this->asJson($result);
                        return Api::writeResponse(false, 'Resep Obat Gagal Ditambahkan!');
                    }
                } else {
                    $result = ['status' => false, 'msg' => $model->errors];
                    return $this->asJson($result);

                    return Api::writeResponse(false, 'Data Gagal Disimpan', $model->errors);
                }
            }
        }
    }

    public function actionClaimTindakanSave()
    {
        $modelData = CodingClaimIgd::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaimIgd')['registrasi_kode']])->one();
        if ($modelData) {
            $model = CodingClaimIgd::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaimIgd')['registrasi_kode']])->one();
            $modelDetails = $model->pelaporanTindakan;

            if ($model->load(Yii::$app->request->post())) {

                $oldIDs  = ArrayHelper::map($modelDetails, 'id', 'id');
                $modelDetails    = Model::createMultiple(CodingClaimTindakanDetailIgd::className());
                Model::loadMultiple($modelDetails, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelDetails, 'id', 'id')));
                foreach ($modelDetails as $detail) {
                    $detail->coding_pelaporan_id = $model->id;
                }
                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        $model->tindakan_simpan = 1;

                        if ($flag = $model->save(false)) {
                            // delete dahulu semua record yang ada
                            if (!empty($deletedIDs)) {
                                CodingClaimTindakanDetailIgd::deleteAll(['id' => $deletedIDs]);
                            }
                            foreach ($modelDetails as $key => $modelDetails) {

                                $icd9 = Icd9cmv3::find()->where(['id' => $modelDetails->icd9_id])->one();
                                if ($icd9) {
                                    $modelDetails->icd9_kode = $icd9->kode;
                                    $modelDetails->icd9_deskripsi = $icd9->deskripsi;
                                }
                                //membuat urutan paling atas menjadi utama
                                if ($key == 0) {
                                    $modelDetails->utama = 1;
                                } else {
                                    $modelDetails->utama = 0;
                                }
                                $modelDetails->coding_pelaporan_id = $model->id;
                                if (!($flag = $modelDetails->save(false))) {
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
                    return Api::writeResponse(false, 'Resep Obat Gagal Diubah', $model->errors);
                }
            }
        } else {
            $model = new CodingClaimIgd();


            $modelDetails = [new CodingClaimTindakanDetailIgd()];

            if ($model->load(Yii::$app->request->post())) {

                $modelDetails    = Model::createMultiple(CodingClaimTindakanDetailIgd::className());
                Model::loadMultiple($modelDetails, Yii::$app->request->post());
                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {

                        if ($flag = $model->save(false)) {
                            foreach ($modelDetails as $key => $modelDetails) {

                                $icd9 = Icd9cmv3::find()->where(['id' => $modelDetails->icd9_id])->one();
                                if ($icd9) {
                                    $modelDetails->icd9_kode = $icd9->kode;
                                    $modelDetails->icd9_deskripsi = $icd9->deskripsi;
                                }
                                $modelDetails->coding_pelaporan_id = $model->id;
                                if (!($flag = $modelDetails->save(false))) {
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
                        $result = ['status' => false, 'msg' => $e->getMessage()];
                        return $this->asJson($result);
                        return Api::writeResponse(false, 'Resep Obat Gagal Ditambahkan!');
                    }
                } else {
                    $result = ['status' => false, 'msg' => $model->errors];
                    return $this->asJson($result);

                    return Api::writeResponse(false, 'Data Gagal Disimpan', $model->errors);
                }
            }
        }
    }

    function actionPreviewRingkasanPulangIgd()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $id = $req->post('id');
            $kodePasien = $req->post('pasien');
            $pasien = Pasien::find()->joinWith([
                'registrasi' => function ($q) {
                    $q->joinWith(['layanan']);
                }
            ])->where([Pasien::tableName() . '.kode' => $kodePasien])->limit(1)->one();
            $ringkasanPulangIgd = RingkasanPulangIgd::find()->joinWith(['dokter', 'layanan' => function ($q) {
                $q->joinWith(['unit', 'registrasi' => function ($query) {
                    $query->joinWith('pasien');
                }]);
            }])->where([RingkasanPulangIgd::tableName() . '.id' => $id])->nobatal()->orderBy(['created_at' => SORT_DESC])->one();
            //echo "<pre>"; print_r($resume); exit;
            return $this->renderAjax('ringkasan_pulang_igd', [
                'ringkasanPulangIgd' => $ringkasanPulangIgd,
                'pasien' => $pasien,
            ]);
        }
    }




    public function actionIcd10()
    {
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post = Yii::$app->request->post();
            if (!empty($post)) {
                $out['results'] = array_values(Icd10cmv2::getListDiagnosa($post['term']));
                return $out;
            }
        }
        return false;
    }
    public function actionIcd9()
    {
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post = Yii::$app->request->post();
            if (!empty($post)) {
                $out['results'] = array_values(Icd9cmv3::getListProsedur($post['term']));
                return $out;
            }
        }
        return false;
    }
}
