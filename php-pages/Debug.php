



<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Debug</title>
  </head>
  <body>

    <?php

      session_start();

      echo "<pre>";
      print_r($_COOKIE);
      echo "</pre>";
      echo "<pre>";
      print_r($_SESSION);
      echo "</pre>";

    ?>

    <a href="../Home.php"></a>

  </body>
</html>
