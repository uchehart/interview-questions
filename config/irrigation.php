<?php
// config/irrigation.php

return [
    /*
    |--------------------------------------------------------------------------
    | Admin Email
    |--------------------------------------------------------------------------
    |
    | This value is the email address of the administrator who will receive
    | notifications about irrigation schedule changes.
    |
    */
    'admin_email' => env('IRRIGATION_ADMIN_EMAIL', 'admin@cashcardng.com'),

    /*
    |--------------------------------------------------------------------------
    | Queue Settings
    |--------------------------------------------------------------------------
    |
    | Configure the queue settings for irrigation jobs.
    |
    */
    'queue' => [
        'connection' => env('IRRIGATION_QUEUE_CONNECTION', env('QUEUE_CONNECTION', 'database')),
        'queue' => env('IRRIGATION_QUEUE', 'irrigation'),
    ],
];
