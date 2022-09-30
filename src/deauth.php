<?php
      $database = new SQLite3('db/db.sqlite');
      $query = "DELETE FROM parkdata";
      $stm = $database->prepare($query);
      $res = $stm->execute();
      $database->close();
      header('Location: cars.php');
?>