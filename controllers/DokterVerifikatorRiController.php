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
use app\models\search\AnalisaKuantitatifSearch;
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

class DokterVerifikatorRiController extends Controller
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
    public function actionDataRawatInap()
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
            r.is_pelaporan_ri as pelaporan_ri
        FROM
            pendaftaran.registrasi r
        INNER JOIN
            pendaftaran.layanan l ON l.registrasi_kode = r.kode
        INNER JOIN
            pendaftaran.pasien p ON r.pasien_kode = p.kode
        INNER JOIN
            pegawai.dm_unit_penempatan dup ON l.unit_kode = dup.kode
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

        if ($req['unit_kode'] != null) {
            $sql .= " and l.unit_kode = " . $req['unit_kode'];
        }


        $sql .= " group by r.kode,p.nama,rmr.tgl_pulang order by rmr.tgl_pulang";

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

        $model = $this->initModelCreate($id, $chk_pasien, $userLogin);

        if (!$model) {
            \Yii::$app->session->setFlash('warning', "Maaf, Hanya Untuk Resume Medis RI Pasien Tidak Ditemukan ");
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        $registrasi = HelperSpesialClass::getCheckPasien($id);
        $layananId = array();

        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
        }


        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
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


        $modelDokterVerifikator = new ResumeMedisRiClaim();
        return $this->render(
            'view',
            [
                'registrasi' => $registrasi->data,
                'model' => $modelDokterVerifikator,

                'listResumeMedis' => $listResumeMedis,

                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,
            ]
        );
    }

    public function actionViewDetail($id = null, $registrasi_kode = null)
    {
        $modelVerifikator = ResumeMedisRiClaim::find()->where(['id_resume_medis_ri' => $id])->one();
        if (!$modelVerifikator) {
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
        } else {

            $resumeMedisVerifikator = ResumeMedisRiClaim::find()->where(['id_resume_medis_ri' => $id])->one();
        }

        $registrasi = HelperSpesialClass::getCheckPasien($registrasi_kode);
        $layananId = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
        }


        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
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
        return $this->render(
            'view-detail',
            [
                'registrasi' => $registrasi->data,
                'model' => $resumeMedisVerifikator,
                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,

            ]
        );
    }

    public function actionVerifikator($id = null, $registrasi_kode = null)
    {
        $model = ResumeMedisRi::find()->where(['id' => $id])->one();
        // $modelResumeVerifikator = ResumeMedisRiClaim::find()->where(['id_resume_medis_ri'=>])
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
        return $this->render(
            'verifikator',
            [
                'registrasi' => $registrasi->data,
                'model' => $resumeMedisVerifikator,

                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator,

            ]
        );
    }

    public function actionVerifikatorUpdate($id = null, $registrasi_kode = null)
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
        return $this->render(
            'verifikator-update',
            [
                'registrasi' => $registrasi->data,
                'model' => $resumeMedisVerifikator,

                'listResumeMedisDokter' => $listResumeMedisDokter,
                'listResumeMedisVerifikator' => $listResumeMedisDokterVerifikator
            ]
        );
    }

    public function actionVerifikatorSave()
    {
        $model = new ResumeMedisRiClaim();
        $req = Yii::$app->request->post('ResumeMedisRiClaim');
        $user = HelperSpesialClass::getUserLogin();

        $model = ResumeMedisRiClaim::find()->where(['registrasi_kode' => $req['registrasi_kode']])->one();
        if (empty($model)) {
            $model = new ResumeMedisRiClaim();
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
}
