<?php

/**
 * Configuration CORS (Cross-Origin Resource Sharing)
 *
 * Ce fichier permet de définir les règles d'accès entre domaines (frontend ↔ backend).
 * Il est essentiel pour que les navigateurs acceptent les requêtes venant d'une origine différente.
 * 
 * Note : dans un environnement de production, **il est fortement recommandé** de restreindre les origines.
 */
return [
    'paths' => [
        'api/*', 
        'login', 
        'logout', 
        'register',
        'sanctum/csrf-cookie'
    ],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        env('FRONTEND_URL', 'http://localhost:3000'),
        'http://localhost:8080',
        'http://localhost:5173'
    ],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // CRUCIAL
];