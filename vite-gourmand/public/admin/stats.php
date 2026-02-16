<?php
session_start();

if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
    die("Accès interdit");
}

require_once("../../config/mongo_native.php");

// Agrégation: count par menu_titre
$pipeline = [
    ['$group' => ['_id' => '$menu_titre', 'count' => ['$sum' => 1]]],
    ['$sort' => ['count' => -1]],
];

$command = new MongoDB\Driver\Command([
    'aggregate' => $mongoCollection,
    'pipeline' => $pipeline,
    'cursor' => new stdClass
]);

$cursor = $mongoManager->executeCommand($mongoDbName, $command);

$labels = [];
$values = [];
foreach ($cursor as $doc) {
    $labels[] = $doc->_id;
    $values[] = $doc->count;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin - Statistiques</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 900px;">
  <h1>Admin - Statistiques (MongoDB)</h1>

  <div class="card shadow mt-4">
    <div class="card-body">
      <h4>Nombre de commandes par menu</h4>
      <canvas id="chart"></canvas>
    </div>
  </div>
</div>

<script>
const labels = <?= json_encode($labels); ?>;
const values = <?= json_encode($values); ?>;

new Chart(document.getElementById('chart'), {
  type: 'bar',
  data: {
    labels: labels,
    datasets: [{
      label: "Commandes",
      data: values
    }]
  }
});
</script>
<?php require_once("../../views/footer.php"); ?>
</body>
</html>
