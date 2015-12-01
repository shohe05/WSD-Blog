<?php
require_once('./functions.php');
session_start();

// ログインしていなかったらログイン画面に遷移
redirectIfNotLogin();  // ※ この関数はfunctions.phpに定義してある

/*
 * 普通にアクセスした場合: GETリクエスト
 * 登録フォームからSubmitした場合: POSTリクエスト
 */
// POSTリクエストの場合
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 未入力の値が無いか
    if (empty($_POST['title']) || empty($_POST['body'])) {
        $_SESSION["error"] = "タイトルと本文を入力してください。";
        header("Location: index.php");
        return;
    }

    // 記事を登録
    $db = connectDb();
    $sql = "INSERT INTO articles(user_id, title, body) VALUES(:user_id, :title, :body)";
    $statement = $db->prepare($sql);
    $result = $statement->execute([
        ':user_id' => $_SESSION['user']['id'],
        ':title' => $_POST['title'],
        ':body' => $_POST['body'],
    ]);
    if (!$result) {
        die('Database Error');
    }

    $_SESSION["success"] = "記事を投稿しました";
    // 一覧画面に遷移
    header("Location: index.php");
}



?>

<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>WSD Blog</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/jumbotron-narrow.css">
</head>
<body>

<div class="container">

    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation"><a href="./index.php">一覧</a></li>
                <li role="presentation"><a href="./new-article.php">投稿</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo loginUser()['username']; ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="./logout.php">ログアウト</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <h3 class="text-muted">WSD Blog</h3>
    </div>

    <form action="" method="post">

        <!-- Error Message -->
        <?php if(!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                <?php echo $_SESSION['error']; ?>
                <?php $_SESSION['error'] = null; ?>
            </div>
        <?php endif; ?>

        <!-- Title -->
        <div class="form-group">
            <label for="title" class="control-label">タイトル</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="">
        </div>

        <!-- Body -->
        <div class="form-group">
            <label for="body" class="control-label">本文</label>
            <textarea name="body" class="form-control" rows="20" placeholder=""></textarea>
        </div>

        <!-- Submit -->
        <input type="submit" class="btn btn-lg btn-success" value="投稿">

    </form>

</div>

<script src="./js/jquery.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
</body>
</html>