<?php
    $plate = $_GET['plate'];
    $plate = str_replace(" ", "", $plate);
    $plate = trim($plate);

    $pattern = '/^[a-z]{2}[0-9]{5}$/';

    if (preg_match($pattern, $plate)) {

        $database = new SQLite3('/data/db.sqlite');

        $display = str_replace(" (deaktivert)","",$res['vehicleInfo']['infoString']);
        $color = $res['vehicleInfo']['color'];

        $query = "DELETE FROM cardata WHERE plate = '$plate';";

        $database->exec($query);
        $database->close();
        header('Location: cars.php');
        exit;

    } else {
        echo "Invalid plate number '$plate'";
    }
?>