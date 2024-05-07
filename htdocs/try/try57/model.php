<?php
/**
 * DB接続をしてPDOインスタンスを返す
 *
 *
 *@return object $pdo
 */
function get_connection() {
    try{
      // PDOインスタンスの生成
     $pdo = new PDO('mysql:host=localhost;dbname=xb513874_u338x', 'xb513874_fpu2g', 'mj3mt8vtwv');
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

 function get_sql_result($pdo, $sql){
    $data = [];
    if($result = $pdo->query($sql)){
        if($result->rowCount() > 0){
            while($row = $result->fetch()){
                $data[] = $row;
            }
        }
    }
    return $data;
 }

 /**
  * 全商品の商品名データ取得
  *
  *@param object
  *@return array  
  */

 function get_product_list($pdo){
    $sql = "SELECT product_name, price FROM product";
    return get_sql_result($pdo,$sql);
}


 /**
  * htmlspecialchars(特殊文字の変換)のラッパー関数
  *繰り返し使用するので、引数指定の繰り返しなど省略できるようにする
  *
  *@param string
  *@return string  
  */
function h($str){
    return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
}

/**
*特殊文字の変換(二次元配列対応)
*二次元配列で上のh()を使える様にするもの
*
*@param array
*@return array
*/

  function h_array($array){
    //二次元配列をforeachでループさせる
    foreach($array as $keys=>$values){
        foreach($values as $key=>$value){
            //ここの値にh関数を使用して置き換える
            $array[$keys][$key] = h($value);
        }
    }
    return $array;
  }