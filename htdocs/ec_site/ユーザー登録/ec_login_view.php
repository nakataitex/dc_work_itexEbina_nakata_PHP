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
                <p>&raquo;<a href="ec_register.php">ユーザー登録をする</a></p>
            </div>
            <form action="" method="post">
                <dl>
                    <dt>ユーザー名</dt>
                    <dd>
                        <input type="text" name="name" maxlength="255" value="<?php echo h($user); ?>" pattern="[A-Za-z0-9]+" minlength="5" required/> 
                        <?php display_form_error("name", $error); ?>
                    </dd>
                    <dt>パスワード</dt>
                    <dd>
                        <input type="password" name="password" size="35" maxlength="255" value="<?php echo h($password); ?>" pattern="[A-Za-z0-9]+" minlength="8" required/> 
                        <?php display_form_error("password", $error); ?>
                    </dd>
                </dl>
                <div>
                    <input type="submit" value="ログインする" />
                </div>
            </form>
        </div>
    </div>
</body>
</html>