<?php
session_start();
//定数(const.php)を読み込む
require_once '../../include/config/const.php';

//共通のModel(model.php)を読み込む
require_once '../../include/model/ec_model.php';


if (isset($_SESSION["form"])) {
    $form = $_SESSION["form"];
} else {
    header("Location: ec_register.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    date_default_timezone_set("Asia/Tokyo");
    $date = date("Y-m-d");
    $insert_user = "INSERT INTO ec_user_table(user_name, password, create_date) VALUES(:user_name, :password, :create_date)";
    $password = password_hash($form["password"],PASSWORD_DEFAULT);
    $insert_data = [
        ":user_name" => $form["name"],
        ":password" => $password,
        ":create_date" => $date
    ];

    $insert_result = sql_fetch_data($insert_user, $insert_data);
    var_dump($insert_result);

    

    if ($insert_result) {
        unset($_SESSION["form"]);
        header("Location: ec_welcome.php");
    }
}



require_once ('../../include/view/ec_check_view.php');