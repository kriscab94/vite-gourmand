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

<div class="container mt-5" style="max-width: 900px;">
  <h1>Conditions Générales de Vente</h1>
  <div class="card shadow mt-4">
    <div class="card-body">
      <p>Document simplifié (projet pédagogique).</p>
      <p>Les commandes sont soumises à validation, paiement et disponibilité.</p>
    </div>
  </div>
</div>

<?php require_once("../views/footer.php"); ?>
</body>
</html>
