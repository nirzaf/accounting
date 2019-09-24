<?php

return [

    'bill_number'           => 'Número de Recibo',
    'bill_date'             => 'Fecha del Recibo',
    'total_price'           => 'Precio Total',
    'due_date'              => 'Fecha de Vencimiento',
    'order_number'          => 'Número de Orden',
    'bill_from'             => 'Recibo De',

    'quantity'              => 'Cantidad',
    'price'                 => 'Precio',
    'sub_total'             => 'Subtotal',
    'discount'              => 'Descuento',
    'tax_total'             => 'Total de Impuestos',
    'total'                 => 'Total ',

    'item_name'             => 'Nombre del producto/servicio | Nombres de los productos/servicos',

    'show_discount'         => ':discount% Descuento',
    'add_discount'          => 'Agregar Descuento',
    'discount_desc'         => 'de subtotal',

    'payment_due'           => 'Vencimiento del Pago',
    'amount_due'            => 'Importe Vencido',
    'paid'                  => 'Pagado',
    'histories'             => 'Historial',
    'payments'              => 'Pagos',
    'add_payment'           => 'Añadir pago',
    'mark_received'         => 'Marcar como Recibido',
    'download_pdf'          => 'Descargar archivo PDF',
    'send_mail'             => 'Enviar Correo Electrónico',
    'create_bill'           => 'Crear Recibo',
    'receive_bill'          => 'Recibir Recibo',
    'make_payment'          => 'Hacer Pago',

    'status' => [
        'draft'             => 'Borrador',
        'received'          => 'Recibido',
        'partial'           => 'Parcial',
        'paid'              => 'Pagado',
    ],

    'messages' => [
        'received'          => '¡Recibo marcado como recibido con exitosamente!',
        'draft'             => 'Este es un borrador del recibo y será reflejado en los gráficos después de ser recibido.',

        'status' => [
            'created'       => 'Creado el :date',
            'receive' => [
                'draft'     => 'No enviado',
                'received'  => 'Recibido el :date',
            ],
            'paid' => [
                'await'     => 'Pendiente de pago',
            ],
        ],
    ],

];
