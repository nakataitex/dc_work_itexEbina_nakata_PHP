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
        //DBログイン情報
        $dsn = 'mysql:host=localhost;dbname=xb513874_u338x';
        $login_user = 'xb513874_fpu2g';
        $password = 'mj3mt8vtwv';
        // PDOインスタンスの生成
        $pdo = new PDO($dsn, $login_user, $password);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
    return $pdo;
}


/**
 * SQL文を実行・結果を配列で取得する
 * 
 * @param object $pdo
 * @param string $sql 実行されるSQL文章
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
    return add_dir_to_list($data);
}


/**
 * 画像データ取得
 *
 *@param object
 *@return array  
 */

function get_image_list($pdo)
{
    $sql = "SELECT * FROM image_sharing";
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
 * @param dir 保存ディレクトリを指定
 * @param array 画像一覧のデータ
 * @return array 画像一覧のデータにディレクトリを追加
 * 
 */
function add_dir_to_list($array)
{
    $dir = "./img/";    //画像のディレクトリ指定
    foreach ($array as $key => $value):
        $array[$key]["dir"] = $dir . $value["file_name"];
    endforeach;
    return $array;
}

/**
 * 
 * 
 */


/**
 * 表示切替ボタンの文字列の割り当て
 * 
 * 
 */
function public_button_and_class($array){
    switch ($array["public_flg"]):
        case 1:
            $public_message = "非表示にする";
            $public_class = "public";
            break;
        case 0:
            $public_message = "表示する";
            $public_class = "private";
            break;
        default:
            $public_message = "ステータス異常(非公開にする)";
            $public_class = "private";
            break;
    endswitch;
return ["public_message" =>$public_message, "public_class" => $public_class];
}
