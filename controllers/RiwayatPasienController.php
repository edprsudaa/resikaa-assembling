<?php

namespace app\controllers;

use app\components\Api;
use app\components\HelperSpesialClass;
use app\components\MakeResponse;
use app\components\Mdcp;
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
use app\models\medis\AsesmenAwalKebidananRiwayatKehamilan;

use app\models\medis\AsesmenAwalMedis;
use app\models\medis\Cppt;
use app\models\medis\DocClinicalPasien;
use app\models\medis\ResumeMedisRi;
use app\models\medis\TarifTindakanPasien;
use app\models\medis\PermintaanKonsultasi;
use app\models\medis\JawabanKonsultasi;
use app\models\medis\Resep;
use app\models\medis\ResepDetail;
use app\models\Pegawai;
use app\models\pegawai\TbPegawai;
use app\models\Peminjaman;
use app\models\PeminjamanDetail;
use app\models\PencariTracer;
use app\models\PencariTracerSearch;
use app\models\pendaftaran\Layanan;
use app\models\pendaftaran\Pasien;
use app\models\pendaftaran\Registrasi;
use app\models\pendaftaran\DebiturDetail;
use app\models\pengolahandata\MasterJenisAnalisaDetail;
use app\models\pengolahandata\AnalisaDokumen;
use app\models\pengolahandata\AnalisaDokumenDetail;
use app\models\pengolahandata\AnalisaDokumenDetailSearch;
use app\models\pengolahandata\ResultHead;
use app\models\penunjang\HasilPemeriksaan;
use app\models\penunjang\JenisTindakanPa;
use app\models\penunjang\LabelPemeriksaanPa;
use app\models\penunjang\PemeriksaanTindakanHasil;
use app\models\penunjang\ResultPacs;
use app\models\medis\ResumeMedisRj;
use app\widgets\Datatable;
use app\models\search\AnalisaKuantitatifSearch;
use app\models\search\LayananRjSearch;
use app\models\search\RegistrasiSearch;
use app\models\sqlServer\LISORDER;
use app\models\Unit;
use app\widgets\AuthUser;
use yii\base\Exception;
use yii\data\SqlDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * RiwayatPasienController implements the CRUD actions for Distribusi model.
 */
