<?php

return [

    'bill_number'           => 'Fakturanummer',
    'bill_date'             => 'Faktura dato',
    'total_price'           => 'Total pris',
    'due_date'              => 'Forfaldsdato',
    'order_number'          => 'Ordrenummer',
    'bill_from'             => 'Faktura fra',

    'quantity'              => 'Antal',
    'price'                 => 'Pris',
    'sub_total'             => 'Subtotal',
    'discount'              => 'Rabat',
    'tax_total'             => 'Moms i alt',
    'total'                 => 'I alt',

    'item_name'             => 'Varenavn|Varenavne',

    'show_discount'         => ':discount% Rabat',
    'add_discount'          => 'Tilføj rabat',
    'discount_desc'         => 'subtotal',

    'payment_due'           => 'Betalingsfrist',
    'amount_due'            => 'Forfaldent beløb',
    'paid'                  => 'Betalt',
    'histories'             => 'Historik',
    'payments'              => 'Betalinger',
    'add_payment'           => 'Tilføj betaling',
    'mark_received'         => 'Modtagelse godkendt',
    'download_pdf'          => 'Download PDF',
    'send_mail'             => 'Send E-mail',
    'create_bill'           => 'Opret regning',
    'receive_bill'          => 'Modtag regning',
    'make_payment'          => 'Opret betaling',

    'status' => [
        'draft'             => 'Kladde',
        'received'          => 'Modtaget',
        'partial'           => 'Delvis',
        'paid'              => 'Betalt',
    ],

    'messages' => [
        'received'          => 'Regning registreret som modtaget!',
        'draft'             => 'Dette er et <b>UDKAST</b> til faktura og vil blive afspejlet i diagrammer, når den bliver modtaget.',

        'status' => [
            'created'       => 'Oprettet den :date',
            'receive' => [
                'draft'     => 'Ikke sendt',
                'received'  => 'Modtaget den :date',
            ],
            'paid' => [
                'await'     => 'Afventer betaling',
            ],
        ],
    ],

];
