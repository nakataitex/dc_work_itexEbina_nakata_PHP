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
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
    return $pdo;
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
