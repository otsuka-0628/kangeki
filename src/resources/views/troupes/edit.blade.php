<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>劇団情報の登録</title>
    @vite([
        'resources/css/app.css'
    ])
</head>

<body>
    <div class="dashboard-layout">
        @include('sidebar')

        <div class="main-contents">
            <h2>劇団情報の登録</h2>
            <div class="troupe-form">
                @if ($errors->any())
                    <div
                        style="color: red; background-color: #fee; padding: 10px; margin-bottom: 10px; border: 1px solid red;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('troupe.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">劇団名</label>
                        <input type="text" name="name" value="{{ old('name', $troupe->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="representative_name">代表者名</label>
                        <input type="text" name="representative_name"
                            value="{{ old('representative_name', $troupe->representative_name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="prefecture">活動拠点</label>
                        <select name="prefecture" id="prefecture">
                            <option value="">選択してください</option>


                            @foreach($prefectures as $pref)
                                <option value="{{ $pref }}" {{ old('prefecture', $troupe->prefecture) == $pref ? 'selected' : ''}}>
                                    {{ $pref }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">劇団説明文</label>
                        <textarea id="description" name="description" rows="10"
                            required>{{ old('description', $troupe->description) }}</textarea>
                    </div>

                    <div class="form-submit">
                        <input type="submit" value="{{ $troupe->exists ? '更新' : '登録' }}" class="troupe-btn-submit">
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>