<?php
require_once('functions.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['password-confirmation'])) {
        $_SESSION["error"] = "入力されていない項目があります";
        header("Location: user-register.php");
        return;
    }

    if ($_POST['password'] !== $_POST['password-confirmation']) {
        $_SESSION["error"] = "パスワードが一致しません";
        header("Location: user-register.php");
        return;
    }

    $db = connectDb();
    $sql = "INSERT INTO users(username, password) VALUES(:username, :password)";
    $statement = $db->prepare($sql);
    $result = $statement->execute([
        ':username' => $_POST['username'],
        ':password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
    ]);
    if (!$result) {
        die('Database Error');
    }

    $_SESSION["success"] = "登録が完了しました。";
    header("Location: login.php");
}
?>

<html lang="ja">
<head>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/jumbotron-narrow.css">

    <!--    <link rel="stylesheet" href="./css/user-register.css">-->
</head>
<body>
<div class="container">

    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation"><a href="/user-register.php">新規登録</a></li>
                <li role="presentation"><a href="/login.php">ログイン</a></li>
            </ul>
        </nav>
        <h3 class="text-muted">WSD Blog</h3>
    </div>


    <h2>Twitterでログイン</h2>
    <a href="/twitter-login.php" class="btn btn-success">Twitterで登録するならこちら</a>

    <h2>新規登録</h2>

    <!-- Error Message -->
    <?php if(!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            <?php echo $_SESSION['error']; ?>
            <?php $_SESSION['error'] = null; ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="form-group">
            <label for="username-input">ユーザー名</label>
            <input type="text" name="username" class="form-control" id="username-input" placeholder="">
        </div>
        <div class="form-group">
            <label for="password-input">パスワード</label>
            <input type="password" name="password" class="form-control" id="password-input" placeholder="">
        </div>
        <div class="form-group">
            <label for="password-confirmation-input">パスワード確認</label>
            <input type="password" name="password-confirmation" class="form-control" id="password-confirmation-input" placeholder="">
        </div>
        <button type="submit" class="btn btn-primary">登録</button>
    </form>

</div> <!-- /container -->
</body>
</html>