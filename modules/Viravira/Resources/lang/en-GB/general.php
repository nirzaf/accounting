<?php

return [

    'title' => 'Viravira',

    'form' => [
        'token'                 => 'Token',
        'product_category'      => 'Products Category',
        'invoice_category'      => 'Invoices Category',
        'sync'                  => [
            'title'    => 'Get Current Data',
            'customer' => 'Sync Customers',
            'product'  => 'Sync Products',
            'order'    => 'Sync Orders',
            'all'      => 'Sync All',
        ]
    ],

    'types' => [
        'customers'  => 'Customer|Customers',
        'products'   => 'Product|Products',
        'orders'     => 'Order|Orders',
    ],

    'sync_text' => 'Sync this :type: :value',
    'finished'  => ':type sync finished',
    'total'     => 'Total :type: :count',
    'total_all' => 'Total Customers: :customers, Total Products: :products, Total Orders: :orders',

    'success' => [
        'settings_saved'        => 'Setting saved',
        'transactions_synced'   => 'Transactions synced'
    ],

    'error' => [
        'nothing_to_sync'       => 'Nothing to sync',
        'no_settings'           => 'Please, save the settings first.',
    ],
];
