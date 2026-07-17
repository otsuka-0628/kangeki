<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    @vite([
        'resources/css/app.css',
    ])
</head>

<body>
    <div class="lr-bg" style="background-image: url('{{ asset('images/lr-background.jpg') }}')">
        <section class=login-form>
            <div class="form-root">
                <img class="login-logo" src="images/logo-black.png">
                <form action="/user-login" method="post">
                    @csrf
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
                    <input type="text" name="userID" placeholder="ユーザーID（メールアドレス）">

                    <div class="password-group">
                        <input type="password" name="password" placeholder="パスワード">
                        <a href="{{ route('forgot-password') }}" class="forgot-link">パスワードを忘れた</a>
                    </div>

                    <input type="submit" value="ログイン">
                </form>
            </div>
        </section>
    </div>
</body>

</html>