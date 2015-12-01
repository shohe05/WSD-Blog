<?php

require_once('./functions.php');
session_start();

// ログインしていなかったら、ログイン画面にリダイレクトする
redirectIfNotLogin(); // ※ この関数はfunctions.phpに定義してある

// DB接続
$db = connectDB(); // ※ この関数はfunctions.phpに定義してある
// 全記事を降順に取得するSQL文
$sql = 'SELECT * FROM articles ORDER BY id DESC';
// SQLを実行
$statement = $db->query($sql);
// 以下4行で、取得した記事を配列$articlesに格納している
$articles = [];
foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $article ) {
    $articles[]= $article;
}

?>

<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>WSD Blog</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/jumbotron-narrow.css">
    <style>
        body {

        }
        .article:hover {
            background: #f2f2f2;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation"><a href="./index.php">一覧</a></li>
                <li role="presentation"><a href="./new-article.php">投稿</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo h(loginUser()['username']); ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="./logout.php">ログアウト</a></li>
                    </ul>
                </li>
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

    <div class="row">
        <ul style="list-style-type:none; padding-left: 1em;">
            <?php foreach($articles as $article): ?>
                <li class='article'>
                    <h3>
                        <!-- 記事詳細画面へのリンク -->
                        <a href="./article.php?id=<?php echo $article['id']; ?>">
                            <?php echo h($article['title']); ?>
                        </a>
                    </h3>
                    <hr>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</div>
<script src="./js/jquery.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
</body>
</html>