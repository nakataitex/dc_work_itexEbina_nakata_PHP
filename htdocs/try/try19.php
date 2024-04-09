<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TRY19</title>
</head>
<body>
    <?php
        $fruit = ['りんご', 'ばなな', 'ぶどう', 'もも'];
        $vegetable = ['きゃべつ', 'とまと', 'にんじん', 'なす'];
        $meat = ["うし","ぶた","とり","しか"];
        $food = array($fruit, $vegetable,$meat);
    ?>
    <pre>
        <?php
            print_r($food);
            print $food[2][2];
        ?>
    </pre>
</body>
</html>