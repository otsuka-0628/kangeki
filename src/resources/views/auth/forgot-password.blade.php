<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KANGEKI</title>
    @vite([
        'resources/css/app.css',
    ])
</head>

<body>
    <div class="lr-bg" style="background-image: url('{{ asset('images/lr-background.jpg') }}')">
        <section class=login-form>
            <div class="form-root">
                <img class="login-logo" src="{{ asset('images/logo-black.png') }}">
                <form action="/forgot-password" method="post">
                    @csrf
                    <div class="forgot-error-container">
                        @if (session('status'))
                            <div class="error-text">
                                {{ session('status') }}
                            </div>
                        @elseif($errors->has('email'))
                            <div class="error-text">
                                {{ $errors->first('email') }}
                            </div>
                        @else
                            <div class="error-text">
                                ご登録いただいているメールアドレスにパスワード再設定リンクを送信します。
                            </div>
                        @endif

                    </div>
                    <input type="text" name="email" value="{{ old('email') }}" placeholder=" ユーザーID（メールアドレス）">
                    <input type="submit" value="送信">
                </form>
            </div>
        </section>
    </div>
</body>

</html>