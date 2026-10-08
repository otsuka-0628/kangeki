<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ページ</title>
    @vite([
        'resources/css/app.css'
    ])
</head>

<body>

    <div class="dashboard-layout">
        @include('system.sidebar')
        <div class="system-background" style="background-image: url('{{ asset('images/system-background.jpg') }}')">

            <div class="system-main-contents">
                <div class="system-main-text">
                    <h1>KANGEKI管理者ページ</h1>
                    <p>ようこそ、{{ Auth::user()->email }} さん</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>