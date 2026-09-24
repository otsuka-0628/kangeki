<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録劇団一覧</title>
    @vite([
        'resources/css/app.css'
    ])
</head>

<body>
    <div class="dashboard-layout">
        @include('system.sidebar')

        <div class="main-contents">
            <h2>登録劇団一覧</h2>

            {{-- フラッシュメッセージ表示 --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="system-troupes-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>劇団名</th>
                        <th>代表者名</th>
                        <th>メールアドレス</th>
                        <th>ステータス</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->troupe?->name ?: '未設定' }}</td>
                            <td>{{ $user->troupe?->representative_name ?: '未設定' }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                {{-- アカウント停止フラグ等の判定 --}}
                                @if ($user->is_blocked)
                                    <span style="color: red; font-weight: bold;">停止中</span>
                                @else
                                    <span style="color: green;">正常</span>
                                @endif
                            </td>
                            <td>
                                {{-- アカウント停止・解除の切り替えボタン --}}
                                <form action="{{ route('system.users.toggle-block', $user) }}" method="POST"
                                    class="system-actions">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('ステータスを変更しますか？')"
                                        class="btn-account-stop">
                                        {{ $user->is_blocked ? '停止解除' : 'アカウント停止' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">登録されているユーザーはいません。</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- ページネーション --}}
            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</body>

</html>