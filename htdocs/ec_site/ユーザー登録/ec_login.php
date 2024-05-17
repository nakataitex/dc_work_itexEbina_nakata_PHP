<?php
session_start();
//定数(const.php)を読み込む
require_once '../../include/config/const.php';

//共通のModel(model.php)を読み込む
require_once '../../include/model/ec_model.php';

if(isset($_SESSION["login"]) && $_SESSION["user_name"] !== "ec_admin"){
    header("Location: ./index.php");
    exit();
} elseif(isset($_SESSION["login"]) && $_SESSION["user_name"] === "ec_admin"){
    header("Location: ./ec_product_manage.php");
}

$error = [];
$user = "";
$password = "";
$id = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = h($_POST["name"]);
    $password = h($_POST["password"]);
    $error["name"] = validation($user, 5);
    $error["password"] = validation($password, 8);

    if ($user !== "" && $password != "") {
        try {
            $error =[];
            $pdo = get_connection();
            $sql = "SELECT u.user_id,u.user_name,u.password FROM ec_user_table u WHERE user_name = :user_name LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":user_name", $user);
            $stmt->execute();
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($password, $row["password"])) {
                    session_regenerate_id(true);
                    $_SESSION["login"] = true;
                    $_SESSION["user_id"] = $row["user_id"];
                    $_SESSION["user_name"] = $row["user_name"];
                    header("Location:index.php");
                    exit();
                } else {
                    $error["login"] = "failed";
                }
    
            } else {
                $error["login"] = "failed";
            }
    
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}






include_once ('../../include/view/ec_login_view.php');