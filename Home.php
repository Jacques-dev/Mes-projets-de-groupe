
<?php
  include("BDD/Connexion.php");

  session_start();

  if (isset($_SESSION["cookie"])) {
    $emailCookie = $_SESSION["cookie"][0];
    $passwordCookie = $_SESSION["cookie"][1];
    $timeCookie = $_SESSION["cookie"][2];

    $array = array($emailCookie, $passwordCookie, $timeCookie);
    $values = implode(",", $array);

    setcookie("RememberMe", $values, time() + 60 * 60 * 24 * 365);
    unset($_SESSION["cookie"]);
    // header('Location: '.$_SERVER['PHP_SELF']);
    if ($_SESSION["cookiechecked"] === false) {
      header('Location: fonctions/CheckCookie.php');
    }
  }



  if (isset($_SESSION["logout"])) {
    unset($_COOKIE["RememberMe"]);
    setcookie("RememberMe", "", time() - 3600);
    unset($_SESSION["logout"]);
  }

?>

<!DOCTYPE html>
<html lang="fr">
  <head>

    <?php include("php-pages/Header.php"); ?>
    <!-- Main css -->
    <link rel="stylesheet" href="css/Main.css">
    <link rel="stylesheet" href="css/Calendar.css">
    <link rel="stylesheet" href="css/Button.css">

  </head>
  <body>
    <?php
      include("php-pages/LoginForm.php");
      include("php-pages/RegisterForm.php");
    ?>

    <a href="php-pages/Debug.php" id="debuger">debuger</a>

    <?php
    if (isset($_SESSION["popupResult"])) {
      $type = $_SESSION["popupResult"]["type"];
      $title = $_SESSION["popupResult"]["title"];
      $message = $_SESSION["popupResult"]["message"];
      $time = isset($_SESSION["popupResult"]["time"]) ? $_SESSION["popupResult"]["time"] : 2000;
      ?>
      <script type="text/javascript">
        asAlertMsg({
          type: "<?= $type ?>",
          title: "<?= $title ?>",
          message: "<?= $message ?>",
          timer: <?= $time ?>
        })
        setTimeout(function() {
          <?php unset($_SESSION["popupResult"]); ?>
        }, 2000);
      </script>
    <?php } ?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12" align="center" id="head-column">
          Mes Projets De Groupe<br>
          <?php
            echo $_SESSION["email"];
          ?>
        </div>
      </div>

      <?php if (isset($_SESSION["email"])) { ?>
        <div class="row">
          <div class="col-lg-2" id="left-column">
            <?php include("php-pages/ProjectsForm.php"); ?>
          </div>

          <div class="col-lg-8" id="middle-column">
            <?php include("php-pages/Calendar.php"); ?>
          </div>

          <?php if (isset($_SESSION["selectedProjectId"])) {?>
            <div class="col-lg-2" id="right-column">
              <?php include("php-pages/ProjectsManagement.php"); ?>
            </div>
          <?php } ?>
        </div>

      <?php } ?>
    </div>



    <script src="js/app.js"></script>

  </body>
</html>
