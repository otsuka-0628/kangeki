<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KANGEKI</title>
    @vite([
        'resources/css/app.css'
    ])
</head>

<body>
    <div class="dashboard-layout">
        @include('sidebar')

        <div class="main-contents">
            <h2>アカウント情報</h2>

            @if (session('status'))
                <div style="color: green; margin-bottom: 15px;">
                    {{ session('status') }}
                </div>
            @endif

            <div>
                <p><strong>ユーザーID（メールアドレス）:</strong> {{ $user->email }}</p>
                <p><strong>パスワード:</strong> ********</p>
            </div>

            <a href="{{ route('account.edit') }}" class="btn">編集する</a>
        </div>
    </div>
</body>

</html>