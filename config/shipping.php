<?php

return [
    'default_partner' => env('DEFAULT_SHIPPING_PARTNER', 'Shiprocket'),
    'default_product_weight_grams' => (int) env('SHIPPING_DEFAULT_PRODUCT_WEIGHT_GRAMS', 250),
    'weight_threshold_grams' => (int) env('SHIPPING_FREE_WEIGHT_THRESHOLD', 100),
    'cost_per_extra_gram' => (int) env('SHIPPING_COST_PER_EXTRA_GRAM', 20),

    'shiprocket' => [
        'mode' => env('SHIPROCKET_MODE', 'mock'),
        'base_url' => env('SHIPROCKET_BASE_URL', 'https://apiv2.shiprocket.in/v1/external'),
        'email' => env('SHIPROCKET_EMAIL'),
        'password' => env('SHIPROCKET_PASSWORD'),
        'token' => env('SHIPROCKET_TOKEN'),
        'channel_id' => env('SHIPROCKET_CHANNEL_ID'),
        'pickup_location' => env('SHIPROCKET_PICKUP_LOCATION', 'Binayak Enclave'),
        'default_shipping_method' => env('SHIPROCKET_DEFAULT_METHOD', 'Shiprocket Standard'),
        'tracking_prefix' => env('SHIPROCKET_TRACKING_PREFIX', 'SR-MOCK'),
    ],

    'partners' => [
        'Shiprocket',
    ],
];