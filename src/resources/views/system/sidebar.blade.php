<nav class="sidebar" style="background-image: url('{{ asset('images/menu-system.jpg') }}')">
    <img class="sidebar-logo" src="{{ asset('images/logo-white.png') }}">
    <ul>
        <li>
            {{-- 劇団一覧・アカウント停止画面へのリンク --}}
            <a href="{{ route('system.users.index') }}">登録劇団一覧（アカウント管理）</a>
        </li>
        <li>
            {{-- 公演一覧・削除画面へのリンク --}}
            <a href="{{ route('system.performances.index') }}">登録公演一覧（公演削除）</a>
        </li>
        <li><a href='{{ route('account.show') }}'>メール・パスワード</a></li>
    </ul>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn-logout">ログアウト</button>
    </form>


</nav>