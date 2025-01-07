<?php
//定数を記述

//接続情報
define('DSN', 'mysql:host=localhost;dbname=xb513874_u338x');
define('LOGIN_USER', 'xb513874_fpu2g');
define('LOGIN_PASSWORD', 'mj3mt8vtwv');

//商品画像の保存先
define('IMG_DIR', './assets/img/');

//CSSファイルのディレクトリ
define('CSS_DIR', './assets/ec_site_style.css');

//商品一覧のデフォルトの表示件数
define('DEFAULT_PAGINATION_LIMIT', 10);
define('DEFAULT_PAGINATION_MAX_LIMIT', 50);

//商品の公開ステータス
define('PUBLIC_FLG_PUBLIC', 1);
define('PUBLIC_FLG_PRIVATE', 0);