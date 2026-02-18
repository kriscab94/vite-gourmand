<?php

$host = $_SERVER["HTTP_HOST"] ?? "";

/*
|--------------------------------------------------------------------------
| Détection environnement
|--------------------------------------------------------------------------
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
    // Local XAMPP
    define('BASE_URL', '/vite-gourmand/public');
} else {
    // Production Render
    define('BASE_URL', '');
}
