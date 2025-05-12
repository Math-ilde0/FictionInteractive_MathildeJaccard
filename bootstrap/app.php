<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

/**
 * Point d'entrée principal de l'application Laravel.
 * Ce fichier configure l'application, les routes, les middlewares et les gestionnaires d'exceptions.
 * Il retourne ensuite une instance de l'application prête à être lancée.
 */

return Application::configure(basePath: dirname(__DIR__))

    // Définition des routes principales de l'application
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',         // Routes web (sessions, vues, CSRF)
        commands: __DIR__ . '/../routes/console.php', // Commandes artisan personnalisées
        health: '/up',                                // Route de vérification de disponibilité
    )

    // Configuration des middlewares globaux ou par groupe
    ->withMiddleware(function (Middleware $middleware) {
        // Ajoute le middleware de préchargement des assets (HTTP/2 Server Push)
        $middleware->web(append: [
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);
    })

    // Configuration des gestionnaires d'exceptions (à définir selon les besoins)
    ->withExceptions(function (Exceptions $exceptions) {
        // Personnalisation possible via: $exceptions->render(...) ou $exceptions->report(...)
    })

    // Création finale de l'instance de l'application Laravel
    ->create();
