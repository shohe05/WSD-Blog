<?php

require_once('./functions.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (empty($_POST['title']) || empty($_POST['body'])) {
        $_SESSION["error"] = "タイトルと本文を入力してください。";
        header("Location: post.php");
        return;
    }

    $db = connectDb();
    $sql = "INSERT INTO articles(user_id, title, body) VALUES(:user_id, :title, :body)";
    $statement = $db->prepare($sql);
    $user_id = 1;
    $result = $statement->execute([
        ':user_id' => $user_id,
        ':title' => $_POST['title'],
        ':body' => $_POST['body'],
    ]);
    if (!$result) {
        die('Database Error');
    }

    $_SESSION["success"] = "記事を投稿しました";
    header("Location: index.php");
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
            <label for="title" class="control-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Title">
        </div>

        <!-- Body -->
        <div class="form-group">
            <label for="body" class="control-label">Body</label>
            <textarea name="body" class="form-control" rows="5" placeholder="Body"></textarea>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-primary">Save</button>

    </form>

</div>


<script src="./js/bootstrap.min.js"></script>
</body>
</html>