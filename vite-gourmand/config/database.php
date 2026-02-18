<?php

$host = $_ENV["DB_HOST"] ?? "localhost";
$port = $_ENV["DB_PORT"] ?? "3306";
$db   = $_ENV["DB_NAME"] ?? "vite_gourmand";
$user = $_ENV["DB_USER"] ?? "root";
$pass = $_ENV["DB_PASS"] ?? "";

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erreur connexion BDD : " . $e->getMessage());
}


