<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Contact</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php require_once("../views/navbar.php"); ?>

<div class="container mt-5" style="max-width: 800px;">
  <h1>Contact</h1>

  <div class="card shadow mt-4">
    <div class="card-body">
      <p><strong>Vite & Gourmand</strong> — Bordeaux</p>
      <p>Email : contact@vite-gourmand.fr</p>

      <hr>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Nom</label>
          <input class="form-control" name="nom">
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input class="form-control" name="email" type="email">
        </div>

        <div class="mb-3">
          <label class="form-label">Message</label>
          <textarea class="form-control" name="message" rows="4"></textarea>
        </div>

        <button class="btn btn-primary" type="button">Envoyer</button>
        <small class="text-muted d-block mt-2">Formulaire non connecté (démo TP).</small>
      </form>
    </div>
  </div>
</div>

<?php require_once("../views/footer.php"); ?>
</body>
</html>
