<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
    @vite([
        'resources/css/app.css',
    ])
</head>

<body>
    <div class="lr-bg" style="background-image: url('{{ asset('images/lr-background.jpg') }}')">
        <section class=login-form>
            <div class="form-root">
                <img class="login-logo" src="images/logo-black.png">

                <p class="restore-alert">
                    入力されたメールアドレス（<strong>{{ $email }}</strong>）は、過去に退会されたアカウントです。
                </p>
                <p>このアカウントを復旧して、過去のデータ（公演情報や設定など）を引き継いだままログインしますか？</p>

                <form action="{{ route('restore.perform') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-restore-confirm">
                        アカウントを復旧してログイン
                    </button>
                    <a href="{{ route('user-register') }}" class="btn-restore-confirm">
                        キャンセル（新規登録へ戻る）
                    </a>
            </div>
            </form>

    </div>
    </section>
    </div>
</body>

</html>