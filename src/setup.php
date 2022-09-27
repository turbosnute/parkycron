<?php
    //create or open (if exists) the database
    $database = new SQLite3('db/db.sqlite');
    //$processUser = posix_getpwuid(posix_geteuid());
    //echo $processUser['name'];

    $query = "CREATE TABLE IF NOT EXISTS parkdata (
        phone TEXT PRIMARY KEY,
        token TEXT,
        refresh_token TEXT,
        agreementid TEXT
    );";
    $database->exec($query);


?>