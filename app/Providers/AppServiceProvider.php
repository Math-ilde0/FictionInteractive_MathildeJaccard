<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

/**
 * AppServiceProvider
 *
 * Ce fournisseur de services est chargé d'enregistrer et de configurer
 * des services au démarrage de l'application.
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Enregistrement des services de l'application.
     * C'est ici que vous pouvez binder des services ou des classes dans le conteneur.
     *
     * @return void
     */
    public function register(): void
    {
        // Aucun service personnalisé à enregistrer pour l'instant
    }

    /**
     * Démarrage des services de l'application.
     * Idéal pour les initialisations globales comme les macros ou les configurations externes.
     *
     * @return void
     */
    public function boot(): void
    {
        // Précharger les assets Vite en limitant la concurrence à 3 fichiers
        Vite::prefetch(concurrency: 3);
    }
}
