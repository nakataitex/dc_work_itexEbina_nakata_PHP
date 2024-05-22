<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[ECサイト]ログイン画面</title>
</head>

<body>
    <h1>ログインする</h1>
    </div>
    <p>メールアドレスとパスワードを記入してログインしてください。</p>
    <p>入会手続きがまだの方はこちらからどうぞ。</p>
    <p>&raquo;<a href="./ec_register.php">ユーザー登録をする</a></p>
    </div>
    <form action="" method="post">
        <dl>
            <dt>ユーザー名</dt>
            <dd>
                <input type="text" name="name" maxlength="255" value="<?php echo h($user); ?>" pattern="[a-zA-Z0-9_]+"
                    required />
            </dd>
            <dt>パスワード</dt>
            <dd>
                <input type="password" name="password" size="35" maxlength="255" value="<?php echo h($password); ?>"
                    pattern="[a-zA-Z0-9_]+" required />
            </dd>
        </dl>
        <div>
            <input type="submit" value="ログインする" />
            <?php
            display_message($message, $message_list) ?>
        </div>
    </form>
    </div>
    </div>
</body>

</html>