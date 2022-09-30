<?php
    $code = $_GET['code'];
    $phone = $_GET['phone'];


    $pattern = '/^\+[0-9]{10}$/';
    if (preg_match($pattern, $phone)) {

        // check if code is 4 ints:
        $code = trim($code);
        
        $pattern = "/^[0-9]{4}$/";

        if (preg_match($pattern, $code)) {
            echo "code: $code<br />";
                // valid code format


                // create a new cURL resource
                $ch = curl_init();

                // set URL and other appropriate options
                curl_setopt($ch, CURLOPT_URL, "https://parko.giantleap.no/client/suc-verify");
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
                    'host: parko.giantleap.no'
                ));
                
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERAGENT, $config['useragent']);

                $data = array(
                    "phoneNumber" => $phone,
                    "code" => $code
                );

                $data_string = json_encode($data);     

                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                $res = json_decode(curl_exec($ch), true);

                //$obj = json_decode($res, true);

                // {"resultCode":"SUCCESS","errorCode":null,"errorMessage":null,"switchToDemo":false}


                if ($res['resultCode'] == 'SUCCESS') {
                    echo "<p><strong>Token</strong> ".$res["token"]."<br /><strong>Refresh Token:</strong> ".$res['refreshToken']."<br /><strong>userId</strong>".$res['userId']."</p>";

                    // write to database.
                    $database = new SQLite3('db/db.sqlite');
                    //$processUser = posix_getpwuid(posix_geteuid());
                    //echo $processUser['name'];
                
                    $query = "CREATE TABLE IF NOT EXISTS parkdata (
                        userId TEXT PRIMARY KEY,
                        phone TEXT,
                        token TEXT,
                        refresh_token TEXT,
                        agreementid TEXT,
                        plate TEXT
                    );";
                    $database->exec($query);

                    $query = "INSERT OR REPLACE INTO parkdata('userId', 'phone', 'token', 'refresh_token') VALUES ('".$res['userId']."', '$phone', '".$res["token"]."', '".$res['refreshToken']."');";
                    //echo "$query";
                    $database->exec($query);

                    // check if cars exists or something.
                    $query = "SELECT COUNT(*) as count FROM cardata;";

                    $stm = $database->prepare($query);
                    $res = $stm->execute();
                    
                    $row = $res->fetchArray(SQLITE3_NUM);
                    $numRows = $row[0];
                
                    if ($numRows > 0) {
                        echo "<button id='btnGetProducts' type='button' onclick='getProducts()'>Get Parking Agreements</button>";
                    } else {
                        echo "<p>You have no cars added.</p><br /><a href='cars.php'>Add Car</a>";
                    }

                    $database->close();
    



                } else {
                    echo "<p>Not successful.</p>";
                    print_r($res);
                }
                curl_close($ch);

            } else {
                echo "<p>Invalid Code Format. Should be ####</p>";
            }
    } else {
        echo "Invalid phone number '$phone'";
    }
?>