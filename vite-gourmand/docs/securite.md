# Sécurité de l’application — Vite & Gourmand

## 1. Protection des mots de passe

Les mots de passe utilisateurs ne sont jamais stockés en clair.
Ils sont hashés avec la fonction PHP :

password_hash()

Lors de la connexion, la vérification est réalisée avec :

password_verify()

---

## 2. Protection contre les injections SQL

Toutes les requêtes vers la base de données utilisent PDO avec
des requêtes préparées.

Exemple :

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);

Cela empêche l’exécution de code SQL malveillant.

---

## 3. Protection contre les attaques XSS

Les données affichées provenant des utilisateurs sont sécurisées avec :

htmlspecialchars()

Cela empêche l’injection de scripts JavaScript dans les pages.

---

## 4. Validation des formulaires

Tous les formulaires sont validés côté serveur :

- champs obligatoires vérifiés
- nombre minimum de personnes contrôlé
- distance livraison validée
- données typées (int, float, string)

Cela empêche l’envoi de données incorrectes.

---

## 5. Gestion des rôles et accès

L’application distingue trois rôles :

- utilisateur
- employé
- administrateur

L’accès aux pages sensibles est contrôlé via les sessions PHP.

Exemple :

if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
    die("Accès interdit");
}

---

## 6. Gestion des sessions

L’authentification repose sur les sessions PHP :

- session_start() utilisé sur les pages protégées
- accès refusé si utilisateur non connecté

---

## 7. Bonnes pratiques appliquées

- séparation frontend / backend
- validation serveur prioritaire
- limitation des accès par rôle
- stockage minimal des données personnelles
