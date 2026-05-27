<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Hash Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default hash driver used by Laravel's Hash
    | facade and Eloquent's "hashed" cast.
    |
    | Supported: "bcrypt", "argon", "argon2id"
    |
    */

    'driver' => env('HASH_DRIVER', 'argon2id'),

    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 12),
        'verify' => env('HASH_VERIFY', false),
    ],

    'argon' => [
        'memory' => env('ARGON_MEMORY', 1024),
        'threads' => env('ARGON_THREADS', 2),
        'time' => env('ARGON_TIME', 2),
        'verify' => env('HASH_VERIFY', false),
    ],

];
