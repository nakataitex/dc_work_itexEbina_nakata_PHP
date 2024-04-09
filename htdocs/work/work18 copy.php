<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>work17</title>
</head>

<body>
    <?php
    define("MAX", "3");

    $customers = array(
        array("name" => "佐藤", "age" => "10"),
        array("name" => "鈴木", "age" => "15"),
        array("name" => "高橋", "age" => "20"),
        array("name" => "田中", "age" => "25"),
        array("name" => "伊藤", "age" => "30"),
        array("name" => "渡辺", "age" => "35"),
        array("name" => "山本", "age" => "40")
    );

    $customers_num = count($customers);
      $max_page = ceil($customers_num / MAX);



    if(!isset($_GET["page"])){
        $now = 1;
    }else{
        $now = $_GET["page"];
    };
    $start_no = ($now - 1)* MAX;


    $disp_data = array_slice($customers, $start_no,MAX,true);

    $disp_count = count($disp_data);
    for($i = 0; $i < $disp_count; $i++){
        $val = $disp_data[$i];
        echo $val['name']. ' ' . $val['age']. '<br>';
    }
    $b = $a + 1;
    for($a =0; $a < $max_page; $a++){
        $b = $a + 1;
        echo '<a href=?page='.$a.'>'.$b.'ページ </a>';
        };
    ?>;
</body>

</html>