<?php

namespace app\controllers;

use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;
use app\models\laporan\LaporanAnalisaRawatJalan;
use app\models\medis\ResumeMedisRi;
use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;
use app\models\pendaftaran\Registrasi;
use app\models\pengolahandata\AnalisaDokumen;
use app\models\pengolahandata\CodingPelaporanRi;
use app\models\pengolahandata\CodingPelaporanRj;
use app\models\pengolahandata\DataDasarRs;
use app\models\pengolahandata\DataDasarRsSearch;
use app\models\laporan\LaporanKetidakTepatanWaktu;
use app\models\pegawai\DmUnitPenempatan;
use app\models\pengolahandata\AnalisaDokumenDetail;
use app\models\pengolahandata\AnalisaDokumenRj;
use app\models\pengolahandata\AnalisaDokumenRjDetail;
use app\models\pengolahandata\CodingPelaporanIgd;
use app\models\sip\Unit;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Yii;
use yii\db\Expression;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * DataDasarRsController implements the CRUD actions for DataDasarRs model.
 */
class LaporanController extends Controller
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
     * @return string
     */
    public function actionLaporanCoder()
    {
        $model = new AnalisaDokumen();
        $modelAnalisaDokumen = new AnalisaDokumen();
        $modelAnalisaDokumen->jenis_laporan = AnalisaDokumen::JENIS_HARIAN;
        $modelAnalisaDokumen->tgl_hari = date('d-m-Y');
        $modelAnalisaDokumen->tipe_laporan = AnalisaDokumen::TIPE_SELURUH;

        return $this->render('list-laporan-coder', [

            'model' => $model,
            'modelAnalisaDokumen' => $modelAnalisaDokumen,

        ]);
    }
    public function actionDaftarCodingRi()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request->post("datatables");
        $connection = \Yii::$app->db;

        $startDate = date('Y-m-d') . " 00:00:00"; // Tanggal awal dari variabel
        $endDate = date('Y-m-d') . " 23:59:59"; // Tanggal akhir dari variabel
        // ->leftJoin("medis.resume_medis_ri rmr", "rmr.layanan_id=l.id");
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
        if ($req['checkout'] != null) {
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

    public function actionLaporanCoderRi()
    {
        return $this->render('laporan-coder-ri', []);
    }
    public function actionDataLaporanCoderRi()
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
    public function actionLaporanCoderRj()
    {
        return $this->render('laporan-coder-rj', []);
    }
    public function actionDataLaporanCoderRj()
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

    public function actionLaporanCoderIgd()
    {
        return $this->render('laporan-coder-igd', []);
    }
    public function actionDataLaporanCoderIgd()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request->post("datatables");
        $queryData = CodingPelaporanIgd::find()->select(['count(coding_pelaporan_igd.registrasi_kode)', 'tb_pegawai.pegawai_id', 'tb_pegawai.id_nip_nrp', 'tb_pegawai.nama_lengkap'])
            ->innerJoin([Registrasi::tableName()], 'coding_pelaporan_igd.registrasi_kode=registrasi.kode')
            ->innerJoin([TbPegawai::tableName()], 'coding_pelaporan_igd.pegawai_coder_id=tb_pegawai.pegawai_id')
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
    public function actionLaporanAuditRuanganTidakTepatWaktu()
    {
        return $this->render('laporan-audit-ruangan-tidak-tepat-waktu', []);
    }
    public function actionDataLaporanAuditRuanganTidakTepatWaktu()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request->post("datatables");
        $queryData = AnalisaDokumen::find()->alias('ad')
            ->select([
                'dup.nama',
                'dup.kode',
                'COUNT(ad.analisa_dokumen_id) AS total_analisa_dokumen',
                'SUM(CASE WHEN EXTRACT(EPOCH FROM (r.tgl_keluar - rmr.tgl_pulang)) / 3600 <= 24 THEN 1 ELSE 0 END) AS jumlah_tepat_waktu_ppa',
                '(SUM(CASE WHEN EXTRACT(EPOCH FROM (r.tgl_keluar - rmr.tgl_pulang)) / 3600 <= 24 THEN 1 ELSE 0 END) / CAST(COUNT(ad.analisa_dokumen_id) AS DECIMAL(10, 2)) * 100) AS persentase_jumlah_tepat_waktu_ppa',
                'SUM(CASE WHEN EXTRACT(EPOCH FROM (r.tgl_keluar - rmr.tgl_pulang)) / 3600 > 24 THEN 1 ELSE 0 END) AS jumlah_tidak_tepat_waktu_ppa',
                '(SUM(CASE WHEN EXTRACT(EPOCH FROM (r.tgl_keluar - rmr.tgl_pulang)) / 3600 > 24 THEN 1 ELSE 0 END) / CAST(COUNT(ad.analisa_dokumen_id) AS DECIMAL(10, 2)) * 100) AS persentase_jumlah_tidak_tepat_waktu_ppa',
                'SUM(CASE WHEN EXTRACT(EPOCH FROM (r.closing_billing_ranap_at - rmr.tgl_pulang)) / 3600 <= 48 THEN 1 ELSE 0 END) AS jumlah_tepat_waktu_closing',
                '(SUM(CASE WHEN EXTRACT(EPOCH FROM (r.closing_billing_ranap_at - rmr.tgl_pulang)) / 3600 <= 48 THEN 1 ELSE 0 END) / CAST(COUNT(ad.analisa_dokumen_id) AS DECIMAL(10, 2)) * 100) AS persentase_jumlah_tepat_waktu_closing',
                'SUM(CASE WHEN r.closing_billing_ranap_at IS NULL OR EXTRACT(EPOCH FROM (r.closing_billing_ranap_at - rmr.tgl_pulang)) / 3600 > 48 THEN 1 ELSE 0 END) AS jumlah_tidak_tepat_waktu_closing',
                '(SUM(CASE WHEN r.closing_billing_ranap_at IS NULL OR EXTRACT(EPOCH FROM (r.closing_billing_ranap_at - rmr.tgl_pulang)) / 3600 > 48 THEN 1 ELSE 0 END) / NULLIF(CAST(COUNT(ad.analisa_dokumen_id) AS DECIMAL(10, 2)), 0) * 100) AS persentase_jumlah_tidak_tepat_waktu_closing',
            ])
            ->innerJoin(['r' => Registrasi::tableName()], 'ad.reg_kode=r.kode')
            ->innerJoin(['l' => Layanan::tableName()], 'l.registrasi_kode = ad.reg_kode')
            ->innerJoin(['rmr' => ResumeMedisRi::tableName()], 'rmr.layanan_id = l.id')
            ->innerJoin(['dup' => Unit::tableName()], 'dup.kode = ad.unit_id')
            ->where(['dup.is_rj' => '0', 'dup.is_ri' => '1']);
        if ($req['tanggal_awal'] != null) {
            $queryData = $queryData->andWhere([">=", "rmr.tgl_pulang", $req['tanggal_awal'] . " 00:00:00"]);
        } else {
            $queryData = $queryData->andWhere([">=", "rmr.tgl_pulang", date('Y-m-d') . " 00:00:00"]);
        }
        if ($req['tanggal_akhir'] != null) {
            $queryData = $queryData->andWhere(["<=", "rmr.tgl_pulang", $req['tanggal_akhir'] . " 23:59:59"]);
        } else {
            $queryData = $queryData->andWhere(["<=", "rmr.tgl_pulang", date('Y-m-d') . " 23:59:59"]);
        }


        $queryData = $queryData->groupBy(['dup.nama', 'dup.kode'])
            // ->createCommand()->rawSql;
            ->orderBy(['total_analisa_dokumen' => SORT_DESC])
            ->asArray()->all();

        $response = [];
        $totalSum = 0;
        if (count($queryData) > 0) {
            foreach ($queryData as $value) {
                $totalSum += $value['total_analisa_dokumen'];
                $response[] = [
                    'nama' => $value['nama'],
                    'total_analisa_dokumen' => $value['total_analisa_dokumen'],
                    'jumlah_tepat_waktu_ppa' => $value['jumlah_tepat_waktu_ppa'],
                    'persentase_jumlah_tepat_waktu_ppa' => round($value['persentase_jumlah_tepat_waktu_ppa'], 2),
                    'jumlah_tidak_tepat_waktu_ppa' => $value['jumlah_tidak_tepat_waktu_ppa'],
                    'persentase_jumlah_tidak_tepat_waktu_ppa' => round($value['persentase_jumlah_tidak_tepat_waktu_ppa'], 2),
                    'jumlah_tepat_waktu_closing' => $value['jumlah_tepat_waktu_closing'],
                    'persentase_jumlah_tepat_waktu_closing' => round($value['persentase_jumlah_tepat_waktu_closing'], 2),
                    'jumlah_tidak_tepat_waktu_closing' => $value['jumlah_tidak_tepat_waktu_closing'],
                    'persentase_jumlah_tidak_tepat_waktu_closing' => round($value['persentase_jumlah_tidak_tepat_waktu_closing'], 2),

                ];
            }
        }

        return [
            "status" => 200,
            "message" => "Data successfully retrieved",
            "data" => $response,
            "total" => $totalSum
        ];
    }

    public function actionLaporan()
    {
        $modelLaporan = new LaporanKetidakTepatanWaktu();
        $modelLaporanKetidakTepatanWaktu = new LaporanKetidakTepatanWaktu();
        $modelLaporanKetidakTepatanWaktu = new LaporanKetidakTepatanWaktu();
        $modelLaporanKetidakTepatanWaktu->jenis_laporan = LaporanKetidakTepatanWaktu::JENIS_HARIAN;
        $modelLaporanKetidakTepatanWaktu->tgl_hari = date('d-m-Y');
        $modelLaporanKetidakTepatanWaktu->tipe_laporan = LaporanKetidakTepatanWaktu::TIPE_SELURUH;
        $model = new AnalisaDokumen();
        $modelAnalisaDokumen = new AnalisaDokumen();
        $modelAnalisaDokumen->jenis_laporan = AnalisaDokumen::JENIS_HARIAN;
        $modelAnalisaDokumen->tgl_hari = date('d-m-Y');
        $modelAnalisaDokumen->tipe_laporan = AnalisaDokumen::TIPE_SELURUH;
        $modelLaporanAnalisaRawatJalan = new LaporanAnalisaRawatJalan();
        $modelAnalisaDokumenRawatJalan = new LaporanAnalisaRawatJalan();
        $modelAnalisaDokumenRawatJalan->jenis_laporan = LaporanAnalisaRawatJalan::JENIS_HARIAN;
        $modelAnalisaDokumenRawatJalan->tgl_hari = date('d-m-Y');
        $modelAnalisaDokumenRawatJalan->tipe_laporan = LaporanAnalisaRawatJalan::TIPE_SELURUH;

        return $this->render('laporan', [

            'model' => $model,
            'modelLaporan' => $modelLaporan,
            'modelLaporanAnalisaRawatJalan' => $modelLaporanAnalisaRawatJalan,
            'modelLaporanKetidakTepatanWaktu' => $modelLaporanKetidakTepatanWaktu,
            'modelAnalisaDokumen' => $modelAnalisaDokumen,
            'modelAnalisaDokumenRawatJalan' => $modelAnalisaDokumenRawatJalan,


        ]);
    }
    public function actionCetakLaporanAnalisaRawatInap()
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
                ->innerJoin('master_jenis_analisa_detail', 'master_jenis_analisa_detail.jenis_analisa_detail_id=analisa_dokumen_detail.analisa_dokumen_jenis_analisa_detail_id')
                ->where(['master_jenis_analisa_detail.jenis_analisa_detail_aktif' => 1]);

            if ($model->jenis_laporan == AnalisaDokumen::JENIS_HARIAN) {
                $jenisLaporan = 'Harian';
                $tglJudul = Yii::$app->formatter->asDate($model->tgl_hari);
                $analisaDokumen = $analisaDokumen
                    ->andWhere(['=', new Expression("to_char(" . Registrasi::tableName() . '.tgl_keluar' . ", 'DD-MM-YYYY')"), $model->tgl_hari]);
                // ->andWhere(['=', Registrasi::tableName() . '.tgl_keluar', $model->tgl_hari]);
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
                ->innerJoin('master_jenis_analisa_detail', 'master_jenis_analisa_detail.jenis_analisa_detail_id=analisa_dokumen_detail.analisa_dokumen_jenis_analisa_detail_id')
                ->where(['master_jenis_analisa_detail.jenis_analisa_detail_aktif' => 1]);

            if ($model->jenis_laporan == AnalisaDokumen::JENIS_HARIAN) {
                $jenisLaporan = 'Harian';
                $tglJudul = Yii::$app->formatter->asDate($model->tgl_hari);
                $query = $query
                    ->andWhere(['=', new Expression("to_char(" . Registrasi::tableName() . '.tgl_keluar' . ", 'DD-MM-YYYY')"), $model->tgl_hari]);
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
                ->setCellValue("A{$baseRowTitle}", 'Laporan Analisa Data EMR Rawat Inap ' . $jenisLaporan . ' ' . ($ruangan ?? '') . ($dokter ?? ''));
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
                        ->setCellValue('J' . $baseRow, $item['lengkap'] + $item['ada'] + $item['tidak_ada']);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('K' . $baseRow, $item['tidak_lengkap']);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('L' . $baseRow, sprintf("%.2f%%", ($item['tidak_lengkap'] / $item['jumlah_dokumen']) * 100));
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
                        ->setCellValue('J' . $baseRow, $item['lengkap'] + $item['ada'] + $item['tidak_ada']);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('K' . $baseRow, ($item['tidak_lengkap']));
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('L' . $baseRow, sprintf("%.2f%%", (($item['tidak_lengkap']) / $item['jumlah_dokumen']) * 100));
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

    public function actionCetakLaporanAnalisaRawatJalan()
    {

        $model = new LaporanAnalisaRawatJalan();


        if ($model->load(Yii::$app->request->post())) {

            $analisaDokumen = AnalisaDokumenRjDetail::find()
                ->select([
                    'count(analisa_dokumen_rj.analisa_dokumen_id) as jumlah_dokumen',
                    'master_jenis_analisa.jenis_analisa_uraian as jenis_analisa',
                    'master_item_analisa.item_analisa_uraian as item_uraian',
                    'master_item_analisa.item_analisa_tipe',
                    'analisa_dokumen_rj_detail.analisa_dokumen_item_id',
                    'analisa_dokumen_rj_detail.analisa_dokumen_jenis_id',
                    'analisa_dokumen_rj_detail.analisa_dokumen_jenis_analisa_detail_id',
                    'COUNT(analisa_dokumen_rj_detail.analisa_dokumen_kelengkapan) filter (where analisa_dokumen_rj_detail.analisa_dokumen_kelengkapan = 0) as tidak_ada',
                    'COUNT(analisa_dokumen_rj_detail.analisa_dokumen_kelengkapan) filter (where analisa_dokumen_rj_detail.analisa_dokumen_kelengkapan = 1) as tidak_lengkap',
                    'COUNT(analisa_dokumen_rj_detail.analisa_dokumen_kelengkapan) filter (where analisa_dokumen_rj_detail.analisa_dokumen_kelengkapan = 2) as lengkap',
                    'COUNT(analisa_dokumen_rj_detail.analisa_dokumen_kelengkapan) filter (where analisa_dokumen_rj_detail.analisa_dokumen_kelengkapan = 3) as ada'

                ])
                ->innerJoin('analisa_dokumen_rj', 'analisa_dokumen_rj_detail.analisa_dokumen_id=analisa_dokumen_rj.analisa_dokumen_id')
                ->innerJoin(Registrasi::tableName(), Registrasi::tableName() . '.kode=analisa_dokumen_rj.reg_kode')
                ->innerJoin('master_item_analisa', 'master_item_analisa.item_analisa_id=analisa_dokumen_rj_detail.analisa_dokumen_item_id')
                ->innerJoin('master_jenis_analisa', 'analisa_dokumen_rj_detail.analisa_dokumen_jenis_id=master_jenis_analisa.jenis_analisa_id')
                ->innerJoin('master_jenis_analisa_detail', 'master_jenis_analisa_detail.jenis_analisa_detail_id=analisa_dokumen_rj_detail.analisa_dokumen_jenis_analisa_detail_id')
                ->where(['master_jenis_analisa_detail.jenis_analisa_detail_aktif' => 1]);

            if ($model->jenis_laporan == AnalisaDokumenRj::JENIS_HARIAN) {
                $jenisLaporan = 'Harian';
                $tglJudul = Yii::$app->formatter->asDate($model->tgl_hari);
                $analisaDokumen = $analisaDokumen
                    ->andWhere(['=', Registrasi::tableName() . '.tgl_masuk', $model->tgl_hari]);
            } else if ($model->jenis_laporan == AnalisaDokumenRj::JENIS_BULANAN) {
                $jenisLaporan = 'Bulanan';
                $tglJudul = $model->tgl_bulan;
                $analisaDokumen = $analisaDokumen
                    ->andWhere(['=', new Expression("to_char(" . Registrasi::tableName() . '.tgl_masuk' . ", 'MM-YYYY')"), $model->tgl_bulan]);
            } else if ($model->jenis_laporan == AnalisaDokumenRj::JENIS_TAHUNAN) {
                $jenisLaporan = 'Tahunan';
                $tglJudul = $model->tgl_tahun;
                $analisaDokumen = $analisaDokumen
                    ->andWhere(['=', new Expression("to_char(" . Registrasi::tableName() . '.tgl_masuk' . ", 'YYYY')"), $model->tgl_tahun]);
            }
            $ruangan = '';
            $dokter = '';
            if ($model->tipe_laporan == 'ruangan') {
                $analisaDokumen = $analisaDokumen->andWhere(['analisa_dokumen_rj.unit_id' => $model->unit_id]);
                $ruanganData = DmUnitPenempatan::find()->where(['kode' => $model->unit_id])->one();
                $ruangan = $ruanganData->nama;
                $dokter = '';
            } elseif ($model->tipe_laporan == 'dokter') {
                $analisaDokumen = $analisaDokumen->andWhere(['analisa_dokumen_rj.dokter_id' => $model->dokter_id]);
                $dokterData = TbPegawai::find()->where(['pegawai_id' => $model->dokter_id])->one();
                $ruangan = '';
                $dokter = HelperSpesialClass::getNamaPegawai($dokterData);
            }
            // $analisaDokumen->andWhere(['=', new Expression("to_char(analisa_dokumen_rj.created_at, 'MM-YYYY')"), '11-2022']);
            // ->andWhere(['>', new Expression('date (' . AnalisaDokumenDetail::tableName() . '.created_at)'), '2022-11-17'])
            $analisaDokumen = $analisaDokumen->groupBy([
                'analisa_dokumen_rj_detail.analisa_dokumen_item_id',
                'analisa_dokumen_rj_detail.analisa_dokumen_jenis_id',
                'master_item_analisa.item_analisa_id',

                'analisa_dokumen_rj_detail.analisa_dokumen_jenis_analisa_detail_id',
                'master_jenis_analisa.jenis_analisa_uraian'
            ])
                ->orderBy('analisa_dokumen_rj_detail.analisa_dokumen_jenis_id')
                ->asArray()->all();


            $query = AnalisaDokumenRjDetail::find()
                ->select([
                    'count(distinct analisa_dokumen_rj.analisa_dokumen_id) as jumlah_dokumen',
                ])
                ->innerJoin('analisa_dokumen_rj', 'analisa_dokumen_rj_detail.analisa_dokumen_id=analisa_dokumen_rj.analisa_dokumen_id')
                ->innerJoin(Registrasi::tableName(), Registrasi::tableName() . '.kode=analisa_dokumen_rj.reg_kode')
                ->innerJoin('master_item_analisa', 'master_item_analisa.item_analisa_id=analisa_dokumen_rj_detail.analisa_dokumen_item_id')
                ->innerJoin('master_jenis_analisa', 'analisa_dokumen_rj_detail.analisa_dokumen_jenis_id=master_jenis_analisa.jenis_analisa_id')
                ->innerJoin('master_jenis_analisa_detail', 'master_jenis_analisa_detail.jenis_analisa_detail_id=analisa_dokumen_rj_detail.analisa_dokumen_jenis_analisa_detail_id')
                ->where(['master_jenis_analisa_detail.jenis_analisa_detail_aktif' => 1]);

            if ($model->jenis_laporan == AnalisaDokumenRj::JENIS_HARIAN) {
                $jenisLaporan = 'Harian';
                $tglJudul = Yii::$app->formatter->asDate($model->tgl_hari);
                $query = $query
                    ->andWhere(['=', Registrasi::tableName() . '.tgl_masuk', $model->tgl_hari]);
            } else if ($model->jenis_laporan == AnalisaDokumenRj::JENIS_BULANAN) {
                $jenisLaporan = 'Bulanan';
                $tglJudul = $model->tgl_bulan;
                $query = $query
                    ->andWhere(['=', new Expression("to_char(" . Registrasi::tableName() . '.tgl_masuk' . ", 'MM-YYYY')"), $model->tgl_bulan]);
            } else if ($model->jenis_laporan == AnalisaDokumenRj::JENIS_TAHUNAN) {
                $jenisLaporan = 'Tahunan';
                $tglJudul = $model->tgl_tahun;
                $query = $query
                    ->andWhere(['=', new Expression("to_char(" . Registrasi::tableName() . '.tgl_masuk' . ", 'YYYY')"), $model->tgl_tahun]);
            }
            $ruangan = '';
            $dokter = '';
            if ($model->tipe_laporan == 'ruangan') {
                $query = $query->andWhere(['analisa_dokumen_rj.unit_id' => $model->unit_id]);
                $ruanganData = DmUnitPenempatan::find()->where(['kode' => $model->unit_id])->one();
                $ruangan = $ruanganData->nama;
                $dokter = '';
            } elseif ($model->tipe_laporan == 'dokter') {
                $query = $query->andWhere(['analisa_dokumen_rj.dokter_id' => $model->dokter_id]);
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
                ->setCellValue("A{$baseRowTitle}", 'Laporan Analisa Data EMR Rawat Jalan ' . $jenisLaporan . ' ' . ($ruangan ?? '') . ($dokter ?? ''));
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
                        ->setCellValue('J' . $baseRow, $item['lengkap'] + $item['ada'] + $item['tidak_ada']);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('K' . $baseRow, $item['tidak_lengkap']);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('L' . $baseRow, sprintf("%.2f%%", ($item['tidak_lengkap'] / $item['jumlah_dokumen']) * 100));
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
                        ->setCellValue('J' . $baseRow, $item['lengkap'] + $item['ada'] + $item['tidak_ada']);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('K' . $baseRow, ($item['tidak_lengkap']));
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('L' . $baseRow, sprintf("%.2f%%", (($item['tidak_lengkap']) / $item['jumlah_dokumen']) * 100));
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

    public function actionCetakLaporanKetidaktepatanWaktu()
    {
        $model = new LaporanKetidakTepatanWaktu();


        if ($model->load(Yii::$app->request->post())) {
            $queryData = AnalisaDokumen::find()->alias('ad')
                ->select([
                    'dup.nama',
                    'dup.kode',
                    'COUNT(ad.analisa_dokumen_id) AS total_analisa_dokumen',
                    'SUM(CASE WHEN EXTRACT(EPOCH FROM (r.tgl_keluar - rmr.tgl_pulang)) / 3600 <= 24 THEN 1 ELSE 0 END) AS jumlah_tepat_waktu_ppa',
                    '(SUM(CASE WHEN EXTRACT(EPOCH FROM (r.tgl_keluar - rmr.tgl_pulang)) / 3600 <= 24 THEN 1 ELSE 0 END) / CAST(COUNT(ad.analisa_dokumen_id) AS DECIMAL(10, 2)) * 100) AS persentase_jumlah_tepat_waktu_ppa',
                    'SUM(CASE WHEN EXTRACT(EPOCH FROM (r.tgl_keluar - rmr.tgl_pulang)) / 3600 > 24 THEN 1 ELSE 0 END) AS jumlah_tidak_tepat_waktu_ppa',
                    '(SUM(CASE WHEN EXTRACT(EPOCH FROM (r.tgl_keluar - rmr.tgl_pulang)) / 3600 > 24 THEN 1 ELSE 0 END) / CAST(COUNT(ad.analisa_dokumen_id) AS DECIMAL(10, 2)) * 100) AS persentase_jumlah_tidak_tepat_waktu_ppa',
                    'SUM(CASE WHEN EXTRACT(EPOCH FROM (r.closing_billing_ranap_at - rmr.tgl_pulang)) / 3600 <= 48 THEN 1 ELSE 0 END) AS jumlah_tepat_waktu_closing',
                    '(SUM(CASE WHEN EXTRACT(EPOCH FROM (r.closing_billing_ranap_at - rmr.tgl_pulang)) / 3600 <= 48 THEN 1 ELSE 0 END) / CAST(COUNT(ad.analisa_dokumen_id) AS DECIMAL(10, 2)) * 100) AS persentase_jumlah_tepat_waktu_closing',
                    'SUM(CASE WHEN r.closing_billing_ranap_at IS NULL OR EXTRACT(EPOCH FROM (r.closing_billing_ranap_at - rmr.tgl_pulang)) / 3600 > 48 THEN 1 ELSE 0 END) AS jumlah_tidak_tepat_waktu_closing',
                    '(SUM(CASE WHEN r.closing_billing_ranap_at IS NULL OR EXTRACT(EPOCH FROM (r.closing_billing_ranap_at - rmr.tgl_pulang)) / 3600 > 48 THEN 1 ELSE 0 END) / NULLIF(CAST(COUNT(ad.analisa_dokumen_id) AS DECIMAL(10, 2)), 0) * 100) AS persentase_jumlah_tidak_tepat_waktu_closing',
                ])
                ->innerJoin(['r' => Registrasi::tableName()], 'ad.reg_kode=r.kode')
                ->innerJoin(['l' => Layanan::tableName()], 'l.registrasi_kode = ad.reg_kode')
                ->innerJoin(['rmr' => ResumeMedisRi::tableName()], 'rmr.layanan_id = l.id')
                ->innerJoin(['dup' => Unit::tableName()], 'dup.kode = ad.unit_id')
                ->where(['dup.is_rj' => '0', 'dup.is_ri' => '1']);





            if ($model->jenis_laporan == LaporanKetidakTepatanWaktu::JENIS_HARIAN) {
                $jenisLaporan = 'Harian';
                $tglJudul = Yii::$app->formatter->asDate($model->tgl_hari);
                $queryData = $queryData
                    ->andWhere(['=',  'rmr.tgl_pulang', $model->tgl_hari]);
                // ->andWhere(['=', Registrasi::tableName() . '.tgl_keluar', $model->tgl_hari]);
            } else if ($model->jenis_laporan == LaporanKetidakTepatanWaktu::JENIS_BULANAN) {
                $jenisLaporan = 'Bulanan';
                $tglJudul = $model->tgl_bulan;
                $queryData = $queryData
                    ->andWhere(['=', new Expression("to_char(" . 'rmr.tgl_pulang' . ", 'MM-YYYY')"), $model->tgl_bulan]);
            } else if ($model->jenis_laporan == LaporanKetidakTepatanWaktu::JENIS_TAHUNAN) {
                $jenisLaporan = 'Tahunan';
                $tglJudul = $model->tgl_tahun;
                $queryData = $queryData
                    ->andWhere(['=', new Expression("to_char(" . 'rmr.tgl_pulang' . ", 'YYYY')"), $model->tgl_tahun]);
            }
            $ruangan = '';
            $dokter = '';
            if ($model->tipe_laporan == 'ruangan') {
                $queryData = $queryData->andWhere(['dup.kode' => $model->unit_id]);
                $ruanganData = DmUnitPenempatan::find()->where(['kode' => $model->unit_id])->one();
                $ruangan = $ruanganData->nama;
                $dokter = '';
            }
            // $analisaDokumen->andWhere(['=', new Expression("to_char(analisa_dokumen.created_at, 'MM-YYYY')"), '11-2022']);
            // ->andWhere(['>', new Expression('date (' . AnalisaDokumenDetail::tableName() . '.created_at)'), '2022-11-17'])
            $queryData = $queryData->groupBy(['dup.nama', 'dup.kode'])
                ->orderBy(['dup.nama' => SORT_ASC])
                ->asArray()->all();


            $spreadsheet = new Spreadsheet();
            $spreadsheet->getProperties()->setCreator('RESIKA ASSEMBLING - RSUD Arifin Achmad')
                ->setLastModifiedBy('RESIKA ASSEMBLING - RSUD Arifin Achmad')
                ->setTitle('Laporan Ketidaktepatan Waktu Rawat Inap')
                ->setSubject('Laporan Ketidaktepatan Waktu Rawat Inap')
                ->setDescription('Dicetak dari RESIKA ASSEMBLING - RSUD Arifin Achmad')
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
                ->setCellValue("A{$baseRowTitle}", 'LAPORAN HASIL AUDIT KETEPATAN WAKTU PENGISIAN DOKUMEN  ELEKTRONIK MEDICAL RECORD (EMR) ' . $jenisLaporan . ' ' . ($ruangan ?? '') . ($dokter ?? ''));
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
                ->setCellValue("A{$baseRowTitle}", 'BERDASARKAN RUANGAN/UNIT PELAYANAN (' . $tglJudul . ')');
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRowTitle}")->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRowTitle}")->getFont()->setBold(true);

            $baseRowTitle++;


            \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder(new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());
            $baseRowTitle++;
            $baseRowTable = $baseRowTitle + 1;
            $spreadsheet->getActiveSheet()
                ->mergeCells("A" . ($baseRowTable) . ":A" . ($baseRowTable + 2));
            $spreadsheet->getActiveSheet()
                ->mergeCells("B" . ($baseRowTable) . ":B" . ($baseRowTable + 2));
            $spreadsheet->getActiveSheet()
                ->mergeCells("C" . ($baseRowTable + 1) . ":C" . ($baseRowTable + 2));
            $spreadsheet->getActiveSheet()
                ->mergeCells("C" . ($baseRowTable) . ":K" . ($baseRowTable));

            $spreadsheet->getActiveSheet()
                ->mergeCells("D" . ($baseRowTable + 1) . ":G" . ($baseRowTable + 1));
            $spreadsheet->getActiveSheet()
                ->mergeCells("H" . ($baseRowTable + 1) . ":K" . ($baseRowTable + 1));
            foreach (range('C', 'K') as $columnID) {
                $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                    ->setWidth('20');
            }
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                ->setWidth('20');


            $spreadsheet->getActiveSheet()
                ->getStyle("A" . ($baseRowTable) . ":K" . ($baseRowTable + 2))
                ->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            $spreadsheet->getActiveSheet()
                ->getStyle("A" . ($baseRowTable) . ":K" . ($baseRowTable + 2))
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
            $spreadsheet->getActiveSheet()->getColumnDimension('B')
                ->setWidth('15');
            $spreadsheet->getActiveSheet()
                ->setCellValue("A{$baseRowTable}", 'NO');
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRowTable}")->getAlignment()->setHorizontal('center')->setVertical('center');
            $spreadsheet->getActiveSheet()
                ->setCellValue("B{$baseRowTable}", 'UNIT PELAYANAN/ NAMA RUANG');
            $spreadsheet->getActiveSheet()->getStyle("B{$baseRowTable}")->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle("B{$baseRowTable}")->getAlignment()->setWrapText(true);

            $spreadsheet->getActiveSheet()
                ->setCellValue("C{$baseRowTable}", 'JUMLAH DOKUMEN');
            $spreadsheet->getActiveSheet()->getStyle("J{$baseRowTable}")->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()
                ->setCellValue("C" . ($baseRowTable + 1), 'DI ANALISA');
            $spreadsheet->getActiveSheet()->getRowDimension($baseRowTable + 1)
                ->setRowHeight('20');
            $spreadsheet->getActiveSheet()->getRowDimension($baseRowTable + 2)
                ->setRowHeight('30');
            $spreadsheet->getActiveSheet()
                ->setCellValue("D" . ($baseRowTable + 1), 'KETEPATAN WAKTU PENGISIAN EMR OLEH PPA (1 X 24 Jam)');


            $spreadsheet->getActiveSheet()
                ->setCellValue("H" . ($baseRowTable + 1), 'KETEPATAN WAKTU CLOSING SISTIM EMR OLEH ADMIN (2 X 24 JAM)');
            $spreadsheet->getActiveSheet()->getStyle("A" . ($baseRowTable + 1))->getAlignment()->setHorizontal('center');

            // Assume $baseRowTable is defined and initialized appropriately


            $spreadsheet->getActiveSheet()->setCellValue("D" . ($baseRowTable + 2), 'TEPAT WAKTU');
            $spreadsheet->getActiveSheet()->setCellValue("E" . ($baseRowTable + 2), 'PERSENTASE TEPAT WAKTU (%)');
            $spreadsheet->getActiveSheet()->setCellValue("F" . ($baseRowTable + 2), 'TIDAK TEPAT WAKTU');
            $spreadsheet->getActiveSheet()->setCellValue("G" . ($baseRowTable + 2), 'PERSENTASE TIDAK TEPAT WAKTU (%)');
            $spreadsheet->getActiveSheet()->setCellValue("H" . ($baseRowTable + 2), 'TEPAT WAKTU');
            $spreadsheet->getActiveSheet()->setCellValue("I" . ($baseRowTable + 2), 'PERSENTASE TEPAT WAKTU (%)');
            $spreadsheet->getActiveSheet()->setCellValue("J" . ($baseRowTable + 2), 'TIDAK TEPAT WAKTU');
            $spreadsheet->getActiveSheet()->setCellValue("K" . ($baseRowTable + 2), 'PERSENTASE TIDAK TEPAT WAKTU (%)');
            foreach (range('D', 'K') as $columnID) {
                $spreadsheet->getActiveSheet()->getStyle($columnID . ($baseRowTable + 2))->getAlignment()->setWrapText(true);
            }

            // foreach (range('J', 'K') as $columnID) {
            //     $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
            //         ->setWidth('15');
            // }

            $baseRowTable++;
            $baseRowTable++;
            $baseRow = $baseRowTable + 1;

            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $no = 1;
            $jenis = [null, null];
            foreach ($queryData as $index => $item) {

                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $baseRow, $index + 1);
                $spreadsheet->getActiveSheet()->getStyle('A' . $baseRow)->getAlignment()->setWrapText(false);
                $spreadsheet->getActiveSheet()->getStyle('A' . $baseRow)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('B' . $baseRow)->getAlignment()->setHorizontal('left')->setVertical('center');
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('B' . $baseRow, $item['nama']);
                $spreadsheet->getActiveSheet()->getStyle('C' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('c' . $baseRow, $item['total_analisa_dokumen']);
                $spreadsheet->getActiveSheet()->getStyle('D' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('D' . $baseRow, $item['jumlah_tepat_waktu_ppa']);
                $spreadsheet->getActiveSheet()->getStyle('E' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('E' . $baseRow, $item['persentase_jumlah_tepat_waktu_ppa']);
                $spreadsheet->getActiveSheet()->getStyle('E' . $baseRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);
                $spreadsheet->getActiveSheet()->getStyle('F' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('F' . $baseRow, $item['jumlah_tidak_tepat_waktu_ppa']);
                $spreadsheet->getActiveSheet()->getStyle('G' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('G' . $baseRow, $item['persentase_jumlah_tidak_tepat_waktu_ppa']);
                $spreadsheet->getActiveSheet()->getStyle('G' . $baseRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);
                $spreadsheet->getActiveSheet()->getStyle('H' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('H' . $baseRow, $item['jumlah_tepat_waktu_closing']);
                $spreadsheet->getActiveSheet()->getStyle('I' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('I' . $baseRow, $item['persentase_jumlah_tepat_waktu_closing']);
                $spreadsheet->getActiveSheet()->getStyle('I' . $baseRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);
                $spreadsheet->getActiveSheet()->getStyle('J' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('J' . $baseRow, $item['jumlah_tidak_tepat_waktu_closing']);
                $spreadsheet->getActiveSheet()->getStyle('K' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('K' . $baseRow, $item['persentase_jumlah_tidak_tepat_waktu_closing']);
                $spreadsheet->getActiveSheet()->getStyle('K' . $baseRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);
                $baseRowItem = $baseRow;
                $baseRowItem++;
                $baseRow = $baseRowItem;
                $no++;
            }


            $spreadsheet->getActiveSheet()->getStyle("A{$baseRow}")->getAlignment()->setHorizontal('center')->setVertical('center');
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRow}")->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle("J{$baseRow}")->getAlignment()->setHorizontal('center')->setVertical('center');
            $spreadsheet->getActiveSheet()->getStyle("J{$baseRow}")->getFont()->setBold(true);
            // return json_encode($query[0]['jumlah_dokumen']);

            $spreadsheet->getActiveSheet()
                ->setCellValue("A{$baseRow}", 'Total');

            //     ->setCellValue("J{$baseRow}", $query[0]['jumlah_dokumen'] . " Dokumen");


            $spreadsheet->getActiveSheet()
                ->getStyle("A{$baseRowTable}:K{$baseRow}")
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
            header('Content-Disposition: attachment;filename="Laporan Ketidaktepatan Waktu EMR ' . $jenisLaporan . ' ' . $tglJudul . '.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit(); // -> agar file tidak corrupt


        }
    }
}
