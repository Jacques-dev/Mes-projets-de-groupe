<?php
  $sql = "DELETE FROM Profil WHERE email = 'jacques.tellier@efrei.net'";
  $con->query($sql);

  $sql = "UPDATE Profil SET email = 'jacques.tellier@efrei.net' WHERE email = 'jacques.tellier@hotmail.com'";
  $con->query($sql);
?>
