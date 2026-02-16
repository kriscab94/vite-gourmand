<?php
require_once("../../config/database.php");
session_start();

if (!isset($_SESSION["user"]) || 
   ($_SESSION["user"]["role"] !== "employe" && $_SESSION["user"]["role"] !== "admin")) {
    die("Accès interdit");
}

$stmt = $pdo->query("
    SELECT a.*, c.id AS commande_id, u.prenom, u.nom
    FROM avis a
    JOIN commandes c ON c.id = a.commande_id
    JOIN users u ON u.id = c.user_id
    ORDER BY a.id DESC
");
$avis = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Avis - Employé</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php require_once("../../views/navbar.php"); ?>

<div class="container mt-5">
  <h1>Avis clients</h1>

  <table class="table table-bordered mt-4">
    <thead>
      <tr>
        <th>ID</th>
        <th>Client</th>
        <th>Note</th>
        <th>Commentaire</th>
        <th>Validé</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($avis as $a): ?>
      <tr>
        <td><?= $a["id"]; ?></td>
        <td><?= htmlspecialchars($a["prenom"]." ".$a["nom"]); ?></td>
        <td><?= (int)$a["note"]; ?>/5</td>
        <td><?= htmlspecialchars($a["commentaire"]); ?></td>
        <td><?= $a["valide"] ? "Oui" : "Non"; ?></td>
        <td class="d-flex gap-2">
          <?php if(!$a["valide"]): ?>
            <a class="btn btn-success btn-sm" href="validate_review.php?id=<?= $a["id"]; ?>&val=1">Valider</a>
          <?php endif; ?>
          <a class="btn btn-danger btn-sm" href="validate_review.php?id=<?= $a["id"]; ?>&val=0">Refuser</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>

</div>
<?php require_once("../../views/footer.php"); ?>
</body>
</html>
