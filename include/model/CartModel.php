<?php
/* function validationBuy($pdo, $message)
{
    $message = [];
    $product_name = $_POST["product_name"];
    $price = $_POST["price"];
    $stock_qty = $_POST["stock_qty"];
    $public_flg = $_POST["public_flg"];
    $temp_file = $_FILES["image"]["tmp_name"];
    $duplicate_check_sql = "SELECT count(*) count from ec_product_table where product_name = :product_name";
    $stmt = $pdo->prepare($duplicate_check_sql);
    $stmt->bindValue(":product_name", $product_name);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    if (!isset($product_name)) {
        $message[] = "商品名を入力してください";
    }
    if ($count > 0) {
        $message[] = "既に登録された商品です";
    }
    if (!isset($price) || !is_numeric($price) || $price < 0) {
        $message[] = "価格を0以上の半角の整数を入力してください";
    }
    if (!isset($stock_qty) || !is_numeric($stock_qty) || $stock_qty < 0) {
        $message[] = "在庫数を0以上の半角の整数を入力してください";
    }
    if (exif_imagetype($temp_file) !== IMAGETYPE_JPEG && exif_imagetype($temp_file) !== IMAGETYPE_PNG) {
        $message[] = "対応している画像を選択してください(jpgまたはpng)";
    }
    if (!isset($public_flg)) {
        $message[] = "公開・非公開のステータスが異常です";
    }
    return $message;
} */

//カートの中を取得する
function getCart()
{
    $sql = "SELECT
    p.product_id,i.image_name,p.product_name,p.price,c.product_qty FROM ec_cart_table c
       INNER JOIN ec_product_table p
       ON c.product_id = p.product_id 
       JOIN ec_image_table i
       ON p.product_id = i.product_id
       WHERE c.user_id = :user_id;";
    $user_id = $_SESSION["user_id"];
    $param = [
        ":user_id" => $user_id
    ];
    return sql_fetch_data($sql, $param);
}

updateCartQty(){
//ここから

}


//商品を選んで在庫数を変更する
function updateQty($error_message)
{
    try {
        $sql = "UPDATE ec_stock_table SET stock_qty =:stock_qty WHERE product_id =:product_id";
        $product_id = $_POST["product_id"];
        $stock_qty = $_POST["stock_qty"];
        $param = [
            ":product_id" => $product_id,
            ":stock_qty" => $stock_qty
        ];
        $row = sql_fetch_data($sql, $param);
        if (!$row) {
            $error_message[] = "在庫数が変更されませんでした";
            return $error_message;
        }
    } catch (PDOException $e) {
        throw $e;
    }
}


//カートから商品を選んでDBから削除する
function deleteFromCart($message)
{
    try {

        $product_id = $_POST["product_id"];
        $user_id = $_SESSION["user_id"];
        $delete_sql = "DELETE FROM ec_cart_table WHERE product_id = :product_id AND user_id = :user_id";
        $param = [
            ":product_id" => $product_id,
            ":user_id" => $user_id
    ];
        $delete = sql_fetch_data($delete_sql, $param);
        if ($delete) {
            $message[] = "データベースから商品を削除しました";
            return $message;
        }
    } catch (PDOException $e) {
        throw $e;
    }
}