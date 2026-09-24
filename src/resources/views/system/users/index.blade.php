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
        <div class="container">
            <h2>登録劇団（ユーザー）一覧</h2>

            {{-- フラッシュメッセージ表示 --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>劇団名（ユーザー名）</th>
                        <th>メールアドレス</th>
                        <th>ステータス</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->troupe?->name ?: $user->name }}</td>
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
                                    style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('ステータスを変更しますか？')">
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