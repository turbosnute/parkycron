<?php
    $site = 'home';
    include("top.php");


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
?>
        
        <section>
            <div id="authform">
                <?php
                    if (isset($refresh_token) && ($refresh_token != '')) {
                        // probably authenticated.
                        $query = "SELECT COUNT(*) as count FROM cardata;";

                        $stm = $database->prepare($query);
                        $res = $stm->execute();
                        
                        $row = $res->fetchArray(SQLITE3_NUM);
                        $numRows = $row[0];

                        if ($numRows > 0) {
                            echo "<button id='btnGetProducts' type='button' onclick='getProducts()'>Get Parking Agreements</button>";
                        } else {
                            // no cars
                            echo "<p>You have no cars added.</p><br /><a href='cars.php'>Add Car</a>";
                        }
                    } else {
                ?>
                <form>
                    <header>
                        <h2>Authentication</h2>
                    </header>

                        <label for="inputPhone">Phone number:</label>
                        <input type="text" id="inputPhone" name="inputPhone" size="14" placeholder="+47 000 00 000">
                        <button id="btnGetCode" type="button" onclick="getCode()">Get SMS Code</button>
                </form>
                <?php
                    }
                ?>
            </div>
        </section>

<?php
    $database->close();
    include("bottom.php");
?>