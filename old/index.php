<?php

require_once('./functions.php');
session_start();

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
    <link rel="stylesheet" href="./css/blog.css">
</head>
<body>

<div class="container">

    <!-- Success Message -->
    <?php if(!empty($_SESSION['success'])): ?>
        <div class="alert alert-success" role="success">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Success:</span>
            <?php echo $_SESSION['success']; ?>
            <?php $_SESSION['success'] = null; ?>
        </div>
    <?php endif; ?>

    <?php foreach($articles as $article): ?>
<!--        <div class="row">-->
            <div class="col-md-4">
                <h2>
                    <?php echo $article['title']; ?>
                </h2>
                <p>
                    <?php echo $article['body']; ?>
                </p>
                <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
            </div>
<!--        </div>-->
    <?php endforeach; ?>

</div>
<script src="./js/bootstrap.min.js"></script>
</body>
</html>