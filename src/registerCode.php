<?php
    $code = $_GET['code'];

    // check if code is 4 ints:
    $code = trim($code);
    
    $pattern = "/^[0-9]{4}$/";

    if (preg_match($pattern, $code)) {
        echo "code: $code";
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

            curl_setopt($ch, CURLOPT_USERAGENT, $config['useragent']);

            $data = array(
                "phoneNumber" => "+4795293136",
                "code" => $code
            );

            $data_string = json_encode($data);     

            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

            $result = curl_exec($ch);

            // {"resultCode":"SUCCESS","errorCode":null,"errorMessage":null,"switchToDemo":false}
            curl_close($ch);

            if ($result['resultCode'] == "SUCCESS") {
                echo "<p><strong>Token</strong> ".$result["token"]."<br /><strong>Refresh Token:</strong> ".$result['refresh_token']."<br /><strong>userId</strong>".$result['userId']."</p>";

                // write to database.
                $database = new SQLite3('db/db.sqlite');
                //$processUser = posix_getpwuid(posix_geteuid());
                //echo $processUser['name'];
            
                $query = "CREATE TABLE IF NOT EXISTS parkdata (
                    userId TEXT PRIMARY KEY,
                    phone TEXT,
                    token TEXT,
                    refresh_token TEXT,
                    agreementid TEXT
                );";
                $database->exec($query);

                $query = "INSERT OR REPLACE INTO parkdata('userId', 'phone', 'token', 'refresh_token') VALUES (".$result['userId'].", +4700000000, ".$result["token"].", ".$result['refresh_token'].");";
                $database->exec($query);


            } else {
                echo "<p>Not successful.";
                print_r($result);
            }


        } else {
            echo "<p>Invalid Code Format. Should be ####</p>";
        }
?>