<?php

return [
    'merchant_id' => env('VITE_MIDTRANS_MERCHANT_ID'),
    'client_key' => env('VITE_MIDTRANS_CLIENT_KEY'),
    'server_key' => env('VITE_MIDTRANS_SERVER_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_3ds' => env('MIDTRANS_IS_3DS', true),
];
