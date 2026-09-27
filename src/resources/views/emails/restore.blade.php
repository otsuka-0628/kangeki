<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <style>

    </style>
</head>

<body>
    <div class="restore-account-message">
        <p>{{ $user->name ?? '会員' }} 様</p>

        <p>いつもご利用ありがとうございます。</p>
        <p>アカウントの復旧手続きを受け付けました。以下のリンクをクリックして、アカウントの復旧を完了させてください。</p>

        <p>
            <a href="{{ $url }}" class="btn-account-restore">
                アカウントを復旧してログイン
            </a>
        </p>

        <p>※上記ボタンが押せない場合は、以下のURLをブラウザに貼り付けてアクセスしてください：<br>{{ $url }}</p>

        <p>※このURLの有効期限は24時間です。<br>※お心当たりがない場合は、このメールを破棄してください。</p>
    </div>
</body>