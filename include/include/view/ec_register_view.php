<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[ECサイト]会員登録画面</title>
    <link rel="stylesheet" href="./css/register_style.css" />
</head>

<body>
    <div id="wrap">
        <div id="head">
            <h1>会員登録</h1>
        </div>
        <div id="content">
            <p>登録に必要な事項をご記入ください。</p>
            <form action="" method="POST">
                <dl>
                    <dt>ユーザー名<span class="required">必須</span>(半角英数で5文字以上)</dt>
                    <dd>
                        <input type="text" name="name" value="<?php echo h($form["name"]); ?>" pattern="[A-Za-z0-9_]+"
                        minlength="5" required/>
                    <dt>パスワード<span class="required">必須</span>(半角英数で8文字以上)</dt>
                    <dd>
                        <input type="password" name="password" value="<?php echo $form["password"] ?>" pattern="[A-Za-z0-9_]+" minlength="8" required/>
                    </dd>
                    </dd>
                </dl>
                <div><input type="submit" value="入力内容を確認する" /></div>
                <?php display_message($message, $message_list) ?>
            </form>
        </div>
</body>

</html>