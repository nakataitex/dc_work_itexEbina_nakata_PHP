<?php

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
        $pdo = new PDO(DSN, LOGIN_USER, PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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


/**
 * 画像データ取得
 *
 *@param object
 *@return array  
 */

function get_product_list($pdo)
{
    $sql = "SELECT
     *
     FROM
         ec_product_table
         INNER JOIN ec_image_table
         ON ec_product_table.product_id = ec_image_table.product_id 
         JOIN ec_stock_table 
         ON ec_image_table.product_id = ec_stock_table.product_id;";
    return get_sql_result($pdo, $sql);
}





function logout()
{
    if (!empty($_POST["logout"]))
        if ($_SESSION["login"]) {
            echo "ログアウトテスト";
            $params = [
                "login",
                "user_id",
                "user_name"
            ];
            foreach ($params as $param) {
                if ($_SESSION[$param]) {
                    unset($_SESSION[$param]);
                }
            }
        }
}




/**
 * SQLのupdate,insert実行用のファンクション
 * 
 * @param string
 * @param array
 * @return object
 */
function sql_fetch_data($sql, $params)
{
    $pdo = get_connection();
    $pdo->beginTransaction();
    //SQL
    $stmt = $pdo->prepare($sql);

    //バインド
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $result = $stmt->execute();
    if ($result) {
        $pdo->commit();
    } else {
        $pdo->rollBack();
    }
    return $result;
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
function validation($input, $min_length)
{
    $errors = [];
    if ($input === "") {
        $errors[] = "blank";
    } elseif (!preg_match('/^[A-Za-z0-9]+$/', $input)) {
        $errors[] = "string";
    }
    if ($input !== "" && strlen($input) < $min_length) {
        $errors[] = "length";
    }

    return $errors;
}


/**
 * 新規登録フォームにエラーメッセージを表示する
 * 
 * @param string
 * @param array
 * 
 */


function display_form_error($errorType, $errors)
{
    if (isset($errors[$errorType])) {
        foreach ($errors[$errorType] as $error) {
            if ($error === "blank") {
                echo '<p class="error">' . MSG_ERR_BLANK;
                if ($errorType === "name") {
                    echo MSG_ERR_LENGTH_NAME;
                } else if ($errorType === "password") {
                    echo MSG_ERR_LENGTH_PASSWORD;
                }
                echo '</p>';
            } elseif ($error === "length") {
                echo '<p class="error">';
                if ($errorType === "name") {
                    echo MSG_ERR_LENGTH_NAME;
                } else if ($errorType === "password") {
                    echo MSG_ERR_LENGTH_PASSWORD;
                }
                echo '</p>';
            } elseif ($error === "string") {
                echo '<p class="error">' . MSG_ERR_STRING . '</p>';
            }
            if ($error === "duplicate") {
                echo '<p class="error">' . MSG_ERR_DUPLICATE . '</p>';
            }
        }
    }
}




/**
 * 重複チェック
 * 
 * 
 * 
 */

function duplicate_check($count_function, $array)
{
    if ($count_function[0]["cnt"] > 0) {
        $array[] = "duplicate";
    }
    return $array;
}