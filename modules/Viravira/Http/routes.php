<?php

Route::group([
    'middleware' => 'admin',
    'prefix'     => 'viravira',
    'namespace'  => 'Modules\Viravira\Http\Controllers'
], function () {
    Route::get('settings', 'Settings@edit');
    Route::post('settings', 'Settings@update');
    Route::get('sync', 'Sync@send');

    Route::get('sync/count', 'Sync@count');
    Route::get('sync/sync', 'Sync@sync');

    Route::get('customers/count', 'Customers@count');
    Route::get('customers/sync', 'Customers@sync');
    Route::post('customers/sync/{customer_id}', 'Customers@store');

    Route::get('products/count', 'Products@count');
    Route::get('products/sync', 'Products@sync');
    Route::post('products/sync/{product_id}', 'Products@store');

    Route::get('orders/count', 'Orders@count');
    Route::get('orders/sync', 'Orders@sync');
    Route::post('orders/sync/{order_id}', 'Orders@store');
});
