<!DOCTYPE html>
<html lang='ja'>

<head>
    <meta charset='UTF-8'>
    <title>TRY20</title>
</head>

<body>
    <div>入力内容の取得</div>
    <?php
    if (isset($_GET['display_text']) && $_GET['display_text'] != '') {
        print '<p>入力した内容： ' . htmlspecialchars($_GET['display_text'], ENT_QUOTES, 'UTF-8') . '<p>';
    } else {
        print '<p>入力されていません</p>';
    }
    if(isset($_GET['checkbox'])) {
        $count = count($_GET['checkbox']);
        for ($i = 0; $i < $count; $i++) {
            echo '<p>' . htmlspecialchars($_GET['checkbox'][$i], ENT_QUOTES, 'UTF-8') . 'を選択</p>';
        }
    } else {
        echo '<p>選択なし</p>';
    };
    ?>
</body>
</html>