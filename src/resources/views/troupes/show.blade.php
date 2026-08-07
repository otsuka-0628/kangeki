<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>劇団情報</title>
    @vite([
        'resources/css/app.css'
    ])
</head>

<body>
    <div class="dashboard-layout">
        @include('sidebar')

        <div class="main-contents">
            <h2>劇団情報</h2>
            @if(!$troupe)

                <!-- コンテナ名は仮 -->
                <div class="troupe-container">
                    <p>未登録です。</p>
                    <a href="#" class="btn-troupe">
                        劇団情報を登録
                    </a>
                </div>
            @else

            @endif

        </div>
    </div>
</body>

</html>