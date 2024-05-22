<?
//定数を記述
define('DSN', 'mysql:host=localhost;dbname=xb513874_u338x');
define('LOGIN_USER', 'xb513874_fpu2g');
define('LOGIN_PASSWORD', 'mj3mt8vtwv');

//ディレクトリ
define('IMG_DIR', './assets/img/');//商品画像のディレクトリ

//汎用メッセージ
define("USER_NAME", "ユーザー名");
define("PASSWORD", "パスワード");
define("PRICE", "価格");
define("PRODUCT", "商品");
define("PRODUCT_NAME", "商品名");
define("STOCK", "在庫数");
define("FILE_TYPE", "ファイル形式");
define("IMAGE", "画像");
define("PUBLIC_FLG", "公開・非公開");

//通常のメッセージ
define("NORMAL_ADD_PRODUCT", "商品のテータベース登録に成功しました。");

//エラーメッセージ
define("ERR_LENGTH_NAME", "ユーザー名は5文字以上入力してください");
define("ERR_LENGTH_PASSWORD", "パスワードは8文字以上入力してください");
define("ERR_STRING", "は半角英数で入力してください");
define("ERR_DUPLICATE", "は既に使用されています");
define("ERR_LOGIN_FAILED", "ログインに失敗しました");
define("ERR_DB_ERROR", "データベースエラーが発生しました");
define("ERR_PRICE", "価格を半角数字で指定してください");
define("ERR_BLANK", "が入力されていません");
define("ERR_INCORRECT", "が正しくありません");
define("ERR_UPLOAD", "のアップロードに失敗しました");
define("ERR_SELECT", "が選択されていません");
define("ERR_STATUS", "のステータスが不明です");

//Cookieの保存期間
define('EXPIRATION_PERIOD', 30);