<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>work15</title>
</head>

<body>
    <?php
    $class1 = [
        ['tokugawa', rand(1, 100)],
        ['oda', rand(1, 100)],
        ['toyotomi', rand(1, 100)],
        ['takeda', rand(1, 100)]
    ];

    $class2 = [
        ['minamoto', rand(1, 100)],
        ['taira', rand(1, 100)],
        ['sugawara', rand(1, 100)],
        ['fujiwara', rand(1, 100)]
    ];
    $school = [$class1, $class2];
    $odascore = $school[0][1][1];
    $sugawarascore = $school[1][2][1];
    echo '<p> odaさんの点数は' . $odascore . '点です。</p>';
    echo '<p> sugawaraさんの点数は' . $sugawarascore . '点です。</p>';
    if ($odascore < $sugawarascore):
        echo "sugawaraさんの方が点数が高い<br>";
    elseif ($odascore > $sugawarascore):
        echo "odaさんの方が点数が高い<br>";
    else:
        echo "二人の点数は同じ<br>";
    endif;
    $totalscoreclass = array();
    for ($a = 0; $a < count($school); $a++):
        $currentclass = $school[$a];
        $classmatecount = count($currentclass);
        $totalscoreclass[$a] = 0;
        for ($i = 0; $i < $classmatecount; $i++):  // クラスごとの人数でループ
            $currentclassmate = $currentclass[$i];
            $totalscoreclass[$a] += $currentclassmate[1];
        endfor;
    endfor;
        if (count($school[0]) > 0) {
            $avarage1 = round($totalscoreclass[0] / count($school[0]), 2);
        }
        if (count($school[1]) > 0) {
            $avarage2 = round($totalscoreclass[1] / count($school[1]), 2);
        }


    echo '<p>クラス1の平均点は' . $avarage1 . 'です</p>';
    echo $totalscoreclass[0] . 'は1クラスの合計点<br>';
    echo '<p>クラス2の平均点は' . $avarage2 . 'です</p>';
    echo $totalscoreclass[1] . 'は2クラスの合計点<br>';
    echo count($school[0]) . 'はクラス1の人数<br>';
    echo count($school[1]) . 'はクラス2の人数<br>';

    ?>
    <pre>
        <?php
        print_r($school);
        print_r($school[0][2]);
        ?>
    </pre>
</body>

</html>