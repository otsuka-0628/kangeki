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
                <div class="no-troupe-container">
                    <p class="no-troupe-msg">未登録です。</p>
                    <a href="{{ route('troupe.edit') }}" class="btn-troupe">
                        劇団情報を登録
                    </a>
                </div>
            @else

                <div class="troupe-container">
                    <dl class="troupe-info">
                        <dt>劇団名</dt>
                        <dd class="troupe-name">{{ $troupe->name }}</dd>

                        <dt>代表者</dt>
                        <dd class="troupe-representative">{{ $troupe->representative_name }}</dd>

                        <dt>活動拠点</dt>
                        <dd class="troupe-base">{{ $troupe->prefecture }}</dd>

                        <dt>劇団紹介</dt>
                        <dd class="troupe-description">{{ $troupe->description }}</dd>
                    </dl>

                    <a href="{{ route('troupe.edit') }}" class="btn-troupe">編集</a>

                </div>
            @endif

        </div>
    </div>
</body>

</html>