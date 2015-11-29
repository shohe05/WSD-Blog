<?php

require_once('./functions.php');
session_start();
redirectIfNotLogin();

$db = connectDB();
$sql = 'SELECT * FROM articles WHERE id = :id';
$statement = $db->prepare($sql);
$statement->execute(['id' => $_GET['id']]);

$article = $statement->fetch(PDO::FETCH_ASSOC);

$statement = $db->query('SELECT * FROM users WHERE id = ' . $article['user_id']);
$article_user = $statement->fetch(PDO::FETCH_ASSOC);

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

        #article-title {
            font-size: 3em;
            font-weight: 700;
        }

        #article-meta {
            color: grey;
        }

        #article-body {
            font-family: "メイリオ","Hiragino Kaku Gothic Pro",Meiryo,"ヒラギノ角ゴ Pro W3","MS PGothic","MS UI Gothic",Helvetica,Arial,sans-serif;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation"><a href="/article-list.php">一覧</a></li>
                <li role="presentation"><a href="/new-article.php">投稿</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo loginUser()['username']; ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/logout.php">ログアウト</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <h3 class="text-muted">WSD Blog</h3>
    </div>

    <h1 id="article-title">
        <?php echo $article['title']; ?>
    </h1>

    <p id="article-meta">
        <i class="glyphicon glyphicon-user"></i>&nbsp;<?php echo $article_user['username'] ?>&nbsp;&nbsp;
        <i class="glyphicon glyphicon-time"></i>&nbsp;
        <?php echo strftime("%Y年%m月%d日", strtotime($article['modified_at'])); ?>
    </p>

    <pre id="article-body" style="background: white; border:none; font-size:18px; padding: 0; margin-top: 30px;"><?php echo $article['body']; ?></pre>

    <script src="./js/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</body>
</html>