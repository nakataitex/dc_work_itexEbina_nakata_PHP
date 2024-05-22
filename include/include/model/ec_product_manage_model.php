<?php
/**
 * 表示切替ボタンの文字列の割り当て
 * 
 * @param array
 * @return array
 */
function get_public_button_and_class($array)
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
    return ["public_button" => $public_button, "public_class" => $public_class, "public_status" => $public_status];
}

//商品登録
function insert_product($pdo, $form)
{
    try {
        $sql = "INSERT INTO ec_product_table (product_name, price, public_flg, create_date) VALUES (:product_name, :price, :public_flg, :create_date)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":product_name", $form["product_name"]);
        $stmt->bindValue(":price", $form["price"]);
        $stmt->bindValue(":public_flg", $form["public_flg"]);
        $stmt->bindValue(":create_date", current_date());
        $success = $stmt->execute();
        return $success;
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
}

//画像登録
function insert_image($pdo, $form)
{
    try {
        $sql = "INSERT INTO ec_image_table (product_id, image_name, create_date) VALUES (:product_id,:image_name,:create_date)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":product_id", $form["product_id"]);
        $stmt->bindValue(":image_name", $form["image_name"]);
        $stmt->bindValue(":create_date", current_date());
        $success = $stmt->execute();
        return $success;
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
}

//在庫数登録
function insert_stock($pdo, $form)
{
    try {
        $sql = "INSERT INTO ec_stock_table (product_id, stock_qty,create_date) VALUES(:product_id, :stock_qty, :create_date)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":product_id", $form["product_id"]);
        $stmt->bindValue(":stock_qty", $form["stock_qty"]);
        $stmt->bindValue(":create_date", current_date());
        $success = $stmt->execute();
        return $success;
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
}