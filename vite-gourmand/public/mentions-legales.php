<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Mentions légales</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php require_once("../views/navbar.php"); ?>

<div class="container mt-5" style="max-width: 900px;">
  <h1>Mentions légales</h1>
  <div class="card shadow mt-4">
    <div class="card-body">
      <h5>Éditeur</h5>
      <p>Vite & Gourmand — Bordeaux (projet pédagogique)</p>

      <h5>Hébergement</h5>
      <p>Application déployée sur Render.</p>

      <h5>Données personnelles (RGPD)</h5>
      <p>Les données collectées sont utilisées uniquement pour le fonctionnement du service (compte, commandes, avis).</p>

      <h5>Cookies</h5>
      <p>Le site utilise des cookies de session pour la connexion.</p>
    </div>
  </div>
</div>

<?php require_once("../views/footer.php"); ?>
</body>
</html>
