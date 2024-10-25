<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>work18</title>
</head>

<body>
    <?php
    define("MAX", "3");//１ページの表示件数
    
    $customers = array(//表示データの配列
        array("name" => "佐藤", "age" => "10"),
        array("name" => "鈴木", "age" => "15"),
        array("name" => "高橋", "age" => "20"),
        array("name" => "田中", "age" => "25"),
        array("name" => "伊藤", "age" => "30"),
        array("name" => "渡辺", "age" => "35"),
        array("name" => "山本", "age" => "40")
    );

    $customers_num = count($customers);//顧客の総数
    $max_page = ceil($customers_num / MAX);


    //以下データ表示、ページネーションを実装
    if (!isset($_GET["page"])) {//現在のページがなければ1ページにする
        $now = 1;
    } else {
        $now = $_GET["page"];//あるならそのページを表示
    }
    ;
    $start_no = ($now - 1) * MAX;//何番目の配列から取得するか
    
    //array_slice・・・配列の何番目($start_no)から何番目(max)まで切り取る関数
    $disp_data = array_slice($customers, $start_no, MAX);

    $disp_count = count($disp_data);
    for ($i = 0; $i < $disp_count; $i++) {
        $val = $disp_data[$i];
        //      echo $val['name']. ' ' . $val['age']. '<br>';
        echo htmlspecialchars($disp_data[$i]["name"], ENT_QUOTES) . ' ' . htmlspecialchars($disp_data[$i]['age'], ENT_QUOTES) . '<br>';
    }
    $a = 0;
    $b = $a + 1;
    for ($a = 1; $a <= $max_page; $a++) {//最大ページ分のリンク作成
        echo '<a href="?page=' . $a . '">' . $a . 'ページ </a>';
    }
    ;
    ?>
</body>

</html>