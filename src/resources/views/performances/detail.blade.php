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
            <h2>公演情報詳細</h2>

            <div class="detail-container">

                <div class="detail-buttons">
                    <a href="#" class="btn btn-detail">予約フォームURL発行</a>
                    <a href="#" class="btn btn-detail">予約者名簿抽出</a>
                    <a href="#" class="btn btn-detail">編集</a>
                    <form action="#" mathod="POST" onsubmit="return cunfirm('本当に削除しますか？')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete">削除</button>
                    </form>
                </div>


                <p class="performance-subtitle">{{ $performance->sub_title }}</p>
                <p class="performance-title">{{ $performance->title }}</p>
                @if($performance->schedules->isNotEmpty())
                    <p class="schedules-list">
                    <ul>
                        @foreach($performance->schedules as $schedule)
                            <li>{{ $schedule->start_at }}</li>
                        @endforeach
                    </ul>
                    </p>
                @else
                    <p>※開演日時の登録はありません。</p>
                @endif

            </div>
        </div>
    </div>
</body>

</html>