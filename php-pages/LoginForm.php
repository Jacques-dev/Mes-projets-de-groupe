


<?php
  if (isset($_SESSION["email"])) {
?>
  <form action="fonctions/LoginRegister.php" method="post" id="LoginRegisterButton">
    <button type="submit" class="popupLoginLogoutButton" name="logout">logout</button>
  </form>
<?php
  } else {
?>
  <button type="button" class="popupLoginLogoutButton" onclick="popupLogin()">Login</button>
  <button type="button" class="popupRegisterButton" onclick="popupRegister()">Register</button>
<?php
  }
?>


<form action="fonctions/LoginRegister.php" method="post" id="popupLogin">
  Se connecter<br>
  <input type="text" name="email" placeholder="email"><br>
  <input type="password" name="password" placeholder="mot de passe"><br>
  <input type="checkbox" name="remember" id="remember">
  <label for="remember">Se souvenir de moi</label><br>

  <button type="submit" name="submitConnexion">Se connecter</button>

  <button type="submit">Annuler</button>
</form>
