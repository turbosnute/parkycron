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

 
    $uri = $_GET['uri'];

    //echo "URI: $uri<br /><br />";

    $ch = curl_init();

    // set URL and other appropriate options
    curl_setopt($ch, CURLOPT_URL, "https://parko.giantleap.no$uri");
    curl_setopt($ch, CURLOPT_HEADER, 0);

    // Load token

    /*
        Config
    */
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
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

    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, $config['useragent']);

    $res = json_decode(curl_exec($ch), true);

    $elements = $res['sections'][0]['elements'];
    echo "<h2>Choose Variant</h2>";
    ?>
    <table>
    <?php
        $i = 0;
        foreach ($elements as $x => $val) {
            if ($i == 0) {
                $checked = "checked";
            } else {
                $checked = "";
            }
            //print_r($val);
            echo "<tr>";
            echo "<td><input type='radio' id='radio".$i."' name='variant' value='".$val['path']."' $checked></td>";
            echo "<td><strong>".$val['title']."</strong><br />";
            if (isset($val['subtitle'])) {
                echo $val['subtitle']."<br />";
            }
            echo "Free spaces: ".$val['availability']['itemsInStock'];
            echo "</td>";
            echo "</tr>";
            $i++;
        }
    ?>
    </table>
    <?php

    // check if user has defined cars
    $query = "SELECT COUNT(*) as count FROM cardata;";

    $stm = $database->prepare($query);
    $res = $stm->execute();
    
    $row = $res->fetchArray(SQLITE3_NUM);
    $numRows = $row[0];

    //echo "NUMROWS: $numRows";

    if ($numRows > 0) {
        $query = "SELECT * FROM cardata";
        $stm = $database->prepare($query);
        $res = $stm->execute();
        $i = 0;
        echo "<h2>Choose Car</h2>";
        echo "<table>";
        while ($row = $res->fetchArray(SQLITE3_NUM)) {
            echo "<tr>";
            echo "<td><input type='radio' id='car".$i."' name='car' value='".$row[0]."' $checked></td>";
            echo "<td><strong>".$row[0]."</strong></td><td>".$row[1]."</td><td>".$row[2]."</td>";
            echo "</tr>";
            $i++;
        }
        echo "</table>";

    } else {
        // if not add input to add car
        echo "<p>You have no cars added.</p><br /><a href='cars.php'>Add Car</a>";

    }
    echo "<p><button id='btnSaveConfig' type='button' onclick='saveConfig()'>Save Config</button></p>";

    curl_close($ch);



    $database->close();

    //print_r($res);

?>