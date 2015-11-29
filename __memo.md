## 要件
- ユーザー登録(name, email, pass)
- ログイン(name or email, pass)
- Twitter認証も可能
- 記事投稿(ログインしてなかったらログイン画面に遷移)
- 投稿記事一覧(paginate)
- 記事詳細

## 構成

登録: user-register.php  
ログイン: login.php   

一覧: article-list.php
詳細: article-detail.php
新規投稿: new-article.php

DB情報はconfig.phpに定義
複数箇所で呼ばれる処理は関数に纏め、functions.phpに追い出す