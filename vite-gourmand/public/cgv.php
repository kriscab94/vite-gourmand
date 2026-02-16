<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>CGV</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php require_once("../views/navbar.php"); ?>

<div class="container mt-5">
  <h1>Conditions Générales de Vente (CGV)</h1>

  <h3>Commandes</h3>
  <p>Les commandes doivent être passées selon les conditions affichées sur chaque menu.</p>

  <h3>Annulation</h3>
  <p>Une commande peut être annulée par le client tant que le statut est “en attente”.</p>

  <h3>Livraison</h3>
  <p>Les frais de livraison dépendent de la zone et de la distance (Bordeaux / hors Bordeaux).</p>

  <h3>Paiement</h3>
  <p>Paiement à la livraison (à adapter selon le projet).</p>
</div>

<?php require_once("../views/footer.php"); ?>
</body>
</html>
