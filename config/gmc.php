<?php

return [
    'merchant_id' => env('GMC_MERCHANT_ID'),
    'credentials' => storage_path('app/google-merchant-api/service-account-credentials.json'),
    'scopes' => [
        'https://www.googleapis.com/auth/content',
    ],
];
