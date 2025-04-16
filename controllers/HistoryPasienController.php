<?php

namespace app\controllers;

use app\components\Api;
use app\components\HelperGeneral;
use app\components\HelperSpesialClass;
use app\components\MakeResponse;
use app\components\Mdcp;
use app\models\AksesUnit;
use app\models\bedahsentral\AsesmenPraInduksi;
use app\models\bedahsentral\AskanIntraAnestesi;
use app\models\bedahsentral\AskanPascaAnestesi;
use app\models\bedahsentral\AskanPraAnestesi;
use app\models\bedahsentral\CatatanLokalAnestesi;
use app\models\bedahsentral\IntraOperasiPerawat;
use app\models\bedahsentral\LaporanOperasi;
use app\models\bedahsentral\LembarEdukasiTindakanAnestesi;
use app\models\bedahsentral\LokasiOperasi;
use app\models\bedahsentral\PascaLokalAnestesi;
use app\models\bedahsentral\PembatalanOperasi;
use app\models\bedahsentral\PenggunaanJumlahKasaDanInstrumen;
use app\models\bedahsentral\PertanyaanCheckListKeselamatanOk;
use app\models\bedahsentral\PostOperasiPerawat;
use app\models\bedahsentral\PraAnestesi;
use app\models\bedahsentral\PreOperasiPerawatOk;
use app\models\bedahsentral\TimOperasi;
use app\models\bedahsentral\TimOperasiDetail;
use Yii;
use yii\web\Response;
use Mpdf\Mpdf;
use app\models\Distribusi;
use app\models\DistribusiDetail;
use app\models\DistribusiDetailSearch;
use app\models\DistribusiSearch;
use app\models\FmDistribusi;
use app\models\FmDistribusiDetail;
use app\models\fileman\AnalisaKuantitatif;
use app\models\medis\AsesmenAwalKebidanan;
use app\models\medis\AsesmenAwalKebidananRiwayatKehamilan;
use app\models\medis\AsesmenAwalKeperawatanGeneral;
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
use app\models\pengolahandata\CodingPelaporanRj;
use app\models\penunjang\HasilPemeriksaan;
use app\models\penunjang\JenisTindakanPa;
use app\models\penunjang\LabelPemeriksaanPa;
use app\models\penunjang\PemeriksaanTindakanHasil;
use app\models\penunjang\ResultPacs;
use app\models\medis\ResumeMedisRj;
use app\models\pengolahandata\ResumeMedisRjClaim;
use app\models\farmasi\Penjualan;
use app\models\farmasi\PenjualanDetail;
use app\models\Lib;
use app\models\medis\AsesmenHemodialisa;
use app\models\medis\AsesmenHemodialisaDokter;
use app\models\medis\AsesmenHemodialisaDokterLanjutan;
use app\models\medis\CatatanRehabMedik;
use app\models\medis\PasienMonitoringTtv;
use app\models\medis\RehabMedik;
use app\models\medis\RingkasanPulangIgd;
use app\models\medis\TriasePasien;
use app\widgets\Datatable;
use app\models\search\AnalisaKuantitatifSearch;
use app\models\search\LayananRjSearch;
use app\models\search\RegistrasiSearch;
use app\models\sign\Dokumen;
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
 * HistoryPasienController implements the CRUD actions for Distribusi model.
 */
