<?php
    $site = 'cars';
    include("top.php"); 

    //create or open (if exists) the database
    $database = new SQLite3('db/db.sqlite');
    //$processUser = posix_getpwuid(posix_geteuid());
    //echo $processUser['name'];

    $query = "CREATE TABLE IF NOT EXISTS cardata (
        plate TEXT PRIMARY KEY,
        displayname TEXT,
        color TEXT
    );";
    $database->exec($query);


    $query = "SELECT COUNT(*) as count FROM cardata;";

    $stm = $database->prepare($query);
    $res = $stm->execute();
    
    $row = $res->fetchArray(SQLITE3_NUM);
    $numRows = $row[0];

    if ($numRows > 0) {
        $query = "SELECT * FROM cardata";
        $stm = $database->prepare($query);


        ?>
            <section>
                    <header>
                        <h2>Cars</h2>
                    </header>
                    <table>
                        <thead>
                            <tr>
                                <th>Plate</th>
                                <th>Car</th>
                                <th>Color</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
        <?php
        $res = $stm->execute();

        while ($row = $res->fetchArray(SQLITE3_NUM)) {
            echo "<tr><td>{$row[0]}</td><td>{$row[1]}</td><td>{$row[2]}</td><td><a href='deleteCar.php?plate=".$row[0]."'>delete</a></tr>";
        }

        ?>
            </tbody>
            </table>
            </section>
            <hr>
        <?php
    }
    
    $database->close();
    
?>
        <section>
            <div id="carsform">
                <form>
                    <header>
                        <h2>Add Car</h2>
                    </header>
                        <label for="inputPlate">License Plate:</label>
                        <input type="text" id="inputPlate" name="inputPlate" size="14" placeholder="HB 12345">
                        <button id="btnRegisterCar" type="submit">Add Car</button>
                </form>
            </div>
        </section>

<?php
    include("bottom.php");
?>