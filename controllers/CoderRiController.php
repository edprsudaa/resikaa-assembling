<?php

namespace app\controllers;

use app\components\Api;
use app\components\HelperSpesialClass;
use app\components\HelperGeneralClass;

use app\components\MakeResponse;
use app\components\Mdcp;
use app\components\Model;
use app\models\AksesUnit;
use app\models\bedahsentral\AsesmenPraInduksi;
use app\models\bedahsentral\LaporanOperasi;
use app\models\bedahsentral\TimOperasi;
use app\models\bedahsentral\TimOperasiDetail;
use Yii;
use app\models\medis\Icd10cmv2;
use app\models\medis\Icd9cmv3;

use app\models\medis\ResumeMedisRi;
use app\models\medis\TarifTindakan;
use app\models\medis\TarifTindakanPasienByAdm;
use app\models\pendaftaran\Layanan;
use app\models\pendaftaran\Pasien;
use app\models\pendaftaran\Registrasi;
use app\models\pegawai\TbPegawai;


use app\models\pengolahandata\CodingClaim;
use app\models\pengolahandata\CodingClaimDiagnosaDetail;
use app\models\pengolahandata\CodingClaimTindakanDetail;
use app\models\pengolahandata\CodingPelaporanRi;


use app\models\pengolahandata\CodingPelaporanDiagnosaDetailRi;
use app\models\pengolahandata\CodingPelaporanTindakanDetailRi;

use app\models\pengolahandata\ResumeMedisRiClaim;

use yii\base\Exception;

use yii\filters\AccessControl;
use yii\web\Controller;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Response;


/**
 * FilingDistribusiController implements the CRUD actions for Distribusi model.
 */
