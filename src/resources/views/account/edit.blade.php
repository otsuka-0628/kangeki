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
        @include('sidebar')

        <div class="main-contents">
            <h2>アカウント情報の変更</h2>

            <form action="{{ route('account.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- メールアドレス変更 -->
                <div style="margin-bottom: 15px;">
                    <label for="email">新しいメールアドレス</label><br>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 新しいパスワード -->
                <div style="margin-bottom: 15px;">
                    <label for="password">新しいパスワード（変更する場合のみ）</label><br>
                    <input type="password" name="password" id="password">
                    @error('password')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 新しいパスワード（確認用） -->
                <div style="margin-bottom: 15px;">
                    <label for="password_confirmation">新しいパスワード（確認用）</label><br>
                    <input type="password" name="password_confirmation" id="password_confirmation">
                </div>

                <hr style="margin: 20px 0;">

                <!-- 本人確認用：現在のパスワード -->
                <div style="margin-bottom: 20px;">
                    <label for="current_password"><strong>セキュリティ確認：現在のパスワード（必須）</strong></label><br>
                    <input type="password" name="current_password" id="current_password" required>
                    @error('current_password')
                        <p style="color: red;">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit">更新する</button>
                <a href="{{ route('account.show') }}">キャンセル</a>
            </form>

        </div>
    </div>

</body>

</html>