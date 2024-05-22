<?php
//商品をカートに追加
function insert_cart($pdo, $form)
{
    try {
        $pdo->beginTransaction();
        $sql = "INSERT INTO ec_cart_table (user_id, product_id, product_qty, create_date) VALUES (:user_id, :product_id, :product_qty, :create_date)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":user_id", $form["user_id"]);
        $stmt->bindValue(":product_id", $form["product_id"]);
        $stmt->bindValue(":product_qty", $form["product_qty"]);
        $stmt->bindValue(":create_date", current_date());
        $success = $stmt->execute();
        if ($success) {
            $pdo->commit();
        }
        return $success;
    } catch (PDOException $e) {
        echo $e->getMessage();
        $pdo->rollBack();
        exit();
    }
}

//画像登録
function insert_($pdo, $form)
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
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
}