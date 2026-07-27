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
        @include('sidebar')

        <div class="main-contents">
            <h2>予約受付中の公演</h2>
            <div class="performance-container">
                <a href="#" class="btn-performance">
                    公演情報を編集
                </a>

                <p>現在予約受付中の公演はありません。</p>
            </div>
        </div>

    </div>
</body>

</html>