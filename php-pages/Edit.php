
<?php

include("../calendar/EventValidator.php");
include("../calendar/Event.php");
include("../calendar/Events.php");
include('../fonctions/fonctions.php');

  if (isset($_POST["eventToValidate"]) || isset($_POST["eventToUnvalidate"])) {
    include("../BDD/Connexion.php");
    $sql = $con->prepare("UPDATE Evenement SET validated = ? WHERE id = ?");
    $sql->bind_param('ii', $validated, $id);

    if (isset($_POST["eventToValidate"])) {
      $validated = 1;
      $id = $_POST["eventToValidate"];
    } else {
      $validated = 0;
      $id = $_POST["eventToUnvalidate"];
    }

    $sql->execute();
    header('Location: ../Home.php');
    exit();
  }


  session_start();

  $events = new Events();
  $errors = [];

  if (!isset($_GET["id"])) {
    header('Location: 404.php');
  }

  $event = $events->find($_GET["id"]);

  $data = [
    "name-event"               => $event->getName(),
    "date-event"               => $event->getStart()->format("Y-m-d"),
    "start-event"              => $event->getStart()->format("H:i"),
    "end-event"                => $event->getEnd()->format("H:i"),
    "description-event"        => $event->getDescription(),
    "loop-event"               => $event->getLoop(),
    "endLoop-event"            => $event->getEndLoop()->format("Y-m-d")
  ];

  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = $_POST;

    if (!$_POST["loopCheck-event"]) {
      $data["loopCheck-event"] = "";
      $data["loop-event"] = "";
      $data["endLoop-event"] = "";
    }

    $validator = new EventValidator();
    $errors = $validator->validates($data);

    if (empty($errors)) {

      $event = $events->hydrate($event, $data);

      $events->update($event);

      $popupResult = array("type" => "success", "title" => "Validé", "message" => "Évênement modifié.", "time" => 1000);

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
  <body onload="eventCheckbox()">

    <div class="container">

      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
          Merci de bien vouloir corriger vos erreurs.
        </div>
      <?php endif; ?>

      <h1>Editer l'évênement <small><?= $event->getName(); ?></small></h1>

      <form action="" method="post" class="form-event">

        <?php render("Form", ["data" => $data, "errors" => $errors]); ?>

        <div class="form-event-group">
          <button class="btn btn-primary">Modifier l'évênement</button>
        </div>

      </form>
      <form action="Delete.php?id=<?= $_GET["id"]; ?>" method="post" class="form-event">

        <div class="form-event-group">
          <button class="btn btn-primary">Supprimer l'évênement</button>
        </div>

      </form>
      <a href="../Home.php">Annuler</a>

    </div>

    <script src="../js/app.js"></script>

  </body>
</html>
