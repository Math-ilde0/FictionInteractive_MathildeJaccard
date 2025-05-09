# Fiction Interactive - Batterie Mentale

Une application web de fiction interactive développée avec Laravel et Vue.js qui simule les défis de santé mentale d'un étudiant universitaire.

## Présentation du projet

"Batterie Mentale" est un serious game de fiction interactive conçu pour sensibiliser aux problèmes de santé mentale universitaire. Les joueurs suivent le parcours d'un étudiant en ingénierie des médias à la HEIG-VD, prenant des décisions qui affectent son bien-être mental, son sommeil et ses performances académiques.

## Prérequis

- PHP 8.1+
- Composer
- Node.js et npm
- MySQL ou SQLite
- Git

## Installation

```bash
# 1. Cloner le dépôt
git clone <https://github.com/votre-nom/batterie-mentale.git>
cd batterie-mentale

# 2. Installer les dépendances PHP et JavaScript
composer install
npm install

# 3. Configurer l'environnement
cp .env.example .env
php artisan key:generate
# Configurer la base de données dans .env

# 4. Créer la base de données et charger les données d'exemple
php artisan migrate --seed

# 5. Compiler les assets et lancer le serveur
npm run dev
php artisan serve

```

Le seeder crée automatiquement l'histoire interactive avec tous ses chapitres et choix.

## Mécaniques du jeu

### Métriques principales

Le jeu suit trois métriques clés qui déterminent la progression et les fins possibles :

- **🧠 Charge Mentale** (0-10) : Représente le niveau de stress. À 10, déclenche un burn-out.
- **😴 Sommeil** (0-10) : Représente la qualité du repos. À 0, provoque un effondrement physique.
- **🎓 Notes** (0-10) : Représente les performances académiques. À 0, mène à l'échec scolaire.

### Déroulement du jeu

1. Choisissez l'histoire "Batterie Mentale" sur la page d'accueil
2. Lisez chaque chapitre et faites des choix
3. Chaque décision influence les métriques (indiquées visuellement)
4. Des conseils thématiques s'affichent pour chaque situation (icônes survolables)
5. Votre progression est automatiquement sauvegardée

### Fins possibles

- **Succès** : Équilibre atteint entre bien-être et performance
- **Burn-out** : Charge mentale trop élevée
- **Épuisement** : Niveau de sommeil à zéro
- **Échec académique** : Notes insuffisantes

## Fonctionnalités principales

- **Narration interactive** avec des conséquences significatives
- **Visualisation des métriques** en temps réel
- **Sauvegarde automatique** de la progression
- **Plateforme de témoignages** pour partager des expériences réelles
- **Système d'authentification** pour la gestion des témoignages
- **Interface réactive** adaptée aux mobiles et tablettes

## Architecture technique

### Frontend (Vue.js 3)

- **Components/** : Composants Vue réutilisables (Chapter.vue, MetricsDisplay.vue, etc.)
- **Auth/** : Composants d'authentification (Login.vue, Register.vue)
- **Utils/** : Utilitaires JavaScript (metrics.js pour la gestion locale des métriques)
- **Router/** : Configuration du routage Vue

### Backend (Laravel 10)

- **Controllers/** : Logique métier (ChapterController, MetricsController, etc.)
- **Models/** : Modèles Eloquent (Story, Chapter, Choice, Testimony)
- **Migrations/** : Structure de la base de données
- **Seeders/** : Données de test et contenu narratif

### Base de données

- **Stories** : Récits disponibles
- **Chapters** : Segments narratifs avec impacts sur les métriques
- **Choices** : Options de décision avec liens vers les chapitres suivants
- **Testimonies** : Expériences partagées par les utilisateurs



Développé dans le cadre d'un projet éducatif pour sensibiliser à la gestion du stress et à la prévention du burn-out chez les étudiants.
