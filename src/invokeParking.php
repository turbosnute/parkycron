<?php

$plate = $_GET['inputPlate'];
$uri = $_GET['uri'];
$plate = str_replace(" ", "", $plate);
$plate = trim($plate);

$pattern = '/^[a-z]{2}[0-9]{5}$/'; // plat

if (preg_match($pattern, $plate)) {
    $ch = curl_init();

    // set URL and other appropriate options
    curl_setopt($ch, CURLOPT_URL, "https://parko.giantleap.no$uri");
    curl_setopt($ch, CURLOPT_HEADER, 0);

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


    $today = date("Y-m-d");

    $data_string = "
    {
        \"formData\": [
            {
                \"name\": \"note\"
            },
            {
                \"name\": \"plate_number_1\",
                \"value\": \"$today\"
            }
        ],
        \"productVariantId\": \"$productVariantId\"
    }
    ";

    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    $res = json_decode(curl_exec($ch), true);


} else {
    die("Invalid license plate");
}


?>