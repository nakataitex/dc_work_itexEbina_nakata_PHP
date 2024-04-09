<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TRY19</title>
</head>
<body>
    <?php

        $class1 = ['tokugawa','oda','toyotomi','takeda'];
        $class2 = ['minamoto','taira','sugawara','fujiwara'];
        $school = [$class1, $class2];
        $a = 0;//現在のクラス管理
        $b = 0;//現在の生徒管理
 //       $odascore = 0;
   //     $sugawarascore = 0;
        $schoolmate = count($school, COUNT_RECURSIVE);//生徒総数
        $classcount = count($school);//クラス数
        $scores = array();//点数格納用のarray
        while($a < $classcount):
            while($b < count($school[$a])):
                $scores[$a][$b] = rand(0,100);
                echo '<p>'.$school[$a][$b] .'さんのテストの点数は'.$scores[$a][$b].'点です</p>';
                switch ($school):
                    case ($school[0][1]):
                        echo '<p>'.$school[$a][$b] .'さんのテストの点数は'.$scores[$a][$b].'点です</p>';
                        break;
                    case ($school[1][2]):
                        break;
                    default:
                    echo '<p>'.$school[$a][$b] .'さんのテストの点数は'.$scores[$a][$b].'点です</p>';
                endswitch;
            $b++;
            endwhile;
            $a++;
        endwhile;
    ?>
    <pre>
        <?php
                    print_r($school);
                    print $school[0][2];
        ?>
    </pre>
</body>
</html>