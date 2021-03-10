
<?php

  include("../calendar/EventValidator.php");
  include("../calendar/Event.php");
  include("../calendar/Events.php");
  include('../fonctions/fonctions.php');
  session_start();

  $events = new Events();

  if (!isset($_GET["id"])) {
    header('Location: 404.php');
  }

  $event = $events->find($_GET["id"]);

  $events->delete($event);

  $popupResult = array("type" => "success", "title" => "Validé", "message" => "Évênement supprimé.", "time" => 1000);

  $_SESSION["popupResult"] = $popupResult;
  header('Location: ../Home.php');
  exit();

?>
