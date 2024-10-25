<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Classroom Scores Simplified</title>
</head>

<body>
    <?php
    // 各生徒にランダムな点数を割り当て
    $class01 = [
        ['tokugawa', rand(1, 100)],
        ['oda', rand(1, 100)],
        ['toyotomi', rand(1, 100)],
        ['takeda', rand(1, 100)],
    ];
    $class02 = [
        ['minamoto', rand(1, 100)],
        ['taira', rand(1, 100)],
        ['sugawara', rand(1, 100)],
        ['fujiwara', rand(1, 100)],
    ];

    // class01とclass02をschool配列に格納
    $school = [$class01, $class02];

    // odaさんとsugawaraさんの点数を比較
    $odaScore = $school[0][1][1]; // class01のodaの点数
    $sugawaraScore = $school[1][2][1]; // class02のsugawaraの点数
    echo 'odaさんの点数: ' . $odaScore . '<br>';
    echo 'sugawaraさんの点数: ' . $sugawaraScore . '<br>';

    if ($odaScore > $sugawaraScore) {
        echo "odaさんの点数が高いです。<br>";
    } elseif ($odaScore < $sugawaraScore) {
        echo "sugawaraさんの点数が高いです。<br>";
    } else {
        echo "odaさんとsugawaraさんの点数は同じです。<br>";
    }

    // 各クラスの平均点を計算して出力（関数、foreach文を使用しない）
    // class01の平均点
    $totalScoreClass01 = 0;
    for ($i = 0; $i < count($class01); $i++) {
        $totalScoreClass01 += $class01[$i][1];
    }
    $averageClass01 = $totalScoreClass01 / count($class01);
    echo "class01の平均点: " . $averageClass01 . "<br>";

    // class02の平均点
    $totalScoreClass02 = 0;
    for ($i = 0; $i < count($class02); $i++) {
        $totalScoreClass02 += $class02[$i][1];
    }
    $averageClass02 = $totalScoreClass02 / count($class02);
    echo "class02の平均点: " . $averageClass02 . "<br>";
    ?>
</body>

</html>