<?php
session_start();
require_once("../../config/database.php");

if (!isset($_SESSION["user"]) || 
   ($_SESSION["user"]["role"] !== "employe" && $_SESSION["user"]["role"] !== "admin")) {
    die("Accès interdit");
}

if (!isset($_GET["id"]) || !isset($_GET["statut"])) {
    die("Paramètres manquants");
}

$orderId = (int)$_GET["id"];
$newStatut = $_GET["statut"];

$statutsAutorises = [
    "accepté",
    "en préparation",
    "en cours de livraison",
    "livré",
    "terminée"
];

if (!in_array($newStatut, $statutsAutorises)) {
    die("Statut invalide");
}

// Mettre à jour statut
$stmt = $pdo->prepare("UPDATE commandes SET statut = ? WHERE id = ?");
$stmt->execute([$newStatut, $orderId]);

// Ajouter historique
$stmtH = $pdo->prepare("INSERT INTO order_status_history (commande_id, statut) VALUES (?, ?)");
$stmtH->execute([$orderId, $newStatut]);

header("Location: orders.php");
exit;

