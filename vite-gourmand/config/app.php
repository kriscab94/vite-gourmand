<?php
$host = $_SERVER["HTTP_HOST"] ?? "";

// Local si on est sur localhost / 127.0.0.1
$isLocal = ($host === "localhost" || str_starts_with($host, "127.0.0.1") || str_contains($host, "localhost"));

define("BASE_URL", $isLocal ? "/vite-gourmand/public" : "");
