<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TRY09</title>
</head>
<body>
   <?php
        $fruit01 = "りんご";
        $fruit02 = "バナナ";

        if($fruit01 == "りんご" && $fruit02 == "バナナ") {
            echo "<p>fruit01はリンゴで、かつ、frute02はバナナです!</p>";
        }
        if($fruit01 == "りんご" || $fruit02 = "りんご") {
            echo "<p>fruit01がりんご、あるいは、frute02がりんごのどちらかです!</p>";
        }
        if(!($fruit01 == "バナナ")) {
            echo "<p>fruit01はバナナではありません。</p>";
        }

        if($fruit01 == "りんご"){
            echo "<p?>これは".$fruit01."です。</p>";
        }

        if($fruit02 == "みかん" || $fruit02 == "バナナ"){
            echo "<p>これはみかんかバナナのどちらかです。</p>";
        }

    ?>
</body>
</html>