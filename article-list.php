<?php

require_once('./functions.php');
session_start();
redirectIfNotLogin();

$db = connectDB();
$sql = 'SELECT * FROM articles';
$statement = $db->query($sql);
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
                <li role="presentation" class="active"><a href="/article-list.php">一覧</a></li>
                <li role="presentation"><a href="/new-article.php">投稿</a></li>
                <li role="presentation"><a href="/logout.php"><?php echo loginUser()['username']; ?></a></li>
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

<!--    --><?php //foreach($articles as $article): ?>
                <div class="row">
<!--        <div class="col-md-4">-->
<!--            <h2>-->
<!--                --><?php //echo $article['title']; ?>
<!--            </h2>-->
<!--            <p>-->
<!--                --><?php //echo $article['body']; ?>
<!--            </p>-->
<!--            <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>-->
<!--        </div>-->
<!--                </div>-->
<!--    --><?php //endforeach; ?>
                    <ul style="list-style-type:none; padding-left: 1em;">
                        <?php foreach($articles as $article): ?>
                        <li class='article'>
                            <p style="color:#999;">2015/2/2 by Daison</p>
                            <h3>
                                <a href="/article-detail.php?id=<?php echo $article['id']; ?>">
                                    <?php echo $article['title']; ?>
                                </a>
                            </h3>
                            <hr>
                        </li>
                        <?php endforeach; ?>
                    </ul>

</div>
<script src="./js/bootstrap.min.js"></script>
</body>
</html>