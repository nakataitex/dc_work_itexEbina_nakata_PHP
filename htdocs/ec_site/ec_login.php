<?php
session_start();
if (isset($_SESSION["login"]) && $_SESSION["user_name"] !== "ec_admin") {
    header("Location: ./index.php");
    exit();
} elseif (isset($_SESSION["login"]) && $_SESSION["user_name"] === "ec_admin") {
    header("Location: ./ec_product_manage.php");
}

//定数(const.php)を読み込む
require_once '../../include/config/const.php';
//メッセージリスト(message_list.php)を読み込む
require_once '../../include/config/message_list.php';
//共通のModel(model.php)を読み込む
require_once '../../include/model/ec_model.php';

$message = [];
$user = "";
$password = "";
$id = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = $_POST["name"];
    $password = $_POST["password"];
    if ($user !== "" && $password != "") {
        try {
            $pdo = get_connection();
            $sql = "SELECT u.user_id,u.user_name,u.password FROM ec_user_table u WHERE user_name = :user_name LIMIT 1";
            $login_user_param = [
                ":user_name" => $user
            ];
            $row = duplicate_check($sql, $login_user_param);
            if ($row) {
                if (password_verify($password, $row["password"])) {
                    session_regenerate_id(true);
                    $_SESSION["login"] = true;
                    $_SESSION["user_id"] = $row["user_id"];
                    $_SESSION["user_name"] = $row["user_name"];
                    if ($_SESSION["login"] && isset($_SESSION["user_name"]) && $_SESSION["user_name"] === "ec_admin") {
                        header("Location: ./ec_product_manage.php");
                        exit();
                    }
                    header("Location: ./index.php");
                    exit();
                } else{
                    $message["error"]["login"][] = "login_failed";
                }
            } else {
                $message["error"]["login"][] = "login_failed";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            $message["error"]["db"][] = "db_error";
        }
    } else {
        $message["error"]["login"][] = "string";
    }
}

//CSSファイルの選択
$stylesheet = "./assets/ec_style.css";
//ページタイトル
$page_title = "ログイン画面";
//リンク
$menus = [
    "./ec_register.php" => "ユーザー登録",
];

//ログイン画面のヘッダーを読み込む
include_once("../../include/view/ec_header_view.php");
//ログインのView(ec_login_view.php)を読み込む
include_once ('../../include/view/ec_login_view.php');
//ログイン画面のフッターを読み込む
include_once ('../../include/view/ec_footer_view.php');