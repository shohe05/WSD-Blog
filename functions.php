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

function redirectIfNotLogin()
{
    if (!isset($_SESSION['user'])) {
        return header('Location: login.php');
    }
}

function loginUser() {
    return $_SESSION['user'];
}