<?
session_start();//セッションスタート
if (isset($_SESSION["login"]) && isset($_SESSION["user_name"])) {
    $id = $_SESSION["user_id"];
    $user = $_SESSION["user_name"];
    header("Location: ./index.php");//ログインしている場合トップページへ移動
    exit();
}

//登録完了画面のViewを読み込む
include_once "../../include/view/ec_registration_complete_view.php";