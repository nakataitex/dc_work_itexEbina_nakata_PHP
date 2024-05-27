<?php
//文字の長さ確認
function validationLength($input, $type)
{
    $message = "";
    if ($type === "user_name" && strlen($input) < 5) {
        $message = "ユーザー名は5文字以上必要です";
    } elseif ($type === "password" && strlen($input) < 8) {
        $message = "パスワードは8文字以上必要です";
    }
    return $message;
}

//半角英数かアンダースコアのみか確認
function validationStr($input)
{
    return preg_match("/^[a-zA-Z0-9_]+$/", $input);
}


//フォームのバリデーションチェックをまとめて行う
function validationUserForm($error_message)
{
    $user_name = $_POST["user_name"];
    $password = $_POST["password"];
    $user_name_error = validationLength($user_name, "user_name");
    if ($user_name_error) {
        $error_message[] = $user_name_error;
    }
    $password_error = validationLength($password, "password");
    if ($password_error) {
        $error_message[] = $password_error;
    }
    if (!validationStr($user_name) || !validationStr($password)) {
        $error_message[] = "ユーザー名とパスワードは半角英数またはアンダースコアで入力してください";
    }
    return $error_message;
}

//データベースに接続し、重複チェックを行う
function checkUser()
{
    $sql = "SELECT user_id,user_name,password FROM ec_user_table WHERE user_name = :user_name LIMIT 1";
    $user_param = [
        ":user_name" => $_POST["user_name"]
    ];
    return duplicateCheck($sql, $user_param);
}

function createUser($user_name, $password)
{
    try {
        $pdo = getConnection();
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO ec_user_table(user_name, password, create_date) VALUES(:user_name, :password, :create_date)";
        $params = [
            ":user_name" => $user_name,
            ":password" => $hashed_password,
            ":create_date" => currentDate()
        ];
        $result = sql_fetch_data($sql, $params);
        if ($result) {
            $pdo->commit();
            return $result;
        } else {
            $pdo->rollBack();
            return false;
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        throw $e;
    }
}