class HistoryPasienController extends Controller
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
    function actionListKunjungan($id = NULL, $versi = false)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'list_registrasi',
                    [
                        'searchModel' => [],
                        'dataProvider' => [],
                        'debitur' => [],
                        'pasien' => [],
                        'registrasi' => [],
                        'versi' => $versi,
                    ]
                );
            }
        }
        $pasien = NULL;
        if (!HelperSpesialClass::isMpp()) {
            $this->layout = 'main-riwayat';
            $pasien = Pasien::find()->where(['kode' => $id])->asArray()->limit(1)->one();
        } else {
            $this->layout = 'main-riwayat';

            $pasien = Pasien::find()->where(['kode' => $id])->asArray()->limit(1)->one();
        }
        $searchModel = new RegistrasiSearch();
        $dataProvider = $searchModel->searchRegistrasi($id, $this->request->queryParams);
        $debitur = DebiturDetail::find()->asArray()->all();
        $registrasi = Registrasi::find()->joinWith(['layanan' => function ($q) {
            $q->where([Layanan::tableName() . '.deleted_at' => null])->orderBy('tgl_masuk', SORT_DESC);
        }])->where(['pasien_kode' => $id])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();
        return $this->render('list_registrasi', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'debitur' => $debitur,
            'pasien' => $pasien,
            'registrasi' => $registrasi,
            'versi' => $versi,
        ]);
    }

    function actionListKunjunganNew($id = NULL, $versi = false)
    {
        $pasien = NULL;
        if (!HelperSpesialClass::isMpp()) {
            $this->layout = 'main-riwayat';
            $pasien = Pasien::find()->where(['kode' => $id])->asArray()->limit(1)->one();
        } else {
            $this->layout = 'main-riwayat';

            $pasien = Pasien::find()->where(['kode' => $id])->asArray()->limit(1)->one();
        }
        $searchModel = new RegistrasiSearch();
        $dataProvider = $searchModel->searchRegistrasi($id, $this->request->queryParams);
        $debitur = DebiturDetail::find()->asArray()->all();
        $registrasi = Registrasi::find()->joinWith(['layanan' => function ($q) {
            $q->orderBy('tgl_masuk', SORT_DESC);
        }])->where(['pasien_kode' => $id])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();
        return $this->render('list_registrasi_new', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'debitur' => $debitur,
            'pasien' => $pasien,
            'registrasi' => $registrasi,
            'versi' => $versi,
        ]);
    }

    function actionListKunjunganObject($id = NULL, $versi = null)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'error'
                );
            }
        }

        $pasien = NULL;
        if (!HelperSpesialClass::isMpp()) {
            $this->layout = 'main-riwayat';
            $pasien = Pasien::find()->where(['kode' => $id])->asArray()->limit(1)->one();
        } else {
            $this->layout = 'main-riwayat';

            $pasien = Pasien::find()->where(['kode' => $id])->asArray()->limit(1)->one();
        }
        $searchModel = new RegistrasiSearch();
        $dataProvider = $searchModel->searchRegistrasi($id, $this->request->queryParams);
        $debitur = DebiturDetail::find()->asArray()->all();
        $registrasi = Registrasi::find()->joinWith(['layanan' => function ($q) {
            $q->orderBy('tgl_masuk', SORT_DESC);
        }])->where(['pasien_kode' => $id])->orderBy('tgl_masuk', SORT_DESC)->all();
        return $this->render('list_object', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'debitur' => $debitur,
            'pasien' => $pasien,
            'registrasi' => $registrasi,
            'versi' => $versi,
        ]);
    }
    function actionDetailKunjungan($noreg)
    {


        $pasien = NULL;
        if (!HelperSpesialClass::isMpp()) {
            $this->layout = 'main-riwayat';
        } else {
            $this->layout = 'main-riwayat';
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

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listAsesmenMedis = AsesmenAwalMedis::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listResumeMedis = ResumeMedisRi::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])/*->andWhere(['not', ['tanggal_final' => null]])*/->all();
        $listResumeMedisRj = ResumeMedisRj::find()->joinWith(['layanan' => function ($q) {
            $q->joinWith('registrasi');
        }])->where([Registrasi::tableName() . '.kode' => $registrasi->data['kode']])->andWhere(['batal' => 0])->all();
        $listTimOperasi = TimOperasi::find()->where(['in', 'to_ok_pl_id', $layananOperasi])->all();
        foreach ($listTimOperasi as $value) {
            $timOperasi[] = $value['to_id'];
        }
        $listLaporanOperasi = LaporanOperasi::find()->where(['in', 'lap_op_to_id', $timOperasi])->andWhere([LaporanOperasi::tableName() . '.lap_op_deleted_at' => null, LaporanOperasi::tableName() . '.lap_op_final' => 1, LaporanOperasi::tableName() . '.lap_op_batal' => 0])->all();
        $listLaporanAnastesi = AsesmenPraInduksi::find()->where(['in', 'api_to_id', $timOperasi])->andWhere([AsesmenPraInduksi::tableName() . '.api_deleted_at' => null, AsesmenPraInduksi::tableName() . '.api_final' => 1])->all();
        $listLaporanChecklisKeselamatan = PertanyaanCheckListKeselamatanOk::find()->where(['in', 'pcok_to_id', $timOperasi])->andWhere([PertanyaanCheckListKeselamatanOk::tableName() . '.pcok_deleted_at' => null, PertanyaanCheckListKeselamatanOk::tableName() . '.pcok_final' => 1])->all();
        $listLaporanLokasiOperasi = LokasiOperasi::find()->where(['in', 'mlo_to_id', $timOperasi])->andWhere([LokasiOperasi::tableName() . '.mlo_deleted_at' => null, LokasiOperasi::tableName() . '.mlo_final' => 1])->all();
        $listLaporanPembatalanOperasi = PembatalanOperasi::find()->where(['in', 'bat_to_id', $timOperasi])->andWhere([PembatalanOperasi::tableName() . '.bat_deleted_at' => null, PembatalanOperasi::tableName() . '.bat_final' => 1])->all();
        $listLaporanIntraOperasi = IntraOperasiPerawat::find()->where(['in', 'iop_to_id', $timOperasi])->andWhere([IntraOperasiPerawat::tableName() . '.iop_deleted_at' => null, IntraOperasiPerawat::tableName() . '.iop_final' => 1])->all();
        $listLaporanPostOperasi = PostOperasiPerawat::find()->where(['in', 'psop_to_id', $timOperasi])->andWhere([PostOperasiPerawat::tableName() . '.psop_deleted_at' => null, PostOperasiPerawat::tableName() . '.psop_final' => 1])->all();
        $listLaporanInstrumentKasa = PenggunaanJumlahKasaDanInstrumen::find()->where(['in', 'pjki_to_id', $timOperasi])->andWhere([PenggunaanJumlahKasaDanInstrumen::tableName() . '.pjki_deleted_at' => null, PenggunaanJumlahKasaDanInstrumen::tableName() . '.pjki_final' => 1])->all();
        $listPreOperasiPerawatOk = PreOperasiPerawatOk::find()->where(['in', 'pop_to_id', $timOperasi])->andWhere([PreOperasiPerawatOk::tableName() . '.pop_deleted_at' => null, PreOperasiPerawatOk::tableName() . '.pop_final_ok' => 1])->all();
        $listLembarEdukasiTindakanAnestesi = LembarEdukasiTindakanAnestesi::find()->where(['in', 'leta_to_id', $timOperasi])->andWhere([LembarEdukasiTindakanAnestesi::tableName() . '.leta_deleted_at' => null, LembarEdukasiTindakanAnestesi::tableName() . '.leta_final' => 1])->all();
        $listPraAnestesi = PraAnestesi::find()->where(['in', 'ppa_to_id', $timOperasi])->andWhere([PraAnestesi::tableName() . '.ppa_deleted_at' => null, PraAnestesi::tableName() . '.ppa_final' => 1])->all();
        $listCatatanLokalAnestesi = CatatanLokalAnestesi::find()->where(['in', 'cla_to_id', $timOperasi])->andWhere([CatatanLokalAnestesi::tableName() . '.cla_deleted_at' => null, CatatanLokalAnestesi::tableName() . '.cla_final' => 1])->all();
        $listPascaLokalAnestesi = PascaLokalAnestesi::find()->where(['in', 'pla_to_id', $timOperasi])->andWhere([PascaLokalAnestesi::tableName() . '.pla_deleted_at' => null, PascaLokalAnestesi::tableName() . '.pla_final' => 1])->all();
        $listAskanPraAnestesi = AskanPraAnestesi::find()->where(['in', 'apa_to_id', $timOperasi])->andWhere([AskanPraAnestesi::tableName() . '.apa_deleted_at' => null, AskanPraAnestesi::tableName() . '.apa_final' => 1])->all();
        $listAskanIntraAnestesi = AskanIntraAnestesi::find()->where(['in', 'aia_to_id', $timOperasi])->andWhere([AskanIntraAnestesi::tableName() . '.aia_deleted_at' => null, AskanIntraAnestesi::tableName() . '.aia_final' => 1])->all();
        $listAskanPascaAnestesi = AskanPascaAnestesi::find()->where(['in', 'pas_to_id', $timOperasi])->andWhere([AskanPascaAnestesi::tableName() . '.pas_deleted_at' => null, AskanPascaAnestesi::tableName() . '.pas_final' => 1])->all();
        $listEsep = $registrasi;
        $listRingkasanPulangIgd = RingkasanPulangIgd::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();
        $listTriaseIgd = TriasePasien::find()->where(['in', 'layanan_id', $layananId])->andWhere(['batal' => 0])->all();



        $listMonitoringTtv = $this->processDokumenRme(20, $registrasi->data['kode']);
        $listAsesmenHemodialisaDokter = $this->processDokumenRme(26, $registrasi->data['kode']);
        $listAsesmenHemodialisaDokterLanjutan = $this->processDokumenRme(27, $registrasi->data['kode']);
        $listAsesmenHemodialisaKeperawatan = $this->processDokumenRme(19, $registrasi->data['kode']);
        $listAsesmenRehabMedik = $this->processDokumenRme(44, $registrasi->data['kode']);
        $listResumeRehabMedik = $this->processDokumenRme(48, $registrasi->data['kode']);
        $listResepDokterTerbaru = $this->processDokumenRme(56, $registrasi->data['kode']);


        // echo '<pre>';
        // print_r($listResumeRehabMedik);
        // die;
        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'dokterMinta',
            'dokterTujuan',
            'jawabanKonsultasi' => function ($q) {
                $q->joinWith(['dokterJawab']);
            },
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            }
        ])->where(['registrasi_kode' => $noreg, PermintaanKonsultasi::tableName() . '.batal' => 0])->orderBy(['tanggal_minta' => SORT_DESC])->asArray()->all();

        //resep
        $resep = Resep::find()->joinWith(['layanan', 'depo', 'dokter'])->where(['registrasi_kode' => $registrasi->data['kode']])->asArray()->all();
        $penjualanObat = Penjualan::find()->alias('p')->joinWith(['depo', 'dokter'])
            ->where(['p.no_daftar' => $registrasi->data['kode']])
            ->andWhere(['not', ['p.status' => 0]])
            ->orderBy(['p.id_penjualan' => SORT_DESC])->asArray()->all();

        $listPelaporan = CodingPelaporanRj::find()
            ->alias('cprj')
            ->innerJoin('coding_pelaporan_diagnosa_detail_rj pd', 'cprj.id = pd.coding_pelaporan_id')
            ->innerJoin('coding_pelaporan_tindakan_detail_rj pt', 'cprj.id = pt.coding_pelaporan_id')
            ->where(['cprj.registrasi_kode' => $registrasi->data['kode']])
            ->all();
        $listClaim = ResumeMedisRjClaim::find()->where(['registrasi_kode' => $registrasi->data['kode']])->all();
        return $this->render(
            'detail_kunjungan',
            [
                'registrasi' => $registrasi->data,
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
                'listAsesmenKebidanan' => $listAsesmenKebidanan,
                'listAsesmenMedis' => $listAsesmenMedis,
                'listLaporanOperasi' => $listLaporanOperasi,
                'listLaporanAnastesi' => $listLaporanAnastesi,
                'listResumeMedis' => $listResumeMedis,
                'listResumeMedisRj' => $listResumeMedisRj,
                'list_konsultasi' => $list_konsultasi,
                'resep' => $resep,
                'penjualanObat' => $penjualanObat,
                'listPelaporan' => $listPelaporan,
                'listClaim' => $listClaim,
                'listLaporanChecklisKeselamatan' => $listLaporanChecklisKeselamatan,
                'listLaporanLokasiOperasi' => $listLaporanLokasiOperasi,
                'listLaporanPembatalanOperasi' => $listLaporanPembatalanOperasi,
                'listLaporanIntraOperasi' => $listLaporanIntraOperasi,
                'listLaporanPostOperasi' => $listLaporanPostOperasi,
                'listLaporanInstrumentKasa' => $listLaporanInstrumentKasa,
                'listPreOperasiPerawatOk' => $listPreOperasiPerawatOk,
                'listLembarEdukasiTindakanAnestesi' => $listLembarEdukasiTindakanAnestesi,
                'listPraAnestesi' => $listPraAnestesi,
                'listCatatanLokalAnestesi' => $listCatatanLokalAnestesi,
                'listPascaLokalAnestesi' => $listPascaLokalAnestesi,
                'listAskanPraAnestesi' => $listAskanPraAnestesi,
                'listAskanIntraAnestesi' => $listAskanIntraAnestesi,
                'listAskanPascaAnestesi' => $listAskanPascaAnestesi,
                'listRingkasanPulangIgd' => $listRingkasanPulangIgd,
                'listTriaseIgd' => $listTriaseIgd,
                'listEsep' => $listEsep,
                'listMonitoringTtv' => $listMonitoringTtv,
                'listAsesmenHemodialisaDokter' => $listAsesmenHemodialisaDokter,
                'listAsesmenHemodialisaDokterLanjutan' => $listAsesmenHemodialisaDokterLanjutan,
                'listAsesmenHemodialisaKeperawatan' => $listAsesmenHemodialisaKeperawatan,
                'listAsesmenRehabMedik' => $listAsesmenRehabMedik,
                'listResumeRehabMedik' => $listResumeRehabMedik,
                'listResepDokterTerbaru' => $listResepDokterTerbaru,

            ]
        );
    }
    function actionDetailAsesmenKeperawatan($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'error'
                );
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';

        $listAsesmenKeperawatan = AsesmenAwalKeperawatanGeneral::find()->joinWith(['layanan' => function ($q) {
            $q->joinWith('registrasi');
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();



        return $this->render(
            'detail_asesmen_keperawatan',
            [
                'listAsesmenKeperawatan' => $listAsesmenKeperawatan,
            ]
        );
    }
    function actionDetailAsesmenKebidanan($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';
        $listAsesmenKebidanan = AsesmenAwalKebidanan::find()->joinWith(['layanan' => function ($q) {
            $q->joinWith('registrasi');
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id])->andWhere(['batal' => 0])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();



        return $this->render(
            'detail_asesmen_kebidanan',
            [

                'listAsesmenKebidanan' => $listAsesmenKebidanan,

            ]
        );
    }

    function actionDetailAsesmenMedis($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';




        $listAsesmenMedis = AsesmenAwalMedis::find()->joinWith(['layanan' => function ($q) {
            $q->joinWith('registrasi');
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id])->andWhere(['batal' => 0])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();



        return $this->render(
            'detail_asesmen_medis',
            [
                // 'registrasi' => $registrasi->data,

                'listAsesmenMedis' => $listAsesmenMedis,

            ]
        );
    }
    function actionDetailHasilPenunjang($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        return $this->render(
            'detail_hasil_penunjang',
            [
                'registrasi' => $registrasi->data,


            ]
        );
    }

    function actionDetailLaporanOperasi($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'detail_laporan_operasi',
                    [
                        'listLaporanOperasi' => [],

                    ]
                );
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        $listLaporanOperasi = LaporanOperasi::find()->joinWith(['timoperasi' => function ($q) {
            $q->joinWith(['layanan' => function ($e) {
                $e->joinWith('registrasi');
            }]);
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id, LaporanOperasi::tableName() . '.lap_op_deleted_at' => null, LaporanOperasi::tableName() . '.lap_op_final' => 1, LaporanOperasi::tableName() . '.lap_op_batal' => 0])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();



        return $this->render(
            'detail_laporan_operasi',
            [
                'listLaporanOperasi' => $listLaporanOperasi,

            ]
        );
    }
    function actionDetailLaporanAnastesi($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'detail_laporan_anastesi',
                    [
                        'registrasi' => [],

                        'listLaporanAnastesi' => [],

                    ]
                );
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        $listLaporanAnastesi = AsesmenPraInduksi::find()->joinWith(['timoperasi' => function ($q) {
            $q->joinWith(['layanan' => function ($e) {
                $e->joinWith('registrasi');
            }]);
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id, AsesmenPraInduksi::tableName() . '.api_deleted_at' => null, AsesmenPraInduksi::tableName() . '.api_final' => 1])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();



        return $this->render(
            'detail_laporan_anastesi',
            [
                'registrasi' => $registrasi->data,

                'listLaporanAnastesi' => $listLaporanAnastesi,

            ]
        );
    }
    function actionDetailLaporanChecklistKeselamatan($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'detail_laporan_anastesi',
                    [
                        'registrasi' => [],

                        'listLaporanAnastesi' => [],

                    ]
                );
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        $listLaporanChecklisKeselamatan = PertanyaanCheckListKeselamatanOk::find()->joinWith(['timoperasi' => function ($q) {
            $q->joinWith(['layanan' => function ($e) {
                $e->joinWith('registrasi');
            }]);
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id, PertanyaanCheckListKeselamatanOk::tableName() . '.pcok_deleted_at' => null, PertanyaanCheckListKeselamatanOk::tableName() . '.pcok_final' => 1])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();



        return $this->render(
            'detail_laporan_checklist_keselamatan',
            [
                'registrasi' => $registrasi->data,

                'listLaporanChecklisKeselamatan' => $listLaporanChecklisKeselamatan,

            ]
        );
    }
    function actionDetailLaporanMarkingOperasi($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'error'
                );
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        $listMarkingOperasi = LokasiOperasi::find()->joinWith(['timoperasi' => function ($q) {
            $q->joinWith(['layanan' => function ($e) {
                $e->joinWith('registrasi');
            }]);
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id, LokasiOperasi::tableName() . '.mlo_deleted_at' => null, LokasiOperasi::tableName() . '.mlo_final' => 1])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();



        return $this->render(
            'detail_laporan_marking_operasi',
            [
                'registrasi' => $registrasi->data,

                'listMarkingOperasi' => $listMarkingOperasi,

            ]
        );
    }
    function actionDetailLaporanPembatalanOperasi($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'error'
                );
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        $listPembatalanOperasi = PembatalanOperasi::find()->joinWith(['timoperasi' => function ($q) {
            $q->joinWith(['layanan' => function ($e) {
                $e->joinWith('registrasi');
            }]);
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id, PembatalanOperasi::tableName() . '.bat_deleted_at' => null, PembatalanOperasi::tableName() . '.bat_final' => 1])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();



        return $this->render(
            'detail_laporan_pembatalan_operasi',
            [
                'registrasi' => $registrasi->data,

                'listPembatalanOperasi' => $listPembatalanOperasi,

            ]
        );
    }
    function actionDetailLaporanAskanIntraOperasi($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'error'
                );
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        $listIntraOperasiPerawat = IntraOperasiPerawat::find()->joinWith(['timoperasi' => function ($q) {
            $q->joinWith(['layanan' => function ($e) {
                $e->joinWith('registrasi');
            }]);
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id, IntraOperasiPerawat::tableName() . '.iop_deleted_at' => null, IntraOperasiPerawat::tableName() . '.iop_final' => 1])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();



        return $this->render(
            'detail_laporan_askan_intra_operasi',
            [
                'registrasi' => $registrasi->data,

                'listIntraOperasiPerawat' => $listIntraOperasiPerawat,

            ]
        );
    }
    function actionDetailLaporanPostOperasi($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'error'
                );
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        $listPostOperasiPerawat = PostOperasiPerawat::find()->joinWith(['timoperasi' => function ($q) {
            $q->joinWith(['layanan' => function ($e) {
                $e->joinWith('registrasi');
            }]);
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id, PostOperasiPerawat::tableName() . '.psop_deleted_at' => null, PostOperasiPerawat::tableName() . '.psop_final' => 1])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();



        return $this->render(
            'detail_laporan_post_operasi',
            [
                'registrasi' => $registrasi->data,

                'listPostOperasiPerawat' => $listPostOperasiPerawat,

            ]
        );
    }
    function actionDetailLaporanInstrumentKasa($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'error'
                );
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        $listInstrumentKasa = PenggunaanJumlahKasaDanInstrumen::find()->joinWith(['timoperasi' => function ($q) {
            $q->joinWith(['layanan' => function ($e) {
                $e->joinWith('registrasi');
            }]);
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id, PenggunaanJumlahKasaDanInstrumen::tableName() . '.pjki_deleted_at' => null, PenggunaanJumlahKasaDanInstrumen::tableName() . '.pjki_final' => 1])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();



        return $this->render(
            'detail_laporan_instrument_kasa',
            [
                'registrasi' => $registrasi->data,

                'listInstrumentKasa' => $listInstrumentKasa,

            ]
        );
    }


    function actionDetailLaporanAskepPreOperasiPerawat($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'error'
                );
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        $listPreOperasiPerawatOk = PreOperasiPerawatOk::find()->joinWith(['timoperasi' => function ($q) {
            $q->joinWith(['layanan' => function ($e) {
                $e->joinWith('registrasi');
            }]);
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id, PreOperasiPerawatOk::tableName() . '.pop_deleted_at' => null, PreOperasiPerawatOk::tableName() . '.pop_final_ok' => 1])->andWhere(['not', [PreOperasiPerawatOk::tableName() . '.pop_tgl_final' => null]])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();



        return $this->render(
            'detail_laporan_askep_pre_operasi_perawat',
            [
                'registrasi' => $registrasi->data,

                'listPreOperasiPerawatOk' => $listPreOperasiPerawatOk,

            ]
        );
    }

    function actionDetailLaporanLembarEdukasiAnestesi($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'error'
                );
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        $listLembarEdukasiTindakanAnestesi = LembarEdukasiTindakanAnestesi::find()->joinWith(['timoperasi' => function ($q) {
            $q->joinWith(['layanan' => function ($e) {
                $e->joinWith('registrasi');
            }]);
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id, LembarEdukasiTindakanAnestesi::tableName() . '.leta_deleted_at' => null, LembarEdukasiTindakanAnestesi::tableName() . '.leta_final' => 1])->andWhere(['not', [LembarEdukasiTindakanAnestesi::tableName() . '.leta_tgl_final' => null]])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();



        return $this->render(
            'detail_laporan_lembar_edukasi_anestesi',
            [
                'registrasi' => $registrasi->data,

                'listLembarEdukasiTindakanAnestesi' => $listLembarEdukasiTindakanAnestesi,

            ]
        );
    }

    //Function laporan pra anestesi
    function actionDetailLaporanPraAnestesi($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'error'
                );
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        $listPraAnestesi = PraAnestesi::find()->joinWith(['timoperasi' => function ($q) {
            $q->joinWith(['layanan' => function ($e) {
                $e->joinWith('registrasi');
            }]);
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id, PraAnestesi::tableName() . '.ppa_deleted_at' => null, PraAnestesi::tableName() . '.ppa_final' => 1])->andWhere(['not', [PraAnestesi::tableName() . '.ppa_tgl_final' => null]])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();



        return $this->render(
            'detail_laporan_pra_anestesi',
            [
                'registrasi' => $registrasi->data,

                'listPraAnestesi' => $listPraAnestesi,

            ]
        );
    }

    //Function catatan lokal anestesi
    function actionDetailLaporanCatatanLokalAnestesi($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'error'
                );
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        $listCatatanLokalAnestesi = CatatanLokalAnestesi::find()->joinWith(['timoperasi' => function ($q) {
            $q->joinWith(['layanan' => function ($e) {
                $e->joinWith('registrasi');
            }]);
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id, CatatanLokalAnestesi::tableName() . '.cla_deleted_at' => null,  CatatanLokalAnestesi::tableName() . '.cla_final' => 1])->andWhere(['not', [CatatanLokalAnestesi::tableName() . '.cla_tgl_final' => null]])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();



        return $this->render(
            'detail_laporan_catatan_lokal_anestesi',
            [
                'registrasi' => $registrasi->data,

                'listCatatanLokalAnestesi' => $listCatatanLokalAnestesi,

            ]
        );
    }

    //Function pasca lokal anestesi
    function actionDetailLaporanPascaLokalAnestesi($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'error'
                );
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        $listPascaLokalAnestesi = PascaLokalAnestesi::find()->joinWith(['timoperasi' => function ($q) {
            $q->joinWith(['layanan' => function ($e) {
                $e->joinWith('registrasi');
            }]);
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id, PascaLokalAnestesi::tableName() . '.pla_deleted_at' => null, PascaLokalAnestesi::tableName() . '.pla_final' => 1])->andWhere(['not', [PascaLokalAnestesi::tableName() . '.pla_tgl_final' => null]])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();



        return $this->render(
            'detail_laporan_pasca_lokal_anestesi',
            [
                'registrasi' => $registrasi->data,

                'listPascaLokalAnestesi' => $listPascaLokalAnestesi,

            ]
        );
    }

    //Function asuhan kepenataan pra anestesi
    function actionDetailLaporanAsuhanKepenataanPraAnestesi($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'error'
                );
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        $listAskanPraAnestesi = AskanPraAnestesi::find()->joinWith(['timoperasi' => function ($q) {
            $q->joinWith(['layanan' => function ($e) {
                $e->joinWith('registrasi');
            }]);
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id, AskanPraAnestesi::tableName() . '.apa_deleted_at' => null,  AskanPraAnestesi::tableName() . '.apa_final' => 1])->andWhere(['not', [AskanPraAnestesi::tableName() . '.apa_tgl_final' => null]])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();



        return $this->render(
            'detail_laporan_askan_pra_anestesi',
            [
                'registrasi' => $registrasi->data,

                'listAskanPraAnestesi' => $listAskanPraAnestesi,

            ]
        );
    }

    //Function asuhan kepenataan intra anestesi
    function actionDetailLaporanAsuhanKepenataanIntraAnestesi($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'error'
                );
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        $listAskanIntraAnestesi = AskanIntraAnestesi::find()->joinWith(['timoperasi' => function ($q) {
            $q->joinWith(['layanan' => function ($e) {
                $e->joinWith('registrasi');
            }]);
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id, AskanIntraAnestesi::tableName() . '.aia_deleted_at' => null,  AskanIntraAnestesi::tableName() . '.aia_final' => 1])->andWhere(['not', [AskanIntraAnestesi::tableName() . '.aia_tgl_final' => null]])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();



        return $this->render(
            'detail_laporan_askan_intra_anestesi',
            [
                'registrasi' => $registrasi->data,

                'listAskanIntraAnestesi' => $listAskanIntraAnestesi,

            ]
        );
    }

    //Function asuhan kepenataan intra anestesi
    function actionDetailLaporanAsuhanKepenataanPascaAnestesi($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'error'
                );
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        $listAskanPascaAnestesi = AskanPascaAnestesi::find()->joinWith(['timoperasi' => function ($q) {
            $q->joinWith(['layanan' => function ($e) {
                $e->joinWith('registrasi');
            }]);
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id, AskanPascaAnestesi::tableName() . '.pas_deleted_at' => null,  AskanPascaAnestesi::tableName() . '.pas_final' => 1])->andWhere(['not', [AskanPascaAnestesi::tableName() . '.pas_tgl_final' => null]])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();



        return $this->render(
            'detail_laporan_askan_pasca_anestesi',
            [
                'registrasi' => $registrasi->data,

                'listAskanPascaAnestesi' => $listAskanPascaAnestesi,

            ]
        );
    }

    //Function asuhan kepenataan intra anestesi
    function actionDetailRingkasanPulangIgd($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'error'
                );
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        $listRingkasanPulangIgd = RingkasanPulangIgd::find()->joinWith(['layanan' => function ($e) {
            $e->joinWith('registrasi');
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();



        return $this->render(
            'detail_ringkasan_pulang_igd',
            [
                'registrasi' => $registrasi->data,

                'listRingkasanPulangIgd' => $listRingkasanPulangIgd,

            ]
        );
    }
    //Function asuhan kepenataan intra anestesi
    function actionDetailTriaseIgd($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'error'
                );
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        $listTriasePasien = TriasePasien::find()->joinWith(['layanan' => function ($e) {
            $e->with('unit');
            $e->joinWith(['registrasi']);
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();
        return $this->render(
            'detail_triase_igd',
            [
                'registrasi' => $registrasi->data,
                'listTriasePasien' => $listTriasePasien,

            ]
        );
    }

    function actionDetailMonitoringTtv($id)
    {
        $dokumenRmeFix = []; // Inisialisasi variabel di awal

        $this->layout = 'main-riwayat';

        // Validasi ID
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                return $this->render('detail_monitoring_ttv', [
                    'registrasi' => [],
                    'listRegistrasi' => [],
                ]);
            }
        } else {
            return $this->render('detail_monitoring_ttv', [
                'registrasi' => [],
                'listRegistrasi' => [],
            ]);
        }

        // Ambil data registrasi
        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == null || !isset($registrasi->data['pasien']['kode'])) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }



        $dokumenRme = Dokumen::find()->with('dokumenDetail')->where(['id_dokumen' => '20'])->orderBy('urutan', SORT_ASC)->asArray()->all();
        foreach ($dokumenRme as $item) {
            if (isset($item['query_search_riwayat_by_norm']) && $item['query_search_riwayat_by_norm'] != null) {
                $query = str_replace('$', $registrasi->data['pasien']['kode'], $item['query_search_riwayat_by_norm']);
                $data = Yii::$app->db_medis->createCommand($query)->queryAll();
                $item['data'] = $data;

                // Mengisi kolom 'keterangan' berdasarkan sub query jika ada
                foreach ($item['data'] as &$value) {

                    $value['url_lihat'] = null;
                    $value['url_cetak'] = null;

                    foreach ($item['dokumenDetail'] as $subvalue) {
                        if ($subvalue['versi'] == $value['versi']) {
                            if (!empty($subvalue['key_hash_code'])) {
                                $value['url_lihat'] = str_replace('$', HelperGeneral::hashDataCustom($value[$subvalue['name_colums_params_url']], $subvalue['key_hash_code']), $subvalue['url_lihat']);
                                $value['url_cetak'] = str_replace('$', HelperGeneral::hashDataCustom($value[$subvalue['name_colums_params_url']], $subvalue['key_hash_code']), $subvalue['url_cetak']);
                            } else {
                                $value['url_lihat'] = str_replace('$', $value[$subvalue['name_colums_params_url']], $subvalue['url_lihat']);
                                $value['url_cetak'] = str_replace('$', $value[$subvalue['name_colums_params_url']], $subvalue['url_cetak']);
                            }
                        }
                    }
                }

                $dokumenRmeFix[] = $item;
            }
        }

        return $this->render('detail_monitoring_ttv', [
            'registrasi' => $registrasi->data ?? [],
            'dokumenRme' => $dokumenRmeFix ?? [],
        ]);
    }

    function actionDetailAsesmenHdAwal($id)
    {
        $dokumenRmeFix = []; // Inisialisasi variabel di awal

        $this->layout = 'main-riwayat';

        // Validasi ID
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                return $this->render('detail_asesmen_hd_awal', [
                    'registrasi' => [],
                    'listRegistrasi' => [],
                ]);
            }
        } else {
            return $this->render('detail_asesmen_hd_awal', [
                'registrasi' => [],
                'listRegistrasi' => [],
            ]);
        }

        // Ambil data registrasi
        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == null || !isset($registrasi->data['pasien']['kode'])) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }




        $dokumenRme = Dokumen::find()->with('dokumenDetail')->where(['id_dokumen' => '26'])->orderBy('urutan', SORT_ASC)->asArray()->all();
        foreach ($dokumenRme as $item) {
            if (isset($item['query_search_riwayat_by_norm']) && $item['query_search_riwayat_by_norm'] != null) {
                $query = str_replace('$', $registrasi->data['pasien']['kode'], $item['query_search_riwayat_by_norm']);
                $data = Yii::$app->db_medis->createCommand($query)->queryAll();
                $item['data'] = $data;

                // Mengisi kolom 'keterangan' berdasarkan sub query jika ada
                foreach ($item['data'] as &$value) {

                    $value['url_lihat'] = null;
                    $value['url_cetak'] = null;

                    foreach ($item['dokumenDetail'] as $subvalue) {
                        if ($subvalue['versi'] == $value['versi']) {
                            if (!empty($subvalue['key_hash_code'])) {
                                $value['url_lihat'] = str_replace('$', HelperGeneral::hashDataCustom($value[$subvalue['name_colums_params_url']], $subvalue['key_hash_code']), $subvalue['url_lihat']);
                                $value['url_cetak'] = str_replace('$', HelperGeneral::hashDataCustom($value[$subvalue['name_colums_params_url']], $subvalue['key_hash_code']), $subvalue['url_cetak']);
                            } else {
                                $value['url_lihat'] = str_replace('$', $value[$subvalue['name_colums_params_url']], $subvalue['url_lihat']);
                                $value['url_cetak'] = str_replace('$', $value[$subvalue['name_colums_params_url']], $subvalue['url_cetak']);
                            }
                        }
                    }
                }

                $dokumenRmeFix[] = $item;
            }
        }

        return $this->render('detail_asesmen_hd_awal', [
            'registrasi' => $registrasi->data ?? [],
            'dokumenRme' => $dokumenRmeFix ?? [],
        ]);
    }


    function actionDetailAsesmenHdAwalLanjutan($id)
    {
        $dokumenRmeFix = []; // Inisialisasi variabel di awal

        $this->layout = 'main-riwayat';

        // Validasi ID
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                return $this->render('detail_asesmen_hd_awal_lanjutan', [
                    'registrasi' => $registrasi->data ?? [],
                    'dokumenRme' => $dokumenRmeFix ?? [],
                ]);
            }
        } else {
            return $this->render('detail_asesmen_hd_awal_lanjutan', [
                'registrasi' => $registrasi->data ?? [],
                'dokumenRme' => $dokumenRmeFix ?? [],
            ]);
        }

        // Ambil data registrasi
        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == null || !isset($registrasi->data['pasien']['kode'])) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }


        $dokumenRme = Dokumen::find()->with('dokumenDetail')->where(['id_dokumen' => '27'])->orderBy('urutan', SORT_ASC)->asArray()->all();
        foreach ($dokumenRme as $item) {
            if (isset($item['query_search_riwayat_by_norm']) && $item['query_search_riwayat_by_norm'] != null) {
                $query = str_replace('$', $registrasi->data['pasien']['kode'], $item['query_search_riwayat_by_norm']);
                $data = Yii::$app->db_medis->createCommand($query)->queryAll();
                $item['data'] = $data;

                // Mengisi kolom 'keterangan' berdasarkan sub query jika ada
                foreach ($item['data'] as &$value) {

                    $value['url_lihat'] = null;
                    $value['url_cetak'] = null;

                    foreach ($item['dokumenDetail'] as $subvalue) {
                        if ($subvalue['versi'] == $value['versi']) {
                            if (!empty($subvalue['key_hash_code'])) {
                                $value['url_lihat'] = str_replace('$', HelperGeneral::hashDataCustom($value[$subvalue['name_colums_params_url']], $subvalue['key_hash_code']), $subvalue['url_lihat']);
                                $value['url_cetak'] = str_replace('$', HelperGeneral::hashDataCustom($value[$subvalue['name_colums_params_url']], $subvalue['key_hash_code']), $subvalue['url_cetak']);
                            } else {
                                $value['url_lihat'] = str_replace('$', $value[$subvalue['name_colums_params_url']], $subvalue['url_lihat']);
                                $value['url_cetak'] = str_replace('$', $value[$subvalue['name_colums_params_url']], $subvalue['url_cetak']);
                            }
                        }
                    }
                }

                $dokumenRmeFix[] = $item;
            }
        }




        return $this->render('detail_asesmen_hd_awal_lanjutan', [
            'registrasi' => $registrasi->data ?? [],
            'dokumenRme' => $dokumenRmeFix ?? [],

        ]);
    }

    function actionDetailAsesmenHdKeperawatan($id)
    {
        $dokumenRmeFix = []; // Inisialisasi variabel di awal

        $this->layout = 'main-riwayat';

        // Validasi ID
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                return $this->render('detail_asesmen_hd_keperawatan', [
                    'registrasi' => $registrasi->data ?? [],
                    'dokumenRme' => $dokumenRmeFix ?? [],
                ]);
            }
        } else {
            return $this->render('detail_asesmen_hd_keperawatan', [
                'registrasi' => $registrasi->data ?? [],
                'dokumenRme' => $dokumenRmeFix ?? [],
            ]);
        }

        // Ambil data registrasi
        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == null || !isset($registrasi->data['pasien']['kode'])) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        // Ambil daftar Registrasi berdasarkan kode pasien


        $dokumenRme = Dokumen::find()->with('dokumenDetail')->where(['id_dokumen' => '19'])->orderBy('urutan', SORT_ASC)->asArray()->all();
        foreach ($dokumenRme as $item) {
            if (isset($item['query_search_riwayat_by_norm']) && $item['query_search_riwayat_by_norm'] != null) {
                $query = str_replace('$', $registrasi->data['pasien']['kode'], $item['query_search_riwayat_by_norm']);
                $data = Yii::$app->db_medis->createCommand($query)->queryAll();
                $item['data'] = $data;

                // Mengisi kolom 'keterangan' berdasarkan sub query jika ada
                foreach ($item['data'] as &$value) {

                    $value['url_lihat'] = null;
                    $value['url_cetak'] = null;

                    foreach ($item['dokumenDetail'] as $subvalue) {
                        if ($subvalue['versi'] == $value['versi']) {
                            if (!empty($subvalue['key_hash_code'])) {
                                $value['url_lihat'] = str_replace('$', HelperGeneral::hashDataCustom($value[$subvalue['name_colums_params_url']], $subvalue['key_hash_code']), $subvalue['url_lihat']);
                                $value['url_cetak'] = str_replace('$', HelperGeneral::hashDataCustom($value[$subvalue['name_colums_params_url']], $subvalue['key_hash_code']), $subvalue['url_cetak']);
                            } else {
                                $value['url_lihat'] = str_replace('$', $value[$subvalue['name_colums_params_url']], $subvalue['url_lihat']);
                                $value['url_cetak'] = str_replace('$', $value[$subvalue['name_colums_params_url']], $subvalue['url_cetak']);
                            }
                        }
                    }
                }

                $dokumenRmeFix[] = $item;
            }
        }



        return $this->render('detail_asesmen_hd_keperawatan', [
            'registrasi' => $registrasi->data ?? [],
            'dokumenRme' => $dokumenRmeFix ?? [],
        ]);
    }

    function actionDetailResumeRehabMedik($id)
    {
        $dokumenRmeFix = []; // Inisialisasi variabel di awal

        $this->layout = 'main-riwayat';

        // Validasi ID
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                return $this->render('detail_resume_rehab_medik', [
                    'registrasi' => $registrasi->data ?? [],
                    'dokumenRme' => $dokumenRmeFix ?? [],
                ]);
            }
        } else {
            return $this->render('detail_resume_rehab_medik', [
                'registrasi' => $registrasi->data ?? [],
                'dokumenRme' => $dokumenRmeFix ?? [],
            ]);
        }

        // Ambil data registrasi
        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == null || !isset($registrasi->data['pasien']['kode'])) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        // Ambil daftar Registrasi berdasarkan kode pasien



        $dokumenRme = Dokumen::find()->with('dokumenDetail')->where(['id_dokumen' => '48'])->orderBy('urutan', SORT_ASC)->asArray()->all();
        foreach ($dokumenRme as $item) {
            if (isset($item['query_search_riwayat_by_norm']) && $item['query_search_riwayat_by_norm'] != null) {
                $query = str_replace('$', $registrasi->data['pasien']['kode'], $item['query_search_riwayat_by_norm']);
                $data = Yii::$app->db_medis->createCommand($query)->queryAll();
                $item['data'] = $data;

                // Mengisi kolom 'keterangan' berdasarkan sub query jika ada
                foreach ($item['data'] as &$value) {

                    $value['url_lihat'] = null;
                    $value['url_cetak'] = null;

                    foreach ($item['dokumenDetail'] as $subvalue) {
                        if ($subvalue['versi'] == $value['versi']) {
                            if (!empty($subvalue['key_hash_code'])) {
                                $value['url_lihat'] = str_replace('$', HelperGeneral::hashDataCustom($value[$subvalue['name_colums_params_url']], $subvalue['key_hash_code']), $subvalue['url_lihat']);
                                $value['url_cetak'] = str_replace('$', HelperGeneral::hashDataCustom($value[$subvalue['name_colums_params_url']], $subvalue['key_hash_code']), $subvalue['url_cetak']);
                            } else {
                                $value['url_lihat'] = str_replace('$', $value[$subvalue['name_colums_params_url']], $subvalue['url_lihat']);
                                $value['url_cetak'] = str_replace('$', $value[$subvalue['name_colums_params_url']], $subvalue['url_cetak']);
                            }
                        }
                    }
                }

                $dokumenRmeFix[] = $item;
            }
        }


        return $this->render('detail_resume_rehab_medik', [
            'registrasi' => $registrasi->data ?? [],
            'dokumenRme' => $dokumenRmeFix ?? [],
        ]);
    }


    function actionDetailAsesmenRehabMedik($id)
    {
        $dokumenRmeFix = []; // Inisialisasi variabel di awal

        $this->layout = 'main-riwayat';

        // Validasi ID
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                return $this->render('detail_asesmen_rehab_medik', [
                    'registrasi' => [],
                    'listRegistrasi' => [],
                ]);
            }
        } else {
            return $this->render('detail_asesmen_rehab_medik', [
                'registrasi' => [],
                'listRegistrasi' => [],
            ]);
        }

        // Ambil data registrasi
        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == null || !isset($registrasi->data['pasien']['kode'])) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        // Ambil daftar Registrasi berdasarkan kode pasien

        $dokumenRme = Dokumen::find()->with('dokumenDetail')->where(['id_dokumen' => '44'])->orderBy('urutan', SORT_ASC)->asArray()->all();
        foreach ($dokumenRme as $item) {
            if (isset($item['query_search_riwayat_by_norm']) && $item['query_search_riwayat_by_norm'] != null) {
                $query = str_replace('$', $registrasi->data['pasien']['kode'], $item['query_search_riwayat_by_norm']);
                $data = Yii::$app->db_medis->createCommand($query)->queryAll();
                $item['data'] = $data;

                // Mengisi kolom 'keterangan' berdasarkan sub query jika ada
                foreach ($item['data'] as &$value) {

                    $value['url_lihat'] = null;
                    $value['url_cetak'] = null;

                    foreach ($item['dokumenDetail'] as $subvalue) {
                        if ($subvalue['versi'] == $value['versi']) {
                            if (!empty($subvalue['key_hash_code'])) {
                                $value['url_lihat'] = str_replace('$', HelperGeneral::hashDataCustom($value[$subvalue['name_colums_params_url']], $subvalue['key_hash_code']), $subvalue['url_lihat']);
                                $value['url_cetak'] = str_replace('$', HelperGeneral::hashDataCustom($value[$subvalue['name_colums_params_url']], $subvalue['key_hash_code']), $subvalue['url_cetak']);
                            } else {
                                $value['url_lihat'] = str_replace('$', $value[$subvalue['name_colums_params_url']], $subvalue['url_lihat']);
                                $value['url_cetak'] = str_replace('$', $value[$subvalue['name_colums_params_url']], $subvalue['url_cetak']);
                            }
                        }
                    }
                }

                $dokumenRmeFix[] = $item;
            }
        }

        return $this->render('detail_asesmen_rehab_medik', [
            'registrasi' => $registrasi->data ?? [],
            'dokumenRme' => $dokumenRmeFix ?? [],
        ]);
    }

    function actionDetailResepDokterTerbaru($id)
    {
        $dokumenRmeFix = []; // Inisialisasi variabel di awal

        $this->layout = 'main-riwayat';

        // Validasi ID
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                return $this->render('detail_resep_dokter_terbaru', [
                    'registrasi' => [],
                    'listRegistrasi' => [],
                ]);
            }
        } else {
            return $this->render('detail_resep_dokter_terbaru', [
                'registrasi' => [],
                'listRegistrasi' => [],
            ]);
        }

        // Ambil data registrasi
        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == null || !isset($registrasi->data['pasien']['kode'])) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        // Ambil daftar Registrasi berdasarkan kode pasien

        $dokumenRme = Dokumen::find()->with('dokumenDetail')->where(['id_dokumen' => '56'])->orderBy('urutan', SORT_ASC)->asArray()->all();
        foreach ($dokumenRme as $item) {
            if (isset($item['query_search_riwayat_by_norm']) && $item['query_search_riwayat_by_norm'] != null) {
                $query = str_replace('$', $registrasi->data['pasien']['kode'], $item['query_search_riwayat_by_norm']);
                $data = Yii::$app->db_medis->createCommand($query)->queryAll();
                $item['data'] = $data;

                // Mengisi kolom 'keterangan' berdasarkan sub query jika ada
                foreach ($item['data'] as &$value) {

                    $value['url_lihat'] = null;
                    $value['url_cetak'] = null;

                    foreach ($item['dokumenDetail'] as $subvalue) {
                        if ($subvalue['versi'] == $value['versi']) {
                            if (!empty($subvalue['key_hash_code'])) {
                                $value['url_lihat'] = str_replace('$', HelperGeneral::hashDataCustom($value[$subvalue['name_colums_params_url']], $subvalue['key_hash_code']), $subvalue['url_lihat']);
                                $value['url_cetak'] = str_replace('$', HelperGeneral::hashDataCustom($value[$subvalue['name_colums_params_url']], $subvalue['key_hash_code']), $subvalue['url_cetak']);
                            } else {
                                $value['url_lihat'] = str_replace('$', $value[$subvalue['name_colums_params_url']], $subvalue['url_lihat']);
                                $value['url_cetak'] = str_replace('$', $value[$subvalue['name_colums_params_url']], $subvalue['url_cetak']);
                            }
                        }
                    }
                }

                $dokumenRmeFix[] = $item;
            }
        }

        return $this->render('detail_resep_dokter_terbaru', [
            'registrasi' => $registrasi->data ?? [],
            'dokumenRme' => $dokumenRmeFix ?? [],
        ]);
    }



    function actionDetailCppt($id)
    {
        $this->layout = 'main-riwayat';

        // Validasi ID
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                return $this->render('detail_cppt', [
                    'registrasi' => [],
                    'listRegistrasi' => [],
                ]);
            }
        } else {
            return $this->render('detail_cppt', [
                'registrasi' => [],
                'listRegistrasi' => [],
            ]);
        }

        // Ambil data registrasi
        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == null || !isset($registrasi->data['pasien']['kode'])) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        // Ambil daftar Registrasi berdasarkan kode pasien
        $listRegistrasi = Registrasi::find()
            ->where(['pasien_kode' => $registrasi->data['pasien']['kode']])
            ->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])
            ->all();

        return $this->render('detail_cppt', [
            'registrasi' => $registrasi->data ?? [],
            'listRegistrasi' => $listRegistrasi ?? [],
        ]);
    }


    function actionDetailEsep($id)
    {
        $this->layout = 'main-riwayat';

        // Validasi ID
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                return $this->render('detail_esep', [
                    'registrasi' => [],
                    'listEsep' => [],
                ]);
            }
        } else {
            return $this->render('detail_esep', [
                'registrasi' => [],
                'listEsep' => [],
            ]);
        }

        // Ambil data registrasi
        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == null || !isset($registrasi->data['pasien']['kode'])) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        // Ambil daftar Esep berdasarkan kode pasien
        $listEsep = Registrasi::find()
            ->where(['pasien_kode' => $registrasi->data['pasien']['kode']])
            ->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])
            ->all();

        return $this->render('detail_esep', [
            'registrasi' => $registrasi->data ?? [],
            'listEsep' => $listEsep ?? [],
        ]);
    }


    function actionDetailRincianBiaya($id)
    {
        $this->layout = 'main-riwayat';

        // Validasi ID
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                return $this->render('detail_rincian_biaya', [
                    'registrasi' => [],
                    'listRegistrasi' => [],
                ]);
            }
        } else {
            return $this->render('detail_rincian_biaya', [
                'registrasi' => [],
                'listRegistrasi' => [],
            ]);
        }

        // Ambil data registrasi
        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == null || !isset($registrasi->data['pasien']['kode'])) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        // Ambil daftar Registrasi berdasarkan kode pasien
        $listRegistrasi = Registrasi::find()
            ->where(['pasien_kode' => $registrasi->data['pasien']['kode']])
            ->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])
            ->all();

        return $this->render('detail_rincian_biaya', [
            'registrasi' => $registrasi->data ?? [],
            'listRegistrasi' => $listRegistrasi ?? [],
        ]);
    }


    function actionDetailResumeRawatInap($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'detail_resume_rawat_inap',
                    [
                        'registrasi' => [],

                        'listResumeMedis' => [],

                    ]
                );
            }
        }
        $pasien = NULL;
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }


        $listResumeMedis = ResumeMedisRi::find()->joinWith(['layanan' => function ($q) {
            $q->joinWith('registrasi');
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id])->andWhere(['batal' => 0])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();

        return $this->render(
            'detail_resume_rawat_inap',
            [
                'registrasi' => $registrasi->data,

                'listResumeMedis' => $listResumeMedis,

            ]
        );
    }
    function actionDetailResumeRawatJalan($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'detail_resume_rawat_jalan',
                    [
                        'registrasi' => [],

                        'listResumeMedisRj' => [],

                    ]
                );
            }
        }
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }

        $listResumeMedisRj = ResumeMedisRj::find()->joinWith(['layanan' => function ($q) {
            $q->joinWith('registrasi');
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id])->andWhere(['batal' => 0])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();
        // return print_r($listResumeMedis);
        return $this->render(
            'detail_resume_rawat_jalan',
            [
                'registrasi' => $registrasi->data,

                'listResumeMedisRj' => $listResumeMedisRj,

            ]
        );
    }

    function actionDetailRiwayatKonsultasi($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'detail_riwayat_konsultasi',
                    [
                        'registrasi' => [],

                        'list_konsultasi' => [],

                    ]
                );
            }
        }
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }


        //list konsultasi
        $list_konsultasi = PermintaanKonsultasi::find()->joinWith([
            'unitTujuan',
            'dokterMinta',
            'dokterTujuan',
            'jawabanKonsultasi' => function ($q) {
                $q->joinWith(['dokterJawab']);
            },
            'layananMinta' => function ($q) {
                $q->joinWith('registrasi');
            }
        ])->where([Registrasi::tableName() . '.pasien_kode' => $id])->andWhere([PermintaanKonsultasi::tableName() . '.batal' => 0])->orderBy([Registrasi::tableName() . '.tgl_masuk' => SORT_DESC])->all();

        // return print_r($list_konsultasi);

        return $this->render(
            'detail_riwayat_konsultasi',
            [
                'registrasi' => $registrasi->data,

                'list_konsultasi' => $list_konsultasi,
                'is_ajax' => false
            ]
        );
    }

    function actionDetailResepObat($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'detail_resep_obat',
                    [
                        'registrasi' => [],

                        'resep' => [],

                    ]
                );
            }
        }
        $this->layout = 'main-riwayat';


        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }




        $resep = Resep::find()->joinWith(['layanan' => function ($q) {
            $q->joinWith('registrasi');
        }])->joinWith(['depo', 'dokter'])->joinWith(['resepDetail' => function ($q) {
            $q->joinWith('obat');
        }])->where([Registrasi::tableName() . '.pasien_kode' => $id])->orderBy(['tanggal' => SORT_DESC])->asArray()->all();
        // return print_r($resep);
        return $this->render(
            'detail_resep_obat',
            [
                'registrasi' => $registrasi->data,

                'resep' => $resep,

            ]
        );
    }

    function actionDetailObatTerjual($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);
            if (!$id) {
                $this->layout = 'main-riwayat';
                return $this->render(
                    'detail_obat_terjual',
                    [
                        'registrasi' => [],

                        'resep' => [],

                    ]
                );
            }
        }
        $this->layout = 'main-riwayat';
        $registrasi = HelperSpesialClass::getCheckObjectPasien($id);
        if ($registrasi == NULL) {
            throw new NotFoundHttpException('Data kunjungan tidak ditemukan, silahkan hubungi IT Administrator');
        }
        $penjualanObat = Penjualan::find()->alias('p')->joinWith('penjualanDetail')->joinWith(['depo', 'dokter'])
            ->where(['p.no_rm' => $id])
            ->andWhere(['not', ['p.status' => 0]])
            ->groupBy('p.no_daftar', 'p.id_penjualan')->groupBy('p.no_daftar,p.id_penjualan')->orderBy(['p.id_penjualan' => SORT_DESC])->asArray()->all();

        return $this->render(
            'detail_obat_terjual',
            [
                'registrasi' => $registrasi->data,

                'resep' => $penjualanObat,

            ]
        );
    }
    function actionDetailKonsultasi()
    {

        $req = Yii::$app->request;
        if ($req->isAjax) {
            $id = $req->post('id');
            if ($id != null) {
                $id = Lib::validateData($id);

                if (!$id) {

                    $this->layout = 'main-riwayat';
                    return $this->render('error');
                }
            }
            $data = PermintaanKonsultasi::find()->joinWith([
                'dokterMinta',
                'layananMinta' => function ($q) {
                    $q->joinWith(['unit']);
                },
                'unitTujuan',
                'dokterTujuan',
                'jawabanKonsultasi' => function ($q) {
                    $q->joinWith([
                        'dokterJawab',
                        'layananJawab' => function ($q) {
                            $q->joinWith(['unit']);
                        }
                    ]);
                }
            ])->where([PermintaanKonsultasi::tableName() . '.id' => $id])->asArray()->limit(1)->one();
            $pasien = Pasien::find()->joinWith([
                'registrasi' => function ($q) use ($data) {
                    $q->joinWith([
                        'layanan' => function ($q) use ($data) {
                            $q->where(['id' => $data['layanan_id_minta']]);
                        }
                    ]);
                }
            ])->limit(1)->one();
            return $this->renderAjax('konsultasi_detail', [
                'data' => $data,
                'pasien' => $pasien,
                'is_ajax' => true
            ]);
        }
    }
    function actionDetailResep()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $id = $req->post('id');
            if ($id != null) {
                $id = Lib::validateData($id);

                if (!$id) {

                    $this->layout = 'main-riwayat';
                    return $this->render('error');
                }
            }
            $data = Resep::find()->joinWith([
                'resepDetail' => function ($q) {
                    $q->joinWith(['obat']);
                },
                'layanan',
                'depo',
                'dokter'
            ])->where([Resep::tableName() . '.id' => $id])->asArray()->limit(1)->one();
            return $this->renderAjax('resep_detail', [
                'data' => $data,
            ]);
        }
    }
    function actionDetailObatTerjualFarmasi()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $id = $req->post('id');
            if ($id != null) {
                $id = Lib::validateData($id);

                if (!$id) {

                    $this->layout = 'main-riwayat';
                    return $this->render('error');
                }
            }
            $data = Penjualan::find()->joinWith([
                'penjualanDetail' => function ($q) {
                    $q->joinWith(['barang', 'barangGanti']);
                },
                'depo',
                'dokter'
            ])->where([Penjualan::tableName() . '.id_penjualan' => $id])->asArray()->limit(1)->one();
            return $this->renderAjax('detail_obat_terjual_farmasi', [
                'data' => $data,
            ]);
        }
    }
    function actionDetailResumeRj()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $id = $req->post('id');
            if ($id != null) {
                $id = Lib::validateData($id);

                if (!$id) {

                    $this->layout = 'main-riwayat';
                    return $this->render('error');
                }
            }
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
            return $this->renderAjax('resume-medis-rj', [
                'resume' => $resume,
                'pasien' => $pasien,
                'is_ajax' => true
            ]);
        }
    }



    public function actionListPasien()
    {
        if (HelperSpesialClass::isProgrammer() || HelperSpesialClass::isPengolahanData() || HelperSpesialClass::isAksesDaftarPasien()) {
            $searchModel = new RegistrasiSearch();
            $dataProvider = $searchModel->searchPasien($this->request->queryParams);

            return $this->render('list-pasien', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new NotFoundHttpException('Halaman yang dituju tidak ditemukan, silahkan hubungi IT Administrator');
        }
    }





    public function actionPreviewAsesmenAwalKeperawatan($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);

            if (!$id) {

                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }
        $asesmen = AsesmenAwalKeperawatanGeneral::find()->joinWith(['perawat', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['medis.asesmen_awal_keperawatan_general.id' => $id])->one();
        $pasien = Pasien::find()->where(['kode' => $asesmen->layanan->registrasi->pasien->kode])->one();
        return $this->renderAjax('asesmen-awal-keperawatan', ['asesmen' => $asesmen, 'pasien' => $pasien, 'is_ajax' => true]);
    }

    public function actionPreviewAsesmenAwalMedis($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);

            if (!$id) {

                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }
        $asesmen = AsesmenAwalMedis::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['medis.asesmen_awal_medis.id' => $id])->one();
        $pasien = Pasien::find()->where(['kode' => $asesmen->layanan->registrasi->pasien->kode])->one();
        return $this->renderAjax('asesmen-awal-medis', ['asesmen' => $asesmen, 'pasien' => $pasien, 'is_ajax' => true]);
    }

    public function actionPreviewAsesmenAwalKebidanan($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);

            if (!$id) {

                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }
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
        return $this->renderAjax('asesmen-awal-kebidanan', ['asesmen' => $asesmen, 'asesmenRiwayatKehamilan' => $asesmenRiwayatKehamilan, 'pasien' => $pasien, 'is_ajax' => true]);
    }
    public function actionPreviewResumeMedis($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);

            if (!$id) {

                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }
        $asesmen = ResumeMedisRi::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['medis.resume_medis_ri.id' => $id])->limit(1)->one();

        $pasien = Pasien::find()->where(['kode' => $asesmen->layanan->registrasi->pasien_kode])->one();
        return $this->renderAjax('resume-medis-ri', ['resume' => $asesmen, 'pasien' => $pasien, 'is_ajax' => true]);
    }


    public function actionPreviewCppt($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);

            if (!$id) {

                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }
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
        ])
            // ->where(['layanan.deleted_at' => null])
            ->andWhere(['not', ['tanggal_final' => null]])->orderBy(['tanggal_final' => SORT_ASC])->asArray()->all();

        $pasien = Pasien::find()->where(['kode' => $registrasi->data['pasien_kode']])->one();
        return $this->renderAjax('cppt', ['asesmen' => $asesmen, 'pasien' => $pasien, 'is_ajax' => true]);
    }

    public function actionPreviewRingkasanPulangIgd($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);

            if (!$id) {

                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }


        $ringkasanPulangIgd = RingkasanPulangIgd::find()->joinWith(['dokter',  'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where([RingkasanPulangIgd::tableName() . '.id' => $id])
            ->orderBy(['created_at' => SORT_DESC])->limit(1)->one();
        $pasien = Pasien::find()->where(['kode' => $ringkasanPulangIgd->layanan->registrasi->pasien_kode])->one();
        return $this->renderAjax('ringkasan-pulang-igd', ['ringkasanPulangIgd' => $ringkasanPulangIgd, 'pasien' => $pasien, 'is_ajax' => true]);
    }

    public function actionPreviewTriaseIgd($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);

            if (!$id) {

                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }


        $triaseIgd = TriasePasien::find()->joinWith(['dokter',  'layanan' => function ($q) {

            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where([TriasePasien::tableName() . '.id' => $id])
            ->orderBy(['created_at' => SORT_DESC])->limit(1)->one();
        $pasien = Pasien::find()->where(['kode' => $triaseIgd->layanan->registrasi->pasien_kode])->one();
        return $this->renderAjax('triase-igd', ['triaseIgd' => $triaseIgd, 'pasien' => $pasien, 'is_ajax' => true]);
    }

    public function actionPreviewMonitoringTtv($id)
    {
        if ($id != null) {
            $id = Lib::validateData($id);

            if (!$id) {

                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }


        $model = PasienMonitoringTtv::find()->joinWith(['perawat', 'perawatBatal', 'perawatFinal', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['registrasi_kode' => $id])->orderBy(['created_at' => SORT_ASC])->asArray()->all();

        // print_r($model);
        // die;
        // Cek apakah ada data di $model
        if (!empty($model) && isset($model[0]['layanan']['registrasi']['pasien_kode'])) {
            // Temukan pasien berdasarkan kode
            $pasien = Pasien::find()->where(['kode' => $model[0]['layanan']['registrasi']['pasien_kode']])->one();
        } else {
            // Handle jika data tidak ditemukan atau kode pasien tidak ada
            $pasien = [];
        }
        return $this->renderAjax('monitoring-ttv', ['model' => $model, 'pasien' => $pasien, 'is_ajax' => true]);
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

    public function actionCetakCppt()
    {
        ini_set("pcre.backtrack_limit", "5000000000");
        $req = Yii::$app->request;
        $id = $req->get('id');
        if ($id != null) {
            $id = Lib::validateData($id);

            if (!$id) {

                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }

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
        ])->andWhere(['not', ['tanggal_final' => null]])->orderBy(['tanggal_final' => SORT_ASC])->asArray()->all();

        $pasien = Pasien::find()->where(['kode' => $registrasi->data['pasien_kode']])->one();


        // return '<pre>' . json_encode(count($asesmen));

        $title = 'CPPT';
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
        $html = $this->renderPartial('cppt', ['asesmen' => $asesmen, 'pasien' => $pasien, 'is_ajax' => false]);

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


    public function actionCetakRiwayatKonsultasi()
    {
        ini_set("pcre.backtrack_limit", "5000000000");
        $req = Yii::$app->request;
        $id = $req->get('id');
        if ($id != null) {
            $id = Lib::validateData($id);

            if (!$id) {

                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }
        $data = PermintaanKonsultasi::find()->joinWith([
            'dokterMinta',
            'layananMinta' => function ($q) {
                $q->joinWith(['unit']);
            },
            'unitTujuan',
            'dokterTujuan',
            'jawabanKonsultasi' => function ($q) {
                $q->joinWith([
                    'dokterJawab',
                    'layananJawab' => function ($q) {
                        $q->joinWith(['unit']);
                    }
                ]);
            }
        ])->where([PermintaanKonsultasi::tableName() . '.id' => $id])->asArray()->limit(1)->one();
        // return print_r($data);
        $registrasi = Registrasi::find()->joinWith('layanan')->where(['in', Layanan::tableName() . '.id', $data['layanan_id_minta']])->one();
        $pasien = Pasien::find()->where(['kode' => $registrasi->pasien_kode])->one();



        $title = 'Riwayat Konsultasi';
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
        $html = $this->renderPartial('konsultasi_detail', [
            'data' => $data,
            'pasien' => $pasien,
            'is_ajax' => false
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


    public function actionCetakResepDokter()
    {
        ini_set("pcre.backtrack_limit", "5000000000");
        $req = Yii::$app->request;
        $id = $req->get('id');
        if ($id != null) {
            $id = Lib::validateData($id);

            if (!$id) {

                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }
        $data = Resep::find()->joinWith([
            'resepDetail' => function ($q) {
                $q->joinWith(['obat']);
            },
            'layanan',
            'depo',
            'dokter'
        ])->where([Resep::tableName() . '.id' => $id])->asArray()->limit(1)->one();
        $idResep = Resep::find()->joinWith(['layanan' => function ($q) {
            $q->joinWith('registrasi');
        }])->where([Resep::tableName() . '.id' => $id])->one();
        // return print_r($idResep->layanan->registrasi->pasien_kode);
        $pasien = Pasien::find()->where(['kode' => $idResep->layanan->registrasi->pasien_kode])->one();



        $title = 'Resep Dokter';
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
        $html = $this->renderPartial('resep_detail_cetak', [
            'data' => $data,
            'pasien' => $pasien,
            'is_ajax' => false
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
    public function actionCetakObatTerjualFarmasi()
    {
        ini_set("pcre.backtrack_limit", "5000000000");
        $req = Yii::$app->request;
        $id = $req->get('id');
        if ($id != null) {
            $id = Lib::validateData($id);

            if (!$id) {

                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }

        $data = Penjualan::find()->alias('p')->joinWith('penjualanDetail')->joinWith(['depo', 'dokter'])
            ->where(['p.id_penjualan' => $id])
            ->andWhere(['not', ['p.status' => 0]])
            ->groupBy('p.no_daftar', 'p.id_penjualan')->groupBy('p.no_daftar,p.id_penjualan')->orderBy(['p.id_penjualan' => SORT_DESC])->all();
        // return print_r($idResep->layanan->registrasi->pasien_kode);
        $pasien = Pasien::find()->where(['kode' => $data[0]['no_rm']])->one();



        $title = 'Resep Dokter';
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
        $html = $this->renderPartial('obat_terjual_cetak', [
            'data' => $data,
            'pasien' => $pasien
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


    public function actionCetakResumeMedisRi()
    {
        ini_set("pcre.backtrack_limit", "5000000000");
        $req = Yii::$app->request;
        $id = $req->get('id');
        if ($id != null) {
            $id = Lib::validateData($id);

            if (!$id) {

                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }

        $asesmen = ResumeMedisRi::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['medis.resume_medis_ri.id' => $id])->limit(1)->one();

        $pasien = Pasien::find()->where(['kode' => $asesmen->layanan->registrasi->pasien->kode])->one();



        $title = 'Riwayat Konsultasi';
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
        $html = $this->renderPartial('resume-medis-ri', ['resume' => $asesmen, 'pasien' => $pasien, 'is_ajax' => false]);

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

    public function actionCetakAsesmenAwalMedis()
    {
        ini_set("pcre.backtrack_limit", "5000000000");
        $req = Yii::$app->request;
        $id = $req->get('id');
        if ($id != null) {
            $id = Lib::validateData($id);

            if (!$id) {

                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }
        $asesmen = AsesmenAwalMedis::find()->joinWith(['dokter', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['medis.asesmen_awal_medis.id' => $id])->one();
        $pasien = Pasien::find()->where(['kode' => $asesmen->layanan->registrasi->pasien->kode])->one();

        $title = 'Asesmen Awal Medis';
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
        $html = $this->renderPartial('asesmen-awal-medis', ['asesmen' => $asesmen, 'pasien' => $pasien, 'is_ajax' => false]);

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


    public function actionCetakResumeMedisRj()
    {
        ini_set("pcre.backtrack_limit", "5000000000");
        $req = Yii::$app->request;
        $id = $req->get('id');
        if ($id != null) {
            $id = Lib::validateData($id);

            if (!$id) {

                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }
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




        $title = 'Resume Medis Rawat Jalan';
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
        $html = $this->renderPartial('resume-medis-rj', [
            'resume' => $resume,
            'pasien' => $pasien,
            'is_ajax' => false

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

    public function actionCetakAsesmenAwalKeperawatan()
    {
        ini_set("pcre.backtrack_limit", "5000000000");
        $req = Yii::$app->request;
        $id = $req->get('id');
        if ($id != null) {
            $id = Lib::validateData($id);

            if (!$id) {

                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }
        $asesmen = AsesmenAwalKeperawatanGeneral::find()->joinWith(['perawat', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['medis.asesmen_awal_keperawatan_general.id' => $id])->one();
        $pasien = Pasien::find()->where(['kode' => $asesmen->layanan->registrasi->pasien->kode])->one();




        $title = 'Asesmen Awal Keperawatan';
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
        $html = $this->renderPartial('asesmen-awal-keperawatan', ['asesmen' => $asesmen, 'pasien' => $pasien, 'is_ajax' => false]);

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

    public function actionCetakAsesmenAwalKebidanan()
    {
        ini_set("pcre.backtrack_limit", "5000000000");
        $req = Yii::$app->request;
        $id = $req->get('id');
        if ($id != null) {
            $id = Lib::validateData($id);

            if (!$id) {

                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }
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


        $title = 'Asesmen Awal Kebidanan';
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
        $html = $this->renderPartial('asesmen-awal-kebidanan', ['asesmen' => $asesmen, 'asesmenRiwayatKehamilan' => $asesmenRiwayatKehamilan, 'pasien' => $pasien, 'is_ajax' => false]);

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


    public function actionIndexPasien()
    {


        return $this->render('index-pasien', []);
    }
    public function actionDataPasienList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request->post("datatables");
        $dataMpp = Pasien::find()
            ->select('nama', 'kode');





        $dataMpp = $dataMpp->orderBy(['kode' => SORT_ASC])->asArray()->all();





        $response = [];




        return [
            "status" => 200,
            "message" => "Data successfully retrieved",
            "data" => $dataMpp
        ];
    }

    public function actionCetakRingkasanPulangIgd()
    {
        ini_set("pcre.backtrack_limit", "5000000000");
        $req = Yii::$app->request;
        $id = $req->get('id');
        if ($id != null) {
            $id = Lib::validateData($id);

            if (!$id) {

                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }
        $ringkasanPulangIgd = RingkasanPulangIgd::find()->joinWith(['dokter',  'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where([RingkasanPulangIgd::tableName() . '.id' => $id])
            ->orderBy(['created_at' => SORT_DESC])->limit(1)->one();
        $pasien = Pasien::find()->where(['kode' => $ringkasanPulangIgd->layanan->registrasi->pasien_kode])->one();





        $title = 'Ringkasan Pulang IGD';
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
        $html = $this->renderPartial('ringkasan-pulang-igd', [
            'ringkasanPulangIgd' => $ringkasanPulangIgd,
            'pasien' => $pasien,
            'is_ajax' => false

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

    public function actionCetakTriaseIgd()
    {
        ini_set("pcre.backtrack_limit", "5000000000");
        $req = Yii::$app->request;
        $id = $req->get('id');
        if ($id != null) {
            $id = Lib::validateData($id);

            if (!$id) {

                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }
        $triaseIgd = TriasePasien::find()->joinWith(['dokter',  'layanan' => function ($q) {

            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where([TriasePasien::tableName() . '.id' => $id])
            ->orderBy(['created_at' => SORT_DESC])->limit(1)->one();
        $pasien = Pasien::find()->where(['kode' => $triaseIgd->layanan->registrasi->pasien_kode])->one();




        $title = 'Triase IGD';
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
        $html = $this->renderPartial('triase-igd', [
            'triaseIgd' => $triaseIgd,
            'pasien' => $pasien,
            'is_ajax' => false

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

    public function actionCetakMonitoringTtv()
    {
        ini_set("pcre.backtrack_limit", "5000000000");
        $req = Yii::$app->request;
        $id = $req->get('id');
        if ($id != null) {
            $id = Lib::validateData($id);

            if (!$id) {

                $this->layout = 'main-riwayat';
                return $this->render('error');
            }
        }
        $model = PasienMonitoringTtv::find()->joinWith(['perawat', 'perawatBatal', 'perawatFinal', 'layanan' => function ($q) {
            $q->joinWith(['registrasi' => function ($query) {
                $query->joinWith('pasien');
            }]);
        }])->where(['registrasi_kode' => $id])->orderBy(['created_at' => SORT_ASC])->asArray()->all();

        if (!empty($model) && isset($model[0]['layanan']['registrasi']['pasien_kode'])) {
            // Temukan pasien berdasarkan kode
            $pasien = Pasien::find()->where(['kode' => $model[0]['layanan']['registrasi']['pasien_kode']])->one();
        } else {
            // Handle jika data tidak ditemukan atau kode pasien tidak ada
            $pasien = [];
        }

        $title = 'Monitoring TTV';
        $orientasi = 'LEGAL-L';

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
        $html = $this->renderPartial('monitoring-ttv', [
            'model' => $model,
            'pasien' => $pasien,
            'is_ajax' => false

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


    public function actionLihatSep($sep)
    {
        return "<iframe id='iframe-pdf'  width='100%'  height='350px' src='http://pendaftaran.simrs.aa/sep-v3/cetak-esep?no_sep=$sep#toolbar=0' frameborder='0'></iframe>";
    }
    public function actionViewDokumenRme($id_dokumen_rme = null)
    {
        // Jika parameter id_dokumen_rme tidak ada, tampilkan pesan dalam iframe
        if ($id_dokumen_rme === null) {
            $errorMessage = "<html><body><h3 style='text-align:center;color:red;'>Data yang diinginkan tidak ditemukan.</h3></body></html>";
            $iframeSrc = "data:text/html;base64," . base64_encode($errorMessage);
            return "<iframe id='iframe-pdf' width='100%' height='750px' src='" . $iframeSrc . "' frameborder='0'></iframe>";
        }


        $baseUrl = Yii::$app->params['storage-monitoring']['base-url'];
        $urlApiView = $baseUrl . Yii::$app->params['storage-monitoring']['view-dokumen'];

        $dataView = [
            'idDokumenRme' => $id_dokumen_rme,
            'cetak' => 0,
            'userId' => Yii::$app->user->identity->id
        ];

        // Hit API View pada $viewPdf
        $response = Yii::$app->ApiComponent->run($urlApiView, $dataView);

        // Cek apakah URL tersedia dalam response
        if (isset($response->data->url) && !empty($response->data->url)) {
            $iframeSrc = $response->data->url . "#toolbar=0";
        } else {
            $iframeSrc = "data:text/html,<html><body><h3 style='text-align:center;color:red;'>Dokumen tidak tersedia atau terjadi kesalahan saat memuat dokumen.</h3></body></html>";
        }

        return "<iframe id='iframe-pdf' width='100%' height='700px' src='" . $iframeSrc . "' frameborder='0'></iframe>";
    }




    public function actionCetakDokumenRme($id_dokumen_rme)
    {
        $baseUrl = Yii::$app->params['storage-monitoring']['base-url'];
        $urlApiView =  $baseUrl . Yii::$app->params['storage-monitoring']['view-dokumen'];

        $dataView = [
            'idDokumenRme' => $id_dokumen_rme,
            'cetak' => 0,
            'userId' => Yii::$app->user->identity->id
        ];
        // Hit API View pada $viewPdf
        $response = Yii::$app->ApiComponent->run($urlApiView, $dataView);

        // Jika response bukan string, convert ke JSON

        return $this->redirect($response->data->url);
    }

    public function processDokumenRme($idDokumen, $registrasi)
    {
        // Ambil data dokumen dengan relasi dokumenDetail
        $dokumenRme = Dokumen::find()
            ->with('dokumenDetail')
            ->where(['id_dokumen' => $idDokumen]) // Filter berdasarkan id_dokumen
            ->orderBy('urutan', SORT_ASC)
            ->asArray()
            ->all();

        $dokumenRmeFix = [];

        // Proses setiap item dokumen
        foreach ($dokumenRme as $index => $item) {
            if (isset($item['query_search_riwayat_by_noreg']) && $item['query_search_riwayat_by_noreg'] != null) {
                // Ganti parameter dalam query
                $query = str_replace('$', $registrasi, $item['query_search_riwayat_by_noreg']);

                // Eksekusi query untuk mendapatkan data riwayat
                $data = Yii::$app->db_medis->createCommand($query)->queryAll();
                $item['data'] = $data;

                // Mengisi kolom 'keterangan' dan memproses url_lihat, url_cetak
                foreach ($item['data'] as &$value) {
                    // Set default url_lihat dan url_cetak
                    $value['url_lihat'] = null;
                    $value['url_cetak'] = null;

                    // Cek setiap detail dokumen untuk memperbarui url
                    foreach ($item['dokumenDetail'] as $subvalue) {
                        if ($subvalue['versi'] == $value['versi']) {
                            if (!empty($subvalue['key_hash_code'])) {
                                $value['url_lihat'] = str_replace('$', HelperGeneral::hashDataCustom($value[$subvalue['name_colums_params_url']], $subvalue['key_hash_code']), $subvalue['url_lihat']);
                                $value['url_cetak'] = str_replace('$', HelperGeneral::hashDataCustom($value[$subvalue['name_colums_params_url']], $subvalue['key_hash_code']), $subvalue['url_cetak']);
                            } else {
                                $value['url_lihat'] = str_replace('$', $value[$subvalue['name_colums_params_url']], $subvalue['url_lihat']);
                                $value['url_cetak'] = str_replace('$', $value[$subvalue['name_colums_params_url']], $subvalue['url_cetak']);
                            }
                        }
                    }
                }

                // Simpan item yang sudah diproses ke array
                $dokumenRmeFix[] = $item;
            }
        }

        return $dokumenRmeFix;
    }
}
