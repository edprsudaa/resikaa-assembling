<?php

use app\modules\rbac\components\Helper;
use yii\helpers\Url;
use app\components\HelperSpesialClass;
?>

<aside class="<?= Yii::$app->params['setting']['adminlte']['aside_sidebar_class_dark'] ?>">
    <a href="<?= yii\helpers\Url::home() ?>" class="brand-link">
        <img src="<?= yii\helpers\Url::base() . "/images/logo.png" ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SIM<b>RS</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <?php
            $menuItems = [];

            if (HelperSpesialClass::isAnalisaDokumen()) {
                $menuItems = [
                    [
                        'label' => 'Master Analisa Dok',
                        'icon' => 'flask',
                        'items' => [
                            ['label' => 'Jenis Analisa', 'url' => ['/master-jenis-analisa/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                            ['label' => 'Item Analisa', 'url' => ['/master-item-analisa/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                            ['label' => 'Mapping Item Jenis Analisa', 'url' => ['/master-jenis-analisa-detail/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                        ]
                    ],

                    [
                        'label' => 'ANALISA DATA EMR',
                        'icon' => 'lock',
                        'itemsOptions' => [
                            'style' => 'background-color:#6c757d'
                        ],
                        'items' => [
                            ['label' => 'Daftar Analisa', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif/list-checkout'], 'items' => [
                                // ['label' => 'Rawat Jalan', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif/list-rawat-jalan']],
                                // ['label' => 'Rawat Inap', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif/list-rawat-inap']],
                                ['label' => 'Rawat Jalan', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif-rj/list']],
                                ['label' => 'Rawat Inap', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif-ri/list']],
                            ]],



                        ]
                    ],
                    [
                        'label' => 'Laporan Rekam Medis',
                        'icon' => 'flask',
                        'url' => ['/laporan/laporan']
                    ],

                ];
            }
            if (HelperSpesialClass::isAnalisaCoder()) {
                $menuItems = [
                    [
                        'label' => 'Master Analisa Dok',
                        'icon' => 'flask',
                        'items' => [
                            ['label' => 'Jenis Analisa', 'url' => ['/master-jenis-analisa/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                            ['label' => 'Item Analisa', 'url' => ['/master-item-analisa/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                            ['label' => 'Mapping Item Jenis Analisa', 'url' => ['/master-jenis-analisa-detail/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                        ]
                    ],

                    [
                        'label' => 'ANALISA DATA EMR',
                        'icon' => 'lock',
                        'itemsOptions' => [
                            'style' => 'background-color:#6c757d'
                        ],
                        'items' => [
                            ['label' => 'Daftar Analisa', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif/list-checkout'], 'items' => [
                                // ['label' => 'Rawat Jalan', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif/list-rawat-jalan']],
                                // ['label' => 'Rawat Inap', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif/list-rawat-inap']],
                                ['label' => 'Rawat Jalan', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif-rj/list']],
                                ['label' => 'Rawat Inap', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif-ri/list']],
                            ]],



                        ]
                    ],
                    [
                        'label' => 'Coder',
                        'icon' => 'lock',
                        'itemsOptions' => [
                            'style' => 'background-color:#6c757d'
                        ],
                        'items' => [
                            ['label' => 'IGD', 'icon' => 'tag', 'url' => ['/coder-igd/list']],
                            ['label' => 'Rawat Jalan', 'icon' => 'tag', 'url' => ['/coder-rj/list']],
                            ['label' => 'Rawat Inap', 'icon' => 'tag', 'url' => ['/coder-ri/list']],
                        ]
                    ],
                    [
                        'label' => 'Rekapitulasi Coding',
                        'icon' => 'lock',
                        'itemsOptions' => [
                            'style' => 'background-color:#6c757d'
                        ],
                        'items' => [
                            ['label' => 'IGD', 'icon' => 'tag', 'url' => ['/laporan/laporan-coder-igd']],
                            ['label' => 'RJ', 'icon' => 'tag', 'url' => ['/laporan/laporan-coder-rj']],
                            ['label' => 'RI', 'icon' => 'tag', 'url' => ['/laporan/laporan-coder-ri']],
                        ]
                    ],
                    [
                        'label' => 'Laporan Rekam Medis',
                        'icon' => 'flask',
                        'url' => ['/laporan/laporan']
                    ],

                ];
            }
            if (HelperSpesialClass::isDokterVerifikator()) {
                $menuItems = [
                    [
                        'label' => 'Dokter Verifikator',
                        'icon' => 'lock',
                        'itemsOptions' => [
                            'style' => 'background-color:#6c757d'
                        ],
                        'items' => [
                            ['label' => 'Rawat Jalan', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif/list-rawat-jalan-verifikator']],
                            ['label' => 'Rawat Inap', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif/list-rawat-inap-verifikator']],

                        ]
                    ],
                ];
            }
            if (HelperSpesialClass::isPengolahanData()) {
                $menuItems = [
                    [
                        'label' => 'Daftar Pasien',
                        'icon' => 'flask',
                        'url' => ['/history-pasien/list-pasien']
                    ],
                    [
                        'label' => 'Kelola Akses RME',
                        'icon' => 'flask',
                        'items' => [
                            ['label' => 'Pembuatan Peminjaman', 'icon' => 'tag', 'url' => ['/peminjaman-rekam-medis/list']],


                        ]
                    ],
                ];
            }
            if (HelperSpesialClass::isCasemixRj()) {
                $menuItems = [
                    [
                        'label' => 'Casemix',
                        'icon' => 'lock',
                        'itemsOptions' => [
                            'style' => 'background-color:#6c757d'
                        ],
                        'items' => [

                            ['label' => 'Rawat Jalan', 'icon' => 'tag', 'url' => ['/casemix/list-rawat-jalan']],

                        ]
                    ],
                ];
            }
            if (HelperSpesialClass::isCasemix()) {
                $menuItems = [
                    [
                        'label' => 'Casemix',
                        'icon' => 'lock',
                        'itemsOptions' => [
                            'style' => 'background-color:#6c757d'
                        ],
                        'items' => [

                            ['label' => 'IGD', 'icon' => 'tag', 'url' => ['/casemix/list-igd']],
                            ['label' => 'Rawat Inap', 'icon' => 'tag', 'url' => ['/casemix/list-rawat-inap']],
                            ['label' => 'Rawat Jalan', 'icon' => 'tag', 'url' => ['/casemix/list-rawat-jalan']],


                        ]
                    ],
                ];
            }
            if (HelperSpesialClass::isProgrammer()) {
                $menuItems = [
                    [
                        'label' => 'Master Analisa Dok',
                        'icon' => 'flask',
                        'items' => [
                            ['label' => 'Jenis Analisa', 'url' => ['/master-jenis-analisa/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                            ['label' => 'Item Analisa', 'url' => ['/master-item-analisa/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                            ['label' => 'Mapping Item Jenis Analisa', 'url' => ['/master-jenis-analisa-detail/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                        ]
                    ],
                    [
                        'label' => 'Master User Ip Peminjaman',
                        'icon' => 'flask',
                        'items' => [
                            ['label' => 'List Ip', 'url' => ['/master-ip-peminjaman/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                            ['label' => 'List User & IP', 'url' => ['/master-user-access-peminjaman/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                        ]
                    ],
                    [
                        'label' => 'Daftar Pasien',
                        'icon' => 'flask',
                        'url' => ['/history-pasien/list-pasien']
                    ],
                    [
                        'label' => 'ANALISA DATA EMR',
                        'icon' => 'lock',
                        'itemsOptions' => [
                            'style' => 'background-color:#6c757d'
                        ],
                        'items' => [
                            ['label' => 'Rawat Jalan', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif-rj/list']],
                            ['label' => 'Rawat Inap', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif-ri/list']],


                        ]
                    ],
                    [
                        'label' => 'Dokter Verifikator',
                        'icon' => 'lock',
                        'itemsOptions' => [
                            'style' => 'background-color:#6c757d'
                        ],
                        'items' => [
                            ['label' => 'Rawat Jalan', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif/list-rawat-jalan-verifikator']],
                            ['label' => 'Rawat Inap', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif/list-rawat-inap-verifikator']],

                        ]
                    ],
                    [
                        'label' => 'Coder',
                        'icon' => 'lock',
                        'itemsOptions' => [
                            'style' => 'background-color:#6c757d'
                        ],
                        'items' => [
                            ['label' => 'IGD', 'icon' => 'tag', 'url' => ['/coder-igd/list']],
                            ['label' => 'Rawat Jalan', 'icon' => 'tag', 'url' => ['/coder-rj/list']],
                            ['label' => 'Rawat Inap', 'icon' => 'tag', 'url' => ['/coder-ri/list']],
                        ]
                    ],
                    [
                        'label' => 'Rekapitulasi Coding',
                        'icon' => 'lock',
                        'itemsOptions' => [
                            'style' => 'background-color:#6c757d'
                        ],
                        'items' => [
                            ['label' => 'IGD', 'icon' => 'tag', 'url' => ['/laporan/laporan-coder-igd']],
                            ['label' => 'RJ', 'icon' => 'tag', 'url' => ['/laporan/laporan-coder-rj']],
                            ['label' => 'RI', 'icon' => 'tag', 'url' => ['/laporan/laporan-coder-ri']],
                        ]
                    ],
                    [
                        'label' => 'Casemix',
                        'icon' => 'lock',
                        'itemsOptions' => [
                            'style' => 'background-color:#6c757d'
                        ],
                        'items' => [

                            ['label' => 'IGD', 'icon' => 'tag', 'url' => ['/casemix/list-igd']],
                            ['label' => 'Rawat Jalan', 'icon' => 'tag', 'url' => ['/casemix/list-rawat-jalan']],
                            ['label' => 'Rawat Inap', 'icon' => 'tag', 'url' => ['/casemix/list-rawat-inap']],

                        ]
                    ],
                    [
                        'label' => 'Laporan Rekam Medis',
                        'icon' => 'flask',
                        'url' => ['/laporan/laporan']
                    ],
                    [
                        'label' => 'Kelola Akses RME',
                        'icon' => 'flask',
                        'items' => [
                            ['label' => 'Pembuatan Peminjaman', 'icon' => 'tag', 'url' => ['/peminjaman-rekam-medis/list']],


                        ]
                    ],
                    [
                        'label' => 'Panduan Praktik Klinis',
                        'icon' => 'lock',
                        'itemsOptions' => [
                            'style' => 'background-color:#6c757d'
                        ],
                        'items' => [
                            ['label' => 'List', 'icon' => 'tag', 'url' => ['/panduan-praktik-klinis/list']],
                            ['label' => 'Panduan', 'icon' => 'tag', 'url' => ['/panduan-praktik-klinis/panduan']],


                        ]
                    ],
                    [
                        'label' => 'RBAC',
                        'icon' => 'user-cog',
                        'items' => [
                            ['label' => 'Route', 'url' => ['/rbac/route/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                            ['label' => 'Permission', 'url' => ['/rbac/permission/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                            ['label' => 'Role', 'url' => ['/rbac/role/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                            ['label' => 'Assignment', 'url' => ['/rbac/assignment/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                        ]
                    ],

                ];
            }
            if (HelperSpesialClass::isCoder()) {
                $menuItems = [
                    [
                        'label' => 'ANALISA DATA EMR',
                        'icon' => 'lock',
                        'itemsOptions' => [
                            'style' => 'background-color:#6c757d'
                        ],
                        'items' => [
                            ['label' => 'Daftar Analisa', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif/list-checkout'], 'items' => [
                                // ['label' => 'Rawat Jalan', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif/list-rawat-jalan']],
                                // ['label' => 'Rawat Inap', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif/list-rawat-inap']],
                                ['label' => 'Rawat Jalan', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif-rj/list']],
                                ['label' => 'Rawat Inap', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif-ri/list']],
                            ]],



                        ]
                    ],
                    [
                        'label' => 'Coder',
                        'icon' => 'lock',
                        'itemsOptions' => [
                            'style' => 'background-color:#6c757d'
                        ],
                        'items' => [
                            // ['label' => 'Rawat Jalan', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif/list-rawat-jalan-coder-new']],
                            // ['label' => 'Rawat Inap', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif/list-rawat-inap-coder']],
                            ['label' => 'IGD', 'icon' => 'tag', 'url' => ['/coder-igd/list']],
                            ['label' => 'Rawat Jalan', 'icon' => 'tag', 'url' => ['/coder-rj/list']],
                            ['label' => 'Rawat Inap', 'icon' => 'tag', 'url' => ['/coder-ri/list']],
                            ['label' => 'RJ', 'icon' => 'tag', 'url' => ['/laporan/laporan-coder-rj']],
                            ['label' => 'RI', 'icon' => 'tag', 'url' => ['/laporan/laporan-coder-ri']],
                        ]
                    ],
                    [
                        'label' => 'Laporan Rekam Medis',
                        'icon' => 'flask',
                        'url' => ['/laporan/laporan']
                    ],
                ];
            }
            if (HelperSpesialClass::isMpp()) {
                $menuItems = [

                    [
                        'label' => 'MPP Rawat Inap',
                        'icon' => 'flask',
                        'url' => ['/mpp/index-mpp-new']
                    ],

                ];
                if (Yii::$app->request->get('id')) {
                    $menuItems = [

                        [
                            'label' => 'MPP Rawat Inap',
                            'icon' => 'flask',
                            'url' => ['/mpp/index-mpp-new']
                        ],
                        [
                            'label' => 'Catatan DPJP',
                            'icon' => 'edit',
                            'url' => ['/mpp/catatan', 'id' => Yii::$app->request->get('id'), 'layanan_id' => Yii::$app->request->get('layanan_id'), 'layanan_nama' => Yii::$app->request->get('layanan_nama')]
                        ],

                        [
                            'label' => 'Catatan Implementasi MPP',
                            'icon' => 'paper-plane',
                            'url' => ['/mpp/catatan-implementasi-mpp', 'id' => Yii::$app->request->get('id'), 'layanan_id' => Yii::$app->request->get('layanan_id'), 'layanan_nama' => Yii::$app->request->get('layanan_nama')]
                        ],
                        [
                            'label' => 'Update Resume Medis',
                            'icon' => 'flask',
                            'url' => ['/mpp/detail-mpp-resume-medis', 'id' => Yii::$app->request->get('id'), 'layanan_id' => Yii::$app->request->get('layanan_id'), 'layanan_nama' => Yii::$app->request->get('layanan_nama')]
                        ],
                        [
                            'label' => 'Skrining Pasien Mpp',
                            'icon' => 'pen',
                            'url' => ['/mpp/skrining-pasien-mpp', 'id' => Yii::$app->request->get('id'), 'layanan_id' => Yii::$app->request->get('layanan_id'), 'layanan_nama' => Yii::$app->request->get('layanan_nama')]
                        ],
                        [
                            'label' => 'Skrining Pemulangan Pasien Mpp',
                            'icon' => 'book',
                            'url' => ['/mpp/skrining-pemulangan-pasien-mpp', 'id' => Yii::$app->request->get('id'), 'layanan_id' => Yii::$app->request->get('layanan_id'), 'layanan_nama' => Yii::$app->request->get('layanan_nama')]
                        ],
                        [
                            'label' => 'Evaluasi Awal Pasien Mpp',
                            'icon' => 'folder-open',
                            'url' => ['/mpp/evaluasi-awal-mpp', 'id' => Yii::$app->request->get('id'), 'layanan_id' => Yii::$app->request->get('layanan_id'), 'layanan_nama' => Yii::$app->request->get('layanan_nama')]
                        ],
                        [
                            'label' => 'Claim ICD',
                            'icon' => 'edit',
                            'url' => ['/mpp/claim', 'id' => Yii::$app->request->get('id'), 'layanan_id' => Yii::$app->request->get('layanan_id'), 'registrasi_kode' => Yii::$app->request->get('registrasi_kode')]
                        ],
                    ];
                }
            }

            if (HelperSpesialClass::isAksesDaftarPasien()) {
                $menuItems = array_merge($menuItems, [
                    [
                        'label' => 'Daftar Pasien',
                        'icon' => 'flask',
                        'url' => ['/history-pasien/list-pasien']
                    ],

                ]);
            }
            if (HelperSpesialClass::isDokterVerifikator()) {
                $menuItems = array_merge($menuItems, [
                    [
                        'label' => 'Casemix',
                        'icon' => 'lock',
                        'itemsOptions' => [
                            'style' => 'background-color:#6c757d'
                        ],
                        'items' => [

                            ['label' => 'IGD', 'icon' => 'tag', 'url' => ['/casemix/list-igd']],
                            ['label' => 'Rawat Jalan', 'icon' => 'tag', 'url' => ['/casemix/list-rawat-jalan']],
                            ['label' => 'Rawat Inap', 'icon' => 'tag', 'url' => ['/casemix/list-rawat-inap']],

                        ]
                    ],
                ]);
            }
            $menuItems = array_merge($menuItems, [
                [
                    'label' => 'Akses RME',
                    'icon' => 'lock',
                    'itemsOptions' => [
                        'style' => 'background-color:#6c757d'
                    ],
                    'items' => [
                        // ['label' => 'Rawat Jalan', 'icon' => 'tag', 'url' => ['/analisa-kuantitatif/list-rawat-jalan-coder-new']],
                        [
                            'label' => 'Peminjaman Saya',
                            'icon' => 'flask',
                            'url' => ['/peminjaman-rekam-medis/list-peminjaman']
                        ],

                    ]
                ],


            ]);
            // $menuItems = Helper::filter($menuItems);
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => $menuItems,
                'class' => 'nav nav-pills nav-sidebar flex-column nav-flat nav-compact nav-child-indent text-sm'
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>