<nav class="sidebar" style="background-image: url('{{ asset('images/menu-back.jpg') }}')">
    <img class="sidebar-logo" src="{{ asset('images/logo-white.png') }}">
    <ul>
        <li><a href="{{ route('troupe.show') }}">劇団情報</a></li>
        <li><a href="{{ route('home') }}">公演一覧</a></li>
        <li><a href="{{ route('performances.create') }}">公演情報登録</a></li>
        <li><a href='{{ route('account.show') }}'>メール・パスワード</a></li>
        <li><a href='{{ route('contact.index') }}'>お問い合わせ</a></li>
    </ul>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn-logout">ログアウト</button>
    </form>

    <div class="btn-account-delete">
        <a href="{{ route('withdrawal.confirm') }}">退会手続き

        </a>
    </div>
</nav>