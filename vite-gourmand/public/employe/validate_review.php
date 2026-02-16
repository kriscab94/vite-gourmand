<?php
require_once("../../config/database.php");
session_start();

if (!isset($_SESSION["user"]) || 
   ($_SESSION["user"]["role"] !== "employe" && $_SESSION["user"]["role"] !== "admin")) {
    die("Accès interdit");
}

if (!isset($_GET["id"]) || !isset($_GET["val"])) {
    die("Paramètres manquants");
}

$id = (int)$_GET["id"];
$val = (int)$_GET["val"];

$stmt = $pdo->prepare("UPDATE avis SET valide = ? WHERE id = ?");
$stmt->execute([$val, $id]);

header("Location: reviews.php");
exit;
