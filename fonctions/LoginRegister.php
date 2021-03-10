

<?php
  session_start();

  include("../BDD/Connexion.php");
  include('fonctions.php');


  if (isset($_POST["submitConnexion"])) {

    if (!empty($_POST["email"]) && !empty($_POST["password"])) {

      if (check_email_address($_POST['email']) == true) {

        $email = $_POST['email'];
        $sql = "SELECT password FROM Profil WHERE email = '$email'";
        $result = $con->query($sql);
        $row = $result->fetch_assoc();

        if ($result->num_rows == 1) {

          $decrypted_txt = encrypt_decrypt('decrypt', $row['password']);

          if ($decrypted_txt == $_POST['password']) {

            $_SESSION["email"] = $_POST["email"];
            $popupResult = array("type" => "success", "title" => "Validé", "message" => "Vous êtes connecté.", "time" => 1000);

            if (isset($_POST["remember"])) {
              $time = time()*60*60*24*365;  //STOCKS 1 YEAR IN THE VAR
              $_SESSION["cookie"] = array($email, $row['password'], $time);
            }

          } else {
            $popupResult = array("type" => "warning", "title" => "Attention", "message" => "Mot de passe incorrect.");
          }

        } else {
          $popupResult = array("type" => "warning", "title" => "Attention", "message" => "Cette adresse mail n'existe pas.");
        }

      } else {
       $popupResult = array("type" => "warning", "title" => "Attention", "message" => "Cette adresse mail n'est pas valide.");
     }

    } else {
      $popupResult = array("type" => "warning", "title" => "Attention", "message" => "Veuillez remplir tous les champs.");
    }

  }

  if (isset($_POST['submitRegister'])) {

    if (!empty($_POST["email"]) && !empty($_POST["password"])) {

      if (check_email_address($_POST["email"]) == true) {
        $sql = $con->prepare("INSERT INTO Profil (email, password) VALUES (?, ?)");
        $sql->bind_param('ss', $email, $encrypted_txt);

        $encrypted_txt = encrypt_decrypt('encrypt', $_POST['password']);
        $email = $_POST['email'];

        $sqlTest = "SELECT * FROM Profil WHERE email = '".$email."'";
        $result = $con->query($sqlTest);

        if ($result->num_rows == 0) {
          $sql->execute();
          $popupResult = array("type" => "success", "title" => "Validé", "message" => "Vous êtes enregistré.", "time" => 1000);
        } else {
          $popupResult = array("type" => "warning", "title" => "Attention", "message" => "Ce compte existe déjà.");
        }

      } else {
        $popupResult = array("type" => "warning", "title" => "Attention", "message" => "Cette adresse mail n'est pas valide.");
      }

    } else {
      $popupResult = array("type" => "warning", "title" => "Attention", "message" => "Veuillez entrer un email et un mot de passe.");
    }

  }

  $_SESSION["popupResult"] = $popupResult;

  if (isset($_POST['logout'])) {
    if (isset($_SESSION["email"])) {
      session_destroy();
      session_start();
      $_SESSION["logout"] = true;
    }
  }


  header('Location: ../Home.php');
  exit();
?>
