<?php

namespace app\controllers;

use app\components\Api;
use app\components\HelperSpesialClass;
use app\components\HelperGeneralClass;
use app\components\Model;
use app\models\bedahsentral\AsesmenPraInduksi;
use app\models\bedahsentral\LaporanOperasi;
use app\models\bedahsentral\TimOperasi;
use app\models\medis\AsesmenAwalKebidanan;
use app\models\medis\AsesmenAwalKeperawatanGeneral;
use app\models\medis\AsesmenAwalMedis;
use app\models\medis\PermintaanKonsultasi;
use app\models\medis\Resep;
use app\models\medis\ResumeMedisRi;
use app\models\pendaftaran\Layanan;
use app\models\pendaftaran\Registrasi;
use app\models\pendaftaran\Pasien;
use app\models\search\RegistrasiSearch;
use yii\data\SqlDataProvider;
use app\models\medis\Icd10cmv2;
use app\models\medis\Icd9cmv3;
use app\models\search\LayananRiSearch;
use app\models\pengolahandata\CatatanMpp;
use app\models\pengolahandata\CatatanImplementasiMpp;

use app\models\pengolahandata\CatatanMppSearch;
use app\models\pengolahandata\CodingClaim;
use app\models\pengolahandata\CodingClaimDiagnosaDetail;
use app\models\pengolahandata\CodingClaimMpp;
use app\models\pengolahandata\CodingClaimMppDiagnosaDetail;
use app\models\pengolahandata\CodingClaimMppTindakanDetail;
use app\models\pengolahandata\CodingClaimTindakanDetail;
use app\models\pengolahandata\MasterJenisAnalisaDetail;
use app\models\pengolahandata\SkriningPasienMpp;
use app\models\pengolahandata\SkriningPemulanganPasienMpp;
use app\models\pengolahandata\EvaluasiAwalPasienMpp;
use app\models\pengolahandata\ResumeMedisRiClaim;
use app\models\sip\Unit;
use Exception;
use yii\web\Response;

use Yii;
use Mpdf\Mpdf;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * MppController implements the CRUD actions for CatatanMpp model.
 */
