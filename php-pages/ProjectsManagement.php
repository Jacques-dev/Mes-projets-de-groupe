
<?php
  include("../BDD/Connexion.php");
  include("../fonctions/fonctions.php");
  session_start();
?>

<div class="row">

  <div class="col-lg-12">
    <?php
      echo "<br>Projet sélectionné : ".$_SESSION["selectedProjectName"];
    ?>
  </div>
</div>

<?php
  if (checkIfIsManager($_SESSION["selectedProjectId"], $_SESSION['email']) == 1) { ?>
  <div class="row">
    <div class="col-lg-12">
      <form action="fonctions/ProjectQueries.php" method="post">
        Ajouter des collègues
        <br>
        <div class="form__group field">
          <input type="input" class="form__field" placeholder="Email" name="emailCollegue" id='emailCollegue' required />
          <label for="emailCollegue" class="form__label">Email</label>
        </div>
        <button class="custom-btn btn-1" type='submit' name='submitCollegue'><span>Ajouter <i class="far fa-plus-square"></i></span></button>
      </form>
    </div>
  </div>
<?php } ?>

<div class="row">
  <div class="col-lg-12">
    <?php

      $sql = "SELECT role FROM Role ORDER BY role = 'Pas de rôle' DESC";
      $result = $con->query($sql);
      $options = [];

      while($row = $result->fetch_assoc()) {
        array_push($options, $row["role"]);
      }


      echo "Manager: ".$_SESSION["projectManager"]."<br>";

      $projectId = $_SESSION["selectedProjectId"];
      $sql = "SELECT email, role FROM Participe WHERE id = '$projectId'";
      $result = $con->query($sql);

      while($row = $result->fetch_assoc()) {
        $email = $row["email"];
        $role = $row["role"];
        ?>
        <form action='fonctions/ProjectQueries.php' method='post' id="collegueManagement">
          Collègues: <?= $email; ?>
          <?php if (checkIfIsManager($_SESSION["selectedProjectId"], $_SESSION['email']) == 1) { ?>
            <button type='submit' name='submitDeleteCollegue' value='$email' class='deleteProject'><i class='fas fa-trash'></i></button>
          <?php } ?>

          <select name="roleSelection" onchange="changeRole()">
              <option selected disabled><?= $role; ?></option>
            <?php foreach ($options as $option) { ?>
              <?php $val = $option."-".$email."-".$_SESSION["selectedProjectId"]; ?>
              <option value="<?= $val; ?>"><?= $option; ?></option>
            <?php } ?>
          </select>
        </form>
    <?php } ?>
  </div>
</div>
