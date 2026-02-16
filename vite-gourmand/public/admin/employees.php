<?php
require_once("../../config/database.php");
session_start();

if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
    die("Accès interdit");
}

$error = "";
$success = "";

// Création employé
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email invalide.";
    } elseif (strlen($password) < 10) {
        $error = "Mot de passe trop court (10 caractères minimum).";
    } else {
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);
        if ($check->fetch()) {
            $error = "Cet email existe déjà.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("
                INSERT INTO users (nom, prenom, email, telephone, adresse, password_hash, role, is_active)
                VALUES ('Employe', 'Compte', ?, '', 'Bordeaux', ?, 'employe', 1)
            ");
            $stmt->execute([$email, $hash]);

            // Bonus : mail non implémenté ici (on documentera)
            $success = "Employé créé. Le mot de passe doit être transmis en personne.";
        }
    }
}

// Liste employés
$stmt = $pdo->query("SELECT id, email, is_active, created_at FROM users WHERE role='employe' ORDER BY id DESC");
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin - Employés</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php require_once("../../views/navbar.php"); ?>

<div class="container mt-5" style="max-width: 900px;">
  <h1>Admin - Gestion des employés</h1>

  <?php if ($error): ?>
    <div class="alert alert-danger mt-3"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="alert alert-success mt-3"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <div class="card shadow mt-4">
    <div class="card-body">
      <h4>Créer un employé</h4>
      <form method="POST" class="row g-2 mt-2">
        <div class="col-md-6">
          <input class="form-control" type="email" name="email" placeholder="Email employé" required>
        </div>
        <div class="col-md-4">
          <input class="form-control" type="password" name="password" placeholder="Mot de passe (10+)" required>
        </div>
        <div class="col-md-2">
          <button class="btn btn-primary w-100">Créer</button>
        </div>
      </form>
      <div class="form-text mt-2">
        Le mot de passe n’est pas envoyé par email (il sera communiqué par l’administrateur).
      </div>
    </div>
  </div>

  <h4 class="mt-5">Liste des employés</h4>

  <table class="table table-bordered mt-3">
    <thead>
      <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Actif</th>
        <th>Créé le</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($employees as $e): ?>
        <tr>
          <td><?= (int)$e["id"]; ?></td>
          <td><?= htmlspecialchars($e["email"]); ?></td>
          <td><?= $e["is_active"] ? "Oui" : "Non"; ?></td>
          <td><?= htmlspecialchars($e["created_at"]); ?></td>
          <td>
            <?php if ($e["is_active"]): ?>
              <a class="btn btn-danger btn-sm"
                 href="toggle_employee.php?id=<?= (int)$e["id"]; ?>&active=0"
                 onclick="return confirm('Désactiver ce compte ?');">
                 Désactiver
              </a>
            <?php else: ?>
              <a class="btn btn-success btn-sm"
                 href="toggle_employee.php?id=<?= (int)$e["id"]; ?>&active=1">
                 Réactiver
              </a>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</div>
<?php require_once("../../views/footer.php"); ?>
</body>
</html>
                                  