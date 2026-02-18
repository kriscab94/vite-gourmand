<?php

$mongoUri = $_ENV["MONGO_URL"] ?? getenv("MONGO_URL") ?? "mongodb://127.0.0.1:27017";

$mongoManager = new MongoDB\Driver\Manager($mongoUri);

$mongoDbName = "vite_gourmand_stats";
$mongoCollection = "commandes_stats";

