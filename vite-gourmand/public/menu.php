<?php
session_start();
require_once("../config/database.php");

// Vérifier si ID existe
if(!isset($_GET['id'])){
    die("Menu introuvable");
}

$id = $_GET['id'];

// Récupérer menu
$sql = "SELECT * FROM menus WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$menu = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$menu){
    die("Menu introuvable");
}

// Récupérer plats du menu
$sqlPlats = "
SELECT plats.nom, plats.type
FROM plats
JOIN menu_plats ON plats.id = menu_plats.plat_id
WHERE menu_plats.menu_id = ?
";

$stmtPlats = $pdo->prepare($sqlPlats);
$stmtPlats->execute([$id]);
$plats = $stmtPlats->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $menu['titre']; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<meta charset="UTF-8">

<body class="bg-light">

<?php require_once("../views/navbar.php"); ?>

<div class="container mt-5">

    <a href="index.php" class="btn btn-secondary mb-3">Retour</a>

    <h1><?= $menu['titre']; ?></h1>

    <p><?= $menu['description']; ?></p>

    <p><strong>Prix :</strong> <?= $menu['prix_base']; ?> €</p>
<?php if (!isset($_SESSION["user"])): ?>
  <a href="auth/login.php" class="btn btn-success mt-3">Se connecter pour commander</a>
<?php else: ?>
  <a href="commande.php?menu_id=<?= $menu['id']; ?>" class="btn btn-success mt-3">Commander ce menu</a>
<?php endif; ?>

    <p><strong>Minimum :</strong> <?= $menu['nb_personnes_min']; ?> personnes</p>

    <h3 class="mt-4">Plats du menu</h3>

    <ul class="list-group">
        <?php foreach($plats as $plat): ?>
            <li class="list-group-item">
                <?= $plat['type']; ?> - <?= $plat['nom']; ?>
            </li>
        <?php endforeach; ?>
    </ul>

</div>
<?php require_once("../views/footer.php"); ?>

</body>
</html>