class CoderRiController extends Controller
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

    public function actionDaftarCodingRi()
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
        $sql = "SELECT DISTINCT ON (r.kode,p.nama,d.nama,r.tgl_keluar)
            r.kode AS kode,
            r.pasien_kode,
            p.nama AS nama,
            r.tgl_masuk,
            r.tgl_keluar,
            r.is_closing_billing_ranap,
            r.closing_billing_ranap_by,
            r.closing_billing_ranap_at,
            rmr.tgl_pulang,
            array_agg(dup.nama) AS poli,
            r.is_claim as claim,
            r.is_pelaporan as pelaporan,
            r.is_claim_ri as claim_ri,
            r.is_pelaporan_ri as pelaporan_ri,
            d.nama as debitur 
        FROM
            pendaftaran.registrasi r
        INNER JOIN
            pendaftaran.layanan l ON l.registrasi_kode = r.kode
        INNER JOIN
            pendaftaran.pasien p ON r.pasien_kode = p.kode
        INNER JOIN
            pegawai.dm_unit_penempatan dup ON l.unit_kode = dup.kode
        LEFT JOIN pendaftaran.debitur_detail dd ON r.debitur_detail_kode=dd.kode
        LEFT JOIN pendaftaran.debitur d ON dd.debitur_kode=d.kode

        LEFT JOIN
            medis.resume_medis_ri rmr ON rmr.layanan_id = l.id    
        WHERE
            rmr.tgl_pulang >= :startDate
            AND rmr.tgl_pulang <= :endDate";
        // return $req['checkout'];
        if ($req['closing'] != null) {
            if ($req['closing'] == 0) {
                $sql .= " and r.is_closing_billing_ranap = 0 ";
            } else {
                $sql .= " and r.is_closing_billing_ranap = 1 ";
            }
        }
        if ($req['checkout'] != "") {
            if ($req['checkout'] == 0) {
                $sql .= " and r.tgl_keluar is null ";
            } else {
                $sql .= " and r.tgl_keluar is not null ";
            }
        }
        if ($req['claim'] != null) {
            if ($req['claim'] == 1) {
                $sql .= " and r.is_claim_ri = 1 ";
            } elseif ($req['claim'] == 0) {
                $sql .= " and r.is_claim_ri = 0 ";
            }
        }

        if ($req['pelaporan'] != null) {
            if ($req['pelaporan'] == 1) {
                $sql .= " and r.is_pelaporan_ri = 1 ";
            } elseif ($req['pelaporan'] == 0) {
                $sql .= " and r.is_pelaporan_ri = 0 ";
            }
        }
        if ($req['unit_kode'] != null) {
            $sql .= " and l.unit_kode = " . $req['unit_kode'];
        }

        if ($req['debitur'] != null) {
            $sql .= " and dd.debitur_kode = '" . $req['debitur'] . "'";
        }


        $sql .= " group by r.kode,p.nama,d.nama,rmr.tgl_pulang order by r.kode,p.nama,d.nama,r.tgl_keluar, rmr.tgl_pulang DESC";

        Yii::debug(Yii::$app->db->createCommand($sql, [':startDate' => $startDate, ':endDate' => $endDate])->rawSql, __METHOD__);

        $command = $connection->createCommand($sql, [':startDate' => $startDate, ':endDate' => $endDate]);
        $results = $command->queryAll();
        $response = [];
        foreach ($results as $value) {
            $poliList = [];
            $string = str_replace(['{', '}', '"'], '', $value['poli']);

            // memisahkan string berdasarkan tanda koma
            $poliListData = explode(',', $string);
            $poliListData = array_unique($poliListData);

            // Buat array asosiatif untuk "poli" tanpa angka di depannya
            $poli = [];
            foreach ($poliListData as $index => $namaPoli) {
                // Menghapus angka di depan nilai
                $namaPoli = preg_replace("/^[0-9]+/", "", $namaPoli);
                $poli[$index] = $namaPoli;
            }
            $response[] = [
                'kode' => $value['kode'],
                'pasien_kode' => $value['pasien_kode'],
                'nama' => $value['nama'],
                'tgl_masuk' => $value['tgl_masuk'],
                'tgl_keluar' => $value['tgl_keluar'],
                'tgl_pulang' => $value['tgl_pulang'],
                'is_closing_billing_ranap' => $value['is_closing_billing_ranap'],
                'closing_billing_ranap_by' => $value['closing_billing_ranap_by'],
                'closing_billing_ranap_at' => $value['closing_billing_ranap_at'],
                'claim' => $value['claim'],
                'pelaporan' => $value['pelaporan'],
                'debitur' => $value['debitur'],
                'claim_ri' => $value['claim_ri'],
                'pelaporan_ri' => $value['pelaporan_ri'],
                'poli' => array_values($poli),
                'registrasi_kode_hash' => HelperGeneralClass::hashData($value['kode'])
            ];
        }
        return [
            "status" => 200,
            "message" => "Data successfully retrieved",
            "data" => $response
        ];
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
            $queryData = $queryData->andWhere([">=", "registrasi.tgl_keluar", $req['tanggal_awal'] . " 00:00:00"]);
        } else {
            $queryData = $queryData->andWhere([">=", "registrasi.tgl_keluar", date('Y-m-d') . " 00:00:00"]);
        }
        if ($req['tanggal_akhir'] != null) {
            $queryData = $queryData->andWhere(["<=", "registrasi.tgl_keluar", $req['tanggal_akhir'] . " 23:59:59"]);
        } else {
            $queryData = $queryData->andWhere(["<=", "registrasi.tgl_keluar", date('Y-m-d') . " 23:59:59"]);
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
                "registrasi.is_pelaporan as pelaporan"

            ])
            ->from("ranap")
            ->withQuery($queryData, "ranap", true)
            ->innerJoin("pendaftaran.registrasi", "registrasi.kode=ranap.kode and jenis::text like '%3%'")
            ->innerJoin("pendaftaran.layanan", "layanan.registrasi_kode=ranap.kode and layanan.jenis_layanan in (3)")

            ->innerJoin("pendaftaran.pasien", "registrasi.pasien_kode=pasien.kode")
            ->innerJoin("pengolahan_data.resume_medis_ri_claim rmric", "rmric.layanan_id=layanan.id")



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

        // ->andWhere(["in","layanan.jenis"])
        $queryDataTest = $queryDataTest->groupBy(["registrasi.kode", "pasien.nama"])
            ->all();
        $response = [];


        foreach ($queryDataTest as $value) {
            $poliList = [];
            $string = str_replace(['{', '}', '"'], '', $value['poli']);

            // memisahkan string berdasarkan tanda koma
            $poliListData = explode(',', $string);

            $response[] = [
                'kode' => $value['kode'],
                'pasien_kode' => $value['pasien_kode'],
                'nama' => $value['nama'],
                'tgl_masuk' => $value['tgl_masuk'],
                'tgl_keluar' => $value['tgl_keluar'],

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
        $listResumeMedisDokter = ResumeMedisRi::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokterVerifikator = ResumeMedisRiClaim::find()->joinWith(['dokterVerifikator', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listCoder = CodingPelaporanRi::find()->joinWith(['pelaporanDiagnosa', 'pelaporanTindakan', 'resumeMedis'])->where([CodingPelaporanRi::tableName() . '.registrasi_kode' => $chk_pasien->data['kode']])->one();


        return $this->render(
            'view',
            [
                'registrasi' => $chk_pasien->data,
                'listCoder' => $listCoder,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,
            ]
        );
    }
    public function actionPelaporan($id = null, $registrasi_kode = null)
    {

        $resumeMedisRi = ResumeMedisRi::find()->where(['id' => $id])->one();
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

        $listCoder = CodingPelaporanRi::find()->joinWith(['pelaporanDiagnosa', 'pelaporanTindakan', 'resumeMedis'])->where([CodingPelaporanRi::tableName() . '.registrasi_kode' =>  $registrasi->data['kode']])->one();
        $listClaim = CodingClaim::find()->joinWith(['claimDiagnosa', 'claimTindakan'])->where(['registrasi_kode' => $registrasi->data['kode']])->one();
        $listResumeMedisDokter = ResumeMedisRi::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokterVerifikator = ResumeMedisRiClaim::find()->joinWith(['dokterVerifikator', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where([ResumeMedisRiClaim::tableName() . '.registrasi_kode' => $registrasi->data['kode']])->andWhere(['batal' => 0])->all();

        $modelData = CodingPelaporanRi::find()->where(['id_resume_medis_ri' => $resumeMedisRi->id])->one();
        $modelCodingPelaporanRi = new CodingPelaporanRi();
        $modelsPelaporanDiagnosa = [new CodingPelaporanDiagnosaDetailRi];

        $modelsPelaporanTindakan = [new CodingPelaporanTindakanDetailRi];

        if ($modelData) {
            $modelCodingPelaporanRi = CodingPelaporanRi::find()->where(['id_resume_medis_ri' => $resumeMedisRi->id])->one();
            if ($modelCodingPelaporanRi->pelaporanDiagnosa) {
                $modelsPelaporanDiagnosa = $modelCodingPelaporanRi->pelaporanDiagnosa;
            } else {
                $modelsPelaporanDiagnosa = [new CodingPelaporanDiagnosaDetailRi];
            }
            if ($modelCodingPelaporanRi->pelaporanTindakan) {
                $modelsPelaporanTindakan = $modelCodingPelaporanRi->pelaporanTindakan;
            } else {
                $modelsPelaporanTindakan = [new CodingPelaporanTindakanDetailRi];
            }
        }

        return $this->render(
            'pelaporan',
            [
                'registrasi' => $registrasi->data,
                'model' => $resumeMedisRi,
                'listCoder' => $listCoder,
                'listClaim' => $listClaim,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,
                'getListTindakan' => $getListTindakan,

                'modelCodingPelaporanRi' => $modelCodingPelaporanRi,

                'modelsPelaporanDiagnosa' => (empty($modelsPelaporanDiagnosa)) ? [new CodingPelaporanDiagnosaDetailRi] : $modelsPelaporanDiagnosa,
                'modelsPelaporanTindakan' => (empty($modelsPelaporanTindakan)) ? [new CodingPelaporanTindakanDetailRi] : $modelsPelaporanTindakan,

            ]
        );
    }

    public function actionClaim($id = null, $registrasi_kode = null)
    {
        $resumeMedisVerifikator = ResumeMedisRi::find()->where(['id' => $id])->one();


        $registrasi = HelperSpesialClass::getCheckPasien($registrasi_kode);

        $layananId = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
        }

        $listResumeMedisDokter = ResumeMedisRi::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokterVerifikator = ResumeMedisRiClaim::find()->joinWith(['dokterVerifikator', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where([ResumeMedisRiClaim::tableName() . '.registrasi_kode' => $registrasi->data['kode']])->andWhere(['batal' => 0])->all();

        $listCoder = CodingClaim::find()->joinWith(['claimDiagnosa', 'claimTindakan'])->joinWith(['resumeMedis' => function ($query) {
            $query->joinWith('dokter');
        }])->where([CodingClaim::tableName() . '.registrasi_kode' => $registrasi->data['kode']])->one();


        $modelData = CodingClaim::find()->where(['registrasi_kode' => $registrasi->data['kode']])->one();
        $modelCodingClaimRi = new CodingClaim();
        $modelCodingClaimDiagnosaDetailRi = [new CodingClaimDiagnosaDetail];

        $modelCodingClaimTindakanDetailRi = [new CodingClaimTindakanDetail];

        if ($modelData) {
            $modelCodingClaimRi = CodingClaim::find()->where(['registrasi_kode' => $registrasi->data['kode']])->one();
            if ($modelCodingClaimRi->claimDiagnosa) {
                $modelCodingClaimDiagnosaDetailRi = $modelCodingClaimRi->claimDiagnosa;
            } else {
                $modelCodingClaimDiagnosaDetailRi = [new CodingClaimDiagnosaDetail];
            }
            if ($modelCodingClaimRi->claimTindakan) {
                $modelCodingClaimTindakanDetailRi = $modelCodingClaimRi->claimTindakan;
            } else {
                $modelCodingClaimTindakanDetailRi = [new CodingClaimTindakanDetail];
            }
        }
        return $this->render(
            'claim',
            [
                'registrasi' => $registrasi->data,
                'listCoder' => $listCoder,

                'modelCodingClaimRi' => $modelCodingClaimRi,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisDokterVerifikator' => $listResumeMedisDokterVerifikator,

                'modelCodingClaimDiagnosaDetailRi' => (empty($modelCodingClaimDiagnosaDetailRi)) ? [new CodingClaimDiagnosaDetail] : $modelCodingClaimDiagnosaDetailRi,
                'modelCodingClaimTindakanDetailRi' => (empty($modelCodingClaimTindakanDetailRi)) ? [new CodingClaimTindakanDetail] : $modelCodingClaimTindakanDetailRi,
            ]
        );
    }

    public function actionPelaporanDiagnosaSave()
    {

        $modelData = CodingPelaporanRi::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanRi')['registrasi_kode']])->one();

        if ($modelData) {
            $model = CodingPelaporanRi::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanRi')['registrasi_kode']])->one();
            $modelClaim = CodingClaim::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanRi')['registrasi_kode']])->one();

            $modelDetails = $model->pelaporanDiagnosa;


            if ($model->load(Yii::$app->request->post())) {
                $modelDataClaim = CodingClaim::find()->where(['registrasi_kode' => $model['registrasi_kode']])->one();
                if ($modelDataClaim) {
                    if ($modelDataClaim->diagnosa_simpan == 1) {
                        $result = ['status' => false, 'msg' => 'Anda tidak bisa ubah coding pelaporan karena sudah coding claim'];
                        return $this->asJson($result);
                    }
                }
                $oldIDs  = ArrayHelper::map($modelDetails, 'id', 'id');
                $modelDetails    = Model::createMultiple(CodingPelaporanDiagnosaDetailRi::className());
                Model::loadMultiple($modelDetails, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelDetails, 'id', 'id')));
                foreach ($modelDetails as $detail) {
                    $detail->coding_pelaporan_id = $model->id;
                }
                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {

                        $modelClaim->attributes = $model->attributes;
                        $modelDetailsClaim = CodingClaimDiagnosaDetail::loadMultiple($modelDetails, Yii::$app->request->post());

                        CodingClaimDiagnosaDetail::deleteAll(['coding_claim_id' => $modelDataClaim->id]);

                        if ($flag = $model->save(false) && $modelClaim->save(false)) {
                            // delete dahulu semua record yang ada
                            if (!empty($deletedIDs)) {
                                CodingPelaporanDiagnosaDetailRi::deleteAll(['id' => $deletedIDs]);
                            }
                            foreach ($modelDetails as $key => $modelDetail) {

                                $modelDetailsClaim = new CodingClaimDiagnosaDetail();

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
                                } else {
                                    $modelDetail->utama = 0;
                                }
                                $modelDetail->coding_pelaporan_id = $model->id;
                                $modelDetailsClaim->coding_claim_id = $modelClaim->id;
                                $modelDetailsClaim->icd10_id = $modelDetail->icd10_id;
                                $modelDetailsClaim->utama = $modelDetail->utama;



                                if (!($flag = $modelDetail->save(false) && $modelDetailsClaim->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }

                        if ($flag) {
                            $registrasiModel = Registrasi::find()->where(['kode' => Yii::$app->request->post('CodingPelaporanRi')['registrasi_kode']])->one();
                            $registrasiModel->is_pelaporan_ri = 1;
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
            $model = new CodingPelaporanRi();
            $modelClaim = new CodingClaim();


            $modelDetails = [new CodingPelaporanDiagnosaDetailRi()];


            if ($model->load(Yii::$app->request->post())) {
                $modelDataClaim = CodingClaim::find()->where(['registrasi_kode' => $model->registrasi_kode])->one();
                if ($modelDataClaim) {
                    if ($modelDataClaim->diagnosa_simpan == 1) {
                        $result = ['status' => false, 'msg' => 'Anda tidak bisa ubah coding pelaporan karena sudah coding claim'];
                        return $this->asJson($result);
                    }
                }
                $modelDetails    = Model::createMultiple(CodingPelaporanDiagnosaDetailRi::className());

                Model::loadMultiple($modelDetails, Yii::$app->request->post());

                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        $modelClaim->attributes = $model->attributes;
                        $modelDetailsClaim = CodingClaimDiagnosaDetail::loadMultiple($modelDetails, Yii::$app->request->post());

                        if ($flag = $model->save(false) && $modelClaim->save(false)) {
                            foreach ($modelDetails as $key => $modelDetail) {
                                $modelDetailsClaim = new CodingClaimDiagnosaDetail();

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
                                } else {
                                    $modelDetail->utama = 0;
                                }
                                $modelDetail->coding_pelaporan_id = $model->id;
                                $modelDetailsClaim->coding_claim_id = $modelClaim->id;
                                $modelDetailsClaim->icd10_id = $modelDetail->icd10_id;
                                $modelDetailsClaim->utama = $modelDetail->utama;

                                if (!($flag = $modelDetail->save(false) && $modelDetailsClaim->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }

                        if ($flag) {
                            $registrasiModel = Registrasi::find()->where(['kode' => Yii::$app->request->post('CodingPelaporanRi')['registrasi_kode']])->one();
                            $registrasiModel->is_pelaporan_ri = 1;
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
        $modelData = CodingPelaporanRi::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanRi')['registrasi_kode']])->one();
        if ($modelData) {
            $model = CodingPelaporanRi::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanRi')['registrasi_kode']])->one();
            $modelClaim = CodingClaim::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanRi')['registrasi_kode']])->one();

            $modelDetails = $model->pelaporanTindakan;


            if ($model->load(Yii::$app->request->post())) {
                $modelDataClaim = CodingClaim::find()->where(['registrasi_kode' => $model->registrasi_kode])->one();
                if ($modelDataClaim->tindakan_simpan == 1) {
                    $result = ['status' => false, 'msg' => 'Anda tidak bisa ubah coding pelaporan karena sudah coding claim'];
                    return $this->asJson($result);
                }
                $oldIDs  = ArrayHelper::map($modelDetails, 'id', 'id');
                $modelDetails    = Model::createMultiple(CodingPelaporanTindakanDetailRi::className());
                Model::loadMultiple($modelDetails, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelDetails, 'id', 'id')));
                foreach ($modelDetails as $detail) {
                    $detail->coding_pelaporan_id = $model->id;
                }
                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        $modelClaim->attributes = $model->attributes;
                        $modelDetailsClaim = CodingClaimTindakanDetail::loadMultiple($modelDetails, Yii::$app->request->post());

                        CodingClaimTindakanDetail::deleteAll(['coding_claim_id' => $modelDataClaim->id]);

                        if ($flag = $model->save(false) && $modelClaim->save(false)) {
                            // delete dahulu semua record yang ada
                            if (!empty($deletedIDs)) {
                                CodingPelaporanTindakanDetailRi::deleteAll(['id' => $deletedIDs]);
                            }
                            foreach ($modelDetails as $key => $modelDetail) {
                                $modelDetailsClaim = new CodingClaimTindakanDetail();

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
                                $modelDetailsClaim->coding_claim_id = $modelClaim->id;
                                $modelDetailsClaim->icd9_id = $modelDetail->icd9_id;
                                if (!($flag = $modelDetail->save(false) && $modelDetailsClaim->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            $registrasiModel = Registrasi::find()->where(['kode' => Yii::$app->request->post('CodingPelaporanRi')['registrasi_kode']])->one();
                            $registrasiModel->is_pelaporan_ri = 1;
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
            $model = new CodingPelaporanRi();
            $modelClaim = new CodingClaim();


            $modelDetails = [new CodingPelaporanTindakanDetailRi()];
            $modelDetailsClaim = new CodingClaimTindakanDetail();

            if ($model->load(Yii::$app->request->post())) {
                $modelDetails    = Model::createMultiple(CodingPelaporanTindakanDetailRi::className());
                Model::loadMultiple($modelDetails, Yii::$app->request->post());
                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        $modelClaim->attributes = $model->attributes;

                        if ($flag = $model->save(false) && $modelClaim->save(false)) {
                            foreach ($modelDetails as $key => $modelDetail) {

                                $modelDetailsClaim = new CodingClaimTindakanDetail();

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

                                $modelDetailsClaim->coding_claim_id = $modelClaim->id;
                                $modelDetailsClaim->icd9_id = $modelDetail->icd9_id;
                                if (!($flag = $modelDetail->save(false) && $modelDetailsClaim->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }

                        if ($flag) {
                            $registrasiModel = Registrasi::find()->where(['kode' => Yii::$app->request->post('CodingPelaporanRi')['registrasi_kode']])->one();
                            $registrasiModel->is_pelaporan_ri = 1;
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
        $modelData = CodingClaim::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaim')['registrasi_kode']])->one();
        if ($modelData) {

            $model = CodingClaim::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaim')['registrasi_kode']])->one();
            $modelDetails = $model->claimDiagnosa;

            if ($model->load(Yii::$app->request->post())) {
                $oldIDs  = ArrayHelper::map($modelDetails, 'id', 'id');
                $modelDetails    = Model::createMultiple(CodingClaimDiagnosaDetail::className());
                Model::loadMultiple($modelDetails, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelDetails, 'id', 'id')));
                foreach ($modelDetails as $detail) {
                    $detail->coding_claim_id = $model->id;
                }
                if ($model->validate() && Model::validateMultiple($modelDetails)) {

                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        $model->diagnosa_simpan = 1;

                        if ($flag = $model->save(false)) {

                            // delete dahulu semua record yang ada
                            if (!empty($deletedIDs)) {
                                CodingClaimDiagnosaDetail::deleteAll(['id' => $deletedIDs]);
                            }

                            foreach ($modelDetails as $key => $modelDetails) {

                                $icd10 = Icd10cmv2::find()->where(['id' => $modelDetails->icd10_id])->one();
                                if ($icd10) {
                                    $modelDetails->icd10_kode = $icd10->kode;
                                    $modelDetails->icd10_deskripsi = $icd10->deskripsi;
                                }
                                if ($key == 0) {
                                    $modelDetails->utama = 1;
                                } else {
                                    $modelDetails->utama = 0;
                                }
                                $modelDetails->coding_claim_id = $model->id;
                                if (!($flag = $modelDetails->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }


                        if ($flag) {
                            $registrasiModel = Registrasi::find()->where(['kode' =>  Yii::$app->request->post('CodingClaim')['registrasi_kode']])->one();
                            $registrasiModel->is_claim_ri = 1;
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
            $model = new CodingClaim();

            $modelDetails = [new CodingClaimDiagnosaDetail()];
            if ($model->load(Yii::$app->request->post())) {
                $modelDetails    = Model::createMultiple(CodingClaimDiagnosaDetail::className());
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
                                if ($key == 0) {
                                    $modelDetails->utama = 1;
                                } else {
                                    $modelDetails->utama = 0;
                                }
                                $modelDetails->coding_claim_id = $model->id;
                                if (!($flag = $modelDetails->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }

                        if ($flag) {
                            $registrasiModel = Registrasi::find()->where(['kode' =>  Yii::$app->request->post('CodingClaim')['registrasi_kode']])->one();
                            $registrasiModel->is_claim_ri = 1;
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
        $modelData = CodingClaim::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaim')['registrasi_kode']])->one();
        if ($modelData) {
            $model = CodingClaim::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaim')['registrasi_kode']])->one();
            $modelDetails = $model->claimTindakan;
            if ($model->load(Yii::$app->request->post())) {
                $oldIDs  = ArrayHelper::map($modelDetails, 'id', 'id');
                $modelDetails    = Model::createMultiple(CodingClaimTindakanDetail::className());
                Model::loadMultiple($modelDetails, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelDetails, 'id', 'id')));
                foreach ($modelDetails as $detail) {
                    $detail->coding_claim_id = $model->id;
                }
                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        $model->tindakan_simpan = 1;
                        if ($flag = $model->save(false)) {
                            // delete dahulu semua record yang ada
                            if (!empty($deletedIDs)) {
                                CodingClaimTindakanDetail::deleteAll(['id' => $deletedIDs]);
                            }
                            foreach ($modelDetails as $key => $modelDetails) {
                                if ($key == 0) {
                                    $modelDetails->utama = 1;
                                } else {
                                    $modelDetails->utama = 0;
                                }
                                $icd9 = Icd9cmv3::find()->where(['id' => $modelDetails->icd9_id])->one();
                                if ($icd9) {
                                    $modelDetails->icd9_kode = $icd9->kode;
                                    $modelDetails->icd9_deskripsi = $icd9->deskripsi;
                                }
                                $modelDetails->coding_claim_id = $model->id;
                                if (!($flag = $modelDetails->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            $registrasiModel = Registrasi::find()->where(['kode' =>  Yii::$app->request->post('CodingClaim')['registrasi_kode']])->one();
                            $registrasiModel->is_claim_ri = 1;
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
            $model = new CodingClaim();
            $modelDetails = [new CodingClaimTindakanDetail()];
            if ($model->load(Yii::$app->request->post())) {
                $modelDetails    = Model::createMultiple(CodingClaimTindakanDetail::className());
                Model::loadMultiple($modelDetails, Yii::$app->request->post());
                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            foreach ($modelDetails as $key => $modelDetails) {
                                if ($key == 0) {
                                    $modelDetails->utama = 1;
                                } else {
                                    $modelDetails->utama = 0;
                                }
                                $icd9 = Icd9cmv3::find()->where(['id' => $modelDetails->icd9_id])->one();
                                if ($icd9) {
                                    $modelDetails->icd9_kode = $icd9->kode;
                                    $modelDetails->icd9_deskripsi = $icd9->deskripsi;
                                }
                                $modelDetails->coding_claim_id = $model->id;
                                if (!($flag = $modelDetails->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            $registrasiModel = Registrasi::find()->where(['kode' =>  Yii::$app->request->post('CodingClaim')['registrasi_kode']])->one();
                            $registrasiModel->is_claim_ri = 1;
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

    function actionDetailResumeVerifikatorRi()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $id = $req->post('id');

            $kodePasien = $req->post('pasien');
            $asesmen = ResumeMedisRiClaim::find()->joinWith(['dokter', 'layanan' => function ($q) {
                $q->joinWith(['registrasi' => function ($query) {
                    $query->joinWith('pasien');
                }]);
            }])->where(['pengolahan_data.resume_medis_ri_claim.id' => $id])->one();

            $pasien = Pasien::find()->where(['kode' => $kodePasien])->one();
            return $this->renderAjax('resume-medis-verifikator', ['asesmen' => $asesmen, 'pasien' => $pasien]);
        }
    }


    function actionPreviewResumeMedisVerifikator()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $id = $req->post('id');

            $kodePasien = $req->post('pasien');
            $asesmen = ResumeMedisRiClaim::find()->joinWith(['dokter', 'layanan' => function ($q) {
                $q->joinWith(['registrasi' => function ($query) {
                    $query->joinWith('pasien');
                }]);
            }])->where(['pengolahan_data.resume_medis_ri_claim.id' => $id])->one();

            $pasien = Pasien::find()->where(['kode' => $kodePasien])->one();
            return $this->renderAjax('resume-medis-verifikator', ['asesmen' => $asesmen, 'pasien' => $pasien]);
        }
    }






    public function actionPreviewResumeMedis($id)
    {
        $asesmen = ResumeMedisRi::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['medis.resume_medis_ri.id' => $id])->one();

        $pasien = Pasien::find()->where(['kode' => $asesmen->layanan->registrasi->pasien->kode])->one();
        return $this->renderAjax('resume-medis', ['asesmen' => $asesmen, 'pasien' => $pasien]);
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
    public function actionLaporanCoder()
    {
        return $this->render('list-laporan-coder', []);
    }
    public function actionDataLaporanCoder()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request->post("datatables");
        $queryData = CodingPelaporanRi::find()->select(['count(coding_pelaporan_ri.registrasi_kode)', 'tb_pegawai.pegawai_id', 'tb_pegawai.id_nip_nrp', 'tb_pegawai.nama_lengkap'])
            ->innerJoin([Registrasi::tableName()], 'coding_pelaporan_ri.registrasi_kode=registrasi.kode')
            ->innerJoin([TbPegawai::tableName()], 'coding_pelaporan_ri.pegawai_coder_id=tb_pegawai.pegawai_id')
            ->where(['in', 'pegawai_coder_id', HelperSpesialClass::isCoderUser()])->groupBy(['tb_pegawai.pegawai_id', 'tb_pegawai.nama_lengkap']);
        if ($req['tanggal_awal'] != null) {
            $queryData = $queryData->andWhere([">=", CodingPelaporanRi::tableName() . ".created_at", $req['tanggal_awal'] . " 00:00:00"]);
        } else {
            $queryData = $queryData->andWhere([">=", CodingPelaporanRi::tableName() . ".created_at", date('Y-m-d') . " 00:00:00"]);
        }
        if ($req['tanggal_akhir'] != null) {
            $queryData = $queryData->andWhere(["<=", CodingPelaporanRi::tableName() . ".created_at", $req['tanggal_akhir'] . " 23:59:59"]);
        } else {
            $queryData = $queryData->andWhere(["<=", CodingPelaporanRi::tableName() . ".created_at", date('Y-m-d') . " 23:59:59"]);
        }
        $queryData = $queryData->groupBy(['tb_pegawai.pegawai_id', 'tb_pegawai.nama_lengkap', 'tb_pegawai.id_nip_nrp'])->asArray()->all();



        $response = [];


        foreach ($queryData as $value) {
            $response[] = [
                'jumlah' => $value['count'],
                'nama_coder' => $value['nama_lengkap'],
                'nip_nik' => $value['id_nip_nrp'],

            ];
        }
        return [
            "status" => 200,
            "message" => "Data successfully retrieved",
            "data" => $response
        ];
    }
}
