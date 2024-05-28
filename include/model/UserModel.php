<?php
//認証確認
function authenticateUser()
{
    try {
        $check_user = checkUser();
        $password = $_POST["password"];
        if ($check_user && password_verify($password, $check_user["password"])) {
            return $check_user;
        } else {
            return "ユーザー名またはパスワードが一致しません";
        }
    } catch (PDOException $e) {
        return 'データベースエラー：' . $e->getMessage();
    }
}

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

function createUser()
{
    try {
        $user_name = $_POST["user_name"];
        $password = $_POST["password"];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO ec_user_table(user_name, password, create_date) VALUES(:user_name, :password, :create_date)";
        $params = [
            ":user_name" => $user_name,
            ":password" => $hashed_password,
            ":create_date" => currentDate()
        ];
        $result = sql_fetch_data($sql, $params);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        throw $e;
    }
}

function register($password)
{
    try {
        $pdo = getConnection();
        $pdo->beginTransaction();
        $user_name = $_POST["user_name"];
        if (checkUser()) {
            $pdo->rollBack();
            return "そのユーザー名は既に使用されています";
        }
        $result = createUser();
        if ($result) {
            $pdo->commit();
            return true;
        } else {
            $pdo->rollBack();
            return "ユーザー登録に失敗しました";
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        return "データベースエラー：" . $e->getMessage();
    }
}