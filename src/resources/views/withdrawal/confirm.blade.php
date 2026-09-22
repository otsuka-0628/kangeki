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
        <div class="withdrawal-container">
            <div class="withdrawal-text">
                <div class="withdrawal-title">
                    退会手続きの確認
                </div>

                {{-- 開催予定の公演がある場合の警告表示 --}}
                @if ($hasUpcomingEvents)
                    <div class="alert-warning">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>
                            <h2>開催予定・予約受付中の公演があります</h2>
                            <p>
                                現在、受付期間中または今後開催予定の公演データが存在します。<br>
                                退会すると観客からのチケット予約受付ができなくなりますので、内容を十分ご確認の上で手続きを行ってください。
                            </p>
                        </div>
                    </div>
                @endif

                <section class="withdrawal-notice">

                    <h2>退会前の確認事項</h2>
                    <ul>
                        <li>退会すると、劇団管理画面へのログインができなくなります。</li>
                        <li>登録された劇団情報および過去の公演情報は一般画面からアクセスできなくなります。</li>
                        <li>登録されている観客の予約名簿データは保持されますが、管理画面からの閲覧はできなくなります。</li>
                    </ul>
                </section>

                {{-- 退会実行フォーム --}}
                <form action="{{ route('withdrawal.destroy') }}" method="POST"
                    onsubmit="return confirm('本当に退会しますか？この操作は取り消せません。');">
                    @csrf
                    @method('DELETE')

                    <div class="withdrawal-form-actions">
                        <a href="{{ url()->previous() }}" class="withdrawal-cancel-btn">
                            キャンセルして戻る
                        </a>
                        <button type="submit" class="withdrawal-danger-btn">
                            退会する
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>

</html>