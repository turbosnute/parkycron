<?php
    $plate = $_GET['inputPlate'];
    $plate = str_replace(" ", "", $plate);
    $plate = trim($plate);

    $pattern = '/^[a-z]{2}[0-9]{5}$/';

    if (preg_match($pattern, $plate)) {

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

        // create a new cURL resource
        $ch = curl_init();

        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, "https://parko.giantleap.no/vehicle/lookup?regNo=$plate");
        curl_setopt($ch, CURLOPT_HEADER, 0);

        /*
            Config
        */
        $config['useragent'] = 'Android/Cardboard(trondheimparkering-4.9.13)/1.3.28';

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'x-gltlocale: en_US_trondheimparkering',
            'x-partnerid: trondheimparkering',
            'accept-encoding: gzip',
            'user-agent: Android/Cardboard(trondheimparkering-4.9.13)/1.3.28',
            'content-type: application/json;charset=UTF-8',
            'host: parko.giantleap.no',
            "x-token: $token"
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $config['useragent']);

        $res = json_decode(curl_exec($ch), true);


        if (curl_error($ch)) {
            echo curl_error($ch);
        }

        if ($res['resultCode'] == 'SUCCESS') {
            $display = str_replace(" (deaktivert)","",$res['vehicleInfo']['infoString']);
            $color = $res['vehicleInfo']['color'];
            //echo "<p>$display ($color)</p>";

            $query = "INSERT OR REPLACE INTO cardata('plate', 'displayname', 'color') VALUES ('$plate', '$display', '$color');";
            //echo "$query";
            $database->exec($query);
            $database->close();
            header('Location: cars.php');
            exit;

        } else {
            "Non successful result from API";
        }

        $database->close();

    } else {
        echo "Invalid plate number '$plate'";
    }
?>