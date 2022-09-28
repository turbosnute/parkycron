<?php
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

$query = "SELECT * FROM parkdata";


$stm = $database->prepare($query);
$res = $stm->execute();

$row = $res->fetchArray(SQLITE3_NUM);
echo "{$row[0]} {$row[1]} {$row[2]} {$row[3]}";

$database->close();

?>