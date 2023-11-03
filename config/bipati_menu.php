<?php

return [

    'menu' => [
        'mobil'     => biPatiSetMenu('Mobil Uygulama Ayarları', 'shop-4'),
        'veriler'   => biPatiSetMenu('Veriler', 'digital-drawing'),
        'cikis'     => biPatiSetMenu('Çıkış', 'three-arrow-fork', 'http://167.99.137.5/yonetim-paneli/cikis')
    ],
    'submenu' => [
        'veriler' => [
            biPatiSetSubMenu('Kullanıcılar', 'fal fa-users', 'user'),
            biPatiSetSubMenu('İhbarlar', 'far fa-exclamation-triangle', 'notice', ['index' => 'Listele']),
            biPatiSetSubMenu('Hayvanlar', 'far fa-paw-alt', 'animal', ['index' => 'Listele']),
            biPatiSetSubMenu('Bağışlar', 'far fa-paw-alt', 'donation')
        ],
        'mobil-uygulama-ayarlari' => [
            biPatiSetSubMenu('Kategoriler', 'fal fa-list', 'category'),
            biPatiSetSubMenu('Bilgi Bankası', 'fal fa-list', 'blog'),
            biPatiSetSubMenu('Etkinlikler', 'fas fa-tablets', 'event'),
            biPatiSetSubMenu('Ameliyatlar', 'fas fa-scalpel-path', 'operation'),
            biPatiSetSubMenu('İhbar Türü', 'fad fa-subscript', 'notice-type'),
            biPatiSetSubMenu('Hayvan Hastalıkları', 'fad fa-disease', 'disease'),
            biPatiSetSubMenu('İlaçlar', 'fas fa-tablets', 'medicine'),
        ]
    ]

];
