<?php
//定数(const.php)を読み込む
require_once '../../include/config/const.php';
//modelファイル読み込み
require_once "../../include/model/CommonModel.php";
require_once "../../include/model/UserModel.php";

session_start();
loginCheck();
$error_message = [];
$message = [];

//フォームをチェック
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["user_name"]) || empty($_POST["password"])) {
        $error_message[] = "ユーザーとパスワードを入力してください";
    } else {
        $user_name = $_POST["user_name"];
        $password = $_POST["password"];
        try {
            $pdo = getConnection();
            $pdo->beginTransaction();
            if (checkUser()) {
                $error_message[] = "そのユーザー名は既に使われています";
            } else {
                $error_message = validationUserForm($error_message);
            }
            if (empty($error_message)) {
                
                $result = createUser($user_name, $password);
                if ($result !== false) {
                    $_SESSION["success"] = true;
                    header("Location: ./RegisterSuccess.php");
                    exit();
                } else {
                    $error_message = "ユーザー登録に失敗しました";
                }
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
$page_title = "会員登録";
//CSSファイルの選択
$menus = [
    "./Login.php" => "ログイン"
];

//ログイン画面のヘッダーまでを読み込む
include_once ("../../include/view/HeaderView.php");
//会員登録画面を読み込む
include_once "../../include/view/RegisterView.php";
//ログイン画面のフッターを読み込む
include_once ('../../include/view/FooterView.php');