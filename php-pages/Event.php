
<?php
  include("../calendar/Event.php");
  include('../calendar/Events.php');
  include('../fonctions/fonctions.php');

  $events = new Events();
  if (!isset($_GET["id"])) {
    header('Location: 404.php');
  }

  $event = $events->find($_GET["id"]);

?>

<h1><?= $event->getName(); ?></h1>

<ul>
  <li>Date: <?= $event->getStart()->format("d/m/Y"); ?></li>
  <li>Heure de démarrage: <?= $event->getStart()->format("H:i"); ?></li>
  <li>Heure de fin: <?= $event->getEnd()->format("H:i"); ?></li>
  <li>Description:<br>
    <?= $event->getDescription(); ?>
  </li>
</ul>
