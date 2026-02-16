<?php
require_once("../config/database.php");
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: auth/login.php");
    exit;
}

if (!isset($_GET["id"])) {
    die("Commande manquante");
}

$orderId = (int)$_GET["id"];
$userId = (int)$_SESSION["user"]["id"];

// Charger commande + menu
$stmt = $pdo->prepare("
    SELECT c.*, m.titre AS menu_titre
    FROM commandes c
    JOIN menus m ON m.id = c.menu_id
    WHERE c.id = ? AND c.user_id = ?
");
$stmt->execute([$orderId, $userId]);
$commande = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$commande) {
    die("Commande introuvable");
}

// Charger historique statuts
$stmtH = $pdo->prepare("
    SELECT statut, date_modification
    FROM order_status_history
    WHERE commande_id = ?
    ORDER BY date_modification ASC
");
$stmtH->execute([$orderId]);
$history = $stmtH->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Suivi commande #<?= $commande["id"]; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<?php require_once("../views/navbar.php"); ?>

<div class="container mt-5" style="max-width: 900px;">

  <a href="account.php" class="btn btn-secondary mb-3">Retour</a>

  <h1>Commande #<?= $commande["id"]; ?></h1>

  <div class="card shadow mb-4">
    <div class="card-body">
      <p><strong>Menu :</strong> <?= htmlspecialchars($commande["menu_titre"]); ?></p>
      <p><strong>Personnes :</strong> <?= (int)$commande["nb_personnes"]; ?></p>
      <p><strong>Total :</strong> <?= number_format((float)$commande["prix_total"], 2); ?> EUR</p>


      <p><strong>Statut actuel :</strong> <?= htmlspecialchars($commande["statut"]); ?></p>
      <p><strong>Date prestation :</strong> <?= htmlspecialchars($commande["date_evenement"]); ?> - <?= htmlspecialchars($commande["heure_livraison"]); ?></p>

      <p><strong>Adresse :</strong> <?= htmlspecialchars($commande["adresse_livraison"]); ?></p>
    </div>
  </div>

  <h3>Suivi (historique)</h3>

  <?php if (empty($history)): ?>
    <p>Aucun historique.</p>
  <?php else: ?>
    <ul class="list-group">
      <?php foreach ($history as $h): ?>
        <li class="list-group-item d-flex justify-content-between">
          <span><?= htmlspecialchars($h["statut"]); ?></span>
          <span class="text-muted"><?= htmlspecialchars($h["date_modification"]); ?></span>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

</div>
<?php require_once("../views/footer.php"); ?>
</body>
</html>
