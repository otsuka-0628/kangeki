<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワード再設定</title>
    @vite([
        'resources/css/app.css',
    ])
</head>

<body>
    <div class="lr-bg" style="background-image: url('{{ asset('images/lr-background.jpg') }}')">
        <section class=login-form>
            <div class="form-root">
                <img class="login-logo" src="{{ asset('images/logo-black.png') }}">
                <form action="/password/update" method="post">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="error-container">
                        @error('userID')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                        @error('password')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                        @error('login_error')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                    <input type="text" name="userID" value="{{ old('userID', request('email') ?? '') }}"
                        placeholder="ユーザーID（メールアドレス）">
                    <div class="reset-password-group">
                        <input type="password" name="password" placeholder="新しいパスワード（8文字以上）">
                        <input type="password" name="password_confirmation" placeholder="パスワード（確認用）">
                    </div>

                    <input type="submit" value="パスワードを更新">
                </form>
            </div>
        </section>
    </div>
</body>

</html>