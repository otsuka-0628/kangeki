<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録公演一覧</title>
    @vite([
        'resources/css/app.css'
    ])
</head>

<body>
    <div class="dashboard-layout">
        @include('system.sidebar')

        <div class="main-contents">
            <h2>登録公演一覧</h2>

            {{-- フラッシュメッセージ表示 --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>公演タイトル</th>
                        <th>主催劇団</th>
                        <th>登録日</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($performances as $performance)
                        <tr>
                            <td>{{ $performance->id }}</td>
                            <td>{{ $performance->title }}</td>
                            <td>{{ $performance->troupe?->name ?: '（未設定）' }}</td>
                            <td>{{ $performance->created_at->format('Y/m/d') }}</td>
                            <td>
                                {{-- 公演の強制削除（論理削除）ボタン --}}
                                <form action="{{ route('system.performances.destroy', $performance) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('本当に公演「{{ $performance->title }}」を削除しますか？\n（※削除後もデータベース上には論理削除として保持されます）')">
                                        削除
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">登録されている公演はありません。</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- ページネーションリンク --}}
            <div>
                {{ $performances->links() }}
            </div>
        </div>
    </div>
</body>

</html>