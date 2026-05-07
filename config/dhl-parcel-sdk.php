<?php

return [
    'api_key' => env('DHL_PARCEL_API_KEY'),
    'username' => env('DHL_PARCEL_USERNAME'),
    'password' => env('DHL_PARCEL_PASSWORD'),
    'client_secret' => env('DHL_PARCEL_CLIENT_SECRET'),
    'base_url' => env('DHL_PARCEL_BASE_URL', 'https://api-eu.dhl.com/parcel/de/shipping/v2'),
    'oauth_base_url' => env('DHL_PARCEL_OAUTH_BASE_URL'),
    'sandbox' => env('DHL_PARCEL_SANDBOX', false),
];
