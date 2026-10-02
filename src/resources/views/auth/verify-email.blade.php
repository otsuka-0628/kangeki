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
                <img class="verify-logo" src="{{ asset('images/logo-black.png') }}">

                <div class="verify-email-container">
                    <div class="verify-email-text">

                        <h2>ご登録ありがとうございます。</h2>

                        <p>ご入力いただいたメールアドレスに、確認用のメールを送信しました。</p>
                        <p>メールに記載されているリンクをクリックして、登録を完了させてください。</p>
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <p>
                            新しい確認メールを送信しました！
                        </p>
                    @endif

                    <p class="resend-text">メールが届いていない場合はこちら</p>

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn-resend-mail">
                            確認メールを再送信
                        </button>
                    </form>

                    <a href="{{ route('login') }}" class="back-login-btn">ログイン画面に戻る</a>

                </div>

                </form>
            </div>
        </section>
    </div>
</body>

</html>