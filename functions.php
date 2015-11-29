<?php

function connectDB()
{
    $config = require_once('./config.php');
    $dsn = "mysql:dbname={$config['db']['database']};host={$config['db']['host']}";

    try {
        $db = new PDO($dsn, $config['db']['user'], $config['db']['password']);
    } catch (PDOException $e) {
        die('Connecting database failed:' . $e->getMessage());
    }

    return $db;
}