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

        <div class="performance-container">
            <h2>公演情報詳細</h2>

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
</body>

</html>