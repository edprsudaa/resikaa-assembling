<?php

namespace app\controllers;

use Yii;
use app\components\HelperSpesialClass;
use app\components\HelperGeneralClass;
use app\models\pegawai\DmUnitPenempatan;
use app\models\pegawai\TbPegawai;

use app\models\pendaftaran\Layanan;
use app\models\pendaftaran\Registrasi;
use app\models\pengolahandata\MasterJenisAnalisaDetail;
use app\models\pengolahandata\AnalisaDokumen;
use app\models\pengolahandata\AnalisaDokumenRj;
use app\models\pengolahandata\AnalisaDokumenRjDetail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;

class AnalisaKuantitatifRjController extends Controller
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
    public function actionDaftarAnalisaKuantitatif()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request->post("datatables");
        $tanggal_awal = null;
        $tanggal_akhir = null;

        if ($req['tanggal_awal'] != null) {
            $tanggal_awal = $req['tanggal_awal'];
        } else {
            $tanggal_awal = date('Y-m-d');
        }
        if ($req['tanggal_akhir'] != null) {
            $tanggal_akhir = $req['tanggal_akhir'];
        } else {
            $tanggal_akhir = date('Y-m-d');
        }



        $layanan = Layanan::find()->alias('l')
            ->select([
                'r.kode as registrasi_kode',
                'r.pasien_kode',
                'p.nama as nama',
                'dup.nama as unit_nama',
                'r.tgl_masuk',
                'r.is_analisa as analisa'
            ])
            ->innerJoin('pendaftaran.registrasi r', 'r.kode=l.registrasi_kode')
            ->innerJoin('pendaftaran.pasien p', 'p.kode=r.pasien_kode')
            ->innerJoin('pegawai.dm_unit_penempatan dup', 'dup.kode=l.unit_kode')
            ->where([">=", "r.tgl_masuk", $tanggal_awal . " 00:00:00"])
            ->andWhere(["<=", "r.tgl_masuk", $tanggal_akhir . " 23:59:59"])
            ->andWhere(["r.deleted_at" => null])
            ->andWhere(['l.jenis_layanan' => '2']);
        if ($req['analisa'] != null) {
            if ($req['analisa'] == 1) {
                $layanan = $layanan->andWhere(["r.is_analisa" => 1]);
            } elseif ($req['analisa'] == 0) {
                $layanan = $layanan->andWhere(["r.is_analisa" => 0]);
            }
        }
        $layanan = $layanan->orderBy(['r.tgl_masuk' => SORT_ASC])
            ->asArray()
            ->all();

        $groupedData = [];

        $result = [];
        $counter = 0; // Inisialisasi variabel counter mulai dari 0
        foreach ($layanan as $key => $row) {
            $kode = $row['registrasi_kode'];

            // Membuat entri baru jika kode belum ada
            if (!isset($result[$kode])) {
                $result[$kode] = [
                    'kode' => $kode,
                    'pasien_kode' => $row['pasien_kode'],
                    'poliList' => [],
                    'nama' => $row['nama'],
                    'tgl_masuk' => $row['tgl_masuk'],
                    'analisa' => $row['analisa'],
                    'registrasi_kode_hash' => HelperGeneralClass::hashData($kode)
                ];
            }

            // Menambahkan unit_nama ke dalam array poliList
            if (!in_array($row['unit_nama'], $result[$kode]['poliList'])) {
                $result[$kode]['poliList'][] = $row['unit_nama'];
            }
        }
        return [
            "status" => 200,
            "message" => "Data successfully retrieved",
            "data" => $result
        ];
    }
    public function actionView($id = null, $icd = false)
    {
        $registrasi = HelperSpesialClass::getCheckPasien($id);
        $layananId = array();
        $layananOperasi = array();
        foreach ($registrasi->data['layanan'] as $item) {
            $layananId[] = $item['id'];
            if ($item['jenis_layanan'] == '5') {
                $layananOperasi[] = $item['id'];
            }
        }

        $analisaDokumen = AnalisaDokumenRj::find()->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->one();

        if (!empty($analisaDokumen)) {
            $analisaDokumen = AnalisaDokumenRj::find()
                ->innerJoin('analisa_dokumen_rj_detail', 'analisa_dokumen_rj_detail.analisa_dokumen_id=analisa_dokumen_rj.analisa_dokumen_id')
                ->where(['reg_kode' => $registrasi->data['kode']])->limit(1)->orderBy([
                    AnalisaDokumenRjDetail::tableName() . '.analisa_dokumen_item_id' => SORT_ASC,
                    AnalisaDokumenRjDetail::tableName() . '.analisa_dokumen_jenis_id' => SORT_ASC
                ])->one();
        } else {
            $analisaDokumen = new AnalisaDokumenRj();
        }

        $listAnalisa = MasterJenisAnalisaDetail::find()->innerJoinWith(['jenisAnalisa', 'itemAnalisa'])->where(['jenis_analisa_detail_aktif' => 1])->andWhere(['jenis_analisa_detail_rj' => 1])->orderBy(['jenis_analisa_detail_jenis_analisa_id' => SORT_ASC, 'jenis_analisa_detail_item_analisa_id' => SORT_ASC])->asArray()->all();

        if (!$registrasi->con) {
            \Yii::$app->session->setFlash('warning', $registrasi->msg);
            return Yii::$app->response->redirect(Url::to(['/site/index/'], false));
        }
        return $this->render(
            'view',
            [
                'registrasi' => $registrasi->data,
                'model' => $analisaDokumen,
                'listAnalisa' => $listAnalisa,
                'icd' => $icd
            ]
        );
    }


    public function actionSave()
    {
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $id = $req->post('analisa_dokumen_id');



            if ($id != NULL) {
                $model = AnalisaDokumenRj::find()->where(['ps_kode' => $req->post('AnalisaDokumenRj')['ps_kode'], 'reg_kode' => $req->post('AnalisaDokumenRj')['reg_kode']])->limit(1)->one();
            } else {
                $model = new AnalisaDokumenRj();
            }
            $model->load($req->post());

            if ($model->validate()) {
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





    public function actionCetakAnalisa()
    {

        $model = new AnalisaDokumenRj();


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
                ->innerJoin('master_jenis_analisa_detail', 'master_jenis_analisa_detail.jenis_analisa_detail_id=analisa_dokumen_rj_detail.analisa_dokumen_jenis_analisa_detail_id');

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
                ->innerJoin('master_jenis_analisa_detail', 'master_jenis_analisa_detail.jenis_analisa_detail_id=analisa_dokumen_rj_detail.analisa_dokumen_jenis_analisa_detail_id');
            // ->where(['analisa_dokumen_rj.dokter_id'=>'38'])

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
                ->setCellValue("A{$baseRowTitle}", 'Laporan Analisa Data EMR ' . $jenisLaporan . ' ' . ($ruangan ?? '') . ($dokter ?? ''));
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRowTitle}")->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle("A{$baseRowTitle}")->getFont()->setBold(true);

            $baseRowTitle++;

            $spreadsheet->getActiveSheet()
                ->mergeCells("A" . ($baseRowTitle) . ":L" . ($baseRowTitle));

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
                    $spreadsheet->getActiveSheet()->getStyle('J' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                    $spreadsheet->getActiveSheet()->getStyle('K' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                    $spreadsheet->getActiveSheet()->getStyle('L' . $baseRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('J' . $baseRow, $item['ada']);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('K' . $baseRow, $item['tidak_ada']);
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('L' . $baseRow, sprintf("%.2f%%", ($item['tidak_ada'] / $item['jumlah_dokumen']) * 100));
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
}
