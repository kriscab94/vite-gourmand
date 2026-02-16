<?php
require_once("../../config/database.php");
session_start();

if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
    die("Accès interdit");
}

if (!isset($_GET["id"]) || !isset($_GET["active"])) {
    die("Paramètres manquants");
}

$id = (int)$_GET["id"];
$active = (int)$_GET["active"];

// Sécurité : on ne touche qu’aux employés
$stmt = $pdo->prepare("UPDATE users SET is_active = ? WHERE id = ? AND role = 'employe'");
$stmt->execute([$active, $id]);

header("Location: employees.php");
exit;
