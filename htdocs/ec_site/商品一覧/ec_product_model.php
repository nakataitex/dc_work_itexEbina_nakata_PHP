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
    return add_dir_to_result($data);
}


/**
 * 画像データ取得
 *
 *@param object
 *@return array  
 */

function get_product_list($pdo)
{
    $sql = PRODUCT_MANAGEMENT;
    return get_sql_result($pdo, $sql);
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
 * 画像一覧にディレクトリ配列追加
 * @param object 保存ディレクトリを指定
 * @param array 画像一覧のデータ
 * @return array 画像一覧のデータにディレクトリを追加
 * 
 */
function add_dir_to_list($array)
{
    $dir = "./img/";    //画像のディレクトリ指定
    foreach ($array as $key => $value):
        $array[$key]["dir"] = $dir . $value["image_name"];
    endforeach;
    return $array;
}


/**
 * 表示切替ボタンの文字列の割り当て
 * 
 * @param array
 * @return array
 */
function public_button_and_class($array)
{
    switch ($array["public_flg"]):
        case 0:
            $public_button = "表示する";
            $public_class = "private";
            $public_status = "非公開";
            break;
        case 1:
            $public_button = "非表示にする";
            $public_class = "public";
            $public_status = "公開";
            break;
        default:
            $public_button = "ステータス異常(非公開にする)";
            $public_class = "private";
            $public_status = "ステータス異常";
            break;
    endswitch;
    return ["public_button" => $public_button, "public_class" => $public_class,"public_status" =>$public_status];
}