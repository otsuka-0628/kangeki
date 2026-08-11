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

            @if($performances->isEmpty())

                <div class="performance-container">
                    <p>現在予約受付中の公演はありません。</p>
                    <a href="{{ route('performances.create') }}" class="btn-performance">
                        公演情報を登録
                    </a>
                </div>
            @else

                @foreach($performances as $performance)
                    <div class="performance-container">

                        <!-- 冠タイトル（第〇〇公演） -->
                        @if(!empty($performance->sub_title))
                            <p class="performance-subtitle">{{ $performance->sub_title }}</p>
                        @endif

                        <!-- 公演タイトル -->
                        <h3 class="performance-title">{{ $performance->title }}</h3>

                        <a href="#" class="btn-performance">
                            詳細を確認
                        </a>
                    </div>

                @endforeach
            @endif
        </div>
    </div>


</body>

</html>