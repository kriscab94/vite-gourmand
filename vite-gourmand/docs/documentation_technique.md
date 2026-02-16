# Documentation technique — Vite & Gourmand

## 1. Architecture générale

L’application suit une architecture web classique :

- Frontend : HTML, Bootstrap, JavaScript
- Backend : PHP
- Base relationnelle : MySQL
- Base NoSQL : MongoDB

Structure :

/config → connexions bases de données  
/public → pages accessibles utilisateur  
/views → composants réutilisables (navbar, footer)  
/docs → documentation projet  

---

## 2. Gestion des utilisateurs

Trois rôles existent :

### User
- consulter menus
- commander
- suivre commandes
- déposer avis

### Employé
- gérer commandes
- modifier statuts
- valider avis

### Admin
- gérer employés
- consulter statistiques MongoDB
- consulter chiffre d’affaires

Les rôles sont stockés dans la table `users`.

---

## 3. Base de données MySQL

Tables principales :

### users
Informations utilisateurs et rôles.

### menus
Menus disponibles avec prix, stock et conditions.

### commandes
Commandes clients avec :
- statut
- adresse
- livraison
- ville
- distance

### order_status_history
Historique des changements de statut.

### avis
Avis clients validés par employés.

### horaires
Horaires affichés dans le footer.

---

## 4. Base NoSQL MongoDB

MongoDB est utilisée pour stocker les statistiques.

Collection :

commandes_stats

Chaque document contient :
- id commande
- menu
- prix total
- date

MongoDB permet de générer des statistiques rapides pour l’administration.

---

## 5. Calcul du prix

Prix total :

prix_menu + prix_livraison

### Livraison
- Bordeaux : gratuit
- Hors Bordeaux : 5€ + 0,59€/km

### Remise
-10% si nombre de personnes ≥ minimum + 5.

---

## 6. Sécurité

### Authentification
Sessions PHP sécurisées.

### Mots de passe
Hashage via password_hash().

### Protection SQL Injection
Requêtes préparées PDO.

### Protection XSS
htmlspecialchars() lors des affichages.

### Validation serveur
Tous les formulaires sont validés côté backend.

---

## 7. API interne

Endpoint AJAX :

/public/api/menus.php

Permet le filtrage dynamique des menus sans rechargement de page.

---

## 8. Statistiques

Graphiques réalisés avec Chart.js.

Sources :
- MongoDB → nombre de commandes par menu
- MySQL → chiffre d’affaires

---

## 9. Déploiement

Application conçue pour fonctionner sur :
- Apache (XAMPP)
- PHP 8+
- MySQL
- MongoDB

URL locale :
http://localhost/vite-gourmand/public
