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
                <img class="restore-logo" src="{{ asset('images/logo-black.png') }}">

                <div class="restore-container">
                    <div class="restore-send-text">
                        <h2>復旧メールを送信しました。</h2>

                        <p><strong>{{ $email }}</strong> 宛にアカウント復旧用のメールをお送りしました。</p>
                        <p>メールに記載されたリンクをクリックして、アカウントの復旧を完了させてください。</p>

                    </div>

                    <a href="{{ route('register-top') }}" class="top-btn-sendmail">トップページへ戻る</a>

                </div>
            </div>



        </section>
    </div>
</body>

</html>