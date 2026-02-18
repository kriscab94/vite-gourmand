<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">

    <a class="navbar-brand" href="/index.php">Vite & Gourmand</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">

      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="/index.php">Menus</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/contact.php">Contact</a>
        </li>
      </ul>

      <ul class="navbar-nav">
        <?php if (!isset($_SESSION["user"])): ?>

          <li class="nav-item">
            <a class="nav-link" href="/auth/login.php">Connexion</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="/auth/register.php">Inscription</a>
          </li>

        <?php else: ?>

          <li class="nav-item">
            <span class="navbar-text me-3">
              Bonjour <?= htmlspecialchars($_SESSION["user"]["prenom"]) ?>
              (<?= htmlspecialchars($_SESSION["user"]["role"]) ?>)
            </span>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="/account.php">Mon compte</a>
          </li>

          <?php if ($_SESSION["user"]["role"] === "admin"): ?>
            <li class="nav-item">
              <a class="nav-link" href="/admin/stats.php">Stats Mongo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/admin/ca.php">Chiffre d'affaires</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/admin/employees.php">Employés</a>
            </li>
          <?php endif; ?>

          <li class="nav-item">
            <a class="nav-link" href="/auth/logout.php">Déconnexion</a>
          </li>

        <?php endif; ?>
      </ul>

    </div>
  </div>
</nav>
