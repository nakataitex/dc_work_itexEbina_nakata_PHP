<?php
//constファイル読み込み
require_once "../../include/config/const.php";
//modelファイル読み込み
require_once "../../include/model/CommonModel.php";
require_once "../../include/model/UserModel.php";

session_start();
loginCheck();

$error_message = [];
$message = [];
$user_name = $_POST["user_name"] ?? "";
$password = $_POST["password"] ?? "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($user_name === "" || $password === "") {
        $error_message[] = "ユーザーとパスワードを入力してください";
    } else {
        try {
            $pdo = getConnection();
            $user_name = checkUser();
            $error_message = validationUserForm($error_message);
            if ($user_name && password_verify($password, $user_name["password"])) {
                session_regenerate_id(true);
                $_SESSION["login"] = true;
                $_SESSION["user_id"] = $user_name["user_id"];
                $_SESSION["user_name"] = $user_name["user_name"];
                if ($_SESSION["login"] && isset($_SESSION["user_name"]) && $_SESSION["user_name"] === "ec_admin") {
                    header("Location: ./Manage.php");
                    exit();
                } else {
                    header("Location: ./Catalog.php");
                    exit();
                }
            } else {
                $error_message[] = "ユーザー名またはパスワードが一致しません";
            }
        } catch (PDOException $e) {
            $error_message[] = 'データベースエラー：' . $e->getMessage();
        }
    }
}

$display_error_message = convertToArray($error_message) ?? "";
$display_message = convertToArray($message) ?? "";

//CSSファイルの選択
$stylesheet = "./assets/Style.css";
//ページタイトル
$page_title = "ログイン画面";
//ページリンク
$menus = [
    "./Register.php" => "会員登録"
];

//viewファイル読み込み
include_once "../../include/view/HeaderView.php";
include_once "../../include/view/LoginView.php";
include_once "../../include/view/FooterView.php";