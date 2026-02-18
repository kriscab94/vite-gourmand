<?php
// Si tu es en ligne (Render), on met base vide.
// En local XAMPP, le projet est dans /vite-gourmand/public/
$isProd = !empty($_ENV["RENDER"]) || !empty($_ENV["RENDER_SERVICE_ID"]);

define("BASE_URL", $isProd ? "" : "/vite-gourmand/public");
