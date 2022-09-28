<?php
    $database = new SQLite3('db/db.sqlite');
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

    echo "URI: $uri<br /><br />";

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
    ?>
    <table>
    <?php
    foreach ($elements as $x => $val) {
        print_r($val);
        echo "<tr>";
        echo "<td><input type='radio' id='whatever' name='variant' value='".$val['path']."'></td>";
        echo "<td><strong>".$val['title']."</strong><br />";
        if (isset($val['subtitle'])) {
            echo $val['subtitle']."<br />";
        }
        echo "Free spaces: ".$val['availability']['itemsInStock'];
        echo "</td>";
        echo "</tr>";
    }
    ?>
    </table>
    <?php

    curl_close($ch);


    //print_r($res);

?>