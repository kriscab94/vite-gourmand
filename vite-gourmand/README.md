🍽️ Vite & Gourmand — Application Web de Commande de Menus
📌 Présentation

Vite & Gourmand est une application web développée dans le cadre du titre professionnel Développeur Web et Web Mobile.

L’application permet aux utilisateurs de consulter des menus gastronomiques, passer des commandes, suivre leur statut et laisser des avis.
Elle propose également des espaces dédiés aux employés et aux administrateurs pour la gestion complète de la plateforme.

🚀 Fonctionnalités principales
👤 Utilisateur

Création de compte sécurisé

Connexion / déconnexion

Consultation des menus

Filtres dynamiques (prix, thème, régime, personnes)

Consultation du détail d’un menu

Passage de commande

Suivi des commandes

Annulation d’une commande (si non traitée)

Ajout d’un avis après prestation

Modification du mot de passe

👨‍🍳 Employé

Gestion des commandes

Modification du statut des commandes

Validation ou refus des avis clients

Gestion des menus

👑 Administrateur

Création de comptes employés

Activation / désactivation des employés

Accès complet aux fonctionnalités employé

Visualisation des statistiques via graphique (MongoDB)

🧱 Technologies utilisées
Front-end

HTML5

CSS3

Bootstrap 5

JavaScript (Fetch API / AJAX)

Chart.js (graphiques)

Back-end

PHP 8 (PDO)

Architecture MVC simplifiée

Bases de données

MySQL / MariaDB : données principales

MongoDB : statistiques des commandes

Environnement

XAMPP (Apache + MySQL + PHP)

MongoDB Compass

Git / GitHub

⚙️ Installation du projet (Local)
1️⃣ Cloner le projet
git clone https://github.com/VOTRE-USERNAME/vite-gourmand.git


Placer le dossier dans :

C:\xampp\htdocs\

2️⃣ Démarrer les services

Lancer depuis XAMPP :

✅ Apache

✅ MySQL

Démarrer MongoDB.

3️⃣ Importer la base SQL

Ouvrir MySQL Workbench ou phpMyAdmin :

Créer la base :

CREATE DATABASE vite_gourmand;


Importer le fichier SQL fourni (database.sql).

4️⃣ Configuration base de données

Modifier :

config/database.php


Exemple :

$pdo = new PDO(
    "mysql:host=localhost;dbname=vite_gourmand;charset=utf8",
    "root",
    ""
);

5️⃣ Accéder au site

Dans le navigateur :

http://localhost/vite-gourmand/public/

👥 Comptes de test
Admin
Email : admin@vitegourmand.fr
Mot de passe : Admin123456

Employé
Email : employe@vitegourmand.fr
Mot de passe : (défini en base)

Utilisateur

Créer un compte via l’inscription.

📊 Statistiques (MongoDB)

MongoDB est utilisé pour stocker :

le nombre de commandes par menu

les données statistiques affichées dans l’espace admin

Collection :

vite_gourmand_stats.commandes_stats


Accessible via :

/public/admin/stats.php

🔐 Sécurité

L’application implémente plusieurs mesures de sécurité :

Hashage des mots de passe avec password_hash()

Vérification avec password_verify()

Requêtes préparées PDO (protection SQL Injection)

Protection XSS via htmlspecialchars()

Sessions sécurisées

Vérification des rôles utilisateur

Protection CSRF sur formulaires sensibles

📁 Structure du projet
vite-gourmand/
│
├── config/
├── public/
│   ├── admin/
│   ├── auth/
│   ├── api/
│   └── index.php
│
├── views/
├── docs/
└── README.md

📚 Documentation

Le dossier /docs contient :

Manuel utilisateur

Documentation technique

Diagrammes UML

Charte graphique

👨‍💻 Auteur

Projet réalisé dans le cadre du titre professionnel :

Développeur Web et Web Mobile

✅ Statut du projet

✔ Application fonctionnelle
✔ Gestion multi-rôles
✔ Base SQL + NoSQL
✔ Interface responsive
✔ Sécurité implémentée

📄 Licence

Projet pédagogique — utilisation académique uniquement.
