<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    | Nom de l'application utilisé dans les notifications, vues, etc.
    */
    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    | Définit l'environnement actuel : local, production, etc.
    */
    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Debug Mode
    |--------------------------------------------------------------------------
    | Affiche les erreurs complètes (avec trace) si activé.
    */
    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    | URL utilisée pour générer les liens depuis Artisan.
    */
    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Timezone
    |--------------------------------------------------------------------------
    | Fuseau horaire par défaut utilisé par PHP dans l’application.
    */
    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Langues
    |--------------------------------------------------------------------------
    | Langue par défaut, de secours, et pour les données Faker.
    */
    'locale' => env('APP_LOCALE', 'en'),
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Clé de chiffrement
    |--------------------------------------------------------------------------
    | Clé utilisée pour sécuriser les données via AES-256-CBC.
    */
    'cipher' => 'AES-256-CBC',
    'key' => env('APP_KEY'),

    // Clés précédentes autorisées pour déchiffrer les anciens tokens
    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode
    |--------------------------------------------------------------------------
    | Détermine le système utilisé pour activer le mode maintenance (fichier ou cache partagé).
    */
    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],
];
