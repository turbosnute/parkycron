<?php
    $site = 'config';
    include("top.php");

    include("initdb.php");

    $query = "SELECT * FROM parkdata";

    $stm = $database->prepare($query);
    $res = $stm->execute();

    $row = $res->fetchArray(SQLITE3_NUM);
    //echo "userId{$row[0]} {$row[1]} {$row[2]} {$row[3]}";
    echo "<section>";
    echo "<table>";
    echo "<tr><th>Attribute</th><th>Value</th></tr>";
    echo "<tr><th>userId</th><td>{$row[0]}</td></tr>";
    echo "<tr><th>phone</th><td>{$row[1]}</td></tr>";
    echo "<tr><th>token</th><td>{$row[2]}</td></tr>";
    echo "<tr><th>refresh_token</th><td>{$row[3]}</td></tr>";
    echo "<tr><th>agreementid</th><td>{$row[4]}</td></tr>";
    echo "<tr><th>plate</th><td>{$row[5]}</td></tr>";
    echo "<tr><th>lastReauthResult</td><td>{$row[6]}</td></tr>";
    echo "<tr><th>lastReauthAttempt</td><td>{$row[7]}</td></tr>";
    echo "</table>";
    echo "</section>";

    $database->close();

    include("bottom.php");
?>