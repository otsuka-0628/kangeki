<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録公演一覧</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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

            <table class="system-performance-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>公演タイトル</th>
                        <th>主催劇団</th>
                        <th>登録日</th>
                        <th>ステータス</th>
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
                                @if ($performance->trashed())
                                    <span style="color: red; font-weight: bold;">公開停止中</span>
                                @else
                                    <span style="color: green;">公開中</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('system.performances.toggle-publish', $performance->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" onclick="return confirm('ステータスを変更しますか？')"
                                        class="btn-performance-toggle">
                                        {{ $performance->trashed() ? '公開' : '公開停止' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">登録されている公演はありません。</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- ページネーションリンク --}}
            <div>
                {{ $performances->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
</body>

</html>