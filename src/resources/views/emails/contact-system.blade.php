<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <style>

    </style>
</head>

<body>
    <h2>【KANGEKI】お問い合わせ通知</h2>

    <p>アプリ管理者 様</p>

    <p>KANGEKIのお問い合わせフォームより、以下の内容でお問い合わせがありました。</p>
    <p>このメールに直接返信することで、送信者へ回答を送ることができます。</p>

    <div class="contact-message-container">

        <p>■ 劇団名</p>
        <p>{{ $contactData['troupe_name'] }}</p>


        <p>■ 送信者名</p>
        <p>{{ $contactData['sender_name'] }}</p>

        <p>■ メールアドレス</p>
        <p>{{ $contactData['email'] }}</p>

        <p>■ お問い合わせ内容</p>
        <p>{{ $contactData['message'] }}</p>

    </div>
</body>