## 要件
- ユーザー登録(name, email, pass)
- ログイン(name or email, pass)
- Twitter認証も可能
- 記事投稿
- 投稿記事一覧
- 記事詳細

## 構成

- 登録: user-register.php  
- ログイン: login.php   
- Twitterで登録&ログイン twitter-login.php
- 一覧: article-list.php
- 詳細: article-detail.php
- 新規投稿: new-article.php
- DB情報はconfig.phpに定義
- 複数箇所で呼ばれる処理は関数に纏め、functions.phpに定義

## dependency
- CSSフレームワーク -> [Bootstrap](http://getbootstrap.com/)
- Twitter認証 -> [HybridAuth](http://hybridauth.sourceforge.net/)

## バージョン情報
- PHP 5.4 (C4SAと同じ)
- MySQL 5.5 (C4SAと同じ)


## DBの設定について
```connectDB()``` メソッドを使う場合は、config.phpに自身のDBの情報を書いてください。(C4SAの共有MySQLから確認する)

config.php

```
<?php
return [
    'db' => [
        'database' => ‘データベース名', // PHPMyAdminの画面左側のデータベース名
        'user' => 'ユーザー名, // C4SAの共有MySQLに書いてある
        'password' => 'パスワード', // C4SAの共有MySQLに書いてある
        'host' => 'ローカルIP' // C4SAの共有MySQLに書いてある
    ]
];
```

そして、使いたいファイルの上でfunctions.phpを読み込んであげれば使えます。

```

<?php
require_once('./functions.php');
$db = connectDB();

```
