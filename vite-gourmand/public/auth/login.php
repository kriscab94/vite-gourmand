<?php
session_start();
require_once("../../config/database.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND is_active = 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password, $user["password_hash"])) {
        $error = "Identifiants incorrects.";
    } else {
        $_SESSION["user"] = [
            "id" => $user["id"],
            "nom" => $user["nom"],
            "prenom" => $user["prenom"],
            "email" => $user["email"],
            "role" => $user["role"]
        ];

        header("Location: ../index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">  
<title>Connexion</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php require_once("../../views/navbar.php"); ?>
<div class="container mt-5" style="max-width: 520px;">
  <h1 class="mb-4">Connexion</h1>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" class="card card-body shadow">
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input class="form-control" name="email" type="email" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Mot de passe</label>
      <input class="form-control" name="password" type="password" required>
    </div>

    <button class="btn btn-primary">Se connecter</button>
    <a class="btn btn-link" href="register.php">Créer un compte</a>
  </form>
</div>
<?php require_once("../../views/footer.php"); ?>
</body>
</html>

