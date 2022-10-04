<?php
   $database = new SQLite3('/data/db.sqlite');
   $query = "SELECT * FROM parkdata";
   $stm = $database->prepare($query);
   $res = $stm->execute();

   $row = $res->fetchArray((SQLITE3_NUM));
   //echo "{$row[0]} {$row[1]} {$row[2]} {$row[3]}";
   $userId = $row[0];
   $phone = $row[1];
   $token  = $row[2];
   $refresh_token = $row[3];


   $database->close();

?>