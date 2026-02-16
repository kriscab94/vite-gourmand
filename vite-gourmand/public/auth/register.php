<?php
require_once("../../config/database.php");
session_start();

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = trim($_POST["nom"] ?? "");
    $prenom = trim($_POST["prenom"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $telephone = trim($_POST["telephone"] ?? "");
    $adresse = trim($_POST["adresse"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($nom === "" || $prenom === "" || $email === "" || $password === "") {
        $error = "Merci de remplir les champs obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email invalide.";
    } elseif (
    strlen($password) < 10 ||
    !preg_match('/[A-Z]/', $password) ||
    !preg_match('/[a-z]/', $password) ||
    !preg_match('/[0-9]/', $password) ||
    !preg_match('/[^A-Za-z0-9]/', $password)
) {
    $error = "Le mot de passe doit contenir au moins 10 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
}
 else {
        // Vérifier email unique
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);
        if ($check->fetch()) {
            $error = "Cet email est déjà utilisé.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("
                INSERT INTO users (nom, prenom, email, telephone, adresse, password_hash, role)
                VALUES (?, ?, ?, ?, ?, ?, 'user')
            ");
            $stmt->execute([$nom, $prenom, $email, $telephone, $adresse, $hash]);

            $success = "Compte créé ! Vous pouvez vous connecter.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">  
<title>Inscription</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php require_once("../../views/navbar.php"); ?>
<div class="container mt-5" style="max-width: 650px;">
  <h1 class="mb-4">Créer un compte</h1>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <form method="POST" class="card card-body shadow">
    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Nom *</label>
        <input class="form-control" name="nom" required>
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Prénom *</label>
        <input class="form-control" name="prenom" required>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Email *</label>
      <input class="form-control" name="email" type="email" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Téléphone</label>
      <input class="form-control" name="telephone">
    </div>

    <div class="mb-3">
      <label class="form-label">Adresse</label>
      <textarea class="form-control" name="adresse" rows="2"></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Mot de passe * (10 caractères min)</label>
      <input class="form-control" name="password" type="password" required>
    </div>

    <button class="btn btn-primary">Créer mon compte</button>
    <a class="btn btn-link" href="login.php">Déjà un compte ? Se connecter</a>
  </form>
</div>
<?php require_once("../../views/footer.php"); ?>
</body>
</html>
