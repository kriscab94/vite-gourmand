<?php
require_once("../../config/database.php");
session_start();

// Vérifier rôle employé ou admin
if (!isset($_SESSION["user"]) || 
   ($_SESSION["user"]["role"] !== "employe" && $_SESSION["user"]["role"] !== "admin")) {
    die("Accès interdit");
}

// Récupérer toutes les commandes
$filtreStatut = $_GET["statut"] ?? "";

if ($filtreStatut !== "") {
    $stmt = $pdo->prepare("
        SELECT c.*, u.nom, u.prenom, m.titre
        FROM commandes c
        JOIN users u ON u.id = c.user_id
        JOIN menus m ON m.id = c.menu_id
        WHERE c.statut = ?
        ORDER BY c.created_at DESC
    ");
    $stmt->execute([$filtreStatut]);
} else {
    $stmt = $pdo->query("
        SELECT c.*, u.nom, u.prenom, m.titre
        FROM commandes c
        JOIN users u ON u.id = c.user_id
        JOIN menus m ON m.id = c.menu_id
        ORDER BY c.created_at DESC
    ");
}

$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Espace employé</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<?php require_once("../../views/navbar.php"); ?>

<div class="container mt-5">

<h1>Espace employé - Commandes</h1>
<?php
$filtreStatut = $_GET["statut"] ?? "";
$statuts = ["", "en attente", "annulee", "accepté", "en préparation", "en cours de livraison", "livré", "terminée"];
?>

<form method="GET" class="row g-2 mt-3 mb-3">
  <div class="col-md-4">
    <select name="statut" class="form-select">
      <?php foreach ($statuts as $s): ?>
        <option value="<?= htmlspecialchars($s) ?>" <?= ($filtreStatut === $s) ? "selected" : "" ?>>
          <?= $s === "" ? "Tous les statuts" : $s ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-2">
    <button class="btn btn-primary w-100">Filtrer</button>
  </div>
</form>

<table class="table table-bordered mt-4">
<thead>
<tr>
  <th>ID</th>
  <th>Client</th>
  <th>Menu</th>
  <th>Personnes</th>
  <th>Total</th>
  <th>Statut</th>
  <th>Actions</th>
</tr>
</thead>

<tbody>
<?php foreach($commandes as $commande): ?>
<tr>
  <td><?= $commande["id"]; ?></td>
  <td><?= htmlspecialchars($commande["prenom"] . " " . $commande["nom"]); ?></td>
  <td><?= htmlspecialchars($commande["titre"]); ?></td>
  <td><?= $commande["nb_personnes"]; ?></td>
  <td><?= number_format($commande["prix_total"], 2); ?> EUR</td>
  <td><?= htmlspecialchars($commande["statut"]); ?></td>

  <td>
  <a class="btn btn-primary btn-sm"
     href="../order.php?id=<?= $commande["id"]; ?>">
     Voir
  </a>

  <div class="mt-2">

    <a class="btn btn-success btn-sm"
       href="update_status.php?id=<?= $commande["id"]; ?>&statut=accepté">
       Accepté
    </a>

    <a class="btn btn-warning btn-sm"
       href="update_status.php?id=<?= $commande["id"]; ?>&statut=en préparation">
       Préparation
    </a>

    <a class="btn btn-info btn-sm"
       href="update_status.php?id=<?= $commande["id"]; ?>&statut=en cours de livraison">
       Livraison
    </a>

    <a class="btn btn-dark btn-sm"
       href="update_status.php?id=<?= $commande["id"]; ?>&statut=terminée">
       Terminée
    </a>

  </div>
</td>

</tr>
<?php endforeach; ?>
</tbody>

</table>

</div>
<?php require_once("../../views/footer.php"); ?>
</body>
</html>
