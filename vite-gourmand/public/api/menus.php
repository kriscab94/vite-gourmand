<?php
require_once("../../config/database.php");

header("Content-Type: application/json; charset=UTF-8");

$prixMax = isset($_GET["prixMax"]) && $_GET["prixMax"] !== "" ? (float)$_GET["prixMax"] : null;
$theme = isset($_GET["theme"]) ? trim($_GET["theme"]) : "";
$regime = isset($_GET["regime"]) ? trim($_GET["regime"]) : "";
$minPers = isset($_GET["minPers"]) && $_GET["minPers"] !== "" ? (int)$_GET["minPers"] : null;

$sql = "SELECT * FROM menus WHERE 1=1";
$params = [];

if ($prixMax !== null) {
    $sql .= " AND prix_base <= ?";
    $params[] = $prixMax;
}
if ($theme !== "") {
    $sql .= " AND theme = ?";
    $params[] = $theme;
}
if ($regime !== "") {
    $sql .= " AND regime = ?";
    $params[] = $regime;
}
if ($minPers !== null) {
    $sql .= " AND nb_personnes_min <= ?";
    $params[] = $minPers;
}

$sql .= " ORDER BY id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$menus = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($menus);
