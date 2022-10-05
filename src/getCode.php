<?php
    $phone = $_GET['phone'];
    $phone = str_replace(" ", "", $phone);

    // trim
    $phone = trim($phone);

    //check for countrycode
    if (substr($phone, 0, 3) != '+47') {
        $phone = "+47$phone";
    }
    
    // validate
    $pattern = '/^\+[0-9]{10}$/';

    if (preg_match($pattern, $phone)) {
        //echo "Valid phone number ($phone)";

        // create a new cURL resource
        $ch = curl_init();

        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, "https://parko.giantleap.no/client/suc-request");
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
            "phoneNumber" => $phone
        );

        $data_string = json_encode($data);     

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        $result = json_decode(curl_exec($ch),true);

        if (curl_error($ch)) {
            echo curl_error($ch);
        }

        if ($result['resultCode'] == 'SUCCESS') {
            echo "<aside>Successfully ordered SMS Code.</aside>";

            /*
                Enter Code Form Here?
            */
            ?>
            <form>
                <header>
                    <h2>Enter Code</h2>
                </header>
                <label for="inputCode">Code:</label>
                <input type="text" id="inputCode" name="inputCode" size="20" placeholder="0000">
                <input type="hidden" id="frmPhone" name="frmPhone" value="<?php echo $phone;?>">
                <button id="btnRegisterCode" type="button" onclick="registerCode()">Save Code</button>
            </form>
            <div id="coderesult">

            </div>

            <?php
        } else {
            print $result;
        }

        ?>


        <?php
        // {"resultCode":"SUCCESS","errorCode":null,"errorMessage":null,"switchToDemo":false}
        curl_close($ch);        
    } else {
        echo "<p>Error. Invalid phone number. '$phone'</p>";
    }

    //echo "Testing.";
    //sleep(2);
    //echo "<br />$phone";
?>