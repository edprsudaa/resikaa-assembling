<?php


namespace app\components;


class StatusAkun
{
    const TERDAFTAR = 0;
    const AKTIF = 1;
    const BLOKIR = 2;

    public $items = [
        [
            'id' => 0,
            'text' => 'Belum Aktif',
            'icon' => 'fa fa-circle text-warning',
            'keywords' => ['belum aktif', 'terdaftar'],
        ],
        [
            'id' => 1,
            'text' => 'Aktif',
            'icon' => 'fa fa-circle text-success',
            'keywords' => ['aktif'],
        ],
        [
            'id' => 2,
            'text' => 'Blokir',
            'icon' => 'fa fa-close text-danger',
            'keywords' => ['blokir', 'diblokir'],
        ],
    ];
}