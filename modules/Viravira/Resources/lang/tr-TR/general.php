<?php

return [

    'title' => 'Viravira',

    'form' => [
        'token'                 => 'Jeton',
        'product_category'      => 'Ürünler Kategorisi',
        'invoice_category'      => 'Faturalar Kategorisi',
        'sync'                  => [
            'title'    => 'Mevcut Verileri Getir',
            'customer' => 'Müşterileri Getir',
            'product'  => 'Ürünleri Getir',
            'order'    => 'Siparişleri Getir',
            'all'      => 'Hepsini Getir',
        ]
    ],

    'types' => [
        'customers'  => 'Müşteri|Müşteriler',
        'products'   => 'Ürün|Ürünler',
        'orders'     => 'Sipariş|Siparişler',
    ],

    'sync_text' => 'Sync this :type: :value',
    'finished'  => ':type aktarıldı.',
    'total'     => 'Toplam :type: :count',
    'total_all' => 'Toplam Müşteriler: :customers, Toplam Ürünler: :products, Toplam Siparişler: :orders',

    'success' => [
        'settings_saved'        => 'Ayarlar kaydedildi',
        'transactions_synced'   => 'İşlemler Aktarıldı'
    ],

    'error' => [
        'nothing_to_sync'       => 'İşlem Yok',
        'no_settings'           => 'Lütfen, ilk önce ayarlarınızı kaydediniz.',
    ],
];
