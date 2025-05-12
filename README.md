# Fiction Interactive - Batterie Mentale

Une application web de fiction interactive développée avec Laravel et Vue.js qui simule les défis de santé mentale d'un étudiant en bachelor.

## 📖 Description du Projet

"Batterie Mentale" est un serious game de fiction interactive conçu pour sensibiliser aux problèmes de santé mentale universitaire. Les joueurs suivent le parcours d'un étudiant en ingénierie des médias à la HEIG-VD, prenant des décisions qui affectent son bien-être mental, son sommeil et ses performances académiques.

## 🎮 Mécaniques du Jeu

### Métriques Principales
Le jeu suit trois métriques clés qui déterminent la progression et les fins possibles :

- **🧠 Charge Mentale** (0-10) : Représente le niveau de stress. À 10, déclenche un burn-out.
- **😴 Sommeil** (0-10) : Représente la qualité du repos. À 0, provoque un effondrement physique.
- **🎓 Notes** (0-10) : Représente les performances académiques. À 0, mène à l'échec scolaire.

### Déroulement
1. Choisissez l'histoire "Batterie Mentale"
2. Lisez chaque chapitre et faites des choix
3. Chaque décision influence les métriques
4. Des conseils thématiques s'affichent pour chaque situation
5. Votre progression est automatiquement sauvegardée

### Fins Possibles
- **Succès** : Équilibre atteint entre bien-être et performance
- **Burn-out** : Charge mentale trop élevée
- **Épuisement** : Niveau de sommeil à zéro
- **Échec académique** : Notes insuffisantes

## 🛠 Technologies Utilisées

### Backend
- Laravel 10.x
- PHP 8.1+
- Base de données : SQLite/MySQL
- Authentification : Laravel Sanctum

### Frontend
- Vue.js 3.x
- Tailwind CSS
- Axios pour les requêtes API
- Vue Router pour la navigation

## 📦 Prérequis

- PHP 8.1+
- Composer
- Node.js et npm
- Git

## 🚀 Installation

### 1. Clonage du projet
```bash
git clone https://github.com/math-ilde0/story-game
cd story-game
```

### 2. Installation des dépendances
```bash
# Installer les dépendances PHP
composer install

# Installer les dépendances JavaScript
npm install
```

### 3. Configuration de l'environnement
```bash
# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate
```

### 4. Configuration de la base de données
Par défaut, l'application utilise SQLite. Vous pouvez modifier cette configuration dans le fichier `.env`.

```bash
# Créer la base de données et charger les migrations avec les données de test
php artisan migrate --seed
```

### 5. Lancement de l'application
```bash
# Compiler les assets et lancer le serveur de développement
npm run dev

# Dans un autre terminal, lancer le serveur PHP
php artisan serve
```
Ou utilisez cette commande pour lancer les deux en même temps :
```bash
composer run dev
```

## 🧪 Fonctionnalités

- **Fiction interactive** : Parcourez une histoire originale avec de multiples choix et conséquences
- **Système de métriques** : Suivez l'évolution de votre santé mentale, sommeil et performance académique
- **Sauvegarde automatique** : Reprenez votre partie là où vous l'avez laissée
- **Conseils de sensibilisation** : Découvrez des conseils pratiques pour gérer le stress

## 🔌 API REST

Le backend expose une API RESTful pour permettre au frontend de fonctionner en mode SPA (Single Page Application).

    Lorsque http://localhost est ouvert, l'application web interactive apparait.

   /stories, permet de recevoir une réponse JSON avec toutes les histoires.

    Les routes comme /story/1 ou /story/2 affichent l'interface web d'un scénario.

    Les chapitres, comme /story/1/chapter/1, renvoient également du JSON, utile pour naviguer dynamiquement.
## 

Ce projet est développé dans le cadre d'un projet éducatif pour sensibiliser à la gestion du stress et à la prévention du burn-out chez les étudiants.

## 👩‍💻 

Mathilde Jaccard  
HEIG-VD – Bachelor Media Engineering  
Mai 2025
