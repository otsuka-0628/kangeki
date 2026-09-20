<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KANGEKI</title>
    @vite([
        'resources/css/app.css',
    ])
</head>

<body>
    <div class="withdrawal-bg" style="background-image: url('{{ asset('images/withdrawal-background.jpg') }}')">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-danger shadow-sm">
                    <div class="card-header bg-danger text-white fs-5 fw-bold">
                        退会手続きの確認
                    </div>
                    <div class="card-body p-4">

                        {{-- 開催予定の公演がある場合の警告表示 --}}
                        @if ($hasUpcomingEvents)
                            <div class="alert alert-warning border-warning d-flex align-items-start mb-4" role="alert">
                                <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-warning"></i>
                                <div>
                                    <h5 class="alert-heading fw-bold">開催予定・予約受付中の公演があります</h5>
                                    <p class="mb-0">
                                        現在、受付期間中または今後開催予定の公演データが存在します。<br>
                                        退会すると観客からのチケット予約受付ができなくなりますので、内容を十分ご確認の上で手続きを行ってください。
                                    </p>
                                </div>
                            </div>
                        @endif

                        <h5 class="fw-bold mb-3">退会前の確認事項</h5>
                        <ul class="text-muted mb-4">
                            <li>退会すると、劇団管理画面へのログインができなくなります。</li>
                            <li>登録された劇団情報および過去の公演情報は一般画面からアクセスできなくなります。</li>
                            <li>登録されている観客の予約名簿データは保持されますが、管理画面からの閲覧はできなくなります。</li>
                        </ul>

                        {{-- 退会実行フォーム --}}
                        <form action="{{ route('withdrawal.destroy') }}" method="POST"
                            onsubmit="return confirm('本当に退会しますか？この操作は取り消せません。');">
                            @csrf
                            @method('DELETE')

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                    キャンセルして戻る
                                </a>
                                <button type="submit" class="btn btn-danger px-4">
                                    退会する
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>