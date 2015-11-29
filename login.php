<?php
require_once('./functions.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (empty($_POST['username']) || empty($_POST['password'])) {
        $_SESSION["error"] = "入力されていない項目があります";
        header("Location: login.php");
        return;
    }

    $db = connectDb();
    $sql = 'SELECT * FROM users WHERE username = :username';
    $statement = $db->prepare($sql);
    $statement->execute(['username' => $_POST['username']]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION["error"] = "入力した情報に誤りがあります。";
        header("Location: login.php");
        return;
    }

    if (!password_verify($_POST['password'], $user['password'])) {
        $_SESSION["error"] = "入力した情報に誤りがあります。";
        header("Location: login.php");
        return;
    }

    $_SESSION["user"]["id"] = $user['id'];
    $_SESSION["user"]["username"] = $user['username'];

    $_SESSION["success"] = "ログインしました。";
    header("Location: article-list.php");
}

?>

<html lang="ja">
<head>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/jumbotron-narrow.css">
</head>
<body>
<div class="container">

    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation"><a href="./user-register.php">新規登録</a></li>
                <li role="presentation"><a href="./login.php">ログイン</a></li>
            </ul>
        </nav>
        <h3 class="text-muted">WSD Blog</h3>
    </div>

    <!-- Success Message -->
    <?php if(!empty($_SESSION['success'])): ?>
        <div class="alert alert-success" role="success">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Success:</span>
            <?php echo $_SESSION['success']; ?>
            <?php $_SESSION['success'] = null; ?>
        </div>
    <?php endif; ?>

    <!-- Error Message -->
    <?php if(!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            <?php echo $_SESSION['error']; ?>
            <?php $_SESSION['error'] = null; ?>
        </div>
    <?php endif; ?>

    <h2>Twitterでログイン</h2>
    <a href="./twitter-login.php" class="btn btn-success">Twitterログインはこちら</a>


    <h2>ログイン</h2>

    <form action="" method="post">
        <div class="form-group">
            <label for="username-input">ユーザー名</label>
            <input type="text" name="username" class="form-control" id="username-input" placeholder="">
        </div>
        <div class="form-group">
            <label for="password-input">パスワード</label>
            <input type="password" name="password" class="form-control" id="password-input" placeholder="">
        </div>
        <button type="submit" class="btn btn-primary">ログイン</button>
    </form>

</div> <!-- /container -->
</body>
</html>