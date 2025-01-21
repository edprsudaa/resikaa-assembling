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
use app\models\pengolahandata\CodingClaimRj;
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
class CasemixController extends Controller
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


    public function actionListRawatJalan()
    {
        return $this->render('list-rawat-jalan', []);
    }
    public function actionListRawatInap()
    {
        return $this->render('list-rawat-inap', []);
    }

    public function actionListIgd()
    {
        return $this->render('list-igd', []);
    }

    public function actionDataRawatJalan()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request->post("datatables");
        $layanan = Layanan::find()->select(["registrasi_kode", "jenis_layanan", "deleted_at", "unit_tujuan_kode", "id", "unit_kode"])->orderBy(["created_at" => SORT_DESC]);
        $queryData = Registrasi::find()
            ->select(["array_agg(layanan.jenis_layanan) as jenis", "registrasi.kode"])
            ->innerJoin(["layanan" => $layanan], "layanan.registrasi_kode=registrasi.kode and layanan.deleted_at is null")
            ->where("layanan.unit_tujuan_kode is null");
        if ($req['tanggal'] != null) {
            $queryData = $queryData->andWhere([">=", "registrasi.tgl_masuk", $req['tanggal'] . " 00:00:00"]);
            $queryData = $queryData->andWhere(["<=", "registrasi.tgl_masuk", $req['tanggal'] . " 23:59:59"]);
        } else {
            $queryData = $queryData->andWhere([">=", "registrasi.tgl_masuk", date('Y-m-d') . " 00:00:00"]);
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
                "coding_claim_rj.estimasi as estimasi"
            ])
            ->from("ranap")
            ->withQuery($queryData, "ranap", true)
            ->innerJoin("pendaftaran.registrasi", "registrasi.kode=ranap.kode and jenis::text not like '%3%'")
            ->innerJoin("pendaftaran.layanan", "layanan.registrasi_kode=ranap.kode and layanan.jenis_layanan in (2)")
            ->leftJoin("pengolahan_data.coding_claim_rj", "coding_claim_rj.registrasi_kode=ranap.kode")

            ->innerJoin("pendaftaran.pasien", "registrasi.pasien_kode=pasien.kode")
            ->innerJoin("pegawai.dm_unit_penempatan", "dm_unit_penempatan.kode=layanan.unit_kode");
        // Menambahkan kondisi pencarian jika ada
        if (!empty($req['cari'])) {
            $queryDataTest->andWhere([
                'or',
                ['ilike', 'pasien.nama', $req['cari']],
                ['ilike', 'registrasi.pasien_kode', $req['cari']]
            ]);
        }
        // Menambahkan kondisi untuk unit_kode jika ada
        if (!empty($req['unit_kode'])) {
            $queryDataTest->andWhere(['layanan.unit_kode' => $req['unit_kode']]);
        }

        $queryDataTest = $queryDataTest->groupBy(["registrasi.kode", "pasien.nama", "coding_claim_rj.estimasi"])
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

                'claim' => $value['claim'],
                'pelaporan' => $value['pelaporan'],
                'estimasi' => $value['estimasi'],


                'poli' => $poliListData,
                'registrasi_kode_hash' => HelperGeneralClass::hashData($value['kode']),
                'pasien_kode_hash' => HelperGeneralClass::hashData($value['pasien_kode'])
            ];
        }
        return [
            "status" => 200,
            "message" => "Data successfully retrieved",
            "data" => $response
        ];
    }

    public function actionDataRawatInap()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request->post("datatables");
        $connection = \Yii::$app->db;

        $startDate = date('Y-m-d') . " 00:00:00"; // Tanggal awal dari variabel
        $endDate = date('Y-m-d') . " 23:59:59"; // Tanggal akhir dari variabel
        $cari = null;
        if ($req['tanggal'] != null) {
            $startDate = $req['tanggal'] . " 00:00:00";
        } else {
            $startDate = date('Y-m-d') . " 00:00:00";
        }
        if ($req['tanggal'] != null) {
            $endDate = $req['tanggal'] . " 23:59:59";
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
            r.is_pelaporan_ri as pelaporan_ri,
            cl.estimasi
        FROM
            pendaftaran.registrasi r
        INNER JOIN
            pendaftaran.layanan l ON l.registrasi_kode = r.kode
        LEFT JOIN
            pengolahan_data.coding_claim cl ON cl.registrasi_kode = r.kode
        INNER JOIN
            pendaftaran.pasien p ON r.pasien_kode = p.kode
        INNER JOIN
            pegawai.dm_unit_penempatan dup ON l.unit_kode = dup.kode
        INNER JOIN
            medis.resume_medis_ri rmr ON rmr.layanan_id = l.id    
        WHERE
            rmr.tgl_pulang >= :startDate
            AND rmr.tgl_pulang <= :endDate ";
        if ($req['cari'] != null) {
            $sql .= "and (p.nama ilike '%" . $req['cari'] . "%' or r.pasien_kode ilike '%" . $req['cari'] . "%') ";
        }
        if ($req['unit_kode'] != null) {
            $sql .= " and l.unit_kode = " . $req['unit_kode'];
        }


        $sql .= " group by r.kode,p.nama,cl.estimasi,rmr.tgl_pulang order by rmr.tgl_pulang";

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
                'estimasi' => $value['estimasi'],

                'claim_ri' => $value['claim_ri'],
                'pelaporan_ri' => $value['pelaporan_ri'],
                'poli' => array_values($poli),
                'registrasi_kode_hash' => HelperGeneralClass::hashData($value['kode']),
                'pasien_kode_hash' => HelperGeneralClass::hashData($value['pasien_kode'])

            ];
        }
        return [
            "status" => 200,
            "message" => "Data successfully retrieved",
            "data" => $response
        ];
    }

    public function actionDataIgd()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request->post("datatables");
        $layanan = Layanan::find()->select(["registrasi_kode", "jenis_layanan", "deleted_at", "unit_tujuan_kode", "id", "unit_kode"])->orderBy(["created_at" => SORT_DESC]);
        $queryData = Registrasi::find()
            ->select(["array_agg(layanan.jenis_layanan) as jenis", "registrasi.kode"])
            ->innerJoin(["layanan" => $layanan], "layanan.registrasi_kode=registrasi.kode and layanan.deleted_at is null")
            ->where("layanan.unit_tujuan_kode is null");
        if ($req['tanggal'] != null) {
            $queryData = $queryData->andWhere([">=", "registrasi.tgl_masuk", $req['tanggal'] . " 00:00:00"]);
            $queryData = $queryData->andWhere(["<=", "registrasi.tgl_masuk", $req['tanggal'] . " 23:59:59"]);
        } else {
            $queryData = $queryData->andWhere([">=", "registrasi.tgl_masuk", date('Y-m-d') . " 00:00:00"]);
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
                "coding_claim_igd.estimasi"

            ])
            ->from("ranap")
            ->withQuery($queryData, "ranap", true)
            ->innerJoin("pendaftaran.registrasi", "registrasi.kode=ranap.kode and jenis::text not like '%3%' and jenis::text not like '%2%'")
            ->innerJoin("pendaftaran.layanan", "layanan.registrasi_kode=ranap.kode and layanan.jenis_layanan in (1)")
            ->leftJoin("pengolahan_data.coding_claim_igd", "coding_claim_igd.registrasi_kode=ranap.kode")

            ->innerJoin("pendaftaran.pasien", "registrasi.pasien_kode=pasien.kode")
            // ->innerJoin("medis.ringkasan_pulang_igd rpi", "rpi.layanan_id=layanan.id")



            ->innerJoin("pegawai.dm_unit_penempatan", "dm_unit_penempatan.kode=layanan.unit_kode");



        // ->andWhere(["in","layanan.jenis"])
        $queryDataTest = $queryDataTest->groupBy(["registrasi.kode", "pasien.nama", 'coding_claim_igd.estimasi'])
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

                'claim' => $value['claim'],
                'pelaporan' => $value['pelaporan'],
                'estimasi' => $value['estimasi'],


                'poli' => $poliListData,
                'registrasi_kode_hash' => HelperGeneralClass::hashData($value['kode']),
                'pasien_kode_hash' => HelperGeneralClass::hashData($value['pasien_kode'])

            ];
        }
        return [
            "status" => 200,
            "message" => "Data successfully retrieved",
            "data" => $response
        ];
    }

    public function actionClaimRanap($id)
    {
        $this->layout = false; // Menghilangkan layout agar hanya konten yang dimuat di dalam modal

        $data = CodingClaim::find()->with(['claimDiagnosa', 'claimTindakan'])->where(['registrasi_kode' => $id])->all();
        $codingClaim = CodingClaim::find()->where(['registrasi_kode' => $id])->one();

        return $this->render('claim-ranap', [
            'data' => $data,
            'model' => $codingClaim
        ]);
    }

    public function actionClaimRajal($id)
    {
        $this->layout = false; // Menghilangkan layout agar hanya konten yang dimuat di dalam modal

        $data = CodingClaimRj::find()->with(['pelaporanDiagnosa', 'pelaporanTindakan'])->where(['registrasi_kode' => $id])->all();
        $codingClaim = CodingClaimRj::find()->where(['registrasi_kode' => $id])->one();

        return $this->render('claim-rajal', [
            'data' => $data,
            'model' => $codingClaim
        ]);
    }

    public function actionClaimIgd($id)
    {
        $this->layout = false; // Menghilangkan layout agar hanya konten yang dimuat di dalam modal

        $data = CodingClaimIgd::find()->with(['pelaporanDiagnosa', 'pelaporanTindakan'])->where(['registrasi_kode' => $id])->all();
        $codingClaim = CodingClaimIgd::find()->where(['registrasi_kode' => $id])->one();

        return $this->render('claim-igd', [
            'data' => $data,
            'model' => $codingClaim
        ]);
    }

    public function actionUpdateEstimasiRanap()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request->post('CodingClaim');

        $id = $request['id']; // Mengambil ID dari request POST
        $estimasi = $request['estimasi']; // Mengambil nilai estimasi dari request POST
        if ($id === null || $estimasi === null) {
            return ['status' => false, 'msg' => 'ID atau estimasi tidak ditemukan'];
        }

        $model = CodingClaim::findOne($id);

        if ($model === null) {
            return ['status' => false, 'msg' => 'Data tidak ditemukan'];
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $model->estimasi = $estimasi;

            if ($model->validate() && $model->save(false)) {
                $transaction->commit();
                return ['status' => true, 'msg' => 'Data Estimasi Berhasil Disimpan'];
            } else {
                $transaction->rollBack();
                return ['status' => false, 'msg' => 'Data Gagal Disimpan', 'errors' => $model->errors];
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            return ['status' => false, 'msg' => 'Exception: ' . $e->getMessage()];
        }
    }

    public function actionUpdateEstimasiRajal()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request->post('CodingClaimRj');

        $id = $request['id']; // Mengambil ID dari request POST
        $estimasi = $request['estimasi']; // Mengambil nilai estimasi dari request POST
        if ($id === null || $estimasi === null) {
            return ['status' => false, 'msg' => 'ID atau estimasi tidak ditemukan'];
        }

        $model = CodingClaimRj::findOne($id);

        if ($model === null) {
            return ['status' => false, 'msg' => 'Data tidak ditemukan'];
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $model->estimasi = $estimasi;

            if ($model->validate() && $model->save(false)) {
                $transaction->commit();
                return ['status' => true, 'msg' => 'Data Estimasi Berhasil Disimpan'];
            } else {
                $transaction->rollBack();
                return ['status' => false, 'msg' => 'Data Gagal Disimpan', 'errors' => $model->errors];
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            return ['status' => false, 'msg' => 'Exception: ' . $e->getMessage()];
        }
    }

    public function actionUpdateEstimasiIgd()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request->post('CodingClaimIgd');

        $id = $request['id']; // Mengambil ID dari request POST
        $estimasi = $request['estimasi']; // Mengambil nilai estimasi dari request POST
        if ($id === null || $estimasi === null) {
            return ['status' => false, 'msg' => 'ID atau estimasi tidak ditemukan'];
        }

        $model = CodingClaimIgd::findOne($id);

        if ($model === null) {
            return ['status' => false, 'msg' => 'Data tidak ditemukan'];
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $model->estimasi = $estimasi;

            if ($model->validate() && $model->save(false)) {
                $transaction->commit();
                return ['status' => true, 'msg' => 'Data Estimasi Berhasil Disimpan'];
            } else {
                $transaction->rollBack();
                return ['status' => false, 'msg' => 'Data Gagal Disimpan', 'errors' => $model->errors];
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            return ['status' => false, 'msg' => 'Exception: ' . $e->getMessage()];
        }
    }
}
