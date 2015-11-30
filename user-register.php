<?php
require_once('./functions.php');
session_start();

/*
 * 普通にアクセスした場合: GETリクエスト
 * 登録フォームからSubmitした場合: POSTリクエスト
 */
// POSTリクエストの場合
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 送られた値を取得
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password-confirmation'];

    /**
     * 入力値チェック
     */
    // 未入力の項目があるか
    if (empty($username) || empty($password) || empty($password_confirmation)) {
        $_SESSION["error"] = "入力されていない項目があります";
        header("Location: user-register.php");
        return;
    }

    // パスワードとパスワード確認が一致しているか
    if ($password !== $password_confirmation) {
        $_SESSION["error"] = "パスワードが一致しません";
        header("Location: user-register.php");
        return;
    }


    /**
     * 登録処理
     */
    // DB接続
    $db = connectDb();  // ※ この関数はfunctions.phpに定義してある
    // DBにインサート
    $sql = "INSERT INTO users(username, password) VALUES(:username, :password)";
    $statement = $db->prepare($sql);
    $result = $statement->execute([
        ':username' => $username,
        ':password' => crypt($password),
    ]);
    if (!$result) {
        die('Database Error');
    }

    $_SESSION["success"] = "登録が完了しました。";
    // ログイン画面に遷移
    header("Location: login.php");
}
?>

<html lang="ja">
<head>
    <meta charset="utf-8">
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


    <h2>Twitterで登録</h2>
    <a href="./twitter-login.php" class="btn btn-success">Twitterで登録するならこちら</a>

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

    <!-- 登録フォーム -->
    <form method="post" action="">
        <!-- ユーザー名 -->
        <div class="form-group">
            <label for="username-input">ユーザー名</label>
            <input type="text" name="username" class="form-control" id="username-input" placeholder="">
        </div>
        <!-- パスワード -->
        <div class="form-group">
            <label for="password-input">パスワード</label>
            <input type="password" name="password" class="form-control" id="password-input" placeholder="">
        </div>
        <!-- パスワード確認 -->
        <div class="form-group">
            <label for="password-confirmation-input">パスワード確認</label>
            <input type="password" name="password-confirmation" class="form-control" id="password-confirmation-input" placeholder="">
        </div>
        <input type="submit" class="btn btn-primary" value="登録">
    </form>

</div> <!-- .container -->
</body>
</html>