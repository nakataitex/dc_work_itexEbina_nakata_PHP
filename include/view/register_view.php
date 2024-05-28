<h1>会員登録</h1>
<p>登録に必要な事項をご記入ください。</p>
<div class="form_container">
    <form action="" method="POST">
        <dl>
            <div class="form-group">
                <dt>ユーザー名：<span class="required">必須</span>(半角英数で5文字以上)</dt>
                <dd>
                    <input type="text" name="user_name" pattern="[A-Za-z0-9_]+" minlength="5" required />
                </dd>
            </div>
            <div class="form-group">
                <dt>パスワード：<span class="required">必須</span>(半角英数で8文字以上)</dt>
                <dd>
                    <input type="password" name="password" pattern="[A-Za-z0-9_]+" minlength="8" required />
                </dd>
            </div>
        </dl>
        <input type="submit" value="登録する" />
    </form>
</div>