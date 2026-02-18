<?php
session_start();
require_once("../config/database.php");

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION["user"])) {
    header("Location: auth/login.php");
    exit;
}

$user = $_SESSION["user"];
// Récupérer les commandes de l'utilisateur
$stmt = $pdo->prepare("
    SELECT commandes.*, menus.titre 
    FROM commandes
    JOIN menus ON commandes.menu_id = menus.id
    WHERE commandes.user_id = ?
    ORDER BY commandes.created_at DESC
");
$stmt->execute([$user["id"]]);
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mon compte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<?php require_once("../views/navbar.php"); ?>

<div class="container mt-5">

    <h1>Mon compte</h1>

    <div class="card mt-4 shadow">
        <div class="card-body">

            <p><strong>Nom :</strong> <?= htmlspecialchars($user["nom"]); ?></p>
            <p><strong>Prénom :</strong> <?= htmlspecialchars($user["prenom"]); ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($user["email"]); ?></p>
            <p><strong>Rôle :</strong> <?= htmlspecialchars($user["role"]); ?></p>
<h2 class="mt-5">Mes commandes</h2>

<?php if (empty($commandes)): ?>
    <p>Aucune commande pour le moment.</p>
<?php else: ?>

<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Menu</th>
            <th>Personnes</th>
            <th>Total (€)</th>
            <th>Statut</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($commandes as $commande): ?>
            <tr>
    <td><?= $commande["id"]; ?></td>
    <td><?= htmlspecialchars($commande["titre"]); ?></td>
    <td><?= $commande["nb_personnes"]; ?></td>
    <td><?= number_format($commande["prix_total"], 2); ?> EUR</td>
    <td><?= htmlspecialchars($commande["statut"]); ?></td>
    <td><?= $commande["created_at"]; ?></td>

    <td class="d-flex gap-2">
        <a class="btn btn-primary btn-sm"
           href="order.php?id=<?= (int)$commande["id"]; ?>">
           Voir
<?php if ($commande["statut"] === "terminée"): ?>
  <a class="btn btn-outline-secondary btn-sm"
     href="review.php?order_id=<?= (int)$commande["id"]; ?>">
     Avis
  </a>
<?php endif; ?>

        </a>

        <?php if ($commande["statut"] === "en attente"): ?>
            <a class="btn btn-danger btn-sm"
               href="cancel_order.php?id=<?= (int)$commande["id"]; ?>"
               onclick="return confirm('Annuler cette commande ?');">
               Annuler
            </a>
        <?php else: ?>
            <span class="text-muted">-</span>
        <?php endif; ?>
    </td>
</tr>

        <?php endforeach; ?>

    </tbody>
</table>

<?php endif; ?>

        </div>
    </div>

</div>
<?php require_once("../views/footer.php"); ?>

</body>
</html>

