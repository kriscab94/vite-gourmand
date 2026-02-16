<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Mentions légales</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php require_once("../views/navbar.php"); ?>

<div class="container mt-5">
  <h1>Mentions légales</h1>
  <p>Site fictif réalisé dans le cadre d’un projet de formation.</p>

  <h3>Éditeur</h3>
  <p>Vite & Gourmand - Bordeaux</p>

  <h3>Hébergement</h3>
  <p>Localhost (développement) / (à compléter au déploiement)</p>

  <h3>Données personnelles</h3>
  <p>Les données collectées sont utilisées uniquement pour la gestion des commandes. Vous pouvez demander suppression/modification.</p>
</div>

<?php require_once("../views/footer.php"); ?>
</body>
</html>
