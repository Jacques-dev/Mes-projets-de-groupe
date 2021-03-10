


<?php
  session_start();

  include("../BDD/Connexion.php");
  include('fonctions.php');

  if (isset($_POST["submitProject"])) {
    if (!empty($_POST["nomProjet"])) {

      $sql = $con->prepare("INSERT INTO Projet (nom, manager) VALUES (?, ?)");
      $sql->bind_param('ss', $nom, $email);

      $nom = $_POST['nomProjet'];
      $email = $_SESSION['email'];

      $sql->execute();

    }
  }

  if (isset($_POST["submitCollegue"])) {
    if (!empty($_POST["emailCollegue"])) {

      if (check_email_address($_POST["emailCollegue"]) == true) {
        $email = $_POST["emailCollegue"];
        $id = $_SESSION["selectedProjectName"];

        $sqlTest = "SELECT * FROM Participe WHERE email = '$email' AND id = '$id'";
        $result = $con->query($sqlTest);

        if ($result->num_rows === 0) {

          $sql = $con->prepare("INSERT INTO Participe (id, email) VALUES (?, ?)");
          $sql->bind_param('ss', $id, $email);

          $id = $_SESSION["selectedProjectId"];
          $email = $_POST['emailCollegue'];

          $sql->execute();
          $popupcontent = array("type" => "success", "title" => "Validé", "message" => "Collègue ajouté.", "time" => 1000);

        } else {
          $popupcontent = array("type" => "warning", "title" => "Attention", "message" => "Ce collègue existe déjà.");
        }

      } else {
        $popupcontent = array("type" => "warning", "title" => "Attention", "message" => "Cette adresse mail n'est pas valide.");
      }

    }
  }

  if (isset($_POST["submitDeleteCollegue"])) {
    $collegue = $_POST["submitDeleteCollegue"];
    $sql = "DELETE FROM Participe WHERE email = '$collegue'";
    $con->query($sql);
  }

  if (isset($_POST["roleSelection"])) {
    $role = explode("-", $_POST["roleSelection"])[0];
    $email = explode("-", $_POST["roleSelection"])[1];
    $id = explode("-", $_POST["roleSelection"])[2];

    $sql = "UPDATE Participe SET role = '$role' WHERE email = '$email' AND id = '$id'";
    $con->query($sql);
  }

  if (isset($_POST['submitSelectProject'])) {

    $profil = $_SESSION['email'];
    $idProject = $_POST['submitSelectProject'];

    $sql = "SELECT nom, manager FROM Projet WHERE id = '$idProject'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();

    $_SESSION["projectManager"] = $row["manager"];
    $_SESSION["selectedProjectName"] = $row["nom"];
    $_SESSION["selectedProjectId"] = $idProject;
  }

  if (isset($_POST['submitDeleteProject'])) {

    $idProject = $_POST['submitDeleteProject'];

    $sql = "DELETE FROM Projet WHERE id = '$idProject'";
    $result = $con->query($sql);

    $popupResult = array("type" => "success", "title" => "Validé", "message" => "Projet Supprimé", "time" => 1000);
    $_SESSION["popupResult"] = $popupResult;
  }

  if (isset($_POST['submitDeleteSharedProject'])) {
    $idProject = $_POST['submitDeleteProject'];

    $email = $_SESSION["email"];
    $sql = "DELETE FROM Participe WHERE email = '$email' AND id = '$idProject'";
    $result = $con->query($sql);

    $popupResult = array("type" => "success", "title" => "Validé", "message" => "Projet Supprimé", "time" => 1000);
    $_SESSION["popupResult"] = $popupResult;
  }


  $_SESSION["error"] = $popupcontent;
  header('Location: ../Home.php');
  exit();

?>
