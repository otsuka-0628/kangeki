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
                <!-- 予約受付中の公演がない場合 -->
                <div class="performance-container">
                    <p>現在予約受付中の公演はありません。</p>
                    <a href="#" class="btn-performance">
                        公演情報を登録
                    </a>
                </div>
            @else
                <!-- 予約受付中の公演がある場合（複数あればループでperformance-containerが増える） -->
                @foreach($performances as $performance)
                    <div class="performance-container">

                        <!-- 冠タイトル（第〇〇公演） -->
                        @if(!empty($performance->sub_title))
                            <p class="performance-subtitle">{{ $performance->sub_title }}</p>
                        @endif

                        <!-- 公演タイトル -->
                        <h3 class="performance-title">{{ $performance->title }}</h3>

                        <!-- 公演日時ごとの予約状況 -->
                        <div class="resarvation-status">
                            <h4>予約状況</h4>
                            <ul>
                                @foreach($performance->schedules as $schedule)
                                    <li>
                                        {{ $schedule->formatted_date }} :
                                        <strong>{{ $schedule->reserved_seats_count }}</strong>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- 予約状況の抽出ボタン（Excel形式） -->
                        <div class="performance-actions">
                            <a href="#" class="btn-excel">
                                予約状況をExcel抽出
                            </a>
                            <a href="#" class="btn-performance">
                                公演情報を編集
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </div>
</body>

</html>