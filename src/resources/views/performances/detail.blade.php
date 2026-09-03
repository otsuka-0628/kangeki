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
                    <a href="#" class="detail-btn detail-btn-action">予約フォームURL発行</a>
                    <a href="#" class="detail-btn detail-btn-action">予約者名簿抽出</a>
                    <a href="{{ route('performances.edit', $performance->id) }}"
                        class="detail-btn detail-btn-action">編集</a>
                    <form action="{{ route('performances.destroy', $performance->id) }}" method="POST"
                        onsubmit="return confirm('本当に削除しますか？')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="detail-btn detail-btn-delete">削除</button>
                        <!-- テスト用の単純なリンク（GETで叩いてみるテスト） -->
                    </form>
                </div>


                <p class="performance-subtitle">{{ $performance->sub_title }}</p>
                <p class="performance-title">{{ $performance->title }}</p>
                @if($performance->schedules->isNotEmpty())
                    <p class="schedules-list">
                    <ul>
                        @foreach($performance->schedules as $schedule)
                            <li>{{ \Carbon\Carbon::parse($schedule->start_at)->isoFormat('M月D日(ddd) HH:mm') }}</li>
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