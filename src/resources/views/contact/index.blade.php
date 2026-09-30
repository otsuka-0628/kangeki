<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ</title>
    @vite([
        'resources/css/app.css'
    ])
</head>

<body>
    <div class="lr-bg" style="background-image: url('{{ asset('images/lr-background.jpg') }}')">

        <div class="contact-container">
            <div class="contact-form-root">

                <h2>お問い合わせフォーム</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST" class="contact-form">
                    @csrf

                    <div class="form-group">
                        <label for="troupe_name">劇団名 <span class="required-form">＊必須</span></label>
                        <input type="text" id="troupe_name" name="troupe_name"
                            value="{{ old('troupe_name', Auth::user()->troupe->name ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="sender_name">送信者氏名 <span class="required-form">＊必須</span></label>
                        <input type="text" id="sender_name" name="sender_name"
                            value="{{ old('sender_name', Auth::user()->troupe->representative_name ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">メールアドレス <span class="required-form">＊必須</span></label>
                        <input type="email" id="email" name="email"
                            value="{{ old('email', Auth::user()->email ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="message">お問い合わせ内容 <span class="required-form">＊必須</span></label>
                        <textarea id="message" name="message" rows="6" required>{{ old('message') }}</textarea>
                    </div>

                    <div class="form-submit">
                        <button type="submit" class="btn-message-submit">送信する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>