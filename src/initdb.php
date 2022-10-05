<?php
    $database = new SQLite3('/data/db.sqlite');

    $query = "CREATE TABLE IF NOT EXISTS parkdata (
        userId TEXT PRIMARY KEY,
        phone TEXT,
        token TEXT,
        refresh_token TEXT,
        agreementid TEXT,
        plate TEXT,
        lastReauthResult TEXT,
        lastReauthAttempt TEXT
    );";
    $database->exec($query);

    $query = "CREATE TABLE IF NOT EXISTS cardata (
        plate TEXT PRIMARY KEY,
        displayname TEXT,
        color TEXT
    );";
    $database->exec($query);

    $query = "CREATE TABLE IF NOT EXISTS log (
        log_id INTEGER PRIMARY KEY AUTOINCREMENT,
        log_time TEXT,
        operation TEXT,
        msg TEXT
    );";
    $database->exec($query);
?>