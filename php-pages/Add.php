

<?php

  include("../calendar/EventValidator.php");
  include("../calendar/Event.php");
  include("../calendar/Events.php");
  include('../fonctions/fonctions.php');
  session_start();

  $data = [
    "date-event" => $_GET["date"] ?? null,
    "start-event" => date("H:i"),
    "end-event" => date("H:i")
  ];

  $testDate = new Validator($data);

  if (!$testDate->validate("date-event", "date")) {
    $data["date-event"] = date("Y-m-d");
  }
  if (!$testDate->validate("endLoop-event", "date")) {
    $data["endLoop-event"] = date('Y-m-d', strtotime('+1 month'));
  }

  $errors = [];

  if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $validator = new EventValidator();
    $errors = $validator->validateAll($_POST);

    $data = $_POST;

    if (empty($errors)) {

      $events = new Events();
      $event = $events->hydrate(new Event(), $data);
      $events->create($event);
      $popupResult = array("type" => "success", "title" => "Validé", "message" => "Évênement enregistré.", "time" => 1000);
      $_SESSION["popupResult"] = $popupResult;
      header('Location: ../Home.php');
      exit();
    }
  }
?>

<!DOCTYPE html>
<html lang="fr">
  <head>

    <?php include("Header.php"); ?>
    <!-- Main css -->
    <link rel="stylesheet" href="../css/Main.css">
    <link rel="stylesheet" href="../css/Calendar.css">

  </head>
  <body>

    <div class="container">

      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
          Merci de bien vouloir corriger vos erreurs.
        </div>
      <?php endif; ?>

      <h1>Ajouter un évênement</h1>

      <form action="" method="post" class="form-event">

        <?php render("Form", ["data" => $data, "errors" => $errors]); ?>

        <div class="form-event-group">
          <button class="btn btn-primary">Ajouter l'évênement</button>
        </div>

      </form>
      <a href="../Home.php">Annuler</a>
    </div>

    <script src="../js/app.js"></script>

  </body>
</html>
