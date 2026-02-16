<?php
require_once("../config/database.php");

// Récupérer les menus
$sql = "SELECT * FROM menus";
$stmt = $pdo->query($sql);
$menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Récupérer les avis validés (derniers avis)
$sqlAvis = "
SELECT a.note, a.commentaire, u.prenom, m.titre AS menu_titre
FROM avis a
JOIN commandes c ON c.id = a.commande_id
JOIN users u ON u.id = c.user_id
JOIN menus m ON m.id = c.menu_id
WHERE a.valide = 1
ORDER BY a.id DESC
LIMIT 6
";
$stmtAvis = $pdo->query($sqlAvis);
$avisValides = $stmtAvis->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
    <title>Vite & Gourmand</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<meta charset="UTF-8">

<body class="bg-light">

<?php require_once("../views/navbar.php"); ?>

<div class="container mt-5">
<div class="card shadow mb-4">
  <div class="card-body">
    <h5 class="mb-3">Filtrer les menus</h5>

    <div class="row g-2">
      <div class="col-md-3">
        <input id="prixMax" type="number" class="form-control" placeholder="Prix max (€)">
      </div>

      <div class="col-md-3">
        <input id="minPers" type="number" class="form-control" placeholder="Nb personnes min">
      </div>

      <div class="col-md-3">
        <input id="theme" class="form-control" placeholder="Thème (ex: noel)">
      </div>

      <div class="col-md-3">
        <input id="regime" class="form-control" placeholder="Régime (ex: standard)">
      </div>
    </div>

    <button id="resetBtn" class="btn btn-secondary mt-3">Réinitialiser</button>
  </div>
</div>

    <h1 class="text-center mb-4">Nos menus</h1>

    <div class="row" id="menusContainer">

        <?php foreach($menus as $menu): ?>

            <div class="col-md-6 mb-4">

                <div class="card shadow">

                    <div class="card-body">

                        <h3 class="card-title"><?= $menu['titre']; ?></h3>

                        <p class="card-text"><?= $menu['description']; ?></p>

                        <p><strong>Prix :</strong> <?= $menu['prix_base']; ?> €</p>

                        <p><strong>Minimum :</strong> <?= $menu['nb_personnes_min']; ?> personnes</p>

                        <a href="menu.php?id=<?= $menu['id']; ?>" class="btn btn-primary">
    Voir détail
</a>

<h2 class="text-center mt-5 mb-4">Avis clients</h2>

<?php if (empty($avisValides)): ?>
  <p class="text-center text-muted">Aucun avis validé pour le moment.</p>
<?php else: ?>

  <div class="row">
    <?php foreach ($avisValides as $a): ?>
      <div class="col-md-4 mb-4">
        <div class="card shadow">
          <div class="card-body">
            <h5 class="card-title mb-1"><?= htmlspecialchars($a["prenom"]); ?></h5>
            <div class="text-warning mb-2">
              <?= str_repeat("★", (int)$a["note"]); ?><?= str_repeat("☆", 5 - (int)$a["note"]); ?>
              <span class="text-muted">(<?= (int)$a["note"]; ?>/5)</span>
            </div>
            <p class="card-text"><?= nl2br(htmlspecialchars($a["commentaire"])); ?></p>
            <p class="text-muted mb-0"><small>Menu : <?= htmlspecialchars($a["menu_titre"]); ?></small></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

<?php endif; ?>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>
<?php require_once("../views/footer.php"); ?>
<script>
async function loadMenus() {
  const prixMax = document.getElementById("prixMax").value;
  const minPers = document.getElementById("minPers").value;
  const theme = document.getElementById("theme").value;
  const regime = document.getElementById("regime").value;

  const params = new URLSearchParams();
  if (prixMax) params.append("prixMax", prixMax);
  if (minPers) params.append("minPers", minPers);
  if (theme) params.append("theme", theme);
  if (regime) params.append("regime", regime);

  const res = await fetch("api/menus.php?" + params.toString());
  const menus = await res.json();

  const container = document.getElementById("menusContainer");
  container.innerHTML = "";

  if (menus.length === 0) {
    container.innerHTML = `<p class="text-muted">Aucun menu trouvé.</p>`;
    return;
  }

  menus.forEach(menu => {
    container.innerHTML += `
      <div class="col-md-6 mb-4">
        <div class="card shadow">
          <div class="card-body">
            <h3 class="card-title">${menu.titre}</h3>
            <p class="card-text">${menu.description}</p>
            <p><strong>Prix :</strong> ${menu.prix_base} EUR</p>
            <p><strong>Minimum :</strong> ${menu.nb_personnes_min} personnes</p>
            <a href="menu.php?id=${menu.id}" class="btn btn-primary">Voir détail</a>
          </div>
        </div>
      </div>
    `;
  });
}

["prixMax","minPers","theme","regime"].forEach(id => {
  document.getElementById(id).addEventListener("input", loadMenus);
});

document.getElementById("resetBtn").addEventListener("click", () => {
  document.getElementById("prixMax").value = "";
  document.getElementById("minPers").value = "";
  document.getElementById("theme").value = "";
  document.getElementById("regime").value = "";
  loadMenus();
});
</script>

</body>
</html>
