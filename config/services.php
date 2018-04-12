<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'facebook' => [
    'client_id' => '207941333273644',
    'client_secret' => '3e4bc56803720df35570c2e2236db2c9',
    'redirect' => 'http://fabricadesoftwareperu.com/auth/facebook/callback'
    ],
    'google' => [
       //Id suministrado por google        
       'client_id'     => '542583451189-ma4rh77tb2su5tr3et01qkp7sp3fk8l5.apps.googleusercontent.com', 
       //Secret suministrado por google 
       'client_secret' => 'WCfzrbF1fdC-EL0-lLNynvZC',
       //Página a la que sera redireccionado el navegador cuando el login se exitoso 
       //Ejemplo: http://midominio.com/social/handle/google
       'redirect'      =>  'http://fabricadesoftwareperu.com/auth/google/callback'
    ],
];
