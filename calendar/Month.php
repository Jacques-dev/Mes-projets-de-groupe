

<?php

  class Month {

    public $days = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];

    private $months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
    "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
    public $month;
    public $year;

    public function __construct (?int $month = null, ?int $year = null) {
      if ($month === null || $month < 1 || $month > 12) {
        $month = intval(date("m"));
      }
      if ($year === null) {
        $year = intval(date("Y"));
      }
      $this->month = $month;
      $this->year = $year;
    }
    // renvoi le premier jours du mois
    public function getStartedDay (): DateTime {
      return new DateTime("{$this->year}-{$this->month}-01");
    }

    public function toString (): string {
      return $this->months[$this->month -1]." ".$this->year;
    }

    public function getWeeks (): int {
      $start = $this->getStartedDay();
      $end = (clone $start)->modify("+1 month -1 day");

      if ((intval(date('t', strtotime($start->format("Y-m-d")))) % 7) === 3) {
        $end = (clone $start)->modify("+1 month");
      }

      $startWeek = intval($start->format("W"));
      $endWeek = intval((clone $end)->format("W"));

      if ($endWeek === 1) {
        $endWeek = intval((clone $end)->modify("- 7 days")->format("W")) + 1;
      }

      $weeks = $endWeek - $startWeek + 1;
      if ($weeks < 0) {
        $weeks = intval($end->format("W"));
      }
      return $weeks;
    }

    public function withinMonth (DateTime $date): bool {
      return $this->getStartedDay()->format("Y-m") === $date->format("Y-m");
    }

    public function nextMonth (): Month {
      $month = $this->month + 1;
      $year = $this->year;

      if ($month > 12) {
        $month = 1;
        $year += 1;
      }
      return new Month($month, $year);
    }

    public function previousMonth (): Month {
      $month = $this->month - 1;
      $year = $this->year;

      if ($month < 1) {
        $month = 12;
        $year -= 1;
      }
      return new Month($month, $year);
    }

  }

?>
