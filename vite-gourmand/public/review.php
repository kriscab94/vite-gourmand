<?php
require_once("../config/database.php");
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: auth/login.php");
    exit;
}

if (!isset($_GET["order_id"])) {
    die("Commande manquante");
}

$orderId = (int)$_GET["order_id"];
$userId = (int)$_SESSION["user"]["id"];

// Charger la commande
$stmt = $pdo->prepare("SELECT * FROM commandes WHERE id = ? AND user_id = ?");
$stmt->execute([$orderId, $userId]);
$commande = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$commande) {
    die("Commande introuvable");
}

if ($commande["statut"] !== "terminée") {
    die("Vous pouvez donner un avis uniquement quand la commande est terminée.");
}

// Vérifier s’il existe déjà un avis
$check = $pdo->prepare("SELECT id FROM avis WHERE commande_id = ?");
$check->execute([$orderId]);
if ($check->fetch()) {
    die("Avis déjà envoyé.");
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $note = (int)($_POST["note"] ?? 0);
    $commentaire = trim($_POST["commentaire"] ?? "");

    if ($note < 1 || $note > 5) {
        $error = "La note doit être entre 1 et 5.";
    } elseif ($commentaire === "") {
        $error = "Merci d'écrire un commentaire.";
    } else {
        $stmtA = $pdo->prepare("INSERT INTO avis (commande_id, note, commentaire, valide) VALUES (?, ?, ?, 0)");
        $stmtA->execute([$orderId, $note, $commentaire]);
        $success = "Avis envoyé ! Il sera visible après validation.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Avis</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php require_once("../views/navbar.php"); ?>

<div class="container mt-5" style="max-width: 700px;">
  <h1>Laisser un avis</h1>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <a href="account.php" class="btn btn-secondary">Retour</a>
    <?php exit; ?>
  <?php endif; ?>

  <form method="POST" class="card card-body shadow mt-3">
    <div class="mb-3">
      <label class="form-label">Note (1 à 5)</label>
      <select class="form-select" name="note" required>
        <option value="5">5</option>
        <option value="4">4</option>
        <option value="3">3</option>
        <option value="2">2</option>
        <option value="1">1</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Commentaire</label>
      <textarea class="form-control" name="commentaire" rows="4" required></textarea>
    </div>

    <button class="btn btn-primary">Envoyer</button>
  </form>
</div>
<?php require_once("../views/footer.php"); ?>
</body>
</html>
