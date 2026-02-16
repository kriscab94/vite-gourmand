<?php

$mongoManager = new MongoDB\Driver\Manager("mongodb://127.0.0.1:27017");

$mongoDbName = "vite_gourmand_stats";
$mongoCollection = "commandes_stats";
