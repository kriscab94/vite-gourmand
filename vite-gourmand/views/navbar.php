<?php require_once(__DIR__ . "/../config/app.php"); ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?= BASE_URL ?>/index.php">Vite & Gourmand</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>/index.php">Menus</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>/contact.php">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>/mentions-legales.php">Mentions légales</a>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto">
        <?php if (!isset($_SESSION["user"])): ?>

          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL ?>/auth/login.php">Connexion</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL ?>/auth/register.php">Inscription</a>
          </li>

        <?php else: ?>

          <li class="nav-item">
            <span class="navbar-text me-3">
              Bonjour <?= htmlspecialchars($_SESSION["user"]["prenom"]) ?>
              (<?= htmlspecialchars($_SESSION["user"]["role"]) ?>)
            </span>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL ?>/account.php">Mon compte</a>
          </li>

          <?php if ($_SESSION["user"]["role"] === "admin"): ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= BASE_URL ?>/admin/stats.php">Stats Mongo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= BASE_URL ?>/admin/employees.php">Employés</a>
            </li>
          <?php endif; ?>

          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL ?>/auth/logout.php">Déconnexion</a>
          </li>

        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
