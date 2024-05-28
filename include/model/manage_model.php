<?php
//管理者でなければログイン画面に遷移
function adminCheck()
{
    if (!isset($_SESSION["login"]) || !isset($_SESSION["user_name"]) || $_SESSION["user_name"] !== "ec_admin") {
        header("Location: ./login.php");
        exit();
    }
}

//商品登録のバリデーション
function validationAddProduct($pdo, $message)
{
    $message = $message ?? [];
    $product_name = $_POST["product_name"];
    $price = (int) $_POST["price"];
    $stock_qty = (int) $_POST["stock_qty"];
    $public_flg = (int) $_POST["public_flg"];
    $temp_file = $_FILES["image"]["tmp_name"];
    $duplicate_check_sql = "SELECT count(*) count from ec_product_table where product_name = :product_name";
    $stmt = $pdo->prepare($duplicate_check_sql);
    $stmt->bindValue(":product_name", $product_name);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    $count_int = (int) $count;
    if (!isset($product_name)) {
        $message[] = "商品名を入力してください";
    }
    if ($count_int > 0) {
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
}


//商品を登録
function addProductToDatabase($pdo, $error_message)
{
    var_dump($error_message);
    $error_message = $error_message ?? [];
    
    $product_name = $_POST["product_name"];
    $price = $_POST["price"];
    $stock_qty = $_POST["stock_qty"];
    if (isset($_POST["public_flg"]) && $_POST["public_flg"] === "public") {
        $public_flg = 1;
    } else {
        $public_flg = 0;
    }
    $temp_file = $_FILES["image"]["tmp_name"];
    if (exif_imagetype($temp_file) === IMAGETYPE_JPEG) {
        $image_name = uniqid() . '.jpg';
    } elseif (exif_imagetype($temp_file) === IMAGETYPE_PNG) {
        $image_name = uniqid() . '.png';
    } else {
        $error_message[] = "このファイル形式には対応していません";
    }
    $upload_file = IMG_DIR . $image_name;
    if (!move_uploaded_file($temp_file, $upload_file)) {
        $error_message[] = "画像のアップロードに失敗しました";
    }
    $product_data = [
        ":product_name" => $product_name,
        ":price" => $price,
        ":stock_qty" => $stock_qty,
        ":image_name" => $image_name,
        ":public_flg" => $public_flg,
        ":create_date" => currentDate()
    ];
    if (insertProduct($product_data)) {
        $product_data[":product_id"] = $pdo->lastInsertId();
        if (!insertImage($product_data) || !insertStock($product_data)) {
            return $error_message[] = "データベースに登録出来ませんでした";
        }
    }
}

//商品登録クエリ
function insertProduct($form)
{
    try {
        $sql = "INSERT INTO ec_product_table (product_name, price, public_flg, create_date) VALUES (:product_name, :price, :public_flg, :create_date)";
        $param = [
            ":product_name" => $form[":product_name"],
            ":price" => $form[":price"],
            ":public_flg" => $form[":public_flg"],
            ":create_date" => $form[":create_date"]
        ];
        $success = sql_fetch_data($sql, $param);
        return $success;
    } catch (PDOException $e) {
        throw $e;
    }
}

//画像登録クエリ
function insertImage($form)
{
    try {
        $sql = "INSERT INTO ec_image_table (product_id, image_name, create_date) VALUES (:product_id,:image_name,:create_date)";
        $param = [
            ":product_id" => $form[":product_id"],
            ":image_name" => $form[":image_name"],
            ":create_date" => $form[":create_date"]
        ];
        $success = sql_fetch_data($sql, $param);
        return $success;
    } catch (PDOException $e) {
        throw $e;
    }
}

//在庫数登録クエリ
function insertStock($form)
{
    try {
        $sql = "INSERT INTO ec_stock_table (product_id, stock_qty,create_date) VALUES(:product_id, :stock_qty, :create_date)";
        $param = [
            ":product_id" => $form[":product_id"],
            ":stock_qty" => $form[":stock_qty"],
            ":create_date" => $form[":create_date"]
        ];
        $success = sql_fetch_data($sql, $param);
        return $success;
    } catch (PDOException $e) {
        throw $e;
    }
}

//商品登録処理
function addProductManage($error_message)
{
    try {
        $pdo = getConnection();
        $pdo->beginTransaction();
        $error_message[] = validationAddProduct($pdo, $error_message);
        if (empty($error_message)) {
            $error_message[] = addProductToDatabase($pdo, $error_message);
            if (empty($error_message)) {
                $pdo->commit();
            } else {
                $pdo->rollBack();
                $error_message[] = "商品の追加に失敗しました";
                return $error_message;
            }
        }
    } catch (PDOException $e) {
        $error_message[] = 'データベースエラー：' . $e->getMessage();
        $pdo->rollBack();
        return $error_message;
    }
}



//商品の公開ステータスを切り替えるクエリ
function togglePublic()
{
    $date = currentDate();
    $product_id = $_POST["product_id"];
    $sql =
        'UPDATE 
                ec_product_table 
            SET 
            public_flg = 1 - public_flg ,update_date = :update_date
            WHERE 
            product_id = :product_id';
    $param = [
        ":update_date" => $date,
        ":product_id" => $product_id
    ];
    $result = sql_fetch_data($sql, $param);
    return $result;
}

//商品の公開ステータス切り替え処理
function togglePublicManage($error_message)
{
    try {
        $pdo = getConnection();
        $pdo->beginTransaction();
        $result = togglePublic();
        if ($result) {
            $pdo->commit();
        }
    } catch (Exception $e) {
        $error_message[] = 'データベースエラー：' . $e->getMessage();
        $pdo->rollBack();
        return $error_message;
    }
}



//商品を削除するクエリ
function deleteProductManage($error_message)
{
    try {
        $pdo = getConnection();
        $pdo->beginTransaction();
        $select_sql = "SELECT i.image_name FROM ec_image_table i INNER JOIN ec_product_table p ON i.product_id = p.product_id  WHERE i.product_id = :product_id";
        $product_id = $_POST["product_id"];
        $param = [":product_id" => $product_id];
        $get_image_name = sql_fetch_data($select_sql, $param, true);
        $image_name = $get_image_name["image_name"];
        $delete_sql = "DELETE FROM ec_product_table WHERE product_id = :product_id";
        $result = sql_fetch_data($delete_sql, $param);
        if ($result && empty($error_message)) {
            unlink(IMG_DIR . $image_name);
            $pdo->commit();
        }
    } catch (Exception $e) {
        $error_message[] = 'データベースエラー：' . $e->getMessage();
        $pdo->rollBack();
        return $error_message;
    }
}

//在庫数を変更する処理
function updateQty($error_message)
{
    try {
        $pdo = getConnection();
        $pdo->beginTransaction();
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
        $pdo->commit();
    } catch (PDOException $e) {
        $error_message[] = 'データベースエラー：' . $e->getMessage();
        $pdo->rollBack();
    }
}

//管理する商品をリスト化
function getProducts()
{
    $sql = "SELECT
     * FROM ec_product_table 
    INNER JOIN ec_image_table 
    ON ec_product_table.product_id = ec_image_table.product_id 
    JOIN ec_stock_table 
    ON ec_image_table.product_id = ec_stock_table.product_id;";
    return sql_fetch_data($sql);
}