class RiwayatPasienController extends Controller
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
    function actionListKunjungan($id = NULL)
    {
        $pasien = NULL;
        if (!HelperSpesialClass::isMpp()) {
            $this->layout = 'main-riwayat';
            $pasien = Pasien::find()->select('kode, nama')->where(['kode' => $id])->asArray()->limit(1)->one();
        } else {
            $this->layout = 'main';
        }
        $searchModel = new RegistrasiSearch();
        $dataProvider = $searchModel->searchRegistrasi($id, $this->request->queryParams);
        $debitur = DebiturDetail::find()->asArray()->all();
        return $this->render('list_registrasi', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'debitur' => $debitur,
            'pasien' => $pasien,
        ]);
    }
    function actionDetailKunjungan($rm, $noreg)
    {
        $pasien = NULL;
        if (!HelperSpesialClass::isMpp()) {
            $this->layout = 'main-riwayat';
        } else {
            $this->layout = 'main';
        }

        $registrasi = HelperSpesialClass::getCheckRegistrasiPasien($noreg);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
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
        if (HelperSpesialClass::isMpp()) {
            //echo "<pre>"; print_r($layananId); exit;
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
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])/*->andWhere(['not', ['tanggal_final' => null]])*/->all();
        $listResumeMedisRj = Yii::$app->db_medis->createCommand("select * from medis.resume_medis_rj where batal=0 and is_deleted=0 and layanan_id in (" . implode(',', $layananId) . ") ")->queryAll();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();
        //echo "<br><br><br>"; print_r($listResumeMedisRj);
        foreach ($listTimOperasi as $value) {
            $timOperasi[] = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->all();

        $docClinicList = HelperSpesialClass::getCheckDocClinical($noreg);
        $listLabor = HelperSpesialClass::getListLabor($noreg);
        $listRadiologi = HelperSpesialClass::getListRadiologi($noreg);

        $listPatologiAnatomi = HelperSpesialClass::getListPatologiAnatomi($noreg);
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
        ])->where(['registrasi_kode' => $noreg, 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        //resep
        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        //sbpk
        //$sbpk=Registrasi::find()->joinWith(['layanan.unit','layanan.pjp.pegawai','layanan.icd10pasien','layanan.icd9pasien','layanan.reseppasien.resepDetail.obat'])->andWhere([Registrasi::tableName().'.kode'=>$layanan['registrasi_kode']])->orderBy([Layanan::tableName().'.tgl_masuk'=>SORT_ASC])->asArray()->one();

        //echo "<pre>"; print_r($resep); exit;
        return $this->render(
            'detail_kunjungan',
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
            ]
        );
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
    function actionDetailResumeRj()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $id = $req->post('id');
            $resume = ResumeMedisRj::find()->joinWith(['dokter', 'unitTujuan', 'layanan' => function ($q) {
                $q->joinWith(['unit', 'registrasi' => function ($query) {
                    $query->joinWith('pasien');
                }]);
            }])->where([ResumeMedisRj::tableName() . '.id' => $id])->nobatal()->orderBy(['created_at' => SORT_DESC])->limit(1)->one();
            $pasien = Pasien::find()->joinWith([
                'registrasi' => function ($q) use ($resume) {
                    $q->joinWith([
                        'layanan' => function ($q) use ($resume) {
                            $q->where(['id' => $resume->layanan_id]);
                        }
                    ]);
                }
            ])->limit(1)->one();
            //echo "<pre>"; print_r($resume); exit;
            return $this->renderAjax('sbpk_detail', [
                'resume' => $resume,
                'pasien' => $pasien,
            ]);
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
    public function actionDetail($id = null)
    {
        $this->layout = 'main-riwayat';
        $registrasi = HelperSpesialClass::getCheckRegistrasiPasien($id);
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
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->andWhere(['not', ['tanggal_final' => null]])->all();
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

    public function actionListCheckout()
    {
        $searchModel = new RegistrasiSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('list-checkout', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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


        // if(!empty($params['RegistrasiSearch']['tgl_awal'])){
        //     $query->andFilterWhere(['>=', new Expression('date (' . AnalisaDokumen::tableName() . '.created_at)'), $params['RegistrasiSearch']['tgl_awal']]);
        // }
        // if(!empty($params['RegistrasiSearch']['tgl_akhir'])){
        //     $query->andFilterWhere(['<=', new Expression('date (' . AnalisaDokumen::tableName() . '.created_at)'), $params['RegistrasiSearch']['tgl_akhir']]);
        // }
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        // return json_encode($this->request->queryParams);
        return $this->render('laporan-analisa', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'data' => $data
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
        }])->where(['medis.asesmen_awal_kebidanan.id' => $id])->limit(1)->one();
        $asesmenRiwayatKehamilan = AsesmenAwalKebidananRiwayatKehamilan::find()->joinWith(['perawat', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['pendaftaran.registrasi.kode' => $asesmen->layanan->registrasi_kode])->all();
        $pasien = Pasien::find()->where(['kode' => $asesmen->layanan->registrasi->pasien_kode])->limit(1)->one();
        return $this->renderAjax('asesmen-awal-kebidanan', ['asesmen' => $asesmen, 'asesmenRiwayatKehamilan' => $asesmenRiwayatKehamilan, 'pasien' => $pasien]);
    }
    public function actionPreviewResumeMedis($id)
    {
        $asesmen = ResumeMedisRi::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['medis.resume_medis_ri.id' => $id])->limit(1)->one();

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



    public function actionPreviewLaporanAnastesi($id)
    {
        $model = AsesmenPraInduksi::find()->where(['api_id' => $id])->andWhere('api_deleted_at is null')->one();

        $timoperasi = TimOperasi::find()->where(['to_id' => $model->api_to_id])->one();
        // $timoperasidetail = TimOperasiDetail::find()->where(['tod_to_id' => $model->lap_op_to_id])->all();
        $layanan = Layanan::find()->joinWith(['registrasi' => function ($q) {
            $q->joinWith(['pasien']);
        }])->where(['in', 'id', $timoperasi->to_ok_pl_id])->one();

        $detail = TimOperasiDetail::find()->where(['tod_to_id' => $model->api_to_id, 'tod_jo_id' => 2])->all();

        $pasien = Pasien::find()->where(['kode' => $layanan->registrasi->pasien->kode])->one();

        return $this->renderAjax('laporan-anastesi', [
            'model' => $model,
            'timoperasi' => $timoperasi,
            'pasien' => $pasien,
            'detail' => $detail

        ]);
    }
}
