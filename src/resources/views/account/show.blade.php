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

        @if (Auth::user()->role === 'admin')
            @include('system.sidebar')
        @else
            @include('sidebar')
        @endif

        <div class="main-contents">
            <h2>メールアドレス・パスワード</h2>

            @if (session('status'))
                <div style="color: green; margin-bottom: 15px;">
                    {{ session('status') }}
                </div>
            @endif

            <div class="show-account-container">

                <dl class="account-info">
                    <dt>ユーザーID（メールアドレス）</dt>
                    <dd name="account-email"> {{ $user->email }}</dd>
                    <dt>パスワード</dt>
                    <dd name="account-password"><strong>＊＊＊＊＊＊＊＊</strong></dd>
                </dl>

                <a href="{{ route('account.edit') }}" class="btn-account-edit">編集する</a>

            </div>

        </div>
    </div>
</body>

</html>