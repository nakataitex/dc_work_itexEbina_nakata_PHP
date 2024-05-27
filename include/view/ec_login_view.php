<h1>ログインする</h1>
<p>メールアドレスとパスワードを記入してログインしてください。</p>
<p>入会手続きがまだの方はこちらからどうぞ。</p>
<p>&raquo;<a href="./ec_register.php">ユーザー登録をする</a></p>
<div class="form_container">
    <form action="" method="post">
        <dl>
            <div class="form-group">
                <dt>ユーザー名</dt>
                <dd>
                    <input type="text" name="name" size="15" maxlength="255" value="<?php echo h($user); ?>"
                        pattern="[a-zA-Z0-9_]+" required />
                </dd>
            </div>
            <div class="form-group">
                <dt>パスワード</dt>
                <dd>
                    <input type="password" name="password" size="15" maxlength="255" value="<?php echo h($password); ?>"
                        pattern="[a-zA-Z0-9_]+" required />
                </dd>
            </div>
        </dl>
        <input type="submit" value="ログインする" />
    </form>
</div>