<p>メールアドレスとパスワードを記入してログインしてください。</p>
<p>入会手続きがまだの方はこちらからどうぞ。</p>
<p>&raquo;<a href="./register.php">ユーザー登録をする</a></p>
<div class="form_container">
    <form action="" method="post">
        <dl>
            <div class="form-group">
                <dt>ユーザー名：<span class="required">必須</span>(半角英数またはアンダースコアで5文字以上)</dt>
                </dt>
                <dd>
                    <input type="text" name="user_name" size="15" maxlength="20" pattern="[a-zA-Z0-9_]+" minlength="5"
                        required />
                </dd>
            </div>
            <div class="form-group">
                <dt>パスワード：<span class="required">必須</span>(半角英数またはアンダースコアで8文字以上)</dt>
                </dt>
                <dd>
                    <input type="password" name="password" size="15" maxlength="30" minlength="8"
                        pattern="[a-zA-Z0-9_]+" required />
                </dd>
            </div>
        </dl>
        <input type="submit" value="ログインする" />
    </form>
</div>