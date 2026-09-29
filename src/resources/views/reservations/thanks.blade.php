<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約完了</title>
    @vite([
        'resources/css/app.css',
    ])
</head>

<body>
    <div class="lr-bg" style="background-image: url('{{ asset('images/lr-background.jpg') }}')">
        <section class=login-form>
            <div class="form-root">
                <img class="login-logo" src="{{ asset('images/logo-black.png') }}">
                <div class="contact-thanks-container">
                    <h2>ご予約が完了しました。</h2>
                    <p>ご入力いただいたメールアドレスへ、予約内容を記載した確認メールをお送りしましたのでご確認ください。</p>
                    <h2>【予約内容の変更・キャンセルについて】</h2>
                    <p>予約内容の変更やキャンセルは、お届けした確認メール内のリンクからお手続きいただけます。</p>
                    <h2>公演日時の変更について</h2>
                    <p>ご希望日時の残席状況を確認する必要があるため、日時変更は直接お受けできません。日時を変更したい場合は、<strong>ご希望の日時で改めてご予約の上、不要になったご予約をキャンセル</strong>していただきますようお願いいたします。
                    </p>
                </div>
            </div>
        </section>
    </div>
</body>

</html>