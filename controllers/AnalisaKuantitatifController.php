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
use app\models\Distribusi;
use app\models\DistribusiDetail;
use app\models\DistribusiDetailSearch;
use app\models\DistribusiSearch;
use app\models\FmDistribusi;
use app\models\FmDistribusiDetail;
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
use app\models\pengolahandata\MasterJenisAnalisaDetail;
use app\models\pengolahandata\AnalisaDokumen;
use app\models\pengolahandata\AnalisaDokumenDetail;
use app\models\pengolahandata\AnalisaDokumenDetailSearch;
use app\models\pengolahandata\MasterItemAnalisa;
use app\models\pengolahandata\MasterJenisAnalisa;
use app\models\pengolahandata\ResultHead;
use app\models\penunjang\HasilPemeriksaan;
use app\models\penunjang\JenisTindakanPa;
use app\models\penunjang\LabelPemeriksaanPa;
use app\models\penunjang\PemeriksaanTindakanHasil;
use app\models\penunjang\ResultPacs;
use app\models\medis\ResumeMedisRj;
use app\models\pengolahandata\CatatanMpp;
use app\models\pengolahandata\CodingClaim;
use app\models\pengolahandata\CodingClaimDiagnosaDetail;
use app\models\pengolahandata\CodingClaimTindakanDetail;
use app\models\pengolahandata\CodingPelaporanRi;
use app\models\pengolahandata\CodingPelaporanRj;
use app\models\pengolahandata\CodingClaimRj;


use app\models\pengolahandata\CodingPelaporanDiagnosaDetailRi;
use app\models\pengolahandata\CodingPelaporanTindakanDetailRi;
use app\models\pengolahandata\CodingPelaporanDiagnosaDetailRj;
use app\models\pengolahandata\CodingClaimDiagnosaDetailRj;

use app\models\pengolahandata\CodingPelaporanTindakanDetailRj;
use app\models\pengolahandata\CodingClaimTindakanDetailRj;
use app\models\laporan\LaporanCoder;

