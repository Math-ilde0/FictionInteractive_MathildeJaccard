{{-- 
/**
 * @fichier app.blade.php
 * @description
 * Template HTML principal de l'application Vue.js embarquée via Laravel.
 * Ce fichier sert de point d’entrée à l’application interactive "Batterie Mentale".
 * Il inclut :
 * - les métadonnées HTML standards ;
 * - le token CSRF pour sécuriser les requêtes ;
 * - l’initialisation du build Vite (CSS + JS) ;
 * - la police personnalisée utilisée pour la typographie ;
 * - le point de montage Vue <div id="app"></div> où toute l’application sera rendue.
 *
 * @framework Laravel + Vite + Vue.js
 * @auteur Mathilde Jaccard – HEIG-VD, Bachelor Media Engineering
 * @date Mai 2025
 */
--}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fiction Interactive</title>
    
    <!-- Style pour ajouter une transition de couleur entre les thèmes -->
    <style>
        html {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        html.dark {
            color-scheme: dark;
        }
    </style>
    
    <!-- Police Figtree importée via Bunny Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Lien vers le CSS et le JavaScript générés par Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <!-- Point de montage de l'application Vue -->
    <div id="app"></div>
</body>
</html>
<!-- Style pour ajouter une transition de couleur entre les thèmes -->
<style>
    html {
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    
    html.dark {
        color-scheme: dark;
    }
</style>
