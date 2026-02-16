# Manuel utilisateur — Vite & Gourmand

## 1) Accès au site
L’application est accessible via :
- En local : http://localhost/vite-gourmand/public

## 2) Création de compte
1. Aller sur “Inscription”
2. Remplir le formulaire
3. Le mot de passe doit contenir :
   - 10 caractères minimum
   - 1 majuscule, 1 minuscule
   - 1 chiffre
   - 1 caractère spécial
4. Valider

## 3) Connexion / Déconnexion
- Connexion via la page “Connexion”
- Déconnexion via le bouton “Déconnexion” dans la barre de navigation

## 4) Consulter et filtrer les menus
Depuis la page d’accueil :
- Visualiser tous les menus
- Utiliser les filtres dynamiques (prix max, personnes min, thème, régime)
Les résultats se mettent à jour automatiquement sans rechargement.

## 5) Commander un menu
1. Cliquer sur un menu puis “Commander”
2. Renseigner :
   - Ville
   - Distance (km) si hors Bordeaux
   - Adresse de livraison
   - Date et heure de prestation
   - Nombre de personnes
3. Valider la commande

### Livraison
- Bordeaux : 0 €
- Hors Bordeaux : 5 € + 0,59 €/km

## 6) Suivre une commande
Dans “Mon compte” :
- Visualiser les commandes
- Voir le statut actuel
- Accéder au suivi détaillé (“Voir”) avec l’historique

## 7) Annuler une commande
Dans “Mon compte” :
- L’annulation est possible uniquement si la commande est “en attente”
- L’annulation remet automatiquement le stock

## 8) Déposer un avis
- Un avis peut être déposé uniquement si la commande est “terminée”
- L’avis est visible sur l’accueil seulement après validation par un employé

---

# Manuel employé

## 9) Accès employé
Un employé se connecte via la même page de connexion.
Il accède à l’espace :
- /public/employe/orders.php
- /public/employe/reviews.php

## 10) Gestion des commandes
- Afficher toutes les commandes
- Filtrer par statut
- Changer le statut : accepté, préparation, livraison, terminée
Chaque changement est sauvegardé dans l’historique.

## 11) Validation des avis
- Consulter les avis déposés
- Valider ou refuser un avis

---

# Manuel administrateur

## 12) Gestion des employés
Espace admin :
- /public/admin/employees.php
Actions :
- Créer un compte employé
- Désactiver / réactiver un employé

## 13) Statistiques MongoDB
- /public/admin/stats.php
Graphique : nombre de commandes par menu (données MongoDB)

## 14) Chiffre d’affaires (SQL)
- /public/admin/ca.php
Fonctionnalités :
- filtre par menu
- filtre par date début / date fin
Affiche le CA total et le total global
