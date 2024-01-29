<?php

use Illuminate\Support\Str;

return [

  

    'driver' => env('SESSION_DRIVER', 'file'),

   

    'lifetime' => env('SESSION_LIFETIME', 120),

    'expire_on_close' => false,


    'encrypt' => false,

   

    'files' => storage_path('framework/sessions'),


    'connection' => env('SESSION_CONNECTION', null),

   

    'table' => 'sessions',

   

    'store' => env('SESSION_STORE', null),


    'lottery' => [2, 100],


    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
    ),


    'path' => '/',

   

    'domain' => env('SESSION_DOMAIN', null),

   

    'secure' => env('SESSION_SECURE_COOKIE'),

    

    'http_only' => true,

    /*
    |--------------------------------------------------------------------------
    | Same-Site Cookies
    |--------------------------------------------------------------------------
    |
    | This option determines how your cookies behave when cross-site requests
    | take place, and can be used to mitigate CSRF attacks. By default, we
    | will set this value to "lax" since this is a secure default value.
    |
    | Supported: "lax", "strict", "none", null
    |
    */

    'same_site' => 'lax',

];
