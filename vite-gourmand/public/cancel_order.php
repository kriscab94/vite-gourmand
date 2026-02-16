<?php
require_once("../config/database.php");
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: auth/login.php");
    exit;
}

if (!isset($_GET["id"])) {
    die("Commande manquante");
}

$orderId = (int)$_GET["id"];
$userId = (int)$_SESSION["user"]["id"];

// Vérifier que la commande appartient à l'utilisateur et qu'elle est annulable
$stmt = $pdo->prepare("SELECT * FROM commandes WHERE id = ? AND user_id = ?");
$stmt->execute([$orderId, $userId]);
$commande = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$commande) {
    die("Commande introuvable");
}

if ($commande["statut"] !== "en attente") {
    die("Vous ne pouvez plus annuler cette commande.");
}

// Mettre statut "annulee"
$upd = $pdo->prepare("UPDATE commandes SET statut = 'annulee' WHERE id = ?");
$upd->execute([$orderId]);

// Historique
$hist = $pdo->prepare("INSERT INTO order_status_history (commande_id, statut) VALUES (?, 'annulee')");
$hist->execute([$orderId]);

// (Option bonus) remettre le stock +1
$restock = $pdo->prepare("UPDATE menus SET stock = stock + 1 WHERE id = ?");
$restock->execute([$commande["menu_id"]]);

header("Location: account.php");
exit;