class MppController extends Controller
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
     * Lists all CatatanMpp models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $userLogin = HelperSpesialClass::getUserLogin();
        $isMpp = HelperSpesialClass::isMpp();

        if (!$userLogin['akses']) {
            Yii::$app->session->setFlash('warning', 'tes');
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        if (!$isMpp) {
            Yii::$app->session->setFlash('error', "Anda tidak memiliki akses MPP");
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $date = date('Y-m-d');
        // echo'<pre/>';print_r($userLogin);die();
        $pegawai_id = $userLogin['pegawai_id'];
        $mpp = HelperSpesialClass::isMppUnit();


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


        $data = Registrasi::find()
            ->alias('r')
            ->select([
                'r.kode as nomor_registrasi',
                'r.tgl_masuk',
                'r.tgl_keluar',
                'l_max.max_tgl_masuk',
                'l_max.tgl_keluar',
                'l_max.id AS layanan_id',
                'rm.id as resume_jumlah',
                'cm.id as catatan',
                'p.kode as rm_pasien',
                'p.nama as nama_pasien',
                // 'dup.kode',
                'dup.nama as unit',
            ])
            ->innerJoin([
                'l_max' => Layanan::find()
                    ->select(['registrasi_kode', 'MAX(tgl_masuk) AS max_tgl_masuk', 'tgl_keluar', 'unit_kode', 'jenis_layanan', 'id'])
                    ->groupBy(['registrasi_kode', 'id', 'jenis_layanan'])
            ], 'r.kode = l_max.registrasi_kode')
            ->innerJoin(['l' => Layanan::tableName()], 'l_max.registrasi_kode = l.registrasi_kode AND l_max.max_tgl_masuk = l.tgl_masuk')
            ->innerJoin(['p' => Pasien::tableName()], 'p.kode = r.pasien_kode')
            ->innerJoin(['dup' => Unit::tableName()], 'dup.kode = l_max.unit_kode')
            ->leftJoin(['rm' => ResumeMedisRi::tableName()], 'l.id = rm.layanan_id')
            ->leftJoin(['cm' => CatatanMpp::tableName()], 'l.id = cm.layanan_id')
            ->where(['l_max.jenis_layanan' => 3])
            ->andWhere(['in', 'l_max.unit_kode', HelperSpesialClass::isMppUnit()])
            ->asArray()->all();

        return $this->render('index', [
            'data' => $dataMpp,
            'dataNew' => $data
        ]);
    }

    /**
     * Displays a single CatatanMpp model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCatatan($id)
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


        $model = new CatatanMpp();

        $listMpp = CatatanMpp::find()->joinWith(['layanan', 'pegawai'])->where(['in', 'layanan_id', $layananId])->all();
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
        $this->layout = 'main-pasien';
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



    public function actionCatatanImplementasiMpp($id)
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


        $model = new CatatanImplementasiMpp();

        $listMpp = CatatanImplementasiMpp::find()->joinWith(['layanan', 'pegawai'])->where(['in', 'layanan_id', $layananId])->all();

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
        $this->layout = 'main-pasien';
        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        return $this->render(
            'catatan_implementasi_mpp',
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


    public function actionSkriningPasienMpp($id)
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

        $model = new SkriningPasienMpp();
        $listMpp = CatatanMpp::find()->joinWith(['layanan', 'pegawai'])->where(['in', 'layanan_id', $layananId])->all();
        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }

        $listSkriningPasienMpp = SkriningPasienMpp::find()->where(['registrasi_kode' => $registrasi->data['kode']])->all();
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
        $this->layout = 'main-pasien';
        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        return $this->render(
            'skrining-pasien-mpp',
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
                'listSkriningPasienMpp' => $listSkriningPasienMpp,
                'resep' => $resep,
            ]
        );
    }


    public function actionSkriningPemulanganPasienMpp($id)
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

        $model = new SkriningPemulanganPasienMpp();
        $listMpp = CatatanMpp::find()->joinWith(['layanan', 'pegawai'])->where(['in', 'layanan_id', $layananId])->all();
        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }

        $listSkriningPasienMpp = SkriningPemulanganPasienMpp::find()->where(['registrasi_kode' => $registrasi->data['kode']])->all();
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
        $this->layout = 'main-pasien';
        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        return $this->render(
            'skrining-pemulangan-pasien-mpp',
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
                'listSkriningPasienMpp' => $listSkriningPasienMpp,
                'resep' => $resep,
            ]
        );
    }


    public function actionEvaluasiAwalMpp($id)
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

        $model = new EvaluasiAwalPasienMpp();
        $listMpp = CatatanMpp::find()->joinWith(['layanan', 'pegawai'])->where(['in', 'layanan_id', $layananId])->all();
        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }

        $listSkriningPasienMpp = SkriningPasienMpp::find()->where(['registrasi_kode' => $registrasi->data['kode']])->all();
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
        $listEvaluasiAwalMpp = EvaluasiAwalPasienMpp::find()->where(['in', 'layanan_id', $layananId])->all();
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $registrasi->data['kode'], 'batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();
        $this->layout = 'main-pasien';
        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        return $this->render(
            'evaluasi_awal_mpp',
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
                'listSkriningPasienMpp' => $listSkriningPasienMpp,
                'resep' => $resep,
                'listEvaluasiAwalMpp' => $listEvaluasiAwalMpp
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
        $this->layout = 'main-pasien';

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

    public function actionDetailMppEditResume($id = null, $id_resume = null)
    {
        $model = ResumeMedisRi::find()->where(['id' => $id_resume])->one();

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
        $this->layout = 'main-pasien';

        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        return $this->render(
            'detail-mpp-resume-medis-edit',
            [
                'registrasi' => $registrasi->data,
                'model' => $model,
                'docClinicalList' => $docClinicList,
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
    /**
     * Creates a new CatatanMpp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new CatatanMpp();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
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

    public function actionCetakResumeMedisRi()
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
        $asesmen = ResumeMedisRi::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['medis.resume_medis_ri.id' => $id])->one();

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
        $html = $this->renderPartial('resume-medis', ['asesmen' => $asesmen, 'pasien' => $pasien]);

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
    /**
     * Updates an existing CatatanMpp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CatatanMpp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CatatanMpp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return CatatanMpp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CatatanMpp::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSaveSkriningPasienMpp()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $model = new SkriningPasienMpp();
            $model->load($req->post());

            if ($model->validate()) {
                // return json_encode($model->saveDataMpp());
                if ($model->save()) {
                    $result = ['status' => true, 'msg' => 'Data Berhasil Disimpan'];
                } else {
                    $result = ['status' => false, 'msg' => 'Data Gagal Disimpan'];
                }
            } else {
                $result = ['status' => false, 'msg' => $model->errors];
            }

            return $this->asJson($result);
        }
    }

    public function actionSaveSkriningPemulanganPasienMpp()
    {
        $req = Yii::$app->request;


        if ($req->isAjax) {
            $model = new SkriningPemulanganPasienMpp();
            $model->load($req->post());
            $model->bantuan_diperlukan_dalam_hal = json_encode($req->post('SkriningPemulanganPasienMpp')['bantuan_diperlukan_dalam_hal']);

            if ($model->validate()) {
                // return json_encode($model->saveDataMpp());
                if ($model->save()) {
                    $result = ['status' => true, 'msg' => 'Data Berhasil Disimpan'];
                } else {
                    $result = ['status' => false, 'msg' => 'Data Gagal Disimpan'];
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

            // if ($id != NULL) {
            //     $model = CatatanMpp::find()->where(['layanan_id' => $id, 'pegawai_mpp_id' => $mppId])->limit(1)->one();
            // } else {
            $model = new CatatanMpp();
            // }
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

    public function actionSaveCatatanImplementasiMpp()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $id = $req->post('layanan_id');
            $mppId = $req->post('pegawai_mpp_id');

            // if ($id != NULL) {
            //     $model = CatatanMpp::find()->where(['layanan_id' => $id, 'pegawai_mpp_id' => $mppId])->limit(1)->one();
            // } else {
            $model = new CatatanImplementasiMpp();
            // }
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
    public function actionSaveEvaluasiAwalPasienMpp()
    {
        $req = Yii::$app->request;


        if ($req->isAjax) {
            $model = new EvaluasiAwalPasienMpp();
            $model->load($req->post());

            if ($model->validate()) {
                // return json_encode($model->saveDataMpp());
                if ($model->save()) {
                    $result = ['status' => true, 'msg' => 'Data Berhasil Disimpan'];
                } else {
                    $result = ['status' => false, 'msg' => 'Data Gagal Disimpan'];
                }
            } else {
                $result = ['status' => false, 'msg' => $model->errors];
            }

            return $this->asJson($result);
        }
    }

    public function actionBatalkanEvaluasiAwalPasienMpp($id)
    {
        $model = EvaluasiAwalPasienMpp::find()->where(['id' => $id])->one();
        $user = HelperSpesialClass::getUserLogin();
        if ($model->mpp_id != $user['pegawai_id']) {
            $result = ['status' => false, 'msg' => 'Evaluasi Awal Pasien Mpp Tidak Dapat Anda Batalkan!'];
            return $this->asJson($result);
        }
        $model->batal = 1;
        $model->tanggal_batal = date('Y-m-d H:i:s');
        if ($model->save()) {
            $result = ['status' => true, 'msg' => 'Berhasil Dibatalkan!'];
        } else {
            $result = ['status' => false, 'msg' => 'Gagal Dibatalkan!'];
        }
        return $this->asJson($result);
    }

    public function actionBatalkanSkriningPasienMpp($id)
    {
        $model = SkriningPasienMpp::find()->where(['id' => $id])->one();
        $user = HelperSpesialClass::getUserLogin();
        if ($model->mpp_id != $user['pegawai_id']) {
            $result = ['status' => false, 'msg' => 'Skrining Pasien Mpp Tidak Dapat Anda Batalkan!'];
            return $this->asJson($result);
        }
        $model->batal = 1;
        $model->tanggal_batal = date('Y-m-d H:i:s');
        if ($model->save()) {
            $result = ['status' => true, 'msg' => 'Berhasil Dibatalkan!'];
        } else {
            $result = ['status' => false, 'msg' => 'Gagal Dibatalkan!'];
        }
        return $this->asJson($result);
    }

    public function actionBatalkanSkriningPemulanganPasienMpp($id)
    {
        $model = SkriningPemulanganPasienMpp::find()->where(['id' => $id])->one();
        $user = HelperSpesialClass::getUserLogin();
        if ($model->mpp_id != $user['pegawai_id']) {
            $result = ['status' => false, 'msg' => 'Skrining Pemulangan Pasien Mpp Tidak Dapat Anda Batalkan!'];
            return $this->asJson($result);
        }
        $model->batal = 1;
        $model->tanggal_batal = date('Y-m-d H:i:s');
        if ($model->save()) {
            $result = ['status' => true, 'msg' => 'Berhasil Dibatalkan!'];
        } else {
            $result = ['status' => false, 'msg' => 'Gagal Dibatalkan!'];
        }
        return $this->asJson($result);
    }

    public function actionPreviewSkriningPasienMpp($id)
    {
        $skriningPasienMpp = SkriningPasienMpp::find()->joinWith(['mpp', 'layanan' => function ($q) {
            $q->joinWith(['unit', 'registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['pengolahan_data.skrining_pasien_mpp.id' => $id])->one();
        $pasien = Pasien::find()->where(['kode' => $skriningPasienMpp->layanan->registrasi->pasien->kode])->one();
        return $this->renderAjax('preview_skrining_pasien_mpp', ['skriningPasienMpp' => $skriningPasienMpp, 'pasien' => $pasien]);
    }

    public function actionPreviewSkriningPemulanganPasienMpp($id)
    {
        $skriningPasienMpp = SkriningPemulanganPasienMpp::find()->joinWith(['mpp', 'layanan' => function ($q) {
            $q->joinWith(['unit', 'registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['pengolahan_data.skrining_pemulangan_pasien_mpp.id' => $id])->one();
        $pasien = Pasien::find()->where(['kode' => $skriningPasienMpp->layanan->registrasi->pasien->kode])->one();
        return $this->renderAjax('preview_skrining_pemulangan_pasien_mpp', ['skriningPasienMpp' => $skriningPasienMpp, 'pasien' => $pasien]);
    }
    public function actionPreviewEvaluasiAwalPasienMpp($id)
    {
        $skriningPasienMpp = EvaluasiAwalPasienMpp::find()->joinWith(['mpp', 'layanan' => function ($q) {
            $q->joinWith(['unit', 'registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['pengolahan_data.evaluasi_awal_pasien_mpp.id' => $id])->one();
        $pasien = Pasien::find()->where(['kode' => $skriningPasienMpp->layanan->registrasi->pasien->kode])->one();
        return $this->renderAjax('preview_evaluasi_awal_pasien_mpp', ['skriningPasienMpp' => $skriningPasienMpp, 'pasien' => $pasien]);
    }


    public function actionIndexMpp()
    {
        $userLogin = HelperSpesialClass::getUserLogin();
        if (!$userLogin['akses']) {
            Yii::$app->session->setFlash('warning', $userLogin['pesannoakses']);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $searchModel = new LayananRiSearch();
        $dataProvider = $searchModel->searchMpp(Yii::$app->request->queryParams, $userLogin);

        return $this->render('index-mpp', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexMppNew()
    {
        // $isMpp = HelperSpesialClass::isMpp();


        // if (!$isMpp) {
        //     Yii::$app->session->setFlash('error', "Anda tidak memiliki akses MPP");
        //     return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        // }

        return $this->render('index-mpp-new', []);
    }

    public function actionDataMppList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request->post("datatables");
        $dataMpp = Layanan::find()
            ->alias('l')
            ->select('l.id as layanan_id,
            p.nama as nama_pasien,
            p.kode as rm_pasien,
            r.kode as nomor_registrasi,
            r.tgl_masuk as tgl_registrasi,
            r.tgl_keluar as tgl_checkout,
            r.is_closing_billing_ranap as closing,
            r.closing_billing_ranap_at as tgl_closing,
            tp.nama_lengkap as adm,
            up.nama as unit,
            ups.nama as unit_asal,
            l.tgl_masuk,
            l.tgl_keluar,
            l.nomor_urut,
            ')
            ->innerJoin('pendaftaran.registrasi r', 'r.kode=l.registrasi_kode')
            ->innerJoin('pendaftaran.pasien p', 'p.kode=r.pasien_kode')
            ->innerJoin('pegawai.dm_unit_penempatan up', 'l.unit_kode=up.kode')
            ->leftJoin('pegawai.tb_pegawai tp', 'r.closing_billing_ranap_by=tp.pegawai_id')
            ->leftJoin('pegawai.dm_unit_penempatan ups', 'l.unit_asal_kode=ups.kode');

        if (!empty(HelperSpesialClass::isMppUnit())) {
            $unit = HelperSpesialClass::isMppUnit();
        } else {
            $unit = ['0'];
        }

        $dataMpp = $dataMpp->where(['in', 'l.unit_kode', $unit]);
        if ($req['tanggal_masuk_awal'] != null) {
            $dataMpp = $dataMpp->andWhere([">=", "r.tgl_masuk", $req['tanggal_masuk_awal'] . " 00:00:00"]);
        } else {
            $dataMpp = $dataMpp->andWhere([">=", "r.tgl_masuk", date('Y-m-d') . " 00:00:00"]);
        }


        if ($req['tanggal_masuk_akhir'] != null) {
            $dataMpp = $dataMpp->andWhere(["<=", "r.tgl_masuk", $req['tanggal_masuk_akhir'] . " 23:59:59"]);
        } else {
            $dataMpp = $dataMpp->andWhere(["<=", "r.tgl_masuk", date('Y-m-d') . " 23:59:59"]);
        }
        if (isset($req['tanggal_keluar_awal'])) {
            if ($req['tanggal_keluar_awal'] != null) {
                $dataMpp = $dataMpp->andWhere([">=", "r.tgl_keluar", $req['tanggal_keluar_awal'] . " 00:00:00"]);
            }
        }
        if (isset($req['tanggal_keluar_akhir'])) {
            if ($req['tanggal_keluar_akhir'] != null) {
                $dataMpp = $dataMpp->andWhere(["<=", "r.tgl_keluar", $req['tanggal_keluar_akhir'] . " 23:59:59"]);
            }
        }

        if ($req['ruangan'] != null) {
            $dataMpp = $dataMpp->andWhere(["l.unit_kode" => $req['ruangan']]);
        }
        $dataMpp = $dataMpp->orderBy(['r.tgl_masuk' => SORT_DESC])->asArray()->all();





        $response = [];


        foreach ($dataMpp as $value) {
            $resumeMedis = ResumeMedisRi::find()

                ->innerJoin(Layanan::tableName(), Layanan::tableName() . '.id = ' . ResumeMedisRi::tableName() . '.layanan_id')
                ->andWhere([Layanan::tableName() . '.registrasi_kode' => $value['nomor_registrasi']])
                ->all();
            $catatanMpp = CatatanMpp::find()
                ->innerJoin(Layanan::tableName(), Layanan::tableName() . '.id = ' . CatatanMpp::tableName() . '.layanan_id')
                ->andWhere([Layanan::tableName() . '.registrasi_kode' => $value['nomor_registrasi']])
                ->all();

            $catatanMpps = Registrasi::find()->joinWith(['layanan'])->where(['pasien_kode' => '01111196'])->orderBy([Registrasi::tableName() . '.created_at' => SORT_DESC])->createCommand()->rawSql;

            $poliList = [];

            // memisahkan string berdasarkan tanda koma
            $resumeCount = 0;
            if (count($resumeMedis) > 0) {
                $resumeCount = '<span class="right badge badge-success">Sudah Ada Resume</span>';
            } else {
                $resumeCount = '<span class="right badge badge-danger">Belum Ada Resume</span>';
            }
            $catatanCount = 0;
            if (count($catatanMpp) > 0) {
                $catatanCount = '<span class="right badge badge-success">Sudah Ada Catatan</span>';
            } else {
                $catatanCount = '<span class="right badge badge-danger">Belum Ada Catatan</span>';
            }
            $response[] = [
                'layanan_id' => $value['layanan_id'],
                'layanan_nama' => $value['unit'],

                'nama_pasien' => $value['nama_pasien'],
                'rm_pasien' => $value['rm_pasien'],
                'nomor_registrasi' => $value['nomor_registrasi'],
                'tgl_registrasi' => $value['tgl_registrasi'],
                'unit' => ($value['unit'] != null) ? '<span class="right badge badge-success">' . $value['unit'] . '</span>' : '-',
                'unit_asal' => ($value['unit_asal'] != null) ? '<span class="right badge badge-danger">' . $value['unit_asal'] . '</span>' : '-',

                'tgl_registrasi' => $value['tgl_registrasi'] ?? '-',
                'tgl_checkout' => $value['tgl_checkout'] ?? '-',
                'tgl_masuk' => $value['tgl_masuk'] ?? '-',
                'rawat' => ($value['tgl_keluar'] != null) ? '<span class="right badge badge-success">Sudah Pulang/Pindah Ruangan</span>' : '<span class="right badge badge-danger">Masih Dirawat</span>',
                'tgl_keluar' => $value['tgl_keluar'] ?? '-',
                'nomor_urut' => $value['nomor_urut'],
                'resume' => $resumeCount,
                'catatan' => $catatanCount,
                'closing' => $value['closing'],
                'adm' => $value['adm'] ?? '-',
                'tgl_closing' => $value['tgl_closing'] ?? '-',
                'registrasi_kode_hash' => HelperGeneralClass::hashData($value['nomor_registrasi'])
            ];
        }

        return [
            "status" => 200,
            "message" => "Data successfully retrieved",
            "data" => $response
        ];
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

    public function actionClaim($id = null)
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



        $listCoder = CodingClaimMpp::find()->joinWith(['claimDiagnosa', 'claimTindakan'])->joinWith(['resumeMedis' => function ($query) {
            $query->joinWith('dokter');
        }])->where([CodingClaimMpp::tableName() . '.registrasi_kode' => $registrasi->data['kode']])->one();


        $modelData = CodingClaimMpp::find()->where(['registrasi_kode' => $registrasi->data['kode']])->one();
        $modelCodingClaimMppRi = new CodingClaimMpp();
        $modelCodingClaimMppDiagnosaDetailRi = [new CodingClaimMppDiagnosaDetail];

        $modelCodingClaimMppTindakanDetailRi = [new CodingClaimMppTindakanDetail];

        if ($modelData) {
            $modelCodingClaimMppRi = CodingClaimMpp::find()->where(['registrasi_kode' => $registrasi->data['kode']])->one();
            if ($modelCodingClaimMppRi->claimDiagnosa) {
                $modelCodingClaimMppDiagnosaDetailRi = $modelCodingClaimMppRi->claimDiagnosa;
            } else {
                $modelCodingClaimMppDiagnosaDetailRi = [new CodingClaimMppDiagnosaDetail];
            }
            if ($modelCodingClaimMppRi->claimTindakan) {
                $modelCodingClaimMppTindakanDetailRi = $modelCodingClaimMppRi->claimTindakan;
            } else {
                $modelCodingClaimMppTindakanDetailRi = [new CodingClaimMppTindakanDetail];
            }
        }
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        return $this->render(
            'claim',
            [
                'registrasi' => $registrasi->data,
                'model' => $model,
                'listResumeMedis' => $listResumeMedis,
                'modelCodingClaimMppRi' => $modelCodingClaimMppRi,


                'modelCodingClaimMppDiagnosaDetailRi' => (empty($modelCodingClaimMppDiagnosaDetailRi)) ? [new CodingClaimMppDiagnosaDetail] : $modelCodingClaimMppDiagnosaDetailRi,
                'modelCodingClaimMppTindakanDetailRi' => (empty($modelCodingClaimMppTindakanDetailRi)) ? [new CodingClaimMppTindakanDetail] : $modelCodingClaimMppTindakanDetailRi,

            ]
        );
    }
    public function actionClaimMpp($id = null, $registrasi_kode = null)
    {
        $resumeMedis = ResumeMedisRi::find()->where(['id' => HelperGeneralClass::validateData($id)])->one();


        $registrasi = HelperSpesialClass::getCheckPasien($registrasi_kode);

        $layananId = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
        }


        $listCoder = CodingClaimMpp::find()->joinWith(['claimDiagnosa', 'claimTindakan'])->joinWith(['resumeMedis' => function ($query) {
            $query->joinWith('dokter');
        }])->where([CodingClaimMpp::tableName() . '.registrasi_kode' => $registrasi->data['kode']])->one();


        $modelData = CodingClaimMpp::find()->where(['registrasi_kode' => $registrasi->data['kode']])->one();
        $modelCodingClaimMppRi = new CodingClaimMpp();
        $modelCodingClaimMppDiagnosaDetailRi = [new CodingClaimMppDiagnosaDetail];

        $modelCodingClaimMppTindakanDetailRi = [new CodingClaimMppTindakanDetail];

        if ($modelData) {
            $modelCodingClaimMppRi = CodingClaimMpp::find()->where(['registrasi_kode' => $registrasi->data['kode']])->one();
            if ($modelCodingClaimMppRi->claimDiagnosa) {
                $modelCodingClaimMppDiagnosaDetailRi = $modelCodingClaimMppRi->claimDiagnosa;
            } else {
                $modelCodingClaimMppDiagnosaDetailRi = [new CodingClaimMppDiagnosaDetail];
            }
            if ($modelCodingClaimMppRi->claimTindakan) {
                $modelCodingClaimMppTindakanDetailRi = $modelCodingClaimMppRi->claimTindakan;
            } else {
                $modelCodingClaimMppTindakanDetailRi = [new CodingClaimMppTindakanDetail];
            }
        }
        return $this->render(
            'claim',
            [
                'registrasi' => $registrasi->data,
                'listCoder' => $listCoder,

                'modelCodingClaimMppRi' => $modelCodingClaimMppRi,


                'modelCodingClaimMppDiagnosaDetailRi' => (empty($modelCodingClaimMppDiagnosaDetailRi)) ? [new CodingClaimMppDiagnosaDetail] : $modelCodingClaimMppDiagnosaDetailRi,
                'modelCodingClaimMppTindakanDetailRi' => (empty($modelCodingClaimMppTindakanDetailRi)) ? [new CodingClaimMppTindakanDetail] : $modelCodingClaimMppTindakanDetailRi,
            ]
        );
    }

    public function actionClaimDiagnosaSave()
    {
        $modelData = CodingClaimMpp::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaimMpp')['registrasi_kode']])->one();
        if ($modelData) {

            $model = CodingClaimMpp::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaimMpp')['registrasi_kode']])->one();
            $modelDetails = $model->claimDiagnosa;

            if ($model->load(Yii::$app->request->post())) {
                $oldIDs  = ArrayHelper::map($modelDetails, 'id', 'id');
                $modelDetails    = Model::createMultiple(CodingClaimMppDiagnosaDetail::className());
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
                                CodingClaimMppDiagnosaDetail::deleteAll(['id' => $deletedIDs]);
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
                            $registrasiModel = Registrasi::find()->where(['kode' =>  Yii::$app->request->post('CodingClaimMpp')['registrasi_kode']])->one();
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
            $model = new CodingClaimMpp();

            $modelDetails = [new CodingClaimMppDiagnosaDetail()];
            if ($model->load(Yii::$app->request->post())) {
                $modelDetails    = Model::createMultiple(CodingClaimMppDiagnosaDetail::className());
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
        $modelData = CodingClaimMpp::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaimMpp')['registrasi_kode']])->one();
        if ($modelData) {
            $model = CodingClaimMpp::find()->where(['registrasi_kode' => Yii::$app->request->post('CodingClaimMpp')['registrasi_kode']])->one();
            $modelDetails = $model->claimTindakan;

            if ($model->load(Yii::$app->request->post())) {
                $oldIDs  = ArrayHelper::map($modelDetails, 'id', 'id');
                $modelDetails    = Model::createMultiple(CodingClaimMppTindakanDetail::className());
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
                                CodingClaimMppTindakanDetail::deleteAll(['id' => $deletedIDs]);
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
            $model = new CodingClaimMpp();
            $modelDetails = [new CodingClaimMppTindakanDetail()];
            if ($model->load(Yii::$app->request->post())) {
                $modelDetails    = Model::createMultiple(CodingClaimMppTindakanDetail::className());
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
}
