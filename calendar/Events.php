

<?php

  class Events {

    public function getEventsBetween (string $profil, string $projet, DateTime $start, DateTime $end):array {
      include("BDD/Connexion.php");
      $sql = "SELECT DISTINCT e.* FROM Evenement e INNER JOIN Participe p WHERE e.id_projet = p.id AND (p.email = '$profil' OR e.email_profil = '$profil') AND e.id_projet = '$projet' AND
      e.debut BETWEEN '{$start->format("Y-m-d 00:00:00")}' AND '{$end->format("Y-m-d 23:59:59")}'
      ORDER BY e.debut ASC";
      $result = $con->query($sql);
      $results = [];

      while ($row = $result->fetch_assoc()) {
        $tab = array();
        $tab["id"] = $row["id"];
        $tab["nom"] = $row["nom"];
        $tab["description"] = $row["description"];
        $tab["debut"] = $row["debut"];
        $tab["fin"] = $row["fin"];
        $tab["jour_recurrent"] = $row["jour_recurrent"];
        $tab["fin_jour_recurrent"] = $row["fin_jour_recurrent"];
        $tab["validated"] = $row["validated"];
        array_push($results, $tab);
      }

      return $results;
    }

    public function getEventsBetweenByDay (string $profil, string $projet, DateTime $start, DateTime $end):array {
      $events = $this->getEventsBetween($profil, $projet, $start, $end);
      $days = [];
      $days_in_week = array(
        'Monday' => 'Lundi',
        'Tuesday' => 'Mardi',
        'Wednesday' => 'Mercredi',
        'Thursday' => 'Jeudi',
        'Friday' => 'Vendredi',
        'Saturday' => 'Samedi',
        'Sunday' => 'Dimanche'
      );

      foreach ($events as $event) {

        $date = explode(' ', $event["debut"])[0];

        if ($event["jour_recurrent"] != "" || $event["jour_recurrent"] != null) {

          function eachDate ($start, $end) {
            $exp = explode('-', $start);
            $exp2 = explode('-', $end);
            $DateDepart = strtotime($exp[0].'-'.$exp[1].'-'.$exp[2]);
            $DateFin = strtotime($exp2[0].'-'.$exp2[1].'-'.$exp2[2]);
            $NombreSecondes = $DateFin - $DateDepart;
            $NombreJours = $NombreSecondes / (3600*24);
            $ToutesDates = array();
            for($i = 0; $i < $NombreJours+1; $i++) {
              $truc = date('Y-m-d', $DateDepart+((3600*24)*$i));
              array_push($ToutesDates, $truc);
            }
            return $ToutesDates;
          }

          foreach(eachDate($date, $event["fin_jour_recurrent"]) as $d) {

            $jour = $days_in_week[date("l", strtotime($d))];

            if ($event["jour_recurrent"] === $jour) {
              if (!isset($days[$d])) {
                $days[$d] = [$event];
              } else {
                $days[$d][] = $event;
              }
            }

          }

        } else {
          if (!isset($days[$date])) {
            $days[$date] = [$event];
          } else {
            $days[$date][] = $event;
          }
        }

      }

      return $days;
    }

    public function find ($id) {
      include("../BDD/Connexion.php");

      $sql = "SELECT * FROM Evenement WHERE id = $id";
      $result = $con->query($sql);

      if ($result->num_rows === 1) {
        $event = $result->fetch_object("Event");

        return $event;
      } else {
        header('Location: ../php-pages/404.php');
      }
    }

    public function hydrate (Event $event, array $data) {
      $event->setName($data["name-event"]);
      $event->setDescription($data["description-event"]);
      $event->setStart(DateTime::createFromFormat('Y-m-d H:i', $data['date-event'] . ' ' . $data['start-event'])->format('Y-m-d H:i:s'));
      $event->setEnd(DateTime::createFromFormat('Y-m-d H:i', $data['date-event'] . ' ' . $data['end-event'])->format('Y-m-d H:i:s'));
      $event->setLoop($data["loop-event"]);
      $event->setEndLoop($data['endLoop-event']);
      $event->setValidateEvent();
      return $event;
    }

    public function create (Event $event) {
      include("../BDD/Connexion.php");
      session_start();

      $sql = $con->prepare("INSERT INTO Evenement (nom, description, debut, fin, jour_recurrent, fin_jour_recurrent, email_profil, id_projet, validated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

      $sql->bind_param('ssssssssi', $nom, $description, $debut, $fin, $jour_recurrent, $fin_jour_recurrent, $email_profil, $id_projet, $validated);

      $nom = $event->getName();
      $description = $event->getDescription();
      $debut = $event->getStart()->format("Y-m-d H:i:s");
      $fin = $event->getEnd()->format("Y-m-d H:i:s");
      $jour_recurrent = $event->getLoop();
      $fin_jour_recurrent = $event->getEndLoop()->format("Y-m-d");
      $email_profil = $_SESSION["email"];
      $id_projet = $_SESSION["selectedProjectId"];
      $validated = $event->isValidated();

      show($sql);
      show($fin_jour_recurrent);

      $sql->execute();
    }

    public function update (Event $event) {
      include("../BDD/Connexion.php");

      $sql = $con->prepare("UPDATE Evenement SET nom = ?, description = ?, debut = ?, fin = ?, jour_recurrent = ?, fin_jour_recurrent = ? WHERE id = ?");
      $sql->bind_param('ssssssi', $nom, $description, $debut, $fin, $jour_recurrent, $fin_jour_recurrent, $id);

      $nom = $event->getName();
      $description = $event->getDescription();
      $debut = $event->getStart()->format("Y-m-d H:i:s");
      $fin = $event->getEnd()->format("Y-m-d H:i:s");
      $jour_recurrent = $event->getLoop();
      $fin_jour_recurrent = $event->getEndLoop()->format("Y-m-d");
      $id = $event->getId();

      $sql->execute();
    }

    public function delete (Event $event) {
      include("../BDD/Connexion.php");

      $sql = $con->prepare("DELETE FROM Evenement WHERE id = ?");
      $sql->bind_param('i', $id);

      $id = $event->getId();

      $sql->execute();
    }

  }

?>
