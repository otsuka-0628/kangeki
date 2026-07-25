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
            @if(!$troupe)
                <div class="alert alert-warning">
                    <p>まだ劇団情報が登録されていません。まずは劇団情報を登録してください。</p>
                    {{-- ※劇団登録画面へのリンク（ルート名はプロジェクトに合わせて変更してな） --}}
                    <a href="#" class="btn btn-primary">劇団情報を登録する</a>
                </div>
            @elseif($performances->isEmpty())
                <div class="card text-center p-4">
                    <p class="fs-5">現在予約受付中の公演はありません。</p>
                    <div>
                        {{-- ※公演登録画面へのリンク（ルート名はプロジェクトに合わせて変更してな） --}}
                        <a href="#" class="btn btn-success">
                            新規公演情報を登録する
                        </a>
                    </div>
                </div>
            @else
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>公演一覧</h3>
                    <a href="#" class="btn btn-primary">
                        ＋ 新しい公演を登録する
                    </a>
                </div>

                <div class="row">
                    @foreach($performances as $performance)
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $performance->title }}</h5>
                                    <p class="card-text mb-1">
                                        <strong>公演期間：</strong>{{ $performance->period_text }}
                                    </p>
                                    <p class="card-text mb-1">
                                        <strong>会場：</strong>{{ $performance->venue_prefecture }}{{ $performance->venue_city }}
                                    </p>
                                    <p class="card-text mb-1">
                                        <strong>受付期限：</strong>{{ $performance->end_of_reservation_at->format('Y/m/d H:i') }}
                                    </p>
                                    <p class="card-text">
                                        <strong>公開状態：</strong>
                                        @if($performance->is_published)
                                            <span class="badge bg-success">公開中</span>
                                        @else
                                            <span class="badge bg-secondary">非公開</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="card-footer bg-transparent d-flex justify-content-between">
                                    {{-- 各公演の予約状況・編集ページへのリンク --}}
                                    <a href="#" class="btn btn-outline-info btn-sm">
                                        予約状況を見る
                                    </a>
                                    <a href="#" class="btn btn-outline-secondary btn-sm">
                                        編集する
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</body>

</html>