<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KANGEKI</title>
    @vite([
        'resources/css/register-top.css'
    ])
</head>

<body>
    <!-- @if (session('success'))
        <div class="alert alert-success"
            style="color: green; background-color: #e6ffe6; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif -->
    <div class="container">
        <nav class="sidebar">
            <img class="sidebar-logo" src="images/logo-white.png">
            <ul>
                <li><a href='#'>劇団情報</a></li>
                <li><a href='#'>予約フォーム作成</a></li>
                <li><a href='#'>アカウント情報</a></li>
                <li><a href='#'>お問い合わせ</a></li>
                <li><a href='#'>退会</a></li>
            </ul>
        </nav>

        <main class="main-contents">
            <h2>予約受付中の公演</h2>
        </main>
    </div>
</body>

</html>