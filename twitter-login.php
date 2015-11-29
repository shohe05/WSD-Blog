<?php
require("./hybridauth/hybridauth/Hybrid/Auth.php");
session_start();
require_once('functions.php');

$auth = new Hybrid_Auth( "./hybridauth/hybridauth/config.php" );
$twitter = $auth->authenticate("Twitter");
$profile = $twitter->getUserProfile();

$twitter_id = $profile->identifier;
$username = $profile->displayName;

$db = connectDb();
$sql = 'SELECT * FROM users WHERE twitter_id = :twitter_id';
$statement = $db->prepare($sql);
$statement->execute(['twitter_id' => $twitter_id]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $sql = "INSERT INTO users(username, twitter_id) VALUES(:username, :twitter_id)";
    $statement = $db->prepare($sql);
    $result = $statement->execute([
        ':username' => $username,
        ':twitter_id' => $twitter_id,
    ]);
    if (!$result) {
        die('Database Error');
    }

    $sql = 'SELECT * FROM users WHERE twitter_id = :twitter_id';
    $statement = $db->prepare($sql);
    $statement->execute(['twitter_id' => $twitter_id]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);
}

$_SESSION['user']['id'] = $user['id'];
$_SESSION['user']['username'] = $user['username'];

$_SESSION["success"] = "ログインしました。";
header("Location: article-list.php");