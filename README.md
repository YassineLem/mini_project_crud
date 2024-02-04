# Projet Symfony - Gestion des Écoles et Formations

Ce mini_projet Symfony vise à créer une plateforme de gestion des écoles et des formations associées.

## Prérequis

- PHP 7.4 ou supérieur
- Composer (pour gérer les dépendances)
- Symfony CLI (pour exécuter des commandes Symfony)
- MySQL 

## Installation

Clonez le projet depuis le référentiel GitHub.

```bash
git clone https://github.com/votre-utilisateur/votre-projet.git
Installez les dépendances avec Composer.
composer install
Configurez votre base de données dans le fichier .env et exécutez les migrations.

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
Utilisation
#Démarrez le serveur Symfony.
symfony server:start
Accédez à l'application dans votre navigateur à l'adresse http://localhost:8000.
