<?php
require_once("../config/database.php");
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: auth/login.php");
    exit;
}

if (!isset($_GET["menu_id"])) {
    die("Menu manquant");
}

$menu_id = (int)$_GET["menu_id"];

// récupérer menu
$stmt = $pdo->prepare("SELECT * FROM menus WHERE id = ?");
$stmt->execute([$menu_id]);
$menu = $stmt->fetch();

if (!$menu) {
    die("Menu introuvable");
}

$userId = $_SESSION["user"]["id"];

// récupérer infos complètes utilisateur depuis la BDD (plus fiable que session)
$stmtU = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmtU->execute([$userId]);
$user = $stmtU->fetch();

$error = "";
$success = "";

// calcul simple du prix menu (pour nb_personnes)
function calculPrixMenu($prixBase, $minPersonnes, $nbPersonnes) {
    // prixBase = prix pour minPersonnes
    $prixParPersonne = $prixBase / $minPersonnes;
    $prix = $prixParPersonne * $nbPersonnes;

    // remise -10% si nbPersonnes >= min + 5
    if ($nbPersonnes >= ($minPersonnes + 5)) {
        $prix = $prix * 0.90;
    }
    return $prix;
}


    
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $adresse_livraison = trim($_POST["adresse_livraison"] ?? "");
    $date_evenement = $_POST["date_evenement"] ?? "";
    $heure_livraison = $_POST["heure_livraison"] ?? "";
    $nb_personnes = (int)($_POST["nb_personnes"] ?? 0);

    $ville = trim($_POST["ville"] ?? "");
    $distance_km = (float)($_POST["distance_km"] ?? 0);

    if ($adresse_livraison === "" || $date_evenement === "" || $heure_livraison === "" || $nb_personnes <= 0 || $ville === "") {
        $error = "Merci de remplir tous les champs obligatoires.";
    } elseif ($nb_personnes < (int)$menu["nb_personnes_min"]) {
        $error = "Le nombre de personnes doit être au minimum de " . (int)$menu["nb_personnes_min"] . ".";
    } elseif ((int)$menu["stock"] <= 0) {
        $error = "Stock indisponible pour ce menu.";
    } else {

        // Calcul livraison
        if (mb_strtolower($ville) === "bordeaux") {
            $prix_livraison = 0.00;
            $distance_km = 0;
        } else {
            if ($distance_km <= 0) {
                $error = "Merci d'indiquer la distance (km) si vous êtes hors Bordeaux.";
            } else {
                $prix_livraison = 5 + (0.59 * $distance_km);
            }
        }

        if ($error === "") {
            $prix_menu = calculPrixMenu((float)$menu["prix_base"], (int)$menu["nb_personnes_min"], $nb_personnes);
            $prix_total = $prix_menu + $prix_livraison;

            $stmtC = $pdo->prepare("
                INSERT INTO commandes (
                    user_id, menu_id, nb_personnes, prix_total, prix_livraison,
                    adresse_livraison, date_evenement, heure_livraison, statut,
                    ville, distance_km
                )
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'en attente', ?, ?)
            ");

            $stmtC->execute([
                $userId,
                $menu_id,
                $nb_personnes,
                $prix_total,
                $prix_livraison,
                $adresse_livraison,
                $date_evenement,
                $heure_livraison,
                $ville,
                $distance_km
            ]);

            $commandeId = $pdo->lastInsertId();

            // Mongo stats
            require_once("../config/mongo_native.php");
            $bulk = new MongoDB\Driver\BulkWrite;
            $bulk->insert([
                "commande_id" => (int)$commandeId,
                "menu_id" => (int)$menu["id"],
                "menu_titre" => (string)$menu["titre"],
                "prix_total" => (float)$prix_total,
                "date_commande" => new MongoDB\BSON\UTCDateTime((new DateTime())->getTimestamp() * 1000),
            ]);
            $mongoManager->executeBulkWrite("$mongoDbName.$mongoCollection", $bulk);

            // historique statut
            $stmtH = $pdo->prepare("INSERT INTO order_status_history (commande_id, statut) VALUES (?, 'en attente')");
            $stmtH->execute([$commandeId]);

            // stock -1
            $stmtS = $pdo->prepare("UPDATE menus SET stock = stock - 1 WHERE id = ? AND stock > 0");
            $stmtS->execute([$menu_id]);

            $success = "Commande créée !";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Commander</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once("../views/navbar.php"); ?>

<div class="container mt-5" style="max-width: 800px;">

  <h1 class="mb-3">Commander : <?= htmlspecialchars($menu["titre"]); ?></h1>

  <div class="card shadow mb-4">
    <div class="card-body">
      <p><strong>Menu :</strong> <?= htmlspecialchars($menu["titre"]); ?></p>
      <p><strong>Minimum :</strong> <?= (int)$menu["nb_personnes_min"]; ?> personnes</p>
      <p><strong>Prix (pour min) :</strong> <?= number_format((float)$menu["prix_base"], 2); ?> EUR</p>
      <p><strong>Stock :</strong> <?= (int)$menu["stock"]; ?></p>
      <p class="text-danger"><strong>Conditions :</strong> <?= htmlspecialchars($menu["conditions_menu"]); ?></p>
    </div>
  </div>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
  <?php endif; ?>

  <form method="POST" class="card card-body shadow">
    <h4>Informations client</h4>
    <p><strong><?= htmlspecialchars($user["prenom"]); ?> <?= htmlspecialchars($user["nom"]); ?></strong> — <?= htmlspecialchars($user["email"]); ?></p>
<div class="mb-3">
  <label class="form-label">Ville *</label>
  <input class="form-control" name="ville" required placeholder="Ex: Bordeaux">
</div>

<div class="mb-3">
  <label class="form-label">Distance (km) (si hors Bordeaux)</label>
  <input class="form-control" name="distance_km" type="number" step="0.1" min="0" value="0">
  <div class="form-text">Si vous êtes à Bordeaux, laissez 0. Sinon indiquez la distance en km.</div>
</div>

    <hr>

   
      <label class="form-label">Adresse de livraison *</label>
      <textarea class="form-control" name="adresse_livraison" rows="2" required></textarea>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Date prestation *</label>
        <input type="date" class="form-control" name="date_evenement" required>
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Heure livraison *</label>
        <input type="time" class="form-control" name="heure_livraison" required>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Nombre de personnes *</label>
      <input type="number" class="form-control" name="nb_personnes" min="<?= (int)$menu["nb_personnes_min"]; ?>" value="<?= (int)$menu["nb_personnes_min"]; ?>" required>
      <div class="form-text">Remise -10% si vous commandez au moins <?= (int)$menu["nb_personnes_min"] + 5; ?> personnes.</div>
    </div>

    <button class="btn btn-success">Valider la commande</button>
  </form>

</div>
<?php require_once("../views/footer.php"); ?>
</body>
</html>