use app\models\pengolahandata\ResumeMedisRiClaim;
use app\models\pengolahandata\ResumeMedisRjClaim;
use app\widgets\Datatable;
use app\models\search\LayananRiSearch;
use app\models\search\LayananRj2Search;
use app\models\search\LayananRjSearch;
use app\models\search\RegistrasiSearch;
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
class AnalisaKuantitatifController extends Controller
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
    function actionDetailResumeRj()
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
            $resume = ResumeMedisRj::find()->joinWith(['dokter', 'unitTujuan', 'layanan' => function ($q) {
                $q->joinWith(['unit', 'registrasi' => function ($query) {
                    $query->joinWith('pasien');
                }]);
            }])->where([ResumeMedisRj::tableName() . '.id' => $id])->nobatal()->orderBy(['created_at' => SORT_DESC])->one();
            //echo "<pre>"; print_r($resume); exit;
            return $this->renderAjax('sbpk_detail', [
                'resume' => $resume,
                'pasien' => $pasien,
            ]);
        }
    }

    function actionDetailResumeVerifikatorRj()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $id = $req->post('id');

            $kodePasien = $req->post('pasien');
            $pasien = Pasien::find()->joinWith([
                'registrasi' => function ($q) {
                    $q->joinWith(['layanan']);
                }
            ])->where(['pasien.kode' => $kodePasien])->limit(1)->one();
            $resume = ResumeMedisRjClaim::find()->joinWith(['dokterVerifikator', 'unitTujuan', 'layanan' => function ($q) {
                $q->joinWith(['unit', 'registrasi' => function ($query) {
                    $query->joinWith('pasien');
                }]);
            }])->where([ResumeMedisRjClaim::tableName() . '.id' => $id])->orderBy(['created_at' => SORT_DESC])->one();
            return $this->renderAjax('sbpk_detail_verifikator', [
                'resume' => $resume,
                'pasien' => $pasien,
            ]);
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



    public function actionAnalisaForm()
    {
        $analisa = AnalisaDokumen::find()->asArray()->all();
        $out = array();
        foreach ($analisa as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if (array_key_exists($key2, $out) && array_key_exists($value2, $out[$key2])) {
                    $out[$key2][$value2]++;
                } else {
                    $out[$key2][$value2] = 1;
                }
            }
        }
        return $this->render('registrasi-form', [

            'analisa' => $analisa,
            'out' => $out
            // 'dataProvider' => $dataProvider,
        ]);
    }
    public function actionDetail($id = null, $icd = false)
    {
        $registrasi = HelperSpesialClass::getCheckPasien($id);
        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()
                ->innerJoin('analisa_dokumen_detail', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        return $this->render(
            'index',
            [
                'registrasi' => $registrasi->data,
                'model' => $analisaDokumen,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'resep' => $resep,
                'icd' => $icd
            ]
        );
    }

    public function actionDetailCoder($id = null, $icd = true)
    {
        $registrasi = HelperSpesialClass::getCheckPasien($id);
        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()
                ->innerJoin('analisa_dokumen_detail', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();

        $listCoder = CodingPelaporan::find()->joinWith(['pelaporanDiagnosa', 'pelaporanTindakan'])->where(['registrasi_kode' => $registrasi->data['kode']])->one();

        $listClaim = CodingClaim::find()->joinWith(['claimDiagnosa', 'claimTindakan'])->where(['registrasi_kode' => $registrasi->data['kode']])->one();

        $modelCustomer = new CodingPelaporan();
        $modelClaim = new CodingClaim();

        $modelsAddress = [new CodingPelaporanDiagnosaDetail];
        $modelsIcd9 = [new CodingPelaporanTindakanDetail()];
        $modelsAddressClaim = [new CodingClaimDiagnosaDetail()];
        $modelsIcd9Claim = [new CodingClaimTindakanDetail()];
        if ($modelCustomer->load(Yii::$app->request->post())) {

            $modelsAddress = Model::createMultiple(CodingPelaporanDiagnosaDetail::classname());
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());


            // validate all models
            $valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsAddress) && $valid;

            if ($valid) {

                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {

                        foreach ($modelsAddress as $modelAddress) {
                            $modelAddress->coding_pelaporan_id = $modelCustomer->id;
                            if (!($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelCustomer->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    echo '<pre>';
                    print_r($e->getMessage());
                    echo '</pre>';
                    die;
                    // return Api::writeResponse(false, 'Resep Obat Gagal Ditambahkan!');
                }
            }
        }

        return $this->render(
            'detail-coder',
            [
                'registrasi' => $registrasi->data,
                'model' => $analisaDokumen,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'resep' => $resep,
                'listCoder' => $listCoder,
                'listClaim' => $listClaim,


                'icd' => $icd,
                'modelClaim' => $modelClaim,
                'modelCustomer' => $modelCustomer,

                'modelsAddress' => (empty($modelsAddress)) ? [new CodingPelaporanDiagnosaDetail] : $modelsAddress,
                'modelsIcd9' => (empty($modelsIcd9)) ? [new CodingPelaporanTindakanDetail] : $modelsIcd9,
                'modelsAddressClaim' => (empty($modelsAddressClaim)) ? [new CodingClaimDiagnosaDetail()] : $modelsAddressClaim,
                'modelsIcd9Claim' => (empty($modelsIcd9Claim)) ? [new CodingClaimTindakanDetail] : $modelsIcd9Claim
            ]
        );
    }
    public function actionDetailCoderPelaporanEdit($id = null, $icd = true, $registrasi_kode = null)
    {

        $resumeMedisRi = ResumeMedisRi::find()->where(['id' => $id])->one();
        $registrasi = HelperSpesialClass::getCheckPasien($registrasi_kode);
        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()
                ->innerJoin('analisa_dokumen_detail', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();

        $listCoder = CodingPelaporanRi::find()->joinWith(['pelaporanDiagnosa', 'pelaporanTindakan'])->where(['registrasi_kode' => $registrasi->data['kode']])->one();

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
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();

        $modelData = CodingPelaporanRi::find()->where(['id_resume_medis_ri' => $id])->one();
        $modelCustomer = new CodingPelaporanRi();
        $modelsAddress = [new CodingPelaporanDiagnosaDetailRi];

        $modelsIcd9 = [new CodingPelaporanTindakanDetailRi];

        if ($modelData) {
            $modelCustomer = CodingPelaporanRi::find()->where(['id_resume_medis_ri' => $id])->one();
            if ($modelCustomer->pelaporanDiagnosa) {
                $modelsAddress = $modelCustomer->pelaporanDiagnosa;
            } else {
                $modelsAddress = [new CodingPelaporanDiagnosaDetailRi];
            }
            if ($modelCustomer->pelaporanTindakan) {
                $modelsIcd9 = $modelCustomer->pelaporanTindakan;
            } else {
                $modelsIcd9 = [new CodingPelaporanTindakanDetailRi];
            }
        }




        return $this->render(
            'detail-coder-pelaporan-edit',
            [
                'registrasi' => $registrasi->data,
                'model' => $resumeMedisRi,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'resep' => $resep,
                'listCoder' => $listCoder,
                'listClaim' => $listClaim,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,

                'icd' => $icd,
                'modelCustomer' => $modelCustomer,

                'modelsAddress' => (empty($modelsAddress)) ? [new CodingPelaporanDiagnosaDetailRi] : $modelsAddress,
                'modelsIcd9' => (empty($modelsIcd9)) ? [new CodingPelaporanTindakanDetailRi] : $modelsIcd9,

            ]
        );
    }

    public function actionDetailCoderPelaporanEditRj($id = null, $icd = true, $registrasi_kode = null)
    {

        $resumeMedisRi = ResumeMedisRj::find()->where(['id' => $id])->one();
        $registrasi = HelperSpesialClass::getCheckPasien($registrasi_kode);
        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()
                ->innerJoin('analisa_dokumen_detail', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();

        $listCoder = CodingPelaporanRi::find()->joinWith(['pelaporanDiagnosa', 'pelaporanTindakan'])->where(['registrasi_kode' => $registrasi->data['kode']])->one();

        $listClaim = CodingClaim::find()->joinWith(['claimDiagnosa', 'claimTindakan'])->where(['registrasi_kode' => $registrasi->data['kode']])->one();
        $listResumeMedisDokter = ResumeMedisRj::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokterVerifikator = ResumeMedisRjClaim::find()->joinWith(['dokterVerifikator', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where([ResumeMedisRjClaim::tableName() . '.registrasi_kode' => $registrasi->data['kode']])->andWhere(['batal' => 0])->all();

        $modelData = CodingPelaporanRj::find()->where(['id_resume_medis_rj' => $resumeMedisRi->id])->one();
        $modelCustomer = new CodingPelaporanRj();
        $modelsAddress = [new CodingPelaporanDiagnosaDetailRj];

        $modelsIcd9 = [new CodingPelaporanTindakanDetailRj];

        if ($modelData) {
            $modelCustomer = CodingPelaporanRj::find()->where(['id_resume_medis_rj' => $resumeMedisRi->id])->one();
            if ($modelCustomer->pelaporanDiagnosa) {
                $modelsAddress = $modelCustomer->pelaporanDiagnosa;
            } else {
                $modelsAddress = [new CodingPelaporanDiagnosaDetailRj];
            }
            if ($modelCustomer->pelaporanTindakan) {
                $modelsIcd9 = $modelCustomer->pelaporanTindakan;
            } else {
                $modelsIcd9 = [new CodingPelaporanTindakanDetailRj];
            }
        }




        return $this->render(
            'detail-coder-pelaporan-edit-rj',
            [
                'registrasi' => $registrasi->data,
                'model' => $resumeMedisRi,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'resep' => $resep,
                'listCoder' => $listCoder,
                'listClaim' => $listClaim,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,

                'icd' => $icd,
                'modelCustomer' => $modelCustomer,

                'modelsAddress' => (empty($modelsAddress)) ? [new CodingPelaporanDiagnosaDetailRi] : $modelsAddress,
                'modelsIcd9' => (empty($modelsIcd9)) ? [new CodingPelaporanTindakanDetailRi] : $modelsIcd9,

            ]
        );
    }
    public function actionDetailMpp($id = null)
    {
        $registrasi = HelperSpesialClass::getCheckPasien($id);
        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $model = CatatanMpp::find()->where(['layanan_id' => $layananId, 'pegawai_mpp_id' => HelperSpesialClass::getUserLogin()['pegawai_id']])->limit(1)->one();

        if ($model) {
            $model = CatatanMpp::find()->where(['layanan_id' => $layananId, 'pegawai_mpp_id' => HelperSpesialClass::getUserLogin()['pegawai_id']])->limit(1)->one();
        } else {
            $model = new CatatanMpp();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();
        $listMpp = CatatanMpp::find()->joinWith(['layanan', 'pegawai'])->where(['in', 'layanan_id', $layananId])->all();
        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        return $this->render(
            'detail-mpp',
            [
                'registrasi' => $registrasi->data,
                'model' => $model,
                'docClinicalList' => $docClinicList,
                'listMpp' => $listMpp,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'resep' => $resep,
            ]
        );
    }
    public function actionDetailMppResumeMedis($id = null)
    {
        $registrasi = HelperSpesialClass::getCheckPasien($id);
        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $model = new ResumeMedisRi();



        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();
        $listMpp = CatatanMpp::find()->joinWith(['layanan', 'pegawai'])->where(['in', 'layanan_id', $layananId])->all();
        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        return $this->render(
            'detail-mpp-resume-medis',
            [
                'registrasi' => $registrasi->data,
                'model' => $model,
                'docClinicalList' => $docClinicList,
                'listMpp' => $listMpp,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'resep' => $resep,
            ]
        );
    }
    public function actionDetailDokterVerifikator($id = null)
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

        $model = $this->initModelCreate($id, $chk_pasien, $userLogin);

        if (!$model) {

            \Yii::$app->session->setFlash('warning', "Maaf, Hanya Untuk Resume Medis RI Pasien Tidak Ditemukan ");
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $registrasi = HelperSpesialClass::getCheckPasien($id);
        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()
                ->innerJoin('analisa_dokumen_detail', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            return 'tes';

            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
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

        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);
        $modelDokterVerifikator = new ResumeMedisRiClaim();

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        return $this->render(
            'detail-dokter-verifikator',
            [
                'registrasi' => $registrasi->data,
                'model' => $modelDokterVerifikator,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,
                'resep' => $resep,
            ]
        );
    }

    public function actionDetailCoderClaim($id = null)
    {

        $userLogin = HelperSpesialClass::getUserLogin();
        if (!$userLogin['akses']) {
            Yii::$app->session->setFlash('warning', $userLogin['pesannoakses']);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $chk_pasien = HelperSpesialClass::getCheckPasien($id);
        // echo '<pre>';
        // print_r(HelperSpesialClass::getCheckPasien($id));
        // echo '</pre>';
        // die;
        if (!$chk_pasien->con) {
            \Yii::$app->session->setFlash('warning', $chk_pasien->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }

        $model = $this->initModelCreate($id, $chk_pasien, $userLogin);

        if (!$model) {
            \Yii::$app->session->setFlash('warning', "Maaf, Hanya Untuk Resume Medis RI Pasien Tidak Ditemukan ");
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $registrasi = HelperSpesialClass::getCheckPasien($id);
        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()
                ->innerJoin('analisa_dokumen_detail', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
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

        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);
        $modelDokterVerifikator = new ResumeMedisRiClaim();

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        return $this->render(
            'detail-coder-claim',
            [
                'registrasi' => $registrasi->data,
                'model' => $modelDokterVerifikator,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,
                'resep' => $resep,
            ]
        );
    }
    public function actionDetailCoderClaimRj($id = null)
    {

        $userLogin = HelperSpesialClass::getUserLogin();
        if (!$userLogin['akses']) {
            Yii::$app->session->setFlash('warning', $userLogin['pesannoakses']);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $chk_pasien = HelperSpesialClass::getCheckPasien($id);
        // echo '<pre>';
        // print_r(HelperSpesialClass::getCheckPasien($id));
        // echo '</pre>';
        // die;
        if (!$chk_pasien->con) {
            \Yii::$app->session->setFlash('warning', $chk_pasien->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }

        $model = $this->initModelCreateCoderRj($id, $chk_pasien, $userLogin);

        if (!$model) {
            \Yii::$app->session->setFlash('warning', "Maaf, Hanya Untuk Resume Medis RI Pasien Tidak Ditemukan ");
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $registrasi = HelperSpesialClass::getCheckPasien($id);
        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()
                ->innerJoin('analisa_dokumen_detail', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokter = ResumeMedisRj::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokterVerifikator = ResumeMedisRjClaim::find()->joinWith(['dokterVerifikator', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();

        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);
        $modelDokterVerifikator = new ResumeMedisRjClaim();

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        return $this->render(
            'detail-coder-claim-rj',
            [
                'registrasi' => $registrasi->data,
                'model' => $modelDokterVerifikator,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,
                'resep' => $resep,
            ]
        );
    }

    public function actionDetailCoderClaimRjNoVerif($id = null)
    {

        $userLogin = HelperSpesialClass::getUserLogin();
        if (!$userLogin['akses']) {
            Yii::$app->session->setFlash('warning', $userLogin['pesannoakses']);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $chk_pasien = HelperSpesialClass::getCheckPasien($id);
        // echo '<pre>';
        // print_r(HelperSpesialClass::getCheckPasien($id));
        // echo '</pre>';
        // die;
        if (!$chk_pasien->con) {
            \Yii::$app->session->setFlash('warning', $chk_pasien->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }

        $model = $this->initModelCreateCoderRj($id, $chk_pasien, $userLogin);

        if (!$model) {
            \Yii::$app->session->setFlash('warning', "Maaf, Hanya Untuk Resume Medis RI Pasien Tidak Ditemukan ");
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $registrasi = HelperSpesialClass::getCheckPasien($id);
        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()
                ->innerJoin('analisa_dokumen_detail', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokter = ResumeMedisRj::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokterVerifikator = ResumeMedisRjClaim::find()->joinWith(['dokterVerifikator', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();

        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);
        $modelDokterVerifikator = new ResumeMedisRjClaim();

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        return $this->render(
            'detail-coder-claim-rj-no-verif',
            [
                'registrasi' => $registrasi->data,
                'model' => $modelDokterVerifikator,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,
                'resep' => $resep,
            ]
        );
    }
    public function actionDetailCoderPelaporan($id = null, $icd = true)
    {

        $userLogin = HelperSpesialClass::getUserLogin();
        if (!$userLogin['akses']) {
            Yii::$app->session->setFlash('warning', $userLogin['pesannoakses']);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $chk_pasien = HelperSpesialClass::getCheckPasien($id);
        // echo '<pre>';
        // print_r(HelperSpesialClass::getCheckPasien($id));
        // echo '</pre>';
        // die;
        if (!$chk_pasien->con) {
            \Yii::$app->session->setFlash('warning', $chk_pasien->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        // print_r($this->initModelCreateCoder($id, $chk_pasien, $userLogin));
        // die;
        $model = $this->initModelCreateCoder($id, $chk_pasien, $userLogin);

        if (!$model) {
            \Yii::$app->session->setFlash('warning', "Maaf, Hanya Untuk Resume Medis RI Pasien Tidak Ditemukan ");
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $registrasi = HelperSpesialClass::getCheckPasien($id);
        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()
                ->innerJoin('analisa_dokumen_detail', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
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

        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);
        $modelDokterVerifikator = new ResumeMedisRiClaim();

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        $listCoder = CodingPelaporanRi::find()->joinWith(['pelaporanDiagnosa', 'pelaporanTindakan'])->where(['registrasi_kode' => $registrasi->data['kode']])->one();



        $modelCustomer = new CodingPelaporanRi();

        $modelsAddress = [new CodingPelaporanDiagnosaDetailRi];
        $modelsIcd9 = [new CodingPelaporanTindakanDetailRi()];



        return $this->render(
            'detail-coder-pelaporan',
            [
                'registrasi' => $registrasi->data,
                'model' => $model,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'resep' => $resep,
                'listCoder' => $listCoder,
                'icd' => $icd,
                'modelCustomer' => $modelCustomer,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,

                'modelsAddress' => (empty($modelsAddress)) ? [new CodingPelaporanDiagnosaDetailRi] : $modelsAddress,
                'modelsIcd9' => (empty($modelsIcd9)) ? [new CodingPelaporanTindakanDetailRi] : $modelsIcd9,

            ]
        );
    }
    public function actionDetailCoderPelaporanRj($id = null, $icd = true)
    {

        $userLogin = HelperSpesialClass::getUserLogin();
        if (!$userLogin['akses']) {
            Yii::$app->session->setFlash('warning', $userLogin['pesannoakses']);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $chk_pasien = HelperSpesialClass::getCheckPasien($id);
        // echo '<pre>';
        // print_r(HelperSpesialClass::getCheckPasien($id));
        // echo '</pre>';
        // die;
        if (!$chk_pasien->con) {
            \Yii::$app->session->setFlash('warning', $chk_pasien->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        // print_r($this->initModelCreateCoder($id, $chk_pasien, $userLogin));
        // die;
        $model = $this->initModelCreateCoderRj($id, $chk_pasien, $userLogin);

        if (!$model) {
            \Yii::$app->session->setFlash('warning', "Maaf, Hanya Untuk Resume Medis RI Pasien Tidak Ditemukan ");
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $registrasi = HelperSpesialClass::getCheckPasien($id);
        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()
                ->innerJoin('analisa_dokumen_detail', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRj::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokter = ResumeMedisRj::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokterVerifikator = ResumeMedisRjClaim::find()->joinWith(['dokterVerifikator', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();


        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);
        $modelDokterVerifikator = new ResumeMedisRiClaim();

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        $listCoder = CodingPelaporanRi::find()->joinWith(['pelaporanDiagnosa', 'pelaporanTindakan'])->where(['registrasi_kode' => $registrasi->data['kode']])->one();



        $modelCustomer = new CodingPelaporanRj();

        $modelsAddress = [new CodingPelaporanDiagnosaDetailRi];
        $modelsIcd9 = [new CodingPelaporanTindakanDetailRi()];



        return $this->render(
            'detail-coder-pelaporan-rj',
            [
                'registrasi' => $registrasi->data,
                'model' => $model,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'resep' => $resep,
                'listCoder' => $listCoder,
                'icd' => $icd,
                'modelCustomer' => $modelCustomer,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,

                'modelsAddress' => (empty($modelsAddress)) ? [new CodingPelaporanDiagnosaDetailRj] : $modelsAddress,
                'modelsIcd9' => (empty($modelsIcd9)) ? [new CodingPelaporanTindakanDetailRj] : $modelsIcd9,

            ]
        );
    }
    public function actionDetailDokterVerifikatorRj($id = null)
    {

        $userLogin = HelperSpesialClass::getUserLogin();
        if (!$userLogin['akses']) {
            Yii::$app->session->setFlash('warning', $userLogin['pesannoakses']);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $chk_pasien = HelperSpesialClass::getCheckPasien($id);
        // echo '<pre>';
        // print_r(HelperSpesialClass::getCheckPasien($id));
        // echo '</pre>';
        // die;
        if (!$chk_pasien->con) {
            \Yii::$app->session->setFlash('warning', $chk_pasien->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }

        $model = $this->initModelCreateRj($id, $chk_pasien, $userLogin);
        if (!$model) {
            \Yii::$app->session->setFlash('warning', "Maaf, Hanya Untuk Resume Medis RI Pasien Tidak Ditemukan ");
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $registrasi = HelperSpesialClass::getCheckPasien($id);
        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()
                ->innerJoin('analisa_dokumen_detail', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokter = ResumeMedisRj::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokterVerifikator = ResumeMedisRjClaim::find()->joinWith(['dokterVerifikator', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();

        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);
        $modelDokterVerifikator = new ResumeMedisRjClaim();

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        return $this->render(
            'detail-dokter-verifikator-rj',
            [
                'registrasi' => $registrasi->data,
                'model' => $modelDokterVerifikator,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,
                'resep' => $resep,
            ]
        );
    }
    public function actionDetailDokterVerifikatorEdit($id = null, $registrasi_kode = null)
    {
        $model = ResumeMedisRi::find()->where(['id' => $id])->one();
        $resumeMedisVerifikator = new ResumeMedisRiClaim();
        $resumeMedisVerifikator->id_resume_medis_ri = $model->id;
        $resumeMedisVerifikator->dokter_verifikator_id = HelperSpesialClass::getUserLogin()['pegawai_id'];
        $resumeMedisVerifikator->layanan_id = $model->layanan_id;
        $resumeMedisVerifikator->dokter_id = $model->dokter_id;
        $resumeMedisVerifikator->ringkasan_riwayat_penyakit = $model->ringkasan_riwayat_penyakit;
        $resumeMedisVerifikator->hasil_pemeriksaan_fisik = $model->hasil_pemeriksaan_fisik;
        $resumeMedisVerifikator->indikasi_rawat_inap = $model->indikasi_rawat_inap;
        $resumeMedisVerifikator->diagnosa_masuk_id = $model->diagnosa_masuk_id;
        $resumeMedisVerifikator->diagnosa_masuk_kode = $model->diagnosa_masuk_kode;
        $resumeMedisVerifikator->diagnosa_masuk_deskripsi = $model->diagnosa_masuk_deskripsi;
        $resumeMedisVerifikator->diagnosa_utama_id = $model->diagnosa_utama_id;
        $resumeMedisVerifikator->diagnosa_utama_kode = $model->diagnosa_utama_kode;
        $resumeMedisVerifikator->diagnosa_utama_deskripsi = $model->diagnosa_utama_deskripsi;
        $resumeMedisVerifikator->diagnosa_tambahan1_id = $model->diagnosa_tambahan1_id;
        $resumeMedisVerifikator->diagnosa_tambahan1_kode = $model->diagnosa_tambahan1_kode;
        $resumeMedisVerifikator->diagnosa_tambahan1_deskripsi = $model->diagnosa_tambahan1_deskripsi;
        $resumeMedisVerifikator->diagnosa_tambahan2_id = $model->diagnosa_tambahan2_id;
        $resumeMedisVerifikator->diagnosa_tambahan2_kode = $model->diagnosa_tambahan2_kode;

        $resumeMedisVerifikator->diagnosa_tambahan2_deskripsi = $model->diagnosa_tambahan2_deskripsi;
        $resumeMedisVerifikator->diagnosa_tambahan3_id = $model->diagnosa_tambahan3_id;
        $resumeMedisVerifikator->diagnosa_tambahan3_kode = $model->diagnosa_tambahan3_kode;
        $resumeMedisVerifikator->diagnosa_tambahan3_deskripsi = $model->diagnosa_tambahan3_deskripsi;
        $resumeMedisVerifikator->diagnosa_tambahan4_id = $model->diagnosa_tambahan4_id;
        $resumeMedisVerifikator->diagnosa_tambahan4_kode = $model->diagnosa_tambahan4_kode;
        $resumeMedisVerifikator->diagnosa_tambahan4_deskripsi = $model->diagnosa_tambahan4_deskripsi;
        $resumeMedisVerifikator->diagnosa_tambahan5_id = $model->diagnosa_tambahan5_id;
        $resumeMedisVerifikator->diagnosa_tambahan5_kode = $model->diagnosa_tambahan5_kode;
        $resumeMedisVerifikator->diagnosa_tambahan5_deskripsi = $model->diagnosa_tambahan5_deskripsi;
        $resumeMedisVerifikator->diagnosa_tambahan6_id = $model->diagnosa_tambahan6_id;
        $resumeMedisVerifikator->diagnosa_tambahan6_kode = $model->diagnosa_tambahan6_kode;
        $resumeMedisVerifikator->diagnosa_tambahan6_deskripsi = $model->diagnosa_tambahan6_deskripsi;
        $resumeMedisVerifikator->tindakan_utama_id = $model->tindakan_utama_id;
        $resumeMedisVerifikator->tindakan_utama_kode = $model->tindakan_utama_kode;
        $resumeMedisVerifikator->tindakan_utama_deskripsi = $model->tindakan_utama_deskripsi;
        $resumeMedisVerifikator->tindakan_tambahan1_id = $model->tindakan_tambahan1_id;
        $resumeMedisVerifikator->tindakan_tambahan1_kode = $model->tindakan_tambahan1_kode;
        $resumeMedisVerifikator->tindakan_tambahan1_deskripsi = $model->tindakan_tambahan1_deskripsi;
        $resumeMedisVerifikator->tindakan_tambahan2_id = $model->tindakan_tambahan2_id;
        $resumeMedisVerifikator->tindakan_tambahan2_kode = $model->tindakan_tambahan2_kode;
        $resumeMedisVerifikator->tindakan_tambahan2_deskripsi = $model->tindakan_tambahan2_deskripsi;
        $resumeMedisVerifikator->tindakan_tambahan3_id = $model->tindakan_tambahan3_id;
        $resumeMedisVerifikator->tindakan_tambahan3_kode = $model->tindakan_tambahan3_kode;
        $resumeMedisVerifikator->tindakan_tambahan3_deskripsi = $model->tindakan_tambahan3_deskripsi;
        $resumeMedisVerifikator->tindakan_tambahan4_id = $model->tindakan_tambahan4_id;
        $resumeMedisVerifikator->tindakan_tambahan4_kode = $model->tindakan_tambahan4_kode;
        $resumeMedisVerifikator->tindakan_tambahan4_deskripsi = $model->tindakan_tambahan4_deskripsi;
        $resumeMedisVerifikator->tindakan_tambahan5_id = $model->tindakan_tambahan5_id;
        $resumeMedisVerifikator->tindakan_tambahan5_kode = $model->tindakan_tambahan5_kode;
        $resumeMedisVerifikator->tindakan_tambahan5_deskripsi = $model->tindakan_tambahan5_deskripsi;
        $resumeMedisVerifikator->tindakan_tambahan6_id = $model->tindakan_tambahan6_id;
        $resumeMedisVerifikator->tindakan_tambahan6_kode = $model->tindakan_tambahan6_kode;
        $resumeMedisVerifikator->tindakan_tambahan6_deskripsi = $model->tindakan_tambahan6_deskripsi;
        $resumeMedisVerifikator->alergi = $model->alergi;
        $resumeMedisVerifikator->diet = $model->diet;
        $resumeMedisVerifikator->alasan_pulang = $model->alasan_pulang;
        $resumeMedisVerifikator->kondisi_pulang = $model->kondisi_pulang;
        $resumeMedisVerifikator->cara_pulang = $model->cara_pulang;
        $resumeMedisVerifikator->gcs_e = $model->gcs_e;
        $resumeMedisVerifikator->gcs_m = $model->gcs_m;
        $resumeMedisVerifikator->gcs_v = $model->gcs_v;
        $resumeMedisVerifikator->tingkat_kesadaran = $model->tingkat_kesadaran;
        $resumeMedisVerifikator->nadi = $model->nadi;
        $resumeMedisVerifikator->darah = $model->darah;
        $resumeMedisVerifikator->pernapasan = $model->pernapasan;
        $resumeMedisVerifikator->suhu = $model->suhu;
        $resumeMedisVerifikator->sato2 = $model->sato2;
        $resumeMedisVerifikator->berat_badan = $model->berat_badan;
        $resumeMedisVerifikator->tinggi_badan = $model->tinggi_badan;
        $resumeMedisVerifikator->keadaan_gizi = $model->keadaan_gizi;
        $resumeMedisVerifikator->keadaan_umum = $model->keadaan_umum;
        $resumeMedisVerifikator->terapi_perawatan = $model->terapi_perawatan;
        $resumeMedisVerifikator->obat_rumah = $model->obat_rumah;
        $resumeMedisVerifikator->terapi_pulang = $model->terapi_pulang;
        $resumeMedisVerifikator->hasil_penunjang = $model->hasil_penunjang;
        $resumeMedisVerifikator->poli_tujuan_kontrol_id = $model->poli_tujuan_kontrol_id;
        $resumeMedisVerifikator->poli_tujuan_kontrol_nama = $model->poli_tujuan_kontrol_nama;
        $resumeMedisVerifikator->tgl_kontrol = $model->tgl_kontrol;
        $resumeMedisVerifikator->terapi_dirawat = $model->terapi_dirawat;
        $resumeMedisVerifikator->tgl_pulang = $model->tgl_pulang;
        $resumeMedisVerifikator->layanan_pulang_id = $model->layanan_pulang_id;



        // $chk_pasien = HelperSpesialClass::getCheckPasien($id);
        // // echo '<pre>';
        // // print_r(HelperSpesialClass::getCheckPasien($id));
        // // echo '</pre>';
        // // die;
        // if (!$chk_pasien->con) {
        //     \Yii::$app->session->setFlash('warning', $chk_pasien->msg);
        //     return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        // }


        $registrasi = HelperSpesialClass::getCheckPasien($registrasi_kode);

        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()
                ->innerJoin('analisa_dokumen_detail', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
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
        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        return $this->render(
            'detail-dokter-verifikator-edit',
            [
                'registrasi' => $registrasi->data,
                'model' => $resumeMedisVerifikator,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,

                'resep' => $resep,
            ]
        );
    }
    public function actionDetailDokterVerifikatorRjEdit($id = null, $registrasi_kode = null)
    {
        $model = ResumeMedisRj::find()->where(['id' => $id])->one();
        $resumeMedisVerifikator = new ResumeMedisRjClaim();
        $resumeMedisVerifikator->id_resume_medis_rj = $model->id;
        $resumeMedisVerifikator->dokter_verifikator_id = HelperSpesialClass::getUserLogin()['pegawai_id'];
        $resumeMedisVerifikator->layanan_id = $model->layanan_id;
        $resumeMedisVerifikator->dokter_id = $model->dokter_id;
        $resumeMedisVerifikator->anamesis = $model->anamesis;
        $resumeMedisVerifikator->pemeriksaan_fisik = $model->pemeriksaan_fisik;
        $resumeMedisVerifikator->diagnosa = $model->diagnosa;
        $resumeMedisVerifikator->diagnosa_utama_id = $model->diagnosa_utama_id;
        $resumeMedisVerifikator->diagnosa_tambahan1_id = $model->diagnosa_tambahan1_id;
        $resumeMedisVerifikator->diagnosa_tambahan2_id = $model->diagnosa_tambahan2_id;
        $resumeMedisVerifikator->diagnosa_tambahan3_id = $model->diagnosa_tambahan3_id;
        $resumeMedisVerifikator->diagnosa_tambahan4_id = $model->diagnosa_tambahan4_id;
        $resumeMedisVerifikator->diagnosa_tambahan5_id = $model->diagnosa_tambahan5_id;
        $resumeMedisVerifikator->diagnosa_tambahan6_id = $model->diagnosa_tambahan6_id;
        $resumeMedisVerifikator->tindakan = $model->tindakan;
        $resumeMedisVerifikator->tindakan_utama_id = $model->tindakan_utama_id;
        $resumeMedisVerifikator->tindakan_tambahan1_id = $model->tindakan_tambahan1_id;
        $resumeMedisVerifikator->tindakan_tambahan2_id = $model->tindakan_tambahan2_id;
        $resumeMedisVerifikator->tindakan_tambahan3_id = $model->tindakan_tambahan3_id;
        $resumeMedisVerifikator->tindakan_tambahan4_id = $model->tindakan_tambahan4_id;
        $resumeMedisVerifikator->tindakan_tambahan5_id = $model->tindakan_tambahan5_id;
        $resumeMedisVerifikator->tindakan_tambahan6_id = $model->tindakan_tambahan6_id;
        $resumeMedisVerifikator->terapi = $model->terapi;
        $resumeMedisVerifikator->rencana = $model->rencana;
        $resumeMedisVerifikator->alasan_kontrol = $model->alasan_kontrol;
        $resumeMedisVerifikator->alasan = $model->alasan;
        $resumeMedisVerifikator->lab = $model->lab;
        $resumeMedisVerifikator->rad = $model->rad;
        $resumeMedisVerifikator->poli_tujuan_kontrol_id = $model->poli_tujuan_kontrol_id;
        $resumeMedisVerifikator->poli_tujuan_kontrol_nama = $model->poli_tujuan_kontrol_nama;
        $resumeMedisVerifikator->tgl_kontrol = $model->tgl_kontrol;
        $resumeMedisVerifikator->keterangan = $model->keterangan;
        $resumeMedisVerifikator->kasus = $model->kasus;


        $registrasi = HelperSpesialClass::getCheckPasien($registrasi_kode);

        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()
                ->innerJoin('analisa_dokumen_detail', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokter = ResumeMedisRj::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokterVerifikator = ResumeMedisRjClaim::find()->joinWith(['dokterVerifikator', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        return $this->render(
            'detail-dokter-verifikator-rj-edit',
            [
                'registrasi' => $registrasi->data,
                'model' => $resumeMedisVerifikator,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,

                'resep' => $resep,
            ]
        );
    }

    public function actionDetailMppEditResume($id = null, $registrasi_kode = null)
    {
        $model = ResumeMedisRi::find()->where(['id' => $id])->one();

        $registrasi = HelperSpesialClass::getCheckPasien($registrasi_kode);

        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()
                ->innerJoin('analisa_dokumen_detail', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
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
        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();
        $listMpp = CatatanMpp::find()->joinWith(['layanan', 'pegawai'])->where(['in', 'layanan_id', $layananId])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        return $this->render(
            'detail-mpp-resume-medis-edit',
            [
                'registrasi' => $registrasi->data,
                'model' => $model,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,
                'listMpp' => $listMpp,
                'resep' => $resep,
            ]
        );
    }
    public function actionDetailDokterVerifikatorUpdate($id = null, $registrasi_kode = null)
    {
        $resumeMedisVerifikator = ResumeMedisRiClaim::find()->where(['id' => $id])->one();


        $registrasi = HelperSpesialClass::getCheckPasien($registrasi_kode);

        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()
                ->innerJoin('analisa_dokumen_detail', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
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
        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        return $this->render(
            'detail-dokter-verifikator-update',
            [
                'registrasi' => $registrasi->data,
                'model' => $resumeMedisVerifikator,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,

                'resep' => $resep,
            ]
        );
    }

    public function actionDetailCoderClaimUpdate($id = null, $registrasi_kode = null)
    {
        $resumeMedisVerifikator = ResumeMedisRiClaim::find()->where(['id' => $id])->one();


        $registrasi = HelperSpesialClass::getCheckPasien($registrasi_kode);

        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()
                ->innerJoin('analisa_dokumen_detail', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
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
        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        return $this->render(
            'detail-coder-claim-update',
            [
                'registrasi' => $registrasi->data,
                'model' => $resumeMedisVerifikator,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,

                'resep' => $resep,
            ]
        );
    }

    public function actionDetailCoderClaimRjUpdate($id = null, $registrasi_kode = null)
    {
        $resumeMedisVerifikator = ResumeMedisRjClaim::find()->where(['id' => $id])->one();


        $registrasi = HelperSpesialClass::getCheckPasien($registrasi_kode);

        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()
                ->innerJoin('analisa_dokumen_detail', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRj::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokter = ResumeMedisRj::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokterVerifikator = ResumeMedisRjClaim::find()->joinWith(['dokterVerifikator', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();


        return $this->render(
            'detail-coder-claim-update-rj',
            [
                'registrasi' => $registrasi->data,
                'model' => $resumeMedisVerifikator,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,

                'resep' => $resep,
            ]
        );
    }
    public function actionDetailCoderClaimRjNoVerifUpdate($id = null, $registrasi_kode = null)
    {
        $resumeMedisVerifikator = ResumeMedisRjClaim::find()->where(['id' => $id])->one();


        $registrasi = HelperSpesialClass::getCheckPasien($registrasi_kode);

        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()
                ->innerJoin('analisa_dokumen_detail', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRj::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokter = ResumeMedisRj::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokterVerifikator = ResumeMedisRjClaim::find()->joinWith(['dokterVerifikator', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where([ResumeMedisRjClaim::tableName() . '.registrasi_kode' => $registrasi->data['kode']])->andWhere(['batal' => 0])->all();
        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        $modelData = CodingClaimRj::find()->where(['registrasi_kode' => $registrasi->data['kode']])->one();
        $modelCustomer = new CodingClaimRj();
        $modelsAddress = [new CodingClaimDiagnosaDetailRj];

        $modelsIcd9 = [new CodingClaimTindakanDetailRj];

        if ($modelData) {
            $modelCustomer = CodingClaimRj::find()->where(['registrasi_kode' => $registrasi->data['kode']])->one();
            if ($modelCustomer->pelaporanDiagnosa) {
                $modelsAddress = $modelCustomer->pelaporanDiagnosa;
            } else {
                $modelsAddress = [new CodingClaimDiagnosaDetailRj];
            }
            if ($modelCustomer->pelaporanTindakan) {
                $modelsIcd9 = $modelCustomer->pelaporanTindakan;
            } else {
                $modelsIcd9 = [new CodingClaimTindakanDetailRj];
            }
        }
        return $this->render(
            'detail-coder-claim-update-rj-no-verif',
            [
                'registrasi' => $registrasi->data,
                'model' => $resumeMedisVerifikator,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,

                'resep' => $resep,
                'modelCustomer' => $modelCustomer,

                'modelsAddress' => (empty($modelsAddress)) ? [new CodingPelaporanDiagnosaDetailRi] : $modelsAddress,
                'modelsIcd9' => (empty($modelsIcd9)) ? [new CodingPelaporanTindakanDetailRi] : $modelsIcd9,
            ]
        );
    }

    public function actionDetailCoderClaimRjNoVerifEdit($id = null, $registrasi_kode = null)
    {
        $model = ResumeMedisRj::find()->where(['id' => $id])->one();
        $registrasi = HelperSpesialClass::getCheckPasien($registrasi_kode);
        $resumeMedisVerifikator = ResumeMedisRjClaim::find()->where(['id_resume_medis_rj' => $model->id])->one();
        if (!empty($modelResumeMedisRjClaim)) {
            $resumeMedisVerifikator = ResumeMedisRjClaim::find()->where(['id_resume_medis_rj' => $model->id])->one();
        } else {
            $resumeMedisVerifikator = new ResumeMedisRjClaim();
            $resumeMedisVerifikator->id_resume_medis_rj = $model->id;
            $resumeMedisVerifikator->dokter_verifikator_id = HelperSpesialClass::getUserLogin()['pegawai_id'];
            $resumeMedisVerifikator->layanan_id = $model->layanan_id;
            $resumeMedisVerifikator->registrasi_kode = $registrasi->data['kode'];

            $resumeMedisVerifikator->dokter_id = $model->dokter_id;
            $resumeMedisVerifikator->anamesis = $model->anamesis;
            $resumeMedisVerifikator->pemeriksaan_fisik = $model->pemeriksaan_fisik;
            $resumeMedisVerifikator->diagnosa = $model->diagnosa;
            $resumeMedisVerifikator->diagnosa_utama_id = $model->diagnosa_utama_id;
            $resumeMedisVerifikator->diagnosa_tambahan1_id = $model->diagnosa_tambahan1_id;
            $resumeMedisVerifikator->diagnosa_tambahan2_id = $model->diagnosa_tambahan2_id;
            $resumeMedisVerifikator->diagnosa_tambahan3_id = $model->diagnosa_tambahan3_id;
            $resumeMedisVerifikator->diagnosa_tambahan4_id = $model->diagnosa_tambahan4_id;
            $resumeMedisVerifikator->diagnosa_tambahan5_id = $model->diagnosa_tambahan5_id;
            $resumeMedisVerifikator->diagnosa_tambahan6_id = $model->diagnosa_tambahan6_id;
            $resumeMedisVerifikator->tindakan = $model->tindakan;
            $resumeMedisVerifikator->tindakan_utama_id = $model->tindakan_utama_id;
            $resumeMedisVerifikator->tindakan_tambahan1_id = $model->tindakan_tambahan1_id;
            $resumeMedisVerifikator->tindakan_tambahan2_id = $model->tindakan_tambahan2_id;
            $resumeMedisVerifikator->tindakan_tambahan3_id = $model->tindakan_tambahan3_id;
            $resumeMedisVerifikator->tindakan_tambahan4_id = $model->tindakan_tambahan4_id;
            $resumeMedisVerifikator->tindakan_tambahan5_id = $model->tindakan_tambahan5_id;
            $resumeMedisVerifikator->tindakan_tambahan6_id = $model->tindakan_tambahan6_id;
            $resumeMedisVerifikator->terapi = $model->terapi;
            $resumeMedisVerifikator->rencana = $model->rencana;
            $resumeMedisVerifikator->alasan_kontrol = $model->alasan_kontrol;
            $resumeMedisVerifikator->alasan = $model->alasan;
            $resumeMedisVerifikator->lab = $model->lab;
            $resumeMedisVerifikator->rad = $model->rad;
            $resumeMedisVerifikator->poli_tujuan_kontrol_id = $model->poli_tujuan_kontrol_id;
            $resumeMedisVerifikator->poli_tujuan_kontrol_nama = $model->poli_tujuan_kontrol_nama;
            $resumeMedisVerifikator->tgl_kontrol = $model->tgl_kontrol;
            $resumeMedisVerifikator->keterangan = $model->keterangan;
            $resumeMedisVerifikator->kasus = $model->kasus;
        }




        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()
                ->innerJoin('analisa_dokumen_detail', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRj::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokter = ResumeMedisRj::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokterVerifikator = ResumeMedisRjClaim::find()->joinWith(['dokterVerifikator', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        return $this->render(
            'detail-coder-claim-edit-rj-no-verif',
            [
                'registrasi' => $registrasi->data,
                'model' => $resumeMedisVerifikator,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,

                'resep' => $resep,
            ]
        );
    }

    public function actionDetailDokterVerifikatorRjUpdate($id = null, $registrasi_kode = null)
    {
        $resumeMedisVerifikator = ResumeMedisRjClaim::find()->where(['id' => $id])->one();


        $registrasi = HelperSpesialClass::getCheckPasien($registrasi_kode);

        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()
                ->innerJoin('analisa_dokumen_detail', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokter = ResumeMedisRj::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisDokterVerifikator = ResumeMedisRjClaim::find()->joinWith(['dokterVerifikator', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere(['api_final' => 1])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        return $this->render(
            'detail-dokter-verifikator-rj-update',
            [
                'registrasi' => $registrasi->data,
                'model' => $resumeMedisVerifikator,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,

                'resep' => $resep,
            ]
        );
    }
    protected function initModelCreateCoder($id = null, $chk_pasien = [], $user = [])
    {
        if (!$chk_pasien) {
            $chk_pasien = HelperSpesialClass::getCheckPasien($id);
            if (!$chk_pasien->con) {
                \Yii::$app->session->setFlash('warning', $chk_pasien->msg);
                return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
            }
        }

        $dokter_id = null;
        $layanan_id = null;
        foreach ($chk_pasien->data['pjpRi'] as $val) {

            // if($val['pegawai_id']==$user['pegawai_id'] && HelperSpesialClass::isDokter($user) && $val['status']==PjpRi::DPJP){
            $dokter_id = $val['pegawai_id'];
            // break;
            // }

        }

        if (empty($dokter_id)) {
            // \Yii::$app->session->setFlash('warning', "Maaf, Anda Tidak Terdaftar Sebagai DPJP Rawatinap");
            // return Yii::$app->response->redirect(Url::to(['/pasien-site/index/'], false));
            return false;
        }
        foreach ($chk_pasien->data['layanan'] as $item) {
            $layanan_id[] = $item['id'];
        }
        $d_layanan = Layanan::find()->select(['id'])->where(['registrasi_kode' => $chk_pasien->data['kode'], 'jenis_layanan' => Layanan::RI])->asArray()->all();
        $model = ResumeMedisRi::find()->where(['IN', 'layanan_id', ArrayHelper::getColumn($d_layanan, 'id')])->orderBy(['created_at' => SORT_DESC])->one();
        // return $model;

        if (!isset($model)) {
            // $asesmen=AsesmenAwalMedis::find()->where(['IN','layanan_id',ArrayHelper::getColumn($d_layanan, 'id')])->andWhere(['dokter_id'=>$dokter_id,'draf'=>0,'batal'=>0])->orderBy(['tanggal_final'=>SORT_DESC])->asArray()->one();
            $asesmen = AsesmenAwalMedis::find()->where(['IN', 'layanan_id', ArrayHelper::getColumn($d_layanan, 'id')])->andWhere(['dokter_id' => $dokter_id])->orderBy(['created_at' => SORT_DESC])->asArray()->one();
            // echo'<pre/>';print_r($asesmen);die();
            $model = new ResumeMedisRi();
            $model->dokter_id = $dokter_id;
            $model->layanan_id = $layanan_id;
            if ($asesmen) {
                $model->ringkasan_riwayat_penyakit = $asesmen['riwayat_penyakit_sekarang'];
                $model->alergi = $asesmen['alergi'];
                $model->diagnosa_masuk_deskripsi = $asesmen['masalah'];
            } else {
                $model->alergi = 'Tidak Ada';
            }
            $model->draf = 1;
            $model->diet = 'Tidak Ada';
            $model->obat_rumah = 'Tidak Ada';
            $model->terapi_pulang = 'Tidak Ada';
        }
        return $model;
    }
    protected function initModelCreateCoderRj($id = null, $chk_pasien = [], $user = [])
    {
        if (!$chk_pasien) {
            $chk_pasien = HelperSpesialClass::getCheckPasien($id);
            if (!$chk_pasien->con) {
                \Yii::$app->session->setFlash('warning', $chk_pasien->msg);
                return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
            }
        }

        $dokter_id = null;
        $layanan_id = null;

        foreach ($chk_pasien->data['layanan'] as $item) {
            $layanan_id[] = $item['id'];
        }
        $d_layanan = Layanan::find()->select(['id'])->where(['registrasi_kode' => $chk_pasien->data['kode']])->asArray()->all();
        $model = ResumeMedisRj::find()->where(['IN', 'layanan_id', ArrayHelper::getColumn($d_layanan, 'id')])->orderBy(['created_at' => SORT_DESC])->one();


        if (!isset($model)) {
            // $asesmen=AsesmenAwalMedis::find()->where(['IN','layanan_id',ArrayHelper::getColumn($d_layanan, 'id')])->andWhere(['dokter_id'=>$dokter_id,'draf'=>0,'batal'=>0])->orderBy(['tanggal_final'=>SORT_DESC])->asArray()->one();
            $asesmen = AsesmenAwalMedis::find()->where(['IN', 'layanan_id', ArrayHelper::getColumn($d_layanan, 'id')])->andWhere(['dokter_id' => $dokter_id])->orderBy(['created_at' => SORT_DESC])->asArray()->one();
            // echo'<pre/>';print_r($asesmen);die();
            $model = new ResumeMedisRi();
            $model->dokter_id = $dokter_id;
            $model->layanan_id = $layanan_id;
            if ($asesmen) {
                $model->ringkasan_riwayat_penyakit = $asesmen['riwayat_penyakit_sekarang'];
                $model->alergi = $asesmen['alergi'];
                $model->diagnosa_masuk_deskripsi = $asesmen['masalah'];
            } else {
                $model->alergi = 'Tidak Ada';
            }
            $model->draf = 1;
            $model->diet = 'Tidak Ada';
            $model->obat_rumah = 'Tidak Ada';
            $model->terapi_pulang = 'Tidak Ada';
        }
        return $model;
    }


    protected function initModelCreate($id = null, $chk_pasien = [], $user = [])
    {
        if (!$chk_pasien) {
            $chk_pasien = HelperSpesialClass::getCheckPasien($id);
            if (!$chk_pasien->con) {
                \Yii::$app->session->setFlash('warning', $chk_pasien->msg);
                return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
            }
        }

        $dokter_id = null;
        $layanan_id = null;
        foreach ($chk_pasien->data['pjpRi'] as $val) {

            // if($val['pegawai_id']==$user['pegawai_id'] && HelperSpesialClass::isDokter($user) && $val['status']==PjpRi::DPJP){
            $dokter_id = $val['pegawai_id'];
            // break;
            // }

        }

        if (empty($dokter_id)) {
            // \Yii::$app->session->setFlash('warning', "Maaf, Anda Tidak Terdaftar Sebagai DPJP Rawatinap");
            // return Yii::$app->response->redirect(Url::to(['/pasien-site/index/'], false));
            return false;
        }
        foreach ($chk_pasien->data['layanan'] as $item) {
            $layanan_id[] = $item['id'];
        }
        // $layanan_id=$chk_pasien->data['id'];
        $d_layanan = Layanan::find()->select(['id'])->where(['registrasi_kode' => $chk_pasien->data['kode'], 'jenis_layanan' => Layanan::RI])->asArray()->all();
        $model = ResumeMedisRi::find()->where(['IN', 'layanan_id', ArrayHelper::getColumn($d_layanan, 'id')])->andWhere(['dokter_id' => $dokter_id])->nobatal()->orderBy(['created_at' => SORT_DESC])->one();
        if (!isset($model)) {
            // $asesmen=AsesmenAwalMedis::find()->where(['IN','layanan_id',ArrayHelper::getColumn($d_layanan, 'id')])->andWhere(['dokter_id'=>$dokter_id,'draf'=>0,'batal'=>0])->orderBy(['tanggal_final'=>SORT_DESC])->asArray()->one();
            $asesmen = AsesmenAwalMedis::find()->where(['IN', 'layanan_id', ArrayHelper::getColumn($d_layanan, 'id')])->andWhere(['dokter_id' => $dokter_id])->orderBy(['created_at' => SORT_DESC])->asArray()->one();
            // echo'<pre/>';print_r($asesmen);die();
            $model = new ResumeMedisRi();
            $model->dokter_id = $dokter_id;
            $model->layanan_id = $layanan_id;
            if ($asesmen) {
                $model->ringkasan_riwayat_penyakit = $asesmen['riwayat_penyakit_sekarang'];
                $model->alergi = $asesmen['alergi'];
                $model->diagnosa_masuk_deskripsi = $asesmen['masalah'];
            } else {
                $model->alergi = 'Tidak Ada';
            }
            $model->draf = 1;
            $model->diet = 'Tidak Ada';
            $model->obat_rumah = 'Tidak Ada';
            $model->terapi_pulang = 'Tidak Ada';
        }
        return $model;
    }
    protected function initModelCreateRj($id = null, $chk_pasien = [], $user = [])
    {

        if (!$chk_pasien) {
            $chk_pasien = HelperSpesialClass::getCheckPasien($id);

            if (!$chk_pasien->con) {
                \Yii::$app->session->setFlash('warning', $chk_pasien->msg);
                return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
            }
        }
        return $chk_pasien;

        $dokter_id = null;
        $layanan_id = [];

        if ($chk_pasien->data['jenis_layanan'] === Layanan::RJ) {
            foreach ($chk_pasien->data['pjp'] as $val) {
                if ($val['pegawai_id'] == $user['pegawai_id'] && HelperSpesialClass::isDokter($user)) {
                    $dokter_id = $val['pegawai_id'];
                    break;
                } else if ($val['status'] == Pjp::DPJP) {
                    $dokter_id = $val['pegawai_id'];
                    break;
                }
            }
        } else {
            return false;
        }

        if (empty($dokter_id)) {
            // \Yii::$app->session->setFlash('warning', "Maaf, Anda Tidak Terdaftar Sebagai DPJP Rawatinap");
            // return Yii::$app->response->redirect(Url::to(['/pasien-site/index/'], false));
            return false;
        }
        foreach ($chk_pasien->data['layanan'] as $item) {
            if ($chk_pasien->data['jenis_layanan'] === Layanan::RJ) {
                $layanan_id[] = $item['id'];
                foreach ($chk_pasien->data['pjp'] as $val) {
                    if ($val['pegawai_id'] == $user['pegawai_id'] && HelperSpesialClass::isDokter($user)) {
                        $dokter_id = $val['pegawai_id'];
                        break;
                    } else if ($val['status'] == Pjp::DPJP) {
                        $dokter_id = $val['pegawai_id'];
                        break;
                    }
                }
            } else {
                return false;
            }
        }



        // $d_layanan = Layanan::find()->select(['id'])->where(['registrasi_kode' => $chk_pasien->data['kode'], 'jenis_layanan' => Layanan::RI])->asArray()->all();
        $model = ResumeMedisRj::find()->where([['in', 'layanan_id' => $layanan_id], 'dokter_id' => $dokter_id])->nobatal()->orderBy(['created_at' => SORT_DESC])->one();

        if (!isset($model)) {
            $cppt = Cppt::find()->where(['layanan_id' => $layanan_id, 'dokter_perawat_id' => $dokter_id, 'draf' => 0, 'batal' => 0])->asArray()->one();
            $model = new ResumeMedisRj();
            $resep_txt = null;
            // if($user['pegawai_id']=='219'){
            $resep = Resep::find()->with(['resepDetail.obat'])->where(['layanan_id' => $layanan_id, 'dokter_id' => $dokter_id, 'is_deleted' => 0])->orderBy(['created_at' => SORT_ASC])->asArray()->all();
            // echo'<pre/>';print_r($resep);die();
            if ($resep) {
                foreach ($resep as $val) {
                    $no = 1;
                    foreach ($val['resepDetail'] as $resep_detail) {
                        if (empty($resep_txt)) {
                            // $resep_txt=$resep_detail['obat']['nama_barang'].'/'.$resep_detail['jumlah'].'/'.$resep_detail['dosis'].'/'.$resep_detail['catatan'];
                            $resep_txt = $no++ . ') Nama Obat/Alkes :' . $resep_detail['obat']['nama_barang'];
                            // if(!empty($resep_detail['jumlah'])){
                            //     $resep_txt=$resep_txt.'/ Jumlah :'.$resep_detail['jumlah'];
                            // }
                            if (!empty($resep_detail['dosis'])) {
                                $resep_txt = $resep_txt . '/ Dosis :' . $resep_detail['dosis'];
                            }
                            // if(!empty($resep_detail['catatan'])){
                            //     $resep_txt=$resep_txt.'/ Catatan :'.$resep_detail['catatan'];
                            // }
                        } else {
                            $resep_txt = $resep_txt . '; ' . $no++ . ')  Nama Obat/Alkes :' . $resep_detail['obat']['nama_barang'];
                            // if(!empty($resep_detail['jumlah'])){
                            //     $resep_txt=$resep_txt.'/ Jumlah :'.$resep_detail['jumlah'];
                            // }
                            if (!empty($resep_detail['dosis'])) {
                                $resep_txt = $resep_txt . '/ Dosis :' . $resep_detail['dosis'];
                            }
                            // if(!empty($resep_detail['catatan'])){
                            //     $resep_txt=$resep_txt.'/ Catatan :'.$resep_detail['catatan'];
                            // }
                        }
                    }
                }
                // echo'<pre/>';print_r($resep_txt);die();
            }
            // }

            if ($cppt) {
                $model->anamesis = $cppt['s'];
                $model->pemeriksaan_fisik = $cppt['o'];
                $model->diagnosa = $cppt['a'];
                $model->tindakan = $cppt['p'];
            } else {
                $model->anamesis = 'Tidak Ada';
                $model->pemeriksaan_fisik = 'Tidak Ada';
            }


            $model->dokter_id = $dokter_id;
            $model->layanan_id = $layanan_id;
            $model->draf = 1;

            if (!empty($resep_txt)) {
                $model->terapi = $resep_txt;
            } else {
                $model->terapi = 'Tidak Ada';
            }

            // $model->terapi='Tidak Ada';
            $model->lab = 'Tidak Ada';
            $model->rad = 'Tidak Ada';
            $model->keterangan = 'Tidak Ada';
        }
        return $model;
    }
    public function actionListCheckout()
    {
        $searchModel = new RegistrasiSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('list-checkout', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionListRawatJalanBackup()
    {
        $req = Yii::$app->request;
        $searchModel = new RegistrasiSearch();



        $queryCount = "with ranap as (
            select   d.kode ,array_agg(r.jenis_layanan) as jenis
            from pendaftaran.registrasi d
            left join (select * from pendaftaran.layanan r order by r.registrasi_kode,r.created_at asc) as r on r.registrasi_kode=d.kode and r.deleted_at is null
            where r.unit_tujuan_kode is null and d.deleted_at is Null ";
        if (!empty($req->get('RegistrasiSearch')['tgl_awal'])) {
            $queryCount .= " and d.tgl_masuk::date >= date '" . $req->get('RegistrasiSearch')['tgl_awal'] . "'";
        } else {
            $queryCount .= " and d.tgl_masuk::date >= date '" . date('Y-m-d') . "'";
        }

        if (!empty($req->get('RegistrasiSearch')['tgl_akhir'])) {
            $queryCount .= " and d.tgl_masuk::date <= date '" . $req->get('RegistrasiSearch')['tgl_akhir'] . "'";
        } else {
            $queryCount .= " and d.tgl_masuk::date <= date '" . date('Y-m-d') . "'";
        }

        $queryCount .= " GROUP BY d.kode
            )
            select
                count(distinct d.kode)
            from
                ranap
            inner join pendaftaran.registrasi d on
                d.kode = ranap.kode
                and jenis::text not like '%3%'
            inner join pendaftaran.layanan r on
                r.registrasi_kode = d.kode
                and r.jenis_layanan = '2'
                and r.deleted_at is null  
            inner join pendaftaran.pasien k on k.kode=d.pasien_kode
            left join pengolahan_data.analisa_dokumen ad on d.kode = ad.reg_kode ";
        if (!empty($req->get('RegistrasiSearch')['pasien'])) {
            $queryCount .= " where k.nama ilike '%" . $req->get('RegistrasiSearch')['pasien'] . "%' or d.kode ilike '%" . $req->get('RegistrasiSearch')['pasien'] . "%' or k.kode ilike '%" . $req->get('RegistrasiSearch')['pasien'] . "%'";
        }

        if (!empty($req->get('RegistrasiSearch')['is_analisa']) && $req->get('RegistrasiSearch')['is_analisa'] == 1) {
            $queryCount .= " and d.is_analisa = '" . $req->get('RegistrasiSearch')['pasien'] . "'";
        }

        $totalCount  = \Yii::$app->db->createCommand($queryCount)->queryScalar();


        $sql  = "with ranap as (
            select   d.kode ,array_agg(r.jenis_layanan) as jenis
            from pendaftaran.registrasi d
            left join (select * from pendaftaran.layanan r order by r.registrasi_kode,r.created_at asc) as r on r.registrasi_kode=d.kode  and r.deleted_at is null
            where r.unit_tujuan_kode is null and d.deleted_at is Null ";
        if (!empty($req->get('RegistrasiSearch')['tgl_awal'])) {
            $sql .= " and d.tgl_masuk::date >= date '" . $req->get('RegistrasiSearch')['tgl_awal'] . "'";
        } else {
            $sql .= " and d.tgl_masuk::date >= date '" . date('Y-m-d') . "'";
        }

        if (!empty($req->get('RegistrasiSearch')['tgl_akhir'])) {
            $sql .= " and d.tgl_masuk::date <= date '" . $req->get('RegistrasiSearch')['tgl_akhir'] . "'";
        } else {
            $sql .= " and d.tgl_masuk::date <= date '" . date('Y-m-d') . "'";
        }
        $sql .= " GROUP BY d.kode
            )
            select d.kode,
            d.pasien_kode,
            k.nama,
            d.tgl_masuk,
            d.tgl_keluar,
            array_agg(r.tgl_masuk) as list_tgl,
            array_agg(u.nama) as poli,
            d.is_analisa
            from
                ranap
            inner join pendaftaran.registrasi d on
                d.kode = ranap.kode
                and jenis::text not like '%3%'
            inner join pendaftaran.layanan r on
                r.registrasi_kode = d.kode
                and r.jenis_layanan = '2'
                and r.deleted_at is null  
            inner join pendaftaran.pasien k on k.kode=d.pasien_kode
            inner join pegawai.dm_unit_penempatan u on u.kode=r.unit_kode 
            left join pengolahan_data.analisa_dokumen ad on d.kode = ad.reg_kode ";

        if ($req->get('RegistrasiSearch')['pasien'] == null && $req->get('RegistrasiSearch')['is_analisa'] != null) {
            $sql .= "where ";
            if ($req->get('RegistrasiSearch')['is_analisa'] == 'belum') {
                $sql .= " d.is_analisa = '0'";
            } elseif ($req->get('RegistrasiSearch')['is_analisa'] == 'sudah') {
                $sql .= " d.is_analisa = '1'";
            }
        } elseif ($req->get('RegistrasiSearch')['pasien'] != null && $req->get('RegistrasiSearch')['is_analisa'] == null) {
            $sql .= "where ";
            $sql .= " k.nama ilike '%" . $req->get('RegistrasiSearch')['pasien'] . "%' or d.kode ilike '%" . $req->get('RegistrasiSearch')['pasien'] . "%' or k.kode ilike '%" . $req->get('RegistrasiSearch')['pasien'] . "%'";
        } elseif ($req->get('RegistrasiSearch')['pasien'] != null && $req->get('RegistrasiSearch')['is_analisa'] != null) {
            $sql .= "where ";
            $sql .= " k.nama ilike '%" . $req->get('RegistrasiSearch')['pasien'] . "%' or d.kode ilike '%" . $req->get('RegistrasiSearch')['pasien'] . "%' or k.kode ilike '%" . $req->get('RegistrasiSearch')['pasien'] . "%'";
        }

        $sql .= "GROUP BY d.kode,k.nama";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => $totalCount,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $model = $dataProvider->getModels();

        return $this->render('index-rj', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListRawatJalan()
    {
        $req = Yii::$app->request;
        $searchModel = new RegistrasiSearch();

        $layanan = Layanan::find()->orderBy(['created_at' => SORT_DESC]);
        $queryData = Registrasi::find()
            ->select(['array_agg(layanan.jenis_layanan) as jenis', 'registrasi.kode'])
            ->innerJoin(['layanan' => $layanan], 'layanan.registrasi_kode=registrasi.kode and layanan.deleted_at is null')
            ->where('layanan.unit_tujuan_kode is null');
        if (!empty($req->get('RegistrasiSearch')['tgl_awal'])) {
            $queryData = $queryData->andWhere(['>=', 'registrasi.tgl_masuk', $req->get('RegistrasiSearch')['tgl_awal'] . ' 00:00:00']);
        } else {
            $queryData = $queryData->andWhere(['>=', 'registrasi.tgl_masuk', date('Y-m-d') . ' 00:00:00']);
        }
        if (!empty($req->get('RegistrasiSearch')['tgl_akhir'])) {
            $queryData = $queryData->andWhere(['<=', 'registrasi.tgl_masuk', $req->get('RegistrasiSearch')['tgl_akhir'] . ' 23:59:59']);
        } else {
            $queryData = $queryData->andWhere(['<=', 'registrasi.tgl_masuk', date('Y-m-d') . ' 23:59:59']);
        }

        $queryData = $queryData->andWhere('registrasi.deleted_at is Null')
            ->groupBy('registrasi.kode');

        $queryDataTest = (new \yii\db\Query())
            ->select([
                'registrasi.kode',
                'registrasi.pasien_kode',
                'pasien.nama',
                'registrasi.tgl_masuk',
                'registrasi.tgl_keluar',
                'array_agg(dm_unit_penempatan.nama) as poli',
                'registrasi.is_analisa'

            ])
            ->from('ranap')
            ->withQuery($queryData, 'ranap', true)
            ->innerJoin("pendaftaran.registrasi", "registrasi.kode=ranap.kode and jenis::text not like '%3%'")
            ->innerJoin("pendaftaran.layanan", "layanan.registrasi_kode=ranap.kode and layanan.jenis_layanan in ('2','1')")

            ->innerJoin("pendaftaran.pasien", "registrasi.pasien_kode=pasien.kode")
            ->innerJoin("pegawai.dm_unit_penempatan", "dm_unit_penempatan.kode=layanan.unit_kode");
        if (isset($req->get('RegistrasiSearch')['pasien'])) {
            if (!empty($req->get('RegistrasiSearch')['pasien'])) {
                $queryDataTest = $queryDataTest->andWhere([
                    'or',
                    ['ilike', 'pasien.nama', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'pasien.kode', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'registrasi.kode', $req->get('RegistrasiSearch')['pasien']]
                    // ]
                ]);
            }
        }
        if (isset($req->get('RegistrasiSearch')['is_analisa'])) {
            if ($req->get('RegistrasiSearch')['is_analisa'] == '1' || $req->get('RegistrasiSearch')['is_analisa'] == '0') {
                $queryDataTest = $queryDataTest->andWhere(['registrasi.is_analisa' => $req->get('RegistrasiSearch')['is_analisa']]);
            }
        }
        // ->andWhere(['in','layanan.jenis'])
        $queryDataTest = $queryDataTest->groupBy(['registrasi.kode', 'pasien.nama'])
            ->createCommand()->rawSql;
        $queryDataCount = (new \yii\db\Query())
            ->select([
                'count(distinct registrasi.kode)'

            ])
            ->from('ranap')
            ->withQuery($queryData, 'ranap', true)
            ->innerJoin("pendaftaran.registrasi", "registrasi.kode=ranap.kode and jenis::text not like '%3%'")
            ->innerJoin(['layanan' => $layanan], "layanan.registrasi_kode=ranap.kode and layanan.jenis_layanan in ('2','1')")

            ->innerJoin("pendaftaran.pasien", "registrasi.pasien_kode=pasien.kode")
            ->innerJoin("pegawai.dm_unit_penempatan", "dm_unit_penempatan.kode=layanan.unit_kode");
        if (isset($req->get('RegistrasiSearch')['pasien'])) {

            if (!empty($req->get('RegistrasiSearch')['pasien'])) {
                $queryDataCount = $queryDataCount->andWhere([
                    'or',
                    ['ilike', 'pasien.nama', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'pasien.kode', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'registrasi.kode', $req->get('RegistrasiSearch')['pasien']]
                ]);
            }
        }
        if (isset($req->get('RegistrasiSearch')['is_analisa'])) {
            if ($req->get('RegistrasiSearch')['is_analisa'] == '1' || $req->get('RegistrasiSearch')['is_analisa'] == '0') {
                $queryDataCount = $queryDataCount->andWhere(['registrasi.is_analisa' => $req->get('RegistrasiSearch')['is_analisa']]);
            }
        }

        // ->groupBy(['registrasi.kode', 'pasien.nama'])


        $queryDataCount = $queryDataCount->createCommand()->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $queryDataTest,
            'totalCount' => $queryDataCount,
            'pagination' => [
                'pageSize' => 10,
                'totalCount' => $queryDataCount,
            ],
        ]);
        $model = $dataProvider->getModels();
        return $this->render('index-rj-new', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListRawatJalanVerifikator()
    {
        $req = Yii::$app->request;
        $searchModel = new RegistrasiSearch();

        $layanan = Layanan::find()->orderBy(['created_at' => SORT_DESC]);
        $queryData = Registrasi::find()
            ->select(['array_agg(layanan.jenis_layanan) as jenis', 'registrasi.kode'])
            ->innerJoin(['layanan' => $layanan], 'layanan.registrasi_kode=registrasi.kode and layanan.deleted_at is null')
            ->innerJoin('medis.resume_medis_rj rmrj', 'rmrj.layanan_id=layanan.id')

            ->where('layanan.unit_tujuan_kode is null');
        if (!empty($req->get('RegistrasiSearch')['tgl_awal'])) {
            $queryData = $queryData->andWhere(['>=', 'registrasi.tgl_masuk', $req->get('RegistrasiSearch')['tgl_awal'] . ' 00:00:00']);
        } else {
            $queryData = $queryData->andWhere(['>=', 'registrasi.tgl_masuk', date('Y-m-d') . ' 00:00:00']);
        }
        if (!empty($req->get('RegistrasiSearch')['tgl_akhir'])) {
            $queryData = $queryData->andWhere(['<=', 'registrasi.tgl_masuk', $req->get('RegistrasiSearch')['tgl_akhir'] . ' 23:59:59']);
        } else {
            $queryData = $queryData->andWhere(['<=', 'registrasi.tgl_masuk', date('Y-m-d') . ' 23:59:59']);
        }

        $queryData = $queryData->andWhere('registrasi.deleted_at is Null')
            ->groupBy('registrasi.kode');

        $queryDataTest = (new \yii\db\Query())
            ->select([
                'registrasi.kode',
                'registrasi.pasien_kode',
                'pasien.nama',
                'registrasi.tgl_masuk',
                'registrasi.tgl_keluar',
                'array_agg(dm_unit_penempatan.nama) as poli',
                'registrasi.is_analisa',
                'pg.nama_lengkap as verifikator'

            ])
            ->from('ranap')
            ->withQuery($queryData, 'ranap', true)
            ->innerJoin("pendaftaran.registrasi", "registrasi.kode=ranap.kode and jenis::text not like '%3%'")
            ->innerJoin("pendaftaran.layanan", "layanan.registrasi_kode=ranap.kode and layanan.jenis_layanan in ('2')")

            ->innerJoin("pendaftaran.pasien", "registrasi.pasien_kode=pasien.kode")
            ->innerJoin('medis.resume_medis_rj rmrj', 'rmrj.layanan_id=layanan.id')
            ->leftJoin('pengolahan_data.resume_medis_rj_claim rmrjc', 'rmrjc.layanan_id=layanan.id')
            ->leftJoin('pegawai.tb_pegawai pg', 'pg.pegawai_id=rmrjc.dokter_verifikator_id')

            ->innerJoin("pegawai.dm_unit_penempatan", "dm_unit_penempatan.kode=layanan.unit_kode");
        if (isset($req->get('RegistrasiSearch')['pasien'])) {
            if (!empty($req->get('RegistrasiSearch')['pasien'])) {
                $queryDataTest = $queryDataTest->andWhere([
                    'or',
                    ['ilike', 'pasien.nama', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'pasien.kode', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'registrasi.kode', $req->get('RegistrasiSearch')['pasien']]
                    // ]
                ]);
            }
        }
        if (isset($req->get('RegistrasiSearch')['is_analisa'])) {
            if ($req->get('RegistrasiSearch')['is_analisa'] == '1' || $req->get('RegistrasiSearch')['is_analisa'] == '0') {
                $queryDataTest = $queryDataTest->andWhere(['registrasi.is_analisa' => $req->get('RegistrasiSearch')['is_analisa']]);
            }
        }
        // ->andWhere(['in','layanan.jenis'])
        $queryDataTest = $queryDataTest->groupBy(['registrasi.kode', 'pasien.nama', 'pg.nama_lengkap'])
            ->createCommand()->rawSql;
        // return $queryDataTest;
        $queryDataCount = (new \yii\db\Query())
            ->select([
                'count(distinct registrasi.kode)'

            ])
            ->from('ranap')
            ->withQuery($queryData, 'ranap', true)
            ->innerJoin("pendaftaran.registrasi", "registrasi.kode=ranap.kode and jenis::text not like '%3%'")
            ->innerJoin(['layanan' => $layanan], "layanan.registrasi_kode=ranap.kode and layanan.jenis_layanan in ('2')")

            ->innerJoin("pendaftaran.pasien", "registrasi.pasien_kode=pasien.kode")
            ->innerJoin('medis.resume_medis_rj rmrj', 'rmrj.layanan_id=layanan.id')
            ->leftJoin('pengolahan_data.resume_medis_rj_claim rmrjc', 'rmrjc.layanan_id=layanan.id')
            ->leftJoin('pegawai.tb_pegawai pg', 'pg.pegawai_id=rmrjc.dokter_verifikator_id')

            ->innerJoin("pegawai.dm_unit_penempatan", "dm_unit_penempatan.kode=layanan.unit_kode");
        if (isset($req->get('RegistrasiSearch')['pasien'])) {

            if (!empty($req->get('RegistrasiSearch')['pasien'])) {
                $queryDataCount = $queryDataCount->andWhere([
                    'or',
                    ['ilike', 'pasien.nama', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'pasien.kode', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'registrasi.kode', $req->get('RegistrasiSearch')['pasien']]
                ]);
            }
        }
        if (isset($req->get('RegistrasiSearch')['is_analisa'])) {
            if ($req->get('RegistrasiSearch')['is_analisa'] == '1' || $req->get('RegistrasiSearch')['is_analisa'] == '0') {
                $queryDataCount = $queryDataCount->andWhere(['registrasi.is_analisa' => $req->get('RegistrasiSearch')['is_analisa']]);
            }
        }

        // ->groupBy(['registrasi.kode', 'pasien.nama'])


        $queryDataCount = $queryDataCount->createCommand()->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $queryDataTest,
            'totalCount' => $queryDataCount,
            'pagination' => [
                'pageSize' => 10,
                'totalCount' => $queryDataCount,
            ],
        ]);
        $model = $dataProvider->getModels();
        return $this->render('index-rj-new-verifikator', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionListRawatJalanCoder()
    {
        $req = Yii::$app->request;
        $searchModel = new RegistrasiSearch();

        $layanan = Layanan::find()->select(['registrasi_kode', 'jenis_layanan', 'deleted_at', 'unit_tujuan_kode', 'id', 'unit_kode'])->orderBy(['created_at' => SORT_DESC]);
        $queryData = Registrasi::find()
            ->select(['array_agg(layanan.jenis_layanan) as jenis', 'registrasi.kode'])
            ->innerJoin(['layanan' => $layanan], 'layanan.registrasi_kode=registrasi.kode and layanan.deleted_at is null')
            ->where('layanan.unit_tujuan_kode is null');
        if (!empty($req->get('RegistrasiSearch')['tgl_awal'])) {
            $queryData = $queryData->andWhere(['>=', 'registrasi.tgl_masuk', $req->get('RegistrasiSearch')['tgl_awal'] . ' 00:00:00']);
        } else {
            $queryData = $queryData->andWhere(['>=', 'registrasi.tgl_masuk', date('Y-m-d') . ' 00:00:00']);
        }
        if (!empty($req->get('RegistrasiSearch')['tgl_akhir'])) {
            $queryData = $queryData->andWhere(['<=', 'registrasi.tgl_masuk', $req->get('RegistrasiSearch')['tgl_akhir'] . ' 23:59:59']);
        } else {
            $queryData = $queryData->andWhere(['<=', 'registrasi.tgl_masuk', date('Y-m-d') . ' 23:59:59']);
        }

        $queryData = $queryData->andWhere('registrasi.deleted_at is Null')
            ->groupBy('registrasi.kode');


        $queryDataTest = (new \yii\db\Query())
            ->select([
                'registrasi.kode',
                'registrasi.pasien_kode',
                'pasien.nama',
                'registrasi.tgl_masuk',
                'registrasi.tgl_keluar',
                'array_agg(dm_unit_penempatan.nama) as poli',
                'registrasi.is_claim as claim',
                'registrasi.is_pelaporan as pelaporan',





            ])
            ->from('ranap')
            ->withQuery($queryData, 'ranap', true)
            ->innerJoin("pendaftaran.registrasi", "registrasi.kode=ranap.kode and jenis::text not like '%3%'")
            ->innerJoin("pendaftaran.layanan", "layanan.registrasi_kode=ranap.kode and layanan.jenis_layanan in ('2')")

            ->innerJoin("pendaftaran.pasien", "registrasi.pasien_kode=pasien.kode")
            ->innerJoin('medis.resume_medis_rj rmrj', 'rmrj.layanan_id=layanan.id')



            ->innerJoin("pegawai.dm_unit_penempatan", "dm_unit_penempatan.kode=layanan.unit_kode");
        if (isset($req->get('RegistrasiSearch')['pasien'])) {


            if (!empty($req->get('RegistrasiSearch')['pasien'])) {
                $queryDataTest = $queryDataTest->andWhere([
                    'or',
                    ['ilike', 'pasien.nama', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'pasien.kode', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'registrasi.kode', $req->get('RegistrasiSearch')['pasien']]
                    // ]
                ]);
            }
        }

        // ->andWhere(['in','layanan.jenis'])
        $queryDataTest = $queryDataTest->groupBy(['registrasi.kode', 'pasien.nama'])
            ->createCommand()->rawSql;
        // return $queryDataTest;
        $queryDataCount = (new \yii\db\Query())
            ->select([
                'count(distinct registrasi.kode)'

            ])
            ->from('ranap')
            ->withQuery($queryData, 'ranap', true)
            ->innerJoin("pendaftaran.registrasi", "registrasi.kode=ranap.kode and jenis::text not like '%3%'")
            ->innerJoin(['layanan' => $layanan], "layanan.registrasi_kode=ranap.kode and layanan.jenis_layanan in ('2')")

            ->innerJoin("pendaftaran.pasien", "registrasi.pasien_kode=pasien.kode")

            ->innerJoin('medis.resume_medis_rj rmrj', 'rmrj.layanan_id=layanan.id')


            ->innerJoin("pegawai.dm_unit_penempatan", "dm_unit_penempatan.kode=layanan.unit_kode");
        if (isset($req->get('RegistrasiSearch')['pasien'])) {

            if (!empty($req->get('RegistrasiSearch')['pasien'])) {
                $queryDataCount = $queryDataCount->andWhere([
                    'or',
                    ['ilike', 'pasien.nama', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'pasien.kode', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'registrasi.kode', $req->get('RegistrasiSearch')['pasien']]
                ]);
            }
        }

        // ->groupBy(['registrasi.kode', 'pasien.nama'])


        $queryDataCount = $queryDataCount->createCommand()->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $queryDataTest,
            'totalCount' => $queryDataCount,
            'pagination' => [
                'pageSize' => 30,
                'totalCount' => $queryDataCount,
            ],
        ]);
        $model = $dataProvider->getModels();
        return $this->render('index-rj-new-coder', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListRawatJalanCoderNew()
    {
        return $this->render('list-rawat-jalan-coder-new', []);
    }

    public function actionListLaporanCoderRj()
    {
        return $this->render('list-laporan-coder-rj', []);
    }

    public function actionListRawatInapBackup()
    {
        $req = Yii::$app->request;
        $searchModel = new RegistrasiSearch();

        $queryCount = "with ranap as (
            select   d.kode ,array_agg(r.jenis_layanan) as jenis
            from pendaftaran.registrasi d
            left join (select * from pendaftaran.layanan r order by r.registrasi_kode,r.created_at asc) as r on r.registrasi_kode=d.kode and r.deleted_at is null
            where r.unit_tujuan_kode is null and d.deleted_at is Null ";
        if (!empty($req->get('RegistrasiSearch')['tgl_awal'])) {
            $queryCount .= " and d.tgl_keluar::date >= date '" . $req->get('RegistrasiSearch')['tgl_awal'] . "'";
        } else {
            $queryCount .= " and d.tgl_keluar::date >= date '" . date('Y-m-d') . "'";
        }

        if (!empty($req->get('RegistrasiSearch')['tgl_akhir'])) {
            $queryCount .= " and d.tgl_keluar::date <= date '" . $req->get('RegistrasiSearch')['tgl_akhir'] . "'";
        } else {
            $queryCount .= " and d.tgl_keluar::date <= date '" . date('Y-m-d') . "'";
        }

        $queryCount .= " and d.tgl_keluar is not null 
            GROUP BY d.kode
                )

            select count(distinct d.kode)
            from
            ranap
            inner join pendaftaran.registrasi d on
            d.kode = ranap.kode
            and jenis::text like '%3%'
            and d.tgl_keluar is not null
            inner join (select * from pendaftaran.layanan r order by r.registrasi_kode,r.created_at asc) as r on
            r.registrasi_kode = d.kode
            and r.jenis_layanan in ('1','3')
            and r.deleted_at is null
            inner join pendaftaran.pasien k on k.kode=d.pasien_kode
            inner join pegawai.dm_unit_penempatan u on u.kode=r.unit_kode
            left join pengolahan_data.analisa_dokumen ad on d.kode = ad.reg_kode ";

        if (!empty($req->get('RegistrasiSearch')['pasien'])) {
            $queryCount .= " where k.nama ilike '%" . $req->get('RegistrasiSearch')['pasien'] . "%' or d.kode ilike '%" . $req->get('RegistrasiSearch')['pasien'] . "%' or k.kode ilike '%" . $req->get('RegistrasiSearch')['pasien'] . "%'";
        }
        if (!empty($req->get('RegistrasiSearch')['is_analisa'])) {
            $queryCount .= " and d.is_analisa = '" . $req->get('RegistrasiSearch')['pasien'] . "'";
        }
        $totalCount  = \Yii::$app->db->createCommand($queryCount)->queryScalar();
        $sql  = "with ranap as (
            select   d.kode ,array_agg(r.jenis_layanan) as jenis
            from pendaftaran.registrasi d
            left join (select * from pendaftaran.layanan r order by r.registrasi_kode,r.created_at asc) as r on r.registrasi_kode=d.kode  and r.deleted_at is null
            where r.unit_tujuan_kode is null and d.deleted_at is Null ";
        if (!empty($req->get('RegistrasiSearch')['tgl_awal'])) {
            $sql .= " and d.tgl_keluar::date >= date '" . $req->get('RegistrasiSearch')['tgl_awal'] . "'";
        } else {
            $sql .= " and d.tgl_keluar::date >= date '" . date('Y-m-d') . "'";
        }

        if (!empty($req->get('RegistrasiSearch')['tgl_akhir'])) {
            $sql .= " and d.tgl_keluar::date <= date '" . $req->get('RegistrasiSearch')['tgl_akhir'] . "'";
        } else {
            $sql .= " and d.tgl_keluar::date <= date '" . date('Y-m-d') . "'";
        }
        $sql .= " and d.tgl_keluar is not null
            GROUP BY d.kode
            )
            select d.kode,
            d.pasien_kode,
            k.nama,
            d.tgl_masuk,
            d.tgl_keluar,
            array_agg(r.tgl_masuk) as list_tgl,
            array_agg(u.nama) as poli,
            d.is_analisa
            from
            ranap
            inner join pendaftaran.registrasi d on
            d.kode = ranap.kode
            and jenis::text like '%3%'
            
            inner join (select * from pendaftaran.layanan r order by r.registrasi_kode,r.created_at asc) as r on
            r.registrasi_kode = d.kode
            and r.jenis_layanan in ('1','3')
            
            and r.deleted_at is null
            inner join pendaftaran.pasien k on k.kode=d.pasien_kode
            inner join pegawai.dm_unit_penempatan u on u.kode=r.unit_kode 
            left join pengolahan_data.analisa_dokumen ad on d.kode = ad.reg_kode ";
        if (!empty($req->get('RegistrasiSearch')['pasien'])) {
            $sql .= " where k.nama ilike '%" . $req->get('RegistrasiSearch')['pasien'] . "%' or d.kode ilike '%" . $req->get('RegistrasiSearch')['pasien'] . "%' or k.kode ilike '%" . $req->get('RegistrasiSearch')['pasien'] . "%'";
        }
        if (!empty($req->get('RegistrasiSearch')['is_analisa'])) {
            $sql .= " and d.is_analisa = '" . $req->get('RegistrasiSearch')['pasien'] . "'";
        }
        $sql .= "GROUP BY d.kode,k.nama";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => $totalCount,
            'pagination' => [
                'pageSize' => 10,
                'totalCount' => $totalCount,
            ],
        ]);
        $model = $dataProvider->getModels();

        return $this->render('index-ri', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionListRawatInap()
    {
        $req = Yii::$app->request;
        $searchModel = new RegistrasiSearch();
        $layanan = Layanan::find()->orderBy(['created_at' => SORT_DESC]);
        $queryData = Registrasi::find()
            ->select(['array_agg(layanan.jenis_layanan) as jenis', 'registrasi.kode'])
            ->innerJoin(['layanan' => $layanan], 'layanan.registrasi_kode=registrasi.kode and layanan.deleted_at is null')
            ->where('layanan.unit_tujuan_kode is null');
        if (!empty($req->get('RegistrasiSearch')['tgl_awal'])) {
            $queryData = $queryData->andWhere(['>=', 'registrasi.tgl_keluar', $req->get('RegistrasiSearch')['tgl_awal'] . ' 00:00:00']);
        } else {
            $queryData = $queryData->andWhere(['>=', 'registrasi.tgl_keluar', date('Y-m-d') . ' 00:00:00']);
        }
        if (!empty($req->get('RegistrasiSearch')['tgl_akhir'])) {
            $queryData = $queryData->andWhere(['<=', 'registrasi.tgl_keluar', $req->get('RegistrasiSearch')['tgl_akhir'] . ' 23:59:59']);
        } else {
            $queryData = $queryData->andWhere(['<=', 'registrasi.tgl_keluar', date('Y-m-d') . ' 23:59:59']);
        }

        $queryData = $queryData->andWhere('registrasi.deleted_at is Null')
            ->groupBy('registrasi.kode');

        $queryDataTest = (new \yii\db\Query())
            ->select([
                'registrasi.kode',
                'registrasi.pasien_kode',
                'pasien.nama',
                'registrasi.tgl_masuk',
                'registrasi.tgl_keluar',
                'array_agg(dm_unit_penempatan.nama) as poli',
                'registrasi.is_analisa'

            ])
            ->from('ranap')
            ->withQuery($queryData, 'ranap', true)
            ->innerJoin("pendaftaran.registrasi", "registrasi.kode=ranap.kode and jenis::text like '%3%'")
            ->innerJoin(['layanan' => $layanan], "layanan.registrasi_kode=ranap.kode and layanan.jenis_layanan in ('1','3') and layanan.deleted_by is null")

            ->innerJoin("pendaftaran.pasien", "registrasi.pasien_kode=pasien.kode")
            ->innerJoin("pegawai.dm_unit_penempatan", "dm_unit_penempatan.kode=layanan.unit_kode")
            ->where(['not', ['registrasi.tgl_keluar' => null]]);
        if (isset($req->get('RegistrasiSearch')['pasien'])) {
            if (!empty($req->get('RegistrasiSearch')['pasien'])) {
                $queryDataTest = $queryDataTest->andWhere([
                    'or',
                    ['ilike', 'pasien.nama', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'pasien.kode', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'registrasi.kode', $req->get('RegistrasiSearch')['pasien']]
                    // ]
                ]);
            }
        }
        if (isset($req->get('RegistrasiSearch')['is_analisa'])) {
            if ($req->get('RegistrasiSearch')['is_analisa'] == '1' || $req->get('RegistrasiSearch')['is_analisa'] == '0') {
                $queryDataTest = $queryDataTest->andWhere(['registrasi.is_analisa' => $req->get('RegistrasiSearch')['is_analisa']]);
            }
        }
        // ->andWhere(['in','layanan.jenis'])
        $queryDataTest = $queryDataTest->groupBy(['registrasi.kode', 'pasien.nama'])
            ->createCommand()->rawSql;
        $queryDataCount = (new \yii\db\Query())
            ->select([
                'count(distinct registrasi.kode)'

            ])
            ->from('ranap')
            ->withQuery($queryData, 'ranap', true)
            ->innerJoin("pendaftaran.registrasi", "registrasi.kode=ranap.kode and jenis::text like '%3%'")
            ->innerJoin("pendaftaran.layanan", "layanan.registrasi_kode=ranap.kode and layanan.jenis_layanan in ('1','3') and layanan.deleted_by is null")

            ->innerJoin("pendaftaran.pasien", "registrasi.pasien_kode=pasien.kode")
            ->innerJoin("pegawai.dm_unit_penempatan", "dm_unit_penempatan.kode=layanan.unit_kode")
            ->where(['not', ['registrasi.tgl_keluar' => null]]);
        if (isset($req->get('RegistrasiSearch')['pasien'])) {

            if (!empty($req->get('RegistrasiSearch')['pasien'])) {
                $queryDataCount = $queryDataCount->andWhere([
                    'or',
                    ['ilike', 'pasien.nama', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'pasien.kode', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'registrasi.kode', $req->get('RegistrasiSearch')['pasien']]
                ]);
            }
        }
        if (isset($req->get('RegistrasiSearch')['is_analisa'])) {

            if ($req->get('RegistrasiSearch')['is_analisa'] == '1' || $req->get('RegistrasiSearch')['is_analisa'] == '0') {
                $queryDataCount = $queryDataCount->andWhere(['registrasi.is_analisa' => $req->get('RegistrasiSearch')['is_analisa']]);
            }
        }
        // ->groupBy(['registrasi.kode', 'pasien.nama'])


        $queryDataCount = $queryDataCount->createCommand()->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $queryDataTest,
            'totalCount' => $queryDataCount,
            'pagination' => [
                'pageSize' => 10,
                'totalCount' => $queryDataCount,
            ],
        ]);
        $model = $dataProvider->getModels();

        return $this->render('index-ri-new', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListRawatInapVerifikator()
    {
        $req = Yii::$app->request;
        $searchModel = new RegistrasiSearch();
        $layanan = Layanan::find()->orderBy(['created_at' => SORT_DESC]);
        $queryData = Registrasi::find()
            ->select(['array_agg(layanan.jenis_layanan) as jenis', 'registrasi.kode'])
            ->innerJoin(['layanan' => $layanan], 'layanan.registrasi_kode=registrasi.kode and layanan.deleted_at is null')
            ->innerJoin('medis.resume_medis_ri rmri', 'rmri.layanan_id=layanan.id')
            ->where('layanan.unit_tujuan_kode is null');
        if (!empty($req->get('RegistrasiSearch')['tgl_awal'])) {
            $queryData = $queryData->andWhere(['>=', 'registrasi.tgl_keluar', $req->get('RegistrasiSearch')['tgl_awal'] . ' 00:00:00']);
        } else {
            $queryData = $queryData->andWhere(['>=', 'registrasi.tgl_keluar', date('Y-m-d') . ' 00:00:00']);
        }
        if (!empty($req->get('RegistrasiSearch')['tgl_akhir'])) {
            $queryData = $queryData->andWhere(['<=', 'registrasi.tgl_keluar', $req->get('RegistrasiSearch')['tgl_akhir'] . ' 23:59:59']);
        } else {
            $queryData = $queryData->andWhere(['<=', 'registrasi.tgl_keluar', date('Y-m-d') . ' 23:59:59']);
        }


        $queryData = $queryData->andWhere('registrasi.deleted_at is Null')->groupBy('registrasi.kode');
        // return $queryData->createCommand()->rawSql;

        $queryDataTest = (new \yii\db\Query())
            ->select([
                'registrasi.kode',
                'registrasi.pasien_kode',
                'pasien.nama',
                'registrasi.tgl_masuk',
                'registrasi.tgl_keluar',
                'array_agg(dm_unit_penempatan.nama) as poli',
                'registrasi.is_analisa',
                'pg.nama_lengkap as verifikator'

            ])
            ->from('ranap')
            ->withQuery($queryData, 'ranap', true)
            ->innerJoin("pendaftaran.registrasi", "registrasi.kode=ranap.kode and jenis::text like '%3%'")
            ->innerJoin(['layanan' => $layanan], "layanan.registrasi_kode=ranap.kode and layanan.jenis_layanan in ('1','3') and layanan.deleted_by is null")

            ->innerJoin("pendaftaran.pasien", "registrasi.pasien_kode=pasien.kode")
            ->innerJoin("pegawai.dm_unit_penempatan", "dm_unit_penempatan.kode=layanan.unit_kode")
            ->innerJoin('medis.resume_medis_ri rmri', 'rmri.layanan_id=layanan.id')
            ->leftJoin('pengolahan_data.resume_medis_ri_claim rmrjc', 'rmrjc.layanan_id=layanan.id')
            ->leftJoin('pegawai.tb_pegawai pg', 'pg.pegawai_id=rmrjc.dokter_verifikator_id')

            ->where(['not', ['registrasi.tgl_keluar' => null]]);
        if (isset($req->get('RegistrasiSearch')['pasien'])) {
            if (!empty($req->get('RegistrasiSearch')['pasien'])) {
                $queryDataTest = $queryDataTest->andWhere([
                    'or',
                    ['ilike', 'pasien.nama', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'pasien.kode', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'registrasi.kode', $req->get('RegistrasiSearch')['pasien']]
                    // ]
                ]);
            }
        }
        if (isset($req->get('RegistrasiSearch')['is_analisa'])) {
            if ($req->get('RegistrasiSearch')['is_analisa'] == '1' || $req->get('RegistrasiSearch')['is_analisa'] == '0') {
                $queryDataTest = $queryDataTest->andWhere(['registrasi.is_analisa' => $req->get('RegistrasiSearch')['is_analisa']]);
            }
        }
        // ->andWhere(['in','layanan.jenis'])
        $queryDataTest = $queryDataTest->groupBy(['registrasi.kode', 'pasien.nama', 'pg.nama_lengkap'])
            ->createCommand()->rawSql;
        // return $queryDataTest;
        $queryDataCount = (new \yii\db\Query())
            ->select([
                'count(distinct registrasi.kode)'

            ])
            ->from('ranap')
            ->withQuery($queryData, 'ranap', true)
            ->innerJoin("pendaftaran.registrasi", "registrasi.kode=ranap.kode and jenis::text like '%3%'")
            ->innerJoin("pendaftaran.layanan", "layanan.registrasi_kode=ranap.kode and layanan.jenis_layanan in ('1','3') and layanan.deleted_by is null")

            ->innerJoin("pendaftaran.pasien", "registrasi.pasien_kode=pasien.kode")
            ->innerJoin("pegawai.dm_unit_penempatan", "dm_unit_penempatan.kode=layanan.unit_kode")
            ->innerJoin('medis.resume_medis_ri rmri', 'rmri.layanan_id=layanan.id')
            ->leftJoin('pengolahan_data.resume_medis_ri_claim rmrjc', 'rmrjc.layanan_id=layanan.id')
            ->leftJoin('pegawai.tb_pegawai pg', 'pg.pegawai_id=rmrjc.dokter_verifikator_id')

            ->where(['not', ['registrasi.tgl_keluar' => null]]);
        if (isset($req->get('RegistrasiSearch')['pasien'])) {

            if (!empty($req->get('RegistrasiSearch')['pasien'])) {
                $queryDataCount = $queryDataCount->andWhere([
                    'or',
                    ['ilike', 'pasien.nama', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'pasien.kode', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'registrasi.kode', $req->get('RegistrasiSearch')['pasien']]
                ]);
            }
        }
        if (isset($req->get('RegistrasiSearch')['is_analisa'])) {

            if ($req->get('RegistrasiSearch')['is_analisa'] == '1' || $req->get('RegistrasiSearch')['is_analisa'] == '0') {
                $queryDataCount = $queryDataCount->andWhere(['registrasi.is_analisa' => $req->get('RegistrasiSearch')['is_analisa']]);
            }
        }
        // ->groupBy(['registrasi.kode', 'pasien.nama'])


        $queryDataCount = $queryDataCount->createCommand()->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $queryDataTest,
            'totalCount' => $queryDataCount,
            'pagination' => [
                'pageSize' => 10,
                'totalCount' => $queryDataCount,
            ],
        ]);
        $model = $dataProvider->getModels();

        return $this->render('index-ri-new-verifikator', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionListRawatInapCoder()
    {
        $req = Yii::$app->request;
        $searchModel = new RegistrasiSearch();
        $layanan = Layanan::find()->orderBy(['created_at' => SORT_DESC]);
        $queryData = Registrasi::find()
            ->select(['array_agg(layanan.jenis_layanan) as jenis', 'registrasi.kode'])
            ->innerJoin(['layanan' => $layanan], 'layanan.registrasi_kode=registrasi.kode and layanan.deleted_at is null')
            ->innerJoin('pengolahan_data.resume_medis_ri_claim rmri', 'rmri.layanan_id=layanan.id')
            ->where('layanan.unit_tujuan_kode is null');
        if (!empty($req->get('RegistrasiSearch')['tgl_awal'])) {
            $queryData = $queryData->andWhere(['>=', 'registrasi.tgl_keluar', $req->get('RegistrasiSearch')['tgl_awal'] . ' 00:00:00']);
        } else {
            $queryData = $queryData->andWhere(['>=', 'registrasi.tgl_keluar', date('Y-m-d') . ' 00:00:00']);
        }
        if (!empty($req->get('RegistrasiSearch')['tgl_akhir'])) {
            $queryData = $queryData->andWhere(['<=', 'registrasi.tgl_keluar', $req->get('RegistrasiSearch')['tgl_akhir'] . ' 23:59:59']);
        } else {
            $queryData = $queryData->andWhere(['<=', 'registrasi.tgl_keluar', date('Y-m-d') . ' 23:59:59']);
        }


        $queryData = $queryData->andWhere('registrasi.deleted_at is Null')->groupBy('registrasi.kode');
        // return $queryData->createCommand()->rawSql;

        $queryDataTest = (new \yii\db\Query())
            ->select([
                'registrasi.kode',
                'registrasi.pasien_kode',
                'pasien.nama',
                'registrasi.tgl_masuk',
                'registrasi.tgl_keluar',
                'array_agg(dm_unit_penempatan.nama) as poli',
                'registrasi.is_analisa',
                'pg.nama_lengkap as claim',
                'pgc.nama_lengkap as pelaporan',


            ])
            ->from('ranap')
            ->withQuery($queryData, 'ranap', true)
            ->innerJoin("pendaftaran.registrasi", "registrasi.kode=ranap.kode and jenis::text like '%3%'")
            ->innerJoin(['layanan' => $layanan], "layanan.registrasi_kode=ranap.kode and layanan.jenis_layanan in ('1','3') and layanan.deleted_by is null")

            ->innerJoin("pendaftaran.pasien", "registrasi.pasien_kode=pasien.kode")
            ->innerJoin("pegawai.dm_unit_penempatan", "dm_unit_penempatan.kode=layanan.unit_kode")
            ->innerJoin('pengolahan_data.resume_medis_ri_claim rmri', 'rmri.layanan_id=layanan.id')
            ->leftJoin('pengolahan_data.coding_pelaporan_ri cpr', 'cpr.registrasi_kode=registrasi.kode')
            ->leftJoin('pegawai.tb_pegawai pg', 'pg.pegawai_id=rmri.coder_claim_id')
            ->leftJoin('pegawai.tb_pegawai pgc', 'pgc.pegawai_id=cpr.pegawai_coder_id')

            ->where(['not', ['registrasi.tgl_keluar' => null]]);
        if (isset($req->get('RegistrasiSearch')['pasien'])) {
            if (!empty($req->get('RegistrasiSearch')['pasien'])) {
                $queryDataTest = $queryDataTest->andWhere([
                    'or',
                    ['ilike', 'pasien.nama', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'pasien.kode', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'registrasi.kode', $req->get('RegistrasiSearch')['pasien']]
                    // ]
                ]);
            }
        }
        if (isset($req->get('RegistrasiSearch')['is_analisa'])) {
            if ($req->get('RegistrasiSearch')['is_analisa'] == '1' || $req->get('RegistrasiSearch')['is_analisa'] == '0') {
                $queryDataTest = $queryDataTest->andWhere(['registrasi.is_analisa' => $req->get('RegistrasiSearch')['is_analisa']]);
            }
        }
        // ->andWhere(['in','layanan.jenis'])
        $queryDataTest = $queryDataTest->groupBy(['registrasi.kode', 'pg.nama_lengkap', 'pgc.nama_lengkap', 'pasien.nama'])
            ->createCommand()->rawSql;
        $queryDataCount = (new \yii\db\Query())
            ->select([
                'count(distinct registrasi.kode)'

            ])
            ->from('ranap')
            ->withQuery($queryData, 'ranap', true)
            ->innerJoin("pendaftaran.registrasi", "registrasi.kode=ranap.kode and jenis::text like '%3%'")
            ->innerJoin("pendaftaran.layanan", "layanan.registrasi_kode=ranap.kode and layanan.jenis_layanan in ('1','3') and layanan.deleted_by is null")
            ->innerJoin("pendaftaran.pasien", "registrasi.pasien_kode=pasien.kode")
            ->innerJoin("pegawai.dm_unit_penempatan", "dm_unit_penempatan.kode=layanan.unit_kode")
            ->innerJoin('pengolahan_data.resume_medis_ri_claim rmri', 'rmri.layanan_id=layanan.id')
            ->leftJoin('pengolahan_data.coding_pelaporan_ri cpr', 'cpr.registrasi_kode=registrasi.kode')
            ->leftJoin('pegawai.tb_pegawai pg', 'pg.pegawai_id=rmri.coder_claim_id')
            ->leftJoin('pegawai.tb_pegawai pgc', 'pgc.pegawai_id=cpr.pegawai_coder_id')

            ->where(['not', ['registrasi.tgl_keluar' => null]]);
        if (isset($req->get('RegistrasiSearch')['pasien'])) {

            if (!empty($req->get('RegistrasiSearch')['pasien'])) {
                $queryDataCount = $queryDataCount->andWhere([
                    'or',
                    ['ilike', 'pasien.nama', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'pasien.kode', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'registrasi.kode', $req->get('RegistrasiSearch')['pasien']]
                ]);
            }
        }
        if (isset($req->get('RegistrasiSearch')['is_analisa'])) {

            if ($req->get('RegistrasiSearch')['is_analisa'] == '1' || $req->get('RegistrasiSearch')['is_analisa'] == '0') {
                $queryDataCount = $queryDataCount->andWhere(['registrasi.is_analisa' => $req->get('RegistrasiSearch')['is_analisa']]);
            }
        }
        // ->groupBy(['registrasi.kode', 'pasien.nama'])


        $queryDataCount = $queryDataCount->createCommand()->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $queryDataTest,
            'totalCount' => $queryDataCount,
            'pagination' => [
                'pageSize' => 10,
                'totalCount' => $queryDataCount,
            ],
        ]);
        $model = $dataProvider->getModels();

        return $this->render('index-ri-new-coder', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // public function actionListRawatInapMpp()
    // {


    //     $userLogin=HelperSpesialClass::getUserLogin();
    //     $isMpp = HelperSpesialClass::isMpp();

    //     if(!$userLogin['akses']){
    //         Yii::$app->session->setFlash('warning',$userLogin['pesannoakses']);
    //         return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
    //     }
    //     if(!$isMpp){
    //         Yii::$app->session->setFlash('warning',$userLogin['pesannoakses']);
    //         return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
    //     }
    //     $searchModel = new LayananRiSearch();
    //     $dataProvider = $searchModel->searchLayanan(Yii::$app->request->queryParams,$userLogin);

    //     return $this->render('index-ri-mpp', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    public function actionListRawatInapMpp()
    {


        $userLogin = HelperSpesialClass::getUserLogin();
        $isMpp = HelperSpesialClass::isMpp();

        if (!$userLogin['akses']) {
            Yii::$app->session->setFlash('warning', $userLogin['pesannoakses']);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        if (!$isMpp) {
            Yii::$app->session->setFlash('warning', $userLogin['pesannoakses']);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        // if(in_array($userLogin['username'],['197807022005012006','196910132000032002'])){
        // if(in_array($userLogin['username'],['196910132000032002','197807022005012006','3275033006870018','197101082000121005'])){
        $date = date('Y-m-d');
        // echo'<pre/>';print_r($userLogin);die();
        $pegawai_id = $userLogin['pegawai_id'];
        $mpp = HelperSpesialClass::isMppUnit();
        // $data=\Yii::$app->db->createCommand("
        // 	SELECT 
        // 		l.id as layanan_id,p.nama as nama_pasien,p.kode as rm_pasien,r.kode as nomor_registrasi,up.nama as unit,l.tgl_masuk,l.nomor_urut
        // 	FROM medis.pjp pjp
        // 	INNER JOIN pendaftaran.layanan l ON pjp.layanan_id=l.id
        // 	INNER JOIN pegawai.dm_unit_penempatan up ON l.unit_kode='up.kode'
        // 	INNER JOIN pendaftaran.registrasi r ON l.registrasi_kode=r.kode
        // 	INNER JOIN pendaftaran.pasien p ON r.pasien_kode=p.kode
        // 	WHERE pjp.is_deleted=0 AND l.deleted_by is null AND r.deleted_by is null
        //     AND l.unit_kode in ('$mpp')
        // 	ORDER BY l.tgl_masuk DESC, l.nomor_urut ASC
        // ")->queryAll();

        $dataMpp = Layanan::find()
            ->alias('l')
            ->select('l.id as layanan_id,p.nama as nama_pasien,p.kode as rm_pasien,r.kode as nomor_registrasi,up.nama as unit,l.tgl_masuk,l.tgl_keluar,l.nomor_urut,(select count(*) from pengolahan_data.catatan_mpp mp where mp.layanan_id=l.id) as mpp_jumlah,(select count(*) from medis.resume_medis_ri rm where rm.layanan_id=l.id) as resume_jumlah')
            ->innerJoin('pendaftaran.registrasi r', 'r.kode=l.registrasi_kode')
            ->innerJoin('pendaftaran.pasien p', 'p.kode=r.pasien_kode')
            ->innerJoin('pegawai.dm_unit_penempatan up', 'l.unit_kode=up.kode')
            ->where(['in', 'l.unit_kode', HelperSpesialClass::isMppUnit()])
            // ->andWhere(['r.tgl_keluar' => null])
            ->orderBy(['r.tgl_masuk' => SORT_DESC])
            ->asArray()->all();

        // echo'<pre/>';print_r($pegawai_id);die();
        // AND l.tgl_masuk between '$date' AND '$date' 
        // echo'<pre/>';print_r($data);die();
        return $this->render('index-ri-new-mpp', [
            'data' => $dataMpp
        ]);
        // }else 
        // 	if($userLogin['akses_level']==HelperSpesialClass::LEVEL_DOKTER){
        // 	$searchModel = new LayananRj2Search();
        // 	// $searchModel = new LayananRjSearch();
        // 	$dataProvider = $searchModel->search(Yii::$app->request->queryParams,$userLogin);
        // 	return $this->render('index2', [
        // 		'searchModel' => $searchModel,
        // 		'dataProvider' => $dataProvider,
        // 	]);
        // }else{
        // 	$searchModel = new LayananRjSearch();
        // 	$dataProvider = $searchModel->search(Yii::$app->request->queryParams,$userLogin);
        // 	return $this->render('index-mpp', [
        // 		'searchModel' => $searchModel,
        // 		'dataProvider' => $dataProvider,
        // 	]);
        // }
        $searchModel = new LayananRjSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $userLogin);

        return $this->render('index-mpp', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionRiwatatRegistrasiPasien($id = null)
    {
        $registrasi = HelperSpesialClass::getCheckPasien($id);
        $layananId = array();
        $layananOperasi = array();
        $timOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }


        $analisaDokumen = AnalisaDokumen::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();
        if ($analisaDokumen) {
            $analisaDokumen = AnalisaDokumen::find()->joinWith('analisaDokumenDetail')->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                AnalisaDokumenDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                AnalisaDokumenDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
            ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumen();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->joinWith(['jenisAnalisa', 'itemAnalisa'])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();

        foreach ($listTimOperasi as $value) {
            $timOperasi = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($id);
        $listLabor = HelperSpesialClass::getListLabor($id);
        $listRadiologi = HelperSpesialClass::getListRadiologi($id);

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($id);
        if (!$docClinicList->con) {
            \Yii::$app->session->setFlash('warning', $docClinicList->msg);
        }
        if (!$listLabor->con) {
            \Yii::$app->session->setFlash('warning', $listLabor->msg);
        }
        if (!$listRadiologi->con) {
            \Yii::$app->session->setFlash('warning', $listRadiologi->msg);
        }
        if (!$listPatologiAnatomi->con) {
            \Yii::$app->session->setFlash('warning', $listPatologiAnatomi->msg);
        }

        return $this->render(
            'index',
            [
                'registrasi' => $registrasi->data,
                'model' => $analisaDokumen,
                'docClinicalList' => $docClinicList,
                'listAnalisa' => $listAnalisa,
                'listLabor' => $listLabor,
                'listRadiologi' => $listRadiologi,
                'listPatologiAnatomi' => $listPatologiAnatomi,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,

            ]
        );
    }
    public function actionListTes()
    {
        $listPatologiAnatomi = HasilPemeriksaan::find()->alias('hp')->select([
            'hp.id',
            'hp.tarif_tindakan_pasien_id',
            'upa.nama as unitAsal',
            'lpo.tgl_pemeriksaan',
            't.deskripsi',
            'hp.is_save',
            "coalesce(concat(dok.gelar_sarjana_depan, ' ') , '') || coalesce(dok.nama_lengkap, '') || coalesce(concat(' ', dok.gelar_sarjana_belakang), '') as dokterNama",
            "coalesce(concat(dok2.gelar_sarjana_depan, ' ') , '') || coalesce(dok2.nama_lengkap, '') || coalesce(concat(' ', dok2.gelar_sarjana_belakang), '') as dokterPAnama"
        ])
            ->leftJoin('pendaftaran.layanan lp', 'lp.id=hp.layanan_id_penunjang')
            ->leftJoin('pendaftaran.registrasi r', 'r.kode=lp.registrasi_kode')
            ->leftJoin('medis.lab_pa_order lpo', 'lpo.layanan_id_penunjang=hp.layanan_id_penunjang')
            ->leftJoin('pegawai.tb_pegawai dok', 'dok.pegawai_id=lpo.dokter_id')
            ->leftJoin('pegawai.tb_pegawai dok2', 'dok.pegawai_id=hp.dokter_pemeriksa')
            ->leftJoin('pegawai.dm_unit_penempatan upa', 'upa.kode=lp.unit_asal_kode')
            ->leftJoin('medis.tarif_tindakan tt', 'tt.id=hp.tarif_tindakan_pasien_id')
            ->leftJoin('medis.tindakan t', 't.id=tt.tindakan_id')
            ->where(['r.kode' => '2209003219'])
            ->asArray()->all();
        return json_encode($listPatologiAnatomi);
    }

    public function actionListCoding()
    {
        $searchModel = new RegistrasiSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('list-coding', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionLaporanIndex()
    {
        $model = new AnalisaDokumen();
        $modelAnalisaDokumen = new AnalisaDokumen();
        $modelAnalisaDokumen->jenis_laporan = AnalisaDokumen::JENIS_HARIAN;
        $modelAnalisaDokumen->tgl_hari = date('d-m-Y');
        $modelAnalisaDokumen->tipe_laporan = AnalisaDokumen::TIPE_SELURUH;

        return $this->render('laporan-index', [
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
            'model' => $model,
            'modelAnalisaDokumen' => $modelAnalisaDokumen,

        ]);
    }

    public function actionLaporanCoderIndex()
    {
        $model = new LaporanCoder();
        $modelLaporanCoder = new LaporanCoder();
        $modelLaporanCoder->jenis_laporan = LaporanCoder::JENIS_HARIAN;
        $modelLaporanCoder->tgl_hari = date('d-m-Y');
        $modelLaporanCoder->tipe_laporan = LaporanCoder::TIPE_SELURUH;

        return $this->render('laporan-coder-index', [
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
            'model' => $model,
            'modelLaporanCoder' => $modelLaporanCoder,

        ]);
    }

    public function actionLaporanAnalisaIndex()
    {
        $model = new AnalisaDokumen();
        $modelAnalisaDokumen = new AnalisaDokumen();
        $modelAnalisaDokumen->jenis_laporan = AnalisaDokumen::JENIS_HARIAN;
        $modelAnalisaDokumen->tgl_hari = date('d-m-Y');
        $modelAnalisaDokumen->tipe_laporan = AnalisaDokumen::TIPE_SELURUH;

        return $this->render('laporan-analisa-index', [
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
            'model' => $model,
            'modelAnalisaDokumen' => $modelAnalisaDokumen,

        ]);
    }



    public function actionLaporanAnalisa()
    {
        $searchModel = new AnalisaDokumenDetailSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $sql = "select count(pengolahan_data.analisa_dokumen_detail.analisa_dokumen_id),
        mja.jenis_analisa_uraian,mia.item_analisa_uraian,mia.item_analisa_tipe,pengolahan_data.analisa_dokumen_detail.analisa_dokumen_jenis_analisa_detail_id,pengolahan_data.analisa_dokumen_detail.analisa_dokumen_item_id,pengolahan_data.analisa_dokumen_detail.analisa_dokumen_jenis_id,
        COUNT(pengolahan_data.analisa_dokumen_detail.analisa_dokumen_kelengkapan) filter (where pengolahan_data.analisa_dokumen_detail.analisa_dokumen_kelengkapan = '0') as tidak_ada,
        COUNT(pengolahan_data.analisa_dokumen_detail.analisa_dokumen_kelengkapan) filter (where pengolahan_data.analisa_dokumen_detail.analisa_dokumen_kelengkapan = '1') as tidak_lengkap,
        COUNT(pengolahan_data.analisa_dokumen_detail.analisa_dokumen_kelengkapan) filter (where pengolahan_data.analisa_dokumen_detail.analisa_dokumen_kelengkapan = '2') as lengkap,
        COUNT(pengolahan_data.analisa_dokumen_detail.analisa_dokumen_kelengkapan) filter (where pengolahan_data.analisa_dokumen_detail.analisa_dokumen_kelengkapan = '3') as ada 
        from pengolahan_data.analisa_dokumen_detail
        left join pengolahan_data.master_item_analisa mia on mia.item_analisa_id =pengolahan_data.analisa_dokumen_detail.analisa_dokumen_item_id
        left join pengolahan_data.master_jenis_analisa mja on mja.jenis_analisa_id =pengolahan_data.analisa_dokumen_detail.analisa_dokumen_jenis_id ";
        if (!empty($this->request->queryParams['RegistrasiSearch']['tgl_awal']) && empty($this->request->queryParams['RegistrasiSearch']['tgl_akhir'])) {
            $sql .= "where pengolahan_data.analisa_dokumen_detail.created_at::date >=date '" . $this->request->queryParams['RegistrasiSearch']['tgl_awal'] . "'";
        } elseif (empty($this->request->queryParams['RegistrasiSearch']['tgl_awal']) && !empty($this->request->queryParams['RegistrasiSearch']['tgl_akhir'])) {
            $sql .= "where pengolahan_data.analisa_dokumen_detail.created_at::date <=date '" . $this->request->queryParams['RegistrasiSearch']['tgl_akhir'] . "'";
        } elseif (!empty($this->request->queryParams['RegistrasiSearch']['tgl_awal']) && !empty($this->request->queryParams['RegistrasiSearch']['tgl_akhir'])) {
            $sql .= "where pengolahan_data.analisa_dokumen_detail.created_at::date >=date '" . $this->request->queryParams['RegistrasiSearch']['tgl_awal'] . "'";
            $sql .= "and pengolahan_data.analisa_dokumen_detail.created_at::date <=date '" . $this->request->queryParams['RegistrasiSearch']['tgl_akhir'] . "'";
        }

        $sql .= " group by pengolahan_data.analisa_dokumen_detail.analisa_dokumen_item_id,pengolahan_data.analisa_dokumen_detail.analisa_dokumen_jenis_id,mia.item_analisa_id,pengolahan_data.analisa_dokumen_detail.analisa_dokumen_jenis_analisa_detail_id,mja.jenis_analisa_uraian order by pengolahan_data.analisa_dokumen_detail.analisa_dokumen_jenis_id ASC, pengolahan_data.analisa_dokumen_detail.analisa_dokumen_item_id ASC 
        ";

        $sqlQuery = "select count(distinct(pengolahan_data.analisa_dokumen_detail.analisa_dokumen_id))
        from pengolahan_data.analisa_dokumen_detail
        left join pengolahan_data.master_item_analisa mia on mia.item_analisa_id =pengolahan_data.analisa_dokumen_detail.analisa_dokumen_item_id
        left join pengolahan_data.master_jenis_analisa mja on mja.jenis_analisa_id =pengolahan_data.analisa_dokumen_detail.analisa_dokumen_jenis_id ";
        if (!empty($this->request->queryParams['RegistrasiSearch']['tgl_awal']) && empty($this->request->queryParams['RegistrasiSearch']['tgl_akhir'])) {
            $sqlQuery .= "where pengolahan_data.analisa_dokumen_detail.created_at::date >=date '" . $this->request->queryParams['RegistrasiSearch']['tgl_awal'] . "'";
        } elseif (empty($this->request->queryParams['RegistrasiSearch']['tgl_awal']) && !empty($this->request->queryParams['RegistrasiSearch']['tgl_akhir'])) {
            $sqlQuery .= "where pengolahan_data.analisa_dokumen_detail.created_at::date <=date '" . $this->request->queryParams['RegistrasiSearch']['tgl_akhir'] . "'";
        } elseif (!empty($this->request->queryParams['RegistrasiSearch']['tgl_awal']) && !empty($this->request->queryParams['RegistrasiSearch']['tgl_akhir'])) {
            $sqlQuery .= "where pengolahan_data.analisa_dokumen_detail.created_at::date >=date '" . $this->request->queryParams['RegistrasiSearch']['tgl_awal'] . "'";
            $sqlQuery .= "and pengolahan_data.analisa_dokumen_detail.created_at::date <=date '" . $this->request->queryParams['RegistrasiSearch']['tgl_akhir'] . "'";
        }

        $data = Yii::$app->db->createCommand($sql)->queryAll();
        $dataQuery = Yii::$app->db->createCommand($sqlQuery)->queryAll();
        // return json_encode($this->request->queryParams);
        return $this->render('laporan-analisa', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'data' => $data,
            'dataQuery' => $dataQuery
        ]);
    }


    public function actionPreviewDocClinical($id)
    {
        $mdcp = DocClinicalPasien::find()->where(['id_doc_clinical_pasien' => $id])->asArray()->one();
        if ($mdcp) {
            $mdcp['data'] = base64_decode($mdcp['data']);
            return MakeResponse::create(true, 'Data Tersedia', $mdcp);
        }
        return MakeResponse::create(false, 'Data Tidak Ditemukan');
    }

    public function actionPreviewListLabor($id)
    {
        $hasil = array();
        $data = LISORDER::find()->select([
            'ID', 'PID', 'APID', 'ONO', 'PNAME', 'SOURCE', 'CLINICIAN', "CAST(Convert(CHAR(8),REQUEST_DT,112) as DATETIME) AS REQUEST_DT"
        ])->where([
            'ID' => $id
        ])->orderBy(['REQUEST_DT' => SORT_DESC])->asArray()->one();


        $cari = ResultHead::find()->select([
            'pname', 'source_nm', 'clinician_nm', 'data_api', 'request_dt'
        ])
            ->where(['ono' => $data['ONO']])
            ->asArray()->limit(1)->one();

        if (!empty($cari)) {
            $pdf = json_decode($cari['data_api'], true);
            if (!empty($pdf)) {
                $hasil = [
                    'id' => $data['ID'],
                    'no_rm' => $data['PID'],
                    'nama' => $cari['pname'],
                    'unit_asal' => $cari['source_nm'],
                    'dokter_asal' => $cari['clinician_nm'],
                    'tgl' => $cari['request_dt'],
                    'jenis' => 'result_head',
                    'pdf' => base64_decode($pdf['pdf'])
                ];
            } else {
                $pdfLis = $this->DataApiNoLab($data['ONO']);
                if (!empty($pdfLis)) {
                    if ($pdfLis['pdf'] != 'Ono Not Found') {
                        $hasil = [
                            'id' => $data['ID'],
                            'no_rm' => $data['PID'],
                            'nama' => $data['PNAME'],
                            'unit_asal' => explode('^', $data['SOURCE']),
                            'dokter_asal' => explode('^', $data['CLINICIAN']),
                            'tgl' => $data['REQUEST_DT'],
                            'jenis' => 'lis',
                            'pdf' => base64_decode($pdfLis['pdf'])
                        ];
                    }
                } else {
                    $hasil = [
                        'id' => $data['ID'],
                        'no_rm' => $data['PID'],
                        'nama' => $data['PNAME'],
                        'unit_asal' => explode('^', $data['SOURCE']),
                        'dokter_asal' => explode('^', $data['CLINICIAN']),
                        'tgl' => $data['REQUEST_DT'],
                        'jenis' => null,
                        'pdf' => null
                    ];
                }
            }
        } else {
            $pdfLis = $this->DataApiNoLab($data['ONO']);
            if (!empty($pdfLis)) {
                if ($pdfLis['pdf'] != 'Ono Not Found') {
                    $hasil = [
                        'id' => $data['ID'],
                        'no_rm' => $data['PID'],
                        'nama' => $data['PNAME'],
                        'unit_asal' => explode('^', $data['SOURCE']),
                        'dokter_asal' => explode('^', $data['CLINICIAN']),
                        'tgl' => $data['REQUEST_DT'],
                        'jenis' => 'lis',
                        'pdf' => base64_decode($pdfLis['pdf'])
                    ];
                }
            } else {
                $hasil = [
                    'id' => $data['ID'],
                    'no_rm' => $data['PID'],
                    'nama' => $data['PNAME'],
                    'unit_asal' => explode('^', $data['SOURCE']),
                    'dokter_asal' => explode('^', $data['CLINICIAN']),
                    'tgl' => $data['REQUEST_DT'],
                    'jenis' => null,
                    'pdf' => null
                ];
            }
        }
        // }

        if ($hasil != null) {
            // $mdcp['data'] = base64_decode($data->pdf);
            return MakeResponse::create(true, 'Data Tersedia',  $hasil);
        }
        return MakeResponse::create(false, 'Data Tidak Ditemukan / Hasil Pemeriksaan Belum Masuk');
    }

    public function actionSave()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $id = $req->post('analisa_dokumen_id');


            if ($id != NULL) {
                $model = AnalisaDokumen::find()->where(['ps_kode' => $req->post('AnalisaDokumen')['ps_kode'], 'reg_kode' => $req->post('AnalisaDokumen')['reg_kode']])->limit(1)->one();
            } else {
                $model = new AnalisaDokumen();
            }
            $model->load($req->post());

            if ($model->validate()) {
                // return json_encode($model->saveData());
                if ($model->saveData()) {
                    $result = ['status' => true, 'msg' => 'Data Analisa Dokumen Berhasil Disimpan'];
                } else {
                    $result = ['status' => false, 'msg' => 'Data Analisa Dokumen Gagal Disimpan'];
                }
            } else {
                $result = ['status' => false, 'msg' => $model->errors];
            }

            return $this->asJson($result);
        }
    }
    public function actionSaveCatatanMpp()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $id = $req->post('layanan_id');
            $mppId = $req->post('pegawai_mpp_id');

            if ($id != NULL) {
                $model = CatatanMpp::find()->where(['layanan_id' => $id, 'pegawai_mpp_id' => $mppId])->limit(1)->one();
            } else {
                $model = new CatatanMpp();
            }
            $model->load($req->post());

            if ($model->validate()) {
                // return json_encode($model->saveDataMpp());
                if ($model->saveDataMpp()) {
                    $result = ['status' => true, 'msg' => 'Data Analisa Dokumen Berhasil Disimpan'];
                } else {
                    $result = ['status' => false, 'msg' => 'Data Analisa Dokumen Gagal Disimpan'];
                }
            } else {
                $result = ['status' => false, 'msg' => $model->errors];
            }

            return $this->asJson($result);
        }
    }

    public function actionSaveCoder()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $id = $req->post('layanan_id');
            $mppId = $req->post('pegawai_mpp_id');

            if ($id != NULL) {
                $model = CatatanMpp::find()->where(['layanan_id' => $id, 'pegawai_mpp_id' => $mppId])->limit(1)->one();
            } else {
                $model = new CatatanMpp();
            }
            $model->load($req->post());

            if ($model->validate()) {
                // return json_encode($model->saveDataMpp());
                if ($model->saveDataMpp()) {
                    $result = ['status' => true, 'msg' => 'Data Analisa Dokumen Berhasil Disimpan'];
                } else {
                    $result = ['status' => false, 'msg' => 'Data Analisa Dokumen Gagal Disimpan'];
                }
            } else {
                $result = ['status' => false, 'msg' => $model->errors];
            }


            return $this->asJson($result);
        }
    }
    public function actionCoderSave()
    {
        // $model=$this->initModelCreate($id);
        $model = new CodingPelaporan();
        $modelDetails = [new CodingPelaporanDiagnosaDetail()];
        if ($model->load(Yii::$app->request->post())) {
            $modelDetails    = Model::createMultiple(CodingPelaporanDiagnosaDetail::className());
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
                        // Yii::$app->session->setFlash('success', 'Resep Obat No : '.$model->no_transaksi.' Berhasil Ditambahkan!');
                        // if(\Yii::$app->request->isAjax){
                        //     return Yii::$app->response->redirect(['resep/index']);false;
                        // }else{
                        //     return $this->redirect(['resep/index']);false;
                        // }
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    $result = ['status' => false, 'msg' => $e->getMessage];
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
    public function actionCodingPelaporanIcd10Save()
    {
        // $model=$this->initModelCreate($id);
        $modelData = CodingPelaporanRi::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanRi')['registrasi_kode']])->one();
        if ($modelData) {
            $model = CodingPelaporanRi::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanRi')['registrasi_kode']])->one();
            $modelDetails = $model->pelaporanDiagnosa;

            if ($model->load(Yii::$app->request->post())) {
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
                        if ($flag = $model->save(false)) {
                            // delete dahulu semua record yang ada
                            if (!empty($deletedIDs)) {
                                CodingPelaporanDiagnosaDetailRi::deleteAll(['id' => $deletedIDs]);
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

            $modelDetails = [new CodingPelaporanDiagnosaDetailRi()];
            if ($model->load(Yii::$app->request->post())) {
                $modelDetails    = Model::createMultiple(CodingPelaporanDiagnosaDetailRi::className());
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
                            $transaction->commit();
                            $result = ['status' => true, 'msg' => 'Data Berhasil Disimpan'];
                            return $this->asJson($result);
                            // Yii::$app->session->setFlash('success', 'Resep Obat No : '.$model->no_transaksi.' Berhasil Ditambahkan!');
                            // if(\Yii::$app->request->isAjax){
                            //     return Yii::$app->response->redirect(['resep/index']);false;
                            // }else{
                            //     return $this->redirect(['resep/index']);false;
                            // }
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

    public function actionCodingPelaporanRjIcd10Save()
    {
        // $model=$this->initModelCreate($id);

        $modelData = CodingPelaporanRj::find()->where(['id_resume_medis_rj' => Yii::$app->request->post('CodingPelaporanRj')['id_resume_medis_rj']])->one();


        if ($modelData) {
            $model = CodingPelaporanRj::find()->where(['id_resume_medis_rj' => Yii::$app->request->post('CodingPelaporanRj')['id_resume_medis_rj']])->one();
            $modelClaim = CodingClaimRj::find()->where(['id_resume_medis_rj' => Yii::$app->request->post('CodingPelaporanRj')['id_resume_medis_rj']])->one();

            $modelDetails = $model->pelaporanDiagnosa;


            if ($model->load(Yii::$app->request->post())) {

                $modelDataClaim = CodingClaimRj::find()->where(['registrasi_kode' => $model['registrasi_kode']])->one();
                if ($modelDataClaim) {
                    if ($modelDataClaim->diagnosa_simpan == 1) {
                        $result = ['status' => false, 'msg' => 'Anda tidak bisa ubah coding pelaporan karena sudah coding claim'];
                        return $this->asJson($result);
                    }
                }
                $oldIDs  = ArrayHelper::map($modelDetails, 'id', 'id');
                $modelDetails    = Model::createMultiple(CodingPelaporanDiagnosaDetailRj::className());
                Model::loadMultiple($modelDetails, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelDetails, 'id', 'id')));
                foreach ($modelDetails as $detail) {
                    $detail->coding_pelaporan_id = $model->id;
                }
                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        CodingClaimDiagnosaDetailRj::deleteAll(['coding_pelaporan_id' => $modelDataClaim->id]);

                        if ($flag = $model->save(false)) {
                            // delete dahulu semua record yang ada
                            if (!empty($deletedIDs)) {
                                CodingPelaporanDiagnosaDetailRj::deleteAll(['id' => $deletedIDs]);
                            }
                            foreach ($modelDetails as $key => $modelDetail) {

                                $modelDetailsClaim = new CodingClaimDiagnosaDetailRj();

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
                                $modelDetailsClaim->coding_pelaporan_id = $modelClaim->id;
                                $modelDetailsClaim->icd10_id = $modelDetail->icd10_id;
                                $modelDetailsClaim->utama = $modelDetail->utama;




                                if (!($flag = $modelDetail->save(false) && $modelDetailsClaim->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            $modelResumeMedisRjClaim = ResumeMedisRjClaim::find()->where(['id_resume_medis_rj' => Yii::$app->request->post('CodingPelaporanRj')['id_resume_medis_rj']])->one();
                            if (empty($modelResumeMedisRjClaim)) {
                                $modelResumeMedisRjClaim = new ResumeMedisRjClaim();
                            } else {
                                $modelResumeMedisRjClaim = ResumeMedisRjClaim::find()->where(['id_resume_medis_rj' => Yii::$app->request->post('CodingPelaporanRj')['id_resume_medis_rj']])->one();
                            }
                            $modelResumeMedisRJ = ResumeMedisRj::find()->where(['id' => Yii::$app->request->post('CodingPelaporanRj')['id_resume_medis_rj']])->one();

                            $modelResumeMedisRjClaim->id_resume_medis_rj = $modelResumeMedisRJ->id;
                            $modelResumeMedisRjClaim->dokter_verifikator_id = HelperSpesialClass::getUserLogin()['pegawai_id'];
                            $modelResumeMedisRjClaim->layanan_id = $modelResumeMedisRJ->layanan_id;
                            $modelResumeMedisRjClaim->registrasi_kode = Yii::$app->request->post('CodingPelaporanRj')['registrasi_kode'];

                            //Set Is Pelaporan tabel registrasi =1
                            $registrasiModel = Registrasi::find()->where(['kode' => Yii::$app->request->post('CodingPelaporanRj')['registrasi_kode']])->one();
                            $registrasiModel->is_pelaporan = 1;
                            $registrasiModel->save(false);

                            $modelResumeMedisRjClaim->dokter_id = $modelResumeMedisRJ->dokter_id;
                            $modelResumeMedisRjClaim->anamesis = $modelResumeMedisRJ->anamesis;
                            $modelResumeMedisRjClaim->pemeriksaan_fisik = $modelResumeMedisRJ->pemeriksaan_fisik;
                            $modelResumeMedisRjClaim->diagnosa = $modelResumeMedisRJ->diagnosa;
                            $CodingPelaporanDiagnosaDetailRj = Yii::$app->request->post('CodingPelaporanDiagnosaDetailRj');

                            usort($CodingPelaporanDiagnosaDetailRj, function ($a, $b) {
                                return $b['utama'] - $a['utama'];
                            });


                            $modelResumeMedisRjClaim->diagnosa_utama_id = $CodingPelaporanDiagnosaDetailRj[0]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->diagnosa_tambahan1_id = $CodingPelaporanDiagnosaDetailRj[1]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->diagnosa_tambahan2_id = $CodingPelaporanDiagnosaDetailRj[2]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->diagnosa_tambahan3_id = $CodingPelaporanDiagnosaDetailRj[3]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->diagnosa_tambahan4_id = $CodingPelaporanDiagnosaDetailRj[4]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->diagnosa_tambahan5_id = $CodingPelaporanDiagnosaDetailRj[5]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->diagnosa_tambahan6_id = $CodingPelaporanDiagnosaDetailRj[6]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->tindakan = $modelResumeMedisRJ->tindakan;

                            $modelResumeMedisRjClaim->terapi = $modelResumeMedisRJ->terapi;
                            $modelResumeMedisRjClaim->rencana = $modelResumeMedisRJ->rencana;
                            $modelResumeMedisRjClaim->alasan_kontrol = $modelResumeMedisRJ->alasan_kontrol;
                            $modelResumeMedisRjClaim->alasan = $modelResumeMedisRJ->alasan;
                            $modelResumeMedisRjClaim->lab = $modelResumeMedisRJ->lab;
                            $modelResumeMedisRjClaim->rad = $modelResumeMedisRJ->rad;
                            $modelResumeMedisRjClaim->poli_tujuan_kontrol_id = $modelResumeMedisRJ->poli_tujuan_kontrol_id;
                            $modelResumeMedisRjClaim->poli_tujuan_kontrol_nama = $modelResumeMedisRJ->poli_tujuan_kontrol_nama;
                            $modelResumeMedisRjClaim->tgl_kontrol = $modelResumeMedisRJ->tgl_kontrol;
                            $modelResumeMedisRjClaim->keterangan = $modelResumeMedisRJ->keterangan;
                            $modelResumeMedisRjClaim->kasus = Yii::$app->request->post('CodingPelaporanRj')['kasus'];
                            if ($flags = $modelResumeMedisRjClaim->save(false)) {
                                if (!($flags = $modelResumeMedisRjClaim->save(false))) {
                                    $transaction->rollBack();
                                }
                            }
                            if ($flags) {
                                $transaction->commit();
                                $result = ['status' => true, 'msg' => 'Data Berhasil Disimpan'];
                                return $this->asJson($result);
                            }
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
            $model = new CodingPelaporanRj();
            $modelClaim = new CodingClaimRj();


            $modelDetails = [new CodingPelaporanDiagnosaDetailRj()];


            if ($model->load(Yii::$app->request->post())) {
                $modelDataClaim = CodingClaimRj::find()->where(['registrasi_kode' => $model->registrasi_kode])->one();
                if ($modelDataClaim) {
                    if ($modelDataClaim->diagnosa_simpan == 1) {
                        $result = ['status' => false, 'msg' => 'Anda tidak bisa ubah coding pelaporan karena sudah coding claim'];
                        return $this->asJson($result);
                    }
                }
                $modelDetails    = Model::createMultiple(CodingPelaporanDiagnosaDetailRj::className());

                Model::loadMultiple($modelDetails, Yii::$app->request->post());

                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        $modelClaim->attributes = $model->attributes;
                        $modelDetailsClaim = CodingClaimDiagnosaDetailRj::loadMultiple($modelDetails, Yii::$app->request->post());

                        if ($flag = $model->save(false) && $modelClaim->save(false)) {
                            foreach ($modelDetails as $key => $modelDetail) {
                                $modelDetailsClaim = new CodingClaimDiagnosaDetailRj();

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
                                $modelDetailsClaim->coding_pelaporan_id = $modelClaim->id;
                                $modelDetailsClaim->icd10_id = $modelDetail->icd10_id;
                                $modelDetailsClaim->utama = $modelDetail->utama;




                                if (!($flag = $modelDetail->save(false) && $modelDetailsClaim->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            $modelResumeMedisRjClaim = ResumeMedisRjClaim::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanRj')['registrasi_kode']])->one();
                            if (empty($modelResumeMedisRjClaim)) {
                                $modelResumeMedisRjClaim = new ResumeMedisRjClaim();
                            } else {
                                $modelResumeMedisRjClaim = ResumeMedisRjClaim::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanRj')['registrasi_kode']])->one();
                            }
                            $modelResumeMedisRJ = ResumeMedisRj::find()->where(['id' => Yii::$app->request->post('CodingPelaporanRj')['id_resume_medis_rj']])->one();

                            $modelResumeMedisRjClaim->id_resume_medis_rj = $modelResumeMedisRJ->id;
                            $modelResumeMedisRjClaim->dokter_verifikator_id = HelperSpesialClass::getUserLogin()['pegawai_id'];
                            $modelResumeMedisRjClaim->layanan_id = $modelResumeMedisRJ->layanan_id;
                            $modelResumeMedisRjClaim->registrasi_kode = Yii::$app->request->post('CodingPelaporanRj')['registrasi_kode'];
                            //Set Is Pelaporan tabel registrasi =1
                            $registrasiModel = Registrasi::find()->where(['kode' => Yii::$app->request->post('CodingPelaporanRj')['registrasi_kode']])->one();
                            $registrasiModel->is_pelaporan = 1;
                            $registrasiModel->save(false);
                            $modelResumeMedisRjClaim->dokter_id = $modelResumeMedisRJ->dokter_id;
                            $modelResumeMedisRjClaim->anamesis = $modelResumeMedisRJ->anamesis;
                            $modelResumeMedisRjClaim->pemeriksaan_fisik = $modelResumeMedisRJ->pemeriksaan_fisik;
                            $modelResumeMedisRjClaim->diagnosa = $modelResumeMedisRJ->diagnosa;
                            $CodingPelaporanDiagnosaDetailRj = Yii::$app->request->post('CodingPelaporanDiagnosaDetailRj');

                            usort($CodingPelaporanDiagnosaDetailRj, function ($a, $b) {
                                return $b['utama'] - $a['utama'];
                            });


                            $modelResumeMedisRjClaim->diagnosa_utama_id = $CodingPelaporanDiagnosaDetailRj[0]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->diagnosa_tambahan1_id = $CodingPelaporanDiagnosaDetailRj[1]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->diagnosa_tambahan2_id = $CodingPelaporanDiagnosaDetailRj[2]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->diagnosa_tambahan3_id = $CodingPelaporanDiagnosaDetailRj[3]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->diagnosa_tambahan4_id = $CodingPelaporanDiagnosaDetailRj[4]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->diagnosa_tambahan5_id = $CodingPelaporanDiagnosaDetailRj[5]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->diagnosa_tambahan6_id = $CodingPelaporanDiagnosaDetailRj[6]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->tindakan = $modelResumeMedisRJ->tindakan;

                            $modelResumeMedisRjClaim->terapi = $modelResumeMedisRJ->terapi;
                            $modelResumeMedisRjClaim->rencana = $modelResumeMedisRJ->rencana;
                            $modelResumeMedisRjClaim->alasan_kontrol = $modelResumeMedisRJ->alasan_kontrol;
                            $modelResumeMedisRjClaim->alasan = $modelResumeMedisRJ->alasan;
                            $modelResumeMedisRjClaim->lab = $modelResumeMedisRJ->lab;
                            $modelResumeMedisRjClaim->rad = $modelResumeMedisRJ->rad;
                            $modelResumeMedisRjClaim->poli_tujuan_kontrol_id = $modelResumeMedisRJ->poli_tujuan_kontrol_id;
                            $modelResumeMedisRjClaim->poli_tujuan_kontrol_nama = $modelResumeMedisRJ->poli_tujuan_kontrol_nama;
                            $modelResumeMedisRjClaim->tgl_kontrol = $modelResumeMedisRJ->tgl_kontrol;
                            $modelResumeMedisRjClaim->keterangan = $modelResumeMedisRJ->keterangan;
                            $modelResumeMedisRjClaim->kasus = Yii::$app->request->post('CodingPelaporanRj')['kasus'];
                            if ($flags = $modelResumeMedisRjClaim->save(false)) {
                                if (!($flags = $modelResumeMedisRjClaim->save(false))) {
                                    $transaction->rollBack();
                                }
                            }
                            if ($flags) {
                                $transaction->commit();
                                $result = ['status' => true, 'msg' => 'Data Berhasil Disimpan'];
                                return $this->asJson($result);
                            }
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

    public function actionCodingClaimRjIcd10Save()
    {
        // $model=$this->initModelCreate($id);
        $modelData = CodingClaimRj::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaimRj')['registrasi_kode']])->one();
        if ($modelData) {
            $model = CodingClaimRj::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaimRj')['registrasi_kode']])->one();
            $modelDetails = $model->pelaporanDiagnosa;

            if ($model->load(Yii::$app->request->post())) {
                $oldIDs  = ArrayHelper::map($modelDetails, 'id', 'id');
                $modelDetails    = Model::createMultiple(CodingClaimDiagnosaDetailRj::className());
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
                                CodingClaimDiagnosaDetailRj::deleteAll(['id' => $deletedIDs]);
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
                        $modelResumeMedisRjClaim = ResumeMedisRjClaim::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaimRj')['registrasi_kode']])->one();
                        if (empty($modelResumeMedisRjClaim)) {
                            $modelResumeMedisRjClaim = new ResumeMedisRjClaim();
                        } else {
                            $modelResumeMedisRjClaim = ResumeMedisRjClaim::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaimRj')['registrasi_kode']])->one();
                        }
                        $modelResumeMedisRJ = ResumeMedisRj::find()->where(['id' => Yii::$app->request->post('CodingClaimRj')['id_resume_medis_rj']])->one();

                        $modelResumeMedisRjClaim->id_resume_medis_rj = $modelResumeMedisRJ->id;
                        $modelResumeMedisRjClaim->dokter_verifikator_id = HelperSpesialClass::getUserLogin()['pegawai_id'];
                        $modelResumeMedisRjClaim->layanan_id = $modelResumeMedisRJ->layanan_id;
                        $modelResumeMedisRjClaim->registrasi_kode = Yii::$app->request->post('CodingClaimRj')['registrasi_kode'];
                        //Set Is claim  tabel registrasi =1
                        $registrasiModel = Registrasi::find()->where(['kode' =>  Yii::$app->request->post('CodingClaimRj')['registrasi_kode']])->one();
                        $registrasiModel->is_claim = 1;
                        $registrasiModel->save(false);
                        $modelResumeMedisRjClaim->dokter_id = $modelResumeMedisRJ->dokter_id;
                        $modelResumeMedisRjClaim->anamesis = $modelResumeMedisRJ->anamesis;
                        $modelResumeMedisRjClaim->pemeriksaan_fisik = $modelResumeMedisRJ->pemeriksaan_fisik;
                        $modelResumeMedisRjClaim->diagnosa = $modelResumeMedisRJ->diagnosa;
                        $CodingPelaporanDiagnosaDetailRj = Yii::$app->request->post('CodingClaimDiagnosaDetailRj');

                        usort($CodingPelaporanDiagnosaDetailRj, function ($a, $b) {
                            return $b['utama'] - $a['utama'];
                        });

                        $modelResumeMedisRjClaim->diagnosa_utama_id = $CodingPelaporanDiagnosaDetailRj[0]['icd10_id'] ?? null;
                        $modelResumeMedisRjClaim->diagnosa_tambahan1_id = $CodingPelaporanDiagnosaDetailRj[1]['icd10_id'] ?? null;
                        $modelResumeMedisRjClaim->diagnosa_tambahan2_id = $CodingPelaporanDiagnosaDetailRj[2]['icd10_id'] ?? null;
                        $modelResumeMedisRjClaim->diagnosa_tambahan3_id = $CodingPelaporanDiagnosaDetailRj[3]['icd10_id'] ?? null;
                        $modelResumeMedisRjClaim->diagnosa_tambahan4_id = $CodingPelaporanDiagnosaDetailRj[4]['icd10_id'] ?? null;
                        $modelResumeMedisRjClaim->diagnosa_tambahan5_id = $CodingPelaporanDiagnosaDetailRj[5]['icd10_id'] ?? null;
                        $modelResumeMedisRjClaim->diagnosa_tambahan6_id = $CodingPelaporanDiagnosaDetailRj[6]['icd10_id'] ?? null;
                        $modelResumeMedisRjClaim->tindakan = $modelResumeMedisRJ->tindakan;

                        $modelResumeMedisRjClaim->terapi = $modelResumeMedisRJ->terapi;
                        $modelResumeMedisRjClaim->rencana = $modelResumeMedisRJ->rencana;
                        $modelResumeMedisRjClaim->alasan_kontrol = $modelResumeMedisRJ->alasan_kontrol;
                        $modelResumeMedisRjClaim->alasan = $modelResumeMedisRJ->alasan;
                        $modelResumeMedisRjClaim->lab = $modelResumeMedisRJ->lab;
                        $modelResumeMedisRjClaim->rad = $modelResumeMedisRJ->rad;
                        $modelResumeMedisRjClaim->poli_tujuan_kontrol_id = $modelResumeMedisRJ->poli_tujuan_kontrol_id;
                        $modelResumeMedisRjClaim->poli_tujuan_kontrol_nama = $modelResumeMedisRJ->poli_tujuan_kontrol_nama;
                        $modelResumeMedisRjClaim->tgl_kontrol = $modelResumeMedisRJ->tgl_kontrol;
                        $modelResumeMedisRjClaim->keterangan = $modelResumeMedisRJ->keterangan;
                        $modelResumeMedisRjClaim->kasus = Yii::$app->request->post('CodingClaimRj')['kasus'];

                        if ($flags = $modelResumeMedisRjClaim->save(false)) {
                            if (!($flags = $modelResumeMedisRjClaim->save(false))) {
                                $transaction->rollBack();
                            }
                        }
                        if ($flags) {
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
            $model = new CodingClaimRj();
            $modelClaim = new CodingClaimRj();

            $modelDetails = [new CodingClaimDiagnosaDetailRj()];
            if ($model->load(Yii::$app->request->post())) {
                $modelDetails    = Model::createMultiple(CodingClaimDiagnosaDetailRj::className());
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
                        $modelResumeMedisRjClaim = ResumeMedisRjClaim::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaimRj')['registrasi_kode']])->one();
                        if (empty($modelResumeMedisRjClaim)) {
                            $modelResumeMedisRjClaim = new ResumeMedisRjClaim();
                        } else {
                            $modelResumeMedisRjClaim = ResumeMedisRjClaim::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaimRj')['registrasi_kode']])->one();
                        }
                        $modelResumeMedisRJ = ResumeMedisRj::find()->where(['id' => Yii::$app->request->post('CodingClaimRj')['id_resume_medis_rj']])->one();

                        $modelResumeMedisRjClaim->id_resume_medis_rj = $modelResumeMedisRJ->id;
                        $modelResumeMedisRjClaim->dokter_verifikator_id = HelperSpesialClass::getUserLogin()['pegawai_id'];
                        $modelResumeMedisRjClaim->layanan_id = $modelResumeMedisRJ->layanan_id;
                        $modelResumeMedisRjClaim->registrasi_kode = Yii::$app->request->post('CodingClaimRj')['registrasi_kode'];
                        //Set Is claim tabel registrasi =1
                        $registrasiModel = Registrasi::find()->where(['kode' =>  Yii::$app->request->post('CodingClaimRj')['registrasi_kode']])->one();
                        $registrasiModel->is_claim = 1;
                        $registrasiModel->save(false);
                        $modelResumeMedisRjClaim->dokter_id = $modelResumeMedisRJ->dokter_id;
                        $modelResumeMedisRjClaim->anamesis = $modelResumeMedisRJ->anamesis;
                        $modelResumeMedisRjClaim->pemeriksaan_fisik = $modelResumeMedisRJ->pemeriksaan_fisik;
                        $modelResumeMedisRjClaim->diagnosa = $modelResumeMedisRJ->diagnosa;
                        $CodingPelaporanDiagnosaDetailRj = Yii::$app->request->post('CodingClaimDiagnosaDetailRj');

                        usort($CodingPelaporanDiagnosaDetailRj, function ($a, $b) {
                            return $b['utama'] - $a['utama'];
                        });


                        $modelResumeMedisRjClaim->diagnosa_utama_id = $CodingPelaporanDiagnosaDetailRj[0]['icd10_id'] ?? null;
                        $modelResumeMedisRjClaim->diagnosa_tambahan1_id = $CodingPelaporanDiagnosaDetailRj[1]['icd10_id'] ?? null;
                        $modelResumeMedisRjClaim->diagnosa_tambahan2_id = $CodingPelaporanDiagnosaDetailRj[2]['icd10_id'] ?? null;
                        $modelResumeMedisRjClaim->diagnosa_tambahan3_id = $CodingPelaporanDiagnosaDetailRj[3]['icd10_id'] ?? null;
                        $modelResumeMedisRjClaim->diagnosa_tambahan4_id = $CodingPelaporanDiagnosaDetailRj[4]['icd10_id'] ?? null;
                        $modelResumeMedisRjClaim->diagnosa_tambahan5_id = $CodingPelaporanDiagnosaDetailRj[5]['icd10_id'] ?? null;
                        $modelResumeMedisRjClaim->diagnosa_tambahan6_id = $CodingPelaporanDiagnosaDetailRj[6]['icd10_id'] ?? null;
                        $modelResumeMedisRjClaim->tindakan = $modelResumeMedisRJ->tindakan;

                        $modelResumeMedisRjClaim->terapi = $modelResumeMedisRJ->terapi;
                        $modelResumeMedisRjClaim->rencana = $modelResumeMedisRJ->rencana;
                        $modelResumeMedisRjClaim->alasan_kontrol = $modelResumeMedisRJ->alasan_kontrol;
                        $modelResumeMedisRjClaim->alasan = $modelResumeMedisRJ->alasan;
                        $modelResumeMedisRjClaim->lab = $modelResumeMedisRJ->lab;
                        $modelResumeMedisRjClaim->rad = $modelResumeMedisRJ->rad;
                        $modelResumeMedisRjClaim->poli_tujuan_kontrol_id = $modelResumeMedisRJ->poli_tujuan_kontrol_id;
                        $modelResumeMedisRjClaim->poli_tujuan_kontrol_nama = $modelResumeMedisRJ->poli_tujuan_kontrol_nama;
                        $modelResumeMedisRjClaim->tgl_kontrol = $modelResumeMedisRJ->tgl_kontrol;
                        $modelResumeMedisRjClaim->keterangan = $modelResumeMedisRJ->keterangan;
                        $modelResumeMedisRjClaim->kasus = Yii::$app->request->post('CodingClaimRj')['kasus'];
                        if ($flags = $modelResumeMedisRjClaim->save(false)) {
                            if (!($flags = $modelResumeMedisRjClaim->save(false))) {
                                $transaction->rollBack();
                            }
                        }
                        if ($flags) {
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




    public function actionClaimIcd10Save()
    {
        // $model=$this->initModelCreate($id);
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
                        if ($flag = $model->save(false)) {
                            // delete dahulu semua record yang ada
                            if (!empty($deletedIDs)) {
                                CodingClaimDiagnosaDetail::deleteAll(['id' => $deletedIDs]);
                            }
                            foreach ($modelDetails as $key => $modelDetails) {
                                if ($key == 0) {
                                    $modelDetails->utama = 1;
                                } else {
                                    $modelDetails->utama = 0;
                                }
                                $icd10 = Icd10cmv2::find()->where(['id' => $modelDetails->icd10_id])->one();
                                if ($icd10) {
                                    $modelDetails->icd10_kode = $icd10->kode;
                                    $modelDetails->icd10_deskripsi = $icd10->deskripsi;
                                }
                                $modelDetails->coding_claim_id = $model->id;
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
                                if ($key == 0) {
                                    $modelDetails->utama = 1;
                                } else {
                                    $modelDetails->utama = 0;
                                }
                                $icd10 = Icd10cmv2::find()->where(['id' => $modelDetails->icd10_id])->one();
                                if ($icd10) {
                                    $modelDetails->icd10_kode = $icd10->kode;
                                    $modelDetails->icd10_deskripsi = $icd10->deskripsi;
                                }
                                $modelDetails->coding_claim_id = $model->id;
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

    public function actionPelaporanIcd9Save()
    {
        // $model=$this->initModelCreate($id);
        $modelData = CodingPelaporan::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporan')['registrasi_kode']])->one();
        if ($modelData) {
            $model = CodingPelaporan::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporan')['registrasi_kode']])->one();
            $modelDetails = $model->pelaporanTindakan;

            if ($model->load(Yii::$app->request->post())) {
                $oldIDs  = ArrayHelper::map($modelDetails, 'id', 'id');
                $modelDetails    = Model::createMultiple(CodingPelaporanTindakanDetail::className());
                Model::loadMultiple($modelDetails, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelDetails, 'id', 'id')));
                foreach ($modelDetails as $detail) {
                    $detail->coding_pelaporan_id = $model->id;
                }
                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            // delete dahulu semua record yang ada
                            if (!empty($deletedIDs)) {
                                CodingPelaporanTindakanDetail::deleteAll(['id' => $deletedIDs]);
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
            $model = new CodingPelaporan();
            $modelDetails = [new CodingPelaporanTindakanDetail()];
            if ($model->load(Yii::$app->request->post())) {
                $modelDetails    = Model::createMultiple(CodingPelaporanTindakanDetail::className());
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
                            // Yii::$app->session->setFlash('success', 'Resep Obat No : '.$model->no_transaksi.' Berhasil Ditambahkan!');
                            // if(\Yii::$app->request->isAjax){
                            //     return Yii::$app->response->redirect(['resep/index']);false;
                            // }else{
                            //     return $this->redirect(['resep/index']);false;
                            // }
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
    public function actionCodingPelaporanIcd9Save()
    {
        // $model=$this->initModelCreate($id);
        $modelData = CodingPelaporanRi::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanRi')['registrasi_kode']])->one();
        if ($modelData) {
            $model = CodingPelaporanRi::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanRi')['registrasi_kode']])->one();
            $modelDetails = $model->pelaporanTindakan;

            if ($model->load(Yii::$app->request->post())) {
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
                        if ($flag = $model->save(false)) {
                            // delete dahulu semua record yang ada
                            if (!empty($deletedIDs)) {
                                CodingPelaporanTindakanDetailRi::deleteAll(['id' => $deletedIDs]);
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
            $model = new CodingPelaporanRi();
            $modelDetails = [new CodingPelaporanTindakanDetailRi()];
            if ($model->load(Yii::$app->request->post())) {
                $modelDetails    = Model::createMultiple(CodingPelaporanTindakanDetailRi::className());
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
                            // Yii::$app->session->setFlash('success', 'Resep Obat No : '.$model->no_transaksi.' Berhasil Ditambahkan!');
                            // if(\Yii::$app->request->isAjax){
                            //     return Yii::$app->response->redirect(['resep/index']);false;
                            // }else{
                            //     return $this->redirect(['resep/index']);false;
                            // }
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

    public function actionCodingPelaporanRjIcd9Save()
    {
        // $model=$this->initModelCreate($id);
        $modelData = CodingPelaporanRj::find()->where(['id_resume_medis_rj' => Yii::$app->request->post('CodingPelaporanRj')['id_resume_medis_rj']])->one();
        if ($modelData) {
            $model = CodingPelaporanRj::find()->where(['id_resume_medis_rj' => Yii::$app->request->post('CodingPelaporanRj')['id_resume_medis_rj']])->one();
            $modelClaim = CodingClaimRj::find()->where(['id_resume_medis_rj' => Yii::$app->request->post('CodingPelaporanRj')['id_resume_medis_rj']])->one();

            $modelDetails = $model->pelaporanTindakan;


            if ($model->load(Yii::$app->request->post())) {
                $modelDataClaim = CodingClaimRj::find()->where(['id_resume_medis_rj' => $model->id_resume_medis_rj])->one();
                if ($modelDataClaim->tindakan_simpan == 1) {
                    $result = ['status' => false, 'msg' => 'Anda tidak bisa ubah coding pelaporan karena sudah coding claim'];
                    return $this->asJson($result);
                }
                $oldIDs  = ArrayHelper::map($modelDetails, 'id', 'id');
                $modelDetails    = Model::createMultiple(CodingPelaporanTindakanDetailRj::className());
                Model::loadMultiple($modelDetails, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelDetails, 'id', 'id')));
                foreach ($modelDetails as $detail) {
                    $detail->coding_pelaporan_id = $model->id;
                }
                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        CodingClaimTindakanDetailRj::deleteAll(['coding_pelaporan_id' => $modelDataClaim->id]);

                        if ($flag = $model->save(false)) {
                            // delete dahulu semua record yang ada
                            if (!empty($deletedIDs)) {
                                CodingPelaporanTindakanDetailRj::deleteAll(['id' => $deletedIDs]);
                            }
                            foreach ($modelDetails as $key => $modelDetail) {
                                $modelDetailsClaim = new CodingClaimTindakanDetailRj();

                                $icd9 = Icd9cmv3::find()->where(['id' => $modelDetail->icd9_id])->one();
                                if ($icd9) {
                                    $modelDetail->icd9_kode = $icd9->kode;
                                    $modelDetailsClaim->icd9_kode = $icd9->kode;

                                    $modelDetail->icd9_deskripsi = $icd9->deskripsi;
                                    $modelDetailsClaim->icd9_deskripsi = $icd9->deskripsi;
                                }
                                //membuat urutan paling atas menjadi utama
                                if ($key == 0) {
                                    $modelDetail->utama = 1;
                                } else {
                                    $modelDetail->utama = 0;
                                }
                                $modelDetail->coding_pelaporan_id = $model->id;
                                $modelDetailsClaim->coding_pelaporan_id = $modelClaim->id;
                                $modelDetailsClaim->icd9_id = $modelDetail->icd9_id;
                                $modelDetailsClaim->utama = $modelDetail->utama;
                                if (!($flag = $modelDetail->save(false) && $modelDetailsClaim->save(false))) {
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
            $model = new CodingPelaporanRj();
            $modelClaim = new CodingClaimRj();


            $modelDetails = [new CodingPelaporanTindakanDetailRj()];
            $modelDetailsClaim = new CodingClaimTindakanDetailRj();

            if ($model->load(Yii::$app->request->post())) {
                $modelDetails    = Model::createMultiple(CodingPelaporanTindakanDetailRj::className());
                Model::loadMultiple($modelDetails, Yii::$app->request->post());
                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        $modelClaim->attributes = $model->attributes;

                        if ($flag = $model->save(false) && $modelClaim->save(false)) {
                            foreach ($modelDetails as $key => $modelDetail) {

                                $modelDetailsClaim = new CodingClaimTindakanDetailRj();

                                $icd9 = Icd9cmv3::find()->where(['id' => $modelDetail->icd9_id])->one();
                                if ($icd9) {
                                    $modelDetail->icd9_kode = $icd9->kode;
                                    $modelDetailsClaim->icd9_kode = $icd9->kode;

                                    $modelDetail->icd9_deskripsi = $icd9->deskripsi;
                                    $modelDetailsClaim->icd9_deskripsi = $icd9->deskripsi;
                                }
                                //membuat urutan paling atas menjadi utama
                                if ($key == 0) {
                                    $modelDetail->utama = 1;
                                } else {
                                    $modelDetail->utama = 0;
                                }
                                $modelDetail->coding_pelaporan_id = $model->id;
                                $modelDetailsClaim->coding_pelaporan_id = $modelClaim->id;
                                $modelDetailsClaim->icd9_id = $modelDetail->icd9_id;
                                $modelDetailsClaim->utama = $modelDetail->utama;
                                if (!($flag = $modelDetail->save(false) && $modelDetailsClaim->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            $modelResumeMedisRjClaim = ResumeMedisRjClaim::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanRj')['registrasi_kode']])->one();
                            if (empty($modelResumeMedisRjClaim)) {
                                $modelResumeMedisRjClaim = new ResumeMedisRjClaim();
                            } else {
                                $modelResumeMedisRjClaim = ResumeMedisRjClaim::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanRj')['registrasi_kode']])->one();
                            }
                            $modelResumeMedisRJ = ResumeMedisRj::find()->where(['id' => Yii::$app->request->post('CodingPelaporanRj')['id_resume_medis_rj']])->one();

                            $modelResumeMedisRjClaim->id_resume_medis_rj = $modelResumeMedisRJ->id;
                            $modelResumeMedisRjClaim->dokter_verifikator_id = HelperSpesialClass::getUserLogin()['pegawai_id'];
                            $modelResumeMedisRjClaim->layanan_id = $modelResumeMedisRJ->layanan_id;
                            $modelResumeMedisRjClaim->registrasi_kode = Yii::$app->request->post('CodingPelaporanRj')['registrasi_kode'];

                            $modelResumeMedisRjClaim->dokter_id = $modelResumeMedisRJ->dokter_id;
                            $modelResumeMedisRjClaim->anamesis = $modelResumeMedisRJ->anamesis;
                            $modelResumeMedisRjClaim->pemeriksaan_fisik = $modelResumeMedisRJ->pemeriksaan_fisik;
                            $modelResumeMedisRjClaim->diagnosa = $modelResumeMedisRJ->diagnosa;
                            $CodingPelaporanTindakanDetailRj = Yii::$app->request->post('CodingPelaporanTindakanDetailRj');

                            usort($CodingPelaporanTindakanDetailRj, function ($a, $b) {
                                return $b['utama'] - $a['utama'];
                            });



                            $modelResumeMedisRjClaim->tindakan = $modelResumeMedisRJ->tindakan;
                            $modelResumeMedisRjClaim->tindakan_utama_id = $CodingPelaporanTindakanDetailRj[0]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->tindakan_tambahan1_id = $CodingPelaporanTindakanDetailRj[0]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->tindakan_tambahan2_id = $CodingPelaporanTindakanDetailRj[0]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->tindakan_tambahan3_id = $CodingPelaporanTindakanDetailRj[0]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->tindakan_tambahan4_id = $CodingPelaporanTindakanDetailRj[0]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->tindakan_tambahan5_id = $CodingPelaporanTindakanDetailRj[0]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->tindakan_tambahan6_id = $CodingPelaporanTindakanDetailRj[0]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->terapi = $modelResumeMedisRJ->terapi;
                            $modelResumeMedisRjClaim->rencana = $modelResumeMedisRJ->rencana;
                            $modelResumeMedisRjClaim->alasan_kontrol = $modelResumeMedisRJ->alasan_kontrol;
                            $modelResumeMedisRjClaim->alasan = $modelResumeMedisRJ->alasan;
                            $modelResumeMedisRjClaim->lab = $modelResumeMedisRJ->lab;
                            $modelResumeMedisRjClaim->rad = $modelResumeMedisRJ->rad;
                            $modelResumeMedisRjClaim->poli_tujuan_kontrol_id = $modelResumeMedisRJ->poli_tujuan_kontrol_id;
                            $modelResumeMedisRjClaim->poli_tujuan_kontrol_nama = $modelResumeMedisRJ->poli_tujuan_kontrol_nama;
                            $modelResumeMedisRjClaim->tgl_kontrol = $modelResumeMedisRJ->tgl_kontrol;
                            $modelResumeMedisRjClaim->keterangan = $modelResumeMedisRJ->keterangan;
                            if ($flags = $modelResumeMedisRjClaim->save(false)) {
                                if (!($flags = $modelResumeMedisRjClaim->save(false))) {
                                    $transaction->rollBack();
                                }
                            }
                            if ($flags) {
                                $transaction->commit();
                                $result = ['status' => true, 'msg' => 'Data Berhasil Disimpan'];
                                return $this->asJson($result);
                            }
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


    public function actionCodingClaimRjIcd9Save()
    {
        // $model=$this->initModelCreate($id);
        $modelData = CodingClaimRj::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaimRj')['registrasi_kode']])->one();
        if ($modelData) {
            $model = CodingClaimRj::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaimRj')['registrasi_kode']])->one();
            $modelDetails = $model->pelaporanTindakan;

            if ($model->load(Yii::$app->request->post())) {

                $oldIDs  = ArrayHelper::map($modelDetails, 'id', 'id');
                $modelDetails    = Model::createMultiple(CodingClaimTindakanDetailRj::className());
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
                                CodingClaimTindakanDetailRj::deleteAll(['id' => $deletedIDs]);
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
                            $modelResumeMedisRjClaim = ResumeMedisRjClaim::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaimRj')['registrasi_kode']])->andWhere(['id_resume_medis_rj' => Yii::$app->request->post('CodingClaimRj')['id_resume_medis_rj']])->one();
                            if (empty($modelResumeMedisRjClaim)) {
                                $modelResumeMedisRjClaim = new ResumeMedisRjClaim();
                            } else {
                                $modelResumeMedisRjClaim = ResumeMedisRjClaim::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaimRj')['registrasi_kode']])->andWhere(['id_resume_medis_rj' => Yii::$app->request->post('CodingClaimRj')['id_resume_medis_rj']])->one();
                            }
                            $modelResumeMedisRJ = ResumeMedisRj::find()->where(['id' => Yii::$app->request->post('CodingClaimRj')['id_resume_medis_rj']])->one();

                            $modelResumeMedisRjClaim->id_resume_medis_rj = $modelResumeMedisRJ->id;
                            $modelResumeMedisRjClaim->dokter_verifikator_id = HelperSpesialClass::getUserLogin()['pegawai_id'];
                            $modelResumeMedisRjClaim->layanan_id = $modelResumeMedisRJ->layanan_id;
                            $modelResumeMedisRjClaim->registrasi_kode = Yii::$app->request->post('CodingClaimRj')['registrasi_kode'];

                            $modelResumeMedisRjClaim->dokter_id = $modelResumeMedisRJ->dokter_id;
                            $modelResumeMedisRjClaim->anamesis = $modelResumeMedisRJ->anamesis;
                            $modelResumeMedisRjClaim->pemeriksaan_fisik = $modelResumeMedisRJ->pemeriksaan_fisik;
                            $modelResumeMedisRjClaim->diagnosa = $modelResumeMedisRJ->diagnosa;
                            $CodingPelaporanTindakanDetailRj = Yii::$app->request->post('CodingClaimTindakanDetailRj');

                            usort($CodingPelaporanTindakanDetailRj, function ($a, $b) {
                                return $b['utama'] - $a['utama'];
                            });



                            $modelResumeMedisRjClaim->tindakan = $modelResumeMedisRJ->tindakan;
                            $modelResumeMedisRjClaim->tindakan_utama_id = $CodingPelaporanTindakanDetailRj[0]['icd9_id'] ?? null;
                            $modelResumeMedisRjClaim->tindakan_tambahan1_id = $CodingPelaporanTindakanDetailRj[1]['icd9_id'] ?? null;
                            $modelResumeMedisRjClaim->tindakan_tambahan2_id = $CodingPelaporanTindakanDetailRj[2]['icd9_id'] ?? null;
                            $modelResumeMedisRjClaim->tindakan_tambahan3_id = $CodingPelaporanTindakanDetailRj[3]['icd9_id'] ?? null;
                            $modelResumeMedisRjClaim->tindakan_tambahan4_id = $CodingPelaporanTindakanDetailRj[4]['icd9_id'] ?? null;
                            $modelResumeMedisRjClaim->tindakan_tambahan5_id = $CodingPelaporanTindakanDetailRj[5]['icd9_id'] ?? null;
                            $modelResumeMedisRjClaim->tindakan_tambahan6_id = $CodingPelaporanTindakanDetailRj[6]['icd9_id'] ?? null;
                            $modelResumeMedisRjClaim->terapi = $modelResumeMedisRJ->terapi;
                            $modelResumeMedisRjClaim->rencana = $modelResumeMedisRJ->rencana;
                            $modelResumeMedisRjClaim->alasan_kontrol = $modelResumeMedisRJ->alasan_kontrol;
                            $modelResumeMedisRjClaim->alasan = $modelResumeMedisRJ->alasan;
                            $modelResumeMedisRjClaim->lab = $modelResumeMedisRJ->lab;
                            $modelResumeMedisRjClaim->rad = $modelResumeMedisRJ->rad;
                            $modelResumeMedisRjClaim->poli_tujuan_kontrol_id = $modelResumeMedisRJ->poli_tujuan_kontrol_id;
                            $modelResumeMedisRjClaim->poli_tujuan_kontrol_nama = $modelResumeMedisRJ->poli_tujuan_kontrol_nama;
                            $modelResumeMedisRjClaim->tgl_kontrol = $modelResumeMedisRJ->tgl_kontrol;
                            $modelResumeMedisRjClaim->keterangan = $modelResumeMedisRJ->keterangan;
                            if ($flags = $modelResumeMedisRjClaim->save(false)) {
                                if (!($flags = $modelResumeMedisRjClaim->save(false))) {
                                    $transaction->rollBack();
                                }
                            }
                            if ($flags) {
                                $transaction->commit();
                                $result = ['status' => true, 'msg' => 'Data Berhasil Disimpan'];
                                return $this->asJson($result);
                            }
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
            $model = new CodingClaimRj();


            $modelDetails = [new CodingClaimTindakanDetailRj()];

            if ($model->load(Yii::$app->request->post())) {

                $modelDetails    = Model::createMultiple(CodingClaimTindakanDetailRj::className());
                Model::loadMultiple($modelDetails, Yii::$app->request->post());
                if ($model->validate() && Model::validateMultiple($modelDetails)) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        $modelClaim->attributes = $model->attributes;

                        if ($flag = $model->save(false) && $modelClaim->save(false)) {
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
                            $modelResumeMedisRjClaim = ResumeMedisRjClaim::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanRj')['registrasi_kode']])->one();
                            if (empty($modelResumeMedisRjClaim)) {
                                $modelResumeMedisRjClaim = new ResumeMedisRjClaim();
                            } else {
                                $modelResumeMedisRjClaim = ResumeMedisRjClaim::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingPelaporanRj')['registrasi_kode']])->one();
                            }
                            $modelResumeMedisRJ = ResumeMedisRj::find()->where(['id' => Yii::$app->request->post('CodingPelaporanRj')['id_resume_medis_rj']])->one();

                            $modelResumeMedisRjClaim->id_resume_medis_rj = $modelResumeMedisRJ->id;
                            $modelResumeMedisRjClaim->dokter_verifikator_id = HelperSpesialClass::getUserLogin()['pegawai_id'];
                            $modelResumeMedisRjClaim->layanan_id = $modelResumeMedisRJ->layanan_id;
                            $modelResumeMedisRjClaim->registrasi_kode = Yii::$app->request->post('CodingClaimRj')['registrasi_kode'];

                            $modelResumeMedisRjClaim->dokter_id = $modelResumeMedisRJ->dokter_id;
                            $modelResumeMedisRjClaim->anamesis = $modelResumeMedisRJ->anamesis;
                            $modelResumeMedisRjClaim->pemeriksaan_fisik = $modelResumeMedisRJ->pemeriksaan_fisik;
                            $modelResumeMedisRjClaim->diagnosa = $modelResumeMedisRJ->diagnosa;
                            $CodingPelaporanTindakanDetailRj = Yii::$app->request->post('CodingPelaporanTindakanDetailRj');

                            usort($CodingPelaporanTindakanDetailRj, function ($a, $b) {
                                return $b['utama'] - $a['utama'];
                            });



                            $modelResumeMedisRjClaim->tindakan = $modelResumeMedisRJ->tindakan;
                            $modelResumeMedisRjClaim->tindakan_utama_id = $CodingPelaporanTindakanDetailRj[0]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->tindakan_tambahan1_id = $CodingPelaporanTindakanDetailRj[0]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->tindakan_tambahan2_id = $CodingPelaporanTindakanDetailRj[0]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->tindakan_tambahan3_id = $CodingPelaporanTindakanDetailRj[0]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->tindakan_tambahan4_id = $CodingPelaporanTindakanDetailRj[0]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->tindakan_tambahan5_id = $CodingPelaporanTindakanDetailRj[0]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->tindakan_tambahan6_id = $CodingPelaporanTindakanDetailRj[0]['icd10_id'] ?? null;
                            $modelResumeMedisRjClaim->terapi = $modelResumeMedisRJ->terapi;
                            $modelResumeMedisRjClaim->rencana = $modelResumeMedisRJ->rencana;
                            $modelResumeMedisRjClaim->alasan_kontrol = $modelResumeMedisRJ->alasan_kontrol;
                            $modelResumeMedisRjClaim->alasan = $modelResumeMedisRJ->alasan;
                            $modelResumeMedisRjClaim->lab = $modelResumeMedisRJ->lab;
                            $modelResumeMedisRjClaim->rad = $modelResumeMedisRJ->rad;
                            $modelResumeMedisRjClaim->poli_tujuan_kontrol_id = $modelResumeMedisRJ->poli_tujuan_kontrol_id;
                            $modelResumeMedisRjClaim->poli_tujuan_kontrol_nama = $modelResumeMedisRJ->poli_tujuan_kontrol_nama;
                            $modelResumeMedisRjClaim->tgl_kontrol = $modelResumeMedisRJ->tgl_kontrol;
                            $modelResumeMedisRjClaim->keterangan = $modelResumeMedisRJ->keterangan;
                            if ($flags = $modelResumeMedisRjClaim->save(false)) {
                                if (!($flags = $modelResumeMedisRjClaim->save(false))) {
                                    $transaction->rollBack();
                                }
                            }
                            if ($flags) {
                                $transaction->commit();
                                $result = ['status' => true, 'msg' => 'Data Berhasil Disimpan'];
                                return $this->asJson($result);
                            }
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
    public function actionClaimIcd9Save()
    {
        // $model=$this->initModelCreate($id);
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
                            $transaction->commit();
                            $result = ['status' => true, 'msg' => 'Data Berhasil Disimpan'];
                            return $this->asJson($result);
                            // Yii::$app->session->setFlash('success', 'Resep Obat No : '.$model->no_transaksi.' Berhasil Ditambahkan!');
                            // if(\Yii::$app->request->isAjax){
                            //     return Yii::$app->response->redirect(['resep/index']);false;
                            // }else{
                            //     return $this->redirect(['resep/index']);false;
                            // }
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

    public function actionSaveResumeMedisVerifikator()
    {
        $model = new ResumeMedisRiClaim();
        $req = Yii::$app->request->post('ResumeMedisRiClaim');
        $user = HelperSpesialClass::getUserLogin();


        $model = ResumeMedisRiClaim::find()->where(['registrasi_kode' => $req['registrasi_kode']])->one();
        if (empty($model)) {
            $model = new ResumeMedisRiClaim();
        }

        // echo'<pre/>';print_r(Yii::$app->request->post());die();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->save()) {
                $result = ['status' => true, 'msg' => 'Resume Medis RI Medis Berhasil Disimpan!'];
                return $this->asJson($result);
                return Api::writeResponse(true, 'Resume Medis RI Medis Berhasil Disimpan!');
            } else {
                $result = ['status' => false, 'msg' => 'Resume Medis RI Gagal Disimpan!' . json_encode($model->errors)];
                return $this->asJson($result);

                return Api::writeResponse(false, 'Resume Medis RI Gagal Disimpan', $model->errors);
            }
        }
    }


    public function actionSaveResumeMedisMpp()
    {
        $model = new ResumeMedisRi();
        $req = Yii::$app->request->post('ResumeMedisRi');
        $user = HelperSpesialClass::getUserLogin();


        $model = ResumeMedisRi::find()->where(['id' => $req['id']])->one();
        if (empty($model)) {
            $model = new ResumeMedisRi();
        }
        // print_r($model->id);
        // die;
        // echo'<pre/>';print_r(Yii::$app->request->post());die();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->save()) {
                $result = ['status' => true, 'msg' => 'Resume Medis RI Medis Berhasil Disimpan!'];
                return $this->asJson($result);
                return Api::writeResponse(true, 'Resume Medis RI Medis Berhasil Disimpan!');
            } else {
                $result = ['status' => false, 'msg' => 'Resume Medis RI Gagal Disimpan!' . json_encode($model->errors)];
                return $this->asJson($result);

                return Api::writeResponse(false, 'Resume Medis RI Gagal Disimpan', $model->errors);
            }
        }
    }
    public function actionSaveResumeMedisVerifikatorRj()
    {
        $model = new ResumeMedisRjClaim();
        return print_r(Yii::$app->request->post());
        $req = Yii::$app->request->post('ResumeMedisRjClaim');
        $user = HelperSpesialClass::getUserLogin();


        $model = ResumeMedisRjClaim::find()->where(['registrasi_kode' => $req['registrasi_kode']])->one();
        if (empty($model)) {
            $model = new ResumeMedisRjClaim();
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->save()) {
                $result = ['status' => true, 'msg' => 'Resume Medis RI Medis Berhasil Disimpan!'];
                return $this->asJson($result);
                return Api::writeResponse(true, 'Resume Medis RI Medis Berhasil Disimpan!');
            } else {
                $result = ['status' => false, 'msg' => 'Resume Medis RI Gagal Disimpan!' . json_encode($model->errors)];
                return $this->asJson($result);

                return Api::writeResponse(false, 'Resume Medis RI Gagal Disimpan', $model->errors);
            }
        }
    }
    public static function DataApiNoLab($notran)
    {
        // Create a new cURL resource
        $ch = curl_init('192.168.254.67/saba/patient');

        // Setup request to send json via POST
        $data = array(
            'username' => 'lis',
            'password' => 'sab@2020',
            'ono'      => $notran
        );
        $payload = json_encode($data);

        // Attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        // Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        // Return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the POST request
        $result = curl_exec($ch);

        // Close cURL resource
        curl_close($ch);

        return json_decode($result, TRUE);
    }

    public function actionPreviewAsesmenAwalKeperawatan($id)
    {
        $asesmen = AsesmenAwalKeperawatanGeneral::find()->joinWith(['perawat', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['medis.asesmen_awal_keperawatan_general.id' => $id])->one();
        $pasien = Pasien::find()->where(['kode' => $asesmen->layanan->registrasi->pasien->kode])->one();
        return $this->renderAjax('asesmen-awal-keperawatan', ['asesmen' => $asesmen, 'pasien' => $pasien]);
    }

    public function actionPreviewAsesmenAwalMedis($id)
    {
        $asesmen = AsesmenAwalMedis::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['medis.asesmen_awal_medis.id' => $id])->one();
        $pasien = Pasien::find()->where(['kode' => $asesmen->layanan->registrasi->pasien->kode])->one();
        return $this->renderAjax('asesmen-awal-medis', ['asesmen' => $asesmen, 'pasien' => $pasien]);
    }

    public function actionPreviewAsesmenAwalKebidanan($id)
    {
        $asesmen = AsesmenAwalKebidanan::find()->joinWith(['perawat', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['medis.asesmen_awal_kebidanan.id' => $id])->one();
        $pasien = Pasien::find()->where(['kode' => $asesmen->layanan->registrasi->pasien->kode])->one();
        return $this->renderAjax('asesmen-awal-kebidanan', ['asesmen' => $asesmen, 'pasien' => $pasien]);
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
    public function actionPreviewCppt($id)
    {

        $registrasi = HelperSpesialClass::getCheckPasien($id);
        $registrasiKode = $registrasi->data['kode'];


        $asesmen = Cppt::find()->joinWith([
            'layanan' => function ($q) use ($registrasi) {
                $q->with(['unit'])->where([Layanan::tableName() . '.registrasi_kode' => $registrasi->data['kode']]);
                $q->joinWith(['registrasi']);
                $q->andWhere([Registrasi::tableName() . '.pasien_kode' => $registrasi->data['pasien_kode']]);
            },
            'dokter',

            'dokterVerif'
        ])->where(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->orderBy(['tanggal_final' => SORT_ASC])->asArray()->all();
        // print_r($asesmen);
        // die;
        $pasien = Pasien::find()->where(['kode' => $registrasi->data['pasien_kode']])->one();
        return $this->renderAjax('cppt', ['asesmen' => $asesmen, 'pasien' => $pasien]);
    }


    public function actionPreviewRadiologi($id)
    {
        $data = ResultPacs::find()->alias('rp')->select([
            'rp.id_pacsorder',
            'rp.report_description',
            'rp.nomor_pasien',
            'rp.nomor_registrasi',
            'p.nama AS pasien_nama',
            'p.jkel',
            'pl.nama AS pasien_luar_nama',
            'pl.jkel AS pasien_luar_jkel',
            "rp.nomor_transaksi",
            'rp.kode_jenis',
            'rp.nama_tindakan',
            'rp.unit_asal_nama',
            'rp.dokter_asal_nama',
            'rp.dokter_nama',
            'rp.tanggal_masuk',
            'rp.link',
            'rp.order_date',
            'rp.dokter_name'
        ])
            ->innerJoin('pendaftaran.pasien p', 'p.kode=rp.nomor_pasien')
            ->leftJoin('pendaftaran.registrasi r', 'r.kode=rp.nomor_registrasi')
            ->leftJoin('pendaftaran.pasien_luar pl', 'pl.registrasi_kode=r.kode')
            ->where(['rp.id_pacsorder' => $id])->asArray()->one();

        $pasien = Pasien::find()->where(['kode' => $data['nomor_pasien']])->one();

        // $content = $this->renderPartial('CetakHasil', [
        //     'data' => $data,
        //     'no_tran' => $no_tran
        // ]);
        return $this->renderAjax('CetakHasil', ['data' => $data, 'pasien' => $pasien, 'no_tran' => $id]);
    }

    public function actionPreviewPatologiAnatomi($id, $pemeriksaan)
    {
        $modelExpertise = HasilPemeriksaan::findOne(['id' => $id]);
        $data = HasilPemeriksaan::find()->where(['id' => $id])->asArray()->one();
        $pasienLaporan = Layanan::getDataExpertisePa($modelExpertise->layanan_id_penunjang);
        $tindakan = TarifTindakanPasien::getTarifTIndakanPasienExpertisePa($pemeriksaan);
        $dokter = TbPegawai::getNamaDokter($data['dokter_pemeriksa']);
        $panel = PemeriksaanTindakanHasil::find()->where(['hasil_pemeriksaan_id' => $id])->asArray()->all();
        $no_periksa = LabelPemeriksaanPa::find()->select(['no_periksa'])->where(['tindakan_tarif_pasien_id' => $pemeriksaan])->asArray()->one();

        $jenis = JenisTindakanPa::find()->select('jenis')->where(['id_tindakan' => $tindakan['id']])->asArray()->one();

        $pasien = Pasien::find()->where(['kode' => $pasienLaporan['pasien_kode']])->one();
        // print_r($pasien);
        // die;
        // $content = $this->renderPartial('CetakHasil', [
        //     'data' => $data,
        //     'no_tran' => $no_tran
        // ]);
        return $this->renderAjax('expertise', [
            'data' => $data,
            'pasien' => $pasien,
            'pasienLaporan' => $pasienLaporan,
            'tindakan' => $tindakan,
            'dokter' => $dokter,
            'panel' => $panel,
            'jenis' => $jenis,
            'no_periksa' => $no_periksa,
            'no_tran' => $id
        ]);
    }
    public function actionPreviewLaporanOperasi($id)
    {
        $model = LaporanOperasi::find()
            ->joinWith(['timOperasi' => function ($query) {
                $query->joinWith(['layanan' => function ($query) {
                    $query->joinWith(['registrasi' => function ($query) {
                        $query->joinWith('pasien');
                    }]);
                }]);
            }])->where(['lap_op_id' => $id])->one();
        $timoperasi = TimOperasi::find()->where(['to_id' => $model->lap_op_to_id])->one();
        $timoperasidetail = TimOperasiDetail::find()->where(['tod_to_id' => $model->lap_op_to_id])->all();

        $asisten = TimOperasiDetail::find()->where(['tod_to_id' => $timoperasi->to_id])->andWhere(['tod_jo_id' => 3])->all();
        $instrumen = TimOperasiDetail::find()->where(['tod_to_id' => $timoperasi->to_id])->andWhere(['tod_jo_id' => 6])->all();
        $sirkuler = TimOperasiDetail::find()->where(['tod_to_id' => $timoperasi->to_id])->andWhere(['tod_jo_id' => 7])->all();
        $ahlibedah = TimOperasiDetail::find()->where(['tod_to_id' => $timoperasi->to_id])->andWhere(['tod_jo_id' => 1])->all();
        $ahlianestesi = TimOperasiDetail::find()->where(['tod_to_id' => $timoperasi->to_id])->andWhere(['tod_jo_id' => 2])->all();
        $perawatanestesi = TimOperasiDetail::find()->where(['tod_to_id' => $timoperasi->to_id])->andWhere(['tod_jo_id' => 11])->all();
        $pasien = Pasien::find()->where(['kode' => $model->timOperasi->layanan->registrasi->pasien->kode])->one();
        return $this->renderAjax('laporan-operasi', [
            'instrumen' => $instrumen,
            'model' => $model,
            'asisten' => $asisten,
            'timoperasi' => $timoperasi,
            'timoperasidetail' => $timoperasidetail,
            'pasien' => $pasien,
            'sirkuler' => $sirkuler,
            'ahlibedah' => $ahlibedah,
            'ahlianestesi' => $ahlianestesi,
            'perawatanestesi' => $perawatanestesi

        ]);
    }

    public function actionTesting()
    {
        $model = new AnalisaDokumen();

        if ($model->load(Yii::$app->request->post())) {

            $analisaDokumen = AnalisaDokumenDetail::find()
                ->select([
                    'count(analisa_dokumen.analisa_dokumen_id) as jumlah_dokumen',
                    'master_jenis_analisa.jenis_analisa_uraian as jenis_analisa',
                    'master_item_analisa.item_analisa_uraian as item_uraian',
                    'master_item_analisa.item_analisa_tipe',
                    'analisa_dokumen_detail.analisa_dokumen_item_id',
                    'analisa_dokumen_detail.analisa_dokumen_jenis_id',
                    'analisa_dokumen_detail.analisa_dokumen_jenis_analisa_detail_id',
                    'COUNT(analisa_dokumen_detail.analisa_dokumen_kelengkapan) filter (where analisa_dokumen_detail.analisa_dokumen_kelengkapan = 0) as tidak_ada',
                    'COUNT(analisa_dokumen_detail.analisa_dokumen_kelengkapan) filter (where analisa_dokumen_detail.analisa_dokumen_kelengkapan = 1) as tidak_lengkap',
                    'COUNT(analisa_dokumen_detail.analisa_dokumen_kelengkapan) filter (where analisa_dokumen_detail.analisa_dokumen_kelengkapan = 2) as lengkap',
                    'COUNT(analisa_dokumen_detail.analisa_dokumen_kelengkapan) filter (where analisa_dokumen_detail.analisa_dokumen_kelengkapan = 3) as ada'

                ])
                ->innerJoin('analisa_dokumen', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->innerJoin('master_item_analisa', 'master_item_analisa.item_analisa_id=analisa_dokumen_detail.analisa_dokumen_item_id')
                ->innerJoin('master_jenis_analisa', 'analisa_dokumen_detail.analisa_dokumen_jenis_id=master_jenis_analisa.jenis_analisa_id')
                ->innerJoin('master_jenis_analisa_detail', 'master_jenis_analisa_detail.jenis_analisa_detail_id=analisa_dokumen_detail.analisa_dokumen_jenis_analisa_detail_id');
            // ->where(['analisa_dokumen.dokter_id'=>'38'])

            if ($model->jenis_laporan == AnalisaDokumen::JENIS_HARIAN) {
                $jenisLaporan = 'Harian';
                $tglJudul = Yii::$app->formatter->asDate($model->tgl_hari);
                $analisaDokumen = $analisaDokumen
                    ->andWhere(['=', 'analisa_dokumen.created_at', $model->tgl_hari]);
            } else if ($model->jenis_laporan == AnalisaDokumen::JENIS_BULANAN) {
                $jenisLaporan = 'Bulanan';
                $tglJudul = $model->tgl_bulan;
                $analisaDokumen = $analisaDokumen
                    ->andWhere(['=', new Expression("to_char(analisa_dokumen.created_at, 'MM-YYYY')"), $model->tgl_bulan]);
            } else if ($model->jenis_laporan == AnalisaDokumen::JENIS_TAHUNAN) {
                $jenisLaporan = 'Tahunan';
                $tglJudul = $model->tgl_tahun;
                $analisaDokumen = $analisaDokumen
                    ->andWhere(['=', new Expression("to_char(analisa_dokumen.created_at, 'YYYY')"), $model->tgl_tahun]);
            }
            $ruangan = '';
            $dokter = '';
            if ($model->tipe_laporan == 'ruangan') {
                $analisaDokumen = $analisaDokumen->andWhere(['analisa_dokumen.unit_id' => $model->unit_id]);
                $ruanganData = DmUnitPenempatan::find()->where(['kode' => $model->unit_id])->one();
                $ruangan = $ruanganData->nama;
                $dokter = '';
            } elseif ($model->tipe_laporan == 'dokter') {
                $analisaDokumen = $analisaDokumen->andWhere(['analisa_dokumen.dokter_id' => $model->dokter_id]);
                $dokterData = TbPegawai::find()->where(['pegawai_id' => $model->dokter_id])->one();
                $ruangan = '';
                $dokter = HelperSpesialClass::getNamaPegawai($dokterData);
            }
            // $analisaDokumen->andWhere(['=', new Expression("to_char(analisa_dokumen.created_at, 'MM-YYYY')"), '11-2022']);
            // ->andWhere(['>', new Expression('date (' . AnalisaDokumenDetail::tableName() . '.created_at)'), '2022-11-17'])
            $analisaDokumen = $analisaDokumen->groupBy([
                'analisa_dokumen_detail.analisa_dokumen_item_id',
                'analisa_dokumen_detail.analisa_dokumen_jenis_id',
                'master_item_analisa.item_analisa_id',

                'analisa_dokumen_detail.analisa_dokumen_jenis_analisa_detail_id',
                'master_jenis_analisa.jenis_analisa_uraian'
            ])
                ->orderBy('analisa_dokumen_detail.analisa_dokumen_jenis_id')
                ->asArray()->all();

            $query = AnalisaDokumenDetail::find()
                ->select([
                    'count(distinct analisa_dokumen.analisa_dokumen_id) as jumlah_dokumen',
                ])
                ->innerJoin('analisa_dokumen', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->innerJoin('master_item_analisa', 'master_item_analisa.item_analisa_id=analisa_dokumen_detail.analisa_dokumen_item_id')
                ->innerJoin('master_jenis_analisa', 'analisa_dokumen_detail.analisa_dokumen_jenis_id=master_jenis_analisa.jenis_analisa_id')
                ->innerJoin('master_jenis_analisa_detail', 'master_jenis_analisa_detail.jenis_analisa_detail_id=analisa_dokumen_detail.analisa_dokumen_jenis_analisa_detail_id');
            // ->where(['analisa_dokumen.dokter_id'=>'38'])

            if ($model->jenis_laporan == AnalisaDokumen::JENIS_HARIAN) {
                $jenisLaporan = 'Harian';
                $tglJudul = Yii::$app->formatter->asDate($model->tgl_hari);
                $query = $query
                    ->andWhere(['=', 'analisa_dokumen.created_at', $model->tgl_hari]);
            } else if ($model->jenis_laporan == AnalisaDokumen::JENIS_BULANAN) {
                $jenisLaporan = 'Bulanan';
                $tglJudul = $model->tgl_bulan;
                $query = $query
                    ->andWhere(['=', new Expression("to_char(analisa_dokumen.created_at, 'MM-YYYY')"), $model->tgl_bulan]);
            } else if ($model->jenis_laporan == AnalisaDokumen::JENIS_TAHUNAN) {
                $jenisLaporan = 'Tahunan';
                $tglJudul = $model->tgl_tahun;
                $query = $query
                    ->andWhere(['=', new Expression("to_char(analisa_dokumen.created_at, 'YYYY')"), $model->tgl_tahun]);
            }
            $ruangan = '';
            $dokter = '';
            if ($model->tipe_laporan == 'ruangan') {
                $query = $query->andWhere(['analisa_dokumen.unit_id' => $model->unit_id]);
                $ruanganData = DmUnitPenempatan::find()->where(['kode' => $model->unit_id])->one();
                $ruangan = $ruanganData->nama;
                $dokter = '';
            } elseif ($model->tipe_laporan == 'dokter') {
                $query = $query->andWhere(['analisa_dokumen.dokter_id' => $model->dokter_id]);
                $dokterData = TbPegawai::find()->where(['pegawai_id' => $model->dokter_id])->one();
                $ruangan = '';
                $dokter = HelperSpesialClass::getNamaPegawai($dokterData);
            }

            $query = $query->asArray()->all();


            $spreadsheet = new Spreadsheet();
            $spreadsheet->getProperties()->setCreator('SIMRS Farmasi - RSUD Arifin Achmad')
                ->setLastModifiedBy('SIMRS Farmasi - RSUD Arifin Achmad')
                ->setTitle('Laporan Pengadaan RSUD Arifin Achmad')
                ->setSubject('Laporan Pengadaan RSUD Arifin Achmad')
                ->setDescription('Dicetak dari SIMRS Farmasi RSUD Arifin Achmad')
                ->setKeywords('office 2007+ openxml php')
                ->setCategory('Laporan');

            $spreadsheet->getActiveSheet()->getPageSetup()
                ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
                ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL)
                ->setFitToWidth(0)
                ->setFitToHeight(0);

            // Start - Penulisan Data ke Excel
            // --------------------------------------------------------------------------

            $baseHeader = 1;

            $spreadsheet->getActiveSheet()
                ->setCellValue("A" . ($baseHeader), 'PEMERINTAH PROVINSI RIAU')
                ->setCellValue("A" . ($baseHeader + 1), 'RSUD ARIFIN ACHMAD')
                ->setCellValue("A" . ($baseHeader + 2), 'Jl. Diponegoro No. 2 Telp. (0761) - 23418, 21618, 21657 Fax. (0761) - 20253')
                ->setCellValue("A" . ($baseHeader + 3), 'KOTA PEKANBARU');
            $spreadsheet->getActiveSheet()->getStyle("A" . ($baseHeader))->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle("A" . ($baseHeader + 1))->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle("A" . ($baseHeader + 2))->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle("A" . ($baseHeader + 3))->getAlignment()->setHorizontal('center');

            $spreadsheet->getActiveSheet()
                ->mergeCells("A" . ($baseHeader) . ":L" . ($baseHeader))
                ->mergeCells("A" . ($baseHeader + 1) . ":L" . ($baseHeader + 1))
                ->mergeCells("A" . ($baseHeader + 2) . ":L" . ($baseHeader + 2))
                ->mergeCells("A" . ($baseHeader + 3) . ":L" . ($baseHeader + 3));
            // set logo
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setWorksheet($spreadsheet->getActiveSheet());
            $drawing->setPath(Url::to('@app/web/images/logo_riau.png'));
            $drawing->setCoordinates('A1');
            $drawing->setWidthAndHeight(158, 72);
            $drawing->setResizeProportional(true);
            $drawing->setOffsetX(10);    // this is how
            $drawing->setOffsetY(3);
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setWorksheet($spreadsheet->getActiveSheet());
            $drawing->setPath(Url::to('@app/web/images/rsud.png'));
            $drawing->setCoordinates('J1');
            $drawing->setWidthAndHeight(158, 72);
            $drawing->setResizeProportional(true);
            $drawing->setOffsetX(250);    // this is how
            $drawing->setOffsetY(3);
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setWorksheet($spreadsheet->getActiveSheet());
            $drawing->setPath(Url::to('@app/web/images/kars.png'));
            $drawing->setCoordinates('L1');
            $drawing->setWidthAndHeight(158, 72);
            $drawing->setResizeProportional(true);
            $drawing->setOffsetX(-20);    // this is how
            $drawing->setOffsetY(3);

            $baseRowTitle = $baseHeader + 5;

            $spreadsheet->getActiveSheet()
                ->mergeCells("A" . ($baseRowTitle) . ":L" . ($baseRowTitle));
            $spreadsheet->getActiveSheet()
                ->setCellValue("A{$baseRowTitle}", 'Laporan Analisa Data EMR ' . $jenisLaporan . ' ' . ($ruangan ?? '') . ($dokter ?? ''));
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRowTitle}")->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRowTitle}")->getFont()->setBold(true);

            $baseRowTitle++;

            $spreadsheet->getActiveSheet()
                ->mergeCells("A" . ($baseRowTitle) . ":L" . ($baseRowTitle));
            // $spreadsheet->getActiveSheet()
            //     ->setCellValue("A{$baseRowTitle}", $jenisLaporanKegiatan);
            // $baseRowTitle++;
            $spreadsheet->getActiveSheet()
                ->mergeCells("A" . ($baseRowTitle) . ":L" . ($baseRowTitle));
            $spreadsheet->getActiveSheet()
                ->setCellValue("A{$baseRowTitle}", $tglJudul);
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRowTitle}")->getAlignment()->setHorizontal('center');

            $baseRowTitle++;


            \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder(new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());
            $baseRowTitle++;
            $baseRowTable = $baseRowTitle + 1;
            $spreadsheet->getActiveSheet()
                ->mergeCells("A" . ($baseRowTable) . ":I" . ($baseRowTable + 1));
            $spreadsheet->getActiveSheet()
                ->mergeCells("J" . ($baseRowTable) . ":K" . ($baseRowTable));
            // $spreadsheet->getActiveSheet()
            //     ->mergeCells("L" . ($baseRowTable) . ":L" . ($baseRowTable + 1));

            $spreadsheet->getActiveSheet()
                ->getStyle("A" . ($baseRowTable) . ":L" . ($baseRowTable + 1))
                ->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            $spreadsheet->getActiveSheet()
                ->getStyle("A" . ($baseRowTable) . ":L" . ($baseRowTable + 1))
                ->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFFF00',
                        ],
                    ],
                    'font' => [
                        'size' => 11,
                        'bold' => true,
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
            $spreadsheet->getActiveSheet()
                ->setCellValue("A{$baseRowTable}", 'KRITERIA ANALISA');
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRowTable}")->getAlignment()->setHorizontal('center')->setVertical('center');
            $spreadsheet->getActiveSheet()
                ->setCellValue("J{$baseRowTable}", 'JUMLAH KELENGKAPAN');
            $spreadsheet->getActiveSheet()->getStyle("J{$baseRowTable}")->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()
                ->setCellValue("J" . ($baseRowTable + 1), 'BAIK');
            $spreadsheet->getActiveSheet()->getStyle("A" . ($baseRowTable + 1))->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()
                ->setCellValue("K" . ($baseRowTable + 1), 'TIDAK BAIK');
            $spreadsheet->getActiveSheet()
                ->setCellValue("L" . ($baseRowTable), 'PERSENTASE');
            $spreadsheet->getActiveSheet()
                ->setCellValue("L" . ($baseRowTable + 1), 'TIDAK BAIK');
            foreach (range('J', 'L') as $columnID) {
                $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                    ->setWidth('15');
            }

            $spreadsheet->getActiveSheet()->getStyle("L" . ($baseRowTable))->getAlignment()->setHorizontal('center')->setVertical('center');
            $baseRowTable++;

            $baseRow = $baseRowTable + 1;

            $no = 1;
            $jenis = [null, null];

            foreach ($analisaDokumen as $item) {

                if ($jenis[0] != $item['analisa_dokumen_jenis_id']) {
                    $jenis = [$item['analisa_dokumen_jenis_id'], $item['jenis_analisa']];
                    $spreadsheet->getActiveSheet()
                        ->mergeCells("A" . ($baseRow) . ":L" . ($baseRow));
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $baseRow, $item['jenis_analisa']);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $baseRow)->getAlignment()->setWrapText(false);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $baseRow)->getFont()->setBold(true);
                    $baseRow++;
                }
                if ($item['item_analisa_tipe'] == 1) {
                    $spreadsheet->getActiveSheet()
                        ->mergeCells("A" . ($baseRow) . ":I" . ($baseRow));
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $baseRow, $no . ". " . $item['item_uraian']);
                    // $spreadsheet->getActiveSheet()
                    //     ->mergeCells("J" . ($baseRow) . ":K" . ($baseRow));
                    $spreadsheet->getActiveSheet()->getStyle('J' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                    $spreadsheet->getActiveSheet()->getStyle('K' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                    $spreadsheet->getActiveSheet()->getStyle('L' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('J' . $baseRow, $item['ada']);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('K' . $baseRow, $item['tidak_ada']);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('L' . $baseRow, sprintf("%.2f%%", ($item['tidak_ada'] / $item['jumlah_dokumen']) * 100));
                    // ->setCellValue('C' . $baseRow, $item->no_sp)
                    // ->setCellValue('D' . $baseRow, $item->supplier->nama_supplier ?? '-')
                    // ->setCellValue('E' . $baseRow, $item->tipe_pembelian)
                    // ->setCellValue('L' . $baseRow, $item->total);

                } else {
                    $spreadsheet->getActiveSheet()
                        ->mergeCells("A" . ($baseRow) . ":I" . ($baseRow));
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $baseRow, $no . ". " . $item['item_uraian']);
                    $spreadsheet->getActiveSheet()->getStyle('J' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                    $spreadsheet->getActiveSheet()->getStyle('K' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                    $spreadsheet->getActiveSheet()->getStyle('L' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');

                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('J' . $baseRow, $item['lengkap']);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('K' . $baseRow, ($item['tidak_lengkap'] + $item['tidak_ada']));
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('L' . $baseRow, sprintf("%.2f%%", (($item['tidak_lengkap'] + $item['tidak_ada']) / $item['jumlah_dokumen']) * 100));
                    // ->setCellValue('C' . $baseRow, $item->no_sp)
                    // ->setCellValue('D' . $baseRow, $item->supplier->nama_supplier ?? '-')
                    // ->setCellValue('E' . $baseRow, $item->tipe_pembelian)
                    // ->setCellValue('L' . $baseRow, $item->total);
                }
                $baseRowItem = $baseRow;
                $baseRowItem++;
                $baseRow = $baseRowItem;
                $no++;
            }
            $spreadsheet->getActiveSheet()
                ->mergeCells("A" . ($baseRow) . ":I" . ($baseRow));
            $spreadsheet->getActiveSheet()
                ->mergeCells("J" . ($baseRow) . ":L" . ($baseRow));
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRow}")->getAlignment()->setHorizontal('center')->setVertical('center');
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRow}")->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle("J{$baseRow}")->getAlignment()->setHorizontal('center')->setVertical('center');
            $spreadsheet->getActiveSheet()->getStyle("J{$baseRow}")->getFont()->setBold(true);
            // return json_encode($query[0]['jumlah_dokumen']);
            $spreadsheet->getActiveSheet()
                ->setCellValue("A{$baseRow}", 'Total')
                ->setCellValue("J{$baseRow}", $query[0]['jumlah_dokumen'] . " Dokumen");


            $spreadsheet->getActiveSheet()
                ->getStyle("A{$baseRowTable}:L{$baseRow}")
                ->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            $spreadsheet->setActiveSheetIndex(0);

            // Redirect output to a client’s web browser (Xlsx)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan Analisa EMR ' . $jenisLaporan . ' ' . $tglJudul . '.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit(); // -> agar file tidak corrupt


        }
    }
    public function actionCetakAnalisa()
    {
        $model = new AnalisaDokumen();

        if ($model->load(Yii::$app->request->post())) {

            $analisaDokumen = AnalisaDokumenDetail::find()
                ->select([
                    'count(analisa_dokumen.analisa_dokumen_id) as jumlah_dokumen',
                    'master_jenis_analisa.jenis_analisa_uraian as jenis_analisa',
                    'master_item_analisa.item_analisa_uraian as item_uraian',
                    'master_item_analisa.item_analisa_tipe',
                    'analisa_dokumen_detail.analisa_dokumen_item_id',
                    'analisa_dokumen_detail.analisa_dokumen_jenis_id',
                    'analisa_dokumen_detail.analisa_dokumen_jenis_analisa_detail_id',
                    'COUNT(analisa_dokumen_detail.analisa_dokumen_kelengkapan) filter (where analisa_dokumen_detail.analisa_dokumen_kelengkapan = 0) as tidak_ada',
                    'COUNT(analisa_dokumen_detail.analisa_dokumen_kelengkapan) filter (where analisa_dokumen_detail.analisa_dokumen_kelengkapan = 1) as tidak_lengkap',
                    'COUNT(analisa_dokumen_detail.analisa_dokumen_kelengkapan) filter (where analisa_dokumen_detail.analisa_dokumen_kelengkapan = 2) as lengkap',
                    'COUNT(analisa_dokumen_detail.analisa_dokumen_kelengkapan) filter (where analisa_dokumen_detail.analisa_dokumen_kelengkapan = 3) as ada'

                ])
                ->innerJoin('analisa_dokumen', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->innerJoin(Registrasi::tableName(), Registrasi::tableName() . '.kode=analisa_dokumen.reg_kode')
                ->innerJoin('master_item_analisa', 'master_item_analisa.item_analisa_id=analisa_dokumen_detail.analisa_dokumen_item_id')
                ->innerJoin('master_jenis_analisa', 'analisa_dokumen_detail.analisa_dokumen_jenis_id=master_jenis_analisa.jenis_analisa_id')
                ->innerJoin('master_jenis_analisa_detail', 'master_jenis_analisa_detail.jenis_analisa_detail_id=analisa_dokumen_detail.analisa_dokumen_jenis_analisa_detail_id');
            // ->where(['analisa_dokumen.dokter_id'=>'38'])

            if ($model->jenis_laporan == AnalisaDokumen::JENIS_HARIAN) {
                $jenisLaporan = 'Harian';
                $tglJudul = Yii::$app->formatter->asDate($model->tgl_hari);
                $analisaDokumen = $analisaDokumen
                    ->andWhere(['=', Registrasi::tableName() . '.tgl_keluar', $model->tgl_hari]);
            } else if ($model->jenis_laporan == AnalisaDokumen::JENIS_BULANAN) {
                $jenisLaporan = 'Bulanan';
                $tglJudul = $model->tgl_bulan;
                $analisaDokumen = $analisaDokumen
                    ->andWhere(['=', new Expression("to_char(" . Registrasi::tableName() . '.tgl_keluar' . ", 'MM-YYYY')"), $model->tgl_bulan]);
            } else if ($model->jenis_laporan == AnalisaDokumen::JENIS_TAHUNAN) {
                $jenisLaporan = 'Tahunan';
                $tglJudul = $model->tgl_tahun;
                $analisaDokumen = $analisaDokumen
                    ->andWhere(['=', new Expression("to_char(" . Registrasi::tableName() . '.tgl_keluar' . ", 'YYYY')"), $model->tgl_tahun]);
            }
            $ruangan = '';
            $dokter = '';
            if ($model->tipe_laporan == 'ruangan') {
                $analisaDokumen = $analisaDokumen->andWhere(['analisa_dokumen.unit_id' => $model->unit_id]);
                $ruanganData = DmUnitPenempatan::find()->where(['kode' => $model->unit_id])->one();
                $ruangan = $ruanganData->nama;
                $dokter = '';
            } elseif ($model->tipe_laporan == 'dokter') {
                $analisaDokumen = $analisaDokumen->andWhere(['analisa_dokumen.dokter_id' => $model->dokter_id]);
                $dokterData = TbPegawai::find()->where(['pegawai_id' => $model->dokter_id])->one();
                $ruangan = '';
                $dokter = HelperSpesialClass::getNamaPegawai($dokterData);
            }
            // $analisaDokumen->andWhere(['=', new Expression("to_char(analisa_dokumen.created_at, 'MM-YYYY')"), '11-2022']);
            // ->andWhere(['>', new Expression('date (' . AnalisaDokumenDetail::tableName() . '.created_at)'), '2022-11-17'])
            $analisaDokumen = $analisaDokumen->groupBy([
                'analisa_dokumen_detail.analisa_dokumen_item_id',
                'analisa_dokumen_detail.analisa_dokumen_jenis_id',
                'master_item_analisa.item_analisa_id',

                'analisa_dokumen_detail.analisa_dokumen_jenis_analisa_detail_id',
                'master_jenis_analisa.jenis_analisa_uraian'
            ])
                ->orderBy('analisa_dokumen_detail.analisa_dokumen_jenis_id')
                ->asArray()->all();

            $query = AnalisaDokumenDetail::find()
                ->select([
                    'count(distinct analisa_dokumen.analisa_dokumen_id) as jumlah_dokumen',
                ])
                ->innerJoin('analisa_dokumen', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->innerJoin(Registrasi::tableName(), Registrasi::tableName() . '.kode=analisa_dokumen.reg_kode')
                ->innerJoin('master_item_analisa', 'master_item_analisa.item_analisa_id=analisa_dokumen_detail.analisa_dokumen_item_id')
                ->innerJoin('master_jenis_analisa', 'analisa_dokumen_detail.analisa_dokumen_jenis_id=master_jenis_analisa.jenis_analisa_id')
                ->innerJoin('master_jenis_analisa_detail', 'master_jenis_analisa_detail.jenis_analisa_detail_id=analisa_dokumen_detail.analisa_dokumen_jenis_analisa_detail_id');
            // ->where(['analisa_dokumen.dokter_id'=>'38'])

            if ($model->jenis_laporan == AnalisaDokumen::JENIS_HARIAN) {
                $jenisLaporan = 'Harian';
                $tglJudul = Yii::$app->formatter->asDate($model->tgl_hari);
                $query = $query
                    ->andWhere(['=', Registrasi::tableName() . '.tgl_keluar', $model->tgl_hari]);
            } else if ($model->jenis_laporan == AnalisaDokumen::JENIS_BULANAN) {
                $jenisLaporan = 'Bulanan';
                $tglJudul = $model->tgl_bulan;
                $query = $query
                    ->andWhere(['=', new Expression("to_char(" . Registrasi::tableName() . '.tgl_keluar' . ", 'MM-YYYY')"), $model->tgl_bulan]);
            } else if ($model->jenis_laporan == AnalisaDokumen::JENIS_TAHUNAN) {
                $jenisLaporan = 'Tahunan';
                $tglJudul = $model->tgl_tahun;
                $query = $query
                    ->andWhere(['=', new Expression("to_char(" . Registrasi::tableName() . '.tgl_keluar' . ", 'YYYY')"), $model->tgl_tahun]);
            }
            $ruangan = '';
            $dokter = '';
            if ($model->tipe_laporan == 'ruangan') {
                $query = $query->andWhere(['analisa_dokumen.unit_id' => $model->unit_id]);
                $ruanganData = DmUnitPenempatan::find()->where(['kode' => $model->unit_id])->one();
                $ruangan = $ruanganData->nama;
                $dokter = '';
            } elseif ($model->tipe_laporan == 'dokter') {
                $query = $query->andWhere(['analisa_dokumen.dokter_id' => $model->dokter_id]);
                $dokterData = TbPegawai::find()->where(['pegawai_id' => $model->dokter_id])->one();
                $ruangan = '';
                $dokter = HelperSpesialClass::getNamaPegawai($dokterData);
            }

            $query = $query->asArray()->all();


            $spreadsheet = new Spreadsheet();
            $spreadsheet->getProperties()->setCreator('SIMRS Farmasi - RSUD Arifin Achmad')
                ->setLastModifiedBy('SIMRS Farmasi - RSUD Arifin Achmad')
                ->setTitle('Laporan Pengadaan RSUD Arifin Achmad')
                ->setSubject('Laporan Pengadaan RSUD Arifin Achmad')
                ->setDescription('Dicetak dari SIMRS Farmasi RSUD Arifin Achmad')
                ->setKeywords('office 2007+ openxml php')
                ->setCategory('Laporan');

            $spreadsheet->getActiveSheet()->getPageSetup()
                ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
                ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL)
                ->setFitToWidth(0)
                ->setFitToHeight(0);

            // Start - Penulisan Data ke Excel
            // --------------------------------------------------------------------------

            $baseHeader = 1;

            $spreadsheet->getActiveSheet()
                ->setCellValue("A" . ($baseHeader), 'PEMERINTAH PROVINSI RIAU')
                ->setCellValue("A" . ($baseHeader + 1), 'RSUD ARIFIN ACHMAD')
                ->setCellValue("A" . ($baseHeader + 2), 'Jl. Diponegoro No. 2 Telp. (0761) - 23418, 21618, 21657 Fax. (0761) - 20253')
                ->setCellValue("A" . ($baseHeader + 3), 'KOTA PEKANBARU');
            $spreadsheet->getActiveSheet()->getStyle("A" . ($baseHeader))->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle("A" . ($baseHeader + 1))->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle("A" . ($baseHeader + 2))->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle("A" . ($baseHeader + 3))->getAlignment()->setHorizontal('center');

            $spreadsheet->getActiveSheet()
                ->mergeCells("A" . ($baseHeader) . ":L" . ($baseHeader))
                ->mergeCells("A" . ($baseHeader + 1) . ":L" . ($baseHeader + 1))
                ->mergeCells("A" . ($baseHeader + 2) . ":L" . ($baseHeader + 2))
                ->mergeCells("A" . ($baseHeader + 3) . ":L" . ($baseHeader + 3));
            // set logo
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setWorksheet($spreadsheet->getActiveSheet());
            $drawing->setPath(Url::to('@app/web/images/logo_riau.png'));
            $drawing->setCoordinates('A1');
            $drawing->setWidthAndHeight(158, 72);
            $drawing->setResizeProportional(true);
            $drawing->setOffsetX(10);    // this is how
            $drawing->setOffsetY(3);
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setWorksheet($spreadsheet->getActiveSheet());
            $drawing->setPath(Url::to('@app/web/images/rsud.png'));
            $drawing->setCoordinates('J1');
            $drawing->setWidthAndHeight(158, 72);
            $drawing->setResizeProportional(true);
            $drawing->setOffsetX(250);    // this is how
            $drawing->setOffsetY(3);
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setWorksheet($spreadsheet->getActiveSheet());
            $drawing->setPath(Url::to('@app/web/images/kars.png'));
            $drawing->setCoordinates('L1');
            $drawing->setWidthAndHeight(158, 72);
            $drawing->setResizeProportional(true);
            $drawing->setOffsetX(-20);    // this is how
            $drawing->setOffsetY(3);

            $baseRowTitle = $baseHeader + 5;

            $spreadsheet->getActiveSheet()
                ->mergeCells("A" . ($baseRowTitle) . ":L" . ($baseRowTitle));
            $spreadsheet->getActiveSheet()
                ->setCellValue("A{$baseRowTitle}", 'Laporan Analisa Data EMR ' . $jenisLaporan . ' ' . ($ruangan ?? '') . ($dokter ?? ''));
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRowTitle}")->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRowTitle}")->getFont()->setBold(true);

            $baseRowTitle++;

            $spreadsheet->getActiveSheet()
                ->mergeCells("A" . ($baseRowTitle) . ":L" . ($baseRowTitle));
            // $spreadsheet->getActiveSheet()
            //     ->setCellValue("A{$baseRowTitle}", $jenisLaporanKegiatan);
            // $baseRowTitle++;
            $spreadsheet->getActiveSheet()
                ->mergeCells("A" . ($baseRowTitle) . ":L" . ($baseRowTitle));
            $spreadsheet->getActiveSheet()
                ->setCellValue("A{$baseRowTitle}", $tglJudul);
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRowTitle}")->getAlignment()->setHorizontal('center');

            $baseRowTitle++;


            \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder(new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());
            $baseRowTitle++;
            $baseRowTable = $baseRowTitle + 1;
            $spreadsheet->getActiveSheet()
                ->mergeCells("A" . ($baseRowTable) . ":I" . ($baseRowTable + 1));
            $spreadsheet->getActiveSheet()
                ->mergeCells("J" . ($baseRowTable) . ":K" . ($baseRowTable));
            // $spreadsheet->getActiveSheet()
            //     ->mergeCells("L" . ($baseRowTable) . ":L" . ($baseRowTable + 1));

            $spreadsheet->getActiveSheet()
                ->getStyle("A" . ($baseRowTable) . ":L" . ($baseRowTable + 1))
                ->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            $spreadsheet->getActiveSheet()
                ->getStyle("A" . ($baseRowTable) . ":L" . ($baseRowTable + 1))
                ->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFFF00',
                        ],
                    ],
                    'font' => [
                        'size' => 11,
                        'bold' => true,
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
            $spreadsheet->getActiveSheet()
                ->setCellValue("A{$baseRowTable}", 'KRITERIA ANALISA');
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRowTable}")->getAlignment()->setHorizontal('center')->setVertical('center');
            $spreadsheet->getActiveSheet()
                ->setCellValue("J{$baseRowTable}", 'JUMLAH KELENGKAPAN');
            $spreadsheet->getActiveSheet()->getStyle("J{$baseRowTable}")->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()
                ->setCellValue("J" . ($baseRowTable + 1), 'BAIK');
            $spreadsheet->getActiveSheet()->getStyle("A" . ($baseRowTable + 1))->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()
                ->setCellValue("K" . ($baseRowTable + 1), 'TIDAK BAIK');
            $spreadsheet->getActiveSheet()
                ->setCellValue("L" . ($baseRowTable), 'PERSENTASE');
            $spreadsheet->getActiveSheet()
                ->setCellValue("L" . ($baseRowTable + 1), 'TIDAK BAIK');
            foreach (range('J', 'L') as $columnID) {
                $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                    ->setWidth('15');
            }

            $spreadsheet->getActiveSheet()->getStyle("L" . ($baseRowTable))->getAlignment()->setHorizontal('center')->setVertical('center');
            $baseRowTable++;

            $baseRow = $baseRowTable + 1;

            $no = 1;
            $jenis = [null, null];

            foreach ($analisaDokumen as $item) {

                if ($jenis[0] != $item['analisa_dokumen_jenis_id']) {
                    $jenis = [$item['analisa_dokumen_jenis_id'], $item['jenis_analisa']];
                    $spreadsheet->getActiveSheet()
                        ->mergeCells("A" . ($baseRow) . ":L" . ($baseRow));
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $baseRow, $item['jenis_analisa']);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $baseRow)->getAlignment()->setWrapText(false);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $baseRow)->getFont()->setBold(true);
                    $baseRow++;
                }
                if ($item['item_analisa_tipe'] == 1) {
                    $spreadsheet->getActiveSheet()
                        ->mergeCells("A" . ($baseRow) . ":I" . ($baseRow));
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $baseRow, $no . ". " . $item['item_uraian']);
                    // $spreadsheet->getActiveSheet()
                    //     ->mergeCells("J" . ($baseRow) . ":K" . ($baseRow));
                    $spreadsheet->getActiveSheet()->getStyle('J' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                    $spreadsheet->getActiveSheet()->getStyle('K' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                    $spreadsheet->getActiveSheet()->getStyle('L' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('J' . $baseRow, $item['ada']);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('K' . $baseRow, $item['tidak_ada']);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('L' . $baseRow, sprintf("%.2f%%", ($item['tidak_ada'] / $item['jumlah_dokumen']) * 100));
                    // ->setCellValue('C' . $baseRow, $item->no_sp)
                    // ->setCellValue('D' . $baseRow, $item->supplier->nama_supplier ?? '-')
                    // ->setCellValue('E' . $baseRow, $item->tipe_pembelian)
                    // ->setCellValue('L' . $baseRow, $item->total);

                } else {
                    $spreadsheet->getActiveSheet()
                        ->mergeCells("A" . ($baseRow) . ":I" . ($baseRow));
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $baseRow, $no . ". " . $item['item_uraian']);
                    $spreadsheet->getActiveSheet()->getStyle('J' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                    $spreadsheet->getActiveSheet()->getStyle('K' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                    $spreadsheet->getActiveSheet()->getStyle('L' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');

                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('J' . $baseRow, $item['lengkap']);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('K' . $baseRow, ($item['tidak_lengkap'] + $item['tidak_ada']));
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('L' . $baseRow, sprintf("%.2f%%", (($item['tidak_lengkap'] + $item['tidak_ada']) / $item['jumlah_dokumen']) * 100));
                    // ->setCellValue('C' . $baseRow, $item->no_sp)
                    // ->setCellValue('D' . $baseRow, $item->supplier->nama_supplier ?? '-')
                    // ->setCellValue('E' . $baseRow, $item->tipe_pembelian)
                    // ->setCellValue('L' . $baseRow, $item->total);
                }
                $baseRowItem = $baseRow;
                $baseRowItem++;
                $baseRow = $baseRowItem;
                $no++;
            }
            $spreadsheet->getActiveSheet()
                ->mergeCells("A" . ($baseRow) . ":I" . ($baseRow));
            $spreadsheet->getActiveSheet()
                ->mergeCells("J" . ($baseRow) . ":L" . ($baseRow));
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRow}")->getAlignment()->setHorizontal('center')->setVertical('center');
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRow}")->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle("J{$baseRow}")->getAlignment()->setHorizontal('center')->setVertical('center');
            $spreadsheet->getActiveSheet()->getStyle("J{$baseRow}")->getFont()->setBold(true);
            // return json_encode($query[0]['jumlah_dokumen']);
            $spreadsheet->getActiveSheet()
                ->setCellValue("A{$baseRow}", 'Total')
                ->setCellValue("J{$baseRow}", $query[0]['jumlah_dokumen'] . " Dokumen");


            $spreadsheet->getActiveSheet()
                ->getStyle("A{$baseRowTable}:L{$baseRow}")
                ->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            $spreadsheet->setActiveSheetIndex(0);

            // Redirect output to a client’s web browser (Xlsx)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan Analisa EMR ' . $jenisLaporan . ' ' . $tglJudul . '.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit(); // -> agar file tidak corrupt


        }
    }

    public function actionCetakLaporanCoder()
    {
        $model = new LaporanCoder();

        if ($model->load(Yii::$app->request->post())) {

            $analisaDokumen = AnalisaDokumenDetail::find()
                ->select([
                    'count(analisa_dokumen.analisa_dokumen_id) as jumlah_dokumen',
                    'master_jenis_analisa.jenis_analisa_uraian as jenis_analisa',
                    'master_item_analisa.item_analisa_uraian as item_uraian',
                    'master_item_analisa.item_analisa_tipe',
                    'analisa_dokumen_detail.analisa_dokumen_item_id',
                    'analisa_dokumen_detail.analisa_dokumen_jenis_id',
                    'analisa_dokumen_detail.analisa_dokumen_jenis_analisa_detail_id',
                    'COUNT(analisa_dokumen_detail.analisa_dokumen_kelengkapan) filter (where analisa_dokumen_detail.analisa_dokumen_kelengkapan = 0) as tidak_ada',
                    'COUNT(analisa_dokumen_detail.analisa_dokumen_kelengkapan) filter (where analisa_dokumen_detail.analisa_dokumen_kelengkapan = 1) as tidak_lengkap',
                    'COUNT(analisa_dokumen_detail.analisa_dokumen_kelengkapan) filter (where analisa_dokumen_detail.analisa_dokumen_kelengkapan = 2) as lengkap',
                    'COUNT(analisa_dokumen_detail.analisa_dokumen_kelengkapan) filter (where analisa_dokumen_detail.analisa_dokumen_kelengkapan = 3) as ada'

                ])
                ->innerJoin('analisa_dokumen', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->innerJoin(Registrasi::tableName(), Registrasi::tableName() . '.kode=analisa_dokumen.reg_kode')
                ->innerJoin('master_item_analisa', 'master_item_analisa.item_analisa_id=analisa_dokumen_detail.analisa_dokumen_item_id')
                ->innerJoin('master_jenis_analisa', 'analisa_dokumen_detail.analisa_dokumen_jenis_id=master_jenis_analisa.jenis_analisa_id')
                ->innerJoin('master_jenis_analisa_detail', 'master_jenis_analisa_detail.jenis_analisa_detail_id=analisa_dokumen_detail.analisa_dokumen_jenis_analisa_detail_id');
            // ->where(['analisa_dokumen.dokter_id'=>'38'])

            $dataLaporan = CodingPelaporanRj::find();

            if ($model->jenis_laporan == AnalisaDokumen::JENIS_HARIAN) {
                $jenisLaporan = 'Harian';
                $tglJudul = Yii::$app->formatter->asDate($model->tgl_hari);
                $analisaDokumen = $analisaDokumen
                    ->andWhere(['=', Registrasi::tableName() . '.tgl_keluar', $model->tgl_hari]);
            } else if ($model->jenis_laporan == AnalisaDokumen::JENIS_BULANAN) {
                $jenisLaporan = 'Bulanan';
                $tglJudul = $model->tgl_bulan;
                $analisaDokumen = $analisaDokumen
                    ->andWhere(['=', new Expression("to_char(" . Registrasi::tableName() . '.tgl_keluar' . ", 'MM-YYYY')"), $model->tgl_bulan]);
            } else if ($model->jenis_laporan == AnalisaDokumen::JENIS_TAHUNAN) {
                $jenisLaporan = 'Tahunan';
                $tglJudul = $model->tgl_tahun;
                $analisaDokumen = $analisaDokumen
                    ->andWhere(['=', new Expression("to_char(" . Registrasi::tableName() . '.tgl_keluar' . ", 'YYYY')"), $model->tgl_tahun]);
            }
            $ruangan = '';
            $dokter = '';
            if ($model->tipe_laporan == 'ruangan') {
                $analisaDokumen = $analisaDokumen->andWhere(['analisa_dokumen.unit_id' => $model->unit_id]);
                $ruanganData = DmUnitPenempatan::find()->where(['kode' => $model->unit_id])->one();
                $ruangan = $ruanganData->nama;
                $dokter = '';
            } elseif ($model->tipe_laporan == 'dokter') {
                $analisaDokumen = $analisaDokumen->andWhere(['analisa_dokumen.dokter_id' => $model->dokter_id]);
                $dokterData = TbPegawai::find()->where(['pegawai_id' => $model->dokter_id])->one();
                $ruangan = '';
                $dokter = HelperSpesialClass::getNamaPegawai($dokterData);
            }
            // $analisaDokumen->andWhere(['=', new Expression("to_char(analisa_dokumen.created_at, 'MM-YYYY')"), '11-2022']);
            // ->andWhere(['>', new Expression('date (' . AnalisaDokumenDetail::tableName() . '.created_at)'), '2022-11-17'])
            $analisaDokumen = $analisaDokumen->groupBy([
                'analisa_dokumen_detail.analisa_dokumen_item_id',
                'analisa_dokumen_detail.analisa_dokumen_jenis_id',
                'master_item_analisa.item_analisa_id',

                'analisa_dokumen_detail.analisa_dokumen_jenis_analisa_detail_id',
                'master_jenis_analisa.jenis_analisa_uraian'
            ])
                ->orderBy('analisa_dokumen_detail.analisa_dokumen_jenis_id')
                ->asArray()->all();

            $query = AnalisaDokumenDetail::find()
                ->select([
                    'count(distinct analisa_dokumen.analisa_dokumen_id) as jumlah_dokumen',
                ])
                ->innerJoin('analisa_dokumen', 'analisa_dokumen_detail.analisa_dokumen_id=analisa_dokumen.analisa_dokumen_id')
                ->innerJoin(Registrasi::tableName(), Registrasi::tableName() . '.kode=analisa_dokumen.reg_kode')
                ->innerJoin('master_item_analisa', 'master_item_analisa.item_analisa_id=analisa_dokumen_detail.analisa_dokumen_item_id')
                ->innerJoin('master_jenis_analisa', 'analisa_dokumen_detail.analisa_dokumen_jenis_id=master_jenis_analisa.jenis_analisa_id')
                ->innerJoin('master_jenis_analisa_detail', 'master_jenis_analisa_detail.jenis_analisa_detail_id=analisa_dokumen_detail.analisa_dokumen_jenis_analisa_detail_id');
            // ->where(['analisa_dokumen.dokter_id'=>'38'])

            if ($model->jenis_laporan == AnalisaDokumen::JENIS_HARIAN) {
                $jenisLaporan = 'Harian';
                $tglJudul = Yii::$app->formatter->asDate($model->tgl_hari);
                $query = $query
                    ->andWhere(['=', Registrasi::tableName() . '.tgl_keluar', $model->tgl_hari]);
            } else if ($model->jenis_laporan == AnalisaDokumen::JENIS_BULANAN) {
                $jenisLaporan = 'Bulanan';
                $tglJudul = $model->tgl_bulan;
                $query = $query
                    ->andWhere(['=', new Expression("to_char(" . Registrasi::tableName() . '.tgl_keluar' . ", 'MM-YYYY')"), $model->tgl_bulan]);
            } else if ($model->jenis_laporan == AnalisaDokumen::JENIS_TAHUNAN) {
                $jenisLaporan = 'Tahunan';
                $tglJudul = $model->tgl_tahun;
                $query = $query
                    ->andWhere(['=', new Expression("to_char(" . Registrasi::tableName() . '.tgl_keluar' . ", 'YYYY')"), $model->tgl_tahun]);
            }
            $ruangan = '';
            $dokter = '';
            if ($model->tipe_laporan == 'ruangan') {
                $query = $query->andWhere(['analisa_dokumen.unit_id' => $model->unit_id]);
                $ruanganData = DmUnitPenempatan::find()->where(['kode' => $model->unit_id])->one();
                $ruangan = $ruanganData->nama;
                $dokter = '';
            } elseif ($model->tipe_laporan == 'dokter') {
                $query = $query->andWhere(['analisa_dokumen.dokter_id' => $model->dokter_id]);
                $dokterData = TbPegawai::find()->where(['pegawai_id' => $model->dokter_id])->one();
                $ruangan = '';
                $dokter = HelperSpesialClass::getNamaPegawai($dokterData);
            }

            $query = $query->asArray()->all();


            $spreadsheet = new Spreadsheet();
            $spreadsheet->getProperties()->setCreator('SIMRS Farmasi - RSUD Arifin Achmad')
                ->setLastModifiedBy('SIMRS Farmasi - RSUD Arifin Achmad')
                ->setTitle('Laporan Pengadaan RSUD Arifin Achmad')
                ->setSubject('Laporan Pengadaan RSUD Arifin Achmad')
                ->setDescription('Dicetak dari SIMRS Farmasi RSUD Arifin Achmad')
                ->setKeywords('office 2007+ openxml php')
                ->setCategory('Laporan');

            $spreadsheet->getActiveSheet()->getPageSetup()
                ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
                ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL)
                ->setFitToWidth(0)
                ->setFitToHeight(0);

            // Start - Penulisan Data ke Excel
            // --------------------------------------------------------------------------

            $baseHeader = 1;

            $spreadsheet->getActiveSheet()
                ->setCellValue("A" . ($baseHeader), 'PEMERINTAH PROVINSI RIAU')
                ->setCellValue("A" . ($baseHeader + 1), 'RSUD ARIFIN ACHMAD')
                ->setCellValue("A" . ($baseHeader + 2), 'Jl. Diponegoro No. 2 Telp. (0761) - 23418, 21618, 21657 Fax. (0761) - 20253')
                ->setCellValue("A" . ($baseHeader + 3), 'KOTA PEKANBARU');
            $spreadsheet->getActiveSheet()->getStyle("A" . ($baseHeader))->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle("A" . ($baseHeader + 1))->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle("A" . ($baseHeader + 2))->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle("A" . ($baseHeader + 3))->getAlignment()->setHorizontal('center');

            $spreadsheet->getActiveSheet()
                ->mergeCells("A" . ($baseHeader) . ":L" . ($baseHeader))
                ->mergeCells("A" . ($baseHeader + 1) . ":L" . ($baseHeader + 1))
                ->mergeCells("A" . ($baseHeader + 2) . ":L" . ($baseHeader + 2))
                ->mergeCells("A" . ($baseHeader + 3) . ":L" . ($baseHeader + 3));
            // set logo
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setWorksheet($spreadsheet->getActiveSheet());
            $drawing->setPath(Url::to('@app/web/images/logo_riau.png'));
            $drawing->setCoordinates('A1');
            $drawing->setWidthAndHeight(158, 72);
            $drawing->setResizeProportional(true);
            $drawing->setOffsetX(10);    // this is how
            $drawing->setOffsetY(3);
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setWorksheet($spreadsheet->getActiveSheet());
            $drawing->setPath(Url::to('@app/web/images/rsud.png'));
            $drawing->setCoordinates('J1');
            $drawing->setWidthAndHeight(158, 72);
            $drawing->setResizeProportional(true);
            $drawing->setOffsetX(250);    // this is how
            $drawing->setOffsetY(3);
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setWorksheet($spreadsheet->getActiveSheet());
            $drawing->setPath(Url::to('@app/web/images/kars.png'));
            $drawing->setCoordinates('L1');
            $drawing->setWidthAndHeight(158, 72);
            $drawing->setResizeProportional(true);
            $drawing->setOffsetX(-20);    // this is how
            $drawing->setOffsetY(3);

            $baseRowTitle = $baseHeader + 5;

            $spreadsheet->getActiveSheet()
                ->mergeCells("A" . ($baseRowTitle) . ":L" . ($baseRowTitle));
            $spreadsheet->getActiveSheet()
                ->setCellValue("A{$baseRowTitle}", 'Laporan Analisa Data EMR ' . $jenisLaporan . ' ' . ($ruangan ?? '') . ($dokter ?? ''));
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRowTitle}")->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRowTitle}")->getFont()->setBold(true);

            $baseRowTitle++;

            $spreadsheet->getActiveSheet()
                ->mergeCells("A" . ($baseRowTitle) . ":L" . ($baseRowTitle));
            // $spreadsheet->getActiveSheet()
            //     ->setCellValue("A{$baseRowTitle}", $jenisLaporanKegiatan);
            // $baseRowTitle++;
            $spreadsheet->getActiveSheet()
                ->mergeCells("A" . ($baseRowTitle) . ":L" . ($baseRowTitle));
            $spreadsheet->getActiveSheet()
                ->setCellValue("A{$baseRowTitle}", $tglJudul);
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRowTitle}")->getAlignment()->setHorizontal('center');

            $baseRowTitle++;


            \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder(new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());
            $baseRowTitle++;
            $baseRowTable = $baseRowTitle + 1;
            $spreadsheet->getActiveSheet()
                ->mergeCells("A" . ($baseRowTable) . ":I" . ($baseRowTable + 1));
            $spreadsheet->getActiveSheet()
                ->mergeCells("J" . ($baseRowTable) . ":K" . ($baseRowTable));
            // $spreadsheet->getActiveSheet()
            //     ->mergeCells("L" . ($baseRowTable) . ":L" . ($baseRowTable + 1));

            $spreadsheet->getActiveSheet()
                ->getStyle("A" . ($baseRowTable) . ":L" . ($baseRowTable + 1))
                ->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            $spreadsheet->getActiveSheet()
                ->getStyle("A" . ($baseRowTable) . ":L" . ($baseRowTable + 1))
                ->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFFF00',
                        ],
                    ],
                    'font' => [
                        'size' => 11,
                        'bold' => true,
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
            $spreadsheet->getActiveSheet()
                ->setCellValue("A{$baseRowTable}", 'KRITERIA ANALISA');
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRowTable}")->getAlignment()->setHorizontal('center')->setVertical('center');
            $spreadsheet->getActiveSheet()
                ->setCellValue("J{$baseRowTable}", 'JUMLAH KELENGKAPAN');
            $spreadsheet->getActiveSheet()->getStyle("J{$baseRowTable}")->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()
                ->setCellValue("J" . ($baseRowTable + 1), 'BAIK');
            $spreadsheet->getActiveSheet()->getStyle("A" . ($baseRowTable + 1))->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()
                ->setCellValue("K" . ($baseRowTable + 1), 'TIDAK BAIK');
            $spreadsheet->getActiveSheet()
                ->setCellValue("L" . ($baseRowTable), 'PERSENTASE');
            $spreadsheet->getActiveSheet()
                ->setCellValue("L" . ($baseRowTable + 1), 'TIDAK BAIK');
            foreach (range('J', 'L') as $columnID) {
                $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                    ->setWidth('15');
            }

            $spreadsheet->getActiveSheet()->getStyle("L" . ($baseRowTable))->getAlignment()->setHorizontal('center')->setVertical('center');
            $baseRowTable++;

            $baseRow = $baseRowTable + 1;

            $no = 1;
            $jenis = [null, null];

            foreach ($analisaDokumen as $item) {

                if ($jenis[0] != $item['analisa_dokumen_jenis_id']) {
                    $jenis = [$item['analisa_dokumen_jenis_id'], $item['jenis_analisa']];
                    $spreadsheet->getActiveSheet()
                        ->mergeCells("A" . ($baseRow) . ":L" . ($baseRow));
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $baseRow, $item['jenis_analisa']);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $baseRow)->getAlignment()->setWrapText(false);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $baseRow)->getFont()->setBold(true);
                    $baseRow++;
                }
                if ($item['item_analisa_tipe'] == 1) {
                    $spreadsheet->getActiveSheet()
                        ->mergeCells("A" . ($baseRow) . ":I" . ($baseRow));
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $baseRow, $no . ". " . $item['item_uraian']);
                    // $spreadsheet->getActiveSheet()
                    //     ->mergeCells("J" . ($baseRow) . ":K" . ($baseRow));
                    $spreadsheet->getActiveSheet()->getStyle('J' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                    $spreadsheet->getActiveSheet()->getStyle('K' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                    $spreadsheet->getActiveSheet()->getStyle('L' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('J' . $baseRow, $item['ada']);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('K' . $baseRow, $item['tidak_ada']);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('L' . $baseRow, sprintf("%.2f%%", ($item['tidak_ada'] / $item['jumlah_dokumen']) * 100));
                    // ->setCellValue('C' . $baseRow, $item->no_sp)
                    // ->setCellValue('D' . $baseRow, $item->supplier->nama_supplier ?? '-')
                    // ->setCellValue('E' . $baseRow, $item->tipe_pembelian)
                    // ->setCellValue('L' . $baseRow, $item->total);

                } else {
                    $spreadsheet->getActiveSheet()
                        ->mergeCells("A" . ($baseRow) . ":I" . ($baseRow));
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $baseRow, $no . ". " . $item['item_uraian']);
                    $spreadsheet->getActiveSheet()->getStyle('J' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                    $spreadsheet->getActiveSheet()->getStyle('K' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                    $spreadsheet->getActiveSheet()->getStyle('L' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');

                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('J' . $baseRow, $item['lengkap']);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('K' . $baseRow, ($item['tidak_lengkap'] + $item['tidak_ada']));
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('L' . $baseRow, sprintf("%.2f%%", (($item['tidak_lengkap'] + $item['tidak_ada']) / $item['jumlah_dokumen']) * 100));
                    // ->setCellValue('C' . $baseRow, $item->no_sp)
                    // ->setCellValue('D' . $baseRow, $item->supplier->nama_supplier ?? '-')
                    // ->setCellValue('E' . $baseRow, $item->tipe_pembelian)
                    // ->setCellValue('L' . $baseRow, $item->total);
                }
                $baseRowItem = $baseRow;
                $baseRowItem++;
                $baseRow = $baseRowItem;
                $no++;
            }
            $spreadsheet->getActiveSheet()
                ->mergeCells("A" . ($baseRow) . ":I" . ($baseRow));
            $spreadsheet->getActiveSheet()
                ->mergeCells("J" . ($baseRow) . ":L" . ($baseRow));
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRow}")->getAlignment()->setHorizontal('center')->setVertical('center');
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRow}")->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle("J{$baseRow}")->getAlignment()->setHorizontal('center')->setVertical('center');
            $spreadsheet->getActiveSheet()->getStyle("J{$baseRow}")->getFont()->setBold(true);
            // return json_encode($query[0]['jumlah_dokumen']);
            $spreadsheet->getActiveSheet()
                ->setCellValue("A{$baseRow}", 'Total')
                ->setCellValue("J{$baseRow}", $query[0]['jumlah_dokumen'] . " Dokumen");


            $spreadsheet->getActiveSheet()
                ->getStyle("A{$baseRowTable}:L{$baseRow}")
                ->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            $spreadsheet->setActiveSheetIndex(0);

            // Redirect output to a client’s web browser (Xlsx)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan Analisa EMR ' . $jenisLaporan . ' ' . $tglJudul . '.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit(); // -> agar file tidak corrupt


        }
    }
    public function actionPreviewLaporanAnastesi($id)
    {
        $model = AsesmenPraInduksi::find()->where(['api_id' => $id])->andWhere('api_deleted_at is null')->one();

        $timoperasi = TimOperasi::find()->where(['to_id' => $model->api_to_id])->all();
        // $timoperasidetail = TimOperasiDetail::find()->where(['tod_to_id' => $model->lap_op_to_id])->all();
        $layanan = Layanan::find()->joinWith(['registrasi' => function ($q) {
            $q->joinWith(['pasien']);
        }])->where(['in', 'id', $timoperasi[0]->to_ok_pl_id])->one();

        $detail = TimOperasiDetail::find()->where(['tod_to_id' => $model->api_to_id, 'tod_jo_id' => 2])->all();

        $pasien = Pasien::find()->where(['kode' => $layanan->registrasi->pasien->kode])->one();

        return $this->renderAjax('laporan-anastesi', [
            'model' => $model,
            'timoperasi' => $timoperasi,
            'pasien' => $pasien,
            'detail' => $detail

        ]);
    }

    function actionDetailKonsultasi()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $id = $req->post('id');
            $data = PermintaanKonsultasi::find()->joinWith([
                'dokterMinta',
                'layananMinta' => function ($q) {
                    $q->joinWith(['unit']);
                },
                'unitTujuan', 'dokterTujuan',
                'jawabanKonsultasi' => function ($q) {
                    $q->joinWith([
                        'dokterJawab',
                        'layananJawab' => function ($q) {
                            $q->joinWith(['unit']);
                        }
                    ]);
                }
            ])->where([PermintaanKonsultasi::tableName() . '.id' => $id])->asArray()->limit(1)->one();
            return $this->renderAjax('konsultasi_detail', [
                'data' => $data,
            ]);
        }
    }
    function actionDetailResep()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $id = $req->post('id');
            $data = Resep::find()->joinWith([
                'resepDetail' => function ($q) {
                    $q->joinWith(['obat']);
                }, 'layanan', 'depo', 'dokter'
            ])->where([Resep::tableName() . '.id' => $id])->asArray()->limit(1)->one();
            return $this->renderAjax('resep_detail', [
                'data' => $data,
            ]);
        }
    }
    function actionDetailSbpk()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $id = $req->post('id');

            $pasien = Registrasi::find()->joinWith(['pasien'])->where([Registrasi::tableName() . '.kode' => $id])->asArray()->limit(1)->one();
            //echo "<pre>"; print_r($registrasi); exit;
            $data = Registrasi::find()->joinWith([
                'layanan.unit', 'layanan.pjp.pegawai', 'layanan.icd10pasien', 'layanan.icd9pasien', 'layanan.reseppasien.resepDetail.obat'
            ])
                ->andWhere([Registrasi::tableName() . '.kode' => $id])
                ->orderBy([Layanan::tableName() . '.tgl_masuk' => SORT_ASC])->asArray()->one();
            return $this->renderAjax('sbpk_detail', [
                'data' => $data,
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
    public function actionCetakResumeMedisDokterVerifikatorRj()
    {
        ini_set("pcre.backtrack_limit", "5000000000");
        $req = Yii::$app->request;
        $id = $req->get('id');

        $kodePasien = $req->get('pasien');
        $pasien = Pasien::find()->joinWith([
            'registrasi' => function ($q) {
                $q->joinWith(['layanan']);
            }
        ])->where(['pasien.kode' => $kodePasien])->limit(1)->one();
        $resume = ResumeMedisRjClaim::find()->joinWith(['dokterVerifikator', 'unitTujuan', 'layanan' => function ($q) {
            $q->joinWith(['unit', 'registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where([ResumeMedisRjClaim::tableName() . '.id' => $id])->orderBy(['created_at' => SORT_DESC])->one();





        $title = 'Resume Dokter Verifikator';
        $orientasi = 'LEGAL-P';

        $fontUrl = \Yii::getAlias('@app') . DIRECTORY_SEPARATOR . "font";
        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'fontDir' => [
                $fontUrl
            ],
            'fontdata' => [
                'sanserif' => [
                    'R' => 'sanserif.ttf',
                ]
            ],
            'default_font' => 'sanserif',
            'default_font_size' => 10,
        ]);

        $pdf->SetTitle($title);
        $html = $this->renderPartial('sbpk_detail_verifikator', [
            'resume' => $resume,
            'pasien' => $pasien,
        ]);

        $pdf->AddPageByArray([
            'margin-left' => 5,
            'margin-top' => 5,
            'margin-right' => 5,
            'margin-bottom' => 15,
            'sheet-size' => $orientasi,
        ]);

        $pdf->shrink_tables_to_fit = 1;

        $pdf->WriteHTML($html);



        $pdf->Output("{$title}.pdf", 'I');
    }

    public function actionCetakResumeMedisDokterVerifikatorRi()
    {
        ini_set("pcre.backtrack_limit", "5000000000");
        $req = Yii::$app->request;
        $id = $req->get('id');

        $kodePasien = $req->get('pasien');
        $pasien = Pasien::find()->joinWith([
            'registrasi' => function ($q) {
                $q->joinWith(['layanan']);
            }
        ])->where(['pasien.kode' => $kodePasien])->limit(1)->one();
        $asesmen = ResumeMedisRiClaim::find()->joinWith(['dokter', 'dokterVerifikator', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['pengolahan_data.resume_medis_ri_claim.id' => $id])->one();

        $pasien = Pasien::find()->where(['kode' => $kodePasien])->one();




        $title = 'Resume Dokter Verifikator';
        $orientasi = 'LEGAL-P';

        $fontUrl = \Yii::getAlias('@app') . DIRECTORY_SEPARATOR . "font";
        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'fontDir' => [
                $fontUrl
            ],
            'fontdata' => [
                'sanserif' => [
                    'R' => 'sanserif.ttf',
                ]
            ],
            'default_font' => 'sanserif',
            'default_font_size' => 10,
        ]);

        $pdf->SetTitle($title);
        $html = $this->renderPartial('resume-medis-verifikator', ['asesmen' => $asesmen, 'pasien' => $pasien]);

        $pdf->AddPageByArray([
            'margin-left' => 5,
            'margin-top' => 5,
            'margin-right' => 5,
            'margin-bottom' => 15,
            'sheet-size' => $orientasi,
        ]);

        $pdf->shrink_tables_to_fit = 1;

        $pdf->WriteHTML($html);



        $pdf->Output("{$title}.pdf", 'I');
    }
    public function actionListRawatInapKembali()
    {
        $req = Yii::$app->request;
        $searchModel = new RegistrasiSearch();
        $layanan = Layanan::find()->orderBy(['created_at' => SORT_DESC]);
        $queryData = Registrasi::find()
            ->select(['array_agg(layanan.jenis_layanan) as jenis', 'registrasi.kode'])
            ->innerJoin(['layanan' => $layanan], 'layanan.registrasi_kode=registrasi.kode and layanan.deleted_at is null')
            ->where('layanan.unit_tujuan_kode is null');
        if (!empty($req->get('RegistrasiSearch')['tgl_awal'])) {
            $queryData = $queryData->andWhere(['>=', 'registrasi.tgl_keluar', $req->get('RegistrasiSearch')['tgl_awal'] . ' 00:00:00']);
        } else {
            $queryData = $queryData->andWhere(['>=', 'registrasi.tgl_keluar', date('Y-m-d') . ' 00:00:00']);
        }
        if (!empty($req->get('RegistrasiSearch')['tgl_akhir'])) {
            $queryData = $queryData->andWhere(['<=', 'registrasi.tgl_keluar', $req->get('RegistrasiSearch')['tgl_akhir'] . ' 23:59:59']);
        } else {
            $queryData = $queryData->andWhere(['<=', 'registrasi.tgl_keluar', date('Y-m-d') . ' 23:59:59']);
        }

        $queryData = $queryData->andWhere('registrasi.deleted_at is Null')
            ->groupBy('registrasi.kode');

        $queryDataTest = (new \yii\db\Query())
            ->select([
                'registrasi.kode',
                'registrasi.pasien_kode',
                'pasien.nama',
                'registrasi.tgl_masuk',
                'registrasi.tgl_keluar',
                'array_agg(dm_unit_penempatan.nama) as poli',
                'registrasi.is_analisa',

            ])
            ->from('ranap')
            ->withQuery($queryData, 'ranap', true)
            ->innerJoin("pendaftaran.registrasi", "registrasi.kode=ranap.kode and jenis::text like '%3%'")
            ->innerJoin(['layanan' => $layanan], "layanan.registrasi_kode=ranap.kode and layanan.jenis_layanan in ('1','3') and layanan.deleted_by is null")

            ->innerJoin("pendaftaran.pasien", "registrasi.pasien_kode=pasien.kode")
            ->innerJoin("pegawai.dm_unit_penempatan", "dm_unit_penempatan.kode=layanan.unit_kode")
            ->where(['not', ['registrasi.tgl_keluar' => null]]);
        if (isset($req->get('RegistrasiSearch')['pasien'])) {
            if (!empty($req->get('RegistrasiSearch')['pasien'])) {
                $queryDataTest = $queryDataTest->andWhere([
                    'or',
                    ['ilike', 'pasien.nama', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'pasien.kode', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'registrasi.kode', $req->get('RegistrasiSearch')['pasien']]
                    // ]
                ]);
            }
        }
        if (isset($req->get('RegistrasiSearch')['is_analisa'])) {
            if ($req->get('RegistrasiSearch')['is_analisa'] == '1' || $req->get('RegistrasiSearch')['is_analisa'] == '0') {
                $queryDataTest = $queryDataTest->andWhere(['registrasi.is_analisa' => $req->get('RegistrasiSearch')['is_analisa']]);
            }
        }
        // ->andWhere(['in','layanan.jenis'])
        $queryDataTest = $queryDataTest->groupBy(['registrasi.kode', 'pasien.nama'])
            ->createCommand()->rawSql;
        $queryDataCount = (new \yii\db\Query())
            ->select([
                'count(distinct registrasi.kode)'

            ])
            ->from('ranap')
            ->withQuery($queryData, 'ranap', true)
            ->innerJoin("pendaftaran.registrasi", "registrasi.kode=ranap.kode and jenis::text like '%3%'")
            ->innerJoin("pendaftaran.layanan", "layanan.registrasi_kode=ranap.kode and layanan.jenis_layanan in ('1','3') and layanan.deleted_by is null")

            ->innerJoin("pendaftaran.pasien", "registrasi.pasien_kode=pasien.kode")
            ->innerJoin("pegawai.dm_unit_penempatan", "dm_unit_penempatan.kode=layanan.unit_kode")
            ->leftJoin("medis.resume_medis_ri", "resume_medis_ri.layanan_id=layanan.id")
            ->where(['not', ['registrasi.tgl_keluar' => null]]);
        if (isset($req->get('RegistrasiSearch')['pasien'])) {

            if (!empty($req->get('RegistrasiSearch')['pasien'])) {
                $queryDataCount = $queryDataCount->andWhere([
                    'or',
                    ['ilike', 'pasien.nama', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'pasien.kode', $req->get('RegistrasiSearch')['pasien']],
                    ['ilike', 'registrasi.kode', $req->get('RegistrasiSearch')['pasien']]
                ]);
            }
        }
        if (isset($req->get('RegistrasiSearch')['is_analisa'])) {

            if ($req->get('RegistrasiSearch')['is_analisa'] == '1' || $req->get('RegistrasiSearch')['is_analisa'] == '0') {
                $queryDataCount = $queryDataCount->andWhere(['registrasi.is_analisa' => $req->get('RegistrasiSearch')['is_analisa']]);
            }
        }
        // ->groupBy(['registrasi.kode', 'pasien.nama'])


        $queryDataCount = $queryDataCount->createCommand()->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $queryDataTest,
            'totalCount' => $queryDataCount,
            'pagination' => [
                'pageSize' => 10,
                'totalCount' => $queryDataCount,
            ],
        ]);
        $model = $dataProvider->getModels();

        return $this->render('index-ri-kembali', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDataCoderRawatJalan()
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
                "registrasi.is_pelaporan as pelaporan"

            ])
            ->from("ranap")
            ->withQuery($queryData, "ranap", true)
            ->innerJoin("pendaftaran.registrasi", "registrasi.kode=ranap.kode and jenis::text not like '%3%'")
            ->innerJoin("pendaftaran.layanan", "layanan.registrasi_kode=ranap.kode and layanan.jenis_layanan in (2)")

            ->innerJoin("pendaftaran.pasien", "registrasi.pasien_kode=pasien.kode")
            ->innerJoin("medis.resume_medis_rj rmrj", "rmrj.layanan_id=layanan.id")



            ->innerJoin("pegawai.dm_unit_penempatan", "dm_unit_penempatan.kode=layanan.unit_kode");
        // if (isset($req->get("RegistrasiSearch")["pasien"])) {


        //     if (!empty($req->get("RegistrasiSearch")["pasien"])) {
        //         $queryDataTest = $queryDataTest->andWhere([
        //             "or",
        //             ["ilike", "pasien.nama", $req->get("RegistrasiSearch")["pasien"]],
        //             ["ilike", "pasien.kode", $req->get("RegistrasiSearch")["pasien"]],
        //             ["ilike", "registrasi.kode", $req->get("RegistrasiSearch")["pasien"]]
        //             // ]
        //         ]);
        //     }
        // }

        if ($req['claim'] != null) {
            if ($req['claim'] == 1) {
                $queryData = $queryData->andWhere(["registrasi.is_claim" => 1]);
            } elseif ($req['claim'] == 0) {
                $queryData = $queryData->andWhere(["registrasi.is_claim" => 0]);
            }
        }

        if ($req['pelaporan'] != null) {
            if ($req['pelaporan'] == 1) {
                $queryData = $queryData->andWhere(["registrasi.is_pelaporan" => 1]);
            } elseif ($req['pelaporan'] == 0) {
                $queryData = $queryData->andWhere(["registrasi.is_pelaporan" => 0]);
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


    public function actionDataLaporanCoderRawatJalan()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request->post("datatables");
        $queryData = CodingPelaporanRj::find()->select(['count(coding_pelaporan_rj.registrasi_kode)', 'tb_pegawai.pegawai_id', 'tb_pegawai.id_nip_nrp', 'tb_pegawai.nama_lengkap'])
            ->innerJoin([Registrasi::tableName()], 'coding_pelaporan_rj.registrasi_kode=registrasi.kode')
            ->innerJoin([TbPegawai::tableName()], 'coding_pelaporan_rj.pegawai_coder_id=tb_pegawai.pegawai_id')
            ->where(['in', 'pegawai_coder_id', HelperSpesialClass::isCoderUser()])->groupBy(['tb_pegawai.pegawai_id', 'tb_pegawai.nama_lengkap']);
        if ($req['tanggal_awal'] != null) {
            $queryData = $queryData->andWhere([">=", Registrasi::tableName() . ".tgl_masuk", $req['tanggal_awal'] . " 00:00:00"]);
        } else {
            $queryData = $queryData->andWhere([">=", Registrasi::tableName() . ".tgl_masuk", date('Y-m-d') . " 00:00:00"]);
        }
        if ($req['tanggal_akhir'] != null) {
            $queryData = $queryData->andWhere(["<=", Registrasi::tableName() . ".tgl_masuk", $req['tanggal_akhir'] . " 23:59:59"]);
        } else {
            $queryData = $queryData->andWhere(["<=", Registrasi::tableName() . ".tgl_masuk", date('Y-m-d') . " 23:59:59"]);
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
