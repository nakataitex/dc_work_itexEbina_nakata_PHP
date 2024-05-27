<?php
//ログインしていなければログイン画面に遷移する
function login_check(){
    if (!isset($_SESSION["login"]) || !isset($_SESSION["user_name"]) || $_SESSION["user_name"] === "ec_admin") {
        header("Location: ./ec_login.php");//管理者以外はログインページへ移動、ログインしてる場合はその後index.phpに移動
        exit();
    }
}

/**
 * DB接続をしてPDOインスタンスを返す
 *
 *
 *@return object $pdo
 */

function get_connection()
{
    try {
        // PDOインスタンスの生成
        $pdo = new PDO(DSN, LOGIN_USER, LOGIN_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
    return $pdo;
}

/**
 * SQL文を実行・結果を配列で取得する
 * 
 * @param object 
 * @param string  実行されるSQL文章
 * @return array 結果セットの配列
 */

function get_sql_result($pdo, $sql)
{
    $data = [];
    if ($result = $pdo->query($sql)) {
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch()) {
                $data[] = $row;
            }
        }
    }
    return $data;
}

function sql_fetch_data($sql, $params)
{
    $pdo = get_connection();
    $pdo->beginTransaction();
    $stmt = $pdo->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $result = $stmt->execute();
    if ($result) {
        if (strpos(strtoupper($sql), 'SELECT') !== false) {
            if ($stmt->rowCount() === 1) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);  // 結果が1行だけの場合はfetchを実行
            } else {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);  // 結果が複数行の場合はfetchAllを実行
            }
        } else {
            $data = $stmt->rowCount();  // INSERT、UPDATE、DELETEの場合は影響を受けた行数を返す
        }
        $pdo->commit();
    } else {
        $pdo->rollBack();
        $data = false;  // クエリが失敗した場合はfalseを返す
    }
    return $data;
}

/**
 * htmlspecialchars(特殊文字の変換)のラッパー関数
 *繰り返し使用するので、引数指定の繰り返しなど省略できるようにする
 *
 *@param string
 *@return string  
 */
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

/**
 *特殊文字の変換(二次元配列対応)
 *二次元配列で上のh()を使える様にするもの
 *
 *@param array
 *@return array
 */
function h_array($array)
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

/**
 * フォームチェック
 * 名前とパスワードのチェックを行う
 * 
 * 
 */
function validation_user_password($input, $min_length)
{
    $errors = [];
    if (!preg_match("/^[a-zA-Z0-9_]+$/", $input)) {
        $errors[] = "string";
    }
    if (strlen($input) < $min_length) {
        $errors[] = "length";
    }
    return $errors;
}

//データベースに接続し、重複チェックを行う
function duplicate_check($sql, $params)
{
    try {
        $pdo = get_connection();
        $stmt = $pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

//今日の日付をタイムゾーンAsia/Tokyoで取得し"Y-m-d"形式で返す
function current_date()
{
    date_default_timezone_set("Asia/Tokyo");
    return date("Y-m-d");
}

//メッセージの種類を受取り、すべて画面に表示する
function display_message($messages, $message_list)
{
    if (!empty($messages) && !empty($message_list)) {
        echo '<div class="message_area">';
        foreach ($messages as $type => $fields) {
            if (isset($message_list[$type])) {
                foreach ($fields as $field => $statuses) {
                    if (isset($message_list[$type][$field])) {
                        foreach ($statuses as $status) {
                            if (isset($message_list[$type][$field][$status])) {
                                echo '<p class="' . $type . '_message">' . $message_list[$type][$field][$status] . '</p>';
                            }
                        }
                    }
                }
            }
        }
        echo '</div>';
    }
}


//正の数、かつ整数であるかのバリデーション
function validation_int($value)
{
    if (filter_var($value, FILTER_VALIDATE_INT) !== false && $value >= 0) {
        return true;
    }
    return false;
}

//DBから受け取った結果が単一だった場合配列化して他の関数で流用出来るようにする
function array_convert_product_data($data){
    if(isset($data["product_id"])){
        $data = [$data];
    }
    return $data;
}