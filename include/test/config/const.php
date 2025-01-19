<?php
//定数を記述

//接続情報
define('DSN', 'mysql:host=localhost:3306;dbname=ec_site');
define('LOGIN_USER', 'root');
define('LOGIN_PASSWORD', 'root');

//商品画像の保存先
define('IMG_DIR', './assets/img/');

//CSSファイルのディレクトリ
define('CSS_DIR', './assets/ec_site_style.css');

//商品一覧のデフォルトの表示件数
define('DEFAULT_PAGINATION_LIMIT', 10);//デフォルトの表示数
define('DEFAULT_PAGINATION_MAX_LIMIT', 50);//最大表示数

//商品の公開ステータス
define('PUBLIC_FLG_PUBLIC', 1);//公開
define('PUBLIC_FLG_PRIVATE', 0);//非公開

//GETパラメータのデフォルトステータス
define('DEFAULT_PAGE_NUM', 0);//1ページ目のページネーションの値
define('DEFAULT_MAX_PAGE_NUM',100);//GETパラメータからアクセス可能な最大ページ数

//トップページのURL
define('TOP_PAGE_URL' ,  './index.php');