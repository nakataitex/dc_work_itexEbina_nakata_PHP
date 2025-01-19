<?php
// PDOインスタンスの生成
function getConnection()
{
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO(DSN, LOGIN_USER, LOGIN_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
    }
    return $pdo;
}

//ログインしていたら対応するページに遷移させる
function loginCheck()
{
    if (isset($_SESSION["login"])) {
        if ($_SESSION["user_name"] !== "ec_admin") {
            header("Location: ./catalog.php");
            exit();
        } elseif ($_SESSION["user_name"] === "ec_admin") {
            header("Location: ./manage.php");
            exit();
        }
    }
}

//管理者またはログインしてない場合はログインページへ移動
function commonUserCheck()
{
    if (!isset($_SESSION["login"]) || !isset($_SESSION["user_name"]) || $_SESSION["user_name"] === "ec_admin") {
        header("Location: ./index.php");
        exit();
    }
}

//タイムゾーンAsia/Tokyoの日付を取得
function currentDate()
{
    date_default_timezone_set("Asia/Tokyo");
    return date("Y-m-d");
}

//DBに重複があるか確認
function duplicateCheck($sql, $params)
{
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetch();
    } catch (PDOException $e) {
        throw $e;
    }
}

//格納したメッセージを表示
function displayMessage($messages)
{
    if (isset($messages) && is_array($messages)) {
        foreach ($messages as $message) {
            echo "<p>" . $message . "</p>";
        }
    } else {
        echo "<p>" . $messages . "</p>";
    }
}

//DBから受け取った結果が単一だった場合配列化して他の関数で流用出来るようにする
function convertToArray($data)
{
    if (isset($data["product_name"]) || isset($data["product_id"])) {
        $data = [$data];
    }
    return $data;
}

//htmlspecialchars(特殊文字の変換)のラッパー関数
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

//二次元配列で上のh()を使える様にする関数
function hArray($array)
{
    //二次元配列をforeachでループさせる
    foreach ($array as $keys => $values) {
        foreach ($values as $key => $value) {
            //ここの値にh関数を使用して置き換える
            $array[$keys][$key] = h($value);
        }
    }
    return $array;
}

//SQLを実行して複数のデータを取得
function sqlFetchData($sql, $params = [], $singleRow = false)
{
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $result = $stmt->execute();
        if ($result) {
            if (stripos($sql, 'SELECT') === 0) {
                if ($singleRow) {
                    return $stmt->fetch();
                } else {
                    return $stmt->fetchAll();
                }
            } else {
                return $stmt->rowCount();
            }
        } else {
            return false;
        }
    } catch (Exception $e) {
        throw $e;
    }
}

//ログインしていたらセッション情報からユーザー名を取得
function getUserName()
{
    if (isset($_SESSION["user_name"])) {
        $user_name = $_SESSION["user_name"];
        return  $user_name;
    } else {
        return "";
    }
}

//ログインしていたら挨拶する
function helloUser($user_name)
{
    if (!empty($user_name)) {
        $message =  'こんにちは、' . $user_name . 'さん';
        return $message;
    }
}

//SQL実行
function sqlFetch($sql)
{
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute();
        if ($result) {
            return $stmt->fetchColumn();
        } else {
            throw new Exception("データベースエラー");
        }
    } catch (Exception $e) {
        throw $e;
    }
}

//商品数をカウント
function getProductCount($public_flg = null)
{
    $sql =
        'SELECT COUNT(*) product_id 
    FROM ec_product_table_test';
    switch ($public_flg) {
        case null:
            echo "すべての商品をカウントしました";
            break;
        case 0:
            $sql = $sql . ' WHERE public_flg = 0';
            break;
        default:
            $sql = $sql . ' WHERE public_flg = 1';
            break;
    }
    return sqlFetch($sql);
}
