<?php
session_start();
require_once("../../config/database.php");
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
    die("Accès interdit");
}

// Menus pour le filtre
$menus = $pdo->query("SELECT id, titre FROM menus ORDER BY titre")->fetchAll(PDO::FETCH_ASSOC);

$menuId = $_GET["menu_id"] ?? "";
$dateDebut = $_GET["date_debut"] ?? "";
$dateFin = $_GET["date_fin"] ?? "";

// Requête CA
$sql = "
SELECT m.titre, COUNT(*) as nb_commandes, SUM(c.prix_total) as ca_total
FROM commandes c
JOIN menus m ON m.id = c.menu_id
WHERE c.statut IN ('accepté','en préparation','en cours de livraison','livré','terminée')
";
$params = [];

if ($menuId !== "") {
    $sql .= " AND c.menu_id = ?";
    $params[] = (int)$menuId;
}

if ($dateDebut !== "") {
    $sql .= " AND DATE(c.created_at) >= ?";
    $params[] = $dateDebut;
}

if ($dateFin !== "") {
    $sql .= " AND DATE(c.created_at) <= ?";
    $params[] = $dateFin;
}

$sql .= " GROUP BY m.titre ORDER BY ca_total DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Total global
$totalGlobal = 0;
foreach ($rows as $r) {
    $totalGlobal += (float)$r["ca_total"];
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin - Chiffre d'affaires</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php require_once("../../views/navbar.php"); ?>

<div class="container mt-5" style="max-width: 1000px;">
  <h1>Chiffre d'affaires</h1>

  <form method="GET" class="card card-body shadow mt-4">
    <div class="row g-2">
      <div class="col-md-4">
        <label class="form-label">Menu</label>
        <select name="menu_id" class="form-select">
          <option value="">Tous</option>
          <?php foreach($menus as $m): ?>
            <option value="<?= (int)$m["id"]; ?>" <?= ($menuId == $m["id"]) ? "selected" : "" ?>>
              <?= htmlspecialchars($m["titre"]); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Date début</label>
        <input type="date" name="date_debut" class="form-control" value="<?= htmlspecialchars($dateDebut); ?>">
      </div>

      <div class="col-md-3">
        <label class="form-label">Date fin</label>
        <input type="date" name="date_fin" class="form-control" value="<?= htmlspecialchars($dateFin); ?>">
      </div>

      <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-primary w-100">Filtrer</button>
      </div>
    </div>
  </form>

  <div class="alert alert-info mt-4">
    <strong>Total global :</strong> <?= number_format($totalGlobal, 2); ?> EUR
  </div>

  <table class="table table-bordered bg-white shadow">
    <thead>
      <tr>
        <th>Menu</th>
        <th>Nb commandes</th>
        <th>CA total (EUR)</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($rows)): ?>
        <tr><td colspan="3" class="text-center text-muted">Aucune donnée</td></tr>
      <?php else: ?>
        <?php foreach($rows as $r): ?>
          <tr>
            <td><?= htmlspecialchars($r["titre"]); ?></td>
            <td><?= (int)$r["nb_commandes"]; ?></td>
            <td><?= number_format((float)$r["ca_total"], 2); ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>

</div>
</body>
</html>
              
