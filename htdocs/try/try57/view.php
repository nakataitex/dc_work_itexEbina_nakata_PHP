<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>try56</title>
    <style type="text/css">
        table,
        td,
        th {
            border: solid black 1px;
        }

        table {
            width: 150px;
        }

        caption {
            text-align: left;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <caption>商品一覧</caption>
            <th>商品名</th>
            <th>価格</th>
        </tr>
        <?php foreach ($product_data as $value) { ?>
            <tr>
                <td><?php print $value["product_name"]; ?></td>
                <td><?php print $value["price"]; ?></td>
            </tr>
        <?php }
        var_dump(get_sql_result($pdo, $sql)) ?>
    </table>
</body>

</html>