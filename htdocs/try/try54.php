<?php
    session_start();
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>try54</title>
</head>
<body>
    <?php
    var_dump($_SESSION);
    echo "<br>";
    echo "<br>";
    $_SESSION["id"] =1;
    $_SESSION["username"] = "login_user";
    $_SESSION["year"] = date("Y");
    var_dump($_SESSION);
    echo "<br>";
    echo "<br>";

    unset($_SESSION["username"]);
    var_dump($_SESSION);
    ?>
</body>
</html>