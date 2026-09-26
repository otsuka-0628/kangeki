<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>送信完了</title>
</head>

<body>
    <div class="contact-thanks-container">
        <h2>お問い合わせ送信完了</h2>
        <p>お問い合わせありがとうございます。</p>
        <p>ご入力いただいた内容を確認の上、管理者よりメールにてご連絡いたします。</p>

        <div class="contact-thanks-actions">
            @auth
                <a href="{{ route('home') }}" class="btn btn-primary">トップページへ戻る</a>
            @else
                <a href="{{ route('auth.register-top') }}" class="btn">トップページへ戻る</a>
            @endauth
        </div>
    </div>
</body>

</html>