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
 * SQL実行用のファンクション
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
    if($result){
        $pdo->commit();
    }else{
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
