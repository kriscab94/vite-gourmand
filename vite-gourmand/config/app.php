<?php

$host = $_SERVER["HTTP_HOST"] ?? "";

/*
|--------------------------------------------------------------------------
| Détection environnement
|--------------------------------------------------------------------------
| Local (XAMPP) ou Production (Render)
*/

$isLocal =
    $host === "localhost" ||
    str_starts_with($host, "127.0.0.1") ||
    str_contains($host, "localhost");

/*
|--------------------------------------------------------------------------
| URL de base
|--------------------------------------------------------------------------
*/

if ($isLocal) {
    // XAMPP
    define('BASE_URL', '/vite-gourmand/public');
} else {
    // Render / Production
    define('BASE_URL', '');
}

