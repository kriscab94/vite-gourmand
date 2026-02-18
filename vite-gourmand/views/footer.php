<?php
require_once(__DIR__ . "/../config/app.php");
require_once(__DIR__ . "/../config/database.php");

// Récupérer horaires
$stmtH = $pdo->query("SELECT * FROM horaires");
$horaires = $stmtH->fetchAll(PDO::FETCH_ASSOC);
?>

<footer class="bg-dark text-light mt-5 pt-4 pb-4">
  <div class="container">
    <div class="row">

      <div class="col-md-4 mb-3">
        <h5>Vite & Gourmand</h5>
        <p class="mb-1">Traiteur événementiel</p>
        <p class="mb-0">Bordeaux</p>
      </div>

      <div class="col-md-4 mb-3">
        <h5>Horaires</h5>
        <?php foreach($horaires as $h): ?>
          <div>
            <?= htmlspecialchars($h["jour"]); ?> :
            <?php if ($h["heure_ouverture"] === null): ?>
              Fermé
            <?php else: ?>
              <?= htmlspecialchars($h["heure_ouverture"]); ?> - <?= htmlspecialchars($h["heure_fermeture"]); ?>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="col-md-4 mb-3">
        <h5>Liens</h5>
        <a class="text-light d-block" href="<?= BASE_URL ?>/mentions.php">Mentions légales</a>
        <a class="text-light d-block" href="<?= BASE_URL ?>/cgv.php">CGV</a>
        <a class="text-light d-block" href="<?= BASE_URL ?>/contact.php">Contact</a>
      </div>

    </div>

    <hr class="border-light">
    <p class="mb-0 text-center">&copy; <?= date("Y"); ?> Vite & Gourmand</p>
  </div>
</footer>
