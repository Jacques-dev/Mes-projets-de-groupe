




<?php

  include('calendar/Month.php');
  include('calendar/Events.php');
  include('fonctions/fonctions.php');

  $month = new Month($_GET["month"] ?? null, $_GET["year"] ?? null);
  $start = $month->getStartedDay();
  $start = $start->format("N") === "1" ? $start : $month->getStartedDay()->modify("last monday");

  $events = new Events();
  $weeks = $month->getWeeks();
  $end = (clone $start)->modify("+".(6 + 7 * ($weeks - 1))." days");

  $events = $events->getEventsBetweenByDay($_SESSION["email"], $_SESSION["selectedProjectId"], $start, $end);

?>

<div class="calendar">

  <div class="d-flex flex-row align-items-center justify-content-between mx-lg-3">
    <h1><?= $month->toString(); ?></h1>
    <a href="php-pages/Add.php" class="calendar__button">+</a>
    <div class="">
      <a href="Home.php?month=<?= $month->previousMonth()->month ?>&year=<?= $month->previousMonth()->year ?>" class="btn btn-primary">&lt;</a>
      <a href="Home.php?month=<?= $month->nextMonth()->month ?>&year=<?= $month->nextMonth()->year ?>" class="btn btn-primary">&gt;</a>
    </div>
  </div>

  <table class="calendar__table calendar__table--<?php $month->getWeeks(); echo $month->getWeeks();?>weeks">
    <?php for ($i = 0; $i < $month->getWeeks(); $i++): ?>

      <tr>
        <?php
          foreach($month->days as $k => $day):
          $date = (clone $start)->modify("+" . ($k + $i * 7) ." days");
          $eventsForDay = $events[$date->format("Y-m-d")] ?? [];
          $isToDay = date("Y-m-d") === $date->format("Y-m-d");
        ?>
          <td class="<?= $month->withinMonth($date) ? '' : "calendar__othermonth"; ?> <?= $isToDay ? "is-today" : '' ; ?>">
            <?php if ($i === 0): ?>
              <div class="calendar__weekday"><?= $day; ?></div>
            <?php endif; ?>

            <div class="calendar__day">
              <?= $date->format("d"); ?>
              <a href="php-pages/Add.php?date=<?= $date->format("Y-m-d"); ?>" class="calendar__button2">+</a>
            </div>

            <?php foreach($eventsForDay as $event): ?>
              <?php $destination = isAllowed($event["id"]) ? "Edit.php" : "Event.php" ;?>

              <div class="calendar__event">
                <?= (new DateTime($event["debut"]))->format("H:i") ?> - <a style="color: <?= $event['validated'] == 1 ? 'green' : ''; ?>" href="php-pages/<?= $destination; ?>?id=<?= $event["id"]; ?>"><?= $event["nom"]; ?></a>
                <form action="php-pages/Edit.php" method="post">
                  <button name="eventToValidate" value="<?= $event['id']; ?>"><i class="fas fa-check-circle"></i></button>
                  <button name="eventToUnvalidate" value="<?= $event['id']; ?>"><i class="fas fa-times-circle"></i></button>
                </form>
              </div>
            <?php endforeach; ?>
          </td>
        <?php endforeach; ?>
      </tr>
    <?php endfor; ?>
  </table>

</div>
