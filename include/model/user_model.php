<?php
//認証情報を確認
function authenticateUser()
{
    $user_name = $_POST["user_name"];
    $password = $_POST["password"];
    if ($user_name === "" || $password === "") {
        throw new Exception("ユーザー名とパスワードを入力してください");
    }
    $check_user = validationUserName();
    if ($check_user && password_verify($password, $check_user["password"])) {
        return $check_user;
    } else {
        throw new Exception("ユーザー名またはパスワードが一致しません");
    }
}

//文字の長さを検証
function validationLength($input, $type)
{
    $user_name = $_POST["user_name"];
    $password = $_POST["password"];
    if ($user_name === "" || $password === "") {
        throw new Exception("ユーザーとパスワードを入力してください");
    }
    if ($type === "user_name" && strlen($input) < 5) {
        throw new Exception("ユーザー名は5文字以上必要です");
    } elseif ($type === "password" && strlen($input) < 8) {
        throw new Exception("パスワードは8文字以上必要です");
    }
}

//半角英数かアンダースコアのみか確認
function validationStr($input)
{
    return preg_match("/^[a-zA-Z0-9_]+$/", $input);
}

//フォームのバリデーションチェックをまとめて行う
function validationUserForm()
{
    $user_name = $_POST["user_name"];
    $password = $_POST["password"];
    validationLength($user_name, "user_name");
    validationLength($password, "password");
    if (!validationStr($user_name) || !validationStr($password)) {
        throw new Exception("ユーザー名とパスワードは半角英数またはアンダースコアで入力してください");
    }
}

//データベースに接続し、重複チェックを行う
function validationUserName()
{
    $sql = "SELECT user_id,user_name,password FROM ec_user_table WHERE user_name = :user_name LIMIT 1";
    $user_param = [
        ":user_name" => $_POST["user_name"]
    ];
    return duplicateCheck($sql, $user_param);
}

//ユーザー情報をDBに挿入
function createUser()
{
    $user_name = $_POST["user_name"];
    $password = $_POST["password"];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO ec_user_table(user_name, password, create_date) VALUES(:user_name, :password, :create_date)";
    $params = [
        ":user_name" => $user_name,
        ":password" => $hashed_password,
        ":create_date" => currentDate()
    ];
    $result = sqlFetchData($sql, $params);
    if ($result) {
        return $result;
    } else {
        return false;
    }
}

//ユーザー名重複のバリデーションを行ってからユーザー登録処理
function register($password)
{
    $pdo = getConnection();
    $pdo->beginTransaction();
    if (validationUserName()) {
        $pdo->rollBack();
        throw new Exception("そのユーザー名は既に使用されています");
    }
    $result = createUser();
    if ($result) {
        $pdo->commit();
        return true;
    } else {
        $pdo->rollBack();
        throw new Exception("ユーザー登録に失敗しました");
    }
}

//ユーザー登録完了処理
function registerSuccess(){
    if(isset($_SESSION["success"])){
        unset($_SESSION);
        $message[] = "登録完了しました";
        return $message;
    }else{
        throw new Exception("セッションが保存されていないか登録に失敗しました");
    }

}