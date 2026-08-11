<nav class="sidebar" style="background-image: url('{{ asset('images/menu-back.jpg') }}')">
    <img class="sidebar-logo" src="{{ asset('images/logo-white.png') }}">
    <ul>
        <li><a href="{{ route('troupe.show') }}">劇団情報</a></li>
        <li><a href="{{ route('home') }}">公演一覧</a></li>
        <li><a href="{{ route('performances.create') }}">予約フォーム作成</a></li>
        <li><a href='#'>アカウント情報</a></li>
        <li><a href='#'>お問い合わせ</a></li>
        <li><a href='#'>退会</a></li>
    </ul>
</nav>