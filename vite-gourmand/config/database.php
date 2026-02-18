<?php

$dbUrl = $_ENV["DB_URL"] ?? null;

if ($dbUrl) {
    // Exemple DB_URL: mysql://user:pass@host:port/dbname?ssl-mode=REQUIRED
    $parts = parse_url($dbUrl);

    $host = $parts["host"] ?? "localhost";
    $port = $parts["port"] ?? 3306;
    $user = $parts["user"] ?? "root";
    $pass = $parts["pass"] ?? "";
    $db   = ltrim($parts["path"] ?? "/vite_gourmand", "/");

} else {
    $host = $_ENV["DB_HOST"] ?? "localhost";
    $port = $_ENV["DB_PORT"] ?? "3306";
    $db   = $_ENV["DB_NAME"] ?? "vite_gourmand";
    $user = $_ENV["DB_USER"] ?? "root";
    $pass = $_ENV["DB_PASS"] ?? "";
}

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erreur connexion BDD : " . $e->getMessage());
}




