<?php
    include("initdb.php");
    $query = "SELECT * FROM parkdata";
    $stm = $database->prepare($query);
    $res = $stm->execute();

    $row = $res->fetchArray((SQLITE3_NUM));
    //echo "{$row[0]} {$row[1]} {$row[2]} {$row[3]}";
    $userId = $row[0];
    $phone = $row[1];
    $token  = $row[2];
    $refresh_token = $row[3];


 
    $ch = curl_init();

    // set URL and other appropriate options
    curl_setopt($ch, CURLOPT_URL, "https://parko.giantleap.no/permit/dynamic/products?placeId=ALL_PLACES&category=PERMIT");
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
    <form>
    <select id="products" name="products">
    <?php

    foreach ($elements as $x => $val) {

        //print_r($val);
        echo "<option value='".$val['path']."'>".$val['title']."</option>";

    }

    ?>
    </select>
    <button id="btnGetVariants" type="button" onclick="getVariants()">Select</button>
    </form>
    <?php

    curl_close($ch);


    //print_r($res);

?>