<?php
 $check_data = '';
if(isset($_POST["check_data"])):
    $check_data = htmlspecialchars($_POST["check_data"],ENT_QUOTES,"UTF-8");
endif;
 
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>try25</title>
</head>
<body>
    <form method="post">
        <div>半角英数で入力して</div>
        <input type="text" name="check_data" value = <?php echo $check_data ?>>
        <input type="submit" value="送信">
    </form>
    <?php
    if(!preg_match("/^[a-zA-Z0-9]+$/", $check_data) && $check_data !== ''):
        echo '<div>半角英数字以外が入力されてる</div>';
    elseif($check_data == ''):
        echo("<div>何も入力されていない</div>");
    endif;
?>

</body>
</html>