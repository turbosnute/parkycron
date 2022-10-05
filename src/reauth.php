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

    
    $ch = curl_init();

    // set URL and other appropriate options
    curl_setopt($ch, CURLOPT_URL, "https://parko.giantleap.no/client/reauth");
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

    $data = array(
        "clientIdentifier " => '',
        "refreshToken" => $refresh_token
    );

    echo "<hr>";
    
    print_r($data);

    echo "<hr>";
    //$data_string = json_encode($data);    

    $data_string = "{
        \"refreshToken\": \"$refresh_token\",
        \"clientIdentifier\": \"SNWKJJSP7NZ4J1DY\"
      }";

    echo "<hr>";
    echo "$data_string<hr>";

    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    $res = json_decode(curl_exec($ch), true);

    print_r($res);

    curl_close($ch);

?>
