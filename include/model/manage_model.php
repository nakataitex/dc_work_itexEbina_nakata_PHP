<?php
//管理者でなければログイン画面に遷移
function adminCheck()
{
    if (!isset($_SESSION["login"]) || !isset($_SESSION["user_name"]) || $_SESSION["user_name"] !== "ec_admin") {
        header("Location: ./login.php");
        exit();
    }
}

//在庫数更新のバリデーション
function manageIntValidation()
{
    if (isset($_POST["stock_qty"])) {
        if ($_POST["stock_qty"] < 0 || !is_numeric($_POST["stock_qty"])) {
            throw new Exception("在庫数は0以上の整数を指定してください");
        }
        if (isset($_POST["price"])) {
            if ($_POST["price"] < 0 || !is_numeric($_POST["price"])) {
                throw new Exception("在庫数は0以上の整数を指定してください");
            }
        }
    }
}

//商品登録のバリデーション
function validationAddProduct($pdo)
{
    if (
        !isset($_POST["product_name"]) || !isset($_POST["price"]) || !isset($_POST["stock_qty"]) ||
        !isset($_FILES["image"]) || !isset($_POST["public_flg"])
    ) {
        throw new Exception("すべての項目を入力してください");
    } else {
        //商品名
        $product_name = $_POST["product_name"];
        manageIntValidation();
        $public_flg = (int) $_POST["public_flg"];
        if ($public_flg !== 1 && $public_flg !== 0) {
            throw new Exception("公開・非公開のステータスが不正です");
        }
        $temp_file = $_FILES["image"]["tmp_name"];
        if (exif_imagetype($temp_file) !== IMAGETYPE_JPEG && exif_imagetype($temp_file) !== IMAGETYPE_PNG) {
            throw new Exception("対応している画像を選択してください(jpg/jpegまたはpng)");
        }
        $duplicate_check_sql = "SELECT count(*) count from ec_product_table where product_name = :product_name";
        $stmt = $pdo->prepare($duplicate_check_sql);
        $stmt->bindValue(":product_name", $product_name);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        $count_int = (int) $count;
        if ($count_int > 0) {
            throw new Exception("既に登録された商品です");
        }
    }
}

//商品を登録
function addProductToDatabase($pdo)
{
    try {
        $pdo->beginTransaction();
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
            throw new Exception("このファイル形式には対応していません");
        }
        $upload_file = IMG_DIR . $image_name;
        if (!move_uploaded_file($temp_file, $upload_file)) {
            throw new Exception("画像のアップロードに失敗しました");
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
            if (insertImage($product_data) && insertStock($product_data)) {
                $pdo->commit();
                $message = "商品の追加に成功しました";
                return $message;
            } else {
                throw new Exception("商品の追加に失敗しました");
            }
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        throw new Exception('データベースエラー');
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
        $success = sqlFetchData($sql, $param);
        return $success;
    } catch (PDOException $e) {
        throw new Exception("データベースエラー:商品の登録に失敗しました");
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
        $success = sqlFetchData($sql, $param);
        return $success;
    } catch (PDOException $e) {
        throw new Exception("データベースエラー：画像の登録に失敗しました");
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
        $success = sqlFetchData($sql, $param);
        return $success;
    } catch (PDOException $e) {
        throw new Exception("データベースエラー：在庫の登録に失敗しました");
    }
}

//商品の公開ステータス切り替え処理
function togglePublicManage($pdo)
{
    try {
        $pdo->beginTransaction();
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
        $result = sqlFetchData($sql, $param);
        if ($result) {
            $pdo->commit();
            $message = "公開ステータスの切り替えに成功しました";
            return $message;
        } else {
            $pdo->rollBack();
            throw new Exception("データベースエラー");
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        throw new Exception("商品の追加に失敗した為処理を取り消します");
    }
}

//商品を削除するクエリ
function deleteProductManage($pdo)
{
    try {
        $pdo->beginTransaction();
        $select_sql = "SELECT i.image_name FROM ec_product_table p INNER JOIN ec_image_table i ON p.product_id = i.product_id  WHERE p.product_id = :product_id";
        $product_id = $_POST["product_id"];
        $param = [":product_id" => $product_id];
        $get_image_name = sqlFetchData($select_sql, $param, true);
        $image_name = $get_image_name["image_name"];
        $delete_sql = "DELETE FROM ec_product_table WHERE product_id = :product_id";
        $result = sqlFetchData($delete_sql, $param);
        if ($result) {
            unlink(IMG_DIR . $image_name);
            $pdo->commit();
            $message = "商品の削除に成功しました";
            return $message;
        } else {
            $pdo->rollBack();
            throw new Exception("データベースエラー");
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        throw new Exception('データベースエラー');
    }
}

//在庫数を変更する処理
function updateQty($pdo)
{
    try {
        $pdo->beginTransaction();
        $sql = "UPDATE ec_stock_table SET stock_qty =:stock_qty WHERE product_id =:product_id";
        $product_id = $_POST["product_id"];
        $stock_qty = $_POST["stock_qty"];
        $param = [
            ":product_id" => $product_id,
            ":stock_qty" => $stock_qty
        ];
        $result = sqlFetchData($sql, $param);
        if ($result) {
            $pdo->commit();
            $message = "在庫数を変更しました";
            return $message;
        } else {
            $pdo->rollBack();
            throw new Exception("在庫数を変更出来ませんでした");
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        throw new Exception("データベースエラー");
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
    return sqlFetchData($sql);
}