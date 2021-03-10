

<div class="row">
  <div class="col-lg-12">

    <form action="fonctions/ProjectQueries.php" method="post" id="createProject">
      Créer un projet
      <div class="form__group field">
        <input type="input" class="form__field" placeholder="Nom du projet" name="nomProjet" id='nomProjet' required />
        <label for="nomProjet" class="form__label">Nom du projet</label>
      </div>
      <button class="custom-btn btn-1" type='submit' name='submitProject'><span>Créer <i class="far fa-plus-square"></i></span></button>
    </form>
  </div>
</div>


<div class="row">
  <div class="col-lg-12">
    Mes projets
    <?php
      $profil = $_SESSION['email'];
      $sql = "SELECT id, nom FROM Projet WHERE manager = '$profil'";
      $result = $con->query($sql);

      while($row = $result->fetch_assoc()) {
        $projectId = $row["id"];
        ?>
        <form action='fonctions/ProjectQueries.php' method='post'>
          <button class="custom-btn btn-1" type='submit' name='submitSelectProject' value=<?= $projectId; ?>><span><?= $row['nom']; ?> <i class="fas fa-search"></i></span></button>
          <button class="custom-btn btn-1" type='submit' name='submitDeleteProject' value=<?= $projectId; ?>><span><i class='fas fa-trash'></i></span></button>
        </form>
        <?php
      }
    ?>
    <br>------------------------------------------------------------------------------
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    Mes projets partagés
    <?php
      $profil = $_SESSION['email'];
      $sql = "SELECT id, nom, manager FROM Projet NATURAL JOIN Participe WHERE Participe.email = '$profil'";
      $result = $con->query($sql);

      while($row = $result->fetch_assoc()) {
        $projectId = $row["id"];
        ?>
        <form action='fonctions/ProjectQueries.php' method='post'>
          <button class="custom-btn btn-1" type='submit' name='submitSelectProject' value=<?= $projectId; ?>><span><?= $row['nom']; ?> <i class="fas fa-search"></i></span></button>
          <button class="custom-btn btn-1" type='submit' name='submitDeleteProject' value=<?= $projectId; ?>><span><i class='fas fa-trash'></i></span></button>
        </form>
        <?php
      }
    ?>
  </div>
</div>
