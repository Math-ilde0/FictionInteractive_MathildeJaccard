<?php
return [
    'paths' => ['*'], // Toutes les routes sont concernées
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'], // En production, limitez aux domaines autorisés
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // Important pour les cookies
];