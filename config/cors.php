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

    /*
    |--------------------------------------------------------------------------
    | Chemins concernés
    |--------------------------------------------------------------------------
    | Les routes concernées par la configuration CORS.
    | Ici '*' signifie que toutes les routes sont affectées.
    */
    'paths' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Méthodes HTTP autorisées
    |--------------------------------------------------------------------------
    | Méthodes que le client est autorisé à utiliser.
    | '*' autorise toutes les méthodes (GET, POST, PUT, DELETE, etc.)
    */
    'allowed_methods' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Origines autorisées
    |--------------------------------------------------------------------------
    | Détermine quelles URL frontend peuvent faire des requêtes.
    | En développement, '*' est acceptable. En production, spécifiez vos domaines (ex. : ['https://monapp.fr'])
    */
    'allowed_origins' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Patterns d'origine autorisés (regex)
    |--------------------------------------------------------------------------
    | Peut être utilisé pour autoriser dynamiquement certains domaines via expression régulière.
    */
    'allowed_origins_patterns' => [],

    /*
    |--------------------------------------------------------------------------
    | En-têtes autorisés
    |--------------------------------------------------------------------------
    | Détermine les headers que le client peut envoyer.
    */
    'allowed_headers' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | En-têtes exposés au client
    |--------------------------------------------------------------------------
    | Liste des headers que le client JS peut lire dans la réponse.
    */
    'exposed_headers' => [],

    /*
    |--------------------------------------------------------------------------
    | Durée de mise en cache (en secondes)
    |--------------------------------------------------------------------------
    | Durée durant laquelle le navigateur peut garder en cache la réponse de pré-vol (OPTIONS).
    */
    'max_age' => 0,

    /*
    |--------------------------------------------------------------------------
    | Support des cookies (Access-Control-Allow-Credentials)
    |--------------------------------------------------------------------------
    | Doit être activé si l'authentification repose sur les cookies.
    */
    'supports_credentials' => true,
];
