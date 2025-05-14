<?php

return [
    'bsVersion' => '4.x',
    'nik_pemilik' => 1471102605960025,
    // ------------------SETTINGAN SSO ATAU LOCALHOST ----------------------------- //
    'config_sso' => true, // sso
    // 'config_sso' => false, // localhost
    // ---------------------------------------------------------------------------- //
    'fitur' => [
        'riwayat' => true,
        'esep' => true,
        'closing' => true,
        'resume_medis_ri' => true,
        'resume_medis_rj' => true,
    ],
    'tte' => [
        'versi' => [
            'resume_medis_ri' => '2.0',
            'resume_medis_rj' => '2.0',

        ],
        'kode-dokumen' => [
            'resume_medis_ri' => 'resume_medis_ri',
            'resume_medis_rj' => 'resume_medis_rj',

        ],
    ],
    'app' => [
        'shortName' => 'RESIKA ASSEMBLING',
        'longName' => 'Resika Assembling',
        'fullName' => 'RESIKA ASSEMBLING',
        'version' => '3.24.6.7',
        'createAt' => '2022'
    ],
    'client' => [
        'shortName' => 'RSUD ARIFIN ACHMAD',
        'longName' => ' RSUD ARIFIN ACHMAD',
        'fullName' => 'RSUD ARIFIN ACHMAD',
        'address' => ' Jl. Diponegoro No.01',
        'telp' => '(07xx) - 2xxx, 2xxx',
        'fax' => '(07xx) - 2xxx',
        'website' => 'http://rsudarifinachmad.riau.go.id',
        'email' => 'admin@rsudarifinachmad.riau.go.id'
    ],
    'owner' => [
        'shortName' => 'RSUD ARIFIN ACHMAD',
        'longName' => ' RSUD ARIFIN ACHMAD',
        'fullName' => 'RSUD ARIFIN ACHMAD',
        'address' => ' Jl. Diponegoro No.01',
        'telp' => '(07xx) - 2xxx, 2xxx',
        'fax' => '(07xx) - 2xxx',
        'website' => 'http://rsudarifinachmad.riau.go.id',
        'email' => 'admin@rsudarifinachmad.riau.go.id'
    ],
    'local' => [
        'Owner' => 'RSUD Arifin Achmad',
        'OwnerAddress' => 'Jl. Diponegoro No.2 Pekanbaru',
        'OwnerTelp' => 'Telp.(0761) 21618, 23418, 21657 FAX.(0761) 20253',
    ],

    'other' => [
        // 'keys' => 'EDP@123DeniSapri',
        'keys' => 'EMS@123FikriUtriaMri',

        'username_allow_root' => ['1471062008970021'], //sso ROOT bisa akses pasien & RBAC
        'username_allow_admin' => ['1471062008970021'], //sso ROOT bisa akses pasien
        'skrining_pasien_mpp' => [
            'spmpp' => [
                'penilaian' => [
                    [
                        'id' => 'spmpp_q1',
                        'parameter' => 'Usia',
                        'kriteria' =>
                        [
                            ['des' => 'Neonatus - 1 Tahun atau > 60 tahun', 'val' => '2', 'pilih' => '0'],
                            ['des' => '18 - 60 tahun', 'val' => '1', 'pilih' => '0'],
                            ['des' => '1 - 18 tahun', 'val' => '0', 'pilih' => '0']
                        ]
                    ],
                    [
                        'id' => 'spmpp_q2',
                        'parameter' => 'Gangguan Fungsi kognitif rendah',
                        'kriteria' =>
                        [
                            ['des' => 'Gangguan Kejiwaan Berat ', 'val' => '2', 'pilih' => '0'],
                            ['des' => 'Gangguan Kecemasan', 'val' => '1', 'pilih' => '0'],
                            ['des' => 'Tidak ada gangguan kejiwaan', 'val' => '0', 'pilih' => '0']
                        ]
                    ],
                    [
                        'id' => 'spmpp_q3',
                        'parameter' => 'Pasien beresiko tinggi, potensi komplain biaya',
                        'kriteria' =>
                        [
                            ['des' => 'Tidak ada jaminan / kurang mampu / terlantar', 'val' => '2', 'pilih' => '0'],
                            ['des' => 'Ada jaminan tapi dalam pengurusan', 'val' => '1', 'pilih' => '0'],
                            ['des' => 'Ada jaminan (Umum, Asuransi)', 'val' => '0', 'pilih' => '0']
                        ]
                    ],
                    [
                        'id' => 'spmpp_q4',
                        'parameter' => 'Penyakit Kronis, katastrofik, terminal',
                        'kriteria' =>
                        [
                            ['des' => 'Membutuhkan alat bantu hidup, riwayat penggunaan alat medis dan multi diagise > 2 DPJP', 'val' => '2', 'pilih' => '0'],
                            ['des' => 'Membutuhkan alat bantu hidup, riwayat penggunaan alat medis dengan 1-2 DPJP', 'val' => '1', 'pilih' => '0'],
                            ['des' => 'Membutuhkan alat bantu hidup minimal ', 'val' => '0', 'pilih' => '0']
                        ]
                    ],
                    [
                        'id' => 'spmpp_q5',
                        'parameter' => 'Fungsi ADL (Activity of Daily Living)',
                        'kriteria' =>
                        [
                            ['des' => 'Intensive atau Total Care', 'val' => '2', 'pilih' => '0'],
                            ['des' => 'Partian Care', 'val' => '1', 'pilih' => '0'],
                            ['des' => 'Minimal Care', 'val' => '0', 'pilih' => '0']
                        ]
                    ],
                    [
                        'id' => 'spmpp_q6',
                        'parameter' => 'Pasien dengan riwayat pemakain peralatan medis',
                        'kriteria' =>
                        [
                            ['des' => 'Ada, > 2 peralatan medis', 'val' => '2', 'pilih' => '0'],
                            ['des' => 'Ada, 1 peralatan medis', 'val' => '1', 'pilih' => '0'],
                            ['des' => 'Tidak ada', 'val' => '0', 'pilih' => '0']
                        ]
                    ],
                    [
                        'id' => 'spmpp_q7',
                        'parameter' => 'Riwayat gangguan mental (suicide, krisis keluarga, terlantar, tinggal sendiri, narkoba)',
                        'kriteria' =>
                        [
                            ['des' => 'Ada, kompleks', 'val' => '2', 'pilih' => '0'],
                            ['des' => 'Ada, salah satu gangguan', 'val' => '1', 'pilih' => '0'],
                            ['des' => 'Tidak ada', 'val' => '0', 'pilih' => '0']
                        ]
                    ],
                    [
                        'id' => 'spmpp_q8',
                        'parameter' => 'Read Misi',
                        'kriteria' =>
                        [
                            ['des' => '< 3 bulan terakhir dengan kasus sama', 'val' => '2', 'pilih' => '0'],
                            ['des' => 'Dalam 1 tahun terakhir dengan kasus yang sama atau berbeda', 'val' => '1', 'pilih' => '0'],
                            ['des' => 'Belum pernah di rawat sebelumnya', 'val' => '0', 'pilih' => '0']
                        ]
                    ],
                    [
                        'id' => 'spmpp_q9',
                        'parameter' => 'Perkiraan LOS (lengt Of Stay)',
                        'kriteria' =>
                        [
                            ['des' => '> 9 hari', 'val' => '2', 'pilih' => '0'],
                            ['des' => '7 - 9 hari', 'val' => '1', 'pilih' => '0'],
                            ['des' => '< 7 hari', 'val' => '0', 'pilih' => '0']
                        ]
                    ],
                    [
                        'id' => 'spmpp_q10',
                        'parameter' => 'Discharge Planing (Rencana Pemulangan Kritis)',
                        'kriteria' =>
                        [
                            ['des' => 'Perlu, ada care giver (khusus medis)', 'val' => '2', 'pilih' => '0'],
                            ['des' => 'Perlu, ada care giver', 'val' => '1', 'pilih' => '0'],
                            ['des' => 'Tidak perlu', 'val' => '0', 'pilih' => '0']
                        ]
                    ],
                    [
                        'id' => 'spmpp_q11',
                        'parameter' => 'Kebutuhan Edukasi Kesehatan',
                        'kriteria' =>
                        [
                            ['des' => 'Proses edukasi tidak mendukung', 'val' => '2', 'pilih' => '0'],
                            ['des' => 'Proses edukasi kurang mendukung', 'val' => '1', 'pilih' => '0'],
                            ['des' => 'Proses edukasi dapat diterima', 'val' => '0', 'pilih' => '0']
                        ]
                    ],
                    [
                        'id' => 'spmpp_q12',
                        'parameter' => 'Akses ke RSUD / Lokasi tempat tinggal',
                        'kriteria' =>
                        [
                            ['des' => 'Akses ke RSUD > 30 menit', 'val' => '2', 'pilih' => '0'],
                            ['des' => 'Akses ke RSUD 10 - 30 menit', 'val' => '1', 'pilih' => '0'],
                            ['des' => 'Akses ke RSUD < 10 menit', 'val' => '0', 'pilih' => '0']
                        ]
                    ],

                ],
                'total_skor' => '',
                'kategori_skor' => '',
                'keterangan_skor' => '-'
            ],

        ],
        'neonatus' => [
            'bantuan_diperlukan_dalam_hal' => [
                0 => 'Menyiapkan Makanan',
                1 => 'Makan Diet',
                2 => 'Menyiapkan Obat',
                3 => 'Minum Obat',
                4 => 'Mandi',
                5 => 'Berpakaian',
                6 => 'Transportasi',
                7 => 'Edukasi Kesehatan',
                8 => '',
            ],
        ],

    ],
    'setting' => [
        'adminlte' =>
        [
            'bg_color_style' => '#28a745', #28a745=>green, #e83e8c=>pink
            'color_style' => '#ffffff',
            'navbar_class' => 'main-header navbar navbar-expand navbar-dark navbar-green text-sm',
            'body_class' => 'sidebar-mini layout-fixed layout-navbar-fixed accent-green text-sm',
            'body_class_collapse' => 'sidebar-mini layout-fixed sidebar-collapse accent-green text-sm',
            'aside_sidebar_class' => 'main-sidebar elevation-4 sidebar-light-green',
            'aside_sidebar_class_dark' => 'main-sidebar sidebar-dark-primary elevation-4',
            'card' => 'card card-outline card-success',
            'code_color_style2' => [
                'bg' => '#ffffff',
                'color' => '#28a745'
            ]
        ],
        'paging' => [
            'size' => [
                'short' => 5,
                'medium' => 10,
                'long' => 20
            ]
        ],
        'iframe' => [
            'body_class' => 'accent-green text-sm',
        ],
        'msg_chk_allow_crud_medis_pasien' => 'Data Tidak Dapat Dihapus Lagi',
        'mapping_doc_item_clinical' => [
            'DM_000001' => 1, //Formulir DPJP
            'DM_000002' => 2, //Asesmen Awal Medis General
            'DM_000003' => 3, //CPPT
            'DM_000004' => 4, //RESUME MEDIS IGD & RJ
            'DM_000005' => 5, //Order Penunjang
            'DM_000006' => 6, //Resep Obat
            'DM_000007' => 7, //Asesmen Awal Keperawatan
            'DM_000008' => 8, //Resume Medis RI
            'DM_000009' => 9, //Asesmen Awal Gizi
            'DM_000010' => 10, //Asesmen Awal Keperawatan Neonatus
            'DM_000011' => 11, //Asesmen Awal Hemidialisis
            'DM_000012' => 12, //Asesmen Awal Kebidanan
            'DM_000013' => 13, //Partograf & Catatan Persalinan
            'DM_000014' => 14, //Laporan Persalinan
            'DM_000015' => 15, //Asesmen Awal Bayi Baru Lahir
            'DM_000016' => 16, //Lembar Observasi
            'DM_000017' => 17, //Asesmen Awal Keperawatan Psikiatri
            'DM_000018' => 18, //Asesmen Awal Medis Psikiatri
            'DM_000019' => 19, //Asesmen Awal Medis Obstetri & Ginekologi
            'DM_000020' => 20, //Odontogram Anak
            'DM_000021' => 21, //Odontogram Dewasa
        ],
        //RSAA
        'kop_doc' => [
            'nama' => 'PEMERINTAHAN RIAU',
            'namasub' => 'RSUD ARIFIN ACHMAD',
            'alamat' => 'Jl. Pekanbaru No. x Telp. (0761) xxxxx Fax. (0761) xxxxx Pekanbaru-xxxxx',
            'logo1' => '/app/images/logo-kop-doc-clinical-pasien.png',
            'logo2' => '/app/images/logo-kop-doc-clinical-pasien.png',
            'logo3' => '/app/images/logo-kop-doc-clinical-pasien.png'
        ],
        'odontogram' => '/app/images/odontogram.PNG',
        'doc' => [
            'bg_batal' => '/images/batal-transparan-min.png'
        ],
        'show_stock_obat_depo' => true,
    ],
    'hail812/yii2-adminlte3' => [
        'pluginMap' => [
            'icheck-bootstrap' => [
                'css' => 'icheck-bootstrap/icheck-bootstrap.min.css',
            ],
            'overlayScrollbars' => [
                'css' => 'overlayScrollbars/css/OverlayScrollbars.min.css',
                'js' => 'overlayScrollbars/js/jquery.overlayScrollbars.min.js',
            ],
            'pace' => [
                'css' => 'pace-progress/themes/red/pace-theme-loading-bar.css',
                'js' => 'pace-progress/pace.min.js'
            ],
            'pace-iframe' => [
                'css' => 'pace-progress/themes/green/pace-theme-flat-top.css',
                'js' => 'pace-progress/pace.min.js'
            ],
            'popper' => [
                'js' => 'popper/umd/popper.min.js'
            ],
            'sweetalert2' => [
                'css' => 'sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
                'js' => 'sweetalert2/sweetalert2.min.js'
            ],
            'toastr' => [
                'css' => ['toastr/toastr.min.css'],
                'js' => ['toastr/toastr.min.js']
            ],
            'jquery' => [
                'css' => [],
                'js' => ['jquery/jquery.min.js']
            ],
            'jquery-ui' => [
                'css' => ['jquery-ui/jquery-ui.min.css'],
                'js' => ['jquery-ui/jquery-ui.min.js']
            ],
            'jquery-validation' => [
                'css' => [],
                'js' => ['jquery-validation/jquery-validate.min.js']
            ],
        ]
    ],
    'storage' => [
        'peminjaman-rekam-medis' => '../storage/peminjaman-rekam-medis/',
        'panduan-praktik-klinis' => '../storage/panduan-praktik-klinis/',
    ],
    'mpp' => [
        158 => [
            'id' => 158, //'196709211998031003',//dr marlon
            'unit' => [131, 132, 130, 349, 350]
        ],
        63 => [
            'id' => 63, //'196311031998031001'//dr ali
            'unit' => [
                267,
                263,
                111,
                359,
            ]
        ],

        3218 => [
            'id' => 3218, //'198304082010012016'//Tengku Lya
            'unit' => [
                117,
                264,
                121,
                129,
                339,
                132,
                144,
                119,
                214,
                118,
                111,
                265,
                125,
                216,
                191,
                120,
                123,
                128,
                136,
                131,
                207,
                269,
                142,
                130,
                241,
                263,
                122
            ]
        ],
        3405 => [
            'id' => 3405, //'197810302009032002'//SAFRINA S. PANE
            'unit' => [
                117,
                264,
                121,
                129,
                339,
                132,
                144,
                119,
                214,
                118,
                111,
                265,
                125,
                216,
                191,
                120,
                123,
                128,
                136,
                131,
                207,
                269,
                142,
                130,
                241,
                263,
                122
            ]
        ],
        332 => [
            'id' => 332, //'197407262006042008'//TENGKU MISDALIA
            'unit' => [119]
        ],

        749 => [
            'id' => 749, //'198409282010012028'//dr putri
            'unit' => [202, 213, 216, 260, 207, 232, 215, 261, 111, 263, 359, 122, 339, 117, 119]
        ],
        252 => [
            'id' => 252, //197012292002122001,//dr dewi
            'unit' => [305, 123, 125]
        ],
        204 => [
            'id' => 204, //'196905071989012002'//ns nurmiati
            'unit' => [

                264,
                265,
                113,
                263,
                111,
            ]
        ],
        442 => [
            'id' => 442, //'197707141999032003'//ns henny
            'unit' => [339, 122]
        ],
        194 => [
            'id' => 194, //'196901311989032004'//ns devi yanti
            'unit' => [118, 120, 304]
        ],
        94 => [
            'id' => 94, //'196503241989032004'//ns arriyaniy
            'unit' => [119, 303, 117, 269, 349, 350]
        ],
        98 => [
            'id' => 98, //'196505281987032004'//ns toleransih
            'unit' => [129, 214, 314, 128, 136]
        ],
        545 => [
            'id' => 545, //'197904212009032001'//ns sofia
            'unit' => [121, 216, 191]
        ],
        3231 => [
            'id' => 3231, //1472012108970004 riski
            'unit' => NULL,
        ],

        383 => [
            'id' => 383, //197605031997032002,//SUSILAWATI SIMATUPANG
            'unit' => [215, 267, 207, 111]
        ],
    ],

    'dokter_verifikator' => [
        3326 => [
            'id' => 3326, //dr fakhrul
            'unit' => []
        ],
        710 => [
            'id' => 710, //
            'unit' => []
        ],
        3654 => [
            'id' => 3654, //
            'unit' => []
        ],
        // 2940 => [
        //     'id' => 2940, //
        //     'unit' => []
        // ],
        695 => [
            'id' => 695, //
            'unit' => []
        ],
        3323 => [
            'id' => 3323, //
            'unit' => []
        ],
        3396 => [
            'id' => 3396, //
            'unit' => []
        ],

        3539 => [
            'id' => 3539, //deni sapri
            'unit' => []
        ],
        425 => [
            'id' => 425, //deni sapri
            'unit' => []
        ],
        463 => [
            'id' => 463, //deni sapri
            'unit' => []
        ],
        3526 => [
            'id' => 3526, //deni sapri
            'unit' => []
        ],
        896 => [
            'id' => 896, //deni sapri
            'unit' => []
        ],
    ],
    'coder' => [

        362 => [
            'id' => 362, //
            'unit' => []
        ],
        896 => [
            'id' => 896, //
            'unit' => []
        ],
        892 => [
            'id' => 892, //
            'unit' => []
        ],
        1673 => [
            'id' => 1673, //
            'unit' => []
        ],
        1327 => [
            'id' => 1327, //
            'unit' => []
        ],
        3454 => [
            'id' => 3454, //
            'unit' => []
        ],
        809 => [
            'id' => 809, //
            'unit' => []
        ],
        1198 => [
            'id' => 1198, //
            'unit' => []
        ],
        3457 => [
            'id' => 3457, //
            'unit' => []
        ],

        1873 => [
            'id' => 1873, //
            'unit' => []
        ],
        3478 => [
            'id' => 3478, //
            'unit' => []
        ],
        1221 => [
            'id' => 1221, //
            'unit' => []
        ],
        3619 => [
            'id' => 3619, //
            'unit' => []
        ],
        716 => [
            'id' => 716, //
            'unit' => []
        ],



    ],
    'programmer' => [

        3228 => [
            'id' => 3228, //deni sapri
            'unit' => []
        ],
        3229 => [
            'id' => 3229, //deni sapri
            'unit' => []
        ],



    ],
    'analisa-dokumen' => [


        // 1869 => [
        //     'id' => 1869, //MUHAMMAD TANTAWI
        //     'unit' => []
        // ],

    ],
    'analisa-coder' => [

        888 => [
            'id' => 888, //LATIFAH HANOUM
            'unit' => []
        ],


        1869 => [
            'id' => 1869, //MUHAMMAD TANTAWI
            'unit' => []
        ],
        1406 => [
            'id' => 1406, //ROSMAWATI A.Md.PK
            'unit' => []
        ],
        1184 => [
            'id' => 1184, //KURNIA
            'unit' => []
        ],
        547 => [
            'id' => 547, //Kak Meri
            'unit' => []
        ],

        3342 => [
            'id' => 3342, //Kak Meri
            'unit' => []
        ],
        726 => [
            'id' => 726, //SUKMAWATI AMBAR KP
            'unit' => []
        ],
    ],
    'pengolahan-data' => [
        929 => [
            'id' => 929, //ANDRE ABWIN VANES
            'unit' => []
        ],

        1138 => [
            'id' => 1138, //deni sapri
            'unit' => []
        ],
        1461 => [
            'id' => 1461, //deni sapri
            'unit' => []
        ],
        3469 => [
            'id' => 3469, //deni sapri
            'unit' => []
        ],

    ],
    'akses-daftar-pasien' => [
        710 => [
            'id' => 710, //
            'unit' => []
        ],
        1869 => [
            'id' => 1869, //MUHAMMAD TANTAWI
            'unit' => []
        ],

        360 => [
            'id' => 360, //NURI JELITA IDRUS
            'unit' => []
        ],
        139 => [
            'id' => 139, //RIAMIN MARIA SIMANIHURUK
            'unit' => []
        ],
        402 => [
            'id' => 402, //NOLY EKA FITRIA
            'unit' => []
        ],
        281 => [
            'id' => 281, //MISYENNI RUMAISYA
            'unit' => []
        ],
        547 => [
            'id' => 547, //ASMERINAWATI
            'unit' => []
        ],

    ],
    'casemix-rj' => [],
    'casemix-ri' => [],
    'casemix-igd' => [],
    'casemix' => [

        704 => [
            'id' => 704, //LIDIA ELMADONA
            'unit' => []
        ],
        488 => [
            'id' => 488, //RITA ARISANDI
            'unit' => []
        ],
        268 => [
            'id' => 268, //NURBAITI
            'unit' => []
        ],
        453 => [
            'id' => 453, //SRI AINI
            'unit' => []
        ],
        351 => [
            'id' => 351, //AINI SURYANI
            'unit' => []
        ],
        676 => [
            'id' => 676, //MELVA LOVINA
            'unit' => []
        ],
        3552 => [
            'id' => 3552, //YASTI NURAINI
            'unit' => []
        ],
        375 => [
            'id' => 375, //SUSI NORITA
            'unit' => []
        ],
        255 => [
            'id' => 255, //JASWANDI
            'unit' => []
        ],
        626 => [
            'id' => 626, //ERLINA
            'unit' => []
        ],
        1440 => [
            'id' => 1440, //SITI AISYAH POHAN
            'unit' => []
        ],
        960 => [
            'id' => 960, //ASWITA SUSANTI
            'unit' => []
        ],
        1460 => [
            'id' => 1460, //SUSANTI
            'unit' => []
        ],
        1094 => [
            'id' => 1094, //FITRIYA
            'unit' => []
        ],
        994 => [
            'id' => 994, //DESWITA
            'unit' => []
        ],
        1352 => [
            'id' => 1352, //RATNA HASTUTI
            'unit' => []
        ],
        1429 => [
            'id' => 1429, //SEPTI ANGGI
            'unit' => []
        ],
        1321 => [
            'id' => 1321, //NURMIDA
            'unit' => []
        ],
        1424 => [
            'id' => 1424, //SAWALINA
            'unit' => []
        ],
        3343 => [
            'id' => 3343, //ZIZIA
            'unit' => []
        ],

        1456 => [
            'id' => 1456, //ZIZIA
            'unit' => []
        ],

        1180 => [
            'id' => 1180, //KHESI
            'unit' => []
        ],
        1277 => [
            'id' => 1277, //MUSTIKASARI
            'unit' => []
        ],

        3468 => [
            'id' => 3468, //AGUSDINA
            'unit' => []
        ],
        3346 => [
            'id' => 3346, //WAN ROSLIANA
            'unit' => []
        ],
        1430 => [
            'id' => 1430, //SEPTIYANA KOMALA SARI
            'unit' => []
        ],
        958 => [
            'id' => 958, //ASTER NOFA RITA
            'unit' => []
        ],
        1517 => [
            'id' => 1517, //YULIATI BAHRI
            'unit' => []
        ],
    ],


];
