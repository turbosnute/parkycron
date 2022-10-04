<?php

$plate = $_GET['inputPlate'];
$uri = $_GET['uri'];
$plate = str_replace(" ", "", $plate);
$plate = trim($plate);

$pattern = '/^[a-z]{2}[0-9]{5}$/'; // plat

if (preg_match($pattern, $plate)) {
    
    if (preg_match("/\?variantId\=(.+)$/", $uri, $matches)) {
        $variantId = $matches[1];
        // write to database.

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

        $query = "UPDATE parkdata SET plate = '$plate', agreementid = '$variantId' WHERE userId = '$userId';";
        //echo "$query";
        $database->exec($query);

        echo "<aside>Config saved</aside>";

    } else {
        echo "invalid variant id.";
    }

} else {
    echo "invalid license plate.";
}

?>