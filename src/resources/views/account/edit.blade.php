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
        @if (Auth::user()->role === 'admin')
            @include('system.sidebar')
        @else
            @include('sidebar')
        @endif

        <div class="main-contents">
            <h2>メールアドレス・パスワードの変更</h2>

            <form action="{{ route('account.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="account-edit-form">
                    <!-- メールアドレス変更 -->

                    <label for="email">新しいメールアドレス</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror

                    <!-- 新しいパスワード -->

                    <label for="password">新しいパスワード</label>
                    <input type="password" name="password" id="password">
                    @error('password')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror

                    <!-- 新しいパスワード（確認用） -->

                    <label for="password_confirmation">新しいパスワード（確認用）</label>
                    <input type="password" name="password_confirmation" id="password_confirmation">


                    <!-- 本人確認用：現在のパスワード -->

                    <label for="current_password">現在のパスワード<span class="required-form">＊必須</span></label>
                    <input type="password" name="current_password" id="current_password" required>
                    @error('current_password')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror

                </div>

                <div class="account-form-actions">
                    <button type="submit">更新する</button>
                    <a href="{{ route('account.show') }}">キャンセル</a>
                </div>

            </form>

        </div>
    </div>

</body>

</html>