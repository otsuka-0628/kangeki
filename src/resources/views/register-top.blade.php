<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KANGEKI</title>
    @vite([
        'resources/css/app.css',
        'resources/css/register-top.css'
    ])
</head>

<body>
    <div class="rt-bg" style="background-image: url('{{ asset('images/rt-background.jpg') }}')">

        <img class="top-logo" src="images/logo.png">

        <a href="{{ route('user-login') }}" class="btn btn-login">
            ログイン
        </a>

        <a href="{{ route('user-register') }}" class="btn btn-register">
            新規登録
        </a>
    </div>
</body>

</html>